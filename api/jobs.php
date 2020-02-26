<?php
/**
 *
 * @copyright 2007-2018 Xiaoqiang.Wu
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2018-2-12
 */

set_time_limit(0);
include_once("../includes/config.inc.php");

$rawJson = file_get_contents('php://input', 'r');

if (empty($rawJson)) {
    $data = $_REQUEST;
    if (empty($data['channel'])) {
        $data['channel'] = 0;
    }
} else {
    $data = json_decode($rawJson, TRUE);
    if (empty($data['q'])) {
        $data['q'] = $_REQUEST ['q'];
    }
}

switch ($data['q']) {
    /*case 'tmpInitData1':
        tmpInitData1();*/
    case 'tmpInitData233':
        tmpInitData233();

    case 'saveJobs':
        saveJobs($data);
        break;
    case 'getInfo':
        getInfo($data);
        break;
    case 'deleteInfo':
        deleteInfo($data);
        break;
    case 'getJobs':
        getJobs($data);
        break;
    case 'getJobNoNewList':
        getJobNoNewList($data);
        break;
    case 'setDataEntry':
        setDataEntry($data);
        break;
    case 'getDataEntryList':
        getDataEntryList($data);
        break;
    case 'setJobOpenStatus':
        setJobOpenStatus($data);
        break;
    /*case 'assign':
        assignSurveyor($data,'assign');
        break;
    case 'unassign':
        assignSurveyor($data,'unassign');
        break;*/
    case 'openJob':
        openJob($data);
        break;
    case 'saveJobs':
        saveJobs($data);
        break;
    case 'getInfo':
        getInfo($data);
        break;
    case 'deleteInfo':
        deleteInfo($data);
        break;
    case 'getJobs':
        getJobs($data);
        break;
    case 'getJobNoNewList':
        getJobNoNewList($data);
        break;
    case 'setDataEntry':
        setDataEntry($data);
        break;
    case 'setStatus':
        setStatus($data);
        break;
    case 'getDataEntryList':
        getDataEntryList($data);
        break;
    case 'setJobOpenStatus':
        setJobOpenStatus($data);
        break;
    /*case 'assign':
        assignSurveyor($data,'assign');
        break;
    case 'unassign':
        assignSurveyor($data,'unassign');
        break;*/
    case 'openJob':
        openJob($data);
        break;
    case 'getPaymentPDF':
        getPaymentPDF($data);
        break;
    case 'batchDelJobs':
        batchDelJobs($data);
        break;
    case 'batchEditJobs':
        batchEditJobs($data);
        break;
    case "batchOpenJob":
        batchOpenJob($data);
        break;
    case "batchCloseJob":
        batchCloseJob($data);
        break;
    case "add"://添加课堂
        add($data);
        break;
    case "getVehicle"://添加课堂
        getVehicle($data);
        break;
    case "setVehicleClass":
        setVehicleClass($data);
        break;
    case "batchSign":
        batchSign($data);
        break;
    case "batchUnsign":
        batchUnsign($data);
        break;
    case "SignList":
        SignList($data);
        break;
    case "unSignList":
        unSignList($data);
        break;
    case "isCheckIn":
        isCheckIn($data);
        break;
    case "familyStatus":
        familyStatus($data);
        break;
    case "getClassRecord":
        getClassRecord($data);
        break;
    case "getUnsignLimitTime":
        getUnsignLimitTime($data);
        break;
    case "getConfig":
        getConfig($data);
        break;
    case "setConfig":
        setConfig($data);
        break;
    case "setUnsignLimitTime":
        setUnsignLimitTime($data);
        break;
    case "paymentHistory":
        paymentHistory($data);
        break;
    default:
        echo 'error';
        break;

}

function updateClassPDF($pdfid, $set_class_by, $class_num, $class_remain)
{
    global $db;

    $now_time = date('Y-m-d H:i:s');
    $sql = "UPDATE Survey_SurveyorClassPDF set is_set_class = 1,set_class_time = '$now_time',class_num = class_num+'$class_num',class_remain = class_remain+'$class_remain', set_class_by = '$set_class_by'  where id = '$pdfid'";
    return $db->query($sql);
}

function addClassRecord($surveyor_id, $jobNoNew, $use_class, $class_remain, $remark, $record_surveyor_id, $status = 1, $confirm_pdf = null, $confirm_pdf_create_by = 0, $confirm_pdf_create_time = null, $time = false)
{
    global $db;
    if ($time == false) {
        $record_time = date('Y-m-d H:i:s');
    } else {
        $record_time = $time;
    }


    if ($confirm_pdf === null) {
        $confirm_pdf_create_time = '0000-00-00 00:00:00';
    }

    $sql = "INSERT into Survey_SurveyorClassRecord(surveyor_id,jobNoNew,use_class,class_remain,remark,record_time,record_surveyor_id,status,confirm_pdf,confirm_pdf_create_by,confirm_pdf_create_time)
 values ('$surveyor_id','$jobNoNew','$use_class','$class_remain','$remark','$record_time','$record_surveyor_id','$status','$confirm_pdf','$confirm_pdf_create_by','$confirm_pdf_create_time')";

    $res = $db->query($sql);

    if ($status == 1) {
        $sql2 = "SELECT last_insert_id() ";
        $db->query($sql2);
        if ($lastid = $db->next_record()) {
            $lastid = $lastid[0];
        }
        if ($jobNoNew != 0) {
            $ss_sql = "UPDATE Survey_MainSchedule set class_record_id = '$lastid'  where jobNoNew = '$jobNoNew'";
        }
    } elseif ($status == 1) {
        $ss_sql = "UPDATE Survey_MainSchedule set class_record_id = '' where jobNoNew = '$jobNoNew'";
    } else {
        return $res;
    }

    $ss_res = $db->query($ss_sql);
    return $ss_res;

}

function getpdfidByClassRecord($class_record_id, $surveyor_id = 0)
{
    global $db;

    $sql = "SELECT id FROM Survey_SurveyorClassPDF where class_record_id = $class_record_id AND surveyor_id=$surveyor_id";
    if ($class_record_id == 0) {
        $sql .= " AND jobNoNew = 0";
    }
    $sql .= ' ORDER BY id desc';
    $db->query($sql);
    if ($pdfid = $db->next_record()) {
        $pdfid = $pdfid[0];
    }

    return $pdfid;
}

/*
 * 初始化數據
 * 對學員原有的課堂數據做適配
 *
 * */
function tmpInitData1()
{
    global $db;
    sleep(0.5);
    $sql = "SELECT * FROM Survey_SurveyorClass where is_del <> 1";

    $db->query($sql);
    $data = array();
    while ($rs = $db->next_record()) {
        $data[] = $rs;
    }
    foreach ($data as $k => $one) {
        sleep(0.25);
        $id = $one['id'];
        $nowTime = $one['create_time'];
        $surveyor_id = $one['surveyor_id'];
        $pdfid = getpdfidByClassRecord(0, $one['surveyor_id']);
        $jobNoNew = 0;
        $firstTime = false;
        $class_num = $one['class'];
        if (empty($pdfid)) {
            $firstTime = true;
            $default_path = '';//default PDF
            $class_record_id = 0;

            $sql = "INSERT into Survey_SurveyorClassPDF(surveyor_id,class_record_id,jobNoNew,path,upload_surveyor_id,upload_pdf_time,is_set_class,set_class_by,set_class_time,class_num,class_remain) values ('$surveyor_id','$class_record_id','$jobNoNew','$default_path','1','$nowTime','1','1','$nowTime',$class_num,$class_num)";
            $res = $db->query($sql);
            $sql2 = "SELECT last_insert_id() ";
            $db->query($sql2);
            if ($lastid = $db->next_record()) {
                $pdfid = $lastid[0];
            }
        }
        if ($pdfid) {

            $recordRemark = $class_num < 0 ? '管理員减少課堂' : '管理員添加課堂';
            // 添加Survey_SurveyorClassRecord
            //TODO 修改 class_num class_remain

            if ($firstTime == false) {

                $old_sql = "select sum(use_class) as use_class from Survey_SurveyorClassRecord where surveyor_id = '$surveyor_id'";
                $db->query($old_sql);
                if ($rs = $db->next_record()) {
                    $old_class = $rs['use_class'];
                }
                $class_remain = $old_class + $class_num;
                $addres = addClassRecord($surveyor_id, $jobNoNew, $class_num, $class_remain, $recordRemark, 1, 2, $pdfid, $one['surveyor_id'], $nowTime);

                updateClassPDF($pdfid, 1, $class_num, $class_num);
            } else {
                $addres = addClassRecord($surveyor_id, $jobNoNew, $class_num, $class_num, $recordRemark, 1, 2, $pdfid, $one['surveyor_id'], $nowTime);
            }

            $update_sql = "UPDATE Survey_SurveyorClass set pdfid=$pdfid where id = $id";
            $db->query($update_sql);
            echo 'success:' . $one['surveyor_id'] . "\n" . var_dump($addres);
        } else {
            echo 'failed:' . $one['surveyor_id'] . "\n";
        }
    }
}

/*
 * 初始化數據
 * 對原有的課堂數據做適配
 *
 * */
function tmpInitData233()
{
    global $db;
    $sql = "SELECT * FROM Survey_MainSchedule WHERE surveyorCode <> ''";

    $db->query($sql);
    $data = array();
    while ($rs = $db->next_record()) {
        $data[] = $rs;
    }
    $msa = new MainScheduleAccess($db);
    foreach ($data as $k => $one) {
        //sleep(0.25);
        $surveyor_id = $one['surveyorCode'];
        $old_sql = "select sum(use_class) as use_class from Survey_SurveyorClassRecord where surveyor_id = '$surveyor_id'";
        $db->query($old_sql);
        if ($rs = $db->next_record()) {
            $old_class = $rs['use_class'];
        }
        if ($one['realClass'] == 1) {
            $class_remain = $old_class - 1;
            $use_class = -1;
        } else {
            $class_remain = $old_class;
            $use_class = 0;
        }
        $time = $one['plannedSurveyDate'] . ' ' . $one['startTime_1'];
        $time = date('Y-m-d H:i:s');
        $msa->addClassRecord($one['surveyorCode'], $one['jobNoNew'], $use_class, $class_remain, '初始課堂', 1, 1, $time);
        echo 'success' . "\n";
    }
}


/*
 * 获取课堂记录
 * */
function getClassRecord($data)
{
    $surInfo = getSurInfo($data['sign']);

    $class_surId = getArrNoNull($data, 'class_surId');
    $start_time = isset($data['start_time']) ? $data['start_time'] : false;
    $end_time = isset($data['end_time']) ? $data['end_time'] : false;
    if ($class_surId != $surInfo->survId) {
        if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {

            $res = _getClassRecord($class_surId, $start_time, $end_time);
        } else {
            returnJson('failed', '', 'Permission Error');
        }
    } else {
        $res = _getClassRecord($class_surId, $start_time, $end_time);
        $class_surId = getArrNoNull($data, 'class_surId');
        $start_time = isset($data['start_time']) ? $data['start_time'] : false;
        $end_time = isset($data['end_time']) ? $data['end_time'] : false;
        $is_goods = isset($data['is_goods']) ? $data['is_goods'] : false;

        if ($class_surId != $surInfo->survId) {

            if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {
                //管理员能查看所有人的
                $res = _getClassRecord($class_surId, $start_time, $end_time, $is_goods);
            } else {
                returnJson('failed', '', 'Permission Error');
            }
        } else {
            //学员自己只能查自己的
            $res = _getClassRecord($class_surId, $start_time, $end_time, $is_goods);
        }
        returnJson('success', $res, '');
    }
}


