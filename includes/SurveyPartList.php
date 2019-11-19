<?php
/*
 * Header: Create: 2007-1-3 Auther: Jamblues.
 */
class SurveyPartList {
	var $db;
	var $supaId;
	var $refNo;
	var $weatherId;
	var $surDate;
	var $surFromTime;
	var $surToTime;
	var $surId;
	var $busId;
	var $routeNo;
	var $location;
	var $bounds;
	var $userId;
	var $userName;
	var $inputTime;
	var $inputTimeStart;
	var $inputTimeEnd;
	var $modifyTime;
	var $modifyUserId;
	var $modifyUserName;
	var $channel;
	var $delFlag = '';
	var $isRelease = '';
	var $order = ' ORDER BY surFromTime ASC';
	var $type;
	var $supaIds;
	var $newsupaId;
	var $surDateStart;
	var $surDateEnd;
	var $doDistrict;
	var $district;
	var $pageLimit;
	function SurveyPartList($db) {
		$this->db = $db;
	}
	
	/**
	 * 改变状态
	 */
	function UpdateIsRelease() {
		$sql = "UPDATE  Survey_SurveyPart" . " SET isRelease = '" . $this->isRelease . "'" . " WHERE supaId = " . $this->supaId;
		$this->db->query ( $sql );
	}
	function GetListSearchCount() {
		$query = "";
		if ($this->supaId != "")
			$query .= " AND SP.supaId = " . $this->supaId;
		if ($this->userId != "")
			$query .= " AND SP.userId = " . $this->userId;
		if ($this->userName != "")
			$query .= " AND SP.userName LIKE '%" . $this->userName . "%'";
		if ($this->refNo != "")
			$query .= " AND SP.refNo LIKE '" . $this->refNo . "%'";
		if ($this->routeNo != "")
			$query .= " AND BS.routeNo LIKE '%" . $this->routeNo . "%'";
		if ($this->surDate != "")
			$query .= " AND SP.surDate = '" . $this->surDate . "'";
		if ($this->surDateStart != "")
			$query .= " AND SP.surDate >= '" . $this->surDateStart . "'";
		if ($this->surDateEnd != "")
			$query .= " AND SP.surDate <= '" . $this->surDateEnd . "'";
		if ($this->inputTimeStart != "")
			$query .= " AND SP.inputTime >= '" . $this->inputTimeStart . "'";
		if ($this->inputTimeEnd != "")
			$query .= " AND SP.inputTime <= '" . $this->inputTimeEnd . "'";
		if ($this->supaIds != "")
			$query .= " AND SP.supaId IN (" . $this->supaIds . ")";
		if ($this->delFlag != "")
			$query .= " AND SP.delFlag = '" . $this->delFlag . "'";
		if ($this->isRelease != "")
			$query .= " AND SP.isRelease = '" . $this->isRelease . "'";
		if ($this->district != "")
			$query .= " AND SP.refNo LIKE '" . $this->district . "%'";
		if ($this->doDistrict != "") {
			$tempDoDist = explode ( ",", $this->doDistrict );
			$query .= " AND (1=2 ";
			for($i = 1; $i < count ( $tempDoDist ); $i ++) {
				$query .= " OR SP.refNo LIKE '" . $tempDoDist [$i] . "%'";
			}
			$query .= ")";
		}
		
		$rows = array ();
		$sql = "SELECT COUNT(*) AS rowNum FROM  Survey_SurveyPart SP
		LEFT JOIN Survey_Bus BS ON SP.busId = BS.busId
		LEFT JOIN Survey_BusType BT ON BS.typeId = BT.butyId WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rowNum = 0;
		if ($rs = $this->db->next_record ()) {
			$rowNum = $rs ["rowNum"];
		}
		return $rowNum;
	}
	function GetListSearch() {
		$query = "";
		if ($this->supaId != "")
			$query .= " AND SP.supaId = " . $this->supaId;
		if ($this->userId != "")
			$query .= " AND SP.userId = " . $this->userId;
		if ($this->userName != "")
			$query .= " AND SP.userName LIKE '%" . $this->userName . "%'";
		if ($this->refNo != "")
			$query .= " AND SP.refNo LIKE '" . $this->refNo . "%'";
		if ($this->weatherId != "")
			$query .= " AND SP.weatherId = '" . $this->weatherId . "'";
		if ($this->routeNo != "")
			$query .= " AND BS.routeNo LIKE '%" . $this->routeNo . "%'";
		if ($this->surDate != "")
			$query .= " AND SP.surDate = '" . $this->surDate . "'";
		if ($this->surDateStart != "")
			$query .= " AND SP.surDate >= '" . $this->surDateStart . "'";
		if ($this->surDateEnd != "")
			$query .= " AND SP.surDate <= '" . $this->surDateEnd . "'";
		if ($this->inputTimeStart != "")
			$query .= " AND SP.inputTime >= '" . $this->inputTimeStart . "'";
		if ($this->inputTimeEnd != "")
			$query .= " AND SP.inputTime <= '" . $this->inputTimeEnd . "'";
		if ($this->supaIds != "")
			$query .= " AND SP.supaId IN (" . $this->supaIds . ")";
		if ($this->delFlag != "")
			$query .= " AND SP.delFlag = '" . $this->delFlag . "'";
		if ($this->isRelease != "")
			$query .= " AND SP.isRelease = '" . $this->isRelease . "'";
		if ($this->district != "")
			$query .= " AND SP.refNo LIKE '" . $this->district . "%'";
		if ($this->doDistrict != "") {
			$tempDoDist = explode ( ",", $this->doDistrict );
			$query .= " AND (1=2 ";
			for($i = 1; $i < count ( $tempDoDist ); $i ++) {
				$query .= " OR SP.refNo LIKE '" . $tempDoDist [$i] . "%'";
			}
			$query .= ")";
		}
		if ($this->order != "")
			$query .= $this->order;
		if ($this->pageLimit != "")
			$query .= $this->pageLimit;
		
		$rows = array ();
		$sql = "SELECT SP.*,BS.sofsDate,BT.engName FROM  Survey_SurveyPart SP
				LEFT JOIN Survey_Bus BS ON SP.busId = BS.busId" . " LEFT JOIN Survey_BusType BT ON BS.typeId = BT.butyId " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
 		print $sql;
		while ( $rs = $this->db->next_record () ) {
			$sp = new SurveyPart ( $this->db );
			$sp->supaId = $rs ['supaId'];
			$sp->refNo = $rs ['refNo'];
			$sp->weatherId = $rs ['weatherId'];
			$sp->surDate = $rs ['surDate'];
			$sp->surFromTime = $rs ['surFromTime'];
			$sp->surToTime = $rs ['surToTime'];
			$sp->busStopNo = $rs ['busStopNo'];
			$sp->surId = $rs ['surId'];
			$sp->busId = $rs ['busId'];
			$sp->routeNo = $rs ['routeNo'];
			$sp->location = $rs ['location'];
			$sp->bounds = $rs ['bounds'];
			$sp->schNo = $rs ['schNo'];
			$sp->schType = $rs ['schType'];
			$sp->busId2 = $rs ['busId2'];
			$sp->routeNo2 = $rs ['routeNo2'];
			$sp->schNo2 = $rs ['schNo2'];
			$sp->schType2 = $rs ['schType2'];
			$sp->survId = $rs ['survId'];
			$sp->remarks = $rs ['remarks'];
			$sp->userId = $rs ['userId'];
			$sp->userName = $rs ['userName'];
			$sp->inputTime = $rs ['inputTime'];
			$sp->modifyTime = $rs ['modifyTime'];
			$sp->modifyUserId = $rs ['modifyUserId'];
			$sp->modifyUserName = $rs ['modifyUserName'];
			$sp->channel = $rs ['channel'];
			$sp->delFlag = $rs ['delFlag'];
			$sp->type = $rs ["engName"];
			$sp->sofsDate = $rs ["sofsDate"];
			$sp->db = null;
			$rows [] = $sp;
		}
		return $rows;
	}

