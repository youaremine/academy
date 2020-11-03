<?php
/**
 *
 * @copyright 2007-2013 Xiaoqiang.Wu
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2013-3-27
 */
include_once("../includes/config.inc.php");
$tmp1 = json_decode(file_get_contents('php://input', 'r'), true);
$tmp2 = $_REQUEST;
if (!empty($tmp1)) {//旧版本请求
    $data = $tmp1;
    if (!isset($data['q'])) {
        $data['q'] = $tmp2['q'];
    }
} else {
    $data = $tmp2;
}


file_put_contents('/tmp/loginPass.log', "request:" . json_encode($_REQUEST) . "\n\r", FILE_APPEND);
file_put_contents('/tmp/loginPass.log', "php_input:" . $a . "\n\r", FILE_APPEND);

/*$rawJson = json_decode(file_get_contents('php://input', 'r'),true);
$data = !empty($rawJson['sign']) ? $rawJson:$_REQUEST;
if(empty($rawJson['q'])){
    $data['q'] = $_REQUEST['q'];
}*/


switch ($data['q']) {
    case 'setClassPDF' :
        setClassPDF($data);
        break;
    case 'setClass' :
        setClass($data);
        break;
    case 'delClass' :
        delClass($data);
        break;
    case 'editClass' :
        editClass($data);
        break;
    case 'login' :

        $username = $data['username'];
        $password = $data['password'];
        $login = new SurveyorLogin ($db);
        if ($login->Login($username, $password)) {//判断密码是否正确

            $s = new Surveyor ();
            $s->company = '';
            $s->status = 'active';
            $s->singleContact = $username;
            $sa = new SurveyorAccess($db);
            $rs = $sa->GetListSearch($s);
            $surveyor = array();
            $s = $rs[0];
            $surveyor['survId'] = $s->survId;
            $surveyor['upSurvId'] = $s->upSurvId;
            $surveyor['chiName'] = $s->chiName;
            $surveyor['engName'] = $s->engName;
            $surveyor['contact'] = $s->contact;
            $surveyor['dipaCode'] = $s->dipaCode;
            $surveyor['survType'] = $s->survType;
            $surveyor['profilePhoto'] = $s->profilePhoto;
            $surveyor['vip_level'] = $s->vip_level;

            if (!empty($surveyor['profilePhoto'])) {
                if (strpos($surveyor['profilePhoto'], 'images/profile-photo')) {
                    $surveyor['profilePhoto'] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . $surveyor['profilePhoto'];
                }
            }

            $message = array(
                'status' => 'success',
                'msg' => '',
                'surveyor' => $surveyor
            );
            //app的登录信息要写入文件,channel:1(安卓）;channel:2(IOS）
            if ($data['channel'] == 2 || $data['channel'] == 3) {
                $sign = date("Ymd") . uniqid();
                $message['sign'] = $sign;
                //写入到文件中
                $filename = $conf["path"]["sign"] . $sign;
                file_put_contents($filename, $s->survId);
            }

        } else {
            $tmp = ['survId' => '', 'upSurvId' => '', 'chiName' => '', 'engName' => '', 'contact' => '', 'dipaCode' => '', "survType" => '', "profilePhoto" => '', "vip_level" => ''];
            $message = array(
                'status' => 'failed',
                'msg' => "username:{$username} or password:{$password} is error.",
                'surveyor' => $tmp,
                'sign' => ''
            );
        }
        file_put_contents('/tmp/loginPass.log', json_encode($message) . "\n\r", FILE_APPEND);
        die(json_encode($message));
        break;


    case 'isLogin':
        if (empty($data['sign'])) {
            $message = array(
                'status' => 'failed',
                'msg' => 'sign is null.',
                'data' => array()
            );
            die(json_encode($message));
        }
        $filename = $conf["path"]["sign"] . $data['sign'];
        $surveyorCode = @file_get_contents($filename);
        if (empty($surveyorCode)) {
            $message = array(
                'status' => 'failed',
                'msg' => 'Login has expired.',
                'data' => array()
            );
            die(json_encode($message));
        } else {
            $message = array(
                'status' => 'success',
                'msg' => '',
                'data' => array()
            );
            die(json_encode($message));
        }
        break;
    case 'getJobs':

        $m = new MainSchedule();
        $ma = new MainScheduleAccess($db);
        $is_goods = isset($data['is_goods']) ? $data['is_goods'] : -1;
        if (empty($data['sign'])) {
            $message = array(
                'status' => 'failed',
                'msg' => 'sign is null.',
                'data' => array()
            );
            die(json_encode($message));
        }
        $filename = $conf["path"]["sign"] . $data['sign'];
        $surveyor_id = file_get_contents($filename);
        $m->surveyorCode = $surveyor_id;
        if (empty($m->surveyorCode)) {
            $message = array(
                'status' => 'failed',
                'msg' => 'Login has expired.',
                'data' => array()
            );
            die(json_encode($message));
        }
        $m->plannedSurveyDateStart = $data['startDate'];


        //如果有传jobNoNew 参数返回对应jobNoNew的单个记录
        if (array_key_exists('jobNoNew', $data)) {
            $m->jobNoNew = $data['jobNoNew'];
        }
        //是否搜索
        $term = $data['term'];
        if ($term !== '0' && empty($term)) {
            $rs = $ma->GetListSearch($m, $m->surveyorCode, $is_goods);
        } else {
            $rs = $ma->GetListSearch($m, $m->surveyorCode, $is_goods, $term);
        }

        $jsonArr = array();
        foreach ($rs as $obj) {
            $dr = array();
            $dr['mascId'] = $obj->mascId;
            $dr['weekNo'] = $obj->weekNo;
            $dr['jobNo'] = $obj->jobNo;
            $dr['jobNoNew'] = $obj->jobNoNew;
            $dr['plannedSurveyDate'] = $obj->plannedSurveyDate;
            $dr['surveyTimeHours'] = $obj->surveyTimeHours;
            $dr['surveyType'] = $obj->surveyType;
            $dr['vehCode'] = $obj->vehCode;
            $dr['vehicle'] = $obj->vehicle;
            $dr['surveyLocation'] = $obj->surveyLocationCn ? $obj->surveyLocationCn : $obj->surveyLocation;
            $dr['routeItems'] = $obj->routeItems;
            $dr['estimatedManHour'] = $obj->estimatedManHour;
            $dr['bookLong'] = $obj->bookLong;
            $dr['bookLat'] = $obj->bookLat;
            $dr['map_address'] = $obj->map_address;
            $dr['diy_name'] = $obj->diy_name;
            $dr['diy_value'] = $obj->diy_value;
            $dr['startTime_1'] = $obj->startTime_1;
            $dr['endTime_1'] = $obj->endTime_1;
            $dr['isopen'] = $obj->isopen;
            $dr['checkIn'] = $obj->checkIn;
            $dr['class_record_id'] = $obj->class_record_id;
            $dr['realClass'] = $obj->realClass;
            $dr['img_url'] = $obj->img_url;
            $dr['is_image'] = $obj->is_image;
            $dr['surveyor_pdf'] = $obj->surveyor_pdf;
            $jsonArr[] = $dr;
        }


        foreach ($jsonArr as $k => $v) {
            $sql = "SELECT userId,modifyUserId FROM Survey_SurveyPart WHERE survId = '{$surveyor_id}' and refNo = '{$v['jobNoNew']}' and delFlag = 'no'";
            $db->query($sql);
            $isCheckIn = 'no';
            if ($rs = $db->next_record()) {
                $isCheckIn = 'yes';
            }
            $jsonArr[$k]['isCheckIn'] = $isCheckIn;
            foreach ($v as $kk => $vv) {
                if (is_string($vv)) {
                    if ($encode = mb_detect_encoding($vv, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'))) {
                        $jsonArr[$k][$kk] = mb_convert_encoding($vv, 'UTF-8', $encode);
                    }
                }
            }
        }


        //数组排序
        $date = date('Y-m-d');
        $arr = array();//最終的
        $oneArr = array();//未超时
        $twoArr = array();//已超时
//        $threeArr = array();//未点名
//        $fourArr = array();//已点名

        foreach ($jsonArr as $k => $v) {
            if (strtotime($v['plannedSurveyDate']) > strtotime($date)) {
                $v['timestamp'] = strtotime($v['plannedSurveyDate']);
                $oneArr[] = $v;
            } else {
                $v['timestamp'] = strtotime($v['plannedSurveyDate']);
                $twoArr[] = $v;
            }
        }




        if (!empty($oneArr)) {
            $oneArr = bubbleSort($oneArr);
        }

        if (!empty($twoArr)) {
            foreach ($twoArr as $k => $v) {
                if ($v['plannedSurveyDate'] == '0000-00-00') {
                    $arr[] = $v;
                    unset($twoArr[$k]);
                }
            }
            //删除完要重现整理下标
            $twoArr=array_values($twoArr);
            $twoArr = quickSort($twoArr);

        }

        if(!empty($twoArr)){
            $rs = array_merge_recursive($arr, $oneArr, $twoArr);
        }else{
            $rs = array_merge_recursive($arr, $oneArr);
        }



        //分页
        $paging = !empty($data['paging']) ? $data['paging'] : 1;//第几页
        //需要分页
        $num = 20;
        $length = ceil(count($rs) / $num);//有多少分页
        //搜索的不要分页
        if ($term !== '0' && empty($term) && isset($data['paging'])) {
            //限制最多多少分页
            if ($paging > $length) {
                $paging = $length;
                $num = count($rs) - ($length - 1) * 20;
            }
            $res = array_slice($rs, 20 * ($paging - 1), $num);




            $message = array(
                'status' => 'success',
                'msg' => '',
                'maxPaging' => $length,
                'data' => $res
            );

        } else {
            $message = array(
                'status' => 'success',
                'msg' => '',
                'maxPaging' => $length,
                'data' => $rs
            );
        }

        echo json_encode($message);
        break;
    case 'saveJobs':
        $filename = '../data/survey/' . $data['refNo'] . '_' . date("YmdHis") . rand(1000, 9999) . '.txt';
        $saveContent = var_export($_SERVER, true);
        $saveContent .= "\r\n" . $rawJson;
        file_put_contents($filename, $saveContent);
        $sp = new SurveyPart($db);
        if (empty($data['refNo'])) {
            $message = array(
                'status' => 'failed',
                'msg' => 'ref no. is not allow null.'
            );
            die(json_encode($message));
        }
        $sp->refNo = $data['refNo'];
        $sp->weatherId = $data['weatherId'];
        $sp->surDate = $data['surDate'];
        $sp->surFromTime = $data['surFromTime'];
        $sp->surToTime = $data['surToTime'];
        $sp->surId = 0;
        $sp->location = addslashes($data['location']);
        $sp->bounds = addslashes($data['bounds']);
        $sp->survId = $data['survId'];
        $sp->userId = 0;
        $sp->channel = empty($data['channel']) ? 2 : $data['channel'];
        $sp->userName = empty($data['survId']) ? 'unknown' : $data['survId'];
        $sp->inputTime = date('Y-m-d H:i:s');
        $sp->remarks = addslashes($data['remarks']);
        $supaId = $sp->Save();
        // Survey Detail
        $sd = new SurveyDetail($db);
        $sd->supaId = $supaId;
        $sd->userName = $sp->userName;
        if (!is_array($data['detailList'])) {
            $message = array(
                'status' => 'failed',
                'msg' => 'survey is not allow null.'
            );
            die(json_encode($message));
        }
        foreach ($data['detailList'] as $v) {
            $sd->displayBoard = '';
            $sd->skippedStop = $v['skippedStop'];
            $sd->fleetNo = $v['fleetNo'];
            $sd->pslNo = $v['pslNo'];
            $sd->arrivalTime = $v['arrivalTime'];
            $sd->departureTime = $v['departureTime'];
            $sd->onArrival = $v['onArrival'];
            $sd->setDown = $v['setDown'];
            $sd->pickup = $v['pickup'];
            $sd->onDept = $v['onDept'];
            $sd->leftBehind = $v['leftBehind'];
            $sd->routeItem = $v['routeItem'];
            $sd->remarks = $v['remarks'];
            $sd->leftRoleFlag = 'yes';
            $sd->Save();
        }

        $message = array(
            'status' => 'success',
            'msg' => '保存成功'
        );
        die(json_encode($message));
        break;

    //新版,根据postId
    case 'getMessagesNew':
        if (!array_key_exists('msgId', $data)) {
            $message = array(
                'status' => 'failed',
                'msg' => 'msgId is required.',
                'data' => array()
            );
            die(json_encode($message));
        }
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
        if (!$survId) {

            $message = array(
                'status' => 'failed',
                'msg' => 'Sign Not Found',
                'data' => array()
            );
            die(json_encode($message));
        }
        $s = new Surveyor();

        $s->survId = $survId;
        $sa = new SurveyorAccess($db);
        $rs = $sa->GetListSearch($s);
        $userInfo = $rs[0];//获取通知的人的信息
        $m = new MessagesNew();
        $ma = new MessagesNewAccess($db);
        $jsonArr = array();
        if ($userInfo->survType == 'admin' || $userInfo->survType == 'teach') {
            //管理员与教练获取到的通知

            $messageModel = new MessagesNew();
            $messageAccess = new MessagesNewAccess($db);
            $messageModel->msgId = $data['msgId'];


            //查詢是否有新增付款憑證
            $sql = "SELECT * FROM Survey_MessagesNew " .
                " WHERE 1=1 ";
            if ($data['msgId'] > 0) {
                $query = "AND msgId > " . $data['msgId'] . " AND type = 3 order by msgId desc limit 0,1";
            } else {
                $query = "AND type = 3 order by msgId desc limit 0,1";
            }

            $sql = $sql . $query;
            $db->query($sql);

            if ($rs = $db->next_record()) {
                $dr['msgId'] = $rs['msgId'];
                $dr['title'] = $rs['title'];
                $dr['content'] = $rs['content'];
                $dr['create_time'] = $rs['create_time'];
                $dr['type'] = $rs['type'];
                $jsonArr[] = $dr;
            }

            $message = array(
                'status' => 'success',
                'msg' => '',
                'data' => $jsonArr
            );


        } else {
            //学员获取到的通知
            //查詢是否有修改課堂通知
            $sql = "SELECT * FROM Survey_MessagesNew " .
                " WHERE 1=1 ";
            if ($data['msgId'] > 0) {
                $query = "AND msgId > " . $data['msgId'] . " AND type = 2 order by msgId desc limit 0,1";
            } else {
                $query = "AND type = 2 order by msgId desc limit 0,1";
            }

            $sql = $sql . $query;
            $db->query($sql);
            if ($rs = $db->next_record()) {
                $dr['msgId'] = $rs['msgId'];
                $dr['title'] = $rs['title'];
                $dr['content'] = $rs['content'];
                $dr['create_time'] = $rs['create_time'];
                $dr['type'] = $rs['type'];
                $jsonArr[] = $dr;
            }

            //查詢是否有開放課堂通知
            $sql = "SELECT * FROM Survey_MessagesNew " .
                " WHERE 1=1 ";
            if ($data['msgId'] > 0) {
                $query = "AND msgId > " . $data['msgId'] . " AND type = 1 order by msgId desc limit 0,1";
            } else {
                $query = "AND type = 1 order by msgId desc limit 0,1";
            }

            $sql = $sql . $query;
            $db->query($sql);

            if ($rs = $db->next_record()) {
                $dr['msgId'] = $rs['msgId'];
                $dr['title'] = $rs['title'];
                $dr['content'] = $rs['content'];
                $dr['create_time'] = $rs['create_time'];
                $dr['type'] = $rs['type'];
                $jsonArr[] = $dr;
            }

            $message = array(
                'status' => 'success',
                'msg' => '',
                'data' => $jsonArr
            );

        }
        usort($message['data'], "cmp");
        die(json_encode($message));


    //旧版
    case 'getMessages':

        if (empty($data['sign'])) {
            $message = array(
                'status' => 'failed',
                'msg' => 'sign is null.',
                'data' => array()
            );
            die(json_encode($message));
        }
        $filename = $conf["path"]["sign"] . $data['sign'];
        $m->survId = file_get_contents($filename);
        $s = new Surveyor();
        $s->survId = $m->survId;
        $sa = new SurveyorAccess($db);
        $rs = $sa->GetListSearch($s);
        $userInfo = $rs[0];

        if (empty($userInfo)) {
            $message = array(
                'status' => 'failed',
                'msg' => 'Sign Not Found',
                'data' => array()
            );
            die(json_encode($message));
        }

        /*
         * 检查是否有PDF
         * */
        $inputTime = date("Y-m-d H:i:s", (time() - 3600));
        $plannedSurveyDate = date("Y-m-d");
        /*if($userInfo->survType == 'admin' || $userInfo->survType == 'teach'){
            $sql1 = "SELECT COUNT(*) AS total,id as pdfid FROM Survey_SurveyorClassPDF sscp
		WHERE is_set_class=0 and sscp.is_del = 0";

            $db->query($sql1);
            if($result = $db->next_record()){

                if($result['total'] > 0) {
                    //判断1小时内是否已经提示过
                    $sql = "SELECT COUNT(*) AS total FROM Survey_Messages
					WHERE msgType='pdf' AND survId='{$m->survId}' AND inputTime>'{$inputTime}'";

                    $db->query($sql);
                    if($result = $db->next_record()){
                        if($result['total'] <= 0){//没有提示过
                            $newMessages = new Messages();
                            $newMessages->survId = $m->survId;
                            $newMessages->msgType = 'pdf';
                            $newMessages->title = "新消息通知";
                            $newMessages->content = "有會員上傳了新的付款憑證，請及時查看處理";
                            $newMessages->inputTime = date('Y-m-d H:i:s');
                            $ma->Add($newMessages);
                        }
                    }
                }
            }
        }*/

        /*
         * 检查是否有新工作
         * */
        //检测1小时内是否有新发布的工作还没有被抢
        //$inputTime = date("Y-m-d H:i:s",(time()-3660));

        $sql = "SELECT COUNT(*) AS total FROM Survey_MainScheduleOpen mso
		INNER JOIN Survey_MainSchedule m ON m.jobNoNew = mso.jobNoNew
		WHERE mso.delFlag = 'no' AND mso.applySurvId=0
		AND mso.inputTime>'{$inputTime}' AND m.plannedSurveyDate>='{$plannedSurveyDate}'";
        $db->query($sql);
        if ($result = $db->next_record()) {
            //有新工作开放
            if ($result['total'] > 0) {
                //判断1小时内是否已经提示过
                $sql = "SELECT COUNT(*) AS total FROM Survey_Messages
					WHERE msgType='open' AND survId='{$m->survId}' AND inputTime>'{$inputTime}'";
                $db->query($sql);
                //echo $sql;exit();
                if ($result = $db->next_record()) {
                    if ($result['total'] <= 0) {//没有提示过
                        $newMessages = new Messages();
                        $newMessages->survId = $m->survId;
                        $newMessages->msgType = 'open';
                        $newMessages->title = "Some new course are opened!";
                        $newMessages->content = "開放了一些新課程！";
                        $newMessages->inputTime = date('Y-m-d H:i:s');
                        $ma->Add($newMessages);
                    }
                }
            }
        }
        $m->msgType = '';
        $m->order = 'ORDER BY msgId DESC';
        $m->pageLimit = 'LIMIT 20';
        $rs = $ma->GetListSearch($m);
        $jsonArr = array();
        foreach ($rs as $obj) {
            $dr = array();
            $dr['msgId'] = $obj->msgId;
            $dr['title'] = $obj->title;
            $dr['content'] = $obj->content;
            $dr['inputTime'] = $obj->inputTime;
            $dr['isRead'] = $obj->isRead;
            $dr['msgType'] = $obj->msgType;
            $jsonArr[] = $dr;
        }
        $message = array(
            'status' => 'success',
            'msg' => '',
            'data' => $jsonArr
        );
        die(json_encode($message));
        break;
    case 'markMessages':
        maskMessage($data);
        break;
    case 'getRegistration':
        getRegistration($data);
        break;
    case 'changePassword':
        changePassword($data);
        break;
    case 'setProfilePhoto':
        setProfilePhoto($data);
        break;
    case 'getInfo':
        getInfo($data);
        break;
    case 'getAllInfo':
        getAllInfo($data);
        break;
    case 'addInfo':
        addInfo($data);
        break;
    case 'getPassword':
        getPassword($data);
        break;
    case 'resetPassword':
        resetPassword($data);
        break;
    case 'getClassInfo':
        getClassInfo($data);
        break;
    case 'tmp_add_class':
        tmp_add_class($data);
        break;
    case 'edit_vip_level':
        edit_vip_level($data);
        break;
    case 'getPDFbyDate':
        getPDFbyDate($data);
    case 'confirmPDFList':
        confirmPDFList($data);
    case 'confirmPDF':
        confirmPDF($data);
    case 'cancelConfirmPDF':
        cancelConfirmPDF($data);
    case 'PDFRecord':
        PDFRecord($data);
    case 'getRecordById':
        getRecordById($data);
    default:
        echo "Params Error";
        break;
}

function cmp($a, $b) {
    return ($a['msgId'] < $b['msgId']) ? -1 : 1;
}

/**获取付款记录PDF
 * @param $data
 */
function getRecordById($data) {
    global $db, $conf;
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

    $class_record_id = getArrNoNull($data, 'class_record_id');


    $sql = "SELECT ssc.id as id,ssc.surveyor_id,ssc.jobNoNew,ssc.use_class,ssc.class_remain,ssc.remark,ssc.record_surveyor_id,ssc.record_time,ssc.is_del,ssc.status,ssc.confirm_pdf_create_time,ssc.record_time,
sm.plannedSurveyDate,sm.surveyType,sm.surveyorCode,sm.startTime_1,sm.jobNo,sm.endTime_1,sscp.id as pdfid,sscp.path as surveyor_pdf,sscp.upload_pdf_time as surveyor_pdf_create_time,sscp.is_set_class,
sscp2.path as confirm_pdf,ssc.confirm_pdf as confirm_pdfid, ss.chiName as confirm_chiName, ss.engName as confirm_engName
FROM Survey_SurveyorClassRecord as ssc 
left Join Survey_MainSchedule as sm on sm.jobNoNew=ssc.jobNoNew
left Join Survey_Surveyor as ss on ss.survId=ssc.confirm_pdf_create_by
left Join Survey_SurveyorClassPDF as sscp2 on sscp2.id=ssc.confirm_pdf
left Join (select * from Survey_SurveyorClassPDF where id in (select max(id) from Survey_SurveyorClassPDF group by class_record_id)) as sscp on sscp.class_record_id=ssc.id 
WHERE ";
    $sql .= "ssc.id = '{$class_record_id}' and ssc.is_del = 0 order by ssc.record_time desc";

//    echo $sql;exit;

    $db->query($sql);
    $rows = array();
    if ($rs = $db->next_record()) {
        $rows = array();
        $rows['class_record_id'] = $rs['id'];
        $rows['surveyor_id'] = $rs['surveyor_id'];
        $rows['jobNoNew'] = $rs['jobNoNew'];
        $rows['surveyor_pdf'] = $rs['surveyor_pdf'];
        $rows['surveyor_pdf_create_time'] = $rs['surveyor_pdf_create_time'];
        $rows['confirm_pdf'] = $rs['confirm_pdf'];
        $rows['confirm_pdf_create_time'] = $rs['confirm_pdf_create_time'];
        $rows['confirm_chiName'] = $rs['confirm_chiName'];
        $rows['confirm_engName'] = $rs['confirm_engName'];
        $rows['use_class'] = $rs['use_class'];
        $rows['class_remain'] = $rs['class_remain'];
        $rows['remark'] = $rs['remark'];
        $rows['plannedSurveyDate'] = $rs['plannedSurveyDate'];
        $rows['startTime_1'] = $rs['startTime_1'];
        $rows['endTime_1'] = $rs['endTime_1'];
        $rows['status'] = $rs['status'];
        $rows['jobNo'] = $rs['jobNo'];
        $rows['surveyType'] = $rs['surveyType'];
        $rows['record_time'] = $rs['record_time'];
        $rows['is_own'] = 0;
        $rows['pdfid'] = $rs['pdfid'];
        $rows['confirm_pdfid'] = $rs['confirm_pdfid'];

        if ($rs['surveyorCode'] == $rs['surveyor_id']) {
            $rows['is_own'] = 1;
        }
    }
    if (empty($rows)) {
        $rows = '';
    }
    returnJson('success', $rows, '');
}

function cancelConfirmPDF($data) {
    global $db, $conf;

    $class_record_id = getArrNoNull($data, 'class_record_id');
    $record = getJobNoNewByClassRecord($class_record_id);
    $pdfid = $record['confirm_pdf'];
    if (!$record) {
        returnJson('failed', '', '未找到對應課堂記錄');
    }
    if (empty($pdfid)) {
        returnJson('failed', '', '未找到確認PDF,不能取消');
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
    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];

    if ($info->survType == 'admin' || $info->survType == 'teach') {
        $nowTime = date('Y-m-d H:i:s');
        //更新课堂记录的确认PDF
        $sql1 = "UPDATE Survey_SurveyorClassRecord SET confirm_pdf = '',
cancel_confirm_pdf_by = '{$info->survId}',confirm_pdf_create_time='{$nowTime}'
 where id='{$class_record_id}' and is_del = 0";
        $updateRes1 = $db->query($sql1);

        //更新PDF的剩余课堂数
        $sql2 = "UPDATE Survey_SurveyorClassPDF SET class_remain = class_remain+1
 where id='{$pdfid}' and is_del = 0";
        $updateRes2 = $db->query($sql2);

        returnJson('success', '', '取消確認成功');

    } else {
        returnJson('failed', '', '權限不足');
    }

}

function PDFRecord($data) {
    global $db;
    $pdfid = getArrNoNull($data, 'pdfid');

    $recordSql = "SELECT sscr.*,sm.surveyType,sm.plannedSurveyDate FROM Survey_SurveyorClassRecord as sscr 
LEFT JOIN Survey_MainSchedule as sm ON sm.jobNoNew = sscr.jobNoNew
where confirm_pdf = '{$pdfid}' and is_del = 0";
    $db->query($recordSql);

    $res = array();
    while ($row = $db->next_record()) {

        $tmp['plannedSurveyDate'] = $row['plannedSurveyDate'];
        $tmp['class_record_id'] = $row['id'];
        $tmp['surveyType'] = $row['surveyType'];
        $tmp['surveyor_id'] = $row['surveyor_id'];
        $tmp['surveyor_id'] = $row['surveyor_id'];
        $tmp['jobNoNew'] = $row['jobNoNew'];
        $tmp['confirm_pdf_create_by'] = $row['confirm_pdf_create_by'];
        $tmp['confirm_pdf_create_time'] = $row['confirm_pdf_create_time'];
        $tmp['use_class'] = $row['use_class'];
        $tmp['class_remain'] = $row['class_remain'];
        $tmp['remark'] = $row['remark'];
        $tmp['record_surveyor_id'] = $row['record_surveyor_id'];
        $tmp['record_time'] = $row['record_time'];
        $tmp['status'] = $row['status'];
        if ($row['status'] == 1) {
            $res[] = $tmp;
        }
    }


    $pdfInfoSql = "SELECT * FROM Survey_SurveyorClassPDF 
where id = '{$pdfid}' and is_del = 0";
    $db->query($pdfInfoSql);
    $res2 = array();
    if ($row = $db->next_record()) {
        $res2['class_num'] = $row['class_num'];
        $res2['class_remain'] = $row['class_remain'];
        $res2['upload_surveyor_id'] = $row['upload_surveyor_id'];
        $res2['path'] = $row['path'];
        $res2['set_class_by'] = $row['set_class_by'];
        $res2['set_class_time'] = $row['set_class_time'];
    }

    returnJson('success', $res, '', $res2);
}

function confirmPDFList($data) {
    global $db, $conf;
    $surveyor_id = getArrNoNull($data, 'surveyor_id');
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
    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];

    if ($info->survType == 'admin' || $info->survType == 'teach') {

        $listSql = "SELECT sscp.id,sscp.class_record_id,sscp.jobNoNew,sscp.upload_surveyor_id,sscp.path,ss1.chiName as upload_surveyor_chiName,ss1.engName as upload_surveyor_engName,
ss2.chiName as set_class_chiName,ss2.engName as set_class_engName,
ss3.chiName as chiName,ss3.engName as engName,ss3.survId as surveyor_id,
sscp.set_class_by,sscp.set_class_time,sscp.class_num,sscp.class_remain,sscp.upload_pdf_time FROM Survey_SurveyorClassPDF as sscp
left join Survey_Surveyor as ss1 on  ss1.survId = sscp.upload_surveyor_id
left join Survey_Surveyor as ss2 on  ss2.survId = sscp.set_class_by
left join Survey_Surveyor as ss3 on  ss3.survId = sscp.surveyor_id
WHERE is_del = 0 and is_set_class = 1 and sscp.class_remain > 0 and surveyor_id='{$surveyor_id}' ORDER BY sscp.upload_pdf_time desc";


        $db->query($listSql);
        $res = array();
        while ($row = $db->next_record()) {
            $tmp = array();
            $tmp['class_record_id'] = $row['class_record_id'];
            $tmp['jobNoNew'] = $row['jobNoNew'];
            $tmp['upload_surveyor_id'] = $row['upload_surveyor_id'];
            $tmp['path'] = $row['path'];
            $tmp['chiName'] = $row['chiName'];
            $tmp['engName'] = $row['engName'];
            $tmp['surveyor_id'] = $row['surveyor_id'];
            $tmp['upload_surveyor_chiName'] = $row['upload_surveyor_chiName'];
            $tmp['upload_surveyor_engName'] = $row['upload_surveyor_engName'];
            $tmp['set_class_chiName'] = $row['set_class_chiName'];
            $tmp['set_class_engName'] = $row['set_class_engName'];
            $tmp['set_class_by'] = $row['set_class_by'];
            $tmp['set_class_time'] = $row['set_class_time'];
            $tmp['class_num'] = $row['class_num'];
            $tmp['class_remain'] = $row['class_remain'];
            $tmp['upload_pdf_time'] = $row['upload_pdf_time'];
            $tmp['pdfid'] = $row['id'];

            $res[] = $tmp;
        }

        returnJson('success', $res, '');

    } else {
        returnJson('failed', '', 'Permission Error');
    }

}

