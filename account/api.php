<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2015-12-13
 * Time: 23:23
 */

include_once ("../includes/config.inc.php");

// 检查是否登录
if (SurveyorLogin::IsLogin())
{
    $surveyorCode = $_SESSION['surveyorId'];
}
else
{
    exit('Login timeout.');
}

$query = $_REQUEST ['q'];

switch ($query)
{
    case "selectJob" :
        //检测用户是否过期
        $s = new Surveyor ();
        $s->company = '';
        $s->status = '';
        $s->survId = $surveyorCode;

        $sa = new SurveyorAccess ( $db );
        $rs = $sa->GetListSearch ( $s );

        $s = $rs [0];

        $ms = new MainSchedule();
        $msa = new MainScheduleAccess($db);
        $ms->jobNoNewSigle = $_REQUEST['jobNoNew'];
        $jobrs = $msa->GetListSearch($ms);
        $v = $jobrs[0];
        if($v->realClass == 1){

            if($s->use_event == 0){
                $message = array (
                    'status' => 'failed',
                    'message' => '當前所選活動錯誤',
                    'data' => array()
                );
                die(json_encode($message));
            }else{
                $event = $s->use_event;
                $vip_end_date = 'vip_end_date_'.$event;
                if(!empty($s->$vip_end_date)){

                    if(strtotime($s->$vip_end_date) > time()){

                    }else{
                        $message = array (
                            'status' => 'failed',
                            'message' => '您的會員已過期，請聯係管理員',
                            'data' => array()
                        );
                        die(json_encode($message));
                    }
                }else{
                    $message = array (
                        'status' => 'failed',
                        'message' => '您還不是會員，請聯係管理員開通會員權限',
                        'data' => array()
                    );
                    die(json_encode($message));
                }
            }

            /*
             * 修改会员制度，由之前的课堂数换成年度季度会员，不判断会员数
             * $chargedLimit = 4;

            $sql = "SELECT sc.config_value FROM Survey_Config as sc
WHERE 1=1 and config_name = 'chargedLimit' ";
            $db->query ( $sql );
            if($chargedLimit_rs = $db->next_record()){
                $chargedLimit = $chargedLimit_rs['config_value'];
            }


            if($s->class_remain <= 0-$chargedLimit ){
                $message = array (
                    'status' => 'failed',
                    'message' => '所欠課堂數已達上限，選取失敗',
                    'data' => array()
                );
                die(json_encode($message));
            }


            if($s->class_remain <= 0-$chargedLimit ){
                $message = array (
                    'status' => 'failed',
                    'message' => '所欠課堂數已達上限，選取失敗',
                    'data' => array()
                );
                die(json_encode($message));
            }*/
        }


        $jobNoNew = $_REQUEST['jobNoNew'];
        $jobNoNew2 = $_REQUEST['jobNoNew2'];
        $jobNoNew3 = $_REQUEST['jobNoNew3'];
        $jobNoNew4 = $_REQUEST['jobNoNew4'];
        if($v->is_image == 1){
            $identifier=false;
        }else{
            $identifier=true;
        }

        //调用此处检测是否加入购物车
        $jobNoNewArr = array($jobNoNew,$jobNoNew2,$jobNoNew3,$jobNoNew4);

        if($identifier){
            //检测是否有冲突
            $isBusy = false;
            $currJobNoNews = array();
            foreach ($jobNoNewArr as $item) {
                if (!empty($item)) {
                    $currJobNoNews[] = $item;
                    $_tmpIsBusy = _checkIsBusy($db,$surveyorCode,$item);

                    if($_tmpIsBusy) {
                        $isBusy = $_tmpIsBusy;
                        break;
                    }
                }
            }

            if($isBusy) {
                $message = array (
                    'success' => false,
                    'message' => '課堂時間衝突'
                );
                die(json_encode($message));
            }
        }
        if (!empty($s))
        {
            $sur = $rs[0];
        }
        if($identifier){
            //檢查項目是否已經被人領取
            $msoa = new MainScheduleOpenAccess($db);

            $_tmpInJobNoNews = "'" . implode("','", $currJobNoNews) . "'";
            $existJobNoNews = $msoa->GetOpenJobNoNews($_tmpInJobNoNews);
            $isOtherSelectedJob = false;
            foreach($existJobNoNews as $item){
                if(!empty($item['applySurvId'])){
                    $isOtherSelectedJob = true;
                    break;
                }
            }

            if($isOtherSelectedJob){
                $message = array (
                    'success' => false,
                    'message' => '抱歉，該課堂已被其他學員搶先一步。'
                );
                die(json_encode($message));
            }
        }

        //檢查通過, 直接插入數據.
        $mso = new MainScheduleOpen();
        $mso->applySurvId =$surveyorCode;
        $mso->applyTime = date("Y-m-d H:i:s");
        $msoa = new MainScheduleOpenAccess($db);
        foreach ($jobNoNewArr as $item) {
            if (!empty($item)) {
                $mso->jobNoNew = $item;
                $msoa->Apply($mso);
            }
        }

        $res = autoAssign($sur, $jobNoNew);

        if($res){
            $message = array (
                'success' => true,
                'message' => '恭喜您，報名成功!'
            );
            echo json_encode($message);
            break;
        }else{
            $message = array (
                'success' => false,
                'message' => 'Unknow Error'
            );
            echo json_encode($message);
            break;
        }
}

