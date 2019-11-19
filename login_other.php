<?php

include_once ("./includes/config.inc.php");

class LoginOauth {
	public $type = 1;
	public $db;
	public $oauth_userId;
	public $user ;
	public $errorText = '';//TODO 错误信息
	public $res = false;

	public function __construct($type,$identifier,$db)
	{
		$this->user = (object)array();
		$this->type = $type;
		$this->db = new DataBase($db);
		$this->oauth_userId = $this->oauth_userId($type,$identifier);
		if($this->oauth_userId){//已经绑定的用户
			$existedRes = $this->existedFoo($this->oauth_userId);
		}else{
			$unExistedRes = $this->unExistedFoo();
			echo '未绑定用户';
			exit;
		}

		if($existedRes === true ){
			header ( "Location:index.php" );
		}else{//TODO 未找到第三方登录所绑定的对应用户
            echo 'User Not Found';
        }

	}

	public function existedFoo($oauth_userId){
		$sql = "SELECT * FROM  Survey_Users " . "WHERE userId = ".$oauth_userId;
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () )
		{
			$this->user->userId = $rs ['userId'];
			$this->user->userName = $rs ['userName'];
			$this->user->chiName = $rs ['chiName'];
			$this->user->engName = $rs ['engName'];
			$this->user->age = $rs ['age'];
			$this->user->sex = $rs ['sex'];
			$this->user->moblie = $rs ['moblie'];
			$this->user->telephone = $rs ['telephone'];
			$this->user->eMail = $rs ['eMail'];
			$this->user->lastLoginTime = $rs ['lastLoginTime'];
			$this->user->loginTimes = $rs ['loginTimes'];
			$this->user->updateDate = $rs ['updateDate'];
			$this->user->createDate = $rs ['createDate'];
			$this->user->userRemark = $rs ['userRemark'];
			$this->user->userHome = $rs ['userHome'];
			$this->user->doDistrict = $rs ['doDistrict'];
			$this->user->dipaId = $rs ['dipaId'];
			$this->user->delFlag = $rs ['delFlag'];
			$this->user->groupId = $rs ['groupId'];
			$this->user->updatePasswordTime = $rs ['updatePasswordTime'];
			$this->user->doCompany = $rs ['doCompany'];
			// 得到用户权限
			$this->GetPermission ($this->oauth_userId);
			// 兼容舊的權限控制抽空再改
			$this->GetRole ($this->oauth_userId);
			// 将登录后的信息保存到session.
			$this->SaveSession ();
			// 写登录日志
			$this->AddLog ( 'Login' );
			// 删除已经存在的在线信息
			$this->DeleteUserOnline ();
			// 更新在线用户表
			$this->UpdateUserOnline ();
			// 登录后，添加登录的一些信息
			$u = new Users ( $this->db );
			$u->userId = $this->user->userId;
			$u->lastLoginTime = date ( 'Y-m-d H:i:s' );
			$u->AddLastLogin ();
			return true;
		}
	}

	/**
	 * 添加到在线用户列表中
	 *
	 * @access private
	 */
	function UpdateUserOnline()
	{
		global $conf;
		$uo = new UserOnline ();
		$uo->userId = $_SESSION ['userId'];
		$uo->activeTime = date ( $conf ['dateTime'] ['format'] );
		$uo->groupId = $_SESSION ['groupId'];
		$uoa = new UserOnlineAccess ( $this->db );
		return $uoa->Add ( $uo );
	}

	/**
	 * 删除已经存在的在线信息
	 *
	 * @access private
	 * @return unknown_type
	 */
	function DeleteUserOnline()
	{
		$uo = new UserOnline ();
		$uo->userId = $_SESSION ['userId'];
		$uoa = new UserOnlineAccess ( $this->db );
		$uoa->RealDel ( $uo );
	}


	/**
	 * 添加登录日志
	 *
	 * @access private
	 * @param $action:登录类型，Login 或者
	 *        	Logout
	 */
	function AddLog($action)
	{
		global $conf;
		$uh = new UserHistory ();
		$uha = new UserHistoryAccess ( $this->db );
		$uh->type = 'User';
		$uh->action = $action;
		$uh->userId = $_SESSION ['userId'];
		$uh->endTime = date ( $conf ['dateTime'] ['format'] );
		$uh->loginIp = getenv ( 'REMOTE_ADDR' );
		$uha->Add ( $uh );
	}


	/**
	 * 将登录后的信息保存到session.
	 *
	 * @access private
	 */
	function SaveSession()
	{
		$_SESSION ['userId'] = $this->user->userId;
		// $_SESSION['userName'] = $this->userName;
		$_SESSION ['permId'] = $this->user->permId;
		$_SESSION ['permCodes'] = $this->user->permCodes;
		$_SESSION ['userEngName'] = $this->user->engName;
		$_SESSION ['userChiName'] = $this->user->chiName;
		$_SESSION ['doDistrict'] = $this->user->doDistrict;
		$_SESSION ['groupId'] = $this->user->groupId;
		$_SESSION ['doCompany'] = $this->user->doCompany;
		// print '$_SESSION[userName]:'.$_SESSION['userName'];
	}

	/**
	 * 兼容舊的權限控制,返回用戶的角色
	 *
	 * @access private
	 */
	public function GetRole($userId)
	{
		$sql = "SELECT * FROM Survey_UserRole
			WHERE userId = '{$userId}'";
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () )
		{
			$this->user->permId = $rs ["roleId"];
		}
	}

	public function GetPermission($userId)
	{
		$sql = "SELECT p.* FROM Survey_Permission p
			INNER JOIN Survey_RolePermission rp ON rp.permId = p.permId
			INNER JOIN Survey_UserRole ur ON ur.roleId = rp.roleId
			WHERE ur.userId = '{$userId}'";
		$this->db->query ( $sql );
		$permCodes = array ();
		while ( $rs = $this->db->next_record () )
		{
			$permCodes [] = $rs ["permCode"];
		}
		$this->user->permCodes = $permCodes;
	}

	//TODO 未绑定用户对应操作
	public function unExistedFoo(){
        return false;
	}

	//第三方登录用户所对应的userId
	public function oauth_userId($type,$identifier){
		$sql = "SELECT userId from survey_user_auth where auth_type = ".$type." and identifier = ".$identifier .' Limit 0,1';
		$this->db->query($sql);
		while($res = $this->db->next_record () ){
			return $res['userId'];
		}
	}

	public function addUser(){
		$sql = "";

	}

	public function addUserAuth(){
		$sql = "";


	}
}



$type = $_GET['type'];
$identifier = $_GET['identifier'];
$a = new LoginOauth($type,$identifier,$conf["dbConnectStr"]["BusSurvey"]);