/**
 * @param $data
 */
function confirmPDF($data) {
    global $db, $conf;
    $pdfid = getArrNoNull($data, 'pdfid');

    $class_record_id = getArrNoNull($data, 'class_record_id');
    $hadRecord = getJobNoNewByClassRecord($class_record_id);
    if (!$hadRecord) {
        returnJson('failed', '', '未找到對應課堂記錄');
    }
    if (!empty($hadRecord['confirm_pdf'])) {
        returnJson('failed', '', '該記錄已確認，不能重複確認');
    }
    $pdfInfo = getpdf($pdfid);
    if ($pdfInfo === false) {
        returnJson('failed', '', '未找到對應PDF');
    }
    if ($pdfInfo['is_set_class'] == 0) {
        returnJson('failed', '', '該PDF尚未設置課堂數，不可確認');
    }
    if ($pdfInfo['class_remain'] <= 0) {
        returnJson('failed', '', '該PDF剩餘課堂數不足，不可確認');
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
    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];

    if ($info->survType == 'admin' || $info->survType == 'teach') {
        $nowTime = date('Y-m-d H:i:s');
        //更新课堂记录的确认PDF
        $sql1 = "UPDATE Survey_SurveyorClassRecord SET confirm_pdf = '{$pdfid}',
confirm_pdf_create_by = '{$info->survId}',confirm_pdf_create_time='{$nowTime}'
 where id='{$class_record_id}' and is_del = 0";
        $updateRes1 = $db->query($sql1);

        //更新PDF的剩余课堂数
        $sql2 = "UPDATE Survey_SurveyorClassPDF SET class_remain = class_remain-1
 where id='{$pdfid}' and is_del = 0";
        $updateRes2 = $db->query($sql2);

        returnJson('success', '', '確認成功');

    } else {
        returnJson('failed', '', '權限不足');
    }
}

