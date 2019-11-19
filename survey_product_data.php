<?php
/*
 * Header: $lowTable指详细表 , $topTable指每半小时统计表
 * Create: 2007-1-28 
 * Auther: Jamblues.
 */

/**
 * 初始化 topTable
 */
function InitNullValue(&$topTable, &$busTimePart, $busTimePartNum)
{
	for($m = 0; $m < $busTimePartNum; $m++)
	{
		$topTable[$m]['halfHourly'] = $busTimePart[$m];
		$topTable[$m]['arrivals'] = 0;
		$topTable[$m]['busTimeCount'] = 0;
		$topTable[$m]['departureTimeCount'] = 0;
		$topTable[$m]['pslNoCount'] = 0;
		$topTable[$m]['onArrivalCount'] = 0;
		$topTable[$m]['setDownCount'] = 0;
		$topTable[$m]['pickupCount'] = 0;
		$topTable[$m]['onDeptCount'] = 0;
		$topTable[$m]['leftBehindMinCount'] = 0;
		$topTable[$m]['leftBehindMaxCount'] = 0;
		$topTable[$m]['leftBehindCount'] = 0;
		$topTable[$m]["onArrivalCountPercent"] = '0.00';
		$topTable[$m]["onDeptCountPercent"] = '0.00';
	}
}

/**
 * 插入
 */
function InsertValue($sd, $busTime, $busTimeKey, &$labIndex, &$lowTable, $sdLast)
{
	global $conf, $currBusType, $jobNoNew;
	$lowTable[$labIndex]['displayBoard'] = $sd->displayBoard;
	$lowTable[$labIndex]['skippedStop'] = $sd->skippedStop;
	$lowTable[$labIndex]['fleetNo'] = $sd->fleetNo;
	$lowTable[$labIndex]['pslNo'] = $sd->pslNo;
	$arrivalTime = ToShortTime($sd->arrivalTime);
	$lowTable[$labIndex]['arrivalTime'] = $arrivalTime;
	
	$departureTime = ToShortTime($sd->departureTime);
	$lowTable[$labIndex]['departureTime'] = $departureTime;
	
	$lowTable[$labIndex]['onArrival'] = $sd->onArrival;
	$lowTable[$labIndex]['pickup'] = $sd->pickup;
	$lowTable[$labIndex]['setDown'] = $sd->setDown;
	$lowTable[$labIndex]['leftBehind'] = (int) $sd->leftBehind;
	$lowTable[$labIndex]['onDept'] = $sd->onDept;
	$lowTable[$labIndex]['leftRoleFlag'] = $sd->leftRoleFlag;
	$lowTable[$labIndex]['diffNo'] = 0;
	
	if ($busTime == "")
	{
		$lowTable[$labIndex]['busTime'] = "";
		$lowTable[$labIndex]['diffNo'] = 1;
	}
	else
	{
		$busTime = ToShortTime($busTime);
		$lowTable[$labIndex]['busTime'] = $busTime;
		$lowTable[$labIndex]['busTimeKey'] = $busTimeKey;
	}
	
	if ($sd->departureTime == "")
	{
		$lowTable[$labIndex]['fleetNo'] = "";
		$lowTable[$labIndex]['diffNo'] = -1;
	}
	else if ($sdLast->departureTime == "")
	{
		// TODO
	}
	else
	{
		$lowTable[$labIndex]['headWay'] = TimeDiff($sdLast->departureTime,$sd->departureTime);
	}
	
	// 应用了这一个规则才会生效
	if ($currBusType == "big")
	{
		
		$lowTable[$labIndex]['person'] = $sd->pslNo;
		// 如果如果架車開出時,車上還有容量的15%以上空位的話就算有left behind, 都當是 "0" request by molly 20140415
		if ($lowTable[$labIndex]['onDept'] < $lowTable[$labIndex]['person'] * 0.85 && $lowTable[$labIndex]['leftRoleFlag'] == 'yes')
		{
			$lowTable[$labIndex]['leftBehind'] = 0;
		}
	}
	else if ($currBusType == "mini")
	{
		$lowTable[$labIndex]['person'] = $conf['bus']['mini']['person'];
		// 如果如果架車開出時,車上還有空位的話就算有left behind, 都當是 "0"
		if ($lowTable[$labIndex]['onDept'] < $lowTable[$labIndex]['person'] && $lowTable[$labIndex]['leftRoleFlag'] == 'yes')
		{
			$lowTable[$labIndex]['leftBehind'] = 0;
		}
	}
	else
	{
		$lowTable[$labIndex]['person'] = $sd->pslNo;
	}
	// H項目顯示真實時間,其它項目保留規則 request by molly 20141030
	if (substr($jobNoNew, 0, 1) != "H")
	{
		if ($lowTable[$labIndex]['headWay'] > 35) // 如果超過35分鐘,那麼為沒有人等 request by molly 20140415
			$lowTable[$labIndex]['headWay'] = 0;
		else if ($lowTable[$labIndex]['headWay'] > 30) // 如果超過30分鐘,沒超過35分鐘,那麼變成30分鐘;request by molly 20140415
			$lowTable[$labIndex]['headWay'] = 30;
	}
	$lowTable[$labIndex]['onArrivalPercent'] = $lowTable[$labIndex]['person'] == 0 ? 0 : round($lowTable[$labIndex]['onArrival'] / $lowTable[$labIndex]['person'] * 100, $conf['decimal']['precision']);
	$lowTable[$labIndex]["onDeptPercent"] = $lowTable[$labIndex]['person'] == 0 ? 0 : round($lowTable[$labIndex]['onDept'] / $lowTable[$labIndex]['person'] * 100, $conf['decimal']['precision']);
	$labIndex++;
}

