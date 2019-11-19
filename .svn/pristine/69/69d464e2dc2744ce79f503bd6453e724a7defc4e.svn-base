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

// 处理请求
if (! empty ( $_POST ['btnJobSave'] )) {
	$fji = new FlowJobInfo ();
	$fjia = new FlowJobInfoAccess ( $db );
	$fji->joinId = $_POST ['joinId'];
	$fji->porjId = $_POST ['porjId'];
	$fji->jobTitle = $_POST ['jobTitle'];
	$fji->jobNo = $_POST ['jobNo'];
	$fji->surveyDate = $_POST ['surveyDate'];
	$fji->periodStartTime = $_POST ['periodStartTime'];
	$fji->periodEndTime = $_POST ['periodEndTime'];
	$fji->period2StartTime = $_POST ['period2StartTime'];
	$fji->period2EndTime = $_POST ['period2EndTime'];
	$fji->period3StartTime = $_POST ['period3StartTime'];
	$fji->period3EndTime = $_POST ['period3EndTime'];
	if ($fji->joinId == "") {
		$fji->joinId = $fjia->Add ( $fji );
	} else {
		$fjia->Update ( $fji );
	}
	header ( "Location:flow_data_entry.php?joinId=" . $fji->joinId );
}

// 模板设置
$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "flow_data_entry.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "PCUFactorRow", "PCUFactorRows" );
$t->set_block ( "HdIndex", "MovementRow", "MovementRows" );
$t->set_var ( "PCUFactorRows", "" );
$t->set_var ( "MovementRows", "" );

$fp = new FlowPorject ();
$fp->porjId = 1;

$fji = new FlowJobInfo ();
$fjia = new FlowJobInfoAccess ( $db );
$fji->joinId = $_GET ['joinId'];
if ($fji->joinId > 0) {
	$rs = $fjia->GetListSearch ( $fji );
	$rsNo = count ( $rs );
	if ($rsNo > 0) {
		$fji = $rs [0];
	}
}
$t->set_var ( array (
		"joinId" => $fji->joinId,
		"jobTitle" => $fji->jobTitle,
		"jobNo" => $fji->jobNo,
		"surveyDate" => ToShortDate ( $fji->surveyDate ),
		"periodStartTime" => substr ( $fji->periodStartTime, 0, 5 ),
		"periodEndTime" => substr ( $fji->periodEndTime, 0, 5 ),
		"period2StartTime" => substr ( $fji->period2StartTime, 0, 5 ),
		"period2EndTime" => substr ( $fji->period2EndTime, 0, 5 ),
		"period3StartTime" => substr ( $fji->period3StartTime, 0, 5 ),
		"period3EndTime" => substr ( $fji->period3EndTime, 0, 5 ),
		"flowChartTemplate" => $fji->flowChartTemplate 
) );

$t->set_var ( "porjId", $fp->porjId );

$fpf = new FlowPcuFactor ();
$fpfa = new FlowPcuFactorAccess ( $db );
$fpf->porjId = $fp->porjId;
$rs = $fpfa->GetListSearch ( $fpf );
$rsNo = count ( $rs );
$maxColNo = 0;
for($i = 0; $i < $rsNo; $i ++) {
	$fpf = $rs [$i];
	$classRow = "DgItemStyle";
	if ($i % 2 == 0)
		$classRow = "AlternatingItemStyle";
	$t->set_var ( array (
			"classRow" => $classRow,
			"pcfaId" => $fpf->pcfaId,
			"PCUFactor" => $fpf->PCUFactor 
	) );
	// 显示隐藏
	$colNo = 0;
	for($j = 1; $j <= 25; $j ++) {
		$typeNQuantity = "TYPE" . $j . "Quantity";
		$classType = "normalFiled";
		if ($fpf->$typeNQuantity <= 0) {
			$classType = "hiddenFiled";
		} else {
			$colNo = $j;
			if ($j > $maxColNo)
				$maxColNo = $j;
		}
		$t->set_var ( array (
				$typeNQuantity => $fpf->$typeNQuantity,
				"classType_" . $j => $classType 
		) );
	}
	// 如果少列的数，补齐.
	for($j = $colNo + 1; $j <= $maxColNo; $j ++) {
		$typeNQuantity = "TYPE" . $j . "Quantity";
		$classType = "normalFiled";
		$t->set_var ( array (
				$typeNQuantity => $fpf->$typeNQuantity,
				"classType_" . $j => $classType 
		) );
	}
	$t->parse ( "PCUFactorRows", "PCUFactorRow", true );
}
$classPCUFactor = "normalFiled";
if ($rsNo <= 0) {
	$classPCUFactor = "hiddenFiled";
}
$t->set_var ( "classPCUFactor", $classPCUFactor );

// MOVEMENT PART
if ($fji->joinId > 0) {
	$fm = new FlowMovement ();
	$fma = new FlowMovementAccess ( $db );
	$fm->joinId = $fji->joinId;
	$rs = $fma->GetListSearch ( $fm );
	$rsNo = count ( $rs );
	for($i = 0; $i < $rsNo; $i ++) {
		$fm = $rs [$i];
		$classRow = "DgItemStyle";
		if ($i % 2 == 0)
			$classRow = "AlternatingItemStyle";
		
		$edit = "<img src='images/Modify.gif' onclick='OpenWinUpdate(" . $fm->moveId . ");' alt='Edit' width='15' height='15' border='0' style='cursor:pointer;'>";
		$t->set_var ( array (
				"classRow" => $classRow,
				"moveId" => $fm->moveId,
				"movementChiName" => $fm->chiName,
				"movementPcfaId" => $fm->pcfaId,
				"edit" => $edit 
		) );
		$t->parse ( "MovementRows", "MovementRow", true );
	}
}

$t->pparse ( "Output", "HdIndex" );
?>