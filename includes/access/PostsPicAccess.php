<?php
/*
 * Header: 
 * Create: 2017-03-22
 * Auther: James Wu<jamblues@gmail.com>.
 */
class PostsPicAccess
{
	var $db;

	function PostsPicAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_PostsPic(postId,imagePath,inputTime,delFlag)".
			" VALUES('".$obj->postId."'".
			",'".$obj->imagePath."'".
			",'".$obj->inputTime."'".
			",'".$obj->delFlag."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_PostsPic ".
			" SET postId = '".$obj->postId."'".
			" ,imagePath = '".$obj->imagePath."'".
			" ,inputTime = '".$obj->inputTime."'".
			" ,delFlag = '".$obj->delFlag."'".
			" WHERE 1=1  AND postsPicId = '".$obj->postsPicId."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_PostsPic ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND postsPicId = '".$obj->postsPicId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_PostsPic ".
			" WHERE 1=1  AND postsPicId = '".$obj->postsPicId."'";
		$this->db->query($sql);
	}

	function GetListSearch($obj)
	{
		$query = '';
		if($obj->postsPicId != '')
			$query .= " AND postsPicId = '".$obj->postsPicId."'";
		if($obj->postId != '')
			$query .= " AND postId = '".$obj->postId."'";
		if($obj->imagePath != '')
			$query .= " AND imagePath = '".$obj->imagePath."'";
		if($obj->inputTime != '')
			$query .= " AND inputTime = '".$obj->inputTime."'";
		if($obj->delFlag != '')
			$query .= " AND delFlag = '".$obj->delFlag."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_PostsPic ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new PostsPic();
			$obj->postsPicId = $rs["postsPicId"];
			$obj->postId = $rs["postId"];
			$obj->imagePath = $rs["imagePath"];
			$obj->inputTime = $rs["inputTime"];
			$obj->delFlag = $rs["delFlag"];
			$rows[] = $obj;
		}
		return $rows;
	}

}
?>