/**获取会员付款记录
 * @param $data
 */
function getPDFbyDate($data) {
    global $db, $conf;
    $startDate = getArrNoNull($data, 'startDate');
    $endDate = getArrNoNull($data, 'endDate');
    $surveyor_id = getArrNoNull($data, 'surveyor_id');
    $is_set_class = isset($data['is_set_class']) ? $data['is_set_class'] : false;

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
    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];

    if ($info->survType == 'admin' || $info->survType == 'teach') {

        $sql = "SELECT ssp.*,ss1.chiName,ss1.engName,ss2.engName as upload_surveyor_engName,ss2.chiName as upload_surveyor_chiName ,ss3.is_image
FROM Survey_SurveyorClassPDF as ssp 
left join Survey_Surveyor as ss1 on ss1.survId = ssp.surveyor_id 
left join Survey_Surveyor as ss2 on ss2.survId = ssp.upload_surveyor_id
left join Survey_MainSchedule as ss3 on  ss3.jobNoNew= ssp.jobNoNew
WHERE ssp.jobNoNew != '0' and upload_pdf_time >= '$startDate' and upload_pdf_time <= '$endDate' and is_del = 0 ";
        if ($surveyor_id != 0) {
            $sql .= " AND ssp.surveyor_id = '{$surveyor_id}' ";
        }

        if ($is_set_class || $is_set_class === '0') {
            $sql .= " AND ssp.is_set_class = '{$is_set_class}' ";
        }





        $sql .= 'ORDER BY ssp.upload_pdf_time desc';

        $db->query($sql);
        $res = array();
        while ($row = $db->next_record()) {
            $tmp = array();
            $tmp['chiName'] = $row['chiName'];
            $tmp['engName'] = $row['engName'];
            $tmp['upload_surveyor_chiName'] = $row['upload_surveyor_chiName'];
            $tmp['upload_surveyor_engName'] = $row['upload_surveyor_engName'];

            $tmp['class_record_id'] = $row['class_record_id'];
            $tmp['jobNoNew'] = $row['jobNoNew'];
            $tmp['surveyor_id'] = $row['surveyor_id'];
            $tmp['upload_surveyor_id'] = $row['upload_surveyor_id'];
            $tmp['path'] = $row['path'];
            $tmp['is_set_class'] = $row['is_set_class'];
            $tmp['set_class_time'] = $row['set_class_time'];
            $tmp['class_num'] = $row['class_num'];
            $tmp['upload_pdf_time'] = $row['upload_pdf_time'];
            $tmp['class_remain'] = $row['class_remain'];
            $tmp['pdfid'] = $row['id'];
            $tmp['is_image'] = isset($row['is_image'])?$row['is_image']:"";


            $res[] = $tmp;
        }

        returnJson('success', '', $res);
    } else {
        $sql = "SELECT ssp.*,ss1.chiName,ss1.engName,ss2.engName as upload_surveyor_engName,ss2.chiName as upload_surveyor_chiName,ss3.is_image
FROM Survey_SurveyorClassPDF as ssp 
left join Survey_Surveyor as ss1 on ss1.survId = ssp.surveyor_id 
left join Survey_Surveyor as ss2 on ss2.survId = ssp.upload_surveyor_id
left join Survey_MainSchedule as ss3 on  ss3.jobNoNew= ssp.jobNoNew
WHERE upload_pdf_time >= '$startDate' and upload_pdf_time <= '$endDate' and ssp.surveyor_id = '{$info->survId}' and is_del = 0  ";

        if ($is_set_class || $is_set_class === '0') {
            $sql .= " AND ssp.is_set_class = '{$is_set_class}' ";
        }
        $sql .= " ORDER BY ssp.upload_pdf_time desc";
        $db->query($sql);

        $res = array();
        while ($row = $db->next_record()) {
            $tmp = array();
            $tmp['chiName'] = $row['chiName'];
            $tmp['engName'] = $row['engName'];
            $tmp['upload_surveyor_chiName'] = $row['upload_surveyor_chiName'];
            $tmp['upload_surveyor_engName'] = $row['upload_surveyor_engName'];

            $tmp['class_record_id'] = $row['class_record_id'];
            $tmp['jobNoNew'] = $row['jobNoNew'];
            $tmp['surveyor_id'] = $row['surveyor_id'];
            $tmp['upload_surveyor_id'] = $row['upload_surveyor_id'];
            $tmp['path'] = $row['path'];
            $tmp['is_set_class'] = $row['is_set_class'];
            $tmp['set_class_time'] = $row['set_class_time'];
            $tmp['class_num'] = $row['class_num'];
            $tmp['upload_pdf_time'] = $row['upload_pdf_time'];
            $tmp['class_remain'] = $row['class_remain'];
            $tmp['pdfid'] = $row['id'];
            $tmp['is_image'] = isset($row['is_image'])?$row['is_image']:"";

            $res[] = $tmp;
        }

        returnJson('success', '', $res);
    }
}

