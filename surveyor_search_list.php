<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (!UserLogin::IsLogin())
{
	header("Location:login.php");
	exit();
}

$t = new CacheTemplate("./templates");
$t->set_file("HdIndex", "surveyor_search_list.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex", "Row", "Rows");
$t->set_var("Rows", "");

$sur = new Surveyor();
$sa = new SurveyorAccess($db);

if ($_REQUEST["txtSurvId"] != "")
{
	$sur->survId = $_REQUEST["txtSurvId"];
	$sur->status = '';
}
if ($_REQUEST["txtEngName"] != "")
{
	$sur->engName = $_REQUEST["txtEngName"];
}
if ($_REQUEST["txtContact"] != "")
{
	$sur->contact = $_REQUEST["txtContact"];
}
if ($_REQUEST["survType"] != "")
{
	$sur->survType = $_REQUEST["survType"];
}

// 设置搜索部分
$t->set_var(array(
		"txtSurvId" => $sur->survId,
		"txtEngName" => $sur->engName,
		"txtContact" => $sur->contact 
));
$sur->company = '';

$rs = $sa->GetListSearch($sur);
$rsNum = count($rs);
for($i = 0; $i < $rsNum; $i++)
{
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$sur = $rs[$i];
	$t->set_var(array(
			"listStyle" => $listStyle,
			"survId" => $sur->survId,
			"chiName" => $sur->chiName,
			"engName" => $sur->engName,
			"contact" => $sur->contact,
			"survHome" => $sur->survHome,
			"dipaCode" => $sur->dipaCode,
			"IsSupervisor" => $sur->IsSupervisor,
			"remark" => $sur->remark 
	));
	$t->parse("Rows", "Row", true);
}
$t->pparse("Output", "HdIndex");
?>