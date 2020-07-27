<?php
/**
 * about main schedule's me
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2012-12-14
 */
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
$ja = new JobsAccess($db);





switch ($data['q']) {

    case "adpic":
        adpic($data);
        break;

    case "androidVersion" :
        $version = array();
        $version['version'] = '1.15';
        $version['url'] = 'http://files.ozzomap.com/apklink/android/InterAcademy/InterAcademyFootball_1.15.apk';
        $message = array(
            'status' => 'success',
            'msg' => '',
            'data' => $version
        );
        echo json_encode($message);
        break;

    case "IOSVersion" :
        echo json_encode(array('Version' => '1.28'));
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
            foreach ($relationJobNoNewsArray as $v2) {
                if (empty ($v2)) continue;
                $mso->jobNoNew = $v2;
                $msoa->Add($mso);
            }
        }
        $message = array('success' => true, 'jobNoNew' => $mso->jobNoNew);
        die(json_encode($message));
        break;
    case 'adve':
        adve($data, $ja);
        break;
}

function adpic($data) {
    $mobileVersionArr = getArray('mobileVersion');
    $version = $mobileVersionArr[$data['version']];
    $type = strtolower(substr($data['version'], 0, 1));
    if ($type == 'a') {//android
        $path = 'android/' . $version . '/';

        /*$adpic = array();
        $adpic[] = 'http://www.ozzotec.com/academy/cache/adpic/'.$path.'2_ad1.png';
        $adpic[] = 'http://www.ozzotec.com/academy/cache/adpic/'.$path.'ad2.png';
        $adpic[] = 'http://www.ozzotec.com/academy/cache/adpic/'.$path.'ad3.png';
        $adpic[] = 'http://www.ozzotec.com/academy/cache/adpic/'.$path.'ad4.png';*/
        $adpic = array();
        $adpic[] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/cache/adpic/' . $path . '2_ad1.png';
        $adpic[] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/cache/adpic/' . $path . 'ad2.png';
        $adpic[] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/cache/adpic/' . $path . 'ad3.png';
        $adpic[] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/cache/adpic/' . $path . 'ad4.png';
    } elseif ($type == 'i') {
        $path = 'ios/' . $version . '/';

        $adpic = array();
        $adpic[] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/cache/adpic/' . $path . '2_ad1.png';
        $adpic[] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/cache/adpic/' . $path . 'ad2.png';
        $adpic[] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/cache/adpic/' . $path . 'ad3.png';
        $adpic[] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/cache/adpic/' . $path . 'ad4.png';
    } else {
        $message = array(
            'status' => 'failed',
            'msg' => 'VERSION ERROR',
            'data' => ''
        );
        echo json_encode($message);
        exit;
    }

    $message = array(
        'status' => 'success',
        'msg' => '',
        'data' => $adpic
    );
    echo json_encode($message);
}

/**新增查询广告图Url接口
 * @param $data 接收的参数
 * @param $ja jobsAccess类对象
 */
