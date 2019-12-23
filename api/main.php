
<?php
/**
 * about main schedule's me
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2012-12-14
 */
include_once("../includes/config.inc.php");

$rawJson = file_get_contents('php://input','r');

if(empty($rawJson)){
    $data = $_REQUEST;
    if(empty($data['channel'])){
        $data['channel'] = 0;
    }
}else{
    $data = json_decode($rawJson,TRUE);
    if(empty($data['q'])){
        $data['q'] = $_REQUEST ['q'];
    }
}

switch ($data['q']) {

    case "adpic":
        adpic($data);
        break;

    case "androidVersion" :
        $version = array();
        $version['version'] = '1.15';
        $version['url'] = 'http://files.ozzomap.com/apklink/android/InterAcademy/InterAcademyFootball_1.15.apk';
        $message = array (
            'status' => 'success',
            'msg' => '',
            'data' => $version
        );
        echo json_encode($message);
        break;

    case "IOSVersion" :
        echo json_encode(array('Version'=>'1.28'));
        break;

    case "Info" :
        $jobNo = $_REQUEST ['jobNo'];
        $jobNoNew = $_REQUEST ['jobNoNew'];
        if (!empty ($jobNo) || !empty ($jobNoNew)) {
            $m = new MainSchedule();
            $ma = new MainScheduleAccess($db);
            $m->jobNo = $jobNo;
            $m->jobNoNewSigle = $jobNoNew;
            $rs = $ma->GetListSearch($m);
            echo json_encode($rs);
        }
        break;
    case 'IsExist' :
        $refNo = $_REQUEST ['refNo'];
        if (!empty ($refNo)) {
            $spl = new SurveyPartList ($db);
            $spl->refNo = $refNo;
            $rs = $spl->GetListSearch();
            $rsNum = count($rs);
            if ($rsNum > 0) {
                $message = array('isExist' => 'true');
            } else {
                $message = array('isExist' => 'false');
            }
        } else {
            $message = array('isExist' => 'false');
        }
        echo json_encode($message);
        break;
    case 'assignContractor' :
        $msc = new MainScheduleContractor ();
        $msc->jobNoNew = $_REQUEST ['jobNoNew'];
        $msc->company = $_REQUEST ['company'];
        $msc->mscId = $_REQUEST ['mscId'];
        $msc->modifyTime = date("Y-m-d H:i:s");
        $msc->modifyUserId = $_SESSION ['userId'];
        $msca = new MainScheduleContractorAccess ($db);
        if ($msc->mscId > 0) {
            if (empty ($msc->company)) // 选空的时候直接删除.
            {
                $msca->Del($msc);
            } else // 更新分判商
            {
                $msc_t = new MainScheduleContractor ();
                $msc_t->mscId = $msc->mscId;
                $rs = $msca->GetListSearch($msc_t);
                $msc_t = $rs [0];
                $msc_t->company = $msc->company;
                $msc_t->modifyTime = $msc->modifyTime;
                $msc_t->modifyUserId = $msc->modifyUserId;
                $msca->Update($msc_t);
            }
        } else // 新加的数据
        {
            if (!empty ($msc->company)) {
                $msc->inputTime = date("Y-m-d H:i:s");
                $msc->inputUserId = $_SESSION ['userId'];
                $msc->mscId = $msca->Add($msc);
            }
        }
        $message = array('success' => 'true', 'mscId' => $msc->mscId);
        echo json_encode($message);
        break;
    case 'changePlannedSurveyDate' :
        $mspd = new MainSchedulePlannedDate ();
        $mspda = new MainSchedulePlannedDateAccess ($db);
        $mspd->plannedSurveyDate = $_REQUEST ['plannedSurveyDate'];
        $mspd->userType = "Surveyor";
        $mspd->inputUserId = $_SESSION ['userId'];
        $mspd->inputTime = date($conf ['dateTime'] ['format']);
        if (empty($mspd->inputUserId)) {
            $message = array('success' => false, 'message' => '登錄已經失效,請重新登錄!', 'mstd' => $mspd->mstd);
        } else {
            $jobNoNews = $_REQUEST ['jobNoNew'];
            $jobNoNewsArray = explode(",", $jobNoNews);
            $jobNoNewsArrayNum = count($jobNoNewsArray);
            foreach ($jobNoNewsArray as $k => $v) {
                if (empty ($v)) continue;
                $mspd->jobNoNew = $v;
                $mspd->mstd = $mspda->Add($mspd);
            }
            $message = array('success' => true, 'mstd' => $mspd->mstd);
        }
        echo json_encode($message);
        break;
    case 'backupMainschedule' :
        $mshl = new MainScheduleHistoryLog ();
        $mshl->backupMonth = $_REQUEST ['backupMonth'];
        $mshl->inputUserId = $_SESSION ['userId'];
        $mshl->inputTime = date("Y-m-d H:i:s");
        $mshla = new MainScheduleHistoryLogAccess ($db);
        $mshl->mshlId = $mshla->BackupMonthMainSchedule($mshl);
        $message = array('success' => 'true', 'mshlId' => $mshl->mshlId);
        echo json_encode($message);
        break;
    case 'unbackupMainschedule' :
        $mshl = new MainScheduleHistoryLog ();
        $mshl->mshlId = $_REQUEST ['mshlId'];
        $mshl->modifyUserId = $_SESSION ['userId'];
        $mshl->modifyTime = date("Y-m-d H:i:s");
        $mshla = new MainScheduleHistoryLogAccess ($db);
        $mshla->Del($mshl);
        $message = array('success' => 'true', 'mshlId' => $mshl->mshlId);
        echo json_encode($message);
        break;
    case 'approvalBackupMainschedule' :
        $mshl = new MainScheduleHistoryLog ();
        $mshl->mshlId = $_REQUEST ['mshlId'];
        $mshl->isApproval = 'yes';
        $mshl->modifyUserId = $_SESSION ['userId'];
        $mshl->modifyTime = date("Y-m-d H:i:s");
        $mshla = new MainScheduleHistoryLogAccess ($db);
        $mshla->ApprovalBackupMonthMainSchedule($mshl);
        $message = array('success' => 'true', 'mshlId' => $mshl->mshlId);
        echo json_encode($message);
        break;
    case 'unapprovalBackupMainschedule' :
        $mshl = new MainScheduleHistoryLog ();
        $mshl->mshlId = $_REQUEST ['mshlId'];
        $mshl->isApproval = 'no';
        $mshl->modifyUserId = $_SESSION ['userId'];
        $mshl->modifyTime = date("Y-m-d H:i:s");
        $mshla = new MainScheduleHistoryLogAccess ($db);
        $mshla->ApprovalBackupMonthMainSchedule($mshl);
        $message = array('success' => 'true', 'mshlId' => $mshl->mshlId);
        echo json_encode($message);
        break;
    case 'openJob' :
        if (empty($_SESSION ['userId'])) {
            $message = array('success' => false, 'message' => '登錄已經失效,請重新登錄!', 'jobNoNew' => $mso->jobNoNew);
            die(json_encode($message));
        }
        $mso = new MainScheduleOpen();
        $msoa = new MainScheduleOpenAccess($db);
        $mso->inputUserId = $_SESSION ['userId'];
        $mso->inputTime = date("Y-m-d H:i:s");
        $relationJobNoNews = $_REQUEST['relationJobNoNews'];
        $relationJobNoNewsArray = explode(",", $relationJobNoNews);
        $jobNoNews = $_REQUEST['jobNoNews'];
        $jobNoNewsArray = explode(",", $jobNoNews);
        foreach ($jobNoNewsArray as $k => $v) {
            if (empty ($v)) continue;
            //添加记录
            $mso->batchNumber = uniqid();
            $mso->jobNoNew = $v;
            $msoa->Add($mso);
            //如果有关联的job,以同一批号插入
            foreach($relationJobNoNewsArray as $v2){
                if (empty ($v2)) continue;
                $mso->jobNoNew = $v2;
                $msoa->Add($mso);
            }
        }
        $message = array('success' => true, 'jobNoNew' => $mso->jobNoNew);
        die(json_encode($message));
        break;
}