/**
 * 得到ID.
 */
function GetNearTime($val, $arr, $index)
{
	$returnIndex = $index;
	$arrNo = count($arr);
	if (TimeDiff($val, $arr[$arrNo - 1]) == 0)
	{
		$returnIndex = $arrNo - 1;
	}
	else
	{
		for($i = $index; $i < $arrNo; $i++)
		{
			if (TimeDiff($val, $arr[$i]) > 0)
			{
				if ($i > 0)
				{
					$returnIndex = $i - 1;
				}
				else
				{
					$returnIndex = $i;
				}
				break;
			}
		}
	}
	// print $val." - ".$arr[$returnIndex]." - ".$returnIndex."<br />";
	return $returnIndex;
}

// 调查表基本信息
$spl = new SurveyPartList($db);
$spl->supaId = $_GET['supaId'];
$rs = $spl->GetListSearch();
$rsNum = count($rs);
$surTimeDiff = 0;
$busSchNo = array();
$jobNoNew = "";
$dist = "HK"; // 市区
if ($rsNum > 0)
{
	$sp = $rs[0];
	$sp->routeNo = empty($sp->routeNo2) ? $sp->routeNo : $sp->routeNo . "&" . $sp->routeNo2;
	$surTimeDiff = TimeDiff(ToShortTime($sp->surFromTime), ToShortTime($sp->surToTime));
	$busSchNo[] = $sp->schNo + $sp->schNo2;
	if (strtoupper(substr($sp->refNo, 0, 1)) == "N" || strtoupper(substr($sp->refNo, 0, 1)) == "T")
	{
		$dist = "NT"; // 新界
	}
	$jobNoNew = $sp->refNo;
}
else
{
	exit();
}

