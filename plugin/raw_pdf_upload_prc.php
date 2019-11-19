<?php
/*
 * Header: Create: 2009-4-8 Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");
include_once ("../includes/config.plugin.inc.php");

$msrf = new MainScheduleRawFile ();
$msrfa = new MainScheduleRawFileAccess ( $db );
$msrf->msrfId = $_GET ['msrfId'];
$msrf->downloadTimes = '';
$msrf->delFlag = '';
if ($msrf->msrfId <= 0) {
	print "failed";
	exit ();
}
// echo $_SERVER["PHP_SELF"].$_SERVER["QUERY_STRING"]."<br />";
$rs = $msrfa->GetListSearch ( $msrf );
$rsNo = count ( $rs );
$msrf->jobNoNew = $_GET ['jobNoNew'];
$msrf->fileType = $_GET ['fileType'];
$msrf->fileName = $_GET ['fileName'];
$msrf->downloadTimes = $_GET ['downloadTimes'];
$msrf->modifyUserId = $_GET ['modifyUserId'];
$msrf->modifyUsername = $_GET ['modifyUsername'];
$msrf->modifyTime = $_GET ['modifyTime'];
$msrf->delFlag = $_GET ['delFlag'];
if ($rsNo <= 0) {
	$msrfa->AddFull ( $msrf );
	//添加通知消息
	$ma = new MessagesAccess($db);
	$ma->AddNew($msrf->jobNoNew);
} else {
	$msrfa->Update ( $msrf );
}

$msa = new MainScheduleAccess ( $db );
$msa->UpdateOneReceiveDate ( $msrf->jobNoNew, $msrf->modifyTime );

print "success";

?>