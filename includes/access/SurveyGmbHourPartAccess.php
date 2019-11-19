<?php
/*
 * Header: Create: 2014-02-18 Auther: James Wu<jamblues@gmail.com>.
 */
class SurveyGmbHourPartAccess {
	var $db;
	function SurveyGmbHourPartAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO Survey_SurveyGmbHourPart(supaId,refNo,weatherId,surDate,surFromTime,surToTime,busId,routeNo,location,bounds,scheduledTrip,observedTrip,scheduledVehicles,observedVehicles,schedueldHeadway,observedHeadway,peakHourStarting,peakFrequency,peakPeriod,onDepartures,obsNoOfDepartures,averageWaitingTime,leftBehindSum,leftBehindCount,leftBehindMin,leftBehindMax,offLefttBehindCount,offLefttBehindMin,offLefttBehindMax,passengerSetDown,passengerOccupiedOnArrival,passengerPickUp,pssengerOccupiedOnDeparture,delFlag)" . " VALUES('" . $obj->supaId . "'" . ",'" . $obj->refNo . "'" . ",'" . $obj->weatherId . "'" . ",'" . $obj->surDate . "'" . ",'" . $obj->surFromTime . "'" . ",'" . $obj->surToTime . "'" . ",'" . $obj->busId . "'" . ",'" . $obj->routeNo . "'" . ",'" . $obj->location . "'" . ",'" . $obj->bounds . "'" . ",'" . $obj->scheduledTrip . "'" . ",'" . $obj->observedTrip . "'" . ",'" . $obj->scheduledVehicles . "'" . ",'" . $obj->observedVehicles . "'" . ",'" . $obj->schedueldHeadway . "'" . ",'" . $obj->observedHeadway . "'" . ",'" . $obj->peakHourStarting . "'" . ",'" . $obj->peakFrequency . "'" . ",'" . $obj->peakPeriod . "'" . ",'" . $obj->onDepartures . "'" . ",'" . $obj->obsNoOfDepartures . "'" . ",'" . $obj->averageWaitingTime . "'" . ",'" . $obj->leftBehindSum . "'" . ",'" . $obj->leftBehindCount . "'" . ",'" . $obj->leftBehindMin . "'" . ",'" . $obj->leftBehindMax . "'" . ",'" . $obj->offLefttBehindCount . "'" . ",'" . $obj->offLefttBehindMin . "'" . ",'" . $obj->offLefttBehindMax . "'" . ",'" . $obj->passengerSetDown . "'" . ",'" . $obj->passengerOccupiedOnArrival . "'" . ",'" . $obj->passengerPickUp . "'" . ",'" . $obj->pssengerOccupiedOnDeparture . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_SurveyGmbHourPart " . " SET refNo = '" . $obj->refNo . "'" . " ,weatherId = '" . $obj->weatherId . "'" . " ,surDate = '" . $obj->surDate . "'" . " ,surFromTime = '" . $obj->surFromTime . "'" . " ,surToTime = '" . $obj->surToTime . "'" . " ,busId = '" . $obj->busId . "'" . " ,routeNo = '" . $obj->routeNo . "'" . " ,location = '" . $obj->location . "'" . " ,bounds = '" . $obj->bounds . "'" . " ,scheduledTrip = '" . $obj->scheduledTrip . "'" . " ,observedTrip = '" . $obj->observedTrip . "'" . " ,scheduledVehicles = '" . $obj->scheduledVehicles . "'" . " ,observedVehicles = '" . $obj->observedVehicles . "'" . " ,schedueldHeadway = '" . $obj->schedueldHeadway . "'" . " ,observedHeadway = '" . $obj->observedHeadway . "'" . " ,peakHourStarting = '" . $obj->peakHourStarting . "'" . " ,peakFrequency = '" . $obj->peakFrequency . "'" . " ,peakPeriod = '" . $obj->peakPeriod . "'" . " ,onDepartures = '" . $obj->onDepartures . "'" . " ,obsNoOfDepartures = '" . $obj->obsNoOfDepartures . "'" . " ,averageWaitingTime = '" . $obj->averageWaitingTime . "'" . " ,leftBehindSum = '" . $obj->leftBehindSum . "'" . " ,leftBehindCount = '" . $obj->leftBehindCount . "'" . " ,leftBehindMin = '" . $obj->leftBehindMin . "'" . " ,leftBehindMax = '" . $obj->leftBehindMax . "'" . " ,offLefttBehindCount = '" . $obj->offLefttBehindCount . "'" . " ,offLefttBehindMin = '" . $obj->offLefttBehindMin . "'" . " ,offLefttBehindMax = '" . $obj->offLefttBehindMax . "'" . " ,passengerSetDown = '" . $obj->passengerSetDown . "'" . " ,passengerOccupiedOnArrival = '" . $obj->passengerOccupiedOnArrival . "'" . " ,passengerPickUp = '" . $obj->passengerPickUp . "'" . " ,pssengerOccupiedOnDeparture = '" . $obj->pssengerOccupiedOnDeparture . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND supaId = '" . $obj->supaId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_SurveyGmbHourPart " . " SET delFlag='yes' " . " WHERE 1=1  AND supaId = '" . $obj->supaId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_SurveyGmbHourPart " . " WHERE 1=1  AND supaId = '" . $obj->supaId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->supaId != '')
			$query .= " AND supaId = '" . $obj->supaId . "'";
		if ($obj->refNo != '')
			$query .= " AND refNo = '" . $obj->refNo . "'";
		if ($obj->weatherId != '')
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
		if ($obj->scheduledTrip != '')
			$query .= " AND scheduledTrip = '" . $obj->scheduledTrip . "'";
		if ($obj->observedTrip != '')
			$query .= " AND observedTrip = '" . $obj->observedTrip . "'";
		if ($obj->scheduledVehicles != '')
			$query .= " AND scheduledVehicles = '" . $obj->scheduledVehicles . "'";
		if ($obj->observedVehicles != '')
			$query .= " AND observedVehicles = '" . $obj->observedVehicles . "'";
		if ($obj->schedueldHeadway != '')
			$query .= " AND schedueldHeadway = '" . $obj->schedueldHeadway . "'";
		if ($obj->observedHeadway != '')
			$query .= " AND observedHeadway = '" . $obj->observedHeadway . "'";
		if ($obj->peakHourStarting != '')
			$query .= " AND peakHourStarting = '" . $obj->peakHourStarting . "'";
		if ($obj->peakFrequency != '')
			$query .= " AND peakFrequency = '" . $obj->peakFrequency . "'";
		if ($obj->peakPeriod != '')
			$query .= " AND peakPeriod = '" . $obj->peakPeriod . "'";
		if ($obj->onDepartures != '')
			$query .= " AND onDepartures = '" . $obj->onDepartures . "'";
		if ($obj->obsNoOfDepartures != '')
			$query .= " AND obsNoOfDepartures = '" . $obj->obsNoOfDepartures . "'";
		if ($obj->averageWaitingTime != '')
			$query .= " AND averageWaitingTime = '" . $obj->averageWaitingTime . "'";
		if ($obj->leftBehindSum != '')
			$query .= " AND leftBehindSum = '" . $obj->leftBehindSum . "'";
		if ($obj->leftBehindCount != '')
			$query .= " AND leftBehindCount = '" . $obj->leftBehindCount . "'";
		if ($obj->leftBehindMin != '')
			$query .= " AND leftBehindMin = '" . $obj->leftBehindMin . "'";
		if ($obj->leftBehindMax != '')
			$query .= " AND leftBehindMax = '" . $obj->leftBehindMax . "'";
		if ($obj->offLefttBehindCount != '')
			$query .= " AND offLefttBehindCount = '" . $obj->offLefttBehindCount . "'";
		if ($obj->offLefttBehindMin != '')
			$query .= " AND offLefttBehindMin = '" . $obj->offLefttBehindMin . "'";
		if ($obj->offLefttBehindMax != '')
			$query .= " AND offLefttBehindMax = '" . $obj->offLefttBehindMax . "'";
		if ($obj->passengerSetDown != '')
			$query .= " AND passengerSetDown = '" . $obj->passengerSetDown . "'";
		if ($obj->passengerOccupiedOnArrival != '')
			$query .= " AND passengerOccupiedOnArrival = '" . $obj->passengerOccupiedOnArrival . "'";
		if ($obj->passengerPickUp != '')
			$query .= " AND passengerPickUp = '" . $obj->passengerPickUp . "'";
		if ($obj->pssengerOccupiedOnDeparture != '')
			$query .= " AND pssengerOccupiedOnDeparture = '" . $obj->pssengerOccupiedOnDeparture . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_SurveyGmbHourPart " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new SurveyGmbHourPart ();
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
			$obj->scheduledTrip = $rs ["scheduledTrip"];
			$obj->observedTrip = $rs ["observedTrip"];
			$obj->scheduledVehicles = $rs ["scheduledVehicles"];
			$obj->observedVehicles = $rs ["observedVehicles"];
			$obj->schedueldHeadway = $rs ["schedueldHeadway"];
			$obj->observedHeadway = $rs ["observedHeadway"];
			$obj->peakHourStarting = $rs ["peakHourStarting"];
			$obj->peakFrequency = $rs ["peakFrequency"];
			$obj->peakPeriod = $rs ["peakPeriod"];
			$obj->onDepartures = $rs ["onDepartures"];
			$obj->obsNoOfDepartures = $rs ["obsNoOfDepartures"];
			$obj->averageWaitingTime = $rs ["averageWaitingTime"];
			$obj->leftBehindSum = $rs ["leftBehindSum"];
			$obj->leftBehindCount = $rs ["leftBehindCount"];
			$obj->leftBehindMin = $rs ["leftBehindMin"];
			$obj->leftBehindMax = $rs ["leftBehindMax"];
			$obj->offLefttBehindCount = $rs ["offLefttBehindCount"];
			$obj->offLefttBehindMin = $rs ["offLefttBehindMin"];
			$obj->offLefttBehindMax = $rs ["offLefttBehindMax"];
			$obj->passengerSetDown = $rs ["passengerSetDown"];
			$obj->passengerOccupiedOnArrival = $rs ["passengerOccupiedOnArrival"];
			$obj->passengerPickUp = $rs ["passengerPickUp"];
			$obj->pssengerOccupiedOnDeparture = $rs ["pssengerOccupiedOnDeparture"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>