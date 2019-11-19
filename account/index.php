<?php

/*
 * Header:
 * Create: 2015-12-06
 * Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");
include_once ("../includes/config.plugin.inc.php");

// 检查是否登录
if (SurveyorLogin::IsLogin())
{
	$surveyorCode = $_SESSION['surveyorId'];
	$noCurrUser = "";
}
else if (UserLogin::IsAdministrator() && !empty($_GET['surveyorId']))
{
	$surveyorCode = $_GET['surveyorId'];
	$noCurrUser = "display:none;";
}
else
{
	header("Location:../surveyor_login.php");
	exit();
}

$t = new CacheTemplate("../templates/account");
$t->set_file("HdIndex", "index.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();

// 设置更改密码，登出
$t->set_var("noCurrUser", $noCurrUser);

$t->pparse("Output", "HdIndex");
?>