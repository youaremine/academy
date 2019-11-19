<?php
/*
 * Header: 
 * Create: 2018-07-05
 * Auther: James Wu<jamblues@gmail.com>.
 */
class SurveyJobOpenAccess
{
	var $db;

	function SurveyJobOpenAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_SurveyJobOpen(jobNo,isOpen,inputUserId,inputTime,modifyUserId,modifyTime,delFlag)".
			" VALUES('".$obj->jobNo."'".
			",'".$obj->isOpen."'".
			",'".$obj->inputUserId."'".
			",'".$obj->inputTime."'".
			",'".$obj->modifyUserId."'".
			",'".$obj->modifyTime."'".
			",'".$obj->delFlag."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_SurveyJobOpen ".
			" SET jobNo = '".$obj->jobNo."'".
			" ,isOpen = '".$obj->isOpen."'".
			" ,inputUserId = '".$obj->inputUserId."'".
			" ,inputTime = '".$obj->inputTime."'".
			" ,modifyUserId = '".$obj->modifyUserId."'".
			" ,modifyTime = '".$obj->modifyTime."'".
			" ,delFlag = '".$obj->delFlag."'".
			" WHERE 1=1  AND sjop = '".$obj->sjop."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_SurveyJobOpen ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND sjop = '".$obj->sjop."'";
		$this->db->query($sql);
	}

	function DelByJobNo($obj)
	{
		$sql = "UPDATE Survey_SurveyJobOpen ".
				" SET delFlag='yes',modifyUserId='{$obj->inputUserId}',modifyTime='{$obj->inputTime}' ".
				" WHERE 1=1  AND jobNo = '".$obj->jobNo."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_SurveyJobOpen ".
			" WHERE 1=1  AND sjop = '".$obj->sjop."'";
		$this->db->query($sql);
	}

	function GetListSearch($obj)
	{
		$query = '';
		if($obj->sjop != '')
			$query .= " AND sjop = '".$obj->sjop."'";
		if($obj->jobNo != '')
			$query .= " AND jobNo = '".$obj->jobNo."'";
		if($obj->isOpen != '')
			$query .= " AND isOpen = '".$obj->isOpen."'";
		if($obj->inputUserId != '')
			$query .= " AND inputUserId = '".$obj->inputUserId."'";
		if($obj->inputTime != '')
			$query .= " AND inputTime = '".$obj->inputTime."'";
		if($obj->modifyUserId != '')
			$query .= " AND modifyUserId = '".$obj->modifyUserId."'";
		if($obj->modifyTime != '')
			$query .= " AND modifyTime = '".$obj->modifyTime."'";
		if($obj->delFlag != '')
			$query .= " AND delFlag = '".$obj->delFlag."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_SurveyJobOpen ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new SurveyJobOpen();
			$obj->sjop = $rs["sjop"];
			$obj->jobNo = $rs["jobNo"];
			$obj->isOpen = $rs["isOpen"];
			$obj->inputUserId = $rs["inputUserId"];
			$obj->inputTime = $rs["inputTime"];
			$obj->modifyUserId = $rs["modifyUserId"];
			$obj->modifyTime = $rs["modifyTime"];
			$obj->delFlag = $rs["delFlag"];
			$rows[] = $obj;
		}
		return $rows;
	}

}
?>