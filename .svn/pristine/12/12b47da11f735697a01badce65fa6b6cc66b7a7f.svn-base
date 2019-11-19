<?php
/*
 * Header: Create: 2007-10-18 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

if (! empty ( $_GET ['butyId'] )) {
	$reg = new Registration ();
	$rega = new RegistrationAccess ( $db );
	$reg->butyId = $_GET ['butyId'];
	$rega->RealDelByButyId ( $reg );
	$message = "Data was successfully deleted.";
} else {
	$message = "Transport Mode is not selected.";
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
			<P><?php print $message; ?></P>
		</td>
	</tr>
</table>
<SCRIPT language=javascript>setTimeout('document.location="registration_list.php"',3000)</SCRIPT>
