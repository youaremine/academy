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

$qt = new QuestionairnTaxi ();
if (! empty ( $_GET ['qutaId'] )) {
	$qt->qutaId = $_GET ['qutaId'];
} else {
	exit ();
}

$qta = new QuestionairnTaxiAccess ( $db );
$rs = $qta->GetListSearch ( $qt );
$rsNum = count ( $rs );
$sur = new Surveyor ();
if ($rsNum > 0) {
	$qt = $rs [0];
	// surveyor part
	$sur->survId = $qt->survId;
	if ($sur->survId > 0) {
		$sa = new SurveyorAccess ( $db );
		$rs = $sa->GetListSearch ( $sur );
		$sur = $rs [0];
	}
} else {
	exit ();
}

$fileName = $conf ["path"] ["taxiExcel"] . $qt->qutaId . '_' . $qt->district . '.xls';

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
$ws = & $wb->addWorksheet ( 'Taxi Sundry Income' );
// set encoding
$ws->setInputEncoding ( 'utf-8' );

$row = 0;
$row = $row + 1;
$ws->setMerge ( $row, 0, $row, 9 );
$ws->write ( $row, 0, "Taxi Sundry Income Survey 2007", $cf );
$row = $row + 1;
$ws->setMerge ( $row, 0, $row, 9 );
$ws->write ( $row, 0, " Interview Survey on Alighting Taxi Passenger", $cuf );
$row = $row + 1;

$row = $row + 1;
$ws->setMerge ( $row, 0, $row, 1 );
$ws->write ( $row, 0, "Survey Taken by:", $cf );
$ws->setMerge ( $row, 2, $row, 4 );
$ws->write ( $row, 2, $sur->engName, $cf );
$ws->setMerge ( $row, 5, $row, 6 );
$ws->write ( $row, 5, "Mobile phone no.:", $cf );
$ws->setMerge ( $row, 7, $row, 8 );
$ws->write ( $row, 7, $sur->contact, $cf );

$row = $row + 1;
$ws->setMerge ( $row, 0, $row, 1 );
$ws->write ( $row, 0, "Location:", $cf );
$ws->setMerge ( $row, 2, $row, 4 );
$ws->write ( $row, 2, $qt->location, $cf );
$ws->setMerge ( $row, 5, $row, 6 );
$ws->write ( $row, 5, "District:", $cf );
$ws->setMerge ( $row, 7, $row, 8 );
$ws->write ( $row, 7, $qt->location, $cf );

$row = $row + 1;
$ws->setMerge ( $row, 0, $row, 1 );
$ws->write ( $row, 0, "Date & Day :", $cf );
$ws->setMerge ( $row, 2, $row, 4 );
$ws->write ( $row, 2, $qt->surveyDate, $cf );
$ws->setMerge ( $row, 5, $row, 6 );
$ws->write ( $row, 5, "Weather :", $cf );
$ws->setMerge ( $row, 7, $row, 8 );
$ws->write ( $row, 7, $qt->weather, $cf );
$row = $row + 1;

$row = $row + 1;
$ws->write ( $row, 0, "Remark:", $cbf );
$ws->setMerge ( $row, 1, $row, 8 );
$ws->write ( $row, 1, "* Taxi fare which excludes (不包括) tips ,the radio surcharge ,tunnel fee, tunnel surcharge and luggage surcharge.", $cf );
$row = $row + 1;
$ws->setMerge ( $row, 1, $row, 8 );
$ws->write ( $row, 1, "# Taxi Type: U – Urban taxi (市區的士), NT –- NT taxi (新界的士), L – Lantau Taxi (大嶼山的士)", $cf );
$row = $row + 1;

$row = $row + 1;
$ws->write ( $row, 0, "Time", $ctf );
$ws->write ( $row, 1, "Taxi Fare", $ctf );
$ws->write ( $row, 2, "Tips \r\n (if any)", $ctf );
$ws->write ( $row, 3, "No. of chargeable luggage \r\n (if any)", $ctf );
$ws->write ( $row, 4, "Radio-callsurcharge \r\n (Y or N)", $ctf );
$ws->write ( $row, 5, "Tunnel fee \r\n (if any)", $ctf );
$ws->write ( $row, 6, "Tunnel surcharge", $ctf );
$ws->write ( $row, 7, "Taxi Type# \r\n (U/NT/L)", $ctf );
$ws->write ( $row, 8, "Refuse the intercept interview \r\n (Y/N)", $ctrf );

$qtd = new QuestionairnTaxiDetail ();
$qtd->qutaId = $qt->qutaId;
$qtda = new QuestionairnTaxiDetailAccess ();
$rs = $qtda->GetListSearch ( $qtd );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$qtd = $rs [$i];
	$row = $row + 1;
	$ws->write ( $row, 0, $qtd->surveyTime, $cf );
	$ws->write ( $row, 1, $qtd->taxiFare, $cf );
	$ws->write ( $row, 2, $qtd->tips, $cf );
	$ws->write ( $row, 3, $qtd->chargeableLuggage, $cf );
	$ws->write ( $row, 4, $qtd->radioCallSurcharge, $cf );
	$ws->write ( $row, 5, $qtd->tunnelFee, $cf );
	$ws->write ( $row, 6, $qtd->tunnelSurcharge, $cf );
	$ws->write ( $row, 7, $qtd->taxiType, $cf );
	$ws->write ( $row, 8, $qtd->interceptInterview, $crf );
}

$row = $row + 1;
$ws->writeArea ( $row, 0, $row, 8, '', $ctf );

// Let's send the file
$wb->close ();
?>
<?php

print "salary excel file has aready been created.<br /> " . " click <a href='" . $_SERVER ["PHP_SELF"] . "'>here</a> to refresh this excel.<br />" . "right click <a href='" . $fileName . "'>here</a> save target as.";

?>
