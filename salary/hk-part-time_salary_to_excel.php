<?php
/*
 * Header: Create: 2014-01-01 Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");
include_once ($conf["path"]["root"] . "../library/PHPExcel/PHPExcel.php");

// 检查是否登录
if(! UserLogin::IsLogin()){
	header("Location:login.php");
	exit();
}

/**
 *
 * 初始化值模板
 *
 * @param string $complateJobNos        	
 */
function GetProjectValuesTemplate($complateJobNos){
	$arr = array ();
	foreach($complateJobNos as $k => $v){
		$arr[$v]["surveyHour"] = "";
		$arr[$v]["wages"] = "";
		$arr[$v]["transportExpenses"] = "";
		$arr[$v]["salaryTotal"] = "";
	}
	return $arr;
}

/**
 *
 * 替指定的值换值
 *
 * @param unknown_type $str        	
 * @param unknown_type $salary        	
 */
function ReplaceProjectValues($arr,$salary){
	$v = $salary["complateJobNo"];
	$arr[$v]["surveyHour"] = $salary["surveyHour"];
	$arr[$v]["wages"] = $salary["wages"];
	$arr[$v]["transportExpenses"] = $salary["transportExpenses"];
	$arr[$v]["salaryTotal"] = $salary["salaryTotal"];
	return $arr;
}

if(! empty($_REQUEST['ddlMonth'])){
	$ddlMonth = $_REQUEST['ddlMonth'];
	$surDateStart = $ddlMonth . "-01";
	$surDateStartTime = strtotime($surDateStart);
	$surveyDateEnd = date("Y-m-d",mktime(0,0,0,date("m",$surDateStartTime) + 1,date("d",$surDateStartTime),date("Y",$surDateStartTime)));
}else{
	$ddlMonth = date("Y-m",strtotime("-1 month"));
	$surDateStart = $ddlMonth . "-01";
	$surDateStartTime = strtotime($surDateStart);
	$surveyDateEnd = date("Y-m-d",mktime(0,0,0,date("m",$surDateStartTime) + 1,date("d",$surDateStartTime),date("Y",$surDateStartTime)));
}

$tableName = 'Survey_MainSchedule';
$mshl = new MainScheduleHistoryLog();
$mshl->backupMonth = $ddlMonth;
$mshla = new MainScheduleHistoryLogAccess($db);
$rs = $mshla->GetListSearch($mshl);
if(! empty($rs)){
	$mshl = $rs[0];
	$tableName = $mshl->tableName;
}

$fileName = date("Y-m",strtotime($surDateStart)) . '-HK-Part-Time-Salary.xls';

// Creating a workbook
$pexcel = new PHPExcel();
// Rename sheet
$pexcel->getActiveSheet()->setTitle("Traffic_Code");

$pexcel->setActiveSheetIndex(0);
$sheet = $pexcel->getActiveSheet();
// $defaultStyle = new PHPExcel_Style ();
// $defaultStyle->getFont ()->setName ( 'Arial' );
// $defaultStyle->getFont ()->setSize ( 10 );
// $sheet->setDefaultStyle ( $defaultStyle );

// Set column widths
$sheet->getColumnDimension('B')->setWidth(12);
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(40);
$sheet->getColumnDimension('E')->setWidth(40);
$sheet->getColumnDimension('F')->setWidth(30);
$sheet->getColumnDimension('G')->setWidth(20);

// 获取数据
$complateJobNos = array ();

// Other projects
$salaryType = "hk-part-time";
$sql = "SELECT surveyorId as surveyorCode,s.engName,s.chiName,s.ozzoCode,s.bank,s.accountNo,s.contact,s.IsSupervisor,projectCode AS complateJobNo,SUM(wages) AS totalWages
	,SUM(transportExpenses) AS transportExpenses,SUM(surveyHour) AS estimatedManHour,0 AS OnBoardCost,0 AS wagesTaOnBoard 
	,SUM(total) AS salaryTotal FROM Survey_OtherSalary os
	INNER JOIN Survey_Surveyor s ON os.surveyorId=s.survId	 
	WHERE 1=1 
	  AND DATE_FORMAT(surveyDate,'%Y-%m-%d') >= '" . $surDateStart . "' 
	  AND DATE_FORMAT(surveyDate,'%Y-%m-%d') < '" . $surveyDateEnd . "'  
	  AND delFlag = 'no' 
	  AND salaryType='{$salaryType}'
	  GROUP BY surveyorId,surveyorEngName,projectCode
	  ORDER BY CAST(surveyorCode AS SIGNED) ASC";
