<?php
/*
 * Header: Create: 2013-01-24 Auther: James Wu<jamblues@gmail.com>.
 */
class DistrictPartAccess {
	var $db;
	function DistrictPartAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO Survey_DistrictPart(dipaCode,engName,chiName,delFlag)" . " VALUES('" . $obj->dipaCode . "'" . ",'" . $obj->engName . "'" . ",'" . $obj->chiName . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_DistrictPart " . " SET dipaCode = '" . $obj->dipaCode . "'" . " ,engName = '" . $obj->engName . "'" . " ,chiName = '" . $obj->chiName . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND dipaId = '" . $obj->dipaId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_DistrictPart " . " SET delFlag='yes' " . " WHERE 1=1  AND dipaId = '" . $obj->dipaId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_DistrictPart " . " WHERE 1=1  AND dipaId = '" . $obj->dipaId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->dipaId != '')
			$query .= " AND dipaId = '" . $obj->dipaId . "'";
		if ($obj->dipaCode != '')
			$query .= " AND dipaCode = '" . $obj->dipaCode . "'";
		if ($obj->engName != '')
			$query .= " AND engName = '" . $obj->engName . "'";
		if ($obj->chiName != '')
			$query .= " AND chiName = '" . $obj->chiName . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_DistrictPart " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new DistrictPart ();
			$obj->dipaId = $rs ["dipaId"];
			$obj->dipaCode = $rs ["dipaCode"];
			$obj->engName = $rs ["engName"];
			$obj->chiName = $rs ["chiName"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>