function _getClassRecord($survId, $start_time = false, $end_time = false, $is_goods = false)
{

    global $db;


    $sql = "SELECT ssc.id as id,ssc.surveyor_id,ssc.jobNoNew,ssc.use_class,ssc.class_remain,ssc.remark,ssc.record_surveyor_id,ssc.record_time,ssc.is_del,ssc.status,ssc.confirm_pdf_create_time,ssc.record_time,
sm.plannedSurveyDate,sm.surveyType,sm.surveyorCode,sm.startTime_1,sm.jobNo,sm.endTime_1,sscp.id as pdfid,sscp.path as surveyor_pdf,sscp.upload_pdf_time as surveyor_pdf_create_time,sscp.is_set_class,
sscp2.path as confirm_pdf,ssc.confirm_pdf as confirm_pdfid, ss.chiName as confirm_chiName, ss.engName as confirm_engName,sm.is_image
FROM Survey_SurveyorClassRecord as ssc 
left Join Survey_MainSchedule as sm on sm.jobNoNew=ssc.jobNoNew
left Join Survey_Surveyor as ss on ss.survId=ssc.confirm_pdf_create_by

left Join Survey_SurveyorClassPDF as sscp2 on sscp2.id=ssc.confirm_pdf
left Join (select * from Survey_SurveyorClassPDF where id in (select max(id) from Survey_SurveyorClassPDF group by class_record_id)) as sscp on sscp.class_record_id=ssc.id 
WHERE ";

    if ($start_time !== false && $end_time !== false) {
        $sql .= "sm.plannedSurveyDate >= '$start_time' and sm.plannedSurveyDate <= '$end_time' and ";
    }
    if ($is_goods) {
        $sql .= "sm.is_image='1' and ";
    }
    $sql .= "ssc.surveyor_id = '{$survId}' and ssc.is_del = 0 order by ssc.id desc";
    $db->query($sql);

//    echo $sql;
//    exit();
    $db->query($sql);

    $rows = array();
    while ($rs = $db->next_record()) {
        $tmp = array();
        $tmp['class_record_id'] = $rs['id'];
        $tmp['surveyor_id'] = $rs['surveyor_id'];
        $tmp['jobNoNew'] = $rs['jobNoNew'];
        $tmp['surveyor_pdf'] = $rs['surveyor_pdf'];
        $tmp['surveyor_pdf_create_time'] = $rs['surveyor_pdf_create_time'];
        $tmp['confirm_pdf'] = $rs['confirm_pdf'];
        $tmp['confirm_pdf_create_time'] = $rs['confirm_pdf_create_time'];
        $tmp['confirm_chiName'] = $rs['confirm_chiName'];
        $tmp['confirm_engName'] = $rs['confirm_engName'];
        $tmp['use_class'] = $rs['use_class'];
        $tmp['class_remain'] = $rs['class_remain'];
        $tmp['remark'] = $rs['remark'];
        $tmp['plannedSurveyDate'] = $rs['plannedSurveyDate'];
        $tmp['startTime_1'] = $rs['startTime_1'];
        $tmp['endTime_1'] = $rs['endTime_1'];
        $tmp['status'] = $rs['status'];
        $tmp['jobNo'] = $rs['jobNo'];
        $tmp['surveyType'] = $rs['surveyType'];
        $tmp['record_time'] = $rs['record_time'];
        $tmp['is_own'] = 0;
        $tmp['pdfid'] = $rs['pdfid'];
        $tmp['confirm_pdfid'] = $rs['confirm_pdfid'];


        if ($rs['surveyorCode'] == $rs['surveyor_id']) {

            $tmp['is_image'] = $rs['is_image'];
            if (empty($rs['is_image'])) {
                $tmp['is_image'] = 0;
            }
            if ($rs['surveyorCode'] == $rs['surveyor_id']) {

                $tmp['is_own'] = 1;
            }
            $rows[] = $tmp;
        }
        return $rows;

    }
}


function familyStatus($data)
{
    global $conf, $db;
    $surInfo = getSurInfo($data['sign']);
    $jobNo = getArrNoNull($data, 'jobNo');
    $surveyorTelephone = getArrNoNull($data, 'surveyorTelephone');


    $familyPhone = substr($surveyorTelephone, 0, 8);

    $ja = new JobsAccess($db);
    $familys = $ja->getFamilysInJob($jobNo, $familyPhone);


    returnJson('success', $familys, '');
    $filter = array();
    $filter['jobNo'] = $jobNo;
    $other = '';
    $rs = $ja->getDataEntryList($filter, $other);

    $sjoa = new SurveyJobOpenAccess($db);
    $sjo = new SurveyJobOpen();
    $sjo->delFlag = 'no';
    $sjo->isOpen = '';
    $sjo->jobNo = $data['jobNo'];
    $result = $sjoa->GetListSearch($sjo);
    $isOpen = 'no';
    if (!empty($result[0])) {
        $isOpen = $result[0]->isOpen;
    }
    $message = array(
        'status' => 'success',
        'msg' => '',
        'isOpen' => $isOpen,
        'data' => $rs
    );
    die(json_encode($message));
}


/*
 * 判斷學員是否已到
 *
 * */
function isCheckIn($data)
{
    global $db;
    $surInfo = getSurInfo($data['sign']);
    $jobNoNew = getArrNoNull($data, 'jobNoNew');
    $surveyorId = $surInfo->survId;
    $sql = "SELECT userId,modifyUserId FROM Survey_SurveyPart WHERE survId = '{$surveyorId}' and refNo = '{$jobNoNew}' and delFlag = 'no'";
    $db->query($sql);
    $isCheckIn = 'no';
    if ($rs = $db->next_record()) {
        $isCheckIn = 'yes';
    }
    returnJson('success', array('isCheckIn' => $isCheckIn), '');
}

function setUnsignLimitTime($data)
{
    global $db;

    $limitTime = getArrNoNull($data, 'limitTime');
    $surInfo = getSurInfo($data['sign']);

    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {
        $survId = $surInfo->survId;
        $now = date('Y-m-d H:i:s');
        $sql = "UPDATE Survey_Config SET config_value='{$limitTime}',config_survId='{$survId}',config_time='{$now}'  
WHERE 1=1 and config_name = 'unsignLimitTime'";

        $db->query($sql);

    } else {
        returnJson('failed', '', 'Permission Error');
    }
    returnJson('success', '修改成功', '');
}

function getConfigName($name)
{
    global $db;
    if ($name == 'all') {
        $sql = "SELECT sc.config_value,sc.config_name,sc.config_survId,sc.config_time,ss.chiName,ss.engName FROM Survey_Config as sc
LEFT JOIN Survey_Surveyor as ss ON sc.config_survId=ss.survId
WHERE 1=1 order by id desc";
        $db->query($sql);
        $dataArr = array();
        while ($rs = $db->next_record()) {
            $tmp = array();
            $tmp['config_name'] = $rs['config_name'];
            $tmp['config_value'] = $rs['config_value'];
            $tmp['config_survId'] = $rs['config_survId'];
            $tmp['engName'] = $rs['engName'];
            $tmp['chiName'] = $rs['chiName'];
            $tmp['config_time'] = $rs['config_time'];
            $dataArr[] = $tmp;
        }
    } else {
        $sql = "SELECT sc.config_value,sc.config_name,sc.config_survId,sc.config_time,ss.chiName,ss.engName FROM Survey_Config as sc
LEFT JOIN Survey_Surveyor as ss ON sc.config_survId=ss.survId
WHERE 1=1 and config_name = '$name' order by id desc";
        $db->query($sql);
        $dataArr = array();
        if ($rs = $db->next_record()) {
            $tmp = array();
            $tmp['config_name'] = $rs['config_name'];
            $tmp['config_value'] = $rs['config_value'];
            $tmp['config_survId'] = $rs['config_survId'];
            $tmp['engName'] = $rs['engName'];
            $tmp['chiName'] = $rs['chiName'];
            $tmp['config_time'] = $rs['config_time'];
            $dataArr[] = $tmp;
        }
    }

    return $dataArr;
}

function getUnsignLimitTime($data)
{
    global $db;
    $surInfo = getSurInfo($data['sign']);
    $dataArr = getConfigName('unsignLimitTime');
    returnJson('success', $dataArr, '');
}


function getConfig($data)
{
    global $db;
    $surInfo = getSurInfo($data['sign']);
    $configName = getArrNoNull($data, 'configName');
    $dataArr = getConfigName($configName);
    returnJson('success', $dataArr, '');
}

function setConfig($data)
{
    global $db;
    $surInfo = getSurInfo($data['sign']);
    $unsignLimitTime = getArrNoNull($data, 'unsignLimitTime');
    $chargedLimit = getArrNoNull($data, 'chargedLimit');
    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {
        $survId = $surInfo->survId;
        $now = date('Y-m-d H:i:s');
        $sql1 = "UPDATE Survey_Config SET config_value='{$unsignLimitTime}',config_survId='{$survId}',config_time='{$now}'  
    WHERE 1=1 and config_name = 'unsignLimitTime'";
        $db->query($sql1);

        $sql2 = "UPDATE Survey_Config SET config_value='{$chargedLimit}',config_survId='{$survId}',config_time='{$now}'  
    WHERE 1=1 and config_name = 'chargedLimit'";
        $db->query($sql2);

    } else {
        returnJson('failed', '', 'Permission Error');
    }
    returnJson('success', '修改成功', '');
}

//TODO setConfig function 的备用
function setConfig_bak($data)
{
    global $db;
    $configs = getArrNoNull($data, 'configs');
    /*$configName = getArrNoNull($data,'configName');
    $configValue = getArrNoNull($data,'configValue');*/

    $surInfo = getSurInfo($data['sign']);
    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {
        $configArr = json_decode($configs, true);
        if (!$configArr) {
            returnJson('failed', array(), 'configs 格式錯誤');
        }
        if (!empty($configArr)) {
            foreach ($configArr as $k => $one) {
                $survId = $surInfo->survId;
                $now = date('Y-m-d H:i:s');
                $configValue = $one['configValue'];
                $configName = $one['configName'];
                $sql = "UPDATE Survey_Config SET config_value='{$configValue}',config_survId='{$survId}',config_time='{$now}'  
WHERE 1=1 and config_name = '$configName'";
                $db->query($sql);
            }
        }

    } else {
        returnJson('failed', '', 'Permission Error');
    }
    returnJson('success', '修改成功', '');
}

