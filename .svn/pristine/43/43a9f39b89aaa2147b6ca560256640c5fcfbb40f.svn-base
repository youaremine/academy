<?php
/**
 *
 * @copyright 2007-2013 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2013-10-21
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "flow_chart_to_excel_list.html" );
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
if ($rsNo > 0) {
	$fji = $rs [0];
} else {
	exit ( "沒有找到該項目資料;" );
}

$fm = new FlowMovement ();
$fma = new FlowMovementAccess ( $db );
$fm->joinId = $fji->joinId;
$rs = $fma->GetListSearch ( $fm );
$rsNo = count ( $rs );
if ($rsNo > 0) {
	$fm = $rs [0];
} else {
	exit ( "請先錄入Movement數據;" );
}

// Movment Sheet
$i = 0;
$listStyle = "AlternatingItemStyle";
$i ++;
$excelDown = "<a href=\"to-excel/flow_table_summary_to_excel.php?joinId={$fji->joinId}\"><img src=\"images/excel.jpg\" width=\"15\" height=\"17\" border=\"0\" title=\"Excel下載\" /></a>";
$t->set_var ( array (
		"listStyle" => $listStyle,
		"title" => "Table Summary",
		"excelDown" => $excelDown 
) );
$t->parse ( "Rows", "Row", true );

$listStyle = "DgItemStyle";
$i ++;
$excelDown = "<a href=\"{$fji->flowChartTemplate}\"><img src=\"images/excel.jpg\" width=\"15\" height=\"17\" border=\"0\" title=\"Excel下載\" /></a>";
$t->set_var ( array (
		"listStyle" => $listStyle,
		"title" => "Movement",
		"excelDown" => $excelDown 
) );
$t->parse ( "Rows", "Row", true );

$fmd = new FlowMovementDetail ();
$fmda = new FlowMovementDetailAccess ( $db );
$fmd->moveId = $fm->moveId;
$rs = $fmda->GetListSearch ( $fmd );
foreach ( $rs as $dr ) {
	if ($dr->TYPE1Quantity === NULL)
		continue;
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$i ++;
	$dr->startTime = substr ( $dr->startTime, 0, 5 );
	$excelDown = "<a href=\"to-excel/flow_chart_to_excel.php?joinId={$fji->joinId}&startTime={$dr->startTime}\"><img src=\"images/excel.jpg\" width=\"15\" height=\"17\" border=\"0\" title=\"Excel下載\" /></a>";
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"title" => $dr->startTime,
			"excelDown" => $excelDown 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>