<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
include_once ("../includes/config.inc.php");

$query = $_REQUEST ['q'];

switch ($query) {
	case "getNoReciveRawData" :
		$ms = new MainSchedule ();
		$msa = new MainScheduleAccess ( $db );
		$ms->plannedSurveyDateEnd = date ( $conf ['date'] ['format'], strtotime ( "+ 1 day" ) );
		$msa->order .= " AND MS.jobNoNew NOT IN (SELECT jobNoNew FROM {$conf['table']['prefix']}MainScheduleRawFile)";
		$msa->order .= " ORDER BY MS.jobNoNew ASC";
		$rs = $msa->GetListSearch ( $ms );
		$arrJobNoNews = array ();
		$i = 0;
		foreach ( $rs as $v ) {
			$arrJobNoNews [$i] = array (
					"districtName" => $conf ['districtName'] [$v->complateJobNo],
					"jobNo" => $v->jobNo,
					"jobNoNew" => $v->jobNoNew,
					"plannedSurveyDate" => $v->plannedSurveyDate 
			);
			$i ++;
		}
		echo json_encode ( $arrJobNoNews );
		break;
	case "getNoFinishedRawData" :
		$msa = new MainScheduleAccess ( $db );
		$rs = $msa->GetNoFinishedRawData ();
		$arrJobNoNews = array ();
		$i = 0;
		foreach ( $rs as $v ) {
			$arrJobNoNews [$i] = array (
					"districtName" => $conf ['districtName'] [$v->complateJobNo],
					"jobNo" => $v->jobNo,
					"jobNoNew" => $v->jobNoNew,
					"plannedSurveyDate" => $v->plannedSurveyDate 
			);
			$i ++;
		}
		echo json_encode ( $arrJobNoNews );
		break;
}

