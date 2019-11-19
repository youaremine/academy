<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.plugin.inc.php");

// 检查是否登录
 if(!UserLogin::IsLogin())
 {
	 header("Location:login.php");
	 exit();
 }

//SELECT * FROM Survey_MainSchedule ms
//INNER JOIN Survey_MainScheduleOpen mso ON mso.jobNoNew = ms.jobNoNew AND ms.surveyorCode=mso.applySurvId
//WHERE mso.delFlag = 'no'

$t = new CacheTemplate("./templates");
$t->set_file("HdIndex", "self_select_list.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex", "Row", "Rows");
$t->set_var("Rows", "");

$ms = new MainSchedule();

// 设置查询
// 设置查询
if ($_GET["txtJobNoNew"] != "") {
	$ms->jobNoNew = $_GET["txtJobNoNew"];
}else{
	if (isset ($_GET["txtPlannedSurveyDateStart"])) {
		$ms->plannedSurveyDateStart = $_GET["txtPlannedSurveyDateStart"];
	} else {
		$ms->plannedSurveyDateStart = date('Y-m-01', strtotime('-1 month'));
	}
	if (isset ($_GET["txtPlannedSurveyDateEnd"])) {
		$ms->plannedSurveyDateEnd = $_GET["txtPlannedSurveyDateEnd"];
	} else {
		$ms->plannedSurveyDateEnd = date('Y-m-t', strtotime('-1 month'));
	}
}
if ($_GET["txtSurveyorCode"] != "") {
	$ms->surveyorCode = $_GET["txtSurveyorCode"];
}

$t->set_var(array(
		"txtSurveyorCode" => $ms->surveyorCode,
		"txtPlannedSurveyDateStart" => $ms->plannedSurveyDateStart,
		"txtPlannedSurveyDateEnd" => $ms->plannedSurveyDateEnd,
		"txtJobNoNew" => $ms->jobNoNew
));
if(!empty($ms->plannedSurveyDateEnd)) {
	$ms->plannedSurveyDateEnd .= " 23:59:59";
}

$msa = new MainScheduleAccess($db);
$msa->order = "ORDER BY MS.plannedSurveyDate";
$rs = $msa->GetSelfSelect($ms);
$rsNum = count($rs);
for($i = 0; $i < $rsNum; $i++)
{
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$dr = $rs[$i];
	$rawFile = "<a href='javascript:void(0);'><img class='printHide' border='0' width='24' src='images/pdf-disable.jpg' /></a>";
	if ($ms->rawFile != "")
	{
		$ms->rawFile = str_replace ( "../", $conf ["plugin"] ["download_pdf_host"], $ms->rawFile );
		$downUrl = "plugin/raw_pdf_download_prc.php?userId=" . $_SESSION ['userId'] . "&jobNoNew=" . $dr['jobNoNew'] . "&downloadUrl=" . $dr['rawFile'];
		$rawFile = "<a href='{$downUrl}' target='_blank'><img class='printHide' border='0' width='24' src='images/pdf.jpg' /></a>";
	}
	$t->set_var(array(
			"listStyle" => $listStyle,
			"i" => $i+1,
			"weekNo" => $dr['weekNo'],
			"jobNo" => $dr['jobNo'],
			"jobNoNew" => $dr['jobNoNew'],
			"plannedSurveyDate" => $dr['plannedSurveyDate'],
			"surveyorCode" => $dr['surveyorCode'],
			"surveyorName" => $dr['surveyorName'],
			"openTime" => $dr['inputTime'],
			"applyTime" => $dr['applyTime'],
			"auditTime" => $dr['auditTime'],
			"rawFile" => $rawFile
	));
	$t->parse("Rows", "Row", true);
}
$t->pparse("Output", "HdIndex");
?>