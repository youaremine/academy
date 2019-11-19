<?php

/*
 * Header: $lowTable指详细表
 * Create: 2007-1-28
 * Auther: Jamblues.
 */
include_once ('../includes/config.inc.php');
/**
 * 插入
 */
function InsertValue($sd,$busTime,$busTimeKey,&$labIndex,&$lowTable,$sdLast){
	global $conf,$currBusType,$jobNoNew;
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
	$lowTable[$labIndex]['leftBehind'] = (int)$sd->leftBehind;
	$lowTable[$labIndex]['onDept'] = $sd->onDept;
	$lowTable[$labIndex]['leftRoleFlag'] = $sd->leftRoleFlag;
	$lowTable[$labIndex]['diffNo'] = 0;
	
	if($busTime == ""){
		$lowTable[$labIndex]['busTime'] = "";
		$lowTable[$labIndex]['diffNo'] = 1;
	}else{
		$busTime = ToShortTime($busTime);
		$lowTable[$labIndex]['busTime'] = $busTime;
		$lowTable[$labIndex]['busTimeKey'] = $busTimeKey;
	}
	
	if($sd->departureTime == ""){
		
		$lowTable[$labIndex]['fleetNo'] = "";
		$lowTable[$labIndex]['diffNo'] = - 1;
	}else if($sdLast->departureTime == ""){
		// TODO
	}else{
		$lowTable[$labIndex]['headWay'] = TimeDiff($sdLast->departureTime,$sd->departureTime);
		// echo $labIndex," - ",$lowTable[$labIndex]['headWay']," - ","imeDiff( {$sdLast->departureTime},{$sd->departureTime});.<br />";
	}
	
	// 应用了这一个规则才会生效
	if($currBusType == "big"){
		
		$lowTable[$labIndex]['person'] = $sd->pslNo;
		// 如果如果架車開出時,車上還有容量的15%以上空位的話就算有left behind, 都當是 "0" request by molly 20140415
		if($lowTable[$labIndex]['onDept'] < $lowTable[$labIndex]['person'] * 0.85 && $lowTable[$labIndex]['leftRoleFlag'] == 'yes'){
			$lowTable[$labIndex]['leftBehind'] = 0;
		}
	}else if($currBusType == "mini"){
		$lowTable[$labIndex]['person'] = $conf['bus']['mini']['person'];
		// 如果如果架車開出時,車上還有空位的話就算有left behind, 都當是 "0"
		if($lowTable[$labIndex]['onDept'] < $lowTable[$labIndex]['person'] && $lowTable[$labIndex]['leftRoleFlag'] == 'yes'){
			$lowTable[$labIndex]['leftBehind'] = 0;
		}
	} // else if ($currBusType == "coach")
	  // {
	  // $lowTable[$labIndex]['person'] = $conf['bus']['coach']['person'];
	  // }
	else{
		$lowTable[$labIndex]['person'] = $sd->pslNo;
	}
	// H項目顯示真實時間,其它項目保留規則 request by molly 20141030
	// NE項目顯示真實時間,其它項目保留規則 request by panda 20150410
	if(substr($jobNoNew,0,1) != "H" && substr($jobNoNew,0,1) != "N"){
		if($lowTable[$labIndex]['headWay'] > 35) // 如果超過35分鐘,那麼為沒有人等 request by molly 20140415
			$lowTable[$labIndex]['headWay'] = 0;
		else if($lowTable[$labIndex]['headWay'] > 30) // 如果超過30分鐘,沒超過35分鐘,那麼變成30分鐘;request by molly 20140415
			$lowTable[$labIndex]['headWay'] = 30;
	}
	$lowTable[$labIndex]['onArrivalPercent'] = $lowTable[$labIndex]['person'] == 0?0:round($lowTable[$labIndex]['onArrival'] / $lowTable[$labIndex]['person'] * 100,$conf['decimal']['precision']);
	$lowTable[$labIndex]["onDeptPercent"] = $lowTable[$labIndex]['person'] == 0?0:round($lowTable[$labIndex]['onDept'] / $lowTable[$labIndex]['person'] * 100,$conf['decimal']['precision']);
	$labIndex ++;
}

