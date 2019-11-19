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
$t->set_file ( "HdIndex", "product.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "BusRow", "BusRows" );

// 调查表基本信息
$spl = new SurveyPartList ( $db );
$spl->supaId = $_GET ['supaId'];
$rs = $spl->GetListSearch ();
$rsNum = count ( $rs );
if ($rsNum > 0) {
	$sp = $rs [0];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"refNo" => $sp->refNo,
			"routeNo" => $sp->routeNo,
			"surDate" => $sp->surDate,
			"surFromTime" => ToShortTime ( $sp->surFromTime ),
			"surToTime" => ToShortTime ( $sp->surToTime ),
			"location" => $sp->location,
			"bounds" => $sp->bounds,
			"userName" => $sp->userName 
	) );
}
// 巴士详细时间表
$btl = new BusTimeList ( $db );
$btl->busId = $sp->busId;
$btl->minBusTime = ToShortTime ( $sp->surFromTime );
$btl->maxBusTime = ToShortTime ( $sp->surToTime );
$rs = $btl->GetListSearch ();
$rsNo = count ( $rs );
$busTimeList = array ();
for($i = 0; $i < $rsNo; $i ++) {
	$bt = $rs [$i];
	$busTimeList [] = $bt->busTime;
}
// 定义所有Total信息
$recordTotal = 0;
$busTimeTotal = 0;
$diffTotal = 0;
$onArrivalTotal = 0;
$setDownTotal = 0;
$pickupTotal = 0;
$onDeptTotal = 0;
$leftBehindMin = 0;
$leftBehindMax = 0;
$leftBehindTotal = 0;
$headWayTotal = 0;

// 调查表详细信息
$sdl = new SurveyDetailList ( $db );
$sdl->supaId = $_GET ['supaId'];
$rs = $sdl->GetListSearch ();
$rsNum = count ( $rs );
$recordTotal = $rsNum;
$m = 1;
$k = 0;
$person = $conf ['bus'] ['mini'] ['person'];
for($i = 0; $i < $rsNum; $i ++) {
	$sd = $rs [$i];
	$busTime = '';
	$diffNo = 1;
	if ($i == $rsNum - 1) {
		$headWay = '--';
		$diffCurr = abs ( TimeDiff ( $busTimeList [$k], $sd->departureTime ) );
		if ($diffCurr == 0) {
			$busTime = $busTimeList [$k];
			$diffNo = '';
			$busTimeTotal = $busTimeTotal + 1;
		}
	} else {
		$headWay = TimeDiff ( $sd->departureTime, $rs [$i + 1]->departureTime );
		$headWayTotal += $headWay;
		$diffCurr = abs ( TimeDiff ( $busTimeList [$k], $sd->departureTime ) );
		$diffNext = abs ( TimeDiff ( $busTimeList [$k], $rs [$i + 1]->departureTime ) );
		if ($diffCurr < $diffNext) {
			$busTime = $busTimeList [$k];
			$diffNo = '';
			$busTimeTotal = $busTimeTotal + 1;
			$k ++;
		}
	}
	// 给所有头信息加上值
	$onArrivalTotal += $sd->onArrival;
	$setDownTotal += $sd->setDown;
	$pickupTotal += $sd->pickup;
	$onDeptTotal += $sd->onDept;
	$leftBehindTotal += $sd->leftBehind;
	if ($sd->leftBehind > 0) {
		if ($leftBehindMin == 0 || $leftBehindMin > $sd->leftBehind)
			$leftBehindMin = $sd->leftBehind;
		if ($leftBehindMax == 0 || $leftBehindMax < $sd->leftBehind)
			$leftBehindMax = $sd->leftBehind;
	}
	
	$t->set_var ( array (
			"fleetNo" => $sd->fleetNo,
			"pslNo" => $sd->pslNo,
			"arrivalTime" => ToShortTime ( $sd->arrivalTime ),
			"busTime" => ToShortTime ( $busTime ),
			"departureTime" => ToShortTime ( $sd->departureTime ),
			"diffNo" => $diffNo,
			"onArrival" => $sd->onArrival,
			"onArrivalPercent" => $sd->onArrival / $person * 100,
			"pickup" => $sd->pickup,
			"setDown" => $sd->setDown,
			"leftBehind" => $sd->leftBehind,
			"onDept" => $sd->onDept,
			"onDeptPercent" => $sd->onDept / $person * 100,
			"headWay" => $headWay 
	) );
	$t->parse ( "Rows", "Row", true );
	// 车牌列表部分
	$t->set_var ( 'fleetNo[' . $i . ']', $sd->fleetNo );
	$m ++;
	if ($m % 14 == 0) {
		$t->parse ( "BusRows", "BusRow", true );
		$m = 0;
	}
}
if ($m != 0) {
	for($i = $m - 1; $i < 14; $i ++) {
		$t->set_var ( 'fleetNo[' . $i . ']', '' );
	}
	$t->parse ( "BusRows", "BusRow", true );
}

// 设置所有Total信息
$diffTotal = $recordTotal - $busTimeTotal;
$t->set_var ( array (
		"recordTotal" => $recordTotal,
		"busTimeTotal" => $busTimeTotal,
		"diffTotal" => $diffTotal,
		"onArrivalTotal" => $onArrivalTotal,
		"setDownTotal" => $setDownTotal,
		"pickupTotal" => $pickupTotal,
		"onDeptTotal" => $onDeptTotal,
		"leftBehindMin" => $leftBehindMin,
		"leftBehindMax" => $leftBehindMax,
		"leftBehindTotal" => $leftBehindTotal,
		"headWayTotal" => $headWayTotal 
) );
$recordTotal = 0;
$busTimeTotal = 0;
$diffTotal = 0;
$onArrivalTotal = 0;
$setDownTotal = 0;
$pickupTotal = 0;
$onDeptTotal = 0;
$leftBehindMin = 0;
$leftBehindMax = 0;
$leftBehindTotal = 0;
$headWayTotal = 0;

$t->pparse ( "Output", "HdIndex" );
?>