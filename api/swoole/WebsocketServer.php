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



    public function __construct() {
        global $conf;
        $this->server = new Websocket\Server($this->host, $this->port);
        echo swoole_get_local_ip()['eth0'] . ":" . $this->port . " Websocket服务启动成功\n";
        $this->db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);//初始化数据库
        $this->onInit();//初始化注册事件
        $this->msgPush = new MsgPush("5caacd2661f564547b000d50", "bzxrxjmxgvlqtuwzrhiysniywl3k87yv");//初始化离线推送
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
        echo "接收到user_id:" . $request->get['user_id'] . "\n";//通过get方式传递参数 用户ID
        echo "接收到msg_token:" . $request->get['deviceToken'] . "\n";//通过ge方式传递参数，设备token
        echo "接收到deviceType:" . $request->get['deviceType'] . "\n";//设备类型 1是安卓 2是IOS(消息推送调用的不同方法)


        $user_id = $request->get['user_id'];
        $msg_token = $request->get['deviceToken'];
        $deviceType = $request->get['deviceType'];

        $sqlOld="SELECT msg_token FROM Survey_Surveyor WHERE survId='{$user_id}'";
        $tokenOldSql=$this->db->query($sqlOld);
        $tokenOld=mysqli_fetch_assoc($tokenOldSql)['msg_token'];//获取之前的token


        //保存token 之前先判断是否已经存在相同token,有的话先删掉
        $sql = "UPDATE Survey_Surveyor SET msg_token='' WHERE msg_token='{$msg_token}'";
        $this->db->query($sql);

        //保存下 token-user_id 到用户表
        $sql = "UPDATE Survey_Surveyor SET msg_token='{$msg_token}',deviceType='{$deviceType}' WHERE survId='{$user_id}'";
        $this->db->query($sql);

        //判断如果存在此用户，且登录的设备不同，给原先设备连接发送离线通知
        if($this->redis->hexists("fd_hash", 'fd_' . $user_id)){
            $offFd= $this->redis->hget("fd_hash", 'fd_' . $user_id);
            $this->close($server,$offFd);//主动断开之前连接
            if($tokenOld !== $msg_token){
                $returnDate['status']='success';
                $returnDate['msg']='';
                $returnDate['type']='off_line';
                $returnDate['data']=[];
                $server->push($offFd, json_encode($returnDate));
            }
        }

        //用redis保存user_id和fd的关系
        $this->redis->hset("fd_hash", 'fd_' . $user_id, $request->fd);

        //存在离线消息，进行推送
        if ($this->redis->exists('off_info' . $user_id)) {
            //获取redis当前队列里面所有的值
            $pushInfo = $this->redis->lrange('off_info' . $user_id,0,-1);
            $returnDate=array();
            $returnDate['status']='success';
            $returnDate['msg']='';
            $returnDate['type']='msg';
            $returnDate['data']=[];
            foreach ($pushInfo as $v){
                $returnDate['data'][]=json_decode($v,true);
            }
            //推送消息
            $server->push($request->fd, json_encode($returnDate));
            //清空当前队列
            $this->redis->del('off_info' . $user_id);
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

        switch ($mode) {
            //私聊
            case 1:
                //私聊功能暂时不需要开发
                break;

            //群发
            case 2:
                $arr = $this->getSendUser($info);//所有要发送的名单

                echo "收到的信息".$info->mss_content."\n";

                //将在线和离线的分开
                $onArr = array();//在线
                $offArr = array();//离线
                foreach ($arr as $value) {
                    if ($this->redis->hexists("fd_hash", 'fd_' . $value)) {
                        $onArr[] = $this->redis->hget("fd_hash", 'fd_' . $value);
                    } else {
                        //不在线的
                        $offArr[] = $value;
                    }
                }

                //写入信息到数据库消息记录
                $sql = "INSERT INTO Survey_Msg(`msg_form`,`msg_to`,`group_id`,`jobNo`,`group_name`,`groups_ident`,`msg_content`,`send_time`,`msg_type`,`group_name_up`) VALUE
                    ('{$info->user_id}','{$info->to_user_id}','{$info->group_id}','{$info->jobNo}','{$info->group_name}','{$info->groups_ident}','{$info->mss_content}','{$timer}','{$info->type}','{$info->group_name_up}')";
                $this->db->query($sql);
                $sqls = "SELECT LAST_INSERT_ID()";
                $postId = mysqli_fetch_assoc($this->db->query($sqls))['LAST_INSERT_ID()'];

                //拿到需要发送的消息
                $returnDate = $this->returnDate($info, $timer, $postId);

                if (!empty($onArr)) {
                    //在线的进行websocket发送
                    foreach ($onArr as $v) {
                        $extra = ['status' => 'success', 'msg' => '', 'type'=>'msg','data' => [$returnDate]];
                        $server->push($v, json_encode($extra));
                    }
                }

                if (!empty($offArr)) {
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
                    $getTokenSql = "SELECT `survId`,`msg_token`,`deviceType` FROM Survey_Surveyor WHERE `survId` IN ({$off_user_id}) AND `msg_token`!=''";

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

                        echo "====Start====";
                        echo "\n";
                        echo 'From:'.$engName."\n".'TO:'.json_encode($androidList);
                        echo "\n";
                        echo "====End======";


                        foreach ($androidList as $v){
                            $data=array();
                            $data['msg_token']=$v['msg_token'];
                            $data['ticker']="你有一条新消息";
                            $data['title']=$info->jobNo!==$info->group_id?$info->group_name:$info-> group_name_up;
                            $data['text']=strstr($chiName,$engName)?$chiName.":".$info->mss_content:$chiName."(".$engName."): ".$info->mss_content;//内容
                            $data['description']="";
                            $this->msgPush->sendAndroidUnicast($data);
                            //保存离线消息
                            $returnDate['is_push']=1;
                            $this->redis->rpush('off_info' . $v['user_id'], json_encode($returnDate));
                        }
                    }

                    if(!empty($iosList)){
                        //ios暂时还未写，需调整发送的格式,先修改方法中要使用的参数
//                        $this->msgPush->sendIOSUnicast($data);
                    }

                }
                break;
            default:
                break;
        }
    }

    /**断开连接回调事件
     * @param $server
     * @param $fd
     */
    public function close($server, $fd) {
        //离线 需要删除对应的数据
        $fdList = $this->redis->hgetall("fd_hash");
        foreach ($fdList as $k => $v) {
            if ($v == $fd) {
                $this->redis->hdel("fd_hash", $k);
            }
        }

        echo "断开连接: {$fd}\n";
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
        $arr['profilePhoto'] = $data['profilePhoto'];
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
        return $arr;
    }

    /**获取消息需要发送到的名单
     * @param $info
     * @return array
     */
    public function getSendUser($info) {
        $arr = array();
        //查询选择课堂的用户
        if ($info->jobNo === $info->group_id) {
            $sql = "SELECT `surveyorCode` FROM Survey_MainSchedule WHERE `jobNo`='{$info->group_id}' AND `surveyorCode` != '' GROUP BY `surveyorCode`";
        } else {
            $sql = "SELECT `surveyorCode` FROM Survey_MainSchedule WHERE `jobNoNew`='{$info->group_id}' AND `surveyorCode` != '' GROUP BY `surveyorCode`";
        }

        //保存所有选择课堂的用户id
        $sqlInfo = $this->db->query($sql);
        while ($data = mysqli_fetch_assoc($sqlInfo)) {
            $arr[] = $data['surveyorCode'];
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