<?php
/*
 * Header:
 * Create: 2015-12-06
 * Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");
include_once ("../includes/config.plugin.inc.php");

// 检查是否登录
if (!SurveyorLogin::IsLogin()) header("Location:../surveyor_login.php");

$t = new CacheTemplate("../templates/account");
$t->set_file("HdIndex", "jobs_4.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex", "JobRow", "JobRows");
$t->set_var("JobRows", "");

//获取总数
$jobA = new JobsAccess($db);

$rs = $jobA->getGoodsList();

foreach($rs as $v){
    $img_url = !empty($v['img_url'])?explode(',',$v['img_url'])[0]:'/images/goods/20191220150910-5dfc739692f10.jpg';
    $t->set_var ( array (
        "i" => $i,
        "mscId" => $v['mscId'],
        "jobNo" => $v['jobNo'],
        "jobNoNew" => $v['jobNoNew'],
        "surveyType" => $v['surveyType'],
        "vehicle" => $v['vehicle'],
        "jobNoShort" => $v['jobNoShort'],
        "img_url" => $img_url,
        "amount" => $v['amount']
    ) );
    $t->parse("JobRows", "JobRow", true);
}


$t->pparse("Output", "HdIndex");
?>