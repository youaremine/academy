<?php
/*
 * Header: 
 * Create: 2007-1-3 
 * Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

//只有调查员自己才能更改密码
if (SurveyorLogin::IsLogin())
{
	$surveyorCode = $_SESSION['surveyorId'];
}
else
{
	header("Location:surveyor_login.php");
	exit();
}

$error = '';
$surveyorCode = $_SESSION['surveyorId'];
if ($_POST['Update'] != "")
{
	$newPassword = $_POST['newPassword'];
	$confirmPassword = $_POST['confirmPassword'];
	if ($newPassword == "")
	{
		$error = "password is not allow null.";
	}
	else if ($newPassword == $confirmPassword)
	{
		$sl = new SurveyorLogin($db);
		$sl->UpdatePassword($surveyorCode, $newPassword);
		$error = "your password updated success.";
	}
}

$t = new CacheTemplate("./templates");
$t->set_file("HdIndex", "surveyor_change_password.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();

$t->set_var('Error', $error);
$t->set_var("surveyorCode", $surveyorCode);

$t->pparse("Output", "HdIndex");
?>