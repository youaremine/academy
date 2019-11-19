<?php
/**
 *
 *
 * @create 2011-11-2
 * @author James Wu<jamblues@gmail.com>
 * @version 1.0
 */
include_once ("../includes/config.inc.php");
include_once ("../includes/config.assign.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$survId = $_REQUEST ["hidSurvId"];
$month = $_REQUEST ["hidMonth"];
$startTime1 = $_REQUEST ["txtStartTime1"];
$endTime1 = $_REQUEST ["txtEndTime1"];
$startTime2 = $_REQUEST ["txtStartTime2"];
$endTime2 = $_REQUEST ["txtEndTime2"];
$startTime3 = $_REQUEST ["txtStartTime3"];
$endTime3 = $_REQUEST ["txtEndTime3"];
$startDate = $_REQUEST ["txtStartDate"];
$endDate = $_REQUEST ["txtEndDate"];
$isFree = $_REQUEST ["radIsFree"];
$remarks = $_REQUEST ["txtRemarks"];
$byType = $_REQUEST ["hidByType"];

// 以星期方式選擇
if ($byType == "week") {
	$selectWeek = array ();
	if (empty ( $_REQUEST ["all"] )) {
		if (! empty ( $_REQUEST ["sun"] )) {
			$selectWeek [] = 0;
		}
		if (! empty ( $_REQUEST ["mon"] )) {
			$selectWeek [] = 1;
		}
		if (! empty ( $_REQUEST ["tue"] )) {
			$selectWeek [] = 2;
		}
		if (! empty ( $_REQUEST ["wed"] )) {
			$selectWeek [] = 3;
		}
		if (! empty ( $_REQUEST ["thu"] )) {
			$selectWeek [] = 4;
		}
		if (! empty ( $_REQUEST ["thu"] )) {
			$selectWeek [] = 5;
		}
		if (! empty ( $_REQUEST ["sat"] )) {
			$selectWeek [] = 6;
		}
	} else {
		$selectWeek = array (
				0,
				1,
				2,
				3,
				4,
				5,
				6 
		);
	}
	var_dump ( $_REQUEST );
	if (! empty ( $month ) && ! empty ( $selectWeek )) {
		$startDay = 1;
		$startDayTime = strtotime ( $month . "-01" );
		$endDayTime = mktime ( 0, 0, 0, date ( "m", $startDayTime ) + 1, 0, date ( "Y", $startDayTime ) );
		$endDay = date ( "d", $endDayTime );
		
		$sft = new SurveyorFreeTime ();
		$sft->isFree = $isFree;
		$sfta = new SurveyorFreeTimeAccess ( $db );
		$sft->survId = $survId;
		$sft->remarks = $remarks;
		for($i = $startDay; $i <= $endDay; $i ++) {
			$day = $month . "-" . $i;
			$week = date ( "w", strtotime ( $day ) );
			if (in_array ( $week, $selectWeek )) {
				if (! empty ( $startTime1 ) && ! empty ( $endTime1 )) {
					$sft->startTime = $day . " " . $startTime1;
					$sft->endTime = $day . " " . $endTime1;
					$sfta->Add ( $sft );
				}
				if (! empty ( $startTime2 ) && ! empty ( $endTime2 )) {
					$sft->startTime = $day . " " . $startTime2;
					$sft->endTime = $day . " " . $endTime2;
					$sfta->Add ( $sft );
				}
				if (! empty ( $startTime3 ) && ! empty ( $endTime3 )) {
					$sft->startTime = $day . " " . $startTime3;
					$sft->endTime = $day . " " . $endTime3;
					$sfta->Add ( $sft );
				}
			}
		}
	}
} else // 以日期方式選擇
{
	if (! empty ( $startDate ) && ! empty ( $endDate )) {
		$sft = new SurveyorFreeTime ();
		$sfta = new SurveyorFreeTimeAccess ( $db );
		$sft->survId = $survId;
		$sft->isFree = $isFree;
		$sft->remarks = $remarks;
		if (! empty ( $startTime1 ) && ! empty ( $endTime1 )) {
			$sft->startTime = $startDate . " " . $startTime1;
			$sft->endTime = $endDate . " " . $endTime1;
			$sfta->Add ( $sft );
		}
		if (! empty ( $startTime2 ) && ! empty ( $endTime2 )) {
			$sft->startTime = $startDate . " " . $startTime2;
			$sft->endTime = $endDate . " " . $endTime2;
			$sfta->Add ( $sft );
		}
		if (! empty ( $startTime3 ) && ! empty ( $endTime3 )) {
			$sft->startTime = $startDate . " " . $startTime3;
			$sft->endTime = $endDate . " " . $endTime3;
			$sfta->Add ( $sft );
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message</title>
<link type="text/css" rel="stylesheet" href="../css/css.css" />
</head>

<body>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<table width="650" border="5" align="center" cellpadding="0"
		cellspacing="0" class="DgBackStyle">
		<tr class="DgHeaderStyle">
			<td align="center"><strong>提交成功(Successfully submitted)!</strong></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a href="surveyor_time.php?survId=<?php echo $survId;?>">繼續调整當前調查員时间计划,请点击这里.(Continue
						to adjust the surveyor time plan,please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					B. <a href="javascript:window.close();">关闭窗口,请点击这里.(Close
						window,please click here.)</a>
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
</body>
</html>



