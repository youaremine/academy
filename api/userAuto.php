<?php
include ('../includes/UserAuto.php');
$user=new UserAuto();
$token=filter_input(INPUT_GET,'TOKEN');
$user_type=filter_input(INPUT_GET,'USERTYPE');
$user_id=filter_input(INPUT_GET,'USERID');
$action_type=filter_input(INPUT_GET,'ACTIONTYPE');//1为验证 2为绑定 3为注册
switch ($action_type){
    case 1:
        $user->setInfo($user_type,$token);
        $user->verify();
    case 2:
        $user->setInfo($user_type,$token,USERID);
        $user->bindUser();
    case 3:

}