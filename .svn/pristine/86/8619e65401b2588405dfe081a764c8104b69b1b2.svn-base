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
$t->set_file ( "HdIndex", "data_unmerge_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );

if (! empty ( $_POST ['submit'] )) {
	$spl = new SurveyPartList ( $db );
	$spl->routeNo = $_POST ['txtRouteNo'];
	$spl->surDate = $_POST ['txtSurveyDate'];
	$spl->delFlag = 'no';
	$t->set_var ( array (
			"txtRouteNo" => $_POST ['txtRouteNo'],
			"txtSurveyDate" => $_POST ['txtSurveyDate'],
			"Rows" => "" 
	) );
	$rs = $spl->GetMergedListSearch ();
	$rsNum = count ( $rs );
	for($i = 0; $i < $rsNum; $i ++) {
		if ($i % 2 == 0)
			$listStyle = "AlternatingItemStyle";
		else
			$listStyle = "DgItemStyle";
		$sp = $rs [$i];
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
			"txtRouteNo" => "",
			"txtSurveyDate" => "",
			"Rows" => "" 
	) );
}
$t->pparse ( "Output", "HdIndex" );
?>