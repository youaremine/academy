<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

$error = '';
$userName = '';
if ($_POST ['login'] != "") {
	// print $_SESSION['antispamChars']." == ".strtolower($_POST['antispam']);
	$userName = $_POST ['userName'];
	if ($_SESSION ['antispamChars'] == strtolower ( $_POST ['antispam'] )) {
		$passWord = $_POST ['passWord'];
		$ul = new UserLogin ( $db );
		if ($ul->Login ( $userName, $passWord )) {
			if ($ul->IsNeedUpdatePassword ()) {
				header ( "Location:update-password.php" );
			} else {
				header ( "Location:index.php" );
			}
			exit ();
		} else {
			$error = "用戶名或者密碼錯誤。";
		}
	} else {
		$error = "請輸入驗證碼.";
	}
} else {
	if ($_GET ['key'] == "l2liib6t") 	// 生成的随机密码
	{
		// TODO
	} else {
		echo "<span style='color:red'>網址錯誤！請聯繫 +852 34885449 。</span>";
		exit ();
		// //暫停使用以下方式
		// $um = new UserMac();
		// $um->keyId = $_SESSION['keyId'];
		// $uma = new UserMacAccess($db);
		// $numberMac = $uma->IsExistMacAddress($um);
		// if($numberMac > 0)
		// {
		// echo "<span style='color:green'>this is genuine software.</span>";
		// }
		// else
		// {
		// echo "<span style='color:red'>please run the destop application again.</span>";
		// exit();
		// }
	}
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "login.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

$t->set_var ( 'forUser', '' );
$t->set_var ( 'Error', $error );
$t->set_var ( "userName", $userName );

$t->pparse ( "Output", "HdIndex" );
?>
