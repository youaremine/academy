<?php
/*
 * Header: Create: 2008-03-13 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:mobile_login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "mobile_appendixd_survey_entry.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

//
$appeId = $_GET ['appeId'];
$apdeId = $_GET ['apdeId'];
$surveyDate = date ( $conf ['date'] ['format'] );
$surveyTime = date ( $conf ['time'] ['format'] );
$allNo = 0;
$rejectNo = 0;
$allowNo = 0;
$rs = array ();
if ($appeId <= 0) {
	$ad = new AppendixD ();
	$ad->survId = $_SESSION ['userId'];
	$ad->surveyDate = date ( $conf ['date'] ['format'] );
	$ada = new AppendixDAccess ( $db );
	$rs = $ada->GetListSearch ( $ad );
	if (count ( $rs ) > 0) {
		$ad = $rs [0];
		$appeId = $ad->appeId;
		$surveyDate = $ad->surveyDate;
		$surveyTime = $ad->surveyTime;
	}
} else {
	$ad = new AppendixD ();
	$ad->appeId = $appeId;
	$ada = new AppendixDAccess ( $db );
	$rs = $ada->GetListSearch ( $ad );
	if (count ( $rs ) > 0) {
		$ad = $rs [0];
		$appeId = $ad->appeId;
		$surveyDate = $ad->surveyDate;
		$surveyTime = $ad->surveyTime;
	}
}

if ($appeId > 0) {
	$add = new AppendixDDetail ();
	$add->apdeId = $apdeId;
	$add->isReject = "";
	$adda = new AppendixDDetailAccess ( $db );
	$rs = $adda->GetListSearch ( $add );
	$rsNo = count ( $rs );
	$allNo = $rsNo;
	for($i = 0; $i < $rsNo; $i ++) {
		$add = $rs [$i];
		if ($add->isReject == "yes") {
			$rejectNo ++;
		} else {
			$allowNo ++;
		}
	}
}

$surveyorEngName = $_SESSION ['userEngName'];
$t->set_var ( array (
		"appeId" => $appeId,
		"apdeId" => $apdeId,
		"allNo" => $allNo,
		"rejectNo" => $rejectNo,
		"allowNo" => $allowNo,
		"surveyorEngName" => $surveyorEngName,
		"surveyDate" => $surveyDate,
		"surveyTime" => $surveyTime 
) );

$t->pparse ( "Output", "HdIndex" );
?>