// 巴士基本信息
$bul = new BusList($db);
$bul->busId = $sp->busId;
$rs = $bul->GetListSearch();
$rsNo = count($rs);
$person = $conf['bus']['mini']['person'];
$currBusType = "";
$titleName = "Capacity.";
$subjectName = "Monitoring Survey of Bus Service";
$vehicleName = "Buses";
if ($rsNo > 0)
{
	$bus = $rs[0];
	$sofsDate = $bus->sofsDate;
	if (!empty($sofsDate))
	{
		$sofsDate = date($conf['date']['format'], strtotime($sofsDate));
	}
	if ($bus->typeId == "1" || $bus->typeId == "3")
	{
		$currBusType = "mini";
		$titleName = "PSL No.";
		$subjectName = "Monitoring Survey of Minibus Service";
		$vehicleName = "GMBs";
	}
	else if ($bus->typeId == "2" || $bus->typeId == "4" || $bus->typeId == "5" || $bus->typeId == "7" || $bus->typeId == "8")
	{
		$currBusType = "big";
	}
	else if ($bus->typeId == "6")
	{
		$currBusType = "big";
		$subjectName = "Monitoring Survey of Unauthorised Residential Bus Service";
	}
	// $bus->typeId=="9"
}
// 巴士详细时间表
$btl = new BusTimeList($db);
$btl->busId = $sp->busId;
$btl->busId2 = $sp->busId2;
$btl->minBusTime = ToShortTime($sp->surFromTime);
$btl->maxBusTime = ToShortTime($sp->surToTime);
$btl->order = "ORDER BY busTime ASC";
$rs = $btl->GetListSearch();
$rsNo = count($rs);
$busTimePart = ToTimePart($btl->minBusTime, $btl->maxBusTime);
// print $btl->minBusTime." - ".$btl->maxBusTime."<br />";
// print_r($busTimePart);exit();
$busTimePartNum = count($busTimePart);

// 初始化顶部表格
$topTable = array();
InitNullValue($topTable, $busTimePart, $busTimePartNum);

$allTimeList = array();
$allBusTypeList = array();
$busTimeList = array();
$allTimeListIndex = 0;
for($i = 0; $i < $rsNo; $i++)
{
	$bt = $rs[$i];
	$busTimeList[] = $bt->busTime;
	$allTimeListIndex = $allTimeListIndex + $i;
	$allTimeList['bus_' . $allTimeListIndex] = $bt->busTime;
	$allBusTypeList[$allTimeListIndex] = ($bt->busId == $sp->busId) ? "" : "*";
	// echo "\$allTimeList['bus_'.{$allTimeListIndex}] = {$bt->busTime};";echo "<br />";
}

// 加上超過24小時部分
if (TimeDiff($btl->maxBusTime, '24:00') < 0)
{
	$btl->minBusTime = '00:00';
	$btl->maxBusTime = TimeAddHour($btl->maxBusTime, -24);
	$btl->order = "ORDER BY busTime ASC";
	$rs = $btl->GetListSearch();
	$rsNo = count($rs);
	$allTimeListIndex += 1;
	for($i = 0; $i < $rsNo; $i++)
	{
		$bt = $rs[$i];
		$busTimeList[] = TimeAddHour($bt->busTime, 24);
		$allTimeListIndex += $i;
		$allTimeList['bus_' . $allTimeListIndex] = TimeAddHour($bt->busTime, 24);
		$allBusTypeList[$allTimeListIndex] = ($bt->busId == $sp->busId) ? "" : "*";
	}
}

