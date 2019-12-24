<?php


include('../includes/UserAuto.php');

/**
 * USERTYPE  第三方类型 1或者2
 * ACTIONTYPE 操作类型 verify为验证 bind为绑定 login为注册
 * TOKEN    第三方ID
 */


$user = new UserAuto();
$token = filter_input(INPUT_GET, 'TOKEN');// 授权ID
$user_type = filter_input(INPUT_GET, 'USERTYPE');//第三方类型
$contact = filter_input(INPUT_GET, 'CONTACT');//手机号码
$action_type = filter_input(INPUT_GET, 'ACTIONTYPE');//verify为验证 bind为绑定 login为注册
$channel=filter_input(INPUT_GET, 'CHANNEL');//默认值为0  网页  1为安卓  2为苹果
session_start();
if(empty($channel)){
    $channel= 0;
}
switch ($action_type) {
    case 'verify':
        $user->setInfo($user_type, $token);
        $judge = $user->verify();
        if ($judge) {
            //登录成功
            $user->SaveSession();//保存会话
            $message=$user->inpuierUser();
            if($channel == 2 || $channel == 3){
                $sign = date("Ymd").uniqid();
                $message['sign'] = $sign;
                //写入到文件中
                $filename = $conf["path"]["sign"].$sign;

                file_put_contents($filename,$user->getUserId());
            }
            echo json_encode($message,JSON_UNESCAPED_UNICODE);
        } else {
            $message = array (
                'status' => 'failed',
                'msg' => "No stored third party information",
                'surveyor' => ''
            );
            echo json_encode($message,JSON_UNESCAPED_UNICODE);
        }
        break;
    case 'bind':
        $user->setInfo($user_type, $token);
        //判断绑定手机是否存在原先账户

        $user->setInfo($user_type, $token, $surveyor['survId'],$surveyor['contact']);
        $user->bindUser();
        break;
    case 'login':
        break;
}