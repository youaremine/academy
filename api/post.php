<?php
/**
 *
 * @copyright 2007-2013 Xiaoqiang.Wu
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2013-3-27
 */
include_once ("../includes/config.inc.php");

$tmp1 = json_decode(file_get_contents('php://input', 'r'),true);
$tmp2 = $_REQUEST;
if(!empty($tmp1)){//旧版本请求
    $data = $tmp1;
    if(!isset($data['q'])){
        $data['q'] = $tmp2['q'];
    }
}else{
    $data = $tmp2;
}
// start output
//if ($data['callback']) {
//	header ( 'Content-Type: text/javascript' );
//} else {
//	header ( 'Content-Type: application/x-json' );
//}

if(UserLogin::IsAdministrator()){
	$data['userId'] = $_SESSION['userId'];
}else{
	$data['signSurvId'] = checkSign($data);
}
switch ($data['q']) {
	case 'add' :
		addPost($data);
		break;
    case 'del' :
        delPost($data);
        break;
    case 'getList_hadDel' :
        getList_hadDel($data);
        break;
	case 'getList':
		getList($data);
		break;
	case 'getAllList':
		getReplyList($data,$data['postType']);
		break;
	case 'uploadPic':
		uploadPic($data);
		break;
    case 'uploadPicPC':
        uploadPicPC($data);
        break;
    case 'uploadVoice':
        uploadVoice($data);
        break;
    case 'editTop' :
        editTop($data);
        break;
    case 'getTopTitle' :
        getTopTitle($data);
        break;
    case 'getTop':
        getTop($data);
        break;
    case 'getTopContent':
        getTopContent($data);
        break;
	default:
		break;
}





/*
 * 删除留言
 *
 * */
