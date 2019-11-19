<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ('./includes/config.inc.php');

// 检查是否登录
if (! UserLogin::IsAdministrator ()) {
	header ( "Location:login.php" );
	exit ();
}

$arrChkSupaId = $_POST ["chkSupaId"];
$spl = new SurveyPartList ( $db );
foreach ( $arrChkSupaId as $v ) {
	$spl->supaId = $v;
	$spl->isRelease = "yes";
	$spl->UpdateIsRelease ();
}
header ( "Location:product_list.php" );
?>
