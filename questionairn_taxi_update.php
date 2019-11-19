<?php
/*
 * Header: Create: 2007-02-25 Auther: Jamblues. M S N: jamblues@gmail.com
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "questionairn_taxi_update.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "EntryRow", "EntryRows" );
$t->set_var ( "EntryRows", "" );

$qt = new QuestionairnTaxi ();
if (! empty ( $_GET ['qutaId'] )) {
	$qt->qutaId = $_GET ['qutaId'];
	$t->set_var ( "qutaId", $qt->qutaId );
} else {
	exit ();
}
$qta = new QuestionairnTaxiAccess ( $db );
$rs = $qta->GetListSearch ( $qt );
$rsNum = count ( $rs );
if ($rsNum > 0) {
	$qt = $rs [0];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"location" => $qt->location,
			"radioDistrictU" => "",
			"radioDistrictNT" => "",
			"radioDistrictL" => "",
			"radioDistrict" . $qt->district => "checked",
			"weather" => $qt->weather,
			"surveyDate" => $qt->surveyDate,
			"survId" => $qt->survId 
	) );
	// surveyor part
	$sur = new Surveyor ();
	$sur->survId = $qt->survId;
	if ($sur->survId > 0) {
		$sa = new SurveyorAccess ( $db );
		$rs = $sa->GetListSearch ( $sur );
		$sur = $rs [0];
	}
	$t->set_var ( array (
			"surveyorEngName" => $sur->engName,
			"surveyorContanct" => $sur->contact,
			"surveyorHome" => $sur->survHome 
	) );
} else {
	exit ();
}

$qtd = new QuestionairnTaxiDetail ();
$qtd->qutaId = $qt->qutaId;
$qtda = new QuestionairnTaxiDetailAccess ( $db );
$rs = $qtda->GetListSearch ( $qtd );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$qtd = $rs [$i];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"i" => $i,
			"qutdId" => $qtd->qutdId,
			"surveyTime" => $qtd->surveyTime,
			"surveyTime" => $qtd->surveyTime,
			"taxiFare" => $qtd->taxiFare,
			"tips" => $qtd->tips,
			"chargeableLuggage" => $qtd->chargeableLuggage,
			"radioCallSurcharge" => $qtd->radioCallSurcharge == "yes" ? "checked" : "",
			"tunnelFee" => $qtd->tunnelFee,
			"tunnelSurcharge" => $qtd->tunnelSurcharge,
			"taxiTypeU" => "",
			"taxiTypeNT" => "",
			"taxiTypeL" => "",
			"taxiType" . $qtd->taxiType => "selected",
			"interceptInterview" => $qtd->interceptInterview == "yes" ? "checked" : "" 
	) );
	$t->parse ( "EntryRows", "EntryRow", true );
}
$t->set_var ( "allRowNo", $rsNum - 1 );
$t->pparse ( "Output", "HdIndex" );
?>