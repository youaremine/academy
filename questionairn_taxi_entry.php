<?php
/*
 * Header: Create: 2007-10-17 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "questionairn_taxi_entry.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "EntryRow", "EntryRows" );

// 显示要输入的行数
$t->set_var ( "allRowNo", $conf ['input'] ['rowNumber'] );
for($i = 0; $i < $conf ['input'] ['rowNumber']; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"i" => $i 
	) );
	$t->parse ( "EntryRows", "EntryRow", true );
}
$t->pparse ( "Output", "HdIndex" );
?>