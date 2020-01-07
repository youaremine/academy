<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsSuperAdministrator ()) {
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "user_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );

$user = new Users ( $db );
$ul = new UsersList ( $db );
$ul->delFlag = 'no';
$ul->order = 'ORDER BY US.userId';
$rs = $ul->GetListSearch ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$user = $rs [$i];
	if ($user->validLoginTime < date ( $conf ['dateTime'] ['format'] ))
		$user->validLoginTime = "<label style='color:red; font-weight:bold;'>" . $user->validLoginTime . "</label>";
	$delete = "<a href=\"user_del_press.php?userId=" . $user->userId . "\" onclick=\"return confirm('are you sure \\r\\n delete " . $user->userName . "?')\"><img src=\"images/Delete.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"Delete\" title=\"Delete\" /></a>";
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"userId" => $user->userId,
			"userName" => $user->userName,
			"engName" => $user->engName,
			"chiName" => $user->chiName,
			"mobile" => $user->moblie,
			"roleName" => $user->roleName,
			"validLoginTime" => $user->validLoginTime,
			"loginTimes" => $user->loginTimes,
			"lastLoginTime" => $user->lastLoginTime,
			"delete" => $delete 
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>