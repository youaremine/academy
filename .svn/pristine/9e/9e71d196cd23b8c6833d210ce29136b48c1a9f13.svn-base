<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}

$order = $_GET ["order"];
$na = $_GET ["na"];
$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "bus_search_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_var ( "Rows", "" );

$bl = new BusList ( $db );
if (! empty ( $na )) {
	$bl->order = " order by " . $na . " " . $order;
	setcookie ( "busListOrder", $bl->order, time () + 2592000 );
	setcookie ( "busListOrderQuery", "order=" . $order . "&na=" . $na, time () + 2592000 );
} else if (! empty ( $_COOKIE ['busListOrder'] )) {
	$bl->order = $_COOKIE ['busListOrder'];
} else {
	$bl->order = " order by busId desc ";
}

if ($_GET ["txtRouteNo"] != "") {
	$bl->routeNo = $_GET ["txtRouteNo"];
} else {
	// 设置的条件不成立,一开始不显示数据
	$bl->busId = - 1;
}
// 设置搜索部分
$t->set_var ( array (
		"txtRouteNo" => $bl->routeNo 
) );
// 设置排序url
$currUrl = $_SERVER ["PHP_SELF"] . "?" . $_SERVER ["QUERY_STRING"];
if (strpos ( $currUrl, "&order" )) {
	$arryPageUrl = explode ( "&order", $currUrl );
} else {
	$arryPageUrl = explode ( "order", $currUrl );
}
$pageUrl = $arryPageUrl [0];
$t->set_var ( array (
		"pageUrl" => $pageUrl . "&" 
) );
// page setting
if ($conf ['page'] ['stat']) {
	$page = $_GET ['page'] < 1 ? 1 : $_GET ['page'];
	$bl->pageLimit = " LIMIT " . ($conf ['page'] ['pagesize'] * ($page - 1)) . "," . $conf ['page'] ['pagesize'];
	$rowNum = $bl->GetListSearchCount ();
	if (strpos ( $pageUrl, "?" ) === false) {
		$pageUrl = $pageUrl . "?" . $_COOKIE ['busListOrderQuery'];
	} else {
		$pageUrl = $pageUrl . "&" . $_COOKIE ['busListOrderQuery'];
	}
	$arryPageUrl = explode ( "page", $pageUrl );
	$pageUrl = $arryPageUrl [0];
	$pageStr = "";
	$pageStr = Pagination ( $rowNum, $conf ['page'] ['pagesize'], $_GET ['page'], $pageUrl );
}
$t->set_var ( array (
		"pageSetting" => $pageStr 
) );

// 只读用户不显示输入员名称
if (UserLogin::IsReadOnly ()) {
	$inputUserCol = "display:none;";
}
$t->set_var ( array (
		"inputUserCol" => $inputUserCol 
) );
// rows
$rs = $bl->GetListSearch ();
$rsNum = count ( $rs );
for($i = 0; $i < $rsNum; $i ++) {
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$bus = $rs [$i];
	// $preview = "<a href=\"bus_view.php?busId=".$bus->busId."\" target=\"_blank\"><img src=\"images/Preview.jpg\" width=\"15\" height=\"17\" border=\"0\" alt=\"Preview\" title=\"Preview\"></a>";
	// $modify = "<a href=\"bus_modify.php?busId=".$bus->busId."\"><img src=\"images/Modify.gif\" alt=\"Modify\" width=\"15\" height=\"15\" border=\"0\" /></a>";
	// $delete = "<a href=\"bus_del_state.php?busId=".$bus->busId."\" onclick=\"return confirm('are you sure?')\"><img src=\"images/Delete.gif\" width=\"11\" height=\"11\" border=\"0\" alt=\"Delete\" title=\"Delete\" /></a>";
	$preview = "";
	$modify = "";
	$delete = "";
	$t->set_var ( array (
			"listStyle" => $listStyle,
			"number" => $i + 1,
			"busId" => $bus->busId,
			"type" => $bus->typeEngName,
			"typeId" => $bus->typeId,
			"routeNo" => $bus->routeNo,
			"sofsDate" => $bus->sofsDate,
			"bounds" => str_replace ( "'", "＇", $bus->bounds ),
			"distCode" => $bus->distCode,
			"amSchNo" => $bus->amSchNo,
			'pmSchNo' => $bus->pmSchNo,
			'allSchNo' => $bus->allSchNo,
			"inputEngName" => $bus->inputEngName,
			"privew" => $preview,
			"modify" => $modify,
			"delete" => $delete 
	) );
	$t->parse ( "Rows", "Row", true );
}

$t->pparse ( "Output", "HdIndex" );
?>