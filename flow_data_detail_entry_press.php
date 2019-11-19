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
function IsNullData($str) {
	if ($str == '')
		return 'NULL';
	else
		return $str;
}

// 处理请求
if (! empty ( $_POST ['btnMovementSave'] )) {
	$fm = new FlowMovement ();
	$fma = new FlowMovementAccess ( $db );
	$fm->moveId = $_POST ['moveId'];
	$fm->joinId = $_POST ['joinId'];
	$fm->chiName = $_POST ['movementChiName'];
	$fm->pcfaId = $_POST ['movementPcfaId'];
	$fm->inputUserId = $_SESSION ['userId'];
	$fm->inputTime = date ( $conf ['dateTime'] ['format'] );
	$fm->updateUserId = $_SESSION ['userId'];
	$fm->updateTime = date ( $conf ['dateTime'] ['format'] );
	if ($fm->moveId == "") {
		$fm->moveId = $fma->Add ( $fm );
	} else {
		$fma->Update ( $fm );
	}
	
	// MOVEMENT DETAIL ADD
	$fmd = new FlowMovementDetail ();
	$fmda = new FlowMovementDetailAccess ( $db );
	$fmd->moveId = $fm->moveId;
	$type1VEH = $_POST ['type1VEH'];
	$entryNo = count ( $type1VEH );
	for($i = 0; $i < $entryNo; $i ++) {
		$fmd->moveId = $fm->moveId;
		$fmd->modeId = $_POST ["modeId"] [$i];
		$fmd->startTime = IsNullData ( $_POST ["startTime"] [$i] );
		$fmd->endTime = IsNullData ( $_POST ["endTime"] [$i] );
		$fmd->TYPE1Quantity = IsNullData ( $_POST ["type1VEH"] [$i] );
		$fmd->TYPE2Quantity = IsNullData ( $_POST ["type2VEH"] [$i] );
		$fmd->TYPE3Quantity = IsNullData ( $_POST ["type3VEH"] [$i] );
		$fmd->TYPE4Quantity = IsNullData ( $_POST ["type4VEH"] [$i] );
		$fmd->TYPE5Quantity = IsNullData ( $_POST ["type5VEH"] [$i] );
		$fmd->TYPE6Quantity = IsNullData ( $_POST ["type6VEH"] [$i] );
		$fmd->TYPE7Quantity = IsNullData ( $_POST ["type7VEH"] [$i] );
		$fmd->TYPE8Quantity = IsNullData ( $_POST ["type8VEH"] [$i] );
		$fmd->TYPE9Quantity = IsNullData ( $_POST ["type9VEH"] [$i] );
		$fmd->TYPE10Quantity = IsNullData ( $_POST ["type10VEH"] [$i] );
		$fmd->TYPE11Quantity = IsNullData ( $_POST ["type11VEH"] [$i] );
		$fmd->TYPE12Quantity = IsNullData ( $_POST ["type12VEH"] [$i] );
		$fmd->TYPE13Quantity = IsNullData ( $_POST ["type13VEH"] [$i] );
		$fmd->TYPE14Quantity = IsNullData ( $_POST ["type14VEH"] [$i] );
		$fmd->TYPE15Quantity = IsNullData ( $_POST ["type15VEH"] [$i] );
		$fmd->TYPE16Quantity = IsNullData ( $_POST ["type16VEH"] [$i] );
		$fmd->TYPE17Quantity = IsNullData ( $_POST ["type17VEH"] [$i] );
		$fmd->TYPE18Quantity = IsNullData ( $_POST ["type18VEH"] [$i] );
		$fmd->TYPE19Quantity = IsNullData ( $_POST ["type19VEH"] [$i] );
		$fmd->TYPE20Quantity = IsNullData ( $_POST ["type20VEH"] [$i] );
		$fmd->TYPE21Quantity = IsNullData ( $_POST ["type21VEH"] [$i] );
		$fmd->TYPE22Quantity = IsNullData ( $_POST ["type22VEH"] [$i] );
		$fmd->TYPE23Quantity = IsNullData ( $_POST ["type23VEH"] [$i] );
		$fmd->TYPE24Quantity = IsNullData ( $_POST ["type24VEH"] [$i] );
		$fmd->TYPE25Quantity = IsNullData ( $_POST ["type25VEH"] [$i] );
		
		if ($fmd->modeId == "")
			$fmda->Add ( $fmd );
		else
			$fmda->Update ( $fmd );
	}
	
	// 更新到统计表
	$fmdt = new FlowMovementDetailTotal ();
	$fmdta = new FlowMovementDetailTotalAccess ( $db );
	$fmdt->moveId = $fm->moveId;
	$fmdta->ProcessTotal ( $fmdt );
	$fmdta->CalculateHourTotal ( $fmdt );
	
	// 更新到小时
	
	$message = "數據已經添加成功.";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message</title>
<link type="text/css" rel="stylesheet" href="css/css.css" />
<style type="text/css">
</style>
</head>

<body>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<table width="450" border="5" align="center" cellpadding="0"
		cellspacing="0" class="DgBackStyle">
		<tr class="DgHeaderStyle">
			<td align="center"><strong>提交成功(Successfully submitted)!</strong></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a
						href="flow_data_detail_entry.php?joinId=<?php echo $fm->joinId; ?>">繼續錄入其他,请点击这里.(Continues
						to enter others, please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					B. <a
						href="flow_data_detail_entry.php?moveId=<?php echo $fm->moveId; ?>">更新,请点击这里.(For
						update information, please click here.)</a>
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
</body>
</html>
