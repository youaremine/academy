<?php
/*
 * Header: Create: 2007-3-21 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
$uh = new UserHistory ();
$uh->jobId = $_GET ['jobId'];
$uh->type = $_GET ['type'];
$uh->action = $_GET ['action'];
$uh->order = $_GET ['order'];
$uh->userName = $_POST ['username'];
$start = isset ( $_POST ['start'] ) ? $_POST ['start'] : 0;
$limit = isset ( $_POST ['limit'] ) ? $_POST ['limit'] : $conf ['page'] ['pagesize'];
$uh->pageLimit = " LIMIT " . $start . "," . $limit;
$uha = new UserHistoryAccess ( $db );
$total = $uha->GetListSearchTotal ( $uh );
$rs = $uha->GetListSearch ( $uh );
$jsonData = array ();
$jsonData ["totalCount"] = $total;
$jsonData ["users"] = $rs;
$json = new Services_JSON ();
$output = "";
$output = $json->encode ( $jsonData );

// Grab the callback variable sent with every ScriptTagProxy request
$callback = $_REQUEST ['callback'];
// Return the JSON string within the callback function, so ExtJS can interpret the response
print $callback . '(' . $output . ')';

?>