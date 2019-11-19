<?php
/**
 *
 *
 * @create 2011-4-30
 * @author James Wu<jamblues@gmail.com>
 * @version 1.0
 */
include_once ("../includes/config.inc.php");

// 检查是否登录
// if(!UserLogin::IsLogin())
// {
// header("Location:../login.php");
// exit();
// }


$t = new CacheTemplate("../templates/salary");
$t->set_file("HdIndex", "other-salary-list.html");
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching(false);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();

$t->set_block("HdIndex", "Row", "Rows");
$t->set_var ( "Rows", "" );

if (!empty($_REQUEST['btnSubmit']))
{
	$surveyDateStart = $_GET['sSurveyDateStart'];
	$surveyDateEnd = $_GET['sSurveyDateEnd'];
	$projectCode = $_GET['sProjectCode'];
	$projectName = $_GET['sProjectName'];
	$surveyorId = $_GET['sSurveyorId'];
	$surveyorEngName = $_GET['sSurveyorEngName'];
	$surveyorContanct = $_GET['sSurveyorContanct'];
	$surveyorHome = $_GET['sSurveyorHome'];
}
else
{
	if (empty($_GET['sSurveyDateStart']))
	{
		$surveyDateStart = date("Y-m", strtotime("-1 month")) . "-01";
	}
	if (empty($_GET['sSurveyDateEnd']))
	{
		$surveyDateEnd = date("Y-m") . "-01";
	}
	if (!empty($_GET['order']))
	{
		$order = " ORDER BY " . $_GET['order'] . " DESC";
	}
}

$t->set_var(array(
		"sSurveyDateStart" => $surveyDateStart,
		"sSurveyDateEnd" => $surveyDateEnd,
		"sProjectCode" => $projectCode,
		"sProjectName" => $projectName,
		"sSurveyorId" => $surveyorId,
		"sSurveyorEngName" => $surveyorEngName,
		"sSurveyorContanct" => $surveyorContanct,
		"sSurveyorHome" => $surveyorHome
));

// rows
$o = new OtherSalary();
$o->projectCode = $projectCode;
$o->surveyorId = $surveyorId;
$o->surveyDateStart = $surveyDateStart;
$o->surveyDateEnd = $surveyDateEnd;
$o->auditStatus = "";
$o->order = $order;
$oa = new OtherSalaryAccess($db);
$rs = $oa->GetListSearch($o);
$rsNum = count($rs);
$salaryTypes = array();
for($i = 0; $i < $rsNum; $i++)
{
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$o = $rs[$i];
	if(!in_array($o->salaryType, $salaryTypes))
		$salaryTypes[] = $o->salaryType;
	$attachment = "";
	if (empty($o->attachment))
	{
		$attachment = '<img src="../images/attachment.png" title="no attachment" />';
	}
	else
	{
		$attachment = '<a href="' . $o->attachment . '" target="_blank"><img src="../images/attachment-c.png" title="attachment" /></a>';
	}
	$btnAudit = "";
	if ($o->auditStatus == "pending")
	{
		if(UserLogin::HasPermission("other_salary_audit"))
			$btnAudit = "<input class=\"ButtonIdea\" style=\"cursor:pointer;\" type=\"button\" id=\"Audit_{$o->otId}\" value=\"審核\" onclick=\"Audit({$o->otId})\" />";
	}
	$t->set_var(array(
			"listStyle" => $listStyle,
			"i" => $i,
			"otId" => $o->otId,
			"surveyorId" => $o->surveyorId,
			"surveyorEngName" => $o->surveyorEngName,
			"projectCode" => $o->projectCode,
			"projectName" => $o->projectName,
			"surveyDate" => $o->surveyDate,
			"startTime" => $o->startTime,
			"endTime" => $o->endTime,
			"restHour" => $o->restHour,
			"surveyHour" => $o->surveyHour,
			"hourlyRate" => $o->hourlyRate,
			"wages" => $o->wages,
			"transportExpenses" => $o->transportExpenses,
			"total" => $o->total,
			"remarks" => $o->remarks,
			"auditStatus" => $o->auditStatus,
			"salaryType" => $o->salaryType,
			"btnAudit" => $btnAudit,
			"delFlag" => 'no',
			"attachment" => $attachment 
	));
	$t->parse("Rows", "Row", true);
}

// 判斷這個時間段內有沒有被鎖定月份的schedule
$editLink = "Edit";
if (!empty($_REQUEST['btnSubmit']))
{
	$isLock = true;//锁定
	$backupMonth = "";
	if(in_array("surveyor", $salaryTypes))
	{
		$mshl = new MainScheduleHistoryLog();
		$mshl->isApproval = '';
		$mshla = new MainScheduleHistoryLogAccess($db);
		if (!empty($surveyDateStart))
			$mshl->order = " AND CONCAT(backupMonth,'-01') >= '{$surveyDateStart}'";
		if (!empty($surveyDateEnd))
			$mshl->order .= " AND CONCAT(backupMonth,'-01') <= '{$surveyDateEnd}'  ";
		$rs = $mshla->GetListSearch($mshl);
		if (empty($rs)) // 未锁定
		{
			$isLock = false;
		}
		else 
		{
			$mshl = $rs[0];
			$backupMonth = $mshl->backupMonth;
		}
	}
	if(in_array("hk-part-time", $salaryTypes) || in_array("sz-part-time", $salaryTypes))
	{
		$oshl = new OtherSalaryHistoryLog();
		if(in_array("hk-part-time", $salaryTypes) && in_array("sz-part-time", $salaryTypes))
		{
			$oshl->backupType = "";
		}
		else if(in_array("hk-part-time", $salaryTypes))
		{
			$oshl->backupType = "hk-part-time";
		}
		else if(in_array("sz-part-time", $salaryTypes))
		{
			$oshl->backupType = "sz-part-time";
		}
		
		$oshl->isApproval = '';
		$oshla = new OtherSalaryHistoryLogAccess($db);
		if (!empty($surveyDateStart))
			$oshl->order = " AND CONCAT(backupMonth,'-01') >= '{$surveyDateStart}'";
		if (!empty($surveyDateEnd))
			$oshl->order .= " AND CONCAT(backupMonth,'-01') <= '{$surveyDateEnd}'  ";
		$rs = $oshla->GetListSearch($oshl);
		if (empty($rs)) // 未锁定
		{
			$isLock = false;
		}
		else 
		{
			$oshl = $rs[0];
			$backupMonth = $oshl->backupMonth;
		}
	}
	
	if ($isLock)
	{
		$editLink = "<span style='color:#CCC'>Edit</span>(<b>{$backupMonth}</b>糧已經被鎖定!)";
	}
	else
	{
		$editLink = "<a href='other-salary-entry.php?action=edit&" . $_SERVER['QUERY_STRING'] . "'>Edit</a>";
	}
}
$t->set_var("editLink" , $editLink );

$t->set_var("pageSetting", "");

$t->pparse("Output", "HdIndex");