$db->query($sql);

while($db->next_record()){
	$salary['surveyorCode'] = $db->Record['surveyorCode'];
	$salary['ozzoCode'] = $db->Record['ozzoCode'];
	$salary['engName'] = $db->Record['engName'];
	$salary['chiName'] = $db->Record['chiName'];
	$salary['bank'] = $db->Record['bank'];
	$salary['accountNo'] = $db->Record['accountNo'];
	$salary['contact'] = $db->Record['contact'];
	$salary['IsSupervisor'] = $db->Record['IsSupervisor'];
	$salary['surveyHour'] = $db->Record['estimatedManHour'];
	$salary['complateJobNo'] = $db->Record['complateJobNo'];
	$salary['wages'] = round($db->Record['totalWages'],$conf['decimal']['precision']);
	;
	$salary['transportExpenses'] = round($db->Record['transportExpenses'],$conf['decimal']['precision']);
	;
	$salary['wagesTaOnBoard'] = 0;
	$salary['salaryTotal'] = round($db->Record['salaryTotal'],$conf['decimal']['precision']);
	;
	$salary['isOtherProject'] = 1;
	if(! empty($salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']])){
		$salary["surveyHour"] += $salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']]["surveyHour"];
		$salary["wages"] += $salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']]["wages"];
		$salary["transportExpenses"] += $salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']]["transportExpenses"];
		$salary["salaryTotal"] += $salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']]["salaryTotal"];
	}
	$salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']] = $salary;
	if(! in_array($salary['complateJobNo'],$complateJobNos)){
		$complateJobNos[] = $salary['complateJobNo'];
	}
}
// sort
function cmp($a,$b){
	if($a['surveyorCode'] == $b['surveyorCode']){
		return 0;
	}
	return ($a['surveyorCode'] < $b['surveyorCode'])?- 1:1;
}
usort($salarys,"cmp");

// 项目名称
$row = 0;
$row = $row + 1;
$colEnd = 0;
for($i = 0;$i < count($complateJobNos);$i ++){
	$colStart = 7 + 4 * ($i);
	$colEnd = $colStart + 3;
	$cName = PHPExcel_Cell::stringFromColumnIndex($colStart);
	$sheet->setCellValue("{$cName}{$row}",$complateJobNos[$i]);
	$cEndName = PHPExcel_Cell::stringFromColumnIndex($colEnd);
	$sheet->mergeCells("{$cName}{$row}:{$cEndName}{$row}");
}

// 项目子标题
$row = $row + 1;
$sheet->setCellValue("A{$row}","Code");
$sheet->setCellValue("B{$row}","OZZO Code");
$sheet->setCellValue("C{$row}","Name of surveyor");
$sheet->setCellValue("D{$row}","");
$sheet->setCellValue("E{$row}","Bank");
$sheet->setCellValue("F{$row}","Account No.",PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValue("G{$row}","Contact of surveyor",PHPExcel_Cell_DataType::TYPE_STRING);
for($i = 0;$i < count($complateJobNos);$i ++){
	$colStart = 7 + 4 * ($i);
	$sheet->setCellValueByColumnAndRow($colStart,$row,'Hour');
	$sheet->setCellValueByColumnAndRow(($colStart + 1),$row,'Wages');
	$sheet->setCellValueByColumnAndRow(($colStart + 2),$row,'TE');
	$sheet->setCellValueByColumnAndRow(($colStart + 3),$row,'Total');
}

$sheet->setCellValueByColumnAndRow(($colEnd + 1),$row,'Total');
$sheet->setCellValueByColumnAndRow(($colEnd + 2),$row,'Leader');
$sheet->setCellValueByColumnAndRow(($colEnd + 3),$row,'Remark');

// 填充数据
$i = 0;
$j = 0;
$salaryTotal = 0;
$salaryTotalAll = 0;
$surveyor = array ();
$projectValues = GetProjectValuesTemplate($complateJobNos);
foreach($salarys as $k => $v){
	if($i > 0 && $vl['surveyorCode'] != $v['surveyorCode']){
		// $projectValues = EmptyProjectValues($projectValues,$complateJobNos);
		$row = $row + 1;
		$sheet->setCellValue("A{$row}",$vl['surveyorCode'],PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue("B{$row}",$vl['ozzoCode']);
		$sheet->setCellValue("C{$row}",$vl['engName']);
		$sheet->setCellValue("D{$row}",$vl['chiName']);
		$sheet->setCellValue("E{$row}",$vl['bank']);
		$sheet->setCellValue("F{$row}"," " . $vl['accountNo'],PHPExcel_Cell_DataType::TYPE_STRING);
		$sheet->setCellValue("G{$row}"," " . $vl['contact'],PHPExcel_Cell_DataType::TYPE_STRING);
		$colStart = 0;
		for($m = 0;$m < count($complateJobNos);$m ++){
			$colStart = 7 + 4 * ($m);
			$sheet->setCellValueByColumnAndRow($colStart,$row,$projectValues[$complateJobNos[$m]]["surveyHour"]);
			$sheet->setCellValueByColumnAndRow(($colStart + 1),$row,$projectValues[$complateJobNos[$m]]["wages"]);
			$sheet->setCellValueByColumnAndRow(($colStart + 2),$row,$projectValues[$complateJobNos[$m]]["transportExpenses"]);
			$sheet->setCellValueByColumnAndRow(($colStart + 3),$row,$projectValues[$complateJobNos[$m]]["salaryTotal"]);
		}
		$sheet->setCellValueByColumnAndRow(($colStart + 4),$row,round($salaryTotalAll,$conf['decimal']['precision']));
		$sheet->setCellValueByColumnAndRow(($colStart + 5),$row,$vl['IsSupervisor']);
		$sheet->setCellValueByColumnAndRow(($colStart + 6),$row,"SALARY " . date("Ym",strtotime($surDateStart)));
		
		$salaryTotalAll = 0;
		$taTotal = 0;
		$projectValues = GetProjectValuesTemplate($complateJobNos);
	}
	$projectValues = ReplaceProjectValues($projectValues,$v);
	$taTotal = $v['transportExpenses'];
	$salaryTotal = $v['salaryTotal'];
	$salaryTotalAll += $salaryTotal;
	$i ++;
	$vl = $v;
}

// the last row.
$row = $row + 1;
$sheet->setCellValue("A{$row}",$vl['surveyorCode'],PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValue("B{$row}",$vl['ozzoCode']);
$sheet->setCellValue("C{$row}",$vl['engName']);
$sheet->setCellValue("D{$row}",$vl['chiName']);
$sheet->setCellValue("E{$row}",$vl['bank']);
$sheet->setCellValue("F{$row}"," " . $vl['accountNo'],PHPExcel_Cell_DataType::TYPE_STRING);
$sheet->setCellValue("G{$row}"," " . $vl['contact'],PHPExcel_Cell_DataType::TYPE_STRING);
$colStart = 0;
for($m = 0;$m < count($complateJobNos);$m ++){
	$colStart = 7 + 4 * ($m);
	$sheet->setCellValueByColumnAndRow($colStart,$row,$projectValues[$complateJobNos[$m]]["surveyHour"]);
	$sheet->setCellValueByColumnAndRow(($colStart + 1),$row,$projectValues[$complateJobNos[$m]]["wages"]);
	$sheet->setCellValueByColumnAndRow(($colStart + 2),$row,$projectValues[$complateJobNos[$m]]["transportExpenses"]);
	$sheet->setCellValueByColumnAndRow(($colStart + 3),$row,$projectValues[$complateJobNos[$m]]["salaryTotal"]);
}
$sheet->setCellValueByColumnAndRow(($colStart + 4),$row,round($salaryTotalAll,$conf['decimal']['precision']));
$sheet->setCellValueByColumnAndRow(($colStart + 5),$row,$vl['IsSupervisor']);
$sheet->setCellValueByColumnAndRow(($colStart + 6),$row,"SALARY " . date("Ym",strtotime($surDateStart)));

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
$endName = PHPExcel_Cell::stringFromColumnIndex($colStart + 8);
$sheet->getColumnDimension($endName)->setWidth(20);
$sheet->getStyle("A1:{$endName}{$row}")->applyFromArray($ltrbThinStyle,false);

// set alignment center.
$sheet->getStyle("A1:{$endName}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Redirect output to a clients web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header("Content-Disposition: attachment;filename=" . $fileName);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($pexcel,'Excel5');
$objWriter->save('php://output');
exit();

?>
