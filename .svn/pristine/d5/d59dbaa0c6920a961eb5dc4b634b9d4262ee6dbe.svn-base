<?php
/*
 * Header: Create: 2008-03-13 Auther: Jamblues.
 */
class AppendixDAccess {
	var $db;
	function AppendixDAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_AppendixD(survId,location,surveyDate,surveyTime,userAgent,inputUserId,inputTime,modifyUserId,modifyTime,delFlag)" . " VALUES('" . $obj->survId . "'" . ",'" . $obj->location . "'" . ",'" . $obj->surveyDate . "'" . ",'" . $obj->surveyTime . "'" . ",'" . $obj->userAgent . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_AppendixD " . " SET survId = '" . $obj->survId . "'" . " ,location = '" . $obj->location . "'" . " ,surveyDate = '" . $obj->surveyDate . "'" . " ,surveyTime = '" . $obj->surveyTime . "'" . " ,userAgent = '" . $obj->userAgent . "'" . " ,inputUserId = '" . $obj->inputUserId . "'" . " ,inputTime = '" . $obj->inputTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND appeId = '" . $obj->appeId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_AppendixD " . " SET delFlag='yes' " . " WHERE 1=1  AND appeId = '" . $obj->appeId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_AppendixD " . " WHERE 1=1  AND appeId = '" . $obj->appeId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->appeId != '')
			$query .= " AND appeId = '" . $obj->appeId . "'";
		if ($obj->survId != '')
			$query .= " AND survId = '" . $obj->survId . "'";
		if ($obj->location != '')
			$query .= " AND location = '" . $obj->location . "'";
		if ($obj->surveyDate != '')
			$query .= " AND surveyDate = '" . $obj->surveyDate . "'";
		if ($obj->surveyTime != '')
			$query .= " AND surveyTime = '" . $obj->surveyTime . "'";
		if ($obj->userAgent != '')
			$query .= " AND userAgent = '" . $obj->userAgent . "'";
		if ($obj->inputUserId != '')
			$query .= " AND inputUserId = '" . $obj->inputUserId . "'";
		if ($obj->inputTime != '')
			$query .= " AND inputTime = '" . $obj->inputTime . "'";
		if ($obj->modifyUserId != '')
			$query .= " AND modifyUserId = '" . $obj->modifyUserId . "'";
		if ($obj->modifyTime != '')
			$query .= " AND modifyTime = '" . $obj->modifyTime . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		
		$sql = "SELECT * FROM Survey_AppendixD " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new AppendixD ();
			$obj->appeId = $rs ["appeId"];
			$obj->survId = $rs ["survId"];
			$obj->location = $rs ["location"];
			$obj->surveyDate = $rs ["surveyDate"];
			$obj->surveyTime = $rs ["surveyTime"];
			$obj->userAgent = $rs ["userAgent"];
			$obj->inputUserId = $rs ["inputUserId"];
			$obj->inputTime = $rs ["inputTime"];
			$obj->modifyUserId = $rs ["modifyUserId"];
			$obj->modifyTime = $rs ["modifyTime"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>