	/**
	 * 获取调查列表
	 * @return array
	 */
	function GetListSearch2() {
		$query = "";
		if ($this->supaId != "")
			$query .= " AND SP.supaId = " . $this->supaId;
		if ($this->userId != "")
			$query .= " AND SP.userId = " . $this->userId;
		if ($this->userName != "")
			$query .= " AND SP.userName LIKE '%" . $this->userName . "%'";
		if ($this->refNo != "")
			$query .= " AND M.jobNoNew LIKE '" . $this->refNo . "%'";
		if ($this->weatherId != "")
			$query .= " AND SP.weatherId = '" . $this->weatherId . "'";
		if ($this->surDate != "")
			$query .= " AND SP.surDate = '" . $this->surDate . "'";
		if ($this->surDateStart != "")
			$query .= " AND M.plannedSurveyDate >= '" . $this->surDateStart . "'";
		if ($this->surDateEnd != "")
			$query .= " AND M.plannedSurveyDate <= '" . $this->surDateEnd . "'";
		if ($this->inputTimeStart != "")
			$query .= " AND SP.inputTime >= '" . $this->inputTimeStart . "'";
		if ($this->inputTimeEnd != "")
			$query .= " AND SP.inputTime <= '" . $this->inputTimeEnd . "'";
		if ($this->supaIds != "")
			$query .= " AND SP.supaId IN (" . $this->supaIds . ")";
		if ($this->district != "")
			$query .= " AND M.jobNoNew LIKE '" . $this->district . "%'";
		if ($this->doDistrict != "") {
			$tempDoDist = explode ( ",", $this->doDistrict );
			$query .= " AND (1=2 ";
			for($i = 1; $i < count ( $tempDoDist ); $i ++) {
				$query .= " OR M.jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
			}
			$query .= ")";
		}
		if ($this->order != "")
			$query .= $this->order;
		if ($this->pageLimit != "")
			$query .= $this->pageLimit;

		$rows = array ();
		$sql = "SELECT M.jobNoNew,M.plannedSurveyDate,M.surveyTimeHours,M.surveyLocation,M.surveyorCode,M.surveyorName
			,M.surveyType
			,SP.*
			,S.engName
			FROM Survey_MainSchedule M
			LEFT JOIN Survey_SurveyPart SP ON M.jobNoNew = SP.refNo AND SP.delFlag = 'no' AND SP.isRelease = 'no'
			LEFT JOIN Survey_Surveyor S ON S.survId = SP.survId
			WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query( $sql );
//		print $sql;
		$result = array();
		while ( $rs = $this->db->next_record () ) {
			$result[] = $rs;
		}
		return $result;
	}

