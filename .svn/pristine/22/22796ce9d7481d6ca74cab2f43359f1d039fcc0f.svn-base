<?php
/*
 * Header: 
 * Create: 2016-09-27
 * Auther: James Wu<jamblues@gmail.com>.
 */
class MessagesAccess
{
	var $db;

	function MessagesAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_Messages(survId,title,content,inputTime,isPublish,isRead,delFlag,msgType)".
			" VALUES('".$obj->survId."'".
			",'".$obj->title."'".
			",'".$obj->content."'".
			",'".$obj->inputTime."'".
			",'".$obj->isPublish."'".
			",'".$obj->isRead."'".
			",'".$obj->delFlag."'".
			",'".$obj->msgType."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_Messages ".
			" SET survId = '".$obj->survId."'".
			" ,title = '".$obj->title."'".
			" ,content = '".$obj->content."'".
			" ,inputTime = '".$obj->inputTime."'".
			" ,isPublish = '".$obj->isPublish."'".
			" ,isRead = '".$obj->isRead."'".
			" ,delFlag = '".$obj->delFlag."'".
			" WHERE 1=1  AND msgId = '".$obj->msgId."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_Messages ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND msgId = '".$obj->msgId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_Messages ".
			" WHERE 1=1  AND msgId = '".$obj->msgId."'";
		$this->db->query($sql);
	}

	/**
	 * 标记为已读/未读
	 * @param Messages $obj
	 */
	function Mark($obj)
	{
		$sql = "UPDATE Survey_Messages SET isRead='{$obj->isRead}'
				WHERE 1=1  AND msgId = '{$obj->msgId}'";
		$this->db->query($sql);
	}

	/**
	 * @param Messages
	 * @return Messages[]
	 */
	function GetListSearch($obj)
	{
		$query = '';
		if($obj->msgId != '')
			$query .= " AND msgId = '".$obj->msgId."'";
		if($obj->survId != '')
			$query .= " AND survId = '".$obj->survId."'";
		if($obj->title != '')
			$query .= " AND title = '".$obj->title."'";
		if($obj->content != '')
			$query .= " AND content = '".$obj->content."'";
		if($obj->inputTime != '')
			$query .= " AND inputTime = '".$obj->inputTime."'";
		if($obj->isPublish != '')
			$query .= " AND isPublish = '".$obj->isPublish."'";
		if($obj->isRead != '')
			$query .= " AND isRead = '".$obj->isRead."'";
		if($obj->delFlag != '')
			$query .= " AND delFlag = '".$obj->delFlag."'";
		if($obj->msgType != '')
			$query .= " AND msgType = '".$obj->msgType."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_Messages ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new Messages();
			$obj->msgId = $rs["msgId"];
			$obj->survId = $rs["survId"];
			$obj->title = $rs["title"];
			$obj->content = $rs["content"];
			$obj->inputTime = $rs["inputTime"];
			$obj->isPublish = $rs["isPublish"];
			$obj->isRead = $rs["isRead"];
			$obj->delFlag = $rs["delFlag"];
			$obj->msgType = $rs["msgType"];
			$rows[] = $obj;
		}
		return $rows;
	}

	/**
	 * 根據項目號添加消息記錄
	 * @param $jobNoNew
	 */
	function AddNew($jobNoNew){
		$ms = new MainSchedule();
		$ms->jobNoNewSigle = $jobNoNew;
		$msa = new MainScheduleAccess($this->db);
		$rs = $msa->GetListSearch($ms);

		if(!empty($rs) && !empty($rs[0]->surveyorCode)){
			$m = new Messages();
			$m->survId = $rs[0]->surveyorCode;
			$m->title = "{$jobNoNew}  is received.";
			$m->content = "{$jobNoNew} 表格照片已經收到.";
			$m->inputTime = date('Y-m-d H:i:s');
			$this->Add($m);
		}
	}

}
?>