function batchUnsign($data)
{
    global $db;

    $surInfo = getSurInfo($data['sign']);
    $jobNo = getArrNoNull($data, 'jobNo');
    $surveyors_str = getArrNoNull($data, 'surveyors');
    $surveyors = explode(',', $surveyors_str);
    if (!is_array($surveyors) || empty($surveyors)) returnJson('failed', '', 'Surveyors Error');
    $ja = new JobsAccess($db);
    $classInfo = $ja->getInfoByJobNo($jobNo);
    if (!$classInfo) {
        returnJson('failed', '', 'JobNo Not Found');
    }

    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {


    } else {
        $nowTime = date('Y-m-d H:i:s');
        $limitTimeArr = getConfigName('unsignLimitTime');
        $limitTime = $limitTimeArr[0]['config_value'] * 60 * 60;
        $classStartTime = $classInfo['plannedSurveyDate'] . ' ' . $classInfo['startTime_1'];

        if ($classInfo['plannedSurveyDate'] != '0000-00-00') {
            if (strtotime($nowTime) >= strtotime($classStartTime)) {
                returnJson('failed', '', '該課堂已完結');
            }

            if ($limitTimeArr['config_value'] == '99999') {
                returnJson('failed', '', '管理員未開放自行取消');
            }

            if (strtotime($nowTime) >= strtotime($classStartTime) - $limitTime) {
                returnJson('failed', '', $limitTimeArr[0]['config_value'] . '小時內的課堂不可取消');
            }
        }
    }

    $sql = "SELECT sm.jobNoNew,sm.class_record_id,sm.surveyorCode,sscr.confirm_pdf FROM Survey_MainSchedule as sm
left join Survey_SurveyorClassRecord as sscr on sscr.id = sm.class_record_id
WHERE sm.jobNo='{$jobNo}' and sm.surveyorCode in($surveyors_str) ";
    $db->query($sql);
    $dataArr = array();
    $response = array();
    $cancel_arr = array();
    while ($rs = $db->next_record()) {
        $tmp = array();
        $tmp['jobNoNew'] = $rs['jobNoNew'];
        $tmp['class_record_id'] = $rs['class_record_id'];
        $tmp['surveyorCode'] = $rs['surveyorCode'];
        if (!empty($rs['confirm_pdf'])) {
            if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {
                $tmp_cancel = array();
                $tmp_cancel['survId'] = $surInfo->surInfo;
                $tmp_cancel['class_record_id'] = $rs['class_record_id'];
                $cancel_arr[] = $tmp_cancel;
                $dataArr[] = $tmp;
            } else {
                $tmp2 = array();
                $tmp2['surveyorCode'] = $rs['surveyorCode'];
                $tmp2['reason'] = '管理員已確認，不能取消';
                $response[] = $tmp2;
            }
        } else {
            $dataArr[] = $tmp;
        }
    }

    if (!empty($cancel_arr)) {
        foreach ($cancel_arr as $cancel_key => $cancel_value) {
            $res = cancelConfirm($cancel_value['survId'], $cancel_value['class_record_id']);
        }
    }

    $sa = new SurveyorAccess($db);
    $sur = new Surveyor();
    foreach ($dataArr as $v) {
        $class_record_id = $v['class_record_id'];
        $sql1 = "UPDATE Survey_SurveyorClassRecord SET confirm_pdf = '',status='0',
cancel_confirm_pdf_by = '{$surInfo->survId}',confirm_pdf_create_time='{$nowTime}'
 where id='{$class_record_id}' and is_del = 0";
        $updateRes1 = $db->query($sql1);

        $sur->survId = $v['surveyorCode'];
        $jobNoNew = $v['jobNoNew'];
        $res = $sa->UnAssign_new($sur, $jobNoNew, $surInfo);
    }
    /*if($res == false){
        returnJson('failed','','未找到該課堂記錄');
    }*/
    returnJson('success', $response, '');
}

function cancelConfirm($survId, $class_record_id)
{
    global $db;
    $nowTime = date('Y-m-d H:i:s');
    $record = getJobNoNewByClassRecord($class_record_id);
    $pdfid = $record['confirm_pdf'];


    //更新PDF的剩余课堂数
    $sql2 = "UPDATE Survey_SurveyorClassPDF SET class_remain = class_remain+1
 where id='{$pdfid}' and is_del = 0";
    $updateRes2 = $db->query($sql2);
    return $updateRes2;
}

/*
 * 判斷該課堂是否已經由管理員確認PDF
 * */
function is_confirm($jobNoNew, $survId)
{
    global $db;
    $sql1 = "SELECT class_record_id FROM Survey_MainSchedule " . " WHERE 1=1  AND jobNoNew = '{$jobNoNew}' AND surveyorCode = '{$survId}'";
    $db->query($sql1);
    $res = array();
    if ($rs = $db->next_record()) {
        $res = $rs;
    }

    if (!empty($res['class_record_id'])) {
        $sql2 = "SELECT confirm_pdf FROM Survey_SurveyorClassRecord " . " WHERE 1=1 AND id = '{$res['class_record_id']}'";
        $db->query($sql2);
        $res2 = array();
        while ($rs2 = $db->next_record()) {
            $res2 = $rs2;
        }
        if (!empty($res2['confirm_pdf'])) {
            return $res2['confirm_pdf'];
        } else {
            return false;
        }
    } else {
        //TODO 無課堂記錄的課堂
        return false;
    }
}


function unSignList($data)
{
    global $db;
    $surInfo = getSurInfo($data['sign']);
    $jobNo = getArrNoNull($data, 'jobNo');
    $ja = new JobsAccess($db);
    $isExist = $ja->isExistJobNo($jobNo);
    if (!$isExist) {
        returnJson('failed', '', 'JobNo Not Found');
    }
    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {
        $sql = "SELECT surveyorCode FROM Survey_MainSchedule WHERE jobNo = '{$jobNo}'";
        $db->query($sql);
        $assignArr = array();
        while ($rs = $db->next_record()) {
            $assignArr[] = $rs['surveyorCode'];
        }
        $allSql = "SELECT survId,chiName,engName,contact,class_remain,survType FROM Survey_Surveyor WHERE  status = 'active' ";
        $db->query($allSql);
        $allArr = array();
        while ($res = $db->next_record()) {
            $tmp = array();
            $tmp['survId'] = $res['survId'];
            $tmp['chiName'] = $res['chiName'];
            $tmp['engName'] = $res['engName'];
            $tmp['contact'] = $res['contact'];
            $tmp['class_remain'] = $res['class_remain'];
            $tmp['survType'] = $res['survType'];
            $allArr[] = $tmp;
        }
        $resArr = array();
        foreach ($allArr as $av => $ak) {
            if (!in_array($ak['survId'], $assignArr)) {
                $resArr[] = $ak;
            }
        }
        returnJson('success', $resArr, '');
    } else {
        returnJson('failed', '', 'Permission Error');
    }
}

function SignList($data)
{
    global $db;
    $surInfo = getSurInfo($data['sign']);
    $jobNo = getArrNoNull($data, 'jobNo');
    $ja = new JobsAccess($db);
    $isExist = $ja->isExistJobNo($jobNo);
    if (!$isExist) {
        returnJson('failed', '', 'JobNo Not Found');
    }
    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {
        $sql = "SELECT sm.jobNoNew,sscr.confirm_pdf,ss.survId,ss.chiName,ss.engName,ss.contact,
ss.class_remain,ss.survType
 FROM Survey_MainSchedule as sm
 left join Survey_SurveyorClassRecord as sscr on sscr.id = sm.class_record_id
left join Survey_Surveyor as ss on ss.survId=sm.surveyorCode
 WHERE jobNo = '{$jobNo}' and sm.surveyorCode <> '' and ss.status = 'active'
";
        $db->query($sql);
        $allArr = array();
        while ($rs = $db->next_record()) {
            $tmp = array();
            $tmp['jobNoNew'] = $rs['jobNoNew'];
            $tmp['survId'] = $rs['survId'];
            $tmp['chiName'] = $rs['chiName'];
            $tmp['engName'] = $rs['engName'];
            $tmp['contact'] = $rs['contact'];
            $tmp['class_remain'] = $rs['class_remain'];
            $tmp['survType'] = $rs['survType'];

            if (empty($rs['confirm_pdf'])) {
                $tmp['had_confirm'] = false;
            } else {
                $tmp['had_confirm'] = true;
            }
            $allArr[] = $tmp;
        }
        returnJson('success', $allArr, '');
    } else {
        returnJson('failed', '', 'Permission Error');
    }
}


function batchSign($data)
{
    global $db;

    $surInfo = getSurInfo($data['sign']);
    $jobNo = getArrNoNull($data, 'jobNo');
    $surveyors_str = getArrNoNull($data, 'surveyors');
    $surveyors = explode(',', $surveyors_str);
    if (!is_array($surveyors) || empty($surveyors)) returnJson('failed', '', 'Surveyors Error');
    $vehicle = getArrNoNull($data, 'vehicle');
    $ja = new JobsAccess($db);
    $isExist = $ja->isExistJobNo($jobNo);
    if (!$isExist) {
        returnJson('failed', '', 'JobNo Not Found');
    }
    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {
        $resData = array();
        $resData['successArray'] = array();
        $resData['errorArray'] = array();
        $msgRes = '';
        $assign_all_sql = "SELECT survId,chiName,engName,contact,class_remain FROM Survey_Surveyor WHERE survId in({$surveyors_str})";
        $jobNoNews_sql = "SELECT jobNo,jobNoNew,vehicle FROM Survey_MainSchedule WHERE vehicle='{$vehicle}' and jobNo = '{$jobNo}' and surveyorCode = ''";

        $db->query($assign_all_sql);
        $assignArr = array();
        while ($rs = $db->next_record()) {
            $tmp = array();
            $tmp['survId'] = $rs['survId'];
            $tmp['class_remain'] = $rs['class_remain'];
            $tmp['chiName'] = $rs['chiName'];
            $tmp['engName'] = $rs['engName'];
            $tmp['contact'] = $rs['contact'];
            $assignArr[] = $tmp;
            /*if($rs['class_remain'] > 0){
                $assignArr[] = $tmp;
            }else{
                $tmp['errorMsg'] = '該學員剩余课堂数不足';
                $resData['errorArray'][] = $tmp;
                $name = empty($rs['chiName'])?$rs['engName']:$rs['chiName'];
                $msgRes .= $name.'('.$rs['survId'].')'.'的剩余课堂数不足'."\n";

            }*/
        }
        unset($tmp);
        $db->query($jobNoNews_sql);
        $jobNoNews = array();
        while ($jobNoNewsrs = $db->next_record()) {
            $tmp['jobNo'] = $jobNoNewsrs['jobNo'];
            $tmp['jobNoNew'] = $jobNoNewsrs['jobNoNew'];
            $tmp['vehicle'] = $jobNoNewsrs['vehicle'];
            $jobNoNews[] = $tmp;
        }

        if (count($assignArr) > count($jobNoNews)) {
            returnJson('failed', '', '該課堂主題剩餘名額不足');
        }

        $sa = new SurveyorAccess($db);
        $sur = new Surveyor();
        foreach ($assignArr as $sk => $sv) {
            if (array_key_exists($sk, $jobNoNews)) {
                $assignArr[$sk]['jobInfo'] = $jobNoNews[$sk];
                $sur->survId = $sv['survId'];
                $sur->contact = $sv['contact'];
                $sur->engName = $sv['engName'];
                $sur->chiName = $sv['chiName'];
                $sur->class_remain = $sv['class_remain'];
                $jobNoNew_sql = "SELECT jobNoNew,vehicle,surveyorCode FROM Survey_MainSchedule WHERE vehicle='{$vehicle}' and jobNoNew='{$jobNoNews[$sk]['jobNoNew']}'  LIMIT 1";
                $db->query($jobNoNew_sql);
                $jobNoNew_s = '';
                if ($jobNoNewrs = $db->next_record()) {
                    $jobNoNew_s = $jobNoNewrs['surveyorCode'];
                }
                $jobNoNew_sql2 = "SELECT jobNoNew,vehicle,surveyorCode FROM Survey_MainSchedule WHERE jobNo='{$jobNo}' and surveyorCode='{$sv['survId']}'  LIMIT 1";
                $db->query($jobNoNew_sql2);
                $jobNoNew_s2 = '';
                if ($jobNoNewrs2 = $db->next_record()) {
                    $jobNoNew_s2 = $jobNoNewrs2['surveyorCode'];
                }
                if ($jobNoNew_s2 == '') {
                    if ($jobNoNew_s == '') {
                        $sa->assign_new($sur, $jobNoNews[$sk]['jobNoNew'], $surInfo);
                        $resData['successArray'][] = $assignArr[$sk];
                    } else {
                        $sv['errorMsg'] = '未分配到課堂1';
                        $resData['errorArray'][] = $sv;
                        $name = empty($sv['chiName']) ? $sv['engName'] : $sv['chiName'];
                        $msgRes .= $name . '(' . $sv['survId'] . ')' . '未分配到課堂' . "\n";
                    }
                } else {
                    $sv['errorMsg'] = '該學員已分配過該課堂';
                    $resData['errorArray'][] = $sv;
                    $name = empty($sv['chiName']) ? $sv['engName'] : $sv['chiName'];
                    $msgRes .= $name . '(' . $sv['survId'] . ')' . '已分配過該課堂' . "\n";
                }
            } else {
                $sv['errorMsg'] = '未分配到課堂2';
                $resData['errorArray'][] = $sv;
                $name = empty($sv['chiName']) ? $sv['engName'] : $sv['chiName'];
                $msgRes .= $name . '(' . $sv['survId'] . ')' . '未分配到課堂，請稍後再試' . "\n";
            }
        }
        $msgRes = empty($msgRes) ? '分配成功！' : $msgRes;
        returnJson('success', $resData, $msgRes);

    } else {
        returnJson('failed', '', 'Permission Error');
    }
}

