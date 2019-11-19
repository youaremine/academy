<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
$pexcel = new PHPExcel ();
// Rename sheet
$pexcel->getActiveSheet ()->setTitle ( "F3m" );
$pexcel->setActiveSheetIndex ( 0 );
$sheet = $pexcel->getActiveSheet ();
$defaultStyle = new PHPExcel_Style ();
$defaultStyle->getFont ()->setName ( 'Arial' );
$defaultStyle->getFont ()->setSize ( 10 );
$sheet->setDefaultStyle ( $defaultStyle );
$sheet->getDefaultStyle ()->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
$sheet->getDefaultRowDimension ()->setRowHeight ( 40 );

include_once ('./survey_form_to_excel_style.php');

// Set column widths
$sheet->getColumnDimension ( 'A' )->setWidth ( 4.1 );
$sheet->getColumnDimension ( 'B' )->setWidth ( 27.6 );
$sheet->getColumnDimension ( 'C' )->setWidth ( 13.2 );
$sheet->getColumnDimension ( 'D' )->setWidth ( 15.6 );
$sheet->getColumnDimension ( 'E' )->setWidth ( 23 );
$sheet->getColumnDimension ( 'F' )->setWidth ( 23 );
$sheet->getColumnDimension ( 'G' )->setWidth ( 14.4 );
$sheet->getColumnDimension ( 'H' )->setWidth ( 14.4 );
$sheet->getColumnDimension ( 'I' )->setWidth ( 18.4 );
$sheet->getColumnDimension ( 'J' )->setWidth ( 13.2 );
$sheet->getColumnDimension ( 'K' )->setWidth ( 10 );
$sheet->getColumnDimension ( 'L' )->setWidth ( 10 );
$sheet->getColumnDimension ( 'M' )->setWidth ( 11.3 );
$sheet->getColumnDimension ( 'N' )->setWidth ( 13.2 );
$sheet->getColumnDimension ( 'O' )->setWidth ( 16.8 );
$sheet->getColumnDimension ( 'P' )->setWidth ( 14.4 );
$sheet->getColumnDimension ( 'Q' )->setWidth ( 16.8 );
$sheet->getColumnDimension ( 'R' )->setWidth ( 14.4 );
$sheet->getColumnDimension ( 'S' )->setWidth ( 21.9 );

// Row 1
$row = 1;
$sheet->getStyle ( "A{$row}:B{$row}" )->getFont ()->setSize ( 11 );

$sheet->setCellValue ( "A{$row}", "JOB TITLE:" );
$sheet->setCellValue ( "B{$row}", "TD235/2008 Surveys on Public Transport Services and Non-franchised Bus Services in Urban 2009/10" );