function _checkIsBusy($db,$surveyorCode,$jobNoNew) {
    //检测一下调查时间是否有冲突
    $ms = new MainSchedule();
    $msa = new MainScheduleAccess($db);
    $ms->jobNoNewSigle = $jobNoNew;
    $rs = $msa->GetListSearch($ms);
    $v = $rs[0];
    //檢測是否已經有同一時間段的Job
    //if($v->plannedSurveyDate != '0000-00-00'){
        $isBusy = $msa->IsBusyTime($surveyorCode,$v->plannedSurveyDate,$v->startTime_1,$v->endTime_1);
    //}
    return $isBusy;
}

function autoAssign($sur, $jobNoNew,$record_surveyor = false)
{

    global $db;
    $assignHour = 0;
    $delSql = "UPDATE Survey_SurveyorMainSchedule SET delFlag='yes' WHERE ";
    if (is_array($jobNoNew))
    {
        $sql = "INSERT INTO Survey_SurveyorMainSchedule(survId,jobNoNew,inputUserId,inputTime)" . " VALUES";
        $i = 0;
        $delSqlWhere = "jobNoNew IN ('0'";
        foreach ( $jobNoNew as $v )
        {
            if ($i > 0)
            {
                $sql .= ",";
            }
            $sql .= "('{$sur->survId}','{$v}','{$_SESSION['userId']}','" . date("Y-m-d H:i:s") . "')";
            $delSqlWhere .= ",'{$v}'";
            $i++;
        }
        $delSqlWhere .= ")";
    }
    else
    {
        $sql = "INSERT INTO Survey_SurveyorMainSchedule(survId,jobNoNew,inputUserId,inputTime)" . " VALUES('" . $sur->survId . "'" . ",'" . $jobNoNew . "'" . ",'" . 1 . "'" . ",'" . date("Y-m-d H:i:s") . "'" . ")";
        $delSqlWhere = " jobNoNew='{$jobNoNew}'";
    }
    $delSql .= $delSqlWhere;

    $db->query($delSql);
    $db->query($sql);

    // 更新MainSchedule
    $ms = new MainSchedule();
    $ms->jobNoNew = $jobNoNew;
    $msa = new MainScheduleAccess($db);
    $msa->Assign2Surveyor($sur, $jobNoNew,true,$sur);//写入住数据库计划

    $assignHour = $msa->GetEstimatedManHour($ms);
    $assignHour = 0 - $assignHour;

    // 更新MainScheduleOpen
    $msoa = new MainScheduleOpenAccess($db);
    $msoa->UpdateAllStatus($sur->survId, $jobNoNew);


    // 更新統計時間
    //$sa = new SurveyorAccess ( $db );
    //$res = $sa->UpdateSingleSurveyorWorkHour($sur->survId, $assignHour);
    return true;
}