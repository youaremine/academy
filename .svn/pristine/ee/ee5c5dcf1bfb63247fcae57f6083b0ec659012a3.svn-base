<?php
/**
 *
 * @author xiao.qiang.wu <jamblues@gmail.com>
 * @version 1.01
 */
include_once ("../includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "../templates/assign" );
$t->set_file ( "HdIndex", "surveyor_assign.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );
$t->set_block ( "HdIndex", "AssignedRow", "AssignedRows" );
$t->set_var ( "AssignedRows", "" );

if ($_REQUEST ["txtMonth"] != "") {
	$txtMonth = $_REQUEST ["txtMonth"];
} else {
	$txtMonth = date ( "Y-m" );
}

if ($_REQUEST ["survId"] != "") {
	$survId = $_REQUEST ["survId"];
} else {
	$survId = 1;
}

$t->set_var ( array (
		"txtMonth" => $txtMonth,
		"survId" => $survId 
) );

// 调查员基本信息
$sur = new Surveyor ();
$sa = new SurveyorAccess ( $db );
$sur->survId = $survId;
$rs = $sa->GetListSearch ( $sur );
if (! empty ( $rs )) {
	$surCurr = $rs [0];
	$t->set_var ( array (
			"survId" => $surCurr->survId,
			"engName" => $surCurr->engName,
			"contact" => $surCurr->contact,
			"survHome" => $surCurr->survHome,
			"dipaCode" => $surCurr->dipaCode,
			"IsSupervisor" => $surCurr->IsSupervisor,
			"VIP" => $surCurr->VIP,
			"whatsAPP" => $surCurr->whatsAPP,
			"email" => $surCurr->email,
			"fax" => $surCurr->fax,
			"remark" => $surCurr->remark 
	) );
}

// 设定委派规则
$assignRule = getArray ( 'assign-rule' );

// 調查員忙的時間
$rs = $sa->GetTimeListSearch ( $sur );
$surveyorBusyTime = array ();
foreach ( $rs as $v ) {
	$surveyorBusyTime [] = array (
			"startTime" => $v->startTime,
			"endTime" => $v->endTime 
	);
}

$monthStartDate = $txtMonth . "-01";
$startDayTime = strtotime ( $monthStartDate );
$endDayTime = mktime ( 0, 0, 0, date ( "m", $startDayTime ) + 1, 1, date ( "Y", $startDayTime ) );
$monthEndDate = date ( $conf ['date'] ['format'], $endDayTime );

// Assigned
$jobNoNews = $sa->GetSystemAssignJobNoNew ( $survId );
// unset($ms);
$ms = new MainSchedule ();
$ms->surveyorCode = $survId;
$ms->plannedSurveyDateStart = $monthStartDate;
$ms->plannedSurveyDateEnd = $monthEndDate;
$msa = new MainScheduleAccess ( $db );
$msa->order = "	ORDER BY plannedSurveyDate ASC";
$rs = $msa->GetListSearch ( $ms );
$rsNo = count ( $rs );
$assignedTime = array ();
for($i = 0; $i < $rsNo; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$ms = $rs [$i];
	$assignedTime [$ms->plannedSurveyDate] [] = array (
			"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_1,
			"endTime" => $ms->plannedSurveyDate . " " . $ms->endTime_1 
	);
	if (! empty ( $ms->startTime_2 ) && ! empty ( $ms->endTime_2 )) {
		$assignedTime [$ms->plannedSurveyDate] [] = array (
				"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_2,
				"endTime" => $ms->plannedSurveyDate . " " . $ms->endTime_2 
		);
	}
	if (! empty ( $ms->startTime_3 ) && ! empty ( $ms->endTime_3 )) {
		$assignedTime [$ms->plannedSurveyDate] [] = array (
				"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_3,
				"endTime" => $ms->plannedSurveyDate . " " . $ms->endTime_3 
		);
	}
	if (! empty ( $ms->startTime_4 ) && ! empty ( $ms->endTime_4 )) {
		$assignedTime [$ms->plannedSurveyDate] [] = array (
				"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_4,
				"endTime" => $ms->plannedSurveyDate . " " . $ms->endTime_4 
		);
	}
	$unAssignButton = "";
	if (! is_array ( $jobNoNews ) || in_array ( $ms->jobNoNew, $jobNoNews )) {
		$unAssignButton = "<a href='surveyor_assign_press.php?action=unassign&txtMonth={$txtMonth}&survId={$survId}&jobNoNew={$ms->jobNoNew}'>
							<img src='../images/no.gif' width='18' height='18' border='0' alt='UnAssign' title='UnAssign' /></a>";
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
			"surveyLocationDistrict" => $ms->surveyLocationDistrict,
			"surveyLocation" => $ms->surveyLocation,
			"routeItems" => $ms->routeItems,
			"estimatedManHour" => $ms->estimatedManHour,
			"receiveDate" => $ms->receiveDate,
			"report" => $ms->report,
			"surveyorCode" => $ms->surveyorCode,
			"surveyorName" => $ms->surveyorName,
			"surveyorTelephone" => $ms->surveyorTelephone,
			"unAssignButton" => $unAssignButton 
	) );
	$t->parse ( "AssignedRows", "AssignedRow", true );
}

// 如果時間超過給調查員的時間份數,只需要警告,仍然可以繼續委派.
$assignWarningStyle = "display:none;";
$assignTableStyle = "";
$lastSystemAssignTime = $sa->GetLastSystemAssignTime ( $survId );
$lastSystemAssignTime = date ( "Y-m-d", strtotime ( $lastSystemAssignTime ) );
if ($lastSystemAssignTime == date ( "Y-m-d" )) {
	$assignWarningStyle = "";
	// $assignTableStyle = "display:none;";
}

$t->set_var ( array (
		"assignWarningStyle" => $assignWarningStyle,
		"assignTableStyle" => $assignTableStyle 
) );

// Assign
$ms = new MainSchedule ();
$ms->isAssigned = false;
// 如果是本月的,则所有委派的数据都必须是当天之后的.
if (strtotime ( $monthStartDate ) == strtotime ( date ( "Y-m" ) . "-01" )) {
	$ms->plannedSurveyDateStart = date ( "Y-m-d" );
} else {
	$ms->plannedSurveyDateStart = $monthStartDate;
}
$ms->plannedSurveyDateEnd = $monthEndDate;
$msa = new MainScheduleAccess ( $db );
$msa->order = "	ORDER BY plannedSurveyDate ASC ";
$rs = $msa->GetListSearch ( $ms );

$arrMainSchedule = array ();

$arrSurveyor ["dipaCode"] = $surCurr->dipaCode;
$arrSurveyor ["order"] = 0;
$lastWorkMonthTime = mktime ( 0, 0, 0, date ( "m", $startDayTime ) - 1, 1, date ( "Y", $startDayTime ) );
$lastWorkMonth = date ( "Y-m", $lastWorkMonthTime );
$monthWorkHour = $sa->GetWorkHour ( $sur->survId, $txtMonth );
$arrSurveyor ["currMonthWorkHour"] = $monthWorkHour ["totalWorkHour"];
$arrSurveyor ["lastMonthWorkHour"] = $monthWorkHour ["lastTotalWorkHour"];
$surveyorPreHour = $monthWorkHour ["canAssignHour"];

// 当月总时间数
$arrMainSchedule ["currMonthEstimatedManHour"] = $msa->GetEstimatedManHour ( $ms );
// 当月未委派时间数
$arrMainSchedule ["currMonthNoAssignEstimatedManHour"] = $msa->GetNoAssignEstimatedManHour ( $ms );

// 上月总共时间数
$msLast = new MainSchedule ();
$msLast->plannedSurveyDateStart = date ( "Y-m", $lastWorkMonthTime ) . "-01";
$startDayTime = strtotime ( $msLast->plannedSurveyDateStart );
$endDayTime = mktime ( 0, 0, 0, date ( "m", $startDayTime ) + 1, 1, date ( "Y", $startDayTime ) );
$msLast->plannedSurveyDateEnd = date ( $conf ['date'] ['format'], $endDayTime );
$arrMainSchedule ["lastMonthEstimatedManHour"] = $msa->GetEstimatedManHour ( $msLast );

// 调查员预计可分派到的时间数
// $surveyorPreHour = $arrMainSchedule["currMonthNoAssignEstimatedManHour"] * ($arrSurveyor["lastMonthWorkHour"] - $arrSurveyor["currMonthWorkHour"]) / $arrMainSchedule["lastMonthEstimatedManHour"];
// $surveyorPreHour = round($surveyorPreHour,1);

$t->set_var ( array (
		"surveyorPreHour" => $surveyorPreHour,
		"currMonthNoAssignEstimatedManHour" => $arrMainSchedule ["currMonthNoAssignEstimatedManHour"] 
) );

$arrScale ["surveyLocationDistrict"] = 1;
$arrScale ["monthWorkHour"] = 30;
$arrScale ["surveyorOrder"] = 30;

// 去掉不符合委派规则的和该时间段没空的Job
foreach ( $rs as $k => $v ) {
	// 去掉不符合委派规则的Job
	$no = filter_var ( $v->jobNo, FILTER_SANITIZE_NUMBER_INT );
	$no = substr ( $no, - 1, 1 );
	$assignRuleNo = $assignRule [$v->complateJobNo] [$no];
	if ($assignRuleNo != $surCurr->IsSupervisor) {
		unset ( $rs [$k] );
		continue;
	}
	// 去掉该时间段没空的Job
	$arrMainSchedule ["surveyLocationDistrict"] = $v->surveyLocationDistrict;
	$arrMainSchedule ["startTime_1"] = $v->startTime_1;
	$currTime = array ();
	$currTime [] = array (
			"startTime" => $v->plannedSurveyDate . " " . $v->startTime_1,
			"endTime" => ConvertLarge24Hour ( $v->startTime_1, $v->endTime_1, $v->plannedSurveyDate ) 
	);
	if (! empty ( $v->startTime_2 ) && ! empty ( $v->endTime_2 )) {
		$currTime [] = array (
				"startTime" => $v->plannedSurveyDate . " " . $v->startTime_2,
				"endTime" => ConvertLarge24Hour ( $v->startTime_2, $v->endTime_2, $v->plannedSurveyDate ) 
		);
	}
	if (! empty ( $v->startTime_3 ) && ! empty ( $v->endTime_3 )) {
		$currTime [] = array (
				"startTime" => $v->plannedSurveyDate . " " . $v->startTime_3,
				"endTime" => ConvertLarge24Hour ( $v->startTime_3, $v->endTime_3, $v->plannedSurveyDate ) 
		);
	}
	if (! empty ( $v->startTime_4 ) && ! empty ( $v->endTime_4 )) {
		$currTime [] = array (
				"startTime" => $v->plannedSurveyDate . " " . $v->startTime_4,
				"endTime" => ConvertLarge24Hour ( $v->startTime_4, $v->endTime_4, $v->plannedSurveyDate ) 
		);
	}
	if ($msa->IsAssignTime ( $assignedTime [$v->plannedSurveyDate], $currTime )) 	// 已委派的時間
	{
		unset ( $rs [$k] );
		continue;
	} else if ($msa->IsAssignTime ( $surveyorBusyTime, $currTime )) 	// 忙碌的時間
	{
		unset ( $rs [$k] );
		continue;
	}
	
	$rs [$k]->source = $sa->CalcSource ( $arrMainSchedule, $arrSurveyor, $arrScale );
	
	if ($rs [$k]->source < 10) {
		// unset($rs[$k]);
	}
}
// 排序,分数高的排在前面
function cmpb($a, $b) {
	if ($a->plannedSurveyDate == $b->plannedSurveyDate) {
		return 0;
	}
	return ($a->plannedSurveyDate < $b->plannedSurveyDate) ? - 1 : 1;
}
usort ( $rs, "cmpb" );
// 排序,分数高的排在前面
function cmp($a, $b) {
	// if ($a->source == $b->source) {
	// return 0;
	// }
	return 1;
	return ($a->source > $b->source) ? - 1 : 1;
}
usort ( $rs, "cmp" );
$result = $source = $plannedSurveyDate = array ();
foreach ( $rs as $k => $v ) {
	$result [] = array (
			"source" => $v->source,
			"weekNo" => $v->weekNo,
			"jobNo" => $v->jobNo,
			"jobNoNew" => $v->jobNoNew,
			"plannedSurveyDate" => $v->plannedSurveyDate,
			"tdFileNo" => $v->tdFileNo,
			"receivedDate" => $v->receivedDate,
			"dueDate" => $v->dueDate,
			"fromTD" => $v->fromTD,
			"surveyTimeHours" => $v->surveyTimeHours,
			"surveyType" => $v->surveyType,
			"vehicle" => $v->vehicle,
			"isHoliday" => $v->isHoliday,
			"surveyLocationDistrict" => $v->surveyLocationDistrict,
			"surveyLocation" => $v->surveyLocation,
			"routeItems" => $v->routeItems,
			"estimatedManHour" => $v->estimatedManHour,
			"receiveDate" => $v->receiveDate,
			"report" => $v->report,
			"surveyorCode" => $v->surveyorCode,
			"surveyorName" => $v->surveyorName,
			"surveyorTelephone" => $v->surveyorTelephone 
	);
	$source [$k] = $v->source;
	$plannedSurveyDate [$k] = $v->plannedSurveyDate;
}
array_multisort ( $source, SORT_DESC, $plannedSurveyDate, SORT_ASC, $result );

// 每天只预安排一个Job给该同事
$i = 0;
$preAssignTime = array ();
$rsPreAssign = array ();
foreach ( $result as $k => $v ) {
	if (! in_array ( $v ['plannedSurveyDate'], $preAssignTime )) {
		$i ++;
		$rsPreAssign [] = $v;
		$preAssignTime [] = $v ['plannedSurveyDate'];
		$surveyorPreHour -= $v ['estimatedManHour'];
		// 香港同事建议超过后仍然可以委派
		if ($surveyorPreHour < 0) {
			if ($i > 20) 			// 超过后最多出10条记录
			{
				break;
			}
		}
	}
}

$i = 0;
foreach ( $rsPreAssign as $k => $v ) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$i ++;
	if ($i == 15)
		break;
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"source" => $v ['source'],
			"weekNo" => $v ['weekNo'],
			"jobNo" => $v ['jobNo'],
			"jobNoNew" => $v ['jobNoNew'],
			"plannedSurveyDate" => $v ['plannedSurveyDate'],
			"tdFileNo" => $v ['tdFileNo'],
			"receivedDate" => $v ['receivedDate'],
			"dueDate" => $v ['dueDate'],
			"fromTD" => $v ['fromTD'],
			"surveyTimeHours" => $v ['surveyTimeHours'],
			"surveyType" => $v ['surveyType'],
			"vehicle" => $v ['vehicle'],
			"isHoliday" => $v ['isHoliday'],
			"surveyLocationDistrict" => $v ['surveyLocationDistrict'],
			"surveyLocation" => $v ['surveyLocation'],
			"routeItems" => $v ['routeItems'],
			"estimatedManHour" => $v ['estimatedManHour'],
			"receiveDate" => $v ['receiveDate'],
			"report" => $v ['report'],
			"surveyorCode" => $v ['surveyorCode'],
			"surveyorName" => $v ['surveyorName'],
			"surveyorTelephone" => $v ['surveyorTelephone'] 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>