<?php
/*
 * Header: Create: 2007-10-18 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! SurveyorLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

if (! empty ( $_POST ['chkJobNoNew'] )) {
	$sms = new SurveyorMainSchedule ();
	$smsa = new SurveyorMainScheduleAccess ( $db );
	$sms->survId = SurveyorLogin::GetLoginId ();
	foreach ( $_POST ['chkJobNoNew'] as $k => $v ) {
		$sms->jobNoNew = $v;
		$smsa->Add ( $sms );
	}
	$message = "你已經成功認領你的Job.";
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
				style="BORDER-RIGHT: #cfcfff 0px solid; BORDER-TOP: #cfcfff 0px solid; BORDER-LEFT: #cfcfff 0px solid; BORDER-BOTTOM: #cfcfff 0px solid; HEIGHT: 20px; BACKGROUND-COLOR: #ada001">
				<FONT color=#333333><STRONG>message</STRONG></FONT>
			</td>
		</tr>
		<tr>
			<td
				style="BORDER-RIGHT: #cfcfcf 1px solid; BORDER-TOP: #cfcfcf 1px solid; BORDER-LEFT: #cfcfcf 1px solid; BORDER-BOTTOM: #cfcfcf 1px solid; HEIGHT: 130px;"
				align="middle" bgColor="#f9f6e7">
				<p><?php print $message; ?></p>
			</td>
		</tr>
	</table>
	<script language="javascript">setTimeout('document.location="<?php print $_SERVER["HTTP_REFERER"]; ?>"',3000)</script>
</body>
</html>