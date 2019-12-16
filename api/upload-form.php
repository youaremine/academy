<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 2016-05-07
 * Time: 22:18
 */

include_once ("../includes/config.inc.php");

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

$query = $_REQUEST ['q'];
if(empty($query)){
    $query = 'uploadForm';
}

switch ($query) {
    case "uploadPDFForm" :
        uploadPDFForm($data);
    case "uploadForm" :
        global $db;
        $jobNoNew = $_REQUEST ['jobNoNew'];
        $shortOneLetter = substr($jobNoNew,0,1);
        $prefix = 1;
        if(!empty($conf['shortDistrictName'][$shortOneLetter])){
            $districtName = $conf['shortDistrictName'][$shortOneLetter];
            $prefix = 1;
        }else{
            $shortTwoLetter = substr($jobNoNew,0,2);
            if(!empty($conf['shortDistrictName'][$shortTwoLetter])){
                $districtName = $conf['shortDistrictName'][$shortTwoLetter];
                $prefix = 2;
            }else{
                $json = array (
                    'success' => false,
                    'msg' => '没有找到对应的项目.'
                );
                die(json_encode($json));
            }
        }


        $m = new MainSchedule();
        $ma = new MainScheduleAccess($db);
        $m->jobNoNewSigle = $jobNoNew;
        $rs = $ma->GetListSearch($m);

        if(isset($rs[0]) && !empty($rs[0])){
            $m = $data = $rs[0];
            $json = array (
                'success' => true,
                'msg' => '成功獲取數據.'
            );
            $path = "/{$districtName}/{$m->jobNo}/";
            $path = $conf["path"]["root"].'cache/'.$path;
            if(!is_readable($path))
            {
                is_file($path) or mkdir($path,0755);
            }

            if(!is_array($_FILES['formFile']['name'])){
                $json = array (
                    'success' => false,
                    'msg' => '沒有檢測到上傳文件.'
                );
                die(json_encode($json));
            }
            foreach($_FILES['formFile']['name'] as $k=>$v){
                $fileExt = fileext($v);
                $fileExt = strtolower($fileExt);
                if($fileExt == 'pdf'){
                    $fileName = $path.$jobNoNew.'.'.fileext($v);
                }else{
                    $fileName = $path.$jobNoNew.'-'.date('YmdHis').$k.'.'.fileext($v);
                }
                move_uploaded_file($_FILES['formFile']['tmp_name'][$k],$fileName);
            }
            die(json_encode($json));
        }else{
            $json = array (
                'success' => false,
                'msg' => '沒有找到對應的調查資料.'
            );
            die(json_encode($json));
        }
        break;
    /*case "uploadForm" :
        global $db;
        $jobNoNew = $_REQUEST ['jobNoNew'];
        $shortOneLetter = substr($jobNoNew,0,1);
        $prefix = 1;
        if(!empty($conf['shortDistrictName'][$shortOneLetter])){
            $districtName = $conf['shortDistrictName'][$shortOneLetter];
            $prefix = 1;
        }else{
            $shortTwoLetter = substr($jobNoNew,0,2);
            if(!empty($conf['shortDistrictName'][$shortTwoLetter])){
                $districtName = $conf['shortDistrictName'][$shortTwoLetter];
                $prefix = 2;
            }else{
                $json = array (
                    'success' => false,
                    'msg' => '没有找到对应的项目.'
                );
                die(json_encode($json));
            }
        }


        $m = new MainSchedule();
        $ma = new MainScheduleAccess($db);
        $m->jobNoNewSigle = $jobNoNew;
        $rs = $ma->GetListSearch($m);


        //获取该job相关的信息.
//        $apiUrl = "http://www.ozzotec.com/".PROJECTNAME."/api/main.php?q=Info&jobNoNew={$jobNoNew}";
//        $apiUrl = "http://localphp.com/".PROJECTNAME."/api/main.php?q=Info&jobNoNew={$jobNoNew}";
//        $json = get_httpfile ( $apiUrl );
//        if (function_exists ( "json_decode" )) {
//            $data = json_decode ( $json );
        //} else {
           // $jsonService = new Services_JSON ();
          //  $data = $jsonService->decode ( $json );
        //}
        if(isset($rs[0]) && !empty($rs[0])){
            $m = $data = $rs[0];
            $json = array (
                'success' => true,
                'msg' => '成功獲取數據.'
            );
            $path = "/{$districtName}/{$m->jobNo}/";
            $path = $conf["path"]["root"].'cache/'.$path;
            if(!is_readable($path))
            {
                is_file($path) or mkdir($path,0755);
            }

            if(!is_array($_FILES['formFile']['name'])){
                $json = array (
                    'success' => false,
                    'msg' => '沒有檢測到上傳文件.'
                );
                die(json_encode($json));
            }
            foreach($_FILES['formFile']['name'] as $k=>$v){
                $fileExt = fileext($v);
                $fileExt = strtolower($fileExt);
                if($fileExt == 'pdf'){
                    $fileName = $path.$jobNoNew.'.'.fileext($v);
                }else{
                    $fileName = $path.$jobNoNew.'-'.date('YmdHis').$k.'.'.fileext($v);
                }
                move_uploaded_file($_FILES['formFile']['tmp_name'][$k],$fileName);
            }
            die(json_encode($json));
        }else{
            $json = array (
                'success' => false,
                'msg' => '沒有找到對應的調查資料.'
            );
            die(json_encode($json));
        }
        break;*/
    case "uploadPic" :
        if(!isset($_FILES['file']) || !isset($_FILES['file']['name'])){
            $json = array (
                'success' => false,
                'msg' => '沒有檢測到上傳文件.'
            );
            die(json_encode($json));
        }

        $dbPath = '/images/vipCard';
        $path = dirname(dirname(__FILE__)).$dbPath;
        if(!is_dir($path)){
            mkdir($path,0777);
        }

        $fileExt = fileext($_FILES['file']['name']);
        $fileExt = strtolower($fileExt);
        $fileName = '/'.date('YmdHis').'.'.$fileExt;
        $filePath = $path.$fileName;
        move_uploaded_file($_FILES['file']['tmp_name'],$filePath);
        $message = array (
            'status' => 'success',
            'msg' => '',
            'data' => $dbPath.$fileName
        );
        echo json_encode($message);
        exit;
        break;
}

