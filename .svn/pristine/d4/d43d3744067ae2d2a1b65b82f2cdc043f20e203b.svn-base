<?php
/*
 * Header: 
 * Create: 2008-9-2 
 * Auther: Jamblues.
 */
include_once("./includes/config.inc.php");
include_once("./includes/config.plugin.inc.php");

// 检查是否登录
if (!UserLogin::IsLogin()) {
    header("Location:login.php");
    exit ();
}

$t = new CacheTemplate ("./templates");
$t->set_file("HdIndex", "main_schedule_list.html");
$t->set_caching($conf ["cache"] ["valid"]);
$t->set_cache_dir($conf ["cache"] ["dir"]);
$t->set_expire_time($conf ["cache"] ["timeout"]);
$t->print_cache();
$t->set_block("HdIndex", "Row", "Rows");
$t->set_block("HdIndex", "MonthRow", "MonthRows");
$t->set_block("HdIndex", "CompanyRow", "CompanyRows");
$t->set_var("Rows", "");
$t->set_var("SITEVESION",SITEVESION);

// singup company
$companys = getArray('company');
foreach ($companys as $k => $v) {
    $t->set_var(array("companyCode" => $k, "companyName" => $v));
    $t->parse("CompanyRows", "CompanyRow", true);
}

// to excel part
$canDoDistrict = UserLogin::CanDoDistrict();
$tempDoDist = explode(",", $canDoDistrict);
$tempDoDistNum = count($tempDoDist);
for ($i = 1; $i < $tempDoDistNum; $i++) {
    $tempDdlDistId = $tempDoDist [$i];
    $toExcelLink .= "&nbsp;&nbsp;<a href='to-excel/main_schedule_list_to_excel.php?ddlDistId={$tempDdlDistId}'>{$conf['shortDistrictName'][$tempDdlDistId]}</a>";
}
$t->set_var("toExcelLink", $toExcelLink);

$ms = new MainSchedule ();
if ($_GET ["txtJobNoNew"] != "") {
    $ms->jobNoNew = $_GET ["txtJobNoNew"];
}
if ($_GET ["txtRouteNo"] != "") {
    $ms->routeItems = $_GET ["txtRouteNo"];
}
if ($_GET ["txtSurveyorCode"] != "") {
    $ms->surveyorCode = $_GET ["txtSurveyorCode"];
}
if (isset ($_GET ["txtPlannedSurveyDateStart"])) {
    $ms->plannedSurveyDateStart = $_GET ["txtPlannedSurveyDateStart"];
} else {
    //$ms->noPlannedSurveyDate = true;
    $ms->plannedSurveyDateStart = date($conf ['date'] ['format'], mktime(0, 0, 0, date("m") - 1, date("d"), date("Y")));
}
if (isset ($_GET ["txtPlannedSurveyDateEnd"])) {
    $ms->plannedSurveyDateEnd = $_GET ["txtPlannedSurveyDateEnd"];
} else {
    $ms->plannedSurveyDateEnd = date($conf ['date'] ['format'], strtotime("+21 day"));
}

if ($ms->jobNoNew != "" || $ms->routeItems != "") {
    $ms->plannedSurveyDateStart = "";
    $ms->plannedSurveyDateEnd = "";
}
if ($_GET ["ddlDistId"] != "") {
    $ms->doDistrict = '1,' . $_GET ["ddlDistId"];
}
if (!empty($_REQUEST['isAssigned'])) {
    $ms->isAssigned = $_REQUEST ['isAssigned'] == 'true' ? true : false;
}
if (!empty($_REQUEST ['isSelected'])) {
    $ms->isSelected = $_REQUEST ['isSelected'] == 'true' ? true : false;
}
$readOnlyStyle = "";
if (UserLogin::IsReadOnly()) {
    $readOnlyStyle = "display:none;";
    $ms->doDistrict = UserLogin::CanDoDistrict();
} else {
    $ddlDistIdSelect = GetdoDistrictSelect();
    $t->set_var("ddlDistIdSelect", $ddlDistIdSelect);
}

