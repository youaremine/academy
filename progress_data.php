<?php
/*
 * Header: Create: 2007-09-08 Auther: Jamblues.
 */
include_once ('./includes/config.inc.php');

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
 * 自定义星期数
 *
 * @param $arryData 传入数据        	
 * @param $arryDataStart 开始部分        	
 * @param $arryDataEnd 结束部分        	
 * @return 匹配过后的数组
 */
function CustomerArray($arryData, $arryDataStart, $arryDataEnd) {
	if ($arryDataStart == 0 && $arryDataEnd == 0) {
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
$weekCount = 0;
$datax = array ();
$datax [0] = 0;
$startTime = strtotime ( $conf ['survey'] ['start_date'] );
$oneDayTime = 86400; // 60*60*24
$oneWeekTime = 604800; // $oneDayTime*7
for($i = 0; $i <= 60; $i ++) {
	$datax [$i] = "  " . $i . "\n(" . date ( "j/n", $startTime + $oneWeekTime * $i - $oneDayTime ) . ")";
	$weekCount ++;
}
$datax = CustomerArray ( $datax, $arryDataStart, $arryDataEnd );
// 数据部分
$ms = new MainSchedule ();
if (UserLogin::IsAdministrator () || UserLogin::IsSupervisor ()) {
	$ms->complateJobNo = $_GET ['distId'];
} else {
	$canDoDistrict = UserLogin::CanDoDistrict ();
	if ($canDoDistrict == "") {
		exit ();
	}
	$tempDoDist = explode ( ",", $canDoDistrict );
	$ms->complateJobNo = GetFullDistNumber ( $tempDoDist [1] );
}

$msa = new MainScheduleAccess ( $db );
$rs = $msa->GetListSearchByProgress ( $ms );
$rsNum = count ( $rs );
$receivedHours = array ();
$receivedHoursIndex = 0;
$formsPrepared = array ();
$formsPreparedIndex = 0;
$surveyHours = array ();
$surveyHoursIndex = 0;
$onBoardCostSummary = array ();
$arrangedHours = array ();
$arrangedHoursIndex = 0;
$receivedForms = array ();
$receivedFormsIndex = 0;
$reportedHours = array ();
$reportedHoursIndex = 0;

$lessTime = strtotime ( "1970-01-01" );

for($i = 0; $i < $rsNum; $i ++) {
	$ms = $rs [$i];
	// Received Hours（有多少調查表收到）
	if ($ms->receivedDate != "" && strtotime ( $ms->receivedDate ) > $lessTime) {
		$receivedHoursIndex = floor ( DateDiffDay ( $conf ['survey'] ['start_date'], $ms->receivedDate ) / 7 ) + 1;
		$receivedHours [$receivedHoursIndex] += $ms->estimatedManHour;
	}
	
	// Forms Prepared(有多少調查表格已准備)
	if ($ms->receivedDate != "" && $ms->distributedToLeader != "" && strtotime ( $ms->receivedDate ) > $lessTime) {
		$formsPreparedIndex = floor ( DateDiffDay ( $conf ['survey'] ['start_date'], $ms->receivedDate ) / 7 ) + 1;
		$formsPrepared [$formsPreparedIndex] += $ms->estimatedManHour;
	}
	
	// Arranged Hours(安排時間)
	if ($ms->plannedSurveyDate != "" && strtotime ( $ms->plannedSurveyDate ) > $lessTime) {
		$arrangedHoursIndex = floor ( DateDiffDay ( $conf ['survey'] ['start_date'], $ms->plannedSurveyDate ) / 7 ) + 1;
		$arrangedHours [$arrangedHoursIndex] += $ms->estimatedManHour;
	}
	
	// Surveyed Hours(調查時間)
	if ($ms->plannedSurveyDate != "" && strtotime ( $ms->plannedSurveyDate ) > $lessTime && strtotime ( $ms->plannedSurveyDate ) < strtotime ( date ( $conf ['date'] ['format'] ) )) {
		$surveyHoursIndex = floor ( DateDiffDay ( $conf ['survey'] ['start_date'], $ms->plannedSurveyDate ) / 7 ) + 1;
		$surveyHours [$surveyHoursIndex] += $ms->estimatedManHour;
		$surveyHours [$surveyHoursIndex] += ($ms->onBoardCostFare * $ms->noOfTrips) / $conf ['feeHour'] [$ms->complateJobNo];
	}
	// print $ms->plannedSurveyDate." - ".DateDiffDay($conf['survey']['start_date'],$ms->plannedSurveyDate)." - ".(floor(DateDiffDay($conf['survey']['start_date'],$ms->plannedSurveyDate)/7))."<br />";
	// Received Forms(收返表格)
	if ($ms->receiveDate != "" && strtotime ( $ms->receiveDate ) > $lessTime) {
		$receivedFormsIndex = floor ( DateDiffDay ( $conf ['survey'] ['start_date'], $ms->receiveDate ) / 7 ) + 1;
		$receivedForms [$receivedFormsIndex] += $ms->estimatedManHour;
	}
	
	// Reported Hours(报告时间）
	if ($ms->report != "" && strtotime ( $ms->report ) > $lessTime) {
		$reportedHoursIndex = floor ( DateDiffDay ( $conf ['survey'] ['start_date'], $ms->report ) / 7 ) + 1;
		$reportedHours [$reportedHoursIndex] += $ms->estimatedManHour;
		// print $ms->report." | ".$reportedHoursIndex." | ".$ms->estimatedManHour."<br />";
	}
}
unset ( $rs );
// 设置数据
if (count ( $receivedHours ) > 0) {
	for($i = 0; $i < min ( $weekCount, max ( array_keys ( $receivedHours ) ) ); $i ++) {
		$receivedHours [$i] = $receivedHours [$i] + $receivedHours [$i - 1];
		$receivedHoursData [$i] = $receivedHours [$i];
	}
	// uksort($receivedHours, mycompare);
}
unset ( $receivedHours );
$receivedHoursData = CustomerArray ( $receivedHoursData, $arryDataStart, $arryDataEnd );

if (count ( $formsPrepared ) > 0) {
	for($i = 0; $i < min ( $weekCount, max ( array_keys ( $formsPrepared ) ) ); $i ++) {
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
?>