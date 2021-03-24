<?php
require_once ('../includes/config.inc.php');
require_once('stripe-php/init.php');
require_once('../account/PaymentConf.php');

/**
 * stripe 支付方式
 * */
class StripePayment extends PaymentConf
{

    private $currency = 'hkd';
    private $locale = 'zh-HK';
    private $payment_method_types = ['card','alipay'];//支付方式


    private $host_name = '';

    public function __construct(){
        $http_str = 'http://';
        if($this->is_https()){
            $http_str = 'https://';
        }
        $this->host_name = $http_str.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME;
    }

    public function create_session($goods,$order_no,$order_id){
        $key = $this->live_mode == false?$this->stripe_test_key:$this->stripe_live_key;
        \Stripe\Stripe::setApiKey($key);
        $images = $this->get_images_url($goods->img_url);
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => $this->payment_method_types,
            'client_reference_id'=>$order_no,
            'line_items' => [[
                'price_data' => [
                    'currency' => $this->currency,
                    'unit_amount' => $goods->amount * 100,
                    'product_data' => [
                        'name' => $goods->surveyType,
                        'images' => $images,
                    ],
                ],
                'quantity' => 1,
            ]],
            'locale'=>$this->locale,
            'mode' => 'payment',
            'success_url' => $this->host_name . '/account/PaymentBack.php?type=stripe&action=success&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $this->host_name . '/account/PaymentBack.php?type=stripe&action=cancel&session_id={CHECKOUT_SESSION_ID}',
        ]);

        return $checkout_session->id;
    }

    /**
     * 获取商品图片
     * */
    public function get_images_url($goods_img_str){
        $goods_url_arr = explode(',',$goods_img_str);
        foreach($goods_url_arr as &$v){
            $v = $this->host_name.$v;
        }

        return $goods_url_arr;
    }

    /**
     * 添加到订单表
     * */
    public function add_order($order_data){
        global $db;
        list($order_no,$survId,$jobNo,$jobNoNew,$payment_type,$amount,$status,$create_time,$result_raw) = $order_data;


        $sql = "INSERT into Survey_SurveyorOrder(order_no,survId,jobNo,jobNoNew,payment_type,amount,status,create_time,result_raw)
 values ('$order_no','$survId','$jobNo','$jobNoNew','$payment_type','$amount','$status','$status','$create_time','$result_raw')";

        $res = $db->query($sql);

        return $res;
    }


    public function is_https() {
        if ( !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return true;
        } elseif ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
            return true;
        } elseif ( !empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return true;
        }
        return false;
    }

}