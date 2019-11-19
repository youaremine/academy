<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");
include_once ("./includes/config.plugin.inc.php");

// 检查是否登录
if (SurveyorLogin::IsLogin())
{
	$surveyorCode = $_SESSION['surveyorId'];
	$noCurrUser = "";
}
else if (UserLogin::HasPermission('worker_salary') && !empty($_GET['surveyorId']))
{
	$surveyorCode = $_GET['surveyorId'];
	$noCurrUser = "display:none;";
}
else
{
	header("Location:surveyor_login.php");
	exit();
}

$t = new CacheTemplate("./templates");
$t->set_file("HdIndex", "surveyor_other_salary.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex", "Row", "Rows");
$t->set_block("HdIndex", "OtherRow", "OtherRows");
$t->set_block("HdIndex", "MonthRow", "MonthRows");
$t->set_var("Rows", "");
$t->set_var("OtherRows", "");
$t->set_var("MonthRows", "");

// 设置更改密码，登出
$t->set_var("noCurrUser", $noCurrUser);

// 调查员基本信息
$sur = new Surveyor();
$sur->survId = $surveyorCode;
$sur->company = '';
$sur->status = '';
$sa = new SurveyorAccess($db);
$rs = $sa->GetListSearch($sur);
$rsNum = count($rs);
if ($rsNum > 0)
{
	$sur = $rs[0];
	$t->set_var(array(
			"listStyle" => $listStyle,
			"survId" => $sur->survId,
			"engName" => $sur->engName,
			"contact" => $sur->contact,
			"survHome" => $sur->survHome,
			"dipaCode" => $sur->dipaCode 
	));
	if($sur->survType == "surveyor" )
	{
		if($sur->upSurvId > 0)
		{
			$sur = new Surveyor();
			$sur->upSurvId = $surveyorCode;
			$sur->company = '';
			$sur->status = '';
			$sa = new SurveyorAccess($db);
			$rs = $sa->GetListSearch($sur);
			$sur = $rs[0];
		}
	}
}
// 设置查询
$firstDatetime = min($conf['survey_start_date']);
$firstMonth = date("Y-m", strtotime($firstDatetime));
$lastMonth = date("Y-m", strtotime("+15 day")); // 最多顯示15天後的項目
$rowMonth = $firstMonth;
$j = 0;
if (UserLogin::IsSuperAdministrator())
{
	$t->set_var("rowMonth", 'ALL');
	$t->parse("MonthRows", "MonthRow", true);
}
while ( $rowMonth <= $lastMonth )
{
	$t->set_var("rowMonth", $rowMonth);
	$t->parse("MonthRows", "MonthRow", true);
	$rowTime = strtotime($rowMonth . "-01");
	$rowMonth = date("Y-m", mktime(0, 0, 0, date("m", $rowTime) + 1, date("d", $rowTime), date("Y", $rowTime)));
}

// 详细信息
$ms = new MainSchedule();
$os = new OtherSalary();
$os->surveyorId = $ms->surveyorCode = $sur->survId;
if (!empty($_GET["ddlMonth"]))
{
	$privMonth = $_GET["ddlMonth"];
}
else
{
	$privMonth = date("Y-m", mktime(0, 0, 0, date("m") - 1, date("d"), date("Y"))); // 得到前一个月
}
$firstMonthDay = $privMonth . "-01";
$t->set_var("privMonth", $privMonth);

$firstMonthDayTime = strtotime($firstMonthDay);
$os->surveyDateStart = $ms->plannedSurveyDateStart = $firstMonthDay;
$os->surveyDateEnd = $ms->plannedSurveyDateEnd = date("Y-m-d", mktime(0, 0, 0, date("m", $firstMonthDayTime) + 1, date("d", $firstMonthDayTime), date("Y", $firstMonthDayTime)));
if ($_GET["ddlMonth"] == "ALL")
{
	$os->surveyDateStart = $ms->plannedSurveyDateStart = '';
	$os->surveyDateStart = $ms->plannedSurveyDateEnd = '';
}

$historyStyle = 'display:none;';
$tableName = 'Survey_MainSchedule';
// $mshl = new MainScheduleHistoryLog();
// $mshl->backupMonth = $privMonth;
// $mshla = new MainScheduleHistoryLogAccess($db);
// $rs = $mshla->GetListSearch($mshl);
// if (!empty($rs))
// {
// 	$mshl = $rs[0];
// 	$tableName = $mshl->tableName;
// 	$historyStyle = '';
// }
$t->set_var("historyStyle", $historyStyle);

// 总计部分
$AR = 0; // 工資
$AY = 0; // 可報銷交通費
$AUAV = 0; // 額外交通津貼
$AWAX = 0; // 交通津貼
$ASAT = 0; // 車上調查車費
$AZ = 0; // 實際可得月薪
$AD = 0; // 總工時

// 其他項目
$osa = new OtherSalaryAccess($db);
// $os->salaryType = "worker";
$os->auditStatus = "audited";
$os->order = "ORDER BY surveyDate ASC";
$rs = $osa->GetListSearch($os);
$rsNum = count($rs);
if ($rsNum > 0)
{
	for($i = 0; $i < $rsNum; $i++)
	{
		if ($i % 2 == 0)
			$listStyle = "AlternatingItemStyle";
		else
			$listStyle = "DgItemStyle";
		$os = $rs[$i];
		$t->set_var(array(
				"listStyle" => $listStyle,
				"surveyorId" => $os->surveyorId,
				"surveyorEngName" => $os->surveyorEngName,
				"projectCode" => $os->projectCode,
				"projectName" => $os->projectName,
				"surveyDate" => $os->surveyDate,
				"surveyHour" => $os->surveyHour,
				"wages" => $os->wages,
				"transportExpenses" => $os->transportExpenses,
				"total" => $os->total,
				"remarks" => $os->remarks 
		));
		$t->parse("OtherRows", "OtherRow", true);
		// 总计部分
		$AR += $os->wages;
		$AY += $os->transportExpenses;
		$AUAV += $os->transportExpenses;
		$AZ += $os->total;
		$AD += $os->surveyHour;
	}
}
else
{
	$t->set_var("otherSalaryStyle", "display:none;");
}

$t->set_var(array(
		"AR" => round($AR, $conf['decimal']['precision']),
		"AY" => round($AY, $conf['decimal']['precision']),
		"AUAV" => round($AUAV, $conf['decimal']['precision']),
		"AWAX" => round($AWAX, $conf['decimal']['precision']),
		"ASAT" => round($ASAT, $conf['decimal']['precision']),
		"AZ" => round($AZ, $conf['decimal']['precision']),
		"AD" => round($AD, $conf['decimal']['precision']) 
));

$t->pparse("Output", "HdIndex");
?>