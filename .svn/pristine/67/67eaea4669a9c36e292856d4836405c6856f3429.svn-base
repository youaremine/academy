<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
$pexcel = new PHPExcel ();
// Rename sheet
$pexcel->getActiveSheet ()->setTitle ( "F1" );
$pexcel->setActiveSheetIndex ( 0 );
$sheet = $pexcel->getActiveSheet ();
$defaultStyle = new PHPExcel_Style ();
$defaultStyle->getFont ()->setName ( 'Arial' );
$defaultStyle->getFont ()->setSize ( 10 );
$sheet->setDefaultStyle ( $defaultStyle );
$sheet->getDefaultStyle ()->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
$sheet->getDefaultRowDimension ()->setRowHeight ( 22.5 );

include_once ('./survey_form_to_excel_style.php');

// Set column widths
$sheet->getColumnDimension ( 'A' )->setWidth ( 25 );
$sheet->getColumnDimension ( 'B' )->setWidth ( 12 );
$sheet->getColumnDimension ( 'C' )->setWidth ( 9.5 );
$sheet->getColumnDimension ( 'D' )->setWidth ( 9.5 );
$sheet->getColumnDimension ( 'E' )->setWidth ( 9.5 );
$sheet->getColumnDimension ( 'F' )->setWidth ( 9.5 );
$sheet->getColumnDimension ( 'G' )->setWidth ( 9.7 );
$sheet->getColumnDimension ( 'H' )->setWidth ( 8.4 );
$sheet->getColumnDimension ( 'I' )->setWidth ( 8.4 );
$sheet->getColumnDimension ( 'J' )->setWidth ( 8.4 );
$sheet->getColumnDimension ( 'K' )->setWidth ( 4 );
$sheet->getColumnDimension ( 'L' )->setWidth ( 23.6 );
$sheet->getColumnDimension ( 'M' )->setWidth ( 12 );
$sheet->getColumnDimension ( 'N' )->setWidth ( 8.5 );
$sheet->getColumnDimension ( 'O' )->setWidth ( 8.5 );
$sheet->getColumnDimension ( 'P' )->setWidth ( 8.5 );
$sheet->getColumnDimension ( 'Q' )->setWidth ( 11 );
$sheet->getColumnDimension ( 'R' )->setWidth ( 9.5 );
$sheet->getColumnDimension ( 'X' )->setWidth ( 8 );
$sheet->getColumnDimension ( 'T' )->setWidth ( 8 );
$sheet->getColumnDimension ( 'U' )->setWidth ( 8 );
$sheet->getColumnDimension ( 'V' )->setWidth ( 4 );

// Row 1
$row = 1;
$sheet->getStyle ( "A{$row}:B{$row}" )->getFont ()->setSize ( 11 );

$sheet->setCellValue ( "A{$row}", "JOB TITLE:" );
$sheet->setCellValue ( "B{$row}", "TD10/2010 Surveys on Non-Franchised Bus Service in the New Territories" );

