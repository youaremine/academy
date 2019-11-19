<?php
/*
 * Header: Create: 2013-01-24 Auther: James Wu<jamblues@gmail.com>.
 */
include_once ("./includes/config.inc.php");

if (!empty($_POST['btnSubmit']))
{
	$s = new Surveyor();
	$sa = new SurveyorAccess($db);
	$s->survId = $_POST['survId'];
	$s->upSurvId = $_POST['upSurvId'];
	$s->ozzoCode = $_POST['ozzoCode'];
	$s->chiName = $_POST['chiName'];
	$s->engName = $_POST['engName'];
	$s->contact = $_POST['contact'];
	$s->survHome = $_POST['survHome'];
	$s->dipaCode = $_POST['dipaCode'];
	$s->IsSupervisor = $_POST['IsSupervisor'];
	$s->personalRecord = $_POST['personalRecord'];
	$s->bank = $_POST['bank'];
	$s->accountNo = $_POST['accountNo'];
	$s->VIP = $_POST['VIP'];
	$s->whatsAPP = $_POST['whatsAPP'];
	$s->email = $_POST['email'];
	$s->fax = $_POST['fax'];
	$s->remarks = $_POST['remarks'];
	$s->birthday = $_POST['birthday'];
	$s->company = $_POST['company'];
	$s->survType = $_POST['survType'];
	$s->status = $_POST['status'];
	$s->selfBefore = $_POST['selfBefore'];
	$s->lastYearSurveyTimes = $_POST['lastYearSurveyTimes'];
	$s->inputUserId = $_SESSION['userId'];
	$s->inputTime = date('Y-m-d H:i:s');
	$s->updateUserId = $_SESSION['userId'];
	$s->updateTime = date('Y-m-d H:i:s');
	if ($s->survId == "")
	{
		$surveyId = $sa->IsExist($s);
		if ($surveyId > 0)
		{
			$isExist = true;
		}
		else
		{
			$s->survId = $sa->Add($s);
		}
	}
	else
	{
		$sa->Update($s);
	}
	// 同步到其他数据库
	// $oldDb = $conf["oldDbConnectStr"]["BusSurvey"]["dataBase"];
	// $currDb = $conf["dbConnectStr"]["BusSurvey"]["dataBase"];
	// $sa->InsertAdd($oldDb, $currDb, $s);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message</title>
<link type="text/css" rel="stylesheet" href="css/css.css" />
</head>

<body>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
<?php
if ($isExist)
{
	?>
<table width="450" border="5" align="center" cellpadding="0"
		cellspacing="0" class="DgBackStyle">
		<tr class="DgHeaderStyle">
			<td align="center"><strong style="color:red;">提交失败(Failed submitted)!</strong></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-left: 20px;">該學員已存在,學員編號為:<strong><?php echo $surveyId;?></strong></p>
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a href="javascript:history.go(-1);">请点击这里修改.(Surveyor is exist,
						please click here to update.)</a>
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
<?php
}
else
{
	?>
<table width="450" border="5" align="center" cellpadding="0"
		cellspacing="0" class="DgBackStyle">
		<tr class="DgHeaderStyle">
			<td align="center"><strong>提交成功(Successfully submitted)!</strong></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-left: 20px;">學員(<?php echo $s->engName;?>)編號為:<strong><?php echo $s->survId;?></strong></p>
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a href="surveyor_entry.php">繼續錄入其他,请点击这里.(Continues to enter
						others, please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					B. <a href="surveyor_entry.php?survId=<?php echo $s->survId;?>">更新,请点击这里.(For
						update information, please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					C. <a href="surveyor_list.php">瀏覽列表,请点击这里.(To browse data List,
						please click here.)</a>.
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
<?php
}
?>
</body>
</html>