function adve($data, $ja) {
    //还需要添加一张公司固定的图片
    $arr = array();
    if (empty($data['resolution'])) {
        $data['resolution']=$_POST['resolution']?$_POST['resolution']:$_GET['resolution'];
        if(empty($data['resolution'])){
            $message = array(
                'status' => 'success',
                'msg' => '`resolution` Data is empty',
                'data' => ''
            );
            echo json_encode($message, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }
    $arr['resolution']=$data['resolution'];
    $string = explode('*', $arr['resolution'], 2);//获取需求实际宽高
    $divisor=max_divisor($string[0],$string[1]);//获取最大公约数
    $arr['rate'] = $string[0]/$divisor . ':' . $string[1]/$divisor;//拿到比例
    $infos = $ja->advImage(2, $arr);//查询比例相同的数据
    if ($infos['status'] == 'success') {
        //如果和数据库数据完全匹配，则不处理图片直接返回
        if($arr['resolution']==$infos['data'][1]['resolution']){
            foreach ($infos['data'] as $info){
                $adpics[] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . '/'.$info['path'];
            }
            $message = array(
                'status' => 'success',
                'msg' => '',
                'data' => $adpics
            );
            echo json_encode($message, JSON_UNESCAPED_UNICODE);
        }else{
            fileCache($ja,$arr);
            $adpics = adaptImage($arr, $infos);
            $message = array(
                'status' => 'success',
                'msg' => '',
                'data' => $adpics
            );
            echo json_encode($message, JSON_UNESCAPED_UNICODE);
        }
    } else {
        fileCache($ja,$arr);
        $imgRate = explode(':', $arr['rate'], 2);
        echo $imgRate;
        //算法计算，智能匹配
        $rate = $imgRate[0] / $imgRate[1];
        $differ1 = abs($rate - 2 / 3);
        $differ2 = abs($rate - 9 / 16);
        $differ3 = abs($rate - 1 / 2);
        $differ4 = abs($rate - 5 / 11);
        $differ5 = abs($rate - 3 / 5);
        $differ6 = abs($rate - 9 / 17);//
        $differArr = array($differ1, $differ2, $differ3, $differ4, $differ5, $differ6);
        sort($differArr);//将数组进行排序
        adaptRecursion($ja,$arr, 0, $differ1, $differ2, $differ3, $differ4, $differ5, $differ6, $differArr);
    }
}

/**广告图文件处理
 * @param $arr
 * @param $info
 * @return array
 */
function adaptImage($arr, $info) {
    $sqlDatas = $info['data'];
    $pathArr = array();
    $fileNameArr = array();
    foreach ($sqlDatas as $sqlData) {
        $pathArr[] = $sqlData['path'];
        $fileNameArr[] = $arr['resolution'].'_'.$sqlData['file_name'];
    }
    $len = count($pathArr);
    $adpics = array();
    for ($i = 0; $i < $len; $i++) {
        $filename = '../' . $pathArr[$i];//获取文件路径
        $fileInfo = getimagesize($filename);//获取文件大小
        $type = $fileInfo['mime'];
        $typeArr = explode('/', $type, 2);
        $type = $typeArr[1];//获取文件后缀
        $func = 'imagecreatefrom' . $type;//拼接建立原图函数
        $image = $func($filename);//构建原图
        $strings = explode('*', $arr['resolution'], 2);//获取需求实际宽高

        $image_thumb = imagecreatetruecolor($strings[0], $strings[1]);//新建蒙版
        imagecopyresampled($image_thumb, $image, 0, 0, 0, 0, $strings[0], $strings[1], $fileInfo[0], $fileInfo[1]);//复制图片到蒙版
        imagedestroy($image);//销毁缓存图片
        $outFunc = 'image' . $type;//拼接输出函数
        $filePath = '/cache/adpic/employ/' . $fileNameArr[$i];

        $outFunc($image_thumb, '..' . $filePath);//保存图片
        $adpics[] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . $filePath;
    }
    return $adpics;
}

/** 匹配广告图分辨率
 * @param $ja
 * @param $arr
 * @param $n
 * @param $differ1
 * @param $differ2
 * @param $differ3
 * @param $differ4
 * @param $differ5
 * @param $differ6
 * @param $differArr
 */
function adaptRecursion($ja,$arr, $n, $differ1, $differ2, $differ3, $differ4, $differ5, $differ6, $differArr) {
    switch ($differArr[$n]) {
        case $differ1:
            $arr['rate'] = '2:3';
            $info = $ja->advImage(2, $arr);
            if ($info['status'] == 'success') {
                $adpics = adaptImage($arr, $info);
                $message = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => $adpics
                );
                //查询数据成功返回数据
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
            } else {
//                echo 1111;
                $message = array(
                    'status' => 'failed',
                    'msg' => 'no data',
                    'data' => ''
                );
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
            }
            break;
        case $differ2:
            $arr['rate'] = '9:16';
            $info = $ja->advImage(2, $arr);
            if ($info['status'] == 'success') {
                $adpics = adaptImage($arr, $info);
                $message = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => $adpics
                );
                //查询数据成功返回数据
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
            } else {
//                echo 2222;
                $message = array(
                    'status' => 'failed',
                    'msg' => 'no data',
                    'data' => ''
                );
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
            }
            break;
        case $differ3:
            $arr['rate'] = '1:2';
            $info = $ja->advImage(2, $arr);
            if ($info['status'] == 'success') {
                echo 3333;
                $adpics = adaptImage($arr, $info);
                $message = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => $adpics
                );
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
            } else {
                $message = array(
                    'status' => 'failed',
                    'msg' => 'no data',
                    'data' => ''
                );
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
            }
            break;

        case $differ4:
            $arr['rate'] = '5:11';
            $info = $ja->advImage(2, $arr);
            if ($info['status'] == 'success') {
                $adpics = adaptImage($arr, $info);
                $message = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => $adpics
                );
                //查询数据成功返回数据
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
            } else {
                echo 4444;
                $message = array(
                    'status' => 'failed',
                    'msg' => 'no data',
                    'data' => ''
                );
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
            }
            break;

        case $differ5:
            $arr['rate'] = '3:5';
            $info = $ja->advImage(2, $arr);
            if ($info['status'] == 'success') {
                $adpics = adaptImage($arr, $info);
                $message = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => $adpics
                );
                //查询数据成功返回数据
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
            } else {
                if ($n < 3) {
                    adaptRecursion($ja, $arr,$n + 1, $differ1, $differ2, $differ3, $differ4, $differ5, $differ6, $differArr);
                }
            }
            break;
        case $differ6:
            $arr['rate'] = '7:16';
            $info = $ja->advImage(2, $arr);
            if ($info['status'] == 'success') {
                $adpics = adaptImage($arr, $info);
                $message = array(
                    'status' => 'success',
                    'msg' => '',
                    'data' => $adpics
                );
                //查询数据成功返回数据
                echo json_encode($message, JSON_UNESCAPED_UNICODE);
            } else {
                if ($n < 3) {
                    adaptRecursion($ja, $arr,$n + 1, $differ1, $differ2, $differ3, $differ4, $differ5, $differ6, $differArr);
                }
            }
            break;
    }
}

