<?php
/*
 * Header: Create: 2011-11-02 Auther: James Wu<jamblues@gmail.com>.
 */
class TransportAllowanceAccess {
	var $db;
	function TransportAllowanceAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_TransportAllowance(liveLocation,destLocation,allowance,delFlag)" . " VALUES('" . $obj->liveLocation . "'" . ",'" . $obj->destLocation . "'" . ",'" . $obj->allowance . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_TransportAllowance " . " SET liveLocation = '" . $obj->liveLocation . "'" . " ,destLocation = '" . $obj->destLocation . "'" . " ,allowance = '" . $obj->allowance . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND tralId = '" . $obj->tralId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_TransportAllowance " . " SET delFlag='yes' " . " WHERE 1=1  AND tralId = '" . $obj->tralId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_TransportAllowance " . " WHERE 1=1  AND tralId = '" . $obj->tralId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->tralId != '')
			$query .= " AND tralId = '" . $obj->tralId . "'";
		if ($obj->liveLocation != '')
			$query .= " AND liveLocation = '" . $obj->liveLocation . "'";
		if ($obj->destLocation != '')
			$query .= " AND destLocation = '" . $obj->destLocation . "'";
		if ($obj->allowance != '')
			$query .= " AND allowance = '" . $obj->allowance . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_TransportAllowance " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new TransportAllowance ();
			$obj->tralId = $rs ["tralId"];
			$obj->liveLocation = $rs ["liveLocation"];
			$obj->destLocation = $rs ["destLocation"];
			$obj->allowance = $rs ["allowance"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>