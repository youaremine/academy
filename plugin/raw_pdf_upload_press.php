<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");
include_once ("../includes/config.plugin.inc.php");

$jobNoNew = $_POST ['jobNoNew'];
$fileType = $_POST ['fileType'];

// 上传文件
$fileName = "../pdf/rawdata/" . $jobNoNew . "_" . $fileType . "." . fileext ( $_FILES ['userfile'] ['name'] );
$uploadfile = $fileName;
// $uploadfile = $conf["path"]["root"].$fileName;

$message = "";
if (move_uploaded_file ( $_FILES ['userfile'] ['tmp_name'], $uploadfile )) {
	$message = "File was successfully uploaded.";
	$msrf = new MainScheduleRawFile ();
	$msrfa = new MainScheduleRawFileAccess ( $db );
	$msrf->jobNoNew = $jobNoNew;
	$msrf->fileType = $fileType;
	$rs = $msrfa->GetListSearch ( $msrf );
	$rsNo = count ( $rs );
	if ($rsNo > 0) {
		$msrf = $rs [0];
		if ($msrf->fileName != $fileName)
			@unlink ( $msrf->fileName );
	}
	$msrf->fileName = $fileName;
	$msrf->modifyTime = date ( $conf ['dateTime'] ['format'] );
	$msrf->modifyUserId = $_SESSION ['uploadUserId'];
	$msrf->modifyUsername = $_SESSION ['uploadUsername'];
	
	if ($msrf->msrfId <= 0)
		$msrf->msrfId = $msrfa->Add ( $msrf );
	else
		$msrfa->Update ( $msrf );
	
	$isUpdateRomote = $msrfa->UpdateRomoteData ( $msrf );
} else {
	$message = "Possible file upload attack!";
}

// print "{success:true,msg:'file name:".$_FILES['fileName']['name']."'}";exit();
print "{success:true,msg:'" . $message . "'}";
exit ();

?>