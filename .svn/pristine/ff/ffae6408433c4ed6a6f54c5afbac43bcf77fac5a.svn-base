<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ('./includes/config.inc.php');

// check this request is true
$supaId = $_GET ['supaId'];
if ($supaId == "") {
	header ( "Location:list.php" );
	exit ();
}

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$sp = new SurveyPart ( $db );
$sp->supaId = $supaId;
$sp->modifyUserId = $_SESSION ['userId'];
$sp->modifyUserName = $_SESSION ['userEngName'];
$sp->modifyTime = date ( $conf ['dateTime'] ['format'] );
$sp->delFlag = 'yes';
$sp->Del ();
// $sp->RealDel();
// header("Location:bus_list.php");
if(!empty($_SERVER['HTTP_REFERER'])){}
$refTemp = explode('?',$_SERVER['HTTP_REFERER']);
$queryString = "";
if(count($refTemp) > 1){
	$queryString = '?'.$refTemp[1];
}

?>
<table style="FONT-SIZE: 12px; WIDTH: 300px; LINE-HEIGHT: 120%; FONT-FAMILY: Tahoma, Georgia; BORDER-COLLAPSE: collapse; HEIGHT: 150px" align="center">
	<tr>
		<td
			style="BORDER-RIGHT: #cfcfff 0px solid; BORDER-TOP: #cfcfff 0px solid; BORDER-LEFT: #cfcfff 0px solid; BORDER-BOTTOM: #cfcfff 0px solid; HEIGHT: 20px; BACKGROUND-COLOR: #ada001"
			height="20"><FONT color=#333333><STRONG>message</STRONG></FONT></td>
	</tr>
	<tr>
		<td
			style="BORDER-RIGHT: #cfcfcf 1px solid; BORDER-TOP: #cfcfcf 1px solid; BORDER-LEFT: #cfcfcf 1px solid; BORDER-BOTTOM: #cfcfcf 1px solid"
			align="middle" bgColor="#f9f6e7">
			<P>this survey data is deleted.</P>
		</td>
	</tr>
</table>
<script type="text/javascript">setTimeout('document.location="data_list.php<?php echo $queryString;?>";',2500)</script>