	/**
	 * 获取调查列表
	 * @return array
	 */
	function GetListSearchCount2() {
		$query = "";
		if ($this->supaId != "")
			$query .= " AND SP.supaId = " . $this->supaId;
		if ($this->userId != "")
			$query .= " AND SP.userId = " . $this->userId;
		if ($this->userName != "")
			$query .= " AND SP.userName LIKE '%" . $this->userName . "%'";
		if ($this->refNo != "")
			$query .= " AND M.jobNoNew LIKE '" . $this->refNo . "%'";
		if ($this->weatherId != "")
			$query .= " AND SP.weatherId = '" . $this->weatherId . "'";
		if ($this->surDate != "")
			$query .= " AND SP.surDate = '" . $this->surDate . "'";
		if ($this->surDateStart != "")
			$query .= " AND M.plannedSurveyDate >= '" . $this->surDateStart . "'";
		if ($this->surDateEnd != "")
			$query .= " AND M.plannedSurveyDate <= '" . $this->surDateEnd . "'";
		if ($this->inputTimeStart != "")
			$query .= " AND SP.inputTime >= '" . $this->inputTimeStart . "'";
		if ($this->inputTimeEnd != "")
			$query .= " AND SP.inputTime <= '" . $this->inputTimeEnd . "'";
		if ($this->supaIds != "")
			$query .= " AND SP.supaId IN (" . $this->supaIds . ")";
		if ($this->district != "")
			$query .= " AND M.jobNoNew LIKE '" . $this->district . "%'";
		if ($this->doDistrict != "") {
			$tempDoDist = explode ( ",", $this->doDistrict );
			$query .= " AND (1=2 ";
			for($i = 1; $i < count ( $tempDoDist ); $i ++) {
				$query .= " OR M.jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
			}
			$query .= ")";
		}

		$rows = array ();
		$sql = "SELECT COUNT(*) AS rowNum
			FROM Survey_MainSchedule M
			LEFT JOIN Survey_SurveyPart SP ON M.jobNoNew = SP.refNo AND SP.delFlag = 'no' AND SP.isRelease = 'no'
			WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rowNum = 0;
		if ($rs = $this->db->next_record ()) {
			$rowNum = $rs ["rowNum"];
		}
		return $rowNum;
	}
	
