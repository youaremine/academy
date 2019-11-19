<?php
/*
 * Header: Create: 2007-09-17 Auther: Jamblues.
 */
include_once ('./includes/config.inc.php');
function GetHoursCount($distId) {
	global $conf, $db;
	$ms = new MainSchedule ();
	$ms->complateJobNo = $distId;
	$msa = new MainScheduleAccess ( $db );
	// $msa->order = ' limit 100';
	$rs = $msa->GetListSearchByProgress ( $ms );
	$rsNum = count ( $rs );
	$receivedHours = 0;
	$formsPrepared = 0;
	$surveyHours = 0;
	$arrangedHours = 0;
	$receivedForms = 0;
	$reportedHours = 0;
	
	for($i = 0; $i < $rsNum; $i ++) {
		$ms = $rs [$i];
		$totalOnBoardCostFare = $ms->onBoardCostFare * $ms->noOfTrips;
		$costHour = CalcOnBoardCostFare2Hour ( $ms->complateJobNo, $totalOnBoardCostFare );
		// Received Hours(有多少調查表收到)
		if ($ms->receivedDate != "" && strtotime ( $ms->receivedDate ) > strtotime ( "1970-01-01" )) {
			$receivedHours += $ms->estimatedManHour;
			$receivedHours += $costHour;
		}
		
		// Forms Prepared(有多少調查表格已准備)
		if ($ms->receivedDate != "" && $ms->distributedToLeader != "" && strtotime ( $ms->receivedDate ) > strtotime ( "1970-01-01" )) {
			$formsPrepared += $ms->estimatedManHour;
			$formsPrepared += $costHour;
		}
		
		// Arranged Hours(安排時間)
		if ($ms->plannedSurveyDate != "" && strtotime ( $ms->plannedSurveyDate ) > strtotime ( "1970-01-01" )) {
			$arrangedHours += $ms->estimatedManHour;
			$arrangedHours += $costHour;
		}
		
		// Surveyed Hours(調查時間)
		if ($ms->plannedSurveyDate != "" && strtotime ( $ms->plannedSurveyDate ) > strtotime ( "1970-01-01" ) && strtotime ( $ms->plannedSurveyDate ) < strtotime ( date ( $conf ['date'] ['format'] ) )) {
			$surveyHours += $ms->estimatedManHour;
			$surveyHours += $costHour;
		}
		
		// Received Forms(收返表格)
		if ($ms->receiveDate != "" && strtotime ( $ms->receiveDate ) > strtotime ( "1970-01-01" )) {
			$receivedForms += $ms->estimatedManHour;
			$receivedForms += $costHour;
		}
		
		// Reported Hours(报告时间)
		if ($ms->report != "" && strtotime ( $ms->report ) > strtotime ( "1970-01-01" )) {
			$reportedHours += $ms->estimatedManHour;
			$reportedHours += $costHour;
		}
	}
	return array (
			$receivedHours,
			$formsPrepared,
			$arrangedHours,
			$surveyHours,
			$receivedForms,
			$reportedHours 
	);
}

$dataReceivedHours = array ();
$dataFormsPrepared = array ();
$dataArrangedHours = array ();
$dataSurveyHours = array ();
$dataReceivedForms = array ();
$dataReportedHours = array ();
foreach ( $conf ['districtName'] as $v ) {
	$groups = GetHoursCount ( $conf ['complateJobNo'] [$v] );
	$dataReceivedHours [] = $groups [0];
	$dataFormsPrepared [] = $groups [1];
	$dataArrangedHours [] = $groups [2];
	$dataSurveyHours [] = $groups [3];
	$dataReceivedForms [] = $groups [4];
	$dataReportedHours [] = $groups [5];
}

?>