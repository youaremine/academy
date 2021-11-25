<?php
require_once(dirname(__FILE__) . '/' . 'notification/android/AndroidBroadcast.php');
require_once(dirname(__FILE__) . '/' . 'notification/android/AndroidFilecast.php');
require_once(dirname(__FILE__) . '/' . 'notification/android/AndroidGroupcast.php');
require_once(dirname(__FILE__) . '/' . 'notification/android/AndroidUnicast.php');
require_once(dirname(__FILE__) . '/' . 'notification/android/AndroidCustomizedcast.php');
require_once(dirname(__FILE__) . '/' . 'notification/ios/IOSBroadcast.php');
require_once(dirname(__FILE__) . '/' . 'notification/ios/IOSFilecast.php');
require_once(dirname(__FILE__) . '/' . 'notification/ios/IOSGroupcast.php');
require_once(dirname(__FILE__) . '/' . 'notification/ios/IOSUnicast.php');
require_once(dirname(__FILE__) . '/' . 'notification/ios/IOSCustomizedcast.php');

class MsgPush {

    protected $android_key = '6135c5aaa8f28d032f1f38b9';
    protected $android_secret = 'l0vcj2wpnpnfe3ijpx8kakcid5d0rrne';
    protected $ios_key = '618104a0abbb3d51d850f7f9';
    protected $ios_secret = 'i05cf8wbkbjw009pzca58fzbwuvqvepu';

    protected $appkey           = NULL;
    protected $appMasterSecret     = NULL;
    protected $timestamp        = NULL;
    protected $validation_token = NULL;

    function __construct($type = 'android') {
        if($type == 'android'){
            $this->appkey = $this->android_key;
            $this->appMasterSecret = $this->android_secret;
        }else{
            $this->appkey = $this->ios_key;
            $this->appMasterSecret = $this->ios_secret;
        }

    }

    /**
     * 安卓 广播推送
     */
    function sendAndroidBroadcast($data) {
        try {
            $brocast = new AndroidBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue("appkey",           $this->appkey);
            $brocast->setPredefinedKeyValue("timestamp",         strval(time()));
            $brocast->setPredefinedKeyValue("ticker",          $data['ticker']);//通知栏提示文字
            $brocast->setPredefinedKeyValue("title",            $data['title']);//通知栏标题
            $brocast->setPredefinedKeyValue("text",             $data['text']);
            $brocast->setPredefinedKeyValue("after_open",       "go_app");
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $brocast->setPredefinedKeyValue("production_mode", "true");
            // [optional]Set extra fields
            $puth_type = $data['push_type'] == 'other'?'other':'msg';
            $brocast->setExtraField("push_type", $puth_type);
//            print("Sending broadcast notification, please wait...\r\n");
            $brocast->send();
//            print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught sendAndroidBroadcast exception: " . $e->getMessage());
        }
    }

    /**$data
     * @param $data 传输的信息
     */
    function sendAndroidUnicast($data) {
        try {
            $unicast = new AndroidUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue("appkey",           $this->appkey);
            $unicast->setPredefinedKeyValue("timestamp",        strval(time()));
            // Set your device tokens here
            $unicast->setPredefinedKeyValue("device_tokens",    $data['msg_token']);//msg_token
            $unicast->setPredefinedKeyValue("ticker",          $data['ticker']);//通知栏提示文字
            $unicast->setPredefinedKeyValue("title",            $data['title']);//通知栏标题
            $unicast->setPredefinedKeyValue("text",             $data['text']);

            $unicast->setPredefinedKeyValue("after_open",       "go_app");

            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $unicast->setPredefinedKeyValue("production_mode", false);
            //新增参数
            $unicast->setPredefinedKeyValue("play_vibrate",false);
            $unicast->setPredefinedKeyValue("play_lights", "false");
            $unicast->setPredefinedKeyValue("play_sound", true);
            $unicast->setPredefinedKeyValue("description", $data['description']);//消息描述
            $unicast->setPredefinedKeyValue("display_type","notification");

  //          $unicast->setPredefinedKeyValue("mi_activity","com.ozzo.interacademy.ui.start.OzzoStartActivity");//厂商识别
            $unicast->setPredefinedKeyValue("mi_activity","com.ozzo.ofaa.mfr.MfrMessageActivity");//厂商识别
            $unicast->setPredefinedKeyValue("mipush",true);
            $puth_type = $data['push_type'] == 'other'?'other':'msg';
            $unicast->setExtraField("push_type", $puth_type);
            $unicast->setExtraField("postId", $data['message']['data'][0]['postId']);

            if($data['message']['data'][0]['mode'] = 2){
                $unicast->setExtraField("jobNo", $data['message']['data'][0]['jobNo']);
                $unicast->setExtraField("jobNoNew", $data['message']['data'][0]['jobNoNew']);
            }else{
                $unicast->setExtraField("matchId", $data['message']['data'][0]['group_id']);
            }




            // Set extra fields

//            print("Sending unicast notification, please wait...\r\n");
            $unicast->send();
//            print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught sendAndroidUnicast exception: " . $e->getMessage());
        }
    }

