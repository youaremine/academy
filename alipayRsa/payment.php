<?php

require_once("alipay.config.php");
require_once("lib/alipay_submit.class.php");

class PayInfo{

    public function paymentInfo($alipay_config) {
        $arr=[
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "notify_url"	=> $alipay_config['notify_url'],
            "return_url"	=> $alipay_config['return_url'],
            "out_trade_no"	=> date("Y").date("m").date("d").time(),
            "subject"	=> "测试商品",
            "total_fee"	=> "250",
            "body"	=> "test",
            "body"	=> "test",
            "secondary_merchant_id"=>"A80001",
            "secondary_merchant_name"=>"Muku",
            "secondary_merchant_industry"=>"7011",
            "currency" =>"HKD",//交易币种
            "product_code" => "NEW_WAP_OVERSEAS_SELLER",
            "_input_charset"	=>"utf-8",
            "payment_type"=>1,
            "it_b_pay"=>"30m",
            "forex_biz"=>"FP",
            "payment_inst"=>"ALIPAYHK"
        ];
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $sign=$alipaySubmit->buildRequestPara($arr);

        $url = urlencode(http_build_query($sign));
//        var_dump( $url);exit;
        return $url;
    }
}

$type=$_GET['type'];
if($type=="paymentInfo"){

    $payInfo=new PayInfo();
    $info=$payInfo->paymentInfo($alipay_config);
//    $info="alipayhk://platformapi/startapp?appId=20000067&url=".$info;
    echo  json_encode($info);
}