// Row 2
$row = 2;
$sheet->getRowDimension ( $row )->setRowHeight ( 30 );
$sheet->mergeCells ( "F{$row}:L{$row}" );
$sheet->mergeCells ( "O{$row}:S{$row}" );
$sheet->getStyle ( "E{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "F{$row}:L{$row}" )->getFont ()->setSize ( 18 );
$sheet->getStyle ( "O{$row}:S{$row}" )->getFont ()->setSize ( 18 );
$sheet->getStyle ( "M{$row}" )->getFont ()->setSize ( 11 );
$sheet->getStyle ( "M{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "M{$row}" )->getFont ()->setUnderline ( PHPExcel_Style_Font::UNDERLINE_SINGLE );
$sheet->getStyle ( "E{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
$sheet->getStyle ( "F{$row}:L{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->getStyle ( "O{$row}:S{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

$sheet->setCellValue ( "E{$row}", "調查日期:" );
$sheet->setCellValue ( "F{$row}", $ms->plannedSurveyDate );
$sheet->setCellValue ( "M{$row}", "Residential Bus" );
$sheet->setCellValue ( "O{$row}", "UBS - 非法村巴" );

// Row 3
$row = 3;
$sheet->getRowDimension ( $row )->setRowHeight ( 29.25 );
$sheet->mergeCells ( "F{$row}:L{$row}" );
$sheet->getStyle ( "E{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "F{$row}:L{$row}" )->getFont ()->setSize ( 18 );
$sheet->getStyle ( "M{$row}" )->getFont ()->setSize ( 11 );
$sheet->getStyle ( "M{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "M{$row}" )->getFont ()->setUnderline ( PHPExcel_Style_Font::UNDERLINE_SINGLE );
$sheet->getStyle ( "E{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
$sheet->getStyle ( "F{$row}:L{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->getStyle ( "F{$row}:L{$row}" )->applyFromArray ( $tThinStyle );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

$sheet->setCellValue ( "E{$row}", "調查時間:" );
$sheet->setCellValue ( "F{$row}", $ms->surveyTimeHours );
$sheet->setCellValue ( "M{$row}", "Survey Form" );

// Add ozzo and td's logo
$tdLogo = "../images/excel/td-logo.png";
// Add a drawing to the worksheet
$tdDrawing = new PHPExcel_Worksheet_Drawing ();
$tdDrawing->setPath ( $tdLogo );
$tdDrawing->setResizeProportional ( true );
$tdDrawing->setWidthAndHeight ( 132, 46 );
$tdDrawing->setCoordinates ( 'A3' );
$tdDrawing->setWorksheet ( $sheet );

// Add a drawing to the worksheet
$ozzoLogo = "../images/excel/ozzo-logo.png";
$ozzoDrawing = new PHPExcel_Worksheet_Drawing ();
$ozzoDrawing->setPath ( $ozzoLogo );
$ozzoDrawing->setResizeProportional ( true );
$ozzoDrawing->setHeight ( 63.58 );
$ozzoDrawing->setCoordinates ( 'C3' );
$ozzoDrawing->setWorksheet ( $sheet );

// Row 4
$row = 4;
$sheet->getRowDimension ( $row )->setRowHeight ( 23.25 );
$sheet->mergeCells ( "J{$row}:L" . ($row + 1) );
$sheet->getStyle ( "F{$row}:L{$row}" )->applyFromArray ( $tThinStyle );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

$sheet->setCellValue ( "J{$row}", "手提電話:" );

// Row 5
$row = 5;
$sheet->getRowDimension ( $row )->setRowHeight ( 22.5 );
$sheet->mergeCells ( "O{$row}:S" . ($row + 5) );
$sheet->getStyle ( "E{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "O{$row}:S{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "E{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
$sheet->getStyle ( "F{$row}:L{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "O{$row}" )->getAlignment ()->setWrapText ( true );

$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

$sheet->setCellValue ( "E{$row}", "調查員:" );
$sheet->setCellValue ( "O{$row}", "註解:\n(1) 請填24小時制, 如早上7時--->07, 下午7時--->19\n(2) 如有警察到場維持秩序, 請寫下時間和原因\n(3) 如有特發情況發生, 請寫下時間和原因" );

// Row 6
$row = 6;
$sheet->getRowDimension ( $row )->setRowHeight ( 36.75 );
$sheet->mergeCells ( "C{$row}:D{$row}" );
$sheet->mergeCells ( "F{$row}:L{$row}" );
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 11 );
$sheet->getStyle ( "C{$row}:D{$row}" )->getFont ()->setSize ( 20 );
$sheet->getStyle ( "C{$row}:D{$row}" )->getFont ()->setBold ( true );
$sheet->getStyle ( "C{$row}:D{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->getStyle ( "F{$row}:L{$row}" )->applyFromArray ( $tThinStyle );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

$sheet->setCellValue ( "A{$row}", "REF NO." );
$sheet->setCellValue ( "C{$row}", $ms->jobNoNew );

// Row 7
$row = 7;
$sheet->getRowDimension ( $row )->setRowHeight ( 42.75 );
$sheet->mergeCells ( "F{$row}:L{$row}" );
$sheet->getStyle ( "E{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "F{$row}:L{$row}" )->getFont ()->setSize ( 18 );
$sheet->getStyle ( "E{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
$sheet->getStyle ( "F{$row}:L{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->getStyle ( "C{$row}:D{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

$sheet->setCellValue ( "E{$row}", "調查地點:" );
$sheet->setCellValue ( "F{$row}", $ms->surveyLocation );

// Row 8
$row = 8;
$sheet->getRowDimension ( $row )->setRowHeight ( 14.25 );
$sheet->mergeCells ( "F{$row}:L" . ($row + 1) );
$sheet->getStyle ( "F{$row}:L{$row}" )->getFont ()->setSize ( 18 );
$sheet->getStyle ( "F{$row}:L{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->getStyle ( "F{$row}:L{$row}" )->applyFromArray ( $tThinStyle );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

$sheet->setCellValue ( "F{$row}", $ms->direction );

// Row 9
$row = 9;
$sheet->getRowDimension ( $row )->setRowHeight ( 24 );
$sheet->getStyle ( "E{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "E{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );

$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

$sheet->setCellValue ( "E{$row}", "方向:" );

// Row 10
$row = 10;
$sheet->getRowDimension ( $row )->setRowHeight ( 18.75 );

$sheet->getStyle ( "F{$row}:L{$row}" )->applyFromArray ( $tThinStyle );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

// Row 11
$row = 11;
$sheet->getRowDimension ( $row )->setRowHeight ( 27 );
$sheet->mergeCells ( "F{$row}:L{$row}" );
$sheet->getStyle ( "E{$row}" )->getFont ()->setSize ( 14 );
$sheet->getStyle ( "F{$row}:L{$row}" )->getFont ()->setSize ( 18 );
$sheet->getStyle ( "E{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
$sheet->getStyle ( "F{$row}:L{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->getStyle ( "O{$row}:S{$row}" )->applyFromArray ( $tStyle, false );

$sheet->setCellValue ( "E{$row}", "路線:" );
$sheet->setCellValue ( "F{$row}", $ms->routeItems );

// Row 12
$row = 12;
$sheet->getRowDimension ( $row )->setRowHeight ( 15.75 );

// Row 13
$row = 13;
$sheet->getRowDimension ( $row )->setRowHeight ( 15.75 );
$sheet->mergeCells ( "O{$row}:R{$row}" );
$sheet->getStyle ( "O{$row}:R{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->getStyle ( "O{$row}:S{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

$sheet->setCellValue ( "O{$row}", "Service Details" );

// Row 14
$row = 14;
$sheet->getRowDimension ( $row )->setRowHeight ( 93 );
$sheet->getStyle ( "B{$row}:R{$row}" )->getFont ()->setSize ( 18 );
$sheet->getStyle ( "S{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setWrapText ( true );

$sheet->getStyle ( "A{$row}:S{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "B{$row}:R{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $lrStyle, false );

$sheet->setCellValue ( "A{$row}", "no." );
$sheet->setCellValue ( "B{$row}", "車牌" );
$sheet->setCellValue ( "C{$row}", "車上\n載客量" );
$sheet->setCellValue ( "D{$row}", "營運\n牌照" );
$sheet->setCellValue ( "E{$row}", "起點" );
$sheet->setCellValue ( "F{$row}", "目的地" );
$sheet->setCellValue ( "G{$row}", "到站\n時間" );
$sheet->setCellValue ( "H{$row}", "離站\n時間" );
$sheet->setCellValue ( "I{$row}", "車資 / 付款方法" );
$sheet->setCellValue ( "J{$row}", "到站車\n上人數" );
$sheet->setCellValue ( "K{$row}", "落車\n人數" );
$sheet->setCellValue ( "L{$row}", "上車\n人數" );
$sheet->setCellValue ( "M{$row}", "剩餘\n人龍" );
$sheet->setCellValue ( "N{$row}", "離站車\n上人數" );
$sheet->setCellValue ( "O{$row}", "擋風玻璃有無詳情(黃色牌)" );
$sheet->setCellValue ( "P{$row}", "有無停站位置詳情" );
$sheet->setCellValue ( "Q{$row}", "上客位有無時間表/詳情" );
$sheet->setCellValue ( "R{$row}", "有無經營時間詳情" );
$sheet->setCellValue ( "S{$row}", "展示於巴士擋風玻璃的字牌(服務類型)" );

// Row 15
$row = 15;
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 12 );
$sheet->getStyle ( "I{$row}" )->getFont ()->setSize ( 12 );
$sheet->getStyle ( "O{$row}:R{$row}" )->getFont ()->setSize ( 18 );
$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setWrapText ( true );

$sheet->getStyle ( "A{$row}:S{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "B{$row}:R{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $lrStyle, false );

$sheet->setCellValue ( "A{$row}", "1" );
$sheet->setCellValue ( "I{$row}", "Cash  /  Octopus\nOther\n            $" );
$sheet->setCellValue ( "O{$row}", "Y / N" );
$sheet->setCellValue ( "P{$row}", "Y / N" );
$sheet->setCellValue ( "Q{$row}", "Y / N" );
$sheet->setCellValue ( "R{$row}", "Y / N" );

for($i = 2; $i <= 15; $i ++) {
	$row = 14 + $i;
	$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 12 );
	$sheet->getStyle ( "I{$row}" )->getFont ()->setSize ( 12 );
	$sheet->getStyle ( "O{$row}:R{$row}" )->getFont ()->setSize ( 18 );
	$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setWrapText ( true );
	
	$sheet->getStyle ( "A{$row}:S{$row}" )->applyFromArray ( $tThinStyle, false );
	$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
	$sheet->getStyle ( "B{$row}:R{$row}" )->applyFromArray ( $lThinStyle, false );
	$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
	$sheet->getStyle ( "S{$row}" )->applyFromArray ( $lrStyle, false );
	
	$sheet->setCellValue ( "A{$row}", $i );
	$sheet->setCellValue ( "I{$row}", "Cash  /  Octopus\nOther\n            $" );
	$sheet->setCellValue ( "O{$row}", "Y / N" );
	$sheet->setCellValue ( "P{$row}", "Y / N" );
	$sheet->setCellValue ( "Q{$row}", "Y / N" );
	$sheet->setCellValue ( "R{$row}", "Y / N" );
}

$sheet->getStyle ( "A{$row}:S{$row}" )->applyFromArray ( $bStyle, false );

// Setting worksheet zoom level
$sheet->getSheetView ()->setZoomScale ( 65 );

// set print scale
$sheet->getPageSetup ()->setScale ( 43 );

// set print area
$sheet->getPageSetup ()->setPrintArea ( "A1:S" . $row );

// set page size and orientation
$sheet->getPageSetup ()->setOrientation ( PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE );
$sheet->getPageSetup ()->setPaperSize ( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4 );

// Sheet 2
$pexcel->createSheet ();
$pexcel->setActiveSheetIndex ( 1 );
$sheet = $pexcel->getActiveSheet ();
$sheet->setTitle ( 'F3m (page2)' );
$sheet->setDefaultStyle ( $defaultStyle );
$sheet->getDefaultStyle ()->getAlignment ()->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
$sheet->getDefaultRowDimension ()->setRowHeight ( 40 );

// Set column widths
$sheet->getColumnDimension ( 'A' )->setWidth ( 4.1 );
$sheet->getColumnDimension ( 'B' )->setWidth ( 27.6 );
$sheet->getColumnDimension ( 'C' )->setWidth ( 13.2 );
$sheet->getColumnDimension ( 'D' )->setWidth ( 15.6 );
$sheet->getColumnDimension ( 'E' )->setWidth ( 23 );
$sheet->getColumnDimension ( 'F' )->setWidth ( 23 );
$sheet->getColumnDimension ( 'G' )->setWidth ( 14.4 );
$sheet->getColumnDimension ( 'H' )->setWidth ( 14.4 );
$sheet->getColumnDimension ( 'I' )->setWidth ( 18.4 );
$sheet->getColumnDimension ( 'J' )->setWidth ( 13.2 );
$sheet->getColumnDimension ( 'K' )->setWidth ( 10 );
$sheet->getColumnDimension ( 'L' )->setWidth ( 10 );
$sheet->getColumnDimension ( 'M' )->setWidth ( 11.3 );
$sheet->getColumnDimension ( 'N' )->setWidth ( 13.2 );
$sheet->getColumnDimension ( 'O' )->setWidth ( 16.8 );
$sheet->getColumnDimension ( 'P' )->setWidth ( 14.4 );
$sheet->getColumnDimension ( 'Q' )->setWidth ( 16.8 );
$sheet->getColumnDimension ( 'R' )->setWidth ( 14.4 );
$sheet->getColumnDimension ( 'S' )->setWidth ( 21.9 );

// Row 1
$row = 1;
$sheet->getRowDimension ( $row )->setRowHeight ( 15.75 );
$sheet->mergeCells ( "O{$row}:R{$row}" );
$sheet->getStyle ( "O{$row}:R{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

$sheet->getStyle ( "O{$row}:S{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $rStyle, false );

$sheet->setCellValue ( "O{$row}", "Service Details" );

// Row 2
$row = 2;
$sheet->getRowDimension ( $row )->setRowHeight ( 93 );
$sheet->getStyle ( "B{$row}:R{$row}" )->getFont ()->setSize ( 18 );
$sheet->getStyle ( "S{$row}" )->getFont ()->setSize ( 16 );
$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setWrapText ( true );

$sheet->getStyle ( "A{$row}:S{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "B{$row}:R{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $lrStyle, false );

$sheet->setCellValue ( "A{$row}", "no." );
$sheet->setCellValue ( "B{$row}", "車牌" );
$sheet->setCellValue ( "C{$row}", "車上\n載客量" );
$sheet->setCellValue ( "D{$row}", "營運\n牌照" );
$sheet->setCellValue ( "E{$row}", "起點" );
$sheet->setCellValue ( "F{$row}", "目的地" );
$sheet->setCellValue ( "G{$row}", "到站\n時間" );
$sheet->setCellValue ( "H{$row}", "離站\n時間" );
$sheet->setCellValue ( "I{$row}", "車資 / 付款方法" );
$sheet->setCellValue ( "J{$row}", "到站車\n上人數" );
$sheet->setCellValue ( "K{$row}", "落車\n人數" );
$sheet->setCellValue ( "L{$row}", "上車\n人數" );
$sheet->setCellValue ( "M{$row}", "剩餘\n人龍" );
$sheet->setCellValue ( "N{$row}", "離站車\n上人數" );
$sheet->setCellValue ( "O{$row}", "擋風玻璃有無詳情(黃色牌)" );
$sheet->setCellValue ( "P{$row}", "有無停站位置詳情" );
$sheet->setCellValue ( "Q{$row}", "上客位有無時間表/詳情" );
$sheet->setCellValue ( "R{$row}", "有無經營時間詳情" );
$sheet->setCellValue ( "S{$row}", "展示於巴士擋風玻璃的字牌(服務類型)" );

// Row 3
$row = 3;
$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 12 );
$sheet->getStyle ( "I{$row}" )->getFont ()->setSize ( 12 );
$sheet->getStyle ( "O{$row}:R{$row}" )->getFont ()->setSize ( 18 );
$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setWrapText ( true );

$sheet->getStyle ( "A{$row}:S{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "B{$row}:R{$row}" )->applyFromArray ( $lThinStyle, false );
$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "S{$row}" )->applyFromArray ( $lrStyle, false );

$sheet->setCellValue ( "A{$row}", "1" );
$sheet->setCellValue ( "I{$row}", "Cash  /  Octopus\nOther\n            $" );
$sheet->setCellValue ( "O{$row}", "Y / N" );
$sheet->setCellValue ( "P{$row}", "Y / N" );
$sheet->setCellValue ( "Q{$row}", "Y / N" );
$sheet->setCellValue ( "R{$row}", "Y / N" );

for($i = 2; $i <= 25; $i ++) {
	$row = 2 + $i;
	$sheet->getStyle ( "A{$row}" )->getFont ()->setSize ( 12 );
	$sheet->getStyle ( "I{$row}" )->getFont ()->setSize ( 12 );
	$sheet->getStyle ( "O{$row}:R{$row}" )->getFont ()->setSize ( 18 );
	$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	$sheet->getStyle ( "A{$row}:S{$row}" )->getAlignment ()->setWrapText ( true );
	
	$sheet->getStyle ( "A{$row}:S{$row}" )->applyFromArray ( $tThinStyle, false );
	$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
	$sheet->getStyle ( "B{$row}:R{$row}" )->applyFromArray ( $lThinStyle, false );
	$sheet->getStyle ( "O{$row}" )->applyFromArray ( $lStyle, false );
	$sheet->getStyle ( "S{$row}" )->applyFromArray ( $lrStyle, false );
	
	$sheet->setCellValue ( "A{$row}", $i );
	$sheet->setCellValue ( "I{$row}", "Cash  /  Octopus\nOther\n            $" );
	$sheet->setCellValue ( "O{$row}", "Y / N" );
	$sheet->setCellValue ( "P{$row}", "Y / N" );
	$sheet->setCellValue ( "Q{$row}", "Y / N" );
	$sheet->setCellValue ( "R{$row}", "Y / N" );
}

$sheet->getStyle ( "A{$row}:S{$row}" )->applyFromArray ( $bStyle, false );

// Setting worksheet zoom level
$sheet->getSheetView ()->setZoomScale ( 65 );

// set print scale
$sheet->getPageSetup ()->setScale ( 43 );

// set print area
$sheet->getPageSetup ()->setPrintArea ( "A1:S" . $row );

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