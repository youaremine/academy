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
$t->set_file ( "HdIndex", "user_role_relationship.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );

$rp = new RolePermission();
$rpa = new RolePermissionAccess($db);
$rp->roleId = $_REQUEST['roleId'];
$rs = $rpa->GetListSearch($rp);
$rsNum = count ( $rs );
$rolePerms = array();
for($i = 0; $i < $rsNum; $i ++) {
	$rp = $rs[$i];
	$rolePerms[$rp->permId] = true;
}


$t->set_var ("roleId" , $rp->roleId);

$p = new Permission();
$pa = new PermissionAccess($db);
$rs = $pa->GetListSearch ( $r );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$perm = $rs [$i];
	$permChecked = "";
	if($rolePerms[$perm->permId])
	{
		$permChecked = "checked=checked";
	}
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"permChecked" => $permChecked,
			"permId" => $perm->permId,
			"permCode" => $perm->permCode,
			"permName" => $perm->permName
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>