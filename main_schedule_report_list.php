<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.schedule.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "main_schedule_report_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "MonthRow", "MonthRows" );
$t->set_var ( "Rows", "" );
$t->set_block ( "HdIndex", "FirstSenderRow", "FirstSenderRows" );

// 查询系统所有用户
$user = new Users ( $db );
$ul = new UsersList ( $db );
$ul->order = 'ORDER BY US.userId';
$rs = $ul->GetListSearch ();
$rsNum = count ( $rs );
$users = array ();
for($i = 0; $i < $rsNum; $i ++) {
	$user = $rs [$i];
	$users [$user->userId] = $user->engName;
}

// 详细信息
$ms = new MainSchedule ();
if ($_GET ['ddlFirstSender']) {
	$ms->firstSender = $_GET ['ddlFirstSender'];
}
if ($_REQUEST ["txtJobNoNew"] != "") {
	$ms->jobNoNew = $_REQUEST ["txtJobNoNew"];
}
if ($_GET ["txtRouteNo"] != "") {
	$ms->routeItems = $_GET ["txtRouteNo"];
}
if ($_GET ["txtReportDateStart"] != "") {
	$ms->reportDateStart = $_GET ["txtReportDateStart"];
}
if ($_GET ["txtReportDateEnd"] != "") {
	$ms->reportDateEnd = $_GET ["txtReportDateEnd"];
}

if (empty ( $_GET ["txtReportDateStart"] ) && empty ( $_GET ["txtReportDateEnd"] )) {
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
}

