<?php
/*
 * Header: Create: 2008-02-28 Auther: Jamblues.
 */
class QuestionairnTaxiAccess {
	var $db;
	function QuestionairnTaxiAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_QuestionairnTaxi(survId,location,district,surveyDate,weather,inputUserId,inputTime,modifyUserId,modifyTime,delFlag)" . " VALUES('" . $obj->survId . "'" . ",'" . $obj->location . "'" . ",'" . $obj->district . "'" . ",'" . $obj->surveyDate . "'" . ",'" . $obj->weather . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_QuestionairnTaxi " . " SET survId = '" . $obj->survId . "'" . " ,location = '" . $obj->location . "'" . " ,district = '" . $obj->district . "'" . " ,surveyDate = '" . $obj->surveyDate . "'" . " ,weather = '" . $obj->weather . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND qutaId = '" . $obj->qutaId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_QuestionairnTaxi " . " SET delFlag='yes' " . " WHERE 1=1  AND qutaId = '" . $obj->qutaId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_QuestionairnTaxi " . " WHERE 1=1  AND qutaId = '" . $obj->qutaId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->qutaId != '')
			$query .= " AND qutaId = '" . $obj->qutaId . "'";
		if ($obj->survId != '')
			$query .= " AND survId = '" . $obj->survId . "'";
		if ($obj->location != '')
			$query .= " AND location = '" . $obj->location . "'";
		if ($obj->district != '')
			$query .= " AND district = '" . $obj->district . "'";
		if ($obj->surveyDate != '')
			$query .= " AND surveyDate = '" . $obj->surveyDate . "'";
		if ($obj->weather != '')
			$query .= " AND weather = '" . $obj->weather . "'";
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
		
		$sql = "SELECT * FROM Survey_QuestionairnTaxi " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new QuestionairnTaxi ();
			$obj->qutaId = $rs ["qutaId"];
			$obj->survId = $rs ["survId"];
			$obj->location = $rs ["location"];
			$obj->district = $rs ["district"];
			$obj->surveyDate = $rs ["surveyDate"];
			$obj->weather = $rs ["weather"];
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