<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("includes/config.inc.php");
if (! UserLogin::IsLogin ()) {
	if (! empty ( $_GET ['keyId'] )) {
		$_SESSION ['keyId'] = $_GET ['keyId'];
	}
	header ( "Location:login.php" );
	exit ();
}

$right = "right.php";
if (!UserLogin::IsReadOnly()) {
	$right = "notification.php";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="css/css.css" type="text/css" rel="stylesheet" />
<title>預訂啦</title>
</head>
<frameset rows="43,*" name="AllFrame" frameborder="NO" border="0"
	framespacing="0">
	<frame src="top.php" id="topFrame" name="topFrame" frameborder="none"
		scrolling="no" noresize>
	<frameset id="MainPartFrame" cols="185,*" framespacing="5"
		frameborder="yes" border="6px" bordercolor="#019192"
		class="DefaultFrameBorder">
		<frame src="left.php" id="leftFrame" name="leftFrame"
			frameborder="yes">
		<frame src="<?php echo $right;?>" name="mainFrame" frameborder="yes"
			scrolling="yes">
	</frameset>
</frameset>
<noframes>
	<body>
	</body>
</noframes>
</html>
