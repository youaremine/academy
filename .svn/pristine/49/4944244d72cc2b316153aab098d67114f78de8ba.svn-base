<?php
/*
 * Header: Create: 2011-10-09 Auther: Jamblues<jamblues@gmail.com>.
 */
include_once ("../includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "../templates/assign" );
$t->set_file ( "HdIndex", "surveyor_time.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

if ($_REQUEST ["txtMonth"] != "") {
	$txtMonth = $_REQUEST ["txtMonth"];
} else {
	$txtMonth = date ( "Y-m" );
}
$monthStartDate = $txtMonth . "-01";
$startDayTime = strtotime ( $monthStartDate );
$endDayTime = mktime ( 0, 0, 0, date ( "m", $startDayTime ) + 1, 0, date ( "Y", $startDayTime ) );
$monthEndDate = date ( $conf ['date'] ['format'], $endDayTime );

$t->set_var ( array (
		"txtMonth" => $txtMonth,
		"monthStartDate" => $monthStartDate,
		"monthEndDate" => $monthEndDate 
) );

// 调查员基本信息
$sur = new Surveyor ();
$sa = new SurveyorAccess ( $db );
$sur->survId = $_GET ["survId"];
$rs = $sa->GetListSearch ( $sur );
if (! empty ( $rs )) {
	$surCurr = $rs [0];
	$t->set_var ( array (
			"survId" => $surCurr->survId,
			"engName" => $surCurr->engName,
			"contact" => $surCurr->contact,
			"survHome" => $surCurr->survHome,
			"dipaCode" => $surCurr->dipaCode,
			"IsSupervisor" => $surCurr->IsSupervisor,
			"VIP" => $surCurr->VIP,
			"whatsAPP" => $surCurr->whatsAPP,
			"email" => $surCurr->email,
			"fax" => $surCurr->fax,
			"remark" => $surCurr->remark 
	) );
}

$sur->startTime = $monthStartDate;
$sur->endTime = $monthEndDate . " 23:59:59";
$rs = $sa->GetTimeListSearch ( $sur );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$preview = "";
	$sur = $rs [$i];
	$isFree = $sur->isFree == "busy" ? "<span style='color:red;'>busy</span>" : 'free';
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"survId" => $sur->survId,
			"engName" => $sur->engName,
			"contact" => $sur->contact,
			"survHome" => $sur->survHome,
			"dipaCode" => $sur->dipaCode,
			"IsSupervisor" => $sur->IsSupervisor,
			"remark" => $sur->remark,
			"sftiId" => $sur->sftiId,
			"startTime" => $sur->startTime,
			"endTime" => $sur->endTime,
			"isFree" => $isFree,
			"freeTimeRemarks" => $sur->freeTimeRemarks 
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>