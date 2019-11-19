<?php
/*
 * Header: Create: 2014-02-18 Auther: James Wu<jamblues@gmail.com>.
 */
class SurveyGmbDriverAccess {
	var $db;
	function SurveyGmbDriverAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO Survey_SurveyGmbDriver(supaId,refNo,weatherId,surDate,surFromTime,surToTime,busId,routeNo,location,bounds,weekNo,isHoliday,driverName,workTimes,workOnceTimes,workHour,delFlag)" . " VALUES('" . $obj->supaId . "'" . ",'" . $obj->refNo . "'" . ",'" . $obj->weatherId . "'" . ",'" . $obj->surDate . "'" . ",'" . $obj->surFromTime . "'" . ",'" . $obj->surToTime . "'" . ",'" . $obj->busId . "'" . ",'" . $obj->routeNo . "'" . ",'" . $obj->location . "'" . ",'" . $obj->bounds . "'" . ",'" . $obj->weekNo . "'" . ",'" . $obj->isHoliday . "'" . ",'" . $obj->driverName . "'" . ",'" . $obj->workTimes . "'" . ",'" . $obj->workOnceTimes . "'" . ",'" . $obj->workHour . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_SurveyGmbDriver " . " SET supaId = '" . $obj->supaId . "'" . " ,refNo = '" . $obj->refNo . "'" . " ,weatherId = '" . $obj->weatherId . "'" . " ,surDate = '" . $obj->surDate . "'" . " ,surFromTime = '" . $obj->surFromTime . "'" . " ,surToTime = '" . $obj->surToTime . "'" . " ,busId = '" . $obj->busId . "'" . " ,routeNo = '" . $obj->routeNo . "'" . " ,location = '" . $obj->location . "'" . " ,bounds = '" . $obj->bounds . "'" . " ,weekNo = '" . $obj->weekNo . "'" . " ,isHoliday = '" . $obj->isHoliday . "'" . " ,driverName = '" . $obj->driverName . "'" . " ,workTimes = '" . $obj->workTimes . "'" . " ,workOnceTimes = '" . $obj->workOnceTimes . "'" . " ,workHour = '" . $obj->workHour . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND sgdrId = '" . $obj->sgdrId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_SurveyGmbDriver " . " SET delFlag='yes' " . " WHERE 1=1  AND sgdrId = '" . $obj->sgdrId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_SurveyGmbDriver " . " WHERE 1=1  AND sgdrId = '" . $obj->sgdrId . "'";
		$this->db->query ( $sql );
	}
	function RealDelBy($obj) {
		$query = " AND refNo = '{$obj->refNo}'";
		$query .= " AND weatherId = '{$obj->weatherId}'";
		if ($obj->surDate != "")
			$query .= " AND surDate = '{$obj->surDate}'";
		if ($obj->routeNo != "")
			$query .= " AND routeNo = '{$obj->routeNo}'";
		
		$sql = "DELETE FROM Survey_SurveyGmbDriver " . " WHERE 1=1  ";
		$sql .= $query;
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->sgdrId != '')
			$query .= " AND sgdrId = '" . $obj->sgdrId . "'";
		if ($obj->supaId != '')
			$query .= " AND supaId = '" . $obj->supaId . "'";
		if ($obj->refNo != '')
			$query .= " AND refNo = '" . $obj->refNo . "'";
		if (isset ( $obj->weatherId ))
			$query .= " AND weatherId = '" . $obj->weatherId . "'";
		if ($obj->surDate != '')
			$query .= " AND surDate = '" . $obj->surDate . "'";
		if ($obj->surFromTime != '')
			$query .= " AND surFromTime = '" . $obj->surFromTime . "'";
		if ($obj->surToTime != '')
			$query .= " AND surToTime = '" . $obj->surToTime . "'";
		if ($obj->busId != '')
			$query .= " AND busId = '" . $obj->busId . "'";
		if ($obj->routeNo != '')
			$query .= " AND routeNo = '" . $obj->routeNo . "'";
		if ($obj->location != '')
			$query .= " AND location = '" . $obj->location . "'";
		if ($obj->bounds != '')
			$query .= " AND bounds = '" . $obj->bounds . "'";
		if ($obj->weekNo != '')
			$query .= " AND weekNo = '" . $obj->weekNo . "'";
		if ($obj->isHoliday != '')
			$query .= " AND isHoliday = '" . $obj->isHoliday . "'";
		if ($obj->driverName != '')
			$query .= " AND driverName = '" . $obj->driverName . "'";
		if ($obj->workTimes != '')
			$query .= " AND workTimes = '" . $obj->workTimes . "'";
		if ($obj->workOnceTimes != '')
			$query .= " AND workOnceTimes = '" . $obj->workOnceTimes . "'";
		if ($obj->workHour != '')
			$query .= " AND workHour = '" . $obj->workHour . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_SurveyGmbDriver " . " WHERE 1=1 ";
		$sql = $sql . $query;
		// echo $sql; exit();
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new SurveyGmbDriver ();
			$obj->sgdrId = $rs ["sgdrId"];
			$obj->supaId = $rs ["supaId"];
			$obj->refNo = $rs ["refNo"];
			$obj->weatherId = $rs ["weatherId"];
			$obj->surDate = $rs ["surDate"];
			$obj->surFromTime = $rs ["surFromTime"];
			$obj->surToTime = $rs ["surToTime"];
			$obj->busId = $rs ["busId"];
			$obj->routeNo = $rs ["routeNo"];
			$obj->location = $rs ["location"];
			$obj->bounds = $rs ["bounds"];
			$obj->weekNo = $rs ["weekNo"];
			$obj->isHoliday = $rs ["isHoliday"];
			$obj->driverName = $rs ["driverName"];
			$obj->workTimes = $rs ["workTimes"];
			$obj->workOnceTimes = $rs ["workOnceTimes"];
			$obj->workHour = $rs ["workHour"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>