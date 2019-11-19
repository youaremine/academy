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

if ($_GET ['supaId'] == "") {
	header ( "Location:list.php" );
	exit ();
}

// 表头数据
$spl = new SurveyPartList ( $db );
$spl->supaId = $_GET ['supaId'];
$rs = $spl->GetListSearch ();
$sp = $rs [0];
$surFromTime = explode ( ':', $sp->surFromTime );
$surFromTimeHor = $surFromTime [0];
$surFromTimeMin = $surFromTime [1];
$surToTime = explode ( ':', $sp->surToTime );
$surToTimeHor = $surToTime [0];
$surToTimeMin = $surToTime [1];
$surPeriod = $surFromTimeHor . ':' . $surFromTimeMin . '-' . $surToTimeHor . ':' . $surToTimeMin;
$weathers = getArray ( 'weather' );
$weatherName = $weathers [$sp->weatherId];

$fileName = CustomerReplace ( $sp->refNo ) . '.xls';

// Add Log
$uh = new UserHistory ();
$uha = new UserHistoryAccess ( $db );
$uh->jobId = $spl->supaId;
$uh->type = 'Monitoring Survey ';
$uh->action = 'Input Download';
$uh->userId = $_SESSION ['userId'];
$uh->startTime = date ( $conf ['dateTime'] ['format'] );
$uh->endTime = $uh->startTime;
$uha->Add ( $uh );

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

$cvuf = & $wb->addFormat ();
$cvuf->setUnderline ( 1 );
$cvuf->setAlign ( 'center' );
$cvuf->setVAlign ( 'vcentre' );

$cubf = & $wb->addFormat ();
$cubf->setUnderline ( 1 );
$cubf->setBold ();
$cubf->setAlign ( 'center' );

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
$ws->setRow ( $row, '40' );
$ws->setMerge ( $row, 7, $row, 9 );
$ws->write ( $row, 7, "MiniBus Terminal \r\n Survey Form", $cvuf );
$ws->write ( $row, 10, "Form D2", $cvuf );
$row = $row + 1;
$ws->write ( $row, 0, 'REF NO.:', $bf );
$ws->write ( $row, 2, $sp->refNo );
$ws->setMerge ( $row, 9, $row, 10 );
$ws->writeArea ( $row, 9, $row, 10, '', $clf );
$ws->write ( $row, 7, 'Survey Date' );
$ws->write ( $row, 9, $sp->surDate, $clf );
$row = $row + 1;
// 只有 NT 顯示"天氣".
if (strtoupper ( substr ( $sp->refNo, 0, 1 ) ) == "N") {
	$ws->write ( $row, 0, 'Weather:' );
	$ws->write ( $row, 2, $weatherName );
}
$ws->setMerge ( $row, 9, $row, 10 );
$ws->writeArea ( $row, 9, $row, 10, '', $clf );
$ws->write ( $row, 7, 'Survey Period' );
$ws->write ( $row, 9, $surPeriod, $clf );
$row = $row + 2;
$ws->setMerge ( $row, 9, $row, 10 );
$ws->writeArea ( $row, 9, $row, 10, '', $clf );
$ws->write ( $row, 7, 'Location:' );
$ws->write ( $row, 9, $sp->location, $clf );
$row = $row + 1;
$ws->setMerge ( $row, 9, $row, 10 );
$ws->writeArea ( $row, 9, $row, 10, '', $clf );
$ws->write ( $row, 7, 'Bounds:' );
$ws->write ( $row, 9, $sp->bounds, $clf );
$row = $row + 1;
$ws->setMerge ( $row, 9, $row, 10 );
$ws->writeArea ( $row, 9, $row, 10, '', $clf );
if (UserLogin::IsReadOnly ()) {
	$ws->write ( $row, 7, '' );
	$ws->write ( $row, 9, "", $clf );
} else {
	$ws->write ( $row, 7, 'Input User:' );
	$ws->write ( $row, 9, $sp->userName, $clf );
}
$row = $row + 1;
$ws->write ( $row, 0, 'Route No:' );
$ws->write ( $row, 2, $sp->routeNo, $cbf );
$ws->write ( $row, 5, 'GMB' );
// top table
$row = $row + 1;
$ws->writeArea ( $row, 0, $row, 10, '', $ctf );
$ws->setMerge ( $row, 0, $row + 2, 0 );
$ws->write ( $row, 0, 'Registration Plate No. / Fleet No. ', $ctf );
$ws->write ( $row, 1, 'PSL', $ctf );
$ws->setMerge ( $row, 2, $row, 5 );
$ws->write ( $row, 2, 'Time', $ctf );
$ws->write ( $row, 6, 'On Arrival.', $ctf );
$ws->write ( $row, 7, 'Pick Up.', $ctf );
$ws->write ( $row, 8, 'Set Down.', $ctf );
$ws->write ( $row, 9, 'Left Behind.', $ctf );
$ws->write ( $row, 10, 'On Dept.', $ctrf );
$row = $row + 1;
$ws->setMerge ( $row, 2, $row, 3 );
$ws->write ( $row, 2, 'Arrival', $cf );
$ws->setMerge ( $row, 4, $row, 5 );
$ws->write ( $row, 4, 'Departure', $cf );
$ws->write ( $row, 10, '', $crf );
$row = $row + 1;
$ws->write ( $row, 0, '', $clf );
$ws->write ( $row, 1, 'No.', $clf );
$ws->write ( $row, 2, 'Hr.', $clf );
$ws->write ( $row, 3, 'Min.', $clf );
$ws->write ( $row, 4, 'Hr.', $clf );
$ws->write ( $row, 5, 'Min.', $clf );
$ws->write ( $row, 6, '(No.)', $clf );
$ws->write ( $row, 7, '(No.)', $clf );
$ws->write ( $row, 8, '(No.)', $clf );
$ws->write ( $row, 9, '(No.)', $clf );
$ws->write ( $row, 10, '(No.)', $clrf );

// 中间内容部分
$sdl = new SurveyDetailList ( $db );
$sdl->supaId = $_GET ['supaId'];
$rs = $sdl->GetListSearch ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$sd = $rs [$i];
	$arrivalTime = explode ( ':', $sd->arrivalTime );
	$arrivalTimeHor = $arrivalTime [0];
	$arrivalTimeMin = $arrivalTime [1];
	$departureTime = explode ( ':', $sd->departureTime );
	$departureTimeHor = $departureTime [0];
	$departureTimeMin = $departureTime [1];
	
	$row = $row + 1;
	$ws->write ( $row, 0, $sd->fleetNo, $cf );
	$ws->write ( $row, 1, $sd->pslNo, $cf );
	$ws->write ( $row, 2, $arrivalTimeHor, $cf );
	$ws->write ( $row, 3, $arrivalTimeMin, $cf );
	$ws->write ( $row, 4, $departureTimeHor, $cf );
	$ws->write ( $row, 5, $departureTimeMin, $cf );
	$ws->write ( $row, 6, $sd->onArrival, $cf );
	$ws->write ( $row, 7, $sd->pickup, $cf );
	$ws->write ( $row, 8, $sd->setDown, $cf );
	$ws->write ( $row, 9, $sd->leftBehind, $cf );
	$ws->write ( $row, 10, $sd->onDept, $crf );
}
$row = $row + 1;
$ws->writeArea ( $row, 0, $row, 10, '', $ctf );
// Let's send the file
$wb->close ();

// header('Location:'.$_GET['next']);
?>
