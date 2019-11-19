<?php
/*
 * Header: Create: 2012-03-13 Auther: Xiaoqiang.Wu<jamblues@gmail.com>
 */
include_once ("./includes/config.inc.php");
include_once ($conf["path"]["root"] . "../library/PHPExcel/PHPExcel.php");

// 检查是否登录
if(! UserLogin::IsLogin()){
	header("Location:login.php");
	exit();
}

if($_GET['supaId'] == '')
	header("Location:list.php");
	// 生成调查结果所需要的数据
include_once ('survey_product_data.php');
$sp->surDate = $sp->surDate . " (" . date("l",strtotime($sp->surDate)) . ")";
$fileName = $sp->refNo . "-" . $sp->routeNo;
$fileName = CustomerReplace($fileName);
$fileName = $fileName . '.xls';
$weathers = getArray('weather');
$weatherName = $weathers[$sp->weatherId];

// Creating a workbook
$pexcel = new PHPExcel();
// Rename sheet
$pexcel->getActiveSheet()->setTitle($sp->refNo);
$pexcel->setActiveSheetIndex(0);
$sheet = $pexcel->getActiveSheet();
$defaultStyle = new PHPExcel_Style();
$defaultStyle->getFont()->setName('Arial');
$defaultStyle->getFont()->setSize(10);
$sheet->setDefaultStyle($defaultStyle);
// 報表樣式文件
include_once ('./survey_to_excel_style.php');
// Set column widths
$sheet->getColumnDimension('L')->setWidth(11);
$sheet->getColumnDimension('M')->setWidth(11);
$sheet->getColumnDimension('N')->setWidth(11);

$person = $conf['bus']['big']['person'];

// Row 2
$row = 2;
$sheet->mergeCells("A{$row}:M{$row}");
$sheet->getStyle("A{$row}:M{$row}")->applyFromArray($cuf,false);
$sheet->setCellValue("A{$row}",$subjectName);

// Row 4
$row = 4;
$sheet->getStyle("A{$row}")->applyFromArray($bf,false);
$sheet->getStyle("J{$row}")->applyFromArray($bf,false);
$sheet->setCellValue("A{$row}",'Ref No. :');
$sheet->setCellValue("C{$row}",$tdRefNo);
$sheet->setCellValue("J{$row}",'Ozzo Ref No. :');
$sheet->setCellValue("L{$row}",$sp->refNo);

// Row 5
$row = 5;
$sheet->getStyle("A{$row}")->applyFromArray($bf,false);
$sheet->getStyle("J{$row}")->applyFromArray($bf,false);
$sheet->setCellValue("A{$row}",'Route No. :');
$sheet->setCellValue("C{$row}",$sp->routeNo);

