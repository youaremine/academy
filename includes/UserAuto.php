<?php

include("../includes/config.inc.php");

class UserAuto {

    private $type, $token, $user_id, $contact, $pass;
    public $chi_name, $eng_name, $surv_type, $avatar;
    private $surveyor = array();

    public function setInfo($type, $token, $user_id = null, $contact = null) {
        $this->type = $type;
        $this->token = $token;
        $this->user_id = $user_id;

    }

    public function setPass($pass) {
        $this->pass = $pass;
    }

    public function getPass() {
        return $this->pass;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function setContact($contact) {
        $this->contact = $contact;
    }

    public function getContact() {
        return $this->contact;
    }

    public function setUserInfo($chiName, $engName, $survType, $avatar = null) {
        $this->chi_name = $chiName;
        $this->eng_name = $engName;
        $this->surv_type = $survType;
        $this->avatar = $avatar;
    }

    /**验证第三方登录
     * @param null $type 默认值时通过类型和TOKEN判断是否存在账户   当不为空时通过id和类型判断是否存在账户
     * @return bool
     */
    public function verify($type = null) {
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
        if (!empty($type)) {
            $sqls = "SELECT
                    `user_id`
                    FROM
                     `Survey_User_Auth`
                    WHERE
                     `type` = '{$this->type}' AND `user_id` = '{$this->getUserId()}'
                     ";
            $info = $db->query($sqls);
            $data = mysqli_fetch_array($info);
            $num = mysqli_num_rows($info);
            if ($num > 0) {
                return true;
            } else {
                return false;
            }
        }else{
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
    }

    /**注册账户并存信息到用户表
     * @param $unimInfo 用户基本信息
     * @return array
     */
    public function register($unimInfo) {
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
        $sql = "INSERT INTO `Survey_Surveyor`(`chiName`,`engName`,`profilePhoto`,`contact`,`email`,`whatsAPP`,`remarks`,`survHome`,`birthday`,`dipaCode`,`vip_level`) 
        VALUE ('{$this->chi_name}','{$this->eng_name}','{$this->avatar}','{$this->getContact()}','{$unimInfo->email}','{$unimInfo->whatsAPP}','{$unimInfo->remarks}','{$unimInfo->survHome}','{$unimInfo->birthday}','{$unimInfo->dipaCode}','{$unimInfo->vip_level}')";
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
    public function bindUser() {
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
    public function inquire() {
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
        $sql = "SELECT `survId`FROM `Survey_Surveyor` WHERE `contact`='{$this->getContact()}'";
        $datas = $db->query($sql);
        $data = mysqli_fetch_array($datas);
        $num = mysqli_num_rows($datas);
        if ($num > 0) {
            $this->setUserId($data['survId']);
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
    public function SaveSession() {
        $_SESSION['surveyorId'] = $this->user_id;
        $_SESSION['surveyor'] = $this->surveyor;
    }

    /**获取用户密码
     * @param $userId 用户id(surveyorId)
     * @param $contact 手机号码
     * @return bool|false|mixed|string
     */
    protected function getUserPw($userId, $contact) {
        global $db;
        $edited = false;
        $sql = "SELECT password FROM Survey_SurveyorPassword WHERE survId = $userId";
        $datas = $db->query($sql);
        if ($data = mysqli_fetch_assoc($datas)) {
            $edited = $data['password'];
        }
        $firstPw = substr(substr($contact, 0, 4) * 666, 0, 3);
        $pw = $edited == false ? $firstPw : $edited;
        return $pw;
    }

    /**获取用户信息，前置条件需要设置userAuto对象的user_id
     * @return array 返回用户信息数组
     */
    public function inpuierUser() {
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
        $surveyor['dipaCode'] = '';//地区
        if (!empty($arr[0]['profilePhoto'])) {
            if (strpos($arr[0]['profilePhoto'], 'images/profile-photo')) {
                $surveyor['profilePhoto'] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . $surveyor['profilePhoto'];
            } else {
                $surveyor['profilePhoto'] = $arr[0]['profilePhoto'];
            }
        } else {
            $surveyor['profilePhoto'] = '';
        }
        //设置用户密码
       $surveyor['password'] = $this->getUserPw($this->getUserId(),$surveyor['contact']);
        $message = array(
            'status' => 'success',
            'msg' => '',
            'surveyor' => $surveyor,
            'state' => 'succeed'
        );
        return $message;
    }

//    /**
//     * @return false|string 获取初始化密码
//     */
//    function startPassword() {
//        $firstCheck = substr(substr($this->getContact(), 0, 4) * 666, 0, 3);
//        return $firstCheck;
//    }

    /**保存密码到数据表
     * @return array
     */
    function getPassword() {
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
        $sql = "INSERT INTO `Survey_SurveyorPassword`(`survId`,`password`) VALUE ('{$this->getUserId()}','{$this->getPass()}')";
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
}

