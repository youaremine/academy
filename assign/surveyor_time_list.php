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
$t->set_file ( "HdIndex", "surveyor_time_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$sur = new Surveyor ();
if ($_REQUEST ["txtStartTime"] != "") {
	$txtStartTime = $_REQUEST ["txtStartTime"];
} else {
	$txtStartTime = date ( "Y-m" ) . "-01 00:00:00";
}
if ($_REQUEST ["txtEndTime"] != "") {
	$txtEndTime = $_REQUEST ["txtEndTime"];
} else {
	$txtEndTime = date ( $conf ['dateTime'] ['format'], mktime ( 23, 59, 59, date ( "m" ) + 1, - 1, date ( "Y" ) ) );
}
$sur->startTime = $txtStartTime;
$sur->endTime = $txtEndTime;
$sur->order = " ORDER BY startTime";
// 设置搜索部分
$t->set_var ( array (
		"txtStartTime" => $txtStartTime,
		"txtEndTime" => $txtEndTime 
) );
$sa = new SurveyorAccess ( $db );
$rs = $sa->GetTimeListSearch ( $sur );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$sur = $rs [$i];
	$preview = "";
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
			"startTime" => $sur->startTime,
			"endTime" => $sur->endTime,
			"isFree" => $isFree,
			"preview" => $preview 
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>