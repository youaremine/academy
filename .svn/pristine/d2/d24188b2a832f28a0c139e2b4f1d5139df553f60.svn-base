<?php
/*
 * Header: Create: 2008-06-29 Auther: Jamblues@gmail.com.
 */
class FlowPorjectAccess {
	var $db;
	function FlowPorjectAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_FlowPorject(chiName,engName,remark,delFlag)" . " VALUES('" . $obj->chiName . "'" . ",'" . $obj->engName . "'" . ",'" . $obj->remark . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_FlowPorject " . " SET chiName = '" . $obj->chiName . "'" . " ,engName = '" . $obj->engName . "'" . " ,remark = '" . $obj->remark . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND porjId = '" . $obj->porjId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_FlowPorject " . " SET delFlag='yes' " . " WHERE 1=1  AND porjId = '" . $obj->porjId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_FlowPorject " . " WHERE 1=1  AND porjId = '" . $obj->porjId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->porjId != '')
			$query .= " AND porjId = '" . $obj->porjId . "'";
		if ($obj->chiName != '')
			$query .= " AND chiName = '" . $obj->chiName . "'";
		if ($obj->engName != '')
			$query .= " AND engName = '" . $obj->engName . "'";
		if ($obj->remark != '')
			$query .= " AND remark = '" . $obj->remark . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_FlowPorject " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new FlowPorject ();
			$obj->porjId = $rs ["porjId"];
			$obj->chiName = $rs ["chiName"];
			$obj->engName = $rs ["engName"];
			$obj->remark = $rs ["remark"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>