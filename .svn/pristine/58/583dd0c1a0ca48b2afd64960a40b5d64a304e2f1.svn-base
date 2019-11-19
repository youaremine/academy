<?php
/*
 * Header: Create: 2008-06-01 Auther: Jamblues@gmail.com.
 */
class MainScheduleReportFileAccess {
	var $db;
	function MainScheduleReportFileAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_MainScheduleReportFile(jobNo,fileType,fileName,inputUserId,inputTime,modifyUserId,modifyTime,delFlag)" . " VALUES('" . $obj->jobNo . "'" . ",'" . $obj->fileType . "'" . ",'" . $obj->fileName . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_MainScheduleReportFile " . " SET jobNo = '" . $obj->jobNo . "'" . " ,fileType = '" . $obj->fileType . "'" . " ,fileName = '" . $obj->fileName . "'" . " ,inputUserId = '" . $obj->inputUserId . "'" . " ,inputTime = '" . $obj->inputTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND msrfId = '" . $obj->msrfId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_MainScheduleReportFile " . " SET delFlag='yes' " . " WHERE 1=1  AND msrfId = '" . $obj->msrfId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_MainScheduleReportFile " . " WHERE 1=1  AND msrfId = '" . $obj->msrfId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->msrfId != '')
			$query .= " AND msrfId = '" . $obj->msrfId . "'";
		if ($obj->jobNo != '')
			$query .= " AND jobNo = '" . $obj->jobNo . "'";
		if ($obj->fileType != '')
			$query .= " AND fileType = '" . $obj->fileType . "'";
		if ($obj->fileName != '')
			$query .= " AND fileName = '" . $obj->fileName . "'";
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
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_MainScheduleReportFile " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new MainScheduleReportFile ();
			$obj->msrfId = $rs ["msrfId"];
			$obj->jobNo = $rs ["jobNo"];
			$obj->fileType = $rs ["fileType"];
			$obj->fileName = $rs ["fileName"];
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