function updateVehicle($jobNo, $oldVehicle, $newVehicle, $mascIds)
{
    global $db;
    if (trim($oldVehicle) == trim($newVehicle)) {
        return true;
    } else {

        /*if($newVehicle == ''){
            $changeSql = "DELETE FROM Survey_MainSchedule WHERE jobNo = '{$jobNo}' and vehicle = '{$oldVehicle}' and (surveyorCode = '' or surveyorCode is Null)";
            $db->query ( $changeSql );
            return true;
        }else*/
        if ($oldVehicle == '') {

            $insert_data_sql = "SELECT vehicle from Survey_MainSchedule WHERE jobNo = '{$jobNo}' and vehicle='{$oldVehicle}' LIMIT 1";
            $db->query($insert_data_sql);

            if ($rs = $db->next_record()) {

                $update_sql = "UPDATE Survey_MainSchedule SET vehicle='{$newVehicle}' WHERE jobNo='{$jobNo}' and vehicle='{$oldVehicle}' and mascId in ($mascIds)";
                $db->query($update_sql);
            } else {

                $insert_data_sql = "SELECT * from Survey_MainSchedule WHERE jobNo = '{$jobNo}'  LIMIT 1";
                $db->query($insert_data_sql);
                if ($insert_data = $db->next_record()) {

                    $tmpSql = "SELECT jobNo,jobNoNew FROM Survey_MainSchedule where jobNo='{$jobNo}' order by mascId desc limit 1";
                    $db->query($tmpSql);
                    if ($tmpRs = $db->next_record()) {
                        $tmpABC = explode($tmpRs['jobNo'], $tmpRs['jobNoNew']);
                        $countStart = chr_to_int($tmpABC[1]);
                    }
                    $insert_data['vehicle'] = $newVehicle;
                    insert_Class($jobNo, 1, $insert_data, $countStart);
                }
            }

            return true;
        } else {

            /*$insert_data_sql = "SELECT * from Survey_MainSchedule WHERE jobNo = '{$jobNo}' and vehicle='{$oldVehicle}' LIMIT 1";
            $db->query ( $insert_data_sql );
            $update_res = false;*/
            //if($rs = $db->next_record ()){
            $update_res = true;
            $update_sql = "UPDATE Survey_MainSchedule SET vehicle='{$newVehicle}' WHERE jobNo='{$jobNo}' and vehicle='{$oldVehicle}' and mascId in ($mascIds)";;
            $db->query($update_sql);
            //}
            return $update_res;
        }
    }
}


/*
 * 批量修改課堂
 * */
function batchEditJobs($data)
{
    global $db;
    $surInfo = getSurInfo($data['sign']);
    $jobNo = getArrNoNull($data, 'jobNo');
    $vehicle = getArrNoNull($data, 'vehicle');
    $vehicle_arr = json_decode($vehicle, true);
    if (!is_array($vehicle_arr)) returnJson('failed', '', 'Vehicle Format Error');
    $ja = new JobsAccess($db);
    $isExist = $ja->isExistJobNo($jobNo);
    if (!$isExist) returnJson('failed', '', 'JobNo Not Found');

    //file_put_contents('/tmp/aaa.log',json_encode($data)."\n",FILE_APPEND);
    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {

        $sqlData = array();
        $sqlData['plannedSurveyDate'] = $data['plannedSurveyDate'];
        $sqlData['actualSurveyDate'] = $data['actualSurveyDate'];
        $sqlData['startTime_1'] = $data['startTime_1'];
        $sqlData['endTime_1'] = $data['endTime_1'];
        $sqlData['surveyType'] = $data['surveyType'];
        $sqlData['realClass'] = $data['realClass'];
        //$sqlData['vehicle'] = $data['vehicle'];
        $sqlData['surveyLocation'] = $data['surveyLocation'];
        $sqlData['bookLong'] = $data['bookLong'];
        $sqlData['bookLat'] = $data['bookLat'];
        $sqlData['map_address'] = $data['map_address'];
        $sqlData['diy_name'] = $data['diy_name'];
        $sqlData['diy_value'] = $data['diy_value'];
        $sqlData['surveyTimeHours'] = $data['surveyTimeHours'];
        $sqlData['estimatedManHour'] = $data['estimatedManHour'];
        $sqlData['totalHours'] = $data['totalHours'];
        $sqlData['img_url'] = $data['img_url'];

        foreach ($sqlData as $k => $v) {
            if (is_null($v)) {
                unset($sqlData[$k]);
            }
        }

        $sm_sql = "SELECT mascId,vehicle from Survey_MainSchedule WHERE jobNo = '{$jobNo}'";
        $db->query($sm_sql);
        $sm = array();
        while ($rs = $db->next_record()) {
            if (!array_key_exists($rs['vehicle'], $sm)) {
                $sm[$rs['vehicle']] = array();
            }
            $sm[$rs['vehicle']][] = $rs['mascId'];
        }
        foreach ($vehicle_arr as $vek => $vev) {
            if (array_key_exists($vev['oldVehicle'], $sm) || empty($vev['oldVehicle'])) {
                $mascIds = false;
                if (!empty($sm[$vev['oldVehicle']])) {
                    $mascIds = implode(',', $sm[$vev['oldVehicle']]);
                }
                updateVehicle($jobNo, $vev['oldVehicle'], $vev['newVehicle'], $mascIds);
            } else {
                returnJson('failed', '', 'Vehicle ' . $vev['oldVehicle'] . ' Not Found');
            }
        }

        /*foreach($vehicle_arr as $vk=>$vv){
            updateVehicle($jobNo, $vv['oldVehicle'], $vv['newVehicle']);
        }*/
        if (!empty($sqlData)) {
            $rsData['mascId'] = $ja->updateByJobNo($sqlData, $data['jobNo']);
        }

        $title = '新消息通知';
        $content = '管理員修改了 ' . $jobNo . ' 的課堂信息';
        $type = 2;
        addNotifition($title, $content, $type);

        $message = array(
            'status' => 'success',
            'msg' => '',
            'data' => ''
        );
        die(json_encode($message));
    } else {
        returnJson('failed', '', 'Permission Error');
    }
}


/*
 * 增加课堂（多主题）
 * $insert_num 增加的课堂数量
 * $countStart 课堂编号开始位置
 * */
function insert_Class($jobNo, $insert_num, $insert_data, $countStart = 0)
{
    global $db;
    $ja = new JobsAccess($db);
    $insrtData = array();
    for ($i = 1; $i <= $insert_num; $i++) {
        $tmp = int_to_chr_2($countStart + $i);
        $jobNoNew = $jobNo . strtolower($tmp);
        $sqlData = array();
        $sqlData['jobNoShort'] = $jobNo;
        $sqlData['jobNo'] = $jobNo;
        $sqlData['jobNoNew'] = $jobNoNew;

        $sqlData['realClass'] = $insert_data['realClass'];//是否减课堂数，1是，0否
        $sqlData['surveyType'] = $insert_data['surveyType'];

        if (isset($insert_data['vehicle1_num']) && $insert_data['vehicle1_num'] > 0) {
            if ($i <= $insert_data['vehicle1_num']) {
                $sqlData['vehicle'] = $insert_data['vehicle1'];
            } else {
                $sqlData['vehicle'] = $insert_data['vehicle2'];
            }
        } else {//追加固定主题
            $sqlData['vehicle'] = $insert_data['vehicle'];
        }

        $sqlData['surveyLocation'] = $insert_data['surveyLocation'];
        $sqlData['surveyLocationDistrict'] = $insert_data['surveyLocationDistrict'];
        $sqlData['plannedSurveyDate'] = $insert_data['plannedSurveyDate'];
        $sqlData['actualSurveyDate'] = $insert_data['actualSurveyDate'];
        $sqlData['startTime_1'] = $insert_data['startTime_1'];
        $sqlData['endTime_1'] = $insert_data['endTime_1'];
        $sqlData['totalHours'] = $insert_data['totalHours'];
        $sqlData['surveyTimeHours'] = $insert_data['surveyTimeHours'];
        $sqlData['estimatedManHour'] = $insert_data['estimatedManHour'];
        $sqlData['totalWages'] = $insert_data['totalWages'];
        $sqlData['surveyorCode'] = $insert_data['surveyorCode'];
        $sqlData['complateJobNo'] = $insert_data['complateJobNo'];
        $sqlData['surveyorName'] = $insert_data['surveyorName'];
        $sqlData['surveyorTelephone'] = $insert_data['surveyorTelephone'];
        $sqlData['bookLong'] = $insert_data['bookLong'];
        $sqlData['bookLat'] = $insert_data['bookLat'];
        $sqlData['map_address'] = $insert_data['map_address'];
        $sqlData['diy_name'] = $insert_data['diy_name'];
        $sqlData['diy_value'] = $insert_data['diy_value'];

        if (array_key_exists('img_url', $insert_data)) {
            $sqlData['img_url'] = $insert_data['img_url'];
        } else {
            $sqlData['img_url'] = array_key_exists('imgUrl', $insert_data) ? $insert_data['imgUrl'] : '';//TODO
        }

        $sqlData['is_image'] = array_key_exists('isImage', $insert_data) ? $insert_data['isImage'] : 0;//TODO

        $insrtData[] = $sqlData;
    }
    foreach ($insrtData as $k => $v) {
        $res = $ja->save($v);
    }
    $msoa = new MainScheduleOpenAccess($db);
    if ($msoa->isOpenJob($jobNo)) {
        $msoa->RealDelbyJobNoNew($jobNo);
        $mso = new MainScheduleOpen();
        $jobNoNew_sql = "SELECT jobNoNew FROM Survey_MainSchedule WHERE jobNo='{$jobNo}'";
        $db->query($jobNoNew_sql);
        $jobNoNews = array();
        while ($rs = $db->next_record()) {
            $jobNoNews[] = $rs['jobNoNew'];
        }
        foreach ($jobNoNews as $k => $v) {
            if (empty ($v)) continue;
            //添加记录
            $mso->batchNumber = uniqid();
            $mso->jobNoNew = $v;
            $msoa->Add($mso);
        }
    }
    return $res;
}

