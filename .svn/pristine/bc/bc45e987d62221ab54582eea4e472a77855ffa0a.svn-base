<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */

// header('Location:survey_to_excel.php?supaId='.$_GET['supaId'].'&next=survey_product_download.php?supaId='.$spl->supaId);
include_once ("./includes/config.inc.php");

// 检查是否登录
if(! UserLogin::IsLogin()){
	header("Location:login.php");
	exit();
}
// 调查表基本信息
$spl = new SurveyPartList($db);
$spl->supaId = $_GET['supaId'];
$rs = $spl->GetListSearch();
$rsNum = count($rs);
if($rsNum > 0){
	$sp = $rs[0];
	$buildUrl = "survey_to_excel.php";
	$dist = "HK"; // 市区
	if(strtoupper(substr($sp->refNo,0,1)) == "K"){
		$dist = "KLN"; // 九龍區
	}else if(strtoupper(substr($sp->refNo,0,2)) == "NE"){
		$dist = "NTE"; // 新界北
	}else if(strtoupper(substr($sp->refNo,0,1)) == "N" || // 如果是T(NF)的也使用NT的格式.--2010-08-22
				strtoupper(substr($sp->refNo,0,1)) == "T"){
		$dist = "NT"; // 新界
	}else if(strtoupper(substr($sp->refNo,0,1)) == "A"){
		$dist = "LTW"; // 路德会
	}
	
	$type = "big"; // 大巴
	$bl = new BusList($db);
	$bl->busId = $sp->busId;
	$rsBus = $bl->GetListSearch();
	$rsBusNum = count($rsBus);
	if($rsBusNum > 0){
		$bus = $rsBus[0];
		if($bus->typeId == "1" || $bus->typeId == "3")
			$type = "mini"; // 小巴
		else if($bus->typeId == "6" && $dist == "HK") // 只对HK，KLN起作用
			$type = "urs"; // 无牌照车
        else if($bus->typeId == "7")
            $type = "lrv"; // 轻铁
	}
		
	// 获取td file no.
	$m = new MainSchedule();
	$m->jobNoNew = $sp->refNo;
	if(strpos($m->jobNoNew, "_") > 0)
		$m->jobNoNew = substr($m->jobNoNew, 0,strpos($m->jobNoNew, "_"));
	$ma = new MainScheduleAccess($db);
	$m = $ma->GetSingle($m);
	$tdRefNo = $m->tdFileNo;
	
	// 判断要跳转到哪里
	$lang = $_GET['lang'];
	switch($lang){
		case 'big5':
			$buildUrl = strtolower("survey_to_excel_" . $type . "_" . $dist . "_big5.php");
			break;
		default:
			$buildUrl = strtolower("survey_to_excel_" . $type . "_" . $dist . ".php");
	}
// 	echo $buildUrl;exit();
	// Add Log
	$uh = new UserHistory();
	$uha = new UserHistoryAccess($db);
	$uh->jobId = $spl->supaId;
	$uh->type = 'Monitoring Survey ';
	$uh->action = 'Product Download';
	$uh->userId = $_SESSION['userId'];
	$uh->startTime = date($conf['dateTime']['format']);
	$uh->endTime = $uh->startTime;
	$uha->Add($uh);
	
	// 下载表格
// 	echo $buildUrl;exit();
	include_once ($buildUrl);
}

?>