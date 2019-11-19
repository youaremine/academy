<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class DistrictPartList {
	var $db;
	var $dipaId;
	var $dipaCode;
	var $engName;
	var $chiName;
	var $delFlag = 'no';
	function DistrictPartList($db) {
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
		$sql = "SELECT * FROM  Survey_DistrictPart WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () ) {
			$dp = new DistrictPart ();
			$dp->dipaId = $rs ['dipaId'];
			$dp->dipaCode = $rs ['dipaCode'];
			$dp->engName = $rs ['engName'];
			$dp->chiName = $rs ['chiName'];
			$rows [] = $dp;
		}
		return $rows;
	}
}
?>
