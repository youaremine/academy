<?php
/*
 * Header: Create: 2006-06-23 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
include_once ("../library/init.php");
require_once '../library/Spreadsheet/Excel/Writer.php';
if ($_GET ['supaId'] == '')
	header ( "Location:list.php" );
	// 生成调查结果所需要的数据
include_once ('survey_product_data.php');
$fileName = $sp->refNo . '.xls';

// Creating a workbook
$wb = new Spreadsheet_Excel_Writer ( $conf ["path"] ["excel"] . $fileName );
// print $conf["path"]["excel"].$fileName;

// sending HTTP headers
// $wb->send($fileName);
// set version
$wb->setVersion ( 8 );
// Creating a worksheet
$ws = & $wb->addWorksheet ( '77' );
// set encoding
// $ws->setInputEncoding('utf-8');
// Ceating a format
$cuf = & $wb->addFormat ();
$cuf->setUnderline ( 1 );
$cuf->setAlign ( 'center' );

$uf = & $wb->addFormat ();
$uf->setUnderline ( 1 );

$bf = & $wb->addFormat ();
$bf->setBold ();

$tlcbf = & $wb->addFormat ();
$tlcbf->setTop ( 2 );
$tlcbf->setBottom ( 2 );
$tlcbf->setBold ();
$tlcbf->setAlign ( 'center' );

$ltlcbf = & $wb->addFormat ();
$ltlcbf->setLeft ( 2 );
$ltlcbf->setTop ( 2 );
$ltlcbf->setBottom ( 2 );
$ltlcbf->setBold ();
$ltlcbf->setAlign ( 'center' );

$rtlcbf = & $wb->addFormat ();
$rtlcbf->setRight ( 2 );
$rtlcbf->setTop ( 2 );
$rtlcbf->setBottom ( 2 );
$rtlcbf->setBold ();
$rtlcbf->setAlign ( 'center' );

$cf = & $wb->addFormat ();
$cf->setAlign ( 'center' );

$cbf = & $wb->addFormat ();
$cbf->setBold ();
$cbf->setAlign ( 'center' );

$ctf = & $wb->addFormat ();
$ctf->setAlign ( 'center' );
$ctf->setTop ( 2 );

$crf = & $wb->addFormat ();
$crf->setRight ( 2 );
$crf->setAlign ( 'center' );

$ctrf = & $wb->addFormat ();
$ctrf->setTop ( 2 );
$ctrf->setRight ( 2 );
$ctrf->setAlign ( 'center' );

$clf = & $wb->addFormat ();
$clf->setAlign ( 'center' );
$clf->setBottom ( 2 );

$clrf = & $wb->addFormat ();
$clrf->setAlign ( 'center' );
$clrf->setBottom ( 2 );
$clrf->setRight ( 2 );

$lrf = & $wb->addFormat ();
$lrf->setBottom ( 2 );
$lrf->setRight ( 2 );

$trf = & $wb->addFormat ();
$trf->setTop ( 2 );
$trf->setRight ( 2 );

$row = 0;
$row = $row + 1;
$ws->setMerge ( $row, 0, $row, 12 ); // 合并单元格
$ws->write ( $row, 0, 'Monitoring Survey of Minibus Service', $cuf );

$row = $row + 2;
$ws->write ( $row, 0, 'Route No. :', $bf );
$ws->write ( $row, 2, $sp->routeNo );
$row = $row + 1;
$ws->write ( $row, 0, 'Date :', $bf );
$ws->write ( $row, 2, $sp->surDate );
$ws->write ( $row, 8, 'Survey Period :', $bf );
$ws->write ( $row, 10, ToShortTime ( $sp->surFromTime ) );
$ws->write ( $row, 11, 'to' );
$ws->write ( $row, 12, ToShortTime ( $sp->surToTime ) );
$row = $row + 1;
$ws->write ( $row, 0, 'Location :', $bf );
$ws->write ( $row, 2, $sp->location );
$ws->write ( $row, 8, 'Direction :', $bf );
$ws->write ( $row, 10, $sp->bounds );
$row = $row + 1;
$ws->write ( $row, 12, 'Table 1a', $bf );

// top table
$row = $row + 1;
$ws->writeArea ( $row, 0, $row, 12, '', $ctf );
$ws->write ( $row, 0, 'Time', $ctf );
$ws->write ( $row, 1, 'No. of', $ctf );
$ws->setMerge ( $row, 2, $row, 4 );
$ws->write ( $row, 2, 'No. of', $ctf );
$ws->setMerge ( $row, 5, $row, 11 );
$ws->write ( $row, 5, 'No. of Passengers', $ctf );
$ws->write ( $row, 12, 'Average', $ctrf );
$row = $row + 1;
$ws->write ( $row, 0, '(Half-', $cf );
$ws->write ( $row, 1, 'Arrivals', $cf );
$ws->setMerge ( $row, 2, $row, 4 );
$ws->write ( $row, 2, 'Departures', $cf );
$ws->setMerge ( $row, 5, $row, 6 );
$ws->write ( $row, 5, 'On Arrival', $cf );
$ws->write ( $row, 7, 'Set', $cf );
$ws->write ( $row, 8, 'Picked', $cf );
$ws->setMerge ( $row, 9, $row, 10 );
$ws->write ( $row, 9, 'On Departure', $cf );
$ws->write ( $row, 12, 'Left Behind', $cf );
$ws->write ( $row, 12, 'Waiting', $crf );
$row = $row + 1;
$ws->write ( $row, 0, 'Hourly)', $clf );
$ws->write ( $row, 1, '', $clf );
$ws->write ( $row, 2, '*Sch.', $clf );
$ws->write ( $row, 3, 'Obs.', $clf );
$ws->write ( $row, 4, 'Diff.', $clf );
$ws->write ( $row, 5, 'No.', $clf );
$ws->write ( $row, 6, '(%)', $clf );
$ws->write ( $row, 7, 'Down', $clf );
$ws->write ( $row, 8, 'Up', $clf );
$ws->write ( $row, 9, 'No.', $clf );
$ws->write ( $row, 10, '(%)', $clf );
$ws->write ( $row, 11, '(Occasion)', $clf );
$ws->write ( $row, 12, 'Time(mins.)', $clrf );
// 顶部表格内容
$topTableRows = count ( $topTable ) - 1;
for($i = 0; $i < $topTableRows; $i ++) {
	$row = $row + 1;
	$tempBehind = $topTable [$i] ['leftBehindMinCount'] . '-' . $topTable [$i] ['leftBehindMaxCount'] . '(' . $topTable [$i] ['leftBehindCount'] . ')';
	$ws->write ( $row, 0, $topTable [$i] ['halfHourly'], $cf );
	$ws->write ( $row, 1, $topTable [$i] ['arrivals'], $cf );
	$ws->write ( $row, 2, $topTable [$i] ['busTimeCount'], $cf );
	$ws->write ( $row, 3, $topTable [$i] ['diffNoCount'], $cf );
	$ws->write ( $row, 4, $topTable [$i] ['departureTimeCount'], $cf );
	$ws->write ( $row, 5, $topTable [$i] ['onArrivalCount'], $cf );
	$ws->write ( $row, 6, $topTable [$i] ['arrivals'] == 0 ? '0.00' : sprintf ( "%01.2f", $topTable [$i] ['onArrivalCount'] / ($topTable [$i] ['arrivals'] * $person) * 100 ), $cf );
	$ws->write ( $row, 7, $topTable [$i] ['setDownCount'], $cf );
	$ws->write ( $row, 8, $topTable [$i] ['pickupCount'], $cf );
	$ws->write ( $row, 9, $topTable [$i] ['onDeptCount'], $cf );
	$ws->write ( $row, 10, $topTable [$i] ['arrivals'] == 0 ? '0.00' : sprintf ( "%01.2f", $topTable [$i] ['onDeptCount'] / ($topTable [$i] ['arrivals'] * $person) * 100 ), $cf );
	$ws->write ( $row, 11, $tempBehind, $cf );
	$ws->write ( $row, 12, $topTable [$i] ['arrivals'] == 0 ? '0.00' : sprintf ( "%01.2f", $topTable [$i] ['headWayCount'] / $topTable [$i] ['arrivals'] ), $crf );
}
// 设置顶部表格底部
$leftBehindCount = $topTable ['total'] ['leftBehindMinCount'] . '-' . $topTable ['total'] ['leftBehindMaxCount'] . '(' . $topTable ['total'] ['leftBehindCount'] . ')';
$row = $row + 1;
$ws->write ( $row, 0, 'Total', $ltlcbf );
$ws->write ( $row, 1, $topTable ['total'] ['arrivals'], $tlcbf );
$ws->write ( $row, 2, $topTable ['total'] ['busTimeCount'], $tlcbf );
$ws->write ( $row, 3, $topTable ['total'] ['departureTimeCount'], $tlcbf );
$ws->write ( $row, 4, $topTable ['total'] ['diffNoCount'], $tlcbf );
$ws->write ( $row, 5, $topTable ['total'] ['onArrivalCount'], $tlcbf );
$ws->write ( $row, 6, $topTable ['total'] ['arrivals'] == 0 ? '0.00' : sprintf ( "%01.2f", $topTable ['total'] ['onArrivalCountTotal'] / ($topTable ['total'] ['arrivals'] * $person) * 100 ), $tlcbf );
$ws->write ( $row, 7, $topTable ['total'] ['setDownCount'], $tlcbf );
$ws->write ( $row, 8, $topTable ['total'] ['pickupCount'], $tlcbf );
$ws->write ( $row, 9, $topTable ['total'] ['onDeptCount'], $tlcbf );
$ws->write ( $row, 10, $topTable ['total'] ['arrivals'] == 0 ? '0.00' : sprintf ( "%01.2f", $topTable ['total'] ['onDeptCount'] / ($topTable ['total'] ['arrivals'] * $person) * 100 ), $tlcbf );
$ws->write ( $row, 11, $leftBehindCount, $tlcbf );
$ws->write ( $row, 12, $topTable ['total'] ['arrivals'] == 0 ? '0.00' : sprintf ( "%01.2f", $topTable ['total'] ['headWayCount'] / $topTable ['total'] ['arrivals'] ), $rtlcbf );

// 中间表格
$schFre = $topTable ['total'] ['busTimeCount'] == 0 ? 0 : ceil ( $surTimeDiff / $topTable ['total'] ['busTimeCount'] );
$obsFre = $topTable ['total'] ['departureTimeCount'] == 0 ? 0 : ceil ( $surTimeDiff / $topTable ['total'] ['departureTimeCount'] );
$fleetNoList = array ();
$lowTableRows = count ( $lowTable ) - 1;
for($i = 0; $i < $lowTableRows; $i ++) {
	$fleetNoList [] = $lowTable [$i] ['fleetNo'];
}
$fleetNoList = UniqueArray ( $fleetNoList );
$fleetNoListRows = count ( $fleetNoList );
$row = $row + 1;
$row = $row + 1;
$ws->write ( $row, 0, 'Vehicle Allocation', $uf );
$row = $row + 1;
$ws->write ( $row, 0, 'Schedule:' );
$ws->write ( $row, 2, $busSchNo [0] );
$ws->write ( $row, 3, 'GMBs' );
$ws->write ( $row, 6, 'Schedule Frequency:' );
$ws->write ( $row, 9, $schFre );
$ws->write ( $row, 10, 'Minutes' );
$row = $row + 1;
$ws->write ( $row, 0, 'Observed:' );
$ws->write ( $row, 2, $fleetNoListRows );
$ws->write ( $row, 3, 'GMBs' );
$ws->write ( $row, 6, 'Observed Frequency:' );
$ws->write ( $row, 9, $obsFre );
$ws->write ( $row, 10, 'Minutes' );
$row = $row + 1;
$ws->write ( $row, 0, 'Difference:' );
$ws->write ( $row, 2, $fleetNoListRows - $busSchNo [0] );
$ws->write ( $row, 3, 'GMBs' );
$ws->write ( $row, 6, 'Schedule Frequency:' );
$ws->write ( $row, 9, $obsFre - $schFre );
$ws->write ( $row, 10, 'Minutes' );
$row = $row + 1;
$row = $row + 1;

// 中间车辆部分
$ws->write ( $row, 0, 'Registration Number', $uf );
$row = $row + 1;
$row = $row + 1;
$m = 0;
for($i = 0; $i < $fleetNoListRows; $i ++) {
	$ws->write ( $row, $m, $fleetNoList [$i] );
	$m ++;
	if ($m % 14 == 0) {
		$row = $row + 1;
		$m = 0;
	}
}
// $ws->write($row,0,'XXXXXX');
$row = $row + 1;
$ws->write ( $row, 12, 'Table 1b', $cbf );

// bottom table
$row = $row + 1;
$ws->write ( $row, 0, 'Registration', $ctf );
$ws->write ( $row, 1, 'Arrival', $ctf );
$ws->setMerge ( $row, 2, $row, 4 );
$ws->writeArea ( $row, 2, $row, 4, '', $ctf );
$ws->write ( $row, 2, 'Departure Time', $ctf );
$ws->write ( $row, 5, 'PSL', $ctf );
$ws->setMerge ( $row, 6, $row, 13 );
$ws->writeArea ( $row, 6, $row, 13, '', $ctf );
$ws->write ( $row, 13, '', $ctrf );
$ws->write ( $row, 6, 'No. of Passengers', $ctf );
$row = $row + 1;
$ws->write ( $row, 0, 'No.', $cf );
$ws->write ( $row, 1, 'Time', $cf );
$ws->write ( $row, 2, '*at Terminus' );
$ws->writeArea ( $row, 3, $row, 5, '' );
$ws->setMerge ( $row, 6, $row, 7 );
$ws->write ( $row, 6, 'On Arrival', $cf );
$ws->write ( $row, 8, 'Set', $cf );
$ws->write ( $row, 9, 'Picked', $cf );
$ws->setMerge ( $row, 10, $row, 11 );
$ws->write ( $row, 10, 'On Departure', $cf );
$ws->write ( $row, 12, 'Left Behind', $cf );
$ws->write ( $row, 13, 'Headway', $crf );
$row = $row + 1;
$ws->writeArea ( $row, 0, $row, 1, '', $clf );
$ws->write ( $row, 2, '*Sch.', $clf );
$ws->write ( $row, 3, 'Obs.', $clf );
$ws->write ( $row, 4, 'Diff.', $clf );
$ws->write ( $row, 5, '', $clf );
$ws->write ( $row, 6, 'No.', $clf );
$ws->write ( $row, 7, '(%)', $clf );
$ws->write ( $row, 8, 'Down', $clf );
$ws->write ( $row, 9, 'Up', $clf );
$ws->write ( $row, 10, 'No.', $clf );
$ws->write ( $row, 11, '(%)', $clf );
$ws->write ( $row, 12, '(Occasion)', $clf );
$ws->write ( $row, 13, '(min)', $clrf );
// 底部表格内容
for($i = 0; $i < $lowTableRows; $i ++) {
	$row = $row + 1;
	$fleetNo = $lowTable [$i] ['skippedStop'] == 1 ? '*' : '';
	$fleetNo .= $lowTable [$i] ['fleetNo'];
	$ws->write ( $row, 0, $fleetNo, $cf );
	$ws->write ( $row, 1, $lowTable [$i] ['arrivalTime'], $cf );
	$ws->write ( $row, 2, $lowTable [$i] ['busTime'], $cf );
	$ws->write ( $row, 3, $lowTable [$i] ['departureTime'], $cf );
	$ws->write ( $row, 4, $lowTable [$i] ['diffNo'] ? $lowTable [$i] ['diffNo'] : '--', $cf );
	$ws->write ( $row, 5, $lowTable [$i] ['pslNo'], $cf );
	$ws->write ( $row, 6, $lowTable [$i] ['onArrival'], $cf );
	$ws->write ( $row, 7, $lowTable [$i] ['onArrival'] / $person * 100, $cf );
	$ws->write ( $row, 8, $lowTable [$i] ['pickup'], $cf );
	$ws->write ( $row, 9, $lowTable [$i] ['setDown'], $cf );
	$ws->write ( $row, 10, $lowTable [$i] ['leftBehind'], $cf );
	$ws->write ( $row, 11, $lowTable [$i] ['onDept'], $cf );
	$ws->write ( $row, 12, $lowTable [$i] ['onDept'] / $person * 100, $cf );
	$ws->write ( $row, 13, $lowTable [$i] ['headWay'] ? $lowTable [$i] ['headWay'] : '--', $crf );
}
// 底部表格统计
$leftBehindTotal = $lowTable ['total'] ['leftBehindMin'] . '-' . $lowTable ['total'] ['leftBehindMax'] . '(' . $lowTable ['total'] ['leftBehindTotal'] . ')';
$row = $row + 1;
$ws->write ( $row, 0, 'Total', $ltlcbf );
$ws->write ( $row, 1, $lowTable ['total'] ['recordTotal'], $tlcbf );
$ws->write ( $row, 2, $lowTable ['total'] ['busTimeTotal'], $tlcbf );
$ws->write ( $row, 3, $lowTable ['total'] ['recordTotal'], $tlcbf );
$ws->write ( $row, 4, $lowTable ['total'] ['diffTotal'], $tlcbf );
$ws->write ( $row, 5, '', $tlcbf );
$ws->write ( $row, 6, $lowTable ['total'] ['onArrivalTotal'], $tlcbf );
$ws->write ( $row, 7, $lowTable ['total'] ['recordTotal'] == 0 ? '0.00' : sprintf ( "%01.2f", $lowTable ['total'] ['onArrivalTotal'] / ($lowTable ['total'] ['recordTotal'] * $person) * 100 ), $tlcbf );
$ws->write ( $row, 8, $lowTable ['total'] ['setDownTotal'], $tlcbf );
$ws->write ( $row, 9, $lowTable ['total'] ['pickupTotal'], $tlcbf );
$ws->write ( $row, 10, $lowTable ['total'] ['onDeptTotal'], $tlcbf );
$ws->write ( $row, 11, $lowTable ['total'] ['recordTotal'] == 0 ? '0.00' : sprintf ( "%01.2f", $lowTable ['total'] ['onDeptTotal'] / ($lowTable ['total'] ['recordTotal'] * $person) * 100 ), $tlcbf );
$ws->write ( $row, 12, $leftBehindTotal, $tlcbf );
$ws->write ( $row, 13, $lowTable ['total'] ['headWayTotal'], $rtlcbf );

$row = $row + 1;
if ($lowTable ['total'] ['skippedStopTotal'] > 0)
	$ws->write ( $row, 0, '*=skipped stop', $tlcbf );
	
	// Let's send the file
$wb->close ();
header ( 'Location:' . $_GET ['next'] );
?>
