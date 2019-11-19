<?php
include_once ('./includes/config.inc.php');

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$r = new Role();
$r->roleId = $_REQUEST['roleId'];
$r->roleCode = $_REQUEST['roleCode'];
$r->roleName = $_REQUEST['roleName'];
$ra = new RoleAccess($db);
if(empty($r->roleId))
{
	$r->roleId = $ra->Add($r);
}
else 
{
	$ra->Update($r);
}
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
					A. <a href="user_role_update.php?roleId=<?php echo $r->roleId; ?>">繼續更新,请点击这里.(Continues to
						update information, please click here.)</a>
				</p>
				<p style="padding-left: 20px;">
					B. <a href="user_role_list.php">瀏覽列表,请点击这里.(To browse data List, please
						click here.)</a>.
				</p>
				<p>&nbsp;</p>
			</td>
		</tr>
	</table>
</body>
</html>