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


$request = filter_input(INPUT_POST,'REQUEST');
$jobNoShort = filter_input( INPUT_GET,'jobNoShort');
$jobNo = filter_input(INPUT_POST,'IDEN');

$ja = new JobsAccess($db);

if($request=="w"){
    if(!empty($jobNo)){
        //获取是否已选

        $buyed = $ja->checkBuyed($jobNo,$_SESSION['surveyorId']);
        $goodsDetail = $ja->getRemainGoodsDetail($jobNo);
        $total = $ja->getGoodsTotal($jobNo);
        $remain = count($goodsDetail);
        $surplus = 0;
        $res = array();
        foreach($goodsDetail as $one){
            if(!$ja->inOrder($one['jobNoNew'])){//是否没有被选
                $res = $one;
                break;
            }
        }

        if(empty($res)){
            echo json_encode(['code'=>404,'msg'=>'該商品已搶購完了'],256);exit;
        }

        $res['code'] = 200;
        $res['buyed'] = empty($buyed);
        $res['total'] = $total;
        $res['surplus'] = $remain;
        echo json_encode($res,256);exit;
    }else{
        $img_url = $_COOKIE['ImgUrl'];
        echo $img_url;
        return;
    }
}else if($request=="q"){
    $arr = $ja->getGoodsUrl(1);
    echo json_encode($arr,JSON_UNESCAPED_UNICODE);
    return;
}

$t = new CacheTemplate("../templates/account");
$t->set_file("HdIndex", "goods_details.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_var('jobNoShort',$jobNoShort);
$t->set_var('jobNo',$jobNoShort);



$t->pparse("Output", "HdIndex");