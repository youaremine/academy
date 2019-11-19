<?php
/*
 * Header:
 * Create: 2017-04-20
 * Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");

$error = '';
$userName = '';
$jsonData = array();
if ($_POST['engName'] != "") {
	$saObj = new SurveyorApply();
	$saObj->engName = $_POST['engName'];
	$saObj->contact = $_POST['contact'];
	$saObj->survHome = $_POST['survHome'];
	$saObj->remarks = $_POST['remarks'];
	if (!empty($saObj->engName) && !empty($saObj->contact)) {
		$saaObj = new SurveyorApplyAccess($db);
		$saaObj->Add($saObj);
		$jsonData = array (
				'success' => true,
				'jump' => 'pending.php',
				'message' => '申請成功!'
		);
		die(json_encode($jsonData));
	} else {
		$jsonData = array (
				'success' => false,
				'jump' => '',
				'message' => '請填寫完整資料!'
		);
		die(json_encode($jsonData));
	}
}

$t = new CacheTemplate("../templates/account");
$t->set_file ( "HdIndex", "register.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

$t->set_var ( 'forUser', 'For Surveyor Login Only.' );
$t->set_var ( 'Error', $error );
$t->set_var ( "userName", $userName );

$t->pparse ( "Output", "HdIndex" );
?>
