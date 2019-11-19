<?php
/*
 * Header: 
 * Create: 2014-08-26
 * Auther: James Wu<jamblues@gmail.com>.
 */
class RolePermissionAccess
{
	var $db;

	function RolePermissionAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_RolePermission(roleId,permId,delFlag)".
			" VALUES('".$obj->roleId."'".
			",'".$obj->permId."'".
			",'".$obj->delFlag."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_RolePermission ".
			" SET permId = '".$obj->permId."'".
			" ,delFlag = '".$obj->delFlag."'".
			" WHERE 1=1  AND roleId = '".$obj->roleId."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_RolePermission ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND roleId = '".$obj->roleId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_RolePermission ".
			" WHERE 1=1  AND roleId = '".$obj->roleId."'";
		$this->db->query($sql);
	}

	function GetListSearch($obj)
	{
		$query = '';
		if($obj->roleId != '')
			$query .= " AND roleId = '".$obj->roleId."'";
		if($obj->permId != '')
			$query .= " AND permId = '".$obj->permId."'";
		if($obj->delFlag != '')
			$query .= " AND delFlag = '".$obj->delFlag."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_RolePermission ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new RolePermission();
			$obj->roleId = $rs["roleId"];
			$obj->permId = $rs["permId"];
			$obj->delFlag = $rs["delFlag"];
			$rows[] = $obj;
		}
		return $rows;
	}

}
?>