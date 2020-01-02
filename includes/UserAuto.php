<?php

include("../includes/config.inc.php");

class UserAuto{

    private $type, $token, $user_id, $contact;
    public $chi_name, $eng_name, $surv_type, $avatar;
    private $surveyor = array();

    public function setInfo($type, $token, $user_id = null, $contact = null){
        $this->type = $type;
        $this->token = $token;
        $this->user_id = $user_id;

    }

    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function setContact($contact){
        $this->contact = $contact;
    }

    public function getContact(){
        return $this->contact;
    }

    public function setUserInfo($chiName, $engName, $survType, $avatar){
        $this->chi_name = $chiName;
        $this->eng_name = $engName;
        $this->surv_type = $survType;
        $this->avatar = $avatar;
    }

    /**验证第三方登录
     * @return bool
     */
    public function verify(){
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
        $sql = "SELECT
                    `user_id`
                    FROM
                     `Survey_User_Auth`
                    WHERE
                     `type` = '{$this->type}' AND `auto_token` = '{$this->token}'
                     ";
        $datas = $db->query($sql);
        $data = mysqli_fetch_array($datas);
        $num = mysqli_num_rows($datas);
        if ($num > 0) {
            $this->setUserId($data['user_id']);
            return true;
        } else {
            return false;
        }
    }

    /**
     * 注册账户并存信息到用户表
     */
    public function register(){
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
        $sql = "INSERT INTO `Survey_Surveyor`(`chiName`,`engName`,`profilePhoto`,`contact`) VALUE ('{$this->chi_name}','{$this->eng_name}','{$this->avatar}','{$this->getContact()}')";
        $data = $db->query($sql);
        if ($data) {
            return $this->inquire();
        } else {
            $arr = array(
                'state' => false,
                'info' => ''
            );
            return $arr;
        }
    }

    /**写入第三方账号信息
     * @return bool
     */
    public function bindUser(){
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
        $sql = "INSERT INTO `Survey_User_Auth`(`user_id`,`type`,`auto_token`) VALUE ('{$this->getUserId()}','{$this->type}','{$this->token}')";
        $data = $db->query($sql);
        if ($data) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * 查询手机是否为原先账户,是则返回用户ID
     */
    public function inquire(){
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
        $sql = "SELECT `survId`FROM `Survey_Surveyor` WHERE `contact`='{$this->getContact()}'";
        $datas = $db->query($sql);
        $data = mysqli_fetch_array($datas);
        $num = mysqli_num_rows($datas);
        if ($num > 0) {
            $this->setUserId($data['user_id']);
            $arr = array(
                'state' => true,
                'info' => $data
            );
            return $arr;
        } else {
            $arr = array(
                'state' => false,
                'info' => ''
            );
            return $arr;
        }
    }

    /**
     * 将登录后的信息保存到session.
     *
     * @access private
     */
    public function SaveSession(){
        $_SESSION['surveyorId'] = $this->user_id;
        $_SESSION['surveyor'] = $this->surveyor;
    }

    /**登陆成功后获取账户信息
     * @return array 返回用户信息数组
     */
    public function inpuierUser($type = null){
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
        $sql = "SELECT
    s.*,
    u.engName AS inputUsername,
    u2.engName AS updateUsername
FROM
    Survey_Surveyor s
LEFT JOIN Survey_Users u ON
    s.inputUserId = u.userId
LEFT JOIN Survey_Users u2 ON
    s.updateUserId = u2.userId
WHERE
    1 = 1 AND s.survId ='{$this->getUserId()}'";
        $datas = $db->query($sql);

        while ($data = mysqli_fetch_assoc($datas)) {
            $arr[] = $data;
        }
        $surveyor['survId'] = $arr[0]['survId'];
        $surveyor['upSurvId'] = $arr[0]['upSurvId'];
        $surveyor['chiName'] = $arr[0]['chiName'];
        $surveyor['engName'] = $arr[0]['engName'];
        $surveyor['contact'] = $arr[0]['contact'];
        $surveyor['survType'] = $arr[0]['survType'];
        $surveyor['vip_level'] = $arr[0]['vip_level'];
        $surveyor['dipaCode']='';//地区
        if(!empty($arr[0]['profilePhoto'])){
            if(strpos($arr[0]['profilePhoto'],'images/profile-photo')){
                $surveyor['profilePhoto'] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.$surveyor['profilePhoto'];
            }else{
                $surveyor['profilePhoto']=$arr[0]['profilePhoto'];
            }
        }else {
            $surveyor['profilePhoto'] = '';
        }
        if (!empty($type)) {
            $surveyor['password'] = $this->startPassword();
        } else {
            $surveyor['password'] = '';
        }
        $message = array(
            'status' => 'success',
            'msg' => '',
            'surveyor' => $surveyor,
            'state' => 'succeed'
        );
        return $message;
    }

    /**
     * @return false|string 获取初始化密码
     */
    function startPassword(){
        $firstCheck = substr(substr($this->getContact(), 0, 4) * 666, 0, 3);
        return $firstCheck;
    }
}
//
//$user=new UserAuto();
//$user->setUserId(30);
//$user->inpuierUser();
