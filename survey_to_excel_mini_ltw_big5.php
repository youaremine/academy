<?php
/*
 * Header: Create: 2006-06-23 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
include_once ("../library/init.php");
require_once '../library/Spreadsheet/Excel/Writer.php';

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
$wb = new Spreadsheet_Excel_Writer ();
// sending HTTP headers
$wb->send ( $fileName );
// set version
$wb->setVersion ( 8 );
// Creating a worksheet
$ws = & $wb->addWorksheet ( $sp->refNo );
// set encoding
$ws->setInputEncoding ( 'utf-8' );
// Ceating a format
$cuf = & $wb->addFormat ();
$cuf->setUnderline ( 1 );
$cuf->setAlign ( 'center' );

$rf = & $wb->addFormat ();
$rf->setAlign ( 'left' );

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

$cztf = & $wb->addFormat ();
$cztf->setAlign ( 'center' );
$cztf->setTop ( 2 );
$cztf->setLeft ( 2 );

$czlf = & $wb->addFormat ();
$czlf->setAlign ( 'center' );
$czlf->setLeft ( 2 );
$czlf->setBottom ( 2 );

$czf = & $wb->addFormat ();
$czf->setAlign ( 'center' );
$czf->setLeft ( 2 );

$person = $conf ['bus'] ['big'] ['person'];

if ($subjectName == "Monitoring Survey of Bus Service") {
	$subjectName = "巴士班次調查";
} else if ($subjectName == "Monitoring Survey of Minibus Service") {
	$subjectName = "小巴班次調查";
}
$vehicleName = "班";

$row = 0;
$row = $row + 1;
$ws->setMerge ( $row, 0, $row, 10 ); // 合并单元格
$ws->write ( $row, 0, $subjectName, $cuf );

$row = $row + 2;
$ws->write ( $row, 0, '調查路線:', $bf );
$ws->write ( $row, 2, $sp->routeNo );
$row = $row + 1;
$ws->write ( $row, 0, '調查日期 :', $bf );
$ws->write ( $row, 2, $sp->surDate );
$ws->write ( $row, 6, '調查時間 :', $bf );
$ws->write ( $row, 8, ToShortTime ( $sp->surFromTime ) );
$ws->write ( $row, 9, '至' );
$ws->write ( $row, 10, ToShortTime ( $sp->surToTime ) );
$row = $row + 1;
$ws->write ( $row, 0, '調查地點 :', $bf );
$ws->write ( $row, 2, $sp->location );
$ws->write ( $row, 6, '調查方向 :', $bf );
$ws->write ( $row, 8, $sp->bounds );
$row = $row + 1;
$ws->write ( $row, 10, '表格 1a', $bf );

// 计总表格头部
$row = $row + 1;
$ws->writeArea ( $row, 1, $row, 10, '', $ctf );
$ws->write ( $row, 0, '開始時間', $cztf );
$ws->write ( $row, 1, '到達車輛', $ctf );
$ws->write ( $row, 2, '離開車輛', $ctf );
$ws->setMerge ( $row, 3, $row, 9 );
$ws->write ( $row, 3, '乘客數目', $ctf );
$ws->write ( $row, 10, '平均', $ctrf );
$row = $row + 1;
$ws->write ( $row, 0, '(每半', $czf );
$ws->write ( $row, 1, '數目', $cf );
$ws->write ( $row, 2, '數目', $cf );
$ws->setMerge ( $row, 3, $row, 4 );
$ws->write ( $row, 3, '到達', $cf );
$ws->write ( $row, 5, '落車', $cf );
$ws->write ( $row, 6, '上車', $cf );
$ws->setMerge ( $row, 7, $row, 8 );
$ws->write ( $row, 7, '離開', $cf );
$ws->write ( $row, 9, '車站人龍', $cf );
$ws->write ( $row, 10, '等候時間', $crf );
$row = $row + 1;
$ws->write ( $row, 0, '小時)', $czlf );
$ws->write ( $row, 1, '', $clf );
$ws->write ( $row, 2, '', $clf );
$ws->write ( $row, 3, '車上人數', $clf );
$ws->write ( $row, 4, '載客率(%)', $clf );
$ws->write ( $row, 5, '人數', $clf );
$ws->write ( $row, 6, '人數', $clf );
$ws->write ( $row, 7, '人數', $clf );
$ws->write ( $row, 8, '載客率(%)', $clf );
$ws->write ( $row, 9, '(出現次數)', $clf );
$ws->write ( $row, 10, '(分鐘)', $clrf );
// 计总表格主体内容
$topTableRows = count ( $topTable ) - 1;
for($i = 0; $i < $topTableRows; $i ++) {
	$row = $row + 1;
	$tempBehind = $topTable [$i] ['leftBehindMinCount'] . '-' . $topTable [$i] ['leftBehindMaxCount'] . '(' . $topTable [$i] ['leftBehindCount'] . ')';
	$ws->write ( $row, 0, $topTable [$i] ['halfHourly'], $czf );
	$ws->write ( $row, 1, $topTable [$i] ['arrivals'], $cf );
	$ws->write ( $row, 2, $topTable [$i] ['departureTimeCount'], $cf );
	$ws->write ( $row, 3, $topTable [$i] ['onArrivalCount'], $cf );
	$ws->write ( $row, 4, $topTable [$i] ["onArrivalCountPercent"], $cf );
	$ws->write ( $row, 5, $topTable [$i] ['setDownCount'], $cf );
	$ws->write ( $row, 6, $topTable [$i] ['pickupCount'], $cf );
	$ws->write ( $row, 7, $topTable [$i] ['onDeptCount'], $cf );
	$ws->write ( $row, 8, $topTable [$i] ["onDeptCountPercent"], $cf );
	$ws->write ( $row, 9, $tempBehind, $cf );
	$ws->write ( $row, 10, $topTable [$i] ['headWayCount'], $crf );
}
// 计总表格底部
$leftBehindCount = $topTable ['total'] ['leftBehindMinCount'] . '-' . $topTable ['total'] ['leftBehindMaxCount'] . '(' . $topTable ['total'] ['leftBehindCount'] . ')';
$row = $row + 1;
$ws->write ( $row, 0, '總數', $ltlcbf );
$ws->write ( $row, 1, $topTable ['total'] ['arrivals'], $tlcbf );
$ws->write ( $row, 2, $topTable ['total'] ['departureTimeCount'], $tlcbf );
$ws->write ( $row, 3, $topTable ['total'] ['onArrivalCount'], $tlcbf );
$ws->write ( $row, 4, $topTable ['total'] ["onArrivalCountTotalPercent"], $tlcbf );
$ws->write ( $row, 5, $topTable ['total'] ['setDownCount'], $tlcbf );
$ws->write ( $row, 6, $topTable ['total'] ['pickupCount'], $tlcbf );
$ws->write ( $row, 7, $topTable ['total'] ['onDeptCount'], $tlcbf );
$ws->write ( $row, 8, $topTable ['total'] ["onDeptCountTotalPercent"], $tlcbf );
$ws->write ( $row, 9, $leftBehindCount, $tlcbf );
$ws->write ( $row, 10, $topTable ['total'] ["headWayCountTotal"], $rtlcbf );

// table 1b start
$row = $row + 2;
$row = $row + 1;
$ws->write ( $row, 10, '表格 1b', $cbf );

// 明细表格头部
$row = $row + 1;
$ws->write ( $row, 0, '車牌', $cztf );
$ws->write ( $row, 1, '到達', $ctf );
$ws->write ( $row, 2, '離開', $ctf );
$ws->setMerge ( $row, 3, $row, 10 );
$ws->writeArea ( $row, 3, $row, 10, '', $ctf );
$ws->write ( $row, 10, '', $ctrf );
$ws->write ( $row, 3, '乘客數目', $ctf );
$row = $row + 1;
$ws->write ( $row, 0, '號碼', $czf );
$ws->write ( $row, 1, '時間', $cf );
$ws->write ( $row, 2, '時間', $cf );
$ws->setMerge ( $row, 3, $row, 4 );
$ws->write ( $row, 3, '到達', $cf );
$ws->write ( $row, 5, '落車', $cf );
$ws->write ( $row, 6, '上車', $cf );
$ws->setMerge ( $row, 7, $row, 8 );
$ws->write ( $row, 7, '離開', $cf );
$ws->write ( $row, 9, '車站人龍', $cf );
$ws->write ( $row, 10, '班次', $crf );
$row = $row + 1;
$ws->write ( $row, 0, '', $czlf );
$ws->write ( $row, 1, '', $clf );
$ws->write ( $row, 2, '', $clf );
$ws->write ( $row, 3, '車上人數', $clf );
$ws->write ( $row, 4, '載客率(%)', $clf );
$ws->write ( $row, 5, '人數', $clf );
$ws->write ( $row, 6, '人數', $clf );
$ws->write ( $row, 7, '人數', $clf );
$ws->write ( $row, 8, '載客率(%)', $clf );
$ws->write ( $row, 9, '(出現次數)', $clf );
$ws->write ( $row, 10, '(分鐘)', $clrf );
// 明细表格主体内容
$lowTableRows = count ( $lowTable ) - 1;
for($i = 0; $i < $lowTableRows; $i ++) {
	if ($lowTable [$i] ['fleetNo'] == "" || $lowTable [$i] ['fleetNo'] == "Missing")
		continue;
	$row = $row + 1;
	$fleetNo = $lowTable [$i] ['skippedStop'] == 1 ? '*' : '';
	$fleetNo .= $lowTable [$i] ['fleetNo'];
	$ws->write ( $row, 0, $fleetNo, $czf );
	$ws->write ( $row, 1, $lowTable [$i] ['arrivalTime'], $cf );
	$ws->write ( $row, 2, $lowTable [$i] ['departureTime'], $cf );
	$ws->write ( $row, 3, $lowTable [$i] ['onArrival'], $cf );
	$ws->write ( $row, 4, $lowTable [$i] ['onArrivalPercent'], $cf );
	$ws->write ( $row, 5, $lowTable [$i] ['setDown'], $cf );
	$ws->write ( $row, 6, $lowTable [$i] ['pickup'], $cf );
	$ws->write ( $row, 7, $lowTable [$i] ['onDept'], $cf );
	$ws->write ( $row, 8, $lowTable [$i] ["onDeptPercent"], $cf );
	$ws->write ( $row, 9, $lowTable [$i] ['leftBehind'], $cf );
	$ws->write ( $row, 10, $lowTable [$i] ['headWay'] ? $lowTable [$i] ['headWay'] : '--', $crf );
	// 计算比预计班次早还是晚
	if (! empty ( $lowTable [$i] ['busTime'] ) && ! empty ( $lowTable [$i] ['departureTime'] )) {
		if ($lowTable [$i] ['busTime'] > $lowTable [$i] ['departureTime']) {
			$lowTable ['total'] ['beforeObs'] += 1;
		} else if ($lowTable [$i] ['busTime'] < $lowTable [$i] ['departureTime']) {
			$lowTable ['total'] ['afterObs'] += 1;
		}
	}
}
// 明细表格统计
$leftBehindTotal = $lowTable ['total'] ['leftBehindMin'] . '-' . $lowTable ['total'] ['leftBehindMax'] . '(' . $lowTable ['total'] ['leftBehindTotal'] . ')';
$row = $row + 1;
$ws->write ( $row, 0, '總數', $ltlcbf );
$ws->write ( $row, 1, $lowTable ['total'] ['recordTotal'], $tlcbf );
$ws->write ( $row, 2, $lowTable ['total'] ['recordTotal'], $tlcbf );
$ws->write ( $row, 3, $lowTable ['total'] ['onArrivalTotal'], $tlcbf );
$ws->write ( $row, 4, $lowTable ['total'] ["onArrivalTotalPercent"], $tlcbf );
$ws->write ( $row, 5, $lowTable ['total'] ['setDownTotal'], $tlcbf );
$ws->write ( $row, 6, $lowTable ['total'] ['pickupTotal'], $tlcbf );
$ws->write ( $row, 7, $lowTable ['total'] ['onDeptTotal'], $tlcbf );
$ws->write ( $row, 8, $lowTable ['total'] ["onDeptTotalPercent"], $tlcbf );
$ws->write ( $row, 9, $leftBehindTotal, $tlcbf );
$ws->write ( $row, 10, '--', $rtlcbf );

// 跳站標記
$row = $row + 1;
if ($lowTable ['total'] ['skippedStopTotal'] > 0)
	$ws->write ( $row, 5, '*=skipped stop' );
	
	// 中间表格
$row = $row + 1;
$schFre = $topTable ['total'] ['busTimeCount'] == 0 ? 0 : ceil ( $surTimeDiff / $topTable ['total'] ['busTimeCount'] );
$obsFre = $topTable ['total'] ['departureTimeCount'] == 0 ? 0 : ceil ( $surTimeDiff / $topTable ['total'] ['departureTimeCount'] );

$row = $row + 1;
$ws->write ( $row, 0, '預定班次有:' );
$ws->write ( $row, 2, $lowTable ['total'] ['busTimeTotal'] );
$ws->write ( $row, 3, $vehicleName );

$row = $row + 1;
$ws->write ( $row, 0, '實際班次有:' );
$ws->write ( $row, 2, $lowTable ['total'] ['recordTotal'] );
$ws->write ( $row, 3, $vehicleName );
$ws->write ( $row, 6, '平均班次:' );
$ws->write ( $row, 9, $obsFre );
$ws->write ( $row, 10, '分鐘' );
$row = $row + 1;
$ws->write ( $row, 0, '比預定班次早到的有:' );
$ws->write ( $row, 2, $lowTable ['total'] ['beforeObs'] );
$ws->write ( $row, 3, $vehicleName );
$row = $row + 1;
$ws->write ( $row, 0, '比預定班次遲到的有:' );
$ws->write ( $row, 2, $lowTable ['total'] ['afterObs'] );
$ws->write ( $row, 3, $vehicleName );
$row = $row + 1;

$ws->setColumn ( 0, 0, 10.6 );
$ws->setColumn ( 11, 12, 10 );
// version(9)支持这个属性,但又不支持中文.
// $ws->printArea(0,0,$row,12);
$ws->setPrintScale ( 68 );
// Let's send the file
$wb->close ();
// header('Location:'.$_GET['next']);
?>
