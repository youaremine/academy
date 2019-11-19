<?php
/*
 * Header: Create: 2008-02-03 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

if (! empty ( $_POST ['surveyDate'] )) {
	// $surveyTime = array_filter($_POST['surveyTime']);
	// $entryNo = count($surveyTime);
	// print_r($surveyTime);exit();
	// print_r($_POST['surveyTime']);exit();
	$qt = new QuestionairnTaxi ();
	$qta = new QuestionairnTaxiAccess ( $db );
	$qt->survId = $_POST ['survId'];
	$qt->location = $_POST ['location'];
	$qt->district = $_POST ['district'];
	$qt->surveyDate = $_POST ['surveyDate'];
	$qt->weather = $_POST ['weather'];
	$qt->inputTime = date ( $conf ['dateTime'] ['format'] );
	$qt->inputUserId = $_SESSION ['userId'];
	$qt->qutaId = $qta->Add ( $qt );
	
	$qtd = new QuestionairnTaxiDetail ();
	$qtd->qutaId = $qt->qutaId;
	$qtda = new QuestionairnTaxiDetailAccess ();
	$surveyTime = array_filter ( $_POST ['surveyTime'] );
	$entryNo = count ( $surveyTime );
	for($i = 0; $i < $entryNo; $i ++) {
		$qtd->surveyTime = $_POST ['surveyTime'] [$i];
		$qtd->taxiFare = $_POST ['taxiFare'] [$i];
		$qtd->tips = $_POST ['tips'] [$i];
		$qtd->chargeableLuggage = $_POST ['chargeableLuggage'] [$i];
		$qtd->radioCallSurcharge = $_POST ['radioCallSurcharge'] [$i] == "" ? 'no' : 'yes';
		$qtd->tunnelFee = $_POST ['tunnelFee'] [$i];
		$qtd->tunnelSurcharge = $_POST ['tunnelSurcharge'] [$i];
		$qtd->taxiType = $_POST ['taxiType'] [$i];
		$qtd->interceptInterview = $_POST ['interceptInterview'] [$i] == "" ? 'no' : 'yes';
		$qtda->Add ( $qtd );
	}
	$message = "Data was successfully added.";
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
				style="BORDER-RIGHT: #cfcfcf 1px solid; BORDER-TOP: #cfcfcf 1px solid; BORDER-LEFT: #cfcfcf 1px solid; BORDER-BOTTOM: #cfcfcf 1px solid; text-align: left;"
				align="middle" bgColor="#f9f6e7" height="130">
				<p><?php print $message; ?>
	  <br />
					<br />click <a href="questionairn_taxi_entry.php">here</a> to entry
					another sheet. <br />
					<br />click <a href="questionairn_taxi_list.php">here</a> to data
					list.
				</p>
			</td>
		</tr>
	</table>
	<!--<SCRIPT language=javascript>setTimeout('document.location="questionairn_taxi_list.php"',5000)</SCRIPT>-->
</body>
</html>
