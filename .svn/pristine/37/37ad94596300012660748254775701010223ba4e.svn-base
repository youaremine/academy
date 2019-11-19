<?php
/*
 * Header: Create: 2008-02-03 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:mobile_login.php" );
	exit ();
}
// 添加调查表
$ad = new AppendixD ();
$ad->appeId = $_POST ['appeId'];
if ($ad->appeId <= 0) {
	$ada = new AppendixDAccess ( $db );
	$ad->survId = $_SESSION ['userId'];
	$ad->surveyDate = $_POST ['surveyDate'];
	$ad->surveyTime = $_POST ['surveyTime'];
	$ad->inputTime = date ( $conf ['dateTime'] ['format'] );
	$ad->inputUserId = $_SESSION ['userId'];
	$ad->appeId = $ada->Add ( $ad );
}

$add = new AppendixDDetail ();
$add->apdeId = $_POST ['apdeId'];
$add->appeId = $ad->appeId;
$add->isReject = $_POST ['isReject'] == "" ? 'no' : 'yes';
$add->questionOne_1 = $_POST ['questionOne_1'];
$add->questionOne_2 = $_POST ['questionOne_2'];
$add->questionOne_3 = $_POST ['questionOne_3'];
$add->questionTwo_1 = $_POST ['questionTwo_1'];
$add->questionTwo_2 = $_POST ['questionTwo_2'];
$add->questionTwo_3 = $_POST ['questionTwo_3'];
$add->surveyTime = date ( $conf ['time'] ['format'] );
$adda = new AppendixDDetailAccess ( $db );
if ($add->apdeId <= 0) // 添加详情
{
	$add->apdeId = $adda->Add ( $add );
} else // 修改详情
{
	$adda->Update ( $add );
}
header ( "Location:mobile_appendixd_survey_entry.php?appeId=" . $ad->appeId );
?>
