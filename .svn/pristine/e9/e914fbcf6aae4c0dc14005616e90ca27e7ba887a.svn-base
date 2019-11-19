<?php
/*
 * Header: Create: 2013-02-06 Auther: James Wu<jamblues@gmail.com>.
 */
class MainScheduleHistoryLogAccess {
	var $db;
	function MainScheduleHistoryLogAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO Survey_MainScheduleHistoryLog(backupMonth,tableName,tableRemarks,isApproval,delFlag,inputUserId,inputTime,modifyUserId,modifyTime)" . " VALUES('" . $obj->backupMonth . "'" . ",'" . $obj->tableName . "'" . ",'" . $obj->tableRemarks . "'" . ",'" . $obj->isApproval . "'" . ",'" . $obj->delFlag . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyTime . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_MainScheduleHistoryLog " . " SET backupMonth = '" . $obj->backupMonth . "'" . " ,tableName = '" . $obj->tableName . "'" . " ,tableRemarks = '" . $obj->tableRemarks . "'" . " ,isApproval = '" . $obj->isApproval . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " ,inputUserId = '" . $obj->inputUserId . "'" . " ,inputTime = '" . $obj->inputTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " WHERE 1=1  AND mshlId = '" . $obj->mshlId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_MainScheduleHistoryLog " . " SET delFlag='yes' " . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " WHERE 1=1  AND mshlId = '" . $obj->mshlId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_MainScheduleHistoryLog " . " WHERE 1=1  AND mshlId = '" . $obj->mshlId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->mshlId != '')
			$query .= " AND mshlId = '" . $obj->mshlId . "'";
		if ($obj->backupMonth != '')
			$query .= " AND backupMonth = '" . $obj->backupMonth . "'";
		if ($obj->tableName != '')
			$query .= " AND tableName = '" . $obj->tableName . "'";
		if ($obj->tableRemarks != '')
			$query .= " AND tableRemarks = '" . $obj->tableRemarks . "'";
		if ($obj->isApproval != '')
			$query .= " AND isApproval = '" . $obj->isApproval . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->inputUserId != '')
			$query .= " AND inputUserId = '" . $obj->inputUserId . "'";
		if ($obj->inputTime != '')
			$query .= " AND inputTime = '" . $obj->inputTime . "'";
		if ($obj->modifyUserId != '')
			$query .= " AND modifyUserId = '" . $obj->modifyUserId . "'";
		if ($obj->modifyTime != '')
			$query .= " AND modifyTime = '" . $obj->modifyTime . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_MainScheduleHistoryLog " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
// 		echo $sql;
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new MainScheduleHistoryLog ();
			$obj->mshlId = $rs ["mshlId"];
			$obj->backupMonth = $rs ["backupMonth"];
			$obj->tableName = $rs ["tableName"];
			$obj->tableRemarks = $rs ["tableRemarks"];
			$obj->isApproval = $rs ["isApproval"];
			$obj->delFlag = $rs ["delFlag"];
			$obj->inputUserId = $rs ["inputUserId"];
			$obj->inputTime = $rs ["inputTime"];
			$obj->modifyUserId = $rs ["modifyUserId"];
			$obj->modifyTime = $rs ["modifyTime"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 獲取有備份的月份
	 * 
	 * @param unknown_type $obj        	
	 * @return multitype:MainScheduleHistoryLog
	 */
	function GetDistinctMonth($obj) {
		$sql = "SELECT DISTINCT backupMonth FROM Survey_MainScheduleHistoryLog " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// echo $sql;
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new MainScheduleHistoryLog ();
			$obj->backupMonth = $rs ["backupMonth"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 備份指定月份的Main Schedule
	 * 
	 * @param MainscheduleHistoryLog $obj        	
	 */
	function BackupMonthMainSchedule($obj) {
		$surDateStart = $obj->backupMonth . "-01";
		$surDateStartTime = strtotime ( $surDateStart );
		$surveyDateEnd = date ( "Y-m-d", mktime ( 0, 0, 0, date ( "m", $surDateStartTime ) + 1, date ( "d", $surDateStartTime ), date ( "Y", $surDateStartTime ) ) );
		$obj->tableName = "Survey_MainSchedule_" . str_replace ( "-", "", $obj->backupMonth );
		// 表存在則刪除
		$sql = "DROP TABLE IF EXISTS {$obj->tableName};";
		$this->db->query ( $sql );
		
		// 備份數據
		$sql = "CREATE TABLE {$obj->tableName}
				SELECT * FROM Survey_MainSchedule 
				WHERE 1=1 
				  AND DATE_FORMAT(plannedSurveyDate,'%Y-%m-%d') >= '" . $surDateStart . "' 
				  AND DATE_FORMAT(plannedSurveyDate,'%Y-%m-%d') < '" . $surveyDateEnd . "' ";
		$this->db->query ( $sql );
		
		// 將備份記錄寫入指定的表
		$mshlId = $this->Add ( $obj );
		return $mshlId;
	}
	
	/**
	 * 审核通过备份
	 * 
	 * @param MainscheduleHistoryLog $obj
	 */
	function ApprovalBackupMonthMainSchedule($obj) {
		$sql = "UPDATE Survey_MainScheduleHistoryLog " . " SET isApproval = '" . $obj->isApproval . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " WHERE 1=1  AND mshlId = '" . $obj->mshlId . "'";
		$this->db->query ( $sql );
	}
}
?>