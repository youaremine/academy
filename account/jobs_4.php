<?php

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



$msoa = new MainScheduleOpenAccess($db);
//获取总数
$ms = new MainSchedule();
$ms->surveyorCode = $surveyorCode;


$msa = new MainScheduleAccess($db);
$assignedNum = $msa->GetListSearchCount($ms);

$type = empty($_GET['type'])?'opening':$_GET['type'];
if($type == 'opening'){
    $ms->surveyorCode = '';
    $rs = $msoa->GetListSearchOpening2($ms,'opening',$surveyorCode,true);//查询控制，输出其开放状态下的物品数据库数据
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
include "../templates/account/jobs_4.html";



