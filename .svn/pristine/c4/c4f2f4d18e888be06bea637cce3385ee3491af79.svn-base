<?php
/*
 * Header: Create: 2013-07-16 Auther: James Wu<jamblues@gmail.com>.
 */
class SurveyGmbPartAccess {
	var $db;
	function SurveyGmbPartAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO Survey_SurveyGmbPart(refNo,weatherId,surDate,surFromTime,surToTime,surId,busId,routeNo,location,bounds,schNo,schType,survId,userId,userName,inputTime,modifyTime,modifyUserId,modifyUserName,delFlag,isRelease)" . " VALUES('" . $obj->refNo . "'" . ",'" . $obj->weatherId . "'" . ",'" . $obj->surDate . "'" . ",'" . $obj->surFromTime . "'" . ",'" . $obj->surToTime . "'" . ",'" . $obj->surId . "'" . ",'" . $obj->busId . "'" . ",'" . $obj->routeNo . "'" . ",'" . $obj->location . "'" . ",'" . $obj->bounds . "'" . ",'" . $obj->schNo . "'" . ",'" . $obj->schType . "'" . ",'" . $obj->survId . "'" . ",'" . $obj->userId . "'" . ",'" . $obj->userName . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyUserName . "'" . ",'" . $obj->delFlag . "'" . ",'" . $obj->isRelease . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_SurveyGmbPart " . " SET refNo = '" . $obj->refNo . "'" . " ,weatherId = '" . $obj->weatherId . "'" . " ,surDate = '" . $obj->surDate . "'" . " ,surFromTime = '" . $obj->surFromTime . "'" . " ,surToTime = '" . $obj->surToTime . "'" . " ,surId = '" . $obj->surId . "'" . " ,busId = '" . $obj->busId . "'" . " ,routeNo = '" . $obj->routeNo . "'" . " ,location = '" . $obj->location . "'" . " ,bounds = '" . $obj->bounds . "'" . " ,schNo = '" . $obj->schNo . "'" . " ,schType = '" . $obj->schType . "'" . " ,survId = '" . $obj->survId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyUserName = '" . $obj->modifyUserName . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " ,isRelease = '" . $obj->isRelease . "'" . " WHERE 1=1  AND supaId = '" . $obj->supaId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_SurveyGmbPart " . " SET delFlag='yes' " . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyUserName = '" . $obj->modifyUserName . "'" . " WHERE 1=1  AND supaId = '" . $obj->supaId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_SurveyGmbPart " . " WHERE 1=1  AND supaId = '" . $obj->supaId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearchCount($obj) {
		$query = '';
		if ($obj->supaId != '')
			$query .= " AND supaId = '" . $obj->supaId . "'";
		if ($obj->refNo != '')
			$query .= " AND refNo = '" . $obj->refNo . "'";
		if ($obj->weatherId != '')
			$query .= " AND weatherId = '" . $obj->weatherId . "'";
		if ($obj->surDate != '')
			$query .= " AND surDate = '" . $obj->surDate . "'";
		if ($obj->surDateStart != '')
			$query .= " AND surDate >= '" . $obj->surDateStart . "'";
		if ($obj->surDateEnd != '')
			$query .= " AND surDate <= '" . $obj->surDateEnd . "'";
		if ($obj->surFromTime != '')
			$query .= " AND surFromTime = '" . $obj->surFromTime . "'";
		if ($obj->surToTime != '')
			$query .= " AND surToTime = '" . $obj->surToTime . "'";
		if ($obj->surId != '')
			$query .= " AND surId = '" . $obj->surId . "'";
		if ($obj->busId != '')
			$query .= " AND busId = '" . $obj->busId . "'";
		if ($obj->routeNo != '')
			$query .= " AND routeNo = '" . $obj->routeNo . "'";
		if ($obj->location != '')
			$query .= " AND location = '" . $obj->location . "'";
		if ($obj->bounds != '')
			$query .= " AND bounds = '" . $obj->bounds . "'";
		if ($obj->schNo != '')
			$query .= " AND schNo = '" . $obj->schNo . "'";
		if ($obj->schType != '')
			$query .= " AND schType = '" . $obj->schType . "'";
		if ($obj->survId != '')
			$query .= " AND survId = '" . $obj->survId . "'";
		if ($obj->userId != '')
			$query .= " AND userId = '" . $obj->userId . "'";
		if ($obj->userName != '')
			$query .= " AND userName = '" . $obj->userName . "'";
		if ($obj->inputTime != '')
			$query .= " AND inputTime = '" . $obj->inputTime . "'";
		if ($obj->modifyTime != '')
			$query .= " AND modifyTime = '" . $obj->modifyTime . "'";
		if ($obj->modifyUserId != '')
			$query .= " AND modifyUserId = '" . $obj->modifyUserId . "'";
		if ($obj->modifyUserName != '')
			$query .= " AND modifyUserName = '" . $obj->modifyUserName . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->isRelease != '')
			$query .= " AND isRelease = '" . $obj->isRelease . "'";
		
