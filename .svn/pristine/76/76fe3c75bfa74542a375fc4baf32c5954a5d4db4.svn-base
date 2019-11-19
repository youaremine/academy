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

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "bus_entry.html" );
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "TypeRow", "TypeRows" );
$t->set_block ( "HdIndex", "DistRow", "DistRows" );
$t->set_block ( "HdIndex", "DistanceRow", "DistanceRows" );

// 车辆类型
$btl = new BusTypeList ( $db );
$rs = $btl->GetListAll ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$bt = $rs [$i];
	$t->set_var ( array (
			"typeId" => $bt->butyId,
			"typeName" => $bt->engName 
	) );
	$t->parse ( "TypeRows", "TypeRow", true );
}

// 车辆所属区域
$dl = new DistrictList ( $db );
$rs = $dl->GetListSearch ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$dist = $rs [$i];
	$t->set_var ( array (
			"distCode" => $dist->distCode,
			"distEngName" => $dist->engName 
	) );
	$t->parse ( "DistRows", "DistRow", true );
}

// 初始化距离行数
for($i=0;$i<50;$i++){
	$t->set_var("i",$i);
	$t->parse ( "DistanceRows", "DistanceRow", true );
}

$t->pparse ( "Output", "HdIndex" );
?>