<?php
/**
 * 等待付款页面
 * @author wooken <471159717@qq.com>
 * @version 1.01 , 2021-03-02
 */

require_once("../includes/config.inc.php");

Class PaymentCheck{
    private $surveyorCode = null;
    private $db;


    public function __construct(){
        global $db;
        //TODO 整合校验手机端请求
        if (!SurveyorLogin::IsLogin())  exit('Login timeout.');// 检查是否登录
        $this->surveyorCode = $_SESSION['surveyorId'];
        $this->db = $db;

        $this->route($_REQUEST);
    }

    /**
     *
     * 路由
     * */
    private function route($data){
        switch ($data['type']) {
            case 'wechat' :
                $this->loading($data);
                break;
            case 'success' :
                $this->success($data);
                break;
            case 'failed' :
                $this->failed($data);
                break;
            default :
                $this->failed($data);
                break;

        }
    }

    public function loading($data){
        global $conf;

        $t = new CacheTemplate("../templates/account");
        $t->set_caching($conf["cache"]["valid"]);
        $t->set_cache_dir($conf["cache"]["dir"]);
        $t->set_expire_time($conf["cache"]["timeout"]);
        $t->set_file("HdIndex", "payment_check.html");
        $t->set_var ( array (
            "type" => $data['type'],
            "order_no" => $data['order_no']
        ) );
        $t->pparse("Output", "HdIndex");

    }

    public function success($data){
        global $conf;
        $t = new CacheTemplate("../templates/account");
        $t->set_caching($conf["cache"]["valid"]);
        $t->set_cache_dir($conf["cache"]["dir"]);
        $t->set_expire_time($conf["cache"]["timeout"]);
        $t->set_file("HdIndex", "payment_success.html");
        $t->set_var ( array (
            "order_no" => $data['order_no']
        ) );
        $t->pparse("Output", "HdIndex");
    }

    public function failed($data){
        global $conf;
        $t = new CacheTemplate("../templates/account");
        $t->set_caching($conf["cache"]["valid"]);
        $t->set_cache_dir($conf["cache"]["dir"]);
        $t->set_expire_time($conf["cache"]["timeout"]);
        $t->set_file("HdIndex", "payment_failed.html");
        $t->set_var ( array (
            "order_no" => $data['order_no']
        ) );
        $t->pparse("Output", "HdIndex");
    }

}


new PaymentCheck();

