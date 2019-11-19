<?php
/*
 * Header: Create: 2011-11-02 Auther: James Wu<jamblues@gmail.com>.
 */
class SurveyorFreeTimeAccess {
	var $db;
	function SurveyorFreeTimeAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_SurveyorFreeTime(survId,jobNoNew,startTime,endTime,isFree,remarks,delFlag)" . " VALUES('" . $obj->survId . "'" . ",'" . $obj->jobNoNew . "'" . ",'" . $obj->startTime . "'" . ",'" . $obj->endTime . "'" . ",'" . $obj->isFree . "'" . ",'" . $obj->remarks . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_SurveyorFreeTime " . " SET survId = '" . $obj->survId . "'" . " ,jobNoNew = '" . $obj->jobNoNew . "'" . " ,startTime = '" . $obj->startTime . "'" . " ,endTime = '" . $obj->endTime . "'" . " ,isFree = '" . $obj->isFree . "'" . " ,remarks = '" . $obj->remarks . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND sftiId = '" . $obj->sftiId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_SurveyorFreeTime " . " SET delFlag='yes' " . " WHERE 1=1  AND sftiId = '" . $obj->sftiId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_SurveyorFreeTime " . " WHERE 1=1  AND sftiId = '" . $obj->sftiId . "'";
		$this->db->query ( $sql );
	}
	
	/**
	 * 根據傳入的日期範圍刪除數據
	 * 
	 * @param datetime $startTime        	
	 * @param datetime $endTime        	
	 */
	function RealDelByDate($survId, $startTime, $endTime) {
		$sql = "DELETE FROM Survey_SurveyorFreeTime WHERE survId={$survId} AND startTime>='{$startTime}' AND startTime<='{$endTime}'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->sftiId != '')
			$query .= " AND sftiId = '" . $obj->sftiId . "'";
		if ($obj->survId != '')
			$query .= " AND survId = '" . $obj->survId . "'";
		if ($obj->jobNoNew != '')
			$query .= " AND jobNoNew = '" . $obj->jobNoNew . "'";
		if ($obj->startTime != '')
			$query .= " AND startTime >= '" . $obj->startTime . "'";
		if ($obj->endTime != '')
			$query .= " AND endTime < '" . $obj->endTime . "'";
		if ($obj->isFree != '')
			$query .= " AND isFree = '" . $obj->isFree . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_SurveyorFreeTime " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new SurveyorFreeTime ();
			$obj->sftiId = $rs ["sftiId"];
			$obj->survId = $rs ["survId"];
			$obj->jobNoNew = $rs ["jobNoNew"];
			$obj->startTime = $rs ["startTime"];
			$obj->endTime = $rs ["endTime"];
			$obj->isFree = $rs ["isFree"];
			$obj->remarks = $rs ["remarks"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 撤銷該jobNoNew對應的時間
	 * 
	 * @param SurveyorFreeTime $obj        	
	 */
	function UnAdd($obj) {
		$sql = "DELETE FROM Survey_SurveyorFreeTime
				  WHERE 1=1 AND survId = '{$obj->survId}' AND jobNoNew = '{$obj->jobNoNew}'";
		$this->db->query ( $sql );
	}
	
	/**
	 * 取得忙碌的时间
	 * 
	 * @param Surveyor $obj        	
	 */
	function GetBusyTime($obj) {
		$query = '';
		if ($obj->survId != '')
			$query .= " AND survId = '" . $obj->survId . "'";
		if ($obj->startTime != '' && $obj->endTime != '')
			$query .= " AND ((startTime > '{$obj->startTime}' AND  startTime <= '{$obj->endTime}') OR (endTime > '{$obj->startTime}'AND endTime <= '{$obj->endTime}'))";
		if ($obj->order != '')
			$query .= $obj->order;
		
		$sql = "SELECT * FROM Survey_SurveyorFreeTime " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new SurveyorFreeTime ();
			$obj->sftiId = $rs ["sftiId"];
			$obj->survId = $rs ["survId"];
			$obj->jobNoNew = $rs ["jobNoNew"];
			$obj->startTime = $rs ["startTime"];
			$obj->endTime = $rs ["endTime"];
			$obj->delFlag = $rs ["delFlag"];
			$obj->isFree = $rs ["isFree"];
			$obj->remarks = $rs ["remarks"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 取得今天空闲的时间列表
	 * 
	 * @param date $currDay        	
	 * @param array $busyTimes        	
	 */
	function GetDayBusyTime($currDay, $busyTimes) {
		$currDayTime = strtotime ( $currDay );
		$daySchedules = "";
		$daySchedulesArray = array ();
		foreach ( $busyTimes as $v ) {
			$startTimeSpam = strtotime ( $v->startTime );
			$startDate = date ( "Y-m-d", $startTimeSpam );
			$startTime = date ( "H:i", $startTimeSpam );
			
			$endTimeSpam = strtotime ( $v->endTime );
			$endDate = date ( "Y-m-d", $endTimeSpam );
			$endTime = date ( "H:i", $endTimeSpam );
			if (strtotime ( $startDate ) <= $currDayTime && strtotime ( $endDate ) >= $currDayTime) {
				if (! in_array ( $startTime . " - " . $endTime, $daySchedulesArray )) {
					$daySchedulesArray [] = $startTime . " - " . $endTime;
					$remarks = empty($v->remarks)?$v->isFree:$v->isFree.":".$v->remarks;
					$daySchedules .= "<div class='s-d'><span class='s-t'>{$startTime}-{$endTime}({$remarks})</span></div>";
				}
			}
		}
		return $daySchedules;
	}
}
?>