<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */

// header('Location:survey_to_excel.php?supaId='.$_GET['supaId'].'&next=survey_product_download.php?supaId='.$spl->supaId);
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

//
if ($_GET ['supaId'] == "") {
	header ( "Location:list.php" );
	exit ();
}

// 调查表基本信息
$spl = new SurveyPartList ( $db );
$spl->supaId = $_GET ['supaId'];
$rs = $spl->GetListSearch ();
$rsNum = count ( $rs );
if ($rsNum > 0) {
	$sp = $rs [0];
	$fileName = $conf ["path"] ["inputExcel"] . CustomerReplace ( $sp->refNo ) . '.xls';
	
	$buildUrl = 'survey_input_to_excel.php?supaId=' . $spl->supaId . '&next=survey_input_download.php?supaId=' . $spl->supaId;
	if (! file_exists ( $fileName )) {
		header ( 'Location:' . $buildUrl );
	}
}

print "input excel file has aready been created.<br /> " . " click <a href='" . $buildUrl . "'>here</a> to refresh this excel.<br />" . "right click <a href='" . $fileName . "'>here</a> to save it.";

?>