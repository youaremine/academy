<?php
/*
 * Header: Create: 2007-10-17 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "registration_view.html" );
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "TypeRow", "TypeRows" );
$t->set_block ( "HdIndex", "Row", "Rows" );

$t->set_var ( "Rows", "" );

// 车辆类型
$btl = new BusTypeList ( $db );
$rs = $btl->GetListAll ();
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	$bt = $rs [$i];
	$t->set_var ( array (
			"typeId" => $bt->butyId,
			"typeName" => $bt->engName 
	) );
	$t->parse ( "TypeRows", "TypeRow", true );
}

$t->set_var ( "selTypeId", $_GET ['butyId'] );

// 所有數據
$reg = new Registration ();
$reg->butyId = $_GET ['butyId'];
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
			"capacity" => $reg->capacity,
			"regiId" => $i  // $reg->regiId
		) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>