<?php
/*
 * Header: Create: 2007-2-13 Auther: Jamblues.
 */
include_once ('./includes/config.inc.php');

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "up_to_date_bar_chart_view.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

//
$i = 0;
foreach ( $conf ['surveytime'] as $k => $v ) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$i ++;
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"complateJobNo" => $k,
			"districtName" => $conf ['districtName'] [$k],
			"survey_start_date" => $conf ['survey_start_date'] [$k],
			"surveytime" => $v 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );

?>