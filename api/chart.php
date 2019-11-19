<?php
/**
 * about main schedule's me
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2015-01-22
 */
include_once ("../includes/config.inc.php");

$query = $_REQUEST ['q'];

switch ($query)
{
	case 'surveyorform' :
		SurveyorForm($db);
		break;
}

/**
 * 調查表格數及人數對比柱狀圖
 * @param $db
 */
function SurveyorForm($db){
	$plannedSurveyDateStart = $_GET['plannedSurveyDateStart'];
	$plannedSurveyDateEnd = $_GET['plannedSurveyDateEnd'];
	$ddlDistId = $_GET['ddlDistId'];
	$xTmp = DateDiffRange($plannedSurveyDateStart,$plannedSurveyDateEnd);
	$ca = new ChartAccess($db);
	$formTmp = $ca->GetFormCount($ddlDistId,$plannedSurveyDateStart,$plannedSurveyDateEnd);
	$surveyorTmp = $ca->GetSurveyorCount($ddlDistId,$plannedSurveyDateStart,$plannedSurveyDateEnd);
	$xData = array();
	$formData = array();
	$surveyorData = array();
	foreach($xTmp as $v){
		$xData[$v] = date("M d",strtotime($v));
		$formData[$v] = intval($formTmp[$v]);
		$surveyorData[$v] = intval($surveyorTmp[$v]);
	}
	$xData = array_values($xData);
	$formData = array_values($formData);
	$surveyorData = array_values($surveyorData);
	$json = array (
			'success' => 'true',
			'xData' => $xData,
			'formData' => $formData,
			'surveyorData' => $surveyorData
	);
	die(json_encode($json));
}