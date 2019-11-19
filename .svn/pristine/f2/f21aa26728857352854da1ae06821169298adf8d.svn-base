<?php
/*
 * Header: Create: 2011-11-02 Auther: James Wu<jamblues@gmail.com>.
 */
class SurveyorWorkHourAccess {
	var $db;
	function SurveyorWorkHourAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_SurveyorWorkHour(survId,workMonth,totalWorkHour,delFlag)" . " VALUES('" . $obj->survId . "'" . ",'" . $obj->workMonth . "'" . ",'" . $obj->totalWorkHour . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_SurveyorWorkHour " . " SET survId = '" . $obj->survId . "'" . " ,workMonth = '" . $obj->workMonth . "'" . " ,totalWorkHour = '" . $obj->totalWorkHour . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND swhoId = '" . $obj->swhoId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_SurveyorWorkHour " . " SET delFlag='yes' " . " WHERE 1=1  AND swhoId = '" . $obj->swhoId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_SurveyorWorkHour " . " WHERE 1=1  AND swhoId = '" . $obj->swhoId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->swhoId != '')
			$query .= " AND swhoId = '" . $obj->swhoId . "'";
		if ($obj->survId != '')
			$query .= " AND survId = '" . $obj->survId . "'";
		if ($obj->workMonth != '')
			$query .= " AND workMonth = '" . $obj->workMonth . "'";
		if ($obj->totalWorkHour != '')
			$query .= " AND totalWorkHour = '" . $obj->totalWorkHour . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_SurveyorWorkHour " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new SurveyorWorkHour ();
			$obj->swhoId = $rs ["swhoId"];
			$obj->survId = $rs ["survId"];
			$obj->workMonth = $rs ["workMonth"];
			$obj->totalWorkHour = $rs ["totalWorkHour"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>