<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class BusTime {
	var $db;
	var $butiId;
	var $busId;
	var $busTime;
	var $inputTime;
	var $modifyTime;
	var $delFlag = 'no';
	function BusTime($db) {
		$this->db = $db;
		$this->inputTime = date ( "Y-m-d H:i:s" );
		$this->modifyTime = date ( "Y-m-d H:i:s" );
	}
	function Save() {
		$sql = "INSERT INTO  Survey_BusTime(busId,busTime,inputTime,delFlag) " . " VALUES('" . $this->busId . "'," . "'" . $this->busTime . "'," . "'" . $this->inputTime . "'," . "'" . $this->delFlag . "')";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Modify() {
		// $sql = "UPDATE BusTime ".
		// "SET routeNo='".$this->routeNo."' ".
		// ",typeId='".$this->typeId."' ".
		// ",engName='".$this->engName."' ".
		// ",chiName='".$this->chiName."' ".
		// ",inputTime='".$this->inputTime."' ".
		// ",delFlag='".$this->delFlag."' ".
		// "WHERE busId = ".$this->busId;
		// $this->db->query($sql);
	}
	function Del() {
		$sql = "UPDATE  Survey_BusTime " . "SET delFlag = '" . $this->delFlag . "'" . "WHERE butiId = " . $this->butiId;
		$this->db->query ( $sql );
	}
	function RealDel() {
		$sql = "DELETE FROM Survey_BusTime " . "WHERE butiId = " . $this->butiId;
		$this->db->query ( $sql );
	}
	function RealDelByBusId() {
		$sql = "DELETE FROM Survey_BusTime " . "WHERE busId = " . $this->busId;
		$this->db->query ( $sql );
	}
}
?>