    function sendAndroidFilecast() {
        try {
            $filecast = new AndroidFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue("appkey",           $this->appkey);
            $filecast->setPredefinedKeyValue("timestamp",        $this->timestamp);
            $filecast->setPredefinedKeyValue("ticker",           "Android filecast ticker");
            $filecast->setPredefinedKeyValue("title",            "Android filecast title");
            $filecast->setPredefinedKeyValue("text",             "Android filecast text");
            $filecast->setPredefinedKeyValue("after_open",       "go_app");  //go to app
            print("Uploading file contents, please wait...\r\n");
            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
            $filecast->uploadContents("aa"."\n"."bb");
            print("Sending filecast notification, please wait...\r\n");
            $filecast->send();
            print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }

    function sendAndroidGroupcast() {
        try {
            /*
              *  Construct the filter condition:
              *  "where":
              *	{
              *		"and":
              *		[
                *			{"tag":"test"},
                *			{"tag":"Test"}
              *		]
              *	}
              */
            $filter = 	array(
                "where" => 	array(
                    "and" 	=>  array(
                        array(
                            "tag" => "test"
                        ),
                        array(
                            "tag" => "Test"
                        )
                    )
                )
            );

            $groupcast = new AndroidGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue("appkey",           $this->appkey);
            $groupcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue("filter",           $filter);
            $groupcast->setPredefinedKeyValue("ticker",           "Android groupcast ticker");
            $groupcast->setPredefinedKeyValue("title",            "Android groupcast title");
            $groupcast->setPredefinedKeyValue("text",             "Android groupcast text");
            $groupcast->setPredefinedKeyValue("after_open",       "go_app");
            // Set 'production_mode' to 'false' if it's a test device.
            // For how to register a test device, please see the developer doc.
            $groupcast->setPredefinedKeyValue("production_mode", "true");
            print("Sending groupcast notification, please wait...\r\n");
            $groupcast->send();
            print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }

    function sendAndroidCustomizedcast() {
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey",           $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->setPredefinedKeyValue("alias",            "xx");
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue("alias_type",       "xx");
            $customizedcast->setPredefinedKeyValue("ticker",           "Android customizedcast ticker");
            $customizedcast->setPredefinedKeyValue("title",            "Android customizedcast title");
            $customizedcast->setPredefinedKeyValue("text",             "Android customizedcast text");
            $customizedcast->setPredefinedKeyValue("after_open",       "go_app");
            print("Sending customizedcast notification, please wait...\r\n");
            $customizedcast->send();
            print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }

    function sendAndroidCustomizedcastFileId() {
        try {
            $customizedcast = new AndroidCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey",           $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
            // if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->uploadContents("aa"."\n"."bb");
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue("alias_type",       "xx");
            $customizedcast->setPredefinedKeyValue("ticker",           "Android customizedcast ticker");
            $customizedcast->setPredefinedKeyValue("title",            "Android customizedcast title");
            $customizedcast->setPredefinedKeyValue("text",             "Android customizedcast text");
            $customizedcast->setPredefinedKeyValue("after_open",       "go_app");
            print("Sending customizedcast notification, please wait...\r\n");
            $customizedcast->send();
            print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }

    function sendIOSBroadcast($data) {
        try {
            $brocast = new IOSBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue("appkey",           $this->appkey);


            $brocast->setPredefinedKeyValue("timestamp",        strval(time()));

            $brocast->setPredefinedKeyValue("alert", $data['text']);
            $brocast->setPredefinedKeyValue("badge", 0);
            $brocast->setPredefinedKeyValue("sound", "chime");
            // Set 'production_mode' to 'true' if your app is under production mode
            $brocast->setPredefinedKeyValue("production_mode", true);
            // Set customized fields
            if(isset($data['message'])){
                if(isset($data['message']['type'])){
                    $data['message']['type'] = $data['message']['type'] == 'other'?'other':'msg';
                }
            }
            $brocast->setCustomizedField("message", $data['message']);


            $brocast->send();
        } catch (Exception $e) {
            print("Caught sendIOSBroadcast exception: " . $e->getMessage());
        }
    }

    function sendIOSUnicast($data) {

        try {
            $unicast = new IOSUnicast();
            $unicast->setAppMasterSecret($this->appMasterSecret);
            $unicast->setPredefinedKeyValue("appkey",           $this->appkey);
            $unicast->setPredefinedKeyValue("timestamp",        strval(time()));
            // Set your device tokens here
            $unicast->setPredefinedKeyValue("device_tokens",   $data['msg_token']);

            $alert_arr = array();
            $alert_arr['title'] = $data['title'];
            $alert_arr['subtitle'] = '';
            $alert_arr['body'] = $data['text'];
            $unicast->setPredefinedKeyValue("alert",$alert_arr);
            $unicast->setPredefinedKeyValue("badge", '+1');
            $unicast->setPredefinedKeyValue("sound", "defautl");
            // Set 'production_mode' to 'true' if your app is under production mode
            $unicast->setPredefinedKeyValue("production_mode", true);
            // Set customized fields
            if(isset($data['message']) && !empty($data['message'])){
                if(isset($data['message']['type'])){
                    $data['message']['type'] = $data['message']['type'] == 'other'?'other':'msg';
                }
            }else{
                $data['message'] = '';
            }
            $unicast->setCustomizedField("message", $data['message']);
            //print("Sending unicast notification, please wait...\r\n");
            $unicast->send();
            //print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught sendIOSUnicast exception: " . $e->getMessage());
        }
    }

    function sendIOSFilecast() {
        try {
            $filecast = new IOSFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue("appkey",           $this->appkey);
            $filecast->setPredefinedKeyValue("timestamp",        $this->timestamp);

            $filecast->setPredefinedKeyValue("alert", "IOS 文件播测试");
            $filecast->setPredefinedKeyValue("badge", 0);
            $filecast->setPredefinedKeyValue("sound", "chime");
            // Set 'production_mode' to 'true' if your app is under production mode
            $filecast->setPredefinedKeyValue("production_mode", true);
            print("Uploading file contents, please wait...\r\n");
            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
            $filecast->uploadContents("aa"."\n"."bb");
            print("Sending filecast notification, please wait...\r\n");
            $filecast->send();
            print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }

    function sendIOSGroupcast() {
        try {
            $filter = 	array(
                "where" => 	array(
                    "and" 	=>  array(
                        array(
                            "tag" => "iostest"
                        )
                    )
                )
            );

            $groupcast = new IOSGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue("appkey",           $this->appkey);
            $groupcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue("filter",           $filter);
            $groupcast->setPredefinedKeyValue("alert", "IOS 组播测试");
            $groupcast->setPredefinedKeyValue("badge", 0);
            $groupcast->setPredefinedKeyValue("sound", "chime");
            // Set 'production_mode' to 'true' if your app is under production mode
            $groupcast->setPredefinedKeyValue("production_mode", "true");
            print("Sending groupcast notification, please wait...\r\n");
            $groupcast->send();
            print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }

    function sendIOSCustomizedcast() {
        try {
            $customizedcast = new IOSCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey",           $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp",        $this->timestamp);

            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->setPredefinedKeyValue("alias", "xx");
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue("alias_type", "xx");
            $customizedcast->setPredefinedKeyValue("alert", "IOS 个性化测试");
            $customizedcast->setPredefinedKeyValue("badge", 0);
            $customizedcast->setPredefinedKeyValue("sound", "chime");
            // Set 'production_mode' to 'true' if your app is under production mode
            $customizedcast->setPredefinedKeyValue("production_mode", "true");
            print("Sending customizedcast notification, please wait...\r\n");
            $customizedcast->send();
            print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            print("Caught exception: " . $e->getMessage());
        }
    }
}