// var_dump($allBusTypeList);
// 调查表详细信息
$sdl = new SurveyDetailList($db);
$sdl->supaId = $_GET['supaId'];
$rs = $sdl->GetListSearch();
$rsNum = count($rs);
$departureTimeList = array();
for($i = 0; $i < $rsNum; $i++)
{
	$departureTimeList[] = $rs[$i]->departureTime;
	$allTimeList['dep_' . $i] = $rs[$i]->departureTime;
}
// 按从小到大排序
asort($busTimeList);
asort($departureTimeList);
asort($allTimeList);
$allTimeListKeyArray = array_keys($allTimeList);
$newAllTimeList = array();
$newAllTimeListIndex = 0;
$allTimeListIndex = 0;
// var_dump($allTimeList);exit();
$allTimeListNo = count($allTimeList);
foreach ( $allTimeList as $k => $v )
{
	// var_dump($v);exit();
	$timeListKey = explode('_', $k);
	$timeListKeyPrefix = $timeListKey[0];
	$timeListKeySuffix = $timeListKey[1];
	if ($allTimeListIndex > 0)
	{
		$allTimeListKeyPrev = explode('_', $allTimeListKeyArray[$allTimeListIndex - 1]);
		$allTimeListKeyPrevPrefix = $allTimeListKeyPrev[0];
	}
	if ($allTimeListIndex < $allTimeListNo)
	{
		$allTimeListKeyNext = explode('_', $allTimeListKeyArray[$allTimeListIndex + 1]);
		$allTimeListKeyNextPrefix = $allTimeListKeyNext[0];
	}
	
	$status = false; // true 增加行，false 插入到上一行.
	if ($newAllTimeListIndex == 0)
	{
		$status = true;
	}
	else if ($timeListKeyPrefix == $allTimeListKeyPrevPrefix)
	{
		$status = true;
	}
	else if ($newAllTimeList[$newAllTimeListIndex - 1][$timeListKeyPrefix][0] != "")
	{
		$status = true;
	}
	else if ($timeListKeyPrefix != $allTimeListKeyPrevPrefix && $timeListKeyPrefix != $allTimeListKeyNextPrefix && abs(TimeDiff($v, $allTimeList[$allTimeListKeyArray[$allTimeListIndex - 1]])) > abs(TimeDiff($v, $allTimeList[$allTimeListKeyArray[$allTimeListIndex + 1]])))
	{
		$status = true;
	}
	
	// 插入到上一行還是下一行.
	if ($status == true)
	{
		$newAllTimeList[$newAllTimeListIndex][$timeListKeyPrefix][0] = $timeListKeySuffix;
		$newAllTimeList[$newAllTimeListIndex][$timeListKeyPrefix][1] = $v;
		$newAllTimeListIndex++;
	}
	else
	{
		$newAllTimeList[$newAllTimeListIndex - 1][$timeListKeyPrefix][0] = $timeListKeySuffix;
		$newAllTimeList[$newAllTimeListIndex - 1][$timeListKeyPrefix][1] = $v;
	}
	
	$allTimeListIndex++;
}
// var_dump($newAllTimeList);
$labIndex = 0;
$lowTable = array();
$newAllTimeListNo = count($newAllTimeList);
// print "<table width=\"300\" border=\"1\">";
foreach ( $newAllTimeList as $k => $v )
{
	if ($v['dep'][0] == "")
	{
		$sdNull = new SurveyDetail($db);
		InsertValue($sdNull, $v['bus'][1], $v['bus'][0], $labIndex, $lowTable, $sdNull);
	}
	else if ($labIndex == 0)
	{
		InsertValue($rs[$v['dep'][0]], $v['bus'][1], $v['bus'][0], $labIndex, $lowTable, $rs[$v['dep'][0]]);
	}
	else
	{
		InsertValue($rs[$v['dep'][0]], $v['bus'][1], $v['bus'][0], $labIndex, $lowTable, $rs[$v['dep'][0] - 1]);
	}
	
	// print $labIndex." | ".$v['dep'][1]." | ".$v['bus'][1]."<br />";
	// print " <tr>
	// <td>".$labIndex."</td>
	// <td>".$v['bus'][0]."&nbsp;</td>
	// <td>".$v['bus'][1]."&nbsp;</td>
	// <td>".$v['dep'][0]."&nbsp;</td>
	// <td>".$v['dep'][1]."&nbsp;</td>
	// </tr>";
	// $labIndex++;
}
// print "</table>";
// exit();