//
$plannedSurveyDateStyle = 'display:none;';
if (UserLogin::HasPermission("planned_survey_date_assign")) {
    $plannedSurveyDateStyle = "";
}
// 设置搜索部分
$t->set_var(array("readOnlyStyle" => $readOnlyStyle, "plannedSurveyDateStyle" => $plannedSurveyDateStyle, "txtJobNoNew" => $ms->jobNoNew, "txtRouteNo" => $ms->routeItems, "txtSurveyorCode" => $ms->surveyorCode, "txtPlannedSurveyDateStart" => $ms->plannedSurveyDateStart, "txtPlannedSurveyDateEnd" => $ms->plannedSurveyDateEnd, "ddlDistId" => $_GET ["ddlDistId"]));

// 只读用户不显示输入员名称
$inputUserCol = "";
if (UserLogin::IsReadOnly()) {
    $inputUserCol = "display:none;";
}
$t->set_var("inputUserCol", $inputUserCol);

$msa = new MainScheduleAccess ($db);
$msca = new MainScheduleContractorAccess ($db);
// page setting
if (empty ($_SERVER ["QUERY_STRING"])) {
    $pageUrl = $_SERVER ["PHP_SELF"];
} else {
    $currUrl = $_SERVER ["PHP_SELF"] . "?" . $_SERVER ["QUERY_STRING"];
    if (strpos($currUrl, "&page")) {
        $arryPageUrl = explode("&page", $currUrl);
    } else {
        $arryPageUrl = explode("page", $currUrl);
    }
    $pageUrl = $arryPageUrl [0];
}
$page = $_GET ['page'] < 1 ? 1 : $_GET ['page'];
$msa->pageLimit = " LIMIT " . ($conf ['page'] ['pagesize'] * ($page - 1)) . "," . $conf ['page'] ['pagesize'];
if (UserLogin::HasPermission("main_schedule_contractor_all")) {
    $rowNum = $msa->GetListSearchCount($ms);
} else {
    $rowNum = $msca->GetMainScheduleListCount($ms);
}
$pageStr = Pagination($rowNum, $conf ['page'] ['pagesize'], $_GET ['page'], $pageUrl);
$t->set_var(array("pageSetting" => $pageStr));
$msa->order = "	ORDER BY plannedSurveyDate ASC,jobNoNew ASC";

if (UserLogin::HasPermission("main_schedule_contractor_all")) {
    $rs = $msa->GetListSearch($ms);
} else {
    $rs = $msca->GetMainScheduleListSearch($ms);
}

$jobNoNews = "";
foreach ($rs as $k => $v) {
    $jobNoNews .= ",'{$v->jobNoNew}'";
}
$jobNoNews = substr($jobNoNews, 1);
//系统委派的调查
$sa = new SurveyorAccess ($db);
$systemJobNoNews = $sa->GetSystemAssignJobNoNews($jobNoNews);
//系统更改调查时间
$mspa = new MainSchedulePlannedDateAccess($db);
$systemPlannedDates = $mspa->GetSystemChangeJobNoNews($jobNoNews);

//是否开放让用户自主选择
$msoa = new MainScheduleOpenAccess($db);
$openJobs = $msoa->GetOpenJobNoNews($jobNoNews);

//是否已经有奖金
$osa = new OtherSalaryAccess($db);
$bonusResult = $osa->GetListByJobNoNews($jobNoNews);

$blankdataLink = $conf ["plugin"] ["download_pdf_host"].'pdf/blankdata/';

$rsNum = count($rs);
$totalEstimatedManHour = 0;

