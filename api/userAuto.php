<?php

/**
 * q 操作类型 verify为验证 bind为绑定(注册/第三方),signIn为直接注册
 * USERTYPE  第三方类型 facebook或者 google
 * TOKEN    第三方验证ID
 * contact  电话号码
 * chiName  中文名
 * engName  英文名
 * survType 用户类型
 * avatar   用户头像Url
 * CHANNEL  客户端类型  默认0  2：安卓  3:为苹果
 * pass     密码
 * 用户信息
 * --------------------
 * email    邮箱
 * whatsAPP whatsAPP
 * remarks  备注
 * survHome 住址
 * birthday 出生日期
 * dipaCode 地区
 * vip_level会员等级
 * ----------------------
 * 第三方验证时需传递  q=verify USERTYPE TOKEN CHANNEL参数
 * 第三方绑定注册时  q=bind TOKEN CHANNEL USERTYPE contact chiName engName survType avatar,用户信息 参数，
 *
 * 直接注册时
 * 第一次验证号码是否存在 传递 q=signIn contact参数
 * 第二次注册传递 q=signIn contact chiName engName survType avatar pass,用户信息 参数
 */

$rawJson = file_get_contents('php://input', 'r');
$data_info = json_decode($rawJson, TRUE);

if(empty($data_info)){
    $data_info=$_REQUEST;
}

$token = addslashes($data_info['TOKEN']);
$user_type = addslashes($data_info['USERTYPE']);
$action_type = $data_info['q'];
$channel = addslashes($data_info['channel']);
$contact=addslashes($data_info['contact']);
$chiName=addslashes($data_info['chiName']);
$engName=addslashes($data_info['engName']);
$survType=addslashes($data_info['survType']);
$avatar=addslashes($data_info['avatar']);
$pass=addslashes($data_info['pass']);

$email=addslashes($data_info['email']);//邮箱
$whatsAPP=addslashes($data_info['whatsAPP']);//whatsAPP
$remarks=addslashes($data_info['remarks']);//备注
$survHome=addslashes($data_info['survHome']);//住址
$birthday=addslashes($data_info['birthday']);//出生日期
$dipaCode=addslashes($data_info['dipaCode']);//地区
$vip_level=addslashes($data_info['vip_level']);//会员等级

$unimInfo=array(
    'email'=>$email,
    'whatsAPP'=>$whatsAPP,
    'remarks'=>$remarks,
    'survHome'=>$survHome,
    'birthday'=>$birthday,
    'dipaCode'=>$dipaCode,
    'vip_level'=>$vip_level
);

$arrs=array(
    'contact'=>$contact,
    'chiName'=>$chiName,
    'engName'=>$engName,
    'survType'=>$survType,
    'avatar'=>$avatar,
);
$info=json_encode($arrs);//进行json编码
if(empty($unimInfo)){
    $unimInfo=json_encode($unimInfo);//进行json编码
    $unimInfo=json_decode($unimInfo);//将json格式转换为对象
}
session_start();
include('../includes/UserAuto.php');
$user = new UserAuto();
if (empty($channel)) {
    $channel = 0;
}

if (!empty($info)) {
    $info = json_decode($info);//将json格式转换为对象
}
    //file_put_contents('/tmp/bindlog.log', json_encode($_REQUEST) . "\n\r", FILE_APPEND);
file_put_contents('/tmp/third.log','~~~~~~~~~~~'.time().'Request:'.json_encode($_REQUEST)."\n\n",FILE_APPEND);
//


