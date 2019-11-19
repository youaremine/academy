<?php
/*
 * Header: Create: 2013-01-24 Auther: James Wu<jamblues@gmail.com>.
 */
class UserRoleAccess {
	var $db;
	function UserRoleAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO Survey_UserRole(userId,roleId,delFlag)" . " VALUES('" . $obj->userId . "'" . ",'" . $obj->roleId . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_UserRole " . " SET roleId = '" . $obj->roleId . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND userId = '" . $obj->userId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_UserRole " . " SET delFlag='yes' " . " WHERE 1=1  AND userId = '" . $obj->userId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_UserRole " . " WHERE 1=1  AND userId = '" . $obj->userId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->userId != '')
			$query .= " AND userId = '" . $obj->userId . "'";
		if ($obj->roleId != '')
			$query .= " AND roleId = '" . $obj->roleId . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_UserRole " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new UserRole ();
			$obj->userId = $rs ["userId"];
			$obj->roleId = $rs ["roleId"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>