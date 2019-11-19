<?php
/*
 * Header: Create: 2007-1-28 Auther: Jamblues.
 */

/*
 * 取最新的值
 */
function GetNearValue($val, $arr, $index) {
	$arrNo = count ( $arr );
	if ($index > 0) {
		$index = $index - 1;
	}
	for($i = $index; $i < $arrNo; $i ++) {
		if ($i < 1) {
			if (abs ( TimeDiff ( $val, $arr [$i] ) ) < abs ( TimeDiff ( $val, $arr [$i + 1] ) )) {
				return $i;
			}
		} else if ($i > ($arrNo - 2)) {
			if (abs ( TimeDiff ( $val, $arr [$i] ) ) < abs ( TimeDiff ( $val, $arr [$i - 1] ) )) {
				return $i;
			}
		} else {
			if ((abs ( TimeDiff ( $val, $arr [$i] ) ) < abs ( TimeDiff ( $val, $arr [$i - 1] ) )) && (abs ( TimeDiff ( $val, $arr [$i] ) ) < abs ( TimeDiff ( $val, $arr [$i + 1] ) ))) {
				return $i;
			}
		}
	}
	return $index;
}

/**
 * 插入值
 */
function InsertValue($sd, $busTime, &$labIndex, &$lowTable) {
	if ($busTime == "") {
		$lowTable [$labIndex] ['busTime'] = "";
	} else {
		$lowTable [$labIndex] ['busTime'] = ToShortTime ( $busTime );
	}
	if ($sd->arrivalTime == "") {
		$lowTable [$labIndex] ['arrivalTime'] = "Missing";
	} else {
		$lowTable [$labIndex] ['arrivalTime'] = ToShortTime ( $sd->arrivalTime );
	}
	$labIndex ++;
}

// 调查表基本信�?
$spl = new SurveyPartList ( $db );
$spl->supaId = $_GET ['supaId'];
$rs = $spl->GetListSearch ();
$rsNum = count ( $rs );
$surTimeDiff = 0;
$busSchNo = array ();
if ($rsNum > 0) {
	$sp = $rs [0];
	$surTimeDiff = TimeDiff ( ToShortTime ( $sp->surFromTime ), ToShortTime ( $sp->surToTime ) );
	$busSchNo [] = $sp->schNo;
}
// 巴士基本信息
$bul = new BusList ( $db );
$bul->busId = $sp->busId;
$rs = $bul->GetListSearch ();
$rsNo = count ( $rs );
$person = $conf ['bus'] ['mini'] ['person'];
$currBusType = "1";
$titleName = "PSL No.";
$subjectName = "Monitoring Survey of Minibus Service";
$vehicleName = "GMBs";

for($i = 0; $i < $rsNo; $i ++) {
	$bus = $rs [$i];
	// $busSchNo[] = $bus->schNo;
	if ($bus->typeId == "2") {
		$currBusType = $bus->typeId;
		$titleName = "Capability.";
		$subjectName = "Monitoring Survey of Bus Service";
		$vehicleName = "Buses";
	}
}
// 巴士详细时间�?
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

// 调查表详细信�?
$sdl = new SurveyDetailList ( $db );
$sdl->supaId = $_GET ['supaId'];
$rs = $sdl->GetListSearch ();
$rsNum = count ( $rs );
$busTimePart = ToTimePart ( $rs [0]->arrivalTime, $rs [$rsNum - 1]->arrivalTime );
$arrivalTimeList = array ();
for($i = 0; $i < $rsNum; $i ++) {
	$sd = $rs [$i];
	$arrivalTimeList [] = $sd->arrivalTime;
}
$n = 0;
$m = 1;
$k = 0;
$j = 0;

$topTable [$j] ['leftBehindCount'] = 0;
$topTable [$j] ['leftBehindMinCount'] = 0;
$topTable [$j] ['leftBehindMaxCount'] = 0;
$topTable ['total'] ['leftBehindCount'] = 0;
$lowTable ['total'] ['leftBehindTotal'] = 0;
$lowTable ['total'] ['leftBehindMin'] = 0;
$lowTable ['total'] ['leftBehindMax'] = 0;

