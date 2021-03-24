<?php
/**
 * 生成支付类
 * @author wooken <471159717@qq.com>
 * @version 1.01 , 2021-03-02
 */


Class PaymentConf{

    protected $live_mode = false;//是否生产环境

    //stripe 支付配置项
    protected $stripe_test_key = 'sk_test_51IBweYKfjMsC8JpVz6GDo5KWc9OrKQx1nJx1xQhndcLcQ7nPBdH0VMHfYABSxofUPjLTB2OH5PHUvNQZjngMEMn9007tcNpG4X';//测试环境秘钥
    protected $stripe_live_key = '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';//生产环境秘钥

    //微信支付配置
    protected $appid = 'wxcfd86c246a46ff84'; // 商户号
    protected $merchantId = '126125418'; // 商户号
    protected $merchantSerialNumber = '76709B83E5A0494EA3F25ADBC38939778B7B94F2'; // 商户API证书序列号
    protected $merchant_category_code = '7032';//类别，参考 https://pay.weixin.qq.com/wiki/doc/api/wxpay/en/fusion_wallet/chapter2_3.shtml#part-7
    protected $merchantPrivateKey_path = '../payment/wechat/apiclient_key.pem';//商户私钥
    protected $wechatpayCertificate_path = '../payment/wechat/wechatpay_447B76563F1BDE4DEAE64000D34758F4378542CC.pem';//支付证书
    protected $apis = 'RoriN4KyomwaAFL4KyMvjrFuJlbGoNGg';

    //支付宝支付配置项
    protected $alipay_config = array();

    protected function __construct(){

    }


}