$j = 0;
$k = 0;
$b = 0;
$lowTable['total']['skippedStopTotal'] = 0;
$lowTable['total']['busTimeTotal'] = 0;
$lowTable['total']['leftBehindMin'] = 0;
$lowTable['total']['leftBehindMax'] = 0;
$lowTable['total']['leftBehindTotal'] = 0;
foreach ( $lowTable as $v )
{
	$topTable[$j]['diffNoCount'] += $v['diffNo'];
	$lowTable['total']['diffTotal'] += $v['diffNo'];
	if ($v['busTime'] != "")
	{
		// print $k." - ".$busTimePart[$k+1]." - ".$v['busTime']." - ".TimeDiff($busTimePart[$k+1],$v['busTime'])."<br />";
		$busTimeDiff = TimeDiff($busTimePart[$k + 1], $v['busTime']);
		if ($busTimeDiff >= 0)
		{
			$jumpNo = ceil($busTimeDiff / 30);
			if ($busTimeDiff % 30 == 0)
				$jumpNo++;
			$k += $jumpNo;
		}
		$topTable[$k]['busTimeCount'] += 1;
		$lowTable['total']['busTimeTotal'] += 1;
	}
	
	if ($v['departureTime'] == "")
		continue;
		// 顶部表格
		// print "busTime:".$v['busTime']." \$k:".$k."<br/>";
		// print $j." - ".$busTimePart[$j+1]." - ".$v['departureTime']." - ".TimeDiff($busTimePart[$j+1],$v['departureTime'])."<br />";
	$departureTimeDiff = TimeDiff($busTimePart[$j + 1], $v['departureTime']);
	if ($departureTimeDiff >= 0 && $v['departureTime'] < $busTimePart[$busTimePartNum - 1])
	{
		$jumpNo = ceil($departureTimeDiff / 30);
		if ($departureTimeDiff % 30 == 0)
			$jumpNo++;
		$j += $jumpNo;
	}
	
	$topTable[$j]['headWayCount'] += $v['headWay'] * $v['pickup'];
	$topTable[$j]['halfHourly'] = $busTimePart[$j];
	$topTable[$j]['pslNoCount'] += $v['pslNo'];
	$topTable[$j]['personCount'] += $v['person'];
	$topTable[$j]['arrivals'] += 1;
	$topTable[$j]['departureTimeCount'] += 1;
	$topTable[$j]['onArrivalCount'] += $v['onArrival'];
	$topTable[$j]['setDownCount'] += $v['setDown'];
	$topTable[$j]['pickupCount'] += $v['pickup'];
	$topTable[$j]['onDeptCount'] += $v['onDept'];
	$topTable[$j]["onArrivalCountPercent"] = $topTable[$j]['personCount'] == 0 ? '0.00' : sprintf("%01.2f", $topTable[$j]['onArrivalCount'] / $topTable[$j]['personCount'] * 100);
	$topTable[$j]["onDeptCountPercent"] = $topTable[$j]['personCount'] == 0 ? '0.00' : sprintf("%01.2f", $topTable[$j]['onDeptCount'] / $topTable[$j]['personCount'] * 100);
	
	// 底部表格
	if ($v['leftBehind'] > 0)
	{
		$lowTable['total']['leftBehindTotal'] += 1;
		if ($lowTable['total']['leftBehindMin'] >= $v['leftBehind'] || $lowTable['total']['leftBehindMin'] == 0)
			$lowTable['total']['leftBehindMin'] = $v['leftBehind'];
		if ($lowTable['total']['leftBehindMax'] <= $v['leftBehind'])
			$lowTable['total']['leftBehindMax'] = $v['leftBehind'];
		
		$topTable[$j]['leftBehindSum'] += $v['leftBehind'];
		$topTable[$j]['leftBehindCount'] += 1;
		if ($topTable[$j]['leftBehindMinCount'] > $v['leftBehind'] || $topTable[$j]['leftBehindMinCount'] == 0)
			$topTable[$j]['leftBehindMinCount'] = $v['leftBehind'];
		if ($topTable[$j]['leftBehindMaxCount'] < $v['leftBehind'])
			$topTable[$j]['leftBehindMaxCount'] = $v['leftBehind'];
	}
	
	// 跳站车辆统计
	if ($v['skippedStop'] == 1)
		$lowTable['total']['skippedStopTotal'] += 1;
	
	$lowTable['total']['pslNo'] += $v['person'];
	$lowTable['total']['onArrivalTotal'] += $v['onArrival'];
	$lowTable['total']['setDownTotal'] += $v['setDown'];
	$lowTable['total']['pickupTotal'] += $v['pickup'];
	$lowTable['total']['onDeptTotal'] += $v['onDept'];
	$lowTable['total']['headWayTotal'] += $v['headWay'];
	// print $j." _ ".$v['headWay']."<br />";
}
$lowTable['total']['recordTotal'] = $rsNum;
$lowTable['total']["onArrivalTotalPercent"] = $lowTable['total']['pslNo'] == 0 ? 0 : round($lowTable['total']['onArrivalTotal'] / $lowTable['total']['pslNo'] * 100, $conf['decimal']['precision']);
$lowTable['total']["onDeptTotalPercent"] = $lowTable['total']['pslNo'] == 0 ? 0 : round($lowTable['total']['onDeptTotal'] / $lowTable['total']['pslNo'] * 100, $conf['decimal']['precision']);

