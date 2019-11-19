<?php
include_once ('./includes/config.inc.php');
include_once ("../library/init.php");
require_once '../library/Spreadsheet/Excel/Reader.php';
function ExpressReplace($str) {
	$str = str_replace ( "'", "\'", $str );
	$str = str_replace ( "\n", " ", $str );
	return $str;
}
// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
// 上传文件位置
// print var_dump($_FILES['fileOtherProjects']);
// exit();
if ($_FILES ['fileOtherProjects'] ['tmp_name'] == "") {
	exit ();
}

$data = new Spreadsheet_Excel_Reader ();
$data->setOutputEncoding ( 'UTF-8' ); // 设置为utf-8
$data->read ( $_FILES ['fileOtherProjects'] ['tmp_name'] );
$oa = new OtherProjectsAccess ( $db );
$oa->EmptyTable ();

for($i = 7; $i <= $data->sheets [0] ['numRows']; $i ++) {
	if ($data->sheets [0] ['cells'] [$i] [1] == '')
		continue;
	$o = new OtherProjects ();
	$o->projectCode = $data->sheets [0] ['cells'] [$i] [1];
	$o->projectName = ExpressReplace ( $data->sheets [0] ['cells'] [$i] [12] );
	$oa->Add ( $o );
}

$url = "";
if ($_GET ["url"] == "") {
	$url = "other-project-search-list.php";
} else {
	$url = $_GET ["url"];
}
header ( "Location:" . $url );
exit ();
