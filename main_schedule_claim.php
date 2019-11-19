<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (SurveyorLogin::IsLogin ()) {
	// TODO
} else {
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "main_schedule_claim.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "MonthRow", "MonthRows" );
$t->set_var ( "Rows", "" );

// 调查员基本信息
$sur = new Surveyor ();
$sur->survId = SurveyorLogin::GetLoginId ();
$sa = new SurveyorAccess ( $db );
$rs = $sa->GetListSearch ( $sur );
$rsNum = count ( $rs );
if ($rsNum > 0) {
	$sur = $rs [0];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"survId" => $sur->survId,
			"engName" => $sur->engName,
			"contact" => $sur->contact,
			"survHome" => $sur->survHome,
			"dipaCode" => $sur->dipaCode 
	) );
}

// 详细信息
$ms = new MainSchedule ();
if ($_GET ["txtJobNoNew"] != "") {
	$ms->jobNoNew = $_GET ["txtJobNoNew"];
}
if ($_GET ["txtRouteNo"] != "") {
	$ms->routeItems = $_GET ["txtRouteNo"];
}
if ($_GET ["txtPlannedSurveyDateStart"] != "") {
	$ms->plannedSurveyDateStart = $_GET ["txtPlannedSurveyDateStart"];
} else {
	$ms->plannedSurveyDateStart = date ( $conf ['date'] ['format'], mktime ( 0, 0, 0, date ( "m" ) - 1, date ( "d" ), date ( "Y" ) ) );
}
if ($_GET ["txtPlannedSurveyDateEnd"] != "") {
	$ms->plannedSurveyDateEnd = $_GET ["txtPlannedSurveyDateEnd"];
} else {
	$ms->plannedSurveyDateEnd = date ( $conf ['date'] ['format'] );
}

if ($ms->jobNoNew != "" || $ms->routeItems != "") {
	$ms->plannedSurveyDateStart = "";
	$ms->plannedSurveyDateEnd = "";
}
if ($_GET ["ddlDistrict"] != "") {
	$ms->doDistrict = '1,' . $_GET ["ddlDistrict"];
}
$readOnlyStyle = "";
if (UserLogin::IsReadOnly ()) {
	$readOnlyStyle = "display:none;";
	$ms->doDistrict = UserLogin::CanDoDistrict ();
}
// 设置搜索部分
$t->set_var ( array (
		"readOnlyStyle" => $readOnlyStyle,
		"txtJobNoNew" => $ms->jobNoNew,
		"txtRouteNo" => $ms->routeItems,
		"txtPlannedSurveyDateStart" => $ms->plannedSurveyDateStart,
		"txtPlannedSurveyDateEnd" => $ms->plannedSurveyDateEnd,
		"ddlDistrict" => $_GET ["ddlDistrict"] 
) );

$msa = new MainScheduleAccess ( $db );
$msa->order = "	ORDER BY plannedSurveyDate ASC";
$rs = $msa->GetListSearchNoClaim ( $ms );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$ms = $rs [$i];
	// //Period 1,Period 2,时间如果大于24或者小于0，则整行红色.
	// if($ms->periodHour_1<0 || $ms->periodHour_1>24 || $ms->periodHour_2<0 || $ms->periodHour_1>24)
	// {
	// $listStyle="DgErrorItemStyle";
	// }
	if ($ms->surveyorCode == "") {
		$chkJobNoNew = "<input type=\"checkbox\" name=\"chkJobNoNew[]\" id=\"chkJobNoNew[]\" value=\"" . $ms->jobNoNew . "\" />";
	} else {
		$chkJobNoNew = "";
	}
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"weekNo" => $ms->weekNo,
			"jobNo" => $ms->jobNo,
			"jobNoNew" => $ms->jobNoNew,
			"plannedSurveyDate" => $ms->plannedSurveyDate,
			"tdFileNo" => $ms->tdFileNo,
			"receivedDate" => $ms->receivedDate,
			"dueDate" => $ms->dueDate,
			"fromTD" => $ms->fromTD,
			"surveyTimeHours" => $ms->surveyTimeHours,
			"surveyType" => $ms->surveyType,
			"vehicle" => $ms->vehicle,
			"isHoliday" => $ms->isHoliday,
			"surveyLocation" => $ms->surveyLocation,
			"routeItems" => $ms->routeItems,
			"estimatedManHour" => $ms->estimatedManHour,
			"receiveDate" => $ms->receiveDate,
			"report" => $ms->report,
			"surveyorCode" => '', // $ms->surveyorCode,
			"surveyorName" => '', // $ms->surveyorName,
			"surveyorTelephone" => '', // $ms->surveyorTelephone,
			"chkJobNoNew" => $chkJobNoNew 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>