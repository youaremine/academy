<?php
/*
 * Header: 
 * Create: 2015-01-22
 * Auther: James Wu<jamblues@gmail.com>.
 */
class OtherSalaryHistoryLogAccess
{
	var $db;

	function OtherSalaryHistoryLogAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_OtherSalaryHistoryLog(backupMonth,tableName,tableRemarks,backupType,isApproval,delFlag,inputUserId,inputTime,modifyUserId,modifyTime)".
			" VALUES('".$obj->backupMonth."'".
			",'".$obj->tableName."'".
			",'".$obj->tableRemarks."'".
			",'".$obj->backupType."'".
			",'".$obj->isApproval."'".
			",'".$obj->delFlag."'".
			",'".$obj->inputUserId."'".
			",'".$obj->inputTime."'".
			",'".$obj->modifyUserId."'".
			",'".$obj->modifyTime."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_OtherSalaryHistoryLog ".
			" SET backupMonth = '".$obj->backupMonth."'".
			" ,tableName = '".$obj->tableName."'".
			" ,tableRemarks = '".$obj->tableRemarks."'".
			" ,backupType = '".$obj->backupType."'".
			" ,isApproval = '".$obj->isApproval."'".
			" ,delFlag = '".$obj->delFlag."'".
			" ,inputUserId = '".$obj->inputUserId."'".
			" ,inputTime = '".$obj->inputTime."'".
			" ,modifyUserId = '".$obj->modifyUserId."'".
			" ,modifyTime = '".$obj->modifyTime."'".
			" WHERE 1=1  AND oshlId = '".$obj->oshlId."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_OtherSalaryHistoryLog ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND oshlId = '".$obj->oshlId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_OtherSalaryHistoryLog ".
			" WHERE 1=1  AND oshlId = '".$obj->oshlId."'";
		$this->db->query($sql);
	}

	function GetListSearch($obj)
	{
		$query = '';
		if($obj->oshlId != '')
			$query .= " AND oshlId = '".$obj->oshlId."'";
		if($obj->backupMonth != '')
			$query .= " AND backupMonth = '".$obj->backupMonth."'";
		if($obj->tableName != '')
			$query .= " AND tableName = '".$obj->tableName."'";
		if($obj->tableRemarks != '')
			$query .= " AND tableRemarks = '".$obj->tableRemarks."'";
		if($obj->backupType != '')
			$query .= " AND backupType = '".$obj->backupType."'";
		if($obj->isApproval != '')
			$query .= " AND isApproval = '".$obj->isApproval."'";
		if($obj->delFlag != '')
			$query .= " AND delFlag = '".$obj->delFlag."'";
		if($obj->inputUserId != '')
			$query .= " AND inputUserId = '".$obj->inputUserId."'";
		if($obj->inputTime != '')
			$query .= " AND inputTime = '".$obj->inputTime."'";
		if($obj->modifyUserId != '')
			$query .= " AND modifyUserId = '".$obj->modifyUserId."'";
		if($obj->modifyTime != '')
			$query .= " AND modifyTime = '".$obj->modifyTime."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_OtherSalaryHistoryLog ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new OtherSalaryHistoryLog();
			$obj->oshlId = $rs["oshlId"];
			$obj->backupMonth = $rs["backupMonth"];
			$obj->tableName = $rs["tableName"];
			$obj->tableRemarks = $rs["tableRemarks"];
			$obj->backupType = $rs["backupType"];
			$obj->isApproval = $rs["isApproval"];
			$obj->delFlag = $rs["delFlag"];
			$obj->inputUserId = $rs["inputUserId"];
			$obj->inputTime = $rs["inputTime"];
			$obj->modifyUserId = $rs["modifyUserId"];
			$obj->modifyTime = $rs["modifyTime"];
			$rows[] = $obj;
		}
		return $rows;
	}
	


	/**
	 * 獲取有備份的月份
	 *
	 * @param unknown_type $obj
	 * @return multitype:OtherSalaryHistoryLog
	 */
	function GetDistinctMonth($obj) {
		$sql = "SELECT DISTINCT backupMonth FROM Survey_OtherSalaryHistoryLog " . " WHERE 1=1 ";
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
	 * @param OtherSalaryHistoryLog $obj
	 */
	function BackupMonthOtherSalary($obj) {
		$surDateStart = $obj->backupMonth . "-01";
		$obj->tableName = "Survey_OtherSalary";	
		// 將備份記錄寫入指定的表
		$oshlId = $this->Add ( $obj );
		return $oshlId;
	}
	
	/**
	* 审核通过备份
	*
	* @param OtherSalaryHistoryLog $obj
	*/
	function ApprovalBackupMonthOtherSalary($obj) {
	$sql = "UPDATE Survey_OtherSalaryHistoryLog 
				SET isApproval = '{$obj->isApproval}' ,modifyUserId = '{$obj->modifyUserId}' ,modifyTime = '{$obj->modifyTime}' 
				WHERE 1=1  AND oshlId = '{$obj->oshlId}'";
		$this->db->query ( $sql );
	}

}
?>