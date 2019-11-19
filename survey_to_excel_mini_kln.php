<?php
/*
 * Header: Create: 2006-06-23 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
include_once ($conf ["path"] ["root"] . "../library/PHPExcel/PHPExcel.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

if ($_GET ['supaId'] == '')
	header ( "Location:list.php" );
	// 生成调查结果所需要的数据
include_once ('survey_product_data.php');
$fileName = $sp->refNo . "-" . $sp->routeNo;
$fileName = CustomerReplace ( $fileName );
$fileName = $fileName . '.xls';
$weathers = getArray ( 'weather' );
$weatherName = $weathers [$sp->weatherId];

// Creating a workbook
$pexcel = new PHPExcel ();
// Rename sheet
$pexcel->getActiveSheet ()->setTitle ( $sp->refNo );
$pexcel->setActiveSheetIndex ( 0 );
$sheet = $pexcel->getActiveSheet ();
$defaultStyle = new PHPExcel_Style ();
$defaultStyle->getFont ()->setName ( 'Arial' );
$defaultStyle->getFont ()->setSize ( 10 );
$sheet->setDefaultStyle ( $defaultStyle );
// 報表樣式文件
include_once ('./survey_to_excel_style.php');
// Set column widths
$sheet->getColumnDimension ( 'L' )->setWidth ( 11 );
$sheet->getColumnDimension ( 'M' )->setWidth ( 11 );
$sheet->getColumnDimension ( 'N' )->setWidth ( 11 );

$person = $conf ['bus'] ['big'] ['person'];

// Row 2
$row = 2;
$sheet->mergeCells ( "A{$row}:M{$row}" );
$sheet->getStyle ( "A{$row}:M{$row}" )->applyFromArray ( $cuf, false );
$sheet->setCellValue ( "A{$row}", $subjectName );

// Row 4
$row = 4;
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $bf, false );
$sheet->setCellValue ( "A{$row}", 'Ref No. :' );
$sheet->setCellValue ( "C{$row}", $sp->refNo );

// Row 5
$row = 5;
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $bf, false );
$sheet->getStyle ( "I{$row}" )->applyFromArray ( $bf, false );
$sheet->setCellValue ( "A{$row}", 'Route No. :' );
$sheet->setCellValue ( "C{$row}", $sp->routeNo );
$sheet->setCellValue ( "I{$row}", 'S of S Date :' );
$sheet->setCellValue ( "K{$row}", $sofsDate );

// Row 6
$row = 6;
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $bf, false );
$sheet->getStyle ( "I{$row}" )->applyFromArray ( $bf, false );
$sheet->setCellValue ( "A{$row}", 'Date :' );
$sheet->setCellValue ( "C{$row}", $sp->surDate );
$sheet->setCellValue ( "I{$row}", 'Survey Period :' );
$sheet->setCellValue ( "K{$row}", ToShortTime ( $sp->surFromTime ) );
$sheet->setCellValue ( "L{$row}", 'to' );
$sheet->setCellValue ( "M{$row}", ToShortTime ( $sp->surToTime ) );

// Row 7
$row = 7;
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $bf, false );
$sheet->getStyle ( "I{$row}" )->applyFromArray ( $bf, false );
$sheet->setCellValue ( "A{$row}", 'Location :' );
$sheet->setCellValue ( "C{$row}", $sp->location );
$sheet->setCellValue ( "I{$row}", 'Direction :' );
$sheet->setCellValue ( "K{$row}", $sp->bounds );

// 详细表格
$row = $row + 1;
$sheet->getStyle ( "M{$row}:N{$row}" )->applyFromArray ( $bf, false );
$sheet->getStyle ( "M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
$sheet->getStyle ( "N{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_LEFT );
$sheet->setCellValue ( "M{$row}", 'Table' );
$sheet->setCellValue ( "N{$row}", '1' );

$row = $row + 1;
$detailRow = $row;
$sheet->mergeCells ( "C{$row}:E{$row}" );
$sheet->mergeCells ( "G{$row}:N{$row}" );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $ltStyle, false );
$sheet->getStyle ( "B{$row}:M{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "N{$row}" )->applyFromArray ( $trStyle, false );
$sheet->setCellValue ( "A{$row}", 'Registration' );
$sheet->setCellValue ( "B{$row}", 'Arrival' );
$sheet->setCellValue ( "C{$row}", 'Departure Time' );
$sheet->setCellValue ( "F{$row}", 'PSL' );
$sheet->setCellValue ( "G{$row}", 'No. of Passengers' );

$row = $row + 1;
$sheet->mergeCells ( "G{$row}:H{$row}" );
$sheet->mergeCells ( "K{$row}:L{$row}" );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "N{$row}" )->applyFromArray ( $rStyle, false );
$sheet->setCellValue ( "A{$row}", 'No.' );
$sheet->setCellValue ( "B{$row}", 'Time' );
$sheet->setCellValue ( "G{$row}", 'On Arrival' );
$sheet->setCellValue ( "I{$row}", 'Set' );
$sheet->setCellValue ( "J{$row}", 'Picked' );
$sheet->setCellValue ( "K{$row}", 'On Departure' );
$sheet->setCellValue ( "M{$row}", 'Left Behind' );
$sheet->setCellValue ( "N{$row}", 'Headway' );

$row = $row + 1;
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lbStyle, false );
$sheet->getStyle ( "B{$row}:M{$row}" )->applyFromArray ( $bStyle, false );
$sheet->getStyle ( "N{$row}" )->applyFromArray ( $rbStyle, false );
$sheet->setCellValue ( "C{$row}", 'SOS' );
$sheet->setCellValue ( "D{$row}", 'Obs.' );
$sheet->setCellValue ( "E{$row}", 'Diff.' );
$sheet->setCellValue ( "G{$row}", 'No.' );
$sheet->setCellValue ( "H{$row}", '(%)' );
$sheet->setCellValue ( "I{$row}", 'Down' );
$sheet->setCellValue ( "J{$row}", 'Up' );
$sheet->setCellValue ( "K{$row}", 'No.' );
$sheet->setCellValue ( "L{$row}", '(%)' );
$sheet->setCellValue ( "M{$row}", '(Occasion)' );
$sheet->setCellValue ( "N{$row}", '(min)' );

// 底部表格内容 1b
for($i = 0; $i < $lowTableRows; $i ++) {
	$row = $row + 1;
	$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
	$sheet->getStyle ( "N{$row}" )->applyFromArray ( $rStyle, false );
	$fleetNo = $lowTable [$i] ['skippedStop'] == 1 ? '*' : '';
	$fleetNo .= $lowTable [$i] ['fleetNo'];
	$sheet->setCellValue ( "A{$row}", $fleetNo );
	$sheet->setCellValue ( "B{$row}", $lowTable [$i] ['arrivalTime'] );
	$sheet->setCellValue ( "C{$row}", $lowTable [$i] ['busTime'] );
	$sheet->setCellValue ( "D{$row}", $lowTable [$i] ['departureTime'] );
	$sheet->setCellValue ( "E{$row}", $lowTable [$i] ['diffNo'] ? $lowTable [$i] ['diffNo'] : '--' );
	$sheet->setCellValue ( "F{$row}", $lowTable [$i] ['pslNo'] );
	$sheet->setCellValue ( "G{$row}", $lowTable [$i] ['onArrival'] );
	$sheet->setCellValue ( "H{$row}", $lowTable [$i] ['onArrivalPercent'] );
	$sheet->setCellValue ( "I{$row}", $lowTable [$i] ['setDown'] );
	$sheet->setCellValue ( "J{$row}", $lowTable [$i] ['pickup'] );
	$sheet->setCellValue ( "K{$row}", $lowTable [$i] ['onDept'] );
	$sheet->setCellValue ( "L{$row}", $lowTable [$i] ["onDeptPercent"] );
	$sheet->setCellValue ( "M{$row}", $lowTable [$i] ['leftBehind'] );
	$sheet->setCellValue ( "N{$row}", $lowTable [$i] ['headWay'] ? $lowTable [$i] ['headWay'] : '--' );
}
$leftBehindTotal = $lowTable ['total'] ['leftBehindMin'] . '-' . $lowTable ['total'] ['leftBehindMax'] . '(' . $lowTable ['total'] ['leftBehindTotal'] . ')';
$row = $row + 1;
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $ltbStyle, false );
$sheet->getStyle ( "B{$row}:M{$row}" )->applyFromArray ( $tbStyle, false );
$sheet->getStyle ( "N{$row}" )->applyFromArray ( $trbStyle, false );
$sheet->getStyle ( "A{$row}:N{$row}" )->getFont ()->setBold ( true );
$sheet->setCellValue ( "A{$row}", 'Total' );
$sheet->setCellValue ( "B{$row}", $lowTable ['total'] ['recordTotal'] );
$sheet->setCellValue ( "C{$row}", $lowTable ['total'] ['busTimeTotal'] );
$sheet->setCellValue ( "D{$row}", $lowTable ['total'] ['recordTotal'] );
$sheet->setCellValue ( "E{$row}", $lowTable ['total'] ['diffTotal'] );
$sheet->setCellValue ( "G{$row}", $lowTable ['total'] ['onArrivalTotal'] );
$sheet->setCellValue ( "H{$row}", $lowTable ['total'] ["onArrivalTotalPercent"] );
$sheet->setCellValue ( "I{$row}", $lowTable ['total'] ['setDownTotal'] );
$sheet->setCellValue ( "J{$row}", $lowTable ['total'] ['pickupTotal'] );
$sheet->setCellValue ( "K{$row}", $lowTable ['total'] ['onDeptTotal'] );
$sheet->setCellValue ( "L{$row}", $lowTable ['total'] ["onDeptTotalPercent"] );
$sheet->setCellValue ( "M{$row}", $leftBehindTotal );
$sheet->setCellValue ( "N{$row}", '--' );

// 详细表格:全部设置为居中
$sheet->getStyle ( "A{$detailRow}:N{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

// 跳站標記
$row = $row + 1;
if ($lowTable ['total'] ['skippedStopTotal'] > 0)
	$sheet->setCellValue ( "C{$row}", '*=skipped stop' );
	
	// 统计表格
$row = $row + 3;
$totalRow = $row;
$sheet->mergeCells ( "C{$row}:E{$row}" );
$sheet->mergeCells ( "F{$row}:L{$row}" );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $ltStyle, false );
$sheet->getStyle ( "B{$row}:L{$row}" )->applyFromArray ( $tStyle, false );
$sheet->getStyle ( "M{$row}" )->applyFromArray ( $trStyle, false );
$sheet->setCellValue ( "A{$row}", 'Time' );
$sheet->setCellValue ( "B{$row}", 'No. of' );
$sheet->setCellValue ( "C{$row}", 'No. of' );
$sheet->setCellValue ( "F{$row}", 'No. of Passengers' );
$sheet->setCellValue ( "M{$row}", 'Average' );

$row = $row + 1;
$sheet->mergeCells ( "C{$row}:E{$row}" );
$sheet->mergeCells ( "F{$row}:G{$row}" );
$sheet->mergeCells ( "J{$row}:K{$row}" );
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
$sheet->getStyle ( "M{$row}" )->applyFromArray ( $rStyle, false );
$sheet->setCellValue ( "A{$row}", '(Half-' );
$sheet->setCellValue ( "B{$row}", 'Arrivals' );
$sheet->setCellValue ( "C{$row}", 'Departures' );
$sheet->setCellValue ( "F{$row}", 'On Arrival' );
$sheet->setCellValue ( "H{$row}", 'Set' );
$sheet->setCellValue ( "I{$row}", 'Picked' );
$sheet->setCellValue ( "J{$row}", 'On Departure' );
$sheet->setCellValue ( "L{$row}", 'Left Behind' );
$sheet->setCellValue ( "M{$row}", 'Waiting' );

$row = $row + 1;
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lbStyle, false );
$sheet->getStyle ( "B{$row}:L{$row}" )->applyFromArray ( $bStyle, false );
$sheet->getStyle ( "M{$row}" )->applyFromArray ( $rbStyle, false );
$sheet->setCellValue ( "A{$row}", 'Hourly)' );
$sheet->setCellValue ( "C{$row}", 'SOS' );
$sheet->setCellValue ( "D{$row}", 'Obs.' );
$sheet->setCellValue ( "E{$row}", 'Diff.' );
$sheet->setCellValue ( "F{$row}", 'No.' );
$sheet->setCellValue ( "G{$row}", '(%)' );
$sheet->setCellValue ( "H{$row}", 'Down' );
$sheet->setCellValue ( "I{$row}", 'Up' );
$sheet->setCellValue ( "J{$row}", 'No.' );
$sheet->setCellValue ( "K{$row}", '(%)' );
$sheet->setCellValue ( "L{$row}", '(Occasion)' );
$sheet->setCellValue ( "M{$row}", 'Time(mins.)' );

$topTableRows = count ( $topTable ) - 1;
for($i = 0; $i < $topTableRows; $i ++) {
	$row = $row + 1;
	$tempBehind = $topTable [$i] ['leftBehindMinCount'] . '-' . $topTable [$i] ['leftBehindMaxCount'] . '(' . $topTable [$i] ['leftBehindCount'] . ')';
	$sheet->getStyle ( "A{$row}" )->applyFromArray ( $lStyle, false );
	$sheet->getStyle ( "M{$row}" )->applyFromArray ( $rStyle, false );
	$sheet->setCellValue ( "A{$row}", $topTable [$i] ['halfHourly'] );
	$sheet->setCellValue ( "B{$row}", $topTable [$i] ['arrivals'] );
	$sheet->setCellValue ( "C{$row}", $topTable [$i] ['busTimeCount'] );
	$sheet->setCellValue ( "D{$row}", $topTable [$i] ['departureTimeCount'] );
	$sheet->setCellValue ( "E{$row}", $topTable [$i] ['diffNoCount'] );
	$sheet->setCellValue ( "F{$row}", $topTable [$i] ['onArrivalCount'] );
	$sheet->setCellValue ( "G{$row}", $topTable [$i] ["onArrivalCountPercent"] );
	$sheet->setCellValue ( "H{$row}", $topTable [$i] ['setDownCount'] );
	$sheet->setCellValue ( "I{$row}", $topTable [$i] ['pickupCount'] );
	$sheet->setCellValue ( "J{$row}", $topTable [$i] ['onDeptCount'] );
	$sheet->setCellValue ( "K{$row}", $topTable [$i] ["onDeptCountPercent"] );
	$sheet->setCellValue ( "L{$row}", $tempBehind );
	$sheet->setCellValue ( "M{$row}", $topTable [$i] ['headWayCount'] );
}

$row = $row + 1;
$leftBehindCount = $topTable ['total'] ['leftBehindMinCount'] . '-' . $topTable ['total'] ['leftBehindMaxCount'] . '(' . $topTable ['total'] ['leftBehindCount'] . ')';
$sheet->getStyle ( "A{$row}" )->applyFromArray ( $ltbStyle, false );
$sheet->getStyle ( "B{$row}:L{$row}" )->applyFromArray ( $tbStyle, false );
$sheet->getStyle ( "M{$row}" )->applyFromArray ( $trbStyle, false );
$sheet->getStyle ( "A{$row}:M{$row}" )->getFont ()->setBold ( true );
$sheet->setCellValue ( "A{$row}", 'Total' );
$sheet->setCellValue ( "B{$row}", $topTable ['total'] ['arrivals'] );
$sheet->setCellValue ( "C{$row}", $topTable ['total'] ['busTimeCount'] );
$sheet->setCellValue ( "D{$row}", $topTable ['total'] ['departureTimeCount'] );
$sheet->setCellValue ( "E{$row}", $topTable ['total'] ['diffNoCount'] );
$sheet->setCellValue ( "F{$row}", $topTable ['total'] ['onArrivalCount'] );
$sheet->setCellValue ( "G{$row}", $topTable ['total'] ["onArrivalCountTotalPercent"] );
$sheet->setCellValue ( "H{$row}", $topTable ['total'] ['setDownCount'] );
$sheet->setCellValue ( "I{$row}", $topTable ['total'] ['pickupCount'] );
$sheet->setCellValue ( "J{$row}", $topTable ['total'] ['onDeptCount'] );
$sheet->setCellValue ( "K{$row}", $topTable ['total'] ["onDeptCountTotalPercent"] );
$sheet->setCellValue ( "L{$row}", $leftBehindCount );
$sheet->setCellValue ( "M{$row}", $topTable ['total'] ["headWayCountTotal"] );

// 统计表格:全部设置为居中
$sheet->getStyle ( "A{$totalRow}:M{$row}" )->getAlignment ()->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );

// 中间表格:Vehicle Allocation
$schFre = $topTable ['total'] ['busTimeCount'] == 0 ? 0 : ceil ( $surTimeDiff / $topTable ['total'] ['busTimeCount'] );
$obsFre = $topTable ['total'] ['departureTimeCount'] == 0 ? 0 : ceil ( $surTimeDiff / $topTable ['total'] ['departureTimeCount'] );
$fleetNoList = array ();
$lowTableRows = count ( $lowTable ) - 1;
for($i = 0; $i < $lowTableRows; $i ++) {
	if ($lowTable [$i] ['fleetNo'] == "" || $lowTable [$i] ['fleetNo'] == "Missing")
		continue;
	$fleetNoList [] = trim ( $lowTable [$i] ['fleetNo'] );
}
$fleetNoList = UniqueArray ( $fleetNoList );
sort ( $fleetNoList );
$fleetNoListRows = count ( $fleetNoList );

$row = $row + 2;
$sheet->getStyle ( "A{$row}" )->getFont ()->setUnderline ( PHPExcel_Style_Font::UNDERLINE_SINGLE );
$sheet->setCellValue ( "A{$row}", 'Vehicle Allocation' );

$row = $row + 1;
$sheet->setCellValue ( "A{$row}", 'Schedule:' );
$sheet->setCellValue ( "C{$row}", $busSchNo [0] );
$sheet->setCellValue ( "D{$row}", $vehicleName );
$sheet->setCellValue ( "G{$row}", 'Schedule Frequency:' );
$sheet->setCellValue ( "J{$row}", $schFre );
$sheet->setCellValue ( "K{$row}", 'Minutes' );

$row = $row + 1;
$sheet->setCellValue ( "A{$row}", 'Observed:' );
$sheet->setCellValue ( "C{$row}", $fleetNoListRows );
$sheet->setCellValue ( "D{$row}", $vehicleName );
$sheet->setCellValue ( "G{$row}", 'Observed Frequency:' );
$sheet->setCellValue ( "J{$row}", $obsFre );
$sheet->setCellValue ( "K{$row}", 'Minutes' );

$row = $row + 1;
$sheet->setCellValue ( "A{$row}", 'Difference:' );
$sheet->setCellValue ( "C{$row}", $fleetNoListRows - $busSchNo [0] );
$sheet->setCellValue ( "D{$row}", $vehicleName );
$sheet->setCellValue ( "G{$row}", 'Difference:' );
$sheet->setCellValue ( "J{$row}", $obsFre - $schFre );
$sheet->setCellValue ( "K{$row}", 'Minutes' );

// 中间车辆部分:Registration Number
$row = $row + 2;
$sheet->setCellValue ( "A{$row}", 'Registration Number' );
$sheet->getStyle ( "A{$row}" )->getFont ()->setUnderline ( PHPExcel_Style_Font::UNDERLINE_SINGLE );

$row = $row + 2;
$m = 0;
for($i = 0; $i < $fleetNoListRows; $i ++) {
	$col = chr ( $m + 65 );
	$sheet->setCellValue ( "{$col}{$row}", $fleetNoList [$i] );
	$m ++;
	if ($m % 14 == 0) {
		$row = $row + 1;
		$m = 0;
	}
}

// set print scale
$sheet->getPageSetup ()->setScale ( 66 );

// set print area
$sheet->getPageSetup ()->setPrintArea ( "A1:N" . $row );

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

?>
