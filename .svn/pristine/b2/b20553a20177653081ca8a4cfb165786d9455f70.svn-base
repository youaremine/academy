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
$t->set_file ( "HdIndex", "data_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$spl = new SurveyPartList ( $db );
$order = $_GET ["order"];
$na = $_GET ["na"];
$spl->order = "ORDER BY M.plannedSurveyDate,M.jobNoNew";

if ($_GET ["txtRefNo"] != "") {
	$spl->refNo = trim($_GET["txtRefNo"]);
}
if ($_GET ["txtRouteNo"] != "") {
	$spl->routeNo = trim($_GET["txtRouteNo"]);
}

if ($_GET["txtInputTimeStart"] != "") {
	$spl->inputTimeStart = $_GET["txtInputTimeStart"];
}
if ($_GET["txtInputTimeEnd"] != "") {
	$spl->inputTimeEnd = $_GET["txtInputTimeEnd"];
}

if ($_GET ["txtSurveyDateStart"] != "") {
	$spl->surDateStart = $_GET ["txtSurveyDateStart"];
} elseif(empty($_GET["txtInputTimeStart"]) && empty($_GET["txtInputTimeEnd"])) {
	$spl->surDateStart = date ( $conf ['date'] ['format'], mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) - 15, date ( "Y" ) ) );
}
if ($_GET ["txtSurveyDateEnd"] != "") {
	$spl->surDateEnd = $_GET ["txtSurveyDateEnd"];
} elseif(empty($_GET["txtInputTimeStart"]) && empty($_GET["txtInputTimeEnd"])) {
	$spl->surDateEnd = date ( $conf ['date'] ['format'] );
}
if ($_GET ["ddlIsRelease"] != "") {
	$spl->isRelease = $_GET ["ddlIsRelease"];
} else {
	$spl->isRelease = 'no';
}
if (isset($_GET["ddlDelFlag"])) {
	$spl->delFlag = $_GET["ddlDelFlag"];
} else {
	$spl->delFlag = 'no';
}
if ($_GET ["ddlDistId"] != "") {
	$spl->district = $_GET ["ddlDistId"];
}
$spl->doDistrict = UserLogin::CanDoDistrict ();
if (UserLogin::IsReadOnly ()) {
	$styleStatus = "display:none;";
	$spl->isRelease = 'yes';
} else {
	$ddlDistIdSelect = GetdoDistrictSelect ();
	$t->set_var ( "ddlDistIdSelect", $ddlDistIdSelect );
}
//输入员
if ($_GET['txtInputter'] != "") {
	$spl->userName = $_GET["txtInputter"];
}
// 设置搜索部分
$t->set_var ( array (
		"txtRefNo" => $spl->refNo,
		"txtRouteNo" => $spl->routeNo,
		"txtSurveyDateStart" => $spl->surDateStart,
		"txtSurveyDateEnd" => $spl->surDateEnd,
		"txtInputTimeStart" => $spl->inputTimeStart,
		"txtInputTimeEnd" => $spl->inputTimeEnd,
		"txtInputter" => $spl->userName,
		"ddlDistId" => $_GET ["ddlDistId"],
		"styleStatus" => $styleStatus,
		"ddlIsRelease" => $spl->isRelease,
		"ddlDelFlag" => $spl->delFlag
) );
// 设置排序url
$currUrl = $_SERVER ["PHP_SELF"] . "?" . $_SERVER ["QUERY_STRING"];
// $pageUrl = substr(0,length($pageUrl)-strpos($pageUrl,"na"));
$arryPageUrl = explode ( "na", $currUrl );
$pageUrl = $arryPageUrl[0];
$t->set_var ( array (
		"pageUrl" => $pageUrl,
		"queryString" => $_SERVER['QUERY_STRING']
) );

// 有refNo的时候时间段无效
if ($spl->refNo != "") {
	$spl->surDateStart = "";
	$spl->surDateEnd = "";
}

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

if(!empty($spl->inputTimeEnd)){
	$spl->inputTimeEnd .= " 23:59:59";
}

$page = $_GET ['page'] < 1 ? 1 : $_GET ['page'];
$spl->pageLimit = " LIMIT " . ($conf ['page'] ['pagesize'] * ($page - 1)) . "," . $conf ['page'] ['pagesize'];
$rowNum = $spl->GetListSearchCount2();
$pageStr = Pagination ( $rowNum, $conf ['page'] ['pagesize'], $_GET ['page'], $pageUrl );
$t->set_var ( array (
		"pageSetting" => $pageStr 
) );

