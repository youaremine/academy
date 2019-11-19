<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ('./includes/config.inc.php');

// check this request is true
$fileName = $_GET ['fileName'];
if ($fileName == "") {
	header ( "Location:schedule_list.php" );
	exit ();
}

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
$fileName = $conf ["path"] ["schedule"] . $fileName;
if (file_exists ( $fileName )) {
	unlink ( $fileName );
}
?>
<table
	style="FONT-SIZE: 12px; WIDTH: 300px; LINE-HEIGHT: 120%; FONT-FAMILY: Tahoma, Georgia; BORDER-COLLAPSE: collapse; HEIGHT: 150px"
	align="center">
	<tr>
		<td
			style="BORDER-RIGHT: #cfcfff 0px solid; BORDER-TOP: #cfcfff 0px solid; BORDER-LEFT: #cfcfff 0px solid; BORDER-BOTTOM: #cfcfff 0px solid; HEIGHT: 20px; BACKGROUND-COLOR: #ada001"
			height="20"><FONT color=#333333><STRONG>message</STRONG></FONT></td>
	</tr>
	<tr>
		<td
			style="BORDER-RIGHT: #cfcfcf 1px solid; BORDER-TOP: #cfcfcf 1px solid; BORDER-LEFT: #cfcfcf 1px solid; BORDER-BOTTOM: #cfcfcf 1px solid"
			align="middle" bgColor="#f9f6e7">
			<P>this schedule file is deleted.</P>
		</td>
	</tr>
</table>
<SCRIPT language=javascript>setTimeout('document.location="schedule_list.php";',2500)</SCRIPT>