// 将底部表格的值赋给顶部表格
$topTable['total']['pslNoCount'] = $lowTable['total']['pslNo'];
$topTable['total']['busTimeCount'] = $lowTable['total']['busTimeTotal'];
$topTable['total']['leftBehindMinCount'] = $lowTable['total']['leftBehindMin'];
$topTable['total']['leftBehindMaxCount'] = $lowTable['total']['leftBehindMax'];
$topTable['total']['leftBehindCount'] = $lowTable['total']['leftBehindTotal'];
$topTable['total']['arrivals'] = $lowTable['total']['recordTotal'];
$topTable['total']['departureTimeCount'] = $lowTable['total']['recordTotal'];
$topTable['total']['onArrivalCount'] = $lowTable['total']['onArrivalTotal'];
$topTable['total']['setDownCount'] = $lowTable['total']['setDownTotal'];
$topTable['total']['pickupCount'] = $lowTable['total']['pickupTotal'];
$topTable['total']['onDeptCount'] = $lowTable['total']['onDeptTotal'];
$topTable['total']['leftBehindCount'] = $lowTable['total']['leftBehindTotal'];
$topTable['total']['diffNoCount'] = $lowTable['total']['diffTotal'];
$topTable['total']["onArrivalCountTotalPercent"] = $lowTable['total']["onArrivalTotalPercent"];
$topTable['total']["onDeptCountTotalPercent"] = $lowTable['total']["onDeptTotalPercent"];

