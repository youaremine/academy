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
$t->set_file("HdIndex", "jobs_2.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();

// 设置更改密码，登出
$t->set_var("noCurrUser", $noCurrUser);

//获取参数
$filterDateType = $_GET['filterDateType'];
$filterDistrict = $_GET['filterDistrict'];

$t->set_var(array(
    'filterDateType' => $filterDateType,
    'filterDistrictCode' => $filterDistrict
));

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
        $v['filterDistrictName'] = $districtCn[$v['surveyLocationDistrict']];
    }
    $t->set_var ( array (
        "i" => $i,
        "type" => $type,
        "filterDistrictClass" => $filterDistrictClass,
        "filterDateTypeGet" => $filterDateType,
        "filterDistrictCode" => $v['surveyLocationDistrict'],
        "filterDistrictName" => $v['filterDistrictName'],
        "filterDistrictTotal" => $v['total']
    ) );
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
    $ms->plannedSurveyDate = $filterDateType;
}
$msa = new MainScheduleAccess($db);
$assignedNum = $msa->GetListSearchCount($ms);
$t->set_var('assignedNum',$assignedNum);

if($type == 'opening'){
    $msa->order = 'ORDER BY MS.plannedSurveyDate ASC';
    $confirmed_job = $msa->GetListSearch($ms);
    $ms->surveyorCode = '';
    $msoa->order = 'ORDER BY plannedSurveyDate ASC ';
    $applied_job = $msoa->GetListSearchOpening2($ms,'applied',$surveyorCode);
    $rs = $msoa->GetListSearchOpening2($ms,'opening',$surveyorCode);
    $rs = check_repeat_job($confirmed_job,$applied_job,$rs);

}elseif($type == 'applied'){
    $ms->surveyorCode = '';
    $msoa->order = 'ORDER BY plannedSurveyDate ASC ';
    $rs = $msoa->GetListSearchOpening($ms,$type,$surveyorCode);
}else{
    $msa->order = 'ORDER BY MS.plannedSurveyDate ASC';
    $rs = $msa->GetListSearch($ms);
}
$timeIcon = "";
if($type == 'opening'){
    $timeIcon = "";
}
$res = array();

foreach($rs as $k=>$v){
    $remainTime = strtotime($v->mainScheduleOpen->inputTime) + $conf["job"]['pickTime'] - time();
    $remainTimeHtml = "";
    if($remainTime > 0){
        $remainTimeHtml = "<span><i class='icon-time icon-large' ></i><span>".date("i分s秒",$remainTime)."</span></span>";
    }
    $busy_time = (isset($v->busy_time) && $v->busy_time == true)?'時間衝突':'';
    if(!array_key_exists($v->plannedSurveyDate,$res)){
        $res[$v->plannedSurveyDate] = array();
    }

    if(!array_key_exists($v->jobNo,$res[$v->plannedSurveyDate])){
        $res[$v->plannedSurveyDate][$v->jobNo]['surveyType'] = $v->surveyType;
        $res[$v->plannedSurveyDate][$v->jobNo]['diy_name'] = $v->diy_name;
        $res[$v->plannedSurveyDate][$v->jobNo]['diy_value'] = $v->diy_value;
        $res[$v->plannedSurveyDate][$v->jobNo]['surveyTimeHours'] = $v->surveyTimeHours;
//        $res[$v->plannedSurveyDate][$v->jobNo]['endTime_1'] = $v->endTime_1;
        $res[$v->plannedSurveyDate][$v->jobNo]['vehicle'][] = htmlentities($v->vehicle);
    }else{
        if(!in_array($v->vehicle,$res[$v->plannedSurveyDate][$v->jobNo]['vehicle'])){
            $res[$v->plannedSurveyDate][$v->jobNo]['vehicle'][] = htmlentities($v->vehicle);
        }
    }
}

//exit();

include "../templates/account/jobs_3.html";

function br2nl($text){
    $text=preg_replace('/<br\\s*?\/??>/i',chr(13),$text);
    return preg_replace('/&nbsp;/i',' ',$text);
}

function check_repeat_job($confirmed_job,$applied_job,$job_list){

    $busy_time = array();
    foreach($confirmed_job as $k=>$v){
        $tmp_arr = array();
        $tmp_arr['startTime_1'] = $v->startTime_1;
        $tmp_arr['endTime_1'] = $v->endTime_1;
        $busy_time[$v->plannedSurveyDate] = $tmp_arr;
    }

    foreach($applied_job as $k=>$v){
        $tmp_arr = array();
        $tmp_arr['startTime_1'] = $v->startTime_1;
        $tmp_arr['endTime_1'] = $v->endTime_1;
        $busy_time[$v->plannedSurveyDate] = $tmp_arr;
    }

    foreach($job_list as $job_k => $one_job){
        foreach($busy_time as $date => $time){
            if($date == $one_job->plannedSurveyDate){
                if($one_job->startTime_1 > $one_job->endTime_1){
                    $one_job->endTime_1 = TimeAddHour($one_job->endTime_1,24);
                }

                if(($one_job->startTime_1 < $time['startTime_1'] && $one_job->endTime_1 < $time['startTime_1'])
                    || ($one_job->startTime_1 > $time['endTime_1'] && $one_job->endTime_1 > $time['endTime_1'])){
                    //时间不冲突
                    continue;
                }else{
                    //时间有冲突
                    $job_list[$job_k]->busy_time = true;
                }
            }else{
                continue;
            }
        }
    }
    return $job_list;
}

?>