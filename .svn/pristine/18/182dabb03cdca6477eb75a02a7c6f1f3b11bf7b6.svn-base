<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "main_schedule_different_report_date_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$ms = new MainSchedule ();

if ($_GET ["txtReportDateStart"] != "") {
	$ms->reportDateStart = $_GET ["txtReportDateStart"];
} else {
	// $ms->plannedSurveyDateStart = date($conf['date']['format'],mktime(0, 0, 0, date("m")-1,1,date("Y")));
}
if ($_GET ["txtReportDateEnd"] != "") {
	$ms->reportDateEnd = $_GET ["txtReportDateEnd"];
} else {
	// $ms->plannedSurveyDateEnd = date($conf['date']['format'],mktime(0, 0, 0, date("m"),1,date("Y")));
}
// 设置搜索部分
$t->set_var ( array (
		"txtReportDateStart" => $ms->reportDateStart,
		"txtReportDateEnd" => $ms->reportDateEnd 
) );

$msa = new MainScheduleAccess ( $db );
$msa->order = "ORDER BY MS.report";
$rs = $msa->GetDiffReportDate ( $ms );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$ms = $rs [$i];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"weekNo" => $ms->weekNo,
			"jobNo" => $ms->jobNo,
			"jobNoNew" => $ms->jobNoNew,
			"reportDate" => $ms->report,
			"myReportDate" => $ms->myReport 
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>