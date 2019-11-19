<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class BusTimeList {
	var $db;
	var $butiId;
	var $busId;
	var $busId2;
	var $busTime;
	var $minBusTime;
	var $maxBusTime;
	var $inputTime;
	var $modifyTime;
	var $delFlag = 'no';
	var $order = '';
	function BusTimeList($db) {
		$this->db = $db;
		$this->inputTime = date ( "Y-m-d H:i:s" );
		$this->modifyTime = date ( "Y-m-d H:i:s" );
	}
	function GetListSearch() {
		$query = "";
		if ($this->busId != '') {
			if ($this->busId2 != '') {
				$query .= " AND (busId = {$this->busId} OR busId = {$this->busId2})";
			} else {
				$query .= " AND busId = " . $this->busId;
			}
		}
		if ($this->minBusTime != '')
			$query .= " AND busTime >= '" . $this->minBusTime . "'";
		if ($this->maxBusTime != '')
			$query .= " AND busTime < '" . $this->maxBusTime . "'";
		if ($this->order != '')
			$query .= " " . $this->order;
		
		$rows = array ();
		$sql = "SELECT * FROM  Survey_BusTime WHERE 1=1 ";
		$sql = $sql . $query;
// 		echo $sql;
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () ) {
			$bt = new BusTime ( $this->db );
			$bt->butiId = $rs ['butiId'];
			$bt->busId = $rs ['busId'];
			$bt->busTime = $rs ['busTime'];
			$bt->inputTime = $rs ['inputTime'];
			$bt->modifyTime = $rs ['modifyTime'];
			;
			$bt->delFlag = $rs ['delFlag'];
			$rows [] = $bt;
		}
		return $rows;
	}
	function GetListAll() {
		$rows = array ();
		$sql = "SELECT * FROM  Survey_BusTime ";
		$db->query ( $sql );
		while ( $rs = $db->next_record () ) {
			$bt = new BusTime ( $this->db );
			$bt->butiId = $rs ['butiId'];
			$bt->busId = $rs ['busId'];
			$bt->busTime = $rs ['busTime'];
			$bt->inputTime = $rs ['inputTime'];
			$bt->modifyTime = $rs ['modifyTime'];
			;
			$bt->delFlag = $rs ['delFlag'];
			$rows [] = $bt;
		}
		return $rows;
	}
}
?>
