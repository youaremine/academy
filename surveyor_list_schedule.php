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
$t->set_file ( "HdIndex", "surveyor_list_schedule.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );
$t->set_block ( "HdIndex", "DistPartRow", "DistPartRows" );
$t->set_block ( "HdIndex", "StatusRow", "StatusRows" );

// 区域
$d = new DistrictPart ();
$da = new DistrictPartAccess ( $db );
$rs = $da->GetListSearch ( $d );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$d = $rs [$i];
	$t->set_var ( array (
			"distPartCode" => $d->dipaCode,
			"distPartEngName" => $d->engName 
	) );
	$t->parse ( "DistPartRows", "DistPartRow", true );
}

// 状态
$surveyorStatus = getArray ( 'surveyor-status' );
foreach ( $surveyorStatus as $k => $v ) {
	$t->set_var ( array (
			"statusCode" => $k,
			"statusName" => $v 
	) );
	$t->parse ( "StatusRows", "StatusRow", true );
}

$sur = new Surveyor ();
$sa = new SurveyorAccess ( $db );

// 设置排序
$order = $_GET ["order"];
$na = $_GET ["na"];
if (! empty ( $order ) && ! empty ( $na )) {
	$sur->order = " ORDER BY {$na} {$order}";
	setcookie ( "surveyorListOrder", $sur->order, time () + 2592000 );
} else if (! empty ( $_COOKIE ['surveyorListOrder'] )) {
	$sur->order = $_COOKIE ['surveyorListOrder'];
} else // 缺省排序
{
	$sur->order = " ORDER BY (lastTotalWorkHour-totalWorkHour) DESC";
}
// 设置排序url
$currUrl = $_SERVER ["PHP_SELF"] . "?" . $_SERVER ["QUERY_STRING"];
// $pageUrl = substr(0,length($pageUrl)-strpos($pageUrl,"na"));
$arryPageUrl = explode ( "na", $currUrl );
$pageUrl = $arryPageUrl [0];
if (empty ( $arryPageUrl [1] )) {
	$pageUrl .= "&";
}
$t->set_var ( array (
		"pageUrl" => $pageUrl 
) );

if ($_GET ["ddlStatus"] != "") {
	$sur->status = $_GET ["ddlStatus"];
} else {
	$sur->status = "active";
}
if ($_GET ["txtSurvId"] != "") {
	$sur->survId = $_GET ["txtSurvId"];
	$sur->status = "";
}
if ($_GET ["txtEngName"] != "") {
	$sur->engName = $_GET ["txtEngName"];
	$sur->status = "";
}
if ($_GET ["txtContact"] != "") {
	$sur->contact = $_GET ["txtContact"];
	$sur->status = "";
}
if (! empty ( $_GET ['ddlDipaCode'] )) {
	$sur->dipaCode = $_GET ["ddlDipaCode"];
	$conf ['page'] ['pagesize'] = 200;
}
// if(UserLogin::HasPermission("surveyor_contractor_all"))
// {
// $sur->company = $_GET["ddlCompany"];
// }
// else
// {
// $sur->company = UserLogin::CanDoCompany();
// }

// 设置搜索部分
$t->set_var ( array (
		"txtSurvId" => $sur->survId,
		"txtEngName" => $sur->engName,
		"txtContact" => $sur->contact,
		"ddlDipaCode" => $sur->dipaCode,
		"ddlStatus" => $sur->status 
) );

// 查找特定條件時,另外的條件忽略
if (! empty ( $sur->survId ) || ! empty ( $sur->engName ) || ! empty ( $sur->contact )) {
	$sur->company = "";
	$sur->status = "";
}
$sur->survType = "surveyor";
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
$sur->pageLimit = " LIMIT " . ($conf ['page'] ['pagesize'] * ($page - 1)) . "," . $conf ['page'] ['pagesize'];
$rowNum = $sa->GetListSearchCount ( $sur );
$pageStr = Pagination ( $rowNum, $conf ['page'] ['pagesize'], $_GET ['page'], $pageUrl );
$t->set_var ( array (
		"pageSetting" => $pageStr 
) );

// 未来14天日期
$nextDays = array ();
$currDayTime = time ();
$oneDayTime = 86400;
for($i = 0; $i < 14; $i ++) {
	$nextDays [$i] = date ( $conf ['date'] ['format'], ($currDayTime + $oneDayTime * $i) );
	$t->set_var ( "nextDay" . $i, date ( 'd M', ($currDayTime + $oneDayTime * $i) ) );
}

