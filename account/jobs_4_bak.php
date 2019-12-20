<?php

include_once ("../includes/config.inc.php");
include_once ("../includes/config.plugin.inc.php");

$request=filter_input(INPUT_POST,REQUEST);
$jobNoShort=filter_input(INPUT_GET,'jobNoShort');


if(!empty($jobNoShort)){
    $ja = new JobsAccess($db);
    $arr=$ja->getGoodsUrl(2,$jobNoShort);
    setcookie("ImgUrl",$arr,time()+10);
}else if($request=="w"){
    $img_url=$_COOKIE['ImgUrl'];
    echo $img_url;
    return;
}else if($request=="q"){
    $ja = new JobsAccess($db);
    $arr=$ja->getGoodsUrl(1);
    echo $arr;
    return;
}
include_once("../templates/account/goods_details.html");