switch ($action_type) {
    case 'verify':
        judgeToken($token,$user_type);
        $user->setInfo($user_type, $token);
        $sign = date("Ymd") . uniqid();
        $filename = $conf["path"]["sign"] . $sign;
        login($user, $channel, $filename, $sign);
        break;
    case 'bind':
        judgeToken($token,$user_type);
        $user->setInfo($user_type, $token);
        if(empty($contact)){
            $message = array(
                'status' => 'success',
                'msg' => "`contact` Data is empty",
                'surveyor' => '',
                'state' => 'writeFailed'
            );
            echo json_encode($message, JSON_UNESCAPED_UNICODE);
            exit();
        }
        $user->setContact($info->contact);
        $user->inquire();//查询ID
        $sign = date("Ymd") . uniqid();
        $filename = $conf["path"]["sign"] . $sign;
        //通过手机号和token判定是否已经绑定第三方
        if ($user->verify()) {
            login($user, $channel, $filename, $sign);
            break;
        } else {
            //判定绑定手机是否存在原先账户
            $arr = $user->inquire();
            if ($arr['state']) {
                //通过ID和手机号判断是否绑定第三方
                if($user->verify(1)){
                    $message = array(
                        'status' => 'success',
                        'msg' => "The third-party account has been bound",
                        'surveyor' => '',
                        'state' => 'repeatToWrite'
                    );
                    echo json_encode($message, JSON_UNESCAPED_UNICODE);
                }else{
                    writeUser($user, $arr, $channel, $filename, $sign);
                }
            } else {
                //不存在，注册账户并写入
                $user->setUserInfo($info->chiName, $info->engName, $info->suryType, $info->avatar);
                $infoUser = $user->register($unimInfo);
                if ($infoUser['state']) {
                    writeUser($user, $infoUser, $channel, $filename, $sign);
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
    case 'signIn':
        //判断电话号码是否注册
        if(empty($contact)){
            //写入失败
            $message = array(
                'status' => 'success',
                'msg' => "`contact` Data is empty",
                'surveyor' => '',
                'state' => 'writeFailed'
            );
            echo json_encode($message, JSON_UNESCAPED_UNICODE);
            exit();
        }
        $user->setContact($contact);
        $arr=$user->inquire();
        if($arr['state']){
            //存在 返回登录信息
            $user->setUserId($arr['info']['survId']);
            $message=$user->inpuierUser();
            $sign = date("Ymd") . uniqid();
            $filename = $conf["path"]["sign"] . $sign;
            if ($channel == 2 || $channel == 3) {
                $message['sign'] = $sign;
                file_put_contents($filename, $user->getUserId());
            }
            echo json_encode($message, JSON_UNESCAPED_UNICODE);
        }else{
            //不存在进行注册
            $user->setUserInfo($chiName,$engName,$survType);
            if (empty($pass)) {
                $message = array(
                    'status' => 'success',
                    'msg' => "`pass` Data is empty",
                    'surveyor' => '',
                    'state' => 'none'
                );
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
                exit();
            }
            $user->setPass($pass);
            $infoUser=$user->register($unimInfo);//写入账号信息
            if($infoUser['state']){
                $infoPass=$user->getPassword();//写入密码信息
                if($infoPass['state']){
                    $message=$user->inpuierUser();
                    $sign = date("Ymd") . uniqid();

                    $filename = $conf["path"]["sign"] . $sign;
                    if ($channel == 2 || $channel == 3) {
                        //添加sign值并生成文件
                        $message['sign'] = $sign;
                        file_put_contents($filename, $user->getUserId());
                    }
                    echo json_encode($message, JSON_UNESCAPED_UNICODE);
                }else{
                    //密码写入失败
                    $message = array(
                        'status' => 'success',
                        'msg' => "Password write failed,Please check the database `Survey_SurveyorPassword`",
                        'surveyor' => '',
                        'state' => 'writeFailed'
                    );
                    echo json_encode($message, JSON_UNESCAPED_UNICODE);
                }
            }else{
                //账号写入失败
                $message = array(
                    'status' => 'success',
                    'msg' => "Third party data write failed,Please check the database `Survey_Surveyor`",
                    'surveyor' => '',
                    'state' => 'writeFailed'
                );
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
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
/**登錄賬戶，并返回用戶信息
 * @param $user userAuto的实例对象
 * @param $channel 安卓，苹果，pc端标识
 * @param $filename 保存文件名
 * @param $sign 手机端识别码
 * @param null $mark 是否需要返回密码
 */
function login($user, $channel, $filename, $sign){
    $judge = $user->verify();
    if ($judge) {
        //登录成功
        $user->SaveSession();//保存会话
        $message = $user->inpuierUser();//获取信息
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

function writeUser($user, $arr, $channel, $filename, $sign){
    //创建成功
    $user->setUserId($arr['info']['survId']);
    $state = $user->bindUser();
    if ($state) {
        //写入成功
        login($user, $channel, $filename, $sign);
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

/**判断传送的变量是否为空值
 * @param $token
 * @param $user_type
 */
function judgeToken($token,$user_type){
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
}