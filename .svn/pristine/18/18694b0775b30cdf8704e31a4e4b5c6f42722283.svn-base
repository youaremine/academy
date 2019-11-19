<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class BusList {
	var $db;
	var $busId;
	var $busIds;
	var $routeNo = '';
	var $typeId = '';
	var $engName = '';
	var $chiName = '';
	var $bounds = '';
	var $distId = 0;
	var $distCode = '';
	var $busDay = '';
	var $allSchNo = 0;
	var $amSchNo = 0;
	var $pmSchNo = 0;
	var $inputTime;
	var $modifyTime;
	var $delFlag = 'no';
	var $order = '';
	var $pageLimit = '';
	function BusList($db) {
		$this->db = $db;
	}
	function GetListSearchCount() {
		$query = "";
		if ($this->routeNo != '')
			$query .= " AND routeNo LIKE '%" . $this->routeNo . "%'";
		if ($this->bounds != '')
			$query .= " AND bounds = '" . $this->bounds . "'";
		if ($this->busId != '')
			$query .= " AND busId = '" . $this->busId . "'";
		
		$rows = array ();
		$sql = "SELECT COUNT(Bs.busId) AS rowNum" . " FROM  Survey_Bus Bs" . " INNER JOIN Survey_BusType Sb ON Bs.typeId=Sb.butyId" . " LEFT JOIN Survey_Users Us ON Us.userId=Bs.inputUserId" . " WHERE 1=1 ";
		$sql = $sql . $query;
		$sql = $sql . $this->order;
		$this->db->query ( $sql );
		$rowNum = 0;
		if ($rs = $this->db->next_record ()) {
			$rowNum = $rs ["rowNum"];
		}
		return $rowNum;
	}
	function GetListSearch() {
		$query = "";
		if ($this->routeNo != '')
			$query .= " AND routeNo LIKE '%" . $this->routeNo . "%'";
		if ($this->bounds != '')
			$query .= " AND bounds = '" . $this->bounds . "'";
		if ($this->busId != '')
			$query .= " AND busId = '" . $this->busId . "'";
		if ($this->distCode != '')
			$query .= " AND distCode = '" . $this->distCode . "'";
		if ($this->typeId != '')
			$query .= " AND typeId = '" . $this->typeId . "'";
		
		$rows = array ();
		$sql = "SELECT Bs.*,Sb.engName AS typeEngName,Us.engName AS inputEngName" . " FROM  Survey_Bus Bs
				INNER JOIN Survey_BusType Sb ON Bs.typeId=Sb.butyId
				LEFT JOIN Survey_Users Us ON Us.userId=Bs.inputUserId
				WHERE 1=1 ";
		$sql = $sql . $query;
		$sql = $sql . $this->order;
		$sql = $sql . $this->pageLimit;
		// echo $sql."<br />";
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () ) {
			$bus = new Bus ( $db );
			$bus->busId = $rs ['busId'];
			$bus->routeNo = $rs ['routeNo'];
			$bus->typeId = $rs ['typeId'];
			$bus->typeEngName = $rs ['typeEngName'];
			$bus->engName = $rs ['engName'];
			$bus->chiName = $rs ['chiName'];
			$bus->bounds = $rs ['bounds'];
			$bus->sofsDate = $rs ['sofsDate'];
			$bus->distId = $rs ['distId'];
			$bus->distCode = $rs ['distCode'];
			$bus->busDay = $rs ['busDay'];
			$bus->allSchNo = $rs ['allSchNo'];
			$bus->amSchNo = $rs ['amSchNo'];
			$bus->pmSchNo = $rs ['pmSchNo'];
			$bus->totalJourneyTime = $rs ['totalJourneyTime'];
			$bus->totalJourneyDistance = $rs ['totalJourneyDistance'];
			$bus->inputUserId = $rs ['inputUserId'];
			$bus->inputEngName = $rs ['inputEngName'];
			$bus->inputTime = $rs ['inputTime'];
			$bus->modifyTime = $rs ['modifyTime'];
			;
			$bus->delFlag = $rs ['delFlag'];
			$rows [] = $bus;
		}
		return $rows;
	}
	
	/**
	 * 返回分组资料
	 */
	function GetListGroup() {
		$query = "";
		if ($this->routeNo != '')
			$query .= " AND routeNo LIKE '%" . $this->routeNo . "%'";
		if ($this->bounds != '')
			$query .= " AND bounds = '" . $this->bounds . "'";
		if ($this->busId != '')
			$query .= " AND busId = '" . $this->busId . "'";
		if ($this->busIds != '')
			$query .= " AND busId IN(" . $this->busIds . ")";
		
		$rows = array ();
		$sql = "SELECT GROUP_CONCAT(busId) as busIds,typeId" . " FROM  Survey_Bus Bs" . " INNER JOIN Survey_BusType Sb ON Bs.typeId=Sb.butyId" . " LEFT JOIN Survey_Users Us ON Us.userId=Bs.inputUserId" . " WHERE 1=1 ";
		$sql = $sql . $query;
		$sql = $sql . " GROUP BY typeId ";
		$sql = $sql . $this->pageLimit;
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () ) {
			$bus = new Bus ( $this->db );
			$bus->busId = $rs ['busIds'];
			$bus->typeId = $rs ['typeId'];
			$rows [] = $bus;
		}
		return $rows;
	}
}
?>