$rs = $spl->GetListSearch2();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$dr = $rs[$i];
	if($dr['delFlag']=='yes') {
		$listStyle = "DgDisableItemStyle";
	}
	$inputUserCol = "";
	$preview = "<a href=\"data_view.php?supaId=" . $dr['supaId'] . "\" target=\"_blank\"><img src=\"images/Preview.jpg\" width=\"15\" height=\"17\" border=\"0\" alt=\"Preview\">";
	// $modify = "<a href=\"survey_data_entry.php?supaId=".$sp->supaId."\"><img src=\"images/Modify.gif\" alt=\"Modify\" width=\"15\" height=\"15\" border=\"0\"></a>";
	$modify = "<a href=\"data_update.php?supaId=" . $dr['supaId'] . "\"><img src=\"images/Modify.gif\" alt=\"Modify\" width=\"15\" height=\"15\" border=\"0\"></a>";
	// $excelDown = "<a href=\"survey_input_to_excel.php?supaId=".$sp->supaId."\"><img src=\"images/excel.jpg\" alt=\"excel\" width=\"15\" height=\"17\" border=\"0\" title=\"Excel Download\" /></a>";
	$excelDown = "<img style='cursor:pointer;' onclick='ShowDownloadDialog(" . $dr['supaId'] . ");' src=\"images/excel.jpg\" alt=\"excel\" width=\"15\" height=\"17\" border=\"0\" title=\"Excel Download\" />";
	$delete = "<a href=\"data_del_press.php?supaId=" . $dr['supaId'] . "\" onclick=\"return confirm('are you sure?')\"><img src=\"images/Delete.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"Delete\" title=\"Delete\" /></a>";
	if (UserLogin::IsReadOnly ()) {
		// $preview = "";
		$modify = "";
		// $excelDown = "";
		$delete = "";
		$inputUserCol = "display:none;";
	}
	$surFromTime = explode ( ':', $dr['surFromTime'] );
	$dr['surFromTime'] = $surFromTime [0] . ":" . $surFromTime [1];
	$surToTime = explode ( ':', $dr['surToTime'] );
	$dr['surToTime'] = $surToTime [0] . ":" . $surToTime [1];

	$remarks = "";
	if(!empty($dr['remarks'])){
		$remarks = "<img src='./images/help.png' alt='{$dr['remarks']}' title='{$dr['remarks']}'/>";
	}
	$channelIcon = '<span class="i-client i-client-4"></span>';
	if($dr['channel'] == 2){
		$channelIcon = '<span class="i-client i-client-2"></span>';
	}elseif($dr['channel'] == 3){
		$channelIcon = '<span class="i-client i-client-3"></span>';
	}
	$surveyorInfo = "";
	$isAssign = '否';
	$isDataEntry = '未到';
	if(!empty($dr['surveyorCode'])){
		$surveyorInfo = "{$dr['surveyorCode']}：{$dr['surveyorName']}";
		$isAssign = '是';
	}
	if(!empty($dr['survId'])){
		$isDataEntry = '已到';
	}
	if(!empty($dr['survId'])){
		if(!empty($dr['surveyorCode']) && $dr['surveyorCode']!=$dr['survId']){
			$surveyorInfo = "<span style='color:red;'></span>";
		}else{
			$surveyorInfo = "{$dr['survId']}：{$dr['engName']}";
		}
	}
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"i" => $i,
			"supaId" => $dr['supaId'],
			"jobNoNew" => $dr['jobNoNew'],
			"surveyType" => $dr['surveyType'],
			"remarks" => $remarks,
			"channelIcon" => $channelIcon,
			"routeNo" => $dr['routeNo'],
			"plannedSurveyDate" => $dr['plannedSurveyDate'],
			"surveyTimeHours" => $dr['surveyTimeHours'],
			"surveyPeriod" => $dr['surFromTime'] . "-" . $dr['surToTime'],
			"surveyLocation" => $dr['surveyLocation'],
			"surveyorInfo" => $surveyorInfo,
			"isAssign" => $isAssign,
			"isDataEntry" => $isDataEntry,
			"userName" => $dr['userName'],
			"inputTime" => $dr['inputTime'],
			"sofsDate" => $dr['sofsDate'],
			"type" => $dr['type'],
			"inputUserCol" => $inputUserCol,
			"privew" => $preview,
			"modify" => $modify,
			"excelDown" => $excelDown,
			"delete" => $delete 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );