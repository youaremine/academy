<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class SurveyPart {
	var $db;
	var $supaId;
	var $supaIds;
	var $refNo;
	var $weatherId;
	var $surDate;
	var $surFromTime;
	var $surToTime;
	var $surId = 0;
	var $busId = 0;
	var $busStopNo = 0;
	var $routeNo;
	var $location;
	var $bounds;
	var $schNo;
	var $schType;
	var $busId2;
	var $routeNo2;
	var $schNo2;
	var $schType2;
	var $survId;
	var $userId = 0;
	var $userName;
	var $inputTime;
	var $modifyTime;
	var $modifyUserId = 0;
	var $modifyUserName;
	var $channel = 1;
	var $delFlag = 'no';
	var $type;
	var $sofsDate;
	var $tdRefNo;
	var $remarks;

	function SurveyPart($db) {
		$this->db = $db;
		$this->inputTime = date ( "Y-m-d H:i:s" );
		$this->modifyTime = date ( "Y-m-d H:i:s" );
	}
	function Save() {
		$sql = "INSERT INTO  Survey_SurveyPart(refNo,weatherId,surDate,surFromTime,surToTime,busStopNo,surId,busId,routeNo,location
				,bounds,schNo,schType,busId2,routeNo2,schNo2,schType2,survId,remarks,userId,userName,inputTime,channel,delFlag)
				 VALUES('{$this->refNo}','{$this->weatherId}','{$this->surDate}','{$this->surFromTime}','{$this->surToTime}','{$this->busStopNo}','{$this->surId}','{$this->busId}','{$this->routeNo}'
				,'{$this->location}','{$this->bounds}','{$this->schNo}','{$this->schType}','{$this->busId2}','{$this->routeNo2}','{$this->schNo2}','{$this->schType2}','{$this->survId}'
				,'{$this->remarks}','{$this->userId}','{$this->userName}','{$this->inputTime}','{$this->channel}','{$this->delFlag}')";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Copy() {
		$sql = "INSERT INTO Survey_SurveyPart(refNo,weatherId,surDate,surFromTime,surToTime,busStopNo,surId,busId,routeNo,location,bounds,schNo,schType,busId2,routeNo2,schNo2,schType2,survId,remarks,userId,userName,inputTime,channel)
			SELECT refNo,weatherId,surDate,surFromTime,surToTime,busStopNo,surId,busId,routeNo,location,bounds,schNo,schType,busId2,routeNo2,schNo2,schType2,survId,remarks,userId,userName,inputTime,channel
			FROM  Survey_SurveyPart
			WHERE supaId = " . $this->supaId;
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Modify() {
		$sql = "UPDATE  Survey_SurveyPart SET refNo = '{$this->refNo}',weatherId='{$this->weatherId}',surDate='{$this->surDate}',surFromTime='{$this->surFromTime}',surToTime='{$this->surToTime}'
		,busStopNo='{$this->busStopNo}',busId='{$this->busId}',routeNo='{$this->routeNo}',location='{$this->location}',bounds='{$this->bounds}',schNo='{$this->schNo}',schType='{$this->schType}'
		,busId2='{$this->busId2}',routeNo2='{$this->routeNo2}',schNo2='{$this->schNo2}',schType2='{$this->schType2}',survId='{$this->survId}',remarks='{$this->remarks}'
		,modifyTime='{$this->modifyTime}',modifyUserId='{$this->modifyUserId}',modifyUserName='{$this->modifyUserName}',delFlag='{$this->delFlag}'
		WHERE supaId = {$this->supaId}";
		$this->db->query ( $sql );
	}
	function Del() {
		$sql = "UPDATE  Survey_SurveyPart " . " SET delFlag = '" . $this->delFlag . "'" . " ,modifyUserId = '" . $this->modifyUserId . "'" . " ,modifyUserName = '" . $this->modifyUserName . "'" . " ,modifyTime = '" . $this->modifyTime . "'" . " WHERE supaId = " . $this->supaId;
		// print $sql;
		$this->db->query ( $sql );
	}
	function DelByIds() {
		$sql = "UPDATE  Survey_SurveyPart " . " SET delFlag = '" . $this->delFlag . "'" . " WHERE supaId IN (" . $this->supaIds . ")";
		// print $sql;
		$this->db->query ( $sql );
	}
	function RealDel() {
		$sql = "DELETE FROM Survey_SurveyPart " . "WHERE supaId = " . $this->supaId;
		$this->db->query ( $sql );
	}
	function GetByRefNo() {
		$sql = "SELECT * FROM  Survey_SurveyPart " . "WHERE refNo = " . $this->refNo;
		$this->db->query ( $sql );
		if ($rs = $this->db->next_record ()) {
			$this->supaId = $rs ['supaId'];
			$this->refNo = $rs ['supaId'];
			$this->weatherId = $rs ['weatherId'];
			$this->surDate = $rs ['supaId'];
			$this->surFromTime = $rs ['surFromTime'];
			$this->surToTime = $rs ['surToTime'];
			$this->busStopNo = $rs ['busStopNo'];
			$this->surId = $rs ['surId'];
			$this->busId = $rs ['busId'];
			$this->routeNo = $rs ['routeNo'];
			$this->location = $rs ['location'];
			$this->bounds = $rs ['bounds'];
			$this->survId = $rs ['survId'];
			$this->userId = $rs ['userId'];
			$this->userName = $rs ['userName'];
			$this->inputTime = $rs ['inputTime'];
			$this->modifyTime = $rs ['modifyTime'];
			$this->modifyUserId = $rs ['modifyUserId'];
			$this->modifyUserName = $rs ['modifyUserName'];
			$this->channel = $rs ['channel'];
			$this->remarks = $rs ['remarks'];
			$this->delFlag = $rs ['delFlag'];
		}
	}
}
?>
