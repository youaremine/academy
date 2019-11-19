<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// check this request is true
$busId = $_GET['busId'];
if($busId == ""){
	header("Location:bus_list.php");
	exit();
}

// 检查是否登录
if(! UserLogin::IsLogin()){
	header("Location:login.php");
	exit();
}

$t = new CacheTemplate("./templates");
$t->set_file("HdIndex","bus_update.html");
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching(false);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex","TypeRow","TypeRows");
$t->set_block("HdIndex","DistRow","DistRows");
$t->set_block("HdIndex","DistanceRow","DistanceRows");

if($_GET['busId'] == ""){
	header("Location:bus_list.php");
	exit();
}

$bl = new BusList($db);
$bl->busId = $busId;
$rs = $bl->GetListSearch();
$rsNum = count($rs);
if($rsNum > 0){
	$bus = $rs[0];
	$busDay = str_replace('all,','',$bus->busDay);
	$busDay = "'" . str_replace(',',"','",$busDay) . "'";
	$t->set_var(array (
			"busId" => $bus->busId,
			"routeNo" => $bus->routeNo,
			"bounds" => $bus->bounds,
			"sofsDate" => $bus->sofsDate,
			"allSchNo" => $bus->allSchNo,
			"amSchNo" => $bus->amSchNo,
			"pmSchNo" => $bus->pmSchNo,
			"totalJourneyTime" => $bus->totalJourneyTime,
			"totalJourneyDistance" => $bus->totalJourneyDistance,
			"busDay" => $busDay,
			"busTypeId" => $bus->typeId,
			"busDistCode" => $bus->distCode 
	));
	// 车辆类型
	$btl = new BusTypeList($db);
	$rs = $btl->GetListAll();
	$rsNum = count($rs);
	for($i = 0;$i < $rsNum;$i ++){
		$bt = $rs[$i];
		$t->set_var(array (
				"typeId" => $bt->butyId,
				"typeName" => $bt->engName 
		));
		$t->parse("TypeRows","TypeRow",true);
	}
	
	// 车辆所属区域
	$dl = new DistrictList($db);
	$rs = $dl->GetListSearch();
	$rsNum = count($rs);
	for($i = 0;$i < $rsNum;$i ++){
		$dist = $rs[$i];
		$t->set_var(array (
				"distCode" => $dist->distCode,
				"distEngName" => $dist->engName 
		));
		$t->parse("DistRows","DistRow",true);
	}
	// 巴士详细时间表
	$btl = new BusTimeList($db);
	$btl->busId = $busId;
	$rs = $btl->GetListSearch();
	$rsNo = count($rs);
	$busTimeList = '';
	for($i = 0;$i < $rsNo;$i ++){
		$bt = $rs[$i];
		if($i == ($rsNo - 1))
			$busTimeList .= ToShortTime($bt->busTime);
		else
			$busTimeList .= ToShortTime($bt->busTime) . "\r\n";
	}
	$t->set_var('busList',$busTimeList);
	// 巴士详细距离表
	$bd = new BusDistance();
	$bd->busId = $busId;
	$bda = new BusDistanceAccess($db);
	$rs = $bda->GetListSearch($bd);
	$rsNo = count($rs);
	$distanceList = '';
	$i=0;
	for($i;$i < $rsNo;$i ++){
		$bd = $rs[$i];
		$t->set_var(array(
				"i"=>$i,
				"stopNo"=>$bd->stopNo,
				"stopDescription"=>$bd->stopDescription,
				"distance"=>$bd->distance
		));
		$t->parse ( "DistanceRows", "DistanceRow", true );
	}
	// 初始化距离行数
	for($i;$i<50;$i++){
		$t->set_var(array(
				"i"=>$i,
				"stopNo"=>"",
				"stopDescription"=>"",
				"distance"=>""
		));
		$t->parse ( "DistanceRows", "DistanceRow", true );
	}
	$t->set_var('distanceList',$distanceList);
}

$t->pparse("Output","HdIndex");
?>