if ($ms->jobNoNew != "" || $ms->routeItems != "") {
	$ms->plannedSurveyDateStart = "";
	$ms->plannedSurveyDateEnd = "";
	$ms->reportDateStart = "";
	$ms->reportDateEnd = "";
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

$sort = $_GET ['sort'];
if (! empty ( $sort )) {
	$ms->order = $sort;
	setcookie ( "reportListSort", $ms->order, time () + 2592000 );
} else if (! empty ( $_COOKIE ['reportListSort'] )) {
	$ms->order = $_COOKIE ['reportListSort'];
}

// 發送者
$msrda = new MainScheduleReportDateAccess ( $db );
$senders = $msrda->GetAllSender ();
foreach ( $senders as $v ) {
	$t->set_var ( array (
			"firstSenderId" => $v,
			"firstSenderName" => $users [$v] 
	) );
	$t->parse ( "FirstSenderRows", "FirstSenderRow", true );
}
// 设置搜索部分
$t->set_var ( array (
		"readOnlyStyle" => $readOnlyStyle,
		"txtJobNoNew" => $ms->jobNoNew,
		"txtRouteNo" => $ms->routeItems,
		"txtReportDateStart" => $ms->reportDateStart,
		"txtReportDateEnd" => $ms->reportDateEnd,
		"txtPlannedSurveyDateStart" => $ms->plannedSurveyDateStart,
		"txtPlannedSurveyDateEnd" => $ms->plannedSurveyDateEnd,
		"ddlDistId" => $_GET ["ddlDistId"],
		"ddlFirstSender" => $_GET ["ddlFirstSender"] 
) );

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
$pagesize = empty($_GET['ddlFirstSender'])?$conf ['page'] ['pagesize']:200;
$msa->pageLimit = " LIMIT " . ($pagesize * ($page - 1)) . "," . $pagesize;
$rowNum = $msa->GetListSearchForReportCount ( $ms );
// print $rowNum.$conf['page']['pagesize'].$_GET['page'].$pageUrl;
// exit();
$pageStr = Pagination ( $rowNum, $pagesize, $_GET ['page'], $pageUrl );

$t->set_var ( array (
		"pageSetting" => $pageStr,
		"pageUrl" => $_SERVER ["PHP_SELF"] 
) );

// 当前页汇总
$totalNosOfForm = 0;
$totalOnBoardCostFareHours = 0;
$totalTotalHours = 0;
$totalManHours = 0;

$rs = $msa->GetListSearchForReport ( $ms );
$rsNum = count ( $rs );
$spl = new SurveyPartList ( $db );
$spl->delFlag = 'no';
// $spl->pageLimit = " LIMIT 1";
$sdl = new SurveyDetailList ( $db );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$ms = $rs [$i];
	
	$rawDataAction = "<img src=\"images/addfile.gif\" onclick=\"OpenUpload('" . $ms->jobNo . "','rawData');\" style=\"cursor:pointer;\" />";
	$requestFormAction = "<img src=\"images/addfile.gif\" onclick=\"OpenUpload('" . $ms->jobNo . "','requestForm');\" style=\"cursor:pointer;\" />";
	$reportAction = "<img src=\"images/addfile.gif\" onclick=\"OpenUpload('" . $ms->jobNo . "','report');\" style=\"cursor:pointer;\" />";
	$summaryTableAction = "<img src=\"images/addfile.gif\" onclick=\"OpenUpload('" . $ms->jobNo . "','summaryTable');\" style=\"cursor:pointer;\" />";
	$rawDataState = "<img src=\"images/no.gif\" />";
	$requestFormState = "<img src=\"images/no.gif\" />";
	$reportState = "<img src=\"images/no.gif\" />";
	$summaryTableState = "<img src=\"images/no.gif\" />";
	$sendMailState = "<a href=\"main_schedule_report_send_attachment.php?refNo=" . $ms->jobNo . "\"><img src=\"images/send.gif\" boder=\"0\" /></a>";
	$divisionWorkUser = GetDivisionWorkUser ( $ms->jobNo );
	$msrfa = new MainScheduleReportFileAccess ( $db );
	$msrf = new MainScheduleReportFile ();
	$msrf->jobNo = $ms->jobNo;
	
	$msrf->fileType = 'requestForm';
	$rsFile = $msrfa->GetListSearch ( $msrf );
	$rsFileNo = count ( $rsFile );
	if ($rsFileNo > 0) {
		$msrfe = $rsFile [0];
		$requestFormState = "<a href='" . $msrfe->fileName . "' target='blank'><img src=\"images/ok.gif\" title=\"" . $msrfe->fileName . "\" /></a>";
	}
	$msrf->fileType = 'rawData';
	$rsFile = $msrfa->GetListSearch ( $msrf );
	$rsFileNo = count ( $rsFile );
	if ($rsFileNo > 0) {
		$msrfe = $rsFile [0];
		$rawDataState = "<a href='" . $msrfe->fileName . "' target='blank'><img src=\"images/ok.gif\" title=\"" . $msrfe->fileName . "\" /></a>";
	}
	$msrf->fileType = 'report';
	$rsFile = $msrfa->GetListSearch ( $msrf );
	$rsFileNo = count ( $rsFile );
	if ($rsFileNo > 0) {
		$msrfe = $rsFile [0];
		$reportState = "<a href='" . $msrfe->fileName . "' target='blank'><img src=\"images/ok.gif\" title=\"" . $msrfe->fileName . "\" /></a>";
		if (! UserLogin::IsReadOnly ()) 		// ReadOnly不提示
		{
			// 如果离站车上人数大于车的容量,整行变红色.
			$spl->refNo = $ms->jobNo;
			$rsSp = $spl->GetListSearch ();
			$busIdArrs = array ();
			foreach ( $rsSp as $k => $v ) {
				$busIdArrs [] = $v->busId;
				$supaIdArrs [$v->busId] = $v->supaId;
			}
			$busIds = implode ( ",", $busIdArrs );
			if (! empty ( $busIds )) {
				$sp = $rsSp [0];
				$bl = new BusList ( $db );
				$bl->busIds = $busIds;
				$rsBus = $bl->GetListGroup ();
				$rsBusNum = count ( $rsBus );
				$isError = false;
				foreach ( $rsBus as $k => $v ) {
					$bus = $v;
					if (empty ( $bus->busId )) {
						continue;
					}
					$tmpBusIds = explode ( ",", $bus->busId );
					$tmpSupaIds = array ();
					foreach ( $tmpBusIds as $k1 => $v1 ) {
						$tmpSupaIds [] = $supaIdArrs [$v1];
					}
					$supaIds = implode ( ",", $tmpSupaIds );
					$sdl->supaIds = $supaIds;
					if ($bus->typeId == "1" || $bus->typeId == "3") {
						$sdl->order = " AND onDept > 16";
					} else {
						$sdl->order = " AND onDept > pslNo";
					}
					if ($sdl->GetListSearchCount () > 0) {
						$isError = true;
						break;
					}
				}
				if ($isError) {
					$listStyle = "DgErrorItemStyle";
				}
			} // end !empty($busIds)
		}
	}
	$msrf->fileType = 'summaryTable';
	$rsFile = $msrfa->GetListSearch ( $msrf );
	$rsFileNo = count ( $rsFile );
	if ($rsFileNo > 0) {
		$msrfe = $rsFile [0];
		$summaryTableState = "<a href='" . $msrfe->fileName . "' target='blank'><img src=\"images/ok.gif\" title=\"" . $msrfe->fileName . "\" /></a>";
	}
	if (UserLogin::IsReadOnly ()) {
		$requestFormAction = "";
		$reportAction = "";
		$summaryTableAction = "";
		$sendMailState = "";
		$divisionWorkUser = "";
	}
	$plannedSurveyDates = $ms->plannedSurveyDate;
	$plannedSurveyDateArray = explode ( ",", $plannedSurveyDates );
	$plannedSurveyDateArray = UniqueArray ( $plannedSurveyDateArray );
	$plannedSurveyDateArray = DelEmptyArray ( $plannedSurveyDateArray );
	$plannedSurveyDates = implode ( ",", $plannedSurveyDateArray );
	
	$totalOnBoardCostFare = $ms->onBoardCostFare;
	$costHour = CalcOnBoardCostFare2Hour ( $ms->complateJobNo, $totalOnBoardCostFare );
	$totalEstimatedManHour = $ms->estimatedManHour + $costHour;
	$manHour = $ms->estimatedManHour;

	// 特殊控制
	if ($ms->complateJobNo != $conf ['complateJobNo'] ['NFB']) {
		$rawDataAction = "";
		$rawDataState = "";
	}
	
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"jobNo" => $ms->jobNo,
			"dueDate" => $ms->dueDate,
			"nosOfForm" => $ms->noOfPages,
			"onBoardCostFareHours" => $costHour,
			"totalHours" => $totalEstimatedManHour,
			"manHours" => $manHour,
			"report" => $ms->report,
			"plannedSurveyDates" => $plannedSurveyDates,
			"firstSender" => $users [$ms->firstSender],
			"rawDataAction" => $rawDataAction,
			"rawDataState" => $rawDataState,
			"requestFormAction" => $requestFormAction,
			"requestFormState" => $requestFormState,
			"reportAction" => $reportAction,
			"reportState" => $reportState,
			"summaryTableAction" => $summaryTableAction,
			"summaryTableState" => $summaryTableState,
			"sendMailState" => $sendMailState,
			"divisionWorkUser" => $divisionWorkUser 
	) );
	$t->parse ( "Rows", "Row", true );
	// 当前页汇总
	$totalNosOfForm += $ms->noOfPages;
	$totalOnBoardCostFareHours += $costHour;
	$totalTotalHours += $totalEstimatedManHour;
	$totalManHours += $manHour;
}

$t->set_var ( array (
		"totalNosOfForm" => $totalNosOfForm,
		"totalOnBoardCostFareHours" => $totalOnBoardCostFareHours,
		"totalTotalHours" => $totalTotalHours,
		"totalManHours" => $totalManHours
) );

$t->pparse ( "Output", "HdIndex" );
?>