/**求最大公约数
 * @param $a 数a
 * @param $b 数b
 * @return mixed 最大公约数
 */
function max_divisor($a,$b){
    if($b==0){
        return $a;
    }else{
        return max_divisor($b, ($a % $b));
    }
}

/**从指定目录查找指定文件
 * @param $filename
 * @return string|null
 */
function findFile($filename) {
    $dir='../cache/adpic/employ';
    if ($fd = opendir($dir)) {
        while($file = readdir($fd)) {
            if ($file != "." && $file != "..") {
                if ($file == $filename) {
               $newPath = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME.'/cache/adpic/employ/'.$filename;
                return $newPath;
                }
            }
        }
    }
        return null;
}

/**如果存在获取缓存文件的url
 * @param $ja
 * @param $arr
 */
function fileCache($ja,$arr){
    $adpics=array();
    $infos= $ja->advImage(3);
    //进行文件查询，是否已存在原先缓存文件，存在直接拿缓存文件url返回
    if ($infos['status'] == 'success'){
        foreach ($infos['data'] as $info){
            $file_path=$arr['resolution'].'_'.$info['file_name'];//需要查询的文件名
            $file_name=findFile($file_path);//查询指定地址是否存在文件，存在则返回路径
            if (!empty($file_name)){
                $adpics[]=$file_name;
            }
        }
        if (!empty($adpics)){
            $message = array(
                'status' => 'success',
                'msg' => 'faafaf',
                'data' => $adpics
            );
            echo json_encode($message, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }
}