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
$ddlDistIdHStyle = "display:none;";
$ddlDistIdNStyle = "display:none;";
$ddlDistIdTStyle = "display:none;";
$canDoDistrict = UserLogin::CanDoDistrict ();
if ($canDoDistrict == "") {
	exit ();
}
$readonlyStyle = "";
if (UserLogin::IsReadOnly ()) {
	$readonlyStyle = "display:none;";
}

$ddlDistIdSelect = GetdoDistrictSelect ();

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "progress_view.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

$t->set_var ( array (
		"txtWeekStart" => 0,
		"txtWeekEnd" => 0,
		"readonlyStyle" => $readonlyStyle 
) );
$t->set_var ( "ddlDistIdSelect", $ddlDistIdSelect );
$t->pparse ( "Output", "HdIndex" );

?>