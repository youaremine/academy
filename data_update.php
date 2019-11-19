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
$t->set_file ( "HdIndex", "data_update.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "TypeRow", "TypeRows" );
$t->set_block ( "HdIndex", "BoundsRow", "BoundsRows" );
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "DistRow", "DistRows" );
$t->set_block ( "HdIndex", "WeatherRow", "WeatherRows" );
$t->set_block ( "HdIndex", "SurveyDateYearRow", "SurveyDateYearRows" );
$t->set_block ( "HdIndex", "BusStopNoRow", "BusStopNoRows" );
$t->set_block ( "HdIndex", "RouteRow", "RouteRows" );

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

// 天氣
$weathers = getArray ( 'weather' );
foreach ( $weathers as $k => $v ) {
	$t->set_var ( array (
			"weatherId" => $k,
			"weatherName" => $v 
	) );
	$t->parse ( "WeatherRows", "WeatherRow", true );
}

// 調查年份
$currentYear = date ( "Y" );
for($i = 2; $i >= 0; $i --) {
	$surveyDateYearValue = $currentYear - $i;
	$t->set_var ( "surveyDateYearValue", $surveyDateYearValue );
	$t->parse ( "SurveyDateYearRows", "SurveyDateYearRow", true );
}

// 初始化开始时间
$t->set_var ( "startTime", date ( $conf ['dateTime'] ['format'] ) );

