<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	// header("Location:login.php");
	// exit();
}
$otId = $_POST ['otId'];

// 上传文件
$uploadfile = "./files/" . $otId . "_" . date ( "Ymd" ) . "." . fileext ( $_FILES ['userfile'] ['name'] );

$message = "";
if (move_uploaded_file ( $_FILES ['userfile'] ['tmp_name'], $uploadfile )) {
	chmod ( $uploadfile, 0777 );
	$message = "File was successfully uploaded.";
	// 保存到数据库
	$o = new OtherSalary ();
	$oa = new OtherSalaryAccess ( $db );
	$o->otId = $otId;
	$o->auditStatus = "";
	$rs = $oa->GetListSearch ( $o );
	$rsNo = count ( $rs );
	if ($rsNo > 0) {
		$o = $rs [0];
		$o->attachment = $uploadfile;
		$oa->Update ( $o );
	}
} else {
	$message = "Possible file upload attack!";
}

// print "{success:true,msg:'file name:".$_FILES['fileName']['name']."'}";exit();
print "{success:true,msg:'" . $message . "'}";
exit ();

?>