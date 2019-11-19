<?php
/*
 * Header: Create: 2008-03-01 Auther: Jamblues. M S N: jamblues@gmail.com
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
 * 初始化值模板
 * 
 * @param
 *        	$complateJobNos
 */
function GetProjectValuesTemplate($complateJobNos)
{
	$arr = array();
	foreach ( $complateJobNos as $k => $v )
	{
		$arr[$v]["surveyHour"] = "";
		$arr[$v]["wages"] = "";
		$arr[$v]["transportExpenses"] = "";
		$arr[$v]["salaryTotal"] = "";
	}
	return $arr;
}

/**
 *
 * 替指定的值换值
 * 
 * @param unknown_type $str        	
 * @param unknown_type $salary        	
 */
function ReplaceProjectValues($arr, $salary)
{
	$v = $salary["complateJobNo"];
	$arr[$v]["surveyHour"] = $salary["surveyHour"];
	$arr[$v]["wages"] = $salary["wages"];
	$arr[$v]["transportExpenses"] = $salary["transportExpenses"];
	$arr[$v]["salaryTotal"] = $salary["salaryTotal"];
	return $arr;
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

$tableName = 'Survey_MainSchedule';
$mshl = new MainScheduleHistoryLog();
$mshl->backupMonth = $ddlMonth;
$mshla = new MainScheduleHistoryLogAccess($db);
$rs = $mshla->GetListSearch($mshl);
if (!empty($rs))
{
	$mshl = $rs[0];
	$tableName = $mshl->tableName;
}

include_once ("../../library/init.php");
require_once '../../library/Spreadsheet/Excel/Writer.php';

$fileName = date("Y-m", strtotime($surDateStart)) . '-OZZO-Salary.xls';
// $fileName = $conf["path"]["excel"].date("Y-m",strtotime($surDateStart)).'-SW-Salary.xls';


// Creating a workbook
$wb = new Spreadsheet_Excel_Writer();
// sending HTTP headers
$wb->send($fileName);
// set version
$wb->setVersion(9);

// Ceating a format
$cuf = & $wb->addFormat();
$cuf->setUnderline(1);
$cuf->setAlign('center');

$rf = & $wb->addFormat();
$rf->setAlign('left');

$uf = & $wb->addFormat();
$uf->setUnderline(1);

$bf = & $wb->addFormat();
$bf->setBold();

$tlcbf = & $wb->addFormat();
$tlcbf->setTop(2);
$tlcbf->setBottom(2);
$tlcbf->setBold();
$tlcbf->setAlign('center');

$ltlcbf = & $wb->addFormat();
$ltlcbf->setLeft(2);
$ltlcbf->setTop(2);
$ltlcbf->setBottom(2);
$ltlcbf->setBold();
$ltlcbf->setAlign('center');

$rtlcbf = & $wb->addFormat();
$rtlcbf->setRight(2);
$rtlcbf->setTop(2);
$rtlcbf->setBottom(2);
$rtlcbf->setBold();
$rtlcbf->setAlign('center');

$cf = & $wb->addFormat();
$cf->setAlign('center');

$cfnumber = & $wb->addFormat();
$cfnumber->setAlign('center');
$cfnumber->setNumFormat("0");

$cbf = & $wb->addFormat();
$cbf->setBold();
$cbf->setAlign('center');

$ctf = & $wb->addFormat();
$ctf->setAlign('center');
$ctf->setTop(2);

$crf = & $wb->addFormat();
$crf->setRight(2);
$crf->setAlign('center');

$ctrf = & $wb->addFormat();
$ctrf->setTop(2);
$ctrf->setRight(2);
$ctrf->setAlign('center');

$clf = & $wb->addFormat();
$clf->setAlign('center');
$clf->setBottom(2);

$clrf = & $wb->addFormat();
$clrf->setAlign('center');
$clrf->setBottom(2);
$clrf->setRight(2);

$lrf = & $wb->addFormat();
$lrf->setBottom(2);
$lrf->setRight(2);

$trf = & $wb->addFormat();
$trf->setTop(2);
$trf->setRight(2);

// Creating a worksheet
$ws = & $wb->addWorksheet('Traffic_Code');

$ws->setColumn(1,4,20);

// 获取数据
$complateJobNos = array();
foreach ( $conf['surveytime'] as $k => $v )
{
	$complateJobNos[] = $k;
}

// 系統主要項目.
$survType = "surveyor";
$sql = "SELECT m.surveyorCode,s.engName,s.bank,s.accountNo,s.contact,s.IsSupervisor,complateJobNo,SUM(totalWages) AS totalWages
	,SUM(taTotal) AS taTotal,SUM(estimatedManHour) AS estimatedManHour,SUM(onBoardCostFare*noOfTrips) AS OnBoardCost
	,SUM(wagesTaOnBoard) AS wagesTaOnBoard FROM {$tableName} m
	INNER JOIN Survey_Surveyor s ON m.surveyorCode=s.survId
	WHERE 1=1 
	  AND DATE_FORMAT(plannedSurveyDate,'%Y-%m-%d') >= '" . $surDateStart . "' 
	  AND DATE_FORMAT(plannedSurveyDate,'%Y-%m-%d') < '" . $surveyDateEnd . "'
	  AND survType='{$survType}'
	  GROUP BY surveyorCode,engName,contact,complateJobNo
	  ORDER BY CAST(surveyorCode AS SIGNED) ASC";
$db->query($sql);
// echo $sql;exit();
$salarys = array();
while ( $db->next_record() )
{
	$salary['surveyorCode'] = $db->Record['surveyorCode'];
	$salary['engName'] = $db->Record['engName'];
	$salary['bank'] = $db->Record['bank'];
	$salary['accountNo'] = $db->Record['accountNo'];
	$salary['contact'] = $db->Record['contact'];
	$salary['IsSupervisor'] = $db->Record['IsSupervisor'];
	$salary['surveyHour'] = $db->Record['estimatedManHour'];
	$salary['complateJobNo'] = $db->Record['complateJobNo'];
	$salary['wages'] = round($db->Record['totalWages'], $conf['decimal']['precision']);
	;
	$salary['transportExpenses'] = round(($db->Record['taTotal'] + $db->Record['OnBoardCost']), $conf['decimal']['precision']);
	;
	$salary['wagesTaOnBoard'] = round($db->Record['wagesTaOnBoard'], $conf['decimal']['precision']);
	$salary['salaryTotal'] = round(($db->Record['totalWages'] + $salary['transportExpenses']), $conf['decimal']['precision']);
	$salary['isOtherProject'] = 0;
	$salarys[$salary['surveyorCode'] . "_" . $salary['complateJobNo']] = $salary;
	if (!in_array($salary['complateJobNo'], $complateJobNos))
	{
		$complateJobNos[] = $salary['complateJobNo'];
	}
}
// echo $sql;


// Other projects
$salaryType = "surveyor";
$sql = "SELECT surveyorId as surveyorCode,s.engName,s.bank,s.accountNo,s.contact,s.IsSupervisor,projectCode AS complateJobNo,SUM(wages) AS totalWages
	,SUM(transportExpenses) AS transportExpenses,SUM(surveyHour) AS estimatedManHour,0 AS OnBoardCost,0 AS wagesTaOnBoard 
	,SUM(total) AS salaryTotal FROM Survey_OtherSalary os
	INNER JOIN Survey_Surveyor s ON os.surveyorId=s.survId	 
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
	$salary['bank'] = $db->Record['bank'];
	$salary['accountNo'] = $db->Record['accountNo'];
	$salary['contact'] = $db->Record['contact'];
	$salary['IsSupervisor'] = $db->Record['IsSupervisor'];
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

// 项目名称
$row = 0;
$row = $row + 1;
$colEnd = 0;
for($i = 0; $i < count($complateJobNos); $i++)
{
	$colStart = 5 + 4 * ($i);
	$colEnd = $colStart + 3;
	$ws->write($row, $colStart, $complateJobNos[$i], $cf);
	$ws->setMerge($row, $colStart, $row, $colEnd);
}

// 项目子标题
$row = $row + 1;
$ws->write($row, 0, "Code", $cf);
$ws->write($row, 1, "Name of surveyor", $cf);
$ws->write($row, 2, "Bank", $cf);
$ws->write($row, 3, "Account No.", $cf);
$ws->write($row, 4, "Contact of surveyor", $cf);
for($i = 0; $i < count($complateJobNos); $i++)
{
	$colStart = 5 + 4 * ($i);
	$ws->write($row, $colStart, "Hour", $cf);
	$ws->write($row, ($colStart + 1), "Wages", $cf);
	$ws->write($row, ($colStart + 2), "TE", $cf);
	$ws->write($row, ($colStart + 3), "Total", $cf);
}
$ws->write($row, ($colEnd + 1), "Total", $cf);
$ws->write($row, ($colEnd + 2), "Leader", $cf);
$ws->write($row, ($colEnd + 3), "Remark", $cf);

// 填充数据
$i = 0;
$j = 0;
$salaryTotal = 0;
$salaryTotalAll = 0;
$surveyor = array();
$projectValues = GetProjectValuesTemplate($complateJobNos);
foreach ( $salarys as $k => $v )
{
	if ($i > 0 && $vl['surveyorCode'] != $v['surveyorCode'])
	{
		// $projectValues = EmptyProjectValues($projectValues,$complateJobNos);
		$row = $row + 1;
		$ws->write($row, 0, $vl['surveyorCode'], $cf);
		$ws->write($row, 1, $vl['engName'], $cf);
		$ws->write($row, 2, $vl['bank'], $cf);
		$ws->writeString($row, 3, $vl['accountNo'], $cf);
		$ws->write($row, 4, $vl['contact'], $cf);
		$colStart = 0;
		for($m = 0; $m < count($complateJobNos); $m++)
		{
			$colStart = 5 + 4 * ($m);
			$ws->write($row, $colStart, $projectValues[$complateJobNos[$m]]["surveyHour"], $cf);
			$ws->write($row, ($colStart + 1), $projectValues[$complateJobNos[$m]]["wages"], $cf);
			$ws->write($row, ($colStart + 2), $projectValues[$complateJobNos[$m]]["transportExpenses"], $cf);
			$ws->write($row, ($colStart + 3), $projectValues[$complateJobNos[$m]]["salaryTotal"], $cf);
		}
		$ws->write($row, ($colStart + 4), round($salaryTotalAll, $conf['decimal']['precision']), $cf);
		$ws->write($row, ($colStart + 5), $vl['IsSupervisor'], $cf);
		$ws->write($row, ($colStart + 6), "SALARY ".date("Ym", strtotime($surDateStart)), $cf);
		$salaryTotalAll = 0;
		$taTotal = 0;
		$projectValues = GetProjectValuesTemplate($complateJobNos);
	}
	$projectValues = ReplaceProjectValues($projectValues, $v);
	$taTotal = $v['transportExpenses'];
	$salaryTotal = $v['salaryTotal'];
	$salaryTotalAll += $salaryTotal;
	$i++;
	$vl = $v;
}

// the last row.
$row = $row + 1;
$ws->write($row, 0, $vl['surveyorCode'], $cf);
$ws->write($row, 1, $vl['engName'], $cf);
$ws->write($row, 2, $vl['bank'], $cf);
$ws->writeString($row, 3, $vl['accountNo'], $cf);
$ws->write($row, 4, $vl['contact'], $cf);
$colStart = 0;
for($m = 0; $m < count($complateJobNos); $m++)
{
	$colStart = 5 + 4 * ($m);
	$ws->write($row, $colStart, $projectValues[$complateJobNos[$m]]["surveyHour"], $cf);
	$ws->write($row, ($colStart + 1), $projectValues[$complateJobNos[$m]]["wages"], $cf);
	$ws->write($row, ($colStart + 2), $projectValues[$complateJobNos[$m]]["transportExpenses"], $cf);
	$ws->write($row, ($colStart + 3), $projectValues[$complateJobNos[$m]]["salaryTotal"], $cf);
}
$ws->write($row, ($colStart + 4), round($salaryTotalAll, $conf['decimal']['precision']), $cf);
$ws->write($row, ($colStart + 5), $vl['IsSupervisor'], $cf);
$ws->write($row, ($colStart + 6), "SALARY ".date("Ym", strtotime($surDateStart)), $cf);

// Let's send the file
$wb->close();
?>
<?php

print "salary excel file has aready been created.<br /> " . "right click <a href='" . $fileName . "'>here</a> save target as.";

?>
