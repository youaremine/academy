<?php
/*
 * Header: Create: 2013-10-15 Auther: James Wu<jamblues@gmail.com>.
 */
class FlowJobInfoAccess {
	var $db;
	function FlowJobInfoAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO Survey_FlowJobInfo(porjId,jobTitle,jobNo,intervalMinutes,surveyDate,periodStartTime,periodEndTime,period2StartTime,period2EndTime,period3StartTime,period3EndTime,flowChartTemplate,growthRate,remark,inputUserId,inputTime,updateUserId,updateTime,delFlag)" . " VALUES('" . $obj->porjId . "'" . ",'" . $obj->jobTitle . "'" . ",'" . $obj->jobNo . "'" . ",'" . $obj->intervalMinutes . "'" . ",'" . $obj->surveyDate . "'" . ",'" . $obj->periodStartTime . "'" . ",'" . $obj->periodEndTime . "'" . ",'" . $obj->period2StartTime . "'" . ",'" . $obj->period2EndTime . "'" . ",'" . $obj->period3StartTime . "'" . ",'" . $obj->period3EndTime . "'" . ",'" . $obj->flowChartTemplate . "'" . ",'" . $obj->growthRate . "'" . ",'" . $obj->remark . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->updateUserId . "'" . ",'" . $obj->updateTime . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		if (empty ( $obj->period2StartTime ))
			$obj->period2StartTime = 'NULL';
		else
			$obj->period2StartTime = "'{$obj->period2StartTime}'";
		if (empty ( $obj->period2EndTime ))
			$obj->period2EndTime = 'NULL';
		else
			$obj->period2EndTime = "'{$obj->period2EndTime}'";
		if (empty ( $obj->period3StartTime ))
			$obj->period3StartTime = 'NULL';
		else
			$obj->period3StartTime = "'{$obj->period3StartTime}'";
		if (empty ( $obj->period3EndTime ))
			$obj->period3EndTime = 'NULL';
		else
			$obj->period3EndTime = "'{$obj->period3EndTime}'";
		$sql = "UPDATE Survey_FlowJobInfo " . " SET porjId = '" . $obj->porjId . "'" . " ,jobTitle = '" . $obj->jobTitle . "'" . " ,jobNo = '" . $obj->jobNo . "'" . " ,intervalMinutes = '" . $obj->intervalMinutes . "'" . " ,surveyDate = '" . $obj->surveyDate . "'" . " ,periodStartTime = '" . $obj->periodStartTime . "'" . " ,periodEndTime = '" . $obj->periodEndTime . "'" . " ,period2StartTime = " . $obj->period2StartTime . "" . " ,period2EndTime = " . $obj->period2EndTime . "" . " ,period3StartTime = " . $obj->period3StartTime . "" . " ,flowChartTemplate = '" . $obj->flowChartTemplate . "'" . " ,period3EndTime = " . $obj->period3EndTime . "" . " ,growthRate = '" . $obj->growthRate . "'" . " ,remark = '" . $obj->remark . "'" . " ,updateUserId = '" . $obj->updateUserId . "'" . " ,updateTime = '" . $obj->updateTime . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND joinId = '" . $obj->joinId . "'";
		// echo $sql;
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_FlowJobInfo " . " SET delFlag='yes' " . " WHERE 1=1  AND joinId = '" . $obj->joinId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_FlowJobInfo " . " WHERE 1=1  AND joinId = '" . $obj->joinId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->joinId != '')
			$query .= " AND joinId = '" . $obj->joinId . "'";
		if ($obj->porjId != '')
			$query .= " AND porjId = '" . $obj->porjId . "'";
		if ($obj->jobTitle != '')
			$query .= " AND jobTitle = '" . $obj->jobTitle . "'";
		if ($obj->jobNo != '')
			$query .= " AND jobNo = '" . $obj->jobNo . "'";
		if ($obj->intervalMinutes != '')
			$query .= " AND intervalMinutes = '" . $obj->intervalMinutes . "'";
		if ($obj->surveyDate != '')
			$query .= " AND surveyDate = '" . $obj->surveyDate . "'";
		if ($obj->flowChartTemplate != '')
			$query .= " AND flowChartTemplate = '" . $obj->flowChartTemplate . "'";
		if ($obj->remark != '')
			$query .= " AND remark = '" . $obj->remark . "'";
		if ($obj->growthRate != '')
			$query .= " AND growthRate = '" . $obj->growthRate . "'";
		if ($obj->inputUserId != '')
			$query .= " AND inputUserId = '" . $obj->inputUserId . "'";
		if ($obj->inputTime != '')
			$query .= " AND inputTime = '" . $obj->inputTime . "'";
		if ($obj->updateUserId != '')
			$query .= " AND updateUserId = '" . $obj->updateUserId . "'";
		if ($obj->updateTime != '')
			$query .= " AND updateTime = '" . $obj->updateTime . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_FlowJobInfo " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = $this->BindObj($rs);
			$rows [] = $obj;
		}
		return $rows;
	}

	/**
	 * 获取单条记录
	 * @param $uniqueId
	 * @return FlowJobInfo
	 */
	function GetSingleByUniqueId($uniqueId) {
		$sql = "SELECT joinId FROM Survey_FlowJobInfo WHERE 1=1 AND uniqueId='{$uniqueId}'";
		$this->db->query ($sql);
		$rs = $this->db->next_record();
		$obj = $this->BindObj($rs);
		return $obj;
	}

	function BindObj($rs){
		$obj = new FlowJobInfo ();
		$obj->joinId = $rs ["joinId"];
		$obj->porjId = $rs ["porjId"];
		$obj->jobTitle = $rs ["jobTitle"];
		$obj->jobNo = $rs ["jobNo"];
		$obj->intervalMinutes = $rs ["intervalMinutes"];
		$obj->surveyDate = $rs ["surveyDate"];
		$obj->periodStartTime = $rs ["periodStartTime"];
		$obj->periodEndTime = $rs ["periodEndTime"];
		$obj->period2StartTime = $rs ["period2StartTime"];
		$obj->period2EndTime = $rs ["period2EndTime"];
		$obj->period3StartTime = $rs ["period3StartTime"];
		$obj->period3EndTime = $rs ["period3EndTime"];
		$obj->flowChartTemplate = $rs ["flowChartTemplate"];
		$obj->growthRate = $rs ["growthRate"];
		$obj->remark = $rs ["remark"];
		$obj->inputUserId = $rs ["inputUserId"];
		$obj->inputTime = $rs ["inputTime"];
		$obj->updateUserId = $rs ["updateUserId"];
		$obj->updateTime = $rs ["updateTime"];
		$obj->delFlag = $rs ["delFlag"];
		return $obj;
	}
}
?>