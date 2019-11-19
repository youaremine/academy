<?php
/**
 *
 * @author xiao.qiang.wu <jamblues@gmail.com>
 * @version 1.01
 */
include_once ("../includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$action = $_REQUEST ['action'];
$survId = $_REQUEST ['survId'];
$jobNoNew = $_REQUEST ['jobNoNew'];
if (empty ( $jobNoNew )) {
	echo "<script type='text/javascript'>alert('Please select job first.');history.go(-1);</script>";
	exit ();
}
$txtMonth = $_REQUEST ['txtMonth'];

// 调查员基本信息
$sur = new Surveyor ();
$sa = new SurveyorAccess ( $db );
$sur->survId = $survId;
$rs = $sa->GetListSearch ( $sur );
if (! empty ( $rs )) {
	$sur = $rs [0];
}

if ($action == 'assign') {
	$sa->Assign ( $sur, $jobNoNew );
} else if ($action == 'unassign') {
	$sa->UnAssign ( $sur, $jobNoNew );
}

// header("location:surveyor_assign.php?txtMonth={$txtMonth}&survId={$survId}")

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message</title>
<link type="text/css" rel="stylesheet" href="../css/css.css" />
</head>

<body>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<table width="550" border="5" align="center" cellpadding="0"
		cellspacing="0" class="DgBackStyle">
		<tr class="DgHeaderStyle">
			<td align="center"><strong>提交成功(Successfully submitted)!</strong></td>
		</tr>
		<tr>
			<td bgcolor="#FFFFFF">
				<p style="padding-top: 10px;">....................................................................................</p>
				<p style="padding-left: 20px;">
					A. <a
						href="surveyor_assign.php?txtMonth=<?php echo $txtMonth; ?>&survId=<?php echo $survId;?>">繼續委派當前調查員,请点击这里.(Continue
						to assign the surveyor,please click here.)</a>
				</p> <!-- <p style="padding-left:20px;">B. <a href="surveyor_assign.php?txtMonth=<?php echo $txtMonth; ?>&survId=<?php echo $nextSurvId;?>">繼續委派下一個調查員,请点击这里.(Continue to assign the next surveyor,please click here.)</a></p> -->
				<p style="padding-left: 20px;">
					C. <a href="../surveyor_list.php">瀏覽列表,请点击这里.(To browse data List,
						please click here.)</a>.
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
</body>
</html>