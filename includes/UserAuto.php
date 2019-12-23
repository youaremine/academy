<?php

include_once("./config.inc.php");

class UserAuto{

    private  $type,$token,$user_id;
        public function __construct($type,$token,$user_id){
            $this->type=$type;
            $this->token=$token;
            $this->user_id=$user_id;
        }
        public function setInfo($type,$token,$user_id=null){
            $this->type=$type;
            $this->token=$token;
            $this->user_id=$user_id;
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
            $sql="INSERT INTO `survey_user_auth` VALUE `contact`='{$this->user_id}',`type`='{$this->type}',`auto_token`='{$this->token}'";
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
}

