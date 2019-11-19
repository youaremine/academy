<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
<HEAD>
<title>DefaultTop</title>
<meta content="Microsoft Visual Studio 7.0" name="GENERATOR">
<meta content="C#" name="CODE_LANGUAGE">
<meta content="JavaScript" name="vs_defaultClientScript">
<meta content="http://schemas.microsoft.com/intellisense/ie5"
	name="vs_targetSchema">
<script>
			function Show()
			{
				var TabHide;
				var TabShow;
				TabHide=eval("document.getElementById('TabHide')");
				TabHide.style.display="";
				TabHide.style.visibility="visible";
				TabShow=eval("document.getElementById('TabShow')");
				TabShow.style.display="none";
				TabShow.style.visibility="Hidden";
				parent.AllFrame.rows="43,*";
			}
			function Hide()
			{
				var TabHide;
				var TabShow;
				TabHide=eval("document.getElementById('TabHide')");
				TabHide.style.display="none";
				TabHide.style.visibility="hidden";
				TabShow=eval("document.getElementById('TabShow')");
				TabShow.style.display="";
				TabShow.style.visibility="visible";
				parent.AllFrame.rows="16,*";
				
			}
			
			function OpenWin(WinName)
			{
				var width=screen.width-10;
				var height=screen.height-80;
				window.open(WinName,'Report','top=0px,left=0px,width='+width+',height='+height+',scrollbars=yes,toolbars=no');
			}
			
			function ShowMenu()
			{
				parent.MainPartFrame.cols="150,*";
				document.getElementById('showMenu').style.display = "none";
				document.getElementById('hideMenu').style.display = "";
			}
			
			function HideMenu()
			{
				parent.MainPartFrame.cols="0,*";
				document.getElementById('showMenu').style.display = "";
				document.getElementById('hideMenu').style.display = "none";
			}
			
		</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</HEAD>
<body bottomMargin="0" leftMargin="0" topMargin="0" onLoad=""
	rightMargin="0" MS_POSITIONING="GridLayout">
	<table id="TabShow" style="display: none; cursor: pointer;"
		cellSpacing="0" cellPadding="0" width="100%" bgColor="#019192"
		border="0">
		<tr>
			<td onClick="javascript:Show()" vAlign="top" align="center"><img
				src="images/ArrorDown.gif"></td>
		</tr>
		<tr>
			<td style="height: 3px; background-color: #B2B2B2;"></td>
		</tr>
	</table>
	<table class="TableNone" id="TabHide" cellSpacing="0" cellPadding="0"
		width="100%" border="0">
		<tr style="background-color: #019192;">
			<td width="106" valign="middle" align="left">&nbsp;&nbsp;
				<a id="showMenu" style="display: none;" href="javascript:ShowMenu();">顯示菜單</a>
				<a id="hideMenu" href="javascript:HideMenu();">隱藏菜單</a></td>
			<td width="30"><a target="_top" href="index.php"><img
					src="images/home.png" border="0" width="36" height="36" alt="Home"></a></td>
			<td width="10" valign="middle" align="right">&nbsp;</td>
			<td width="665" valign="middle"
				style="color: #ffffff; font-family: Arial, Helvetica, sans-serif;"><img
				src="images/user.png" width="32" height="32" alt="User"><?php print $_SESSION['userChiName'];?></td>
			<td width="400" align="right" valign="bottom">
				<table class="Tablenone" cellpadding="0" cellspacing="0" border="0"
					width="100%" height="100%">
					<tr>
						<td id="ShowDate" vAlign="bottom" align="right">&nbsp;</td>
						<td width="5"></td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="bottom" style="CURSOR: hand"
							onClick="javascript:Hide()" title="Hidden This"><img
							src="images/ArrorUp.gif" border="0"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="5" style="height: 3px; background-color: #B2B2B2;"></td>
		</tr>
	</table>
</body>
</HTML>
