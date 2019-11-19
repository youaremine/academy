<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.plugin.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "main_schedule_unfinished_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "MonthRow", "MonthRows" );
$t->set_var ( "Rows", "" );

// singup company
$companys = getArray ( 'company' );

$ms = new MainSchedule ();
if ($_GET ["txtJobNoNew"] != "") {
	$ms->jobNoNew = $_GET ["txtJobNoNew"];
}
if ($_GET ["txtRouteNo"] != "") {
	$ms->routeItems = $_GET ["txtRouteNo"];
}
if ($_GET ["txtFromTD"] != "") {
	$ms->fromTD = $_GET ["txtFromTD"];
}
if (isset ( $_GET ["txtPlannedSurveyDateStart"] )) {
	$ms->plannedSurveyDateStart = $_GET ["txtPlannedSurveyDateStart"];
} else {
	$ms->plannedSurveyDateStart = date ( $conf ['date'] ['format'], mktime ( 0, 0, 0, date ( "m" ), date ( "d" ), date ( "Y" ) - 1 ) );
}
if (isset ( $_GET ["txtPlannedSurveyDateEnd"] )) {
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
if (! empty ( $_REQUEST ['isAssigned'] )) {
	$ms->isAssigned = $_REQUEST ['isAssigned'] == 'true' ? true : false;
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
		"txtFromTD" => $ms->fromTD,
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
// 處理顯示類別
$currLinkStyle = array (
		'unfinished' => '',
		'unentry' => '',
		'unreceive' => '' 
);
$type = $_GET ['type'];
if ($_GET ['type'] == null) {
	$type = 'unfinished';
	$pageUrl = $pageUrl . "&type=unfinished";
}
$currLinkStyle [$type] = 'CurrentLink';

$ms->report = '';
switch ($type) {
	case 'unfinished' : // 所有未發送報告的
		break;
	case 'unreceive-unentry' : // 未收回未錄入
		$ms->receiveDate = '';
		$ms->entryDate = 'IS NULL';
		break;
	case 'receive-unentry' : // 已收回未錄入
		$ms->receiveDate = "<>''";
		$ms->entryDate = 'IS NULL';
		break;
	case 'receive-entry' : // 已收回已錄入
		$ms->receiveDate = "<>''";
		$ms->entryDate = "<>''";
		break;
	case 'unreceive-entry' : // 未收回已錄入
		$ms->receiveDate = "";
		$ms->entryDate = "<>''";
		break;
}
$typeLink = "<td><a href='?type=unfinished' class='{$currLinkStyle['unfinished']}'>unfinished(所有未發送報告的)</a></td>
<td><a href='?type=unreceive-unentry' class='{$currLinkStyle['unreceive-unentry']}'>unreceive-unentry(未收回未錄入)</a></td>
<td><a href='?type=receive-unentry' class='{$currLinkStyle['receive-unentry']}'>receive-unentry(已收回未錄入)</a></td>
<td><a href='?type=receive-entry' class='{$currLinkStyle['receive-entry']}'>receive-entry(已收回已錄入)</a></td>
<td><a href='?type=unreceive-entry' class='{$currLinkStyle['unreceive-entry']}'>unreceive-entry(未收回已錄入)</a></td>
";

$page = $_GET ['page'] < 1 ? 1 : $_GET ['page'];
$msa->pageLimit = " LIMIT " . ($conf ['page'] ['pagesize'] * ($page - 1)) . "," . $conf ['page'] ['pagesize'];
$rowNum = $msa->GetListSearchUnfinishedAllCount ( $ms );
$pageStr = Pagination ( $rowNum, $conf ['page'] ['pagesize'], $_GET ['page'], $pageUrl );
$t->set_var ( array (
		"pageSetting" => $pageStr,
		"typeLink" => $typeLink,
		"type" => $type 
) );
$msa->order = "	ORDER BY plannedSurveyDate ASC,jobNoNew ASC";
$ms->noSS = true;
$rs = $msa->GetListSearchUnfinishedAll ( $ms );

$rsNum = count ( $rs );
$totalEstimatedManHour = 0;
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$ms = $rs [$i];
	$totalOnBoardCostFare = $ms->onBoardCostFare * $ms->noOfTrips;
	$costHour = CalcOnBoardCostFare2Hour ( $ms->complateJobNo, $totalOnBoardCostFare );
	$totalEstimatedManHour += $ms->estimatedManHour + $costHour;
	$receivedDateState = "<img src='images/no.gif' />";
	$receiveDateState = "<img src='images/no.gif' />";
	$entryDateState = "<img src='images/no.gif' />";
	if (! empty ( $ms->receivedDate )) {
		$receivedDateState = "<img src='images/ok.gif' />";
	}
	if (! empty ( $ms->receiveDate )) {
		$receiveDateState = "<img src='images/ok.gif' />";
		$ms->receiveDate = date ( "Y-m-d H:i", strtotime ( $ms->receiveDate ) );
	}
	if (! empty ( $ms->entryDate )) {
		$entryDateState = "<img src='images/ok.gif' />";
		$ms->entryDate = date ( "Y-m-d H:i", strtotime ( $ms->entryDate ) );
	}
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"weekNo" => $ms->weekNo,
			"jobNo" => $ms->jobNo,
			"jobNoNew" => $ms->jobNoNew,
			"companyName" => $companys [$ms->company],
			"plannedSurveyDate" => $ms->plannedSurveyDate,
			"receivedDate" => $receivedDateState . $ms->receivedDate,
			"receiveDate" => $receiveDateState . $ms->receiveDate,
			"entryDate" => $entryDateState . $ms->entryDate,
			"dueDate" => $ms->dueDate,
			"surveyTimeHours" => $ms->surveyTimeHours,
			"surveyType" => $ms->surveyType,
			"vehicle" => $ms->vehicle,
			"surveyLocation" => $ms->surveyLocation,
			"routeItems" => $ms->routeItems,
			"estimatedManHour" => round ( $ms->estimatedManHour, 1 ),
			"surveyorCode" => $ms->surveyorCode,
			"surveyorName" => $ms->surveyorName,
			"surveyorTelephone" => $ms->surveyorTelephone,
			"rawFile" => $rawFile 
	) );
	$t->parse ( "Rows", "Row", true );
}
$totalEstimatedManHour = round ( $totalEstimatedManHour, 1 );
$t->set_var ( "totalEstimatedManHour", $totalEstimatedManHour );

$t->pparse ( "Output", "HdIndex" );
?>