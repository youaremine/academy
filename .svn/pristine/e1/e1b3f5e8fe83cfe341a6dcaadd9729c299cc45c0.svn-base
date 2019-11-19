<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
if(isMobileBrowser()){
	header("location:./account/login.php");
	exit();
}
// 清除登录信息
unset ( $_SESSION ['surveyorId'] );
$error = '';
$userName = '';
if ($_POST ['login'] != "") {
	$userName = $_POST ['userName'];
	if ($_SESSION ['antispamChars'] == strtolower ( $_POST ['antispam'] )) {
		$passWord = $_POST ['passWord'];
		$login = new SurveyorLogin ( $db );
		if ($login->Login ( $userName, $passWord )) {
			header ( "Location:./account/" );
			exit ();
		} else {
			$error = "Username and password is error.";
		}
	} else {
		$error = "Please enter the letters as they are shown in the image above.";
	}
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "login.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

$t->set_var ( 'forUser', 'For Surveyor Login Only.' );
$t->set_var ( 'Error', $error );
$t->set_var ( "userName", $userName );

$t->pparse ( "Output", "HdIndex" );
?>
