<?php
/**
 *
 * @copyright 2007-2016 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2016-05-07
 */
include_once ("../includes/config.inc.php");

$query = $_REQUEST ['q'];
if(empty($query)){
	$query = 'last';
}
$os = $_REQUEST ['os'];
if(empty($os)){
	$os = 'android';
}
$appName = $_REQUEST ['app'];
if(empty($os)){
	$appName = '';
}

switch ($query) {
	case "last" :
		$av = new AppVersion();
		$ava = new AppVersionAccess($db);
		$av->os = $os;
		$av->appName = $appName;
		$av->uptime = '';
		$av->version = '';
		$av->order = 'ORDER BY uptime DESC';
		$av->pageLimit = 'LIMIT 1';
		$rs = $ava->GetListSearch($av);
		$json = array(
				'success' => true,
				'data' => $rs
		);
		echo json_encode($json);
		break;
}