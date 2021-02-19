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
    private $port = 3333;
    //默认可以访问的Ip
    private $host = "0.0.0.0";
    //离线推送类对象
    private $msgPush;
    //离线推送类对象
    private $ios_msgPush;

    //是否开启debug 模式
    private $debug = true;



    public function __construct() {
        global $conf;
        $this->server = new Websocket\Server($this->host, $this->port);
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

        $user_id = $request->get['user_id'];
        //deviceToken => 友盟token （用于 发送友盟的离线推送）
        $msg_token = $request->get['deviceToken'];
        //deviceToken2 => 设备token （如果不填，或为空，则用友盟token 代替。用于判断单设备登录）
        $deviceToken2 = (isset($request->get['deviceToken2']) && !empty($request->get['deviceToken2']))?$request->get['deviceToken2']:$msg_token;
        $deviceType = $request->get['deviceType'];

        //踢下线（单设备登录）
        $this->oneDevice($user_id,$deviceType,$msg_token,$request,$server,$deviceToken2);

        //存在离线消息，进行推送
        $this->redis->select(1);
        if ($this->redis->exists('unpush_info' . $user_id)) {
            //获取redis当前队列里面所有的值
            $pushInfo = $this->redis->hgetall('unpush_info' . $user_id);
            if(!empty($pushInfo)){
                $returnDate=array();
                $returnDate['status']='success';
                $returnDate['msg']='';
                $returnDate['type']='msg';
                $returnDate['data']=[];
                foreach ($pushInfo as $v){
                    $returnDate['data'][]=json_decode($v,true);
                }

                echo "\n========================".json_encode($returnDate)."\n";
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
        $this->redis->select(0);
        if($this->redis->hexists("fd_hash", 'fd_' . $user_id)){
            if($request->get['autoLogin']) {
                //如果是自动登录
                if($tokenOld !== $deviceToken2){
                    $returnDate['status']='success';
                    $returnDate['msg']='';
                    $returnDate['type']='off_line';
                    $returnDate['data']=[];
                    $server->push($request->fd, json_encode($returnDate));
                    /* $this->close($server,$request->fd);//主动断开之前连接*/
                }else{
                    //用redis保存user_id和fd的关系
                    $this->redis->hset("fd_hash", 'fd_' . $user_id, $request->fd);
                }
            }else{
                if($tokenOld !== $deviceToken2){
                    $returnDate['status']='success';
                    $returnDate['msg']='';
                    $returnDate['type']='off_line';
                    $returnDate['data']=[];
                    $offFd= $this->redis->hget("fd_hash", 'fd_' . $user_id);

                    $this->close($server,$offFd);//主动断开之前连接
                    $server->push($offFd, json_encode($returnDate));
                }
            }
        }else{


            if($request->get['autoLogin']) {
                //如果是自动登录
                if($tokenOld !== $deviceToken2){
                    $returnDate['status']='success';
                    $returnDate['msg']='';
                    $returnDate['type']='off_line';
                    $returnDate['data']=[];
                    $server->push($request->fd, json_encode($returnDate));
                    /* $this->close($server,$request->fd);//主动断开之前连接*/
                }else{
                    //用redis保存user_id和fd的关系
                    $this->redis->hset("fd_hash", 'fd_' . $user_id, $request->fd);

                }

            }else{
                //用redis保存user_id和fd的关系
                $this->redis->hset("fd_hash", 'fd_' . $user_id, $request->fd);
            }
        }


        if(!$request->get['autoLogin']) {
            //保存token 之前先判断是否已经存在相同token,有的话先删掉
            $sql = "UPDATE Survey_Surveyor SET msg_token='' and device_token = '' WHERE device_token='{$deviceToken2}'";
            $this->db->query($sql);
            //保存下 token-user_id 到用户表
            $sql = "UPDATE Survey_Surveyor SET msg_token='{$msg_token}',device_token = '{$deviceToken2}', deviceType='{$deviceType}' WHERE survId='{$user_id}'";
            $this->db->query($sql);
            //用redis保存user_id和fd的关系
            $this->redis->hset("fd_hash", 'fd_' . $user_id, $request->fd);
        }
    }

    /**
     * 即时聊天发送离线推送
     *
     * */
    public function offline_push($offArr,$info,$returnDate,$postId){

        //获取发送人的姓名
        $getUserNameSql="SELECT chiName,engName FROM Survey_Surveyor WHERE survId={$info->user_id} ";
        $user=mysqli_fetch_assoc($this->db->query($getUserNameSql));
        $chiName=$user['chiName'];
        $engName=$user['engName'];


        $off_user_id="";
        //将离线用户id整理成字符串
        for($i=0;$i<count($offArr);$i++){
            if($i===count($offArr)-1){
                $off_user_id.=$offArr[$i];
            }else{
                $off_user_id.=$offArr[$i].",";
            }
        }
        //获取离线用户的msg_token 和 设备类型
        $iosList=array();
        $androidList=array();

        //过滤重复的 token 避免发送多次推送
        $getTokenSql = "SELECT `survId`,`msg_token`,`deviceType` FROM Survey_Surveyor WHERE `survId` IN ({$off_user_id}) ";

        $tokenList=$this->db->query($getTokenSql);
        while ($re = mysqli_fetch_assoc($tokenList)) {
            if($re['deviceType']==1){
                //安卓
                $androidList[]=['user_id'=>$re['survId'],'msg_token'=>$re['msg_token']];
            }else if($re['deviceType']==2){
                //ios
                $iosList[]=['user_id'=>$re['survId'],'msg_token'=>$re['msg_token']];
            }
        }

        //进行离线推送
        if(!empty($androidList)){
            echo "===== Android 用户：".json_encode($androidList)."\n";
            foreach ($androidList as $v){
                $data=array();
                $data['msg_token']=$v['msg_token'];
                $data['ticker']="你有一条新消息";
                $data['title']=$info->jobNo!==$info->group_id?$info->group_name:$info-> group_name_up;
                $data['text']=strstr($chiName,$engName)?$chiName.":".$info->mss_content:$chiName."(".$engName."): ".$info->mss_content;//内容
                $data['description']="";

                if(!empty($v['msg_token'])){
                    $this->msgPush->sendAndroidUnicast($data);
                    //保存离线消息
                    $returnDate['is_push']=1;
                    $this->redis->select(1);
                    $this->redis->hset('unpush_info' . $v['user_id'],$postId, json_encode($returnDate));
                }

            }
        }

        if(!empty($iosList)){
            echo "==================== IOS 用户：".json_encode($iosList)."\n";
            foreach ($iosList as $v){
                $data=array();
                $data['msg_token']=$v['msg_token'];
                $data['ticker']="你有一条新消息";
                $data['title']=$info->jobNo!==$info->group_id?$info->group_name:$info-> group_name_up;
                $data['text']=strstr($chiName,$engName)?$chiName.":".$info->mss_content:$chiName."(".$engName."): ".$info->mss_content;//内容
                $data['description']="";

                $message = array();
                $message['data'] = array();
                $returnDate['is_push']=1;
                $message['data'][] = $returnDate;
                $message['type'] = 'msg';

                $data['message']=$message;//离线消息的自定义字段
                if(!empty($v['msg_token'])){
                    $this->ios_msgPush->sendIOSUnicast($data);
                    //保存离线消息
                    $returnDate['is_push']=1;
                    $this->redis->select(1);
                    $this->redis->hset('unpush_info' . $v['user_id'],$postId, json_encode($returnDate));
                }
            }
        }
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

        if($type == 'sendSuccess'){
            //发送成功后客户端返回回执，确认已收到
            $user_id = $info->user_id;
            $postId = $info->postId;
            $this->redis->select(1);
            if ($this->redis->exists('unpush_info' . $user_id)) {
                //清空当前未发送（未收到客户端回执）队列
                $this->redis->hdel('unpush_info' . $user_id,$postId);
            }

        }else{
            switch ($mode) {
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
                    $this->redis->select(0);
                    foreach ($arr as $value) {
                        if ($this->redis->hexists("fd_hash", 'fd_' . $value)) {
                            $onarr_tmp = array();
                            $onarr_tmp['fd'] = $this->redis->hget("fd_hash", 'fd_' . $value);
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

                    $sql = "INSERT INTO Survey_Msg(`msg_form`,`msg_to`,`group_id`,`jobNo`,`group_name`,`groups_ident`,`msg_content`,`send_time`,`msg_type`,`group_name_up`,`to_user_id`) VALUE
                    ('{$info->user_id}','{$info->to_user_id}','{$info->group_id}','{$info->jobNo}','{$info->group_name}','{$info->groups_ident}','{$info->mss_content}','{$timer}','{$info->type}','{$info->group_name_up}','{$info->to_user_id}')";
                    $this->db->query($sql);
                    $sqls = "SELECT LAST_INSERT_ID()";
                    $postId = mysqli_fetch_assoc($this->db->query($sqls))['LAST_INSERT_ID()'];

                    //拿到需要发送的消息
                    $returnDate = $this->returnDate($info, $timer, $postId);
                    if (!empty($onArr)) {
                        //在线的进行websocket发送
                        echo "==================== Websocket 发送：".json_encode($onArr)."\n";
                        foreach ($onArr as $v) {
                            $extra = ['status' => 'success', 'msg' => '', 'type'=>'msg','data' => [$returnDate]];

                            $this->redis->select(1);
                            $this->redis->hset('unpush_info' . $v['user_id'],$postId, json_encode($returnDate));
                            $server->push($v['fd'], json_encode($extra));
                        }
                    }
                    echo "==================== 离线推送：".json_encode($offArr)."\n";
                    if (!empty($offArr)) {
                        $this->offline_push($offArr,$info,$returnDate,$postId);
                    }
                    echo "====================================================END================================================= \n\n";
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
        $this->redis->select(0);
        $fdList = $this->redis->hgetall("fd_hash");

        echo "---------------------------------------------断开连接:\n";
        if(is_array($fdList) && !empty($fdList)){
            foreach ($fdList as $k => $v) {
                if ($v == $fd) {
                    $this->redis->hdel("fd_hash", $k);
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
        $this->redis->select(0);
        $this->redis->flushDB();
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

}

(new WebsocketServer)->start();