<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.plugin.inc.php");

// 检查是否登录
if (SurveyorLogin::IsLogin () || UserLogin::IsLogin ()) {
	// TODO
} else {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "main_schedule_rawfile_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "MonthRow", "MonthRows" );
$t->set_var ( "Rows", "" );

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
if ($_GET ["ddlDistId"] != "") {
	$ms->doDistrict = '1,' . $_GET ["ddlDistId"];
}
$readOnlyStyle = "";
if (UserLogin::IsReadOnly ()) {
	$readOnlyStyle = "display:none;";
	$ms->doDistrict = UserLogin::CanDoDistrict ();
} else {
	$ddlDistIdSelect = GetdoDistrictSelect ();
	$t->set_var ( "ddlDistIdSelect", $ddlDistIdSelect );
}

// 设置搜索部分
$t->set_var ( array (
		"readOnlyStyle" => $readOnlyStyle,
		"txtJobNoNew" => $ms->jobNoNew,
		"txtRouteNo" => $ms->routeItems,
		"txtPlannedSurveyDateStart" => $ms->plannedSurveyDateStart,
		"txtPlannedSurveyDateEnd" => $ms->plannedSurveyDateEnd,
		"ddlDistId" => $_GET ["ddlDistId"] 
) );

// 只读用户不显示输入员名称
$inputUserCol = "";
if (UserLogin::IsReadOnly ()) {
	$inputUserCol = "display:none;";
}
$t->set_var ( "inputUserCol", $inputUserCol );

$msa = new MainScheduleAccess ( $db );

// page setting
if (empty ( $_SERVER ["QUERY_STRING"] )) {
	$pageUrl = $_SERVER ["PHP_SELF"];
} else {
	$currUrl = $_SERVER ["PHP_SELF"] . "?" . $_SERVER ["QUERY_STRING"];
	if (strpos ( $currUrl, "&page" )) {
		$arryPageUrl = explode ( "&page", $currUrl );
	} else {
		$arryPageUrl = explode ( "page", $currUrl );
	}
	$pageUrl = $arryPageUrl [0];
}
$page = $_GET ['page'] < 1 ? 1 : $_GET ['page'];
$msa->pageLimit = " LIMIT " . ($conf ['page'] ['pagesize'] * ($page - 1)) . "," . $conf ['page'] ['pagesize'];
$rowNum = $msa->GetListSearchCount ( $ms );
$pageStr = Pagination ( $rowNum, $conf ['page'] ['pagesize'], $_GET ['page'], $pageUrl );
$t->set_var ( array (
		"pageSetting" => $pageStr 
) );

$msa->order = "	ORDER BY plannedSurveyDate ASC";
$rs = $msa->GetListSearchForRawFile ( $ms );
$rsNum = count ( $rs );
$totalEstimatedManHour = 0;
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
	$rawFile = "<a href='javascript:void(0);' style='color:#999;'>download</a>";
	if ($ms->rawFile != "") {
		$ms->rawFile = str_replace ( "../", $conf ["plugin"] ["download_pdf_host"], $ms->rawFile );
		$downUrl = "plugin/raw_pdf_download_prc.php?userId=" . $_SESSION ['userId'] . "&jobNoNew=" . $ms->jobNoNew . "&downloadUrl=" . $ms->rawFile;
		$rawFile = "<a href='" . $downUrl . "'>download</a>";
	}
	$uploadUrl = $conf ["plugin"] ["download_pdf_host"] . "plugin/raw_pdf_upload.php?jobNoNew={jobNoNew}&userName={userName}&userId={userId}";
	$uploadUrl = str_replace ( "{jobNoNew}", $ms->jobNoNew, $uploadUrl );
	$uploadUrl = str_replace ( "{userName}", $_SESSION ["userEngName"], $uploadUrl );
	$uploadUrl = str_replace ( "{userId}", $_SESSION ["userId"], $uploadUrl );
	$uploadUrl = "<a href='javascript:OpenUpload(\"" . $uploadUrl . "\");'>upload</a>";
	
	$totalEstimatedManHour += $ms->estimatedManHour;
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
			"surveyorCode" => $ms->surveyorCode,
			"surveyorName" => $ms->surveyorName,
			"surveyorTelephone" => $ms->surveyorTelephone,
			"rawFile" => $rawFile,
			"uploadUrl" => $uploadUrl 
	) );
	$t->parse ( "Rows", "Row", true );
}
$totalEstimatedManHour = round ( $totalEstimatedManHour, 1 );
$t->set_var ( "totalEstimatedManHour", $totalEstimatedManHour );

$t->pparse ( "Output", "HdIndex" );
?>