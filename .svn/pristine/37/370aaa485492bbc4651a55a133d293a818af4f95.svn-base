<?php
/*
 * Header: Create: 2008-03-13 Auther: Jamblues.
 */
class AppendixDDetailAccess {
	var $db;
	function AppendixDDetailAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_AppendixDDetail(appeId,surveyTime,isReject,questionOne_1,questionOne_2,questionOne_3,questionTwo_1,questionTwo_2,questionTwo_3)" . " VALUES('" . $obj->appeId . "'" . ",'" . $obj->surveyTime . "'" . ",'" . $obj->isReject . "'" . ",'" . $obj->questionOne_1 . "'" . ",'" . $obj->questionOne_2 . "'" . ",'" . $obj->questionOne_3 . "'" . ",'" . $obj->questionTwo_1 . "'" . ",'" . $obj->questionTwo_2 . "'" . ",'" . $obj->questionTwo_3 . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_AppendixDDetail " . " SET appeId = '" . $obj->appeId . "'" . " ,surveyTime = '" . $obj->surveyTime . "'" . " ,isReject = '" . $obj->isReject . "'" . " ,questionOne_1 = '" . $obj->questionOne_1 . "'" . " ,questionOne_2 = '" . $obj->questionOne_2 . "'" . " ,questionOne_3 = '" . $obj->questionOne_3 . "'" . " ,questionTwo_1 = '" . $obj->questionTwo_1 . "'" . " ,questionTwo_2 = '" . $obj->questionTwo_2 . "'" . " ,questionTwo_3 = '" . $obj->questionTwo_3 . "'" . " WHERE 1=1  AND apdeId = '" . $obj->apdeId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_AppendixDDetail " . " SET delFlag='yes' " . " WHERE 1=1  AND apdeId = '" . $obj->apdeId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		;
		$sql = "DELETE FROM Survey_AppendixDDetail " . " WHERE 1=1  AND apdeId = '" . $obj->apdeId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->apdeId != '')
			$query .= " AND apdeId = '" . $obj->apdeId . "'";
		if ($obj->appeId != '')
			$query .= " AND appeId = '" . $obj->appeId . "'";
		if ($obj->surveyTime != '')
			$query .= " AND surveyTime = '" . $obj->surveyTime . "'";
		if ($obj->isReject != '')
			$query .= " AND isReject = '" . $obj->isReject . "'";
		if ($obj->questionOne_1 != '')
			$query .= " AND questionOne_1 = '" . $obj->questionOne_1 . "'";
		if ($obj->questionOne_2 != '')
			$query .= " AND questionOne_2 = '" . $obj->questionOne_2 . "'";
		if ($obj->questionOne_3 != '')
			$query .= " AND questionOne_3 = '" . $obj->questionOne_3 . "'";
		if ($obj->questionTwo_1 != '')
			$query .= " AND questionTwo_1 = '" . $obj->questionTwo_1 . "'";
		if ($obj->questionTwo_2 != '')
			$query .= " AND questionTwo_2 = '" . $obj->questionTwo_2 . "'";
		if ($obj->questionTwo_3 != '')
			$query .= " AND questionTwo_3 = '" . $obj->questionTwo_3 . "'";
		
		$sql = "SELECT * FROM Survey_AppendixDDetail " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new AppendixDDetail ();
			$obj->apdeId = $rs ["apdeId"];
			$obj->appeId = $rs ["appeId"];
			$obj->surveyTime = $rs ["surveyTime"];
			$obj->isReject = $rs ["isReject"];
			$obj->questionOne_1 = $rs ["questionOne_1"];
			$obj->questionOne_2 = $rs ["questionOne_2"];
			$obj->questionOne_3 = $rs ["questionOne_3"];
			$obj->questionTwo_1 = $rs ["questionTwo_1"];
			$obj->questionTwo_2 = $rs ["questionTwo_2"];
			$obj->questionTwo_3 = $rs ["questionTwo_3"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>