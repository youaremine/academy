<?php

require_once ('../includes/config.inc.php');
require_once('../account/PaymentConf.php');
use GuzzleHttp\Exception\RequestException;
use WechatPay\GuzzleMiddleware\WechatPayMiddleware;
use WechatPay\GuzzleMiddleware\Util\PemUtil;
use GuzzleHttp\HandlerStack;

/**
 * stripe 支付方式
 * */
class WechatPayment extends PaymentConf
{

    private $currency = 'HKD';


    private $host_name = '';

    public function __construct(){
        $http_str = 'http://';
        if($this->is_https()){
            $http_str = 'https://';
        }
        $this->host_name = $http_str.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME;

    }

    public function create_session($goods,$order_no,$order_id){

        $merchantId = $this->merchantId;
        $merchantSerialNumber = $this->merchantSerialNumber;


        $merchantPrivateKey = PemUtil::loadPrivateKey($this->merchantPrivateKey_path); // 商户私钥

        $wechatpayCertificate = PemUtil::loadCertificate($this->wechatpayCertificate_path); // 微信支付平台证书 (微信支付平台配置)
// 构造一个WechatPayMiddleware
        $wechatpayMiddleware = WechatPayMiddleware::builder()
            ->withMerchant($merchantId, $merchantSerialNumber, $merchantPrivateKey) // 传入商户相关配置
            ->withWechatPay([ $wechatpayCertificate ]) // 可传入多个微信支付平台证书，参数类型为array
            ->build();

// 将WechatPayMiddleware添加到Guzzle的HandlerStack中
        $stack = GuzzleHttp\HandlerStack::create();
        $stack->push($wechatpayMiddleware, 'wechatpay');

// 创建Guzzle HTTP Client时，将HandlerStack传入
        $client = new GuzzleHttp\Client(['handler' => $stack]);
        $amount = $goods->amount * 100 *1;
// 接下来，正常使用Guzzle发起API请求，WechatPayMiddleware会自动地处理签名和验签
        try {

            $resp = $client->request('POST', 'https://api.mch.weixin.qq.com/hk/v3/transactions/app', [
                'json' => [ // JSON请求体
                    'appid' => $this->appid,
                    'mchid' => $this->merchantId,
                    'description' => $goods->surveyType,
                    'out_trade_no' => $order_no,
                    'notify_url' => $this->host_name . '/account/PaymentBack.php',
                    "trade_type"=>"APP",
                    "merchant_category_code"=>$this->merchant_category_code,
                    'amount' => ["total"=>$amount,"currency"=>$this->currency],
                ],
                'headers' => [ 'Accept' => 'application/json' ]
            ]);

            if($resp->getStatusCode() === 200){
                $res = json_decode($resp->getBody());
                return ['res'=>'success','data'=>$res->prepay_id];
            }
        } catch (RequestException $e) {
            return ['res'=>'failed','data'=>$e->getMessage()];
            /*if ($e->hasResponse()) {
                echo $e->getResponse()->getStatusCode().' '.$e->getResponse()->getReasonPhrase()."\n";
                echo $e->getResponse()->getBody();
            }*/
        }
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