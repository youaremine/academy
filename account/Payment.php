<?php
/**
 * 生成支付类
 * @author wooken <471159717@qq.com>
 * @version 1.01 , 2021-03-02
 */

require_once '../payment/StripePayment.php';
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
     * 防止管理员主动分配商品后商品对不上，需要先判断商品数量
     * 获取存在 redis 队列中的 jobNoNew
     * */
    public function get_real_jobNoNew($jobno){

        $count_sql = "SELECT
                          count(`m`.`jobNoNew`) as num
                        FROM
                          `Survey_MainSchedule` AS m,
                          (SELECT `so`.`jobNoNew` FROM `Survey_SurveyorOrder` AS so WHERE `so`.`status` = 0 AND `so`.`jobNo` = '{$jobno}') AS had
                        WHERE
                          `m`.`surveyorCode` = '' AND `m`.`jobNo` = '{$jobno}' AND `had`.`jobNoNew` != `m`.`jobNoNew`";

        $count_res = $this->db->query($count_sql);
        $count_res = mysqli_fetch_assoc($count_res)['num'];
        if(empty($count_res)) return false;

        $key = 'list_'.$jobno;
        $jobno_len = $this->redis->lLen($key);

        //重新添加到缓存,数据库数据与缓存数据不一致，可能管理员有操作商品，需要重新添加到缓存
        if($jobno_len == 0 || $count_res != $jobno_len){
            $this->redis->delete($key);
            $all_sql = "SELECT
                          `m`.`jobNoNew`
                        FROM
                          `Survey_MainSchedule` AS m,
                          (SELECT `so`.`jobNoNew` FROM `Survey_SurveyorOrder` AS so WHERE `so`.`status` = 0 AND `so`.`jobNo` = '{$jobno}') AS had
                        WHERE
                          `m`.`surveyorCode` = '' AND `m`.`jobNo` = '{$jobno}' AND `had`.`jobNoNew` != `m`.`jobNoNew`";
            $all_query = $this->db->query($all_sql);
            while ($all_sql = mysqli_fetch_assoc($all_query)) {
                $this->redis->rpush($key,$all_sql['jobNoNew']);
            }
        }
        return $this->redis->lpop($key);
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
        }
    }

    /**
     * 创建stripe 支付
     * */
    protected function create_stripe($data){
        $jobNoNew = $this->get_real_jobNoNew($data['jobNoShort']);
        if($jobNoNew === false){
            $this->ajax_return(404,'该商品已被抢完');
        }
        $data['jobNoNew'] = $jobNoNew;
        $goods = $this->get_goods($data);
        if($goods === false){
            $this->ajax_return(404,'未找到該商品');
        }

        if($goods->amount <= 0){
            //TODO 支付金额等于0 的时候逻辑
            $this->ajax_return(400,'','該商品暫不能購買');
        }else{
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
    }


    /**
    * 获取没有被选也不在缓存锁定中的jobNoNew ， 如果已经加锁则跳过此jobNoNew ，满了之后返回无库存
    */
    public function get_jobNoNew($jobNo){
        global $db;
        $jobNoNew = null;

        $stock_goods = array();

        $sql = "SELECT `jobNoNew` FROM Survey_MainSchedule WHERE 1=1 and `jobNo` = '{$jobNo}' and `surveyorCode` = '' and `surveyorName` = '' and `surveyorTelephone` = ''";
        $db->query ( $sql );
        while ( $res = $db->next_record () ) {
            $stock_goods[] = $res['jobNoNew'];
        }

        if(empty($stock_goods)){
            $this->ajax_return(400,'','該商品已被搶購完');
        }

        return $jobNoNew;
    }



    /**
     * 锁定当前商品编号，避免多次购买
     * */
    protected function lock_goods($goods){

        $redis = new redis();
        $result = $redis->connect('127.0.0.1', 6379);
        if(!$result){
            $this->ajax_return(500,'','System Error');
        }






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

}


new Payment();

