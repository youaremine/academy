<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.plugin.inc.php");

// 检查是否登录
// if(!UserLogin::IsLogin())
// {
// header("Location:login.php");
// exit();
// }

$t = new CacheTemplate("./templates");
$t->set_file("HdIndex", "different_surveyor_list.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex", "Row", "Rows");
$t->set_block("HdIndex", "MonthRow", "MonthRows");
$t->set_var("Rows", "");

$ms = new MainSchedule();

// 设置查询
$firstDatetime = min($conf['survey_start_date']);
$firstMonth = date("Y-m", strtotime($firstDatetime));
$lastMonth = date("Y-m", strtotime("+15 day")); // 最多顯示15天後的項目
$rowMonth = $firstMonth;
while ( $rowMonth <= $lastMonth )
{
	$t->set_var("rowMonth", $rowMonth);
	$t->parse("MonthRows", "MonthRow", true);
	$rowTime = strtotime($rowMonth . "-01");
	$rowMonth = date("Y-m", mktime(0, 0, 0, date("m", $rowTime) + 1, date("d", $rowTime), date("Y", $rowTime)));
}
if (!empty($_REQUEST['ddlMonth']))
{
	$ddlMonth = $_REQUEST['ddlMonth'];
	$surDateStart = $ddlMonth . "-01";
	$surDateStartTime = strtotime($surDateStart);
	$surveyDateEnd = date("Y-m-d", mktime(0, 0, 0, date("m", $surDateStartTime) + 1, date("d", $surDateStartTime), date("Y", $surDateStartTime)));
}
else
{
	$ddlMonth = date("Y-m", strtotime("-1 month"));
	$surDateStart = $ddlMonth . "-01";
	$surDateStartTime = strtotime($surDateStart);
	$surveyDateEnd = date("Y-m-d", mktime(0, 0, 0, date("m", $surDateStartTime) + 1, date("d", $surDateStartTime), date("Y", $surDateStartTime)));
}
$t->set_var("ddlMonth", $ddlMonth);

$ms = new MainSchedule();
$ms->plannedSurveyDateStart = $surDateStart;
$ms->plannedSurveyDateEnd = $surveyDateEnd;

$msa = new MainScheduleAccess($db);
$msa->order = "ORDER BY MS.plannedSurveyDate";
$rs = $msa->GetDiffSurveyor($ms);
$rsNum = count($rs);
for($i = 0; $i < $rsNum; $i++)
{
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$ms = $rs[$i];
	$rawFile = "<a href='javascript:void(0);'><img class='printHide' border='0' width='24' src='images/pdf-disable.jpg' /></a>";
	if ($ms->rawFile != "")
	{
		$ms->rawFile = str_replace ( "../", $conf ["plugin"] ["download_pdf_host"], $ms->rawFile );
		$downUrl = "plugin/raw_pdf_download_prc.php?userId=" . $_SESSION ['userId'] . "&jobNoNew=" . $ms->jobNoNew . "&downloadUrl=" . $ms->rawFile;
		$rawFile = "<a href='{$downUrl}' target='_blank'><img class='printHide' border='0' width='24' src='images/pdf.jpg' /></a>";
	}
	$t->set_var(array(
			"listStyle" => $listStyle,
			"weekNo" => $ms->weekNo,
			"jobNo" => $ms->jobNo,
			"jobNoNew" => $ms->jobNoNew,
			"plannedSurveyDate" => $ms->plannedSurveyDate,
			"surveyorCode" => $ms->surveyorCode,
			"survId" => $ms->survId,
			"mySurvId" => $ms->mySurvId,
			"rawFile" => $rawFile
	));
	$t->parse("Rows", "Row", true);
}
$t->pparse("Output", "HdIndex");
?>