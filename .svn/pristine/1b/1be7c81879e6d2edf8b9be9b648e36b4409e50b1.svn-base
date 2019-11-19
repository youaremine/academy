<?php
/*
 * Header: Create: 2008-05-02 Auther: Jamblues@gmail.com.
 */
class UserHistoryAccess {
	var $db;
	function UserHistoryAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_UserHistory(userId,jobId,type,action,startTime,endTime,loginIp)" . " VALUES('" . $obj->userId . "'" . ",'" . $obj->jobId . "'" . ",'" . $obj->type . "'" . ",'" . $obj->action . "'" . ",'" . $obj->startTime . "'" . ",'" . $obj->endTime . "'" . ",'" . $obj->loginIp . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_UserHistory " . " SET userId = '" . $obj->userId . "'" . " ,jobId = '" . $obj->jobId . "'" . " ,type = '" . $obj->type . "'" . " ,action = '" . $obj->action . "'" . " ,startTime = '" . $obj->startTime . "'" . " ,endTime = '" . $obj->endTime . "'" . " WHERE 1=1  AND ushiId = '" . $obj->ushiId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_UserHistory " . " SET delFlag='yes' " . " WHERE 1=1  AND ushiId = '" . $obj->ushiId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_UserHistory " . " WHERE 1=1  AND ushiId = '" . $obj->ushiId . "'";
		$this->db->query ( $sql );
	}
	
	/**
	 * 根据条件查找结果
	 *
	 * @param unknown_type $obj        	
	 * @return unknown
	 */
	function GetListSearch($obj) {
		$query = '';
		if ($obj->ushiId != '')
			$query .= " AND UH.ushiId = '" . $obj->ushiId . "'";
		if ($obj->userId != '')
			$query .= " AND UH.userId = '" . $obj->userId . "'";
		if ($obj->jobId != '')
			$query .= " AND UH.jobId = '" . $obj->jobId . "'";
		if ($obj->type != '')
			$query .= " AND UH.type = '" . $obj->type . "'";
		if ($obj->action != '')
			$query .= " AND UH.action = '" . $obj->action . "'";
		if ($obj->startTime != '')
			$query .= " AND UH.startTime = '" . $obj->startTime . "'";
		if ($obj->endTime != '')
			$query .= " AND UH.endTime = '" . $obj->endTime . "'";
		if ($obj->userName != '')
			$query .= " AND U.userName = '" . $obj->userName . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT UH.*,U.userName FROM Survey_UserHistory UH" . " INNER JOIN Survey_Users U ON U.userId = UH.userId" . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new UserHistory ();
			$obj->ushiId = $rs ["ushiId"];
			$obj->userId = $rs ["userId"];
			$obj->userName = $rs ["userName"];
			$obj->jobId = $rs ["jobId"];
			$obj->type = $rs ["type"];
			$obj->action = $rs ["action"];
			$obj->startTime = $rs ["startTime"];
			$obj->endTime = $rs ["endTime"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 统计条数
	 *
	 * @param unknown_type $obj        	
	 * @return unknown
	 */
	function GetListSearchTotal($obj) {
		$query = '';
		if ($obj->ushiId != '')
			$query .= " AND UH.ushiId = '" . $obj->ushiId . "'";
		if ($obj->userId != '')
			$query .= " AND UH.userId = '" . $obj->userId . "'";
		if ($obj->jobId != '')
			$query .= " AND UH.jobId = '" . $obj->jobId . "'";
		if ($obj->type != '')
			$query .= " AND UH.type = '" . $obj->type . "'";
		if ($obj->action != '')
			$query .= " AND UH.action = '" . $obj->action . "'";
		if ($obj->startTime != '')
			$query .= " AND UH.startTime = '" . $obj->startTime . "'";
		if ($obj->endTime != '')
			$query .= " AND UH.endTime = '" . $obj->endTime . "'";
		if ($obj->userName != '')
			$query .= " AND U.userName = '" . $obj->userName . "'";
		
		$sql = "SELECT COUNT(UH.ushiId) AS total FROM Survey_UserHistory UH" . " INNER JOIN Survey_Users U ON U.userId = UH.userId" . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$total = 0;
		if ($rs = $this->db->next_record ()) {
			$total = $rs ["total"];
		}
		return $total;
	}
}
?>