/**添加课堂
 * @param $data
 */
function setClassPDF($data) {
    global $db, $conf;
    $class_record_id = getArrNoNull($data, 'class_record_id');
    $surveyor_id = getArrNoNull($data, 'surveyor_id');
    $money = getArrNoNull($data, 'money');
    $payment_type = getArrNoNull($data, 'payment_type');
    $money_time = getArrNoNull($data, 'money_time');
    $class_num = getArrNoNull($data, 'class_num');

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

    if (!$money_time) {
        $message = array(
            'status' => 'error',
            'msg' => 'Param money_time Error',
            'data' => array()
        );
        die(json_encode($message));
    }

    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];

    $s->survId = $surveyor_id;
    $sa = new SurveyorAccess($db);
    $rs2 = $sa->GetListSearch($s);
    $surveyor_info = $rs2[0];


    $admin_id = $info->survId;
    if ($info->survType != 'admin' && $info->survType != 'teach') {
        $message = array(
            'status' => 'failed',
            'msg' => 'Permission denied',
            'data' => array()
        );
        die(json_encode($message));
    }
    $pdfid = getpdfidByClassRecord($class_record_id, $surveyor_id);


    if ($class_record_id == 0) {

        //不根据学员PDF设置课堂
        $jobNoNew = 0;
        $firstTime = false;
        // 添加classPDF===>is_set_class=1
        if (empty($pdfid)) {
            $firstTime = true;
            $nowTime = date('Y-m-d H:i:s');
            $default_path = '/cache/paymentPDF/default/default.pdf';//default PDF

            $sql = "INSERT into Survey_SurveyorClassPDF(surveyor_id,class_record_id,jobNoNew,path,upload_surveyor_id,upload_pdf_time) values ('$surveyor_id','$class_record_id','$jobNoNew','$default_path',$survId,'$nowTime')";
            $res = $db->query($sql);
            $sql2 = "SELECT last_insert_id() ";
            $db->query($sql2);
            if ($lastid = $db->next_record()) {
                $pdfid = $lastid[0];
            }
        }

        // 添加Survey_SurveyorClass
        $payment_type = htmlspecialchars($payment_type);
        $payment_res = 1;

        $class = htmlspecialchars($class_num);
        $nowTime = date('Y-m-d H:i:s');
        $remark = htmlspecialchars($data['remark']);
        $start_date = strtotime($data['start_date']) ? $data['start_date'] : '0000-00-00';
        $end_date = strtotime($data['end_date']) ? $data['end_date'] : '0000-00-00';

        $sql = "INSERT INTO  Survey_SurveyorClass(money,money_time,payment_type,payment_res,admin_id,class,surveyor_id,create_time,remark,start_date,end_date,pdfid)
             VALUES('{$money}','{$money_time}','{$payment_type}','{$payment_res}','{$admin_id}','{$class}','{$surveyor_id}','{$nowTime}','{$remark}','{$start_date}','{$end_date}','{$pdfid}')";
        $db->query($sql);
        $res = $db->last_insert_id();
        if ($res) {
            $sql = "UPDATE  Survey_Surveyor SET updateTime = date('Y-m-d H:i:s'),class_sum = class_sum+$class,class_remain=class_remain+$class WHERE survId=$surveyor_id";
            $updateRes = $db->query($sql);

            $sql_tmp = "SELECT `class_remain` FROM Survey_Surveyor WHERE `survId`=" . "'" . $surveyor_id . "'";
            $db->query($sql_tmp);
            $info = $db->next_record();

            $recordRemark = $class_num < 0 ? '管理員减少課堂' : '管理員添加課堂';
            // 添加Survey_SurveyorClassRecord
            addClassRecord($surveyor_id, $jobNoNew, $class, $info['class_remain'], $recordRemark, $admin_id, 2, $pdfid, $info->survId, date('Y-m-d H:i:s'));
            if ($firstTime == false) {
                updateClassPDF($pdfid, $admin_id, $class_num, $class_num);
            }
            returnJson('success', array(), '');
        } else {
            returnJson('failed', array(), '設置失敗，請稍後再試');
        }
    } else {

        //根据学员PDF设置课堂
        if (empty($pdfid)) {
            $message = array(
                'status' => 'failed',
                'msg' => 'PDF Not Found',
                'data' => ''
            );
            die(json_encode($message));
        }
        $payment_type = htmlspecialchars($payment_type);
        $payment_res = 1;

        $class = htmlspecialchars($class_num);
        $nowTime = date('Y-m-d H:i:s');
        $remark = htmlspecialchars($data['remark']);
        $start_date = strtotime($data['start_date']) ? $data['start_date'] : '0000-00-00';
        $end_date = strtotime($data['end_date']) ? $data['end_date'] : '0000-00-00';

        $sql = "INSERT INTO  Survey_SurveyorClass(money,money_time,payment_type,payment_res,admin_id,class,surveyor_id,create_time,remark,start_date,end_date,pdfid)
             VALUES('{$money}','{$money_time}','{$payment_type}','{$payment_res}','{$admin_id}','{$class}','{$surveyor_id}','{$nowTime}','{$remark}','{$start_date}','{$end_date}','{$pdfid}')";
        $db->query($sql);
        $res = $db->last_insert_id();

        if ($res) {

            $sql = "UPDATE  Survey_Surveyor SET updateTime = date('Y-m-d H:i:s'),class_sum = class_sum+$class,class_remain=class_remain+$class WHERE survId=$surveyor_id";
            $updateRes = $db->query($sql);

            $classRecordInfo = getJobNoNewByClassRecord($class_record_id);
            $jobNoNew = $classRecordInfo['jobNoNew'];

            $recordRemark = $class_num < 0 ? '管理員减少課堂' : '管理員添加課堂';

            $class_remain = $surveyor_info->class_remain + $class;
            addClassRecord($surveyor_id, $jobNoNew, $class, $class_remain, $recordRemark, $admin_id, 2, $pdfid, $info->survId, date('Y-m-d H:i:s'));
            updateClassPDF($pdfid, $admin_id, $class_num, $class_num);


            if ($updateRes) {
                $message = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => array()
                );
                die(json_encode($message));
            }

        } else {
            $message = array(
                'status' => 'error',
                'msg' => 'Unknow Error',
                'data' => array()
            );
            die(json_encode($message));
        }
    }
}


