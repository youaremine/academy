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
if (empty ( $_GET ["ddlStatus"] )) {
	$fileName = date ( "Y" ) . "_all_surveyor_list_" . date ( "Ymd" ) . ".xls";
} else {
	$fileName = date ( "Y" ) . "_surveyor_list_" . date ( "Ymd" ) . ".xls";
}

// Creating a workbook
$pexcel = new PHPExcel ();
// Rename sheet
$pexcel->getActiveSheet ()->setTitle ( "Sheet1" );

$pexcel->setActiveSheetIndex ( 0 );
$sheet = $pexcel->getActiveSheet ();
$defaultStyle = new PHPExcel_Style ();
$defaultStyle->getFont ()->setName ( 'Arial' );
$defaultStyle->getFont ()->setSize ( 10 );
$sheet->setDefaultStyle ( $defaultStyle );

// Freeze Pane row 1;
$sheet->freezePane ( "A2" );

// Set column widths
$sheet->getColumnDimension ( 'A' )->setWidth ( 9.2 );
$sheet->getColumnDimension ( 'B' )->setWidth ( 22.2 );
$sheet->getColumnDimension ( 'C' )->setWidth ( 17.1 );
$sheet->getColumnDimension ( 'D' )->setWidth ( 15.2 );
$sheet->getColumnDimension ( 'E' )->setWidth ( 9.2 );
$sheet->getColumnDimension ( 'F' )->setWidth ( 11.2 );
$sheet->getColumnDimension ( 'G' )->setWidth ( 9.2 );
$sheet->getColumnDimension ( 'H' )->setWidth ( 9.2 );
$sheet->getColumnDimension ( 'I' )->setWidth ( 62.2 );
$sheet->getColumnDimension ( 'J' )->setWidth ( 18.5 );
$sheet->getColumnDimension ( 'K' )->setWidth ( 9.4 );
$sheet->getColumnDimension ( 'L' )->setWidth ( 9.4 );
$sheet->getColumnDimension ( 'M' )->setWidth ( 9.4 );
$sheet->getColumnDimension ( 'N' )->setWidth ( 9.4 );
$sheet->getColumnDimension ( 'O' )->setWidth ( 9.4 );

// Row 1
$row = 1;

$sheet->getStyle ( "A{$row}:O{$row}" )->getFill ()->setFillType ( PHPExcel_Style_Fill::FILL_SOLID );
$sheet->getStyle ( "A{$row}:O{$row}" )->getFill ()->getStartColor ()->setARGB ( PHPExcel_Style_Color::COLOR_YELLOW );

$sheet->setCellValue ( "A{$row}", "" );
$sheet->setCellValue ( "B{$row}", "Name of surveyor" );
$sheet->setCellValue ( "C{$row}", "Contact of surveyor" );
$sheet->setCellValue ( "D{$row}", "Home" );
$sheet->setCellValue ( "E{$row}", "District" );
$sheet->setCellValue ( "F{$row}", "Supervisor?" );
$sheet->setCellValue ( "G{$row}", "Personal Record" );
$sheet->setCellValue ( "H{$row}", "" );
$sheet->setCellValue ( "I{$row}", "Bank" );
$sheet->setCellValue ( "J{$row}", "A/C No." );
$sheet->setCellValue ( "K{$row}", "VIP" );
$sheet->setCellValue ( "L{$row}", "WhatsAPP" );
$sheet->setCellValue ( "M{$row}", "Email" );
$sheet->setCellValue ( "N{$row}", "Fax" );
$sheet->setCellValue ( "O{$row}", "Remarks" );

$s = new Surveyor ();
if (UserLogin::HasPermission ( "surveyor_contractor_all" )) {
	$s->company = '';
} else {
	$sur->company = UserLogin::CanDoCompany (); // 分判商
}

$s->status = $_GET ["ddlStatus"];
//只导出调查员+深圳兼职
$s->survMultiType = "'surveyor','sz-part-time'";

$sa = new SurveyorAccess ( $db );

$s->order = " ORDER BY survId ASC";

$rs = $sa->GetListSearch ( $s );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$s = $rs [$i];
	$row ++;
	$sheet->setCellValue ( "A{$row}", $s->survId );
	$sheet->setCellValue ( "B{$row}", $s->engName );
	$sheet->setCellValue ( "C{$row}", $s->contact );
	$sheet->setCellValue ( "D{$row}", $s->survHome );
	$sheet->setCellValue ( "E{$row}", $s->dipaCode );
	$sheet->setCellValue ( "F{$row}", $s->IsSupervisor );
	$sheet->setCellValue ( "G{$row}", "" );
	$sheet->setCellValue ( "H{$row}", $s->personalRecord );
	$sheet->setCellValue ( "I{$row}", $s->bank );
	$sheet->getCell ( "J{$row}" )->setValueExplicit ( $s->accountNo, PHPExcel_Cell_DataType::TYPE_STRING );
	$sheet->setCellValue ( "K{$row}", $s->VIP );
	$sheet->setCellValue ( "L{$row}", $s->whatsAPP );
	$sheet->setCellValue ( "M{$row}", $s->email );
	$sheet->setCellValue ( "N{$row}", $s->fax );
	$sheet->setCellValue ( "O{$row}", $s->remarks );
}

// 全部加上邊框
$ltrbThinStyle = array (
		'borders' => array (
				'left' => array (
						'style' => PHPExcel_Style_Border::BORDER_THIN 
				),
				'top' => array (
						'style' => PHPExcel_Style_Border::BORDER_THIN 
				),
				'right' => array (
						'style' => PHPExcel_Style_Border::BORDER_THIN 
				),
				'bottom' => array (
						'style' => PHPExcel_Style_Border::BORDER_THIN 
				) 
		) 
);
$sheet->getStyle ( "A1:O" . $row )->applyFromArray ( $ltrbThinStyle, false );

// set alignment center.
$sheet->getStyle ( "A1:A" . $row )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "C1:C" . $row )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "F1:F" . $row )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$sheet->getStyle ( "H1:H" . $row )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

// set zoom
$sheet->getSheetView ()->setZoomScale ( 85 );

// set print scale
// $sheet->getPageSetup()->setScale(85);

// set print area
// $sheet->getPageSetup()->setPrintArea("A1:O".$row);

// set page size and orientation
$sheet->getPageSetup ()->setOrientation ( PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT );
$sheet->getPageSetup ()->setPaperSize ( PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4 );

// Redirect output to a clients web browser (Excel5)
header ( 'Content-Type: application/vnd.ms-excel; charset=utf-8' );
header ( "Content-Disposition: attachment;filename=" . $fileName );
header ( 'Cache-Control: max-age=0' );
$objWriter = PHPExcel_IOFactory::createWriter ( $pexcel, 'Excel5' );
$objWriter->save ( 'php://output' );
exit ();
