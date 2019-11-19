<?php
/*
 * Header: Create: 2007-6-24 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (!UserLogin::IsLogin())
{
	header("Location:login.php");
	exit();
}

$t = new CacheTemplate("./templates");
$t->set_file("HdIndex", "data_unmerge_list_add.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex", "Row", "Rows");
$t->set_var(array(
		"Rows" => "" 
));

if (!empty($_POST["Submit"]))
{
	$newSupaId = $_POST["newSupaId"];
	$mySupaId = $_POST["supaId"];
	if (count($mySupaId) < 1)
	{
		print "<script>alert(\"you must select more than two record to unmerge.\");history.go(-1);</script>";
		exit();
	}
	
	$spm = new SurveyPartMerge($db);
	$spm->newSupaId = $newSupaId;
	$spm->delFlag = 'yes';
	$spm->UnMerge();
	// 删除合并后的数据
	$sp = new SurveyPart($db);
	$sp->supaId = $newSupaId;
	$sp->delFlag = 'yes';
	$sp->Del();
	
	print "<script>alert(\"unmerge is succeed.\");parent.location='data_unmerge_list.php';</script>";
	exit();
}

// 显示当前supaId的原始记录.
$supaId = $_GET['supaId'];
if (!empty($supaId))
{
	$spl = new SurveyPartList($db);
	$spl->newsupaId = $supaId;
	$spl->delFlag = 'yes';
	$rs = $spl->GetNotMergedListSearch();
	$rsNum = count($rs);
	for($i = 0; $i < $rsNum; $i++)
	{
		if ($i % 2 == 0)
			$listStyle = "AlternatingItemStyle";
		else
			$listStyle = "DgItemStyle";
		$sp = $rs[$i];
		$t->set_var(array(
				"listStyle" => $listStyle,
				"newSupaId" => $supaId,
				"supaId" => $sp->supaId,
				"refNo" => $sp->refNo,
				"busId" => $sp->busId,
				"routeNo" => $sp->routeNo,
				"surveyDate" => $sp->surDate,
				"surveyPeriod" => $sp->surFromTime . "-" . $sp->surToTime,
				"surveyPeriodStart" => $sp->surFromTime,
				"surveyPeriodEnd" => $sp->surToTime,
				"location" => $sp->location,
				"bounds" => $sp->bounds,
				"schNo" => $sp->schNo,
				"schType" => $sp->schType,
				"userName" => $sp->userName,
				"type" => $sp->type 
		));
		$t->parse("Rows", "Row", true);
	}
}

$t->pparse("Output", "HdIndex");
?>