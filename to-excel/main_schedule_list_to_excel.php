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

$fileName = "main_schedule_list_" . $_GET ["ddlDistId"] . "_" . date ( "Ymd" ) . ".xls";

// Creating a workbook
$pexcel = new PHPExcel ();
// Rename sheet
$pexcel->getActiveSheet ()->setTitle ( "Main Schedule" );

$pexcel->setActiveSheetIndex ( 0 );
$sheet = $pexcel->getActiveSheet ();
$defaultStyle = new PHPExcel_Style ();
$defaultStyle->getFont ()->setName ( 'Arial' );
$defaultStyle->getFont ()->setSize ( 11 );
$sheet->setDefaultStyle ( $defaultStyle );

// Row 1
$row = 1;
$sheet->setCellValue ( "A{$row}", "Week No" );
$sheet->setCellValue ( "B{$row}", "Request No." );
$sheet->setCellValue ( "C{$row}", "Planned Survey Date" );
$sheet->setCellValue ( "D{$row}", "TD File No" );
$sheet->setCellValue ( "E{$row}", "Received Date" );
$sheet->setCellValue ( "F{$row}", "Due Date" );
$sheet->setCellValue ( "G{$row}", "From (TD)" );
$sheet->setCellValue ( "H{$row}", "Survey Time (Hours)" );
$sheet->setCellValue ( "I{$row}", "Survey Type" );
$sheet->setCellValue ( "J{$row}", "Vehicle" );
$sheet->setCellValue ( "K{$row}", "Survey Location" );
$sheet->setCellValue ( "L{$row}", "Route / Items" );
$sheet->setCellValue ( "M{$row}", "Man-hour" );
$sheet->setCellValue ( "N{$row}", "Receive Date" );
$sheet->setCellValue ( "O{$row}", "Report" );

$ms = new MainSchedule ();
$msa = new MainScheduleAccess ( $db );
$msca = new MainScheduleContractorAccess ( $db );

if (empty ( $_GET ["ddlDistId"] )) {
	exit ( 'Dist is not allow null.' );
} else {
	$ms->doDistrict = '1,' . $_GET ["ddlDistId"];
}
$msa->order = "	ORDER BY plannedSurveyDate ASC";

if (UserLogin::HasPermission ( "main_schedule_contractor_all" )) {
	$rs = $msa->GetListSearch ( $ms );
} else {
	$rs = $msca->GetMainScheduleListSearch ( $ms );
}
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$ms = $rs [$i];
	$row ++;
	$sheet->setCellValue ( "A{$row}", $ms->weekNo );
	$sheet->setCellValue ( "B{$row}", $ms->jobNoNew );
	$sheet->setCellValue ( "C{$row}", $ms->plannedSurveyDate );
	$sheet->setCellValue ( "D{$row}", $ms->tdFileNo );
	$sheet->setCellValue ( "E{$row}", $ms->receivedDate );
	$sheet->setCellValue ( "F{$row}", $ms->dueDate );
	$sheet->setCellValue ( "G{$row}", $ms->fromTD );
	$sheet->setCellValue ( "H{$row}", $ms->surveyTimeHours );
	$sheet->setCellValue ( "I{$row}", $ms->surveyType );
	$sheet->setCellValue ( "J{$row}", $ms->vehicle );
	$sheet->setCellValue ( "K{$row}", $ms->surveyLocation );
	$sheet->setCellValue ( "L{$row}", $ms->routeItems );
	$sheet->setCellValue ( "M{$row}", $ms->estimatedManHour );
	$sheet->setCellValue ( "N{$row}", $ms->receiveDate );
	$sheet->setCellValue ( "O{$row}", $ms->report );
}

// set print scale
$sheet->getPageSetup ()->setScale ( 60 );

// set print area
$sheet->getPageSetup ()->setPrintArea ( "A1:O" . $row );

// set page size and orientation
$sheet->getPageSetup ()->setOrientation ( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );
$sheet->getPageSetup ()->setPaperSize ( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4 );

// Redirect output to a clients web browser (Excel5)
header ( 'Content-Type: application/vnd.ms-excel; charset=utf-8' );
header ( "Content-Disposition: attachment;filename=" . $fileName );
header ( 'Cache-Control: max-age=0' );
$objWriter = PHPExcel_IOFactory::createWriter ( $pexcel, 'Excel5' );
$objWriter->save ( 'php://output' );
exit ();
