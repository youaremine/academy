<?php
/*
 * Header: 
 * Create: 2015-04-19
 * Auther: James Wu<jamblues@gmail.com>.
 */
class BusDistanceAccess
{
	var $db;

	function BusDistanceAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_BusDistance(busId,stopNo,stopDescription,distance,delFlag)".
			" VALUES('".$obj->busId."'".
			",'".$obj->stopNo."'".
			",'".$obj->stopDescription."'".
			",'".$obj->distance."'".
			",'".$obj->delFlag."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_BusDistance ".
			" SET busId = '".$obj->busId."'".
			" ,stopNo = '".$obj->stopNo."'".
			" ,stopDescription = '".$obj->stopDescription."'".
			" ,distance = '".$obj->distance."'".
			" ,delFlag = '".$obj->delFlag."'".
			" WHERE 1=1  AND budiId = '".$obj->budiId."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_BusDistance ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND budiId = '".$obj->budiId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_BusDistance ".
			" WHERE 1=1  AND budiId = '".$obj->budiId."'";
		$this->db->query($sql);
	}

	function RealDelByBusId($obj)
	{
		$sql = "DELETE FROM Survey_BusDistance ".
				" WHERE 1=1  AND busId = '".$obj->busId."'";
		$this->db->query($sql);
	}

	function GetListSearch($obj)
	{
		$query = '';
		if($obj->budiId != '')
			$query .= " AND budiId = '".$obj->budiId."'";
		if($obj->busId != '')
			$query .= " AND busId = '".$obj->busId."'";
		if($obj->stopNo != '')
			$query .= " AND stopNo = '".$obj->stopNo."'";
		if($obj->stopDescription != '')
			$query .= " AND stopDescription = '".$obj->stopDescription."'";
		if($obj->distance != '')
			$query .= " AND distance = '".$obj->distance."'";
		if($obj->delFlag != '')
			$query .= " AND delFlag = '".$obj->delFlag."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_BusDistance ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new BusDistance();
			$obj->budiId = $rs["budiId"];
			$obj->busId = $rs["busId"];
			$obj->stopNo = $rs["stopNo"];
			$obj->stopDescription = $rs["stopDescription"];
			$obj->distance = $rs["distance"];
			$obj->delFlag = $rs["delFlag"];
			$rows[] = $obj;
		}
		return $rows;
	}

}
?>