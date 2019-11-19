<?php
/**
 *
 * @copyright 2007-2013 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2014-5-5
 */
include_once ("./includes/config.inc.php");
function ConvertStringToTime($currDay,$str){
	$t = array ();
	switch($str){
		case "fullBusy":
			$t['startTime'] = $currDay . " 00:00";
			$t['endTime'] = $currDay . " 23:59";
	}
}

$sfta = new SurveyorFreeTimeAccess($db);

// delete old data
$survId = $_POST['surveyorCode'];
$currMonth = $_POST["currMonth"];
$startTime = $currMonth . "-01";
$dayCount = date("t",strtotime($startTime));
$endTime = $currMonth . $dayCount . ":23:59:59";
$sfta->RealDelByDate($survId,$startTime,$endTime);

for($i = 1;$i <= $dayCount;$i ++){
	$currDay = $currMonth . "-" . $i;
	$sft = new SurveyorFreeTime();
	$sft->survId = $_POST['surveyorCode'];
	$sft->remarks = $_POST["remarks"][$i];
	if(! empty($_POST["unknow"][$i]))
		continue;
	else if(! empty($_POST["fullBusy"][$i])){
		$sft->startTime = $currDay . " 00:00";
		$sft->endTime = $currDay . " 23:59";
		$sft->isFree = 'busy';
		$sfta->Add($sft);
	}else if(! empty($_POST["fullFree"][$i])){
		$sft->startTime = $currDay . " 00:00";
		$sft->endTime = $currDay . " 23:59";
		$sft->isFree = 'free';
		$sfta->Add($sft);
	}else{
		if(! empty($_POST["am"][$i])){
			$sft->startTime = $currDay . " 06:00";
			$sft->endTime = $currDay . " 12:00";
			$sft->isFree = 'free';
			$sfta->Add($sft);
		}
		if(! empty($_POST["pm"][$i])){
			$sft->startTime = $currDay . " 12:00";
			$sft->endTime = $currDay . " 18:00";
			$sft->isFree = 'free';
			$sfta->Add($sft);
		}
		if(! empty($_POST["night"][$i])){
			$sft->startTime = $currDay . " 18:00";
			$sft->endTime = $currDay . " 23:59";
			$sft->isFree = 'free';
			$sfta->Add($sft);
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
		<?php 
		if(UserLogin::IsAdministrator()) {
		?>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a href="surveyor_calendar.php?surveyorId=<?php echo $_POST['surveyorCode']; ?>">查看日曆,请点击这里.(See my calendar,
						please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					B. <a href="surveyor_list_schedule.php?txtSurvId=<?php echo $_POST['surveyorCode']; ?>">列表查詢,请点击这里.(To browse profile,
						please click here.)</a>.
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
		<?php 
		}else{
		?>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a href="surveyor_calendar.php">查看日曆,请点击这里.(See my calendar,
						please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					B. <a href="surveyor_profile.php">帳單查詢,请点击这里.(To browse profile,
						please click here.)</a>.
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
		<?php 
		}
		?>
	</table>
</body>
</html>