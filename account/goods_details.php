<?php
/**
 * 显示物品详情页面
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

$jobNoShort=filter_input(INPUT_GET,'jobNoShort');
$type=filter_input(INPUT_POST,TYPE);
if(!empty($jobNoShort)){
    $ja = new JobsAccess($db);
    $arr=$ja->getGoodsUrl(2,$jobNoShort);
    setcookie("ImgUrl",$arr,time()+10);
}else if($type=="q"){
    $img_url=$_COOKIE['ImgUrl'];
    echo $img_url;
    return;
}
include_once("../templates/account/goods_details.html");



