<?php
/*
 * Header: Create: 2007-3-21 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "appendixd_survey_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

// rows
$ad = new AppendixD ();
$ada = new AppendixDAccess ( $db );
$rs = $ada->GetListSearch ( $ad );
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$ad = $rs [$i];
	
	//
	$sur = new Surveyor ();
	$sur->survId = $ad->survId;
	$sa = new SurveyorAccess ( $db );
	$rsSurvey = $sa->GetListSearch ( $sur );
	$sur = $rsSurvey [0];
	//
	$preview = "<a href=\"bus_view.php?busId=" . $bus->busId . "\" target=\"_blank\"><img src=\"images/Preview.jpg\" width=\"15\" height=\"17\" border=\"0\" alt=\"Preview\" title=\"Preview\"></a>";
	$modify = "<a href=\"bus_modify.php?busId=" . $bus->busId . "\"><img src=\"images/Modify.gif\" alt=\"Modify\" width=\"15\" height=\"15\" border=\"0\" /></a>";
	$delete = "<a href=\"bus_del_state.php?busId=" . $bus->busId . "\" onclick=\"return confirm('are you sure?')\"><img src=\"images/Delete.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"Delete\" title=\"Delete\" /></a>";
	$excelDown = "<a href=\"appendixd_survey_to_excel.php?appeId=" . $ad->appeId . "\"><img src=\"images/excel.jpg\" alt=\"excel\" width=\"15\" height=\"17\" border=\"0\" title=\"Excel Download\" /></a>";
	
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"number" => $i + 1,
			"surveyDate" => $ad->surveyDate,
			"surveyTime" => $ad->surveyTime,
			"location" => $ad->location,
			"survId" => $sur->engName,
			"excelDown" => $excelDown 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );

?>