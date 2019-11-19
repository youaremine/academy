<?php
/*
 * Header: 从main schedule导出周时间表 Create: 2007-3-21 @Ozzo Technology(HK) LTD Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");
include_once ($conf ["path"] ["root"] . "../library/PHPExcel/PHPExcel.php");

$oneDayTime = 86400; // 60*60*24
$oneWeekTime = 604800; // $oneDayTime*7
                       
// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

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
$districtName = $conf ['districtName'] [$complateJobNo];

$fileName = "Weekly_Schedule_" . $shortDistrictName . "_" . date ( "Ymd" ) . ".xls";

// Creating a workbook
$pexcel = new PHPExcel ();
// Rename sheet
$pexcel->getActiveSheet ()->setTitle ( "Summary" );

$pexcel->setActiveSheetIndex ( 0 );
$sheet = $pexcel->getActiveSheet ();

$sheet->getColumnDimension ( 'B' )->setWidth ( 35 );

// 建立一个统计表格
$rowSummary = 2;
$sheet->setCellValue ( "A{$rowSummary}", "Man Hours Used in TD's Record vs Progress Report Record" );

$rowSummary = $rowSummary + 1;
$sheet->setCellValue ( "A{$rowSummary}", "Week No" );
$sheet->setCellValue ( "C{$rowSummary}", "TD's Record" );

$rowSummary = $rowSummary + 1;
$sheet->getRowDimension ( $rowSummary )->setRowHeight ( 40 );
$sheet->setCellValue ( "B{$rowSummary}", $districtName . " Week" );
$sheet->setCellValue ( "C{$rowSummary}", $districtName );
$sheet->setCellValue ( "D{$rowSummary}", "Accu." );
$sheet->setCellValue ( "E{$rowSummary}", "approx. On board Fare" );
$sheet->setCellValue ( "F{$rowSummary}", "remaining hours" );

// 上传SQL文件位置修改时间 mainschedule update time.
$sqlFile = "../survey/" . $conf ["path"] ["main_schedule"] . $conf ["file"] ["main_schedule_sql"];
$currImportTime = "";
if (file_exists ( $sqlFile )) {
	$currImportTime = date ( $conf ['dateTime'] ['format'], filemtime ( $sqlFile ) );
}

// 设置列表数据
$ms = new MainSchedule ();
$msa = new MainScheduleAccess ( $db );
$ms->complateJobNo = $complateJobNo;
$msa->order = " ORDER BY plannedSurveyDate ASC,jobNo ASC,surveyLocation ASC,routeItems ASC";
$maxWeekNo = $msa->GetWeekNo ( $ms );
$weekNo = ceil ( (time () - $startTime) / $oneWeekTime ) + 1;
if ($maxWeekNo < $weekNo)
	$maxWeekNo = $weekNo;
$accuSummary = 0;
for($i = 1; $i <= $maxWeekNo; $i ++) {
	// 建立一个工作表
	$pexcel->createSheet ();
	$pexcel->setActiveSheetIndex ( $i );
	$sheet = $pexcel->getActiveSheet ();
	$sheet->setTitle ( $districtName . '-Week' . sprintf ( "%02d", $i ) );
	
	// 设置最基本数据开始
	$createDate = date ( $conf ['date'] ['format'] );
	$updateDate = date ( $conf ['date'] ['format'] );
	$currYear = date ( "Y" );
	$weekDateStart = date ( $conf ['date'] ['format'], $startTime + $oneWeekTime * ($i - 1) );
	$weekDateEnd = date ( $conf ['date'] ['format'], $startTime + $oneWeekTime * $i - $oneDayTime );
	$row = 1;
	$sheet->setCellValue ( "A{$row}", "Week No:" );
	$sheet->setCellValue ( "B{$row}", $i );
	$sheet->setCellValue ( "C{$row}", $weekDateStart );
	$sheet->setCellValue ( "D{$row}", $weekDateEnd );
	
	$row = 4;
	$sheet->setCellValue ( "A{$row}", "Created Date:" );
	$sheet->setCellValue ( "B{$row}", $updateDate );
	
	$row = $row + 1;
	$sheet->setCellValue ( "A{$row}", "Updated Date:" );
	$sheet->setCellValue ( "B{$row}", $updateDate );
	
	$row = $row + 1;
	$sheet->mergeCells ( "A{$row}:L{$row}" );
	$sheet->setCellValue ( "A{$row}", $tdNo . "/" . $currYear . " Scheduled Survey on Week " . $i . " (" . $weekDateStart . " to " . $weekDateEnd . ")" );
	
	$row = $row + 1;
	$sheet->setCellValue ( "A{$row}", "Planned Survey Date" );
	$sheet->setCellValue ( "B{$row}", "Request Form No." );
	$sheet->setCellValue ( "C{$row}", "TD File No." );
	$sheet->setCellValue ( "D{$row}", "Received Date" );
	$sheet->setCellValue ( "E{$row}", "Due Date" );
	$sheet->setCellValue ( "F{$row}", "From (TD)" );
	$sheet->setCellValue ( "G{$row}", "Survey Time (Hours)" );
	$sheet->setCellValue ( "H{$row}", "Survey Location" );
	$sheet->setCellValue ( "I{$row}", "Route / Items" );
	$sheet->setCellValue ( "J{$row}", "No. of Surveyors" );
	$sheet->setCellValue ( "K{$row}", "Estimated Man-hour" );
	$sheet->setCellValue ( "L{$row}", "On Board Hour" );
	
	// 设置最基本数据结束
	$estimatedManHourSummary = 0;
	$onBoardCostSummary = 0;
	$ms->weekNo = $i;
	$rs = $msa->GetListSearchNoSS ( $ms );
	$rsNo = count ( $rs );
	$mse = new MainSchedule ();
	$mstmp = new MainSchedule ();
	$mstmpl = new MainSchedule ();
	$k = 0;
	for($j = 0; $j < $rsNo; $j ++) {
		$mse = $rs [$j];
		$estimatedManHourSummary += $mse->estimatedManHour;
		$accuSummary += $mse->estimatedManHour;
		$onBoardCostSummary += $mse->onBoardCostFare * $mse->noOfTrips;
		$mse->onBoardCostHour += ($mse->onBoardCostFare * $mse->noOfTrips) / $conf ['feeHour'] [$mse->complateJobNo];
		if ($j == 0) {
			$mstmp = $mse;
			$k ++;
		} else if ($j > 0) {
			$msel = $rs [$j - 1];
			// 如果跟一条记录属于同一分类，则继续
			if (strtotime ( $mse->plannedSurveyDate ) == strtotime ( $msel->plannedSurveyDate ) && trim ( $mse->jobNo ) == trim ( $msel->jobNo ) && trim ( $mse->surveyLocation ) == trim ( $msel->surveyLocation ) && trim ( $mse->routeItems ) == trim ( $msel->routeItems )) {
				$mstmp->surveyTimeHours .= ',' . $mse->surveyTimeHours;
				$mstmp->noOfSurveyors += $mse->noOfSurveyors;
				$mstmp->estimatedManHour += $mse->estimatedManHour;
				continue;
			} else {
				$plannedSurveyDate = $mstmp->plannedSurveyDate;
				$jobNo = $mstmp->jobNo;
				// //如果跟上一个时间相同，则不显示时间
				// if(strtotime($mstmp->plannedSurveyDate) == strtotime($mstmpl->plannedSurveyDate))
				// {
				// $plannedSurveyDate = "";
				// }
				// //如果job号码跟上一个相同，也不显示
				// if(trim($mstmp->jobNo) == trim($mstmpl->jobNo))
				// {
				// $jobNo = "";
				// }
				// 数据列表资料
				$row = $row + 1;
				$sheet->setCellValue ( "A{$row}", $plannedSurveyDate );
				$sheet->setCellValue ( "B{$row}", $jobNo );
				$sheet->setCellValue ( "C{$row}", $mstmp->tdFileNo );
				$sheet->setCellValue ( "D{$row}", $mstmp->receivedDate );
				$sheet->setCellValue ( "E{$row}", $mstmp->dueDate );
				$sheet->setCellValue ( "F{$row}", $mstmp->fromTD );
				$sheet->setCellValue ( "G{$row}", $mstmp->surveyTimeHours );
				$sheet->setCellValue ( "H{$row}", $mstmp->surveyLocation );
				$sheet->setCellValue ( "I{$row}", $mstmp->routeItems );
				$sheet->setCellValue ( "J{$row}", $mstmp->noOfSurveyors );
				$sheet->setCellValue ( "K{$row}", round ( $mstmp->estimatedManHour, 1 ) );
				$sheet->setCellValue ( "L{$row}", round ( $mstmp->onBoardCostHour, 1 ) );
				
				$mstmpl = $mstmp;
				$mstmp = $mse;
				$k ++;
			}
		}
	}
	
	// 因为要比较，所以最后一次一定要打印一次.不用判断！
	if ($rsNo > 0) {
		$row = $row + 1;
		$plannedSurveyDate = $mstmp->plannedSurveyDate;
		$sheet->setCellValue ( "A{$row}", $plannedSurveyDate );
		$sheet->setCellValue ( "B{$row}", $mstmp->jobNo );
		$sheet->setCellValue ( "C{$row}", $mstmp->tdFileNo );
		$sheet->setCellValue ( "D{$row}", $mstmp->receivedDate );
		$sheet->setCellValue ( "E{$row}", $mstmp->dueDate );
		$sheet->setCellValue ( "F{$row}", $mstmp->fromTD );
		$sheet->setCellValue ( "G{$row}", $mstmp->surveyTimeHours );
		$sheet->setCellValue ( "H{$row}", $mstmp->surveyLocation );
		$sheet->setCellValue ( "I{$row}", $mstmp->routeItems );
		$sheet->setCellValue ( "J{$row}", $mstmp->noOfSurveyors );
		$sheet->setCellValue ( "K{$row}", round ( $mstmp->estimatedManHour, 1 ) );
		$sheet->setCellValue ( "L{$row}", round ( $mstmp->onBoardCostHour, 1 ) );
	}
	// 小结
	$estimatedManHourSummary = round ( $estimatedManHourSummary, 1 );
	$row = $row + 1;
	$sheet->setCellValue ( "J{$row}", "Total Manhour Used in this Week" );
	$sheet->setCellValue ( "K{$row}", $estimatedManHourSummary );
	// 设置统计表格
	$onBoardCostSummary = $onBoardCostSummary / $conf ['feeHour'] [$complateJobNo];
	$onBoardCostSummary = round ( $onBoardCostSummary, 1 );
	$totalOnBoardCost += $onBoardCostSummary;
	$accuSummary = round ( $accuSummary, 1 );
	$remainingHour = $conf ['surveytime'] [$complateJobNo] - $accuSummary - $totalOnBoardCost;
	$remainingHour = round ( $remainingHour, 1 );
	$pexcel->setActiveSheetIndex ( 0 );
	$sheet = $pexcel->getActiveSheet ();
	$rowSummary = $rowSummary + 1;
	$sheet->setCellValue ( "A{$rowSummary}", "Week" . $i );
	$sheet->setCellValue ( "B{$rowSummary}", $districtName . "-Week" . sprintf ( "%02d", $i ) );
	$sheet->setCellValue ( "C{$rowSummary}", round ( $estimatedManHourSummary, 1 ) ); //
	$sheet->setCellValue ( "D{$rowSummary}", round ( $accuSummary, 1 ) ); // Accu.
	$sheet->setCellValue ( "E{$rowSummary}", round ( $onBoardCostSummary, 1 ) ); // approx. On board Fare
	$sheet->setCellValue ( "F{$rowSummary}", round ( $remainingHour, 1 ) ); // remaining hours
}

// set page size and orientation
$sheet->getPageSetup ()->setOrientation ( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );
$sheet->getPageSetup ()->setPaperSize ( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4 );

$pexcel->setActiveSheetIndex ( 0 );

// Redirect output to a clients web browser (Excel5)
header ( 'Content-Type: application/vnd.ms-excel; charset=utf-8' );
header ( "Content-Disposition: attachment;filename=" . $fileName );
header ( 'Cache-Control: max-age=0' );
$objWriter = PHPExcel_IOFactory::createWriter ( $pexcel, 'Excel5' );
$objWriter->save ( 'php://output' );
exit ();
