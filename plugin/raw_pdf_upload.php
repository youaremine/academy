<?php
/*
 * Header: Create: 2009-04-07 Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");
include_once ("../includes/config.plugin.inc.php");

$t = new CacheTemplate ( "../templates/plugin" );
$t->set_file ( "HdIndex", "raw_pdf_upload.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$jobNoNew = $_GET ['jobNoNew'];
$userName = $_GET ['userName'];
$userId = $_GET ['userId'];
if (empty ( $jobNoNew ) || empty ( $userName ) || empty ( $userId )) {
	exit ();
}

$_SESSION ['uploadUsername'] = $userName;
$_SESSION ['uploadUserId'] = $userId;

$msrf = new MainScheduleRawFile ();
$msrfa = new MainScheduleRawFileAccess ( $db );
$msrf->jobNoNew = $jobNoNew;
$rs = $msrfa->GetListSearch ( $msrf );
$rsNo = count ( $rs );
// Style
$onlyReadStyle = "";
$updateStyle = "display:none;";
if ($rsNo > 0) {
	$msrf = $rs [0];
	// 更新远程服务器
	$msrfa->UpdateRomoteData ( $msrf );
	
	$onlyReadStyle = "display:none;";
	$updateStyle = "";
}
$t->set_var ( "onlyReadStyle", $onlyReadStyle );
$t->set_var ( "updateStyle", $updateStyle );
$t->set_var ( "msrf", $msrf->msrf );
$t->set_var ( "jobNoNew", $msrf->jobNoNew );
$t->set_var ( "fileType", $msrf->fileType );
$t->set_var ( "fileName", $msrf->fileName );
$t->set_var ( "downloadTimes", $msrf->downloadTimes );
$t->set_var ( "modifyUserId", $msrf->modifyUserId );
$t->set_var ( "modifyUsername", $msrf->modifyUsername );
$t->set_var ( "modifyTime", $msrf->modifyTime );
$t->set_var ( "delFlag", $msrf->delFlag );
$t->set_var ( "romote_pdf_host", $conf ["plugin"] ["romote_pdf_host"] );

$t->pparse ( "Output", "HdIndex" );
?>