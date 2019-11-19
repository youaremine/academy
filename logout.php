<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 退出登录
$ul = new UserLogin ( $db );
$ul->Logout ();
// header("Location:index.php");
print ("<script>parent.location='login.php';</script>") ;
exit ();

?>