// Row 6
$row = 6;
$sheet->getStyle("A{$row}")->applyFromArray($bf,false);
$sheet->getStyle("J{$row}")->applyFromArray($bf,false);
$sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3);
$sheet->getStyle("N{$row}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME3);
$sheet->setCellValue("A{$row}",'Date :');
$sheet->setCellValue("C{$row}",$sp->surDate);
$sheet->setCellValue("J{$row}",'Survey Period :');
$sheet->setCellValue("L{$row}",$sp->surFromTime);
$sheet->setCellValue("M{$row}",'to');
$sheet->setCellValue("N{$row}",$sp->surToTime);

// Row 7
$row = 7;
$sheet->getStyle("A{$row}")->applyFromArray($bf,false);
$sheet->getStyle("J{$row}")->applyFromArray($bf,false);
$sheet->setCellValue("A{$row}",'Location :');
$sheet->setCellValue("C{$row}",$sp->location);
$sheet->setCellValue("J{$row}",'Direction :');
$sheet->setCellValue("L{$row}",$sp->bounds);

// 统计表格
$row = $row + 1;
$sheet->setCellValue("N{$row}",'Table 1');
$sheet->getStyle("N{$row}")->applyFromArray($bf,false);

$row = $row + 1;
$sheet->mergeCells("C{$row}:E{$row}");
$sheet->mergeCells("G{$row}:M{$row}");
$sheet->getStyle("A{$row}")->applyFromArray($ltStyle,false);
$sheet->getStyle("B{$row}:M{$row}")->applyFromArray($tStyle,false);
$sheet->getStyle("N{$row}")->applyFromArray($trStyle,false);
$sheet->setCellValue("A{$row}",'Time');
$sheet->setCellValue("B{$row}",'No. of');
$sheet->setCellValue("C{$row}",'No. of');
$sheet->setCellValue("F{$row}",'Carrying');
$sheet->setCellValue("G{$row}",'No. of Passengers');
$sheet->setCellValue("N{$row}",'Average');

$row = $row + 1;
$sheet->mergeCells("C{$row}:E{$row}");
$sheet->mergeCells("G{$row}:H{$row}");
$sheet->mergeCells("K{$row}:L{$row}");
$sheet->getStyle("A{$row}")->applyFromArray($lStyle,false);
$sheet->getStyle("N{$row}")->applyFromArray($rStyle,false);
$sheet->setCellValue("A{$row}",'(Half-');
$sheet->setCellValue("B{$row}",'Arrivals');
$sheet->setCellValue("C{$row}",'Departures');
$sheet->setCellValue("F{$row}",'Capacity');
$sheet->setCellValue("G{$row}",'On Arrival');
$sheet->setCellValue("I{$row}",'Set');
$sheet->setCellValue("J{$row}",'Picked');
$sheet->setCellValue("K{$row}",'On Departure');
$sheet->setCellValue("M{$row}",'Left Behind');
$sheet->setCellValue("N{$row}",'Waiting');

$row = $row + 1;
$sheet->getStyle("A{$row}")->applyFromArray($lbStyle,false);
$sheet->getStyle("B{$row}:M{$row}")->applyFromArray($bStyle,false);
$sheet->getStyle("N{$row}")->applyFromArray($rbStyle,false);
$sheet->setCellValue("A{$row}",'Hourly)');
$sheet->setCellValue("C{$row}",'SOS');
$sheet->setCellValue("D{$row}",'Obs.');
$sheet->setCellValue("E{$row}",'Diff.');
$sheet->setCellValue("G{$row}",'No.');
$sheet->setCellValue("H{$row}",'(%)');
$sheet->setCellValue("I{$row}",'Down');
$sheet->setCellValue("J{$row}",'Up');
$sheet->setCellValue("K{$row}",'No.');
$sheet->setCellValue("L{$row}",'(%)');
$sheet->setCellValue("M{$row}",'(Occasion)');
$sheet->setCellValue("N{$row}",'Time(mins.)');

// 预算出详细表格分布情况
$detailStartRow = 54;
$detailEndtRow = 76;

// 统计表格数据
$timeHalfHourlyFormula = "=IF(MINUTE(A%s)=15,TIME(HOUR(A%s),45,0),TIME(HOUR(A%s)+1,15,0))";
$timeHalfHourlyFormula = "=IF(MINUTE(A%s)=0,TIME(HOUR(A%s),30,0),TIME(HOUR(A%s)+1,0,0))";
$totalStartRow = $row + 1;
for($i = 0;$i < $busTimePartNum;$i ++){
	$lastRow = $row;
	$row = $row + 1;
	$sheet->getStyle("A{$row}")->applyFromArray($lStyle,false);
	$sheet->getStyle("N{$row}")->applyFromArray($rStyle,false);
	if($i==0)
		$sheet->setCellValue("A{$row}","=L6");
	else 
		$sheet->setCellValue("A{$row}",sprintf($timeHalfHourlyFormula,$lastRow,$lastRow,$lastRow));
	$sheet->setCellValue("B{$row}",'=SUMPRODUCT(1*($G$54:$G$76<>"--"),1*($B$54:$B$76<>""),1*($B$54:$B$76>=$A12),1*($B$54:$B$76<IF(MINUTE($A12)=15,TIME(HOUR($A12),45,0),TIME(HOUR($A12)+1,15,0))))');
	$sheet->setCellValue("C{$row}","=SUMPRODUCT(1*(\$C\${$detailStartRow}:\$C\${$detailEndtRow}<>\"\"),1*(\$C\${$detailStartRow}:\$C\${$detailEndtRow}>=\$A{$row}),1*(\$C\${$detailStartRow}:\$C\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))))");
	$sheet->setCellValue("D{$row}","=SUMPRODUCT(1*(\$K\${$detailStartRow}:\$K\${$detailEndtRow}<>\"--\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))))");
	$sheet->setCellValue("E{$row}","=D{$row}-C{$row}");
	$sheet->setCellValue("F{$row}","=SUMPRODUCT(1*(\$K\${$detailStartRow}:\$K\${$detailEndtRow}<>\"--\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),\$F\${$detailStartRow}:\$F\${$detailEndtRow})");
	$sheet->setCellValue("G{$row}","=SUMPRODUCT(1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}<>\"\"),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}>=\$A{$row}),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),\$G\${$detailStartRow}:\$G\${$detailEndtRow})");
	$sheet->setCellValue("H{$row}","=IF(B12=0,0,G12/SUMPRODUCT(\$F\${$detailStartRow}:\$F\${$detailEndtRow},1*(\$G\${$detailStartRow}:\$G\${$detailEndtRow}<>\"--\"),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}<>\"\"),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}>=\$A{$row}),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))))*100)");
	$sheet->setCellValue("I{$row}","=SUMPRODUCT(1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}<>\"\"),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}>=\$A{$row}),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),\$I\${$detailStartRow}:\$I\${$detailEndtRow})");
	$sheet->setCellValue("J{$row}","=SUMPRODUCT(1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),\$J\${$detailStartRow}:\$J\${$detailEndtRow})");
	$sheet->setCellValue("K{$row}","=SUMPRODUCT(1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),\$K\${$detailStartRow}:\$K\${$detailEndtRow})");
	$sheet->setCellValue("L{$row}","=IF(\$F{$row}=0,0,K{$row}/\$F{$row}*100)");
	$sheet->setCellValue("M{$row}","=IF(SUMPRODUCT(1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))>1,MIN(IF((\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\")*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row})*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0)))*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100)*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))&\"-\"&MAX(IF((\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\")*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row})*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0)))*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))&\"(\"&SUMPRODUCT(1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))&\")\",MAX(IF((\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\")*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row})*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0)))*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))&\"(\"&SUMPRODUCT(1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))&\")\")");
	$sheet->setCellValue("N{$row}","=IF(ISERROR(IF(SUMPRODUCT(1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))=0,30/D12/2,(J12+2*SUMPRODUCT(1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))*30/(2*D12*J12))),\"--\",IF(SUMPRODUCT(1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))=0,30/D12/2,(J12+2*SUMPRODUCT(1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}>=\$A{$row}),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<IF(MINUTE(\$A{$row})=15,TIME(HOUR(\$A{$row}),45,0),TIME(HOUR(\$A{$row})+1,15,0))),1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))*30/(2*D12*J12)))");
	
}
$totalEndRow = $row;

// 统计表格总计
$row = $row + 1;
$totalTotalRow = $row;
$sheet->getStyle("A{$row}")->applyFromArray($ltbStyle,false);
$sheet->getStyle("B{$row}:M{$row}")->applyFromArray($tbStyle,false);
$sheet->getStyle("N{$row}")->applyFromArray($trbStyle,false);
$sheet->getStyle("A{$row}:N{$row}")->getFont()->setBold(true);
$sheet->setCellValue("A{$row}",'Total');
$sheet->setCellValue("B{$row}","=SUM(B{$totalStartRow}:B{$totalEndRow})");
$sheet->setCellValue("C{$row}","=SUM(C{$totalStartRow}:C{$totalEndRow})");
$sheet->setCellValue("D{$row}","=SUM(D{$totalStartRow}:D{$totalEndRow})");
$sheet->setCellValue("E{$row}","=SUM(E{$totalStartRow}:E{$totalEndRow})");
$sheet->setCellValue("F{$row}","=SUM(F{$totalStartRow}:F{$totalEndRow})");
$sheet->setCellValue("G{$row}","=SUM(G{$totalStartRow}:G{$totalEndRow})");
$sheet->setCellValue("H{$row}","=G{$row}/SUMPRODUCT(\$F\${$detailStartRow}:\$F\${$detailEndtRow},1*(\$G\${$detailStartRow}:\$G\${$detailEndtRow}<>\"--\"),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}<>\"\"))*100");
$sheet->setCellValue("I{$row}","=SUM(I{$totalStartRow}:I{$totalEndRow})");
$sheet->setCellValue("J{$row}","=SUM(J{$totalStartRow}:J{$totalEndRow})");
$sheet->setCellValue("K{$row}","=SUM(K{$totalStartRow}:K{$totalEndRow})");
$sheet->setCellValue("L{$row}","=K{$row}/\$F{$row}*100");
$sheet->setCellValue("M{$row}","=IF(SUMPRODUCT(1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))>1,MIN(IF((\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100)*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))&\"-\"&MAX(IF((\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))&\"(\"&SUMPRODUCT(1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))&\")\",MAX(IF((\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))&\"(\"&SUMPRODUCT(1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))&\")\")");
$sheet->setCellValue("N{$row}","=AVERAGE(\$N\${$totalStartRow}:\$N\${$totalEndRow})");

/*
$row = $row + 1;
$sheet->getStyle("A{$row}")->applyFromArray($bf,false);
$sheet->getStyle("M{$row}")->applyFromArray($trbStyle,false);
$sheet->getStyle("N{$row}")->applyFromArray($trbStyle,false);
$sheet->getStyle("N{$row}")->getFont()->setBold(true);
$sheet->getStyle("A{$row}")->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$sheet->getStyle("L{$row}:M{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$sheet->setCellValue("A{$row}",'Schedule of Services as at');
$sheet->setCellValue("C{$row}",$sofsDate);
$sheet->setCellValue("N{$row}","=TEXT(MIN(\$N\${$totalStartRow}:\$N\${$totalEndRow})),\"0.0\")&\"-\"&TEXT(MAX(\$N\${$totalStartRow}:\$N\${$totalEndRow})),\"0.0\")");

// 统计表格:全部设置为居中
$sheet->getStyle("A9:M{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// 中间表格:Vehicle Allocation

$row = $row + 2;
$sheet->getStyle("A{$row}")->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$sheet->setCellValue("A{$row}",'Vehicle Allocation');

$row = $row + 1;
$sheet->setCellValue("A{$row}",'Schedule:');
$sheet->setCellValue("C{$row}",$busSchNo[0]);
$sheet->setCellValue("D{$row}","=IF(LEFT(C$5,3)=\"GMB\",\"GMB(s)\",\"Bus(es)\")");
$sheet->setCellValue("G{$row}",'Schedule Frequency:');
$sheet->setCellValue("J{$row}","=ROUND((\$N\$6-\$L\$6-TIME(1,0,0))/\$C\${$totalTotalRow}*24*60,0)");
$sheet->setCellValue("K{$row}",'Minutes');

$row = $row + 1;
$sheet->setCellValue("A{$row}",'Observed:');
$sheet->setCellValue("C{$row}",$fleetNoListRows);
$sheet->setCellValue("D{$row}","=IF(LEFT(C$5,3)=\"GMB\",\"GMB(s)\",\"Bus(es)\")");
$sheet->setCellValue("G{$row}",'Observed Frequency:');
$sheet->setCellValue("J{$row}","=ROUND((\$N\$6-\$L\$6-TIME(1,0,0))/\$D\${$totalTotalRow}*24*60,0)");
$sheet->setCellValue("K{$row}",'Minutes');

$row = $row + 1;
$sheet->setCellValue("A{$row}",'Difference:');
$sheet->setCellValue("C{$row}","=C".($row-1)."-C".($row-2));
$sheet->setCellValue("D{$row}","=IF(LEFT(C$5,3)=\"GMB\",\"GMB(s)\",\"Bus(es)\")");
$sheet->setCellValue("G{$row}",'Difference:');
$sheet->setCellValue("J{$row}","=J".($row-1)."-J".($row-2));
$sheet->setCellValue("K{$row}",'Minutes');

// 中间车辆部分:Registration Number
$row = $row + 2;
$sheet->setCellValue("A{$row}",'Registration Number');
$sheet->getStyle("A{$row}")->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);

$row = $row + 2;
$m = 0;
for($i = 0;$i < $fleetNoListRows;$i ++){
	$fleetNo = $fleetNoList[$i];
	$col = chr($m + 65);
	$fleetNoRow = "{$col}{$row}";
	$sheet->setCellValue($fleetNoRow,$fleetNo);
	$m ++;
	$col = chr($m + 65);
	$sheet->setCellValue("{$col}{$row}","=SUMPRODUCT(1*(\$A\${$detailStartRow}:\$A\${$detailEndtRow}={$fleetNoRow}),1*(\$K\${$detailStartRow}:\$K\${$detailEndtRow}<>\"--\"))");
	$m ++;
	if($m % 14 == 0){
		$row = $row + 1;
		$m = 0;
	}
}
// 详细表格
$row = $row + 2;
$sheet->setCellValue("A{$row}",'Total Journey Time :');
$sheet->setCellValue("C{$row}",$totalJourneyTime);
$sheet->setCellValue("D{$row}",'minutes');

$row = $row + 1;
$detailRow = $row;
$sheet->mergeCells("B{$row}:E{$row}");
$sheet->mergeCells("G{$row}:N{$row}");
$sheet->getStyle("A{$row}")->applyFromArray($ltStyle,false);
$sheet->getStyle("B{$row}:M{$row}")->applyFromArray($tStyle,false);
$sheet->getStyle("N{$row}")->applyFromArray($trStyle,false);
$sheet->setCellValue("A{$row}",'Registration');
$sheet->setCellValue("B{$row}",'Terminus');
$sheet->setCellValue("F{$row}",'Carrying');
$sheet->setCellValue("G{$row}",'No. of Passengers');

$row = $row + 1;
$sheet->mergeCells("C{$row}:E{$row}");
$sheet->mergeCells("G{$row}:H{$row}");
$sheet->mergeCells("K{$row}:L{$row}");
$sheet->getStyle("A{$row}")->applyFromArray($lStyle,false);
$sheet->getStyle("N{$row}")->applyFromArray($rStyle,false);
$sheet->setCellValue("A{$row}",'No.');
$sheet->setCellValue("B{$row}",'Arrival Time');
$sheet->setCellValue("C{$row}",'Dept. Time');
$sheet->setCellValue("F{$row}",'Capacity');
$sheet->setCellValue("G{$row}",'On Arrival');
$sheet->setCellValue("I{$row}",'Set');
$sheet->setCellValue("J{$row}",'Picked');
$sheet->setCellValue("K{$row}",'On Departure');
$sheet->setCellValue("M{$row}",'Left Behind');
$sheet->setCellValue("N{$row}",'Headway');

$row = $row + 1;
$sheet->getStyle("A{$row}")->applyFromArray($lbStyle,false);
$sheet->getStyle("B{$row}:M{$row}")->applyFromArray($bStyle,false);
$sheet->getStyle("N{$row}")->applyFromArray($rbStyle,false);
$sheet->setCellValue("B{$row}",'Obs.(1)');
$sheet->setCellValue("C{$row}",'Sch.(2)');
$sheet->setCellValue("D{$row}",'Obs.(3)');
$sheet->setCellValue("E{$row}",'Diff. (mins.)');
$sheet->setCellValue("G{$row}",'No.');
$sheet->setCellValue("H{$row}",'(%)');
$sheet->setCellValue("I{$row}",'Down');
$sheet->setCellValue("J{$row}",'Up');
$sheet->setCellValue("K{$row}",'No.');
$sheet->setCellValue("L{$row}",'(%)');
$sheet->setCellValue("M{$row}",'(Wait Next Dep)');
$sheet->setCellValue("N{$row}",'(mins.)');

for($i = 0;$i < $lowTableRows;$i ++){
	$row = $row + 1;
	$sheet->getStyle("A{$row}")->applyFromArray($lStyle,false);
	$sheet->getStyle("N{$row}")->applyFromArray($rStyle,false);
	$fleetNo = $lowTable[$i]['skippedStop'] == 1?'*':'';
	$fleetNo .= $lowTable[$i]['fleetNo'];
	$sheet->setCellValue("A{$row}",$fleetNo);
	$sheet->setCellValue("B{$row}",$lowTable[$i]['arrivalTime']);
	$sheet->setCellValue("C{$row}",$lowTable[$i]['busTime']);
	$sheet->setCellValue("D{$row}",$lowTable[$i]['departureTime']);
	$sheet->setCellValue("E{$row}","=IF(C{$row}=\"\",\"--\",IF(D{$row}=\"\",\"\",(HOUR(D{$row})*60+MINUTE(D{$row}))-(HOUR(C{$row})*60+MINUTE(C{$row}))))");
	$sheet->setCellValue("F{$row}",$lowTable[$i]['pslNo']);
	$sheet->setCellValue("G{$row}",$lowTable[$i]['onArrival']);
	$sheet->setCellValue("H{$row}",$lowTable[$i]['onArrivalPercent']);
	$sheet->setCellValue("I{$row}",$lowTable[$i]['setDown']);
	$sheet->setCellValue("J{$row}",$lowTable[$i]['pickup']);
	$sheet->setCellValue("K{$row}",$lowTable[$i]['onDept']);
	$sheet->setCellValue("L{$row}",$lowTable[$i]["onDeptPercent"]);
	$sheet->setCellValue("M{$row}",$lowTable[$i]['leftBehindShow']);
	if($i==0) {
		$sheet->setCellValue("N{$row}","--");
	}else {
		if(!empty($lowTable[$i]['departureTime'])) {
			$sheet->setCellValue("N{$row}","");
		}else {
			$sheet->setCellValue("N{$row}","=(HOUR(D{$row})*60+MINUTE(D{$row}))-(HOUR(D{$lastRow})*60+MINUTE(D{$lastRow}))");
		} 
			
	}
	if(!empty($lowTable[$i]['departureTime']))
		$lastRow = $row;
		
}
// 详细表格统计
$row = $row + 1;
$sheet->mergeCells("C{$row}:E{$row}");
$sheet->getStyle("A{$row}")->applyFromArray($ltbStyle,false);
$sheet->getStyle("B{$row}:M{$row}")->applyFromArray($tbStyle,false);
$sheet->getStyle("N{$row}")->applyFromArray($trbStyle,false);
$sheet->getStyle("A{$row}:N{$row}")->getFont()->setBold(true);
$sheet->setCellValue("A{$row}",'Total');
$sheet->setCellValue("B{$row}","=SUMPRODUCT(1*(\$G\${$detailStartRow}:\$G\${$detailEndtRow}<>\"--\"),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}<>\"\"),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}<>\"--\"))");
$sheet->setCellValue("C{$row}","No. of Trips");
$sheet->setCellValue("F{$row}","=SUMPRODUCT(\$F\${$detailStartRow}:\$F\${$detailEndtRow},1*(\$K\${$detailStartRow}:\$K\${$detailEndtRow}<>\"--\"))");
$sheet->setCellValue("G{$row}","=SUM(G{$detailStartRow}:G{$detailEndtRow})");
$sheet->setCellValue("H{$row}","=G{$row}/SUMPRODUCT(\$F\${$detailStartRow}:\$F\${$detailEndtRow},1*(\$G\${$detailStartRow}:\$G\${$detailEndtRow}<>\"--\"),1*(\$B\${$detailStartRow}:\$B\${$detailEndtRow}<>\"\"))*100");
$sheet->setCellValue("I{$row}","=SUM(I{$detailStartRow}:I{$detailEndtRow})");
$sheet->setCellValue("J{$row}","=SUM(J{$detailStartRow}:J{$detailEndtRow})");
$sheet->setCellValue("K{$row}","=SUM(K{$detailStartRow}:K{$detailEndtRow})");
$sheet->setCellValue("L{$row}","=K{$row}/\$F\${$row}*100");
$sheet->setCellValue("M{$row}","=IF(SUMPRODUCT(1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))>1,MIN(IF((\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100)*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))&\"-\"&MAX(IF((\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))&\"(\"&SUMPRODUCT(1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))&\")\",MAX(IF((\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),\$M\${$detailStartRow}:\$M\${$detailEndtRow}))&\"(\"&SUMPRODUCT(1*(\$L\${$detailStartRow}:\$L\${$detailEndtRow}=100),1*(\$M\${$detailStartRow}:\$M\${$detailEndtRow}>0))&\")\")");
$sheet->setCellValue("N{$row}","=AVERAGE(N{$detailStartRow}:N{$detailEndtRow})");

$row = $row + 1;
$sheet->getStyle("C{$row}")->applyFromArray($ltbStyle,false);
$sheet->getStyle("D{$row}")->applyFromArray($tbStyle,false);
$sheet->getStyle("E{$row}")->applyFromArray($trbStyle,false);
$sheet->getStyle("M{$row}")->applyFromArray($ltbStyle,false);
$sheet->getStyle("N{$row}")->applyFromArray($lStyle,false);
$sheet->getStyle("A{$row}:N{$row}")->getFont()->setBold(true);
$sheet->setCellValue("C{$row}","=SUMPRODUCT(1*(\$C\${$detailStartRow}:\$C\${$detailEndtRow}<>\"\"))");
$sheet->setCellValue("D{$row}","=SUMPRODUCT(1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"\"),1*(\$D\${$detailStartRow}:\$D\${$detailEndtRow}<>\"--\"),1*(\$K\${$detailStartRow}:\$K\${$detailEndtRow}<>\"--\"))");
$sheet->setCellValue("E{$row}","=D{$row}-C{$row}");
// 自愿不登车
if($lowTable['total']['voluntaryNoCar'] > 0){
	$sheet->getStyle("M{$row}")->getFont()->setBold(true);
	$sheet->setCellValue("M{$row}","(Wait Next Dept.)");
}

// 详细表格:全部设置为居中
$sheet->getStyle("A{$detailRow}:N{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// 底部备注说明
$row = $row + 2;
$sheet->setCellValue("A{$row}",'Note: (1) Observed arrival time at Terminus');
$row = $row + 1;
$sheet->setCellValue("A{$row}",'Note: (2) Scheduled departure time from Terminus');
$row = $row + 1;
$sheet->setCellValue("A{$row}",'Note: (3) Observed departure time from Terminus');
$row = $row + 1;
$sheet->setCellValue("A{$row}",'Note: (4) "--" represents "Out of Service"');
*/
// set print scale
$sheet->getPageSetup()->setScale(66);

// set print area
$sheet->getPageSetup()->setPrintArea("A1:N" . $row);

// set page size and orientation
$sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

// Redirect output to a clients web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header("Content-Disposition: attachment;filename=" . $fileName);
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($pexcel,'Excel5');
$objWriter->save('php://output');
exit();

?>
