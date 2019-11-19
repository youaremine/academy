<?php
include_once ('./includes/config.inc.php');
include_once ('../library/init.php');
include_once ('../library/PHPExcel/PHPExcel/IOFactory.php');
// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
// 上传文件位置
$uploadFile = $conf ["path"] ["surveyor"] . $conf ["file"] ["surveyor"];
if ($_FILES ['fileSurveyor'] != "") {
	$message = "";
	if (move_uploaded_file ( $_FILES ['fileSurveyor'] ['tmp_name'], $uploadFile )) {
		$message = "File is valid, and was successfully uploaded.\n";
	} else {
		$message = "Possible file upload attack!\n";
	}
}

// 上传文件最后导入到mysql时间
$importTimeFile = $conf ["path"] ["surveyor"] . $conf ["file"] ["surveyor_import_time"];
$lastImportTime = "";
$fp = fopen ( $importTimeFile, "r" );
$lastImportTime = fread ( $fp, filesize ( $importTimeFile ) );
fclose ( $fp );

// 当前文件修改的时间
$currImportTime = "";
if (file_exists ( $uploadFile )) {
	$currImportTime = date ( $conf ['dateTime'] ['format'], filemtime ( $uploadFile ) );
}

// 判断是否是较新的文件并将数据加入到mysql中
if ($currImportTime > $lastImportTime) {
	$reader = PHPExcel_IOFactory::createReader ( 'Excel5' ); // 设置以Excel2003格式
	$PHPExcel = $reader->load ( $uploadFile ); // 载入excel文件
	$sheet = $PHPExcel->getSheet ( 0 ); // 读取第一個工作表
	$highestRow = $sheet->getHighestRow (); // 取得总行数
	$highestColumm = $sheet->getHighestColumn (); // 取得总列数
	
	$sa = new SurveyorAccess ( $db );
	$sa->EmptyTable (); // 清空原表格
	
	for($row = 2; $row <= $highestRow; $row ++) 	// 行数是以第1行开始
	{
		$sur = new Surveyor ();
		$sur->survId = $sheet->getCell ( "A{$row}" )->getValue ();
		$sur->engName = $sheet->getCell ( "B{$row}" )->getValue ();
		$sur->contact = $sheet->getCell ( "C{$row}" )->getValue ();
		$sur->survHome = $sheet->getCell ( "D{$row}" )->getValue ();
		$sur->dipaCode = $sheet->getCell ( "E{$row}" )->getValue ();
		$sur->IsSupervisor = $sheet->getCell ( "F{$row}" )->getValue ();
		$sur->personalRecord = $sheet->getCell ( "H{$row}" )->getValue ();
		$sur->bank = $sheet->getCell ( "I{$row}" )->getValue ();
		$sur->accountNo = $sheet->getCell ( "J{$row}" )->getValue ();
		$sur->VIP = $sheet->getCell ( "K{$row}" )->getValue ();
		$sur->whatsAPP = $sheet->getCell ( "L{$row}" )->getValue ();
		$sur->email = $sheet->getCell ( "M{$row}" )->getValue ();
		$sur->fax = $sheet->getCell ( "N{$row}" )->getValue ();
		$sur->remarks = $sheet->getCell ( "O{$row}" )->getValue ();
		// 是否是数字即是否是调查员列表
		if ($sur->survId != "" && $sur->survId != 0 && intval ( $sur->survId ) == $sur->survId) {
			$sa->AddFull ( $sur );
		}
	}
	// 更改导入的时间
	$handle = fopen ( $importTimeFile, 'w' );
	fwrite ( $handle, $currImportTime );
	fclose ( $handle );
}

$url = "";
if ($_GET ["url"] == "") {
	$url = "surveyor_list_schedule.php";
} else {
	$url = $_GET ["url"];
	header ( "Location:" . $url );
	exit ();
}
?>
<table
	style="FONT-SIZE: 12px; WIDTH: 300px; LINE-HEIGHT: 120%; FONT-FAMILY: Tahoma, Georgia; BORDER-COLLAPSE: collapse; HEIGHT: 150px"
	align="center">
	<tr>
		<td
			style="BORDER-RIGHT: #cfcfff 0px solid; BORDER-TOP: #cfcfff 0px solid; BORDER-LEFT: #cfcfff 0px solid; BORDER-BOTTOM: #cfcfff 0px solid; HEIGHT: 20px; BACKGROUND-COLOR: #ada001"
			height="20"><FONT color=#333333><STRONG>message</STRONG></FONT></td>
	</tr>
	<tr>
		<td
			style="BORDER-RIGHT: #cfcfcf 1px solid; BORDER-TOP: #cfcfcf 1px solid; BORDER-LEFT: #cfcfcf 1px solid; BORDER-BOTTOM: #cfcfcf 1px solid"
			align="middle" bgColor="#f9f6e7">
			<P><?php print $message; ?></P>
		</td>
	</tr>
</table>
<script type="text/javascript">setTimeout('document.location="<?php print $url; ?>";',2500)</script>