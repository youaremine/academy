<?php
/**
 *
 * @author wooken <471159717@qq.com>
 * @version 1.01 , 2021-03-02
 */

require_once("../includes/config.inc.php");
require_once("PaymentConf.php");
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
    public function payment_success($order_no,$return_bak_str = ''){

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
                $this->payment_log('ERROR',$order_no,$return_bak_str,'【pay success but update failed】');
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



        include_once '../templates/account/payment_success.html';

    }


    /**
     * 支付失敗邏輯
     * */
    public function payment_failed($order_no,$return_bak_str,$is_cancel){

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


            include_once '../templates/account/payment_failed.html';
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
