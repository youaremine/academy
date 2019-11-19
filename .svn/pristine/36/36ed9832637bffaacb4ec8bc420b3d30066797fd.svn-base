<?php
/*
 * Header: Create: 2013-01-24 Auther: James Wu<jamblues@gmail.com>.
 */
class RoleAccess {
	var $db;
	function RoleAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_Role(roleCode,roleName,delFlag)" . " VALUES('" . $obj->roleCode . "'" . ",'" . $obj->roleName . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_Role " . " SET roleCode = '" . $obj->roleCode . "'" . " ,roleName = '" . $obj->roleName . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND roleId = '" . $obj->roleId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_Role " . " SET delFlag='yes' " . " WHERE 1=1  AND roleId = '" . $obj->roleId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_Role " . " WHERE 1=1  AND roleId = '" . $obj->roleId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->roleId != '')
			$query .= " AND roleId = '" . $obj->roleId . "'";
		if ($obj->roleCode != '')
			$query .= " AND roleCode = '" . $obj->roleCode . "'";
		if ($obj->roleName != '')
			$query .= " AND roleName = '" . $obj->roleName . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_Role " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new Role ();
			$obj->roleId = $rs ["roleId"];
			$obj->roleCode = $rs ["roleCode"];
			$obj->roleName = $rs ["roleName"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>