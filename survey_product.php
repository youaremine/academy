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

// 调查表基本信息
$spl = new SurveyPartList ( $db );
$spl->supaId = $_GET ['supaId'];
$rs = $spl->GetListSearch ();
$rsNum = count ( $rs );
$templateUrl = "survey_product.html";
if ($rsNum > 0) {
	$sp = $rs [0];
	$weathers = getArray ( 'weather' );
	$weatherName = $weathers [$sp->weatherId];
	$dist = "HK"; // 市区
	if (strtoupper ( substr ( $sp->refNo, 0, 1 ) ) == "N") {
		$dist = "NT"; // 新界
	}
	
	$type = "big"; // 大巴
	$bl = new BusList ( $db );
	$bl->busId = $sp->busId;
	$rsBus = $bl->GetListSearch ();
	$rsBusNum = count ( $rsBus );
	if ($rsBusNum > 0) {
		$bus = $rsBus [0];
		$sofsDate = $bus->sofsDate;
		if (! empty ( $sofsDate )) {
			$sofsDate = date ( $conf ['date'] ['format'], strtotime ( $sofsDate ) );
		}
		if ($bus->typeId == "1" || $bus->typeId == "3" || $bus->typeId == "5")
			$type = "mini"; // 小巴
		else if ($bus->typeId == "6" && $dist == "HK") // 只对HK，KLN起作用
			$type = "urs"; // 无牌照车
	}	
	// 判断要跳转到哪里
	$templateUrl = strtolower ( "survey_product_" . $type . "_" . $dist . ".html" );
	// 获取td file no.
	$m = new MainSchedule();
	$m->jobNoNew = $sp->refNo;
	$ma = new MainScheduleAccess($db);
	$m = $ma->GetSingle($m);
	$tdRefNo = $m->tdFileNo;
}
// echo $templateUrl;
$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", $templateUrl );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "RowCount", "RowsCount" );
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "BusRow", "BusRows" );

// 调查表基本信息
$sp->routeNo = empty ( $sp->routeNo2 ) ? $sp->routeNo : $sp->routeNo . "&" . $sp->routeNo2;
$t->set_var ( array (
		"listStyle" => $listStyle,
		"tdRefNo" => $tdRefNo,
		"refNo" => $sp->refNo,
		"weatherName" => $weatherName,
		"sofsDate" => $sofsDate,
		"routeNo" => $sp->routeNo,
		"surDate" => $sp->surDate,
		"surFromTime" => ToShortTime ( $sp->surFromTime ),
		"surToTime" => ToShortTime ( $sp->surToTime ),
		"location" => $sp->location,
		"bounds" => $sp->bounds,
		"userName" => $sp->userName 
) );

// 生成调查结果所需要的数据
include_once ('survey_product_data.php');

// 设置一些标识
$t->set_var ( array (
		"SubjectName" => $subjectName,
		"VehicleName" => $vehicleName 
) );

// 设置顶部表格内容 1b
$topTableRows = count ( $topTable ) - 1;
for($i = 0; $i < $topTableRows; $i ++) {
	$t->set_var ( array (
			"halfHourly" => $topTable [$i] ['halfHourly'],
			"arrivals" => $topTable [$i] ['arrivals'],
			"busTimeCount" => $topTable [$i] ['busTimeCount'],
			"diffNoCount" => $topTable [$i] ['diffNoCount'],
			"pslNoCount" => $topTable [$i] ['pslNoCount'],
			"departureTimeCount" => $topTable [$i] ['departureTimeCount'],
			"onArrivalCount" => $topTable [$i] ['onArrivalCount'],
			"onArrivalCountPercent" => $topTable [$i] ["onArrivalCountPercent"],
			"setDownCount" => $topTable [$i] ['setDownCount'],
			"pickupCount" => $topTable [$i] ['pickupCount'],
			"onDeptCount" => $topTable [$i] ['onDeptCount'],
			"onDeptCountPercent" => $topTable [$i] ["onDeptCountPercent"],
			"leftBehindMinCount" => $topTable [$i] ['leftBehindMinCount'],
			"leftBehindMaxCount" => $topTable [$i] ['leftBehindMaxCount'],
			"leftBehindCount" => $topTable [$i] ['leftBehindCount'],
			"headWayCount" => $topTable [$i] ['headWayCount'] 
	) );
	$t->parse ( "RowsCount", "RowCount", true );
}
// 顶部表格统计部分 1b
$t->set_var ( array (
		"arrivalsTotal" => $topTable ['total'] ['arrivals'],
		"busTimeCountTotal" => $topTable ['total'] ['busTimeCount'],
		"diffNoCountTotal" => $topTable ['total'] ['diffNoCount'],
		"pslNoCountTotal" => $topTable ['total'] ['pslNoCount'],
		"departureTimeCountTotal" => $topTable ['total'] ['departureTimeCount'],
		"onArrivalCountTotal" => $topTable ['total'] ['onArrivalCount'],
		"onArrivalCountTotalPercent" => $topTable ['total'] ["onArrivalCountTotalPercent"],
		"setDownCountTotal" => $topTable ['total'] ['setDownCount'],
		"pickupCountTotal" => $topTable ['total'] ['pickupCount'],
		"onDeptCountTotal" => $topTable ['total'] ['onDeptCount'],
		"onDeptCountTotalPercent" => $topTable ['total'] ["onDeptCountTotalPercent"],
		"leftBehindMinCountTotal" => $topTable ['total'] ['leftBehindMinCount'],
		"leftBehindMaxCountTotal" => $topTable ['total'] ['leftBehindMaxCount'],
		"leftBehindCountTotal" => $topTable ['total'] ['leftBehindCount'],
		"headWayCountTotal" => $topTable ['total'] ["headWayCountTotal"] 
) );

