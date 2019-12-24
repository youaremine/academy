<?php

include("../includes/config.inc.php");
class UserAuto
{

    private $type, $token, $user_id, $surveyor;

    public function setInfo($type, $token, $user_id = null){
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
    /**验证第三方登录
     * @return bool
     */
    public function verify()
    {
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
        $data=mysqli_fetch_array($datas);
        $num=mysqli_num_rows($datas);
        if ($num > 0) {
            $this->setUserId($data['user_id']);
            $arr=array(
                'status'=>true,
                'info'=>$data
            );
            return $arr;
        } else {
            return false;
        }
    }

    /**绑定第三方账号
     * @return bool
     */
    public function bindUser()
    {
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
        $sql = "INSERT INTO `Survey_User_Auth` VALUE `user_id`='{$this->user_id}',`type`='{$this->type}',`auto_token`='{$this->token}'";
        $data = $db->query($sql);
        if ($data) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * 查询手机是否为原先账户
     */
    public function register(){

    }

    /**
     * 将登录后的信息保存到session.
     *
     * @access private
     */
    public function SaveSession()
    {
        $_SESSION['surveyorId'] = $this->user_id;
        $_SESSION['surveyor'] = $this->surveyor;
    }

    /**登陆成功后获取账户信息
     * @return array 返回用户信息数组
     */
    public function inpuierUser(){
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
        $surveyor['dipaCode'] = $arr[0]['dipaCode'];
        $surveyor['survType'] = $arr[0]['survType'];
        $surveyor['profilePhoto'] = $arr[0]['profilePhoto'];
        $surveyor['vip_level'] = $arr[0]['vip_level'];
        $message = array (
            'status' => 'success',
            'msg' => '',
            'surveyor' => $surveyor
        );
        return $message;
    }
}