/*
 * 設置主題的課堂數量
 *
 * */
function setVehicleClass($data)
{
    global $db;
    $surInfo = getSurInfo($data['sign']);
    $jobNo = getArrNoNull($data, 'jobNo');
    $classNum = getArrNoNull($data, 'classNum');
    $vehicle = getArrNoNull($data, 'vehicle');

    if ($classNum < 0) {
        returnJson('failed', '', 'ClassNum Error');
    }

    $ja = new JobsAccess($db);
    $isExist = $ja->isExistJobNo($jobNo);
    if (!$isExist) {
        returnJson('failed', '', 'JobNo Not Found');
    }

    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {

        $sql = <<<EOF
SELECT s1.*,count(s2.vehicle) as class_num, count(s1.vehicle) as all_num,s1.vehicle,s1.surveyType 
FROM 
Survey_MainSchedule as s1 
left join (SELECT vehicle,mascId FROM Survey_MainSchedule WHERE  jobNo = '$jobNo' and (surveyorCode = '' or surveyorCode is null) ) as s2 on s2.mascId=s1.mascId
WHERE 1=1 and jobNo = '$jobNo'  GROUP BY s1.vehicle
EOF;

        //$sql = "SELECT *,count(vehicle) as class_num FROM Survey_MainSchedule " . " WHERE 1=1 and jobNo = '{$jobNo}'  GROUP BY vehicle";
        $db->query($sql);
        $hadSearched = false;

        while ($rs = $db->next_record()) {
            if ($vehicle == $rs['vehicle']) {
                $hadSearched = true;
                $countChange = $rs['class_num'];
                $res = $rs;
                $res['surveyorCode'] = '';
                $res['surveyorName'] = '';
                $res['surveyorTelephone'] = '';
                foreach ($res as $k => $v) {
                    if (is_int($k)) {
                        unset($res[$k]);
                    }
                }
                break;
            }
        }


        if ($hadSearched === true) {
            if ($classNum > $countChange) {
                $insert_num = $classNum - $countChange;

                //獲取jobNoNew 的字母序號
                $tmpSql = "SELECT jobNo,jobNoNew FROM Survey_MainSchedule where jobNo='{$jobNo}' order by mascId desc limit 1";
                $db->query($tmpSql);
                if ($tmpRs = $db->next_record()) {
                    $tmpABC = explode($tmpRs['jobNo'], $tmpRs['jobNoNew']);
                    $countStart = chr_to_int($tmpABC[1]);
                }

                $res = insert_Class($jobNo, $insert_num, $res, $countStart);
                $returnStr = $res == false ? 'failed' : 'success';
                //TODO Insert All
                //$ja->saveAll($insrtData);
                returnJson($returnStr);
            } else {
                $delete_num = $countChange - $classNum;
                $changeSql = "DELETE FROM Survey_MainSchedule WHERE jobNo = '{$jobNo}' and vehicle = '{$vehicle}' and (surveyorCode = '' or surveyorCode is Null) limit {$delete_num}";
                $db->query($changeSql);
                returnJson('success');
            }

        } else {
            returnJson('failed', '', 'Vehicle Not Found');
        }

    } else {
        returnJson('failed', '', 'Permission Error');
    }
}

/*
 * 根據jobNo 獲取主題信息
 * */
function getVehicle($data)
{
    global $db;
    $surInfo = getSurInfo($data['sign']);

    $jobNo = getArrNoNull($data, 'jobNo');
    $ja = new JobsAccess($db);
    $isExist = $ja->isExistJobNo($jobNo);
    if (!$isExist) {
        returnJson('failed', '', 'JobNo Not Found');
    }
    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {
        $sql = <<<EOF
SELECT count(s2.vehicle) as class_num, count(s1.vehicle) as all_num,s1.vehicle,s1.surveyType 
FROM 
Survey_MainSchedule as s1 
left join (SELECT vehicle,mascId FROM Survey_MainSchedule WHERE  jobNo = '$jobNo' and surveyorCode = '' ) as s2 on s2.mascId=s1.mascId
WHERE 1=1 and jobNo = '$jobNo'  GROUP BY s1.vehicle
EOF;
        //$sql = "SELECT count(vehicle) as class_num,vehicle,surveyType FROM Survey_MainSchedule " . " WHERE 1=1 and jobNo = '{$jobNo}'  GROUP BY vehicle";
        $db->query($sql);
        $res = array();
        while ($rs = $db->next_record()) {
            $tmpArr['class_num'] = $rs['class_num'];
            $tmpArr['all_num'] = $rs['all_num'];
            $tmpArr['vehicle'] = $rs['vehicle'];
            $tmpArr['surveyType'] = $rs['surveyType'];
            $res[] = $tmpArr;
        }
        returnJson('success', $res, '');
    } else {
        returnJson('failed', '', 'Permission Error');
    }
}


function add($data)
{
    global $db;

    $surInfo = getSurInfo($data['sign']);
    if ($surInfo->survType == 'admin' || $surInfo->survType == 'teach') {
        getArrNoNull($data, 'surveyLocationDistrict');
        getArrNoNull($data, 'plannedSurveyDate');
        getArrNoNull($data, 'actualSurveyDate');
        getArrNoNull($data, 'startTime_1');
        getArrNoNull($data, 'endTime_1');
        getArrNoNull($data, 'vehicle1');
        $jobNo = getArrNoNull($data, 'jobNo');
        $vehicle1_num = getArrNoNull($data, 'vehicle1_num');
        $bookLong = getArrNoNull($data, 'bookLong');
        $bookLat = getArrNoNull($data, 'bookLat');
        $map_address = getArrNoNull($data, 'map_address');
        $diy_name = getArrNoNull($data, 'diy_name');
        $diy_value = getArrNoNull($data, 'diy_value');

        $ja = new JobsAccess($db);
        $isExist = $ja->isExistJobNo($jobNo);

        if ($isExist) {
            returnJson('failed', '', 'JobNo Existed');
        }
        $classNum = $vehicle1_num;

        if (isset($data['vehicle2']) && isset($data['vehicle2_num'])) {
            $classNum = $vehicle1_num + $data['vehicle2_num'];
        }
        if (!isset($data['realClass'])) {
            $data['realClass'] = 1;
        }
        $res = insert_Class($jobNo, $classNum, $data);
        $returnStr = $res == false ? 'failed' : 'success';
        returnJson($returnStr);

    } else {
        returnJson('failed', 'Permission Error', '');
    }
}

/**
 * 批量關閉job
 * @param $data
 */
function batchCloseJob($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $mso = new MainScheduleOpen();
    $msoa = new MainScheduleOpenAccess($db);
    $mso->inputUserId = $survId;
    $mso->inputTime = date("Y-m-d H:i:s");
    //$relationJobNoNews = $data['relationJobNoNews'];
    //$relationJobNoNewsArray = explode(",", $relationJobNoNews);
    $jobNo = $data['jobNo'];
    $msoa->RealDelbyJobNoNew($jobNo);
    /*$jobNoNew_sql = "SELECT jobNoNew FROM Survey_MainSchedule WHERE jobNo='{$jobNo}'";
    $db->query($jobNoNew_sql);
    $jobNoNews = array();
    while ( $rs = $db->next_record () ) {
        $jobNoNews[] = $rs['jobNoNew'];
    }

    foreach ($jobNoNews as $k => $v) {
        if (empty ($v)) continue;
        //添加记录
        $mso->batchNumber = uniqid();
        $mso->jobNoNew = $v;
        $msoa->RealDelbyJobNoNew($mso->jobNoNew);
    }*/
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => ''
    );
    die(json_encode($message));
}

/**
 * 批量开放job
 * @param $data
 */
function batchOpenJob($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $mso = new MainScheduleOpen();
    $msoa = new MainScheduleOpenAccess($db);
    $mso->inputUserId = $survId;
    $mso->inputTime = date("Y-m-d H:i:s");
    //$relationJobNoNews = $data['relationJobNoNews'];
    //$relationJobNoNewsArray = explode(",", $relationJobNoNews);
    $jobNo = $data['jobNo'];
    $jobNoNew_sql = "SELECT jobNoNew FROM Survey_MainSchedule WHERE jobNo='{$jobNo}'";
    $db->query($jobNoNew_sql);
    $jobNoNews = array();
    while ($rs = $db->next_record()) {
        $jobNoNews[] = $rs['jobNoNew'];
    }
    foreach ($jobNoNews as $k => $v) {
        if (empty ($v)) continue;
        //添加记录
        $mso->batchNumber = uniqid();
        $mso->jobNoNew = $v;
        $msoa->Add($mso);
    }

    $title = '新消息通知';
    $content = '開放新課堂啦';
    $type = 1;
    addNotifition($title, $content, $type);


    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => ''
    );
    die(json_encode($message));
}


/**
 * 添加通知记录
 *
 * */
function addNotifition($title, $content, $type)
{
    global $db;

    $create_time = date('Y-m-d H:i:s');
    $messageModel = new MessagesNew();
    $messageAccess = new MessagesNewAccess($db);

    $messageModel->content = $content;
    $messageModel->title = $title;
    $messageModel->type = $type;
    $messageModel->create_time = $create_time;

    return $messageAccess->Add($messageModel);
}


/**
 * 批量刪除（根據jobNo）
 * @param $data
 */
function batchDelJobs($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $ja = new JobsAccess($db);
    if (empty($data['jobNo'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Params Error',
            'data' => array()
        );
        die(json_encode($message));
    }

    $hadRes = $ja->hadAssignSurveryor($data['jobNo']);
    if ($hadRes) {
        returnJson('failed', '', '該課堂有已分配學員，請取消分配后再刪除');
    }

    $ja->batchDelete($data['jobNo']);
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => array()
    );
    die(json_encode($message));
}