// 设置底部表格内容 1a
$fleetNoList = array ();
$lowTableRows = count ( $lowTable ) - 1;
for($i = 0; $i < $lowTableRows; $i ++) {
	$t->set_var ( array (
			"skippedStopFlag" => $lowTable [$i] ['skippedStop'] == 1 ? '*' : '',
			"fleetNo" => $lowTable [$i] ['fleetNo'],
			"pslNo" => $lowTable [$i] ['pslNo'],
			"arrivalTime" => $lowTable [$i] ['arrivalTime'],
			"busTime" => $lowTable [$i] ['busTime'],
			"departureTime" => $lowTable [$i] ['departureTime'],
			"diffNo" => $lowTable [$i] ['diffNo'] ? $lowTable [$i] ['diffNo'] : '--',
			"onArrival" => $lowTable [$i] ['onArrival'],
			"onArrivalPercent" => $lowTable [$i] ["onArrivalPercent"],
			"pickup" => $lowTable [$i] ['pickup'],
			"setDown" => $lowTable [$i] ['setDown'],
			"leftBehind" => $lowTable [$i] ['leftBehind'],
			"onDept" => $lowTable [$i] ['onDept'],
			"onDeptPercent" => $lowTable [$i] ["onDeptPercent"],
			"headWay" => $lowTable [$i] ['headWay'] ? $lowTable [$i] ['headWay'] : '--' 
	) );
	$t->parse ( "Rows", "Row", true );
	
	if ($lowTable [$i] ['fleetNo'] == "" || $lowTable [$i] ['fleetNo'] == "Missing")
		continue;
	$fleetNoList [] = $lowTable [$i] ['fleetNo'];
}

// 设置底部表格统计 1a
$skippedStopText = "";
if ($lowTable ['total'] ['skippedStopTotal'] > 0)
	$skippedStopText = "*skipped stop";

$t->set_var ( array (
		"recordTotal" => $lowTable ['total'] ['recordTotal'],
		"busTimeTotal" => $lowTable ['total'] ['busTimeTotal'],
		"diffTotal" => $lowTable ['total'] ['diffTotal'],
		"pslNoTotal" => $lowTable ['total'] ['pslNo'],
		"onArrivalTotal" => $lowTable ['total'] ['onArrivalTotal'],
		"onArrivalTotalPercent" => $lowTable ['total'] ["onArrivalTotalPercent"],
		"setDownTotal" => $lowTable ['total'] ['setDownTotal'],
		"pickupTotal" => $lowTable ['total'] ['pickupTotal'],
		"onDeptTotal" => $lowTable ['total'] ['onDeptTotal'],
		"onDeptTotalPercent" => $lowTable ['total'] ["onDeptTotalPercent"],
		"leftBehindMin" => $lowTable ['total'] ['leftBehindMin'],
		"leftBehindMax" => $lowTable ['total'] ['leftBehindMax'],
		"leftBehindTotal" => $lowTable ['total'] ['leftBehindTotal'],
		"skippedStopText" => $skippedStopText,
		// "headWayTotal"=>$lowTable['total']['headWayTotal']));
		"headWayTotal" => '--' 
) );

// 车牌列表部分
if (count ( $fleetNoList ) > 0) {
	$fleetNoList = UniqueArray ( $fleetNoList );
	sort ( $fleetNoList );
}
$fleetNoListRows = count ( $fleetNoList );
$m = 0;
$n = 0;
for($i = 0; $i < $fleetNoListRows; $i ++) {
	$t->set_var ( 'fleetNo[' . $m . ']', $fleetNoList [$i] );
	$m ++;
	if ($m % 14 == 0) {
		$t->parse ( "BusRows", "BusRow", true );
		$m = 0;
	}
}
// 车牌列表部分
if ($m != 0) {
	for($i = $m - 1; $i < 14; $i ++) {
		$t->set_var ( 'fleetNo[' . $i . ']', '' );
	}
	$t->parse ( "BusRows", "BusRow", true );
}

// 中间表格
$schFre = $topTable ['total'] ['busTimeCount'] == 0 ? 0 : ceil ( $surTimeDiff / $topTable ['total'] ['busTimeCount'] );
$obsFre = $topTable ['total'] ['departureTimeCount'] == 0 ? 0 : ceil ( $surTimeDiff / $topTable ['total'] ['departureTimeCount'] );
$t->set_var ( array (
		"schNo" => $busSchNo [0],
		"obsNo" => $fleetNoListRows,
		"soDiffNo" => $fleetNoListRows - $busSchNo [0],
		"schFre" => $schFre,
		"obsFre" => $obsFre,
		"osFreDiffNo" => $obsFre - $schFre 
) );

/*
 * print_r($topTable); print "<br /><br /><br /><br />"; print_r($lowTable);
 */
$t->pparse ( "Output", "HdIndex" );
?>