$ul = new UsersList($db);
$ul->delFlag = '';
$rsUser = $ul->GetListSearch();
$users = array();
foreach($rsUser as $v){
    $users[$v->userId] = $v->engName;
}
for ($i = 0; $i < $rsNum; $i++) {
    if ($i % 2 == 0) $listStyle = "AlternatingItemStyle"; else
        $listStyle = "DgItemStyle";
    $ms = $rs [$i];
    $rawFile = "<a href='javascript:void(0);'><img class='printHide' border='0' width='24' src='images/pdf-disable.jpg' /></a>";
    if ($ms->rawFile != "") {
        $ms->rawFile = str_replace("../", $conf ["plugin"] ["download_pdf_host"], $ms->rawFile);
        $downUrl = "plugin/raw_pdf_download_prc.php?userId=" . $_SESSION ['userId'] . "&jobNoNew=" . $ms->jobNoNew . "&downloadUrl=" . $ms->rawFile;
        $rawFile = "<a href='{$downUrl}' target='_blank'><img class='printHide' border='0' width='24' src='images/pdf.jpg' /></a>";
    }
    if (!UserLogin::IsAdministrator()) {
        $rawFile = '';
    }

    $totalOnBoardCostFare = $ms->onBoardCostFare * $ms->noOfTrips;
    $costHour = CalcOnBoardCostFare2Hour($ms->complateJobNo, $totalOnBoardCostFare);
    $totalEstimatedManHour += $ms->estimatedManHour + $costHour;

    $assignUserInfo = "";
    $plannedSurveyDateAssignUser = "";
    $assignStyle = $unAssignStyle = 'display:none;';
    if (UserLogin::HasPermission("planned_survey_date_assign")) {
        if (!empty ($ms->plannedSurveyDate)) {
            if (empty ($ms->surveyorCode)) {
                $assignStyle = "";
            } else {
                $unAssignStyle = "";
                $userId = $systemJobNoNews[$ms->jobNoNew]["inputUserId"];
                $assignUserInfo = $users[$userId];
                if (empty($assignUserInfo)) {
                    $assignUserInfo = "Main";
                    $title = "Assign by Main Schedule Excel.";
                } else {
                    $title = "Assign by {$assignUserInfo} at {$systemJobNoNews[$ms->jobNoNew]['inputTime']}.";
                }
                $assignUserInfo = "<span title='{$title}' style='color:#ddd'>({$assignUserInfo})</span>";
            }
            /*
            if($systemJobNoNews[$ms->jobNoNew]['survId'] == $ms->surveyorCode)
            {
                $unAssignStyle = "";
            }
            else
            {
                $unAssignStyle = "display:none;";
            }
            */
            $userId = $systemPlannedDates[$ms->jobNoNew]["inputUserId"];
            $plannedSurveyDateAssignUser = $users[$userId];
            if (empty($plannedSurveyDateAssignUser)) {
                $plannedSurveyDateAssignUser = "Main";
                $title = "Change by Main Schedule Excel.";
            } else {
                $title = "Change by {$plannedSurveyDateAssignUser} at {$systemPlannedDates[$ms->jobNoNew]['inputTime']}.";
            }
            $plannedSurveyDateAssignUser = "<span title='{$title}' style='color:#ddd'>({$plannedSurveyDateAssignUser})</span>";
        }
        $plannedSurveyDateAssign = "<a id='plannedSurveyDateChange_{$i}' href='#plannedSurveyDateDialog' rel='leanModal' title='Assign plannedSurveyDate'>
									<img class='printHide' src='images/kontact_date.png' width='24' border='0' />
									</a>{$plannedSurveyDateAssignUser}";
    } else {
        $plannedSurveyDateAssign = "";
    }

    $applySurvId = "";
    $openJobSyle = "display:none;";
    $openJobSyleDisable = "";
    $openJobSyleDisableTitle = "此調查不符合開放條件";
    if (UserLogin::HasPermission("planned_survey_date_assign")) {
        if (empty($openJobs[$ms->jobNoNew]) && empty($ms->surveyorCode)) {
            $openJobSyle = "";
            $openJobSyleDisable = "display:none;";
        } elseif (!empty($ms->surveyorCode)) {
            $openJobSyle = "display:none;";
            $openJobSyleDisable = "";
            $openJobSyleDisableTitle = "此調查不符合開放條件";
        } else {
            $openJobSyle = "display:none;";
            $openJobSyleDisable = "";
            $openJobSyleDisableTitle = "此調查已開放";
            if ($openJobs[$ms->jobNoNew]['applySurvId'] > 0) {
                $ms->surveyorCode = $openJobs[$ms->jobNoNew]['applySurvId'];
                $applyTime = $openJobs[$ms->jobNoNew]['applyTime'];
                $ms->surveyorName = $openJobs[$ms->jobNoNew]['applyEngName'];;
                $ms->surveyorTelephone = $openJobs[$ms->jobNoNew]['applyContact'];
                $title = "調查員自助申請，等待審批中...";
                $assignUserInfo = "<span title='{$title}' style='color:#FF0000'>(pending)</span>";
            }
//			$applySurvId = "<span title='{$title}' style='color:#ddd'>(1726)</span>";
        }
    } else {
        $openJobSyle = "display:none;";
        $openJobSyleDisable = "display:none;";
    }


// 	$contractorAssign = "";
// 	if (UserLogin::HasPermission ( "main_schedule_contractor_assign" ))
// 	{
// 		$contractorAssign = "<a id='{$i}' href='#signup' rel='leanModal' title='Assign Contractor'><img class='printHide' src='images/assigned_to.png' width='24' border='0' /></a>";
// 	}
    if (!empty ($ms->receiveDate)) $ms->receiveDate = date("Y-m-d H:i", strtotime($ms->receiveDate));
    if (UserLogin::IsReadOnly()) {
        $ms->surveyorName = '';
        $ms->surveyorTelephone = '';
        $ms->receiveDate = '';
    }
    //判断是否已经有过奖金
    $os = $bonusResult[$ms->jobNoNew];
    if(!empty($os)){
        if($os->auditStatus == 'audited'){
            $bonus = '<a href=""><img height="32" title="此奖金已被审核，不能修改！" src="./images/audited.png" /></a>';
        }else{
            $bonus = '<a href=""><img height="32" src="./images/audited.png" /></a>';
        }
    }else{
        $bonus = '<a href=""><img height="32" src="./images/audited_disagble.png" /></a>';
    }
    $t->set_var(array("i" => $i,
        "listStyle" => $listStyle,
        "openJobSyle" => $openJobSyle,
        "openJobSyleDisable" => $openJobSyleDisable,
        "openJobSyleDisableTitle" => $openJobSyleDisableTitle,
        "applySurvId" => $applySurvId,
        "mscId" => $ms->mscId,
        "companyCode" => $ms->company,
        "companyName" => $companys [$ms->company],
        "weekNo" => $ms->weekNo,
        "jobNo" => $ms->jobNo,
        "jobNoNew" => $ms->jobNoNew,
        "plannedSurveyDate" => $ms->plannedSurveyDate,
        "tdFileNo" => $ms->tdFileNo,
        "receivedDate" => $ms->receivedDate,
        "dueDate" => $ms->dueDate,
        "fromTD" => $ms->fromTD,
        "surveyTimeHours" => $ms->surveyTimeHours,
        "surveyType" => $ms->surveyType,
        "vehicle" => $ms->vehicle,
        "isHoliday" => $ms->isHoliday,
        "surveyLocation" => $ms->surveyLocation,
        "routeItems" => $ms->routeItems,
        "estimatedManHour" => $ms->estimatedManHour,
        "receiveDate" => $ms->receiveDate,
        "report" => $ms->report,
        "bonus" => $bonus,
        "surveyorCode" => $ms->surveyorCode,
        "surveyorName" => $ms->surveyorName,
        "surveyorTelephone" => $ms->surveyorTelephone,
        "rawFile" => $rawFile,
        "contractorAssign" => $contractorAssign,
        "plannedSurveyDateAssign" => $plannedSurveyDateAssign,
        "assignStyle" => $assignStyle,
        "unAssignStyle" => $unAssignStyle,
        "assignUserInfo" => $assignUserInfo,
        "direction" => $ms->direction,
        "blankdataLink" => $blankdataLink.$conf['districtName'][$ms->complateJobNo].'/'.$ms->jobNo.'/'.$ms->jobNoNew.'.pdf'
    ));
    $t->parse("Rows", "Row", true);
}
$totalEstimatedManHour = round($totalEstimatedManHour, 1);
$t->set_var("totalEstimatedManHour", $totalEstimatedManHour);

$t->pparse("Output", "HdIndex");
?>