/**
 * 得到ID.
 */
function GetNearTime($val,$arr,$index){
	$returnIndex = $index;
	$arrNo = count($arr);
	if(TimeDiff($val,$arr[$arrNo - 1]) == 0){
		$returnIndex = $arrNo - 1;
	}else{
		for($i = $index;$i < $arrNo;$i ++){
			if(TimeDiff($val,$arr[$i]) > 0){
				if($i > 0){
					$returnIndex = $i - 1;
				}else{
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
if(! empty($_GET['supaId'])){
	$spl->supaId = $_GET['supaId'];
}else if(! empty($_GET['refNo'])){
	$spl->refNo = $_GET['refNo'];
}
$rs = $spl->GetListSearch();
$rsNum = count($rs);
$surTimeDiff = 0;
$busSchNo = array ();
$jobNoNew = "";
$dist = "HK"; // 市区
if($rsNum > 0){
	$sp = $rs[0];
	$sp->routeNo = empty($sp->routeNo2)?$sp->routeNo:$sp->routeNo . "&" . $sp->routeNo2;
	$surTimeDiff = TimeDiff(ToShortTime($sp->surFromTime),ToShortTime($sp->surToTime));
	$busSchNo[] = $sp->schNo + $sp->schNo2;
	if(strtoupper(substr($sp->refNo,0,1)) == "N" || strtoupper(substr($sp->refNo,0,1)) == "T"){
		$dist = "NT"; // 新界
	}
	$jobNoNew = $sp->refNo;
	// 获取td file no.
	$m = new MainSchedule();
	$m->jobNoNew = $sp->refNo;
	if(strpos($m->jobNoNew,"_") > 0)
		$m->jobNoNew = substr($m->jobNoNew,0,strpos($m->jobNoNew,"_"));
	$ma = new MainScheduleAccess($db);
	$m = $ma->GetSingle($m);
	$sp->tdRefNo = $m->tdFileNo;
	// 加上星期几
	$sp->surDate = $sp->surDate . " (" . date("l",strtotime($sp->surDate)) . ")";
}else{
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
$totalJourneyTime = 0;
$totalJourneyDistance = 0;
if($rsNo > 0){
	$bus = $rs[0];
	$sofsDate = $bus->sofsDate;
	if(! empty($sofsDate)){
		$sofsDate = date($conf['date']['format'],strtotime($sofsDate));
	}
	if($bus->typeId == "1" || $bus->typeId == "3"){
		$currBusType = "mini";
		$titleName = "PSL No.";
		$subjectName = "Monitoring Survey of Minibus Service";
		$vehicleName = "GMB";
	}else if($bus->typeId == "5"){
		$currBusType = "coach";
		$titleName = "PSL No.";
		$subjectName = "Monitoring Survey of Coach Service";
		$vehicleName = "Coaches";
	}else if($bus->typeId == "2" || $bus->typeId == "4" || $bus->typeId == "7" || $bus->typeId == "8"){
		$currBusType = "big";
	}else if($bus->typeId == "6"){
		$currBusType = "big";
		$subjectName = "Monitoring Survey of Unauthorised Residential Bus Service";
	}
	$totalJourneyTime = $bus->totalJourneyTime;
	$totalJourneyDistance = $bus->totalJourneyDistance;
	// $bus->typeId=="9"
}

// 巴士详细距离表
$busDistanceDetail = "";
$midJourneyDistance = 0;
if($sp->busStopNo > 0){
	$bd = new BusDistance();
	$bd->busId = $sp->busId;
	$bd->order = " ORDER BY stopNo ASC";
	$bda = new BusDistanceAccess($db);
	$rs = $bda->GetListSearch($bd);
	$rsNum = count($rs);
	$busDistanceArr = array ();
	for($i = 0;$i < $rsNum;$i ++){
		$bd = $rs[$i];
		if($bd->stopNo >= $sp->busStopNo)
			break;
		$busDistanceArr[] = $bd->distance;
		$midJourneyDistance += $bd->distance;
	}
	$busDistanceDetail = implode("+",$busDistanceArr);
	$estimatedTime = ROUND($totalJourneyTime * $midJourneyDistance / $totalJourneyDistance,0);
}else if($sp->busStopNo == - 1){
	$busDistanceDetail = "--";
}

// 巴士详细时间表
$btl = new BusTimeList($db);
$btl->busId = $sp->busId;
$btl->busId2 = $sp->busId2;
$minBusTime = date("H:i",strtotime($sp->surFromTime) - $estimatedTime * 60);
$btl->minBusTime = $minBusTime;
$hasCrossDay = false;
if(TimeDiff($sp->surToTime,'24:00') <= 0){
	$tmpTime = $sp->surToTime;
	$tmpTime = TimeAddHour($tmpTime,- 24);
	$maxBusTime = date("H:i",strtotime($tmpTime) - $estimatedTime * 60);
	$tDay1 = date("Ymd",strtotime($tmpTime));
	$tDay2 = date("Ymd",strtotime($tmpTime) - $estimatedTime * 60);
	if($tDay1 == $tDay2){
		$maxBusTime = TimeAddHour($maxBusTime,24);
	}
	$hasCrossDay = true;
}else{
	$maxBusTime = date("H:i",strtotime($sp->surToTime) - $estimatedTime * 60);
}
$btl->maxBusTime = $maxBusTime;
$btl->order = "ORDER BY busTime ASC";
if(TimeDiff($btl->maxBusTime,'24:00') <= 0){
	$tmpMaxBusTime = $btl->maxBusTime;
	$btl->maxBusTime = "24:00";
	$rs = $btl->GetListSearch();
	$btl->maxBusTime = $tmpMaxBusTime;
}else {
	$rs = $btl->GetListSearch();
}
$rsNo = count($rs);
$busTimePart = ToTimePartDynamic($btl->minBusTime,$btl->maxBusTime);
// $busTimePart = ToTimePartDynamic($sp->surFromTime, $sp->surToTime);
// print $sp->surFromTime." - ".$sp->surToTime."<br />";
// print $btl->minBusTime . " - " . $btl->maxBusTime . " - " . ($estimatedTime * 60) . "<br />";
// var_dump($busTimePart);
// exit();
$busTimePartNum = count($busTimePart);
$crossDayPartNum = - 1;
for($i = 0;$i < $busTimePartNum;$i ++){
	$timeDiff = TimeDiff($busTimePart[$i],'24:00');
	$timeDiff -= $estimatedTime;
// 	echo $busTimePart[$i],"-",$timeDiff,"<br />";
	if($timeDiff > 0 && $timeDiff <= 30){
		$crossDayPartNum = $i;
	}
}

$allTimeList = array ();
$allBusTypeList = array ();
$busTimeList = array ();
$allTimeListIndex = 0;
for($i = 0;$i < $rsNo;$i ++){
	$bt = $rs[$i];
	$bt->busTime = date("H:i",strtotime($bt->busTime) + $estimatedTime * 60);
	$busTimeList[] = $bt->busTime;
	$allTimeListIndex = $allTimeListIndex + $i;
	$allTimeList['bus_' . $allTimeListIndex] = $bt->busTime;
	$allBusTypeList[$allTimeListIndex] = ($bt->busId == $sp->busId)?"":"*";
//	 echo "\$allTimeList['bus_'.{$allTimeListIndex}] = {$bt->busTime};";echo "<br />";
}
// 加上超過24小時部分
if(TimeDiff($btl->maxBusTime,'24:00') < 0){
	//获取Bus数据库中输入了25:00这类数据
	$btl->minBusTime = '24:00';
	$btl->maxBusTime = $btl->maxBusTime;
	$btl->order = "ORDER BY busTime ASC";
	$rs = $btl->GetListSearch();
	$rsNo = count($rs);
	$allTimeListIndex += 1;
	for($i = 0;$i < $rsNo;$i ++){
		$bt = $rs[$i];
		$bt->busTime = TimeAddHour($bt->busTime,-24);
		$bt->busTime = date("H:i",strtotime($bt->busTime) + $estimatedTime * 60);
		$busTimeList[] = TimeAddHour($bt->busTime,24);
		$allTimeListIndex += $i;
		$allTimeList['bus_' . $allTimeListIndex] = TimeAddHour($bt->busTime,24);
		$allBusTypeList[$allTimeListIndex] = ($bt->busId == $sp->busId)?"":"*";
	}
	//获取Bus数据库中00:05这类数据
	$btl->minBusTime = '00:00';
	$btl->maxBusTime = TimeAddHour($btl->maxBusTime,- 24);
	$btl->order = "ORDER BY busTime ASC";
	$rs = $btl->GetListSearch();
	$rsNo = count($rs);
	$allTimeListIndex += 1;
	for($i = 0;$i < $rsNo;$i ++){
		$bt = $rs[$i];
		$bt->busTime = date("H:i",strtotime($bt->busTime) + $estimatedTime * 60);
		$busTimeList[] = TimeAddHour($bt->busTime,24);
		$allTimeListIndex += $i;
		$allTimeList['bus_' . $allTimeListIndex] = TimeAddHour($bt->busTime,24);
		$allBusTypeList[$allTimeListIndex] = ($bt->busId == $sp->busId)?"":"*";
	}
}

// var_dump($busTimeList);exit();
// 调查表详细信息
$sdl = new SurveyDetailList($db);
$sdl->supaId = $sp->supaId;
$rs = $sdl->GetListSearch();
$rsNum = count($rs);
$departureTimeList = array ();
for($i = 0;$i < $rsNum;$i ++){
	$departureTimeList[] = $rs[$i]->departureTime;
	$allTimeList['dep_' . $i] = $rs[$i]->departureTime;
}
// 按从小到大排序
asort($busTimeList);
asort($departureTimeList);
//asort($allTimeList);
function sortByValue($a, $b) {
    if (TimeToMinute($a) == TimeToMinute($b)) {
        return 1;
    } else {
        return (TimeToMinute($a) > TimeToMinute($b)) ? 1 : -1;
    }
}
uasort($allTimeList,'sortByValue');
//var_dump($allTimeList);exit();
$allTimeListKeyArray = array_keys($allTimeList);
$newAllTimeList = array ();
$newAllTimeListIndex = 0;
$allTimeListIndex = 0;
$allTimeListNo = count($allTimeList);
foreach($allTimeList as $k => $v){
	// var_dump($v);exit();
	$timeListKey = explode('_',$k);
	$timeListKeyPrefix = $timeListKey[0];
	$timeListKeySuffix = $timeListKey[1];
	if($allTimeListIndex > 0){
		$allTimeListKeyPrev = explode('_',$allTimeListKeyArray[$allTimeListIndex - 1]);
		$allTimeListKeyPrevPrefix = $allTimeListKeyPrev[0];
	}
	if($allTimeListIndex < $allTimeListNo){
		$allTimeListKeyNext = explode('_',$allTimeListKeyArray[$allTimeListIndex + 1]);
		$allTimeListKeyNextPrefix = $allTimeListKeyNext[0];
	}
	
	$status = false; // true 增加行，false 插入到上一行.
	if($newAllTimeListIndex == 0){
		$status = true;
	}else if($timeListKeyPrefix == $allTimeListKeyPrevPrefix){
		$status = true;
	}else if($newAllTimeList[$newAllTimeListIndex - 1][$timeListKeyPrefix][0] != ""){
		$status = true;
	}else if($timeListKeyPrefix != $allTimeListKeyPrevPrefix && $timeListKeyPrefix != $allTimeListKeyNextPrefix && abs(TimeDiff($v,$allTimeList[$allTimeListKeyArray[$allTimeListIndex - 1]])) > abs(TimeDiff($v,$allTimeList[$allTimeListKeyArray[$allTimeListIndex + 1]]))){
		$status = true;
	}
	
	// 插入到上一行還是下一行.
	if($status == true){
		$newAllTimeList[$newAllTimeListIndex][$timeListKeyPrefix][0] = $timeListKeySuffix;
		$newAllTimeList[$newAllTimeListIndex][$timeListKeyPrefix][1] = $v;
		$newAllTimeListIndex ++;
	}else{
		$newAllTimeList[$newAllTimeListIndex - 1][$timeListKeyPrefix][0] = $timeListKeySuffix;
		$newAllTimeList[$newAllTimeListIndex - 1][$timeListKeyPrefix][1] = $v;
	}
	
	$allTimeListIndex ++;
}
// var_dump($newAllTimeList);exit();
$labIndex = 0;
$lowTable = array ();
$newAllTimeListNo = count($newAllTimeList);
// print "<table width=\"300\" border=\"1\">";
foreach($newAllTimeList as $k => $v){
	if($v['dep'][0] == ""){
		$sdNull = new SurveyDetail($db);
		InsertValue($sdNull,$v['bus'][1],$v['bus'][0],$labIndex,$lowTable,$sdNull);
	}else if($labIndex == 0){
		InsertValue($rs[$v['dep'][0]],$v['bus'][1],$v['bus'][0],$labIndex,$lowTable,$rs[$v['dep'][0]]);
	}else{
		InsertValue($rs[$v['dep'][0]],$v['bus'][1],$v['bus'][0],$labIndex,$lowTable,$rs[$v['dep'][0] - 1]);
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

// 重新整理$lowTable数据
$fleetNoList = array ();
$lowTableRows = count($lowTable);
for($i = 0;$i < $lowTableRows;$i ++){
	// 没有车辆到达时
	if(empty($lowTable[$i]['arrivalTime']) && ! empty($lowTable[$i]['busTime'])){
		$lowTable[$i]['displayBoard'] = "";
		$lowTable[$i]['skippedStop'] = "";
		$lowTable[$i]['fleetNo'] = "";
		$lowTable[$i]['pslNo'] = "";
		$lowTable[$i]['person'] = "";
		$lowTable[$i]['arrivalTime'] = "";
		$lowTable[$i]['departureTime'] = "";
		$lowTable[$i]['onArrival'] = "";
		$lowTable[$i]['onArrivalPercent'] = "";
		$lowTable[$i]['setDown'] = "";
		$lowTable[$i]['pickup'] = "";
		$lowTable[$i]['onDept'] = "";
		$lowTable[$i]['onDeptPercent'] = "";
		$lowTable[$i]['leftBehind'] = "";
		$lowTable[$i]['leftBehind'] = "";
		$lowTable[$i]['headWay'] = "";
	}
	if(TimeDiff($lowTable[$i]['arrivalTime'],"24:00") <= 0){
		$lowTable[$i]['arrivalTime'] = TimeAddHour($lowTable[$i]['arrivalTime'],- 24);
        $lowTable[$i]['arrivalTime'] = "1900-01-01 ".$lowTable[$i]['arrivalTime'];
	}

	if(TimeDiff($lowTable[$i]['busTime'],"24:00") <= 0){
		$lowTable[$i]['busTime'] = TimeAddHour($lowTable[$i]['busTime'],- 24);
        $lowTable[$i]['busTime'] = "1971-01-01 ".$lowTable[$i]['busTime'];
	}else{
        if(! empty($lowTable[$i]['busTime'])) {
            $lowTable[$i]['busTime'] = "1970-12-31 " . $lowTable[$i]['busTime'];
        }
    }
	if(! empty($lowTable[$i]['busTime'])){
		$lowTable[$i]['busTime'] = date("Y-m-d H:i",strtotime($lowTable[$i]['busTime']) - $estimatedTime * 60);
        $lowTable[$i]['busTime'] = str_replace('1971-01-01 ','1900-01-01 ',$lowTable[$i]['busTime']);
        $lowTable[$i]['busTime'] = str_replace('1970-12-31 ','',$lowTable[$i]['busTime']);
	}
	
	if(TimeDiff($lowTable[$i]['departureTime'],"24:00") <= 0){
		$lowTable[$i]['departureTime'] = TimeAddHour($lowTable[$i]['departureTime'],- 24);
        $lowTable[$i]['departureTime'] = "1900-01-01 ".$lowTable[$i]['departureTime'];
	}
	// 如果车牌不为空,sofs time也不为空
	$lowTable[$i]['diffMinShow'] = "--";
	if(! empty($lowTable[$i]['fleetNo']) && ! empty($lowTable[$i]['busTime'])){
		$lowTable[$i]['diffMin'] = TimeDiff($lowTable[$i]['departureTime'],$lowTable[$i]['busTime']);
		$lowTable[$i]['diffMinShow'] = $lowTable[$i]['diffMin']?$lowTable[$i]['diffMin']:"--";
	}
	// 如果on departure不足100%,而left behind有人数,则要显示自愿不登车
	$lowTable[$i]['leftBehindShow'] = $lowTable[$i]['leftBehind'];
	if($lowTable[$i]['onDeptPercent'] < 100 && $lowTable[$i]['leftBehind'] > 0){
		$lowTable[$i]['leftBehindShow'] = "({$lowTable[$i]['leftBehind']})";
		$lowTable[$i]['leftBehind'] = 0;
	}
	// 如果是第二個routeNo,則默認加上"*"號;
	if(! empty($allBusTypeList[$lowTable[$i]['busTimeKey']])){
		$lowTable[$i]['busTime'] =  $lowTable[$i]['busTime']."*";
	}
	
	if($lowTable[$i]['fleetNo'] == "" || $lowTable[$i]['fleetNo'] == "Missing")
		continue;
	$fleetNo = trim($lowTable[$i]['fleetNo']);
	$fleetNoList[] = $fleetNo;
	$fleetNoCountList[$fleetNo] += 1;
}
$fleetNoList = UniqueArray($fleetNoList);
sort($fleetNoList);
$fleetNoListRows = count($fleetNoList);

$json = array ();
unset($sp->db);

$json['currBusType'] = $currBusType;
$json['totalJourneyTime'] = intval($totalJourneyTime);
$json['totalJourneyDistance'] = floatval($totalJourneyDistance);
$json['busDistanceDetail'] = $busDistanceDetail;
$json['busTimePartNum'] = $busTimePartNum;
$json['crossDayPartNum'] = $crossDayPartNum;
$tmp = explode(":",$sp->surFromTime);
$busTimePartStartMins = intval($tmp[1]);
if($busTimePartStartMins >= 30)
	$busTimePartStartMins = $busTimePartStartMins - 30;
$busTimePartEndMins = $busTimePartStartMins + 30;
$json['busTimePartStartMins'] = $busTimePartStartMins;
$json['busTimePartEndMins'] = $busTimePartEndMins;
$json['detailPartNum'] = count($lowTable);
$json['vehicleSchedule'] = $busSchNo[0];
$json['vehicleObserved'] = $fleetNoListRows;
$json['registrationPartNum'] = ceil($fleetNoListRows / 7);
$json['fleetNoList'] = $fleetNoList;
$json['surveyPart'] = $sp;
$json['detailList'] = $lowTable;
echo json_encode($json);
?>
