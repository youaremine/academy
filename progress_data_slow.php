<?php
/*
 * Header: Create: 2007-09-08 Auther: Jamblues.
 */
include_once ('./includes/config.inc.php');
include_once ('./includes/config.schedule.inc.php');

$arryDataStart = 0;
$arryDataEnd = 0;
if (! empty ( $_GET ['txtWeekStart'] ))
	$arryDataStart = $_GET ['txtWeekStart'];
if (! empty ( $_GET ['txtWeekEnd'] ))
	$arryDataEnd = $_GET ['txtWeekEnd'];
function mycompare($a, $b) {
	if ($a == $b)
		return 0;
	return ($a > $b) ? 1 : - 1;
}

/**
 * 得到星期数
 * 
 * @param $date 日期        	
 * @param $type 类型        	
 * @param $survey_start_date 开始时间        	
 */
function GetWeekNo($date, $survey_start_date) {
	$weekNo = ceil ( (DateDiffDay ( $survey_start_date, $date ) + 1) / 7 );
	return $weekNo;
}

/**
 * 自定义星期数
 *
 * @param $arryData 传入数据        	
 * @param $arryDataStart 开始部分        	
 * @param $arryDataEnd 结束部分        	
 * @return 匹配过后的数组
 */
function CustomerArray($arryData, $arryDataStart, $arryDataEnd) {
	if (($arryDataStart == 0 && $arryDataEnd == 0) || ! is_array ( $arryData )) {
		return $arryData;
	}
	$customerArryData = array ();
	$i = 0;
	foreach ( $arryData as $k => $v ) {
		if ($k >= $arryDataStart && $k <= $arryDataEnd) {
			$customerArryData [$i] = $v;
			$i ++;
		}
	}
	
	return $customerArryData;
}
// xdata
$survey_start_date = $conf ['survey_start_date'] ['all'];
if (! empty ( $_GET ['distId'] )) {
	$complateJobNo = GetFullDistNumber ( $_GET ['distId'] );
	;
}
$canDoDistrict = UserLogin::CanDoDistrict ();
$tempDoDist = explode ( ",", $canDoDistrict );
$canDoDistNo = count ( $tempDoDist );
if ($canDoDistNo == 2) {
	$complateJobNo = GetFullDistNumber ( $tempDoDist [1] );
}
if ($complateJobNo != "") {
	$survey_start_date = $conf ['survey_start_date'] [$complateJobNo];
}
$weekCount = 0;
$datax = array ();
$datax [0] = 0;
$startTime = strtotime ( $survey_start_date );
$oneDayTime = 86400; // 60*60*24
$oneWeekTime = 604800; // $oneDayTime*7
for($i = 0; $i <= 60; $i ++) {
	$datax [$i] = "  " . $i . "\n(" . date ( "j/n", $startTime + $oneWeekTime * $i ) . ")";
	$weekCount ++;
}
$datax = CustomerArray ( $datax, $arryDataStart, $arryDataEnd );
// print_r($datax);exit();
// 数据部分
$ms = new MainSchedule ();
$ms->complateJobNo = $complateJobNo;
$msa = new MainScheduleAccess ( $db );
// $msa->order = " AND complateJobNo IN (".$conf['complateJobNo']['HKI'].",".$conf['complateJobNo']['KLN'].",".$conf['complateJobNo']['NT'].",".$conf['complateJobNo']['BR'].")";
// if($arryDataStart && $arryDataEnd)
// {
// $msa->order .= " AND weekNo >=".$arryDataStart." AND weekNo <=".$arryDataEnd;
// }
$rs = $msa->GetListSearchByProgress ( $ms );
$rsNum = count ( $rs );

$pd = new ProgressData ();
$pd->complateJobNo = $ms->complateJobNo;
$pda = new ProgressDataAccess ( $db );

