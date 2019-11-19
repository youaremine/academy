<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// check this request is true
$busId = $_GET ['busId'];
if ($busId == "") {
	header ( "Location:bus_list.php" );
	exit ();
}

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "bus_view.html" );
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

if ($_GET ['busId'] == "") {
	header ( "Location:bus_list.php" );
	exit ();
}

$bl = new BusList ( $db );
$bl->busId = $busId;
$rs = $bl->GetListSearch ();
$rsNum = count ( $rs );
if ($rsNum > 0) {
	$bus = $rs [0];
	$busDay = str_replace ( 'all,', '', $bus->busDay );
	$busDay = "'" . str_replace ( ',', "','", $busDay ) . "'";
	$t->set_var ( array (
			"busId" => $bus->busId,
			"routeNo" => $bus->routeNo,
			"bounds" => $bus->bounds,
			"sofsDate" => $bus->sofsDate,
			"allSchNo" => $bus->allSchNo,
			"amSchNo" => $bus->amSchNo,
			"pmSchNo" => $bus->pmSchNo,
			"busDay" => $busDay,
			"distCode" => $bus->distCode 
	) );
	// 车辆类型
	$btl = new BusTypeList ( $db );
	$btl->butyId = $bus->typeId;
	$rs = $btl->GetListSearch ();
	$rsNum = count ( $rs );
	if ($rsNum > 0) {
		$bt = $rs [0];
		$t->set_var ( "typeName", $bt->engName );
	}
	// 巴士详细时间表
	$btl = new BusTimeList ( $db );
	$btl->busId = $busId;
	$rs = $btl->GetListSearch ();
	$rsNo = count ( $rs );
	$busTimeList = '';
	for($i = 0; $i < $rsNo; $i ++) {
		$bt = $rs [$i];
		$busTimeList .= ToShortTime ( $bt->busTime ) . "\r\n";
	}
	$t->set_var ( 'busList', $busTimeList );
}

$t->pparse ( "Output", "HdIndex" );
?>