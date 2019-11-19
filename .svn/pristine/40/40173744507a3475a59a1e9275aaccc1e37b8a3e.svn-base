<?php
/*
 * Header:
 * Create: 2016-11-28
 * Auther: James Wu<jamblues@gmail.com>.
 */
class ChartAccess {
	var $db;
	function ChartAccess($db) {
		$this->db = $db;
	}

	/**
	 * 获取指定时间内每天的调查表格人数
	 * @param $distId
	 * @param $plannedSurveyDateStart
	 * @param $plannedSurveyDateEnd
	 * @return array
	 */
	function GetFormCount($distId,$plannedSurveyDateStart,$plannedSurveyDateEnd) {
		$query = '';
		if ($distId != '')
			$query .= " AND jobNoNew LIKE '{$distId}%'";
		if ($plannedSurveyDateStart != '')
			$query .= " AND plannedSurveyDate >= '{$plannedSurveyDateStart}'";
		if ($plannedSurveyDateEnd != '')
			$query .= " AND plannedSurveyDate <= '{$plannedSurveyDateEnd}'";
		
		$sql = "SELECT plannedSurveyDate,COUNT(*) AS total FROM Survey_MainSchedule WHERE 1=1 ";
		$sql = $sql . $query;
		$sql .= " GROUP BY plannedSurveyDate";
		$this->db->query($sql);
		$rows = array();
		while ($rs = $this->db->next_record()) {
			$rows[$rs["plannedSurveyDate"]] = $rs["total"];
		}
		return $rows;
	}

	/**
	 * 获取指定时间内每天的调查員人数
	 * @param $distId
	 * @param $plannedSurveyDateStart
	 * @param $plannedSurveyDateEnd
	 * @return array
	 */
	function GetSurveyorCount($distId,$plannedSurveyDateStart,$plannedSurveyDateEnd) {
		$query = '';
		if ($distId != '')
			$query .= " AND jobNoNew LIKE '{$distId}%'";
		if ($plannedSurveyDateStart != '')
			$query .= " AND plannedSurveyDate >= '{$plannedSurveyDateStart}'";
		if ($plannedSurveyDateEnd != '')
			$query .= " AND plannedSurveyDate <= '{$plannedSurveyDateEnd}'";
		$query .= " AND surveyorCode != ''";

		$sql = "SELECT plannedSurveyDate,GROUP_CONCAT(DISTINCT surveyorCode) AS surveyorCodes FROM Survey_MainSchedule WHERE 1=1 ";
		$sql .= $query;
		$sql .= " GROUP BY plannedSurveyDate";
		$this->db->query($sql);
		$rows = array();
		while ($rs = $this->db->next_record()) {
			$tmp = explode(',',$rs['surveyorCodes']);
			$rows[$rs["plannedSurveyDate"]] = count($tmp);
		}
		return $rows;
	}
}
?>