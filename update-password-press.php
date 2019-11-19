<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
include_once ('./includes/config.inc.php');

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$ul = new UsersList ( $db );
$ul->userId = $_SESSION ['userId'];
$rs = $ul->GetListSearch ();
$user = $rs [0];

$txtNewPassword = trim ( $_REQUEST ['txtNewPassword'] );
if ($txtNewPassword == "") {
	$message = "密碼不允許為空.";
	$toUrl = "update-password.php";
} else if ($txtNewPassword == $user->passWord) {
	$message = "不能和舊密碼一樣.";
	$toUrl = "update-password.php";
} else {
	$ul = new UserLogin ( $db );
	$ul->UpdatePassword ( $txtNewPassword );
	$message = "密碼修改成功.";
	$toUrl = "index.php";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Message</title>
<script type="text/javascript">
alert("<?php echo $message;?>");
document.location="<?php echo $toUrl;?>";
</script>
</head>

<body>
</body>
</html>