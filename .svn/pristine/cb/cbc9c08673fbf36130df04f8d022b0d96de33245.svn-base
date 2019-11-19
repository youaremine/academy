<?php
/*
 * Header: Create: 2011-05-10 Auther: James Wu<jamblues@gmail.com>.
 */
class OtherProjectsAccess {
	var $db;
	function OtherProjectsAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_OtherProjects(projectCode,projectName,delFlag)" . " VALUES('" . $obj->projectCode . "'" . ",'" . $obj->projectName . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_OtherProjects " . " SET projectCode = '" . $obj->projectCode . "'" . " ,projectName = '" . $obj->projectName . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND opId = '" . $obj->opId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_OtherProjects " . " SET delFlag='yes' " . " WHERE 1=1  AND opId = '" . $obj->opId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_OtherProjects " . " WHERE 1=1  AND opId = '" . $obj->opId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->opId != '')
			$query .= " AND opId = '" . $obj->opId . "'";
		if ($obj->projectCode != '')
			$query .= " AND projectCode = '" . $obj->projectCode . "'";
		if ($obj->projectName != '')
			$query .= " AND projectName = '" . $obj->projectName . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_OtherProjects " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new OtherProjects ();
			$obj->opId = $rs ["opId"];
			$obj->projectCode = $rs ["projectCode"];
			$obj->projectName = $rs ["projectName"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 清空表
	 */
	function EmptyTable() {
		$sql = "TRUNCATE TABLE Survey_OtherProjects ";
		$this->db->query ( $sql );
	}
}
?>