function adpic($data){
    $mobileVersionArr = getArray('mobileVersion');
    $version = $mobileVersionArr[$data['version']];
    $type = strtolower(substr($data['version'],0,1));
    if($type == 'a'){//android
        $path = 'android/'.$version.'/';

        /*$adpic = array();
        $adpic[] = 'http://www.ozzotec.com/academy/cache/adpic/'.$path.'2_ad1.png';
        $adpic[] = 'http://www.ozzotec.com/academy/cache/adpic/'.$path.'ad2.png';
        $adpic[] = 'http://www.ozzotec.com/academy/cache/adpic/'.$path.'ad3.png';
        $adpic[] = 'http://www.ozzotec.com/academy/cache/adpic/'.$path.'ad4.png';*/
        $adpic = array();
        $adpic[] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.'/cache/adpic/'.$path.'2_ad1.png';
        $adpic[] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.'/cache/adpic/'.$path.'ad2.png';
        $adpic[] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.'/cache/adpic/'.$path.'ad3.png';
        $adpic[] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.'/cache/adpic/'.$path.'ad4.png';
    }elseif($type == 'i'){
        $path = 'ios/'.$version.'/';

        $adpic = array();
        $adpic[] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.'/cache/adpic/'.$path.'3_ad.png';
        $adpic[] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.'/cache/adpic/'.$path.'ad2.png';
        $adpic[] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.'/cache/adpic/'.$path.'ad3.png';
        $adpic[] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.'/cache/adpic/'.$path.'ad4.png';
    }else{
        $message = array (
            'status' => 'failed',
            'msg' => 'VERSION ERROR',
            'data' => ''
        );
        echo json_encode($message);
        exit;
    }

    $message = array (
        'status' => 'success',
        'msg' => '',
        'data' => $adpic
    );
    echo json_encode($message);
}