<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
// $json = array(
// 'success'=>'true',
// 'msg'=>$message
// );


// echo json_encode($json);exit();
include_once ("../includes/config.inc.php");

// 检查是否登录
if (!UserLogin::IsLogin())
{
	header("Location:login.php");
	exit();
}

$action = $_REQUEST['action'];
$survId = $_REQUEST['survId'];
$jobNoNew = $_REQUEST['jobNoNew'];

if ($action == 'unassign')
{
	$ms = new MainSchedule();
	$ms->jobNoNewSigle = $jobNoNew;
	$msa = new MainScheduleAccess($db);
	$rs = $msa->GetListSearch($ms);
	$ms = $rs[0];
	$survId = $ms->surveyorCode;
}

// 调查员基本信息
$sur = new Surveyor();
$sa = new SurveyorAccess($db);
$sur->survId = $survId;
$sur->company = '';
$rs = $sa->GetListSearch($sur);
if (!empty($rs))
{
	$sur = $rs[0];
}

if ($action == 'assign')
{
	$sa->Assign($sur, $jobNoNew);
	$message = "Assign Success.";
}
else if ($action == 'unassign')
{
	$sa->UnAssign($sur, $jobNoNew);
	$message = "UnAssign Success.";
}

header('content-Type: application/json;');

echo "{\"success\":\"true\",\"msg\":\"{$message}\"}";