<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "../templates" );
$t->set_file ( "HdIndex", "assign/can_assign_surveyor_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "SecondRow", "SecondRows" );
$t->set_var ( "SecondRows", "" );
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$sur = new Surveyor ();
$sa = new SurveyorAccess ( $db );
$ms2 = new MainSchedule ();

if ($_GET ["txtSurvId"] != "") {
	$sur->survId = $_GET ["txtSurvId"];
    $ms2->surveyorCode = $_GET ["txtSurvId"];
}
if ($_GET ["txtEngName"] != "") {
	$sur->engName = $_GET ["txtEngName"];
}
if ($_GET ["txtContact"] != "") {
	$sur->contact = $_GET ["txtContact"];
}
if (! empty ( $_REQUEST ['jobNoNew'] )) {
	$jobNoNew = $_REQUEST ['jobNoNew'];
}
if (UserLogin::HasPermission ( "surveyor_contractor_all" )) {
	$sur->company = '';
} else {
	$sur->company = UserLogin::CanDoCompany (); // 分判商
}

// 調查詳情
$ms = new MainSchedule ();
$ms->jobNoNewSigle = $jobNoNew;
$msa = new MainScheduleAccess ( $db );
$rs = $msa->GetListSearch ( $ms );
$ms = $rs [0];
$currTime = array ();
$currTime [] = array (
		"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_1,
		"endTime" => ConvertLarge24Hour ( $ms->startTime_1, $ms->endTime_1, $ms->plannedSurveyDate )
);
if (! empty ( $ms->startTime_2 ) && ! empty ( $ms->endTime_2 )) {
	$currTime [] = array (
			"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_2,
			"endTime" => ConvertLarge24Hour ( $ms->startTime_2, $ms->endTime_2, $ms->plannedSurveyDate )
	);
}
if (! empty ( $ms->startTime_3 ) && ! empty ( $ms->endTime_3 )) {
	$currTime [] = array (
			"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_3,
			"endTime" => ConvertLarge24Hour ( $ms->startTime_3, $ms->endTime_3, $ms->plannedSurveyDate )
	);
}
if (! empty ( $ms->startTime_4 ) && ! empty ( $ms->endTime_4 )) {
	$currTime [] = array (
			"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_4,
			"endTime" => ConvertLarge24Hour ( $ms->startTime_4, $ms->endTime_4, $ms->plannedSurveyDate )
	);
}

$arrMainSchedule ["surveyLocationDistrict"] = $ms->surveyLocationDistrict;
$arrMainSchedule ["startTime_1"] = $ms->startTime_1;

// 设置搜索部分
if (! empty ( $ms->plannedSurveyDate )) {
	$txtMonth = date ( "Y-m", strtotime ( $ms->plannedSurveyDate ) );
}
$t->set_var ( array (
		"txtSurvId" => $sur->survId,
		"txtEngName" => $sur->engName,
		"txtContact" => $sur->contact,
		"jobNoNew" => $jobNoNew,
		"txtMonth" => $txtMonth
) );

// 調查員忙的時間段
$startTime = $ms->plannedSurveyDate;
$endTime = $ms->plannedSurveyDate . " 24:00:00";
$sur->order = " AND sft.startTime <= '{$endTime}' AND sft.endTime > '{$startTime}'";
$sa = new SurveyorAccess ( $db );
$rs = $sa->GetTimeListSearch ( $sur );
$sur->order = '';
$sur->status = 'active';
$surveyorBusyTime = array ();
$surveyorBusyTimePeroid = array();
$tmpPeriodTime = array(
    '06:00 - 12:00'=>array(
            "startTime" => $ms->plannedSurveyDate." 06:00:00",
            "endTime" => $ms->plannedSurveyDate." 12:00:00"),
    '12:00 - 18:00'=>array(
        "startTime" => $ms->plannedSurveyDate." 12:00:00",
        "endTime" => $ms->plannedSurveyDate." 18:00:00"),
    '18:00 - 23:59'=>array(
        "startTime" => $ms->plannedSurveyDate." 18:00:00",
        "endTime" => $ms->plannedSurveyDate." 23:59:00")
    );
$lastSurvId = $rs[0]->survId;
$tmp = array();
$tmp[$lastSurvId] = array();
$hasBusyTime = false;
foreach ( $rs as $v ) {
    if(!isset($tmp[$v->survId])){
        $tmp[$v->survId] = $tmpPeriodTime;
    }
    if($v->isFree == 'busy'){
        $surveyorBusyTime[$v->survId][] = array (
            "startTime" => $v->startTime,
            "endTime" => $v->endTime
        );
        $tmp[$v->survId] = array();
    }else{
        $startTimeStamp = strtotime($v->startTime);
        $endTimeStamp = strtotime($v->endTime);
        $tmpPeriod = date("H:i",$startTimeStamp) . " - " . date("H:i",$endTimeStamp);
        if($tmpPeriod == '00:00 - 23:59'){
            $tmp[$v->survId] = array();
        }else{
            unset($tmp[$v->survId][$tmpPeriod]);
        }
    }
    if($lastSurvId != $v->survId){
        foreach($tmp[$v->survId] as $vv){
            $surveyorBusyTime[$v->survId][] = $vv;
        }
    }

}
foreach($tmp[$lastSurvId] as $vv){
    $surveyorBusyTime[$lastSurvId][] = $vv;
}
// 已委派的時間
$ms2->plannedSurveyDateStart = $startTime;
$ms2->plannedSurveyDateEnd = $endTime;
$msa = new MainScheduleAccess ( $db );
$msa->order = "	ORDER BY surveyorCode ASC";
$rs = $msa->GetListSearch ( $ms2 );
$rsNum = count ( $rs );
$assignedTime = array ();
for($i = 0; $i < $rsNum; $i ++) {
	$ms = $rs [$i];
	$assignedTime [$ms->surveyorCode] [] = array (
			"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_1,
			"endTime" => ConvertLarge24Hour ( $ms->startTime_1, $ms->endTime_1, $ms->plannedSurveyDate )
	);
	if (! empty ( $ms->startTime_2 ) && ! empty ( $ms->endTime_2 )) {
		$assignedTime [$ms->surveyorCode] [] = array (
				"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_2,
				"endTime" => ConvertLarge24Hour ( $ms->startTime_2, $ms->endTime_2, $ms->plannedSurveyDate )
		);
	}
	if (! empty ( $ms->startTime_3 ) && ! empty ( $ms->endTime_3 )) {
		$assignedTime [$ms->surveyorCode] [] = array (
				"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_3,
				"endTime" => ConvertLarge24Hour ( $ms->startTime_3, $ms->endTime_3, $ms->plannedSurveyDate )
		);
	}
	if (! empty ( $ms->startTime_4 ) && ! empty ( $ms->endTime_4 )) {
		$assignedTime [$ms->surveyorCode] [] = array (
				"startTime" => $ms->plannedSurveyDate . " " . $ms->startTime_4,
				"endTime" => ConvertLarge24Hour ( $ms->startTime_4, $ms->endTime_4, $ms->plannedSurveyDate )
		);
	}
}
$sur->survType = "";
$rs = $sa->GetListSearch ( $sur );
$rsNum = count ( $rs );

$arrScale ["surveyLocationDistrict"] = 1;
$arrScale ["monthWorkHour"] = 30;
$arrScale ["surveyorOrder"] = 30;

$startDayTime = strtotime ( $startTime );
$lastWorkMonthTime = mktime ( 0, 0, 0, date ( "m", $startDayTime ) - 1, 1, date ( "Y", $startDayTime ) );
$lastWorkMonth = date ( "Y-m", $lastWorkMonthTime );

$monthStartDate = $txtMonth . "-01";
$startDayTime = strtotime ( $monthStartDate );
$endDayTime = mktime ( 0, 0, 0, date ( "m", $startDayTime ) + 1, 1, date ( "Y", $startDayTime ) );
$monthEndDate = date ( $conf ['date'] ['format'], $endDayTime );

$msCurr = new MainSchedule ();
$msCurr->isAssigned = false;
$msCurr->plannedSurveyDateStart = $monthStartDate;
$msCurr->plannedSurveyDateEnd = $monthEndDate;
// 当月总时间数
$arrMainSchedule ["currMonthEstimatedManHour"] = $msa->GetEstimatedManHour ( $msCurr );
// 当月未委派时间数
$arrMainSchedule ["currMonthNoAssignEstimatedManHour"] = $msa->GetNoAssignEstimatedManHour ( $msCurr );

// 上月总共时间数
$msLast = new MainSchedule ();
$msLast->plannedSurveyDateStart = date ( "Y-m", $lastWorkMonthTime ) . "-01";
$startDayTime = strtotime ( $msLast->plannedSurveyDateStart );
$endDayTime = mktime ( 0, 0, 0, date ( "m", $startDayTime ) + 1, 1, date ( "Y", $startDayTime ) );
$msLast->plannedSurveyDateEnd = date ( $conf ['date'] ['format'], $endDayTime );
$arrMainSchedule ["lastMonthEstimatedManHour"] = $msa->GetEstimatedManHour ( $msLast );

$rsSurveyors = array ();
for($i = 0; $i < $rsNum; $i ++) {
	$sur = $rs [$i];
	$arrSurveyor ["dipaCode"] = $sur->dipaCode;
	$arrSurveyor ["order"] = 0;
	$monthWorkHour = $sa->GetWorkHour ( $sur->survId, $txtMonth );
	$arrSurveyor ["currMonthWorkHour"] = $monthWorkHour ["totalWorkHour"];
	$arrSurveyor ["lastMonthWorkHour"] = $monthWorkHour ["lastTotalWorkHour"];
	$sur->source = $sa->CalcSource ( $arrMainSchedule, $arrSurveyor, $arrScale );
	$sur->source += $sur->VIP;
	$rsSurveyors[] = $sur;
}

// 排序,分数高的排在前面
function cmp($a, $b) {
	if ($a->source == $b->source) {
		return 0;
	}
	return ($a->source > $b->source) ? - 1 : 1;
}
usort($rsSurveyors, "cmp");


$rsFirst = $rsSurveyors;
if (! empty ( $rsFirst )) {
	unset ( $rsSurveyors [$userCompanyCode] );
	$t->set_var ( array (
			"companyName" => $companys [$userCompanyCode],
			"companyCode" => $userCompanyCode,
			"btnShowStyle" => "display:none;",
			"btnHideStyle" => "",
			"style" => ""
	) );
	$rsFirstNum = count ( $rsFirst );
	for($i = 0; $i < $rsFirstNum; $i ++) {
		$sur = $rsFirst [$i];
		// if($sur->survId=='1615')
		// {
		// echo "{$sur->survId}:";var_dump($assignedTime[$sur->survId]);echo "<br />";
		// var_dump($currTime);echo "<br />";
		// }
		if ($msa->IsAssignTime ( $assignedTime [$sur->survId], $currTime )) 		// 已委派的時間
		{
			$sur->isBusy = true;
		} else if ($msa->IsAssignTime ( $surveyorBusyTime [$sur->survId], $currTime )) 		// 忙碌的時間
		{
			$sur->isBusy = true;
		}
		if ($i % 2 == 0)
			$listStyle = "AlternatingItemStyle";
		else
			$listStyle = "DgItemStyle";
		$dbClickEvent = "var selValue = '{survId}|{engName}|{contact}|{survHome}|{dipaCode}|{IsSupervisor}|{remark}';if(window.opener){window.opener.returnValue = selValue;}window.returnValue=selValue;self.close();";
		if ($sur->isBusy == true && $sur->survId != 999) {
			$listStyle = "DgDisableItemStyle";
			$dbClickEvent = "";
		}
		$whatsAPPICO = "";
		$emailICO = "";
		if (! empty ( $sur->whatsAPP )) {
			$whatsAPPICO = "<img border='0' src='../images/whatsapp.png' width='24' />";
		}
		if (! empty ( $sur->email )) {
			$emailICO = "<a href='mailto:{$sur->email}'><img border='0' src='../images/email.png' width='24' /></a>";
		}
		$t->set_var ( array (
				"listStyle" => $listStyle,
				"dbClickEvent" => $dbClickEvent,
				"survId" => $sur->survId, // ." - (source:".$sur->source.")",
				"chiName" => $sur->chiName,
				"engName" => $sur->engName,
				"contact" => $sur->contact,
				"survHome" => $sur->survHome,
				"dipaCode" => $sur->dipaCode,
				"IsSupervisor" => $sur->IsSupervisor,
				"whatsAPPICO" => $whatsAPPICO,
				"emailICO" => $emailICO,
				"remark" => $sur->remark
		) );
		$t->parse ( "SecondRows", "SecondRow", true );
	}
	$t->parse ( "Rows", "Row", true );
	$t->set_var ( "SecondRows", "" );
}

/*
 * foreach($rsSurveyors as $k=>$v) { $t->set_var(array("companyName"=>$companys[$k], "companyCode"=>$k, "btnShowStyle"=>"", "btnHideStyle"=>"display:none;", "style"=>"display:none;" )); $rsSecond = $v; $rsSecondNum = count($rsSecond); for($i=0;$i<$rsSecondNum;$i++) { $sur = $rsSecond[$i]; if($msa->IsAssignTime($assignedTime[$sur->survId],$currTime))//已委派的時間 { $sur->isBusy = true; } else if($msa->IsAssignTime($surveyorBusyTime[$sur->survId], $currTime))//忙碌的時間 { $sur->isBusy = true; } if($i%2 == 0) $listStyle="AlternatingItemStyle"; else $listStyle="DgItemStyle"; $dbClickEvent = "var selValue = '{survId}|{engName}|{contact}|{survHome}|{dipaCode}|{IsSupervisor}|{remark}';if(window.opener){window.opener.returnValue = selValue;}window.returnValue=selValue;self.close();"; if($sur->isBusy == true && $sur->survId!=999) { $listStyle="DgDisableItemStyle"; $dbClickEvent = ""; } $t->set_var(array( "listStyle"=>$listStyle, "dbClickEvent"=>$dbClickEvent, "survId"=>$sur->survId,//." - (source:".$sur->source.")", "chiName"=>$sur->chiName, "engName"=>$sur->engName, "contact"=>$sur->contact, "survHome"=>$sur->survHome, "dipaCode"=>$sur->dipaCode, "IsSupervisor"=>$sur->IsSupervisor, "whatsAPPICO"=>$whatsAPPICO, "emailICO"=>$emailICO, "remark"=>$sur->remark, )); $t->parse("SecondRows","SecondRow",true); } $t->parse("Rows","Row",true); $t->set_var("SecondRows",""); }
 */
$t->pparse ( "Output", "HdIndex" );
?>