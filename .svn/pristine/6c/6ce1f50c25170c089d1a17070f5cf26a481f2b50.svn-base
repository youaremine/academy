<?php
/*
 * Header: Create: 2007-3-21 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$ad = new AppendixD ();
$ada = new AppendixDAccess ( $db );
$rs = $ada->GetListSearch ( $ad );
$json = new Services_JSON ();
$output = "";
$output = $json->encode ( $rs );
print $output;

?>