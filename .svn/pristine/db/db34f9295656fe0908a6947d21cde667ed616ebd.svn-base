<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "data_entry.html" );
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "TypeRow", "TypeRows" );
$t->set_block ( "HdIndex", "InputRow", "InputRows" );
$t->set_block ( "HdIndex", "DistRow", "DistRows" );
$t->set_block ( "HdIndex", "WeatherRow", "WeatherRows" );
$t->set_block ( "HdIndex", "SurveyDateYearRow", "SurveyDateYearRows" );

// 车辆类型
$btl = new BusTypeList ( $db );
$rs = $btl->GetListAll ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$bt = $rs [$i];
	$t->set_var ( array (
			"typeId" => $bt->butyId,
			"typeName" => $bt->engName 
	) );
	$t->parse ( "TypeRows", "TypeRow", true );
}

// 车辆所属区域
$dl = new DistrictList ( $db );
$rs = $dl->GetListSearch ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	$dist = $rs [$i];
	$t->set_var ( array (
			"distCode" => $dist->distCode,
			"distEngName" => $dist->engName 
	) );
	$t->parse ( "DistRows", "DistRow", true );
}

// 天氣
$weathers = getArray ( 'weather' );
foreach ( $weathers as $k => $v ) {
	$t->set_var ( array (
			"weatherId" => $k,
			"weatherName" => $v 
	) );
	$t->parse ( "WeatherRows", "WeatherRow", true );
}

// 調查年份
$currentYear = date ( "Y" );
for($i = 2; $i >= 0; $i --) {
	$surveyDateYearValue = $currentYear - $i;
	$t->set_var ( "surveyDateYearValue", $surveyDateYearValue );
	$t->parse ( "SurveyDateYearRows", "SurveyDateYearRow", true );
}

// 初始化开始时间
$t->set_var ( "startTime", date ( $conf ['dateTime'] ['format'] ) );

// 显示要输入的行数
for($i = 0; $i < $conf ['input'] ['rowNumber']; $i ++) {
	$t->set_var ( "i", $i );
	$t->parse ( "InputRows", "InputRow", true );
}
$t->set_var ( "allRowNo", $conf ['input'] ['rowNumber'] - 1 );
$t->set_var ( "userChiName", $_SESSION ['userChiName'] );
$t->pparse ( "Output", "HdIndex" );
?>