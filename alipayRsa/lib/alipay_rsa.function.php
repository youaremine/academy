<?php
/* *
 * 支付宝接口RSA函数
 * 详细：RSA签名、验签、解密
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 *Function:RSA function of Alipay
 *Detail:RSA sign,verify and Decrypt
 *version:3.3
 *modify date:2012-08-13
 *instructions:
 *This code below is a sample demo for merchants to do test.Merchants can refer to the integration documents and write your own code to fit your website.Not necessarily to use this code.  
 *Alipay provide this code for you to study and research on Alipay interface, just for your reference.
 
 */

/**
 * RSA签名RSA sign
 * @param $data 待签名数据 pre-sign string
 * @param $private_key_path 商户私钥文件路径 private key path
 * return 签名结果 sign
 */
function rsaSign($data, $private_key_path) {
    $priKey = file_get_contents($private_key_path);
//    $res = "MIIEoQIBAAKCAQBsLZXolzDuj7Z+ZaHyg3MU8v59VrpwHYcIprQTEdLI0W6XEPxnQcu++YtdIPaPzLvQqhBRp82CsWbyuIKR1V0LH+w/7oUfm/YYCTrdfxXiiAkQ7jW7HF0ZmXpmYkJ4eNsj485OKHCddX8C9YOxrhyb1h79K4MaSFVhUECVErKnQQMG/cJIyWJz3hCNdc6PQtW6QUKleatTt9zM9LZEcqy6s23zFuokLccBTPCPEk7ktcyEv67P1lk758vx7WhT7HiTmcR1Xdi2IBR7V77p4O1LpWRqZndRtm8lpfGnreFWbxIqZTG6Myb03IKQL+9iDKgiav3+H+ZTAQRGhHQxg3nxAgMBAAECggEADuWkLDiN23xc9EEIsT3a3jqsQxRrbj8StmVGjQ26Sj9VDGaha5LK/QyeXX/JlHnsL0sMHkKOcX3+oFQ6XtzUCFEoFpHBMV4n4J18xr3WhLCZFwTGz3KTe5AAJBNJ9g8mlmWrpmW5RGXGzOCEdzZz6B3vfIu+bSMi5tjHXAAMLC4AvrE4y8wX9w7kkNN/UvDdL2zkJEIR5tZlgaNyGk7nSBRrcuQ8QKAXAfZ6T/jCcy9zNAevPo4HpY459Ric1k5DZneOUUuoxl+8I9ZbDlmeQ/GtjojJHIJTjJLjJ8RiaeDUbK4hdvNCLny5qN2whLIGXGUiVBNYnQ5OJWay8i1bpQKBgQC1BS/0WULckPnK4JqaZKHU4YGTIoab4ZbFAtURKDS7973pnts0f/0/mVRcG0ePu7U5QU45goCyg4PGypXj6blyw9JDswoZLZ3ZsMWySME/O+ikor9cmYMCM9SR64/E9+cxVs/VUoO5wkHdbhxmXXJ4SxoSvt6/oOVeftaMXwEvFwKBgQCY/HGaKvRj0JmRVZoLKmzOkxSf5/td76rMZITq7NfAK/LkbEvYczE/nHZJ5QaO05/dn+PZXot0hlt3r14LEaOOvYNYrsFoZJyYWnSUmCQdqhOP68fntbE5v1fOdK13N4yp1uLv2O3FQHo/T+B+mMwjHxEwbMpkm0ak6LOKXGoENwKBgCv0yIJDMpMwuRdkluYqzYlOARLjbWBo1R2d5HM4GiYSsJEMPBpxgeNxriR3k1b5s7Xlf8NDR1ER0mvxQZiIZrnRhztdPHSEuTHlVPxH4nUibQmdY25u8HsWbuXIF68yq3c1p14bnVT8MNY+KLNKucMwKXKn2psZzNi3YA3R/A2dAoGAHWfgmiaJhSoSaooOqvjDo01IGJhpi5vGs7Tai6FsswZ/kIJ0ba1umPCFGB0KjqeEwf+6twxiN8qfiDjQFcaVLpmkxoYIrP0x0GMKp4k63+zSB8blTNdyskviH8/zi8fEpNymED4dLd3/4W2EFDFgg5u0HR+8I2xpPsdvwzeSNS8CgYBWOyoPzQz++M4r60CtdLFG3OYddJd/6kSCWRi/byIfxXLNGBFSOxwk6ZBI6f4TQgRns8Ik+aVLyu7bw9jXQX+xH1hTKSp5i5M3BogxMORIav8vXVBaTMP97LXwaNH9ShkG3EPeK/pJCHTrtCwztCZAYMJH1RdR6XS0u7oIvGxpnQ==";
    $res = openssl_get_privatekey($priKey);
    openssl_sign($data, $sign, $res);
    openssl_free_key($res);
	//base64编码
    $sign = base64_encode($sign);
    return $sign;
}

/**
 * RSA验签  RSA sign verification
 * @param $data 待签名数据 pre-sign string
 * @param $ali_public_key_path 支付宝的公钥文件路径 Alipay's public key path
 * @param $sign 要校对的的签名结果 the sign to virify
 * return 验证结果 verification result
 */
function rsaVerify($data, $ali_public_key_path, $sign)  {
	$pubKey = file_get_contents($ali_public_key_path);
    $res = openssl_get_publickey($pubKey);
    $result = (bool)openssl_verify($data, base64_decode($sign), $res);
    openssl_free_key($res);    
    return $result;
}

/**
 * RSA解密 decrypt 
 * @param $content 需要解密的内容，密文 cryptograph
 * @param $private_key_path 商户私钥文件路径path of merchant's private key
 * return 解密后内容，明文 decrypted content
 */
function rsaDecrypt($content, $private_key_path) {
    $priKey = file_get_contents($private_key_path);
    $res = openssl_get_privatekey($priKey);
	//用base64将内容还原成二进制
    $content = base64_decode($content);
	//把需要解密的内容，按128位拆开解密
//decrypt the content need to be decrypted by 128 bits
    $result  = '';
    for($i = 0; $i < strlen($content)/128; $i++  ) {
        $data = substr($content, $i * 128, 128);
        openssl_private_decrypt($data, $decrypt, $res);
        $result .= $decrypt;
    }
    openssl_free_key($res);
    return $result;
}
?>