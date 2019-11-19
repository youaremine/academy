<?php
/*
 * Header: 
 * Create: 2014-08-26
 * Auther: James Wu<jamblues@gmail.com>.
 */
class PermissionAccess
{
	var $db;

	function PermissionAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_Permission(permCode,permName,delFlag)".
			" VALUES('".$obj->permCode."'".
			",'".$obj->permName."'".
			",'".$obj->delFlag."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_Permission ".
			" SET permCode = '".$obj->permCode."'".
			" ,permName = '".$obj->permName."'".
			" ,delFlag = '".$obj->delFlag."'".
			" WHERE 1=1  AND permId = '".$obj->permId."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_Permission ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND permId = '".$obj->permId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_Permission ".
			" WHERE 1=1  AND permId = '".$obj->permId."'";
		$this->db->query($sql);
	}

	function GetListSearch($obj)
	{
		$query = '';
		if($obj->permId != '')
			$query .= " AND permId = '".$obj->permId."'";
		if($obj->permCode != '')
			$query .= " AND permCode = '".$obj->permCode."'";
		if($obj->permName != '')
			$query .= " AND permName = '".$obj->permName."'";
		if($obj->delFlag != '')
			$query .= " AND delFlag = '".$obj->delFlag."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_Permission ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new Permission();
			$obj->permId = $rs["permId"];
			$obj->permCode = $rs["permCode"];
			$obj->permName = $rs["permName"];
			$obj->delFlag = $rs["delFlag"];
			$rows[] = $obj;
		}
		return $rows;
	}

}
?>