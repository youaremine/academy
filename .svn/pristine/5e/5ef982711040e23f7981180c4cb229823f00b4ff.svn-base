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
$order = $_GET ["order"];
$na = $_GET ["na"];
$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "data_result_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$spl = new SurveyPartList ( $db );
if (! empty ( $order ) && ! empty ( $na )) {
	$spl->order = " order by " . $na . " " . $order;
	setcookie ( "productListOrder", $spl->order, time () + 2592000 );
} else if (! empty ( $_COOKIE ['productListOrder'] )) {
	$spl->order = $_COOKIE ['productListOrder'];
}
// if(UserLogin::IsSurveyor())
// {
// $spl->userId = $_SESSION['userId'];
// }

if ($_GET ["txtRefNo"] != "") {
	$spl->refNo = $_GET ["txtRefNo"];
}
if ($_GET ["txtRouteNo"] != "") {
	$spl->routeNo = $_GET ["txtRouteNo"];
}
if ($_GET ["txtSurveyDateStart"] != "") {
	$spl->surDateStart = $_GET ["txtSurveyDateStart"];
} else {
	$spl->surDateStart = date ( $conf ['date'] ['format'], mktime ( 0, 0, 0, date ( "m" ) - 1, date ( "d" ), date ( "Y" ) ) );
}
if ($_GET ["txtSurveyDateEnd"] != "") {
	$spl->txtSurveyDateEnd = $_GET ["txtSurveyDateEnd"];
} else {
	$spl->txtSurveyDateEnd = date ( $conf ['date'] ['format'] );
}
if ($_GET ["ddlIsRelease"] != "") {
	$spl->isRelease = $_GET ["ddlIsRelease"];
} else {
	$spl->isRelease = 'no';
}
if ($_GET ["ddlDistId"] != "") {
	$spl->district = $_GET ["ddlDistId"];
}
$spl->doDistrict = UserLogin::CanDoDistrict ();
if (UserLogin::IsReadOnly ()) {
	$inputUserCol = "display:none;";
	$checkboxCol = "display:none;";
	$styleStatus = "display:none;";
	$spl->isRelease = 'yes';
} else {
	$ddlDistIdSelect = GetdoDistrictSelect ();
	$t->set_var ( "ddlDistIdSelect", $ddlDistIdSelect );
}
// 设置搜索部分
$t->set_var ( array (
		"txtRefNo" => $spl->refNo,
		"txtRouteNo" => $spl->routeNo,
		"txtSurveyDateStart" => $spl->surDateStart,
		"txtSurveyDateEnd" => $spl->txtSurveyDateEnd,
		"ddlDistId" => $_GET ["ddlDistId"],
		"styleStatus" => $styleStatus,
		"ddlIsRelease" => $spl->isRelease 
) );
// 设置提交按钮
$submitStyle = "";
if (! UserLogin::IsAdministrator ()) {
	$submitStyle = "display:none;";
}
$t->set_var ( array (
		"submitStyle" => $submitStyle 
) );
// 设置排序url
$currUrl = $_SERVER ["PHP_SELF"] . "?" . $_SERVER ["QUERY_STRING"];
// $pageUrl = substr(0,length($pageUrl)-strpos($pageUrl,"na"));
$arryPageUrl = explode ( "na", $currUrl );
$pageUrl = $arryPageUrl [0];
$t->set_var ( array (
		"pageUrl" => $pageUrl 
) );

$spl->delFlag = 'no';
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
$page = $_GET ['page'] < 1 ? 1 : $_GET ['page'];
$spl->pageLimit = " LIMIT " . ($conf ['page'] ['pagesize'] * ($page - 1)) . "," . $conf ['page'] ['pagesize'];
$rowNum = $spl->GetListSearchCount ();
$pageStr = Pagination ( $rowNum, $conf ['page'] ['pagesize'], $_GET ['page'], $pageUrl );
$t->set_var ( array (
		"pageSetting" => $pageStr 
) );

$rs = $spl->GetListSearch ();
$rsNum = count ( $rs );
$sdl = new SurveyDetailList ( $db );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$sp = $rs [$i];
	if (! UserLogin::IsReadOnly ()) 	// ReadOnly不提示
	{
		// 如果离站车上人数大于车的容量,整行变红色.
		$bl = new BusList ( $db );
		$bl->busId = $sp->busId;
		$rsBus = $bl->GetListSearch ();
		$rsBusNum = count ( $rsBus );
		$bus = $rsBus [0];
		$sdl->supaId = $sp->supaId;
		if ($bus->typeId == "1" || $bus->typeId == "3") {
			$sdl->order = " AND onDept > 16";
		} else {
			$sdl->order = " AND onDept > pslNo";
		}
		if ($sdl->GetListSearchCount () > 0) {
			$listStyle = "DgErrorItemStyle";
		}
		// 如果调查日期与Main Schedule不一样,则整行变此紫色;
		$ms = new MainSchedule ();
		$ms->jobNoNew = $sp->refNo;
		$msa = new MainScheduleAccess ( $db );
		$ms = $msa->GetSingle ( $ms );
		if (! empty ( $ms->plannedSurveyDate ) && ($ms->plannedSurveyDate != $sp->surDate)) {
			$listStyle = "DgWarningItemStyle";
		}
	}
	
	$inputUserCol = "";
	$checkboxCol = "";
	$surFromTime = explode ( ':', $sp->surFromTime );
	$sp->surFromTime = $surFromTime [0] . ":" . $surFromTime [1];
	$surToTime = explode ( ':', $sp->surToTime );
	$sp->surToTime = $surToTime [0] . ":" . $surToTime [1];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"checkboxCol" => $checkboxCol,
			"supaId" => $sp->supaId,
			"refNo" => $sp->refNo,
			"routeNo" => $sp->routeNo,
			"surveyDate" => $sp->surDate,
			"surveyPeriod" => $sp->surFromTime . "-" . $sp->surToTime,
			"location" => $sp->location,
			"bounds" => $sp->bounds,
			"userName" => $sp->userName,
			"type" => $sp->type,
			"sofsDate" => $sp->sofsDate,
			"inputUserCol" => $inputUserCol 
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>