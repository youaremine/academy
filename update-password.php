<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "update-password.html" );
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

$ul = new UsersList ( $db );
$ul->userId = $_SESSION ['userId'];
$rs = $ul->GetListSearch ();
$user = $rs [0];
$skipStyle = "";
if ($user->updatePasswordTime == '') {
	$message = "Your password is never changed.";
	$skipStyle = "display:none;";
} else {
	$days = ceil ( (time () - strtotime ( $user->updatePasswordTime )) / 86400 );
	if ($days >= 180) {
		$skipStyle = "display:none;";
	}
	$message = "Your password has been <span style='font-weight:bold;'>{$days}</span> days did not change.";
}
$t->set_var ( array (
		'userName' => $user->userName,
		'passWord' => $user->passWord,
		'skipStyle' => $skipStyle,
		'message' => $message 
) );

$t->pparse ( "Output", "HdIndex" );