/*
 * 获取付款证明pdf
 *
 * */

function getPaymentPDF($data)
{
    global $conf;
    if (empty($data['sign'])) {
        http_code(404);
        exit;
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        http_code(404);
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    if (empty($data['jobNo'])) {
        http_code(404);
        $message = array(
            'status' => 'failed',
            'msg' => 'The jobNo is incomplete.',
            'data' => array()
        );
        die(json_encode($message));
    }
    if (empty($data['jobNoNew'])) {
        Header("HTTP/1.1 404 Not Found");
        $message = array(
            'status' => 'failed',
            'msg' => 'The jobNoNew is incomplete.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $jobNo = $data['jobNo'];
    $shortTwoLetter = $shortTwoLetter = substr($data['jobNoNew'], 0, 1);
    $districtName = $conf['shortDistrictName'][$shortTwoLetter];
    $path = "/{$districtName}/{$jobNo}/";
    $path = $conf["path"]["root"] . 'cache/' . $path;
    $fileName = $path . $data['jobNoNew'] . '.pdf';
    if (!file_exists($fileName)) {
        header('HTTP/1.1 404 Not Found');
        $message = array(
            'status' => 'failed',
            'msg' => $fileName . ' FILE NOT FOUND',
            'data' => array()
        );
        die(json_encode($message));
    }

// required
    header('Pragma: public');
//no cache
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
//强制下载
    header('Content-Type:application/force-download');
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Connection: close');
    //输出到浏览器
    readfile($fileName);
    exit();
}

/**
 * 保存工作
 * @param $data
 */


function saveJobs($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(

            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    if (empty($data['jobNoNew'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'The information is incomplete.',
            'data' => array()
        );
        die(json_encode($message));
    }
    //判断是否接收到了图片的url
    if (empty($data['imgUrl'])) {
        $data['imgUrl'] = '';
    }
    $sqlData = array();
    $sqlData['weekNo'] = $data['weekNo'];
    $sqlData['jobNoShort'] = $data['jobNoShort'];
    $sqlData['jobNo'] = $data['jobNo'];
    $sqlData['jobNoNew'] = $data['jobNoNew'];
    $sqlData['plannedSurveyDate'] = $data['plannedSurveyDate'];
    $sqlData['tdFileNo'] = $data['tdFileNo'];
    $sqlData['receivedDate'] = $data['receivedDate'];
    $sqlData['dueDate'] = $data['dueDate'];
    $sqlData['fromTD'] = $data['fromTD'];
    $sqlData['actualSurveyDate'] = $data['actualSurveyDate'];
    $sqlData['startTime_1'] = $data['startTime_1'];
    $sqlData['endTime_1'] = $data['endTime_1'];
    $sqlData['startTime_2'] = $data['startTime_2'];
    $sqlData['endTime_2'] = $data['endTime_2'];
    $sqlData['startTime_3'] = $data['startTime_3'];
    $sqlData['endTime_3'] = $data['endTime_3'];
    $sqlData['startTime_4'] = $data['startTime_4'];
    $sqlData['endTime_4'] = $data['endTime_4'];
    $sqlData['totalHours'] = $data['totalHours'];
    $sqlData['surveyTimeHours'] = $data['surveyTimeHours'];
    $sqlData['stCode'] = $data['stCode'];
    $sqlData['surveyType'] = $data['surveyType'];
    $sqlData['vehCode'] = $data['vehCode'];
    $sqlData['vehicle'] = $data['vehicle'];
    $sqlData['isHoliday'] = $data['isHoliday'];
    $sqlData['bonusHours'] = $data['bonusHours'];
    $sqlData['surveyLocationDistrict'] = $data['surveyLocationDistrict'];
    $sqlData['surveyLocation'] = $data['surveyLocation'];
    $sqlData['routeItems'] = $data['routeItems'];
    $sqlData['noOfSurveyors'] = $data['noOfSurveyors'];
    $sqlData['estimatedManHour'] = $data['estimatedManHour'];
    $sqlData['receiveDate'] = $data['receiveDate'];
    $sqlData['dataInputNo'] = $data['dataInputNo'];
    $sqlData['dataInputBy'] = $data['dataInputBy'];
    $sqlData['entryFormTypeNo'] = $data['entryFormTypeNo'];
    $sqlData['noOfPages'] = $data['noOfPages'];
    $sqlData['report'] = $data['report'];
    $sqlData['hourlyRate'] = $data['hourlyRate'];
    $sqlData['surveyFinding'] = $data['surveyFinding'];
    $sqlData['am'] = $data['am'];
    $sqlData['periodHour_1'] = $data['periodHour_1'];
    $sqlData['periodWagesHr_1'] = $data['periodWagesHr_1'];
    $sqlData['periodHour_2'] = $data['periodHour_2'];
    $sqlData['periodWagesHr_2'] = $data['periodWagesHr_2'];
    $sqlData['totalWages'] = $data['totalWages'];
    $sqlData['onBoardCostFare'] = $data['onBoardCostFare'];
    $sqlData['noOfTrips'] = $data['noOfTrips'];
    $sqlData['transportAllowanceAm'] = $data['transportAllowanceAm'];
    $sqlData['transportAllowanceNoon'] = $data['transportAllowanceNoon'];
    $sqlData['transportAllowancePm'] = $data['transportAllowancePm'];
    $sqlData['transportAllowanceOvernight'] = $data['transportAllowanceOvernight'];
    $sqlData['taTotal'] = $data['taTotal'];
    $sqlData['wagesTaOnBoard'] = $data['wagesTaOnBoard'];
    $sqlData['onBoardTranportAllowanceTotal'] = $data['onBoardTranportAllowanceTotal'];
    $sqlData['surveyorCode'] = $data['surveyorCode'];
    $sqlData['surveyorName'] = $data['surveyorName'];
    $sqlData['surveyorTelephone'] = $data['surveyorTelephone'];
    $sqlData['complateJobNo'] = $data['complateJobNo'];
    $sqlData['distributedToLeader'] = $data['distributedToLeader'];
    $sqlData['reportWeek'] = $data['reportWeek'];
    $sqlData['surveyLocationCn'] = $data['surveyLocationCn'];
    $sqlData['direction'] = $data['direction'];
    $sqlData['bookLong'] = $data['bookLong'];
    $sqlData['bookLat'] = $data['bookLat'];
    $sqlData['map_address'] = $data['map_address'];
    $sqlData['diy_name'] = $data['diy_name'];
    $sqlData['diy_value'] = $data['diy_value'];
    $sqlData['img_url'] = $data['imgUrl'];


    $ja = new JobsAccess($db);
    $mascId = intval($data['mascId']);
    if ($mascId > 0) {
        $rsData['mascId'] = $mascId;
        $ja->update($sqlData, $mascId);
    } else {
        $searchData = array();
        $searchData['jobNoNew'] = $data['jobNoNew'];
        $info = $ja->getInfo($searchData);
        if (!empty($info)) {
            $message = array(
                'status' => 'failed',
                'msg' => 'jobNoNew is already exist.',
                'data' => array()
            );
            die(json_encode($message));
        }
        $rsData['mascId'] = $ja->save($sqlData);
    }
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $rsData
    );
    die(json_encode($message));
}

/**
 * 獲取单个工作的具体内容
 * @param $data
 */
function getInfo($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $ja = new JobsAccess($db);
    $sqlData = array();
    $sqlData['jobNoNew'] = $data['jobNoNew'];
    $rs = $ja->getInfo($sqlData);
    $rs['startTime_1'] = date('H:i', strtotime(date('Y-m-d') . $rs['startTime_1']));
    $rs['endTime_1'] = date('H:i', strtotime(date('Y-m-d') . $rs['endTime_1']));
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $rs
    );
    die(json_encode($message));

}

/**
 * 删除某个工作
 * @param $data
 */
function deleteInfo($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $ja = new JobsAccess($db);
    $mascId = intval($data['mascId']);
    $ja->delete($mascId);
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => array()
    );
    die(json_encode($message));
}

/**
 * 獲取所有工作列表
 * @param $data
 */

//function getJobs($data)
//{
//    global $conf, $db;
//    if (empty($data['sign'])) {
//        $message = array(
//            'status' => 'failed',
//            'msg' => 'sign is null.',
//            'data' => array()
//        );
//        die(json_encode($message));
//    }
//    $filename = $conf["path"]["sign"] . $data['sign'];
//    $survId = file_get_contents($filename);
//    if (empty($survId)) {
//        $message = array(
//            'status' => 'failed',
//            'msg' => 'Login has expired.',
//            'data' => array()
//        );
//        die(json_encode($message));
//    }
//    $ja = new JobsAccess($db);
//    $rs = $ja->getList2(array());
//    foreach ($rs as $k => $v) {
//        foreach ($v as $kk => $vv) {
//            if (is_string($vv)) {
//                if ($encode = mb_detect_encoding($vv, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'))) {
//                }
//            }
//        }
//    }
//}

function getJobs($data)
{
    global $conf, $db;

    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $is_goods = isset($data['is_goods']) ? $data['is_goods'] : false;
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $ja = new JobsAccess($db);
    $rs = $ja->getList2(array(), '', '', $is_goods);
    foreach ($rs as $k => $v) {
        foreach ($v as $kk => $vv) {
            if (is_string($vv)) {
                if ($encode = mb_detect_encoding($vv, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'))) {

                    $rs[$k][$kk] = mb_convert_encoding($vv, 'UTF-8', $encode);
                }
            }
        }
    }

    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $rs
    );
    die(json_encode($message));


    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $rs
    );
    die(json_encode($message));

}

/**
 * 获取已报名的学员列表
 * @param $data
 */
function getJobNoNewList($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    if (empty($data['jobNo'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'JobNo is not allow null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $ja = new JobsAccess($db);
    $filter = array();
    $filter['jobNo'] = $data['jobNo'];
    $other = '';
    if ($data['showType'] == 'all') {
        $other = '';
    } else if ($data['showType'] == 'noAssign') {
        $other = ' AND (surveyorCode <= 0 OR surveyorCode IS NULL)';
    } else {
        $other = ' AND surveyorCode > 0';
    }
//
    $rs = $ja->getJobNoNewList($filter, $other);

    $jobNoNews = "";
    foreach ($rs as $k => $v) {
        $jobNoNews .= ",'{$v['jobNoNew']}'";
    }
    $jobNoNews = substr($jobNoNews, 1);
    //是否开放让用户自主选择
    $msoa = new MainScheduleOpenAccess($db);
    $openJobs = $msoa->GetOpenJobNoNews($jobNoNews);

    foreach ($rs as $k => $v) {
        if ($confirm_pdfid = is_confirm($v['jobNoNew'], $v['surveyorCode'])) {
            $v['had_confirm'] = true;
            $v['confirm_pdfid'] = $confirm_pdfid;
        } else {
            $v['had_confirm'] = false;
            $v['confirm_pdfid'] = '0';
        }
        $openJob = $openJobs[$v['jobNoNew']];
        if (!empty($openJob)) {
            $v['isOpen'] = '1';
        } else {
            $v['isOpen'] = '0';
        }
        if ($v['surveyorCode'] > 0) {
            $v['assignStatus'] = 'assigned';
        } else if ($openJob['applySurvId'] > 0) {
            $v['assignStatus'] = 'pending';
            $v['surveyorCode'] = $openJob['applySurvId'];
            $v['surveyorName'] = $openJob['applyEngName'];
            $v['surveyorChiName'] = $openJob['applyChiName'];
            $v['surveyorTelephone'] = $openJob['applyContact'];
            $v['surveyorProfilePhoto'] = $openJob['applyProfilePhoto'];
        } else {
            $v['assignStatus'] = 'waiting';
        }
        $rs[$k] = $v;
    }
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $rs
    );
    die(json_encode($message));
}


/**
 * 管理员设置学员状态（已到，缺席，迟到，替代者，病假）
 * $data['status'] 默认1，1已到，2：迟到，3：他人报道，4：病假）
 * $data['status_mark'] status 为3时记录用
 * @param $data
 */
function setStatus($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);

    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $data['survId'] = $survId;
    $s = new Surveyor();
    $sa = new SurveyorAccess($db);
    $s->survId = $survId;
    $rsSurveyor = $sa->GetListSearch($s);

    if (count($rsSurveyor) > 0) {
        $data['engName'] = $rsSurveyor[0]->engName;
    }
    if ($rsSurveyor[0]->survType == 'surveyor') {

        $sql = "SELECT mso.sjop FROM Survey_SurveyJobOpen mso
				WHERE 1=1 AND mso.delFlag='no' and JobNo = '{$data['jobNo']}'";
        $db->query($sql);

        $isOpen = false;
        while ($rs = $db->next_record()) {
            $isOpen = true;
        }
        if ($isOpen == false) {
            $message = array(
                'status' => 'failed',
                'msg' => '暫未開放自行報到',
                'data' => ''
            );
            echo json_encode($message);
            exit;
        }
    }

    $ja = new JobsAccess($db);
    $result = $ja->setDataEntryNew($data);
    if ($result) {
        $message = array(
            'status' => 'success',
            'msg' => '',
            'data' => ''
        );
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => '',
            'data' => ''
        );
    }
    die(json_encode($message));
}


/**
 * 上传已点名学员
 * @param $data
 */
function setDataEntry($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);

    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $data['survId'] = $survId;
    $s = new Surveyor();
    $sa = new SurveyorAccess($db);
    $s->survId = $survId;
    $rsSurveyor = $sa->GetListSearch($s);

    if (count($rsSurveyor) > 0) {
        $data['engName'] = $rsSurveyor[0]->engName;
    }
    if ($rsSurveyor[0]->survType == 'surveyor') {

        $sql = "SELECT mso.sjop FROM Survey_SurveyJobOpen mso
				WHERE 1=1 AND mso.delFlag='no' and JobNo = '{$data['jobNo']}'";
        $db->query($sql);

        $isOpen = false;
        while ($rs = $db->next_record()) {
            $isOpen = true;
        }
        if ($isOpen == false) {
            $message = array(
                'status' => 'failed',
                'msg' => '暫未開放自行報到',
                'data' => ''
            );
            echo json_encode($message);
            exit;
        }
    }

    $ja = new JobsAccess($db);
    $result = $ja->setDataEntry($data);
    if ($result) {
        $message = array(
            'status' => 'success',
            'msg' => '',
            'data' => ''
        );
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => '',
            'data' => ''
        );
    }
    die(json_encode($message));
}

