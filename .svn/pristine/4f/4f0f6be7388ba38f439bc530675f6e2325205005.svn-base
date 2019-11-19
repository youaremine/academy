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
$t->set_file ( "HdIndex", "inputer_timesheet_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );
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

// if(empty($_GET['periodYear']) || empty($_GET['periodMonth']))
// {
// $periodYear = date("Y");
// $periodMonth = date("m");
// }
// else
// {
// $periodYear = $_GET['periodYear'];
// $periodMonth = $_GET['periodMonth'];
//
// }
$periodYear = $_GET ['periodYear'];
$periodMonth = $_GET ['periodMonth'];
$t->set_var ( "defaultPeriodYear", $periodYear );
$t->set_var ( "defaultPeriodMonth", $periodMonth );

$itm = new InputerTimesheetMonth ();
$itma = new InputerTimesheetMonthAccess ( $db );
if ($periodYear != "") {
	if ($periodMonth != "") {
		$itm->periodMonth = $periodYear . '-' . $periodMonth;
	} else {
		$itm->periodMonthStart = $periodYear . '-' . '01';
		$itm->periodMonthEnd = ($periodYear + 1) . '-' . '01';
	}
}
if (! UserLogin::IsAdministrator ()) {
	$itm->inputUserId = $_SESSION ['userId'];
}
$rs = $itma->GetListSearch ( $itm );
$rsNum = count ( $rs );
$u = new Users ( $db );
$ul = new UsersList ( $db );

for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$itm = $rs [$i];
	$ul->userId = $itm->inputerCode;
	$rsUser = $ul->GetListSearch ();
	if (count ( $rsUser ) > 0) {
		$u = $rsUser [0];
	}
	
	$preview = "<a href=\"inputer_timesheet_detail.php?itmoId=" . $itm->itmoId . "\" ><img src=\"images/Preview.jpg\" width=\"15\" height=\"17\" border=\"0\" alt=\"Preview\"></a>";
	// $modify = "<a href=\"inputer_timesheet_update.php?intiId=".$it->intiId."\"><img src=\"images/Modify.gif\" alt=\"Modify\" width=\"15\" height=\"15\" border=\"0\"></a>";
	// $excelDown = "<a href=\"questionairn_taxi_to_excel.php?qutaId=".$qt->qutaId."\"><img src=\"images/excel.jpg\" alt=\"excel\" width=\"15\" height=\"17\" border=\"0\" title=\"Excel Download\" /></a>";
	// $delete = "<a href=\"questionairn_taxi_del_state.php?qutaId=".$qt->qutaId."\" onclick=\"return confirm('are you sure?')\"><img src=\"images/Delete.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"Delete\" title=\"Delete\" /></a>";
	
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"inputUserId" => $itm->inputerCode,
			"engName" => $u->engName,
			"inputPhone" => $u->moblie,
			"period" => $itm->periodMonth,
			"privew" => $preview,
			"modify" => $modify,
			"excelDown" => $excelDown,
			"delete" => $delete 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>