for($i = 0; $i < $rsNum; $i ++) {
	$sd = $rs [$i];
	// 顶部表格
	if (TimeDiff ( $busTimePart [$j + 1], $rs [$i]->arrivalTime ) > 0) {
		$j ++;
		$topTable [$j] ['leftBehindCount'] = 0;
		$topTable [$j] ['leftBehindMinCount'] = 0;
		$topTable [$j] ['leftBehindMaxCount'] = 0;
		$topTable [$j] ['pslNoCount'] = 0;
	}
	// 判断是否为大�?
	if ($currBusType == "2") {
		$person = $sd->pslNo;
	} else {
		$person = $conf ['bus'] ['mini'] ['person'];
	}
	
	$topTable [$j] ['halfHourly'] = $busTimePart [$j];
	$topTable [$j] ['pslNoCount'] += $sd->pslNo;
	$topTable [$j] ['arrivals'] += 1;
	$topTable [$j] ['departureTimeCount'] += 1;
	$topTable [$j] ['onArrivalCount'] += $sd->onArrival;
	$topTable [$j] ['setDownCount'] += $sd->setDown;
	$topTable [$j] ['pickupCount'] += $sd->pickup;
	$topTable [$j] ['onDeptCount'] += $sd->onDept;
	if ($sd->leftBehind > 0)
		$topTable [$j] ['leftBehindCount'] += 1;
	$topTable [$j] ["onArrivalCountPercent"] = $topTable [$j] ['pslNoCount'] == 0 ? '0.00' : sprintf ( "%01.2f", $topTable [$j] ['onArrivalCount'] / $topTable [$j] ['pslNoCount'] * 100 );
	$topTable [$j] ["onDeptCountPercent"] = $topTable [$j] ['pslNoCount'] == 0 ? '0.00' : sprintf ( "%01.2f", $topTable [$j] ['onDeptCount'] / $topTable [$j] ['pslNoCount'] * 100 );
	
	// 底部表格
	if ($i == count ( $busTimeList ) - 1) {
		$lowTable [$n] ['headWay'] = 0;
		$diffCurr = abs ( TimeDiff ( $busTimeList [$k], $sd->departureTime ) );
		if ($diffCurr == 0) {
			$lowTable [$n] ['busTime'] = ToShortTime ( $busTimeList [$k] );
			$lowTable [$n] ['diffNo'] = 0;
			$lowTable ['total'] ['busTimeTotal'] = $lowTable ['total'] ['busTimeTotal'] + 1;
			$topTable [$j] ['busTimeCount'] += 1;
		} else {
			$lowTable [$n] ['diffNo'] = 1;
			$topTable [$j] ['diffNoCount'] += 1;
			$topTable ['total'] ['diffNoCount'] += 1;
		}
	} else {
		if ($i < $rsNum) {
			$lowTable [$n] ['headWay'] = TimeDiff ( $sd->departureTime, $rs [$i + 1]->departureTime );
		}
		$lowTable ['total'] ['headWayTotal'] += $lowTable [$n] ['headWay'];
		$topTable [$j] ['headWayCount'] += $lowTable [$n] ['headWay'];
		$diffCurr = abs ( TimeDiff ( $busTimeList [$k], $sd->departureTime ) );
		$diffNext = abs ( TimeDiff ( $busTimeList [$k], $rs [$i + 1]->departureTime ) );
		if ($diffCurr <= $diffNext) {
			$diffCurrDepa = abs ( TimeDiff ( $busTimeList [$k], $sd->arrivalTime ) );
			$diffNextDepa = abs ( TimeDiff ( $busTimeList [$k + 1], $sd->arrivalTime ) );
			if ($diffCurrDepa <= $diffNextDepa) {
				$lowTable [$n] ['busTime'] = ToShortTime ( $busTimeList [$k] );
				$lowTable [$n] ['arrivalTime'] = ToShortTime ( $sd->arrivalTime );
				$k ++;
			} else {
				$lowTable [$n] ['busTime'] = ToShortTime ( $busTimeList [$k] );
				$lowTable [$n] ['fleetNo'] = "Missing";
				$lowTable [$n] ['diffNo'] = - 1;
				$lowTable ['total'] ['busTimeTotal'] = $lowTable ['total'] ['busTimeTotal'] + 1;
				$lowTable ['total'] ['diffTotal'] += $lowTable [$n] ['diffNo'];
				$topTable [$j] ['busTimeCount'] += 1;
				$n ++;
				$k ++;
				
				$lowTable [$n] ['busTime'] = ToShortTime ( $busTimeList [$k] );
				$lowTable [$n] ['arrivalTime'] = ToShortTime ( $sd->arrivalTime );
				$k ++;
			}
			$lowTable [$n] ['diffNo'] = 0;
			$lowTable ['total'] ['busTimeTotal'] = $lowTable ['total'] ['busTimeTotal'] + 1;
			$topTable [$j] ['busTimeCount'] += 1;
		} else {
			$lowTable [$n] ['busTime'] = "";
			$lowTable [$n] ['arrivalTime'] = ToShortTime ( $sd->arrivalTime );
			$lowTable [$n] ['diffNo'] = 1;
		}
	}
	
	if ($sd->leftBehind > 0) {
		if ($lowTable ['total'] ['leftBehindMin'] > $sd->leftBehind || $lowTable ['total'] ['leftBehindMin'] == 0)
			$lowTable ['total'] ['leftBehindMin'] = $sd->leftBehind;
		if ($lowTable ['total'] ['leftBehindMax'] < $sd->leftBehind)
			$lowTable ['total'] ['leftBehindMax'] = $sd->leftBehind;
		if ($topTable [$j] ['leftBehindMinCount'] > $sd->leftBehind || $topTable [$j] ['leftBehindMinCount'] == 0)
			$topTable [$j] ['leftBehindMinCount'] = $sd->leftBehind;
		if ($topTable [$j] ['leftBehindMaxCount'] < $sd->leftBehind)
			$topTable [$j] ['leftBehindMaxCount'] = $sd->leftBehind;
	}
	$lowTable [$n] ['fleetNo'] = $sd->fleetNo;
	$lowTable [$n] ['pslNo'] = $sd->pslNo;
	$lowTable [$n] ['arrivalTime'] = ToShortTime ( $sd->arrivalTime );
	$lowTable [$n] ['departureTime'] = ToShortTime ( $sd->departureTime );
	$lowTable [$n] ['onArrival'] = $sd->onArrival;
	$lowTable [$n] ['pickup'] = $sd->pickup;
	$lowTable [$n] ['setDown'] = $sd->setDown;
	// $lowTable[$n]['leftBehind'] = $sd->leftBehind==0?$sd->onArrival:$sd->leftBehind;
	$lowTable [$n] ['leftBehind'] = $sd->leftBehind;
	$lowTable [$n] ['onDept'] = $sd->onDept;
	$lowTable [$n] ['onArrivalPercent'] = $person == 0 ? '0.00' : sprintf ( "%01.2f", $lowTable [$n] ['onArrival'] / $person * 100 );
	$lowTable [$n] ["onDeptPercent"] = $person == 0 ? '0.00' : sprintf ( "%01.2f", $lowTable [$n] ['onDept'] / $person * 100 );
	
	$lowTable ['total'] ['recordTotal'] = $rsNum;
	$lowTable ['total'] ['diffTotal'] += $lowTable [$n] ['diffNo'];
	$lowTable ['total'] ['pslNo'] += $person;
	$lowTable ['total'] ['onArrivalTotal'] += $sd->onArrival;
	$lowTable ['total'] ['setDownTotal'] += $sd->setDown;
	$lowTable ['total'] ['pickupTotal'] += $sd->pickup;
	$lowTable ['total'] ['onDeptTotal'] += $sd->onDept;
	if ($sd->leftBehind > 0)
		$lowTable ['total'] ['leftBehindTotal'] += 1;
	$lowTable ['total'] ["onArrivalTotalPercent"] = $lowTable ['total'] ['pslNo'] == 0 ? '0.00' : sprintf ( "%01.2f", $lowTable ['total'] ['onArrivalTotal'] / $lowTable ['total'] ['pslNo'] * 100 );
	$lowTable ['total'] ["onDeptTotalPercent"] = $lowTable ['total'] ['pslNo'] == 0 ? '0.00' : sprintf ( "%01.2f", $lowTable ['total'] ['onDeptTotal'] / $lowTable ['total'] ['pslNo'] * 100 );
	
	$topTable ['total'] ['pslNoCount'] = $lowTable ['total'] ['pslNo'];
	$topTable ['total'] ['busTimeCount'] = $lowTable ['total'] ['busTimeTotal'];
	$topTable ['total'] ['leftBehindMinCount'] = $lowTable ['total'] ['leftBehindMin'];
	$topTable ['total'] ['leftBehindMaxCount'] = $lowTable ['total'] ['leftBehindMax'];
	$topTable ['total'] ['leftBehindCount'] = $lowTable ['total'] ['leftBehindTotal'];
	$topTable ['total'] ['headWayCount'] = $lowTable ['total'] ['headWayTotal'];
	$topTable ['total'] ['arrivals'] = $lowTable ['total'] ['recordTotal'];
	$topTable ['total'] ['departureTimeCount'] = $lowTable ['total'] ['recordTotal'];
	$topTable ['total'] ['onArrivalCount'] = $lowTable ['total'] ['onArrivalTotal'];
	$topTable ['total'] ['setDownCount'] = $lowTable ['total'] ['setDownTotal'];
	$topTable ['total'] ['pickupCount'] = $lowTable ['total'] ['pickupTotal'];
	$topTable ['total'] ['onDeptCount'] = $lowTable ['total'] ['onDeptTotal'];
	$topTable ['total'] ['leftBehindCount'] = $lowTable ['total'] ['leftBehindTotal'];
	$topTable ['total'] ["onArrivalCountTotalPercent"] = $lowTable ['total'] ["onArrivalTotalPercent"];
	$topTable ['total'] ["onDeptCountTotalPercent"] = $lowTable ['total'] ["onDeptTotalPercent"];
	$topTable ['total'] ["headWayCount"] = $lowTable ['total'] ['headWayTotal'];
	
	$n ++;
}
for($i = $k; $i < count ( $busTimeList ); $i ++) {
	$lowTable [$n] ['busTime'] = ToShortTime ( $busTimeList [$i] );
	$lowTable [$n] ['fleetNo'] = "Missing";
	$n ++;
}

