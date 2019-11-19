<?php
/*
 * Header: 从main schedule导出周时间表 Create: 2007-3-21 @Ozzo Technology(HK) LTD Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");
include_once ($conf["path"]["root"] . "../library/PHPExcel/PHPExcel.php");
include_once ("./main_schedule_week_to_excel_style.php");
ini_set('max_execution_time','120');

$oneDayTime = 86400; // 60*60*24
$oneWeekTime = 604800; // $oneDayTime*7
                       
// 检查是否登录
if(! UserLogin::IsLogin()){
	header("Location:login.php");
	exit();
}

$survey_start_date = $conf['survey_start_date']['all'];
if($_GET['complateJobNo'] != ""){
	$complateJobNo = $_GET['complateJobNo'];
	$survey_start_date = $conf['survey_start_date'][$complateJobNo];
}else{
	print "complateJobNo is NULL";
	exit();
}
$startTime = strtotime($survey_start_date);
$tdNo = $conf['tdNo'][$complateJobNo];
$districtName = $conf['districtName'][$complateJobNo];

$fileName = "Weekly_Schedule_" . $shortDistrictName . "_" . date("Ymd") . ".xls";

// Creating a workbook
$pexcel = new PHPExcel();

$defaultStyle = new PHPExcel_Style();
$defaultStyle->getFont()->setName('Arial');
$defaultStyle->getFont()->setSize(10);

$pexcel->setActiveSheetIndex(0);
$sheet = $pexcel->getActiveSheet();

$sheet->setDefaultStyle($defaultStyle);
$sheet->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$sheet->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

// Rename sheet
$sheet->setTitle("Summary");

$sheet->getColumnDimension('E')->setWidth(12);

// 建立一个统计表格
$rowSummary = 2;
$sheet->getStyle("A{$rowSummary}")->applyFromArray($titleStyle);

$sheet->setCellValue("A{$rowSummary}","Man Hours Used in TD's Record vs Progress Report Record");

$rowSummary = $rowSummary + 1;

$rowSummary = $rowSummary + 1;
$sheet->mergeCells("A" . $rowSummary . ":A" . ($rowSummary + 1));

$sheet->getStyle("A{$rowSummary}:D{$rowSummary}")->applyFromArray($ltThinStyle,false);
$sheet->getStyle("E{$rowSummary}")->applyFromArray($ltrThinStyle);
$sheet->getStyle("B{$rowSummary}:E{$rowSummary}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS);
$sheet->getStyle("A{$rowSummary}:E{$rowSummary}")->getFont()->setBold(true);

$sheet->setCellValue("A{$rowSummary}","Week No");
$sheet->setCellValue("B{$rowSummary}","TD's Record");

$rowSummary = $rowSummary + 1;

$sheet->getStyle("E{$rowSummary}")->applyFromArray($ltrThinStyle);
$sheet->getStyle("A{$rowSummary}:D{$rowSummary}")->applyFromArray($ltThinStyle,false);
$sheet->getStyle("A{$rowSummary}:E{$rowSummary}")->getFont()->setBold(true);
$sheet->getStyle("A{$rowSummary}:E{$rowSummary}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle("B{$rowSummary}:E{$rowSummary}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->getStyle("B{$rowSummary}:E{$rowSummary}")->getAlignment()->setWrapText(true);
$sheet->getStyle('A' . ($rowSummary - 1) . ":E" . $rowSummary)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$sheet->getStyle('A' . ($rowSummary - 1) . ":E" . $rowSummary)->getFill()->getStartColor()->setARGB('FFFFFF00');

$sheet->getRowDimension($rowSummary)->setRowHeight(48);
$sheet->setCellValue("B{$rowSummary}",$districtName);
$sheet->setCellValue("C{$rowSummary}","Accu.");
$sheet->setCellValue("D{$rowSummary}","On Board Cost");
$sheet->setCellValue("E{$rowSummary}","Remaining hours");

// 上传SQL文件位置修改时间 mainschedule update time.
$sqlFile = "../survey/" . $conf["path"]["main_schedule"] . $conf["file"]["main_schedule_sql"];
$currImportTime = "";
if(file_exists($sqlFile)){
	$currImportTime = date($conf['dateTime']['format'],filemtime($sqlFile));
}

// 设置列表数据
$ms = new MainSchedule();
$msa = new MainScheduleAccess($db);
$ms->complateJobNo = $complateJobNo;
$msa->order = " ORDER BY plannedSurveyDate ASC,jobNo ASC,surveyLocation ASC,routeItems ASC";
$maxWeekNo = $msa->GetWeekNo($ms);
$weekNo = ceil((time() - $startTime) / $oneWeekTime) + 1;
if($maxWeekNo < $weekNo)
	$maxWeekNo = $weekNo;
$accuSummary = 0;
for($i = 1;$i <= $maxWeekNo;$i ++){
	// 建立一个工作表
	$pexcel->createSheet();
	$pexcel->setActiveSheetIndex($i);
	$sheet = $pexcel->getActiveSheet();
	$sheet->setTitle($districtName . '-Week' . sprintf("%02d",$i));
	
	// 設置寬度
	$sheet->getColumnDimension('A')->setWidth(16);
	$sheet->getColumnDimension('B')->setWidth(13);
	$sheet->getColumnDimension('C')->setWidth(18);
	$sheet->getColumnDimension('D')->setWidth(16);
	$sheet->getColumnDimension('E')->setWidth(16);
	$sheet->getColumnDimension('F')->setWidth(13);
	$sheet->getColumnDimension('G')->setWidth(13);
    $sheet->getColumnDimension('H')->setWidth(18);
	$sheet->getColumnDimension('I')->setWidth(39);
	$sheet->getColumnDimension('J')->setWidth(15);
	$sheet->getColumnDimension('K')->setWidth(15);
	$sheet->getColumnDimension('L')->setWidth(13);
	$sheet->getColumnDimension('M')->setWidth(13);

	
	// 设置最基本数据开始
	$createDate = date($conf['date']['format']);
	$updateDate = date($conf['date']['format']);
	$currYear = date("Y");
	$weekDateStart = date($conf['date']['format'],$startTime + $oneWeekTime * ($i - 1));
	$weekDateEnd = date($conf['date']['format'],$startTime + $oneWeekTime * $i - $oneDayTime);
	
	$row = 1;
	$sheet->setCellValue("A{$row}","Week No:");
	$sheet->setCellValue("B{$row}",$i);
	$sheet->setCellValue("C{$row}",$weekDateStart);
	$sheet->setCellValue("D{$row}",$weekDateEnd);
	
	$row = 4;
	$sheet->setCellValue("A{$row}","Created Date:");
	$sheet->setCellValue("B{$row}",$updateDate);
	
	$row = 5;
	$sheet->setCellValue("A{$row}","Updated Date:");
	$sheet->setCellValue("B{$row}",$updateDate);
	
	$row = 6;
	
	$row = 7;
	$sheet->getStyle('A' . $row)->applyFromArray($titleStyle);
	
	$sheet->setCellValue("A{$row}",$tdNo . "/" . $currYear . " Scheduled Survey on Week " . $i);
	
	$row = 8;
	$sheet->getStyle("A{$row}:N{$row}")->applyFromArray($bStyle);
	
	$row = 9;
	// $sheet->getStyle('A'.$row)->applyFromArray($ltStyle);
	$sheet->getStyle("A{$row}:L{$row}")->applyFromArray($ltThinStyle,false);
	$sheet->getStyle('N' . $row)->applyFromArray($ltrThinStyle);
	$sheet->getRowDimension($row)->setRowHeight(33);
	$sheet->getStyle("A{$row}:N{$row}")->getAlignment()->setWrapText(true);
	$sheet->getStyle("A{$row}:N{$row}")->getFont()->setBold(true);
	$sheet->getStyle("A{$row}:N{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	$sheet->getStyle("A{$row}:N{$row}")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$sheet->getStyle("A{$row}:N{$row}")->getFill()->getStartColor()->setARGB('FFFFFF00');
	
	$sheet->setCellValue("A{$row}","Planned Survey Date");
	$sheet->setCellValue("B{$row}","Request Form No.");
	$sheet->setCellValue("C{$row}","TD File No.");
	$sheet->setCellValue("D{$row}","Received Date");
	$sheet->setCellValue("E{$row}","Due Date");
	$sheet->setCellValue("F{$row}","From (TD)");
	$sheet->setCellValue("G{$row}","Survey Time (Hours)");
    $sheet->setCellValue("H{$row}","Survey Type");
	$sheet->setCellValue("I{$row}","Survey Location");
	$sheet->setCellValue("J{$row}","Route / Items");
	$sheet->setCellValue("K{$row}","Direction");
	$sheet->setCellValue("L{$row}","No. of Surveyors");
	$sheet->setCellValue("M{$row}","Estimated Man-hour");
	$sheet->setCellValue("N{$row}","On Board Hour");
	
	// 设置最基本数据结束
	$estimatedManHourSummary = 0;
	$onBoardCostSummary = 0;
	$bonusHoursSummary = 0;
	$ms->weekNo = $i;
	$rs = $msa->GetListSearchNoSS($ms);
	$rsNo = count($rs);
	$mse = new MainSchedule();
	$mstmp = new MainSchedule();
	$mstmpl = new MainSchedule();
	$k = 0;
	for($j = 0;$j < $rsNo;$j ++){
		$mse = $rs[$j];
		$mse->onBoardCostHour = $mse->onBoardCostFare * $mse->noOfTrips;
//        //request by molly
//        //跟最後一程車,即使超过了1分钟也按超过30分钟计算;
//        if($mse->surveyType=='On board survey'){
//            $diffHour = $mse->estimatedManHour - intval($mse->estimatedManHour);
//            if($diffHour != 0 && $diffHour != 0.5){
//                if($diffHour<0.5){
//                    $mse->estimatedManHour = intval($mse->estimatedManHour) + 0.5;
//                }else{
//                    $mse->estimatedManHour = intval($mse->estimatedManHour) + 1;
//                }
//                $tmpSurveyTimeHours = explode('-',$mse->surveyTimeHours);
//                $tmpStartTime = substr($tmpSurveyTimeHours[0],0,2).':'.substr($tmpSurveyTimeHours[0],2,2);
//                $tmpEndTime = strtotime($tmpStartTime) + 3600*$mse->estimatedManHour;
//                $mse->surveyTimeHours = $tmpSurveyTimeHours[0].'-'.date("Hi",$tmpEndTime);
////                echo $mse->jobNoNew,'-',$diffHour,' - ',$mse->estimatedManHour,' - ',$mse->surveyTimeHours,"<br />";
//            }
//        }
		if($j == 0){
			$mstmp = $mse;
			$k ++;
		}else if($j > 0){
			$msel = $rs[$j - 1];
			// 如果跟一条记录属于同一分类，则继续
			if(trim($mse->surveyType) == trim($msel->surveyType)
                    && strtotime($mse->plannedSurveyDate) == strtotime($msel->plannedSurveyDate)
					&& trim($mse->jobNo) == trim($msel->jobNo) 
					&& trim($mse->surveyLocation) == trim($msel->surveyLocation) 
					&& trim($mse->routeItems) == trim($msel->routeItems)
					&& trim($mse->direction) == trim($msel->direction)){
				$mstmp->surveyTimeHours .= "," . $mse->surveyTimeHours;
				$mstmp->noOfSurveyors += $mse->noOfSurveyors;
				$mstmp->estimatedManHour += $mse->estimatedManHour;
				$mstmp->bonusHours += $mse->bonusHours;
				$mstmp->onBoardCostHour += $mse->onBoardCostHour;
				continue;
			}else{
				// add by james 2014-04-16,request by molly.
				// 讀取main時把ob hr(CT)+bouns hr(Y)計算 另外把TOTEL MAN HR改掉不計算(Y)
				$mstmp->estimatedManHour = round($mstmp->estimatedManHour,1);
				$mstmp->bonusHours = round($mstmp->bonusHours,1);
				$mstmp->estimatedManHour -= $mstmp->bonusHours;
				$estimatedManHourSummary += $mstmp->estimatedManHour;
				$accuSummary += $mstmp->estimatedManHour;
				$mstmp->onBoardCostHour = $mstmp->onBoardCostHour / $conf['feeHour'][$complateJobNo];
				$mstmp->onBoardCostHour = round($mstmp->onBoardCostHour,1);
				$mstmp->onBoardCostHour += $mstmp->bonusHours;
				$onBoardCostSummary += $mstmp->onBoardCostHour;
				
				// 数据列表资料
				$row = $row + 1;
				$sheet->getStyle("A{$row}:M{$row}")->applyFromArray($ltThinStyle,false);
				$sheet->getStyle('N' . $row)->applyFromArray($ltrThinStyle);
				$sheet->getStyle("A{$row}:N{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				// 如果跟上一个时间相同，则时间變白色
				if(strtotime($mstmp->plannedSurveyDate) == strtotime($mstmpl->plannedSurveyDate)){
					$sheet->getStyle("A{$row}")->applyFromArray($whiteFontStyle);
				}
				// 如果job号码跟上一个相同，則字體變白色
				if(trim($mstmp->jobNo) == trim($mstmpl->jobNo)){
					$sheet->getStyle("B{$row}")->applyFromArray($whiteFontStyle);
				}
				if(empty($mstmp->dueDate))
					$mstmp->dueDate = "-";
				
				$sheet->getStyle("G{$row}")->getAlignment()->setWrapText(true);
				$mstmp->surveyTimeHours = str_replace(",","\n",$mstmp->surveyTimeHours);
				
				$plannedSurveyDateWeek = $mstmp->plannedSurveyDate.'('.date('D',strtotime($mstmp->plannedSurveyDate)).')';
				$sheet->setCellValue("A{$row}",$plannedSurveyDateWeek);
				$sheet->setCellValue("B{$row}",$mstmp->jobNo);
				$sheet->setCellValue("C{$row}",$mstmp->tdFileNo);
				$sheet->setCellValue("D{$row}",$mstmp->receivedDate);
				$sheet->setCellValue("E{$row}",$mstmp->dueDate);
				$sheet->setCellValue("F{$row}",$mstmp->fromTD);
				$sheet->setCellValue("G{$row}",$mstmp->surveyTimeHours);
                $sheet->setCellValue("H{$row}",$mstmp->surveyType);
				$sheet->setCellValue("I{$row}",$mstmp->surveyLocation);
				$sheet->setCellValue("J{$row}",$mstmp->routeItems);
				$sheet->setCellValue("K{$row}",$mstmp->direction);
				$sheet->setCellValue("L{$row}",$mstmp->noOfSurveyors);
				$sheet->setCellValue("M{$row}",$mstmp->estimatedManHour);
				$sheet->setCellValue("N{$row}",$mstmp->onBoardCostHour);
				
				$mstmpl = $mstmp;
				$mstmp = $mse;
				$k ++;
			}
		}
	}
	
	// 因为要比较，所以最后一次一定要打印一次.不用判断！
	if($rsNo > 0){
		// add by james 2014-04-16,request by molly.
		// 讀取main時把ob hr(CT)+bouns hr(Y)計算 另外把TOTEL MAN HR改掉不計算(Y)
		$mstmp->estimatedManHour = round($mstmp->estimatedManHour,1);
		$mstmp->bonusHours = round($mstmp->bonusHours,1);
		$mstmp->estimatedManHour -= $mstmp->bonusHours;
		$estimatedManHourSummary += $mstmp->estimatedManHour;
		$accuSummary += $mstmp->estimatedManHour;
		$mstmp->onBoardCostHour = $mstmp->onBoardCostHour / $conf['feeHour'][$complateJobNo];
		$mstmp->onBoardCostHour = round($mstmp->onBoardCostHour,1);
		$mstmp->onBoardCostHour += $mstmp->bonusHours;
		$onBoardCostSummary += $mstmp->onBoardCostHour;
		
		$row = $row + 1;
		$sheet->getStyle("A{$row}:M{$row}")->applyFromArray($ltThinStyle,false);
		$sheet->getStyle("N{$row}")->applyFromArray($ltrThinStyle);
		$sheet->getStyle("A{$row}:N{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// 如果跟上一个时间相同，则时间變白色
		if(strtotime($mstmp->plannedSurveyDate) == strtotime($mstmpl->plannedSurveyDate)){
			$sheet->getStyle("A{$row}")->applyFromArray($whiteFontStyle);
		}
		// 如果job号码跟上一个相同，則字體變白色
		if(trim($mstmp->jobNo) == trim($mstmpl->jobNo)){
			$sheet->getStyle("B{$row}")->applyFromArray($whiteFontStyle);
		}
		if(empty($mstmp->dueDate))
			$mstmp->dueDate = "-";
		
		$sheet->getStyle("G{$row}")->getAlignment()->setWrapText(true);
		$mstmp->surveyTimeHours = str_replace(",","\n",$mstmp->surveyTimeHours);
		
		$plannedSurveyDateWeek = $mstmp->plannedSurveyDate.'('.date('D',strtotime($mstmp->plannedSurveyDate)).')';
		$sheet->setCellValue("A{$row}",$plannedSurveyDateWeek);
		$sheet->setCellValue("B{$row}",$mstmp->jobNo);
		$sheet->setCellValue("C{$row}",$mstmp->tdFileNo);
		$sheet->setCellValue("D{$row}",$mstmp->receivedDate);
		$sheet->setCellValue("E{$row}",$mstmp->dueDate);
		$sheet->setCellValue("F{$row}",$mstmp->fromTD);
		$sheet->setCellValue("G{$row}",$mstmp->surveyTimeHours);
        $sheet->setCellValue("H{$row}",$mstmp->surveyType);
		$sheet->setCellValue("I{$row}",$mstmp->surveyLocation);
		$sheet->setCellValue("J{$row}",$mstmp->routeItems);
		$sheet->setCellValue("K{$row}",$mstmp->direction);
		$sheet->setCellValue("L{$row}",$mstmp->noOfSurveyors);
		$sheet->setCellValue("M{$row}",$mstmp->estimatedManHour);
		$sheet->setCellValue("N{$row}",$mstmp->onBoardCostHour);
	}
	// 小结
	// $estimatedManHourSummary = round($estimatedManHourSummary,1);
	$row = $row + 1;
	$sheet->getStyle("A{$row}")->applyFromArray($ltThinStyle);
	$sheet->getStyle("B{$row}:J{$row}")->applyFromArray($tThinStyle,false);
	$sheet->getStyle("K{$row}:M{$row}")->applyFromArray($ltThinStyle,false);
	$sheet->getStyle("N{$row}")->applyFromArray($ltrThinStyle);
	$sheet->getStyle("K{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle("K{$row}")->getFont()->setBold(true);
	$sheet->getStyle("L{$row}:N{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	$sheet->setCellValue("L{$row}","Total Manhour Used in this Week");
	$sheet->setCellValue("M{$row}",$estimatedManHourSummary);
	$sheet->setCellValue("N{$row}",$onBoardCostSummary);
	
	$row = $row + 1;
	$sheet->getStyle("A{$row}:N{$row}")->applyFromArray($tThinStyle,false);
	
	// zoom to see
	$sheet->getSheetView()->setZoomScale(90);
	// set print scale
	$sheet->getPageSetup()->setScale(64);
	// set print area
	$sheet->getPageSetup()->setPrintArea("A1:N{$row}");
	// set page size and orientation
	$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	
	// 设置统计表格
	// $totalOnBoardCost += $onBoardCostSummary;
	// $accuSummary = round($accuSummary,1);
	$surveytime = $conf['surveytime'][$complateJobNo];
//	if($i < 29 && $complateJobNo == "80535") // add by molly 2014-09-02
//	{
//		$surveytime = $conf['surveytime'][$complateJobNo] - 1786;
//	}
	$remainingHour = $surveytime - $accuSummary - $onBoardCostSummary;
	// $remainingHour = round($remainingHour,1);
	
	$pexcel->setActiveSheetIndex(0);
	$sheet = $pexcel->getActiveSheet();
	
	$rowSummary = $rowSummary + 1;
	$sheet->getStyle("A{$rowSummary}:D{$rowSummary}")->applyFromArray($ltThinStyle,false);
	$sheet->getStyle("E{$rowSummary}")->applyFromArray($ltrThinStyle);
	$sheet->getStyle("A{$rowSummary}:E{$rowSummary}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// $sheet->getStyle("A{$rowSummary}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
	
	$weekNo = sprintf("%02d",$i);
	// $sheet->setCellValue("A{$rowSummary}", $weekNo);
	$sheet->getCell("A{$rowSummary}")->setValueExplicit($weekNo,PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValue("B{$rowSummary}",$estimatedManHourSummary); //
	$sheet->setCellValue("C{$rowSummary}",$accuSummary); // Accu.
	$sheet->setCellValue("D{$rowSummary}",$onBoardCostSummary); // approx. On board Fare
	$sheet->setCellValue("E{$rowSummary}",$remainingHour); // remaining hours
	
	$accuSummary += $onBoardCostSummary;
}
$rowSummary = $rowSummary + 1;
$sheet->getStyle("A{$rowSummary}:E{$rowSummary}")->applyFromArray($tThinStyle,false);

// zoom to see
// $sheet->getSheetView()->setZoomScale(90);
// set print scale
// $sheet->getPageSetup()->setScale(68);
// set print area
$sheet->getPageSetup()->setPrintArea("A1:N{$row}");

// set page size and orientation
$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

$pexcel->setActiveSheetIndex(0);

// Redirect output to a clients web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header("Content-Disposition: attachment;filename=" . $fileName);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($pexcel,'Excel5');
$objWriter->save('php://output');
exit();
