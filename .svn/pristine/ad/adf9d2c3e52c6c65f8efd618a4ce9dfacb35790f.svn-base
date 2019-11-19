<?php
/*
 * Header: Create: 2007-09-23 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// //判断是否在同一个用户组
// $groupId = UserLogin::GetUserGroupId();
// if(!empty($groupId))
// {
// //判断该组是否只有它一个用户登录
// $uo = new UserOnline();
// $uo->groupId = $groupId;
// $uo->order = " ORDER BY activeTime DESC";
// $uo->pageLimit = " LIMIT 1";
// $uoa = new UserOnlineAccess();
// $rows = $uoa->GetListSearch($uo);
// $userId = $rows[0]->userId;
// if($userId != $_SESSION['userId'])
// {
// UserLogin::Logout();
// }
// }

if (UserLogin::IsLogin ()) {
	print "successful";
} else {
	print "failed";
}
?>