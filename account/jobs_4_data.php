<?php

include_once ("../includes/config.inc.php");
include_once ("../includes/config.plugin.inc.php");

$request=filter_input(INPUT_POST,'REQUEST');
$jobNoShort=filter_input(INPUT_GET,'jobNoShort');
$iden=filter_input(INPUT_POST,'IDEN');

$ja = new JobsAccess($db);



if(!empty($jobNoShort)){
    $arr=$ja->getGoodsUrl(2,$jobNoShort);
    setcookie("ImgUrl",$arr,time()+10);
}
if($request=="w"){
    if(!empty($iden)){
        $userId=$_SESSION['surveyorId'];
        $arr=$ja->getGoodsUrl(3,$iden,$userId);
        echo $arr;
        return;
    }else{
        $img_url=$_COOKIE['ImgUrl'];
        echo $img_url;
        return;
    }
}else if($request=="q"){
    $arr=$ja->getGoodsUrl(1);
    echo $arr;
    return;
}
include_once("../templates/account/goods_details.html");