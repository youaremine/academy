<?php
/*
 * Header: 
 * Create: 2011-05-10 
 * Auther: James Wu<jamblues@gmail.com>.
 */
include_once ("../includes/config.inc.php");

$oa = new OtherSalaryAccess($db);
$rowNo = count($_POST['surveyorId']);
$searchDate = date("Y-m-d");
$rows = 0;
$survType = "surveyor";
for($i = 0; $i < $rowNo; $i++)
{
	$o = new OtherSalary();
	$o->otId = $_POST['otId'][$i];
	$o->surveyorId = $_POST['surveyorId'][$i];
	$o->surveyorEngName = $_POST['surveyorEngName'][$i];
	$o->projectCode = $_POST['projectCode'][$i];
	$o->projectName = $_POST['projectName'][$i];
	$o->projectName = str_replace("'", "\\'", $o->projectName);
	$o->surveyDate = $_POST['surveyDate'][$i];
	$o->startTime = $_POST['startTime'][$i];
	$o->endTime = $_POST['endTime'][$i];
	$o->restHour = $_POST['restHour'][$i];
	$o->surveyHour = $_POST['surveyHour'][$i];
	$o->hourlyRate = $_POST['hourlyRate'][$i];
	$o->wages = $_POST['wages'][$i];
	$o->transportExpenses = $_POST['transportExpenses'][$i];
	$o->total = $_POST['total'][$i];
	$o->remarks = $_POST['remarks'][$i];
	$o->userId = $_SESSION['userId'];
	$o->userName = $_SESSION['userEngName'];
	$o->inputTime = date($conf['dateTime']['format']);
	$o->modifyTime = date($conf['dateTime']['format']);
	$o->modifyUserId = $_SESSION['userId'];
	$o->modifyUserName = $_SESSION['userEngName'];
	$o->auditStatus = "pending";
	$o->salaryType = $_POST['salaryType'][$i];
	$survType = $o->salaryType;
	if(UserLogin::HasPermission("other_salary_audit"))
		$o->auditStatus = "audited";
	$o->delFlag = $_POST['delFlag'][$i];
	if (empty($o->surveyDate) || empty($o->surveyorId))
		continue;
	$searchDate = $o->surveyDate;
	if ($o->otId == "")
	{
		$message = "數據已經成功添加.";
		$oa->Add($o);
	}
	else
	{
		if(!empty($_POST['isUpdate'][$i]))
		{
			$message = "數據已經成功更改.";
			$oa->Update($o);
		}
	}
	$rows ++;
}
if(empty($message))
{
	$message = "失敗,沒有數據提交!";
}
else 
{
	$message = $rows."條".$message;
}
$searchDateUnix = strtotime($searchDate);
$surveyDateStart = date("Y-m", $searchDateUnix) . "-01";
$surveyDateEndUnix = mktime(0,0,0,date("n",$searchDateUnix)+1,1,date("Y",$searchDateUnix));
$surveyDateEnd = date("Y-m-d",$surveyDateEndUnix);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Message</title>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<table width="450" border="5" align="center" cellpadding="0"
		cellspacing="0" class="DgBackStyle">
		<tr class="DgHeaderStyle">
			<td align="center"><strong><?php echo $message; ?></strong></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a href="other-salary-entry.php?survType=<?php echo $survType;?>">繼續錄入其他,请点击这里.(Continues to
						enter others, please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					B. <a href="other-salary-list.php?sSurveyDateStart=<?php echo $surveyDateStart;?>&sSurveyDateEnd=<?php echo $surveyDateEnd;?>&order=otId">瀏覽列表,请点击这里.(To browse data List,
						please click here.)</a>.
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
</body>
</html>
