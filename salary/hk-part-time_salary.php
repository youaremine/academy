<?php
/*
 * Header: Create: 2007-1-3 
 * Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");

// 检查是否登录
if (!UserLogin::IsLogin())
{
	header("Location:login.php");
	exit();
}

/**
 *
 * 初始化模板
 *
 * @param
 *        	$complateJobNos
 */
function InitProjectNames($complateJobNos)
{
	$str = "";
	foreach ( $complateJobNos as $k => $v )
	{
		$str .= '
		<td colspan="4" align="center">' . $v . '</td>';
	}
	return $str;
}

/**
 *
 * 初始化子标题
 *
 * @param
 *        	$complateJobNos
 */
function InitProjectTitles($complateJobNos)
{
	$str = "";
	foreach ( $complateJobNos as $k => $v )
	{
		$str .= '
	<td align="center">Hour</td>
    <td align="center">Wages</td>
    <td align="center">TE</td>
    <td align="center">Total</td>';
	}
	return $str;
}

/**
 *
 * 初始化值模板
 *
 * @param
 *        	$complateJobNos
 */
function GetProjectValuesTemplate($complateJobNos)
{
	$str = "";
	foreach ( $complateJobNos as $k => $v )
	{
		$str .= "
	<td>{surveyHour_" . $v . "}</td>
    <td>{wages_" . $v . "}</td>
    <td>{transportExpenses_" . $v . "}</td>
    <td>{salaryTotal_" . $v . "}</td>";
	}
	return $str;
}

/**
 *
 * 替指定的值换值
 *
 * @param unknown_type $str        	
 * @param unknown_type $salary        	
 */
function ReplaceProjectValues($str, $salary)
{
	$str = str_replace("{surveyHour_" . $salary["complateJobNo"] . "}", $salary["surveyHour"], $str);
	$str = str_replace("{wages_" . $salary["complateJobNo"] . "}", $salary["wages"], $str);
	$str = str_replace("{transportExpenses_" . $salary["complateJobNo"] . "}", $salary["transportExpenses"], $str);
	$str = str_replace("{salaryTotal_" . $salary["complateJobNo"] . "}", $salary["salaryTotal"], $str);
	return $str;
}

/**
 *
 * 换成空白值
 *
 * @param
 *        	$str
 * @param
 *        	$complateJobNos
 */
function EmptyProjectValues($str, $complateJobNos)
{
	foreach ( $complateJobNos as $k => $v )
	{
		$str = str_replace("{surveyHour_" . $v . "}", '', $str);
		$str = str_replace("{wages_" . $v . "}", '', $str);
		$str = str_replace("{transportExpenses_" . $v . "}", '', $str);
		$str = str_replace("{salaryTotal_" . $v . "}", '', $str);
	}
	return $str;
}

