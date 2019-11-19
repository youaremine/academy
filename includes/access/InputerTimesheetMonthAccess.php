<?php
/*
 * Header: Create: 2008-04-06 Auther: Jamblues.
 */
class InputerTimesheetMonthAccess {
	var $db;
	function InputerTimesheetMonthAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_InputerTimesheetMonth(periodMonth,perHourMoney,inputerCode,durationMonth,inputUserId,inputTime,modifyUserId,modifyTime,delFlag)" . " VALUES('" . $obj->periodMonth . "'" . ",'" . $obj->perHourMoney . "'" . ",'" . $obj->inputerCode . "'" . ",'" . $obj->durationMonth . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_InputerTimesheetMonth " . " SET periodMonth = '" . $obj->periodMonth . "'" . " ,perHourMoney = '" . $obj->perHourMoney . "'" . " ,inputerCode = '" . $obj->inputerCode . "'" . " ,durationMonth = '" . $obj->durationMonth . "'" . " ,inputUserId = '" . $obj->inputUserId . "'" . " ,inputTime = '" . $obj->inputTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND itmoId = '" . $obj->itmoId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_InputerTimesheetMonth " . " SET delFlag='yes' " . " WHERE 1=1  AND itmoId = '" . $obj->itmoId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_InputerTimesheetMonth " . " WHERE 1=1  AND itmoId = '" . $obj->itmoId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->itmoId != '')
			$query .= " AND itmoId = '" . $obj->itmoId . "'";
		if ($obj->periodMonth != '')
			$query .= " AND periodMonth = '" . $obj->periodMonth . "'";
		if ($obj->periodMonthStart != '')
			$query .= " AND periodMonth >= '" . $obj->periodMonthStart . "'";
		if ($obj->periodMonthEnd != '')
			$query .= " AND periodMonth < '" . $obj->periodMonthEnd . "'";
		if ($obj->perHourMoney != '')
			$query .= " AND perHourMoney = '" . $obj->perHourMoney . "'";
		if ($obj->inputerCode != '')
			$query .= " AND inputerCode = '" . $obj->inputerCode . "'";
		if ($obj->durationMonth != '')
			$query .= " AND durationMonth = '" . $obj->durationMonth . "'";
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
		
		$sql = "SELECT * FROM Survey_InputerTimesheetMonth " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// print $sql;
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new InputerTimesheetMonth ();
			$obj->itmoId = $rs ["itmoId"];
			$obj->periodMonth = $rs ["periodMonth"];
			$obj->perHourMoney = $rs ["perHourMoney"];
			$obj->inputerCode = $rs ["inputerCode"];
			$obj->durationMonth = $rs ["durationMonth"];
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