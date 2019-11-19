<?php
/*
 * Header: Create: 2013-07-16 Auther: James Wu<jamblues@gmail.com>.
 */
class SurveyGmbDetailAccess {
	var $db;
	function SurveyGmbDetailAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO Survey_SurveyGmbDetail(supaId,skippedStop,regplateNo,fleetNo,pslNo,arrivalTime,opendoorTime,departureTime,startPlace,startPlaceEng,endPlace,endPlaceEng,onArrival,setDown,setDown65,setDownAdult,setDownStudent,setDownHandicapped,setDownChildrenUniforms,setDownChildrenMufti,setDownChildrenHandicapped,pickup,pickup65,pickupAdult,pickupStudent,pickupHandicapped,pickupChildrenUniforms,pickupChildrenMufti,pickupChildrenHandicapped,onDept,leftBehind,leftBehindCar,leftBehindCarOut,driverName,userId,userName,inputTime,modifyTime,modifyUserId,modifyUserName,delFlag,leftRoleFlag)" . " VALUES('" . $obj->supaId . "'" . ",'" . $obj->skippedStop . "'" . ",'" . $obj->regplateNo . "'" . ",'" . $obj->fleetNo . "'" . ",'" . $obj->pslNo . "'" . ",'" . $obj->arrivalTime . "'" . ",'" . $obj->opendoorTime . "'" . ",'" . $obj->departureTime . "'" . ",'" . $obj->startPlace . "'" . ",'" . $obj->startPlaceEng . "'" . ",'" . $obj->endPlace . "'" . ",'" . $obj->endPlaceEng . "'" . ",'" . $obj->onArrival . "'" . ",'" . $obj->setDown . "'" . ",'" . $obj->setDown65 . "'" . ",'" . $obj->setDownAdult . "'" . ",'" . $obj->setDownStudent . "'" . ",'" . $obj->setDownHandicapped . "'" . ",'" . $obj->setDownChildrenUniforms . "'" . ",'" . $obj->setDownChildrenMufti . "'" . ",'" . $obj->setDownChildrenHandicapped . "'" . ",'" . $obj->pickup . "'" . ",'" . $obj->pickup65 . "'" . ",'" . $obj->pickupAdult . "'" . ",'" . $obj->pickupStudent . "'" . ",'" . $obj->pickupHandicapped . "'" . ",'" . $obj->pickupChildrenUniforms . "'" . ",'" . $obj->pickupChildrenMufti . "'" . ",'" . $obj->pickupChildrenHandicapped . "'" . ",'" . $obj->onDept . "'" . ",'" . $obj->leftBehind . "'" . ",'" . $obj->leftBehindCar . "'" . ",'" . $obj->leftBehindCarOut . "'" . ",'" . $obj->driverName . "'" . ",'" . $obj->userId . "'" . ",'" . $obj->userName . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyUserName . "'" . ",'" . $obj->delFlag . "'" . ",'" . $obj->leftRoleFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_SurveyGmbDetail " . " SET supaId = '" . $obj->supaId . "'" . " ,skippedStop = '" . $obj->skippedStop . "'" . " ,regplateNo = '" . $obj->regplateNo . "'" . " ,fleetNo = '" . $obj->fleetNo . "'" . " ,pslNo = '" . $obj->pslNo . "'" . " ,arrivalTime = '" . $obj->arrivalTime . "'" . " ,opendoorTime = '" . $obj->opendoorTime . "'" . " ,departureTime = '" . $obj->departureTime . "'" . " ,startPlace = '" . $obj->startPlace . "'" . " ,startPlaceEng = '" . $obj->startPlaceEng . "'" . " ,endPlace = '" . $obj->endPlace . "'" . " ,endPlaceEng = '" . $obj->endPlaceEng . "'" . " ,onArrival = '" . $obj->onArrival . "'" . " ,setDown = '" . $obj->setDown . "'" . " ,setDown65 = '" . $obj->setDown65 . "'" . " ,setDownAdult = '" . $obj->setDownAdult . "'" . " ,setDownStudent = '" . $obj->setDownStudent . "'" . " ,setDownHandicapped = '" . $obj->setDownHandicapped . "'" . " ,setDownChildrenUniforms = '" . $obj->setDownChildrenUniforms . "'" . " ,setDownChildrenMufti = '" . $obj->setDownChildrenMufti . "'" . " ,setDownChildrenHandicapped = '" . $obj->setDownChildrenHandicapped . "'" . " ,pickup = '" . $obj->pickup . "'" . " ,pickup65 = '" . $obj->pickup65 . "'" . " ,pickupAdult = '" . $obj->pickupAdult . "'" . " ,pickupStudent = '" . $obj->pickupStudent . "'" . " ,pickupHandicapped = '" . $obj->pickupHandicapped . "'" . " ,pickupChildrenUniforms = '" . $obj->pickupChildrenUniforms . "'" . " ,pickupChildrenMufti = '" . $obj->pickupChildrenMufti . "'" . " ,pickupChildrenHandicapped = '" . $obj->pickupChildrenHandicapped . "'" . " ,onDept = '" . $obj->onDept . "'" . " ,leftBehind = '" . $obj->leftBehind . "'" . " ,leftBehindCar = '" . $obj->leftBehindCar . "'" . " ,leftBehindCarOut = '" . $obj->leftBehindCarOut . "'" . " ,driverName = '" . $obj->driverName . "'" . " ,userId = '" . $obj->userId . "'" . " ,userName = '" . $obj->userName . "'" . " ,inputTime = '" . $obj->inputTime . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyUserName = '" . $obj->modifyUserName . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " ,leftRoleFlag = '" . $obj->leftRoleFlag . "'" . " WHERE 1=1  AND sudeId = '" . $obj->sudeId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_SurveyGmbDetail " . " SET delFlag='yes' " . " WHERE 1=1  AND sudeId = '" . $obj->sudeId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_SurveyGmbDetail " . " WHERE 1=1 AND sudeId = '" . $obj->sudeId . "'";
		$this->db->query ( $sql );
	}
	
