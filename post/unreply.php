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
$t->set_file ("HdIndex", "index.html");
$t->set_caching ($conf ["cache"]["valid"]);
$t->set_cache_dir ($conf ["cache"]["dir"]);
$t->set_expire_time ($conf ["cache"]["timeout"] );
$t->print_cache();
$t->set_var("SITEVESION",SITEVESION);

$t->set_var("postType","unreply");
$t->set_var("indexActive","");
$t->set_var("unreplyActive","active");

$t->pparse ("Output", "HdIndex");