<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class UserPermission {
	var $db;
	var $userId;
	var $permId;
	var $delFlag = 'no';
	function UserPermission($db) {
		$this->db = $db;
		// TODO to be delete
	}
	
	/**
	 * 添加一个用户对应的权限
	 * 
	 * @access public
	 */
	function Save() {
		$sql = "INSERT INTO Survey_UserPermission(userId,permId) " . " VALUES('" . $this->userId . "'," . "'" . $this->permId . "')";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Modify() {
		$sql = "UPDATE Survey_UserPermission " . "SET permId = " . $this->permId . " WHERE userId = " . $this->userId;
		$this->db->query ( $sql );
	}
	function Del() {
	}
	function RealDel() {
	}
}
?>
