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
$complateJobNo = $_GET ['distId'];
// if(UserLogin::IsAdministrator() || UserLogin::IsSupervisor())
// {
// $complateJobNo = $_GET['distId'];
// }
// else
// {
// $canDoDistrict = UserLogin::CanDoDistrict();
// if($canDoDistrict == "")
// {
// exit();
// }
// $tempDoDist = explode(",",$canDoDistrict);
// $complateJobNo = GetFullDistNumber($tempDoDist[1]);
// }
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
$pd = new ProgressData ();
$pd->complateJobNo = $ms->complateJobNo;
$pda = new ProgressDataAccess ( $db );
$receivedHours = array ();
$formsPrepared = array ();
$surveyHours = array ();
$arrangedHours = array ();
$receivedForms = array ();
$reportedHours = array ();

// Received Hours（有多少調查表收到）
$rs = $pda->GetListReceivedHours ( $pd );
$rsNo = count ( $rs );
// $temp = 0;
for($i = 0; $i < $rsNo; $i ++) {
	$obj = $rs [$i];
	$receivedHours [$obj->weekNo] = $obj->estimatedManHour;
	// $temp += $obj->estimatedManHour;
}
// print $temp."<br />";
// print_r($receivedHours);
// Forms Prepared(有多少調查表格已准備)
$rs = $pda->GetListFormsPrepared ( $pd );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	$obj = $rs [$i];
	$formsPrepared [$obj->weekNo] = $obj->estimatedManHour;
}
// Arranged Hours(安排時間)
$rs = $pda->GetListArrangedHours ( $pd );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	$obj = $rs [$i];
	$arrangedHours [$obj->weekNo] = $obj->estimatedManHour;
}
// Surveyed Hours(調查時間)
$rs = $pda->GetListSurveyedHours ( $pd );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	$obj = $rs [$i];
	$surveyHours [$obj->weekNo] = $obj->estimatedManHour;
}
// Received Forms(收返表格)
$rs = $pda->GetListReceivedForms ( $pd );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	$obj = $rs [$i];
	$receivedForms [$obj->weekNo] = $obj->estimatedManHour;
}
// Reported Hours(报告时间）
$rs = $pda->GetListReportedHours ( $pd );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	$obj = $rs [$i];
	$reportedHours [$obj->weekNo] = $obj->estimatedManHour;
}
// print_r($surveyHours);
// print "<br /><br />";
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