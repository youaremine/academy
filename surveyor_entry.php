<?php
/*
 * Header: Create: 2013-01-24 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "surveyor_entry.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "DistPartRow", "DistPartRows" );
$t->set_block ( "HdIndex", "SurvTypeRow", "SurvTypeRows" );
$t->set_block ( "HdIndex", "StatusRow", "StatusRows" );

$s = new Surveyor ();
if (! empty ( $_GET ['survId'] )) {
	$sa = new SurveyorAccess ( $db );
	$s->survId = $_GET ['survId'];
	$s->company = '';
	$s->status = '';
	$rs = $sa->GetListSearch ( $s );
	$s = $rs [0];
	$currentPosition = "學員管理 &gt;&gt;&gt; 修改學員";
} else {
	$s->survType = "surveyor";
	$currentPosition = "學員管理 &gt;&gt;&gt; 新增學員";
}

// 区域
$d = new DistrictPart ();
$da = new DistrictPartAccess ( $db );
$rs = $da->GetListSearch ( $d );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$d = $rs [$i];
	$t->set_var ( array (
			"distPartCode" => $d->dipaCode,
			"distPartEngName" => $d->engName 
	) );
	$t->parse ( "DistPartRows", "DistPartRow", true );
}


// 状态
$surveyorStatus = getArray ( 'surveyor-status' );
foreach ( $surveyorStatus as $k => $v ) {
	$t->set_var ( array (
			"statusCode" => $k,
			"statusName" => $v 
	) );
	$t->parse ( "StatusRows", "StatusRow", true );
}

//类型
$survType = getArray ( 'surveyor-type' );
foreach ( $survType as $k => $v ) {
	$t->set_var ( array (
			"survTypeCode" => $k,
			"survTypeName" => $v
	) );
	$t->parse ( "SurvTypeRows", "SurvTypeRow", true );
}

$t->set_var ( array (
		"currentPosition" => $currentPosition,
		"survId" => $s->survId,
		"upSurvId" => $s->upSurvId,
		"ozzoCode" => $s->ozzoCode,
		"chiName" => $s->chiName,
		"engName" => $s->engName,
		"contact" => $s->contact,
		"survHome" => $s->survHome,
		"dipaCode" => $s->dipaCode,
		"IsSupervisor" => $s->IsSupervisor,
		"personalRecord" => $s->personalRecord,
		"bank" => $s->bank,
		"accountNo" => $s->accountNo,
		"VIP" => $s->VIP,
		"whatsAPP" => $s->whatsAPP,
		"email" => $s->email,
		"fax" => $s->fax,
		"remarks" => $s->remarks,
		"birthday" => $s->birthday,
		"company" => $s->company,
		"survType" => $s->survType,
		"status" => $s->status,
		"selfBefore" => $s->selfBefore,
		"lastYearSurveyTimes" => $s->lastYearSurveyTimes
) );

$t->pparse ( "Output", "HdIndex" );
?>