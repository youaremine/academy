<?php
/*
 * Header: 从main schedule导出周时间表
 * Create: 2016-09-19
 * @Ozzo Technology(HK) LTD
 * Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
$oneDayTime = 86400; // 60*60*24
$oneWeekTime = 604800; // $oneDayTime*7
$survey_start_date = $conf ['survey_start_date'] ['all'];
if ($_GET ['complateJobNo'] != "") {
	$complateJobNo = $_GET ['complateJobNo'];
	$survey_start_date = $conf ['survey_start_date'] [$complateJobNo];
} else {
	print "complateJobNo is NULL";
	exit ();
}
$startTime = strtotime ( $survey_start_date );
$tdNo = $conf ['tdNo'] [$complateJobNo];
// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "main_schedule_week_kln.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "WeekRow", "WeekRows" );
$t->set_block ( "HdIndex", "TabRow", "TabRows" );
$t->set_block ( "HdIndex", "SummaryRow", "SummaryRows" );
$t->set_var ( "Rows", "" );
$t->set_var ( "WeekRows", "" );
$t->set_var ( "TabRows", "" );
$t->set_var ( "SummaryRows", "" );

// 上传SQL文件位置修改时间 mainschedule update time.
$sqlFile = $conf ["path"] ["main_schedule"] . $conf ["file"] ["main_schedule_import_time"];
$currImportTime = "";
if (file_exists ( $sqlFile )) {
	$currImportTime = date ( $conf ['dateTime'] ['format'], filemtime ( $sqlFile ) );
}
$t->set_var ( "currImportTime", $currImportTime );
$t->set_var ( "complateJobNo", $complateJobNo );

$ms = new MainSchedule ();
$msa = new MainScheduleAccess ( $db );
$ms->complateJobNo = $complateJobNo;
$msa->order = " ORDER BY plannedSurveyDate ASC,jobNo ASC,surveyLocation ASC,routeItems ASC";
$maxWeekNo = $msa->GetWeekNo ( $ms );
$weekNo = ceil ( (time () - $startTime) / $oneWeekTime ) + 1;
if ($maxWeekNo < $weekNo)
	$maxWeekNo = $weekNo;
$t->set_var ( "maxWeekNo", $maxWeekNo );
$accuSummary = 0;
$totalOnBoardCost = 0;
for($i = 1; $i <= $maxWeekNo; $i ++) {
	$ms->weekNo = $i;
	// Tab设置
	$t->set_var ( array (
			"tabNo" => $i,
			"districtName" => '',
			"tabFullNo" => sprintf ( "%02d", $i ) 
	) );
	$t->parse ( "TabRows", "TabRow", true );
	// 设置基本参数
	$createDate = date ( $conf ['date'] ['format'] );
	$updateDate = date ( $conf ['date'] ['format'] );
	$currYear = date ( "Y" );
	$weekDateStart = date ( $conf ['date'] ['format'], $startTime + $oneWeekTime * ($i - 1) );
	$weekDateEnd = date ( $conf ['date'] ['format'], $startTime + $oneWeekTime * $i - $oneDayTime );
	$t->set_var ( array (
			"createDate" => $createDate,
			"updateDate" => $updateDate,
			"currYear" => $currYear,
			"weekDateStart" => $weekDateStart,
			"weekDateEnd" => $weekDateEnd,
			"weekNo" => $i,
			"tdNo" => $tdNo 
	) );
	
	$estimatedManHourSummary = 0;
	$onBoardCostSummary = 0;
	$rs = $msa->GetListSearchNoSS ( $ms );
	$rsNo = count ( $rs );
	$mse = new MainSchedule ();
	$mstmp = new MainSchedule ();
	$mstmpl = new MainSchedule ();
	$k = 0;
	$isPrint = false;
	for($j = 0; $j < $rsNo; $j ++) {
		$isPrint = false;
		if ($k % 2 == 0)
			$listStyle = "AlternatingItemStyle";
		else
			$listStyle = "DgItemStyle";
		
		$mse = $rs [$j];
		$mse->onBoardCostHour = $mse->onBoardCostFare * $mse->noOfTrips;
		
		if ($j == 0) {
			$mstmp = $mse;
			$k ++;
		} else if ($j > 0) {
			$msel = $rs [$j - 1];
			// 如果跟一条记录属于同一分类，则继续
			if (strtotime ( $mse->plannedSurveyDate ) == strtotime ( $msel->plannedSurveyDate ) && trim ( $mse->jobNo ) == trim ( $msel->jobNo ) && trim ( $mse->surveyLocation ) == trim ( $msel->surveyLocation ) && trim ( $mse->routeItems ) == trim ( $msel->routeItems )) {
				// 如果时间段已经存在，就不串进来
				$pos = strpos ( $mstmp->surveyTimeHours, $mse->surveyTimeHours );
				if ($pos === false) {
					$mstmp->surveyTimeHours .= ',' . $mse->surveyTimeHours;
				}
				$mstmp->noOfSurveyors += $mse->noOfSurveyors;
				$mstmp->estimatedManHour += $mse->estimatedManHour;
				$mstmp->bonusHours += $mse->bonusHours;
				$mstmp->onBoardCostHour += $mse->onBoardCostHour;
				continue;
			} else {
				// add by james 2014-04-16,request by molly.
				// 讀取main時把ob hr(CT)+bouns hr(Y)計算 另外把TOTEL MAN HR改掉不計算(Y)
				$mstmp->estimatedManHour = round ( $mstmp->estimatedManHour, 1 );
				$mstmp->bonusHours = round ( $mstmp->bonusHours, 1 );
				$mstmp->estimatedManHour -= $mstmp->bonusHours;
				$estimatedManHourSummary += $mstmp->estimatedManHour;
				$accuSummary += $mstmp->estimatedManHour;
				$mstmp->onBoardCostHour = $mstmp->onBoardCostHour / $conf ['feeHour'] [$complateJobNo];
				$mstmp->onBoardCostHour = round ( $mstmp->onBoardCostHour, 1 );
				$mstmp->onBoardCostHour += $mstmp->bonusHours;
				$onBoardCostSummary += $mstmp->onBoardCostHour;
				
				$t->set_var ( array (
						"listStyle" => $listStyle,
						"plannedSurveyDate" => $mstmp->plannedSurveyDate,
						"jobNo" => $mstmp->jobNo,
						"tdFileNo" => $mstmp->tdFileNo,
						"receivedDate" => $mstmp->receivedDate,
						"dueDate" => $mstmp->dueDate,
						"fromTD" => $mstmp->fromTD,
						"surveyTimeHours" => $mstmp->surveyTimeHours,
						"surveyLocation" => $mstmp->surveyLocation,
						"routeItems" => $mstmp->routeItems,
						"direction" => $mstmp->direction,
						"noOfSurveyors" => $mstmp->noOfSurveyors,
						"estimatedManHour" => $mstmp->estimatedManHour,
						"onBoardCostHour" => $mstmp->onBoardCostHour 
				) );
				$t->parse ( "Rows", "Row", true );
				$isPrint = true;
				$mstmpl = $mstmp;
				$mstmp = $mse;
				$k ++;
			}
		}
	}
	
	// 因为要比较，所以最后一次一定要打印一次.不用判断！
	if ($rsNo > 0) {
		// add by james 2014-04-16,request by molly.
		// 讀取main時把ob hr(CT)+bouns hr(Y)計算 另外把TOTEL MAN HR改掉不計算(Y)
		$mstmp->estimatedManHour = round ( $mstmp->estimatedManHour, 1 );
		$mstmp->bonusHours = round ( $mstmp->bonusHours, 1 );
		$mstmp->estimatedManHour -= $mstmp->bonusHours;
		$estimatedManHourSummary += $mstmp->estimatedManHour;
		$accuSummary += $mstmp->estimatedManHour;
		$mstmp->onBoardCostHour = $mstmp->onBoardCostHour / $conf ['feeHour'] [$complateJobNo];
		$mstmp->onBoardCostHour = round ( $mstmp->onBoardCostHour, 1 );
		$mstmp->onBoardCostHour += $mstmp->bonusHours;
		$onBoardCostSummary += $mstmp->onBoardCostHour;
		
		$t->set_var ( array (
				"listStyle" => $listStyle,
				"plannedSurveyDate" => $mstmp->plannedSurveyDate,
				"jobNo" => $mstmp->jobNo,
				"tdFileNo" => $mstmp->tdFileNo,
				"receivedDate" => $mstmp->receivedDate,
				"dueDate" => $mstmp->dueDate,
				"fromTD" => $mstmp->fromTD,
				"surveyTimeHours" => $mstmp->surveyTimeHours,
				"surveyLocation" => $mstmp->surveyLocation,
				"routeItems" => $mstmp->routeItems,
				"direction" => $mstmp->direction,
				"noOfSurveyors" => $mstmp->noOfSurveyors,
				"estimatedManHour" => $mstmp->estimatedManHour,
				"onBoardCostHour" => $mstmp->onBoardCostHour 
		) );
		$t->parse ( "Rows", "Row", true );
	}
	$t->set_var ( "estimatedManHourSummary", $estimatedManHourSummary );
	$t->set_var ( "onBoardCostSummary", $onBoardCostSummary );
	$t->parse ( "WeekRows", "WeekRow", true );
	$t->set_var ( "Rows", "" );
	
	if (($i - 1) % 2 == 0)
		$listStyleSummary = "AlternatingItemStyle";
	else
		$listStyleSummary = "DgItemStyle";
	
	$weekNoSummary = sprintf ( "%02d", $i );
	$remainingHour = $conf ['surveytime'] [$complateJobNo] - $accuSummary - $onBoardCostSummary;
	$t->set_var ( array (
			"listStyleSummary" => $listStyleSummary,
			"weekNoSummary" => $weekNoSummary,
			"districtName" => $conf ['districtName'] [$complateJobNo],
			"estimatedManHourSummary" => $estimatedManHourSummary,
			"accuSummary" => $accuSummary,
			"onBoardCostSummary" => $onBoardCostSummary,
			"remainingHour" => $remainingHour 
	) );
	$t->parse ( "SummaryRows", "SummaryRow", true );
	$accuSummary += $onBoardCostSummary;
}

$t->pparse ( "Output", "HdIndex" );

?>