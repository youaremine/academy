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

if (! empty ( $_POST ['inputUserId'] )) {
	// InputerTimesheet
	// Inputer Timesheet Month
	$itm = new InputerTimesheetMonth ();
	$itma = new InputerTimesheetMonthAccess ( $db );
	$itm->itmoId = $_POST ['itmoId'];
	$itm->periodMonth = date ( "Y-m", strtotime ( $_POST ['period'] . "-01" ) ); // $_POST['period'];
	$itm->inputerCode = $_POST ['inputerCode'];
	$itm->inputUserId = $_POST ['inputUserId'];
	$itm->inputTime = $_POST ['inputTime'];
	$itm->modifyUserId = $_SESSION ['userId'];
	$itm->modifyTime = date ( $conf ['dateTime'] ['format'] );
	$itm->durationMonth = $_POST ['durationMonth'];
	$itm->perHourMoney = $_POST ['perHourMoney'];
	$itma->Update ( $itm );
	$message = "Data was successfully updated.";
}

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
				style="BORDER-RIGHT: #cfcfcf 1px solid; BORDER-TOP: #cfcfcf 1px solid; BORDER-LEFT: #cfcfcf 1px solid; BORDER-BOTTOM: #cfcfcf 1px solid;"
				bgColor="#f9f6e7" height="130">
				<p><?php print $message; ?></p>
				<p>
					click <a
						href="inputer_timesheet_detail.php?itmoId=<?php print $itm->itmoId; ?>">here</a>
					to skip it.
				</p>
			</td>
		</tr>
	</table>
	<script type="text/javascript">setTimeout('document.location="inputer_timesheet_detail.php?itmoId=<?php print $itm->itmoId; ?>"',5000)</script>
</body>
</html>
