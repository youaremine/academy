<?php
/*
 * Header: Create: 2008-05-19 Auther: Jamblues@gmail.com.
 */
class MainSchedulePlannedDateAccess {
	var $db;
	function MainSchedulePlannedDateAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		global $conf;
		$msa = new MainScheduleAccess ( $this->db );
		$msa->UpdateOnePlannedSurveyDate ( $obj->jobNoNew, $obj->plannedSurveyDate );
		
		// 把旧的记录全部删除
		$sql = "UPDATE Survey_MainSchedulePlannedDate 
				SET delFlag='yes' , modifyTime = '".date ( $conf ['dateTime'] ['format'] )."'
				WHERE delFlag='no' AND jobNoNew='" . $obj->jobNoNew . "'";
		$this->db->query ( $sql );
		
		// 插入新的数据
		$sql = "INSERT INTO  Survey_MainSchedulePlannedDate(jobNoNew,plannedSurveyDate,userType,inputUserId,inputTime,modifyUserId,modifyTime,delFlag)" . " VALUES('" . $obj->jobNoNew . "'" . ",'" . $obj->plannedSurveyDate . "'" . ",'" . $obj->userType . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_MainSchedulePlannedDate " . " SET jobNoNew = '" . $obj->jobNoNew . "'" . " ,plannedSurveyDate = '" . $obj->plannedSurveyDate . "'" . " ,userType = '" . $obj->userType . "'" . " ,inputUserId = '" . $obj->inputUserId . "'" . " ,inputTime = '" . $obj->inputTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND mstd = '" . $obj->mstd . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_MainSchedulePlannedDate " . " SET delFlag='yes' " . " WHERE 1=1  AND mstd = '" . $obj->mstd . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_MainSchedulePlannedDate " . " WHERE 1=1  AND mstd = '" . $obj->mstd . "'";
		$this->db->query ( $sql );
	}
	function GetNotificationListSearch($obj) {
		$query = '';
		if ($obj->mstd != '')
			$query .= " AND mstd = '" . $obj->mstd . "'";
		if ($obj->jobNoNew != '')
			$query .= " AND jobNoNew LIKE '" . $obj->jobNoNew . "%'";
		if ($obj->plannedSurveyDate != '')
			$query .= " AND plannedSurveyDate = '" . $obj->plannedSurveyDate . "'";
		if ($obj->userType != '')
			$query .= " AND userType = '" . $obj->userType . "'";
		if ($obj->inputUserId != '')
			$query .= " AND inputUserId = '" . $obj->inputUserId . "'";
		if ($obj->inputTimeStart != '')
			$query .= " AND inputTime >= '" . $obj->inputTimeStart . "'";
		if ($obj->inputTimeEnd != '')
			$query .= " AND inputTime < '" . $obj->inputTimeEnd . "'";
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
		
		$sql = "SELECT * FROM Survey_MainSchedulePlannedDate " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
// 		echo $sql;
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new MainSchedulePlannedDate ();
			$obj->mstd = $rs ["mstd"];
			$obj->jobNoNew = $rs ["jobNoNew"];
			$obj->plannedSurveyDate = $rs ["plannedSurveyDate"];
			$obj->userType = $rs ["userType"];
			$obj->inputUserId = $rs ["inputUserId"];
			$obj->inputTime = $rs ["inputTime"];
			$obj->modifyUserId = $rs ["modifyUserId"];
			$obj->modifyTime = $rs ["modifyTime"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->mstd != '')
			$query .= " AND mstd = '" . $obj->mstd . "'";
		if ($obj->jobNoNew != '')
			$query .= " AND jobNoNew LIKE '" . $obj->jobNoNew . "%'";
		if ($obj->plannedSurveyDate != '')
			$query .= " AND plannedSurveyDate = '" . $obj->plannedSurveyDate . "'";
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
		
		$sql = "SELECT * FROM Survey_MainSchedulePlannedDate " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new MainSchedulePlannedDate ();
			$obj->mstd = $rs ["mstd"];
			$obj->jobNoNew = $rs ["jobNoNew"];
			$obj->plannedSurveyDate = $rs ["plannedSurveyDate"];
			$obj->userType = $rs ["userType"];
			$obj->inputUserId = $rs ["inputUserId"];
			$obj->inputTime = $rs ["inputTime"];
			$obj->modifyUserId = $rs ["modifyUserId"];
			$obj->modifyTime = $rs ["modifyTime"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 获取调查日期在系统中更改的列表
	 *
	 * @param string $jobNoNews
	 * @return number
	 */
	function GetSystemChangeJobNoNews($jobNoNews) {
		$query = '';
		if (empty ( $jobNoNews )) {
			return array ();
		}
		$query .= " AND JobNoNew IN ({$jobNoNews})";
	
		$sql = "SELECT * FROM Survey_MainSchedulePlannedDate 
				  WHERE 1=1 AND delFlag='no'";
		$sql = $sql . $query;
// 		echo $sql;
		$this->db->query ( $sql );
		$jobNoNews = array ();
		while ( $rs = $this->db->next_record () ) {
			$jobNoNews [$rs ['jobNoNew']]['plannedSurveyDate'] = $rs ['plannedSurveyDate'];
			$jobNoNews [$rs ['jobNoNew']]['inputUserId'] = $rs ['inputUserId'];
			$jobNoNews [$rs ['jobNoNew']]['inputTime'] = $rs ['inputTime'];
		}
		return $jobNoNews;
	}
}
?>