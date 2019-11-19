<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.plugin.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "main_schedule_different_planned_date_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$ms = new MainSchedule ();

if ($_GET ["txtPlannedSurveyDateStart"] != "") {
	$ms->plannedSurveyDateStart = $_GET ["txtPlannedSurveyDateStart"];
} else {
	// $ms->plannedSurveyDateStart = date($conf['date']['format'],mktime(0, 0, 0, date("m")-1,1,date("Y")));
}
if ($_GET ["txtPlannedSurveyDateEnd"] != "") {
	$ms->plannedSurveyDateEnd = $_GET ["txtPlannedSurveyDateEnd"];
} else {
	// $ms->plannedSurveyDateEnd = date($conf['date']['format'],mktime(0, 0, 0, date("m"),1,date("Y")));
}
// 设置搜索部分
$t->set_var ( array (
		"txtPlannedSurveyDateStart" => $ms->plannedSurveyDateStart,
		"txtPlannedSurveyDateEnd" => $ms->plannedSurveyDateEnd 
) );

$msa = new MainScheduleAccess ( $db );
$msa->order = "ORDER BY MS.plannedSurveyDate";
$rs = $msa->GetDiffPlannedDate ( $ms );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$ms = $rs [$i];
	$rawFile = "<a href='javascript:void(0);'><img class='printHide' border='0' width='24' src='images/pdf-disable.jpg' /></a>";
	if ($ms->rawFile != "")
	{
		$ms->rawFile = str_replace ( "../", $conf ["plugin"] ["download_pdf_host"], $ms->rawFile );
		$downUrl = "plugin/raw_pdf_download_prc.php?userId=" . $_SESSION ['userId'] . "&jobNoNew=" . $ms->jobNoNew . "&downloadUrl=" . $ms->rawFile;
		$rawFile = "<a href='{$downUrl}' target='_blank'><img class='printHide' border='0' width='24' src='images/pdf.jpg' /></a>";
	}
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"weekNo" => $ms->weekNo,
			"jobNo" => $ms->jobNo,
			"jobNoNew" => $ms->jobNoNew,
			"plannedSurveyDate" => $ms->plannedSurveyDate,
			"myPlannedSurveyDate" => $ms->myPlannedSurveyDate,
			"rawFile" => $rawFile
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>