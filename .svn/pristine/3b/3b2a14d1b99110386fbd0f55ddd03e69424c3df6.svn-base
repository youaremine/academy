<?php
/*
 * Header: Create: 2007-11-14 Auther: Jamblues.
 */
class SurveyorMainScheduleAccess {
	var $db;
	function SurveyorMainScheduleAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_SurveyorMainSchedule(survId,jobNoNew,delFlag)" . " VALUES('" . $obj->survId . "'" . ",'" . $obj->jobNoNew . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_SurveyorMainSchedule " . " SET survId = '" . $obj->survId . "'" . " ,jobNoNew = '" . $obj->jobNoNew . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND smscId = '" . $obj->smscId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_SurveyorMainSchedule " . " SET delFlag='yes' " . " WHERE 1=1  AND smscId = '" . $obj->smscId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_SurveyorMainSchedule " . " WHERE 1=1  AND smscId = '" . $obj->smscId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->smscId != '')
			$query .= " AND smscId = '" . $obj->smscId . "'";
		if ($obj->survId != '')
			$query .= " AND survId = '" . $obj->survId . "'";
		if ($obj->mascId != '')
			$query .= " AND jobNoNew = '" . $obj->jobNoNew . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		
		$sql = "SELECT * FROM Survey_SurveyorMainSchedule " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new SurveyorMainSchedule ();
			$obj->smscId = $rs ["smscId"];
			$obj->survId = $rs ["survId"];
			$obj->jobNoNew = $rs ["jobNoNew"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>