<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
// if(!UserLogin::IsLogin())
// {
// header("Location:login.php");
// exit();
// }

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "different_surveyor_history.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "MonthRow", "MonthRows" );
$t->set_var ( "Rows", "" );

$ms = new MainSchedule ();

// 设置查询
$mshl = new MainScheduleHistoryLog ();
$mshla = new MainScheduleHistoryLogAccess ( $db );
$rs = $mshla->GetDistinctMonth ( $mshl );
$firstMonth = $rs [0]->backupMonth;
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$mshl = $rs [$i];
	$t->set_var ( "rowMonth", $mshl->backupMonth );
	$t->parse ( "MonthRows", "MonthRow", true );
}
if($rsNum <= 0)
	exit();
if (! empty ( $_REQUEST ['ddlMonth'] )) {
	$ddlMonth = $_REQUEST ['ddlMonth'];
	$surDateStart = $ddlMonth . "-01";
	$surDateStartTime = strtotime ( $surDateStart );
	$surveyDateEnd = date ( "Y-m-d", mktime ( 0, 0, 0, date ( "m", $surDateStartTime ) + 1, date ( "d", $surDateStartTime ), date ( "Y", $surDateStartTime ) ) );
} else {
	$ddlMonth = $mshl->backupMonth;
	$surDateStart = $ddlMonth . "-01";
	$surDateStartTime = strtotime ( $surDateStart );
	$surveyDateEnd = date ( "Y-m-d", mktime ( 0, 0, 0, date ( "m", $surDateStartTime ) + 1, date ( "d", $surDateStartTime ), date ( "Y", $surDateStartTime ) ) );
}
$t->set_var ( "ddlMonth", $ddlMonth );

$ms = new MainSchedule ();
$ms->plannedSurveyDateStart = $surDateStart;
$ms->plannedSurveyDateEnd = $surveyDateEnd;

$msa = new MainScheduleAccess ( $db );
$msa->order = "ORDER BY MS.plannedSurveyDate";
$rs = $msa->GetDiffSurveyorHistory ( $ms );
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
			"plannedSurveyDate" => $ms->plannedSurveyDate,
			"surveyorCode" => $ms->surveyorCode,
			"survId" => $ms->survId,
			"mySurvId" => $ms->mySurvId 
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>