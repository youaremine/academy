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
if (! UserLogin::IsLogin ()) {
	header ( "Location:../login.php" );
	exit ();
}

$t = new CacheTemplate ( "../templates/salary" );
$t->set_file ( "HdIndex", "other-salary-entry.html" );
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();

$t->set_block ( "HdIndex", "Row", "Rows" );

$t->set_var ( array (
		"sSurveyDate" => $surveyDate,
		"sProjectCode" => $projectCode,
		"sProjectName" => $projectName,
		"sSurveyorId" => $surveyorId,
		"sSurveyorEngName" => $surveyorEngName,
		"sSurveyorContanct" => $surveyorContanct,
		"sSurveyorHome" => $surveyorHome
) );

$survType = "surveyor";
if(!empty($_GET["survType"]))
{
	$survType = $_GET["survType"];
}
	

$attachment = '';
if (empty ( $_REQUEST ['btnSubmit'] )) {
	// 显示要输入的行数
	for($i = 0; $i < $conf ['input'] ['rowNumber']; $i ++) {
		$t->set_var ( array (
				"i" => $i,
				"otId" => '',
				"surveyorId" => '',
				"surveyorEngName" => '',
				"projectCode" => '',
				"projectName" => '',
				"surveyDate" => '',
				"startTime" => '',
				"endTime" => '',
				"restHour" => 0,
				"surveyHour" => '',
				"hourlyRate" => '',
				"wages" => '',
				"transportExpenses" => 0,
				"total" => '',
				"remarks" => '',
				"salaryType" => $survType,
				"delFlag" => 'no',
				"attachment" => $attachment 
		) );
		$t->parse ( "Rows", "Row", true );
	}
} else {
	$surveyDateStart = $_GET ['sSurveyDateStart'];
	$surveyDateEnd = $_GET ['sSurveyDateEnd'];
	$projectCode = $_GET ['sProjectCode'];
	$projectName = $_GET ['sProjectName'];
	$surveyorId = $_GET ['sSurveyorId'];
	$surveyorEngName = $_GET ['sSurveyorEngName'];
	$surveyorContanct = $_GET ['sSurveyorContanct'];
	$surveyorHome = $_GET ['sSurveyorHome'];
	$o = new OtherSalary ();
	$o->projectCode = $projectCode;
	$o->surveyorId = $surveyorId;
	$o->surveyDateStart = $surveyDateStart;
	$o->surveyDateEnd = $surveyDateEnd;
	$o->auditStatus = "";
	$o->order = $order;
	$oa = new OtherSalaryAccess ( $db );
	$rs = $oa->GetListSearch ( $o );
	$rsNum = count ( $rs );
	for($i = 0; $i < $rsNum; $i ++) {
		$o = $rs [$i];
		$readonlyStyle = "";		
		$attachment = "<img src='../images/addfile.gif' onclick=\"OpenUpload('" . $o->otId . "');\" style=\"cursor:pointer;\" />";
		if($o->auditStatus == "audited")
		{
			if(!UserLogin::HasPermission("other_salary_audit"))
			{
				$readonlyStyle = " disabled=\"disabled\"";
				$attachment = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		}

		if (empty ( $o->attachment )) {
			$attachment .= '<img src="../images/attachment.png" title="no attachment" />';
		}
		else 
		{
			$attachment .= '&nbsp;<a href="' . $o->attachment . '" target="_blank"><img src="../images/attachment-c.png" title="attachment" /></a>';
		}
		
// 		echo $readonlyStyle."<br />";
		$t->set_var ( array (
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
				"salaryType" => $o->salaryType,
				"delFlag" => 'no',
				"readonlyStyle" => $readonlyStyle,
				"attachment" => $attachment 
		) );
		$t->parse ( "Rows", "Row", true );
	}
}

$t->set_var ( "allRowNo", $conf ['input'] ['rowNumber'] - 1 );

$t->pparse ( "Output", "HdIndex" );