<?php
/*
 * Header: Create: 2009-12-11 Auther: Jamblues@gmail.com.
 */
class UserOnlineAccess {
	var $db;
	function UserOnlineAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_UserOnline(userId,activeTime,groupId)" . " VALUES('" . $obj->userId . "'" . ",'" . $obj->activeTime . "'" . ",'" . $obj->groupId . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_UserOnline " . " SET userId = '" . $obj->userId . "'" . " ,activeTime = '" . $obj->activeTime . "'" . " ,groupId = '" . $obj->groupId . "'" . " WHERE 1=1  AND usonId = '" . $obj->usonId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_UserOnline " . " SET delFlag='yes' " . " WHERE 1=1  AND usonId = '" . $obj->usonId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_UserOnline " . " WHERE 1=1  AND userId = '" . $obj->userId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->usonId != '')
			$query .= " AND usonId = '" . $obj->usonId . "'";
		if ($obj->userId != '')
			$query .= " AND userId = '" . $obj->userId . "'";
		if ($obj->activeTime != '')
			$query .= " AND activeTime = '" . $obj->activeTime . "'";
		if ($obj->groupId != '')
			$query .= " AND groupId = '" . $obj->groupId . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_UserOnline " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $this->db->next_record () ) {
			$obj = new UserOnline ();
			$obj->usonId = $this->db->Record ["usonId"];
			$obj->userId = $this->db->Record ["userId"];
			$obj->activeTime = $this->db->Record ["activeTime"];
			$obj->groupId = $this->db->Record ["groupId"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>