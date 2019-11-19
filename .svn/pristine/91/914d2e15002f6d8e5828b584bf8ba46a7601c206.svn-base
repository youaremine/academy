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
$t->set_file ( "HdIndex", "questionairn_taxi_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$qt = new QuestionairnTaxi ();
$qta = new QuestionairnTaxiAccess ( $db );

$rs = $qta->GetListSearch ( $qt );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$qt = $rs [$i];
	// $preview = "<a href=\"questionairn_taxi_preview.php?qutaId=".$qt->qutaId."\" target=\"_blank\"><img src=\"images/Preview.jpg\" width=\"15\" height=\"17\" border=\"0\" alt=\"Preview\">";
	$modify = "<a href=\"questionairn_taxi_update.php?qutaId=" . $qt->qutaId . "\"><img src=\"images/Modify.gif\" alt=\"Modify\" width=\"15\" height=\"15\" border=\"0\"></a>";
	$excelDown = "<a href=\"questionairn_taxi_to_excel.php?qutaId=" . $qt->qutaId . "\"><img src=\"images/excel.jpg\" alt=\"excel\" width=\"15\" height=\"17\" border=\"0\" title=\"Excel Download\" /></a>";
	// $delete = "<a href=\"questionairn_taxi_del_state.php?qutaId=".$qt->qutaId."\" onclick=\"return confirm('are you sure?')\"><img src=\"images/Delete.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"Delete\" title=\"Delete\" /></a>";
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"location" => $qt->location,
			"district" => $qt->district,
			"weather" => $qt->weather,
			"surveyDate" => $qt->surveyDate,
			"survId" => $qt->survId,
			"privew" => $preview,
			"modify" => $modify,
			"excelDown" => $excelDown,
			"delete" => $delete 
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>