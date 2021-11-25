<?php

use Swoole\Websocket;

//use Redis;
include("../../includes/config.inc.php");
include("./push/php/src/MsgPush.php");

class WebsocketServer {

    //swoole对象
    private $server;
    //swoole中的table对象
    private $table;
    //redis对象
    private $redis;
    //数据库对象
    private $db;
    //设置端口
    private $port = 3338;
    //默认可以访问的Ip
    private $host = "0.0.0.0";
    //离线推送类对象
    private $msgPush;
    //离线推送类对象
    private $ios_msgPush;
    //是否开启debug 模式
    private $debug = true;
    //設置redis的登錄賬號的filed名
    private $loginAccount = PROJECTNAME . "_login_account";


    public function __construct() {
        global $conf;
        $this->server = new Websocket\Server($this->host, $this->port);//建立websocket連接



        //获取本机所有网络接口的IP地址
        echo swoole_get_local_ip()['eth0'] . ":" . $this->port . " Websocket服务启动成功\n";

        $this->db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);//初始化数据库
        $this->onInit();//初始化注册事件
        $this->msgPush = new MsgPush();//初始化安卓离线推送
        $this->ios_msgPush = new MsgPush('ios');//初始化ios离线推送
        $this->redisInit();//初始化redis
    }

    /**设置连接端口
     * @param $value
     */
    public function setPort($value) {
        $this->port = $value;
    }

    /**限制可连接IP
     * @param $value
     */
    public function setHost($value) {
        $this->host = $value;
    }

    /**连接回调事件
     * @param $server
     * @param $request
     */
    public function open($server, $request) {
        echo "连接成功: {$request->fd}\n";
        //獲取鏈接id
        $user_id = $request->get['user_id'];

        //deviceToken => 友盟token （用于 发送友盟的离线推送）
        $msg_token = $request->get['deviceToken'];

        //deviceToken2 => 设备token （如果不填，或为空，则用友盟token 代替。用于判断单设备登录）
        $deviceToken2 = (isset($request->get['deviceToken2']) && !empty($request->get['deviceToken2'])) ? $request->get['deviceToken2'] : $msg_token;

        $deviceType = $request->get['deviceType'];

        //踢下线（单设备登录）
        $this->oneDevice($user_id,$deviceType,$msg_token,$request,$server,$deviceToken2);

        //存在离线消息，进行推送

        if ($this->redis->exists(PROJECTNAME . '_unpush_info' . $user_id)) { //檢查KEY是否存在
            //获取redis当前队列里面所有的值
            $pushInfo = $this->redis->hgetall(PROJECTNAME . '_unpush_info' . $user_id);
            if(!empty($pushInfo)){
                $returnDate=array();
                $returnDate['status']='success';
                $returnDate['msg']='';
                $returnDate['type']='msg';
                $returnDate['data']=[];
                foreach ($pushInfo as $v){
                    $returnDate['data'][]=json_decode($v,true);
                }

                //echo "\n========================".json_encode($returnDate)."\n";
                echo "\n======================TO==".$request->fd."\n";
                //推送消息
                $server->push($request->fd, json_encode($returnDate));
            }
        }
    }

    /**
     * 踢下线，单设备登录
     * */

    public function oneDevice($user_id,$deviceType,$msg_token,$request,$server,$deviceToken2){
        $sqlOld = "SELECT device_token FROM Survey_Surveyor WHERE survId='{$user_id}'";
        $tokenOldSql=$this->db->query($sqlOld);
        $tokenOld=mysqli_fetch_assoc($tokenOldSql)['device_token'];//获取之前的token

        if($this->debug){
            echo 'autoLogin'.$request->get['autoLogin']."\n";
            echo 'tokenOld'.$tokenOld."\n";
            echo 'msg_token'.$msg_token."\n";
            echo 'deviceToken2'.$deviceToken2."\n";
        }

        //判断如果存在此用户，且登录的设备不同，给原先设备连接发送离线通知
        if($this->redis->hexists($this->loginAccount,'survId_' . $user_id)){
            $this->loginState($request,$tokenOld,$deviceToken2,$server,$user_id);
        }else{
            $this->redis->hset($this->loginAccount,'survId_' . $user_id, $request->fd);
        }

        if(!$request->get['autoLogin']) {
            //保存token 之前先判断是否已经存在相同token,有的话先删掉
            $sql = "UPDATE Survey_Surveyor SET msg_token='' and device_token = '' WHERE device_token='{$deviceToken2}'";
            $this->db->query($sql);
            //保存下 token-user_id 到用户表
            $sql = "UPDATE Survey_Surveyor SET msg_token='{$msg_token}',device_token = '{$deviceToken2}', deviceType='{$deviceType}' WHERE survId='{$user_id}'";
            $this->db->query($sql);
            //用redis保存user_id和fd的关系
            $this->redis->hset($this->loginAccount,'survId_' . $user_id, $request->fd);
        }
    }


    /**
     * 判断登录状态
     * @param $request
     * @param $tokenOld
     * @param $deviceToken2
     * @param $server
     * @param $user_id
     */
    public function loginState($request,$tokenOld,$deviceToken2,$server,$user_id)
    {
        if($request->get['autoLogin']) {
            //如果是自动登录
            if($tokenOld !== $deviceToken2){
                echo "是自动登录";
                //如果是自动登录，下线通知
                $this->logoffNotice($request->fd,$server);
            }else{
                //用redis保存user_id和fd的关系
                $this->redis->hset($this->loginAccount,'survId_' . $user_id, $request->fd);
            }
        }else{
            if($tokenOld !== $deviceToken2){

                $offFd= $this->redis->hget($this->loginAccount,'survId_' . $user_id);
                //主动断开之前连接
                $this->close($server,$offFd);
                //不是自动登录，下线通知
                $this->logoffNotice($offFd,$server);
            }else{
                $this->redis->hset($this->loginAccount,'survId_' . $user_id, $request->fd);
            }
        }
    }



    /**
     * 通知另一台用户下线
     * @param $requestId//通知用户的id
     * @param $server
     */
    public function logoffNotice($requestId,$server)
    {
        $returnDate['status']='success';
        $returnDate['msg']='';
        $returnDate['type']='off_line';
        $returnDate['data']=[];
        $server->push($requestId, json_encode($returnDate));//通知另外一台用戶下線
    }

    /**
     * 获取发送人的姓名
     * @param $info
     * @return string[]|null
     */
    public function getSenderName($info)
    {
        $getUserNameSql = "SELECT chiName,engName FROM `Survey_Surveyor` WHERE `survId` = {$info->user_id} ";
        $user = mysqli_fetch_assoc($this->db->query($getUserNameSql));

        return $user;
    }

    /**
     * 过滤重复的 token 避免发送多次推送
     * @param $offArr
     * @return mixed
     */
    public function getToken($offArr)
    {
        //将离线用户id整理成字符串
        if(is_array($offArr)){
            $off_user_id = implode(",",$offArr);
        }
        //过滤重复的 token 避免发送多次推送
        $getTokenSql = "SELECT `survId`,`msg_token`,`deviceType` FROM Survey_Surveyor WHERE `survId` IN ({$off_user_id}) ";

        $tokenList=$this->db->query($getTokenSql);

        return $tokenList;
    }

    /**
     * 即时聊天发送离线推送
     * @param $offArr
     * @param $info
     * @param $returnDate
     * @param $postId
     */
    public function offline_push($offArr,$info,$returnDate,$postId){
        //获取发送人的姓名
        $user = $this->getSenderName($info);

        $dataArr = array();
        $dataArr['info'] = $info;
        $dataArr['chiName'] = $user['chiName'];
        $dataArr['engName'] = $user['engName'];
        $dataArr['returnDate'] = $returnDate;
        $dataArr['postId'] = $postId;

        //过滤重复的 token 避免发送多次推送
        $tokenList = $this->getToken($offArr);
        //离线消息循环推送
        while ($re = mysqli_fetch_assoc($tokenList)) {
            $this->offlinePush($re,$dataArr);
        }
    }

    /**
     * 保存離綫消息在redis裏面
     * @param $list
     * @param $postId
     * @param $returnDate
     */
    public function saveOfflineMsg($list,$postId,$returnDate)
    {
        $returnDate['is_push']=1;
        $this->redis->hset(PROJECTNAME . '_unpush_info' . $list['user_id'],$postId, json_encode($returnDate));
    }

    /**
     * 處理Android和IOS用戶離綫消息推送的公用方法
     * @param $re
     * @param $dataArr
     */
    public function offlinePush($re,$dataArr){
        if($re['deviceType']==1){
            //安卓
            $androidList = ['user_id'=>$re['survId'],'msg_token'=>$re['msg_token']];
            echo "===== Android 用户：".json_encode($androidList)."271\n";
            $this->processTheMsg($androidList,$dataArr,1);//1代表安卓用戶
        }else if($re['deviceType']==2){
            //ios
            $iosList=['user_id'=>$re['survId'],'msg_token'=>$re['msg_token']];

            echo "==================== IOS 用户 ：".json_encode($iosList)."277\n";
            $this->processTheMsg($iosList,$dataArr,2);//2代表ios用戶
        }
    }

    /**
     * 發送離綫消息給不同系統的用戶
     * @param $list
     * @param $dataArr
     * @param $status
     */
    public function processTheMsg($list,$dataArr,$status)
    {
        $info = $dataArr['info'];

        $data['msg_token'] = $list['msg_token'];
        $data['ticker'] = "你有一条新消息";
        $data['title'] = $info->jobNo !== $info->group_id ? $info->group_name : $info->group_name_up;
        $data['text'] = strstr($dataArr['chiName'],$dataArr['engName']) ? $dataArr['chiName'] . ":" . $info->mss_content : $dataArr['chiName'] . "(" . $dataArr['engName'] . "):" . $info->mss_content;//内容
        $data['description'] = "";


        $message = array();
        $message['data'] = array();
        $dataArr['returnDate']['is_push'] = 1;
        $message['data'][] = $dataArr['returnDate'];
        $message['type'] = 'msg';
        $data['message']=$message;//离线消息的自定义字段
        if(!empty($list['msg_token'])){
            //判斷是1為Android還是2為IOS用戶
            $status == 1 ? $this->msgPush->sendAndroidUnicast($data) : $this->ios_msgPush->sendIOSUnicast($data);

        }
        //保存离线消息
        $this->saveOfflineMsg($list,$dataArr['postId'],$dataArr['returnDate']);
    }

    /**接收消息回调事件
     * @param $server
     * @param $frame
     */
    public function message($server, $frame) {

        $info = json_decode($frame->data);
        $type = $info->type;
        //获取回传的格式
        $timer = date('Y-m-d H:i:s');
        $mode = $info->mode;//1--私聊，2--群聊

        echo "\n\n".'app send data:'.$frame->data;

        if($type == 'sendSuccess'){
            //发送成功后客户端返回回执，确认已收到
            $user_id = $info->user_id;
            $postId = $info->postId;
            //清空在redis上储存的离线消息  postId是redis的key
            if ($this->redis->exists(PROJECTNAME . '_unpush_info' . $user_id)) {
                //清空当前未发送（未收到客户端回执）队列
                $this->redis->hdel(PROJECTNAME . '_unpush_info' . $user_id,$postId);
            }

        }else{
            switch ($mode) {
                //alive
                case 0:

                    $to = $this->redis->hget($this->loginAccount,'survId_' . $info->user_id);
                    $extra = ['status' => 'success', 'msg' => '', 'type'=>'msg','data' => ['service']];
                    $server->push($to, json_encode($extra));
                    break;
                //私聊
                case 1:
                    //私聊功能暂时不需要开发
                    break;

                //群发
                case 2:

                    if($this->debug == true){
                        echo "\n\n\n\n\n==========================================================\n";
                        echo 'to_user_id:'.$info->to_user_id."\n";
                    }

                    $arr = $this->getSendUser($info,$info->to_user_id);//所有要发送的名单

                    if($this->debug == true){
                        echo "\n\n\n\n\n==========================================================\n";
                        echo 'All User:'.json_encode($arr)."\n";
                    }


                    //将在线和离线的分开
                    $onArr = array();//在线
                    $offArr = array();//离线

                    foreach ($arr as $value) {
                        //檢查hash表指定的字段是否存在
                        if ($this->redis->hexists($this->loginAccount,'survId_' . $value)) {
                            $onarr_tmp = array();
                            $onarr_tmp['fd'] = $this->redis->hget($this->loginAccount,'survId_' . $value);
                            $onarr_tmp['user_id'] = $value;
                            $onArr[] = $onarr_tmp;
                        } else {
                            //不在线的
                            $offArr[] = $value;
                        }
                    }

                    foreach($info as &$one){
                        if(is_string($one)){
                            $one = addslashes($one);
                        }
                    }
                    //將需要發送的消息存入數據庫
                    $sql = "INSERT INTO Survey_Msg(`msg_form`,`msg_to`,`group_id`,`jobNo`,`group_name`,`groups_ident`,`msg_content`,`send_time`,`msg_type`,`group_name_up`,`to_user_id`) VALUE
                    ('{$info->user_id}','{$info->to_user_id}','{$info->group_id}','{$info->jobNo}','{$info->group_name}','{$info->groups_ident}','{$info->mss_content}','{$timer}','{$info->type}','{$info->group_name_up}','{$info->to_user_id}')";
                    $this->db->query($sql);
                    $sqls = "SELECT LAST_INSERT_ID()";//返回自增id
                    $postId = mysqli_fetch_assoc($this->db->query($sqls))['LAST_INSERT_ID()'];

                    //拿到需要发送的消息
                    $returnDate = $this->returnDate($info, $timer, $postId);

                    if (!empty($onArr)) {
                        //在线的进行websocket发送
                        echo "==================== Websocket 发送：".json_encode($onArr)."\n";
                        echo "\n==onarr:".json_encode($onArr);
                        foreach ($onArr as $v) {
                            $extra = ['status' => 'success', 'msg' => '', 'type'=>'msg','data' => [$returnDate]];

                            $this->redis->hset(PROJECTNAME . '_unpush_info' . $v['user_id'],$postId, json_encode($returnDate));
                            $server->push($v['fd'], json_encode($extra));
                        }
                    }
                    echo "==================== 离线推送：".json_encode($offArr)."\n";
                    //判斷不在線的人員
                    if (!empty($offArr)) {
                        $this->offline_push($offArr,$info,$returnDate,$postId);
                    }
                    echo "====================================================END================================================= \n\n";
                    break;

                //onfire 比赛的聊天
                case 3:
                    $arr = $this->getMatcherSendUser($info);


                    //将在线和离线的分开
                    $onArr = array();//在线
                    $offArr = array();//离线

                    foreach ($arr as $value) {
                        //檢查hash表指定的字段是否存在
                        if ($this->redis->hexists($this->loginAccount,'survId_' . $value)) {
                            $onarr_tmp = array();
                            $onarr_tmp['fd'] = $this->redis->hget($this->loginAccount,'survId_' . $value);
                            $onarr_tmp['user_id'] = $value;
                            $onArr[] = $onarr_tmp;
                        } else {
                            //不在线的
                            $offArr[] = $value;
                        }
                    }

                    foreach($info as &$one){
                        if(is_string($one)){
                            $one = addslashes($one);
                        }
                    }
                    //將需要發送的消息存入數據庫
                    $sql = "INSERT INTO Survey_Msg(`msg_form`,`msg_to`,`group_id`,`jobNo`,`group_name`,`groups_ident`,`msg_content`,`send_time`,`msg_type`,`group_name_up`,`to_user_id`) VALUE
                    ('{$info->user_id}','{$info->to_user_id}','{$info->group_id}','{$info->jobNo}','{$info->group_name}','{$info->groups_ident}','{$info->mss_content}','{$timer}','{$info->type}','{$info->group_name_up}','{$info->to_user_id}')";
                    $this->db->query($sql);
                    $sqls = "SELECT LAST_INSERT_ID()";//返回自增id
                    $postId = mysqli_fetch_assoc($this->db->query($sqls))['LAST_INSERT_ID()'];

                    //拿到需要发送的消息
                    $returnDate = $this->returnDate($info, $timer, $postId);

                    if (!empty($onArr)) {
                        //在线的进行websocket发送
                        echo "==================== Websocket 发送：".json_encode($onArr)."\n";
                        echo "\n==onarr:".json_encode($onArr);
                        foreach ($onArr as $v) {
                            $extra = ['status' => 'success', 'msg' => '', 'type'=>'msg','data' => [$returnDate]];

                            $this->redis->hset(PROJECTNAME . '_unpush_info' . $v['user_id'],$postId, json_encode($returnDate));
                            $server->push($v['fd'], json_encode($extra));
                        }
                    }
                    echo "==================== 离线推送：".json_encode($offArr)."\n";
                    //判斷不在線的人員
                    if (!empty($offArr)) {
                        $this->offline_push($offArr,$info,$returnDate,$postId);
                    }
                    echo "====================================================END================================================= \n\n";
                    break;

                    break;

                default:
                    break;
            }
        }
    }

    /**断开连接回调事件
     * @param $server
     * @param $fd
     */
    public function close($server, $fd) {
        //离线 需要删除对应的数据
        $fdList = $this->redis->hgetall($this->loginAccount);
        echo "---------------------------------------断开连接:\n";
        if(is_array($fdList) && !empty($fdList)){
            foreach ($fdList as $k => $v) {
                if ($v == $fd) {
                    //斷開連接去刪除redis的登錄賬號信息
                    $this->redis->hdel($this->loginAccount, $k);
                    echo "断开连接: {$k}\n";
                }
            }
        }else{
            echo "ERROR::::::::::::::::::::";
            var_dump($fdList);
        }


    }

    /**
     * 注册事件
     */
    private function onInit() {
//        [$this,'open'] --把方法转为闭包参数传入
        $this->server->on('open', [$this, 'open']);
        $this->server->on('message', [$this, 'message']);
        $this->server->on('close', [$this, 'close']);
    }

    /**
     * 初始化swoole表格
     */
    public function tableInit() {
        $this->table = new Swoole\Table(1 * 1024 * 1024);
        $this->table->column('fd', Swoole\Table::TYPE_INT);//增加一列，字段名fd，字段类型int
        $this->table->create();//初始化
    }

    /**
     * 初始化redis
     */
    public function redisInit() {

        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379);
        //$this->redis->Flushdb ();//清空当前数据库中指定的key
