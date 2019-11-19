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
$t->set_file ( "HdIndex", "data_merge_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );

if (! empty ( $_POST ['submit'] )) {
	$spl = new SurveyPartList ( $db );
	$spl->delFlag = 'no';
	$spl->refNo = $_POST ['txtRefNo'];
	$spl->routeNo = $_POST ['txtRouteNo'];
	$spl->surDate = $_POST ['txtSurveyDate'];
	$t->set_var ( array (
			"txtRefNo" => $_POST ['txtRefNo'],
			"txtRouteNo" => $_POST ['txtRouteNo'],
			"txtSurveyDate" => $_POST ['txtSurveyDate'],
			"Rows" => "" 
	) );
	$rs = $spl->GetListSearch ();
	$rsNum = count ( $rs );
	for($i = 0; $i < $rsNum; $i ++) {
		if ($i % 2 == 0)
			$listStyle = "AlternatingItemStyle";
		else
			$listStyle = "DgItemStyle";
		$sp = $rs [$i];
		$surFromTime = explode ( ':', $sp->surFromTime );
		$sp->surFromTime = $surFromTime [0] . ":" . $surFromTime [1];
		$surToTime = explode ( ':', $sp->surToTime );
		$sp->surToTime = $surToTime [0] . ":" . $surToTime [1];
		$t->set_var ( array (
				"listStyle" => $listStyle,
				"supaId" => $sp->supaId,
				"refNo" => $sp->refNo,
				"routeNo" => $sp->routeNo,
				"surveyDate" => $sp->surDate,
				"surveyPeriod" => $sp->surFromTime . "-" . $sp->surToTime,
				"location" => $sp->location,
				"bounds" => $sp->bounds,
				"userName" => $sp->userName,
				"type" => $sp->type 
		) );
		$t->parse ( "Rows", "Row", true );
	}
} else {
	$t->set_var ( array (
			"txtRefNo" => "",
			"txtRouteNo" => "",
			"txtSurveyDate" => "",
			"Rows" => "" 
	) );
}
$t->pparse ( "Output", "HdIndex" );
?>