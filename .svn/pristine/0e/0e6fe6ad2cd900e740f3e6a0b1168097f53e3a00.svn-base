<?php
/*
 * Header: Create: 2014-8-26 Auther: Xiaoqiang.Wu
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsSuperAdministrator ()) {
	// header("Location:login.php");
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "user_role_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );

$r = new Role ();
$ra = new RoleAccess ( $db );
$rs = $ra->GetListSearch ( $r );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$role = $rs [$i];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"roleId" => $role->roleId,
			"roleCode" => $role->roleCode,
			"roleName" => $role->roleName,
			"delete" => $delete 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>