function getClassRecord($class_record_id){
    global $db;
    $insert_data_sql = "SELECT surveyor_id,id,jobNoNew from Survey_SurveyorClassRecord WHERE id = '{$class_record_id}'  and is_del = 0 LIMIT 1";
    $db->query ( $insert_data_sql );
    $record = array();
    if($res = $db->next_record ()){
        $record['id'] = $res['id'];
        $record['surveyor_id'] = $res['surveyor_id'];
        $record['jobNoNew'] = $res['jobNoNew'];
    }
    return $record;
}

function uploadPDFForm($data){
    global $db,$conf;

    $surInfo = getSurInfo($data['sign']);

    $class_record_id = getArrNoNull($data,'class_record_id');

    $class_record = getClassRecord($class_record_id);
    if(empty($class_record)){
        returnJson('failed','','Class Record Not Found');
    }

    $jobNoNew = $class_record['jobNoNew'];
    if(isset($data['surveyor_id'])){
        $surveyor_id = $data['surveyor_id'];
        $ss = new Surveyor();
        $ss->survId = $surveyor_id;
        $ssa = new SurveyorAccess($db);
        $rs = $ssa->GetListSearch($ss);
        $info = $rs[0];
        if(!empty($info)){
            if(strpos($info->engName,$info->chiName) === false){
                $content = $info->chiName.' 上傳了新的付款證明。';
            }else{
                $content = $info->engName.' 上傳了新的付款證明。';
            }


        }else{
            returnJson('failed','','surveyor_id Not Found');
        }
    }else{
        $surveyor_id = $surInfo->survId;
        if(strpos($surInfo->engName,$surInfo->chiName) === false){
            $content = $surInfo->chiName.' 上傳了新的付款證明。';
        }else{
            $content = $surInfo->engName.' 上傳了新的付款證明。';
        }
    }

    if($surveyor_id != $surInfo->survId){
        if($surInfo->survType != 'admin' && $surInfo->survType != 'teach'){

            returnJson('failed','','Permission Error');
        }
    }


    $m = new MainSchedule();
    $ma = new MainScheduleAccess($db);
    $m->jobNoNewSigle = $jobNoNew;
    $m->surveyorCode = $surveyor_id;


    file_put_contents('/tmp/wkktest.logg','jobNoNew:'.$jobNoNew."\n".'data:'.json_encode($data)."\n".'surveyor_id:'.$surveyor_id,FILE_APPEND);

    $rs = $ma->GetListSearch($m);
    if(isset($rs[0]) && !empty($rs[0])){
        $m = $rs[0];
        $path = $conf["path"]["root"].'cache/paymentPDF/';
        if(!is_readable($path))
        {
            is_file($path) or mkdir($path,0755);
        }
        $urlPath = '/cache/paymentPDF/'.$m->jobNo.'/';
        $path = $conf["path"]["root"].$urlPath;
        if(!is_readable($path))
        {
            is_file($path) or mkdir($path,0755);
        }

        foreach($_FILES['formFile']['name'] as $k=>$v){
            $fileExt = fileext($v);
            $fileExt = strtolower($fileExt);

            if($fileExt == 'pdf'){
                $fileName = $jobNoNew.'-'.date('YmdHis').'.'.fileext($v);
                $savePath = $path.$fileName;
            }else{
                $fileName = $jobNoNew.'-'.date('YmdHis').$k.'.'.fileext($v);
                $savePath = $path.$fileName;
            }

            $moveres = move_uploaded_file($_FILES['formFile']['tmp_name'][$k],$savePath);
            if(!$moveres){
                returnJson('failed','','Move file failed');
            }else{
                addClassPDF($surveyor_id,$jobNoNew,$urlPath.$fileName,$surInfo->survId,$class_record_id);
            }
        }

        $title = '新消息通知';

        $type = 3;
        addNotifition($title,$content,$type);

        returnJson('success','','');

    }else{
        returnJson('failed','','沒有找到對應的課堂資料');
    }
}




