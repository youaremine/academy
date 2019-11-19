<?php
/**
 * 根據錄入的數據和上傳的Excel模板,自動生成有數據的Excel模板
 * @copyright 2007-2013 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2013-10-15
 */
include_once ('../includes/config.inc.php');
include_once ($conf ["path"] ["root"] . "../library/PHPExcel/PHPExcel.php");

$joinId = $_GET ['joinId'];
$fji = new FlowJobInfo ();
$fjia = new FlowJobInfoAccess ( $db );
$fji->joinId = $joinId;
if ($fji->joinId > 0) {
	$rs = $fjia->GetListSearch ( $fji );
	$rsNo = count ( $rs );
	if ($rsNo > 0) {
		$fji = $rs [0];
	}
}

// 獲取所有的Movent
$fm = new FlowMovement ();
$fma = new FlowMovementAccess ( $db );
$fm->joinId = $fji->joinId;
$rs = $fma->GetListSearch ( $fm );
$movements = array ();
$firstMoveId = $rs [0]->moveId;
foreach ( $rs as $v ) {
	$movements [$v->moveId] = $v->chiName;
}
// var_dump($movements);exit();

// 獲取調查範圍內的所有時間
$fmd = new FlowMovementDetail ();
$fmda = new FlowMovementDetailAccess ( $db );
$fmd->moveId = $firstMoveId;
$rs = $fmda->GetListSearch ( $fmd );
$suveyTimes = array ();
foreach ( $rs as $v ) {
	if ($v->TYPE1Quantity === NULL
			&& $v->TYPE2Quantity === NULL
			&& $v->TYPE3Quantity === NULL
			&& $v->TYPE4Quantity === NULL
			&& $v->TYPE5Quantity === NULL
			&& $v->TYPE6Quantity === NULL
			&& $v->TYPE7Quantity === NULL
			&& $v->TYPE8Quantity === NULL)
		continue;
	$surveyTimes [] = $v->startTime;
}

// 獲取所有Movent,所有時間的統計數據
$fmdt = new FlowMovementDetailTotal ();
$fmdta = new FlowMovementDetailTotalAccess ( $db );
$fmdt->joinId = $joinId;
$rs = $fmdta->GetListSearch ( $fmdt );
$data = array ();
foreach ( $rs as $v ) {
	if ($v->TYPE1Quantity === NULL
			&& $v->TYPE2Quantity === NULL
			&& $v->TYPE3Quantity === NULL
			&& $v->TYPE4Quantity === NULL
			&& $v->TYPE5Quantity === NULL
			&& $v->TYPE6Quantity === NULL
			&& $v->TYPE7Quantity === NULL
			&& $v->TYPE8Quantity === NULL)
		continue;
	$key = $movements [$v->moveId];
	$data [$key] [$v->startTime] = $v->totalHourPCUQuantity;
}

// var_dump($data);exit();

// Create Excel
date_default_timezone_set ( 'Asia/Shanghai' );

$pexcel = new PHPExcel ();

$pexcel->setActiveSheetIndex ( 0 );

$sheet = $pexcel->getActiveSheet ();

$row = 2;
$sheet->setCellValue ( "A{$row}", "Movements" );
foreach ( $surveyTimes as $k => $v ) {
	$column = PHPExcel_Cell::stringFromColumnIndex ( $k + 1 );
	$v = substr ( $v, 0, 5 );
	$sheet->setCellValue ( "{$column}{$row}", $v );
}

$row = 3;
foreach ( $data as $k => $v ) {
	$sheet->setCellValue ( "A{$row}", $k );
	foreach ( $surveyTimes as $key => $time ) {
		$column = PHPExcel_Cell::stringFromColumnIndex ( $key + 1 );
		$sheet->setCellValue ( "{$column}{$row}", $v [$time] );
	}
	$row ++;
}

$title = "Table Summary";
$pexcel->getActiveSheet ()->setTitle ( $title );

// Redirect output to a clients web browser (Excel2007)
header ( 'Content-Type: application/vnd.ms-excel; charset=utf-8' );
$fileName = "_".$fji->jobNo."_summary.xls";
$start = strrpos ( $fileName, "/" ) + 1;
$fileName = substr ( $fileName, $start );
header ( "Content-Disposition: attachment;filename=" . date ( "YmdHis" ) . "_" . $fileName );
header ( 'Cache-Control: max-age=0' );
// $objWriter = PHPExcel_IOFactory::createWriter($pexcel, 'Excel2007');
$objWriter = PHPExcel_IOFactory::createWriter ( $pexcel, 'Excel5' );
$objWriter->save ( 'php://output' );
exit ();