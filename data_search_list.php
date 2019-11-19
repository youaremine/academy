<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
if ($_GET ['fleetNo'] == "") {
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "data_search_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "RowReg", "RowRegs" );
$t->set_block ( "HdIndex", "RowAcross", "RowAcrosss" );
$t->set_var ( "Rows", "" );
$t->set_var ( "RowRegs", "" );
$t->set_var ( "RowAcrosss", "" );

// 歷史記錄
$sdl = new SurveyDetailList ( $db );
$sdl->fleetNo = $_GET ['fleetNo'];
$sdl->limit = 10;
$rs = $sdl->GetCacpcityHistory ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	
	$sd = $rs [$i];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"fleetNo" => $sd->fleetNo,
			"pslNo" => $sd->pslNo 
	) );
	$t->parse ( "Rows", "Row", true );
}

// 運輸署
$reg = new Registration ();
$reg->plateNo = $_GET ['fleetNo'];
$reg->fleetNo = $_GET ['fleetNo'];
$rega = new RegistrationAccess ( $db );
$rs = $rega->GetListSearch ( $reg );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	
	$reg = $rs [$i];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"plateNo" => $reg->plateNo,
			"fleetNo" => $reg->fleetNo,
			"capacity" => $reg->capacity 
	) );
	$t->parse ( "RowRegs", "RowReg", true );
}

// ACROSS 網站數據
$ac = new Across ();
$ac->plateNo = $_GET ["fleetNo"];
$ac->fleetNo = $_GET ["fleetNo"];
$aca = new AcrossAccess ( $db );
$rs = $aca->GetListSearch ( $ac );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	
	$ac = $rs [$i];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"company" => $ac->company,
			"plateNo" => $ac->plateNo,
			"fleetNo" => $ac->fleetNo,
			"capacity" => $ac->capacity,
			"sch" => $ac->sch 
	) );
	$t->parse ( "RowAcrosss", "RowAcross", true );
}

$t->pparse ( "Output", "HdIndex" );
?>