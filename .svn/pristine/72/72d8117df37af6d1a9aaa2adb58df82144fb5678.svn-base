<?php
/*
 * Header: Create: 2008-02-23 Auther: Jamblues. M S N: jamblues@gmail.com
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

// InputerTimesheetDetail
$itd = new InputerTimesheetDetail ();
$itda = new InputerTimesheetDetailAccess ( $db );
$itd->intiId = $_POST ['intiId'];
$jobNo = $_POST ['jobNo'];
$entryNo = count ( $jobNo );
for($i = 0; $i < $entryNo; $i ++) {
	$itd->itdeId = $_POST ['itdeId'] [$i];
	if ($_POST ['isUpdate'] [$i] == "1") 	// 新增或者更新
	{
		$itd->jobNo = $_POST ['jobNo'] [$i];
		$itd->purpose = $_POST ['purpose'] [$i];
		$itd->travellingForm = $_POST ['travellingForm'] [$i];
		$itd->travellingTo = $_POST ['travellingTo'] [$i];
		$itd->transportType = $_POST ['transportType'] [$i];
		$itd->transportMoney = $_POST ['transportMoney'] [$i];
		$itd->timeForm = $_POST ['timeFormHor'] [$i] . ":" . $_POST ['timeFormMin'] [$i];
		$itd->timeTo = $_POST ['timeToHor'] [$i] . ":" . $_POST ['timeToMin'] [$i];
		$itd->druation = $_POST ['duration'] [$i];
		$itd->isLunch = $_POST ['isLunch'] [$i] == "" ? 'no' : 'yes';
		if ($itd->jobNo == "" && $itd->timeForm == ":" && $itd->timeTo == ":")
			continue;
		if ($itd->itdeId == "")
			$itda->Add ( $itd );
		else
			$itda->Update ( $itd );
	} else if ($_POST ['isDelete'] [$i] == "yes") 	// 删除
	{
		if ($itd->itdeId != "") {
			$itda->RealDel ( $itd );
		}
	}
}

$message = "Data was successfully updated.";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>message</title>
</head>

<body>
	<table
		style="FONT-SIZE: 12px; WIDTH: 300px; LINE-HEIGHT: 120%; FONT-FAMILY: Tahoma, Georgia; BORDER-COLLAPSE: collapse; HEIGHT: 150px"
		align="center">
		<tr>
			<td
				style="BORDER-RIGHT: #cfcfff 0px solid; BORDER-TOP: #cfcfff 0px solid; BORDER-LEFT: #cfcfff 0px solid; BORDER-BOTTOM: #cfcfff 0px solid; HEIGHT: 20px; BACKGROUND-COLOR: #ada001"
				height="20"><font color=#333333><strong>message</strong></font></td>
		</tr>
		<tr>
			<td
				style="BORDER-RIGHT: #cfcfcf 1px solid; BORDER-TOP: #cfcfcf 1px solid; BORDER-LEFT: #cfcfcf 1px solid; BORDER-BOTTOM: #cfcfcf 1px solid"
				align="middle" bgColor="#f9f6e7" height="130">
				<p><?php print $message; ?></p>
			</td>
		</tr>
	</table>
	<script type="text/javascript">setTimeout('document.location="inputer_timesheet_update.php?intiId=<?php print $itd->intiId; ?>"',5000)</script>
</body>
</html>
