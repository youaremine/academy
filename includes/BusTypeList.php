<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class BusTypeList {
	var $db;
	var $butyId;
	var $color;
	var $engName;
	var $chiName;
	var $inputTime;
	var $modifyTime;
	var $delFlag = 'no';
	function BusTypeList($db) {
		$this->db = $db;
		$this->inputTime = date ( "Y-m-d H:i:s" );
		$this->modifyTime = date ( "Y-m-d H:i:s" );
	}
	function GetListSearch() {
		$query = "";
		if ($this->butyId != "") {
			$query .= " AND butyId = " . $this->butyId;
		}
		
		$rows = array ();
		$sql = "SELECT * FROM  Survey_BusType WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () ) {
			$bt = new BusType ( $this->db );
			$bt->butyId = $rs ['butyId'];
			$bt->color = $rs ['color'];
			$bt->engName = $rs ['engName'];
			$bt->chiName = $rs ['chiName'];
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
		$sql = "SELECT * FROM  Survey_BusType ";
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () ) {
			$bt = new BusType ( $this->db );
			$bt->butyId = $rs ['butyId'];
			$bt->color = $rs ['color'];
			$bt->engName = $rs ['engName'];
			$bt->chiName = $rs ['chiName'];
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
