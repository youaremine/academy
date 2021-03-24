<?php
/**
 * 生成支付类
 * @author wooken <471159717@qq.com>
 * @version 1.01 , 2021-03-02
 */

require_once '../payment/StripePayment.php';
require_once '../payment/WechatPayment.php';
require_once("../includes/config.inc.php");

Class Payment{
    private $surveyorCode = null;
    private $redis;
    private $db;


    public function __construct(){
        global $db;
        //TODO 整合校验手机端请求
        if (!SurveyorLogin::IsLogin())  exit('Login timeout.');// 检查是否登录
        $this->surveyorCode = $_SESSION['surveyorId'];

        $this->db = $db;
        $this->redis = new redis();
        $this->redis->connect('127.0.0.1',6379);
        $this->redis->select(1);

        $this->route($_REQUEST);
    }

    /**
     *
     * 路由
     * */
    private function route($data){
        switch ($data['type']) {
            case 'stripe' :
                $this->create_stripe($data);
                break;
            case 'alipay' :
                $this->create_alipay($data);
                break;
            case 'wechat' :
                $this->create_wechat_pay($data);
                break;
            case 'check' :
                $this->check_payment($data);
                break;

            default :
                $this->ajax_return(401,'','請稍後再試');

        }
    }




    /**
     * 確認第三方支付回調結果
     */
    protected function check_payment($data){
        $select_sql = "SELECT status FROM Survey_SurveyorOrder WHERE order_no = '{$data['order_no']}'";
        $this->db->query ( $select_sql );

        if($select_res = $this->db->next_record()){
            $this->ajax_return(200,['status'=>$select_res['status']],'');
        }else{
            $this->ajax_return(400,'','訂單號未找到');
        }
    }

    /**
     * 创建微信 支付
     * */
    protected function create_wechat_pay($data){
        $goods = $this->get_real_goods($data['jobNoShort']);
        $wechatpay = new WechatPayment();

        $order_no = $this->create_order_no($goods->jobNoNew);
        $order_data = array();
        $order_data['order_no'] = $order_no;
        $order_data['survId'] = $this->surveyorCode;
        $order_data['jobNo'] = $data['jobNoShort'];

        $order_data['jobNoNew'] = $goods->jobNoNew;
        $order_data['payment_type'] = 1;
        $order_data['amount'] = $goods->amount;
        $order_data['status'] = 0;
        $order_data['create_time'] = date('Y-m-d H:i:s');

        $order_res = $this->create_order($order_data);
        if(!$order_res){
            $this->ajax_return(400,'','請稍後再試');
        }

        $session = $wechatpay->create_session($goods,$order_no,$order_res);

        if($session['res'] == 'success'){
            $res = array();
            $res['prepay_id'] = $session['data'];
            $res['order_no'] = $order_no;
            $this->ajax_return(200,$res,'success');
        }else{
            $this->payment_log('failed',$order_no,'【wechat failed】',$session['data']);
            $this->ajax_return(400,'',$session['data']);
        }
    }

    /**
     * 创建支付宝 支付
     * */
    protected function create_alipay($data){
        $goods = $this->get_real_goods($data['jobNoShort']);

    }

    /**
     * 创建stripe 支付
     * */
    protected function create_stripe($data){
        $goods = $this->get_real_goods($data['jobNoShort']);
        $stripe = new StripePayment();

        //$jobNoNew = $this->get_jobNoNew($data['jobNoShort']);
        $order_no = $this->create_order_no($goods->jobNoNew);
        $order_data = array();
        $order_data['order_no'] = $order_no;
        $order_data['survId'] = $this->surveyorCode;
        $order_data['jobNo'] = $data['jobNoShort'];

        $order_data['jobNoNew'] = $goods->jobNoNew;
        $order_data['payment_type'] = 1;
        $order_data['amount'] = $goods->amount;
        $order_data['status'] = 0;
        $order_data['create_time'] = date('Y-m-d H:i:s');

        $order_res = $this->create_order($order_data);
        if(!$order_res){
            $this->ajax_return(400,'','請稍後再試');
        }

        $session = $stripe->create_session($goods,$order_no,$order_res);
        $this->ajax_return(200,$session,'success');
    }

    /**
     * 获取真实商品信息
     * （防止管理员主动分配商品后商品对不上，需要先判断商品数量）
     * （获取没有被选在且缓存队列中的jobNoNew， 满了之后返回无库存）
     * */
    public function get_real_goods($jobno){
        $count_sql = "SELECT count(m.jobNoNew) as num FROM Survey_MainSchedule AS m WHERE `m`.`surveyorCode` = '' AND `m`.`jobNo` = '{$jobno}' and m.jobNoNew Not In (SELECT o.jobNoNew FROM Survey_SurveyorOrder AS o WHERE  o.status=0 AND o.jobNo = '{$jobno}' )";

        $count_res = $this->db->query($count_sql);
        $count_res = mysqli_fetch_assoc($count_res)['num'];
        if(empty($count_res)) $this->ajax_return(404,'','该商品已被抢完');

        $key = 'list_'.$jobno;
        $jobno_len = $this->redis->lLen($key);

        //数据库数据与缓存数据不一致，可能管理员有操作商品，需要重新添加缓存
        if($jobno_len == 0 || $count_res != $jobno_len){
            $this->redis->delete($key);
            $all_sql = "SELECT m.jobNoNew FROM Survey_MainSchedule AS m WHERE `m`.`surveyorCode` = '' AND `m`.`jobNo` = '{$jobno}' and m.jobNoNew Not In (SELECT o.jobNoNew FROM Survey_SurveyorOrder AS o WHERE  o.status=0 AND o.jobNo = '{$jobno}' )";
            $all_query = $this->db->query($all_sql);
            while ($all_sql = mysqli_fetch_assoc($all_query)) {
                $this->redis->rpush($key,$all_sql['jobNoNew']);
            }
        }
        $jobNoNew = $this->redis->lpop($key);

        $data['jobNoNew'] = $jobNoNew;
        $goods = $this->get_goods($data);
        if($goods === false){
            $this->ajax_return(404,'未找到該商品');
        }

        if($goods->amount <= 0){
            //TODO 支付金额等于0 的时候逻辑
            $this->ajax_return(400,'','該商品暫不能購買');
        }
        return $goods;
    }


    /**
     * 插入订单表
     * */
    public function create_order($order_data){
        global $db;

        $order_no = $order_data['order_no'];
        $survId = $order_data['survId'];
        $jobNo = $order_data['jobNo'];
        $jobNoNew = $order_data['jobNoNew'];
        $payment_type = $order_data['payment_type'];
        $amount = $order_data['amount'];
        $status = $order_data['status'];
        $create_time = $order_data['create_time'];

        $sql = "INSERT into Survey_SurveyorOrder(order_no,survId,jobNo,jobNoNew,payment_type,amount,status,create_time)
 values ('$order_no','$survId','$jobNo','$jobNoNew','$payment_type','$amount','$status','$create_time')";

        $res = $db->query($sql);
        if($res){
            return $db->last_insert_id();
        }else{
            return false;
        }


    }

    /**
     * 生成订单编号
     * */
    public function create_order_no($jobNoNew){

        return $jobNoNew.date('Ymd') . str_pad(mt_rand(1, 9999999999), 5, '0', STR_PAD_LEFT);

    }


    /**
     * 获取商品信息
     * */
    protected function get_goods($data){
        global $db;

        $ms = new MainSchedule();
        $msa = new MainScheduleAccess($db);
        $ms->jobNo = $data['jobNoShort'];
        $ms->jobNoNewSigle = $data['jobNoNew'];
        $jobrs = $msa->GetListSearch($ms);
        if(empty($jobrs)){
            return false;
        }
        return $jobrs[0];
    }


    public function ajax_return($code,$data,$msg = ''){

        echo json_encode(['code'=>$code,'data'=>$data,'msg'=>$msg,]);
        exit;
    }

    private function __destruct(){
        $this->redis->close();
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

        file_put_contents('/tmp/payment_log'.PROJECTNAME.'.log',$content,FILE_APPEND);

    }

}


new Payment();

