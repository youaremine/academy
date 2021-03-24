<?php
/**
 *
 * @author wooken <471159717@qq.com>
 * @version 1.01 , 2021-03-02
 */

require_once("../includes/config.inc.php");
require_once("PaymentConf.php");
use WechatPay\GuzzleMiddleware\Util\AesUtil;

Class PaymentBack extends PaymentConf {
    protected $payment_type = null;
    protected $return_data = null;
    protected $db;
    protected $redis;

    public function __construct(){
        global $db;
        $this->payment_type = $_GET['type'];
        $this->return_data = $_REQUEST;

        $this->db = $db;
        $this->redis = new redis();
        $this->redis->connect('127.0.0.1',6379);
        $this->redis->select(1);

        $this->route();
    }

    /**
     *
     * 路由
     * */
    private function route(){
        switch ($this->payment_type) {
            case 'stripe' :
                $this->stripe_back();
                break;
            default:
                $this->checkBack();
        }
    }

    /**
     * 确认是微信支付的通知还是其他通知
     * */
    public function checkBack(){
        if(isset($_SERVER['HTTP_WECHATPAY_NONCE']) && isset($_SERVER['HTTP_WECHATPAY_SERIAL'])
            && isset($_SERVER['HTTP_WECHATPAY_SIGNATURE']) && isset($_SERVER['HTTP_WECHATPAY_TIMESTAMP'])){
            $this->wechat_back();
        }elseif('支付宝支付回调' == true){//TODO

        }else{
            echo json_encode(['code'=>'FAILED','message'=>'失败',]);exit;
        }
    }

    /**
     * 验证微信回调
     * */
    protected function VerifySign($data, $signature){
        $signature = base64_decode($signature);//解密应答签名
        // 微信支付平台证书
        $wechatpayCertificate = openssl_pkey_get_public(file_get_contents($this->wechatpayCertificate_path));
        $retCode = openssl_verify($data, $signature, $wechatpayCertificate, OPENSSL_ALGO_SHA256);
        if ($retCode == 1) {
            return true;
        }
        return false;
    }


    /**
     * 微信 支付回调
     * */
    protected function wechat_back(){
        $nonce = $_SERVER['HTTP_WECHATPAY_NONCE'];
        $serial = $_SERVER['HTTP_WECHATPAY_SERIAL'];
        $signature = $_SERVER['HTTP_WECHATPAY_SIGNATURE'];
        $timestamp = $_SERVER['HTTP_WECHATPAY_TIMESTAMP'];
        $params = file_get_contents('php://input');

        $contents = json_decode($params,true)['resource'];
        $bf_msg = $timestamp . "\n" . $nonce . "\n" . $params . "\n";
        $res = $this->VerifySign($bf_msg,$signature);//验证是否微信回调

        if(!$res){
            $this->payment_log('VerifySign FAILED','',json_encode($params),'Wechat VerifySign Failed');
            echo json_encode(['code'=>'FAILED','msg'=>'failed']);exit;
        }

        $decrypter = new AesUtil($this->apis);
        $decrypter_res = $decrypter->decryptToString($contents['associated_data'], $contents['nonce'], $contents['ciphertext']);
        $decrypter_res = json_decode($decrypter_res,true);
        if(!is_array($decrypter_res)){//如果解密
            $this->payment_log('decrypter_res FAILED','',json_encode($params),'Wechat decrypter_res');
            echo json_encode(['code'=>'FAILED','msg'=>'failed']);exit;
        }

        if($decrypter_res['appid'] != $this->appid){
            $this->payment_log('decrypter_res FAILED','',json_encode($params),'appid error');
        }

        if($decrypter_res['trade_state'] == 'SUCCESS'){
            $this->payment_success($decrypter_res['out_trade_no'],json_encode($decrypter_res),false);
            echo json_encode(['code'=>'SUCCESS','msg'=>'success']);exit;
        }else{
            $this->payment_failed($decrypter_res['out_trade_no'],json_encode($decrypter_res),false);
            echo json_encode(['code'=>'FAILED','msg'=>'failed']);exit;
        }
    }


    /**
     * stripe 支付回调
     * */
    protected function stripe_back(){
        require_once ('../includes/config.inc.php');
        require_once('../payment/stripe-php/init.php');
        $key = $this->live_mode == false?$this->stripe_test_key:$this->stripe_live_key;
        \Stripe\Stripe::setApiKey($key);
        $session = \Stripe\Checkout\Session::retrieve($this->return_data['session_id']);

        $this->payment_log('Unknow',$session->client_reference_id,json_encode($session),'stripe payment back');

        if($session->payment_status == 'paid' && $this->return_data['action'] == 'success'){//支付成功
            $this->payment_success($session->client_reference_id,json_encode($session));
        }else if($session->payment_status == 'unpaid' && $this->return_data['action'] == 'cancel'){//取消支付
            $this->payment_failed($session->client_reference_id,json_encode($session),true);
        }else{
            $this->payment_failed($session->client_reference_id,json_encode($session));
        }
    }

    /**
     * 支付成功邏輯
     * */
    public function payment_success($order_no,$return_bak_str = '',$show_page = true){
        global $conf;
        $this->payment_log('SUCCESS',$order_no,$return_bak_str,'SUCCESS step 1');
        $select_sql = "SELECT * FROM Survey_SurveyorOrder WHERE order_no = '{$order_no}' and status = 0";
        $this->db->query ( $select_sql );
        $order_detail = array();
        if($select_res = $this->db->next_record()){
            $order_detail['survId'] = $select_res['survId'];
            $order_detail['jobNoNew'] = $select_res['jobNoNew'];
        }

        if(empty($order_detail)){
            $this->payment_log('ERROR',$order_no,$return_bak_str,'【pay success .can not find order no】');
        }else{

            $sql = "UPDATE Survey_SurveyorOrder SET status=1 WHERE order_no = '{$order_no}'";

            $res = $this->db->query($sql);

            if(!$res){
                $this->payment_log('ERROR',$order_no,$return_bak_str,'【pay success but update failed1】');
            }


            $s = new Surveyor ();
            $s->company = '';
            $s->status = '';
            $s->survId = $order_detail['survId'];

            $sa = new SurveyorAccess ( $this->db );
            $rs = $sa->GetListSearch ( $s );

            //檢查通過, 直接插入數據.
            $mso = new MainScheduleOpen();
            $mso->applySurvId =$order_detail['survId'];
            $mso->applyTime = date("Y-m-d H:i:s");
            $msoa = new MainScheduleOpenAccess($this->db);
            $mso->jobNoNew =  $order_detail['jobNoNew'];
            $msoa->Apply($mso);
            $this->autoAssign($rs [0],  $order_detail['jobNoNew']);
        }
        if($show_page){
            $t = new CacheTemplate("../templates/account");
            $t->set_caching($conf["cache"]["valid"]);
            $t->set_cache_dir($conf["cache"]["dir"]);
            $t->set_expire_time($conf["cache"]["timeout"]);
            $t->set_file("HdIndex", "payment_success.html");
            $t->set_var ( array (
                "order_no" => $order_no
            ) );
            $t->pparse("Output", "HdIndex");
        }
    }


    /**
     * 支付失敗邏輯
     * */
    public function payment_failed($order_no,$return_bak_str,$is_cancel,$show_page = true){
        global $conf;
        $this->payment_log('Failed',$order_no,$return_bak_str,'Failed step 1');
        $select_sql = "SELECT * FROM Survey_SurveyorOrder WHERE order_no = '{$order_no}' and status = 0";
        $this->db->query ( $select_sql );
        $order_detail = array();
        if($select_res = $this->db->next_record()){
            $order_detail['survId'] = $select_res['survId'];
            $order_detail['jobNo'] = $select_res['jobNo'];
            $order_detail['jobNoNew'] = $select_res['jobNoNew'];
        }

        if(empty($order_detail)){
            $this->payment_log('ERROR',$order_no,$return_bak_str,'【pay success .can not find order no】');
        }else{

            $status = $is_cancel?2:-1;

            $sql = "UPDATE Survey_SurveyorOrder SET status={$status} WHERE order_no = '{$order_no}'";

            $res = $this->db->query($sql);

            if(!$res){
                $this->payment_log('ERROR',$order_no,$return_bak_str,'【pay failed and update failed】');
            }

            $key = 'list_'.$order_detail['jobNo'];

            $this->redis->rpush($key,$order_detail['jobNoNew']);

            if($show_page){
                $t = new CacheTemplate("../templates/account");
                $t->set_caching($conf["cache"]["valid"]);
                $t->set_cache_dir($conf["cache"]["dir"]);
                $t->set_expire_time($conf["cache"]["timeout"]);
                $t->set_file("HdIndex", "payment_failed.html");
                $t->set_var ( array (
                    "order_no" => $order_no
                ) );
                $t->pparse("Output", "HdIndex");
            }

        }
    }



    /**
     * 记录异常订单
     * */
    public function payment_log($status,$order_no,$return_bak_str,$msg = ''){


        $content = "\n=========".$status."==========";
        $content .= "\n=========".date('Y-m-d H:i:s')."==========";
        $content .= "\nOrder No:".$order_no;
        $content .= "\nReturn_bak_str:".$return_bak_str;
        $content .= "\nMsg:".$msg;

        file_put_contents('payment_log'.PROJECTNAME.'.log',$content,FILE_APPEND);

    }


    public function ajax_return($code,$data,$msg = ''){

        echo json_encode(['code'=>$code,'data'=>$data,'msg'=>$msg,]);
        exit;
    }

    public function autoAssign($sur, $jobNoNew,$record_surveyor = false){
        $assignHour = 0;
        $delSql = "UPDATE Survey_SurveyorMainSchedule SET delFlag='yes' WHERE ";
        if (is_array($jobNoNew))
        {
            $sql = "INSERT INTO Survey_SurveyorMainSchedule(survId,jobNoNew,inputUserId,inputTime)" . " VALUES";
            $i = 0;
            $delSqlWhere = "jobNoNew IN ('0'";
            foreach ( $jobNoNew as $v )
            {
                if ($i > 0)
                {
                    $sql .= ",";
                }
                $sql .= "('{$sur->survId}','{$v}','{$_SESSION['userId']}','" . date("Y-m-d H:i:s") . "')";
                $delSqlWhere .= ",'{$v}'";
                $i++;
            }
            $delSqlWhere .= ")";
        }
        else
        {
            $sql = "INSERT INTO Survey_SurveyorMainSchedule(survId,jobNoNew,inputUserId,inputTime)" . " VALUES('" . $sur->survId . "'" . ",'" . $jobNoNew . "'" . ",'" . 1 . "'" . ",'" . date("Y-m-d H:i:s") . "'" . ")";
            $delSqlWhere = " jobNoNew='{$jobNoNew}'";
        }
        $delSql .= $delSqlWhere;

        $this->db->query($delSql);
        $this->db->query($sql);

        // 更新MainSchedule
        $ms = new MainSchedule();
        $ms->jobNoNew = $jobNoNew;
        $msa = new MainScheduleAccess($this->db);
        $msa->Assign2Surveyor($sur, $jobNoNew,true,$sur);//写入住数据库计划

        $assignHour = $msa->GetEstimatedManHour($ms);
        $assignHour = 0 - $assignHour;

        // 更新MainScheduleOpen
        $msoa = new MainScheduleOpenAccess($this->db);
        $msoa->UpdateAllStatus($sur->survId, $jobNoNew);


        return true;
    }


}

new PaymentBack();