function delPost($data){
    global $db,$conf;
    if(!isset($data['userId']) || $data['userId'] <= 0){
        if(empty($data['sign'])){
            $message = array (
                'status' => 'failed',
                'msg' => 'Permission denied',
                'data' => array()
            );
            die(json_encode($message));
        }
        $filename = $conf["path"]["sign"].$data['sign'];
        $survId = @file_get_contents($filename);
        $s = new Surveyor();
        $s->survId = $survId;
        $s->status = '';
        $sa = new SurveyorAccess($db);
        $rs = $sa->GetListSearch($s);
        $info = $rs[0];
        if($info->survType != 'teach' && $info->survType != 'admin'){
            $message = array (
                'status' => 'failed',
                'msg' => 'Permission denied.',
                'data' => array()
            );
            die(json_encode($message));
        }
    }

    if(!isset($data['postId']) || empty($data['postId'])){
        $message = array (
            'status' => 'failed',
            'msg' => 'postId is not allow null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $p = new Posts();
    $p->postId = $data['postId'];
    $pa = new PostsAccess($db);
    $rs = $pa->GetListSearch($p);
    if(empty($rs)){
        $message = array (
            'status' => 'failed',
            'msg' => 'postId not found',
            'data' => array()
        );
        die(json_encode($message));
    }

    if($rs[0]->format != 'text' && $rs[0]->format != 'image'){
        $message = array (
            'status' => 'failed',
            'msg' => 'this post format can not be deleted',
            'data' => array()
        );
        die(json_encode($message));
    }

    $nowTime = time();

    //可以刪除迄今為止7天內的留言
    if($nowTime - strtotime($rs[0]->inputTime) > 7 * 24 * 3600){
        $message = array (
            'status' => 'failed',
            'msg' =>'Failed!! This post over the time limit.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $res = $pa->deleteF($data['postId'],$data['userId']);
    if($res){
        $message = array (
            'status' => 'success',
            'msg' => '',
            'data' => array()
        );
        die(json_encode($message));
    }else{
        $message = array (
            'status' => 'failed',
            'msg' => 'System Error.Try again',
            'data' => array()
        );
        die(json_encode($message));
    }
}



function uploadPicPC($data){
    if(empty($data['jobNoNew'])){
        $message = array (
            'status' => 'failed',
            'msg' => 'job no is not allow null.',
            'data' => array()
        );
        die(json_encode($message));
    }

    global $conf,$db;
    $path = $conf["path"]["root"]."/images/post-pic/".date("Ymd");
    if(!is_readable($path))
    {
        is_file($path) or mkdir($path,0755);
    }
    if(empty($_FILES['picFile']['name'])){
        $message = array (
            'status' => 'failed',
            'msg' => '沒有檢測到上傳文件.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $p = new Posts();
    $pa = new PostsAccess($db);
    $p->parentId = empty($data['parentId'])?0:intval($data['parentId']);
    $p->categoryId = empty($data['categoryId'])?1:intval($data['categoryId']);;
    $p->jobNoNew = addslashes($data['jobNoNew']);
    $p->survId = intval($data['signSurvId']);
    $p->userId = intval($data['userId']);
    $p->format = empty($data['format'])?'image':$data['format'];
    $p->extInfo = $data['extInfo'];
    $p->inputip = getIP();
    $p->delFlag = 'no';
    $v = $_FILES['picFile']['name'];
    $fileName = $path.'/'.date('YmdHis').'-'.uniqid().'.'.fileext($v);
    $isSuccess = move_uploaded_file($_FILES['picFile']['tmp_name'],$fileName);
    if($isSuccess){
        //添加到聊天记录
        $p->content = str_replace($conf["path"]["root"],'',$fileName);
        $p->inputTime = date("Y-m-d H:i:s");
        $pa->Add($p);
    }else{
        $message = array (
            'status' => 'failed',
            'msg' => '上傳失敗，服務器錯誤001。',
            'data' => array()
        );
        die(json_encode($message));
    }
    $message = array (
        'status' => 'success',
        'msg' => '成功！',
        'data' => array()
    );
    die(json_encode($message));
}

/*
 * 编辑置顶留言板
 *
 * */
function editTop($data){
    global $conf,$db;
    if(empty($data['sign'])){
        $message = array (
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $filename = $conf["path"]["sign"].$data['sign'];
    $survId = @file_get_contents($filename);
    $s = new Surveyor();
    $s->survId = $survId;
    $s->status = '';
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];
    if($info->survType != 'teach' && $info->survType != 'admin'){
        $message = array (
            'status' => 'failed',
            'msg' => 'Permission denied.',
            'data' => array()
        );
        die(json_encode($message));
    }


    $n = new Notice();
    $na = new NoticeAccess($db);
    $n->title = isset($data['title'])?$data['title']:'';
    $n->title = htmlspecialchars($n->title);
    $n->content = isset($data['content'])?$data['content']:'';
    $n->content = htmlspecialchars($n->content);
    $n->update_time = date('Y-m-d H:i:s');
    $n->update_survId = $info->survId;
    $res = $na->Add($n);

    if($res){
        $message = array (
            'status' => 'success',
            'msg' => '',
            'data' => array()
        );

    }else{
        $message = array (
            'status' => 'failed',
            'msg' => 'Unknow Error',
            'data' => array()
        );
    }
    die(json_encode($message));
}

function post_check($post)
{
    if (!get_magic_quotes_gpc())
    {
        $post = addslashes($post);
    }
    $post = str_replace("_", "\_", $post);
    $post = str_replace("%", "\%", $post);
    $post = nl2br($post);
    $post= htmlspecialchars($post);
    return $post;
}
/*
 * 获取置顶留言板标题
 *
 * */
function getTopTitle($data){
    global $db;
    if(empty($data['sign'])){
        $message = array (
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $na = new NoticeAccess($db);
    $res = $na->SelectLast();
    $conres = htmlspecialchars_decode($res['content']);
    if(!empty($res)){
        $message = array (
            'status' => 'success',
            'msg' => '',
            'data' => array("title"=>$conres)
        );
    }else{
        $message = array (
            'status' => 'success',
            'msg' => '',
            'data' => array()
        );
    }
    die(json_encode($message));
}

/*
 * 获取置顶留言板详情
 *
 * */
function getTopContent($data){
    global $db;
    if(empty($data['sign'])){
        $message = array (
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $na = new NoticeAccess($db);
    $res = $na->SelectLast();
    $conres = htmlspecialchars_decode($res['content']);
    if(!empty($res)){
        $message = array (
            'status' => 'success',
            'msg' => '',
            'data' => array("content"=>$conres)
        );
    }else{
        $message = array (
            'status' => 'success',
            'msg' => '',
            'data' => array()
        );
    }
    die(json_encode($message));
}

function getTop($data){
    global $db;
    if(empty($data['sign'])){
        $message = array (
            'status' => 'failed',
            'msg' => 'sign is null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $na = new NoticeAccess($db);
    $res = $na->SelectLast();
    $conres = htmlspecialchars_decode($res['content']);
    if(!empty($res)){
        $message = array (
            'status' => 'success',
            'msg' => '',
            'data' => array("content"=>$conres,"title"=>$res['title'])
        );
    }else{
        $message = array (
            'status' => 'success',
            'msg' => '',
            'data' => array("content"=>'',"title"=>'')
        );
    }
    die(json_encode($message));
}

/**
 * 检查是否已经登录
 * @param $data
 * @return string
 */
function checkSign($data){
	global $conf;
	if(empty($data['sign'])){
		$message = array (
				'status' => 'failed',
				'msg' => 'sign is null.',
				'data' => array()
		);
		die(json_encode($message));
	}
	$filename = $conf["path"]["sign"].$data['sign'];
	$survId = file_get_contents($filename);


	if(empty($survId)){
		$message = array (
				'status' => 'failed',
				'msg' => 'Login has expired.',
				'data' => array()
		);
		die(json_encode($message));
	}
	return $survId;
}

/**
 * 添加留言板回复
 * @param $data
 */
function addPost($data){
    file_put_contents('/tmp/third.log','~~~~~~~~~~~'.time().'Request:'.json_encode($_REQUEST)."\n\n",FILE_APPEND);
	global $conf,$db;
	if(empty($data['jobNoNew']) || empty($data['content'])){
		$message = array (
				'status' => 'failed',
				'msg' => 'job no or content is not allow null.',
				'data' => array()
		);
		die(json_encode($message));
	}
	$p = new Posts();
	$pa = new PostsAccess($db);
	$p->parentId = empty($data['parentId'])?0:intval($data['parentId']);
	$p->categoryId = empty($data['categoryId'])?1:intval($data['categoryId']);
	$p->jobNoNew = addslashes($data['jobNoNew']);
	$p->content = addslashes($data['content']);
	$p->survId = intval($data['signSurvId']);
	$p->userId = intval($data['userId']);
	$p->inputip = getIP();
	$p->inputTime = date("Y-m-d H:i:s");
    $p->group_sending = isset($data['group_sending'])?$data['group_sending']:0;

    $s = new Surveyor();
    $s->survId = $data['signSurvId'];
    $s->status = '';
    $sa = new SurveyorAccess($db);
    $rs = $sa->GetListSearch($s);
    $info = $rs[0];
    if($info->survType == 'teach' || $info->survType == 'admin'){
        $p->had_reply = 1;
    }

    $p->surveyType = empty($data['surveyType']) || !isset($data['surveyType'])?'':$data['surveyType'];

	$p->delFlag = 'no';
	$pa->Add($p);
	$message = array (
			'status' => 'success',
			'msg' => '',
			'data' => array()
	);
	die(json_encode($message));
}

/*
 * 含有已经删除的留言
 * */
function getList_hadDel($data){
    global $conf,$db;
    if(empty($data['jobNoNew'])){
        $message = array (
            'status' => 'failed',
            'msg' => 'job no or is not allow null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $p = new Posts();
    $pa = new PostsAccess($db);
    $p->jobNoNew = $data['jobNoNew'];
    $p->startPostId = intval($data['startPostId']);
    $p->endPostId = intval($data['endPostId']);
    $p->limitTime = $data['limitTime'];
    $pagesize = intval($data['pagesize']);
    if($pagesize<=0){
        //$pagesize = 20;
    }
    if($p->endPostId > 0){
        $p->order = "ORDER BY postId DESC";
    }
    //$p->delFlag = 'no';
    if($pagesize > 0){
        $p->pageLimit = "LIMIT {$pagesize}";
    }
    $rs = $pa->GetListSearch($p);
    $jsonArr = array();
    $surveyorObj = new Surveyor();
    $surveyorAccessObj = new SurveyorAccess($db);

    $usersListObj = new UsersList($db);
    foreach($rs as $obj){
        $dr = array();
        $dr['postId'] = $obj->postId;
        $dr['format'] = $obj->format;
        $dr['jobNoNew'] = $obj->jobNoNew;
        if($obj->format == "image"){
            $dr['content'] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.'/'.$obj->content;
        }else{
            $dr['content'] = $obj->content;
            $dr['voiceTime'] = $obj->voiceTime;
        }
        $dr['survId'] = $obj->survId;

        if(!empty($obj->survId)){
            $surveyorObj->survId = $obj->survId;
            $surveyorObj->status = '';
            $_rs = $surveyorAccessObj->GetListSearch($surveyorObj);
            $dr['survName'] = $_rs[0]->chiName;
            $dr['survEngName'] = $_rs[0]->engName;
            $dr['profilePhoto'] = $_rs[0]->profilePhoto;
        }
        $dr['userId'] = $obj->userId;
        if(!empty($obj->userId)){
            $usersListObj->userId = $obj->userId;
            $_rs = $usersListObj->GetListSearch();
            $dr['userName'] = empty($_rs[0]->chiName)?$_rs[0]->engName:$_rs[0]->chiName;
        }
        $dr['inputTime'] = $obj->inputTime;
        $dr['group_sending'] = $obj->group_sending;
        $dr['delFlag'] = $obj->delFlag;
        $dr['delTime'] = $obj->delTime;
        $dr['deluser_chiName'] = $obj->deluser_chiName;
        $dr['deluser_engName'] = $obj->deluser_engName;
        $dr['shortInputTime'] = date("m月d日 H:i",strtotime($obj->inputTime));
        $jsonArr[] = $dr;
    }

    //按postId从小到大排序
    function mySort($a,$b)
    {
//		echo intval($a['postId']),'<',intval($b['postId']),'<br />';
        if ($a['postId']==$b['postId']) return 0;
        return (intval($a['postId'])<intval($b['postId']))?-1:1;
    }
    uasort($jsonArr,"mySort");
    $jsonArr = array_values($jsonArr);

    if(isset($data['limitTime'])){
        $limitTime = date('Y-m-d H:i:s',strtotime($data['limitTime'])-7*3600*24);
    }else{
        $limitTime = date('Y-m-d H:i:s',strtotime('-7 day'));
    }

    $deletedItem = $pa->getDeletedItem($data['jobNoNew'],$limitTime);

    $message = array (
        'status' => 'success',
        'msg' => '',
        'data' => $jsonArr,
        'deletedItem' => $deletedItem
    );
    die(json_encode($message));

}

function getList($data){
    global $conf,$db;
    if(empty($data['jobNoNew'])){
        $message = array (
            'status' => 'failed',
            'msg' => 'jobNoNew or is not allow null.',
            'data' => array()
        );
        die(json_encode($message));
    }
    $p = new Posts();
    $pa = new PostsAccess($db);
    $p->jobNoNew = $data['jobNoNew'];
    $p->startPostId = intval($data['startPostId']);
    $p->endPostId = intval($data['endPostId']);
    $pagesize = intval($data['pagesize']);
    if($pagesize<=0){
        //$pagesize = 20;
    }
    if($p->endPostId > 0){
        $p->order = "ORDER BY postId DESC";
    }
    //$p->delFlag = 'no';
    if($pagesize > 0){
        $p->pageLimit = "LIMIT {$pagesize}";
    }
    $rs = $pa->GetListSearch($p);
    $jsonArr = array();
    $surveyorObj = new Surveyor();
    $surveyorAccessObj = new SurveyorAccess($db);

    $usersListObj = new UsersList($db);
    foreach($rs as $obj){
        $dr = array();
        $dr['postId'] = $obj->postId;
        $dr['format'] = $obj->format;
        $dr['jobNoNew'] = $obj->jobNoNew;
        if($obj->format == "image"){
            $dr['content'] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.'/'.$obj->content;
        }else{
            $dr['content'] = $obj->content;
            $dr['voiceTime'] = $obj->voiceTime;
        }
        $dr['survId'] = $obj->survId;

        if(!empty($obj->survId)){
            $surveyorObj->survId = $obj->survId;
            $surveyorObj->status = '';
            $_rs = $surveyorAccessObj->GetListSearch($surveyorObj);

            $dr['survName'] = $_rs[0]->chiName;
            $dr['survEngName'] = $_rs[0]->engName;
            $dr['profilePhoto'] = $_rs[0]->profilePhoto;
        }
        $dr['userId'] = $obj->userId;
        if(!empty($obj->userId)){
            $usersListObj->userId = $obj->userId;
            $_rs = $usersListObj->GetListSearch();
            $dr['userName'] = empty($_rs[0]->chiName)?$_rs[0]->engName:$_rs[0]->chiName;
        }
        $dr['inputTime'] = $obj->inputTime;
        $dr['group_sending'] = $obj->group_sending;
        $dr['delFlag'] = $obj->delFlag;
        $dr['delTime'] = $obj->delTime;

        $dr['deluser_chiName'] = $obj->deluser_chiName;
        $dr['deluser_engName'] = $obj->deluser_engName;
        $dr['shortInputTime'] = date("m月d日 H:i",strtotime($obj->inputTime));
        $jsonArr[] = $dr;
    }

    //按postId从小到大排序
    function mySort($a,$b)
    {
//		echo intval($a['postId']),'<',intval($b['postId']),'<br />';
        if ($a['postId']==$b['postId']) return 0;
        return (intval($a['postId'])<intval($b['postId']))?-1:1;
    }
    uasort($jsonArr,"mySort");
    $jsonArr = array_values($jsonArr);
    /*$jsonArr['deletedItem'] = array();


    $limitTime = date('Y-m-d H:i:s',strtotime('-7 day'));
    $deletedItem = $pa->getDeletedItem($data['jobNoNew'],$limitTime);
    if($deletedItem){
        $jsonArr['deletedItem'] = $deletedItem;
    }*/

    $message = array (
        'status' => 'success',
        'msg' => '',
        'data' => $jsonArr
    );
    die(json_encode($message));

}

function getReplyList($data,$type="all"){
	global $conf,$db;
	$p = new Posts();
	$pa = new PostsAccess($db);
	$p->order = 'ORDER BY postId DESC';

    $pageLimit = empty(intval($data['pageLimit']))?200:intval($data['pageLimit']);
    $p->pageLimit = " LIMIT {$pageLimit}";

	$rs = $pa->GetUnReplyList($p,$type);

	$jsonArr = array();
	foreach($rs as $obj){
		$dr = array();
		$dr['postId'] = $obj->postId;
		$dr['jobNo'] = $obj->jobNo;
		$dr['jobNoNew'] = $obj->jobNoNew;
        $dr['surveyType'] = $obj->surveyType;
		$dr['content'] = $obj->content;
		$dr['survId'] = $obj->survId;
		$dr['userId'] = $obj->userId;
		$dr['inputTime'] = $obj->inputTime;
		$dr['shortInputTime'] = date("m月d日 H:i",strtotime($obj->inputTime));
        $dr['voiceTime'] = $obj->voiceTime;
        $dr['engName'] = $obj->engName;
        $dr['chiName'] = $obj->chiName;
        $dr['format'] = $obj->format;
        $dr['s_chiName'] = empty($obj->s_chiName)?'':$obj->s_chiName;
        $dr['s_engName'] = empty($obj->s_engName)?'':$obj->s_engName;
        $dr['s_survId'] = empty($obj->s_survId)?'':$obj->s_survId;
		$jsonArr[] = $dr;
	}

	$message = array (
			'status' => 'success',
			'msg' => '成功！',
			'data' => $jsonArr
	);
	die(json_encode($message));
}

function uploadPic($data){
    file_put_contents('/tmp/third.log','~~~~~~~~~~~'.time().'Request:'.json_encode($_REQUEST)."\n\n",FILE_APPEND);
	if(empty($data['jobNoNew'])){
		$message = array (
				'status' => 'failed',
				'msg' => 'job no is not allow null.',
				'data' => array()
		);
		die(json_encode($message));
	}

	global $conf,$db;
	$path = $conf["path"]["root"]."/images/post-pic/".date("Ymd");
	if(!is_readable($path))
	{
		is_file($path) or mkdir($path,0755);
	}
	if(!is_array($_FILES['picFile']['name'])){
		$message = array (
				'status' => 'failed',
				'msg' => '沒有檢測到上傳文件.',
				'data' => array()
		);
		die(json_encode($message));
	}

	$p = new Posts();
	$pa = new PostsAccess($db);
	$p->parentId = empty($data['parentId'])?0:intval($data['parentId']);
	$p->categoryId = empty($data['categoryId'])?1:intval($data['categoryId']);;
	$p->jobNoNew = addslashes($data['jobNoNew']);
	$p->survId = intval($data['signSurvId']);
	$p->userId = intval($data['userId']);
	$p->format = 'image';
	$p->inputip = getIP();
	$p->delFlag = 'no';
    $p->group_sending = isset($data['group_sending'])?$data['group_sending']:0;
	foreach($_FILES['picFile']['name'] as $k=>$v){
		$fileName = $path.'/'.date('YmdHis').'-'.uniqid().'.'.fileext($v);
		move_uploaded_file($_FILES['picFile']['tmp_name'][$k],$fileName);
		//添加到聊天记录
		$p->content = str_replace($conf["path"]["root"],'',$fileName);
		$p->inputTime = date("Y-m-d H:i:s");
		$pa->Add($p);
	}
	$message = array (
			'status' => 'success',
			'msg' => '成功！',
			'data' => array()
	);
	die(json_encode($message));
}

function uploadVoice($data){
    include_once ("../includes/getid3/getid3.php");

    if(empty($data['jobNoNew'])){
        $message = array (
            'status' => 'failed',
            'msg' => 'job no is not allow null.',
            'data' => array()
        );
        die(json_encode($message));
    }

    global $conf,$db;
    $path = $conf["path"]["root"]."/voice/post-pic/".date("Ymd");
    if(!is_readable($path))
    {
        is_file($path) or mkdir($path,0755);
    }
    if(!is_array($_FILES['picFile']['name'])){
        $message = array (
            'status' => 'failed',
            'msg' => '沒有檢測到上傳文件.',
            'data' => array()
        );
        die(json_encode($message));
    }

    $p = new Posts();
    $pa = new PostsAccess($db);
    $p->parentId = empty($data['parentId'])?0:intval($data['parentId']);
    $p->categoryId = empty($data['categoryId'])?1:intval($data['categoryId']);
    $p->jobNoNew = addslashes($data['jobNoNew']);
    $p->survId = intval($data['signSurvId']);
    $p->userId = intval($data['userId']);
    $p->format = 'voice';
    $p->inputip = getIP();
    $p->delFlag = 'no';

    foreach($_FILES['picFile']['name'] as $k=>$v){
        $fileName = $path.'/'.date('YmdHis').'-'.uniqid().'.'.fileext($v);
        $getID3 = new getID3();

        $ThisFileInfo = $getID3->analyze($_FILES['picFile']['tmp_name'][$k]); //分析文件，$path为音频文件的地址
        $fileduration=$ThisFileInfo['playtime_seconds']; //这个获得的便是音频文件的时长
        move_uploaded_file($_FILES['picFile']['tmp_name'][$k],$fileName);
        //添加到聊天记录
        $p->content = str_replace($conf["path"]["root"],'',$fileName);
        $p->inputTime = date("Y-m-d H:i:s");
        $p->voiceTime = $fileduration;
        $pa->Add($p);
    }
    $message = array (
        'status' => 'success',
        'msg' => '成功！',
        'data' => array()
    );
    die(json_encode($message));
}