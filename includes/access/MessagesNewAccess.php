<?php
/*
 * Header: 
 * Create: 2016-09-27
 * Auther: James Wu<jamblues@gmail.com>.
 */
class MessagesNewAccess
{
	var $db;

	function MessagesNewAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_MessagesNew(title,content,create_time,delFlag,type)".
			" VALUES(".
			"'".$obj->title."'".
			",'".$obj->content."'".
			",'".$obj->create_time."'".
			",'".$obj->delFlag."'".
			",'".$obj->type."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_MessagesNew ".
			" ,title = '".$obj->title."'".
			" ,content = '".$obj->content."'".
			" ,inputTime = '".$obj->create_time."'".
			" ,delFlag = '".$obj->delFlag."'".
            " ,type = '".$obj->type."'".
			" WHERE 1=1  AND msgId = '".$obj->msgId."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_MessagesNew ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND msgId = '".$obj->msgId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_MessagesNew ".
			" WHERE 1=1  AND msgId = '".$obj->msgId."'";
		$this->db->query($sql);
	}

	/**
	 * 标记为已读/未读
	 * @param MessagesNew $obj
	 */
	function Mark($obj)
	{
	    //TODO
		/*$sql = "UPDATE Survey_MessagesNew SET isRead='{$obj->isRead}'
				WHERE 1=1  AND msgId = '{$obj->msgId}'";
		$this->db->query($sql);*/
	}

	/**
	 * @param MessagesNew
	 * @return MessagesNew[]
	 */
	function GetListSearch($obj)
	{
		$query = '';
		if($obj->msgId != '')
			$query .= " AND msgId = '".$obj->msgId."'";
		if($obj->title != '')
			$query .= " AND title = '".$obj->title."'";
		if($obj->content != '')
			$query .= " AND content = '".$obj->content."'";
		if($obj->create_time != '')
			$query .= " AND inputTime = '".$obj->create_time."'";
		if($obj->delFlag != '')
			$query .= " AND delFlag = '".$obj->delFlag."'";
		if($obj->type != '')
			$query .= " AND type = '".$obj->type."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_MessagesNew ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new MessagesNew();
			$obj->msgId = $rs["msgId"];
			$obj->title = $rs["title"];
			$obj->content = $rs["content"];
			$obj->create_time = $rs["create_time"];
			$obj->delFlag = $rs["delFlag"];
			$obj->type = $rs["type"];
			$rows[] = $obj;
		}
		return $rows;
	}

}
?>