<?php
/**
 * 根據錄入的數據和上傳的Excel模板,自動生成有數據的Excel模板
 * @copyright 2007-2013 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2013-10-15
 */
include_once('../includes/config.inc.php');
include_once($conf ["path"] ["root"] . "../library/PHPExcel/PHPExcel.php");

$joinId = $_GET ['joinId'];
$fji = new FlowJobInfo ();
$fjia = new FlowJobInfoAccess ($db);
$fji->joinId = $joinId;
if ($fji->joinId > 0) {
    $rs = $fjia->GetListSearch($fji);
    $rsNo = count($rs);
    if ($rsNo > 0) {
        $fji = $rs [0];
    }
}

// 獲取所有的Movent
$fm = new FlowMovement();
$fma = new FlowMovementAccess($db);
$fm->joinId = $fji->joinId;
$rsMovement = $fma->GetListSearch($fm);

// Create Excel
date_default_timezone_set('Asia/Shanghai');
$pexcel = new PHPExcel ();
$pexcel->setActiveSheetIndex(0);
$sheet = $pexcel->getActiveSheet();

$row = 2;
$sheet->setCellValue("A{$row}", 'JOB TITLE');
$row = 3;
$sheet->setCellValue("A{$row}", 'JOB NO.');
$sheet->setCellValue("C{$row}", $fji->jobNo);
$row = 4;
$sheet->setCellValue("A{$row}", 'DATE');
$sheet->setCellValue("C{$row}", $fji->surveyDate);
$row = 6;
$sheet->setCellValue("A{$row}", 'Survey Period');
$sheet->setCellValue("D{$row}", $fji->periodStartTime);
$sheet->setCellValue("E{$row}", '-');
$sheet->setCellValue("F{$row}", $fji->periodEndTime);
$row = 9;
$sheet->setCellValue("A{$row}", 'FOR ENTERING DATA, DELETE ALL BLUE AREAS AND EDIT THE SURVEY PERIOD');
$row = 10;
$sheet->setCellValue("A{$row}", 'TO ACTIVATE MACRO FOR DATA ENTRY, PRESS "CTRL A", TO STOP MACRO, PRESS "CTRL BREAK".');
$row = 11;
$sheet->setCellValue("C{$row}", 'C');
$sheet->setCellValue("D{$row}", 'D');
$sheet->setCellValue("E{$row}", 'E');
$sheet->setCellValue("F{$row}", 'F');
$sheet->setCellValue("G{$row}", 'G');
$sheet->setCellValue("H{$row}", 'H');

$fmd = new FlowMovementDetail();
$fmda = new FlowMovementDetailAccess($db);
$row = 12;
foreach ($rsMovement as $v) {
    $sheet->setCellValue("A{$row}", 'MOVEMENT');
    $sheet->setCellValue("D{$row}", $v->chiName);
    $sheet->setCellValue("E{$row}", 'ROAD TYPE:');
    $sheet->setCellValue("L{$row}", $v->pcfaId);
    $row++;
    $sheet->setCellValue("A{$row}", 'TIME');
    $sheet->setCellValue("C{$row}", 'TYPE1');
    $sheet->setCellValue("D{$row}", 'TYPE2');
    $sheet->setCellValue("E{$row}", 'TYPE3');
    $sheet->setCellValue("F{$row}", 'TYPE4');
    $sheet->setCellValue("G{$row}", 'TYPE5');

    // 獲取調查範圍內的所有時間
    $fmd->moveId = $v->moveId;
    $rs = $fmda->GetListSearch($fmd);
    $suveyTimes = array();
    foreach ($rs as $v2) {
        $row++;
        $sheet->setCellValue("A{$row}", $v2->startTime);
        $sheet->setCellValue("B{$row}", $v2->endTime);
        $sheet->setCellValue("C{$row}", $v2->TYPE1Quantity);
        $sheet->setCellValue("D{$row}", $v2->TYPE2Quantity);
        $sheet->setCellValue("E{$row}", $v2->TYPE3Quantity);
        $sheet->setCellValue("F{$row}", $v2->TYPE4Quantity);
        $sheet->setCellValue("G{$row}", $v2->TYPE5Quantity);
    }
    $row += 2;
}

$title = "Survey";
$pexcel->getActiveSheet()->setTitle($title);

// Redirect output to a clients web browser (Excel2007)
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
$fileName = "_" . $fji->jobNo . "_summary.xls";
$start = strrpos($fileName, "/") + 1;
$fileName = substr($fileName, $start);
header("Content-Disposition: attachment;filename=" . date("YmdHis") . "_" . $fileName);
header('Cache-Control: max-age=0');
// $objWriter = PHPExcel_IOFactory::createWriter($pexcel, 'Excel2007');
$objWriter = PHPExcel_IOFactory::createWriter($pexcel, 'Excel5');
$objWriter->save('php://output');
exit ();