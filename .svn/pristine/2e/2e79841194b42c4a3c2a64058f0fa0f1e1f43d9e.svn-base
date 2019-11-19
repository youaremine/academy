<?php
/*
 * Header: Create: 2014-8-29 Auther: Xiaoqiang.Wu
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsSuperAdministrator ())
{
	// header("Location:login.php");
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "user_role_update.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

$r = new Role ();
$r->roleId = $_REQUEST ["roleId"];
if (! empty ( $r->roleId ))
{
	$ra = new RoleAccess ( $db );
	$rs = $ra->GetListSearch ( $r );
	$role = $rs [0];
	$t->set_var ( array (
			"roleId" => $role->roleId,
			"roleCode" => $role->roleCode,
			"roleName" => $role->roleName 
	) );
}
else 
{
	$t->set_var ( array (
			"roleId" => "",
			"roleCode" => "",
			"roleName" => ""
	) );
}

$t->pparse ( "Output", "HdIndex" );
?>