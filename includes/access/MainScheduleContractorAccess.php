<?php
/*
 * Header: Create: 2013-01-31 Auther: James Wu<jamblues@gmail.com>.
 */
class MainScheduleContractorAccess {
	var $db;
	function MainScheduleContractorAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO Survey_MainScheduleContractor(jobNoNew,company,delFlag,inputUserId,inputTime,modifyUserId,modifyTime)" . " VALUES('" . $obj->jobNoNew . "'" . ",'" . $obj->company . "'" . ",'" . $obj->delFlag . "'" . ",'" . $obj->inputUserId . "'" . ",'" . $obj->inputTime . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyTime . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_MainScheduleContractor " . " SET jobNoNew = '" . $obj->jobNoNew . "'" . " ,company = '" . $obj->company . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " ,inputUserId = '" . $obj->inputUserId . "'" . " ,inputTime = '" . $obj->inputTime . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " WHERE 1=1  AND mscId = '" . $obj->mscId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_MainScheduleContractor " . " SET delFlag='yes' " . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " WHERE 1=1  AND mscId = '" . $obj->mscId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_MainScheduleContractor " . " WHERE 1=1  AND mscId = '" . $obj->mscId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->mscId != '')
			$query .= " AND mscId = '" . $obj->mscId . "'";
		if ($obj->jobNoNew != '')
			$query .= " AND jobNoNew = '" . $obj->jobNoNew . "'";
		if ($obj->company != '')
			$query .= " AND company = '" . $obj->company . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->inputUserId != '')
			$query .= " AND inputUserId = '" . $obj->inputUserId . "'";
		if ($obj->inputTime != '')
			$query .= " AND inputTime = '" . $obj->inputTime . "'";
		if ($obj->modifyUserId != '')
			$query .= " AND modifyUserId = '" . $obj->modifyUserId . "'";
		if ($obj->modifyTime != '')
			$query .= " AND modifyTime = '" . $obj->modifyTime . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_MainScheduleContractor " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new MainScheduleContractor ();
			$obj->mscId = $rs ["mscId"];
			$obj->jobNoNew = $rs ["jobNoNew"];
			$obj->company = $rs ["company"];
			$obj->delFlag = $rs ["delFlag"];
			$obj->inputUserId = $rs ["inputUserId"];
			$obj->inputTime = $rs ["inputTime"];
			$obj->modifyUserId = $rs ["modifyUserId"];
			$obj->modifyTime = $rs ["modifyTime"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 获取记录数
	 * 
	 * @param MainSchedule $obj        	
	 * @return multitype:MainSchedule
	 */
	function GetMainScheduleListCount($obj) {
		$query = '';
		if ($obj->mascId != '')
			$query .= " AND MS.mascId = '" . $obj->mascId . "'";
		if ($obj->weekNo != '')
			$query .= " AND MS.weekNo = '" . $obj->weekNo . "'";
		if ($obj->jobNo != '')
			$query .= " AND MS.jobNo = '" . $obj->jobNo . "'";
		if ($obj->jobNoNew != '')
			$query .= " AND MS.jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
		if ($obj->plannedSurveyDate != '')
			$query .= " AND MS.plannedSurveyDate = '" . $obj->plannedSurveyDate . "'";
		if ($obj->tdFileNo != '')
			$query .= " AND MS.tdFileNo = '" . $obj->tdFileNo . "'";
		if ($obj->receivedDate != '')
			$query .= " AND MS.receivedDate = '" . $obj->receivedDate . "'";
		if ($obj->dueDate != '')
			$query .= " AND MS.dueDate = '" . $obj->dueDate . "'";
		if ($obj->fromTD != '')
			$query .= " AND MS.fromTD like '%" . $obj->fromTD . "%'";
		if ($obj->actualSurveyDate != '')
			$query .= " AND MS.actualSurveyDate = '" . $obj->actualSurveyDate . "'";
		if ($obj->startTime_1 != '')
			$query .= " AND MS.startTime_1 = '" . $obj->startTime_1 . "'";
		if ($obj->endTime_1 != '')
			$query .= " AND MS.endTime_1 = '" . $obj->endTime_1 . "'";
		if ($obj->startTime_2 != '')
			$query .= " AND MS.startTime_2 = '" . $obj->startTime_2 . "'";
		if ($obj->endTime_2 != '')
			$query .= " AND MS.endTime_2 = '" . $obj->endTime_2 . "'";
		if ($obj->startTime_3 != '')
			$query .= " AND MS.startTime_3 = '" . $obj->startTime_3 . "'";
		if ($obj->endTime_3 != '')
			$query .= " AND MS.endTime_3 = '" . $obj->endTime_3 . "'";
		if ($obj->startTime_4 != '')
			$query .= " AND MS.startTime_4 = '" . $obj->startTime_4 . "'";
		if ($obj->endTime_4 != '')
			$query .= " AND MS.endTime_4 = '" . $obj->endTime_4 . "'";
		if ($obj->totalHours != '')
			$query .= " AND MS.totalHours = '" . $obj->totalHours . "'";
		if ($obj->surveyTimeHours != '')
			$query .= " AND MS.surveyTimeHours = '" . $obj->surveyTimeHours . "'";
		if ($obj->stCode != '')
			$query .= " AND MS.stCode = '" . $obj->stCode . "'";
		if ($obj->surveyType != '')
			$query .= " AND MS.surveyType = '" . $obj->surveyType . "'";
		if ($obj->vehCode != '')
			$query .= " AND MS.vehCode = '" . $obj->vehCode . "'";
		if ($obj->vehicle != '')
			$query .= " AND MS.vehicle = '" . $obj->vehicle . "'";
		if ($obj->isHoliday != '')
			$query .= " AND MS.isHoliday = '" . $obj->isHoliday . "'";
		if ($obj->bonusHours != '')
			$query .= " AND MS.bonusHours = '" . $obj->bonusHours . "'";
		if ($obj->surveyLocationDistrict != '')
			$query .= " AND MS.surveyLocationDistrict = '" . $obj->surveyLocationDistrict . "'";
		if ($obj->surveyLocation != '')
			$query .= " AND MS.surveyLocation = '" . $obj->surveyLocation . "'";
		if ($obj->routeItems != '')
			$query .= " AND MS.routeItems LIKE '%" . $obj->routeItems . "%'";
		if ($obj->noOfSurveyors != '')
			$query .= " AND MS.noOfSurveyors = '" . $obj->noOfSurveyors . "'";
		if ($obj->estimatedManHour != '')
			$query .= " AND MS.estimatedManHour = '" . $obj->estimatedManHour . "'";
		if ($obj->receiveDate != '')
			$query .= " AND MS.receiveDate = '" . $obj->receiveDate . "'";
		if ($obj->dataInputNo != '')
			$query .= " AND MS.dataInputNo = '" . $obj->dataInputNo . "'";
		if ($obj->dataInputBy != '')
			$query .= " AND MS.dataInputBy = '" . $obj->dataInputBy . "'";
		if ($obj->entryFormTypeNo != '')
			$query .= " AND MS.entryFormTypeNo = '" . $obj->entryFormTypeNo . "'";
		if ($obj->noOfPages != '')
			$query .= " AND MS.noOfPages = '" . $obj->noOfPages . "'";
		if ($obj->report !== NULL)
			$query .= " AND MS.report = '" . $obj->report . "'";
		if ($obj->hourlyRate != '')
			$query .= " AND MS.hourlyRate = '" . $obj->hourlyRate . "'";
		if ($obj->surveyFinding != '')
			$query .= " AND MS.surveyFinding = '" . $obj->surveyFinding . "'";
		if ($obj->am != '')
			$query .= " AND MS.am = '" . $obj->am . "'";
		if ($obj->periodHour_1 != '')
			$query .= " AND MS.periodHour_1 = '" . $obj->periodHour_1 . "'";
		if ($obj->periodWagesHr_1 != '')
			$query .= " AND MS.periodWagesHr_1 = '" . $obj->periodWagesHr_1 . "'";
		if ($obj->periodHour_2 != '')
			$query .= " AND MS.periodHour_2 = '" . $obj->periodHour_2 . "'";
		if ($obj->periodWagesHr_2 != '')
			$query .= " AND MS.periodWagesHr_2 = '" . $obj->periodWagesHr_2 . "'";
		if ($obj->totalWages != '')
			$query .= " AND MS.totalWages = '" . $obj->totalWages . "'";
		if ($obj->onBoardCostFare != '')
			$query .= " AND MS.onBoardCostFare = '" . $obj->onBoardCostFare . "'";
		if ($obj->noOfTrips != '')
			$query .= " AND MS.noOfTrips = '" . $obj->noOfTrips . "'";
		if ($obj->transportAllowanceAm != '')
			$query .= " AND MS.transportAllowanceAm = '" . $obj->transportAllowanceAm . "'";
		if ($obj->transportAllowanceNoon != '')
			$query .= " AND MS.transportAllowanceNoon = '" . $obj->transportAllowanceNoon . "'";
		if ($obj->transportAllowancePm != '')
			$query .= " AND MS.transportAllowancePm = '" . $obj->transportAllowancePm . "'";
		if ($obj->transportAllowanceOvernight != '')
			$query .= " AND MS.transportAllowanceOvernight = '" . $obj->transportAllowanceOvernight . "'";
		if ($obj->taTotal != '')
			$query .= " AND MS.taTotal = '" . $obj->taTotal . "'";
		if ($obj->wagesTaOnBoard != '')
			$query .= " AND MS.wagesTaOnBoard = '" . $obj->wagesTaOnBoard . "'";
		if ($obj->onBoardTranportAllowanceTotal != '')
			$query .= " AND MS.onBoardTranportAllowanceTotal = '" . $obj->onBoardTranportAllowanceTotal . "'";
		if ($obj->surveyorCode != '')
			$query .= " AND MS.surveyorCode = '" . $obj->surveyorCode . "'";
		if ($obj->surveyorName != '')
			$query .= " AND MS.surveyorName = '" . $obj->surveyorName . "'";
		if ($obj->surveyorTelephone != '')
			$query .= " AND MS.surveyorTelephone = '" . $obj->surveyorTelephone . "'";
		if ($obj->complateJobNo != '')
			$query .= " AND MS.complateJobNo = '" . $obj->complateJobNo . "'";
		if ($obj->distributedToLeader != '')
			$query .= " AND MS.distributedToLeader = '" . $obj->distributedToLeader . "'";
		if ($obj->reportWeek != '')
			$query .= " AND MS.reportWeek = '" . $obj->reportWeek . "'";
		if ($obj->direction != '')
			$query .= " AND MS.direction = '" . $obj->direction . "'";
		if ($obj->noPlannedSurveyDate) {
			if ($obj->plannedSurveyDateStart != '' && $obj->plannedSurveyDateEnd != '') {
				$query .= " AND ((plannedSurveyDate >= '{$obj->plannedSurveyDateStart}' 
					AND plannedSurveyDate < '{$obj->plannedSurveyDateEnd}') 
					OR plannedSurveyDate >= '')";
			} else if ($obj->plannedSurveyDateStart != '') {
				$query .= " AND (plannedSurveyDate >= '{$obj->plannedSurveyDateStart}' 
					OR plannedSurveyDate >= '')";
			}
		} else {
			if ($obj->plannedSurveyDateStart != '')
				$query .= " AND plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
			if ($obj->plannedSurveyDateEnd != '')
				$query .= " AND plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
		}
		if ($obj->doDistrict != "") {
			$tempDoDist = explode ( ",", $obj->doDistrict );
			$query .= " AND (1=2 ";
			for($i = 1; $i < count ( $tempDoDist ); $i ++) {
				$query .= " OR MS.jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
			}
			$query .= ")";
		}
		if ($obj->isAssigned === false) {
			$query .= " AND MS.surveyorCode = ''";
		} else if ($obj->isAssigned === true) {
			$query .= " AND MS.surveyorCode <> ''";
		}
		if ($this->order != '')
			$query .= $this->order;
		if ($this->pageLimit != '')
			$query .= $this->pageLimit;
		
		$sql = "SELECT COUNT(*) AS rowNum FROM Survey_MainScheduleContractor MSC" . " INNER JOIN Survey_MainSchedule MS ON MSC.delFlag='no' AND MSC.jobNoNew=MS.jobNoNew" . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// echo "{$sql}<br>";
		$rowNum = 0;
		if ($rs = $this->db->next_record ()) {
			$rowNum = $rs ["rowNum"];
		}
		return $rowNum;
	}
	
	/**
	 * 获取包括main schedule 详细资料的列表
	 * 
	 * @param MainSchedule $obj        	
	 * @return multitype:MainSchedule
	 */
	function GetMainScheduleListSearch($obj) {
		$query = '';
		if ($obj->mascId != '')
			$query .= " AND MS.mascId = '" . $obj->mascId . "'";
		if ($obj->weekNo != '')
			$query .= " AND MS.weekNo = '" . $obj->weekNo . "'";
		if ($obj->jobNo != '')
			$query .= " AND MS.jobNo = '" . $obj->jobNo . "'";
		if ($obj->jobNoNew != '')
			$query .= " AND MS.jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
		if ($obj->plannedSurveyDate != '')
			$query .= " AND MS.plannedSurveyDate = '" . $obj->plannedSurveyDate . "'";
		if ($obj->tdFileNo != '')
			$query .= " AND MS.tdFileNo = '" . $obj->tdFileNo . "'";
		if ($obj->receivedDate != '')
			$query .= " AND MS.receivedDate = '" . $obj->receivedDate . "'";
		if ($obj->dueDate != '')
			$query .= " AND MS.dueDate = '" . $obj->dueDate . "'";
		if ($obj->fromTD != '')
			$query .= " AND MS.fromTD like '%" . $obj->fromTD . "%'";
		if ($obj->actualSurveyDate != '')
			$query .= " AND MS.actualSurveyDate = '" . $obj->actualSurveyDate . "'";
		if ($obj->startTime_1 != '')
			$query .= " AND MS.startTime_1 = '" . $obj->startTime_1 . "'";
		if ($obj->endTime_1 != '')
			$query .= " AND MS.endTime_1 = '" . $obj->endTime_1 . "'";
		if ($obj->startTime_2 != '')
			$query .= " AND MS.startTime_2 = '" . $obj->startTime_2 . "'";
		if ($obj->endTime_2 != '')
			$query .= " AND MS.endTime_2 = '" . $obj->endTime_2 . "'";
		if ($obj->startTime_3 != '')
			$query .= " AND MS.startTime_3 = '" . $obj->startTime_3 . "'";
		if ($obj->endTime_3 != '')
			$query .= " AND MS.endTime_3 = '" . $obj->endTime_3 . "'";
		if ($obj->startTime_4 != '')
			$query .= " AND MS.startTime_4 = '" . $obj->startTime_4 . "'";
		if ($obj->endTime_4 != '')
			$query .= " AND MS.endTime_4 = '" . $obj->endTime_4 . "'";
		if ($obj->totalHours != '')
			$query .= " AND MS.totalHours = '" . $obj->totalHours . "'";
		if ($obj->surveyTimeHours != '')
			$query .= " AND MS.surveyTimeHours = '" . $obj->surveyTimeHours . "'";
		if ($obj->stCode != '')
			$query .= " AND MS.stCode = '" . $obj->stCode . "'";
		if ($obj->surveyType != '')
			$query .= " AND MS.surveyType = '" . $obj->surveyType . "'";
		if ($obj->vehCode != '')
			$query .= " AND MS.vehCode = '" . $obj->vehCode . "'";
		if ($obj->vehicle != '')
			$query .= " AND MS.vehicle = '" . $obj->vehicle . "'";
		if ($obj->isHoliday != '')
			$query .= " AND MS.isHoliday = '" . $obj->isHoliday . "'";
		if ($obj->bonusHours != '')
			$query .= " AND MS.bonusHours = '" . $obj->bonusHours . "'";
		if ($obj->surveyLocationDistrict != '')
			$query .= " AND MS.surveyLocationDistrict = '" . $obj->surveyLocationDistrict . "'";
		if ($obj->surveyLocation != '')
			$query .= " AND MS.surveyLocation = '" . $obj->surveyLocation . "'";
		if ($obj->routeItems != '')
			$query .= " AND MS.routeItems LIKE '%" . $obj->routeItems . "%'";
		if ($obj->noOfSurveyors != '')
			$query .= " AND MS.noOfSurveyors = '" . $obj->noOfSurveyors . "'";
		if ($obj->estimatedManHour != '')
			$query .= " AND MS.estimatedManHour = '" . $obj->estimatedManHour . "'";
		if ($obj->receiveDate != '')
			$query .= " AND MS.receiveDate = '" . $obj->receiveDate . "'";
		if ($obj->dataInputNo != '')
			$query .= " AND MS.dataInputNo = '" . $obj->dataInputNo . "'";
		if ($obj->dataInputBy != '')
			$query .= " AND MS.dataInputBy = '" . $obj->dataInputBy . "'";
		if ($obj->entryFormTypeNo != '')
			$query .= " AND MS.entryFormTypeNo = '" . $obj->entryFormTypeNo . "'";
		if ($obj->noOfPages != '')
			$query .= " AND MS.noOfPages = '" . $obj->noOfPages . "'";
		if ($obj->report !== NULL)
			$query .= " AND MS.report = '" . $obj->report . "'";
		if ($obj->hourlyRate != '')
			$query .= " AND MS.hourlyRate = '" . $obj->hourlyRate . "'";
		if ($obj->surveyFinding != '')
			$query .= " AND MS.surveyFinding = '" . $obj->surveyFinding . "'";
		if ($obj->am != '')
			$query .= " AND MS.am = '" . $obj->am . "'";
		if ($obj->periodHour_1 != '')
			$query .= " AND MS.periodHour_1 = '" . $obj->periodHour_1 . "'";
		if ($obj->periodWagesHr_1 != '')
			$query .= " AND MS.periodWagesHr_1 = '" . $obj->periodWagesHr_1 . "'";
		if ($obj->periodHour_2 != '')
			$query .= " AND MS.periodHour_2 = '" . $obj->periodHour_2 . "'";
		if ($obj->periodWagesHr_2 != '')
			$query .= " AND MS.periodWagesHr_2 = '" . $obj->periodWagesHr_2 . "'";
		if ($obj->totalWages != '')
			$query .= " AND MS.totalWages = '" . $obj->totalWages . "'";
		if ($obj->onBoardCostFare != '')
			$query .= " AND MS.onBoardCostFare = '" . $obj->onBoardCostFare . "'";
		if ($obj->noOfTrips != '')
			$query .= " AND MS.noOfTrips = '" . $obj->noOfTrips . "'";
		if ($obj->transportAllowanceAm != '')
			$query .= " AND MS.transportAllowanceAm = '" . $obj->transportAllowanceAm . "'";
		if ($obj->transportAllowanceNoon != '')
			$query .= " AND MS.transportAllowanceNoon = '" . $obj->transportAllowanceNoon . "'";
		if ($obj->transportAllowancePm != '')
			$query .= " AND MS.transportAllowancePm = '" . $obj->transportAllowancePm . "'";
		if ($obj->transportAllowanceOvernight != '')
			$query .= " AND MS.transportAllowanceOvernight = '" . $obj->transportAllowanceOvernight . "'";
		if ($obj->taTotal != '')
			$query .= " AND MS.taTotal = '" . $obj->taTotal . "'";
		if ($obj->wagesTaOnBoard != '')
			$query .= " AND MS.wagesTaOnBoard = '" . $obj->wagesTaOnBoard . "'";
		if ($obj->onBoardTranportAllowanceTotal != '')
			$query .= " AND MS.onBoardTranportAllowanceTotal = '" . $obj->onBoardTranportAllowanceTotal . "'";
		if ($obj->surveyorCode != '')
			$query .= " AND MS.surveyorCode = '" . $obj->surveyorCode . "'";
		if ($obj->surveyorName != '')
			$query .= " AND MS.surveyorName = '" . $obj->surveyorName . "'";
		if ($obj->surveyorTelephone != '')
			$query .= " AND MS.surveyorTelephone = '" . $obj->surveyorTelephone . "'";
		if ($obj->complateJobNo != '')
			$query .= " AND MS.complateJobNo = '" . $obj->complateJobNo . "'";
		if ($obj->distributedToLeader != '')
			$query .= " AND MS.distributedToLeader = '" . $obj->distributedToLeader . "'";
		if ($obj->reportWeek != '')
			$query .= " AND MS.reportWeek = '" . $obj->reportWeek . "'";
		if ($obj->direction != '')
			$query .= " AND MS.direction = '" . $obj->direction . "'";
		if ($obj->noPlannedSurveyDate) {
			if ($obj->plannedSurveyDateStart != '' && $obj->plannedSurveyDateEnd != '') {
				$query .= " AND ((plannedSurveyDate >= '{$obj->plannedSurveyDateStart}' 
					AND plannedSurveyDate < '{$obj->plannedSurveyDateEnd}') 
					OR plannedSurveyDate >= '')";
			} else if ($obj->plannedSurveyDateStart != '') {
				$query .= " AND (plannedSurveyDate >= '{$obj->plannedSurveyDateStart}' 
					OR plannedSurveyDate >= '')";
			}
		} else {
			if ($obj->plannedSurveyDateStart != '')
				$query .= " AND plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
			if ($obj->plannedSurveyDateEnd != '')
				$query .= " AND plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
		}
		if ($obj->doDistrict != "") {
			$tempDoDist = explode ( ",", $obj->doDistrict );
			$query .= " AND (1=2 ";
			for($i = 1; $i < count ( $tempDoDist ); $i ++) {
				$query .= " OR MS.jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
			}
			$query .= ")";
		}
		if ($obj->isAssigned === false) {
			$query .= " AND MS.surveyorCode = ''";
		} else if ($obj->isAssigned === true) {
			$query .= " AND MS.surveyorCode <> ''";
		}
		if ($this->order != '')
			$query .= $this->order;
		if ($this->pageLimit != '')
			$query .= $this->pageLimit;
		
		$sql = "SELECT MS.*
				,RF.fileName as rawFile
				,MSC.mscId,MSC.company FROM Survey_MainScheduleContractor MSC" . " INNER JOIN Survey_MainSchedule MS ON MSC.delFlag='no' AND MSC.jobNoNew=MS.jobNoNew" . " LEFT JOIN Survey_MainScheduleRawFile RF ON RF.jobNoNew=MS.jobNoNew" . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// echo "{$sql}<br>";
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new MainSchedule ();
			$obj->mascId = $rs ["mascId"];
			$obj->weekNo = $rs ["weekNo"];
			$obj->jobNo = $rs ["jobNo"];
			$obj->jobNoNew = $rs ["jobNoNew"];
			$obj->plannedSurveyDate = $rs ["plannedSurveyDate"];
			$obj->tdFileNo = $rs ["tdFileNo"];
			$obj->receivedDate = $rs ["receivedDate"];
			$obj->dueDate = $rs ["dueDate"];
			$obj->fromTD = $rs ["fromTD"];
			$obj->actualSurveyDate = $rs ["actualSurveyDate"];
			$obj->startTime_1 = $rs ["startTime_1"];
			$obj->endTime_1 = $rs ["endTime_1"];
			$obj->startTime_2 = $rs ["startTime_2"];
			$obj->endTime_2 = $rs ["endTime_2"];
			$obj->startTime_3 = $rs ["startTime_3"];
			$obj->endTime_3 = $rs ["endTime_3"];
			$obj->startTime_4 = $rs ["startTime_4"];
			$obj->endTime_4 = $rs ["endTime_4"];
			$obj->totalHours = $rs ["totalHours"];
			$obj->surveyTimeHours = $rs ["surveyTimeHours"];
			$obj->stCode = $rs ["stCode"];
			$obj->surveyType = $rs ["surveyType"];
			$obj->vehCode = $rs ["vehCode"];
			$obj->vehicle = $rs ["vehicle"];
			$obj->isHoliday = $rs ["isHoliday"];
			$obj->bonusHours = $rs ["bonusHours"];
			$obj->surveyLocationDistrict = $rs ["surveyLocationDistrict"];
			$obj->surveyLocation = $rs ["surveyLocation"];
			$obj->routeItems = $rs ["routeItems"];
			$obj->noOfSurveyors = $rs ["noOfSurveyors"];
			$obj->estimatedManHour = $rs ["estimatedManHour"];
			$obj->receiveDate = $rs ["receiveDate"];
			$obj->dataInputNo = $rs ["dataInputNo"];
			$obj->dataInputBy = $rs ["dataInputBy"];
			$obj->entryFormTypeNo = $rs ["entryFormTypeNo"];
			$obj->noOfPages = $rs ["noOfPages"];
			$obj->report = $rs ["report"];
			$obj->hourlyRate = $rs ["hourlyRate"];
			$obj->surveyFinding = $rs ["surveyFinding"];
			$obj->am = $rs ["am"];
			$obj->periodHour_1 = $rs ["periodHour_1"];
			$obj->periodWagesHr_1 = $rs ["periodWagesHr_1"];
			$obj->periodHour_2 = $rs ["periodHour_2"];
			$obj->periodWagesHr_2 = $rs ["periodWagesHr_2"];
			$obj->totalWages = $rs ["totalWages"];
			$obj->onBoardCostFare = $rs ["onBoardCostFare"];
			$obj->noOfTrips = $rs ["noOfTrips"];
			$obj->transportAllowanceAm = $rs ["transportAllowanceAm"];
			$obj->transportAllowanceNoon = $rs ["transportAllowanceNoon"];
			$obj->transportAllowancePm = $rs ["transportAllowancePm"];
			$obj->transportAllowanceOvernight = $rs ["transportAllowanceOvernight"];
			$obj->taTotal = $rs ["taTotal"];
			$obj->wagesTaOnBoard = $rs ["wagesTaOnBoard"];
			$obj->onBoardTranportAllowanceTotal = $rs ["onBoardTranportAllowanceTotal"];
			$obj->surveyorCode = $rs ["surveyorCode"];
			$obj->surveyorName = $rs ["surveyorName"];
			$obj->surveyorTelephone = $rs ["surveyorTelephone"];
			$obj->complateJobNo = $rs ["complateJobNo"];
			$obj->distributedToLeader = $rs ["distributedToLeader"];
			$obj->reportWeek = $rs ["reportWeek"];
			$obj->surveyLocationCn = $rs ["surveyLocationCn"];
			$obj->direction = $rs ["direction"];
			$obj->rawFile = $rs ["rawFile"];
			$obj->mscId = $rs ["mscId"];
			$obj->company = $rs ["company"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>