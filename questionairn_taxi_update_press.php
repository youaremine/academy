<?php
include_once ('./includes/config.inc.php');

// check this request is true
$qutaId = $_POST ['qutaId'];
if ($qutaId == "") {
	exit ();
}
// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

// Main
$qt = new QuestionairnTaxi ();
$qta = new QuestionairnTaxiAccess ();
$qt->survId = $_POST ['survId'];
$qt->location = $_POST ['location'];
$qt->district = $_POST ['district'];
$qt->surveyDate = $_POST ['surveyDate'];
$qt->weather = $_POST ['weather'];
$qt->modifyTime = date ( $conf ['dateTime'] ['format'] );
$qt->modifyUserId = $_SESSION ['userId'];
$qt->qutaId = $qutaId;
$qta->Update ( $qt );

// Detail
$qtd = new QuestionairnTaxiDetail ();
$qtd->qutaId = $qt->qutaId;
$qtda = new QuestionairnTaxiDetailAccess ( $db );
$detailNo = count ( $_POST ['isUpdate'] );
for($i = 0; $i < $detailNo; $i ++) {
	if ($_POST ['isUpdate'] [$i] == "1") 	// 新增或者更新
	{
		if ($_POST ['surveyTime'] [$i] != "") {
			$qtd->surveyTime = $_POST ['surveyTime'] [$i];
			$qtd->taxiFare = $_POST ['taxiFare'] [$i];
			$qtd->tips = $_POST ['tips'] [$i];
			$qtd->chargeableLuggage = $_POST ['chargeableLuggage'] [$i];
			$qtd->radioCallSurcharge = $_POST ['radioCallSurcharge'] [$i] == "" ? 'no' : 'yes';
			$qtd->tunnelFee = $_POST ['tunnelFee'] [$i];
			$qtd->tunnelSurcharge = $_POST ['tunnelSurcharge'] [$i];
			$qtd->taxiType = $_POST ['taxiType'] [$i];
			$qtd->interceptInterview = $_POST ['interceptInterview'] [$i] == "" ? 'no' : 'yes';
			if ($_POST ['qutdId'] [$i] == "") {
				$qtda->Add ( $qtd );
			} else {
				$qtd->qutdId = $_POST ['qutdId'] [$i];
				$qtda->Update ( $qtd );
			}
		}
	} else if ($_POST ['isDelete'] [$i] == "yes") 	// 删除
	{
		if ($_POST ['qutdId'] [$i] == "") {
			// TODO
			// 未新增的记录，不用操作
		} else {
			$qtd->qutdId = $_POST ['qutdId'] [$i];
			$qtda->RealDel ( $qtd );
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
				style="BORDER-RIGHT: #cfcfcf 1px solid; BORDER-TOP: #cfcfcf 1px solid; BORDER-LEFT: #cfcfcf 1px solid; BORDER-BOTTOM: #cfcfcf 1px solid; text-align: left;"
				align="middle" bgColor="#f9f6e7" height="130">
				<p><?php print $message; ?>
	  <br />
					<br />click <a
						href="questionairn_taxi_update.php?qutaId=<?php print $qutaId;?> ?>">here</a>
					to return front page. <br />
					<br />click <a href="questionairn_taxi_list.php">here</a> to data
					list.
				</p>
			</td>
		</tr>
	</table>
	<!--<SCRIPT language=javascript>setTimeout('document.location="questionairn_taxi_list.php"',5000)</SCRIPT>-->
</body>
</html>
