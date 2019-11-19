<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-04-22
 * Time: 20:56
 */

include_once ("../includes/config.inc.php");

// 检查是否登录
if (!UserLogin::IsLogin())
{
    header("Location:login.php");
    exit();
}

$t = new CacheTemplate("../templates/post");
$t->set_file ("HdIndex", "single.html");
$t->set_caching ($conf ["cache"]["valid"]);
$t->set_cache_dir ($conf ["cache"]["dir"]);
$t->set_expire_time ($conf ["cache"]["timeout"] );
$t->print_cache();
$t->set_var("SITEVESION",SITEVESION);
$t->set_block ( "HdIndex", "JobNoNewRow", "JobNoNewRows" );
$t->set_var("JobNoNewRows","");



//相關調查
$m = new MainSchedule();
$m->jobNoNewSigle = $_GET['jobNoNew'];
$ma = new MainScheduleAccess($db);
$rs = $ma->GetListSearch($m);
if(empty($rs)){
    //這可能是一個匯總調查編號
    $m->jobNo = $m->jobNoNewSigle;
}else{
    $m->jobNo = $rs[0]->jobNo;
}
$m->jobNoNewSigle = '';
$rs = $ma->GetListSearch($m);
$jobNo = "";
//var_dump($rs);exit();
foreach($rs as $v){
    if(empty($jobNo)){
        $jobNo = $v->jobNo;
    }
    $t->set_var("rowJobNoNew",$v->jobNoNew);
    $t->parse ( "JobNoNewRows", "JobNoNewRow", true );
}

$t->set_var("jobNoNew",$_GET['jobNoNew']);
$t->set_var("jobNo",$jobNo);
$t->pparse ("Output", "HdIndex");