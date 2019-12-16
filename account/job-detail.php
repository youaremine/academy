<?php
/*
 * Header:
 * Create: 2015-12-06
 * Auther: Jamblues.
 */

include_once ("../includes/config.inc.php");
include_once ("../includes/config.plugin.inc.php");

$btnDetailConfirmStatus = 'disabled="disabled"';
$btnDetailConfirmText = '聯繫Whatsapp:<br />92091806開通';
$btnClass = 'btn-danger';
$successBtnStyle = 'display:none';
// 检查是否登录
if (SurveyorLogin::IsLogin())
{
	$surveyorCode = $_SESSION['surveyorId'];
	//$selfBefore = $_SESSION['surveyorSelfBefore'];
	//if(empty($selfBefore) || strtotime($selfBefore) < time()){
		$btnDetailConfirmStatus = "";
		$btnDetailConfirmText = '選取本課堂';
	//}
	$noCurrUser = "";
}
else if (UserLogin::IsAdministrator() && !empty($_GET['surveyorId']))
{
	$surveyorCode = $_GET['surveyorId'];
	$noCurrUser = "display:none;";
}
else
{
	header("Location:../surveyor_login.php");
	exit();
}



$t = new CacheTemplate("../templates/account");
$t->set_file("HdIndex", "job-detail.html");
$t->set_caching($conf["cache"]["valid"]);
$t->set_cache_dir($conf["cache"]["dir"]);
$t->set_expire_time($conf["cache"]["timeout"]);
$t->print_cache();

$t->set_var("SITEVESION",SITEVESION);

// 设置更改密码，登出
$t->set_var("noCurrUser", $noCurrUser);

$tmpcount = strlen($conf['auth']['slat']);

if(isset($_GET['random']) && $_GET['random'] == true){
    if(isset($_GET['jobno']) && !empty($_GET['jobno'])){

        //获取该课堂类型的选取情况
        $get_empty_sql = "SELECT jobNoNew,surveyorCode FROM Survey_MainSchedule where jobNo = '{$_GET['jobno']}' ";
        if(isset($_GET['vehicle']) && !empty($_GET['vehicle'])){
            $get_empty_sql .= " and vehicle = '{$_GET['vehicle']}'";
        }

        $surveyorCodes = array();

        $db->query ( $get_empty_sql );
        while ( $rs = $db->next_record () ) {
            $surveyorCodes[$rs['jobNoNew']] = $rs['surveyorCode'];
        }
        //判断是否有选本课堂
        $jobNoNew = '';
        $myClass = false;
        if(in_array($surveyorCode,$surveyorCodes)){
            $getJobNoNewArr = array_flip($surveyorCodes);
            $jobNoNew = $getJobNoNewArr[$surveyorCode];
            $myClass = true;
        }else{

            //判断该课堂是否已全部被选完
            foreach($surveyorCodes as $sk=>$sv){
                if($sv == ''){
                    $jobNoNew = $sk;
                    break;
                }
            }
        }

        $type = 'opening';
        if(empty($jobNoNew)){
            $t->set_file("HdIndex", "job-detail2.html");
            $t->pparse("Output", "HdIndex");
            exit;
        }

    }else{
        echo "ERROR PAGE";
        exit;
    }
}else{
    $jobNoNew = substr(base64_decode($_REQUEST['jobNoNew']),$tmpcount);
    $type = $_GET['type'];
}


$t->set_block("HdIndex", "JobRow", "JobRows");
$t->set_var("JobRows", "");
$t->set_var('type',$type);

//查询调查类型对应的中文名
$surveyTypeCnName = getArray('survey-type-cn-name');

