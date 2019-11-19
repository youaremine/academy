<?php
/*
 * Header: 
 * Create: 2007-1-2
 * Auther: Jamblues.
 */
class Permission
{
	var $db;
	var $permId;
	var $permCode;
	var $permName;
	var $delFlag = 'no';
	
	function Permission($db)
	{
		$this->db = $db;
		$this->lastLoginTime = date("Y-m-d H:i:s");
	}

	function Save()
	{
		$sql = "INSERT INTO Survey_Permission(permCode,permName) ".
							" VALUES('".$this->permCode."'," .
									"'".$this->permName."')";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}
	
	function Modify()
	{
		//TODO
	}
	
	function Del()
	{
		//TODO
	}
	
	function RealDel()
	{
		//TODO
	}

}
?>
