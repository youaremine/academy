<?php
/*
 * Header: Create: 2011-05-10 Auther: James Wu<jamblues@gmail.com>.
 */
class OtherSalaryAccess
{
	var $db;
	function OtherSalaryAccess($db)
	{
		$this->db = $db;
	}
	
	/**
	 * 新加
	 * @param OtherSalary $obj
	 */
	function Add($obj)
	{
		$sql = "INSERT INTO  Survey_OtherSalary(surveyorId,surveyorEngName,projectCode,projectName,surveyDate,startTime,endTime
				,restHour,surveyHour,hourlyRate,wages,transportExpenses,total,remarks
				,userId,userName,inputTime,auditStatus,salaryType,delFlag)
				 VALUES({$obj->surveyorId},'{$obj->surveyorEngName}','{$obj->projectCode}','{$obj->projectName}','{$obj->surveyDate}','{$obj->startTime}','{$obj->endTime}'
				 ,'{$obj->restHour}','{$obj->surveyHour}','{$obj->hourlyRate}','{$obj->wages}','{$obj->transportExpenses}','{$obj->total}','{$obj->remarks}'
				,{$obj->userId},'{$obj->userName}','{$obj->inputTime}','{$obj->auditStatus}','{$obj->salaryType}','{$obj->delFlag}')";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}
	
	/**
	 * 更新
	 * @param OtherSalary $obj
	 */
	function Update($obj)
	{
		$sql = "UPDATE Survey_OtherSalary SET surveyorId ={$obj->surveyorId},surveyorEngName ='{$obj->surveyorEngName}',projectCode ='{$obj->projectCode}' 
					,projectName ='{$obj->projectName}',surveyDate ='{$obj->surveyDate}',startTime='{$obj->startTime}',endTime='{$obj->endTime}'
					,restHour ='{$obj->restHour}',surveyHour ='{$obj->surveyHour}',hourlyRate ='{$obj->hourlyRate}',wages ='{$obj->wages}',transportExpenses ='{$obj->transportExpenses}'
					,total ='{$obj->total}',remarks ='{$obj->remarks}',attachment ='{$obj->attachment}',modifyTime ='{$obj->modifyTime}',modifyUserId ={$obj->modifyUserId}
					,modifyUserName ='{$obj->modifyUserName}',auditStatus='{$obj->auditStatus}',salaryType='{$obj->salaryType}',delFlag ='{$obj->delFlag}' 
					WHERE 1=1  AND otId ='{$obj->otId}'";
		$this->db->query($sql);
	}
	
	/**
	 * 更新狀態
	 * @param string $otId
	 */
	function UpdateStatus($otId,$auditStatus)
	{
		$dt = date("Y-m-d H:i:s");
		$sql = "UPDATE Survey_OtherSalary SET auditUserId = '{$_SESSION['userId']}',auditTime = '{$dt}',auditStatus = '{$auditStatus}'
					WHERE 1=1  AND otId ='{$otId}'";
		$this->db->query($sql);
	}
	
	function Del($obj)
	{
		$sql = "UPDATE Survey_OtherSalary " . " SET delFlag='yes' " . " WHERE 1=1  AND otId = '" . $obj->otId . "'";
		$this->db->query($sql);
	}
	
	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_OtherSalary " . " WHERE 1=1  AND otId = '" . $obj->otId . "'";
		$this->db->query($sql);
	}

	/**
	 * @param $obj
	 * @return array
	 */
	function GetListSearch($obj)
	{
		$query = '';
		if ($obj->otId != '')
			$query .= " AND otId = '" . $obj->otId . "'";
		if ($obj->surveyorId != '')
			$query .= " AND surveyorId = '" . $obj->surveyorId . "'";
		if ($obj->surveyorEngName != '')
			$query .= " AND surveyorEngName = '" . $obj->surveyorEngName . "'";
		if ($obj->projectCode != '')
			$query .= " AND projectCode = '" . $obj->projectCode . "'";
		if ($obj->projectName != '')
			$query .= " AND projectName = '" . $obj->projectName . "'";
		if ($obj->surveyDate != '')
			$query .= " AND surveyDate = '" . $obj->surveyDate . "'";
		if ($obj->surveyHour != '')
			$query .= " AND surveyHour = '" . $obj->surveyHour . "'";
		if ($obj->hourlyRate != '')
			$query .= " AND hourlyRate = '" . $obj->hourlyRate . "'";
		if ($obj->wages != '')
			$query .= " AND wages = '" . $obj->wages . "'";
		if ($obj->transportExpenses != '')
			$query .= " AND transportExpenses = '" . $obj->transportExpenses . "'";
		if ($obj->total != '')
			$query .= " AND total = '" . $obj->total . "'";
		if ($obj->remarks != '')
			$query .= " AND remarks = '" . $obj->remarks . "'";
		if ($obj->userId != '')
			$query .= " AND userId = '" . $obj->userId . "'";
		if ($obj->userName != '')
			$query .= " AND userName = '" . $obj->userName . "'";
		if ($obj->inputTime != '')
			$query .= " AND inputTime = '" . $obj->inputTime . "'";
		if ($obj->modifyTime != '')
			$query .= " AND modifyTime = '" . $obj->modifyTime . "'";
		if ($obj->modifyUserId != '')
			$query .= " AND modifyUserId = '" . $obj->modifyUserId . "'";
		if ($obj->modifyUserName != '')
			$query .= " AND modifyUserName = '" . $obj->modifyUserName . "'";
		if ($obj->salaryType != '')
			$query .= " AND salaryType = '" . $obj->salaryType . "'";
		if ($obj->auditStatus != '')
			$query .= " AND auditStatus = '" . $obj->auditStatus . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->surveyDateStart != '')
			$query .= " AND surveyDate >= '" . $obj->surveyDateStart . "'";
		if ($obj->surveyDateEnd != '')
			$query .= " AND surveyDate < '" . $obj->surveyDateEnd . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_OtherSalary " . " WHERE 1=1 ";
		$sql = $sql . $query;
