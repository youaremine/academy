<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
include_once ("../includes/config.inc.php");
include_once ($conf ["path"] ["root"] . "../library/PHPExcel/PHPExcel.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$ms = new MainSchedule ();
$msa = new MainScheduleAccess ( $db );

$ms->jobNoNew = $_REQUEST ['jobNoNew'];

$rs = $msa->GetListSearch ( $ms );
$rsNum = count ( $rs );
if ($rsNum > 0) {
	$ms = $rs [0];
	$routes = explode ( ",", $ms->routeItems );
	if (! is_array ( $routes )) {
		$routes = array (
				0 => $ms->routeItems 
		);
	} else {
		$routesNum = count ( $routes );
		if ($routesNum == 1) {
			$routes [1] = $routes [0];
		} else if ($routesNum > 2) {
			$routes [0] = $routes [1] = '';
		}
		// 最後一頁不顯示路線號碼
		$routes [2] = $routes [3] = '';
	}
	// 假設最多4部車
	if ($ms->surveyLocation == $ms->surveyLocationCn)
		$ms->surveyLocation = "";
} else {
	exit ( "Not found this ref no.:{$ms->jobNoNew}." );
}

$ms->surveyType = strtolower ( trim ( $ms->surveyType ) );
$ms->vehicle = strtoupper ( trim ( $ms->vehicle ) );
$fileKey = "bus";
switch ($ms->surveyType) {
	case "monitoring survey" :
	case "screenline survey" :
	case "terminal survey" :
		switch ($ms->vehicle) {
			case "UBS" :
				$fileKey = "rs";
				break;
			case "GMB" :
			case "RMB" :
				$fileKey = "gmb";
				break;
			case "KMB" :
			case "NWFB" :
			case "CTB" :
			case "LWB" :
				$fileKey = "bus";
				break;
		}
}
if (empty ( $fileKey )) {
	exit ( "Not found this survey type excel template." );
} else {
	include ("survey_form_to_excel_{$fileKey}.php");
}