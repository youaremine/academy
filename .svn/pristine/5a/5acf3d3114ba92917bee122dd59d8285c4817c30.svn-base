<?php
/*
 * Header: Create: 2008-04-06 Auther: Jamblues.
 */
class InputerTimesheetAccess {
	var $db;
	function InputerTimesheetAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_InputerTimesheet(itmoId,periodDate,perHourMoneyDay,durationDay,inputUserId,inputTime,modifyUserId,modifyTime,delFlag)" . " VALUES('" . $obj->itmoId . "'" . ",'" . $obj->periodDate . "'" . ",'" . $obj->perHourMoneyDay . "'" . ",'" . $obj->durationDay . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_InputerTimesheet " . " SET itmoId = '" . $obj->itmoId . "'" . " ,periodDate = '" . $obj->periodDate . "'" . " ,perHourMoneyDay = '" . $obj->perHourMoneyDay . "'" . " ,durationDay = '" . $obj->durationDay . "'" . " ,inputUserId = '" . $obj->inputUserId . "'" . " ,inputTime = '" . $obj->inputTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND intiId = '" . $obj->intiId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_InputerTimesheet " . " SET delFlag='yes' " . " WHERE 1=1  AND intiId = '" . $obj->intiId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_InputerTimesheet " . " WHERE 1=1  AND intiId = '" . $obj->intiId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->intiId != '')
			$query .= " AND intiId = '" . $obj->intiId . "'";
		if ($obj->itmoId != '')
			$query .= " AND itmoId = '" . $obj->itmoId . "'";
		if ($obj->periodDate != '')
			$query .= " AND periodDate = '" . $obj->periodDate . "'";
		if ($obj->perHourMoneyDay != '')
			$query .= " AND perHourMoneyDay = '" . $obj->perHourMoneyDay . "'";
		if ($obj->durationDay != '')
			$query .= " AND durationDay = '" . $obj->durationDay . "'";
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
		if ($obj->order != '')
			$query .= " " . $obj->order;
		
		$sql = "SELECT * FROM Survey_InputerTimesheet " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// print $sql;
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new InputerTimesheet ();
			$obj->intiId = $rs ["intiId"];
			$obj->itmoId = $rs ["itmoId"];
			$obj->periodDate = $rs ["periodDate"];
			$obj->perHourMoneyDay = $rs ["perHourMoneyDay"];
			$obj->durationDay = $rs ["durationDay"];
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