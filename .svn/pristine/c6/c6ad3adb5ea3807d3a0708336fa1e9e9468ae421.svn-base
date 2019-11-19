<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2017-01-12
 * Time: 15:04
 */
include_once("../includes/config.inc.php");

// 检查是否登录
if (!UserLogin::IsLogin()) {
    header( "Location:login.php" );
    exit();
}

$spl = new SurveyPartList ( $db );
$order = $_GET["order"];
$na = $_GET["na"];
if (! empty ( $order ) && ! empty ( $na )) {
    $spl->order = " order by " . $na . " " . $order;
} else if (! empty ( $_COOKIE ['dataListOrder'] )) {
    $spl->order = $_COOKIE ['dataListOrder'];
}

if ($_GET["txtRefNo"] != "") {
    $spl->refNo = trim($_GET["txtRefNo"]);
}
if ($_GET["txtRouteNo"] != "") {
    $spl->routeNo = trim($_GET["txtRouteNo"]);
}
if ($_GET["txtInputTimeStart"] != "") {
    $spl->inputTimeStart = $_GET["txtInputTimeStart"];
}
if ($_GET["txtInputTimeEnd"] != "") {
    $spl->inputTimeEnd = $_GET["txtInputTimeEnd"];
}

if ($_GET ["txtSurveyDateStart"] != "") {
    $spl->surDateStart = $_GET ["txtSurveyDateStart"];
} elseif(empty($_GET["txtInputTimeStart"]) && empty($_GET["txtInputTimeEnd"])) {
    $spl->surDateStart = date ( $conf ['date'] ['format'], mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) - 15, date ( "Y" ) ) );
}
if ($_GET ["txtSurveyDateEnd"] != "") {
    $spl->surDateEnd = $_GET ["txtSurveyDateEnd"];
} elseif(empty($_GET["txtInputTimeStart"]) && empty($_GET["txtInputTimeEnd"])) {
    $spl->surDateEnd = date ( $conf ['date'] ['format'] );
}
if ($_GET["ddlIsRelease"] != "") {
    $spl->isRelease = $_GET["ddlIsRelease"];
} else {
    $spl->isRelease = 'no';
}
if (isset($_GET["ddlDelFlag"])) {
    $spl->delFlag = $_GET["ddlDelFlag"];
} else {
    $spl->delFlag = 'no';
}
if ($_GET["ddlDistId"] != "") {
    $spl->district = $_GET["ddlDistId"];
}
$spl->doDistrict = UserLogin::CanDoDistrict ();
if (UserLogin::IsReadOnly ()) {
    $spl->isRelease = 'yes';
} else {
    $ddlDistIdSelect = GetdoDistrictSelect ();
}
//输入员
if ($_GET['txtInputter'] != "") {
    $spl->userName = $_GET["txtInputter"];
}

// 有refNo的时候时间段无效
if ($spl->refNo != "") {
    $spl->surDateStart = "";
    $spl->surDateEnd = "";
}

if(!empty($spl->inputTimeEnd)){
    $spl->inputTimeEnd .= " 23:59:59";
}

$rs = $spl->GetListSearch();
$rsNum = count($rs);
$data = array();
$label[] = '編號';
$label[] = '路線號碼';
$label[] = '路線更新時間';
$label[] = '類型';
$label[] = '調查日期';
$label[] = '調查時間';
$label[] = '地點';
$label[] = '方向';
$label[] = '輸入員';
$label[] = '輸入時間';
$data['label'] = $label;
for($i = 0; $i < $rsNum; $i ++) {
    $sp = $rs[$i];
    $surFromTime = explode ( ':', $sp->surFromTime );
    $sp->surFromTime = $surFromTime [0] . ":" . $surFromTime [1];
    $surToTime = explode ( ':', $sp->surToTime );
    $sp->surToTime = $surToTime [0] . ":" . $surToTime [1];
    $info = array();
    $info[] = $sp->refNo;
    $info[] = $sp->routeNo;
    $info[] = $sp->sofsDate;
    $info[] = $sp->type;
    $info[] = $sp->surDate;
    $info[] = $sp->surFromTime . "-" . $sp->surToTime;
    $info[] = $sp->location;
    $info[] = $sp->bounds;
    $sp->userName = str_replace('<br />',';',$sp->userName);
    $info[] = $sp->userName;
    $info[] = $sp->inputTime;

    $data['content'][] = $info;
}
$strFileName = 'data_list_'.date('YmdHi').'.csv';
downloadCsv($data, $strFileName);