function getpdf($pdfid, $class_record_id = null) {
    global $db;

    $sql = "SELECT id,class_record_id,jobNoNew,surveyor_id,upload_surveyor_id,path,is_set_class,set_class_by,set_class_time,class_num,class_remain,upload_pdf_time FROM Survey_SurveyorClassPDF where id = $pdfid  and is_del = 0";
    if ($class_record_id) {
        $sql .= " AND class_record_id = '{$class_record_id}'";
    }
    $db->query($sql);
    if ($pdf = $db->next_record()) {
        return $pdf;
    }
    return false;

}


function getpdfidByClassRecord($class_record_id, $surveyor_id = 0) {
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

function getJobNoNewByClassRecord($class_record_id) {
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

function updateClassPDF($pdfid, $set_class_by, $class_num, $class_remain) {
    global $db;

    $now_time = date('Y-m-d H:i:s');
    $sql = "UPDATE Survey_SurveyorClassPDF set is_set_class = 1,set_class_time = '$now_time',class_num = class_num+'$class_num',class_remain = class_remain+'$class_remain', set_class_by = '$set_class_by'  where id = '$pdfid'";
    return $db->query($sql);
}

function addClassRecord($surveyor_id, $jobNoNew, $use_class, $class_remain, $remark, $record_surveyor_id, $status = 1, $confirm_pdf = null, $confirm_pdf_create_by = 0, $confirm_pdf_create_time = null) {
    global $db;

    $record_time = date('Y-m-d H:i:s');

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


function edit_vip_level($data) {
    global $db, $conf;

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

    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $userInfo = $rs[0];
    if (empty($userInfo)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Sign Not Found',
            'data' => array()
        );
        die(json_encode($message));
    }

    if ($userInfo->survType != 'admin' && $userInfo->survType != 'teach') {
        $message = array(
            'status' => 'failed',
            'msg' => 'Permission Error',
            'data' => array()
        );
        die(json_encode($message));
    }

    if (!isset($data['vip_level']) && empty($data['vip_level'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'vip_level is required',
            'data' => array()
        );
        die(json_encode($message));
    }
    if (!isset($data['surveyorId']) && empty($data['surveyorId'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'surveyorId is required',
            'data' => array()
        );
        die(json_encode($message));
    }
    $vip_level = $data['vip_level'];
    $surveyorId = $data['surveyorId'];
    $sql = "UPDATE  Survey_Surveyor SET vip_level = '{$vip_level}' WHERE survId='{$surveyorId}'";

    $updateRes = $db->query($sql);
    if ($updateRes) {
        $message = array(
            'status' => 'success',
            'msg' => '',
            'data' => array()
        );
        die(json_encode($message));
    } else {
        $message = array(
            'status' => 'error',
            'msg' => 'Try again',
            'data' => array()
        );
        die(json_encode($message));
    }
}

function tmp_add_class() {
    global $db;
    $sql = 'SELECT survId FROM Survey_Surveyor';
    $db->query($sql);
    $class_num = array();
    while ($rs = $db->next_record()) {
        $class_num[] = $rs['survId'];
    }
    foreach ($class_num as $k => $v) {
        if ($v) {
            $sql = "INSERT INTO Survey_SurveyorClass "
                . "(surveyor_id,money,money_time,payment_type,payment_res,admin_id,class,update_time,update_by,create_time)"
                . "value({$v},0,'2019-07-23 10:12:00','轉賬',1,1,20,'2019-07-23 10:12:00',1,'2019-07-23 10:12:00')";
            $db->query($sql);
        }
    }
}


/*
 * 獲取學員購買和剩餘的課堂信息
 *
 * */
function getClassInfo($data) {
    global $db, $conf;

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

    if (!isset($data['surveyorId']) || empty($data['surveyorId'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'surveyorId is required',
            'data' => array()
        );
        die(json_encode($message));
    }

    $class_num_sql = "SELECT class_sum,class_remain,vip_level,avatar FROM Survey_Surveyor " . " WHERE 1=1  AND survId = " . $data['surveyorId'];
    $db->query($class_num_sql);
    while ($rs = $db->next_record()) {
        $class_num = $rs['class_sum'];
        $class_remain = $rs['class_remain'];
        $vip_level = $rs['vip_level'];
        $avatar = $rs['avatar'];
    }

    /*$used_class_num_sql = "SELECT count(mascId) as class_num_sql FROM Survey_MainSchedule " . " WHERE 1=1  AND surveyorCode = ".$data['surveyorId'] ." and (actualSurveyDate < '".date('Y-m-d')."' or (actualSurveyDate = '".date('Y-m-d')."' and endTime_1 <= '".date('H:i:s')."')) and realClass = 1";
    $db->query ( $used_class_num_sql );
    while ( $rs = $db->next_record () ) {
        $used_class_num = $class_num - $rs['class_num_sql'];
    }*/

    $payment_log_sql = "SELECT ss.engName,ss.chiName,ssc.id,ssc.money,ssc.money_time,ssc.payment_type,ssc.class,ssc.remark,ssc.end_date,ssc.start_date FROM Survey_SurveyorClass ssc,Survey_Surveyor ss " . " WHERE 1=1  AND ssc.surveyor_id = " . $data['surveyorId'] . " AND ss.survId = ssc.admin_id AND ssc.is_del=0 " . " ORDER BY ssc.create_time desc";
    $db->query($payment_log_sql);
    $payment_log = array();
    while ($rs = $db->next_record()) {
        $payment_log_tmp['operator_engName'] = $rs['engName'];
        $payment_log_tmp['operator_chiName'] = $rs['chiName'];
        $payment_log_tmp['money'] = number_format($rs['money'], 2);
        $payment_log_tmp['money_time'] = $rs['money_time'];
        $payment_log_tmp['payment_type'] = $rs['payment_type'];
        $payment_log_tmp['class_num'] = $rs['class'];
        $payment_log_tmp['id'] = $rs['id'];
        $payment_log_tmp['remark'] = $rs['remark'];
        $payment_log_tmp['start_date'] = $rs['start_date'];
        $payment_log_tmp['end_date'] = $rs['end_date'];
        $payment_log[] = $payment_log_tmp;
    }

    $res = array();
    $res['class_num'] = $class_num;
    $res['used_class_num'] = $class_remain;
    //$res['used_class_num'] = $used_class_num;
    $res['payment_log'] = $payment_log;
    $res['vip_level'] = $vip_level;
    $res['avatar'] = $avatar;

    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $res
    );
    die(json_encode($message));

}

/*
 * 重設學員密碼
 * */
function resetPassword($data) {
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

    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];

    if ($info->survType == 'admin') {
        if (!isset($data['surveyorId']) || empty($data['surveyorId'])) {
            $message = array(
                'status' => 'failed',
                'msg' => 'surveyorId is required',
                'data' => array()
            );
            die(json_encode($message));
        } else {
            $sql = "DELETE FROM Survey_SurveyorPassword " . " WHERE 1=1  AND survId = " . $data['surveyorId'];
            $res = $db->query($sql);
            $message = array(
                'status' => 'success',
                'msg' => '',
                'data' => array()
            );
            die(json_encode($message));
        }
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => 'Permission denied',
            'data' => array()
        );
        die(json_encode($message));
    }

}

/*
 * 刷新会员拥有的课堂总数
 * */
function flushClasSum($surveyor_id) {
    global $db;

    $class_num_sql = "SELECT sum(class) as class_num from Survey_SurveyorClass where is_del = 0 AND surveyor_id=" . $surveyor_id;
    $db->query($class_num_sql);
    $res = $db->next_record();
    $class_num = is_null($res['class_num']) ? 0 : $res['class_num'];
    $sql = "UPDATE  Survey_Surveyor SET updateTime = '" . date('Y-m-d H:i:s') . "', class_sum = $class_num WHERE survId=$surveyor_id";

    $updateRes = $db->query($sql);
    return true;

}

/*
 * 修改會員課堂信息
 * 
 * */
function editClass($data) {
    global $conf, $db;
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
    if (!isset($data['id']) || empty($data['id'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'ID is required',
            'data' => array()
        );
        die(json_encode($message));
    }
    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];

    if ($info->survType == 'admin') {

        $updateSql = '';
        if (!isset($data['surveyor_id']) || empty($data['surveyor_id'])) {
            $message = array(
                'status' => 'failed',
                'msg' => 'Params Error',
                'data' => array()
            );
            die(json_encode($message));
        }

        $ss = new Surveyor();
        $ss->survId = $data['surveyor_id'];
        $rss = $sa->GetListSearch($ss);
        $sinfo = $rss[0];

        $source_class_sql = "SELECT class FROM Survey_SurveyorClass WHERE id='" . $data['id'] . "' and is_del = 0 and surveyor_id = " . $data['surveyor_id'];

        $db->query($source_class_sql);

        while ($resdb = $db->next_record()) {
            $source_class = $resdb['class'];
        }
        if (is_null($source_class) || $source_class < 0) {
            $message = array(
                'status' => 'failed',
                'msg' => 'Params Error',
                'data' => array()
            );
            die(json_encode($message));
        }
        if (isset($data['money'])) {
            $money = $data['money'];
            $updateSql .= " money = '{$money}',";
        }
        if (isset($data['payment_type']) && !empty($data['payment_type'])) {
            $payment_type = $data['payment_type'];
            $updateSql .= " payment_type = '{$payment_type}',";
        }
        if (isset($data['money_time']) && !empty($data['money_time'])) {
            $money_time = $data['money_time'];
            $updateSql .= " money_time = '{$money_time}',";
        }
        if (isset($data['class_num'])) {
            $class_num = $data['class_num'];
            $updateSql .= " class = '{$class_num}',";
        }
        if (isset($data['remark'])) {
            $remark = $data['remark'];
            $updateSql .= " remark = '{$remark}',";
        }
        if (isset($data['remark'])) {
            $remark = $data['remark'];
            $updateSql .= " remark = '{$remark}',";
        }
        if (isset($data['start_date'])) {
            $start_date = strtotime($data['start_date']) ? $data['start_date'] : '0000-00-00';
            $updateSql .= " start_date = '{$start_date}',";
        }
        if (isset($data['end_date'])) {
            $end_date = strtotime($data['end_date']) ? $data['end_date'] : '0000-00-00';
            $updateSql .= " start_date = '{$end_date}',";
        }


        $nowTime = date('Y-m-d H:i:s');
        $updateSql .= " update_time = '{$nowTime}',update_by = '{$info->survId}'";
        $sql = "UPDATE  Survey_SurveyorClass SET ";
        $sql .= $updateSql;
        $sql .= " WHERE id=" . $data['id'];

        $delRes = $db->query($sql);
        if ($delRes >= 1) {
            $sum_update_class = $sinfo->class_sum - $source_class + $class_num;
            $remain_update_class = $sinfo->class_remain - $source_class + $class_num;
            $sql = "UPDATE  Survey_Surveyor SET updateTime = '" . date('Y-m-d H:i:s') . "', class_sum = {$sum_update_class},class_remain = {$remain_update_class} WHERE survId={$data['surveyor_id']}";
            $updateRes = $db->query($sql);
            if ($updateRes) {
                $message = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => array()
                );
                die(json_encode($message));
            }
        } else {
            $message = array(
                'status' => 'failed',
                'msg' => 'Unknow Error',
                'data' => array()
            );
            die(json_encode($message));
        }

    } else {
        $message = array(
            'status' => 'failed',
            'msg' => 'Permission denied',
            'data' => array()
        );
        die(json_encode($message));
    }
}

/*
 * 刪除會員課堂信息
 *
 * */
function delClass($data) {
    global $conf, $db;
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
    if (!isset($data['id']) || empty($data['id'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'ID is required',
            'data' => array()
        );
        die(json_encode($message));
    }

    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];

    if ($info->survType == 'admin') {

        $sql = "SELECT  class ,is_del,surveyor_id From Survey_SurveyorClass WHERE id=" . $data['id'];
        $db->query($sql);

        if ($dr = $db->next_record()) {
            $class_num = $dr['class'];
            $is_del = $dr['is_del'];
            $surveyor_id = $dr['surveyor_id'];
        } else {
            $message = array(
                'status' => 'failed',
                'msg' => 'id No Found',
                'data' => array()
            );
            die(json_encode($message));
        }
        if ($is_del == 0) {
            $nowTime = date('Y-m-d H:i:s');
            $sql = "UPDATE  Survey_SurveyorClass SET is_del = 1,update_time = '{$nowTime}',update_by = $info->survId WHERE id=" . $data['id'];
            $delRes = $db->query($sql);
            if ($delRes >= 1) {

                $sql = "UPDATE  Survey_Surveyor SET updateTime = '" . date('Y-m-d H:i:s') . "',class_sum = class_sum-$class_num,class_remain = class_remain-$class_num WHERE survId=$surveyor_id";
                $db->query($sql);

                $message = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => array()
                );
                die(json_encode($message));
            } else {
                $message = array(
                    'status' => 'failed',
                    'msg' => 'Unknow Error',
                    'data' => array()
                );
                die(json_encode($message));
            }

        } else {
            $message = array(
                'status' => 'failed',
                'msg' => 'Already deleted',
                'data' => array()
            );
            die(json_encode($message));
        }
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => 'Permission denied',
            'data' => array()
        );
        die(json_encode($message));
    }
}

