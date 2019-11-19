<?php
/*
 * Header: Create: 2007-2-13 Auther: Jamblues.
 */
include_once ('./includes/config.inc.php');

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
if ($_GET ['userId'] != "") {
	$user = new Users ( $db );
	$user->userId = $_GET ['userId'];
	$user->Del ();
}

header ( "Location:user_list.php" );
?>