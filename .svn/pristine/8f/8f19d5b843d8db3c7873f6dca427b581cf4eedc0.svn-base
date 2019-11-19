<?php
/*
 * Header: 从main schedule导出周时间表 Create: 2007-3-21 @Ozzo Technology(HK) LTD Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");
include_once ($conf ["path"] ["root"] . "../library/PHPExcel/PHPExcel.php");
include_once ("./main_schedule_week_to_excel_style.php");

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

$defaultStyle = new PHPExcel_Style ();
$defaultStyle->getFont ()->setName ( 'Arial' );
$defaultStyle->getFont ()->setSize ( 10 );

$pexcel->setActiveSheetIndex ( 0 );
$sheet = $pexcel->getActiveSheet ();

$sheet->setDefaultStyle ( $defaultStyle );
$sheet->getDefaultStyle ()->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
$sheet->getDefaultStyle ()->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );

// Rename sheet
$pexcel->getActiveSheet ()->setTitle ( "Summary" );

$sheet->getColumnDimension ( 'D' )->setWidth ( 12 );

// 建立一个统计表格
$rowSummary = 2;
$sheet->getStyle ( "A{$rowSummary}" )->applyFromArray ( $titleStyle );
$sheet->setCellValue ( "A{$rowSummary}", "Man Hours Used in TD's Record vs Progress Report Record" );

$rowSummary = $rowSummary + 1;

$rowSummary = $rowSummary + 1;
$sheet->mergeCells ( "A" . $rowSummary . ":A" . ($rowSummary + 1) );

$sheet->getStyle ( "A{$rowSummary}:C{$rowSummary}" )->applyFromArray ( $ltThinStyle, false );
$sheet->getStyle ( "D{$rowSummary}" )->applyFromArray ( $ltrThinStyle );
$sheet->getStyle ( "B{$rowSummary}:C{$rowSummary}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS );
$sheet->getStyle ( "A{$rowSummary}:D{$rowSummary}" )->getFont ()->setBold ( true );

$sheet->setCellValue ( "A{$rowSummary}", "Week No" );
$sheet->setCellValue ( "C{$rowSummary}", "TD's Record" );

$rowSummary = $rowSummary + 1;
$sheet->getStyle ( "D{$rowSummary}" )->applyFromArray ( $ltrThinStyle );
$sheet->getStyle ( "A{$rowSummary}:C{$rowSummary}" )->applyFromArray ( $ltThinStyle, false );
$sheet->getStyle ( "A{$rowSummary}:D{$rowSummary}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "A{$rowSummary}:D{$rowSummary}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "B{$rowSummary}:D{$rowSummary}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "B{$rowSummary}:D{$rowSummary}" )->getAlignment ()->setWrapText ( true );
$sheet->getStyle ( 'A' . ($rowSummary - 1) . ":D" . $rowSummary )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
$sheet->getStyle ( 'A' . ($rowSummary - 1) . ":D" . $rowSummary )->getFill ()->getStartColor ()->setARGB ( 'FFFFFF00' );

$sheet->getRowDimension ( $rowSummary )->setRowHeight ( 48 );
$sheet->setCellValue ( "B{$rowSummary}", $districtName );
$sheet->setCellValue ( "C{$rowSummary}", "Accu." );
$sheet->setCellValue ( "D{$rowSummary}", "Remaining hours" );

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
	// $maxWeekNo = 3;
$accuSummary = 0;
for($i = 1; $i <= $maxWeekNo; $i ++) {
	// 建立一个工作表
	$pexcel->createSheet ();
	$pexcel->setActiveSheetIndex ( $i );
	$sheet = $pexcel->getActiveSheet ();
	$sheet->setTitle ( $districtName . '-Week' . sprintf ( "%02d", $i ) );
	
	// 設置寬度
	$sheet->getColumnDimension ( 'A' )->setWidth ( 16 );
	$sheet->getColumnDimension ( 'B' )->setWidth ( 13 );
	$sheet->getColumnDimension ( 'C' )->setWidth ( 18 );
	$sheet->getColumnDimension ( 'D' )->setWidth ( 16 );
	$sheet->getColumnDimension ( 'E' )->setWidth ( 16 );
	$sheet->getColumnDimension ( 'F' )->setWidth ( 13 );
	$sheet->getColumnDimension ( 'G' )->setWidth ( 23 );
	$sheet->getColumnDimension ( 'H' )->setWidth ( 39 );
	$sheet->getColumnDimension ( 'I' )->setWidth ( 15 );
	$sheet->getColumnDimension ( 'J' )->setWidth ( 13 );
	$sheet->getColumnDimension ( 'K' )->setWidth ( 13 );
	$sheet->getColumnDimension ( 'L' )->setWidth ( 19 );
	$sheet->getColumnDimension ( 'M' )->setWidth ( 13 );
	
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
	
	$row = 5;
	$sheet->setCellValue ( "A{$row}", "Updated Date:" );
	$sheet->setCellValue ( "B{$row}", $updateDate );
	
	$row = 6;
	
	$row = 7;
	$sheet->getStyle ( 'A' . $row )->applyFromArray ( $titleStyle );
	
	$sheet->setCellValue ( "A{$row}", $tdNo . "/" . $currYear . " Scheduled Survey on Week " . $i );
	
	$row = 8;
	$sheet->getStyle ( "A{$row}:M{$row}" )->applyFromArray ( $bStyle );
	
	$row = 9;
	$sheet->getStyle ( "A{$row}:L{$row}" )->applyFromArray ( $ltThinStyle, false );
	$sheet->getStyle ( 'M' . $row )->applyFromArray ( $ltrThinStyle );
	$sheet->getRowDimension ( $row )->setRowHeight ( 33 );
	$sheet->getStyle ( "A{$row}:M{$row}" )->getAlignment ()->setWrapText ( true );
	$sheet->getStyle ( "A{$row}:M{$row}" )->getFont ()->setBold ( true );
	$sheet->getStyle ( "A{$row}:M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	$sheet->getStyle ( "A{$row}:M{$row}" )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
	$sheet->getStyle ( "A{$row}:M{$row}" )->getFill ()->getStartColor ()->setARGB ( 'FFFFFF00' );
	
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
	$sheet->setCellValue ( "L{$row}", "Surveyor Name" );
	$sheet->setCellValue ( "M{$row}", "Contact No." );
	
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
		$mse->estimatedManHour = round ( $mse->estimatedManHour, 1 );
		$estimatedManHourSummary += $mse->estimatedManHour;
		$accuSummary += $mse->estimatedManHour;
		
		$mse->onBoardCostHour = ($mse->onBoardCostFare * $mse->noOfTrips) / $conf ['feeHour'] [$mse->complateJobNo];
		$mse->onBoardCostHour = round ( $mse->onBoardCostHour, 1 );
		
		$onBoardCostSummary += $mse->onBoardCostHour;
		
		if ($j == 0) {
			$mstmp = $mse;
			$k ++;
		} else if ($j > 0) {
			$msel = $rs [$j - 1];
			// 如果跟一条记录属于同一分类，则继续
			if (trim($mse->surveyType) == trim($msel->surveyType)
                && strtotime($mse->plannedSurveyDate) == strtotime($msel->plannedSurveyDate)
                && trim ( $mse->jobNo ) == trim ( $msel->jobNo )
                && trim ( $mse->surveyLocation ) == trim ( $msel->surveyLocation )
                && trim ( $mse->routeItems ) == trim ( $msel->routeItems )) {
				$mstmp->surveyTimeHours .= ',' . $mse->surveyTimeHours;
				$mstmp->noOfSurveyors += $mse->noOfSurveyors;
				$mstmp->estimatedManHour += $mse->estimatedManHour;
				$mstmp->onBoardCostHour += $mse->onBoardCostHour;
				continue;
			} else {
				$row = $row + 1;
				$sheet->getStyle ( "A{$row}:L{$row}" )->applyFromArray ( $ltThinStyle, false );
				$sheet->getStyle ( 'M' . $row )->applyFromArray ( $ltrThinStyle );
				$sheet->getStyle ( "A{$row}:M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
				// 如果跟上一个时间相同，则时间變白色
				if (strtotime ( $mstmp->plannedSurveyDate ) == strtotime ( $mstmpl->plannedSurveyDate )) {
					$sheet->getStyle ( "A{$row}" )->applyFromArray ( $whiteFontStyle );
				}
				// 如果job号码跟上一个相同，則字體變白色
				if (trim ( $mstmp->jobNo ) == trim ( $mstmpl->jobNo )) {
					$sheet->getStyle ( "B{$row}" )->applyFromArray ( $whiteFontStyle );
				}
				if (empty ( $mstmp->dueDate ))
					$mstmp->dueDate = "-";
				
				$sheet->setCellValue ( "A{$row}", $mstmp->plannedSurveyDate );
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
				$sheet->setCellValue ( "L{$row}", $mstmp->surveyorName );
				$sheet->setCellValue ( "M{$row}", $mstmp->surveyorTelephone );
				
				$mstmpl = $mstmp;
				$mstmp = $mse;
				$k ++;
			}
		}
	}
	
	// 因为要比较，所以最后一次一定要打印一次.不用判断！
	if ($rsNo > 0) {
		$row = $row + 1;
		$sheet->getStyle ( "A{$row}:L{$row}" )->applyFromArray ( $ltThinStyle, false );
		$sheet->getStyle ( "M{$row}" )->applyFromArray ( $ltrThinStyle );
		$sheet->getStyle ( "A{$row}:M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
		// 如果跟上一个时间相同，则时间變白色
		if (strtotime ( $mstmp->plannedSurveyDate ) == strtotime ( $mstmpl->plannedSurveyDate )) {
			$sheet->getStyle ( "A{$row}" )->applyFromArray ( $whiteFontStyle );
		}
		// 如果job号码跟上一个相同，則字體變白色
		if (trim ( $mstmp->jobNo ) == trim ( $mstmpl->jobNo )) {
			$sheet->getStyle ( "B{$row}" )->applyFromArray ( $whiteFontStyle );
		}
		if (empty ( $mstmp->dueDate ))
			$mstmp->dueDate = "-";
		
		$sheet->setCellValue ( "A{$row}", $mstmp->plannedSurveyDate );
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
		$sheet->setCellValue ( "L{$row}", $mstmp->surveyorName );
		$sheet->setCellValue ( "M{$row}", $mstmp->surveyorTelephone );
	}
	
	// 小结
	$estimatedManHourSummary = round ( $estimatedManHourSummary, 1 );
	$row = $row + 1;
	$sheet->getStyle ( "A{$row}" )->applyFromArray ( $ltThinStyle );
	$sheet->getStyle ( "B{$row}:I{$row}" )->applyFromArray ( $tThinStyle, false );
	$sheet->getStyle ( "J{$row}:L{$row}" )->applyFromArray ( $ltThinStyle, false );
	$sheet->getStyle ( "M{$row}" )->applyFromArray ( $ltrThinStyle );
	$sheet->getStyle ( "J{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
	$sheet->getStyle ( "J{$row}" )->getFont ()->setBold ( true );
	$sheet->getStyle ( "K{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	
	$sheet->setCellValue ( "J{$row}", "Total Manhour Used in this Week" );
	$sheet->setCellValue ( "K{$row}", $estimatedManHourSummary );
	
	$row = $row + 1;
	$sheet->getStyle ( "A{$row}:M{$row}" )->applyFromArray ( $tThinStyle, false );
	
	// zoom to see
	$sheet->getSheetView ()->setZoomScale ( 90 );
	// set print scale
	$sheet->getPageSetup ()->setScale ( 58 );
	// set print area
	$sheet->getPageSetup ()->setPrintArea ( "A1:M{$row}" );
	// set page size and orientation
	$sheet->getPageSetup ()->setOrientation ( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );
	$sheet->getPageSetup ()->setPaperSize ( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4 );
	
	// 设置统计表格
	$remainingHour = $conf ['surveytime'] [$complateJobNo] - $accuSummary - $totalOnBoardCost;
	
	$pexcel->setActiveSheetIndex ( 0 );
	$sheet = $pexcel->getActiveSheet ();
	
	$rowSummary = $rowSummary + 1;
	$sheet->getStyle ( "A{$rowSummary}:C{$rowSummary}" )->applyFromArray ( $ltThinStyle, false );
	$sheet->getStyle ( "D{$rowSummary}" )->applyFromArray ( $ltrThinStyle );
	$sheet->getStyle ( "A{$rowSummary}:D{$rowSummary}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	// $sheet->getStyle("A{$rowSummary}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
	
	$weekNo = sprintf ( "%02d", $i );
	// $sheet->setCellValue("A{$rowSummary}", $weekNo);
	$sheet->getCell ( "A{$rowSummary}" )->setValueExplicit ( $weekNo, PHPExcel_Cell_DataType::TYPE_STRING );
	$sheet->setCellValue ( "B{$rowSummary}", $estimatedManHourSummary ); //
	$sheet->setCellValue ( "C{$rowSummary}", $accuSummary ); // Accu.
	$sheet->setCellValue ( "D{$rowSummary}", $remainingHour ); // remaining hours
	
	$accuSummary += $onBoardCostSummary;
}
$rowSummary = $rowSummary + 1;
$sheet->getStyle ( "A{$rowSummary}:D{$rowSummary}" )->applyFromArray ( $tThinStyle, false );

// zoom to see
// $sheet->getSheetView()->setZoomScale(90);
// set print scale
// $sheet->getPageSetup()->setScale(68);
// set print area
$sheet->getPageSetup ()->setPrintArea ( "A1:D{$rowSummary}" );

// set page size and orientation
$sheet->getPageSetup ()->setOrientation ( PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT );
$sheet->getPageSetup ()->setPaperSize ( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4 );

$pexcel->setActiveSheetIndex ( 0 );

// Redirect output to a clients web browser (Excel5)
header ( 'Content-Type: application/vnd.ms-excel; charset=utf-8' );
header ( "Content-Disposition: attachment;filename=" . $fileName );
header ( 'Cache-Control: max-age=0' );
$objWriter = PHPExcel_IOFactory::createWriter ( $pexcel, 'Excel5' );
$objWriter->save ( 'php://output' );
exit ();
