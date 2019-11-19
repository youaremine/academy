<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");

// 清除登录信息
unset ( $_SESSION ['surveyorId'] );
$error = '';
$userName = '';
$jsonData = array();
if ($_POST['username'] != "") {
	$username = $_POST['username'];
	if ($_SESSION ['antispamChars'] == strtolower($_POST ['antispam'])) {
		$password = $_POST ['password'];
		$login = new SurveyorLogin ( $db );
		if ($login->Login( $username, $password )) {
			$jsonData = array (
					'success' => true,
					'jump' => './index.php',
					'message' => '登入成功!'
			);
			die(json_encode($jsonData));
		} else {
			$jsonData = array (
					'success' => false,
					'jump' => '',
					'message' => '用戶名或密碼錯誤!'
			);
			die(json_encode($jsonData));
		}
	} else {
		$jsonData = array (
				'success' => false,
				'jump' => '',
				'message' => '驗證碼錯誤!'
		);
		die(json_encode($jsonData));
	}
}

$t = new CacheTemplate("../templates/account");
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
