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
$t->set_file ( "HdIndex", "schedule_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$canDoDistrict = UserLogin::CanDoDistrict ();
if ($canDoDistrict == "") {
	exit ();
}
$files = array ();
$fullFiles = array ();
$fullDistName = array ();
$tempDoDist = explode ( ",", $canDoDistrict );
for($i = 1; $i < count ( $tempDoDist ); $i ++) {
	if ($handle = opendir ( $conf ["path"] ["schedule"] . $tempDoDist [$i] . "/" )) {
		// print $conf["path"]["schedule"].$tempDoDist[$i]."/";
		while ( false !== ($file = readdir ( $handle )) ) {
			if ($file != "." && $file != "..") {
				$files [] = $file;
				$fullFiles [] = $tempDoDist [$i] . "/" . $file;
				$fullDistName [] = GetFullDistCode ( $tempDoDist [$i] );
			}
		}
		closedir ( $handle );
	}
}

$rsNum = count ( $files );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	
	$excelDown = "<a href=\"" . $conf ["path"] ["schedule"] . $fullFiles [$i] . "\"><img src=\"images/excel.jpg\" alt=\"excel\" width=\"15\" height=\"17\" border=\"0\" title=\"Excel Download\" /></a>";
	$delete = "<a href=\"schedule_del_press.php?fileName=" . $files [$i] . "\" onclick=\"return confirm('are you sure?')\"><img src=\"images/Delete.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"Delete\" title=\"Delete\" /></a>";
	if (UserLogin::IsReadOnly ()) {
		$delete = "";
	}
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"scheduleName" => $files [$i],
			"distName" => $fullDistName [$i],
			"excelDown" => $excelDown,
			"delete" => $delete 
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>