// Row 2
$row = 2;
$sheet->getStyle ( "K{$row}:S{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "T{$row}" )->getFont ()->setSize ( 11 );
$sheet->getStyle ( "T{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "T{$row}" )->getFont ()->setUnderline ( PHPExcel_Style_Font::UNDERLINE_SINGLE );
$sheet->getStyle ( "M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->mergeCells ( "M{$row}:S{$row}" );
$sheet->setCellValue ( "K{$row}", "調查日期:" );
$sheet->setCellValue ( "M{$row}", $ms->plannedSurveyDate );
$sheet->setCellValue ( "T{$row}", "Bus Terminal" );

// Row 3
$row = 3;
$sheet->getStyle ( "K{$row}:S{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "T{$row}" )->getFont ()->setSize ( 11 );
$sheet->getStyle ( "T{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "T{$row}" )->getFont ()->setUnderline ( PHPExcel_Style_Font::UNDERLINE_SINGLE );
$sheet->getStyle ( "M{$row}:S{$row}" )->applyFromArray ( $tThinStyle );
$sheet->getStyle ( "M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->mergeCells ( "M{$row}:S{$row}" );
$sheet->setCellValue ( "K{$row}", "調查時間:" );
$sheet->setCellValue ( "M{$row}", $ms->surveyTimeHours );
$sheet->setCellValue ( "T{$row}", "Survey Form" );

// Row 4
$row = 4;
$sheet->getStyle ( "A{$row}:B{$row}" )->getFont ()->setSize ( 11 );
$sheet->getStyle ( "M{$row}:S{$row}" )->applyFromArray ( $tThinStyle );

$sheet->mergeCells ( "Q{$row}:S" . ($row + 1) );
$sheet->setCellValue ( "A{$row}", "JOB NUMBER:" );
$sheet->setCellValue ( "B{$row}", $ms->complateJobNo );
$sheet->setCellValue ( "Q{$row}", "手提電話:" );

// Row 5
$row = 5;
$sheet->mergeCells ( "B{$row}:E{$row}" );
$sheet->getStyle ( "B{$row}:E{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "K{$row}:S{$row}" )->getFont ()->setSize ( 14 );

$sheet->setCellValue ( "B{$row}", "當天天氣: 晴天 / 陰天 / 雨天" );
$sheet->setCellValue ( "K{$row}", "調查員:" );
$sheet->setCellValue ( "P{$row}", "(       )" );

// Row 6
$row = 6;
$sheet->mergeCells ( "B{$row}:E{$row}" );
$sheet->mergeCells ( "M{$row}:S{$row}" );
$sheet->getStyle ( "B{$row}:E{$row}" )->getFont ()->setSize ( 20 );
$sheet->getStyle ( "B{$row}:E{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "M{$row}:S{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "B{$row}:E{$row}" )->applyFromArray ( $tThinStyle );
$sheet->getStyle ( "M{$row}:S{$row}" )->applyFromArray ( $tThinStyle );
$sheet->getStyle ( "B{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->setCellValue ( "B{$row}", $ms->jobNoNew );
$sheet->setCellValue ( "M{$row}", $ms->surveyLocation );

// Row 7
$row = 7;
$sheet->mergeCells ( "M{$row}:S{$row}" );
$sheet->getStyle ( "K{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "M{$row}:S{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "B{$row}:E{$row}" )->applyFromArray ( $tThinStyle );
$sheet->getStyle ( "M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->setCellValue ( "K{$row}", "調查地點:" );
$sheet->setCellValue ( "M{$row}", $ms->surveyLocationCn );

// Row 8
$row = 8;
$sheet->mergeCells ( "M{$row}:S" . ($row + 1) );
$sheet->getStyle ( "M{$row}:S{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "M{$row}:S{$row}" )->applyFromArray ( $tThinStyle );
$sheet->getStyle ( "M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->setCellValue ( "M{$row}", $ms->direction );

// Row 9
$row = 9;
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "K{$row}" )->getFont ()->setSize ( 14 );

$sheet->setCellValue ( "A{$row}", "(1) 請填24小時制, 如早上7時--->07, 下午7時--->19" );
$sheet->setCellValue ( "K{$row}", "方向:" );

// Row 10
$row = 10;
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "M{$row}:S{$row}" )->applyFromArray ( $tThinStyle );

$sheet->setCellValue ( "A{$row}", "(2) 九巴, 嶼巴, 龍運請記錄車牌，城巴, 新巴請記錄車輛編號" );

// Row 11
$row = 11;
$sheet->mergeCells ( "M{$row}:S{$row}" );
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "A{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "K{$row}:S{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->setCellValue ( "A{$row}", "(3) 如巴士在中途站「飛站」" );
$sheet->setCellValue ( "K{$row}", "路線:" );
$sheet->setCellValue ( "M{$row}", $ms->routeItems );

// Row 12
$row = 12;
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "A{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "M{$row}:S{$row}" )->applyFromArray ( $tThinStyle );

$sheet->setCellValue ( "A{$row}", "　（即車站有乘客候車，而巴士並非因滿座而不停站），請打「＊」" );

// Add ozzo and td's logo
$tdLogo = "../images/excel/td-logo.png";
// Add a drawing to the worksheet
$tdDrawing = new PHPExcel_Worksheet_Drawing ();
$tdDrawing->setPath ( $tdLogo );
$tdDrawing->setResizeProportional ( true );
$tdDrawing->setWidthAndHeight ( 132, 46 );
$tdDrawing->setCoordinates ( 'T9' );
$tdDrawing->setWorksheet ( $sheet );

$ozzoLogo = "../images/excel/ozzo-logo.png";
// Add a drawing to the worksheet
$ozzoDrawing = new PHPExcel_Worksheet_Drawing ();
$ozzoDrawing->setPath ( $ozzoLogo );
$ozzoDrawing->setResizeProportional ( true );
$ozzoDrawing->setHeight ( 63.58 );
$ozzoDrawing->setCoordinates ( 'T11' );
$ozzoDrawing->setOffsetY ( - 10 );
$ozzoDrawing->setOffsetX ( - 18 );
$ozzoDrawing->setWorksheet ( $sheet );

// Row 13
$row = 13;
$sheet->getRowDimension ( $row )->setRowHeight ( 30 );
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 9 );
$sheet->getStyle ( "B{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "B{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "L{$row}" )->getFont ()->setSize ( 9 );
$sheet->getStyle ( "M{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "M{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $tStyle );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "K{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "V{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "G{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "R{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->setCellValue ( "A{$row}", "ROUTE NO.:" );
$sheet->setCellValue ( "B{$row}", $routes [0] );
$sheet->setCellValue ( "G{$row}", "CITYBUS / KMB / NWFB / LWB" );
$sheet->setCellValue ( "L{$row}", "ROUTE NO.:" );
$sheet->setCellValue ( "M{$row}", $routes [1] );
$sheet->setCellValue ( "R{$row}", "CITYBUS / KMB / NWFB / LWB" );

// Row 14
$row = 14;
$sheet->getRowDimension ( $row )->setRowHeight ( 33 );
$sheet->getStyle ( "A{$row}:F{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "G{$row}:J{$row}" )->getFont ()->setSize ( 12 );
$sheet->getStyle ( "L{$row}:Q{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "R{$row}:U{$row}" )->getFont ()->setSize ( 12 );
$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "K{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "V{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "B{$row}:C{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "G{$row}:J{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "M{$row}:N{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "R{$row}:U{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setWrapText ( true );

$sheet->mergeCells ( "A{$row}:A" . ($row + 2) );
$sheet->mergeCells ( "K{$row}:K" . ($row + 2) );
$sheet->mergeCells ( "L{$row}:L" . ($row + 2) );
$sheet->mergeCells ( "V{$row}:V" . ($row + 2) );
$sheet->mergeCells ( "C{$row}:F{$row}" );
$sheet->mergeCells ( "N{$row}:Q{$row}" );

$sheet->setCellValue ( "A{$row}", "Registration no. / Fleet no. 車牌/車隊編號" );
$sheet->setCellValue ( "B{$row}", "Capacity" );
$sheet->setCellValue ( "C{$row}", "Time  時間" );
$sheet->setCellValue ( "G{$row}", "On Arrival." );
$sheet->setCellValue ( "H{$row}", "Pick\nUp" );
$sheet->setCellValue ( "I{$row}", "Drop off" );
$sheet->setCellValue ( "J{$row}", "Left Behind" );
$sheet->setCellValue ( "K{$row}", "Ref. No" );
$sheet->setCellValue ( "L{$row}", "Registration no. / Fleet no. 車牌/車隊編號" );
$sheet->setCellValue ( "M{$row}", "Capacity" );
$sheet->setCellValue ( "N{$row}", "Time  時間" );
$sheet->setCellValue ( "R{$row}", "On Arrival." );
$sheet->setCellValue ( "S{$row}", "Pick\nUp" );
$sheet->setCellValue ( "T{$row}", "Drop off" );
$sheet->setCellValue ( "U{$row}", "Left Behind" );
$sheet->setCellValue ( "V{$row}", "Ref. No" );

// Row 15
$row = 15;
$sheet->getRowDimension ( $row )->setRowHeight ( 45.75 );
$sheet->getStyle ( "B{$row}:U{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "C{$row}:F{$row}" )->applyFromArray ( $tThinStyle, false );
$sheet->getStyle ( "N{$row}:Q{$row}" )->applyFromArray ( $tThinStyle, false );
$sheet->getStyle ( "K{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "V{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "B{$row}:C{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "E{$row}" )->applyFromArray ( $lThinStyle );
$sheet->getStyle ( "G{$row}:J{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "M{$row}:N{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "P{$row}" )->applyFromArray ( $lThinStyle );
$sheet->getStyle ( "R{$row}:U{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "C{$row}:F{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_GENERAL );
$sheet->getStyle ( "N{$row}:Q{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_GENERAL );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setWrapText ( true );
$sheet->getStyle ( "C{$row}:F{$row}" )->getAlignment ()->setWrapText ( false );
$sheet->getStyle ( "N{$row}:Q{$row}" )->getAlignment ()->setWrapText ( false );

$sheet->setCellValue ( "C{$row}", "Arrival  到達" );
$sheet->setCellValue ( "E{$row}", "Departure 出發" );
$sheet->setCellValue ( "G{$row}", "到站車上人數" );
$sheet->setCellValue ( "H{$row}", "上車人數" );
$sheet->setCellValue ( "I{$row}", "落車人數" );
$sheet->setCellValue ( "J{$row}", "剩餘人龍" );
$sheet->setCellValue ( "N{$row}", "Arrival  到達" );
$sheet->setCellValue ( "P{$row}", "Departure 出發" );
$sheet->setCellValue ( "R{$row}", "到站車上人數" );
$sheet->setCellValue ( "S{$row}", "上車人數" );
$sheet->setCellValue ( "T{$row}", "落車人數" );
$sheet->setCellValue ( "U{$row}", "剩餘人龍" );

// Row 16
$row = 16;
$sheet->getRowDimension ( $row )->setRowHeight ( 42.75 );
$sheet->getStyle ( "B{$row}:U{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "C{$row}:F{$row}" )->applyFromArray ( $tThinStyle, false );
$sheet->getStyle ( "N{$row}:Q{$row}" )->applyFromArray ( $tThinStyle, false );
$sheet->getStyle ( "K{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "V{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "B{$row}:J{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "M{$row}:U{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setWrapText ( true );

$sheet->setCellValue ( "B{$row}", "載客量" );
$sheet->setCellValue ( "C{$row}", "Hr\n小時" );
$sheet->setCellValue ( "D{$row}", "Min\n分鐘" );
$sheet->setCellValue ( "E{$row}", "Hr\n小時" );
$sheet->setCellValue ( "F{$row}", "Min\n分鐘" );
$sheet->setCellValue ( "G{$row}", "(No.)" );
$sheet->setCellValue ( "H{$row}", "(No.)" );
$sheet->setCellValue ( "I{$row}", "(No.)" );
$sheet->setCellValue ( "J{$row}", "(No.)" );
$sheet->setCellValue ( "M{$row}", "載客量" );
$sheet->setCellValue ( "N{$row}", "Hr\n小時" );
$sheet->setCellValue ( "O{$row}", "Min\n分鐘" );
$sheet->setCellValue ( "P{$row}", "Hr\n小時" );
$sheet->setCellValue ( "Q{$row}", "Min\n分鐘" );
$sheet->setCellValue ( "R{$row}", "(No.)" );
$sheet->setCellValue ( "S{$row}", "(No.)" );
$sheet->setCellValue ( "T{$row}", "(No.)" );
$sheet->setCellValue ( "U{$row}", "(No.)" );

// Row 17
$row = 17;
$sheet->getRowDimension ( $row )->setRowHeight ( 50 );
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 8 );
$sheet->getStyle ( "L{$row}" )->getFont ()->setSize ( 8 );
$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $ltThinStyle, false );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "K{$row}" )->applyFromArray ( $lrStyle, false );
$sheet->getStyle ( "V{$row}" )->applyFromArray ( $lrStyle, false );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "A{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
$sheet->getStyle ( "A{$row}" )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_BOTTOM );
$sheet->getStyle ( "L{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
$sheet->getStyle ( "L{$row}" )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_BOTTOM );

$sheet->setCellValue ( "A{$row}", "(雙層 / 單層)" );
$sheet->setCellValue ( "K{$row}", "1" );
$sheet->setCellValue ( "L{$row}", "(雙層 / 單層)" );
$sheet->setCellValue ( "V{$row}", "11" );

for($i = 2; $i <= 10; $i ++) {
	$row = 16 + $i;
	$sheet->getRowDimension ( $row )->setRowHeight ( 50 );
	$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 8 );
	$sheet->getStyle ( "L{$row}" )->getFont ()->setSize ( 8 );
	$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $ltThinStyle, false );
	$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
	$sheet->getStyle ( "K{$row}" )->applyFromArray ( $lrStyle, false );
	$sheet->getStyle ( "V{$row}" )->applyFromArray ( $lrStyle, false );
	$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	$sheet->getStyle ( "A{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
	$sheet->getStyle ( "A{$row}" )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_BOTTOM );
	$sheet->getStyle ( "L{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
	$sheet->getStyle ( "L{$row}" )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_BOTTOM );
	
	$sheet->setCellValue ( "A{$row}", "(雙層 / 單層)" );
	$sheet->setCellValue ( "K{$row}", $i );
	$sheet->setCellValue ( "L{$row}", "(雙層 / 單層)" );
	$sheet->setCellValue ( "V{$row}", $i + 10 );
}

$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $bStyle, false );

// Setting worksheet zoom level
$sheet->getSheetView ()->setZoomScale ( 70 );

// set print scale
$sheet->getPageSetup ()->setScale ( 54 );

// set print area
$sheet->getPageSetup ()->setPrintArea ( "A1:V" . $row );

// set page size and orientation
$sheet->getPageSetup ()->setOrientation ( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );
$sheet->getPageSetup ()->setPaperSize ( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4 );

// Sheet 2
$pexcel->createSheet ();
$pexcel->setActiveSheetIndex ( 1 );
$sheet = $pexcel->getActiveSheet ();
$sheet->setTitle ( 'F1 (page2)' );
$sheet->setDefaultStyle ( $defaultStyle );
$sheet->getDefaultStyle ()->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
$sheet->getDefaultRowDimension ()->setRowHeight ( 50 );

// Set column widths
$sheet->getColumnDimension ( 'A' )->setWidth ( 25 );
$sheet->getColumnDimension ( 'B' )->setWidth ( 12 );
$sheet->getColumnDimension ( 'C' )->setWidth ( 9.5 );
$sheet->getColumnDimension ( 'D' )->setWidth ( 9.5 );
$sheet->getColumnDimension ( 'E' )->setWidth ( 9.5 );
$sheet->getColumnDimension ( 'F' )->setWidth ( 9.5 );
$sheet->getColumnDimension ( 'G' )->setWidth ( 9.7 );
$sheet->getColumnDimension ( 'H' )->setWidth ( 8.4 );
$sheet->getColumnDimension ( 'I' )->setWidth ( 8.4 );
$sheet->getColumnDimension ( 'J' )->setWidth ( 8.4 );
$sheet->getColumnDimension ( 'K' )->setWidth ( 4 );
$sheet->getColumnDimension ( 'L' )->setWidth ( 23.6 );
$sheet->getColumnDimension ( 'M' )->setWidth ( 12 );
$sheet->getColumnDimension ( 'N' )->setWidth ( 8.5 );
$sheet->getColumnDimension ( 'O' )->setWidth ( 8.5 );
$sheet->getColumnDimension ( 'P' )->setWidth ( 8.5 );
$sheet->getColumnDimension ( 'Q' )->setWidth ( 11 );
$sheet->getColumnDimension ( 'R' )->setWidth ( 9.5 );
$sheet->getColumnDimension ( 'X' )->setWidth ( 8 );
$sheet->getColumnDimension ( 'T' )->setWidth ( 8 );
$sheet->getColumnDimension ( 'U' )->setWidth ( 8 );
$sheet->getColumnDimension ( 'V' )->setWidth ( 4 );

// Row 1
$row = 1;
$sheet->getRowDimension ( $row )->setRowHeight ( 53.25 );
$sheet->getStyle ( "S{$row}:T{$row}" )->getFont ()->setSize ( 20 );
$sheet->getStyle ( "S{$row}:T{$row}" )->getFont ()->setBold ( true );

$sheet->mergeCells ( "S{$row}:T{$row}" );

$sheet->setCellValue ( "R{$row}", "REF NO." );
$sheet->setCellValue ( "S{$row}", $ms->jobNoNew );

// Row 2
$row = 2;
$sheet->getRowDimension ( $row )->setRowHeight ( 30 );
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 9 );
$sheet->getStyle ( "B{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "B{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "L{$row}" )->getFont ()->setSize ( 9 );
$sheet->getStyle ( "M{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "M{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $tStyle );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "K{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "V{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "G{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "R{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->setCellValue ( "A{$row}", "ROUTE NO.:" );
$sheet->setCellValue ( "B{$row}", $routes [2] );
$sheet->setCellValue ( "G{$row}", "CITYBUS / KMB / NWFB / LWB" );
$sheet->setCellValue ( "L{$row}", "ROUTE NO.:" );
$sheet->setCellValue ( "M{$row}", $routes [3] );
$sheet->setCellValue ( "R{$row}", "CITYBUS / KMB / NWFB / LWB" );

// Row 3
$row = 3;
$sheet->getRowDimension ( $row )->setRowHeight ( 33 );
$sheet->getStyle ( "A{$row}:F{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "G{$row}:J{$row}" )->getFont ()->setSize ( 12 );
$sheet->getStyle ( "L{$row}:Q{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "R{$row}:U{$row}" )->getFont ()->setSize ( 12 );
$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "K{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "V{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "B{$row}:C{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "G{$row}:J{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "M{$row}:N{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "R{$row}:U{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setWrapText ( true );

$sheet->mergeCells ( "A{$row}:A" . ($row + 2) );
$sheet->mergeCells ( "K{$row}:K" . ($row + 2) );
$sheet->mergeCells ( "L{$row}:L" . ($row + 2) );
$sheet->mergeCells ( "V{$row}:V" . ($row + 2) );
$sheet->mergeCells ( "C{$row}:F{$row}" );
$sheet->mergeCells ( "N{$row}:Q{$row}" );

$sheet->setCellValue ( "A{$row}", "Registration no. / Fleet no. 車牌/車隊編號" );
$sheet->setCellValue ( "B{$row}", "Capacity" );
$sheet->setCellValue ( "C{$row}", "Time  時間" );
$sheet->setCellValue ( "G{$row}", "On Arrival." );
$sheet->setCellValue ( "H{$row}", "Pick\nUp" );
$sheet->setCellValue ( "I{$row}", "Drop off" );
$sheet->setCellValue ( "J{$row}", "Left Behind" );
$sheet->setCellValue ( "K{$row}", "Ref. No" );
$sheet->setCellValue ( "L{$row}", "Registration no. / Fleet no. 車牌/車隊編號" );
$sheet->setCellValue ( "M{$row}", "Capacity" );
$sheet->setCellValue ( "N{$row}", "Time  時間" );
$sheet->setCellValue ( "R{$row}", "On Arrival." );
$sheet->setCellValue ( "S{$row}", "Pick\nUp" );
$sheet->setCellValue ( "T{$row}", "Drop off" );
$sheet->setCellValue ( "U{$row}", "Left Behind" );
$sheet->setCellValue ( "V{$row}", "Ref. No" );

// Row 4
$row = 4;
$sheet->getRowDimension ( $row )->setRowHeight ( 45.75 );
$sheet->getStyle ( "B{$row}:U{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "C{$row}:F{$row}" )->applyFromArray ( $tThinStyle, false );
$sheet->getStyle ( "N{$row}:Q{$row}" )->applyFromArray ( $tThinStyle, false );
$sheet->getStyle ( "K{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "V{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "B{$row}:C{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "E{$row}" )->applyFromArray ( $lThinStyle );
$sheet->getStyle ( "G{$row}:J{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "M{$row}:N{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "P{$row}" )->applyFromArray ( $lThinStyle );
$sheet->getStyle ( "R{$row}:U{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "C{$row}:F{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_GENERAL );
$sheet->getStyle ( "N{$row}:Q{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_GENERAL );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setWrapText ( true );
$sheet->getStyle ( "C{$row}:F{$row}" )->getAlignment ()->setWrapText ( false );
$sheet->getStyle ( "N{$row}:Q{$row}" )->getAlignment ()->setWrapText ( false );

$sheet->setCellValue ( "C{$row}", "Arrival  到達" );
$sheet->setCellValue ( "E{$row}", "Departure 出發" );
$sheet->setCellValue ( "G{$row}", "到站車上人數" );
$sheet->setCellValue ( "H{$row}", "上車人數" );
$sheet->setCellValue ( "I{$row}", "落車人數" );
$sheet->setCellValue ( "J{$row}", "剩餘人龍" );
$sheet->setCellValue ( "N{$row}", "Arrival  到達" );
$sheet->setCellValue ( "P{$row}", "Departure 出發" );
$sheet->setCellValue ( "R{$row}", "到站車上人數" );
$sheet->setCellValue ( "S{$row}", "上車人數" );
$sheet->setCellValue ( "T{$row}", "落車人數" );
$sheet->setCellValue ( "U{$row}", "剩餘人龍" );

// Row 5
$row = 5;
$sheet->getRowDimension ( $row )->setRowHeight ( 42.75 );
$sheet->getStyle ( "B{$row}:U{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "C{$row}:F{$row}" )->applyFromArray ( $tThinStyle, false );
$sheet->getStyle ( "N{$row}:Q{$row}" )->applyFromArray ( $tThinStyle, false );
$sheet->getStyle ( "K{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "V{$row}" )->applyFromArray ( $ltrStyle );
$sheet->getStyle ( "B{$row}:J{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "M{$row}:U{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setWrapText ( true );

$sheet->setCellValue ( "B{$row}", "載客量" );
$sheet->setCellValue ( "C{$row}", "Hr\n小時" );
$sheet->setCellValue ( "D{$row}", "Min\n分鐘" );
$sheet->setCellValue ( "E{$row}", "Hr\n小時" );
$sheet->setCellValue ( "F{$row}", "Min\n分鐘" );
$sheet->setCellValue ( "G{$row}", "(No.)" );
$sheet->setCellValue ( "H{$row}", "(No.)" );
$sheet->setCellValue ( "I{$row}", "(No.)" );
$sheet->setCellValue ( "J{$row}", "(No.)" );
$sheet->setCellValue ( "M{$row}", "載客量" );
$sheet->setCellValue ( "N{$row}", "Hr\n小時" );
$sheet->setCellValue ( "O{$row}", "Min\n分鐘" );
$sheet->setCellValue ( "P{$row}", "Hr\n小時" );
$sheet->setCellValue ( "Q{$row}", "Min\n分鐘" );
$sheet->setCellValue ( "R{$row}", "(No.)" );
$sheet->setCellValue ( "S{$row}", "(No.)" );
$sheet->setCellValue ( "T{$row}", "(No.)" );
$sheet->setCellValue ( "U{$row}", "(No.)" );

// Row 6
$row = 6;
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 8 );
$sheet->getStyle ( "L{$row}" )->getFont ()->setSize ( 8 );
$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $ltThinStyle, false );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "K{$row}" )->applyFromArray ( $lrStyle, false );
$sheet->getStyle ( "V{$row}" )->applyFromArray ( $lrStyle, false );
$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "A{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
$sheet->getStyle ( "A{$row}" )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_BOTTOM );
$sheet->getStyle ( "L{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
$sheet->getStyle ( "L{$row}" )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_BOTTOM );

$sheet->setCellValue ( "A{$row}", "(雙層 / 單層)" );
$sheet->setCellValue ( "K{$row}", "1" );
$sheet->setCellValue ( "L{$row}", "(雙層 / 單層)" );
$sheet->setCellValue ( "V{$row}", "11" );

for($i = 2; $i <= 15; $i ++) {
	$row = 5 + $i;
	$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 8 );
	$sheet->getStyle ( "L{$row}" )->getFont ()->setSize ( 8 );
	$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $ltThinStyle, false );
	$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
	$sheet->getStyle ( "K{$row}" )->applyFromArray ( $lrStyle, false );
	$sheet->getStyle ( "V{$row}" )->applyFromArray ( $lrStyle, false );
	$sheet->getStyle ( "A{$row}:V{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	$sheet->getStyle ( "A{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
	$sheet->getStyle ( "A{$row}" )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_BOTTOM );
	$sheet->getStyle ( "L{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
	$sheet->getStyle ( "L{$row}" )->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_BOTTOM );
	
	$sheet->setCellValue ( "A{$row}", "(雙層 / 單層)" );
	$sheet->setCellValue ( "K{$row}", $i );
	$sheet->setCellValue ( "L{$row}", "(雙層 / 單層)" );
	$sheet->setCellValue ( "V{$row}", $i + 10 );
}

$sheet->getStyle ( "A{$row}:V{$row}" )->applyFromArray ( $bStyle, false );

// Setting worksheet zoom level
$sheet->getSheetView ()->setZoomScale ( 70 );

// set print scale
$sheet->getPageSetup ()->setScale ( 52 );

// set print area
$sheet->getPageSetup ()->setPrintArea ( "A1:V" . $row );

// set page size and orientation
$sheet->getPageSetup ()->setOrientation ( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );
$sheet->getPageSetup ()->setPaperSize ( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4 );

$pexcel->setActiveSheetIndex ( 0 );

// Redirect output to a clients web browser (Excel5)
$fileName = "survey_form_" . $ms->jobNoNew;
header ( 'Content-Type: application/vnd.ms-excel; charset=utf-8' );
header ( "Content-Disposition: attachment;filename=" . $fileName );
header ( 'Cache-Control: max-age=0' );
$objWriter = PHPExcel_IOFactory::createWriter ( $pexcel, 'Excel5' );
$objWriter->save ( 'php://output' );
exit ();

?>