//查詢噹前調查的詳細資料
$mso = new MainScheduleOpen();
$msoa = new MainScheduleOpenAccess($db);
$mso->jobNoNew = $jobNoNew;
$rs = $msoa->GetListSearch($mso);
$relationTableStyle = "display:none;";
if($type == 'opening'){
	$confirmBtnStyle = "";
}else{
	$confirmBtnStyle = "display:none;";
}
$pdfLink = $conf ["plugin"] ["download_pdf_host"].'pdf/blankdata/';
if(count($rs) > 0){
	$mso = $rs[0];
	$ms = new MainSchedule();
	$msa = new MainScheduleAccess($db);
	$ms->jobNoNewSigle = $jobNoNew;
	$rs = $msa->GetListSearch($ms);
	$v = $rs[0];
	$v->surveyType = trim($v->surveyType);
	$t->set_var ( array (
			"mscId" => $v->mscId,
			"weekNo" => $v->weekNo,
			"jobNo" => $v->jobNo,
			"jobNoNew" => $v->jobNoNew,
			"plannedSurveyDate" => $v->plannedSurveyDate,
			"surveyTimeHours" => $v->surveyTimeHours,
			"surveyType" => $surveyTypeCnName[$v->surveyType]?$surveyTypeCnName[$v->surveyType]:$v->surveyType,
            "surveyVehicle" => $v->vehicle,
			"surveyLocation" => $v->surveyLocationCn?$v->surveyLocationCn:$v->surveyLocation,
			"routeItems" => $v->routeItems,
			"direction" => $v->direction,
			"estimatedManHour" => $v->estimatedManHour,
			"pdfLink" => $pdfLink.$conf['districtName'][$v->complateJobNo].'/'.$v->jobNo.'/'.$v->jobNoNew.'.pdf'
	) );

	if($myClass == false){
        if(empty($v->plannedSurveyDate)) {
            $confirmBtnStyle = "display:none;";
        }

        //檢測是否已經有同一時間段的Job
        //if($v->plannedSurveyDate != '0000-00-00'){
        $isBusy = $msa->IsBusyTime($surveyorCode,$v->plannedSurveyDate,$v->startTime_1,$v->endTime_1);
        if($isBusy && $btnDetailConfirmStatus == ''){
            $btnDetailConfirmStatus = 'disabled="disabled"';
            $btnDetailConfirmText = '課堂時間與<br />已選取的衝突';
        }
        //}
    }else{
        $confirmBtnStyle = "display:none;";
        $btnClass = 'btn-success';
        $successBtnStyle = '';
        $btnDetailConfirmStatus = '';
        $btnDetailConfirmText = '已選取本課堂';
    }


	//判斷是否有關聯調查項目多个
	if(!empty($mso->batchNumber)){
		$mso1 = new MainScheduleOpen();
		$mso1->batchNumber = $mso->batchNumber;
		$msoa1 = new MainScheduleOpenAccess($db);
		$rs1 = $msoa1->GetListSearch($mso1);
		$relationJobNoNews = array();
		foreach ($rs1 as $item) {
			$relationJobNoNews[] = $item->jobNoNew;
		}
		$ms->jobNoNewSigle = $relationJobNoNews;
		$rs = $msa->GetListSearch($ms);
		$rowId = 1;
		foreach($rs	as $v){
			if($v->jobNoNew == $jobNoNew){ continue; }
			$v->surveyType = trim($v->surveyType);
			$rowId ++;
			$t->set_var ( array (
					"rowId" => $rowId,
					"mscId_2" => $v->mscId,
					"weekNo_2" => $v->weekNo,
					"jobNo_2" => $v->jobNo,
					"jobNoNew_2" => $v->jobNoNew,
					"plannedSurveyDate_2" => $v->plannedSurveyDate,
					"surveyTimeHours_2" => $v->surveyTimeHours,
					"surveyType_2" => $surveyTypeCnName[$v->surveyType]?$surveyTypeCnName[$v->surveyType]:$v->surveyType,
					"surveyLocation_2" => $v->surveyLocationCn?$v->surveyLocationCn:$v->surveyLocation,
					"routeItems_2" => $v->routeItems,
					"direction_2" => $v->direction,
					"estimatedManHour_2" => $v->estimatedManHour,
					"pdfLink_2" => $pdfLink.$conf['districtName'][$v->complateJobNo].'/'.$v->jobNo.'/'.$v->jobNoNew.'.pdf'
			) );
			$t->parse("JobRows", "JobRow", true);
		}
	}
}else{
	$ms = new MainSchedule();
	$msa = new MainScheduleAccess($db);
	$ms->jobNoNewSigle = $jobNoNew;
	$rs = $msa->GetListSearch($ms);
	$v = $rs[0];
	$v->surveyType = trim($v->surveyType);
	$t->set_var( array (
			"mscId" => $v->mscId,
			"weekNo" => $v->weekNo,
			"jobNo" => $v->jobNo,
			"jobNoNew" => $v->jobNoNew,
			"plannedSurveyDate" => $v->plannedSurveyDate,
			"surveyTimeHours" => $v->surveyTimeHours,
			"surveyType" => $surveyTypeCnName[$v->surveyType]?$surveyTypeCnName[$v->surveyType]:$v->surveyType,
            "surveyVehicle" => $v->vehicle,
			"surveyLocation" => $v->surveyLocationCn?$v->surveyLocationCn:$v->surveyLocation,
			"routeItems" => $v->routeItems,
			"direction" => $v->direction,
			"estimatedManHour" => $v->estimatedManHour,
			"pdfLink" => $pdfLink.$conf['districtName'][$v->complateJobNo].'/'.$v->jobNo.'/'.$v->jobNoNew.'.pdf'
	) );
    //if($v->plannedSurveyDate != '0000-00-00'){
        $confirmBtnStyle = "display:none;";
    //}

}
$t->set_var("confirmBtnStyle",$confirmBtnStyle);
$t->set_var("btnDetailConfirmStatus",$btnDetailConfirmStatus);
$t->set_var("btnDetailConfirmText",$btnDetailConfirmText);
$t->set_var("btnClass",$btnClass);
$t->set_var("successBtnStyle",$successBtnStyle);
$t->pparse("Output", "HdIndex");
?>