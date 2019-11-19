<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
//使用移動端
header("location:account/salary.php?".$_SERVER['QUERY_STRING']);
exit();
include_once ("./includes/config.inc.php");
include_once ("./includes/config.plugin.inc.php");

// 检查是否登录
if (SurveyorLogin::IsLogin())
{
	$surveyorCode = $_SESSION['surveyorId'];
	$noCurrUser = "";
}
else if (UserLogin::IsAdministrator() && !empty($_GET['surveyorId']))
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
$t->set_file("HdIndex", "surveyor_profile.html");
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
$styleOtherSalary = "display:none;";
$mainSurvType = "";
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
	$mainSurvType = $sur->survType;
	if ($sur->survType == "surveyor")
	{
		if ($sur->upSurvId > 0)
		{
			$sur = new Surveyor();
			$sur->upSurvId = $surveyorCode;
			$sur->company = '';
			$sur->status = '';
			$sa = new SurveyorAccess($db);
			$rs = $sa->GetListSearch($sur);
			if (count($rs) > 0)
			{
				$styleOtherSalary = "";
			}
		}
	}
	else
	{
		$styleOtherSalary = "";
	}
}
if(!SurveyorLogin::IsLogin() && !UserLogin::HasPermission('worker_salary'))
	$styleOtherSalary = "display:none;";
$t->set_var("styleOtherSalary", $styleOtherSalary);
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
$os->surveyorId = $ms->surveyorCode = $surveyorCode;
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
$mshl = new MainScheduleHistoryLog();
$mshl->backupMonth = $privMonth;
$mshla = new MainScheduleHistoryLogAccess($db);
$rs = $mshla->GetListSearch($mshl);
if (!empty($rs))
{
	$mshl = $rs[0];
	$tableName = $mshl->tableName;
	$historyStyle = '';
}
$t->set_var("historyStyle", $historyStyle);

$msa = new MainScheduleAccess($db);
$msa->tableName = $tableName;
$msa->order = "	ORDER BY plannedSurveyDate ASC";
if ($mainSurvType == "surveyor"){
	$rs = $msa->GetListSearchForRawFile($ms);
}else{
	$rs = array();
}
$rsNum = count($rs);
// 总计部分
$AR = 0; // 工資
$AY = 0; // 可報銷交通費
$AUAV = 0; // 額外交通津貼
$AWAX = 0; // 交通津貼
$ASAT = 0; // 車上調查車費
$AZ = 0; // 實際可得月薪
$AD = 0; // 總工時
for($i = 0; $i < $rsNum; $i++)
{
	if ($i % 2 == 0)
		$listStyle = "AlternatingItemStyle";
	else
		$listStyle = "DgItemStyle";
	$ms = $rs[$i];
	$rawFile = "<a href='javascript:void(0);'><img border='0' width='18' src='images/pdf-disable.jpg' /></a>";
	if ($ms->rawFile != "")
	{
		$ms->rawFile = str_replace("../", $conf["plugin"]["download_pdf_host"], $ms->rawFile);
		$downUrl = "plugin/raw_pdf_download_prc.php?userId=" . $_SESSION['userId'] . "&jobNoNew=" . $ms->jobNoNew . "&downloadUrl=" . $ms->rawFile;
		$rawFile = "<a href='{$downUrl}' target='_blank'><img border='0' width='18' src='images/pdf.jpg' /></a>";
	}
	if (!UserLogin::IsAdministrator())
	{
		$rawFile = '';
	}
	// Period 1,Period 2,时间如果大于24或者小于0，则整行红色.
	if ($ms->periodHour_1 < 0 || $ms->periodHour_1 > 24 || $ms->periodHour_2 < 0 || $ms->periodHour_1 > 24)
	{
		$listStyle = "DgErrorItemStyle";
	}
	$t->set_var(array(
			"listStyle" => $listStyle,
			"jobNo" => $ms->jobNoNew == "" ? $ms->jobNo : $ms->jobNoNew,
			"plannedSurveyDate" => $ms->plannedSurveyDate,
			"surveyTimeHours" => $ms->surveyTimeHours,
			"surveyLocation" => $ms->surveyLocationCn?$ms->surveyLocationCn:$ms->surveyLocation,
			"routeItems" => $ms->routeItems,
			"estimatedManHour" => $ms->estimatedManHour,
			"periodHour_1" => $ms->periodHour_1,
			"periodWagesHr_1" => $ms->periodWagesHr_1,
			"periodHour_2" => $ms->periodHour_2,
			"periodWagesHr_2" => $ms->periodWagesHr_2,
			"totalWages" => $ms->totalWages,
			"onBoardCostFare" => $ms->onBoardCostFare,
			"noOfTrips" => $ms->noOfTrips,
			"transportAllowanceAm" => $ms->transportAllowanceAm,
			"transportAllowanceNoon" => $ms->transportAllowanceNoon,
			"transportAllowancePm" => $ms->transportAllowancePm,
			"transportAllowanceOvernight" => $ms->transportAllowanceOvernight,
			"taTotal" => $ms->taTotal,
			"wagesTaOnBoard" => $ms->wagesTaOnBoard,
			"onBoardTranportAllowanceTotal" => $ms->onBoardTranportAllowanceTotal,
			"rawFile" => $rawFile 
	));
	$t->parse("Rows", "Row", true);
	
	// 总计部分
	$AR += $ms->totalWages;
	$AY += $ms->taTotal;
	$AUAV += $ms->transportAllowanceAm + $ms->transportAllowanceNoon;
	$AWAX += $ms->transportAllowancePm + $ms->transportAllowanceOvernight;
	$ASAT += $ms->onBoardCostFare * $ms->noOfTrips;
	$AZ += $ms->wagesTaOnBoard;
	$AD += $ms->estimatedManHour;
}

// 其他項目
$osa = new OtherSalaryAccess($db);
$os->salaryType = "surveyor";
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
				"startTime" => $os->startTime,
				"endTime" => $os->endTime,
				"restHour" => $os->restHour,
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