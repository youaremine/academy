<?php
include_once ('./includes/config.inc.php');

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$rp = new RolePermission();
$rpa = new RolePermissionAccess($db);
$rp->roleId = $_REQUEST ['roleId'];
$rpa->RealDel($rp);//刪除之前的權限
$permIds = $_REQUEST ['permId'];
foreach ($permIds as $v)
{
	$rp->permId = $v;
	$rpa->Add($rp);
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
					A. <a href="user_role_relationship.php?roleId=<?php echo $rp->roleId; ?>">繼續更新,请点击这里.(Continues to
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