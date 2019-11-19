<?php
/*
 * Created on 2007-4-17 To change the template for this generated file go to Window - Preferences - PHPeclipse - PHP - Code Templates
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "user_update.html" );
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "DistPartRow", "DistPartRows" );
$t->set_block ( "HdIndex", "RoleRow", "RoleRows" );
$t->set_block ( "HdIndex", "Rowyear", "Rowsyear" );
$t->set_block ( "HdIndex", "Rowmonth", "Rowsmonth" );
$t->set_block ( "HdIndex", "Rowday", "Rowsday" );
$t->set_block ( "HdIndex", "Rowhour", "Rowshour" );
$t->set_block ( "HdIndex", "Rowmin", "Rowsmin" );
$t->set_block ( "HdIndex", "Rowsecond", "Rowssecond" );
$t->set_block ( "HdIndex", "DistrictRow", "DistrictRows" );
$t->set_block ( "HdIndex", "CompanyRow", "CompanyRows" );

if ($_GET ['userId'] == "") {
	header ( "Location:user_list.php" );
	exit ();
}
$ul = new UsersList ( $db );
$ul->userId = $_GET ['userId'];
$rows = $ul->GetListSearch ();
// 日期列表
$time = explode ( " ", $rows [0]->validLoginTime );
$YMD = explode ( "-", $time [0] );
$HMS = explode ( ":", $time [1] );
// 年份时间列表默认值
$t->set_var ( array (
		"year" => $YMD [0],
		"month" => $YMD [1],
		"day" => $YMD [2],
		"hour" => $HMS [0],
		"min" => $HMS [1],
		"second" => $HMS [2],
		"monthName" => ReturnNameByMonth ( $YMD [1] ) 
) );
// 年份时间列表下拉
// 年
for($i = date ( "Y" ) - 3; $i <= date ( "Y" ) + 2; $i ++) {
	if ($i == $YMD [0]) {
		continue;
	} else {
		$t->set_var ( "years", $i );
	}
	$t->parse ( "Rowsyear", "Rowyear", true );
}
// 月
for($i = 1; $i < 13; $i ++) {
	if ($i == $YMD [1]) {
		continue;
	} else {
		$t->set_var ( array (
				"months" => $i,
				"monthsName" => ReturnNameByMonth ( $i ) 
		) );
	}
	$t->parse ( "Rowsmonth", "Rowmonth", true );
}
// 日
for($i = 1; $i < 32; $i ++) {
	if ($i == $YMD [2]) {
		continue;
	} else {
		$t->set_var ( "days", $i );
	}
	$t->parse ( "Rowsday", "Rowday", true );
}
// 小时
for($i = 00; $i < 25; $i ++) {
	if ($i == $HMS [0]) {
		continue;
	} else {
		$t->set_var ( "hours", $i );
	}
	$t->parse ( "Rowshour", "Rowhour", true );
}
// 分钟
for($i = 00; $i < 61; $i ++) {
	if ($i == $HMS [1]) {
		continue;
	} else {
		$t->set_var ( "mins", $i );
	}
	$t->parse ( "Rowsmin", "Rowmin", true );
}
// 秒
for($i = 00; $i < 61; $i ++) {
	if ($i == $HMS [2]) {
		continue;
	} else {
		$t->set_var ( "seconds", $i );
	}
	$t->parse ( "Rowssecond", "Rowsecond", true );
}

if ($rows [0]->sex == 'F') {
	$t->set_var ( array (
			"sex" => 'Female',
			"sexvalue" => 'F',
			"othersex" => 'Male',
			"othersexvalue" => 'M' 
	) );
} else {
	
	$t->set_var ( array (
			"sex" => 'Male',
			"sexvalue" => 'M',
			"othersex" => 'Female',
			"othersexvalue" => 'F' 
	) );
}
// 系統現有的項目
foreach ( $conf ['shortDistrictName'] as $k => $v ) {
	$t->set_var ( array (
			"DistrictCode" => $k,
			"DistrictName" => $v 
	) );
	$t->parse ( "DistrictRows", "DistrictRow", true );
}
// 能做的范围
$tempDoDist = explode ( ",", $rows [0]->doDistrict );
$chkDoDistrict = "";
for($i = 1; $i < count ( $tempDoDist ); $i ++) {
	$chkDoDistrict .= "\$('chkDoDistrict" . $tempDoDist [$i] . "').checked = true;" . "\r\n";
}
$t->set_var ( "chkDoDistrict", $chkDoDistrict );
// 当前用户的角色
$t->set_var ( "currRoleId", $rows [0]->roleId );
// 角色列表
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

// company
$companys = getArray ( 'company' );
foreach ( $companys as $k => $v ) {
	$t->set_var ( array (
			"companyCode" => $k,
			"companyName" => $v 
	) );
	$t->parse ( "CompanyRows", "CompanyRow", true );
}
$t->set_var ( "doCompany", $rows [0]->doCompany );

// 区域
$t->set_var ( array (
		"distPartIdO" => $rows [0]->dipaId,
		"distPartEngNameO" => $rows [0]->distEngName 
) );
$dpl = new DistrictPartList ( $db );
$rs = $dpl->GetListSearch ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$dp = $rs [$i];
	if ($rows [0]->dipaId == $dp->dipaId) {
		continue;
	} else {
		$t->set_var ( array (
				"distPartId" => $dp->dipaId,
				"distPartEngName" => $dp->engName 
		) );
		$t->parse ( "DistPartRows", "DistPartRow", true );
	}
}
// 修改参数
$t->set_var ( array (
		"Name" => $rows [0]->userName,
		"engName" => $rows [0]->engName,
		"chiName" => $rows [0]->chiName,
		"moblie" => $rows [0]->moblie,
		"telephone" => $rows [0]->telephone,
		"Email" => $rows [0]->eMail,
		"home" => $rows [0]->userHome,
		"remark" => $rows [0]->userRemark,
		"password" => $rows [0]->passWord,
		"userId" => $_GET ['userId'] 
) );
$t->pparse ( "Output", "HdIndex" );
?>
