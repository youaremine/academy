<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if(! UserLogin::IsLogin()){
	// 检查是否登录
	// if($_GET['sn'] != base64_encode(date("Y-m-d")))
	if($_GET['sn'] != base64_encode("2014-04-04")){
		if(! empty($_GET['sn'])){
			print 'sn is error.';
			exit();
		}else{
			header("Location:login.php");
			exit();
		}
	}
}

$t = new CacheTemplate("./templates");
$t->set_file("HdIndex","notification-week-schedule.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();

$t->set_block("HdIndex","WarningRow","WarningRows");
$t->set_var("WarningRows","");
$t->set_block("HdIndex","WarningFirstRow","WarningFirstRows");
$t->set_var("WarningFirstRows","");

$mspd = new MainSchedulePlannedDate();
$mspda = new MainSchedulePlannedDateAccess($db);
if(date("G") < 13){
	$mspd->inputTimeStart = date($conf['date']['format'],strtotime("-1 day")) . " 15:30";
	$mspd->inputTimeEnd = date($conf['date']['format']) . " 00:00";
}else{
	$mspd->inputTimeStart = date($conf['date']['format']) . " 00:00";
	$mspd->inputTimeEnd = date($conf['date']['format']) . " 15:30";
}
$updatePeriod = "{$mspd->inputTimeStart} - {$mspd->inputTimeEnd}";

if(! empty($_GET['prefix']))
	$mspd->jobNoNew = $_GET['prefix'];

$mspd->order = " ORDER BY jobNoNew,plannedSurveyDate";
$rs = $mspda->GetNotificationListSearch($mspd);
$rsNo = count($rs);
$lastFirstWord = "";
$noWarningStyle = "";
foreach($rs as $v){
	$mspd = $v;
	$firstWord = substr($mspd->jobNoNew,0,1);
	if(! empty($lastFirstWord) && $lastFirstWord != $firstWord){
		$lastFirstWord = $firstWord;
		
		$t->parse("WarningFirstRows","WarningFirstRow",true);
		$t->set_var("WarningRows");
	}
	if(empty($lastFirstWord)){
		$lastFirstWord = $firstWord;
	}
	$mspd->jobNoNew = sprintf("%14s",$mspd->jobNoNew);
	$mspd->jobNoNew = str_replace(" ","&nbsp;",$mspd->jobNoNew);
	if(empty($mspd->plannedSurveyDate))
		$mspd->plannedSurveyDate = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$t->set_var(array (
			"jobNo" => $mspd->jobNoNew,
			"plannedSurveyDate" => $mspd->plannedSurveyDate,
			"inputTime" => $mspd->inputTime 
	));
	$t->parse("WarningRows","WarningRow",true);
}
$t->parse("WarningFirstRows","WarningFirstRow",true);
$t->set_var("WarningRows");
if($rsNo > 0){
	$noWarningStyle = "display:none;";
}

$lastSplit = strrpos($_SERVER["PHP_SELF"],"/");
$floder = substr($_SERVER["PHP_SELF"],0,$lastSplit);
$siteUrl = $_SERVER["HTTP_HOST"] . $floder;

$t->set_var(array (
		"siteUrl" => $siteUrl,
		"updatePeriod" => $updatePeriod,
		"noWarningStyle" => $noWarningStyle 
));

$t->pparse("Output","HdIndex");
?>