<?php
/*
 * Header: Create: 2008-06-29 Auther: Jamblues@gmail.com.
 */
class FlowMovementAccess {
	var $db;
	function FlowMovementAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_FlowMovement(joinId,pcfaId,chiName,engName,remark,updateTime,updateUserId,inputTime,inputUserId,delFlag)" . " VALUES('" . $obj->joinId . "'" . ",'" . $obj->pcfaId . "'" . ",'" . $obj->chiName . "'" . ",'" . $obj->engName . "'" . ",'" . $obj->remark . "'" . ",'" . $obj->updateTime . "'" . ",'" . $obj->updateUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_FlowMovement " . " SET joinId = '" . $obj->joinId . "'" . " ,pcfaId = '" . $obj->pcfaId . "'" . " ,chiName = '" . $obj->chiName . "'" . " ,engName = '" . $obj->engName . "'" . " ,remark = '" . $obj->remark . "'" . " ,updateTime = '" . $obj->updateTime . "'" . " ,updateUserId = '" . $obj->updateUserId . "'" . " ,inputTime = '" . $obj->inputTime . "'" . " ,inputUserId = '" . $obj->inputUserId . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND moveId = '" . $obj->moveId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_FlowMovement " . " SET delFlag='yes' " . " WHERE 1=1  AND moveId = '" . $obj->moveId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_FlowMovement " . " WHERE 1=1  AND moveId = '" . $obj->moveId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->moveId != '')
			$query .= " AND moveId = '" . $obj->moveId . "'";
		if ($obj->joinId != '')
			$query .= " AND joinId = '" . $obj->joinId . "'";
		if ($obj->pcfaId != '')
			$query .= " AND pcfaId = '" . $obj->pcfaId . "'";
		if ($obj->chiName != '')
			$query .= " AND chiName = '" . $obj->chiName . "'";
		if ($obj->engName != '')
			$query .= " AND engName = '" . $obj->engName . "'";
		if ($obj->remark != '')
			$query .= " AND remark = '" . $obj->remark . "'";
		if ($obj->updateTime != '')
			$query .= " AND updateTime = '" . $obj->updateTime . "'";
		if ($obj->updateUserId != '')
			$query .= " AND updateUserId = '" . $obj->updateUserId . "'";
		if ($obj->inputTime != '')
			$query .= " AND inputTime = '" . $obj->inputTime . "'";
		if ($obj->inputUserId != '')
			$query .= " AND inputUserId = '" . $obj->inputUserId . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_FlowMovement " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
//		echo $sql,'<br />';
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new FlowMovement ();
			$obj->moveId = $rs ["moveId"];
			$obj->joinId = $rs ["joinId"];
			$obj->pcfaId = $rs ["pcfaId"];
			$obj->chiName = $rs ["chiName"];
			$obj->engName = $rs ["engName"];
			$obj->remark = $rs ["remark"];
			$obj->updateTime = $rs ["updateTime"];
			$obj->updateUserId = $rs ["updateUserId"];
			$obj->inputTime = $rs ["inputTime"];
			$obj->inputUserId = $rs ["inputUserId"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>