// 如果bus时间表不够，则用空补齐�?
$busTimePartNum = count ( $busTimePart );
for($m = $j; $m < $busTimePartNum; $m ++) {
	if (TimeDiff ( $busTimePart [$m], ToShortTime ( $sp->surToTime ) ) > 0) {
		$m ++;
		$topTable [$m] ['halfHourly'] = $busTimePart [$m];
		$topTable [$m] ['arrivals'] = 0;
		$topTable [$m] ['busTimeCount'] = 0;
		$topTable [$m] ['departureTimeCount'] = 0;
		$topTable [$m] ['diffNoCount'] = 0;
		$topTable [$m] ['pslNoCount'] = 0;
		$topTable [$m] ['onArrivalCount'] = 0;
		$topTable [$m] ['setDownCount'] = 0;
		$topTable [$m] ['pickupCount'] = 0;
		$topTable [$m] ['onDeptCount'] = 0;
		$topTable [$m] ['leftBehindMinCount'] = 0;
		$topTable [$m] ['leftBehindMaxCount'] = 0;
		$topTable [$m] ['leftBehindCount'] = 0;
		$topTable [$m] ["onArrivalCountPercent"] = '0.00';
		$topTable [$m] ["onDeptCountPercent"] = '0.00';
	} else {
		break;
	}
}
?>