//        $this->redis->auth('Ozzo2019');//密码字符
    }

    /**
     * 启动方法
     */
    public function start() {
        $this->server->start();
    }

    /**返回需要发送的信息格式
     * @param $info 接收到的信息
     * @param $time 接收到的时间
     * @param $postId 保存到数据库的消息ID
     * @return array 处理好的数据
     */
    public function returnDate($info, $time, $postId) {
        $sql = "SELECT chiName,engName,profilePhoto FROM Survey_Surveyor WHERE survId ='{$info->user_id}'";
        $re = $this->db->query($sql);
        $data = mysqli_fetch_array($re);//拿到用户数据
        $arr = array();
        $arr['postId'] = $postId;
        $arr['format'] = $info->type;
        $arr['jobNoNew'] = $info->group_id;
        $arr['content'] = $info->mss_content;
        $arr['voiceTime'] = "";
        $arr['survId'] = $info->user_id;
        $arr['survName'] = $data['chiName'];
        $arr['survEngName'] = $data['engName'];
        $arr['profilePhoto'] = empty($data['profilePhoto'])?'':$data['profilePhoto'];
        $arr['userId'] = "";//网页版id
        $arr['inputTime'] = $time;
        $arr['group_sending'] = $info->group_sending;
        $arr['mode'] = $info->mode;
        $arr['delFlag'] = "no";
        $arr['delTime'] = "0000-00-00 00:00:001";
        $arr['deluser_chiName'] = "";
        $arr['deluser_engName'] = "";
        $arr['shortInputTime'] = date("m月d日 H:i", strtotime($time));
        $arr['jobNo'] = $info->jobNo;
        $arr['group_name'] = $info->group_name;
        $arr['groups_ident'] = $info->groups_ident;
        $arr['group_name_up'] = $info->group_name_up;

        $arr['is_push'] = 0;
        $arr['to_user_id'] = $info->to_user_id;//接收者的用户id

        if($info->type == 'image'){//图片信息
            $arr['img_width'] = $info->img_width;
            $arr['img_height'] = $info->img_height;
            $arr['img_size'] = $info->img_size;
        }


        return $arr;
    }

    /**获取消息需要发送到的名单
     * @param $info
     * @return array
     * $to_user_id 如果不为空， 则为置顶留言  等于调查员id
     */
    public function getSendUser($info,$to_user_id = '') {
        $arr = array();

        if(!empty($to_user_id)){ //置顶留言
            $arr[] = $to_user_id;
        }else{
            //查询选择课堂的用户
            if ($info->jobNo === $info->group_id) {
                $sql = "SELECT `surveyorCode` FROM Survey_MainSchedule WHERE `jobNo`='{$info->group_id}' AND `surveyorCode` != '' GROUP BY `surveyorCode`";
            } else {
                $sql = "SELECT `surveyorCode` FROM Survey_MainSchedule WHERE `jobNoNew`='{$info->group_id}' AND `surveyorCode` != '' GROUP BY `surveyorCode`";
            }

            $sqlInfo = $this->db->query($sql);
            while ($data = mysqli_fetch_assoc($sqlInfo)) {
                $arr[] = $data['surveyorCode'];
            }
        }

        //保存所有管理员id
        $getAdminSql = "SELECT `survId` FROM Survey_Surveyor WHERE `survType` = 'admin' OR `survType` = 'teach'";
        $getAdminInfo = $this->db->query($getAdminSql);
        while ($data = mysqli_fetch_assoc($getAdminInfo)) {
            if (!in_array($data['survId'], $arr)) {
                $arr[] = $data['survId'];
            }
        }

        return $arr;
    }

    /**获取onfire比赛的消息需要发送到的名单
     * @param $info
     * @return array
     * $to_user_id 如果不为空， 则为置顶留言  等于调查员id
     */
    public function getMatcherSendUser($info) {
        $arr = array();

        if(empty($info->group_id)){
            echo 'ERROR!! group_id is empty';
        }else{
            //获取需要接受消息的用户
            $get_plays_sql = "SELECT can_see_id FROM Survey_match WHERE `id` = {$info->group_id}";
            $get_plays = $this->db->query($get_plays_sql);
            while ($data = mysqli_fetch_assoc($get_plays)) {
                if(!empty($data['can_see_id'])){
                    $tmp_arr = explode(',',$data['can_see_id']);
                    $arr = array_merge($arr,$tmp_arr);
                }
            }
        }
        //获取所有管理员id
        $getAdminSql = "SELECT `survId` FROM Survey_Surveyor WHERE `survType` = 'admin' OR `survType` = 'teach'";
        $getAdminInfo = $this->db->query($getAdminSql);
        while ($data = mysqli_fetch_assoc($getAdminInfo)) {
            if (!in_array($data['survId'], $arr)) {
                $arr[] = $data['survId'];
            }
        }



        return $arr;
    }

}

(new WebsocketServer)->start();