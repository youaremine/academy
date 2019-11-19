<?php
/*
 * Header: Create: 2008-10-27 Auther: Jamblues@gmail.com.
 */
class ProgressDataAccess {
	var $db;
	function ProgressDataAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_ProgressData(weekNo,totalType,complateJobNo,estimatedManHour,delFlag)" . " VALUES('" . $obj->weekNo . "'" . ",'" . $obj->totalType . "'" . ",'" . $obj->complateJobNo . "'" . ",'" . $obj->estimatedManHour . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_ProgressData " . " SET weekNo = '" . $obj->weekNo . "'" . " ,totalType = '" . $obj->totalType . "'" . " ,complateJobNo = '" . $obj->complateJobNo . "'" . " ,estimatedManHour = '" . $obj->estimatedManHour . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND prda = '" . $obj->prda . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_ProgressData " . " SET delFlag='yes' " . " WHERE 1=1  AND prda = '" . $obj->prda . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_ProgressData " . " WHERE 1=1  AND prda = '" . $obj->prda . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		global $conf;
		$survey_start_date = $conf ['survey_start_date'] ['all'];
		$query = '';
		if ($obj->complateJobNo != '') {
			$query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
			$survey_start_date = $conf ['survey_start_date'] [$obj->complateJobNo];
		} else {
			$doComplateJobNo = UserLogin::CanDoComplateJobNo ();
			$query .= " AND complateJobNo IN (" . $doComplateJobNo . ")";
		}
		
		$sql = "SELECT weekNo,estimatedManHour
				FROM Survey_MainSchedule 
				WHERE 1=1 AND jobNoNew NOT LIKE '%ss'
				  AND receivedDate <> '' ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// print $sql;exit();
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new ProgressData ();
			$obj->prda = $rs ["prda"];
			$obj->weekNo = $rs ["weekNo"];
			$obj->totalType = $rs ["totalType"];
			$obj->complateJobNo = $rs ["complateJobNo"];
			$obj->estimatedManHour = $rs ["estimatedManHour"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * Received Hours统计数据
	 *
	 * @param ProgressData $obj        	
	 */
	function GetListReceivedHours($obj) {
		global $conf;
		$survey_start_date = $conf ['survey_start_date'] ['all'];
		$query = '';
		if ($obj->complateJobNo != '') {
			$query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
			$survey_start_date = $conf ['survey_start_date'] [$obj->complateJobNo];
		} else {
			$doComplateJobNo = UserLogin::CanDoComplateJobNo ();
			$query .= " AND complateJobNo IN (" . $doComplateJobNo . ")";
		}
		
		$sql = "SELECT CEILING(((TO_DAYS(receivedDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7) AS weekNo
					,SUM(estimatedManHour) AS estimatedManHour
				FROM Survey_MainSchedule 
				WHERE 1=1 AND jobNoNew NOT LIKE '%ss'
				  AND receivedDate <> '' ";
		$sql = $sql . $query;
		$sql = $sql . "
				GROUP BY CEILING(((TO_DAYS(receivedDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7)
				ORDER BY CEILING(((TO_DAYS(receivedDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7)";
		$this->db->query ( $sql );
		// print $sql;exit();
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new ProgressData ();
			$obj->prda = $rs ["prda"];
			$obj->weekNo = $rs ["weekNo"];
			$obj->totalType = $rs ["totalType"];
			$obj->complateJobNo = $rs ["complateJobNo"];
			$obj->estimatedManHour = $rs ["estimatedManHour"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * Forms Prepared 统计数据
	 *
	 * @param ProgressData $obj        	
	 */
	function GetListFormsPrepared($obj) {
		global $conf;
		$survey_start_date = $conf ['survey_start_date'] ['all'];
		$query = '';
		if ($obj->complateJobNo != '') {
			$query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
			$survey_start_date = $conf ['survey_start_date'] [$obj->complateJobNo];
		} else {
			$doComplateJobNo = UserLogin::CanDoComplateJobNo ();
			$query .= " AND complateJobNo IN (" . $doComplateJobNo . ")";
		}
		
		$sql = "SELECT CEILING(((TO_DAYS(receivedDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7) AS weekNo
					,SUM(estimatedManHour) AS estimatedManHour
				FROM Survey_MainSchedule 
				WHERE 1=1 AND jobNoNew NOT LIKE '%ss'
				  AND receivedDate <> '' 
				  AND distributedToLeader <> '' ";
		$sql = $sql . $query;
		$sql = $sql . "
				GROUP BY CEILING(((TO_DAYS(receivedDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7)
				ORDER BY CEILING(((TO_DAYS(receivedDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7)";
		$this->db->query ( $sql );
		// print $sql;exit();
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new ProgressData ();
			$obj->prda = $rs ["prda"];
			$obj->weekNo = $rs ["weekNo"];
			$obj->totalType = $rs ["totalType"];
			$obj->complateJobNo = $rs ["complateJobNo"];
			$obj->estimatedManHour = $rs ["estimatedManHour"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * Arranged Hours统计数据
	 *
	 * @param ProgressData $obj        	
	 */
	function GetListArrangedHours($obj) {
		global $conf;
		$survey_start_date = $conf ['survey_start_date'] ['all'];
		$query = '';
		if ($obj->complateJobNo != '') {
			$query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
			$survey_start_date = $conf ['survey_start_date'] [$obj->complateJobNo];
		} else {
			$doComplateJobNo = UserLogin::CanDoComplateJobNo ();
			$query .= " AND complateJobNo IN (" . $doComplateJobNo . ")";
		}
		
		$sql = "SELECT CEILING(((TO_DAYS(plannedSurveyDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7) AS weekNo
					,SUM(estimatedManHour) AS estimatedManHour
				FROM Survey_MainSchedule 
				WHERE 1=1 AND jobNoNew NOT LIKE '%ss'
				  AND plannedSurveyDate <> '' ";
		$sql = $sql . $query;
		$sql = $sql . "
				GROUP BY CEILING(((TO_DAYS(plannedSurveyDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7)
				ORDER BY CEILING(((TO_DAYS(plannedSurveyDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7)";
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new ProgressData ();
			$obj->prda = $rs ["prda"];
			$obj->weekNo = $rs ["weekNo"];
			$obj->totalType = $rs ["totalType"];
			$obj->complateJobNo = $rs ["complateJobNo"];
			$obj->estimatedManHour = $rs ["estimatedManHour"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * Surveyed Hours统计数据
	 *
	 * @param ProgressData $obj        	
	 */
	function GetListSurveyedHours($obj) {
		global $conf;
		$survey_start_date = $conf ['survey_start_date'] ['all'];
		$query = '';
		if ($obj->complateJobNo != '') {
			$query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
			$survey_start_date = $conf ['survey_start_date'] [$obj->complateJobNo];
		} else {
			$doComplateJobNo = UserLogin::CanDoComplateJobNo ();
			$query .= " AND complateJobNo IN (" . $doComplateJobNo . ")";
		}
		
		$case = "CASE complateJobNo";
		foreach ( $conf ['complateJobNo'] as $v ) {
			$case .= " WHEN '{$v}' THEN '{$conf['survey_start_date'][$v]}'";
		}
		$case .= " END";
		$sql = "SELECT CEILING(((TO_DAYS(plannedSurveyDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7) AS weekNo
					,SUM(estimatedManHour) AS estimatedManHour
					,SUM(onBoardCostFare*noOfTrips/(" . $case . ")) AS totalOnBoardCostFare
				FROM Survey_MainSchedule 
				WHERE 1=1 AND jobNoNew NOT LIKE '%ss'
				  AND plannedSurveyDate <> '' ";
		$sql = $sql . $query;
		$sql = $sql . "
				GROUP BY CEILING(((TO_DAYS(plannedSurveyDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7)
				ORDER BY CEILING(((TO_DAYS(plannedSurveyDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7)";
		$this->db->query ( $sql );
		// echo "{$sql}<br />";exit();
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new ProgressData ();
			$obj->prda = $rs ["prda"];
			$obj->weekNo = $rs ["weekNo"];
			$obj->totalType = $rs ["totalType"];
			$obj->complateJobNo = $rs ["complateJobNo"];
			$obj->estimatedManHour = $rs ["estimatedManHour"] + $rs ["totalOnBoardCostFare"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * Received Forms 统计数据
	 *
	 * @param string $complateJobNo        	
	 */
	function GetListReceivedForms($obj) {
		global $conf;
		$survey_start_date = $conf ['survey_start_date'] ['all'];
		$query = '';
		if ($obj->complateJobNo != '') {
			$query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
			$survey_start_date = $conf ['survey_start_date'] [$obj->complateJobNo];
		} else {
			$doComplateJobNo = UserLogin::CanDoComplateJobNo ();
			$query .= " AND complateJobNo IN (" . $doComplateJobNo . ")";
		}
		
		$sql = "SELECT CEILING(((TO_DAYS(receiveDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7) AS weekNo
					,SUM(estimatedManHour) AS estimatedManHour
				FROM Survey_MainSchedule 
				WHERE 1=1 AND jobNoNew NOT LIKE '%ss'
				  AND receiveDate <> '' ";
		$sql = $sql . $query;
		$sql = $sql . "
				GROUP BY CEILING(((TO_DAYS(receiveDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7)
				ORDER BY CEILING(((TO_DAYS(receiveDate)-TO_DAYS('" . $survey_start_date . "'))+1)/7)";
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new ProgressData ();
			$obj->prda = $rs ["prda"];
			$obj->weekNo = $rs ["weekNo"];
			$obj->totalType = $rs ["totalType"];
			$obj->complateJobNo = $rs ["complateJobNo"];
			$obj->estimatedManHour = $rs ["estimatedManHour"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * Reported Hours统计数据
	 *
	 * @param ProgressData $obj        	
	 */
	function GetListReportedHours($obj) {
		global $conf;
		$survey_start_date = $conf ['survey_start_date'] ['all'];
		$query = '';
		if ($obj->complateJobNo != '') {
			$query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
			$survey_start_date = $conf ['survey_start_date'] [$obj->complateJobNo];
		} else {
			$doComplateJobNo = UserLogin::CanDoComplateJobNo ();
			$query .= " AND complateJobNo IN (" . $doComplateJobNo . ")";
		}
		
		$sql = "SELECT CEILING(((TO_DAYS(report)-TO_DAYS('" . $survey_start_date . "'))+1)/7) AS weekNo
					,SUM(estimatedManHour) AS estimatedManHour
				FROM Survey_MainSchedule 
				WHERE 1=1 AND jobNoNew NOT LIKE '%ss'
				  AND report <> '' ";
		$sql = $sql . $query;
		$sql = $sql . "
				GROUP BY CEILING(((TO_DAYS(report)-TO_DAYS('" . $survey_start_date . "'))+1)/7)
				ORDER BY CEILING(((TO_DAYS(report)-TO_DAYS('" . $survey_start_date . "'))+1)/7)";
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new ProgressData ();
			$obj->prda = $rs ["prda"];
			$obj->weekNo = $rs ["weekNo"];
			$obj->totalType = $rs ["totalType"];
			$obj->complateJobNo = $rs ["complateJobNo"];
			$obj->estimatedManHour = $rs ["estimatedManHour"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>