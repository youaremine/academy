<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class DistrictList {
	var $db;
	var $distId;
	var $distCode;
	var $engName;
	var $chiName;
	function DistrictList($db) {
		$this->db = $db;
	}
	
	/**
	 * 查找所有的资料列表
	 * 
	 * @access public
	 */
	function GetListSearch() {
		$query = "";
		$rows = array ();
		$sql = "SELECT * FROM  Survey_District WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () ) {
			$dist = new District ();
			$dist->distId = $rs ['distId'];
			$dist->distCode = $rs ['distCode'];
			$dist->engName = $rs ['engName'];
			$dist->chiName = $rs ['chiName'];
			$rows [] = $dist;
		}
		return $rows;
	}
}
?>
