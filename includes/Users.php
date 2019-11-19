<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class Users {
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
	var $validLoginTime;
	var $lastLoginTime;
	var $loginTimes;
	var $updateDate;
	var $createDate;
	var $userRemark;
	var $userHome;
	var $doDistrict;
	var $dipaId;
	var $diengName;
	var $delFlag = 'no';
	var $roleId;
	var $roleName;
	var $permId;
	var $permName;
	var $permCodes;
	var $distEngName;
	var $groupId;
	var $updatePasswordTime;
	var $doCompany;
	function Users($db) {
		$this->lastLoginTime = date ( "Y-m-d H:i:s" );
		$this->createDate = date ( "Y-m-d H:i:s" );
		$this->updateDate = date ( "Y-m-d H:i:s" );
		$this->db = $db;
	}
	
	/**
	 * 添加一个新用户
	 * 
	 * @access public
	 */
	function Save() {
		$sql = "INSERT INTO Survey_Users(userName,passWord,engName,chiName" . ",age,sex,moblie,telephone,eMail,validLoginTime,lastLoginTime,loginTimes" . ",updateDate,createDate,userRemark,userHome,doDistrict,dipaId,doCompany) " . " VALUES('" . $this->userName . "'," . "'" . $this->passWord . "'," . "'" . $this->engName . "'," . "'" . $this->chiName . "'," . "'" . $this->age . "'," . "'" . $this->sex . "'," . "'" . $this->moblie . "'," . "'" . $this->telephone . "'," . "'" . $this->eMail . "'," . "'" . $this->validLoginTime . "'," . "'" . $this->lastLoginTime . "'," . "'" . $this->loginTimes . "'," . "'" . $this->updateDate . "'," . "'" . $this->createDate . "'," . "'" . $this->userRemark . "'," . "'" . $this->userHome . "'," . "'" . $this->doDistrict . "'," . "'" . $this->dipaId . "'," . "'" . $this->doCompany . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Modify() {
		$sql = "UPDATE Survey_Users " . "SET userName = '" . $this->userName . "'," . "passWord = '" . $this->passWord . "'," . "engName = '" . $this->engName . "'," . "chiName = '" . $this->chiName . "'," . "age = '" . $this->age . "'," . "sex = '" . $this->sex . "'," . "moblie = '" . $this->moblie . "'," . "telephone = '" . $this->telephone . "'," . "eMail = '" . $this->eMail . "'," . "updateDate ='" . $this->updateDate . "'," . "createDate ='" . $this->createDate . "'," . "userRemark ='" . $this->userRemark . "'," . "userHome ='" . $this->userHome . "'," . "doDistrict ='" . $this->doDistrict . "'," . "dipaId ='" . $this->dipaId . "'," . "doCompany ='" . $this->doCompany . "'," . "validLoginTime ='" . $this->validLoginTime . "'" . " WHERE userId = " . $this->userId;
		$this->db->query ( $sql );
	}
	
	/**
	 * 登录时一并更新登录时间及次数
	 */
	function AddLastLogin() {
		$sql = "UPDATE Survey_Users " . "SET lastLoginTime = '" . $this->lastLoginTime . "'," . " loginTimes = loginTimes+1" . " WHERE userId = " . $this->userId;
		// echo $sql; exit();
		$this->db->query ( $sql );
	}
	
	/**
	 * 标记用户，停用用户
	 */
	function Del() {
		$sql = "UPDATE Survey_Users " . "SET delFlag ='yes'" . " WHERE userId = " . $this->userId;
		$this->db->query ( $sql );
	}
	function RealDel() {
		// TODO
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
}
?>