/**
 * 获取已报名的学员列表
 * @param $data
 */
function getDataEntryList($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    if (empty($data['jobNo'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'JobNo is not allow null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $ja = new JobsAccess($db);
    $filter = array();
    $filter['jobNo'] = $data['jobNo'];
    $other = '';
    $rs = $ja->getDataEntryList($filter, $other);

    $sjoa = new SurveyJobOpenAccess($db);
    $sjo = new SurveyJobOpen();
    $sjo->delFlag = 'no';
    $sjo->isOpen = '';
    $sjo->jobNo = $data['jobNo'];
    $result = $sjoa->GetListSearch($sjo);
    $isOpen = 'no';
    if (!empty($result[0])) {
        $isOpen = $result[0]->isOpen;
    }
    $message = array(
        'status' => 'success',
        'msg' => '',
        'isOpen' => $isOpen,
        'data' => $rs
    );
    die(json_encode($message));
}

/**
 * 设置某个课堂自行点名
 * @param $data
 */
function setJobOpenStatus($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    if (empty($data['jobNo'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'JobNo is not allow null.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $sjoa = new SurveyJobOpenAccess($db);
    $sjo = new SurveyJobOpen();
    $sjo->inputTime = date("Y-m-d H:i:s");
    $sjo->inputUserId = $survId;
    $sjo->jobNo = $data['jobNo'];
    $sjoa->DelByJobNo($sjo);
    if ($data['isOpen'] == 'yes') {
        $sjo->isOpen = 'yes';
        $sjoa->Add($sjo);
    }
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => array("jobNo" => $sjo->jobNo, "isOpen" => $sjo->isOpen)
    );
    die(json_encode($message));
}

/**
 * 设置某个课堂自行点名
 * @param $data
 * @param $action
 */
function assignSurveyor($data, $action)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    if (!isset($data['jobNo']) || empty($data['jobNo'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'jobNo is require',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $editId = file_get_contents($filename);
    if (empty($editId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    if (empty($data['jobNoNew'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'jobNoNew is not allow null.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $survId = $data['assignSurvId'];
    $jobNoNew = $data['jobNoNew'];

    if ($action == 'unassign') {
        $ms = new MainSchedule();
        $ms->jobNoNewSigle = $jobNoNew;
        $msa = new MainScheduleAccess($db);
        $rs = $msa->GetListSearch($ms);
        $ms = $rs[0];
        $survId = $ms->surveyorCode;
    }

    // 调查员基本信息
    $sur = new Surveyor();
    $sa = new SurveyorAccess($db);
    $sur->survId = $survId;
    $sur->company = '';
    $rs = $sa->GetListSearch($sur);
    if (!empty($rs)) {
        $sur = $rs[0];
    }
    $msg = '';
    if ($action == 'assign') {

        /*if($sur->class_sum <=0 ){
            $message = array (
                'status' => 'failed',
                'msg' => '剩餘課堂數不足，選取失敗',
                'data' => array()
            );
            die(json_encode($message));
        }else{
            $used_class_num_sql = "SELECT count(mascId) as class_num_sql FROM Survey_MainSchedule " . " WHERE 1=1  AND surveyorCode = ".$data['assignSurvId'] ." and (actualSurveyDate < '".date('Y-m-d')."' or (actualSurveyDate = '".date('Y-m-d')."' and endTime_1 <= '".date('H:i:s')."'))";
            $db->query ( $used_class_num_sql );
            while ( $rs = $db->next_record () ) {
                $used_class_num = $sur->class_sum - $rs['class_num_sql'];
            }
            if($used_class_num <= 0 ){
                $message = array (
                    'status' => 'failed',
                    'msg' => '剩餘課堂數不足，選取失敗',
                    'data' => array()
                );
                die(json_encode($message));
            }
        }*/

        $res = $sa->Assign($sur, $jobNoNew, $data['jobNo'], $editId);

        if ($res === false) {
            $message = array(
                'status' => 'error',
                'msg' => 'Student existed',
                'data' => array()
            );
            die(json_encode($message));
        }
        $msg = "Assign Success.";
    } else if ($action == 'unassign') {
        $sa->UnAssign($sur, $jobNoNew);
        $msg = "UnAssign Success.";
    }
    $message = array(
        'status' => 'success',
        'msg' => $msg,
        'data' => array()
    );
    die(json_encode($message));
}

/**
 * 开放job
 * @param $data
 */
function openJob($data)
{
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $mso = new MainScheduleOpen();
    $msoa = new MainScheduleOpenAccess($db);
    $mso->inputUserId = $survId;
    $mso->inputTime = date("Y-m-d H:i:s");
    //$relationJobNoNews = $data['relationJobNoNews'];
    //$relationJobNoNewsArray = explode(",", $relationJobNoNews);
    $jobNoNews = $data['jobNoNews'];
    $jobNoNewsArray = explode(",", $jobNoNews);
    foreach ($jobNoNewsArray as $k => $v) {
        if (empty ($v)) continue;
        //添加记录
        $mso->batchNumber = uniqid();
        $mso->jobNoNew = $v;
        $msoa->Add($mso);
        //如果有关联的job,以同一批号插入
        /*foreach($relationJobNoNewsArray as $v2){
            if (empty ($v2)) continue;
            $mso->jobNoNew = $v2;
            $msoa->Add($mso);
        }*/
    }
    $message = array('success' => true, 'jobNoNew' => $mso->jobNoNew);
    die(json_encode($message));
}

function getSurInfo($sign)
{
    global $conf, $db;
    if (empty($sign)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is required.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $filename = $conf["path"]["sign"] . $sign;
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];
    if (empty($info)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Sign Not Found',
            'data' => array()
        );
        die(json_encode($message));
    }
    return $info;
}


/*
function tmp_add($data){
    global $db;
    $sa = new SurveyorAccess($db);

    for($i=0;$i<=125;$i++){
        echo $i.',';
    }

    exit;
    $tmp_arr = explode(',',$data['surs']);


    foreach($tmp_arr as $one_tmp){
        $get_empty_sql = "SELECT jobNoNew FROM Survey_MainSchedule where jobNo = '{$data['jobno']}' and surveyorName = '' order by mascId asc LIMIT 0,1";
        $db->query ( $get_empty_sql );
        while ( $rs = $db->next_record () ) {
            $jobNoNew = $rs['jobNoNew'];
        }
        $sur = new Surveyor();
        $sur->survId = $one_tmp;
        $sur->company = '';
        $rs = $sa->GetListSearch($sur);
        if (!empty($rs))
        {
            $sur = $rs[0];
        }
        $res = $sa->Assign($sur, $jobNoNew);
        var_dump($res);
    }
}
*/


function getArrNoNull($arr, $field)
{
    if (isset($arr[$field])) {
        return $arr[$field];
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => $field . ' is required',
            'data' => array()
        );
        die(json_encode($message));
    }
}

function returnJson($status = 'success', $data = '', $msg = '')
{

    /* if(!empty($data)){
         if(is_array($data)){
             foreach($data){

             }
         }
     }*/
    $message = array(
        'status' => $status,
        'msg' => $msg,
        'data' => $data
    );
    die(json_encode($message));
}

function chr_to_int($char)
{
    //检测字符串是否全字母
    $regex = '/^[a-zA-Z]+$/i';
    if (!preg_match($regex, $char)) return false;
    $int = 0;
    $char = strtoupper($char);
    $array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $len = strlen($char);
    for ($i = 0; $i < $len; $i++) {
        $index = array_search($char[$i], $array);
        $int += ($index + 1) * pow(26, $len - $i - 1);
    }
    return $int > 26 ? $int - 1 : $int;
}

function int_to_chr_2($int)
{
    if (!is_int($int) || $int <= 0) return false;
    $array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $str = '';
    if ($int > 26) {
        $str .= int_to_chr_2((int)floor($int / 26));
        $str .= $array[$int % 26];
        return $str;
    } else {
        return $array[$int - 1];
    }
}

function http_code($num)
{
    $http = array(
        100 => "HTTP/1.1 100 Continue",
        101 => "HTTP/1.1 101 Switching Protocols",
        200 => "HTTP/1.1 200 OK",
        201 => "HTTP/1.1 201 Created",
        202 => "HTTP/1.1 202 Accepted",
        203 => "HTTP/1.1 203 Non-Authoritative Information",
        204 => "HTTP/1.1 204 No Content",
        205 => "HTTP/1.1 205 Reset Content",
        206 => "HTTP/1.1 206 Partial Content",
        300 => "HTTP/1.1 300 Multiple Choices",
        301 => "HTTP/1.1 301 Moved Permanently",
        302 => "HTTP/1.1 302 Found",
        303 => "HTTP/1.1 303 See Other",
        304 => "HTTP/1.1 304 Not Modified",
        305 => "HTTP/1.1 305 Use Proxy",
        307 => "HTTP/1.1 307 Temporary Redirect",
        400 => "HTTP/1.1 400 Bad Request",
        401 => "HTTP/1.1 401 Unauthorized",
        402 => "HTTP/1.1 402 Payment Required",
        403 => "HTTP/1.1 403 Forbidden",
        404 => "HTTP/1.1 404 Not Found",
        405 => "HTTP/1.1 405 Method Not Allowed",
        406 => "HTTP/1.1 406 Not Acceptable",
        407 => "HTTP/1.1 407 Proxy Authentication Required",
        408 => "HTTP/1.1 408 Request Time-out",
        409 => "HTTP/1.1 409 Conflict",
        410 => "HTTP/1.1 410 Gone",
        411 => "HTTP/1.1 411 Length Required",
        412 => "HTTP/1.1 412 Precondition Failed",
        413 => "HTTP/1.1 413 Request Entity Too Large",
        414 => "HTTP/1.1 414 Request-URI Too Large",
        415 => "HTTP/1.1 415 Unsupported Media Type",
        416 => "HTTP/1.1 416 Requested range not satisfiable",
        417 => "HTTP/1.1 417 Expectation Failed",
        500 => "HTTP/1.1 500 Internal Server Error",
        501 => "HTTP/1.1 501 Not Implemented",
        502 => "HTTP/1.1 502 Bad Gateway",
        503 => "HTTP/1.1 503 Service Unavailable",
        504 => "HTTP/1.1 504 Gateway Time-out"
    );

    header($http[$num]);
}


function getJobNoNewByClassRecord($class_record_id)
{
    global $db;
    $sql = "SELECT jobNoNew,confirm_pdf FROM Survey_SurveyorClassRecord where id='$class_record_id'";
    $db->query($sql);
    $res = array();
    $res['jobNoNew'] = null;
    $res['confirm_pdf'] = null;
    if ($jobNoNew = $db->next_record()) {
        $res['jobNoNew'] = $jobNoNew['jobNoNew'];
        $res['confirm_pdf'] = $jobNoNew['confirm_pdf'];
    }

    return $res;
}

/**根据课堂编号获取已付款和未付款人员名单
 * @param $data
 */
function paymentHistory($data)
{
    global $db;
    $verdict = $data['verdict'];
    $jobNo = $data['jobNo'];
    $surInfo = getSurInfo($data['sign']);
    if (empty($verdict)) {
        $urlInfo = array(
            'status' => 'failed',
            'msg' => 'verdict is required ',
            'data' => ''
        );
        echo json_encode($urlInfo, JSON_UNESCAPED_UNICODE);
        exit();
    }
    if (empty($jobNo)) {
        $urlInfo = array(
            'status' => 'failed',
            'msg' => 'jobNo is required ',
            'data' => ''
        );
        echo json_encode($urlInfo, JSON_UNESCAPED_UNICODE);
        exit();
    }
    switch ($verdict) {
        case 1:
            $sql = "SELECT `surveyor_id`,`path`,`jobNoNew` FROM `Survey_SurveyorClassPDF` WHERE `jobNoNew` LIKE '{$jobNo}%' GROUP BY `jobNoNew`,`surveyor_id` ORDER BY `surveyor_id`";
            $db->query($sql);
            //获取已上传pdf名单
            while ($rs = $db->next_record()) {
                $userCodes['surveyor_id'] = $rs['surveyor_id'];
                $userCodes['jobNoNew'] = $rs['jobNoNew'];
                $userCodes['path'] = $rs['path'];

                $userCode[]=$userCodes;
            }
            if (!empty($userCode)) {
                $sqls = "SELECT `survId`,`chiName`,`engName`,`contact` FROM `Survey_Surveyor` WHERE `survId` IN (";
                $userSql = '';
                for ($i = 0; $i < count($userCode); $i++) {
                    if ($i == 0) {
                        $userSql = "'" . $userCode[$i]['surveyor_id'] . "'";
                    } else {
                        $userSql .= "," . "'" . $userCode[$i]['surveyor_id'] . "'";
                    }
                }
                $sqls .= $userSql . ")";
                $db->query($sqls);
                //获取名单信息
                while ($rss = $db->next_record()) {
                    $rs['survId'] = $rss['survId'];
                    $rs['chiName'] = $rss['chiName'];
                    $rs['engName'] = $rss['engName'];
                    $rs['contact'] = $rss['contact'];
                    $info[] = $rs;
                }
                //添加信息
                for($i=0;$i<count($info);$i++){
                        $info[$i]['jobNoNew']=$userCode[$i]['jobNoNew'];
                        $info[$i]['path']=$userCode[$i]['path'];
                }
                $urlInfo = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => $info
                );
                echo json_encode($urlInfo, JSON_UNESCAPED_UNICODE);
                break;
            } else {
                $urlInfo = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => ''
                );
                echo json_encode($urlInfo, JSON_UNESCAPED_UNICODE);
                break;
            }
        case 2:
            $sql = "SELECT `surveyorCode`,`jobNoNew` FROM `Survey_MainSchedule` WHERE `jobNo`='{$jobNo}' AND `surveyorCode`!=''";
            $db->query($sql);
            while ($rs = $db->next_record()) {
                $userCodes['surveyorCode'] = $rs['surveyorCode'];
                $userCodes['jobNoNew'] = $rs['jobNoNew'];
                $userCode[]=$userCodes;
            }
            if (!empty($userCode)) {
                $sql = "SELECT `surveyor_id` FROM `Survey_SurveyorClassPDF` WHERE `jobNoNew` LIKE '{$jobNo}%' GROUP BY `jobNoNew`,`surveyor_id`";
                $db->query($sql);
                while ($rs = $db->next_record()) {
                    $userIds[] = $rs['surveyor_id'];
                }
                //存在已上传pdf情况
                if (!empty($userIds)) {
                    //记录已上传的名单下标
                   for($j=0;$j<count($userCode);$j++){
                       for($k=0;$k<count($userIds);$k++){
                           if ($userCode[$j]['surveyorCode']==$userIds[$k]){
                               $code[]=$j;
                           }
                       }
                   }
                   //移除已上传的元素
                   $result=array_diff_key($userCode,$code);
                    $sqls = "SELECT `survId`,`chiName`,`engName`,`contact` FROM `Survey_Surveyor` WHERE `survId` IN (";
                    $userSql = '';
                    for ($i = 1; $i <= count($result); $i++) {
                        if ($i == 1) {
                            $userSql = "'" . $result[$i]['surveyorCode'] . "'";
                        } else {
                            $userSql .= "," . "'" . $result[$i]['surveyorCode'] . "'";
                        }
                    }
                    $sqls .= $userSql . ") ORDER BY `survId`";
                    $db->query($sqls);
                    while ($rss = $db->next_record()) {
                        $rs['survId'] = $rss['survId'];
                        $rs['chiName'] = $rss['chiName'];
                        $rs['engName'] = $rss['engName'];
                        $rs['contact'] = $rss['contact'];
                        $info[] = $rs;
                    }
                    //重新建立数组索引
                    $result=array_values($result);
                    //添加至返回信息
                   for ($i=0;$i<count($info);$i++){
                       $info[$i]['jobNoNew']=$result[$i]['jobNoNew'];
                       $info[$i]['path']='';
                   }
                    $urlInfo = array(
                        'status' => 'success',
                        'msg' => '',
                        'data' => $info
                    );
                    echo json_encode($urlInfo, JSON_UNESCAPED_UNICODE);
                    break;
                } else {
                    $sqls = "SELECT `survId`,`chiName`,`engName`,`contact` FROM `Survey_Surveyor` WHERE `survId` IN (";
                    $userSql = '';
                    for ($i = 0; $i < count($userCodes); $i++) {
                        if ($i == 0) {
                            $userSql = "'" . $userCodes[$i] . "'";
                        } else {
                            $userSql .= "," . "'" . $userCodes[$i] . "'";
                        }
                    }
                    $sqls .= $userSql . ")";

                    $db->query($sqls);
                    while ($rss = $db->next_record()) {
                        $rs['survId'] = $rss['survId'];
                        $rs['chiName'] = $rss['chiName'];
                        $rs['engName'] = $rss['engName'];
                        $rs['contact'] = $rss['contact'];
                        $info[] = $rs;
                    }
                    for ($i=0;$i<count($info);$i++){
                        $info[$i]['jobNoNew']=$userCode[$i]['jobNoNew'];
                        $info[$i]['path']='';
                    }
                    $urlInfo = array(
                        'status' => 'success',
                        'msg' => '',
                        'data' => $info
                    );
                    echo json_encode($urlInfo, JSON_UNESCAPED_UNICODE);
                    break;
                }
            } else {
                $urlInfo = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => ''
                );
                echo json_encode($urlInfo, JSON_UNESCAPED_UNICODE);
                break;
            }
        case 3:
            $sql="SELECT A.`surveyorCode`,A.`jobNoNew`,
(SELECT B.`path` FROM `Survey_SurveyorClassPDF` B WHERE B.`jobNoNew`=A.`jobNoNew`) AS path,
C.`chiName`,C.`engName`,C.`contact` FROM `Survey_MainSchedule` A,`Survey_Surveyor` C WHERE
A.`jobNo`='{$jobNo}' AND A.`surveyorCode`!='' AND A.`surveyorCode`=C.`survId`";
            $db->query($sql);
            while ($rss = $db->next_record()) {
                $rs['survId'] = $rss['surveyorCode'];
                $rs['chiName'] = $rss['chiName'];
                $rs['engName'] = $rss['engName'];
                $rs['contact'] = $rss['contact'];
                $rs['jobNoNew'] = $rss['jobNoNew'];
                if(!empty($rss['path'])){
                    $rs['path'] = $rss['path'];
                }else{
                    $rs['path']='';
                }
                $info[] = $rs;
            }
            $urlInfo = array(
                'status' => 'success',
                'msg' => '',
                'data' => $info
            );
            echo json_encode($urlInfo, JSON_UNESCAPED_UNICODE);
            break;
        default:
            $urlInfo = array(
                'status' => 'failed',
                'msg' => 'verdict parameter error ',
                'data' => ''
            );
            echo json_encode($urlInfo, JSON_UNESCAPED_UNICODE);
            break;
    }

}