// 		echo $sql;
		$this->db->query($sql);
		$rows = array();
		while ( $rs = $this->db->next_record() )
		{
			$obj = new OtherSalary();
			$obj->otId = $rs["otId"];
			$obj->surveyorId = $rs["surveyorId"];
			$obj->surveyorEngName = $rs["surveyorEngName"];
			$obj->projectCode = $rs["projectCode"];
			$obj->projectName = $rs["projectName"];
			$obj->surveyDate = $rs["surveyDate"];
			$obj->startTime = substr($rs["startTime"],0,5);
			$obj->endTime = substr($rs["endTime"],0,5);
			$obj->restHour = $rs["restHour"];
			$obj->surveyHour = $rs["surveyHour"];
			$obj->hourlyRate = $rs["hourlyRate"];
			$obj->wages = $rs["wages"];
			$obj->transportExpenses = $rs["transportExpenses"];
			$obj->total = $rs["total"];
			$obj->remarks = $rs["remarks"];
			$obj->attachment = $rs["attachment"];
			$obj->userId = $rs["userId"];
			$obj->userName = $rs["userName"];
			$obj->inputTime = $rs["inputTime"];
			$obj->modifyTime = $rs["modifyTime"];
			$obj->modifyUserId = $rs["modifyUserId"];
			$obj->modifyUserName = $rs["modifyUserName"];
			$obj->auditTime = $rs["auditTime"];
			$obj->auditUserId = $rs["auditUserId"];
			$obj->auditStatus = $rs["auditStatus"];
			$obj->salaryType = $rs["salaryType"];
			$obj->delFlag = $rs["delFlag"];
			$rows[] = $obj;
		}
		return $rows;
	}

	/**
	 * @param $jobNoNews
	 * @return array
	 */
	function GetListByJobNoNews($jobNoNews)
	{
		if(empty($jobNoNews)){
			return array();
		}
		$query = '';
		if ($jobNoNews != '')
			$query .= " AND jobNoNew IN ({$jobNoNews})";

		$sql = "SELECT * FROM Survey_OtherSalary " . " WHERE 1=1 ";
		$sql = $sql . $query;
// 		echo $sql;
		$this->db->query($sql);
		$rows = array();
		while ( $rs = $this->db->next_record() )
		{
			$obj = new OtherSalary();
			$obj->otId = $rs["otId"];
			$obj->surveyorId = $rs["surveyorId"];
			$obj->surveyorEngName = $rs["surveyorEngName"];
			$obj->projectCode = $rs["projectCode"];
			$obj->projectName = $rs["projectName"];
			$obj->surveyDate = $rs["surveyDate"];
			$obj->startTime = substr($rs["startTime"],0,5);
			$obj->endTime = substr($rs["endTime"],0,5);
			$obj->restHour = $rs["restHour"];
			$obj->surveyHour = $rs["surveyHour"];
			$obj->hourlyRate = $rs["hourlyRate"];
			$obj->wages = $rs["wages"];
			$obj->transportExpenses = $rs["transportExpenses"];
			$obj->total = $rs["total"];
			$obj->remarks = $rs["remarks"];
			$obj->attachment = $rs["attachment"];
			$obj->userId = $rs["userId"];
			$obj->userName = $rs["userName"];
			$obj->inputTime = $rs["inputTime"];
			$obj->modifyTime = $rs["modifyTime"];
			$obj->modifyUserId = $rs["modifyUserId"];
			$obj->modifyUserName = $rs["modifyUserName"];
			$obj->auditTime = $rs["auditTime"];
			$obj->auditUserId = $rs["auditUserId"];
			$obj->auditStatus = $rs["auditStatus"];
			$obj->salaryType = $rs["salaryType"];
			$obj->jobNoNew = $rs["jobNoNew"];
			$obj->delFlag = $rs["delFlag"];
			$rows[$rs["jobNoNew"]] = $obj;
		}
		return $rows;
	}
}
?>