	/*
	 * 查找合并后的档案
	 */
	function GetMergedListSearch() {
		$query = "";
		if ($this->supaId != "")
			$query .= " AND SP.supaId = " . $this->supaId;
		if ($this->userId != "")
			$query .= " AND SP.userId = " . $this->userId;
		if ($this->routeNo != "")
			$query .= " AND BS.routeNo = '" . $this->routeNo . "'";
		if ($this->surDate != "")
			$query .= " AND SP.surDate = '" . $this->surDate . "'";
		if ($this->supaIds != "")
			$query .= " AND SP.supaId IN (" . $this->supaIds . ")";
		if ($this->delFlag != "")
			$query .= " AND SP.delFlag = '" . $this->delFlag . "'";
		if ($this->newsupaId != "")
			$query .= " AND SPM.newsupaId = " . $this->newsupaId;
		
		$rows = array ();
		$sql = "SELECT DISTINCT SP.*,BT.engName FROM  Survey_SurveyPart SP " . " INNER JOIN Survey_Bus BS ON SP.busId = BS.busId" . " INNER JOIN Survey_BusType BT ON BS.typeId = BT.butyId " . " INNER JOIN Survey_SurveyPartMerge SPM ON SPM.newSupaId = SP.supaId " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$sql = $sql . $this->order;
		$this->db->query ( $sql );
		// print $sql;
		while ( $rs = $this->db->next_record () ) {
			$sp = new SurveyPart ( $this->db );
			$sp->supaId = $rs ['supaId'];
			$sp->refNo = $rs ['refNo'];
			$sp->weatherId = $rs ['weatherId'];
			$sp->surDate = $rs ['surDate'];
			$sp->surFromTime = $rs ['surFromTime'];
			$sp->surToTime = $rs ['surToTime'];
			$sp->surId = $rs ['surId'];
			$sp->busId = $rs ['busId'];
			$sp->routeNo = $rs ['routeNo'];
			$sp->location = $rs ['location'];
			$sp->bounds = $rs ['bounds'];
			$sp->schNo = $rs ['schNo'];
			$sp->schType = $rs ['schType'];
			$sp->busId2 = $rs ['busId2'];
			$sp->routeNo2 = $rs ['routeNo2'];
			$sp->schNo2 = $rs ['schNo2'];
			$sp->schType2 = $rs ['schType2'];
			$sp->remarks = $rs ['remarks'];
			$sp->userId = $rs ['userId'];
			$sp->userName = $rs ['userName'];
			$sp->inputTime = $rs ['inputTime'];
			$sp->modifyTime = $rs ['modifyTime'];
			$sp->modifyUserId = $rs ['modifyUserId'];
			$sp->modifyUserName = $rs ['modifyUserName'];
			$sp->delFlag = $rs ['delFlag'];
			$sp->type = $db->Record ["engName"];
			$rows [] = $sp;
		}
		return $rows;
	}
	