/*
 * 设置会员课堂信息
 *
 * */
function setClass($data) {
    global $conf, $db;
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
    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];

    if ($info->survType == 'admin') {
        if (!isset($data['surveyor_id']) || !isset($data['money']) || !isset($data['payment_type']) || !isset($data['money_time']) || !isset($data['class_num'])) {
            $message = array(
                'status' => 'failed',
                'msg' => 'Params Error',
                'data' => array()
            );
            die(json_encode($message));
        }

        $money = $data['money'];

        $money_time = strtotime($data['money_time']);
        if ($money_time) {
            $money_time = date('Y-m-d H:i:s', $money_time);
        } else {
            $message = array(
                'status' => 'error',
                'msg' => 'Param money_time Error',
                'data' => array()
            );
            die(json_encode($message));
        }
        $payment_type = htmlspecialchars($data['payment_type']);
        $payment_res = 1;
        $admin_id = $info->survId;
        $surveyor_id = $data['surveyor_id'];
        $class = htmlspecialchars($data['class_num']);
        $nowTime = date('Y-m-d H:i:s');
        $remark = htmlspecialchars($data['remark']);
        $start_date = strtotime($data['start_date']) ? $data['start_date'] : '0000-00-00';
        $end_date = strtotime($data['end_date']) ? $data['end_date'] : '0000-00-00';

        $sql = "INSERT INTO  Survey_SurveyorClass(money,money_time,payment_type,payment_res,admin_id,class,surveyor_id,create_time,remark,start_date,end_date)
				 VALUES('{$money}','{$money_time}','{$payment_type}','{$payment_res}','{$admin_id}','{$class}','{$surveyor_id}','{$nowTime}','{$remark}','{$start_date}','{$end_date}')";
        $db->query($sql);
        $res = $db->last_insert_id();
        if ($res) {

            $sql = "UPDATE  Survey_Surveyor SET updateTime = date('Y-m-d H:i:s'),class_sum = class_sum+$class,class_remain=class_remain+$class WHERE survId=$surveyor_id";
            $updateRes = $db->query($sql);
            if ($updateRes) {
                $message = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => array()
                );
                die(json_encode($message));
            }

        } else {
            $message = array(
                'status' => 'error',
                'msg' => 'Unknow Error',
                'data' => array()
            );
            die(json_encode($message));
        }
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => 'Permission denied',
            'data' => array()
        );
        die(json_encode($message));
    }
}

