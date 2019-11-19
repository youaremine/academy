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
$t->set_file ( "HdIndex", "registration_list.html" );
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "TypeRow", "TypeRows" );
$t->set_var ( "TypeRows", "" );

// 车辆类型
$btl = new BusTypeList ( $db );
$rs = $btl->GetListAll ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	
	$bt = $rs [$i];
	
	$reg = new Registration ();
	$reg->butyId = $bt->butyId;
	$rega = new RegistrationAccess ( $db );
	$rsReg = $rega->GetListSearch ( $reg );
	if (count ( $rsReg ) > 0) {
		$preview = "<a href=\"registration_view.php?butyId=" . $bt->butyId . "\" ><img src=\"images/Preview.jpg\" width=\"15\" height=\"17\" border=\"0\" alt=\"Preview\"></a>";
		$add = "<img src=\"images/AddDisabled.gif\" width=\"15\" height=\"16\" border=\"0\" alt=\"Add data\" title=\"Add data\" />";
		$delete = "<a href=\"registration_delete_press.php?butyId=" . $bt->butyId . "\" onclick=\"return confirm('are you sure?')\"><img src=\"images/Delete.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"Delete\" title=\"Delete\" /></a>";
	} else {
		$preview = "<img src=\"images/PreviewDisabled.jpg\" width=\"15\" height=\"17\" border=\"0\" alt=\"Preview\" />";
		$add = "<a href=\"registration_input.php?butyId=" . $bt->butyId . "\"><img src=\"images/Add.gif\" width=\"15\" height=\"16\" border=\"0\" alt=\"Add data\" title=\"Add data\" /></a>";
		$delete = "<img src=\"images/DeleteDisabled.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"Delete\" title=\"Delete\" />";
	}
	
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"preview" => $preview,
			"add" => $add,
			"delete" => $delete,
			"typeId" => $bt->butyId,
			"typeName" => $bt->engName 
	) );
	$t->parse ( "TypeRows", "TypeRow", true );
}

$t->pparse ( "Output", "HdIndex" );
?>