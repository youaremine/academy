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
$t->set_file ( "HdIndex", "flow_data_detail_entry.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "VEHRow", "VEHRows" );
$t->set_var ( "VEHRows", "" );
$t->set_block ( "HdIndex", "PcfaIdRow", "PcfaIdRows" );
$t->set_var ( "PcfaIdRows", "" );

$fp = new FlowPorject ();
$fp->porjId = 1;

$fpf = new FlowPcuFactor ();
$fpfa = new FlowPcuFactorAccess ( $db );
$rs = $fpfa->GetListSearch ( $fpf );
// var_dump($rs);exit();
$rsNo = count ( $rs );
for($i = 0; $i < $rsNo; $i ++) {
	$fpf = $rs [$i];
	$t->set_var ( array (
			"pcfaId" => $fpf->pcfaId,
			"PCUFactor" => $fpf->PCUFactor 
	) );
	$t->parse ( "PcfaIdRows", "PcfaIdRow", true );
}

// MOVEMENT PART
$fm = new FlowMovement ();
$fma = new FlowMovementAccess ( $db );
$fm->moveId = $_GET ['moveId'];
$detailRsNo = 0;
if ($fm->moveId > 0) {
	$rs = $fma->GetListSearch ( $fm );
	if (count ( $rs ) > 0) {
		$fm = $rs [0];
	}
	$fmd = new FlowMovementDetail ();
	$fmda = new FlowMovementDetailAccess ( $db );
	$fmd->moveId = $fm->moveId;
	$detailRs = $fmda->GetListSearch ( $fmd );
	$detailRsNo = count ( $detailRs );
}
$t->set_var ( array (
		"joinId" => $fm->joinId,
		"moveId" => $fm->moveId,
		"movementChiName" => $fm->chiName,
		"movementPcfaId" => $fm->pcfaId 
) );
// Job Info
$fji = new FlowJobInfo ();
$fjia = new FlowJobInfoAccess ( $db );
$fji->joinId = $fm->joinId;
$rs = $fjia->GetListSearch ( $obj );
$fji = $rs [0];

// MOVEMENT DETAIL PART
if ($detailRsNo > 0) {
	for($i = 0; $i < $detailRsNo; $i ++) {
		$fmd = $detailRs [$i];
		$classRow = "DgItemStyle";
		if ($i % 2 == 0)
			$classRow = "AlternatingItemStyle";
		$t->set_var ( array (
				"classRow" => $classRow,
				"modeId" => $fmd->modeId,
				"i" => $i,
				"startTime" => ToShortTime ( $fmd->startTime ),
				"endTime" => ToShortTime ( $fmd->endTime ) 
		) );
		// 显示隐藏
		for($j = 1; $j <= 25; $j ++) {
			$typeNQuantity = "TYPE" . $j . "Quantity";
			$typeNVEH = "type" . $j . "VEH";
			$classType = "normalFiled";
			if ($fpf->$typeNQuantity <= 0) {
				$classType = "hiddenFiled";
			}
			$t->set_var ( array (
					$typeNVEH => $fmd->$typeNQuantity,
					"classType_" . $j => $classType 
			) );
		}
		$t->parse ( "VEHRows", "VEHRow", true );
	}
} else {// 初始化空白输入
	$priodStartTime = "00:00";
	$priodEndTime = "24:00";
	$intervalMinutes = 15;
	for($i = 0; $i < 97; $i ++) {
		$currTimeMinute = TimeToMinute ( $priodStartTime );
		$startTimeMinute = $currTimeMinute + $intervalMinutes * $i;
		$startTime = MinuteToTime ( $startTimeMinute );
		$endTimeMinute = $currTimeMinute + $intervalMinutes * ($i + 1);
		$endTime = MinuteToTime ( $endTimeMinute );
		$breakTimeMinute = TimeToMinute ( $priodEndTime );
		if ($endTimeMinute > $breakTimeMinute) {
			break;
		}
		$classRow = "DgItemStyle";
		if ($i % 2 == 0)
			$classRow = "AlternatingItemStyle";
		$t->set_var ( array (
				"classRow" => $classRow,
				"modeId" => '',
				"i" => $i,
				"startTime" => $startTime,
				"endTime" => $endTime 
		) );
		// 显示隐藏
		for($j = 1; $j <= 25; $j ++) {
			$typeNQuantity = "TYPE" . $j . "Quantity";
			$typeNVEH = "type" . $j . "VEH";
			$classType = "normalFiled";
			if ($fpf->$typeNQuantity <= 0) {
				$classType = "hiddenFiled";
			}
			$t->set_var ( array (
					$typeNVEH => '',
					"classType_" . $j => $classType 
			) );
		}
		$t->parse ( "VEHRows", "VEHRow", true );
	}
}

$t->pparse ( "Output", "HdIndex" );
?>