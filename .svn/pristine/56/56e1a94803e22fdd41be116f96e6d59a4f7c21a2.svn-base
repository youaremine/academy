<?php
/**
 * 根據錄入的數據和上傳的Excel模板,自動生成有數據的Excel模板
 * @copyright 2007-2013 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2013-10-31
 */
include_once ('../includes/config.inc.php');
include_once ($conf ["path"] ["root"] . "../library/PHPExcel/PHPExcel.php");

$joinId = $_GET ['joinId'];

// Sheet - Table Summary
$fji = new FlowJobInfo ();
$fjia = new FlowJobInfoAccess ( $db );
$fji->joinId = $joinId;
$rs = $fjia->GetListSearch ( $fji );
$rsNo = count ( $rs );
$fji = $rs [0];

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
	if ($v->TYPE1Quantity === NULL)
		continue;
	$surveyTimes [] = $v->startTime;
}

// 獲取所有Movement,所有時間的統計數據
$fmdt = new FlowMovementDetailTotal ();
$fmdta = new FlowMovementDetailTotalAccess ( $db );
$fmdt->joinId = $joinId;
$rs = $fmdta->GetListSearch ( $fmdt );
$data = array ();
foreach ( $rs as $v ) {
	if ($v->TYPE1Quantity === NULL)
		continue;
	$key = $movements [$v->moveId];
	$data [$key] [$v->startTime] = $v->totalHourPCUQuantity;
}
// var_dump($data);exit();

$startTime = $_GET ['startTime'];
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
$fileName = "../" . $fji->flowChartTemplate;

// 獲取所有的Movent
$fm = new FlowMovement ();
$fma = new FlowMovementAccess ( $db );
$fm->joinId = $fji->joinId;
$rs = $fma->GetListSearch ( $fm );
$movements = array ();
foreach ( $rs as $v ) {
	$movements [$v->moveId] = $v->chiName;
}
// var_dump($movements);exit();

// 獲取所有Movent對應該時間的統計數據
$fmdt = new FlowMovementDetailTotal ();
$fmdta = new FlowMovementDetailTotalAccess ( $db );
$fmdt->joinId = $joinId;
$fmdt->startTime = $startTime;
$rs = $fmdta->GetListSearch ( $fmdt );
$data = array ();
foreach ( $rs as $v ) {
	$key = $movements [$v->moveId];
	$data [$key] = $v->totalHourPCUQuantity;
}
// var_dump($data);exit();

// Check prerequisites
if (! file_exists ( $fileName )) {
	exit ( "not found {$fileName}.\n" );
}

// 讀取Excel
date_default_timezone_set ( 'Asia/ShangHai' );

$reader = PHPExcel_IOFactory::createReader ( 'Excel2007' );
// $reader = PHPExcel_IOFactory::createReader('Excel5');
$pexcel = $reader->load ( $fileName ); // 载入excel文件
$sheet = $pexcel->getSheet ( 0 ); // 读取第一個工作表
                               
// $movement = array("J1-1","J1-2");
                               // $data = array("J1-1"=>30,"J1-2"=>50);
                               
// 替换生成之后的数据
foreach ( $sheet->getRowIterator () as $row ) {
	$cellIterator = $row->getCellIterator ();
	$cellIterator->setIterateOnlyExistingCells ( false ); // This loops all cells,
	foreach ( $cellIterator as $cell ) {
		$cellValue = $cell->getValue ();
		if (! empty ( $cellValue )) {
			if (in_array ( $cellValue, $movements )) {
				$cell->setValue ( $data [$cellValue] );
			}
		}
	}
}

// ↑ ↓ ← → ↰ ↱ ↲ ↳ ↴ ↵ ↖ ↗ ↙ ↘

$title = str_replace ( ":", "", $startTime );
$pexcel->getActiveSheet ()->setTitle ( $title );

// Redirect output to a clients web browser (Excel2007)
header ( 'Content-Type: application/vnd.ms-excel; charset=utf-8' );
$start = strrpos ( $fileName, "/" ) + 1;
$fileName = substr ( $fileName, $start );
header ( "Content-Disposition: attachment;filename=" . date ( "YmdHis" ) . "_{$fji->jobNo}.xls" );
header ( 'Cache-Control: max-age=0' );
// $objWriter = PHPExcel_IOFactory::createWriter($pexcel, 'Excel2007');
$objWriter = PHPExcel_IOFactory::createWriter ( $pexcel, 'Excel5' );
$objWriter->save ( 'php://output' );
exit ();