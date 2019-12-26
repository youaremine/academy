<?php

/**
 * USERTYPE  第三方类型 facebook或者 google
 * q 操作类型 verify为验证 bind为绑定(注册)
 * TOKEN    第三方ID
 * INFO      用户信息  {"contact":"电话号码","chiName":"中文名","engName":"英文名","survType":"类型","avatar":"头像Url"}
 * CHANNEL    客户端类型  默认0  1：安卓  2为苹果
 * 验证时需传递 USERTYPE q=verify TOKEN CHANNEL等参数
 * 绑定注册时 USERTYPE q=bind TOKEN CHANNEL INFO 等参数
 */

$rawJson = file_get_contents('php://input', 'r');
$data_info = json_decode($rawJson, TRUE);

$token = $data_info['TOKEN'];
$user_type = $data_info['USERTYPE'];
$action_type = $data_info['q'];
$channel = $data_info['channel'];

$contact=$data_info['contact'];
$chiName=$data_info['chiName'];
$engName=$data_info['engName'];
$survType=$data_info['survType'];
$avatar=$data_info['avatar'];


if (empty($token)) {
    $token = $_REQUEST ['TOKEN'];
}
if (empty($user_type)) {
    $user_type = $_REQUEST ['USERTYPE'];
}
if (empty($action_type)) {
    $action_type = $_REQUEST ['q'];
}
if (empty($channel)) {
    $channel = $_REQUEST ['channel'];
}
//$token = filter_input(INPUT_POST, 'TOKEN');// 授权ID
//$user_type = filter_input(INPUT_POST, 'USERTYPE');//第三方类型 facebook
//$info = filter_input(INPUT_POST, 'INFO');  //JSON格式，我这边转换为数组
//$action_type = filter_input(INPUT_POST, 'q');//verify为验证 bind为绑定（注册）
//$channel = filter_input(INPUT_POST, 'CHANNEL');//默认值为0  网页  1为安卓  2为苹果
if (empty($contact)) {
    $contact = $_REQUEST ['contact'];
}
if (empty($chiName)) {
    $chiName = $_REQUEST ['chiName'];
}
if (empty($engName)) {
    $engName = $_REQUEST ['engName'];
}
if (empty($survType)) {
    $survType = $_REQUEST ['survType'];
}
if (empty($avatar)) {
    $avatar = $_REQUEST ['avatar'];
}

$arrs=array(
    'contact'=>$contact,
    'chiName'=>$chiName,
    'engName'=>$engName,
    'survType'=>$survType,
    'avatar'=>$avatar,
);
$info=json_encode($arrs);
session_start();
include('../includes/UserAuto.php');
$user = new UserAuto();
if (empty($channel)) {
    $channel = 0;
}

if (!empty($info)) {
    $info = json_decode($info);
}
//file_put_contents('/tmp/bindlog.log', json_encode($_REQUEST) . "\n\r", FILE_APPEND);

if (empty($token)) {
    $message = array(
        'status' => 'failed',
        'msg' => "`TOKEN` Data is empty",
        'surveyor' => '',
        'state' => 'error'
    );
    echo json_encode($message, JSON_UNESCAPED_UNICODE);
    exit();
}
if (empty($user_type)) {
    $message = array(
        'status' => 'failed',
        'msg' => "`USERTYPE` Data is empty",
        'surveyor' => '',
        'state' => 'error'
    );
    echo json_encode($message, JSON_UNESCAPED_UNICODE);
    exit();
}

switch ($action_type) {
    case 'verify':
        $user->setInfo($user_type, $token);
        $sign = date("Ymd") . uniqid();
        $filename = $conf["path"]["sign"] . $sign;
        login($user, $channel, $filename, $sign);
        break;
    case 'bind':
        $user->setInfo($user_type, $token);
        $user->setContact($info->contact);
        $sign = date("Ymd") . uniqid();
        $filename = $conf["path"]["sign"] . $sign;

        //先判定是否已经绑定第三方
        if ($user->verify()) {
            login($user, $channel, $filename, $sign);
            break;
        } else {
            //判断绑定手机是否存在原先账户
            $arr = $user->inquire();
            if ($arr['state']) {
                //存在
                writeUser($user, $arr, $channel, $filename, $sign);
            } else {
                //不存在，注册账户并写入
                $user->setUserInfo($info->chiName, $info->engName, $info->suryType, $info->avatar);
                $arr = $user->register();
                if ($arr['state']) {
                    writeUser($user, $arr, $channel, $filename, $sign, 'pass');
                } else {
                    //写入失败
                    $message = array(
                        'status' => 'success',
                        'msg' => "Third party data write failed,Please check the database `Survey_Surveyor`",
                        'surveyor' => '',
                        'state' => 'writeFailed'
                    );
                    echo json_encode($message, JSON_UNESCAPED_UNICODE);
                }
            }
        }
        break;
    default:
        $message = array(
            'status' => 'failed',
            'msg' => "No stored third party information",
            'surveyor' => $surveyor,
            'state' => 'error'
        );
        echo json_encode($message, JSON_UNESCAPED_UNICODE);
        break;
}

function login($user, $channel, $filename, $sign, $mark = null)
{
    $judge = $user->verify();
    if ($judge) {
        //登录成功
        $user->SaveSession();//保存会话
        $message = $user->inpuierUser($mark);//获取信息

        if ($channel == 2 || $channel == 3) {
            $message['sign'] = $sign;
            file_put_contents($filename, $user->getUserId());
        }
        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    } else {
        //验证失败
        $message = array(
            'status' => 'success',
            'msg' => "No stored third party information",
            'surveyor' => '',
            'state' => 'none'
        );
        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }
}

function writeUser($user, $arr, $channel, $filename, $sign, $mark = null)
{
    //创建成功
    $user->setUserId($arr['info']['survId']);
    $state = $user->bindUser();
    if ($state) {
        //写入成功
        login($user, $channel, $filename, $sign, $mark);
    } else {
        //写入失败
        $message = array(
            'status' => 'success',
            'msg' => "Third party data write failed,Please check the database`Survey_User_Auth`",
            'surveyor' => '',
            'state' => 'writeFailed'
        );
        echo json_encode($message, JSON_UNESCAPED_UNICODE);
    }
}
//
//function judgeNull($arr){
//    foreach ($arr as $key=>$value){
//            if(empty($value)){
//"$".$key=$value;
//            }
//    }
//}