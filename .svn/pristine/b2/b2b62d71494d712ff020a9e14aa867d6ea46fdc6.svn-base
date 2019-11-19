<?php
/*
 * Header: 
 * Create: 2015-05-02 
 * Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");

$order = $_GET ["order"];
$na = $_GET ["na"];

$spl = new SurveyPartList ( $db );
if (! empty ( $order ) && ! empty ( $na )) {
	$spl->order = " order by " . $na . " " . $order;
	setcookie ( "productListOrder", $spl->order, time () + 2592000 );
} else if (! empty ( $_COOKIE ['productListOrder'] )) {
	$spl->order = $_COOKIE ['productListOrder'];
}else{
	$spl->order = " ORDER BY refNo ASC";
}

if ($_GET ["txtRefNo"] != "") {
	$spl->refNo = $_GET ["txtRefNo"];
}
if ($_GET ["txtRouteNo"] != "") {
	$spl->routeNo = $_GET ["txtRouteNo"];
}

$spl->delFlag = 'no';
// 有refNo的时候时间段无效
if ($spl->refNo != "") {
	$spl->surDateStart = "";
	$spl->surDateEnd = "";
}


$page = $_GET ['page'] < 1 ? 1 : $_GET ['page'];
$spl->pageLimit = " LIMIT " . ($conf ['page'] ['pagesize'] * ($page - 1)) . "," . $conf ['page'] ['pagesize'];
$rowNum = $spl->GetListSearchCount ();

$rs = $spl->GetListSearch ();

$json = array();
$json['total'] = intval($rowNum);
$json['list'] = $rs;

echo json_encode($json);
?>