<?php
/**
 *
 * @copyright 2007-2013 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2013-3-27
 */
include_once ("../includes/config.inc.php");

$query = $_REQUEST ['q'];
$callback = $_REQUEST ['callback'];

// start output
if ($callback) {
	// header('Content-Type: text/javascript');
} else {
	// header('Content-Type: application/x-json');
}

switch ($query) {
	case 'daySurveyorTime' :
		$survId = $_GET ['survId'];
		$currMonth = $_GET ['currMonth'];
		$currDay = $_GET ['currDay'];
		$dayTime = $currMonth . "-" . $currDay;
		$startTime = $_GET ['startTime'];
		$startTime = strtotime ( $dayTime . " " . $startTime );
		$endTime = $_GET ['endTime'];
		$endTime = strtotime ( $currMonth . "-" . $currDay . " " . $endTime );
		$dayTimeStart = strtotime ( $currMonth . "-" . $currDay );
		$dayTimeEnd = strtotime ( $currMonth . "-" . $currDay . " 23:59:59" );
		
		$freeTime [] = array (
				"startTime" => $startTime,
				"endTime" => $endTime 
		);
		$busyTime = array ();
		$diff = $startTime - $dayTimeStart;
		if ($diff > 120) 		// 120 = 2 minutes
		{
			$busyTime [] = array (
					"startTime" => $dayTimeStart,
					"endTime" => $startTime 
			);
		}
		$diff = $dayTimeEnd - $endTime;
		if ($diff > 120) 		// 120 = 2 minutes
		{
			$busyTime [] = array (
					"startTime" => $endTime,
					"endTime" => $dayTimeEnd 
			);
		}
		
		$freeSql = "INSERT INTO Survey_SurveyorFreeTime (survId, dayTime, startTime, endTime, isFree) VALUES";
		foreach ( $freeTime as $k => $v ) {
			$freeSql .= "({$survId}, '{$dayTime}', '" . date ( "Y-m-d H:i:s", $v ['startTime'] ) . "', '" . date ( "Y-m-d H:i:s", $v ['endTime'] ) . "', 'free'),";
		}
		$freeSql = substr ( $freeSql, 0, - 1 );
		$db->query ( $freeSql );
		
		$busySql = "INSERT INTO Survey_SurveyorFreeTime (survId, dayTime, startTime, endTime, isFree) VALUES";
		foreach ( $busyTime as $k => $v ) {
			$busySql .= "({$survId}, '{$dayTime}', '" . date ( "Y-m-d H:i:s", $v ['startTime'] ) . "', '" . date ( "Y-m-d H:i:s", $v ['endTime'] ) . "', 'busy'),";
		}
		$busySql = substr ( $busySql, 0, - 1 );
		$db->query ( $busySql );
		// echo $busySql."<br />";
		// var_dump($busyTime);
		
		$message = array (
				'status' => 'success',
				'msg' => '',
				'freeTime' => $freeTime [0] 
		);
		
		// start output
		if ($callback) {
			echo $callback . '(' . json_encode ( $message ) . ');';
		} else {
			echo json_encode ( $message );
		}
		break;
}