<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
include_once ("../includes/config.inc.php");
include_once ("../includes/config.assign.inc.php");

$query = $_REQUEST ['q'];

switch ($query) {
	case "surveyorRejectJob" :
		$ms = new MainSchedule ();
		$msa = new MainScheduleAccess ( $db );
		$ms->jobNoNew = $_REQUEST ['jobNoNew'];
		$rs = $msa->GetListSearch ( $ms );
		$ms = $rs [0];
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
		$sft = new SurveyorFreeTime ();
		$sfta = new SurveyorFreeTimeAccess ( $db );
		$sft->survId = $_REQUEST ['survId'];
		$sft->jobNoNew = $ms->jobNoNew;
		foreach ( $currTime as $v ) {
			$sft->startTime = $v ['startTime'];
			$sft->endTime = $v ['endTime'];
			$sfta->Add ( $sft );
		}
		$message = array (
				'success' => 'true',
				'msg' => 'success.' 
		);
		echo json_encode ( $message );
		break;
	case "unSurveyorRejectJob" :
		$ms = new MainSchedule ();
		$msa = new MainScheduleAccess ( $db );
		$ms->jobNoNew = $_REQUEST ['jobNoNew'];
		$rs = $msa->GetListSearch ( $ms );
		$ms = $rs [0];
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
		$sft = new SurveyorFreeTime ();
		$sfta = new SurveyorFreeTimeAccess ( $db );
		$sft->survId = $_REQUEST ['survId'];
		$sft->jobNoNew = $ms->jobNoNew;
		$sfta->UnAdd ( $sft );
		$message = array (
				'success' => 'true',
				'msg' => 'success.' 
		);
		echo json_encode ( $message );
		break;
	case "surveyorDelFreeTime" :
		$sft = new SurveyorFreeTime ();
		$sfta = new SurveyorFreeTimeAccess ( $db );
		$sft->sftiId = $_REQUEST ['sftiId'];
		$sfta->RealDel ( $sft );
		$message = array (
				'success' => 'true',
				'msg' => 'success.' 
		);
		echo json_encode ( $message );
		break;
}