<?php
/*
 * Header: Create: 2008-03-08 Auther: Jamblues. M S N: jamblues@gmail.com
 */
include_once ("./includes/config.inc.php");
include_once ("../library/init.php");
require_once '../library/Spreadsheet/Excel/Writer.php';

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$ad = new AppendixD ();
if (! empty ( $_GET ['appeId'] )) {
	$ad->appeId = $_GET ['appeId'];
} else {
	exit ();
}

$ada = new AppendixDAccess ( $db );
$rs = $ada->GetListSearch ( $ad );
$rsNo = count ( $rs );
$sur = new Surveyor ();
if ($rsNo > 0) {
	$ad = $rs [0];
	// surveyor part
	$sur->survId = $ad->survId;
	if ($sur->survId > 0) {
		$sa = new SurveyorAccess ( $db );
		$rs = $sa->GetListSearch ( $sur );
		$sur = $rs [0];
	}
} else {
	exit ();
}

$fileName = $conf ["path"] ["otherExcel"] . 'AppendixD_' . $sur->survId . '_' . $ad->surveyDate . '.xls';

// Creating a workbook
$wb = new Spreadsheet_Excel_Writer ( $fileName );

// set version
$wb->setVersion ( 8 );

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

// Creating a worksheet
$ws = & $wb->addWorksheet ( 'AppendixD Survey Forms' );
// set encoding
$ws->setInputEncoding ( 'utf-8' );

$row = 0;
$row = $row + 1;
$ws->setMerge ( $row, 0, $row, 9 );
$ws->write ( $row, 0, "華人永遠墳場 交通調查", $cbf );

$row = $row + 1;

$row = $row + 1;
$ws->write ( $row, 7, "調查日期:", $cf );
$ws->setMerge ( $row, 8, $row, 9 );
$ws->write ( $row, 8, $ad->surveyDate, $cf );

$row = $row + 1;
$ws->write ( $row, 7, "調查時間:", $cf );
$ws->setMerge ( $row, 8, $row, 9 );
$ws->write ( $row, 8, ToShortTime ( $ad->surveyTime ), $cf );

$row = $row + 1;
$ws->write ( $row, 0, "調查位置:", $cu );
$ws->setMerge ( $row, 1, $row, 6 );
$ws->write ( $row, 1, $ad->location, $cf );
$ws->write ( $row, 7, "調查員:", $cf );
$ws->setMerge ( $row, 8, $row, 9 );
$ws->write ( $row, 8, $sur->engName, $cf );

$row = $row + 1;

$row = $row + 1;
$ws->write ( $row, 0, "Time 時間", $ctf );
$ws->write ( $row, 1, "被訪者拒絕回答?", $ctf );
$ws->writeArea ( $row, 2, $row, 5, '', $ctf );
$ws->setMerge ( $row, 2, $row, 5 );
$ws->write ( $row, 2, "請問你是乘搭哪種交通工具前來墳場? \r\n What transport mode you are using to get to the Cemetery?", $ctf );
$ws->writeArea ( $row, 6, $row, 9, '', $ctf );
$ws->setMerge ( $row, 6, $row, 9 );
$ws->write ( $row, 6, "請問你是乘搭哪種交通工具離開墳場? \r\n What transport mode you are using to leave the Cemetery?", $ctf );
$ws->write ( $row, 9, "", $ctrf );

$add = new AppendixDDetail ();
$add->appeId = $ad->appeId;
$adda = new AppendixDDetailAccess ();
$rs = $adda->GetListSearch ( $add );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	$add = $rs [$i];
	$row = $row + 1;
	$ws->write ( $row, 0, ToShortTime ( $add->surveyTime ), $cf );
	$ws->write ( $row, 1, $add->isReject, $cf );
	$ws->writeArea ( $row, 2, $row, 5, '', $cf );
	$ws->setMerge ( $row, 2, $row, 5 );
	$ws->write ( $row, 2, $add->questionOne_1, $cf );
	$ws->writeArea ( $row, 6, $row, 9, '', $cf );
	$ws->setMerge ( $row, 6, $row, 9 );
	$ws->write ( $row, 6, $add->questionTwo_1, $cf );
	$ws->write ( $row, 9, "", $crf );
}

$row = $row + 1;
$ws->writeArea ( $row, 0, $row, 9, '', $ctf );

// Let's send the file
$wb->close ();
?>
<?php

print "salary excel file has aready been created.<br /> " . " click <a href='" . $_SERVER ["PHP_SELF"] . "'>here</a> to refresh this excel.<br />" . "right click <a href='" . $fileName . "'>here</a> save target as.";

?>
