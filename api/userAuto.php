<?php
include('../includes/UserAuto.php');
$user = new UserAuto();
$token = filter_input(INPUT_GET, 'TOKEN');
$user_type = filter_input(INPUT_GET, 'USERTYPE');
$contact = filter_input(INPUT_GET, 'CONTACT');
$action_type = filter_input(INPUT_GET, 'ACTIONTYPE');//1为验证 2为绑定 3为注册

switch ($action_type) {
    case 1:
        $user->setInfo($user_type, $token);
        $judge = $user->verify();
        if ($judge) {
            //登录成功
            $user->SaveSession();
            $arr=array(
                'judge' => true,
                'surveyor'=>$user->inpuierUser(),
                'info' => "Successful user login"
            );
            return $arr;
        } else {
            //登录失败
            $arr = array(
                'judge' => false,
                'surveyor'=>null,
                'info' => "No third party information found"
            );
            return $arr;
        }
    case 2:
        $surveyor=$user->inpuierUser();//获取信息
        $user->setInfo($user_type, $token, $surveyor['survId'],$contact);//设置属性
        $user->bindUser();
    case 3:

}