$workMonth = date ( "Y-m" );
$rs = $sa->GetFullListSearch ( $sur, $workMonth );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$sur = $rs [$i];
	if (UserLogin::IsAdministrator ()) {
		$assign = "<a href=\"assign/surveyor_assign.php?survId=" . $sur->survId . "\" target=\"_blank\"><img src=\"images/assign.png\" width=\"17\" height=\"17\" border=\"0\" alt=\"Assign\" title=\"Assign\"></a>";
		$time = "<a href=\"surveyor_calendar.php?surveyorId=" . $sur->survId . "\" target=\"_blank\"><img src=\"images/time.png\" width=\"17\" height=\"17\" border=\"0\" alt=\"Schedule\" title=\"Schedule\"></a>";
		$preview = "<a href=\"surveyor_profile.php?surveyorId=" . $sur->survId . "\" target=\"_blank\"><img src=\"images/Preview.jpg\" width=\"15\" height=\"17\" border=\"0\" alt=\"Profile\" title=\"Profile\"></a>";
		$edit = "<a href=\"surveyor_entry.php?survId=" . $sur->survId . "\" target=\"_blank\"><img src=\"images/Modify.gif\" width=\"11\" border=\"0\" alt=\"Edit\" title=\"Edit\"></a>";
		$resetPassword = "<a href=\"surveyor_reset_password.php?surveyorId=" . $sur->survId . "\" target=\"_blank\"><img src=\"images/reset.jpg\" width=\"16\" height=\"16\" border=\"0\" alt=\"View password\" title=\"View Password\"></a>";
	} else {
		$preview = "";
		$resetPassword = "";
	}
	if (! empty ( $sur->IsSupervisor )) {
		$sur->IsSupervisor = "(" . $sur->IsSupervisor . ")";
	}
	$whatsAPPICO = "";
	$emailICO = "";
	if (! empty ( $sur->whatsAPP )) {
		$whatsAPPICO = "<img border='0' src='./images/whatsapp.png' width='24' />";
	}
	if (! empty ( $sur->email )) {
		$emailICO = "<a href='mailto:{$sur->email}'><img border='0' src='./images/email.png' width='24' /></a>";
	}
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"survId" => $sur->survId,
			"chiName" => $sur->chiName,
			"engName" => $sur->engName,
			"contact" => $sur->contact,
			"survHome" => $sur->survHome,
			"dipaCode" => $sur->dipaCode,
			"IsSupervisor" => $sur->IsSupervisor,
			"whatsAPPICO" => $whatsAPPICO,
			"emailICO" => $emailICO,
			"remark" => $sur->remark,
			"time" => $time,
			"assign" => $assign,
			"preview" => $preview,
			"edit" => $edit,
			"resetPassword" => $resetPassword 
	) );
	// 獲取14天內該調查員已委派的Job
	$ms = new MainSchedule ();
	$ms->surveyorCode = $sur->survId;
	$ms->plannedSurveyDateStart = $nextDays [0];
	$ms->plannedSurveyDateEnd = $nextDays [13];
	$msa = new MainScheduleAccess ( $db );
	$msa->order = "	ORDER BY plannedSurveyDate ASC";
	$rsAssigned = $msa->GetListSearch ( $ms );
	$assignedTime = array ();
	foreach ( $rsAssigned as $v ) {
		if (! empty ( $v->startTime_1 ) && ! empty ( $v->endTime_1 )) {
			$assignedTime [$v->plannedSurveyDate] .= "<div class='s-d'><span class='s-t'>{$v->startTime_1}-{$v->endTime_1}({$v->jobNoNew})</span></div>";
		}
		if (! empty ( $v->startTime_2 ) && ! empty ( $v->endTime_2 )) {
			$assignedTime [$v->plannedSurveyDate] .= "<div class='s-d'><span class='s-t'>{$v->startTime_2}-{$v->endTime_2}({$v->jobNoNew})</span></div>";
		}
		if (! empty ( $v->startTime_3 ) && ! empty ( $v->endTime_3 )) {
			$assignedTime [$v->plannedSurveyDate] .= "<div class='s-d'><span class='s-t'>{$v->startTime_3}-{$v->endTime_3}({$v->jobNoNew})</span></div>";
		}
		if (! empty ( $v->startTime_4 ) && ! empty ( $v->endTime_4 )) {
			$assignedTime [$v->plannedSurveyDate] .= "<div class='s-d'><span class='s-t'>{$v->startTime_4}-{$v->endTime_4}({$v->jobNoNew})</span></div>";
		}
	}
	// 获取14天内的该调查员的日程
	$sfta = new SurveyorFreeTimeAccess ( $db );
	$busyTimes = $sfta->GetBusyTime ( $sur );
	for($j = 0; $j < 14; $j ++) {
		$daySchedules = $sfta->GetDayBusyTime ( $nextDays [$j], $busyTimes );
		$daySchedules .= $assignedTime [$nextDays [$j]];
		$t->set_var ( "nextDaySchedule" . $j, $daySchedules );
	}
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>