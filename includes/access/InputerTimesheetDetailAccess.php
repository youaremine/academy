<?php
/*
 * Header: Create: 2008-04-06 Auther: Jamblues.
 */
class InputerTimesheetDetailAccess {
	var $db;
	function InputerTimesheetDetailAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_InputerTimesheetDetail(intiId,jobNo,purpose,travellingForm,travellingTo,transportType,transportMoney,timeForm,timeTo,druation,isLunch)" . " VALUES('" . $obj->intiId . "'" . ",'" . $obj->jobNo . "'" . ",'" . $obj->purpose . "'" . ",'" . $obj->travellingForm . "'" . ",'" . $obj->travellingTo . "'" . ",'" . $obj->transportType . "'" . ",'" . $obj->transportMoney . "'" . ",'" . $obj->timeForm . "'" . ",'" . $obj->timeTo . "'" . ",'" . $obj->druation . "'" . ",'" . $obj->isLunch . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_InputerTimesheetDetail " . " SET intiId = '" . $obj->intiId . "'" . " ,jobNo = '" . $obj->jobNo . "'" . " ,purpose = '" . $obj->purpose . "'" . " ,travellingForm = '" . $obj->travellingForm . "'" . " ,travellingTo = '" . $obj->travellingTo . "'" . " ,transportType = '" . $obj->transportType . "'" . " ,transportMoney = '" . $obj->transportMoney . "'" . " ,timeForm = '" . $obj->timeForm . "'" . " ,timeTo = '" . $obj->timeTo . "'" . " ,druation = '" . $obj->druation . "'" . " ,isLunch = '" . $obj->isLunch . "'" . " WHERE 1=1  AND itdeId = '" . $obj->itdeId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_InputerTimesheetDetail " . " SET delFlag='yes' " . " WHERE 1=1  AND itdeId = '" . $obj->itdeId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_InputerTimesheetDetail " . " WHERE 1=1  AND itdeId = '" . $obj->itdeId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->itdeId != '')
			$query .= " AND itdeId = '" . $obj->itdeId . "'";
		if ($obj->intiId != '')
			$query .= " AND intiId = '" . $obj->intiId . "'";
		if ($obj->jobNo != '')
			$query .= " AND jobNo = '" . $obj->jobNo . "'";
		if ($obj->purpose != '')
			$query .= " AND purpose = '" . $obj->purpose . "'";
		if ($obj->travellingForm != '')
			$query .= " AND travellingForm = '" . $obj->travellingForm . "'";
		if ($obj->travellingTo != '')
			$query .= " AND travellingTo = '" . $obj->travellingTo . "'";
		if ($obj->transportType != '')
			$query .= " AND transportType = '" . $obj->transportType . "'";
		if ($obj->transportMoney != '')
			$query .= " AND transportMoney = '" . $obj->transportMoney . "'";
		if ($obj->timeForm != '')
			$query .= " AND timeForm = '" . $obj->timeForm . "'";
		if ($obj->timeTo != '')
			$query .= " AND timeTo = '" . $obj->timeTo . "'";
		if ($obj->druation != '')
			$query .= " AND druation = '" . $obj->druation . "'";
		if ($obj->isLunch != '')
			$query .= " AND isLunch = '" . $obj->isLunch . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		
		$sql = "SELECT * FROM Survey_InputerTimesheetDetail " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// print $sql;
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new InputerTimesheetDetail ();
			$obj->itdeId = $rs ["itdeId"];
			$obj->intiId = $rs ["intiId"];
			$obj->jobNo = $rs ["jobNo"];
			$obj->purpose = $rs ["purpose"];
			$obj->travellingForm = $rs ["travellingForm"];
			$obj->travellingTo = $rs ["travellingTo"];
			$obj->transportType = $rs ["transportType"];
			$obj->transportMoney = $rs ["transportMoney"];
			$obj->timeForm = $rs ["timeForm"];
			$obj->timeTo = $rs ["timeTo"];
			$obj->druation = $rs ["druation"];
			$obj->isLunch = $rs ["isLunch"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>