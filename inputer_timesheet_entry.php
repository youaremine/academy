<?php
/*
 * Header: Create: 2008-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
$oneDayTime = 86400; // 60*60*24
                     // 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "inputer_timesheet_entry.html" );
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "InputRow", "InputRows" );
$t->set_var ( "InputRows", "" );
$t->set_block ( "HdIndex", "PeriodYearRow", "PeriodYearRows" );
$t->set_var ( "PeriodYearRows", "" );

$currMonth = date ( "m" );
$currYear = date ( "Y" );
for($i = - 1; $i <= 1; $i ++) {
	$t->set_var ( "periodYear", date ( "Y" ) + $i );
	$t->parse ( "PeriodYearRows", "PeriodYearRow", true );
}
$periodYear = date ( "Y" );
$periodMonth = date ( "m" );
$t->set_var ( "defaultPeriodYear", $periodYear );
$t->set_var ( "defaultPeriodMonth", $periodMonth );
$it = new InputerTimesheet ();
$ita = new InputerTimesheetAccess ( $db );
$it->inputUserId = $_SESSION ['userId'];
$it->order = " ORDER BY periodDate DESC LIMIT 1";
$rs = $ita->GetListSearch ( $it );
$rsNo = count ( $rs );
if ($rsNo > 0) {
	$it = $rs [0];
	$it->periodDate = date ( $conf ['date'] ['format'], strtotime ( $it->periodDate ) + $oneDayTime );
	$t->set_var ( "period", $it->periodDate );
} else {
	$t->set_var ( "period", date ( $conf ['date'] ['format'] ) );
}
// inputer infomation
$u = new Users ( $db );
$ul = new UsersList ( $db );
$ul->userId = $_SESSION ['userId'];
$rs = $ul->GetListSearch ();
if (count ( $rs ) > 0) {
	$u = $rs [0];
	$t->set_var ( array (
			"engName" => $u->engName,
			"inputerCode" => $u->userId,
			"inputUserId" => $u->userId,
			"inputPhone" => $u->telephone == "" ? $u->moblie : $u->telephone,
			"inputUserPost" => "" 
	) );
} else {
	exit ();
}

// 最后选择的类型
$selectedReport = "";
$selectedForms = "";
$selectedOffice = "";
$itm = new InputerTimesheetMonth ();
$itma = new InputerTimesheetMonthAccess ( $db );
$itm->periodMonth = $periodYear . '-' . $periodMonth;
$itm->inputerCode = $_SESSION ['userId'];
$itm->order = "ORDER BY itmoId DESC LIMIT 1";
$rs = $itma->GetListSearch ( $itm );
if (count ( $rs ) > 0) {
	// 设置每日信息
	$itm = $rs [0];
	$it = new InputerTimesheet ();
	$ita = new InputerTimesheetAccess ();
	$it->itmoId = $itm->itmoId;
	$it->order = "ORDER BY intiId DESC";
	$rs = $ita->GetListSearch ( $it );
	if (count ( $rs ) > 0) {
		$it = $rs [0];
		// 设置每日详情
		$itd = new InputerTimesheetDetail ();
		$itd->intiId = $it->intiId;
		$itd->isLunch = "";
		$itd->order = "ORDER BY itdeId DESC";
		$itda = new InputerTimesheetDetailAccess ();
		$rsDay = $itda->GetListSearch ( $itd );
		if (count ( $rsDay ) > 0) {
			$itd = $rsDay [0];
			${"selected" . $itd->purpose} = "selected";
		}
	}
}
$t->set_var ( array (
		"selectedReport" => $selectedReport,
		"selectedForms" => $selectedForms,
		"selectedOffice" => $selectedOffice 
) );

// day in month
$dayInMonth = 30;

// 显示要输入的行数
for($i = 0; $i < $dayInMonth; $i ++) {
	$t->set_var ( "i", $i );
	$t->set_var ( "day", $i + 1 );
	$t->parse ( "InputRows", "InputRow", true );
}
$t->set_var ( "allRowNo", $dayInMonth - 1 );

$t->pparse ( "Output", "HdIndex" );
?>