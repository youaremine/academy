<?php
/*
 * Header: Create: 2008-10-25 Auther: Jamblues@gmail.com.
 */
class MainScheduleReportDateAccess {
	var $db;
	function MainScheduleReportDateAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		if ($obj->isFirst == 'yes') {
			$msa = new MainScheduleAccess ( $this->db );
			$msa->UpdateOneReportDate ( $obj->jobNo, $obj->reportDate );
		}
		
		$sql = "INSERT INTO  Survey_MainScheduleReportDate(jobNo,reportDate,userType,inputUserId,inputTime,modifyUserId,modifyTime,delFlag,isFirst)" . " VALUES('" . $obj->jobNo . "'" . ",'" . $obj->reportDate . "'" . ",'" . $obj->userType . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->delFlag . "'" . ",'" . $obj->isFirst . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_MainScheduleReportDate " . " SET jobNo = '" . $obj->jobNo . "'" . " ,reportDate = '" . $obj->reportDate . "'" . " ,userType = '" . $obj->userType . "'" . " ,inputUserId = '" . $obj->inputUserId . "'" . " ,inputTime = '" . $obj->inputTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " ,isFirst = '" . $obj->isFirst . "'" . " WHERE 1=1  AND msrd = '" . $obj->msrd . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_MainScheduleReportDate " . " SET delFlag='yes' " . " WHERE 1=1  AND msrd = '" . $obj->msrd . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_MainScheduleReportDate " . " WHERE 1=1  AND msrd = '" . $obj->msrd . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->msrd != '')
			$query .= " AND msrd = '" . $obj->msrd . "'";
		if ($obj->jobNo != '')
			$query .= " AND jobNo = '" . $obj->jobNo . "'";
		if ($obj->reportDate != '')
			$query .= " AND reportDate = '" . $obj->reportDate . "'";
		if ($obj->userType != '')
			$query .= " AND userType = '" . $obj->userType . "'";
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
		if ($obj->isFirst != '')
			$query .= " AND isFirst = '" . $obj->isFirst . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_MainScheduleReportDate " . " WHERE 1=1 ";
		$sql = $sql . $query;
		// echo $sql;exit();
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new MainScheduleReportDate ();
			$obj->msrd = $rs ["msrd"];
			$obj->jobNo = $rs ["jobNo"];
			$obj->reportDate = $rs ["reportDate"];
			$obj->userType = $rs ["userType"];
			$obj->inputUserId = $rs ["inputUserId"];
			$obj->inputTime = $rs ["inputTime"];
			$obj->modifyUserId = $rs ["modifyUserId"];
			$obj->modifyTime = $rs ["modifyTime"];
			$obj->delFlag = $rs ["delFlag"];
			$obj->isFirst = $rs ["isFirst"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 獲取所有發送者
	 */
	function GetAllSender() {
		$sql = "SELECT DISTINCT inputUserId FROM Survey_MainScheduleReportDate";
		$this->db->query ( $sql );
		$senders = array ();
		while ( $rs = $this->db->next_record () ) {
			$senders [] = $rs ['inputUserId'];
		}
		return $senders;
	}
}
?>