	/*
	 * 查找合并前的档案
	 */
	function GetNotMergedListSearch() {
		$query = "";
		if ($this->supaId != "")
			$query .= " AND SP.supaId = " . $this->supaId;
		if ($this->userId != "")
			$query .= " AND SP.userId = " . $this->userId;
		if ($this->routeNo != "")
			$query .= " AND BS.routeNo = '" . $this->routeNo . "'";
		if ($this->surDate != "")
			$query .= " AND SP.surDate = '" . $this->surDate . "'";
		if ($this->supaIds != "")
			$query .= " AND SP.supaId IN (" . $this->supaIds . ")";
		if ($this->delFlag != "")
			$query .= " AND SP.delFlag = '" . $this->delFlag . "'";
		if ($this->newsupaId != "")
			$query .= " AND SPM.newsupaId = " . $this->newsupaId;
		$rows = array ();
		$sql = "SELECT DISTINCT SP.*,BT.engName FROM  Survey_SurveyPart SP " . " INNER JOIN Survey_Bus BS ON SP.busId = BS.busId" . " INNER JOIN Survey_BusType BT ON BS.typeId = BT.butyId " . " INNER JOIN Survey_SurveyPartMerge SPM ON SPM.oldSupaId = SP.supaId " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$sql = $sql . $this->order;
		$this->db->query ( $sql );
		// print $sql;
		while ( $rs = $this->db->next_record () ) {
			$sp = new SurveyPart ( $this->db );
			$sp->supaId = $rs ['supaId'];
			$sp->refNo = $rs ['refNo'];
			$sp->weatherId = $rs ['weatherId'];
			$sp->surDate = $rs ['surDate'];
			$sp->surFromTime = $rs ['surFromTime'];
			$sp->surToTime = $rs ['surToTime'];
			$sp->surId = $rs ['surId'];
			$sp->busId = $rs ['busId'];
			$sp->routeNo = $rs ['routeNo'];
			$sp->location = $rs ['location'];
			$sp->bounds = $rs ['bounds'];
			$sp->schNo = $rs ['schNo'];
			$sp->schType = $rs ['schType'];
			$sp->busId2 = $rs ['busId2'];
			$sp->routeNo2 = $rs ['routeNo2'];
			$sp->schNo2 = $rs ['schNo2'];
			$sp->schType2 = $rs ['schType2'];
			$sp->remarks = $rs ['remarks'];
			$sp->userId = $rs ['userId'];
			$sp->userName = $rs ['userName'];
			$sp->inputTime = $rs ['inputTime'];
			$sp->modifyTime = $rs ['modifyTime'];
			$sp->modifyUserId = $rs ['modifyUserId'];
			$sp->modifyUserName = $rs ['modifyUserName'];
			$sp->delFlag = $rs ['delFlag'];
			$sp->type = $db->Record ["engName"];
			$rows [] = $sp;
		}
		return $rows;
	}
	function GetListAll() {
		$rows = array ();
		$query = "";
		$sql = "SELECT SP.*,BT.engName FROM  Survey_SurveyPart AS SP INNER JOIN Survey_Bus AS BS ON SP.busId = BS.busId" . " INNER JOIN Survey_BusType AS BT ON BS.typeId = BT.butyId" . " WHERE 1=1 ";
		if ($this->delFlag != '')
			$query .= " AND SP.delFlag = '" . $this->delFlag . "'";
		if ($this->order != '')
			$query .= $this->order;
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// print $sql;
		while ( $rs = $this->db->next_record () ) {
			$sp = new SurveyPart ( $this->db );
			$sp->supaId = $rs ['supaId'];
			$sp->refNo = $rs ['refNo'];
			$sp->weatherId = $rs ['weatherId'];
			$sp->surDate = $rs ['surDate'];
			$sp->surFromTime = $rs ['surFromTime'];
			$sp->surToTime = $rs ['surToTime'];
			$sp->surId = $rs ['surId'];
			$sp->busId = $rs ['busId'];
			$sp->routeNo = $rs ['routeNo'];
			$sp->location = $rs ['location'];
			$sp->bounds = $rs ['bounds'];
			$sp->busId2 = $rs ['busId2'];
			$sp->routeNo2 = $rs ['routeNo2'];
			$sp->schNo2 = $rs ['schNo2'];
			$sp->schType2 = $rs ['schType2'];
			$sp->remarks = $rs ['remarks'];
			$sp->userId = $rs ['userId'];
			$sp->userName = $rs ['userName'];
			$sp->inputTime = $rs ['inputTime'];
			$sp->modifyTime = $rs ['modifyTime'];
			$sp->modifyUserId = $rs ['modifyUserId'];
			$sp->modifyUserName = $rs ['modifyUserName'];
			$sp->delFlag = $rs ['delFlag'];
			$sp->type = $db->Record ["engName"];
			$rows [] = $sp;
		}
		return $rows;
	}
}
?>
