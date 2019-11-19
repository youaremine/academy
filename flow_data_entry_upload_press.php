<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
$joinId = $_REQUEST ['fileJoinId'];
$jobNo = $_REQUEST ['fileJobNo'];
// 上传文件
$uploadfile = $conf ["path"] ["flowChartTemplate"] . $jobNo . "-" . $joinId . "." . fileext ( $_FILES ['flowChartTemplate'] ['name'] );

$message = "";
if (move_uploaded_file ( $_FILES ['flowChartTemplate'] ['tmp_name'], $uploadfile )) {
	chmod ( $uploadfile, 0777 );
	$message = "File was successfully uploaded.";
	// 保存到数据库
	$fji = new FlowJobInfo ();
	$fjia = new FlowJobInfoAccess ( $db );
	$fji->joinId = $joinId;
	$rs = $fjia->GetListSearch ( $fji );
	$fji = $rs [0];
	;
	$fji->flowChartTemplate = $uploadfile;
	$fji->updateUserId = $_SESSION ['userId'];
	$fji->updateTime = date ( $conf ['dateTime'] ['format'] );
	$fjia->Update ( $fji );
} else {
	$message = "Possible file upload attack!";
}

// print "{success:true,msg:'file name:".$_FILES['fileName']['name']."'}";exit();
print "{success:true,msg:'" . $message . "',flowChartTemplate:'" . $uploadfile . "'}";
exit ();

?>