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
$t->set_file ( "HdIndex", "inputer_timesheet_update.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "InputRow", "InputRows" );
$t->set_var ( "InputRows", "" );

$it = new InputerTimesheet ();
$it->intiId = $_GET ['intiId'];
$ita = new InputerTimesheetAccess ( $db );
$rs = $ita->GetListSearch ( $it );
$rsNum = count ( $rs );
$u = new Users ( $db );
$ul = new UsersList ( $db );

if ($rsNum > 0) {
	$it = $rs [0];
	$ul->userId = $it->inputUserId;
	$rsUser = $ul->GetListSearch ();
	if (count ( $rsUser ) > 0) {
		$u = $rsUser [0];
	}
	$t->set_var ( array (
			"inputerCode" => $it->inputUserId,
			"intiId" => $it->intiId,
			"engName" => $u->engName,
			"inputPhone" => $u->moblie,
			"inputUserPost" => "",
			"period" => $it->periodDate 
	) );
}

// 是否管理员
$perHourMoneyStyle = "";
if (! UserLogin::IsAdministrator ()) {
	$perHourMoneyStyle = "display:none;";
}
$t->set_var ( "perHourMoneyStyle", $perHourMoneyStyle );
// 是否是自己录入的
$isOwnerStyle = "";
if ($it->inputUserId != $_SESSION ['userId']) {
	$isOwnerStyle = "display:none;";
}
$t->set_var ( "isOwnerStyle", $isOwnerStyle );

// 详情
$itd = new InputerTimesheetDetail ();
$itd->intiId = $it->intiId;
$itd->isLunch = "";
$itda = new InputerTimesheetDetailAccess ( $db );
$rs = $itda->GetListSearch ( $itd );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	$itd = $rs [$i];
	${"selected" . $itd->purpose} = "selected";
	$t->set_var ( array (
			"inputDate" => $itd->inputDate,
			"itdeId" => $itd->itdeId,
			"i" => $i,
			"day" => $i + 1,
			"jobNo" => $itd->jobNo,
			"selectedReport" => $selectedReport,
			"selectedForms" => $selectedForms,
			"selectedOffice" => $selectedOffice,
			"travellingForm" => $itd->travellingForm,
			"travellingTo" => $itd->travellingTo,
			"transportType" => $itd->transportType,
			"transportMoney" => $itd->transportMoney,
			"timeFormHor" => GetHourPart ( $itd->timeForm ),
			"timeFormMin" => GetMinutePart ( $itd->timeForm ),
			"timeToHor" => GetHourPart ( $itd->timeTo ),
			"timeToMin" => GetMinutePart ( $itd->timeTo ),
			"druation" => $itd->druation,
			"isLunch" => $itd->isLunch == "yes" ? 'checked' : '' 
	) );
	$t->parse ( "InputRows", "InputRow", true );
}

// day in month
$dayInMonth = 31;

// 显示要输入的行数
for($i = $rsNo; $i < $dayInMonth; $i ++) {
	$t->set_var ( array (
			"inputDate" => "",
			"itdeId" => "",
			"i" => $i,
			"day" => $i + 1,
			"jobNo" => "",
			"selectedReport" => "",
			"selectedForms" => "",
			"selectedOffice" => "",
			"travellingForm" => "",
			"travellingTo" => "",
			"transportType" => "",
			"transportMoney" => "",
			"timeFormHor" => "",
			"timeFormMin" => "",
			"timeToHor" => "",
			"timeToMin" => "",
			"druation" => "",
			"isLunch" => "" 
	) );
	$t->parse ( "InputRows", "InputRow", true );
}

$t->pparse ( "Output", "HdIndex" );
?>