$spl = new SurveyPartList ( $db );
$spl->supaId = $_GET ['supaId'];
$rs = $spl->GetListSearch ();
$rsNum = count ( $rs );
$busTypeId = '';
for($i = 0; $i < $rsNum; $i ++) {
	$sp = $rs [$i];
	
	$distCode = '';
	
	// bus 2
	$rs = array ();
	if ($sp->busId2 != '') {
		$bul = new BusList ( $db );
		$bul->busId = $sp->busId2;
		$rs = $bul->GetListSearch ();
	}
	$rsNo = count ( $rs );
	if ($rsNo > 0) {
		$v = $rs [0];
		$t->set_var ( array (
				"amSchNo2" => $v->amSchNo,
				"pmSchNo2" => $v->pmSchNo,
				"allSchNo2" => $v->allSchNo,
				"routeNo2Style" => "" 
		) );
	} else {
		$t->set_var ( array (
				"amSchNo2" => 0,
				"pmSchNo2" => 0,
				"allSchNo2" => 0,
				"routeNo2Style" => "ShowHideRoute2();" 
		) );
	}
	// bus 1
	$bul = new BusList ( $db );
	$bul->busId = $sp->busId;
	$rs = $bul->GetListSearch ();
	$rsNo = count ( $rs );
	if ($rsNo > 0) {
		$v = $rs [0];
		$busTypeId = $v->typeId;
		$distCode = $v->distCode;
		$t->set_var ( array (
				"amSchNo" => $v->amSchNo,
				"pmSchNo" => $v->pmSchNo,
				"allSchNo" => $v->allSchNo 
		) );
	} else {
		$t->set_var ( array (
				"amSchNo" => 0,
				"pmSchNo" => 0,
				"allSchNo" => 0 
		) );
	}

	// 中途站
	$bd = new BusDistance();
	$bd->busId = $sp->busId;
	$bda = new BusDistanceAccess($db);
	$rsBusDistance = $bda->GetListSearch($bd);
	$rsBusDistanceNum = count($rsBusDistance);
	for($k=0; $k<$rsBusDistanceNum; $k++) {
		$bd = $rsBusDistance[$k];
		$t->set_var(array(
				"stopNo"=>$bd->stopNo,
				"stopDescription"=>$bd->stopDescription				
		));
		$t->parse ( "BusStopNoRows", "BusStopNoRow", true );
	}
	
	if ($busTypeId == "1" || $busTypeId == "3")
	{
		$t->set_var(array(
				"stopNo"=>-1,
				"stopDescription"=>"標記為中途站"
		));
		$t->parse ( "BusStopNoRows", "BusStopNoRow", true );
	}
	
	$surFromTime = explode ( ':', $sp->surFromTime );
	$surFromTimeHor = $surFromTime [0];
	$surFromTimeMin = $surFromTime [1];
	
	$surToTime = explode ( ':', $sp->surToTime );
	$surToTimeHor = $surToTime [0];
	$surToTimeMin = $surToTime [1];
	$t->set_var ( array (
			"supaId" => $spl->supaId,
			"listStyle" => $listStyle,
			"refNo" => $sp->refNo,
			"weatherId" => $sp->weatherId,
			"busStopNo" => $sp->busStopNo,
			"busId" => $sp->busId,
			"busTypeId" => $busTypeId,
			"routeNo" => $sp->routeNo,
			"surDate" => $sp->surDate,
			"surveyDateYear" => date ( "Y", strtotime ( $sp->surDate ) ),
			"surveyDateMonth" => date ( "m", strtotime ( $sp->surDate ) ),
			"surveyDateDay" => date ( "d", strtotime ( $sp->surDate ) ),
			"surFromTimeHor" => $surFromTimeHor,
			"surFromTimeMin" => $surFromTimeMin,
			"surToTimeHor" => $surToTimeHor,
			"surToTimeMin" => $surToTimeMin,
			"location" => $sp->location,
			"bounds" => $sp->bounds,
			"distCode" => $distCode,
			"schNo" => $sp->schNo,
			"schType" => $sp->schType,
			"busId2" => $sp->busId2,
			"routeNo2" => $sp->routeNo2,
			"schType2" => $sp->schType2,
			"surveyorId" => $sp->survId,
			"remarks" => $sp->remarks,
			"userChiName" => $sp->userName
	) );
	// surveyor part
	$sur = new Surveyor ();
	$sur->survId = $sp->survId;
	if ($sur->survId > 0) {
		$sa = new SurveyorAccess ( $db );
		$rs = $sa->GetListSearch ( $sur );
		$sur = $rs [0];
	}
	$t->set_var ( array (
			"surveyorEngName" => $sur->engName,
			"surveyorContanct" => $sur->contact,
			"surveyorHome" => $sur->survHome 
	) );
}
$sdl = new SurveyDetailList ( $db );
$sdl->supaId = $_GET ['supaId'];
$sdl->butyId = $busTypeId;
if(empty($_GET['routeSort'])){
	$sdl->order = ' ORDER BY departureTime';
}else{
	$sdl->order = ' ORDER BY routeItem,departureTime';
}
$rs = $sdl->GetFleetNoStatListSearch ();
$rsNum = count ( $rs );
$routeArr = array();
for($i = 0; $i < $rsNum; $i ++) {
	$sd = $rs [$i];
	$arrivalTime = explode ( ':', $sd->arrivalTime );
	$arrivalTimeHor = $arrivalTime [0];
	$arrivalTimeMin = $arrivalTime [1];
	$departureTime = explode ( ':', $sd->departureTime );
	$departureTimeHor = $departureTime [0];
	$departureTimeMin = $departureTime [1];
	$cssErrorTextbox = "";
	if ($sd->regiId == "" && $sd->aId == "") {
		$cssErrorTextbox = "ErrorTextbox";
	}
	$wrongDirectionStyle = $blankStyle = $missingDigitalStyle = $missingCharacterStyle = $otherStyle = "";
	$otherDisplayBoard = "";
	$otherDisplayBoardStyle = "style=\"display:none;\"";
	switch ($sd->displayBoard) {
		case "" :
			break;
		case "Wrong Direction" :
			$wrongDirectionStyle = "selected=\"selected\"";
			break;
		case "Blank" :
			$blankStyle = "selected=\"selected\"";
			break;
		case "Missing Digital" :
			$missingDigitalStyle = "selected=\"selected\"";
			break;
		case "Missing Character" :
			$missingCharacterStyle = "selected=\"selected\"";
			break;
		default :
			$otherStyle = "selected=\"selected\"";
			$otherDisplayBoardStyle = "";
			$otherDisplayBoard = $sd->displayBoard;
			break;
	}
	$routeRemarks = "";
	if(!empty($sd->routeItem)){
		$routeRemarks = "<br />路線：".$sd->routeItem;
		$routeArr[] = $sd->routeItem;
	}
	$otherRemarks = "";
	if(!empty($sd->remarks)){
		$otherRemarks = "<br />備註：".$sd->remarks;
	}
	if(!empty($otherRemarks)){
		$routeRemarks .= $otherRemarks;
	}
	$t->set_var ( array (
			"i" => $i,
			"sudeId" => $sd->sudeId,
			"routeItem" => $sd->routeItem,
			"wrongDirectionStyle" => $wrongDirectionStyle,
			"blankStyle" => $blankStyle,
			"missingDigitalStyle" => $missingDigitalStyle,
			"missingCharacterStyle" => $missingCharacterStyle,
			"otherStyle" => $otherStyle,
			"otherDisplayBoardStyle" => $otherDisplayBoardStyle,
			"otherDisplayBoard" => $otherDisplayBoard,
			"skippedStopChecked" => $sd->skippedStop == 1 ? 'checked="checked"' : '',
			"fleetNo" => $sd->fleetNo,
			"pslNo" => $sd->pslNo,
			"arrivalTimeHor" => $arrivalTimeHor,
			"arrivalTimeMin" => $arrivalTimeMin,
			"departureTimeHor" => $departureTimeHor,
			"departureTimeMin" => $departureTimeMin,
			"onArrival" => $sd->onArrival,
			"pickup" => $sd->pickup,
			"setDown" => $sd->setDown,
			"leftBehind" => $sd->leftBehind,
			"leftRoleFlagChecked" => $sd->leftRoleFlag == 'no' ? '' : 'checked="checked"',
			"onDept" => $sd->onDept,
			"routeRemarks" => $routeRemarks,
			"cssErrorTextbox" => $cssErrorTextbox
	) );
	$t->parse ( "Rows", "Row", true );
}
$routeArr = array_unique($routeArr);
$routeFilterStyle = 'display:none;';
if(count($routeArr)>1){
	$routeFilterStyle = '';
	foreach($routeArr as $v) {
		$t->set_var ( array (
				"routeItem" => $v
		) );
		$t->parse ( "RouteRows", "RouteRow", true );
	}
}else{
	$t->set_var( "RouteRows", '');
}
$t->set_var("routeFilterStyle",$routeFilterStyle);
$t->set_var ( "allRowNo", $rsNum - 1 );
$t->pparse ( "Output", "HdIndex" );
?>