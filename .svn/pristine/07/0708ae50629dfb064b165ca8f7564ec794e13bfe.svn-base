<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class Survey {
	var $db;
	var $surId;
	var $surNo;
	var $inputTime;
	var $modifyTime;
	var $delFlag = 'no';
	function Survey($db) {
		$this->db = $db;
		$this->inputTime = date ( "Y-m-d H:i:s" );
		$this->modifyTime = date ( "Y-m-d H:i:s" );
	}
	function Save() {
		$sql = "INSERT INTO  Survey_Survey(surNo,delFlag) " . " VALUES('" . $this->surNo . "','" . $this->delFlag . "')";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Modify() {
		$sql = "UPDATE  Survey_Survey " . "SET surNo='" . $this->surNo . "' " . ",delFlag='" . $this->delFlag . "' " . "WHERE surId = " . $this->surId;
		$this->db->query ( $sql );
	}
	function Del() {
		$sql = "UPDATE  Survey_Survey " . "SET delFlag = '" . $this->delFlag . "'" . "WHERE surId = " . $this->surId;
		$this->db->query ( $sql );
	}
	function RealDel() {
		$sql = "DELETE FROM Survey_Survey " . "WHERE surId = " . $this->surId;
		$this->db->query ( $sql );
	}
}
?>
