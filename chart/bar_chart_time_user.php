<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2016-11-27
 * Time: 21:07
 */

include_once('../includes/config.inc.php');

// 检查是否登录
if (!UserLogin::IsLogin()) {
    header("Location:../login.php");
    exit ();
}

$t = new CacheTemplate ("../templates");
$t->set_file("HdIndex", "chart/bar_chart_time_user.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();

$ddlDistIdSelect = GetdoDistrictSelect();

$t->set_var ( array (
    "plannedSurveyDateStart" => date('Y-m-d'),
    "plannedSurveyDateEnd" => date('Y-m-d',strtotime('+15 day')),
    "ddlDistIdSelect" => $ddlDistIdSelect
) );

$t->pparse("Output", "HdIndex");