/**
 * 添加通知记录
 *
 * */
function addNotifition($title,$content,$type){
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

function addClassPDF($surveyor_id,$jobNoNew,$path,$upload_surveyor_id,$class_record_id){
    global $db;

    $upload_pdf_time = date('Y-m-d H:i:s');
//插入到pdf表
    $sql = "INSERT into Survey_SurveyorClassPDF(surveyor_id,class_record_id,jobNoNew,path,upload_surveyor_id,upload_pdf_time) values ('$surveyor_id','$class_record_id','$jobNoNew','$path','$upload_surveyor_id','$upload_pdf_time')";
    $res = $db->query($sql);
return $res;


}


function getSurInfo($sign){
    global $conf,$db;
    if(empty($sign)){
        $message = array (
            'status' => 'failed',
            'msg' => 'sign is required.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $filename = $conf["path"]["sign"].$sign;
    $survId = file_get_contents($filename);
    if(empty($survId)){
        $message = array (
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
    if(empty($info)){
        $message = array (
            'status' => 'failed',
            'msg' => 'Sign Not Found',
            'data' => array()
        );
        die(json_encode($message));
    }
    return $info;
}


function getArrNoNull($arr,$field){
    if(isset($arr[$field])){
        return $arr[$field];
    }else{
        $message = array (
            'status' => 'failed',
            'msg' => $field.' is required',
            'data' => array()
        );
        die(json_encode($message));
    }
}

function returnJson($status='success',$data='',$msg=''){

    /* if(!empty($data)){
         if(is_array($data)){
             foreach($data){

             }
         }
     }*/
    $message = array (
        'status' => $status,
        'msg' => $msg,
        'data' => $data
    );
    die(json_encode($message));
}