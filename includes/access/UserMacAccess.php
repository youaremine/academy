<?php
/*
 * Header: Create: 2009-12-11 Auther: Jamblues@gmail.com.
 */
class UserMacAccess {
	var $db;
	function UserMacAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_UserMac(userId,macAddress,remarks)" . " VALUES('" . $obj->userId . "'" . ",'" . $obj->macAddress . "'" . ",'" . $obj->remarks . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_UserMac " . " SET userId = '" . $obj->userId . "'" . " ,macAddress = '" . $obj->macAddress . "'" . " ,remarks = '" . $obj->remarks . "'" . " WHERE 1=1  AND usmaId = '" . $obj->usmaId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_UserMac " . " SET delFlag='yes' " . " WHERE 1=1  AND usmaId = '" . $obj->usmaId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_UserMac " . " WHERE 1=1  AND usmaId = '" . $obj->usmaId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->usmaId != '')
			$query .= " AND usmaId = '" . $obj->usmaId . "'";
		if ($obj->userId != '')
			$query .= " AND userId = '" . $obj->userId . "'";
		if ($obj->macAddress != '')
			$query .= " AND macAddress = '" . $obj->macAddress . "'";
		if ($obj->remarks != '')
			$query .= " AND remarks = '" . $obj->remarks . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_UserMac " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new UserMac ();
			$obj->usmaId = $rs ["usmaId"];
			$obj->userId = $rs ["userId"];
			$obj->macAddress = $rs ["macAddress"];
			$obj->remarks = $rs ["remarks"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 是否存在该网卡物理地址
	 * 
	 * @param unknown_type $obj        	
	 * @return number
	 */
	function IsExistMacAddress($obj) {
		if (empty ( $obj->keyId ))
			return 0;
		$keyCode = "survey2009" . date ( "Y-m-d H:i" );
		$query = " AND MD5(CONCAT(macAddress,'" . $keyCode . "')) = '" . $obj->keyId . "'";
		
		$sql = "SELECT * FROM Survey_UserMac " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		return $this->db->num_rows ();
	}
}
?>