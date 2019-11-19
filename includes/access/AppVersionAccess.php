<?php
/*
 * Header: 
 * Create: 2016-05-07
 * Auther: James Wu<jamblues@gmail.com>.
 */
class AppVersionAccess
{
	var $db;

	function AppVersionAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_AppVersion(os,appName,version,uptime,path,isForce)".
			" VALUES('".$obj->os."'".
			",'".$obj->appName."'".
			",'".$obj->version."'".
			",'".$obj->uptime."'".
			",'".$obj->path."'".
			",'".$obj->isForce."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_AppVersion ".
			" SET os = '".$obj->os."'".
			" ,appName = '".$obj->appName."'".
			" ,version = '".$obj->version."'".
			" ,uptime = '".$obj->uptime."'".
			" ,path = '".$obj->path."'".
			" ,isForce = '".$obj->isForce."'".
			" WHERE 1=1  AND apId = '".$obj->apId."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_AppVersion ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND apId = '".$obj->apId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_AppVersion ".
			" WHERE 1=1  AND apId = '".$obj->apId."'";
		$this->db->query($sql);
	}

	function GetListSearch($obj)
	{
		$query = '';
		if($obj->apId != '')
			$query .= " AND apId = '".$obj->apId."'";
		if($obj->os != '')
			$query .= " AND os = '".$obj->os."'";
		if($obj->appName != '')
			$query .= " AND appName = '".$obj->appName."'";
		if($obj->version != '')
			$query .= " AND version = '".$obj->version."'";
		if($obj->uptime != '')
			$query .= " AND uptime = '".$obj->uptime."'";
		if($obj->path != '')
			$query .= " AND path = '".$obj->path."'";
		if($obj->isForce != '')
			$query .= " AND isForce = '".$obj->isForce."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_AppVersion ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
//		echo $sql;
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new AppVersion();
			$obj->apId = $rs["apId"];
			$obj->os = $rs["os"];
			$obj->appName = $rs["appName"];
			$obj->version = $rs["version"];
			$obj->uptime = $rs["uptime"];
			$obj->path = $rs["path"];
			$obj->isForce = $rs["isForce"];
			$rows[] = $obj;
		}
		return $rows;
	}

}
?>