<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.schedule.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	// header("Location:login.php");
	// exit();
}
$refNo = $_POST ['refNo'];
$fileType = $_POST ['fileType'];

// 上传文件
$uploadfile = $conf ["path"] ["report"] . $refNo . "_" . $fileType . "." . fileext ( $_FILES ['userfile'] ['name'] );

$message = "";
if (move_uploaded_file ( $_FILES ['userfile'] ['tmp_name'], $uploadfile )) {
	chmod ( $uploadfile, 0777 );
	$message = "File was successfully uploaded.";
	// 保存到数据库
	$msrf = new MainScheduleReportFile ();
	$msrfa = new MainScheduleReportFileAccess ( $db );
	$msrf->jobNo = $refNo;
	$msrf->fileType = $fileType;
	$rs = $msrfa->GetListSearch ( $msrf );
	$rsNo = count ( $rs );
	$msrf->fileName = $uploadfile;
	$msrf->inputUserId = $_SESSION ['userId'];
	$msrf->inputTime = date ( $conf ['dateTime'] ['format'] );
	if ($rsNo > 0) {
		$msrfe = $rs [0];
		$msrf->msrfId = $msrfe->msrfId;
		if ($msrf->fileName != $msrfe->fileName)
			@unlink ( $msrfe->fileName ); // 删除旧文件
		$msrfa->Update ( $msrf );
	} else {
		$msrf->msrfId = $msrfa->Add ( $msrf );
	}
} else {
	$message = "Possible file upload attack!";
}

// print "{success:true,msg:'file name:".$_FILES['fileName']['name']."'}";exit();
print "{success:true,msg:'" . $message . "'}";
exit ();

?>