<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class PermissionList {
	var $db;
	var $permId;
	var $permCode;
	var $permName;
	var $delFlag = 'no';
	function PermissionList($db) {
		$this->db = $db;
	}
	function GetListSearch() {
		$query = "";
		$rows = array ();
		$sql = "SELECT * FROM  Survey_Permission WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () ) {
			$perm = new Permission ( $db );
			$perm->permId = $rs ['permId'];
			$perm->permCode = $rs ['permCode'];
			$perm->permName = $rs ['permName'];
			$rows [] = $perm;
		}
		return $rows;
	}
}
?>
