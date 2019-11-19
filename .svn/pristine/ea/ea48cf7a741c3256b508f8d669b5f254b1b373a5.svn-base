<?php
/*
 * Header: Create: 2011-5-9 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
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

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "other-project-list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$q = $_REQUEST ['q'];
$oa = new OtherProjectsAccess ( $db );
$showMessageStyle = 'display:none;';
$message = '';
if ($q == 'add') {
	$opNew = new OtherProjects ();
	$opNew->projectCode = $_REQUEST ["projectCode"];
	$rs = $oa->GetListSearch ( $opNew );
	if (count ( $rs ) > 0) {
		$message = "錯誤:該項目編號(<b>{$opNew->projectCode}</b>)已經存在.";
	} else {
		$opNew->projectName = $_REQUEST ["projectName"];
		$oa->Add ( $opNew );
		$message = "成功添加  <b>{$opNew->projectCode}</b> .";
	}
	$showMessageStyle = '';
}
$t->set_var ( array (
		"showMessageStyle" => $showMessageStyle,
		'message' => $message 
) );

$op = new OtherProjects ();
if ($_GET ["txtProjectCode"] != "") {
	$op->projectCode = $_GET ["txtProjectCode"];
}
if ($_GET ["txtProjectName"] != "") {
	$op->projectName = $_GET ["txtProjectName"];
}
// 设置搜索部分
$t->set_var ( array (
		"txtProjectCode" => $op->projectCode,
		"txtProjectName" => $op->projectName 
) );

$op->order = $order;
$rs = $oa->GetListSearch ( $op );
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$op = $rs [$i];
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"projectCode" => $op->projectCode,
			"projectName" => ExpressReplace ( $op->projectName ),
			"remark" => '' 
	) );
	$t->parse ( "Rows", "Row", true );
}
$t->pparse ( "Output", "HdIndex" );
?>