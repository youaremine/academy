<?php
/*
 * Header: Create: 2013-12-06 Auther: James Wu<jamblues@gmail.com>.
 */
class AcrossAccess {
	var $db;
	function AcrossAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO Survey_Across(company,plateNo,fleetNo,capacity,sch)" . " VALUES('" . $obj->company . "'" . ",'" . $obj->plateNo . "'" . ",'" . $obj->fleetNo . "'" . ",'" . $obj->capacity . "'" . ",'" . $obj->sch . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_Across " . " SET company = '" . $obj->company . "'" . " ,plateNo = '" . $obj->plateNo . "'" . " ,fleetNo = '" . $obj->fleetNo . "'" . " ,capacity = '" . $obj->capacity . "'" . " ,sch = '" . $obj->sch . "'" . " WHERE 1=1  AND aId = '" . $obj->aId . "'";
		$this->db->query ( $sql );
	}
	function ReplaceInto($ac) {
		$sql = "REPLACE INTO Survey_Across(aId,company,plateNo,fleetNo,capacity,sch) VALUES({aId},'{company}','{plateNo}','{fleetNo}',{capacity},'{sch}');";
		$sql = str_replace ( "{aId}", $ac->aId, $sql );
		$sql = str_replace ( "{company}", $ac->company, $sql );
		$sql = str_replace ( "{plateNo}", $ac->plateNo, $sql );
		$sql = str_replace ( "{fleetNo}", $ac->fleetNo, $sql );
		$sql = str_replace ( "{capacity}", $ac->capacity, $sql );
		$sql = str_replace ( "{sch}", $ac->sch, $sql );
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_Across " . " SET delFlag='yes' " . " WHERE 1=1  AND aId = '" . $obj->aId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_Across " . " WHERE 1=1  AND aId = '" . $obj->aId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->aId != '')
			$query .= " AND aId = '" . $obj->aId . "'";
		if ($obj->company != '')
			$query .= " AND company = '" . $obj->company . "'";
		if ($obj->plateNo != '' && $obj->fleetNo != '') {
			$query .= " AND (plateNo = '" . $obj->plateNo . "' OR fleetNo = '" . $obj->fleetNo . "')";
		} else if ($obj->plateNo != '')
			$query .= " AND plateNo = '" . $obj->plateNo . "'";
		else if ($obj->fleetNo != '')
			$query .= " AND fleetNo = '" . $obj->fleetNo . "'";
		if ($obj->capacity != '')
			$query .= " AND capacity = '" . $obj->capacity . "'";
		if ($obj->sch != '')
			$query .= " AND sch = '" . $obj->sch . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_Across " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new Across ();
			$obj->aId = $rs ["aId"];
			$obj->company = $rs ["company"];
			$obj->plateNo = $rs ["plateNo"];
			$obj->fleetNo = $rs ["fleetNo"];
			$obj->capacity = $rs ["capacity"];
			$obj->sch = $rs ["sch"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>