$t = new CacheTemplate("../templates/salary");
$t->set_file("HdIndex", "hk-part-time_salary.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();
$t->set_block("HdIndex", "Row", "Rows");
$t->set_block("HdIndex", "MonthRow", "MonthRows");
$t->set_var("Rows", "");

if ($_GET["txtSurveyDateStart"] != "")
{
	$surDateStart = $_GET["txtSurveyDateStart"];
}
else
{
	$surDateStart = date($conf['date']['format'], mktime(0, 0, 0, date("m") - 1, "01", date("Y")));
}
if ($_GET["txtSurveyDateEnd"] != "")
{
	$surveyDateEnd = $_GET["txtSurveyDateEnd"];
}
else
{
	$surveyDateEnd = date($conf['date']['format'], mktime(0, 0, 0, date("m"), "01", date("Y")));
}
// 设置搜索部分
$t->set_var(array(
		"txtSurveyDateStart" => $surDateStart,
		"txtSurveyDateEnd" => $surveyDateEnd 
));

// 设置查询
$firstDatetime = min($conf['survey_start_date']);
$firstMonth = date("Y-m", strtotime($firstDatetime));
$lastMonth = date("Y-m", strtotime("+15 day")); // 最多顯示15天後的項目
$rowMonth = $firstMonth;
while ( $rowMonth <= $lastMonth )
{
	$t->set_var("rowMonth", $rowMonth);
	$t->parse("MonthRows", "MonthRow", true);
	$rowTime = strtotime($rowMonth . "-01");
	$rowMonth = date("Y-m", mktime(0, 0, 0, date("m", $rowTime) + 1, date("d", $rowTime), date("Y", $rowTime)));
}

if (!empty($_REQUEST['ddlMonth']))
{
	$ddlMonth = $_REQUEST['ddlMonth'];
	$surDateStart = $ddlMonth . "-01";
	$surDateStartTime = strtotime($surDateStart);
	$surveyDateEnd = date("Y-m-d", mktime(0, 0, 0, date("m", $surDateStartTime) + 1, date("d", $surDateStartTime), date("Y", $surDateStartTime)));
}
else
{
	$ddlMonth = date("Y-m", strtotime("-1 month"));
	$surDateStart = $ddlMonth . "-01";
	$surDateStartTime = strtotime($surDateStart);
	$surveyDateEnd = date("Y-m-d", mktime(0, 0, 0, date("m", $surDateStartTime) + 1, date("d", $surDateStartTime), date("Y", $surDateStartTime)));
}
$t->set_var("ddlMonth", $ddlMonth);

$complateJobNos = array();
/*
foreach ( $conf ['surveytime'] as $k => $v )
{
	$complateJobNos [] = $k;
}
// 系統主要項目.
$sql = "SELECT surveyorCode,engName,contact,remarks,complateJobNo,SUM(totalWages) AS totalWages
	,SUM(taTotal) AS taTotal,SUM(estimatedManHour) AS estimatedManHour,SUM(onBoardCostFare*noOfTrips) AS OnBoardCost
	,SUM(wagesTaOnBoard) AS wagesTaOnBoard FROM {$tableName} 
	INNER JOIN Survey_Surveyor ON surveyorCode=survId
	WHERE 1=1 
	  AND DATE_FORMAT(plannedSurveyDate,'%Y-%m-%d') >= '" . $surDateStart . "' 
	  AND DATE_FORMAT(plannedSurveyDate,'%Y-%m-%d') < '" . $surveyDateEnd . "' 
	  GROUP BY surveyorCode,engName,contact,complateJobNo
	  ORDER BY CAST(surveyorCode AS SIGNED) ASC";
$db->query ( $sql );
// echo $sql;exit();
$salarys = array ();
while ( $db->next_record () )
{
	$salary ['surveyorCode'] = $db->Record ['surveyorCode'];
	$salary ['engName'] = $db->Record ['engName'];
	$salary ['contact'] = $db->Record ['contact'];
	$salary ['surveyHour'] = $db->Record ['estimatedManHour'];
	$salary ['complateJobNo'] = $db->Record ['complateJobNo'];
	$salary ['wages'] = round ( $db->Record ['totalWages'], $conf ['decimal'] ['precision'] );
	;
	$salary ['transportExpenses'] = round ( ($db->Record ['taTotal'] + $db->Record ['OnBoardCost']), $conf ['decimal'] ['precision'] );
	;
	$salary ['wagesTaOnBoard'] = round ( $db->Record ['wagesTaOnBoard'], $conf ['decimal'] ['precision'] );
	$salary ['salaryTotal'] = round ( ($db->Record ['totalWages'] + $salary ['transportExpenses']), $conf ['decimal'] ['precision'] );
	$salary ['isOtherProject'] = 0;
	$salarys [$salary ['surveyorCode'] . "_" . $salary ['complateJobNo']] = $salary;
	if (! in_array ( $salary ['complateJobNo'], $complateJobNos ))
	{
		$complateJobNos [] = $salary ['complateJobNo'];
	}
}
// echo $sql;
 */

// Other projects
$salaryType = "hk-part-time";
$sql = "SELECT surveyorId as surveyorCode,engName,contact,projectCode AS complateJobNo,SUM(wages) AS totalWages
	,SUM(transportExpenses) AS transportExpenses,SUM(surveyHour) AS estimatedManHour,0 AS OnBoardCost,0 AS wagesTaOnBoard 
	,SUM(total) AS salaryTotal FROM Survey_OtherSalary
	INNER JOIN Survey_Surveyor ON survId = surveyorId
	WHERE 1=1 
	  AND DATE_FORMAT(surveyDate,'%Y-%m-%d') >= '" . $surDateStart . "' 
	  AND DATE_FORMAT(surveyDate,'%Y-%m-%d') < '" . $surveyDateEnd . "' 
	  AND delFlag = 'no'
	  AND salaryType='{$salaryType}'
	  GROUP BY surveyorId,surveyorEngName,projectCode
	  ORDER BY CAST(surveyorCode AS SIGNED) ASC";
$db->query($sql);

while ( $db->next_record() )
{
	$salary['surveyorCode'] = $db->Record['surveyorCode'];
	$salary['engName'] = $db->Record['engName'];
	$salary['contact'] = $db->Record['contact'];
	;
	$salary['surveyHour'] = $db->Record['estimatedManHour'];
	$salary['complateJobNo'] = $db->Record['complateJobNo'];
	$salary['wages'] = round($db->Record['totalWages'], $conf['decimal']['precision']);
	;
	$salary['transportExpenses'] = round($db->Record['transportExpenses'], $conf['decimal']['precision']);
	;
	$salary['wagesTaOnBoard'] = 0;
	$salary['salaryTotal'] = round($db->Record['salaryTotal'], $conf['decimal']['precision']);
	;
	$salary['isOtherProject'] = 1;
	if (!empty($salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']]))
	{
		$salary["surveyHour"] += $salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']]["surveyHour"];
		$salary["wages"] += $salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']]["wages"];
		$salary["transportExpenses"] += $salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']]["transportExpenses"];
		$salary["salaryTotal"] += $salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']]["salaryTotal"];
	}
	$salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']] = $salary;
	if (!in_array($salary['complateJobNo'], $complateJobNos))
	{
		$complateJobNos[] = $salary['complateJobNo'];
	}
}
if (is_array($salarys))
{
	// sort
	function cmp($a, $b)
	{
		if ($a['surveyorCode'] == $b['surveyorCode'])
		{
			return 0;
		}
		return ($a['surveyorCode'] < $b['surveyorCode']) ? -1 : 1;
	}
	usort($salarys, "cmp");
}

//
$projectNames = InitProjectNames($complateJobNos);
$t->set_var("projectNames", $projectNames);
$projectTitles = InitProjectTitles($complateJobNos);
$t->set_var("projectTitles", $projectTitles);

$i = 0;
$j = 0;
$taTotal = 0;
$salaryTotal = 0;
$salaryTotalAll = 0;
$salaryIncludeMainTotalAll = 0;
$mainScheduleTotalAll = 0;
$surveyor = array();
$projectValues = GetProjectValuesTemplate($complateJobNos);
$tempSalarys = array();
if (is_array($salarys))
{
	foreach ( $salarys as $k => $v )
	{
		if ($i > 0 && $vl['surveyorCode'] != $v['surveyorCode'])
		{
			if ($j % 2 == 0)
				$listStyle = "AlternatingItemStyle";
			else
				$listStyle = "DgItemStyle";
			$projectValues = EmptyProjectValues($projectValues, $complateJobNos);
			$t->set_var(array(
					"listStyle" => $listStyle,
					"surveyorCode" => $vl['surveyorCode'],
					"engName" => $vl['engName'],
					"contact" => $vl['contact'],
					"projectValues" => $projectValues,
					"salaryTotalAll" => round($salaryTotalAll, $conf['decimal']['precision']),
					"mainScheduleTotalAll" => round($mainScheduleTotalAll, $conf['decimal']['precision'])  // ."({$salaryIncludeMainTotalAll})",
						));
			$t->parse("Rows", "Row", true);
			$j++;
			$salaryTotalAll = 0;
			$salaryIncludeMainTotalAll = 0;
			$mainScheduleTotalAll = 0;
			$taTotal = 0;
			$projectValues = GetProjectValuesTemplate($complateJobNos);
		}
		$tempSalarys[$v['surveyorCode']][$v['complateJobNo']] = $v;
		$projectValues = ReplaceProjectValues($projectValues, $v);
		$taTotal = $v['transportExpenses'];
		$salaryTotal = $v['salaryTotal'];
		$salaryTotalAll += $salaryTotal;
		if (in_array($v['complateJobNo'], $conf['complateJobNo']))
		{
			$salaryIncludeMainTotalAll += $salaryTotal;
		}
		$mainScheduleTotalAll += $v['wagesTaOnBoard']; // +$v['transportExpenses'];
		$vl = $v;
		$i++;
	}
}
if ($j % 2 == 0)
	$listStyle = "AlternatingItemStyle";
else
	$listStyle = "DgItemStyle";

$projectValues = EmptyProjectValues($projectValues, $complateJobNos);
$t->set_var(array(
		"listStyle" => $listStyle,
		"surveyorCode" => $vl['surveyorCode'],
		"engName" => $vl['engName'],
		"contact" => $vl['contact'],
		"projectValues" => $projectValues,
		"salaryTotalAll" => round($salaryTotalAll, $conf['decimal']['precision']),
		"mainScheduleTotalAll" => round($mainScheduleTotalAll, $conf['decimal']['precision'])  // ."({$salaryIncludeMainTotalAll})",
));
$t->parse("Rows", "Row", true);

$historyStyle = 'display:none;';
$historyDate = date($conf['date']['format']);

// 下載/锁定/審核/撤消
$oshl = new OtherSalaryHistoryLog();
$oshl->backupMonth = $ddlMonth;
$oshl->backupType = $salaryType;
$oshl->isApproval = '';
$oshla = new OtherSalaryHistoryLogAccess($db);
$rs = $oshla->GetListSearch($oshl);
$lockStyle = "display:none;";
$approvalStyle = "display:none;";
$unlockStyle = "display:none;";
$unapprovalStyle = "display:none;";
if (empty($rs))
{
	$lockStyle = "";
}
else
{
	$oshl = $rs[0];
	
	$historyDate = date($conf['date']['format'], strtotime($oshl->inputTime));
	$historyStyle = '';
	
	if ($oshl->isApproval == 'no')
	{
		$approvalStyle = "";
		$unlockStyle = "";
	}
	else
	{
		$unapprovalStyle = "";
	}
}
if (!UserLogin::HasPermission("salary_lock"))
{
	$lockStyle = "display:none;";
}
if (!UserLogin::HasPermission("salary_approval"))
{
	$approvalStyle = "display:none;";
}
if (!UserLogin::HasPermission("salary_unlock"))
{
	$unlockStyle = "display:none;";
}
if (!UserLogin::HasPermission("salary_unapproval"))
{
	$unapprovalStyle = "display:none;";
}
$t->set_var(array(
		"historyStyle" => $historyStyle,
		"historyDate" => $historyDate,
		"saveExcelLink" => $saveExcelLink,
		"oshlId" => $oshl->oshlId,
		"lockStyle" => $lockStyle,
		"approvalStyle" => $approvalStyle,
		"unlockStyle" => $unlockStyle,
		"unapprovalStyle" => $unapprovalStyle 
));

$t->pparse("Output", "HdIndex");
?>