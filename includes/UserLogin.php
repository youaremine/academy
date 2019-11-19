<?php
/*
 * Header: 
 * Create: 2007-2-17 
 * Auther: Jamblues.
 */
class UserLogin
{
	var $db;
	var $userName;
	var $passWord;
	var $user;
	function UserLogin($db)
	{
		$this->db = $db;
		$this->user = new Users ( $this->db );
	}
	
	/**
	 * 用户登录
	 *
	 * @access public
	 */
	function Login($userName, $passWord)
	{
		global $conf;
		$this->userName = $userName;
		$this->passWord = $passWord;
		
		$sql = "SELECT * FROM  Survey_Users " . "WHERE userName='" . $this->userName . "'" . "  AND passWord='" . $this->passWord . "'" . "  AND  validLoginTime>'" . date ( "Y-m-d" ) . "'";
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
			$this->GetPermission ();
			// 兼容舊的權限控制抽空再改
			$this->GetRole ();
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
			$u->lastLoginTime = date ( $conf ['dateTime'] ['format'] );
			$u->AddLastLogin ();
			
			return true;
		}
		return false;
	}
	
	/**
	 * 返回登录用户的权限
	 *
	 * @access private
	 */
	function GetPermission()
	{
		$sql = "SELECT p.* FROM Survey_Permission p
			INNER JOIN Survey_RolePermission rp ON rp.permId = p.permId
			INNER JOIN Survey_UserRole ur ON ur.roleId = rp.roleId
			WHERE ur.userId = '{$this->user->userId}'";
		$this->db->query ( $sql );
		$permCodes = array ();
		while ( $rs = $this->db->next_record () )
		{
			$permCodes [] = $rs ["permCode"];
		}
		$this->user->permCodes = $permCodes;
	}
	
	/**
	 * 兼容舊的權限控制,返回用戶的角色
	 *
	 * @access private
	 */
	function GetRole()
	{
		$sql = "SELECT * FROM Survey_UserRole
			WHERE userId = '{$this->user->userId}'";
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () )
		{
			$this->user->permId = $rs ["roleId"];
		}
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
	 * 清除所有session
	 *
	 * @access public
	 */
	function Logout()
	{
		$this->AddLog ( 'Logout' );
		unset ( $_SESSION ['userId'] );
		unset ( $_SESSION ['permId'] );
		unset ( $_SESSION ['permCodes'] );
		unset ( $_SESSION ['userEngName'] );
		unset ( $_SESSION ['userChiName'] );
		unset ( $_SESSION ['doDistrict'] );
		unset ( $_SESSION ['groupId'] );
		unset ( $_SESSION ['doCompany'] );
	}
	
	/**
	 * 检查是否已经登录
	 *
	 * @access public
	 */
	static function IsLogin()
	{
		if (isset ( $_SESSION ['userId'] ))
		{
			return true;
		} else
		{
			return false;
		}
	}
	
	/**
	 * 檢查是否有訪問該功能的權限
	 *
	 * @param string $permCode        	
	 * @return boolean
	 */
	static function HasPermission($permCode)
	{
		if (is_array ( $_SESSION ['permCodes'] ))
		{
			if (in_array ( $permCode, $_SESSION ['permCodes'] ))
			{
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 是否有其中一个权限
	 *
	 * @param array $permCodes        	
	 * @return boolean
	 */
	static function HasOnePermission($permCodes)
	{
		if (is_array ( $_SESSION ['permCodes'] ))
		{
			foreach ( $permCodes as $k => $v )
			{
				if (in_array ( $v, $_SESSION ['permCodes'] ))
				{
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * 是否有权限
	 *
	 * @access public
	 */
	static function IsRight($right)
	{
		global $currperm;
		if ($_SESSION ['permId'] == "")
		{
			if (in_array ( $_SESSION ['permId'], $right ))
			{
				return true;
			} else
			{
				return false;
			}
		}
	}
	
	/**
	 * 是否是管理员
	 *
	 * @access public
	 */
	static function IsAdministrator()
	{
		if ($_SESSION ['permId'] == '1' || $_SESSION ['permId'] == '5' 
				|| $_SESSION ['permId'] == '7' || $_SESSION ['permId'] == '8' 
				|| $_SESSION ['permId'] == '9' || $_SESSION ['permId'] == '10')
		{
			return true;
		} else
		{
			return false;
		}
	}
	
	/**
	 * 是否是超级管理员
	 *
	 * @access public
	 */
	static function IsSuperAdministrator()
	{
		if ($_SESSION ['permId'] == '5')
		{
			return true;
		} else
		{
			return false;
		}
	}
	
	/**
	 * 是否是超级用户
	 *
	 * @access public
	 */
	static function IsSupervisor()
	{
		if ($_SESSION ['permId'] == '2')
		{
			return true;
		} else
		{
			return false;
		}
	}
	
	/**
	 * 是否是只读用户
	 *
	 * @access public
	 */
	static function IsReadOnly()
	{
		if ($_SESSION ['permId'] == '4')
		{
			return true;
		} else
		{
			return false;
		}
	}
	
	/**
	 * 是否是调查者
	 *
	 * @access public
	 */
	static function IsSurveyor()
	{
		if ($_SESSION ['permId'] == '3')
		{
			return true;
		} else
		{
			return false;
		}
	}
	
	/**
	 * 可以查看的分判商
	 */
	static function CanDoCompany()
	{
		return $_SESSION ['doCompany'];
	}
	
	/**
	 * 可以查看的区域
	 */
	static function CanDoDistrict()
	{
		return $_SESSION ['doDistrict'];
	}
	
	/**
	 * 可以查看的区域编号
	 */
	static function CanDoComplateJobNo()
	{
		$doComplateJobNo = "1";
		$canDoDistrict = UserLogin::CanDoDistrict ();
		if ($canDoDistrict == "")
		{
			return "";
		}
		$tempDoDist = explode ( ",", $canDoDistrict );
		foreach ( $tempDoDist as $k => $v )
		{
			if ($v == 1)
				continue;
			$doComplateJobNo .= "," . GetFullDistNumber ( $v );
		}
		return $doComplateJobNo;
	}
	
	/**
	 * 返回登录用户的groupId
	 *
	 * @return unknown_type
	 */
	static function GetUserGroupId()
	{
		return $_SESSION ['groupId'];
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
	 * 是否需要更改密码(90天没有更新就要改一次密码)
	 *
	 * @access public
	 */
	function IsNeedUpdatePassword()
	{
		$last30DayTime = date ( "Y-m-d H:i:s", time () - 86400 * 90 );
		// 如果有永久不必更改密碼的權限
		if ($this->HasPermission ( 'nerver_change_password' ))
		{
			return false;
		}
		if ($this->user->updatePasswordTime < $last30DayTime || $this->user->updatePasswordTime == '')
		{
			return true;
		}
		return false;
	}
	
	/**
	 * 更改密碼
	 *
	 * @access public
	 * @static
	 *
	 */
	function UpdatePassword($newPassword)
	{
		$currentTime = date ( "Y-m-d H:i:s" );
		$sql = "UPDATE  Survey_Users 
				SET passWord = '{$newPassword}',updatePasswordTime='{$currentTime}'
				WHERE userId='{$_SESSION['userId']}'";
		$this->db->query ( $sql );
	}
}

?>
