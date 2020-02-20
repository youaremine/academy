<?php
/*
 * Header: Create: 2007-2-13 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsSuperAdministrator ()) {
	// header("Location:login.php");
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "user_entry.html" );
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "DistPartRow", "DistPartRows" );
$t->set_block ( "HdIndex", "RoleRow", "RoleRows" );
$t->set_block ( "HdIndex", "Rowyear", "Rowsyear" );
$t->set_block ( "HdIndex", "DistrictRow", "DistrictRows" );



// 年
for($i = date ( "Y" ); $i <= date ( "Y" ) + 2; $i ++) {
	$t->set_var ( "years", $i );
	$t->parse ( "Rowsyear", "Rowyear", true );
}

// 系統現有的項目
foreach ( $conf ['shortDistrictName'] as $k => $v ) {
	$t->set_var ( array (
			"DistrictCode" => $k,
			"DistrictName" => $v 
	) );
	$t->parse ( "DistrictRows", "DistrictRow", true );
}

// 区域
$dpl = new DistrictPartList ( $db );
$rs = $dpl->GetListSearch ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$dp = $rs [$i];
	$t->set_var ( array (
			"distPartId" => $dp->dipaId,
			"distPartEngName" => $dp->engName 
	) );
	$t->parse ( "DistPartRows", "DistPartRow", true );
}

// 角色
$r = new Role ();
$ra = new RoleAccess ( $db );
$rs = $ra->GetListSearch ( $r );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$r = $rs [$i];
	$t->set_var ( array (
			"RoleId" => $r->roleId,
			"RoleName" => $r->roleName 
	) );
	$t->parse ( "RoleRows", "RoleRow", true );
}

$t->pparse ( "Output", "HdIndex" );
?>