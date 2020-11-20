<?php
/*
 * Header: 
 * Create: 2015-11-24
 * Auther: James Wu<jamblues@gmail.com>.
 */
class MainScheduleOpenAccess
{
	var $db;

	function MainScheduleOpenAccess($db)
	{
		$this->db = $db;
	}

	/*
	 * 根據jobNo判斷該課堂是否開放
	 * */
	function isOpenJob($jobNo){

	    $sql = "SELECT jobNoNew FROM Survey_MainScheduleOpen WHERE delFlag = 'no' and jobNoNew LIKE '{$jobNo}%' LIMIT 1";
        $this->db->query ( $sql );
        if($rs = $this->db->next_record ()){
            return true;
        }
        return false;

    }

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_MainScheduleOpen(jobNoNew,batchNumber,applySurvId,applyTime
				,auditUserId,auditTime,delFlag,inputUserId,inputTime,modifyUserId,modifyTime)".
			" VALUES('".$obj->jobNoNew."'".
			",'".$obj->batchNumber."'".
			",'".$obj->applySurvId."'".
			",'".$obj->applyTime."'".
			",'".$obj->auditUserId."'".
			",'".$obj->auditTime."'".
			",'".$obj->delFlag."'".
			",'".$obj->inputUserId."'".
			",'".$obj->inputTime."'".
			",'".$obj->modifyUserId."'".
			",'".$obj->modifyTime."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_MainScheduleOpen ".
			" SET jobNoNew = '".$obj->jobNoNew."'".
			" ,batchNumber = '".$obj->batchNumber."'".
			" ,applySurvId = '".$obj->applySurvId."'".
			" ,applyTime = '".$obj->applyTime."'".
			" ,auditUserId = '".$obj->auditUserId."'".
			" ,auditTime = '".$obj->auditTime."'".
			" ,delFlag = '".$obj->delFlag."'".
			" ,inputUserId = '".$obj->inputUserId."'".
			" ,inputTime = '".$obj->inputTime."'".
			" ,modifyUserId = '".$obj->modifyUserId."'".
			" ,modifyTime = '".$obj->modifyTime."'".
			" WHERE 1=1  AND msoId = '".$obj->msoId."'";
		$this->db->query($sql);
	}

	/**
	 * 申請工作
	 * @param $obj MainScheduleOpen
	 */
	function Apply($obj){
		$sql = "UPDATE Survey_MainScheduleOpen ".
				" SET applySurvId = '".$obj->applySurvId."'".
				" ,applyTime = '".$obj->applyTime."'".
				" WHERE 1=1 AND delFlag='no' AND applySurvId=0 AND jobNoNew = '".$obj->jobNoNew."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_MainScheduleOpen ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND msoId = '".$obj->msoId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_MainScheduleOpen ".
			" WHERE 1=1  AND msoId = '".$obj->msoId."'";
		$this->db->query($sql);
	}

    function RealDelbyJobNoNew2($obj)
    {
        $sql = "DELETE FROM Survey_MainScheduleOpen ".
            " WHERE 1=1  AND jobNoNew = '".$obj->jobNoNew."'";
        $this->db->query($sql);
    }
    function RealDelbyJobNoNew($jobNo){
        if(empty($jobNo))
            return false;
        /*$sql = "DELETE FROM {$conf['table']['prefix']}MainSchedule WHERE jobNo LIKE '{$jobNo}%'";
        $this->db->query($sql);*/
        $sql = "DELETE FROM Survey_SurveyPart ".
            " WHERE 1=1  AND refNo LIKE '{$jobNo}%'";
        $this->db->query($sql);
        $sql = "DELETE FROM Survey_MainScheduleOpen ".
            " WHERE 1=1  AND jobNoNew LIKE '{$jobNo}%'";
        $this->db->query($sql);
        //file_put_contents('/tmp/add1019.log', '`````````````````````````'."\n".$sql. "\n\r", FILE_APPEND);
        $sql = "DELETE FROM Survey_SurveyorMainSchedule ".
            " WHERE 1=1  AND jobNoNew LIKE '{$jobNo}%'";
        $this->db->query($sql);
        /*$sql = "DELETE FROM Survey_SurveyJobOpen ".
            " WHERE 1=1  AND jobNo LIKE '{$jobNo}'";
        $this->db->query($sql);*/
    }

	function GetListSearch($obj)
	{
		$query = '';
		if($obj->msoId != '')
			$query .= " AND msoId = '".$obj->msoId."'";
		if($obj->jobNoNew != '')
			$query .= " AND jobNoNew = '".$obj->jobNoNew."'";
		if($obj->batchNumber != '')
			$query .= " AND batchNumber = '".$obj->batchNumber."'";
		if($obj->applySurvId != '')
			$query .= " AND applySurvId = '".$obj->applySurvId."'";
		if($obj->applyTime != '')
			$query .= " AND applyTime = '".$obj->applyTime."'";
		if($obj->auditUserId != '')
			$query .= " AND auditUserId = '".$obj->auditUserId."'";
		if($obj->auditTime != '')
			$query .= " AND auditTime = '".$obj->auditTime."'";
		if($obj->delFlag != '')
			$query .= " AND delFlag = '".$obj->delFlag."'";
		if($obj->inputUserId != '')
			$query .= " AND inputUserId = '".$obj->inputUserId."'";
		if($obj->inputTime != '')
			$query .= " AND inputTime = '".$obj->inputTime."'";
		if($obj->modifyUserId != '')
			$query .= " AND modifyUserId = '".$obj->modifyUserId."'";
		if($obj->modifyTime != '')
			$query .= " AND modifyTime = '".$obj->modifyTime."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_MainScheduleOpen ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
//		echo $sql;
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new MainScheduleOpen();
			$obj->msoId = $rs["msoId"];
			$obj->jobNoNew = $rs["jobNoNew"];
			$obj->batchNumber = $rs["batchNumber"];
			$obj->applySurvId = $rs["applySurvId"];
			$obj->applyTime = $rs["applyTime"];
			$obj->auditUserId = $rs["auditUserId"];
			$obj->auditTime = $rs["auditTime"];
			$obj->delFlag = $rs["delFlag"];
			$obj->inputUserId = $rs["inputUserId"];
			$obj->inputTime = $rs["inputTime"];
			$obj->modifyUserId = $rs["modifyUserId"];
			$obj->modifyTime = $rs["modifyTime"];
			$rows[] = $obj;
		}
		return $rows;
	}

	function GetOpenJobNoNews($jobNoNews) {
		$query = '';
		if (empty ( $jobNoNews )) {
			return array ();
		}
		$query .= " AND JobNoNew IN ({$jobNoNews})";

		$sql = "SELECT mso.*,s.engName,s.chiName,s.contact,s.profilePhoto,s.survId FROM Survey_MainScheduleOpen mso
				LEFT JOIN Survey_Surveyor s ON s.survId = mso.applySurvId
				WHERE 1=1 AND mso.delFlag='no'";
		$sql = $sql . $query;
// 		echo $sql;
		$this->db->query($sql);
		$jobNoNews = array();
		$survIds = array();
		while ($rs = $this->db->next_record()) {
			$survIds[] = $rs['applySurvId'];
			$jobNoNews[$rs['jobNoNew']]['applySurvId'] = $rs['applySurvId'];
			$jobNoNews[$rs['jobNoNew']]['applyEngName'] = $rs['engName'];
			$jobNoNews[$rs['jobNoNew']]['applyChiName'] = $rs['chiName'];
			$jobNoNews[$rs['jobNoNew']]['applyContact'] = $rs['contact'];
			$jobNoNews[$rs['jobNoNew']]['applyTime'] = $rs['applyTime'];
			if(!empty($rs['profilePhoto'])){
                $jobNoNews[$rs['jobNoNew']]['applyProfilePhoto'] = 'http://'.$_SERVER['SERVER_NAME'].'/'.PROJECTNAME.$rs['profilePhoto'];
            }
		}
		return $jobNoNews;
	}

	function GetListSearchOpening($obj,$type='opening',$applySurvId=null)
	{
		$query = '';
		if ($obj->mascId != '')
			$query .= " AND mascId = '" . $obj->mascId . "'";
		if ($obj->weekNo != '')
			$query .= " AND weekNo = '" . $obj->weekNo . "'";
		if ($obj->jobNo != '')
			$query .= " AND jobNo LIKE '" . $obj->jobNo . "%'";
		if ($obj->jobNoNew != '')
			$query .= " AND jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
		if ($obj->plannedSurveyDate != '')
			$query .= " AND plannedSurveyDate = '" . $obj->plannedSurveyDate . "'";
		if ($obj->tdFileNo != '')
			$query .= " AND tdFileNo = '" . $obj->tdFileNo . "'";
		if ($obj->receivedDate != '')
			$query .= " AND receivedDate = '" . $obj->receivedDate . "'";
		if ($obj->dueDate != '')
			$query .= " AND dueDate = '" . $obj->dueDate . "'";
		if ($obj->dueDateStart != '')
			$query .= " AND dueDate >= '" . $obj->dueDateStart . "'";
		if ($obj->dueDateEnd != '')
			$query .= " AND dueDate < '" . $obj->dueDateEnd . "'";
		if ($obj->fromTD != '')
			$query .= " AND fromTD = '" . $obj->fromTD . "'";
		if ($obj->actualSurveyDate != '')
			$query .= " AND actualSurveyDate = '" . $obj->actualSurveyDate . "'";
		if ($obj->startTime_1 != '')
			$query .= " AND startTime_1 = '" . $obj->startTime_1 . "'";
		if ($obj->endTime_1 != '')
			$query .= " AND endTime_1 = '" . $obj->endTime_1 . "'";
		if ($obj->startTime_2 != '')
			$query .= " AND startTime_2 = '" . $obj->startTime_2 . "'";
		if ($obj->endTime_2 != '')
			$query .= " AND endTime_2 = '" . $obj->endTime_2 . "'";
		if ($obj->startTime_3 != '')
			$query .= " AND startTime_3 = '" . $obj->startTime_3 . "'";
		if ($obj->endTime_3 != '')
			$query .= " AND endTime_3 = '" . $obj->endTime_3 . "'";
		if ($obj->startTime_4 != '')
			$query .= " AND startTime_4 = '" . $obj->startTime_4 . "'";
		if ($obj->endTime_4 != '')
			$query .= " AND endTime_4 = '" . $obj->endTime_4 . "'";
		if ($obj->totalHours != '')
			$query .= " AND totalHours = '" . $obj->totalHours . "'";
		if ($obj->surveyTimeHours != '')
			$query .= " AND surveyTimeHours = '" . $obj->surveyTimeHours . "'";
		if ($obj->stCode != '')
			$query .= " AND stCode = '" . $obj->stCode . "'";
		if ($obj->surveyType != '')
			$query .= " AND surveyType = '" . $obj->surveyType . "'";
		if ($obj->vehCode != '')
			$query .= " AND vehCode = '" . $obj->vehCode . "'";
		if ($obj->vehicle != '')
			$query .= " AND vehicle = '" . $obj->vehicle . "'";
		if ($obj->isHoliday != '')
			$query .= " AND isHoliday = '" . $obj->isHoliday . "'";
		if ($obj->bonusHours != '')
			$query .= " AND bonusHours = '" . $obj->bonusHours . "'";
		if ($obj->surveyLocationDistrict != '')
			$query .= " AND surveyLocationDistrict = '" . $obj->surveyLocationDistrict . "'";
		if ($obj->surveyLocation != '')
			$query .= " AND surveyLocation = '" . $obj->surveyLocation . "'";
		if ($obj->routeItems != '')
			$query .= " AND routeItems LIKE '%" . $obj->routeItems . "%'";
		if ($obj->noOfSurveyors != '')
			$query .= " AND noOfSurveyors = '" . $obj->noOfSurveyors . "'";
		if ($obj->estimatedManHour != '')
			$query .= " AND estimatedManHour = '" . $obj->estimatedManHour . "'";
		if ($obj->receiveDate != '')
			$query .= " AND receiveDate = '" . $obj->receiveDate . "'";
		if ($obj->dataInputNo != '')
			$query .= " AND dataInputNo = '" . $obj->dataInputNo . "'";
		if ($obj->dataInputBy != '')
			$query .= " AND dataInputBy = '" . $obj->dataInputBy . "'";
		if ($obj->entryFormTypeNo != '')
			$query .= " AND entryFormTypeNo = '" . $obj->entryFormTypeNo . "'";
		if ($obj->noOfPages != '')
			$query .= " AND noOfPages = '" . $obj->noOfPages . "'";
		if ($obj->report !== NULL)
			$query .= " AND report = '" . $obj->report . "'";
		if ($obj->hourlyRate != '')
			$query .= " AND hourlyRate = '" . $obj->hourlyRate . "'";
		if ($obj->surveyFinding != '')
			$query .= " AND surveyFinding = '" . $obj->surveyFinding . "'";
		if ($obj->am != '')
			$query .= " AND am = '" . $obj->am . "'";
		if ($obj->periodHour_1 != '')
			$query .= " AND periodHour_1 = '" . $obj->periodHour_1 . "'";
		if ($obj->periodWagesHr_1 != '')
			$query .= " AND periodWagesHr_1 = '" . $obj->periodWagesHr_1 . "'";
		if ($obj->periodHour_2 != '')
			$query .= " AND periodHour_2 = '" . $obj->periodHour_2 . "'";
		if ($obj->periodWagesHr_2 != '')
			$query .= " AND periodWagesHr_2 = '" . $obj->periodWagesHr_2 . "'";
		if ($obj->totalWages != '')
			$query .= " AND totalWages = '" . $obj->totalWages . "'";
		if ($obj->onBoardCostFare != '')
			$query .= " AND onBoardCostFare = '" . $obj->onBoardCostFare . "'";
		if ($obj->noOfTrips != '')
			$query .= " AND noOfTrips = '" . $obj->noOfTrips . "'";
		if ($obj->transportAllowanceAm != '')
			$query .= " AND transportAllowanceAm = '" . $obj->transportAllowanceAm . "'";
		if ($obj->transportAllowanceNoon != '')
			$query .= " AND transportAllowanceNoon = '" . $obj->transportAllowanceNoon . "'";
		if ($obj->transportAllowancePm != '')
			$query .= " AND transportAllowancePm = '" . $obj->transportAllowancePm . "'";
		if ($obj->transportAllowanceOvernight != '')
			$query .= " AND transportAllowanceOvernight = '" . $obj->transportAllowanceOvernight . "'";
		if ($obj->taTotal != '')
			$query .= " AND taTotal = '" . $obj->taTotal . "'";
		if ($obj->wagesTaOnBoard != '')
			$query .= " AND wagesTaOnBoard = '" . $obj->wagesTaOnBoard . "'";
		if ($obj->onBoardTranportAllowanceTotal != '')
			$query .= " AND onBoardTranportAllowanceTotal = '" . $obj->onBoardTranportAllowanceTotal . "'";
		if ($obj->surveyorCode != '')
			$query .= " AND surveyorCode = '" . $obj->surveyorCode . "'";
		if ($obj->surveyorName != '')
			$query .= " AND surveyorName = '" . $obj->surveyorName . "'";
		if ($obj->surveyorTelephone != '')
			$query .= " AND surveyorTelephone = '" . $obj->surveyorTelephone . "'";
		if ($obj->complateJobNo != '')
			$query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
		if ($obj->distributedToLeader != '')
			$query .= " AND distributedToLeader = '" . $obj->distributedToLeader . "'";
		if ($obj->reportWeek != '')
			$query .= " AND reportWeek = '" . $obj->reportWeek . "'";
		if ($obj->direction != '')
			$query .= " AND direction = '" . $obj->direction . "'";
		if ($obj->plannedSurveyDateStart != '')
			$query .= " AND plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
		if ($obj->plannedSurveyDateEnd != '')
			$query .= " AND plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
		if ($obj->doDistrict != "") {
			$tempDoDist = explode(",", $obj->doDistrict);
			$query .= " AND (1=2 ";
			for ($i = 1; $i < count($tempDoDist); $i++) {
				$query .= " OR jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
			}
			$query .= ")";
		}
		$query .= " AND jobNoNew NOT LIKE '%ss' AND jobNoNew NOT LIKE '%tt' AND jobNoNew NOT LIKE '%uu'"; // 去掉end with ss
		if($type=='opening'){
			$query .= " AND jobNoNew IN (SELECT jobNoNew FROM Survey_MainScheduleOpen WHERE delFlag='no' AND applySurvId=0)";
		}elseif($type=='applied'){
			$query .= " AND jobNoNew IN (SELECT jobNoNew FROM Survey_MainScheduleOpen WHERE delFlag='no' AND applySurvId={$applySurvId})";
		}
		if ($this->order != '')
			$query .= $this->order;

		$sql = "SELECT jobNo,jobNoNew,plannedSurveyDate,startTime_1,endTime_1,surveyType,vehicle,surveyLocation FROM Survey_MainSchedule " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query($sql);
//		 echo $sql."<br />";
		$rows = array();
		while ($rs = $this->db->next_record()) {
			$obj = new MainSchedule ();
			$obj->mascId = $rs ["mascId"];
			$obj->weekNo = $rs ["weekNo"];
			$obj->jobNoShort = $rs ["jobNoShort"];
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
            $obj->bookLong = $rs ["bookLong"];
            $obj->bookLat = $rs ["bookLat"];
            $obj->map_address = $rs ["map_address"];
            $obj->diy_name = $rs ["diy_name"];
            $obj->diy_value = $rs ["diy_value"];
			$rows[] = $obj;
		}
		return $rows;
	}

    function GetListSearchOpening2($obj,$type='opening',$applySurvId=null,$is_image = false)
    {
        $query = '';
        if($is_image == true){
            $query .= " AND is_image = 1";
        }else{
            $query .= " AND is_image = 0";
        }
        if ($obj->mascId != '')
            $query .= " AND mascId = '" . $obj->mascId . "'";
        if ($obj->weekNo != '')
            $query .= " AND weekNo = '" . $obj->weekNo . "'";
        if ($obj->jobNo != '')
            $query .= " AND jobNo LIKE '" . $obj->jobNo . "%'";
        if ($obj->jobNoNew != '')
            $query .= " AND jobNoNew LIKE '%" . $obj->jobNoNew . "%'";

        if ($obj->plannedSurveyDate != '')
            $query .= " AND (plannedSurveyDate = '" . $obj->plannedSurveyDate . "' or plannedSurveyDate = '0000-00-00')";
        if ($obj->tdFileNo != '')
            $query .= " AND tdFileNo = '" . $obj->tdFileNo . "'";
        if ($obj->receivedDate != '')
            $query .= " AND receivedDate = '" . $obj->receivedDate . "'";
        if ($obj->dueDate != '')
            $query .= " AND dueDate = '" . $obj->dueDate . "'";
        if ($obj->dueDateStart != '')
            $query .= " AND dueDate >= '" . $obj->dueDateStart . "'";
        if ($obj->dueDateEnd != '')
            $query .= " AND dueDate < '" . $obj->dueDateEnd . "'";
        if ($obj->fromTD != '')
            $query .= " AND fromTD = '" . $obj->fromTD . "'";
        if ($obj->actualSurveyDate != '')
            $query .= " AND actualSurveyDate = '" . $obj->actualSurveyDate . "'";
        if ($obj->startTime_1 != '')
            $query .= " AND startTime_1 = '" . $obj->startTime_1 . "'";
        if ($obj->endTime_1 != '')
            $query .= " AND endTime_1 = '" . $obj->endTime_1 . "'";
        if ($obj->startTime_2 != '')
            $query .= " AND startTime_2 = '" . $obj->startTime_2 . "'";
        if ($obj->endTime_2 != '')
            $query .= " AND endTime_2 = '" . $obj->endTime_2 . "'";
        if ($obj->startTime_3 != '')
            $query .= " AND startTime_3 = '" . $obj->startTime_3 . "'";
        if ($obj->endTime_3 != '')
            $query .= " AND endTime_3 = '" . $obj->endTime_3 . "'";
        if ($obj->startTime_4 != '')
            $query .= " AND startTime_4 = '" . $obj->startTime_4 . "'";
        if ($obj->endTime_4 != '')
            $query .= " AND endTime_4 = '" . $obj->endTime_4 . "'";
        if ($obj->totalHours != '')
            $query .= " AND totalHours = '" . $obj->totalHours . "'";
        if ($obj->surveyTimeHours != '')
            $query .= " AND surveyTimeHours = '" . $obj->surveyTimeHours . "'";
        if ($obj->stCode != '')
            $query .= " AND stCode = '" . $obj->stCode . "'";
        if ($obj->surveyType != '')
            $query .= " AND surveyType = '" . $obj->surveyType . "'";
        if ($obj->vehCode != '')
            $query .= " AND vehCode = '" . $obj->vehCode . "'";
        if ($obj->vehicle != '')
            $query .= " AND vehicle = '" . $obj->vehicle . "'";
        if ($obj->isHoliday != '')
            $query .= " AND isHoliday = '" . $obj->isHoliday . "'";
        if ($obj->bonusHours != '')
            $query .= " AND bonusHours = '" . $obj->bonusHours . "'";
        if ($obj->surveyLocationDistrict != '')
            $query .= " AND surveyLocationDistrict = '" . $obj->surveyLocationDistrict . "'";
        if ($obj->surveyLocation != '')
            $query .= " AND surveyLocation = '" . $obj->surveyLocation . "'";
        if ($obj->routeItems != '')
            $query .= " AND routeItems LIKE '%" . $obj->routeItems . "%'";
        if ($obj->noOfSurveyors != '')
            $query .= " AND noOfSurveyors = '" . $obj->noOfSurveyors . "'";
        if ($obj->estimatedManHour != '')
            $query .= " AND estimatedManHour = '" . $obj->estimatedManHour . "'";
        if ($obj->receiveDate != '')
            $query .= " AND receiveDate = '" . $obj->receiveDate . "'";
        if ($obj->dataInputNo != '')
            $query .= " AND dataInputNo = '" . $obj->dataInputNo . "'";
        if ($obj->dataInputBy != '')
            $query .= " AND dataInputBy = '" . $obj->dataInputBy . "'";
        if ($obj->entryFormTypeNo != '')
            $query .= " AND entryFormTypeNo = '" . $obj->entryFormTypeNo . "'";
        if ($obj->noOfPages != '')
            $query .= " AND noOfPages = '" . $obj->noOfPages . "'";
        if ($obj->report !== NULL)
            $query .= " AND report = '" . $obj->report . "'";
        if ($obj->hourlyRate != '')
            $query .= " AND hourlyRate = '" . $obj->hourlyRate . "'";
        if ($obj->surveyFinding != '')
            $query .= " AND surveyFinding = '" . $obj->surveyFinding . "'";
        if ($obj->am != '')
            $query .= " AND am = '" . $obj->am . "'";
        if ($obj->periodHour_1 != '')
            $query .= " AND periodHour_1 = '" . $obj->periodHour_1 . "'";
        if ($obj->periodWagesHr_1 != '')
            $query .= " AND periodWagesHr_1 = '" . $obj->periodWagesHr_1 . "'";
        if ($obj->periodHour_2 != '')
            $query .= " AND periodHour_2 = '" . $obj->periodHour_2 . "'";
        if ($obj->periodWagesHr_2 != '')
            $query .= " AND periodWagesHr_2 = '" . $obj->periodWagesHr_2 . "'";
        if ($obj->totalWages != '')
            $query .= " AND totalWages = '" . $obj->totalWages . "'";
        if ($obj->onBoardCostFare != '')
            $query .= " AND onBoardCostFare = '" . $obj->onBoardCostFare . "'";
        if ($obj->noOfTrips != '')
            $query .= " AND noOfTrips = '" . $obj->noOfTrips . "'";
        if ($obj->transportAllowanceAm != '')
            $query .= " AND transportAllowanceAm = '" . $obj->transportAllowanceAm . "'";
        if ($obj->transportAllowanceNoon != '')
            $query .= " AND transportAllowanceNoon = '" . $obj->transportAllowanceNoon . "'";
        if ($obj->transportAllowancePm != '')
            $query .= " AND transportAllowancePm = '" . $obj->transportAllowancePm . "'";
        if ($obj->transportAllowanceOvernight != '')
            $query .= " AND transportAllowanceOvernight = '" . $obj->transportAllowanceOvernight . "'";
        if ($obj->taTotal != '')
            $query .= " AND taTotal = '" . $obj->taTotal . "'";
        if ($obj->wagesTaOnBoard != '')
            $query .= " AND wagesTaOnBoard = '" . $obj->wagesTaOnBoard . "'";
        if ($obj->onBoardTranportAllowanceTotal != '')
            $query .= " AND onBoardTranportAllowanceTotal = '" . $obj->onBoardTranportAllowanceTotal . "'";
        if ($obj->surveyorCode != '')
            $query .= " AND surveyorCode = '" . $obj->surveyorCode . "'";
        if ($obj->surveyorName != '')
            $query .= " AND surveyorName = '" . $obj->surveyorName . "'";
        if ($obj->surveyorTelephone != '')
            $query .= " AND surveyorTelephone = '" . $obj->surveyorTelephone . "'";
        if ($obj->complateJobNo != '')
            $query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
        if ($obj->distributedToLeader != '')
            $query .= " AND distributedToLeader = '" . $obj->distributedToLeader . "'";
        if ($obj->reportWeek != '')
            $query .= " AND reportWeek = '" . $obj->reportWeek . "'";
        if ($obj->direction != '')
            $query .= " AND direction = '" . $obj->direction . "'";
        if ($obj->plannedSurveyDateStart != '')
            $query .= " AND (plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "' or plannedSurveyDate = '0000-00-00')";
        if ($obj->plannedSurveyDateEnd != '')
            $query .= " AND plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
        if ($obj->doDistrict != "") {
            $tempDoDist = explode(",", $obj->doDistrict);
            $query .= " AND (1=2 ";
            for ($i = 1; $i < count($tempDoDist); $i++) {
                $query .= " OR jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
            }
            $query .= ")";
        }
        $query .= " AND jobNoNew NOT LIKE '%ss' AND jobNoNew NOT LIKE '%tt' AND jobNoNew NOT LIKE '%uu'"; // 去掉end with ss
        if($type=='opening'){
            $query .= " AND jobNoNew IN (SELECT jobNoNew FROM Survey_MainScheduleOpen WHERE delFlag='no' AND applySurvId=0)";
        }elseif($type=='applied'){
            $query .= " AND jobNoNew IN (SELECT jobNoNew FROM Survey_MainScheduleOpen WHERE delFlag='no' AND applySurvId={$applySurvId})";
        }
        if ($this->order != '')
            $query .= $this->order;

        $sql = "SELECT jobNo,img_url,jobNoNew,surveyTimeHours,plannedSurveyDate,startTime_1,endTime_1,surveyType,vehicle,surveyLocation,diy_name,diy_value,surveyorCode FROM Survey_MainSchedule " . " WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        $rows = array();
        while ($rs = $this->db->next_record()) {
            if($type == 'opening'){
                if(empty($rs["surveyorCode"])){
                    $obj = new MainSchedule ();
                    $obj->jobNo = $rs["jobNo"];
                    $obj->jobNoNew = $rs["jobNoNew"];
                    $obj->plannedSurveyDate = $rs["plannedSurveyDate"];
                    $obj->startTime_1 = $rs["startTime_1"];
                    $obj->endTime_1 = $rs["endTime_1"];
                    $obj->surveyTimeHours = $rs["surveyTimeHours"];
                    $obj->surveyType = $rs["surveyType"];
                    $obj->vehicle = $rs["vehicle"];
                    $obj->surveyLocation = $rs["surveyLocation"];
                    $obj->surveyorCode = $rs["surveyorCode"];
                    $obj->surveyorName = $rs["surveyorName"];
                    $obj->surveyorTelephone = $rs["surveyorTelephone"];
                    $obj->complateJobNo = $rs["complateJobNo"];
                    $obj->diy_name = $rs["diy_name"];
                    $obj->diy_value = $rs["diy_value"];
                    $obj->surveyTimeHours = $rs["surveyTimeHours"];

                    $rows[] = $obj;
                }
            }else{
                $obj = new MainSchedule ();
                $obj->jobNo = $rs["jobNo"];
                $obj->jobNoNew = $rs["jobNoNew"];
                $obj->plannedSurveyDate = $rs["plannedSurveyDate"];
                $obj->startTime_1 = $rs["startTime_1"];
                $obj->endTime_1 = $rs["endTime_1"];
                $obj->surveyTimeHours = $rs["surveyTimeHours"];
                $obj->surveyType = $rs["surveyType"];
                $obj->vehicle = $rs["vehicle"];
                $obj->surveyLocation = $rs["surveyLocation"];
                $obj->surveyorCode = $rs["surveyorCode"];
                $obj->surveyorName = $rs["surveyorName"];
                $obj->surveyorTelephone = $rs["surveyorTelephone"];
                $obj->complateJobNo = $rs["complateJobNo"];
                $obj->diy_name = $rs["diy_name"];
                $obj->diy_value = $rs["diy_value"];
                $obj->surveyTimeHours = $rs["surveyTimeHours"];
                $rows[] = $obj;
            }
        }
        return $rows;
    }

	function GetListSearchOpeningDistrict($obj,$type='opening',$applySurvId=null)
	{
		$query = '';
		if ($obj->mascId != '')
			$query .= " AND mascId = '" . $obj->mascId . "'";
		if ($obj->weekNo != '')
			$query .= " AND weekNo = '" . $obj->weekNo . "'";
		if ($obj->jobNo != '')
			$query .= " AND jobNo LIKE '" . $obj->jobNo . "%'";
		if ($obj->jobNoNew != '')
			$query .= " AND jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
		if ($obj->plannedSurveyDate != '')
			$query .= " AND plannedSurveyDate = '" . $obj->plannedSurveyDate . "'";
		if ($obj->tdFileNo != '')
			$query .= " AND tdFileNo = '" . $obj->tdFileNo . "'";
		if ($obj->receivedDate != '')
			$query .= " AND receivedDate = '" . $obj->receivedDate . "'";
		if ($obj->dueDate != '')
			$query .= " AND dueDate = '" . $obj->dueDate . "'";
		if ($obj->dueDateStart != '')
			$query .= " AND dueDate >= '" . $obj->dueDateStart . "'";
		if ($obj->dueDateEnd != '')
			$query .= " AND dueDate < '" . $obj->dueDateEnd . "'";
		if ($obj->fromTD != '')
			$query .= " AND fromTD = '" . $obj->fromTD . "'";
		if ($obj->actualSurveyDate != '')
			$query .= " AND actualSurveyDate = '" . $obj->actualSurveyDate . "'";
		if ($obj->startTime_1 != '')
			$query .= " AND startTime_1 = '" . $obj->startTime_1 . "'";
		if ($obj->endTime_1 != '')
			$query .= " AND endTime_1 = '" . $obj->endTime_1 . "'";
		if ($obj->startTime_2 != '')
			$query .= " AND startTime_2 = '" . $obj->startTime_2 . "'";
		if ($obj->endTime_2 != '')
			$query .= " AND endTime_2 = '" . $obj->endTime_2 . "'";
		if ($obj->startTime_3 != '')
			$query .= " AND startTime_3 = '" . $obj->startTime_3 . "'";
		if ($obj->endTime_3 != '')
			$query .= " AND endTime_3 = '" . $obj->endTime_3 . "'";
		if ($obj->startTime_4 != '')
			$query .= " AND startTime_4 = '" . $obj->startTime_4 . "'";
		if ($obj->endTime_4 != '')
			$query .= " AND endTime_4 = '" . $obj->endTime_4 . "'";
		if ($obj->totalHours != '')
			$query .= " AND totalHours = '" . $obj->totalHours . "'";
		if ($obj->surveyTimeHours != '')
			$query .= " AND surveyTimeHours = '" . $obj->surveyTimeHours . "'";
		if ($obj->stCode != '')
			$query .= " AND stCode = '" . $obj->stCode . "'";
		if ($obj->surveyType != '')
			$query .= " AND surveyType = '" . $obj->surveyType . "'";
		if ($obj->vehCode != '')
			$query .= " AND vehCode = '" . $obj->vehCode . "'";
		if ($obj->vehicle != '')
			$query .= " AND vehicle = '" . $obj->vehicle . "'";
		if ($obj->isHoliday != '')
			$query .= " AND isHoliday = '" . $obj->isHoliday . "'";
		if ($obj->bonusHours != '')
			$query .= " AND bonusHours = '" . $obj->bonusHours . "'";
		if ($obj->surveyLocationDistrict != '')
			$query .= " AND surveyLocationDistrict = '" . $obj->surveyLocationDistrict . "'";
		if ($obj->surveyLocation != '')
			$query .= " AND surveyLocation = '" . $obj->surveyLocation . "'";
		if ($obj->routeItems != '')
			$query .= " AND routeItems LIKE '%" . $obj->routeItems . "%'";
		if ($obj->noOfSurveyors != '')
			$query .= " AND noOfSurveyors = '" . $obj->noOfSurveyors . "'";
		if ($obj->estimatedManHour != '')
			$query .= " AND estimatedManHour = '" . $obj->estimatedManHour . "'";
		if ($obj->receiveDate != '')
			$query .= " AND receiveDate = '" . $obj->receiveDate . "'";
		if ($obj->dataInputNo != '')
			$query .= " AND dataInputNo = '" . $obj->dataInputNo . "'";
		if ($obj->dataInputBy != '')
			$query .= " AND dataInputBy = '" . $obj->dataInputBy . "'";
		if ($obj->entryFormTypeNo != '')
			$query .= " AND entryFormTypeNo = '" . $obj->entryFormTypeNo . "'";
		if ($obj->noOfPages != '')
			$query .= " AND noOfPages = '" . $obj->noOfPages . "'";
		if ($obj->report !== NULL)
			$query .= " AND report = '" . $obj->report . "'";
		if ($obj->hourlyRate != '')
			$query .= " AND hourlyRate = '" . $obj->hourlyRate . "'";
		if ($obj->surveyFinding != '')
			$query .= " AND surveyFinding = '" . $obj->surveyFinding . "'";
		if ($obj->am != '')
			$query .= " AND am = '" . $obj->am . "'";
		if ($obj->periodHour_1 != '')
			$query .= " AND periodHour_1 = '" . $obj->periodHour_1 . "'";
		if ($obj->periodWagesHr_1 != '')
			$query .= " AND periodWagesHr_1 = '" . $obj->periodWagesHr_1 . "'";
		if ($obj->periodHour_2 != '')
			$query .= " AND periodHour_2 = '" . $obj->periodHour_2 . "'";
		if ($obj->periodWagesHr_2 != '')
			$query .= " AND periodWagesHr_2 = '" . $obj->periodWagesHr_2 . "'";
		if ($obj->totalWages != '')
			$query .= " AND totalWages = '" . $obj->totalWages . "'";
		if ($obj->onBoardCostFare != '')
			$query .= " AND onBoardCostFare = '" . $obj->onBoardCostFare . "'";
		if ($obj->noOfTrips != '')
			$query .= " AND noOfTrips = '" . $obj->noOfTrips . "'";
		if ($obj->transportAllowanceAm != '')
			$query .= " AND transportAllowanceAm = '" . $obj->transportAllowanceAm . "'";
		if ($obj->transportAllowanceNoon != '')
			$query .= " AND transportAllowanceNoon = '" . $obj->transportAllowanceNoon . "'";
		if ($obj->transportAllowancePm != '')
			$query .= " AND transportAllowancePm = '" . $obj->transportAllowancePm . "'";
		if ($obj->transportAllowanceOvernight != '')
			$query .= " AND transportAllowanceOvernight = '" . $obj->transportAllowanceOvernight . "'";
		if ($obj->taTotal != '')
			$query .= " AND taTotal = '" . $obj->taTotal . "'";
		if ($obj->wagesTaOnBoard != '')
			$query .= " AND wagesTaOnBoard = '" . $obj->wagesTaOnBoard . "'";
		if ($obj->onBoardTranportAllowanceTotal != '')
			$query .= " AND onBoardTranportAllowanceTotal = '" . $obj->onBoardTranportAllowanceTotal . "'";
		if ($obj->surveyorCode != '')
			$query .= " AND surveyorCode = '" . $obj->surveyorCode . "'";
		if ($obj->surveyorName != '')
			$query .= " AND surveyorName = '" . $obj->surveyorName . "'";
		if ($obj->surveyorTelephone != '')
			$query .= " AND surveyorTelephone = '" . $obj->surveyorTelephone . "'";
		if ($obj->complateJobNo != '')
			$query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
		if ($obj->distributedToLeader != '')
			$query .= " AND distributedToLeader = '" . $obj->distributedToLeader . "'";
		if ($obj->reportWeek != '')
			$query .= " AND reportWeek = '" . $obj->reportWeek . "'";
		if ($obj->direction != '')
			$query .= " AND direction = '" . $obj->direction . "'";
		if ($obj->plannedSurveyDateStart != '')
			$query .= " AND plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
		if ($obj->plannedSurveyDateEnd != '')
			$query .= " AND plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
		if ($obj->doDistrict != "") {
			$tempDoDist = explode(",", $obj->doDistrict);
			$query .= " AND (1=2 ";
			for ($i = 1; $i < count($tempDoDist); $i++) {
				$query .= " OR jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
			}
			$query .= ")";
		}
		$query .= " AND jobNoNew NOT LIKE '%ss' AND jobNoNew NOT LIKE '%tt' AND jobNoNew NOT LIKE '%uu'"; // 去掉end with ss
		if($type=='opening'){
			$query .= " AND jobNoNew IN (SELECT jobNoNew FROM Survey_MainScheduleOpen WHERE delFlag='no' AND applySurvId=0)";
		}elseif($type=='applied'){
			$query .= " AND jobNoNew IN (SELECT jobNoNew FROM Survey_MainScheduleOpen WHERE delFlag='no' AND applySurvId={$applySurvId})";
		}
		$query .= ' GROUP BY surveyLocationDistrict';
		$query .= ' ORDER BY surveyLocationDistrict ASC';

		$sql = "SELECT surveyLocationDistrict,COUNT(*) AS total FROM Survey_MainSchedule " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query($sql);
//		 echo $sql."<br />";
//		 exit();
		$rows = array();
		$i = 1;
		while ($rs = $this->db->next_record()) {
			$rows[$i] = array('surveyLocationDistrict'=>$rs["surveyLocationDistrict"],'total'=>$rs["total"]);
			$i++;
		}
		return $rows;
	}


	function UpdateAllStatus($surveyorCode, $jobNoNew) {
		/*$userId = $_SESSION['userId'];
		if(is_array($jobNoNew)){
			$jobNoNewStr = implode("','",$jobNoNew);
		}else{
			$jobNoNewStr = $jobNoNew;
		}
		$jobNoNewStr = "'".$jobNoNewStr."'";
		$updateTime = date('Y-m-d H:i:s');
		//委派是同一人的，直接更新爲審核狀態
		$sql = "UPDATE Survey_MainScheduleOpen
			SET auditUserId='{$userId}',auditTime='{$updateTime}'
			WHERE applySurvId='{$surveyorCode}' AND jobNoNew IN ({$jobNoNewStr}) AND delFlag='no'";
		$this->db->query($sql);
		//委派不是同一個人的，直接更新爲刪除狀態
		$sql = "UPDATE Survey_MainScheduleOpen
			SET auditUserId='{$userId}',auditTime='{$updateTime}',delFlag='yes'
			WHERE applySurvId != '{$surveyorCode}' AND jobNoNew IN ({$jobNoNewStr}) AND delFlag='no'";
		$this->db->query($sql);*/

	}


}
?>