$receivedHours = array ();
$formsPrepared = array ();
$surveyHours = array ();
$arrangedHours = array ();
$receivedForms = array ();
$reportedHours = array ();
$minTime = strtotime ( "1970-01-01" );
for($i = 0; $i < $rsNum; $i ++) {
	$ms = $rs [$i];
	$totalOnBoardCostFare = $ms->onBoardCostFare * $ms->noOfTrips;
	$costHour = CalcOnBoardCostFare2Hour ( $ms->complateJobNo, $totalOnBoardCostFare );
	// Received Hours（有多少調查表收到）
	if ($ms->receivedDate != "" && strtotime ( $ms->receivedDate ) > $minTime) {
		$weekNo = GetWeekNo ( $ms->receivedDate, $conf ['survey_start_date'] [$ms->complateJobNo] );
		$receivedHours [$weekNo] += $ms->estimatedManHour;
		$receivedHours [$weekNo] += $costHour;
	}
	// Forms Prepared(有多少調查表格已准備)
	if ($ms->receivedDate != "" && $ms->distributedToLeader != "" && strtotime ( $ms->receivedDate ) > $minTime) {
		$weekNo = GetWeekNo ( $ms->receivedDate, $conf ['survey_start_date'] [$ms->complateJobNo] );
		$formsPrepared [$weekNo] += $ms->estimatedManHour;
		$formsPrepared [$weekNo] += $costHour;
	}
	// Arranged Hours(安排時間)
	if ($ms->plannedSurveyDate != "" && strtotime ( $ms->plannedSurveyDate ) > $minTime) {
		$weekNo = GetWeekNo ( $ms->plannedSurveyDate, $conf ['survey_start_date'] [$ms->complateJobNo] );
		$arrangedHours [$weekNo] += $ms->estimatedManHour;
		$arrangedHours [$weekNo] += $costHour;
	}
	// Surveyed Hours(調查時間)
	if ($ms->plannedSurveyDate != "" && strtotime ( $ms->plannedSurveyDate ) > $minTime && strtotime ( $ms->plannedSurveyDate ) < strtotime ( date ( $conf ['date'] ['format'] ) )) {
		$weekNo = GetWeekNo ( $ms->plannedSurveyDate, $conf ['survey_start_date'] [$ms->complateJobNo] );
		$surveyHours [$weekNo] += $ms->estimatedManHour;
		$surveyHours [$weekNo] += $costHour;
	}
	// Received Forms(收返表格)
	if ($ms->receiveDate != "" && strtotime ( $ms->receiveDate ) > $minTime) {
		$weekNo = GetWeekNo ( $ms->receivedDate, $conf ['survey_start_date'] [$ms->complateJobNo] );
		$receivedForms [$weekNo] += $ms->estimatedManHour;
		$receivedForms [$weekNo] += $costHour;
	}
	// Reported Hours(报告时间)
	if ($ms->report != "" && strtotime ( $ms->report ) > $minTime) {
		$weekNo = GetWeekNo ( $ms->report, $conf ['survey_start_date'] [$ms->complateJobNo] );
		$reportedHours [$weekNo] += $ms->estimatedManHour;
		$reportedHours [$weekNo] += $costHour;
		// echo $weekNo." - ".$ms->report."<br />";
	}
}
unset ( $rs );

// 设置数据
if (count ( $receivedHours ) > 0) {
	for($i = 0; $i <= min ( $weekCount, max ( array_keys ( $receivedHours ) ) ); $i ++) {
		$receivedHours [$i] = $receivedHours [$i] + $receivedHours [$i - 1];
		$receivedHoursData [$i] = $receivedHours [$i];
		// print $receivedHoursData[$i]."<br />";
	}
	// uksort($receivedHours, mycompare);
}
unset ( $receivedHours );
$receivedHoursData = CustomerArray ( $receivedHoursData, $arryDataStart, $arryDataEnd );

if (count ( $formsPrepared ) > 0) {
	for($i = 0; $i <= min ( $weekCount, max ( array_keys ( $formsPrepared ) ) ); $i ++) {
		$formsPrepared [$i] = $formsPrepared [$i] + $formsPrepared [$i - 1];
		$formsPreparedData [$i] = $formsPrepared [$i];
	}
	// uksort($formsPrepared, mycompare);
}
unset ( $formsPrepared );
$formsPreparedData = CustomerArray ( $formsPreparedData, $arryDataStart, $arryDataEnd );

if (count ( $arrangedHours ) > 0) {
	for($i = 0; $i <= min ( $weekCount, max ( array_keys ( $arrangedHours ) ) ); $i ++) {
		$arrangedHours [$i] = $arrangedHours [$i] + $arrangedHours [$i - 1];
		$arrangedHoursData [$i] = $arrangedHours [$i];
	}
	// uksort($arrangedHours, mycompare);
}
unset ( $arrangedHours );
$arrangedHoursData = CustomerArray ( $arrangedHoursData, $arryDataStart, $arryDataEnd );

if (count ( $surveyHours ) > 0) {
	for($i = 0; $i <= min ( $weekCount, max ( array_keys ( $surveyHours ) ) ); $i ++) {
		$surveyHours [$i] = $surveyHours [$i] + $surveyHours [$i - 1];
		$surveyHoursData [$i] = $surveyHours [$i];
	}
	// uksort($surveyHours, mycompare);
}
unset ( $surveyHours );
$surveyHoursData = CustomerArray ( $surveyHoursData, $arryDataStart, $arryDataEnd );

if (count ( $receivedForms ) > 0) {
	for($i = 0; $i <= min ( $weekCount, max ( array_keys ( $receivedForms ) ) ); $i ++) {
		$receivedForms [$i] = $receivedForms [$i] + $receivedForms [$i - 1];
		$receivedFormsData [$i] = $receivedForms [$i];
	}
	// uksort($receivedForms, mycompare);
}
unset ( $receivedForms );
$receivedFormsData = CustomerArray ( $receivedFormsData, $arryDataStart, $arryDataEnd );

if (count ( $reportedHours ) > 0) {
	for($i = 0; $i <= min ( $weekCount, max ( array_keys ( $reportedHours ) ) ); $i ++) {
		$reportedHours [$i] = $reportedHours [$i] + $reportedHours [$i - 1];
		$reportedHoursData [$i] = $reportedHours [$i];
	}
	// uksort($reportedHours, mycompare);
}
unset ( $reportedHours );
$reportedHoursData = CustomerArray ( $reportedHoursData, $arryDataStart, $arryDataEnd );
// print_r($surveyHoursData);
?>