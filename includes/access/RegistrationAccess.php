<?php
/*
 * Header: Create: 2007-10-17 Auther: Jamblues.
 */
class RegistrationAccess {
	var $db;
	function RegistrationAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_Registration(butyId,plateNo,fleetNo,capacity,delFlag)" . " VALUES('" . $obj->butyId . "'" . ",'" . $obj->plateNo . "'" . ",'" . $obj->fleetNo . "'" . ",'" . $obj->capacity . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		// echo "{$sql}<br />";
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_Registration " . " SET butyId = '" . $obj->butyId . "'" . " ,plateNo = '" . $obj->plateNo . "'" . " ,fleetNo = '" . $obj->fleetNo . "'" . " ,plateNo = '" . $obj->plateNo . "'" . " ,capacity = '" . $obj->capacity . "'" . " WHERE 1=1  AND regiId = '" . $obj->regiId . "'";
		$this->db->query ( $sql );
		// echo "{$sql}<br />";
	}
	function Del($obj) {
		$sql = "UPDATE Survey_Registration " . " SET delFlag='yes' " . " WHERE 1=1  AND regiId = '" . $obj->regiId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_Registration " . " WHERE 1=1  AND regiId = '" . $obj->regiId . "'";
		$this->db->query ( $sql );
	}
	function RealDelByButyId($obj) {
		$sql = "DELETE FROM Survey_Registration " . " WHERE 1=1  AND butyId = '" . $obj->butyId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->regiId != '')
			$query .= " AND regiId = '" . $obj->regiId . "'";
		if ($obj->butyId != '')
			$query .= " AND butyId = '" . $obj->butyId . "'";
		if ($obj->plateNo != '' && $obj->fleetNo != '') {
			$query .= " AND (plateNo = '" . $obj->plateNo . "' OR fleetNo = '" . $obj->fleetNo . "')";
		} else {
			if ($obj->plateNo != '')
				$query .= " AND plateNo = '" . $obj->plateNo . "'";
			if ($obj->fleetNo != '')
				$query .= " AND fleetNo = '" . $obj->fleetNo . "'";
		}
		if ($obj->capacity != '')
			$query .= " AND capacity = '" . $obj->capacity . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		
		$sql = "SELECT * FROM Survey_Registration " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new Registration ();
			$obj->regiId = $rs ["regiId"];
			$obj->butyId = $rs ["butyId"];
			$obj->plateNo = $rs ["plateNo"];
			$obj->fleetNo = $rs ["fleetNo"];
			$obj->capacity = $rs ["capacity"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>