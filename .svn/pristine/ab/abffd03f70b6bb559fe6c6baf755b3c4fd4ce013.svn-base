<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class UsersList {
	var $db;
	var $userId;
	var $userName;
	var $passWord;
	var $chiName;
	var $engName;
	var $age;
	var $sex;
	var $moblie;
	var $telephone;
	var $eMail;
	var $lastLoginTime;
	var $loginTimes;
	var $updateDate;
	var $createDate;
	var $userRemark;
	var $userHome;
	var $doDistrict;
	var $dipaId;
	var $delFlag = 'no';
	var $permId;
	var $permName;
	var $order;
	function UsersList($db) {
		$this->db = $db;
	}
	function GetListSearch() {
		$query = "";
		if ($this->userId != '')
			$query .= " AND US.userId = '" . $this->userId . "'";
		if ($this->delFlag != '')
			$query .= " AND US.delFlag = '" . $this->delFlag . "'";
		if ($this->order != '')
			$query .= $this->order;
		$rows = array ();
		$sql = "SELECT US.*,R.roleId,R.roleName,DP.engName AS distEngName FROM  Survey_Users AS US" . " LEFT JOIN Survey_UserRole AS UR ON US.userId = UR.userId" . " LEFT JOIN Survey_Role AS R ON R.roleId = UR.roleId" . " LEFT JOIN Survey_DistrictPart AS DP ON US.dipaId = DP.dipaId" . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// print $sql;
		while ( $rs = $this->db->next_record () ) {
			$user = new Users ( $this->db );
			$user->userId = $rs ['userId'];
			$user->userName = $rs ['userName'];
			$user->passWord = $rs ['passWord'];
			$user->chiName = $rs ['chiName'];
			$user->engName = $rs ['engName'];
			$user->age = $rs ['age'];
			$user->sex = $rs ['sex'];
			$user->moblie = $rs ['moblie'];
			$user->telephone = $rs ['telephone'];
			$user->eMail = $rs ['eMail'];
			$user->lastLoginTime = $rs ['lastLoginTime'];
			$user->loginTimes = $rs ['loginTimes'];
			$user->updateDate = $rs ['updateDate'];
			$user->createDate = $rs ['createDate'];
			$user->userRemark = $rs ['userRemark'];
			$user->userHome = $rs ['userHome'];
			$user->dipaId = $rs ['dipaId'];
			$user->doDistrict = $rs ['doDistrict'];
			$user->delFlag = $rs ['delFlag'];
			$user->roleId = $rs ['roleId'];
			$user->roleName = $rs ['roleName'];
			$user->passWord = $rs ['passWord'];
			$user->distEngName = $rs ['distEngName'];
			$user->validLoginTime = $rs ['validLoginTime'];
			$user->updatePasswordTime = $rs ['updatePasswordTime'];
			$user->doCompany = $rs ['doCompany'];
			$rows [] = $user;
		}
		return $rows;
	}
	
	/**
	 * 检查是否存在该用户
	 * 
	 * @access public
	 */
	function IsExist() {
		$sql = "SELECT * FROM  Survey_Users " . "WHERE userName = '" . $this->userName . "'" . "  AND passWord = '" . $this->passWord . "'";
		$this->db->query ( $sql );
		if ($this->db->num_rows () > 0) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * 获取所有输入过资料的调查员
	 */
	function GetInputter(){

	}
}
?>
