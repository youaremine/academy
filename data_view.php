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
$t->set_file ( "HdIndex", "data_view.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );

$spl = new SurveyPartList ( $db );
$spl->supaId = $_GET ['supaId'];
$rs = $spl->GetListSearch ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$sp = $rs [$i];
	$surFromTime = explode ( ':', $sp->surFromTime );
	$surFromTimeHor = $surFromTime [0];
	$surFromTimeMin = $surFromTime [1];
	
	$surToTime = explode ( ':', $sp->surToTime );
	$surToTimeHor = $surToTime [0];
	$surToTimeMin = $surToTime [1];
	$weathers = getArray ( 'weather' );
	$weatherName = $weathers [$sp->weatherId];
	$weatherStyle = "display:none;";
	// 只有 NT 顯示"天氣".
	if (strtoupper ( substr ( $sp->refNo, 0, 1 ) ) == "N") {
		$weatherStyle = "";
	}
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"refNo" => $sp->refNo,
			"weatherStyle" => $weatherStyle,
			"weatherName" => $weatherName,
			"routeNo" => $sp->routeNo,
			"surDate" => $sp->surDate,
			"surFromTimeHor" => $surFromTimeHor,
			"surFromTimeMin" => $surFromTimeMin,
			"surToTimeHor" => $surToTimeHor,
			"surToTimeMin" => $surToTimeMin,
			"location" => $sp->location,
			"bounds" => $sp->bounds,
			"userName" => $sp->userName 
	) );
}
// 只读用户不显示输入员名称
$inputUserCol = "";
if (UserLogin::IsReadOnly ()) {
	$inputUserCol = "display:none;";
}

// 管理员/组长 可以copy数据
$copyFunction = "";
if (UserLogin::IsAdministrator () || UserLogin::IsSupervisor ()) {
	$copyFunction = "<a href=\"survey_part_copy_press.php?supaId=" . $_GET ['supaId'] . "\" onclick=\"return confirm('are you sure?')\">copy this</a>";
}

$t->set_var ( array (
		"inputUserCol" => $inputUserCol,
		"copyFunction" => $copyFunction 
) );

// row
$sdl = new SurveyDetailList ( $db );
$sdl->supaId = $_GET ['supaId'];
$rs = $sdl->GetListSearch ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$sd = $rs [$i];
	$arrivalTime = explode ( ':', $sd->arrivalTime );
	$arrivalTimeHor = $arrivalTime [0];
	$arrivalTimeMin = $arrivalTime [1];
	$departureTime = explode ( ':', $sd->departureTime );
	$departureTimeHor = $departureTime [0];
	$departureTimeMin = $departureTime [1];
	$t->set_var ( array (
			"skippedStopFlag" => $sd->skippedStop == 1 ? '*' : '',
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
			"onDept" => $sd->onDept 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>