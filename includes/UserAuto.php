<?php

include_once("./config.inc.php");

class UserAuto{

    private  $type,$token,$user_id,$contact,$surveyor;
        public function __construct($type,$token,$user_id){
            $this->type=$type;
            $this->token=$token;
            $this->user_id=$user_id;
        }

    /**设置属性
     * @param $type 第三方账号类型
     * @param $token 第三方账号标识
     * @param null $user_id 用户ID
     * @param null $contact 用户电话
     */
        public function setInfo($type,$token,$user_id=null,$contact=null){
            $this->type=$type;
            $this->token=$token;
            $this->user_id=$user_id;
            $this->contact=$contact;
        }

    /**验证第三方登录
     * @return bool
     */
        public function verify(){
            global $conf;
            $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
            $sql="SELECT
                    COUNT(id) AS `num`
                    FROM
                     `survey_user_auth`
                    WHERE
                     `type` = '{$this->type}' AND `auto_token` = '{$this->token}'
                     ";
            $data=$db->query($sql);
            if($data['num']>0){
                return true;
            }else{
                return false;
            }
        }

    /**绑定第三方账号
     * @return bool
     */
        public function bindUser(){
            global $conf;
            $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
            $sql="INSERT INTO `survey_user_auth` VALUE `user_id`={$this->user_id},`contact`='{$this->contact}',`type`='{$this->type}',`auto_token`='{$this->token}'";
            $data=$db->query($sql);
            if ($data){
                return true;
            }else{
                return false;
            }

        }

    /**
     * 注册第三方账号
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
        $_SESSION['surveyor']=$this->surveyor;
    }

    /**获取账号信息
     * @return false|string 返回false或者json信息
     */
    public function inpuierUser(){
        global $conf;
        $db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
       $sql="SELECT * FROM `Survey_Surveyor` WHERE  `contact`='{$this->contact}'";
       $data=$db->query($sql);
       return json_encode($data,JSON_UNESCAPED_UNICODE);
    }
}

