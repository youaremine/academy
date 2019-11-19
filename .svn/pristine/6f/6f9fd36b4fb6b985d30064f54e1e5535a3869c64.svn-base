<?php
/*
 * Header: Create: 2008-6-29 Auther: Jamblues@gmail.com.
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.flow.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

// 模板设置
$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "flow_data_summary.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "MovementRow", "MovementRows" );
$t->set_var ( "MovementRows", "" );

$fp = new FlowPorject ();
$fp->porjId = 1;

$fji = new FlowJobInfo ();
$fjia = new FlowJobInfoAccess ( $db );
$fji->joinId = $_GET ['joinId'];

// MOVEMENT PART
$movementRow = array ();
if ($fji->joinId > 0) {
	$fm = new FlowMovement ();
	$fma = new FlowMovementAccess ( $db );
	$fm->joinId = $fji->joinId;
	$rs = $fma->GetListSearch ( $fm );
	$rsNo = count ( $rs );
	$movementDetailTotalRow = array ();
	for($i = 0; $i < $rsNo; $i ++) {
		$fm = $rs [$i];
		$movementDetailTotalRow ["movementChiName"] = $fm->chiName;
		$fmdt = new FlowMovementDetailTotal ();
		$fmdta = new FlowMovementDetailTotalAccess ( $db );
		$fmdt->moveId = $fm->moveId;
		$detailRs = $fmdta->GetListSearch ( $fmdt );
		$detailRsNo = count ( $detailRs );
		for($j = 0; $j < $detailRsNo; $j ++) {
			$fmdt = $detailRs [$j];
			$startTime = ToShortTime ( $fmdt->startTime );
			$movementDetailTotalRow [$j] = $fmdt->totalHourPCUQuantity;
			$movementDetailTotalRow [$j . '_total'] = $fmdt->totalPCUQuantity;
		}
		$movementRow [] = $movementDetailTotalRow;
	}
}

// MOVEMENT TOTAL PART
$movementRowNo = count ( $movementRow );
for($i = 0; $i < $movementRowNo; $i ++) {
	$row = $movementRow [$i];
	$classRow = "DgItemStyle";
	if ($i % 2 == 0)
		$classRow = "AlternatingItemStyle";
	$rowNo = count ( $row );
	for($j = 0; $j < $rowNo; $j ++) {
		$classType = "normalFiled";
		if ($row [$j . '_total'] <= 0) {
			if ($rowTop [$j . '_show'] != true)
				$classType = "hiddenFiled";
		} else {
			$rowTop [$j . '_show'] = true;
		}
		// 控制要显示的列
		$t->set_var ( array (
				"totalHourPCUQuantity_" . $j => $row [$j],
				"classType_" . $j => $classType 
		) );
	}
	$t->set_var ( array (
			"classRow" => $classRow,
			"movementChiName" => $row ['movementChiName'] 
	) );
	$t->parse ( "MovementRows", "MovementRow", true );
}
$classEmptyData = "normalFiled";
if ($movementRowNo <= 0) {
	$classEmptyData = "hiddenFiled";
}
$t->set_var ( "classEmptyData", $classEmptyData );

$t->pparse ( "Output", "HdIndex" );
?>