<?php
/*
 * Header: Create: 2008-06-29 Auther: Jamblues@gmail.com.
 */
class FlowBaseCarAccess {
	var $db;
	function FlowBaseCarAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_FlowBaseCar(porjId,chiName,engName,pcuQuantity,delFlag)" . " VALUES('" . $obj->porjId . "'" . ",'" . $obj->chiName . "'" . ",'" . $obj->engName . "'" . ",'" . $obj->pcuQuantity . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_FlowBaseCar " . " SET porjId = '" . $obj->porjId . "'" . " ,chiName = '" . $obj->chiName . "'" . " ,engName = '" . $obj->engName . "'" . " ,pcuQuantity = '" . $obj->pcuQuantity . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND bacaId = '" . $obj->bacaId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_FlowBaseCar " . " SET delFlag='yes' " . " WHERE 1=1  AND bacaId = '" . $obj->bacaId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_FlowBaseCar " . " WHERE 1=1  AND bacaId = '" . $obj->bacaId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->bacaId != '')
			$query .= " AND bacaId = '" . $obj->bacaId . "'";
		if ($obj->porjId != '')
			$query .= " AND porjId = '" . $obj->porjId . "'";
		if ($obj->chiName != '')
			$query .= " AND chiName = '" . $obj->chiName . "'";
		if ($obj->engName != '')
			$query .= " AND engName = '" . $obj->engName . "'";
		if ($obj->pcuQuantity != '')
			$query .= " AND pcuQuantity = '" . $obj->pcuQuantity . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_FlowBaseCar " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new FlowBaseCar ();
			$obj->bacaId = $rs ["bacaId"];
			$obj->porjId = $rs ["porjId"];
			$obj->chiName = $rs ["chiName"];
			$obj->engName = $rs ["engName"];
			$obj->pcuQuantity = $rs ["pcuQuantity"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>