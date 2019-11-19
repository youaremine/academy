<?php
include_once ('./includes/config.inc.php');

// 检查是否登录
if (!UserLogin::IsLogin())
{
	header("Location:login.php");
	exit();
}

// Survey Part
$sp = new SurveyPart($db);
$sp->refNo = $_POST['refNo'];
$sp->weatherId = $_POST['weatherId'];
$surDate = $_POST['surveyDateYear'] . '-' . $_POST['surveyDateMonth'] . '-' . $_POST['surveyDateDay'];
$sp->surDate = date('Y-m-d', strtotime($surDate));
$sp->surFromTime = $_POST['surFromTimeHor'] . ":" . $_POST['surFromTimeMin'];
$sp->surToTime = $_POST['surToTimeHor'] . ":" . $_POST['surToTimeMin'];
$sp->surId = 0;
$sp->busId = $_POST['busId'];
$sp->busStopNo = $_POST['busStopNo'];
$sp->routeNo = $_POST['routeNo'];
$sp->schType = $_POST['schType'];
$sp->schNo = $_POST[$sp->schType];
$sp->busId2 = $_POST['busId2'];
$sp->routeNo2 = $_POST['routeNo2'];
$sp->schType2 = $_POST['schType2'];
$sp->schNo2 = $_POST[$sp->schType2 . "2"];
$sp->location = str_replace("'","\\'",$_POST['location']);
$sp->bounds = str_replace("'","\\'",$_POST['bounds']);
$sp->survId = $_POST['surveyorId'];
$sp->remarks = $_POST['remarks'];
$sp->userId = $_SESSION['userId'];
$sp->userName = $_SESSION['userEngName'];
$supaId = $sp->Save();

// Survey Detail
$sd = new SurveyDetail($db);
$sd->supaId = $supaId;
$sd->userName = $_POST['userName'];
$fleetNo = array_filter($_POST['fleetNo']);
$detailNo = count($fleetNo);
for($i = 0; $i < $detailNo; $i++)
{
	$sd->displayBoard = $_POST['displayBoard'][$i];
	if ($sd->displayBoard == "Other")
	{
		$sd->displayBoard = $_POST['otherDisplayBoard'][$i];
	}
	$sd->skippedStop = $_POST['skippedStop'][$i];
	$sd->fleetNo = $_POST['fleetNo'][$i];
	$sd->pslNo = $_POST['pslNo'][$i];
	$sd->arrivalTime = $_POST['arrivalTimeHor'][$i] . ":" . $_POST['arrivalTimeMin'][$i];
	$sd->departureTime = $_POST['departureTimeHor'][$i] . ":" . $_POST['departureTimeMin'][$i];
	$sd->onArrival = $_POST['onArrival'][$i];
	$sd->setDown = $_POST['setDown'][$i];
	$sd->pickup = $_POST['pickup'][$i];
	$sd->onDept = $_POST['onDept'][$i];
	$sd->leftBehind = $_POST['leftBehind'][$i];
	// $sd->leftRoleFlag = $_POST['leftRoleFlag'][$i]==""?'no':'yes';
	$sd->leftRoleFlag = 'yes';
	$sd->Save();
}

// Add Log
$uh = new UserHistory();
$uha = new UserHistoryAccess($db);
$uh->jobId = $supaId;
$uh->type = 'Monitoring Survey ';
$uh->action = 'Data Entry';
$uh->userId = $_SESSION['userId'];
$uh->startTime = $_POST['startTime'];
$uh->endTime = date($conf['dateTime']['format']);
$uha->Add($uh);

// header('Location:list.php');
// header('Location:survey_to_excel.php?supaId='.$supaId.'&next=list.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message</title>
<link type="text/css" rel="stylesheet" href="css/css.css" />
<style type="text/css">
</style>
</head>

<body>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<table width="450" border="5" align="center" cellpadding="0"
		cellspacing="0" class="DgBackStyle">
		<tr class="DgHeaderStyle">
			<td align="center"><strong>提交成功(Successfully submitted)!</strong></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a href="data_entry.php">繼續錄入其他,请点击这里.(Continues to enter
						others, please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					B. <a href="data_update.php?supaId=<?php print $supaId; ?>">更新,请点击这里.(For
						update information, please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					C. <a href="data_list.php">瀏覽列表,请点击这里.(To browse data List, please
						click here.)</a>.
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
</body>
</html>