	/**
	 * 刪除舊的數據
	 * 
	 * @param SurveyGmbDetail $obj        	
	 */
	function RealDelBySupaId($obj) {
		$sql = "DELETE FROM Survey_SurveyGmbDetail " . " WHERE 1=1 AND supaId = '" . $obj->supaId . "'";
		$this->db->query ( $sql );
	}
	
	/**
	 * 將下車人數=到達車上人數,上車人數=離站車上人數
	 * 
	 * @param SurveyGmbDetail $obj        	
	 */
	function UpdateOnArrivalOnDeptBySupaId($obj) {
		$sql = "UPDATE Survey_SurveyGmbDetail SET onArrival=setDown , onDept=pickup " . " WHERE 1=1 AND supaId = '" . $obj->supaId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->sudeId != '')
			$query .= " AND sudeId = '" . $obj->sudeId . "'";
		if ($obj->supaId != '')
			$query .= " AND supaId = '" . $obj->supaId . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_SurveyGmbDetail " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// echo $sql."<br />";
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new SurveyGmbDetail ();
			$obj->sudeId = $rs ["sudeId"];
			$obj->supaId = $rs ["supaId"];
			$obj->skippedStop = $rs ["skippedStop"];
			$obj->regplateNo = $rs ["regplateNo"];
			$obj->fleetNo = $rs ["fleetNo"];
			$obj->pslNo = $rs ["pslNo"];
			$obj->arrivalTime = $rs ["arrivalTime"];
			$obj->opendoorTime = $rs ["opendoorTime"];
			$obj->departureTime = $rs ["departureTime"];
			$obj->startPlace = $rs ["startPlace"];
			$obj->startPlaceEng = $rs ["startPlaceEng"];
			$obj->endPlace = $rs ["endPlace"];
			$obj->endPlaceEng = $rs ["endPlaceEng"];
			$obj->onArrival = $rs ["onArrival"];
			$obj->setDown = $rs ["setDown"];
			$obj->setDown65 = $rs ["setDown65"];
			$obj->setDownAdult = $rs ["setDownAdult"];
			$obj->setDownStudent = $rs ["setDownStudent"];
			$obj->setDownHandicapped = $rs ["setDownHandicapped"];
			$obj->setDownChildrenUniforms = $rs ["setDownChildrenUniforms"];
			$obj->setDownChildrenMufti = $rs ["setDownChildrenMufti"];
			$obj->setDownChildrenHandicapped = $rs ["setDownChildrenHandicapped"];
			$obj->pickup = $rs ["pickup"];
			$obj->pickup65 = $rs ["pickup65"];
			$obj->pickupAdult = $rs ["pickupAdult"];
			$obj->pickupStudent = $rs ["pickupStudent"];
			$obj->pickupHandicapped = $rs ["pickupHandicapped"];
			$obj->pickupChildrenUniforms = $rs ["pickupChildrenUniforms"];
			$obj->pickupChildrenMufti = $rs ["pickupChildrenMufti"];
			$obj->pickupChildrenHandicapped = $rs ["pickupChildrenHandicapped"];
			$obj->onDept = $rs ["onDept"];
			$obj->leftBehind = $rs ["leftBehind"];
			$obj->leftBehindCar = $rs ["leftBehindCar"];
			$obj->leftBehindCarOut = $rs ["leftBehindCarOut"];
			$obj->driverName = $rs ["driverName"];
			$obj->userId = $rs ["userId"];
			$obj->userName = $rs ["userName"];
			$obj->inputTime = $rs ["inputTime"];
			$obj->modifyTime = $rs ["modifyTime"];
			$obj->modifyUserId = $rs ["modifyUserId"];
			$obj->modifyUserName = $rs ["modifyUserName"];
			$obj->delFlag = $rs ["delFlag"];
			$obj->leftRoleFlag = $rs ["leftRoleFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	function GetListSearchCount($obj) {
		$query = '';
		if ($obj->sudeId != '')
			$query .= " AND sudeId = '" . $obj->sudeId . "'";
		if ($obj->supaId != '')
			$query .= " AND supaId = '" . $obj->supaId . "'";
		if ($obj->fleetNo != "")
			$query .= "AND fleetNo = '" . $obj->fleetNo . "'";
		
		$sql = "SELECT COUNT(*) as totalNum FROM Survey_SurveyGmbDetail " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		while ( $rs = $this->db->next_record () ) {
			return $rs ['totalNum'];
		}
		return 0;
	}
}
?>