/**
 * 标记为已读/未读
 * @param $data
 */
function maskMessage($data) {
    global $conf, $db;
    $m = new Messages();
    $ma = new MessagesAccess($db);
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $m->survId = file_get_contents($filename);
    if (empty($m->survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $m->msgId = $data['msgId'];
    $m->isRead = 'yes';
    $ma->Mark($m);
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => array()
    );
    die(json_encode($message));
}


/**
 * 根据车牌,车队编号获取载客量
 * @param $data
 */
function getRegistration($data) {
    global $db;
    $reg = new Registration();
    $reg->plateNo = $data['fleetNo'];
    $reg->fleetNo = $data['fleetNo'];
    $rega = new RegistrationAccess($db);
    $rs = $rega->GetListSearch($reg);
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $rs
    );
    die(json_encode($message));
}

function changePassword($data) {
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
    $password = $data['password'];
    $newPassword = $data['newPassword'];
    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    if (!empty($rs[0])) {
        $s = $rs[0];
        $username = $s->contact;
        $login = new SurveyorLogin($db);
        if ($login->Login($username, $password)) {
            $sl = new SurveyorLogin($db);
            $sl->UpdatePassword($survId, $newPassword);
            $message = array(
                'status' => 'success',
                'msg' => '',
                'data' => array()
            );
            die(json_encode($message));
        } else {
            $message = array(
                'status' => 'failed',
                'msg' => 'error 001.',
                'data' => array()
            );
            die(json_encode($message));
        }
    }
    $message = array(
        'status' => 'failed',
        'msg' => 'error 001.',
        'data' => array()
    );
    die(json_encode($message));
}


/**
 * 调用调查员用户的头像
 * @param $data
 */
function setProfilePhoto($data) {
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => ''
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"] . $data['sign'];
    $survId = file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => ''
        );
        die(json_encode($message));
    }
    $path = $conf["path"]["root"] . "/images/profile-photo/" . date("Ymd");
    if (!is_readable($path)) {
        is_file($path) or mkdir($path, 0755);
    }
    if (!is_array($_FILES['picFile']['name'])) {
        $message = array(
            'status' => 'failed',
            'msg' => '沒有檢測到上傳文件.',
            'data' => ''
        );
        die(json_encode($message));
    }
    $sa = new SurveyorAccess($db);
    foreach ($_FILES['picFile']['name'] as $k => $v) {
        $fileName = $path . '/' . date('YmdHis') . '-' . uniqid() . '.' . fileext($v);
        move_uploaded_file($_FILES['picFile']['tmp_name'][$k], $fileName);
        //添加到聊天记录
        $profilePhoto = str_replace($conf["path"]["root"], '', $fileName);
        $sa->setProfilePhoto($survId, $profilePhoto);
        $message = array(
            'status' => 'success',
            'msg' => '成功！',
            'profilePhoto' => 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/' . $profilePhoto,
            'data' => ''
        );
        die(json_encode($message));
        break;
    }
}


function getInfo($data) {
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
    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];
    $rsData['info']['survId'] = $info->survId;
    $rsData['info']['chiName'] = $info->chiName;
    $rsData['info']['engName'] = $info->engName;
    $rsData['info']['contact'] = $info->contact;
    $rsData['info']['survHome'] = $info->survHome;
    $rsData['info']['vip_level'] = $info->vip_level;
    $rsData['info']['avatar'] = $info->avatar;
    $rsData['info']['profilePhoto'] = $info->profilePhoto;
    if (!empty($rsData['info']['profilePhoto'])) {
        $rsData['info']['profilePhoto'] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/' . $rsData['info']['profilePhoto'];
    }
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $rsData
    );
    die(json_encode($message));
}


