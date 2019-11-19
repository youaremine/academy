<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
// 检查是否登�?
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>DefaultRight</title>
<meta content="JavaScript" name="vs_defaultClientScript">
<meta content="http://schemas.microsoft.com/intellisense/ie5"
	name="vs_targetSchema">
<LINK href="css/css.css" type="text/css" rel="stylesheet">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</HEAD>
<body bottomMargin="0" leftMargin="0" topMargin="0" rightMargin="0"
	MS_POSITIONING="GridLayout">
	<img src="images/background.jpg" alt="Suvery System">
</body>
</HTML>
