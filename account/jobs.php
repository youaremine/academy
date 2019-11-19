<?php
/*
 * Header:
 * Create: 2015-12-06
 * Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");
include_once ("../includes/config.plugin.inc.php");

// 检查是否登录
if (SurveyorLogin::IsLogin())
{
	$surveyorCode = $_SESSION['surveyorId'];
	$noCurrUser = "";
}
else
{
	header("Location:../surveyor_login.php");
	exit();
}

$t = new CacheTemplate("../templates/account");
$t->set_file("HdIndex", "jobs.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex", "JobRow", "JobRows");
$t->set_block("HdIndex", "FilterDate", "FilterDates");
$t->set_block("HdIndex", "FilterDistrict", "FilterDistricts");
$t->set_var("JobRows", "");

// 设置更改密码，登出
$t->set_var("noCurrUser", $noCurrUser);

//获取参数
$filterDateType = $_GET['filterDateType'];
$filterDistrict = $_GET['filterDistrict'];

//设置过滤日期
$filterDate1TimeStart = strtotime(date("Y-m-d"));

$filterDate[1]['start'] = date('Y-m-d',$filterDate1TimeStart);
$filterDate[1]['end'] = date('Y-m',strtotime('+1 month')).'-1';
$filterDateShow[1] = date('Y年m月',strtotime($filterDate[1]['start']));
$filterDate[2]['start']= $filterDate[1]['end'];
$filterDate[2]['end'] = date('Y-m',strtotime('+2 month')).'-1';
$filterDateShow[2] = date('Y年m月',strtotime($filterDate[2]['start']));
$filterDate[3]['start'] = $filterDate[2]['end'];
$filterDate[3]['end'] = date('Y-m',strtotime('+3 month')).'-1';
$filterDateShow[3] = date('Y年m月',strtotime($filterDate[3]['start']));
$filterDate[4]['start'] = $filterDate[3]['end'];
$filterDate[4]['end'] = date('Y-m',strtotime('+4 month')).'-1';
$filterDateShow[4] = date('Y年m月',strtotime($filterDate[4]['start']));
$filterDate[5]['start'] = $filterDate[4]['end'];
$filterDate[5]['end'] = date('Y-m',strtotime('+5 month')).'-1';
$filterDateShow[5] = date('Y年m月',strtotime($filterDate[5]['start']));
$filterDate[6]['start'] = $filterDate[5]['end'];
$filterDate[6]['end'] = date('Y-m',strtotime('+6 month')).'-1';
$filterDateShow[6] = date('Y年m月',strtotime($filterDate[6]['start']));
$filterDate[7]['start'] = $filterDate[6]['end'];
$filterDate[7]['end'] = date('Y-m',strtotime('+7 month')).'-1';
$filterDateShow[7] = date('Y年m月',strtotime($filterDate[7]['start']));
$filterDate[8]['start'] = $filterDate[7]['end'];
$filterDate[8]['end'] = date('Y-m',strtotime('+8 month')).'-1';
$filterDateShow[8] = date('Y年m月',strtotime($filterDate[8]['start']));
foreach($filterDateShow as $k=>$v){
	if($k == $filterDateType)
		$filterDateClass = 'class="active"';
	else
		$filterDateClass = '';

	$t->set_var ( array (
			"i" => $i,
			"type" => $type,
			"filterDateClass" => $filterDateClass,
			"filterDistrictCodeGet" => $filterDistrict,
			"filterDateType" => $k,
			"filterDateShow" => $v."課程"
	) );
	$t->parse("FilterDates", "FilterDate", true);
}
//设置区域，只显示开放的区域
$ms = new MainSchedule();
$msoa = new MainScheduleOpenAccess($db);
$rs = $msoa->GetListSearchOpeningDistrict($ms,$type,$surveyorCode);
$filterDistrictClass = '';
$districtCn = getArray('district-cn');
foreach($rs as $k=>$v){
	if($v['surveyLocationDistrict'] == $filterDistrict)
		$filterDistrictClass = 'class="active"';
	else
		$filterDistrictClass = '';
	if(!empty($districtCn[$v['surveyLocationDistrict']])){
		$v['surveyLocationDistrict'] = $districtCn[$v['surveyLocationDistrict']];
	}
	$t->set_var ( array (
			"i" => $i,
			"type" => $type,
			"filterDistrictClass" => $filterDistrictClass,
			"filterDateTypeGet" => $filterDateType,
			"filterDistrictCode" => $v['surveyLocationDistrict'],
			"filterDistrictTotal" => $v['total']
	) );
	$t->parse("FilterDistricts", "FilterDistrict", true);
}

//查詢噹前開放中的調查
$openingStyle = '';
$appliedStyle = '';
$assignedStyle = '';
$type = empty($_GET['type'])?'opening':$_GET['type'];
$filterStyle = 'display:none;';
if($type == 'opening'){
	$openingStyle = 'class="active"';
	$filterStyle = '';
}else if($type == 'applied'){
	$appliedStyle = 'class="active"';
}else{
	$assignedStyle = 'class="active"';
}
$t->set_var(array(
		'assignedStyle'=>$assignedStyle,
		'openingStyle'=>$openingStyle,
		'appliedStyle'=>$appliedStyle,
		'filterStyle'=>$filterStyle
));

//获取总数
$ms = new MainSchedule();
$ms->surveyorCode = $surveyorCode;
if(!empty($filterDistrict)){
	$ms->surveyLocationDistrict = $filterDistrict;
}
if(empty($filterDateType)){
	$ms->plannedSurveyDateStart = date("Y-m-d");
}else{
	$ms->plannedSurveyDateStart = $filterDate[$filterDateType]['start'];
	$ms->plannedSurveyDateEnd = $filterDate[$filterDateType]['end'];
}
$msa = new MainScheduleAccess($db);
$assignedNum = $msa->GetListSearchCount($ms);
$t->set_var('assignedNum',$assignedNum);

if($type == 'opening' || $type == 'applied'){
	$ms->surveyorCode = '';
	$msoa->order = 'ORDER BY plannedSurveyDate ASC';
	$rs = $msoa->GetListSearchOpening($ms,$type,$surveyorCode);
}else{
	$msa->order = 'ORDER BY MS.plannedSurveyDate ASC';
	$rs = $msa->GetListSearch($ms);
}

foreach($rs as $v){
	$t->set_var ( array (
			"i" => $i,
			"type" => $type,
			"mscId" => $v->mscId,
			"weekNo" => $v->weekNo,
			"jobNo" => $v->jobNo,
			"jobNoNew" => $v->jobNoNew,
			"plannedSurveyDate" => $v->plannedSurveyDate,
			"surveyTimeHours" => $v->surveyTimeHours,
			"surveyType" => $v->surveyType,
			"surveyLocation" => $v->surveyLocation,
			"surveyLocationCn" => $v->surveyLocationCn?$v->surveyLocationCn:$v->surveyLocation,
			"routeItems" => $v->routeItems,
			"estimatedManHour" => $v->estimatedManHour
	) );
	$t->parse("JobRows", "JobRow", true);
}


$t->pparse("Output", "HdIndex");
?>