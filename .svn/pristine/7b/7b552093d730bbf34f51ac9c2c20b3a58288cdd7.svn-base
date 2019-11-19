<?php
/*
 * Header: Create: 2007-02-23 Auther: Jamblues. M S N: jamblues@gmail.com
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.flow.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "flow_data_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$fji = new FlowJobInfo ();
$fjia = new FlowJobInfoAccess ( $db );
$fji->joinId = $_GET ['joinId'];
$rs = $fjia->GetListSearch ( $fji );
$rsNo = count ( $rs );

for($i = 0; $i < $rsNo; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$fji = $rs [$i];
	
	// $preview = "<a href=\"flow_data_summary.php?joinId=".$fji->joinId."\" ><img src=\"images/Preview.jpg\" width=\"15\" height=\"17\" border=\"0\" alt=\"Preview\"></a>";
	$modify = "<a href=\"flow_data_entry.php?joinId=" . $fji->joinId . "\"><img src=\"images/Modify.gif\" alt=\"Modify\" width=\"15\" height=\"15\" border=\"0\"></a>";
	$excelDown = "<a href=\"to-excel/flow_table_to_excel.php?joinId=" . $fji->joinId . "\"><img src=\"images/excel.jpg\" alt=\"excel\" width=\"15\" height=\"17\" border=\"0\" title=\"Excel Download\" /></a>";
	// $delete = "<a href=\"questionairn_taxi_del_state.php?qutaId=".$qt->qutaId."\" onclick=\"return confirm('are you sure?')\"><img src=\"images/Delete.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"Delete\" title=\"Delete\" /></a>";
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"joinId" => $fji->joinId,
			"jobTitle" => $fji->jobTitle,
			"jobNo" => $fji->jobNo,
			"surveyDate" => ToShortDate ( $fji->surveyDate ),
			"periodStartTime" => $fji->periodStartTime,
			"periodEndTime" => $fji->periodEndTime,
			"privew" => $preview,
			"modify" => $modify,
			"excleDown" => $excelDown 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>