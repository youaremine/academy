<?php
/**
 *  功能 :获取数据库数据，并传递给前端页面，
 */

include_once ("../includes/config.inc.php");
include_once ("../includes/config.plugin.inc.php");

// 检查是否登录
if (SurveyorLogin::IsLogin())
{
    $surveyorCode = $_SESSION['surveyorId'];
    $noCurrUser = "";
}
else
{
    header("Location:../surveyor_login.php");
    exit();
}

$type=filter_input(INPUT_POST,TYPE);
if($type=="q"){
    $ja = new JobsAccess($db);
    $arr=$ja->getGoodsUrl(1);
    echo $arr;
    return;
}
include_once("../templates/account/jobs_4.html");