function checkInfo($data) {
    global $conf, $db;
    if (empty($data['sign'])) {
        $message = array(
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $survId = intval($data['survId']);
    if ($survId <= 0) {
        $message = array(
            'status' => 'failed',
            'msg' => 'surveyor id is error.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];
    $rsData['info']['survId'] = $info->survId;
    $rsData['info']['chiName'] = $info->chiName;
    $rsData['info']['engName'] = $info->engName;
    $rsData['info']['survHome'] = $info->survHome;
    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $rsData
    );
    die(json_encode($message));
}

function getAllInfo($data) {
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
    $survId = @file_get_contents($filename);
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
    $s->status = '';
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];
    $rsData = array();

    $paging = !empty($data['paging']) ? $data['paging'] : 1;//第几页
    $term = isset($data['term']) ? $data['term'] : '';//查询条件
    $s->term = $term;

    if ($info->survType == 'teach' || $info->survType == 'admin') {
        $s->survId = '';
        $result = $sa->GetListSearch($s);
        foreach ($result as $v) {
            $dr['upSurvId'] = $v->upSurvId;
            $dr['ozzoCode'] = $v->ozzoCode;
            $dr['survId'] = $v->survId;
            $dr['chiName'] = $v->chiName;
            $dr['engName'] = $v->engName;
            $dr['contact'] = $v->contact;
            $dr['survHome'] = $v->survHome;
            $dr['dipaCode'] = $v->dipaCode;
            $dr['IsSupervisor'] = $v->IsSupervisor;
            $dr['personalRecord'] = $v->personalRecord;
            $dr['bank'] = $v->bank;
            $dr['accountNo'] = $v->accountNo;
            $dr['VIP'] = $v->VIP;
            $dr['whatsAPP'] = $v->whatsAPP;
            $dr['email'] = $v->email;
            $dr['fax'] = $v->fax;
            $dr['remarks'] = $v->remarks;
            $dr['birthday'] = $v->birthday;
            $dr['company'] = $v->company;
            $dr['status'] = $v->status;
            $dr['survType'] = $v->survType;
            $dr['inputUsername'] = $v->inputUsername;
            $dr['inputTime'] = $v->inputTime;
            $dr['updateUsername'] = $v->updateUsername;
            $dr['updateTime'] = $v->updateTime;
            $dr['selfBefore'] = $v->selfBefore;
            $dr['profilePhoto'] = $v->profilePhoto;
            $dr['vip_level'] = $v->vip_level;
            $dr['avatar'] = $v->avatar;
            $rsData[] = $dr;
        }
        $num = 20;
        $length = ceil(count($rsData) / $num);//有多少分页
        if (isset($data['paging']) && $term !== '0' && empty($term)) {
            //需要分页
            //限制最多多少分页
            if ($paging > $length) {
                $paging = $length;
                $num = count($rsData) - ($length - 1) * 20;
            }
            $returnData = array_slice($rsData, 20 * ($paging - 1), $num);
        } else {
            $length = 1;
            $returnData = $rsData;
        }
        $message = array(
            'status' => 'success',
            'msg' => '',
            'maxPaging' => $length,
            'data' => $returnData
        );
        die(json_encode($message));
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => 'only a teacher can see all the students.',
            'maxPaging' => 1,
            'data' => array()
        );
        die(json_encode($message));
    }
}

function addInfo($data) {
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
    $survId = @file_get_contents($filename);
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
    $rsData = array();
    if ($info->survType == 'admin' || $info->survType == 'teach') {

        $s = new Surveyor();
        $sa = new SurveyorAccess($db);

        $s->survId = addslashes($data['survId']);
        $s->upSurvId = addslashes($data['upSurvId']);
        $s->ozzoCode = addslashes($data['ozzoCode']);
        $s->chiName = addslashes($data['chiName']);
        $s->engName = addslashes($data['engName']);
        $s->contact = addslashes($data['contact']);
        $s->survHome = addslashes($data['survHome']);
        $s->dipaCode = addslashes($data['dipaCode']);
        $s->IsSupervisor = addslashes($data['IsSupervisor']);
        $s->personalRecord = addslashes($data['personalRecord']);
        $s->bank = addslashes($data['bank']);
        $s->accountNo = addslashes($data['accountNo']);
        $s->VIP = addslashes($data['VIP']);
        $s->whatsAPP = addslashes($data['whatsAPP']);
        $s->email = addslashes($data['email']);
        $s->fax = addslashes($data['fax']);
        $s->remarks = addslashes($data['remarks']);
        $s->birthday = addslashes($data['birthday']);
        $s->company = addslashes($data['company']);
        $s->survType = empty($data['survType']) ? 'surveyor' : addslashes($data['survType']);
        $s->status = empty($data['status']) ? 'active' : addslashes($data['status']);
        $s->selfBefore = addslashes($data['selfBefore']);
        $s->lastYearSurveyTimes = addslashes($data['lastYearSurveyTimes']);
        $s->inputUserId = 100000000 + intval($survId);
        $s->inputTime = date('Y-m-d H:i:s');
        $s->updateUserId = '';
        $s->updateTime = date('Y-m-d H:i:s');
        $s->vip_level = $data['vip_level'];
        $s->avatar = isset($data['avatar']) ? addslashes($data['avatar']) : '';

        if (empty($s->survId)) {
            $surveyorCheck = new Surveyor();
            $surveyorCheck->survId = $s->survId;
            $surveyorCheck->contact = $s->contact;
            $surveyId = $sa->IsExist($surveyorCheck);
            if ($surveyId > 0) {
                $message = array(
                    'status' => 'failed',
                    'msg' => 'the student already exists.',
                    'data' => array()
                );
                die(json_encode($message));
            } else {
                $s->survId = $sa->Add($s);
            }
        } else {

            $surs = new Surveyor();
            unset($surs->status);
            $surs->survId = $data['survId'];
            $sursa = new SurveyorAccess($db);
            $rs = $sursa->GetListSearch($surs);
            if ($rs[0]->contact == $data['contact']) {
                $sa->Update($s);
            } else {
                $surveyorCheck = new Surveyor();
                $surveyorCheck->survId = '';
                $surveyorCheck->contact = $s->contact;
                $surveyId = $sa->IsExist($surveyorCheck);
                if ($surveyId) {
                    $message = array(
                        'status' => 'failed',
                        'msg' => '號碼已存在',
                        'data' => ''
                    );
                    die(json_encode($message));
                } else {
                    $sa->Update($s);
                }
            }
        }

        $message = array(
            'status' => 'success',
            'msg' => '',
            'data' => $rsData
        );
        die(json_encode($message));
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => 'Permission denied',
            'data' => array()
        );
        die(json_encode($message));
    }
}

/**修改密码
 * @param $data
 */
function getPassword($data) {
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
    $survId = @file_get_contents($filename);
    if (empty($survId)) {
        $message = array(
            'status' => 'failed',
            'msg' => 'Login has expired.',
            'data' => ['password' => '']
        );
        die(json_encode($message));
    }
    $s = new Surveyor();
    $s->survId = $survId;
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];
    $rsData = array();
    if ($info->survType == 'teach' || $info->survType == 'admin') {

        $s = new Surveyor();
        $sa = new SurveyorAccess($db);
        $s->survId = intval($data['survId']);
        if (!empty($s->survId)) {
            $surveyorCheck = new Surveyor();
            $surveyorCheck->survId = $s->survId;
            if ($sa->IsUpdatedPassword($s->survId)) {
                $message = array(
                    'status' => 'failed',
                    'msg' => 'unable to view modified password.',
                    'data' => ['password' => '']
                );
                die(json_encode($message));
            }

            $rs = $sa->GetListSearch($s);
            if (count($rs) > 0) {
                $sur = $rs[0];
                /*if (($sur->survId) % 2 == 0) {
                    $sur->passWord = $sur->contact + $sur->survId * substr ( $sur->survId, - 1 );
                } else {
                    $sur->passWord = $sur->contact - $sur->survId * substr ( $sur->survId, - 1 );
                }*/
                $firstCheck = substr(substr($sur->contact, 0, 4) * 666, 0, 3);
                $rsData['password'] = $firstCheck;
            }
        } else {
            $message = array(
                'status' => 'failed',
                'msg' => 'survId is not allowed null.',
                'data' => ['password' => '']
            );
            die(json_encode($message));
        }

        $message = array(
            'status' => 'success',
            'msg' => '',
            'data' => $rsData
        );
        die(json_encode($message));
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => 'only teachers can check students password.',
            'data' => ['password' => '']
        );
        die(json_encode($message));
    }
}


function getArrNoNull($arr, $field) {
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


function returnJson($status = 'success', $data = '', $msg = '', $other = '') {

    /* if(!empty($data)){
         if(is_array($data)){
             foreach($data){

             }
         }
     }*/
    if (!empty($other)) {
        $message = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
            'other' => $other
        );
        die(json_encode($message));
    }
    $message = array(
        'status' => $status,
        'msg' => $msg,
        'data' => $data
    );
    die(json_encode($message));
}


//快速排序 时间戳大的在前 小的在后
function quickSort($arr) {
    $length = count($arr);
    if ($length <= 1) {
        return $arr;
    }
    $base_num = $arr[0];
    $left_array = array();  //小于基准的
    $right_array = array();  //大于基准的

    for ($i = 1; $i < $length; $i++) {
        if ($base_num['timestamp'] > $arr[$i]['timestamp']) {
            $left_array[] = $arr[$i];

        } else {
            $right_array[] = $arr[$i];
        }
    }
    $left_array = quickSort($left_array);
    $right_array = quickSort($right_array);
    //合并
    return array_merge($right_array, array($base_num), $left_array);
}

/** 冒泡排序，时间戳小的在前
 * @param $arr
 * @return mixed
 */
function bubbleSort($arr) {
    $len = count($arr);
    //该层循环控制 需要冒泡的轮数
    for ($i = 1; $i < $len; $i++) { //该层循环用来控制每轮 冒出一个数 需要比较的次数
        for ($k = 0; $k < $len - $i; $k++) {
//            echo json_encode($arr[$k]);exit;
            if (strtotime($arr[$k]['plannedSurveyDate']) > strtotime($arr[$k + 1]['plannedSurveyDate'])) {
                $tmp = $arr[$k + 1];
                $arr[$k + 1] = $arr[$k];
                $arr[$k] = $tmp;
            }
        }
    }
    return $arr;
}
