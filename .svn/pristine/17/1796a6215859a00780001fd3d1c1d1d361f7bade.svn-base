<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class Bus {
	var $db;
	var $busId;
	var $routeNo = '';
	var $typeId = '';
	var $typeEngName;
	var $engName = '';
	var $chiName = '';
	var $bounds = '';
	var $sofsDate;
	var $distId = 0;
	var $distCode = '';
	var $busDay = '';
	var $allSchNo = 0;
	var $amSchNo = 0;
	var $pmSchNo = 0;
	var $totalJourneyTime;
	var $totalJourneyDistance;
	var $inputUserId;
	var $inputEngName;
	var $inputTime;
	var $modifyUserId;
	var $modifyTime;
	var $delFlag = 'no';
	function Bus($db) {
		$this->db = $db;
		$this->inputTime = date ( "Y-m-d H:i:s" );
		$this->modifyTime = date ( "Y-m-d H:i:s" );
	}
	function Save() {
		$sql = "INSERT INTO Survey_Bus(routeNo,typeId,engName,chiName,bounds,sofsDate,distId,distCode,busDay,allSchNo
					,amSchNo,pmSchNo,totalJourneyTime,totalJourneyDistance,inputUserId,inputTime,delFlag)
					VALUES('{$this->routeNo}','{$this->typeId}','{$this->engName}','{$this->chiName}','{$this->bounds}','{$this->sofsDate}','{$this->distId}','{$this->distCode}','{$this->busDay}' 
							,'{$this->allSchNo}','{$this->amSchNo}','{$this->pmSchNo}','{$this->totalJourneyTime}','{$this->totalJourneyDistance}','{$this->inputUserId}','{$this->inputTime}','{$this->delFlag}')";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Modify() {
		$sql = "UPDATE  Survey_Bus  SET routeNo='{$this->routeNo}',typeId='{$this->typeId}',engName='{$this->engName}',chiName='{$this->chiName}',bounds='{$this->bounds}'
			,sofsDate='{$this->sofsDate}',distId='{$this->distId}',distCode='{$this->distCode}',busDay='{$this->busDay}',allSchNo='{$this->allSchNo}'
			,amSchNo='{$this->amSchNo}',pmSchNo='{$this->pmSchNo}',totalJourneyTime='{$this->totalJourneyTime}',totalJourneyDistance='{$this->totalJourneyDistance}'
			,modifyUserId='{$this->modifyUserId}',modifyTime='{$this->modifyTime}',delFlag='{$this->delFlag}'
			WHERE busId = {$this->busId}";
		$this->db->query ( $sql );
	}
	function Del() {
		$sql = "UPDATE  Survey_Bus " . "SET delFlag = '" . $this->delFlag . "'" . "WHERE busId = " . $this->busId;
		$this->db->query ( $sql );
	}
	function RealDel() {
		$sql = "DELETE FROM Survey_Bus " . "WHERE busId = " . $this->busId;
		$this->db->query ( $sql );
	}
	function IsExist() {
		$sql = "SELECT busId FROM  Survey_Bus " . "WHERE routeNo = '" . $this->routeNo . "'";
		$this->db->query ( $sql );
		if ($this->db->num_rows () > 0) {
			return true;
		} else {
			return false;
		}
	}
}
?>
