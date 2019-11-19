<?php
/*
 * Header: 从main schedule导出周时间表 Create: 2007-3-21 @Ozzo Technology(HK) LTD Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
$oneDayTime = 86400; // 60*60*24
$oneWeekTime = 604800; // $oneDayTime*7
$survey_start_date = $conf ['survey_start_date'] ['all'];
if ($_GET ['complateJobNo'] != "") {
	$complateJobNo = $_GET ['complateJobNo'];
	$survey_start_date = $conf ['survey_start_date'] [$complateJobNo];
} else {
	print "complateJobNo is NULL";
	exit ();
}
$startTime = strtotime ( $survey_start_date );
$tdNo = $conf ['tdNo'] [$complateJobNo];
// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "main_schedule_week_default.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

// 上传SQL文件位置修改时间 mainschedule update time.
$sqlFile = $conf ["path"] ["main_schedule"] . $conf ["file"] ["main_schedule_import_time"];
$currImportTime = "";
if (file_exists ( $sqlFile )) {
	$currImportTime = date ( $conf ['dateTime'] ['format'], filemtime ( $sqlFile ) );
}
$districtName = $conf ['districtName'] [$complateJobNo];

$t->set_var ( "currImportTime", $currImportTime );
$t->set_var ( "complateJobNo", $complateJobNo );
$t->set_var ( "districtName", $districtName );

$t->pparse ( "Output", "HdIndex" );

?>