// 重新整理$lowTable数据
$lowTableRows = count($lowTable) - 1;
for($i = 0; $i < $lowTableRows; $i++)
{
	if ($lowTable[$i]['arrivalTime'] == "" && $lowTable[$i]['busTime'] != "")
	{
		$lowTable[$i]['fleetNo'] = "Missing";
	}
	
	if (TimeDiff($lowTable[$i]['arrivalTime'], "24:00") <= 0)
	{
		$lowTable[$i]['arrivalTime'] = TimeAddHour($lowTable[$i]['arrivalTime'], -24);
	}
	
	if (TimeDiff($lowTable[$i]['busTime'], "24:00") <= 0)
	{
		$lowTable[$i]['busTime'] = TimeAddHour($lowTable[$i]['busTime'], -24);
	}
	
	if (TimeDiff($lowTable[$i]['departureTime'], "24:00") <= 0)
	{
		$lowTable[$i]['departureTime'] = TimeAddHour($lowTable[$i]['departureTime'], -24);
	}
	
	// 如果是第二個routeNo,則默認加上"*"號;
	if (!empty($allBusTypeList[$lowTable[$i]['busTimeKey']]))
	{
		$lowTable[$i]['busTime'] = "*" . $lowTable[$i]['busTime'];
	}
}
// 整理一下现有的数据
$topTableRows = count($topTable) - 1;
$topTable['total']["headWayCountTotal"] = 0;
$calcTopTableRows = 0;
for($i = 0; $i < $topTableRows; $i++)
{
	if (TimeDiff($topTable[$i]['halfHourly'], "24:00") <= 0)
	{
		$topTable[$i]['halfHourly'] = TimeAddHour($topTable[$i]['halfHourly'], -24);
	}
	$topTable[$i]['diffNoCount'] = $topTable[$i]['arrivals'] - $topTable[$i]['busTimeCount'];
	$topTable[$i]["onArrivalCountPercent"] = $topTable[$i]['personCount'] == 0 ? 0 : round($topTable[$i]['onArrivalCount'] / $topTable[$i]['personCount'] * 100, $conf['decimal']['precision']);
	$topTable[$i]["onDeptCountPercent"] = $topTable[$i]['personCount'] == 0 ? 0 : round($topTable[$i]['onDeptCount'] / $topTable[$i]['personCount'] * 100, $conf['decimal']['precision']);
	
	if ($topTable[$i]['pickupCount'] == 0)
	{
		// 1,如 picked up 等于 0, left behind 也等于 0,那么 Headway 就为 "N/A"
		// 2,如 picked up 等于 0, left behind 也大于 0,那么 Headway 就为 30
		if ($topTable[$i]['leftBehindCount'] <= 0)
		{
			$topTable[$i]['headWayCount'] = "N/A";
			continue;
		}
		else
		{
			$topTable[$i]['headWayCount'] = 30;
		}
	}
	else
	{
		$topTable[$i]['headWayCount'] = 0;
		if ($topTable[$i]['leftBehindSum'] == 0)
		{
			if ($topTable[$i]['departureTimeCount'] != 0)
			{
				$topTable[$i]['headWayCount'] = round(30 / (2 * $topTable[$i]['departureTimeCount']), $conf['decimal']['precision']);
			}
		}
		else
		{
			if ($topTable[$i]['departureTimeCount'] != 0 && $topTable[$i]['pickupCount'] != 0)
			{
				$topTable[$i]['headWayCount'] = round((30 * (2 * $topTable[$i]['leftBehindSum'] + $topTable[$i]['pickupCount'])) / (2 * $topTable[$i]['departureTimeCount'] * $topTable[$i]['pickupCount']), $conf['decimal']['precision']);
				//echo "(30 * (2 * {$topTable[$i]['leftBehindSum']} + {$topTable[$i]['pickupCount']})) / (2 * {$topTable[$i]['departureTimeCount']} * {$topTable[$i]['pickupCount']})"."<br />";
			}
		}
		// 公式:(30 * (2 * left-behind-total + picked-up)) / (2 * departure-obs * picked-up)
		// $topTable[$i]['headWayCount'] = $topTable[$i]['leftBehindSum']==0?($topTable[$i]['departureTimeCount']==0?0:round(30/(2*$topTable[$i]['departureTimeCount']),$conf['decimal']['precision']) ): ( ($topTable[$i]['departureTimeCount']*$topTable[$i]['pickupCount'])==0?0:round((30*(2*$topTable[$i]['leftBehindSum']+$topTable[$i]['pickupCount']))/(2*$topTable[$i]['departureTimeCount']*$topTable[$i]['pickupCount']),$conf['decimal']['precision']) ) ;
	}
	// H項目顯示真實時間,其它項目保留規則 request by molly 20141030
	if (substr($jobNoNew, 0, 1) != "H")
	{
		if ($topTable[$i]['headWayCount'] > 30)
		{
			$topTable[$i]['headWayCount'] = 30;
		}
	}
	$topTable['total']["headWayCountTotal"] += $topTable[$i]['headWayCount'];
	// print $i." _ ".$topTable['total']["headWayCountTotal"]."<br />";
	if ($topTable[$i]['headWayCount'] != "N/A" && $topTable[$i]['headWayCount'] != 0)
	{
		$calcTopTableRows++;
	}
}
// 最后一个整点时间如果都為空,則全部不要
if (empty($topTable[$topTableRows - 1]["arrivals"]))
{
	$tmpArray = array();
	for($i = 0; $i < $topTableRows - 1; $i++)
	{
		$tmpArray[$i] = $topTable[$i];
	}
	$tmpArray['total'] = $topTable['total'];
	unset($topTable);
	$topTable = $tmpArray;
}
// $calcTopTableRows = $topTableRows - 1;
// $topTable['total']["headWayCountTotal"] = $calcTopTableRows==1?0:round($topTable['total']["headWayCountTotal"]/($calcTopTableRows-1),$conf['decimal']['precision']);
$topTable['total']["headWayCountTotal"] = $calcTopTableRows == 0 ? 0 : round($topTable['total']["headWayCountTotal"] / $calcTopTableRows, $conf['decimal']['precision']);
// TODO
// 新中标后需更改规则
// SUM(每行的(上車人數 X $topTable[$i]['headWayCount'] )) 再除 TOTAL上車人數
?>