		$sql = "SELECT COUNT(*) AS rowNum FROM Survey_SurveyGmbPart " . " WHERE 1=1 ";
		$sql = $sql . $query;
		// echo $sql;exit();
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			return $rs ["rowNum"];
		}
		return 0;
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->supaId != '')
			$query .= " AND sgp.supaId = '" . $obj->supaId . "'";
		if ($obj->refNo != '')
			$query .= " AND sgp.refNo = '" . $obj->refNo . "'";
		if ($obj->weatherId != '')
			$query .= " AND sgp.weatherId = '" . $obj->weatherId . "'";
		if ($obj->surDate != '')
			$query .= " AND sgp.surDate = '" . $obj->surDate . "'";
		if ($obj->surDateStart != '')
			$query .= " AND surDate >= '" . $obj->surDateStart . "'";
		if ($obj->surDateEnd != '')
			$query .= " AND surDate <= '" . $obj->surDateEnd . "'";
		if ($obj->surFromTime != '')
			$query .= " AND sgp.surFromTime = '" . $obj->surFromTime . "'";
		if ($obj->surToTime != '')
			$query .= " AND sgp.surToTime = '" . $obj->surToTime . "'";
		if ($obj->surId != '')
			$query .= " AND sgp.surId = '" . $obj->surId . "'";
		if ($obj->busId != '')
			$query .= " AND sgp.busId = '" . $obj->busId . "'";
		if ($obj->routeNo != '')
			$query .= " AND sgp.routeNo = '" . $obj->routeNo . "'";
		if ($obj->location != '')
			$query .= " AND sgp.location = '" . $obj->location . "'";
		if ($obj->bounds != '')
			$query .= " AND sgp.bounds = '" . $obj->bounds . "'";
		if ($obj->schNo != '')
			$query .= " AND sgp.schNo = '" . $obj->schNo . "'";
		if ($obj->schType != '')
			$query .= " AND sgp.schType = '" . $obj->schType . "'";
		if ($obj->survId != '')
			$query .= " AND sgp.survId = '" . $obj->survId . "'";
		if ($obj->userId != '')
			$query .= " AND sgp.userId = '" . $obj->userId . "'";
		if ($obj->userName != '')
			$query .= " AND sgp.userName = '" . $obj->userName . "'";
		if ($obj->inputTime != '')
			$query .= " AND sgp.inputTime = '" . $obj->inputTime . "'";
		if ($obj->modifyTime != '')
			$query .= " AND sgp.modifyTime = '" . $obj->modifyTime . "'";
		if ($obj->modifyUserId != '')
			$query .= " AND sgp.modifyUserId = '" . $obj->modifyUserId . "'";
		if ($obj->modifyUserName != '')
			$query .= " AND sgp.modifyUserName = '" . $obj->modifyUserName . "'";
		if ($obj->delFlag != '')
			$query .= " AND sgp.delFlag = '" . $obj->delFlag . "'";
		if ($obj->isRelease != '')
			$query .= " AND sgp.isRelease = '" . $obj->isRelease . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT sgp.*,b.sofsDate,bt.engName FROM Survey_SurveyGmbPart sgp" . " LEFT JOIN Survey_Bus b ON sgp.busId = b.busId" . " LEFT JOIN Survey_BusType bt ON b.typeId = bt.butyId " . " WHERE 1=1 ";
		$sql = $sql . $query;
		// echo $sql;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new SurveyGmbPart ();
			$obj->supaId = $rs ["supaId"];
			$obj->refNo = $rs ["refNo"];
			$obj->weatherId = $rs ["weatherId"];
			$obj->surDate = $rs ["surDate"];
			$obj->surFromTime = $rs ["surFromTime"];
			$obj->surToTime = $rs ["surToTime"];
			$obj->surId = $rs ["surId"];
			$obj->busId = $rs ["busId"];
			$obj->routeNo = $rs ["routeNo"];
			$obj->location = $rs ["location"];
			$obj->bounds = $rs ["bounds"];
			$obj->schNo = $rs ["schNo"];
			$obj->schType = $rs ["schType"];
			$obj->survId = $rs ["survId"];
			$obj->userId = $rs ["userId"];
			$obj->userName = $rs ["userName"];
			$obj->inputTime = $rs ["inputTime"];
			$obj->modifyTime = $rs ["modifyTime"];
			$obj->modifyUserId = $rs ["modifyUserId"];
			$obj->modifyUserName = $rs ["modifyUserName"];
			$obj->delFlag = $rs ["delFlag"];
			$obj->isRelease = $rs ["isRelease"];
			$obj->type = $rs ["engName"];
			$obj->sofsDate = $rs ["sofsDate"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>