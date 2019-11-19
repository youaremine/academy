<?php
/*
 * Header: Create: 2007-02-23 Auther: Jamblues. M S N: jamblues@gmail.com
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "inputer_timesheet_detail.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "InputRow", "InputRows" );
$t->set_var ( "InputRows", "" );
$t->set_block ( "HdIndex", "MonthRow", "MonthRows" );
$t->set_var ( "MonthRows", "" );

$itm = new InputerTimesheetMonth ();
$itma = new InputerTimesheetMonthAccess ( $db );
$itm->itmoId = $_GET ['itmoId'];
// $itm->periodMonth = $_GET['period'];
// $itm->inputerCode = $_GET['userId'];
$rs = $itma->GetListSearch ( $itm );
$rsNo = count ( $rs );
$u = new Users ( $db );
$ul = new UsersList ( $db );

// 设置头信息
if ($rsNo > 0) {
	$itm = $rs [0];
	$ul->userId = $itm->inputUserId;
	$rsUser = $ul->GetListSearch ();
	if (count ( $rsUser ) > 0) {
		$u = $rsUser [0];
	}
	$t->set_var ( array (
			"itmoId" => $itm->itmoId,
			"inputerCode" => $itm->inputerCode,
			"inputUserId" => $itm->inputUserId,
			"inputTime" => $itm->inputTime,
			"engName" => $u->engName,
			"inputPhone" => $u->moblie,
			"inputUserPost" => "",
			"durationMonth" => $itm->durationMonth,
			"perHourMoney" => $itm->perHourMoney,
			"period" => $itm->periodMonth 
	) );
	$itm->durationMonth = 0;
}

$isOwner = false;
if ($itm->inputUserId == $_SESSION ['userId'])
	$isOwner = true;
	
	// 是否是管理员
if (UserLogin::IsAdministrator ()) {
	$t->set_var ( "canSettingMoney", "" );
} else {
	$t->set_var ( "canSettingMoney", "display:none;" );
}

// 设置每日信息
$it = new InputerTimesheet ();
$ita = new InputerTimesheetAccess ( $db );
$it->itmoId = $itm->itmoId;
$rs = $ita->GetListSearch ( $it );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$it = $rs [$i];
	$durationDay = 0;
	// 设置每日详情
	$itd = new InputerTimesheetDetail ();
	$itd->intiId = $it->intiId;
	$itd->isLunch = "";
	$itda = new InputerTimesheetDetailAccess ();
	$rsDay = $itda->GetListSearch ( $itd );
	$rsDayNo = count ( $rsDay );
	for($j = 0; $j < $rsDayNo; $j ++) {
		$itd = $rsDay [$j];
		$it->durationDay += $itd->druation;
		$t->set_var ( array (
				"listStyle" => $listStyle,
				"no" => $j + 1,
				"jobNo" => $itd->jobNo,
				"purpose" => $itd->purpose,
				"travellingForm" => $itd->travellingForm,
				"travellingTo" => $itd->travellingTo,
				"transportType" => $itd->transportType,
				"transportMoney" => $itd->transportMoney,
				"timeForm" => $itd->timeForm,
				"timeTo" => $itd->timeTo,
				"duration" => $itd->druation,
				"isLunch" => $itd->isLunch == "yes" ? 'checked' : '' 
		) );
		$t->parse ( "InputRows", "InputRow", true );
	}
	$itm->durationMonth += $it->durationDay;
	if ($isOwner)
		$modify = "<a href=\"inputer_timesheet_update.php?intiId=" . $it->intiId . "\"><img src=\"images/Modify.gif\" alt=\"Modify\" width=\"15\" height=\"15\" border=\"0\"></a>";
	$t->set_var ( array (
			"childId" => $i,
			"periodDate" => $it->periodDate,
			"durationDay" => $it->durationDay,
			"modify" => $modify 
	) );
	$t->parse ( "MonthRows", "MonthRow", true );
	$t->set_var ( "InputRows", "" );
}
$t->set_var ( "durationMonth", $itm->durationMonth );
$t->pparse ( "Output", "HdIndex" );
?>