<?php

/*
 * Header: Create: 2007-08-30 Auther: Jamblues.
 */

class MainScheduleAccess
{
    var $order = '';
    var $pageLimit = '';
    var $db = '';
    var $tableName = 'Survey_MainSchedule';

    function MainScheduleAccess($db)
    {
        $this->db = $db;
    }

    function Add($obj)
    {
        $sql = "INSERT INTO  Survey_MainSchedule(weekNo,jobNo,jobNoNew,plannedSurveyDate,tdFileNo,receivedDate,dueDate,fromTD,actualSurveyDate,startTime_1,endTime_1,startTime_2,endTime_2,startTime_3,endTime_3,startTime_4,endTime_4,totalHours,surveyTimeHours,stCode,surveyType,vehCode,vehicle,isHoliday,bonusHours,surveyLocationDistrict,surveyLocation,routeItems,noOfSurveyors,estimatedManHour,receiveDate,dataInputNo,dataInputBy,entryFormTypeNo,noOfPages,report,hourlyRate,surveyFinding,am,periodHour_1,periodWagesHr_1,periodHour_2,periodWagesHr_2,totalWages,onBoardCostFare,noOfTrips,transportAllowanceAm,transportAllowanceNoon,transportAllowancePm,transportAllowanceOvernight,taTotal,wagesTaOnBoard,onBoardTranportAllowanceTotal,surveyorCode,surveyorName,surveyorTelephone,complateJobNo,distributedToLeader,reportWeek,direction)" . " VALUES('" . $obj->weekNo . "'" . ",'" . $obj->jobNo . "'" . ",'" . $obj->jobNoNew . "'" . ",'" . $obj->plannedSurveyDate . "'" . ",'" . $obj->tdFileNo . "'" . ",'" . $obj->receivedDate . "'" . ",'" . $obj->dueDate . "'" . ",'" . $obj->fromTD . "'" . ",'" . $obj->actualSurveyDate . "'" . ",'" . $obj->startTime_1 . "'" . ",'" . $obj->endTime_1 . "'" . ",'" . $obj->startTime_2 . "'" . ",'" . $obj->endTime_2 . "'" . ",'" . $obj->startTime_3 . "'" . ",'" . $obj->endTime_3 . "'" . ",'" . $obj->startTime_4 . "'" . ",'" . $obj->endTime_4 . "'" . ",'" . $obj->totalHours . "'" . ",'" . $obj->surveyTimeHours . "'" . ",'" . $obj->stCode . "'" . ",'" . $obj->surveyType . "'" . ",'" . $obj->vehCode . "'" . ",'" . $obj->vehicle . "'" . ",'" . $obj->isHoliday . "'" . ",'" . $obj->bonusHours . "'" . ",'" . $obj->surveyLocationDistrict . "'" . ",'" . $obj->surveyLocation . "'" . ",'" . $obj->routeItems . "'" . ",'" . $obj->noOfSurveyors . "'" . ",'" . $obj->estimatedManHour . "'" . ",'" . $obj->receiveDate . "'" . ",'" . $obj->dataInputNo . "'" . ",'" . $obj->dataInputBy . "'" . ",'" . $obj->entryFormTypeNo . "'" . ",'" . $obj->noOfPages . "'" . ",'" . $obj->report . "'" . ",'" . $obj->hourlyRate . "'" . ",'" . $obj->surveyFinding . "'" . ",'" . $obj->am . "'" . ",'" . $obj->periodHour_1 . "'" . ",'" . $obj->periodWagesHr_1 . "'" . ",'" . $obj->periodHour_2 . "'" . ",'" . $obj->periodWagesHr_2 . "'" . ",'" . $obj->totalWages . "'" . ",'" . $obj->onBoardCostFare . "'" . ",'" . $obj->noOfTrips . "'" . ",'" . $obj->transportAllowanceAm . "'" . ",'" . $obj->transportAllowanceNoon . "'" . ",'" . $obj->transportAllowancePm . "'" . ",'" . $obj->transportAllowanceOvernight . "'" . ",'" . $obj->taTotal . "'" . ",'" . $obj->wagesTaOnBoard . "'" . ",'" . $obj->onBoardTranportAllowanceTotal . "'" . ",'" . $obj->surveyorCode . "'" . ",'" . $obj->surveyorName . "'" . ",'" . $obj->surveyorTelephone . "'" . ",'" . $obj->complateJobNo . "'" . ",'" . $obj->distributedToLeader . "'" . ",'" . $obj->reportWeek . "'" . ",'" . $obj->direction . "'" . ")";
        $this->db->query($sql);
        return $this->db->last_insert_id();
    }

    function AddBySql($sql)
    {
        $this->db->query($sql);
        return $this->db->last_insert_id();
    }

    function Update($obj)
    {
        $sql = "UPDATE Survey_MainSchedule " . " SET weekNo = '" . $obj->weekNo . "'" . " ,jobNo = '" . $obj->jobNo . "'" . " ,jobNoNew = '" . $obj->jobNoNew . "'" . " ,plannedSurveyDate = '" . $obj->plannedSurveyDate . "'" . " ,tdFileNo = '" . $obj->tdFileNo . "'" . " ,receivedDate = '" . $obj->receivedDate . "'" . " ,dueDate = '" . $obj->dueDate . "'" . " ,fromTD = '" . $obj->fromTD . "'" . " ,actualSurveyDate = '" . $obj->actualSurveyDate . "'" . " ,startTime_1 = '" . $obj->startTime_1 . "'" . " ,endTime_1 = '" . $obj->endTime_1 . "'" . " ,startTime_2 = '" . $obj->startTime_2 . "'" . " ,endTime_2 = '" . $obj->endTime_2 . "'" . " ,startTime_3 = '" . $obj->startTime_3 . "'" . " ,endTime_3 = '" . $obj->endTime_3 . "'" . " ,startTime_4 = '" . $obj->startTime_4 . "'" . " ,endTime_4 = '" . $obj->endTime_4 . "'" . " ,totalHours = '" . $obj->totalHours . "'" . " ,surveyTimeHours = '" . $obj->surveyTimeHours . "'" . " ,stCode = '" . $obj->stCode . "'" . " ,surveyType = '" . $obj->surveyType . "'" . " ,vehCode = '" . $obj->vehCode . "'" . " ,vehicle = '" . $obj->vehicle . "'" . " ,isHoliday = '" . $obj->isHoliday . "'" . " ,bonusHours = '" . $obj->bonusHours . "'" . " ,surveyLocationDistrict = '" . $obj->surveyLocationDistrict . "'" . " ,surveyLocation = '" . $obj->surveyLocation . "'" . " ,routeItems = '" . $obj->routeItems . "'" . " ,noOfSurveyors = '" . $obj->noOfSurveyors . "'" . " ,estimatedManHour = '" . $obj->estimatedManHour . "'" . " ,receiveDate = '" . $obj->receiveDate . "'" . " ,dataInputNo = '" . $obj->dataInputNo . "'" . " ,dataInputBy = '" . $obj->dataInputBy . "'" . " ,entryFormTypeNo = '" . $obj->entryFormTypeNo . "'" . " ,noOfPages = '" . $obj->noOfPages . "'" . " ,report = '" . $obj->report . "'" . " ,hourlyRate = '" . $obj->hourlyRate . "'" . " ,surveyFinding = '" . $obj->surveyFinding . "'" . " ,am = '" . $obj->am . "'" . " ,periodHour_1 = '" . $obj->periodHour_1 . "'" . " ,periodWagesHr_1 = '" . $obj->periodWagesHr_1 . "'" . " ,periodHour_2 = '" . $obj->periodHour_2 . "'" . " ,periodWagesHr_2 = '" . $obj->periodWagesHr_2 . "'" . " ,totalWages = '" . $obj->totalWages . "'" . " ,onBoardCostFare = '" . $obj->onBoardCostFare . "'" . " ,noOfTrips = '" . $obj->noOfTrips . "'" . " ,transportAllowanceAm = '" . $obj->transportAllowanceAm . "'" . " ,transportAllowanceNoon = '" . $obj->transportAllowanceNoon . "'" . " ,transportAllowancePm = '" . $obj->transportAllowancePm . "'" . " ,transportAllowanceOvernight = '" . $obj->transportAllowanceOvernight . "'" . " ,taTotal = '" . $obj->taTotal . "'" . " ,wagesTaOnBoard = '" . $obj->wagesTaOnBoard . "'" . " ,onBoardTranportAllowanceTotal = '" . $obj->onBoardTranportAllowanceTotal . "'" . " ,surveyorCode = '" . $obj->surveyorCode . "'" . " ,surveyorName = '" . $obj->surveyorName . "'" . " ,surveyorTelephone = '" . $obj->surveyorTelephone . "'" . " ,complateJobNo = '" . $obj->complateJobNo . "'" . " ,distributedToLeader = '" . $obj->distributedToLeader . "'" . " ,reportWeek = '" . $obj->reportWeek . "'" . " ,direction = '" . $obj->direction . "'" . " WHERE 1=1  AND mascId = '" . $obj->mascId . "'";
        $this->db->query($sql);
    }

    /**
     * 清空表
     */
    function EmptyTable()
    {
        $sql = "TRUNCATE TABLE Survey_MainSchedule ";
        $this->db->query($sql);
    }

    /**
     * 根据 ComplateJobNo 清空表
     *
     * @param string $complateJobNo
     */
    function EmptyTableByComplateJobNo($complateJobNo)
    {
        $sql = "DELETE FROM Survey_MainSchedule ";
        $sql .= " WHERE complateJobNo IN (" . $complateJobNo . ")";
        $this->db->query($sql);
    }

    /**
     * 清空沒有入系統的 ComplateJobNo 表內容
     *
     * @param string $complateJobNo
     */
    function EmptyOlderByComplateJobNo($complateJobNo)
    {
        $sql = "DELETE FROM Survey_MainSchedule ";
        $sql .= " WHERE complateJobNo NOT IN (" . $complateJobNo . ")";
        $this->db->query($sql);
    }

    function Del($obj)
    {
        $sql = "UPDATE Survey_MainSchedule " . " SET delFlag='yes' " . " WHERE 1=1  AND mascId = '" . $obj->mascId . "'";
        $this->db->query($sql);
    }

    function RealDel($obj)
    {
        $sql = "DELETE FROM Survey_MainSchedule " . " WHERE 1=1  AND mascId = '" . $obj->mascId . "'";
        $this->db->query($sql);
    }

    /**
     * 清空备份表
     */
    function EmptyBackupTable()
    {
        $sql = "TRUNCATE TABLE Survey_MainScheduleBackup ";
        $this->db->query($sql);
    }

    /**
     * 根据 ComplateJobNo 清空备份表
     *
     * @param string $complateJobNo
     */
    function EmptyBackupTableByComplateJobNo($complateJobNo)
    {
        $sql = "DELETE FROM Survey_MainScheduleBackup ";
        $sql .= " WHERE complateJobNo IN (" . $complateJobNo . ")";
        $this->db->query($sql);
    }

    /**
     * 将数据备份到备份表
     */
    function CopyBackupTable()
    {
        $sql = "INSERT INTO Survey_MainScheduleBackup
				SELECT * FROM Survey_MainSchedule ";
        $this->db->query($sql);
    }

    /**
     * 根据 ComplateJobNo 将数据备份到备份表
     *
     * @param string $complateJobNo
     */
    function CopyBackupTableByComplateJobNo($complateJobNo)
    {
        $sql = "INSERT INTO Survey_MainScheduleBackup
				SELECT * FROM Survey_MainSchedule ";
        $sql .= " WHERE complateJobNo IN (" . $complateJobNo . ")";
        $this->db->query($sql);
    }

    /**
     * 自动将SS对就的ass更改为相应的代码
     * @param unknown $complateJobNo
     */
    function AutoChangeSSJob($complateJobNo)
    {
        $this->AutoChangeXXJob($complateJobNo, 'ss');
        $this->AutoChangeXXJob($complateJobNo, 'tt');
        $this->AutoChangeXXJob($complateJobNo, 'uu');
    }

    /**
     * 自动将TT对就的ass更改为相应的代码
     * @param unknown $complateJobNo
     */
    function AutoChangeXXJob($complateJobNo, $suffix = 'ss')
    {
        global $conf;
        //获取最近一个月内新改变的SS job.
        $lastDayTime = date($conf ['date'] ['format'], strtotime("-1 Month"));
        $sql = "SELECT * FROM Survey_MainSchedule WHERE jobNoNew LIKE '%{$suffix}'";
        $sql .= " AND (plannedSurveyDate > '{$lastDayTime}' OR plannedSurveyDate = '')";
        $sql .= " AND complateJobNo IN (" . $complateJobNo . ")";
        $this->db->query($sql);
        $jobNoNews = array();
        while ($rs = $this->db->next_record()) {
            $jobNoNews[$rs["jobNoNew"]] = $rs["jobNoNew"];
        }
        if (count($jobNoNews) > 0) {
            //判断这些ss job是否在委派表中出现过,出现过从数据中删除
            $jobNoNewsQuery = "'" . implode("','", $jobNoNews) . "'";
            $sql = "SELECT * FROM Survey_SurveyorMainSchedule WHERE jobNoNew IN ({$jobNoNewsQuery})";
            $this->db->query($sql);
            while ($rs = $this->db->next_record()) {
                if (in_array($rs["jobNoNew"], $jobNoNews)){
                    unset($jobNoNews[$rs["jobNoNew"]]);
                }
            }
            if (count($jobNoNews) > 0) {
                $jobNoNewsQuery = "'" . implode("','", $jobNoNews) . "'";
                $jobNoNewsQuery = str_replace($suffix, "", $jobNoNewsQuery);
                //更新Survey_SurveyorMainSchedule
                $sql = "UPDATE Survey_SurveyorMainSchedule SET jobNoNew = CONCAT(jobNoNew,'{$suffix}')  WHERE jobNoNew IN ({$jobNoNewsQuery})";
                $this->db->query($sql);
                //更新Survey_MainSchedulePlannedDate
                $sql = "UPDATE Survey_MainSchedulePlannedDate SET jobNoNew = CONCAT(jobNoNew,'{$suffix}')  WHERE jobNoNew IN ({$jobNoNewsQuery})";
                $this->db->query($sql);
            }
        }
    }


    /**
     * 更新调查员阿头输入的计划调查时间
     */
    function UpdatePlannedSurveyDate()
    {
        global $conf;
        $case = "CASE complateJobNo";
        foreach ($conf ['complateJobNo'] as $v) {
            $case .= " WHEN '{$v}' THEN '{$conf['survey_start_date'][$v]}'";
        }
        $case .= " END";
        $sql = "UPDATE  Survey_MainSchedule ms
				INNER JOIN Survey_MainSchedulePlannedDate msp ON ms.jobNoNew = msp.jobNoNew
						SET ms.plannedSurveyDate = msp.plannedSurveyDate
						,ms.weekNo = CEILING(((TO_DAYS(msp.plannedSurveyDate)-TO_DAYS(" . $case . "))+1)/7)
								WHERE msp.delFlag = 'no'";
        $this->db->query($sql);
        // echo $sql;
    }

    /**
     * 更新报表員更新提交报告时间
     */
    function UpdateReportDate()
    {
        $sql = "UPDATE  Survey_MainSchedule ms
				INNER JOIN Survey_MainScheduleReportDate msr ON ms.jobNo = msr.jobNo
						SET ms.report = msr.reportDate
						WHERE msr.isFirst = 'yes'";
        $this->db->query($sql);
    }

    /**
     * 更新資料掃描的时间為收返form時間
     */
    function UpdateReceiveDate()
    {
        $sql = "UPDATE  Survey_MainSchedule ms
				INNER JOIN Survey_MainScheduleRawFile msrf ON ms.jobNoNew = msrf.jobNoNew
						SET ms.receiveDate = msrf.modifyTime
						WHERE msrf.delFlag = 'no'";
        $this->db->query($sql);
    }

    /**
     * 將系統委派的人員更親到MainSchedule
     */
    function UpdateAssignedSurveyor()
    {
        global $conf;
        $sql = "UPDATE Survey_MainSchedule ms
		INNER JOIN Survey_SurveyorMainSchedule sms ON ms.jobNoNew = sms.jobNoNew AND sms.delFlag='no'
		INNER JOIN Survey_Surveyor s ON sms.survId = s.survId
		SET ms.surveyorCode = s.survId,ms.surveyorName = s.engName,ms.surveyorTelephone = s.contact
		";
        //		WHERE ms.surveyorCode = ''";
        $this->db->query($sql);
    }

    /**
     * 单独更新Main Schedule 的 PlannedDate
     *
     * @param
     *            $jobNoNew
     * @param
     *            $plannedSurveyDate
     */
    function UpdateOnePlannedSurveyDate($jobNoNew, $plannedSurveyDate)
    {
        global $conf;
        $ms = new MainSchedule ();
        $ms->jobNoNew = $jobNoNew;
        $rs = $this->GetListSearch($ms);
        $ms = $rs [0];
        $startDate = $conf ['survey_start_date'] [$ms->complateJobNo];
        $sql = "UPDATE  Survey_MainSchedule
				SET plannedSurveyDate = '" . $plannedSurveyDate . "' " . "
						,weekNo = CEILING(((TO_DAYS('{$plannedSurveyDate}')-TO_DAYS('{$startDate}'))+1)/7) " . "
								WHERE jobNoNew = '{$jobNoNew}' ";
        $this->db->query($sql);
    }

    /**
     * 单独更新Main Schedule 的 Report Date(report)
     *
     * @param
     *            $jobNo
     * @param $reportDate 提交报告日期
     */
    function UpdateOneReportDate($jobNo, $reportDate)
    {
        $sql = "UPDATE  Survey_MainSchedule
				SET report = '" . $reportDate . "' " . "
						WHERE jobNo = '" . $jobNo . "' ";
        $this->db->query($sql);
    }

    /**
     * 单独更新Main Schedule 的 ReceiveDate
     *
     * @param
     *            $jobNoNew
     * @param
     *            $receiveDate
     */
    function UpdateOneReceiveDate($jobNoNew, $receiveDate)
    {
        $sql = "UPDATE  Survey_MainSchedule
				SET receiveDate = '" . $receiveDate . "' " . "
						WHERE jobNoNew = '" . $jobNoNew . "' ";
        $this->db->query($sql);
        // echo $sql;exit();
    }

    function GetListSearchNoSS($obj)
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
        if ($this->order != '')
            $query .= $this->order;

        $sql = "SELECT * FROM Survey_MainSchedule " . " WHERE 1=1 ";
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
            $obj->direction = $rs ["direction"];
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 取得该星期之前/之后的jobNoShort(短号)
     *
     * @param
     *            $weekNo
     * @param
     *            $complateJobNo
     * @param $isAfter 是否之后
     */
    function GetWeekJobNoShorts($weekNo, $complateJobNo, $isAfter = false)
    {
        $query = '';
        $query .= " AND complateJobNo = '" . $complateJobNo . "'";
        $query .= " AND jobNoNew NOT LIKE '%ss'"; // 去掉end with ss
        $sql = "SELECT DISTINCT jobNoShort FROM Survey_MainSchedule
				WHERE 1=1 AND weekNo " . ($isAfter ? ">" : "<") . " " . $weekNo . $query . "
						AND jobNoShort IN (SELECT jobNoShort FROM Survey_MainSchedule
								WHERE 1=1 AND weekNo = " . $weekNo . $query . ") ";
        $sql .= " ORDER BY jobNoShort";
        $this->db->query($sql);
        // print $sql."<br />";
        $jobNoShorts = array();
        while ($rs = $this->db->next_record()) {
            $jobNoShorts [] = $rs ["jobNoShort"];
        }
        return $jobNoShorts;
    }

    /**
     * 取得该星期之前的列表
     *
     * @param
     *            $weekNo
     * @param
     *            $complateJobNo
     * @param
     *            $afterJobNoShorts
     * @param $isAfter 是否之后
     */
    function GetWeekList($weekNo, $complateJobNo, $afterJobNoShorts, $isAfter = false){
        $query = '';
        $query .= " AND complateJobNo = '" . $complateJobNo . "'";
        $query .= " AND jobNoNew NOT LIKE '%ss'"; // 去掉end with ss
        $sql = "SELECT jobNoShort,SUM(estimatedManHour) AS estimatedManHour,SUM(onBoardCostFare*noOfTrips) AS onBoardCostFare
				,COUNT(jobNo) AS noOfPages,MAX(report) AS report FROM Survey_MainSchedule
				WHERE 1=1 AND weekNo " . ($isAfter ? ">" : "<") . " " . $weekNo . $query;
        if (count($afterJobNoShorts) > 0) {
            $sql .= " AND jobNoShort NOT IN (" . implodeSqlIn($afterJobNoShorts) . ") ";
        }
        $sql .= "AND jobNoShort IN (SELECT jobNoShort FROM Survey_MainSchedule
				WHERE 1=1 AND weekNo = " . $weekNo . $query . ")
						GROUP BY jobNoShort";
        $sql .= " ORDER BY jobNoShort";
        $this->db->query($sql);
        // print $sql."<br />";
        $rows = array();
        while ($rs = $this->db->next_record()) {
            $obj = new MainSchedule ();
            $obj->jobNoShort = $rs ["jobNoShort"];
            $obj->estimatedManHour = $rs ["estimatedManHour"];
            $obj->onBoardCostFare = $rs ["onBoardCostFare"];
            $obj->noOfPages = $rs ["noOfPages"];
            $obj->report = $rs ["report"];
            $obj->complateJobNo = $db->$complateJobNo;
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     *
     *
     * 得到后续还有编号的job
     *
     * @param
     *            $obj
     */
    function GetAfterJobNoListSearchNoSS($obj)
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
        if ($obj->report != '')
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
        $query .= " AND jobNoNew NOT LIKE '%ss'"; // 去掉end with ss
        if ($this->order != '')
            $query .= $this->order;

        $sql = "SELECT * FROM Survey_MainSchedule " . " WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print $sql."<br />";
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
            $obj->direction = $rs ["direction"];
            $rows [] = $obj;
        }
        return $rows;
    }

    function GetListSearch($obj,$surveyorId = false,$is_goods=false){
        $query = '';
        if ($obj->mascId != '')
            $query .= " AND MS.mascId = '" . $obj->mascId . "'";
        if ($obj->weekNo != '')
            $query .= " AND MS.weekNo = '" . $obj->weekNo . "'";
        if ($obj->jobNoShort != '')
            $query .= " AND MS.jobNoShort = '" . $obj->jobNoShort . "'";
        if ($obj->jobNo != '')
            $query .= " AND MS.jobNo = '" . $obj->jobNo . "'";
        if (!empty($obj->jobNoNewSigle)){
            if(is_array($obj->jobNoNewSigle)){
                $_tmpJobNoNews = implode("','",$obj->jobNoNewSigle);
                $_tmpJobNoNews = "'".$_tmpJobNoNews."'";
                $query .= " AND MS.jobNoNew IN ({$_tmpJobNoNews})";
            }else{
                $query .= " AND MS.jobNoNew = '{$obj->jobNoNewSigle}'";
            }
        }
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
                $query .= " AND ((MS.plannedSurveyDate >= '{$obj->plannedSurveyDateStart}'
				AND MS.plannedSurveyDate < '{$obj->plannedSurveyDateEnd}')
				OR MS.plannedSurveyDate = '')";
            } else if ($obj->plannedSurveyDateStart != '') {
                $query .= " AND (MS.plannedSurveyDate >= '{$obj->plannedSurveyDateStart}'
					OR MS.plannedSurveyDate = '')";
            }
        } else {
            if ($obj->plannedSurveyDateStart != '')
                $query .= " AND MS.plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
            if ($obj->plannedSurveyDateEnd != '')
                $query .= " AND MS.plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
        }
        if ($obj->doDistrict != "") {
            $tempDoDist = explode(",", $obj->doDistrict);
            $query .= " AND (1=2 ";
            for ($i = 1; $i < count($tempDoDist); $i++) {
                $query .= " OR MS.jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
            }
            $query .= ")";
        }
        if ($obj->isAssigned === false) {
            $query .= " AND MS.surveyorCode = ''";
        } else if ($obj->isAssigned === true) {
            $query .= " AND MS.surveyorCode <> ''";
        }
        if ($obj->isSelected === true) {
            $query .= " AND MS.surveyorCode = ''
            AND MS.jobNoNew IN (SELECT jobNoNew FROM Survey_MainScheduleOpen WHERE delFlag='no' AND auditUserId=0 AND applySurvId>0)";
        }
        if ($obj->noSS == true){
            $query .= " AND MS.jobNoNew NOT LIKE '%ss'"; // 去掉end with ss
        }
        if($is_goods){
            $query.= " AND MS.is_image='1'";
        }

        if ($this->order != '')
            $query .= $this->order;
        if ($this->pageLimit != '')
            $query .= $this->pageLimit;

        $sql = "SELECT MS.*,mso.sjop as jop";
        if($surveyorId != false){
            $sql .= ",sp.supaId as checkIn";
        }

        $sql .= ",RF.fileName as rawFile
				,MSC.mscId,MSC.company,MS.img_url,MS.is_image FROM Survey_MainSchedule MS
				LEFT JOIN Survey_MainScheduleRawFile RF ON RF.jobNoNew=MS.jobNoNew
				LEFT JOIN Survey_MainScheduleContractor MSC ON MSC.delFlag='no' AND MSC.jobNoNew=MS.jobNoNew
				LEFT JOIN Survey_SurveyJobOpen mso on mso.jobNo = MS.jobNo and mso.delFlag='no'
				";

        if($surveyorId != false){
            $sql .= "LEFT JOIN  Survey_SurveyPart sp on sp.survId = '{$surveyorId}' and sp.refNo = MS.jobNoNew and sp.delFlag = 'no'";
        }

        $sql .= 'WHERE 1=1 ';
        $sql = $sql . $query;

//        echo $sql;
//        exit();
        $this->db->query($sql);

//         echo "{$sql}<br>";
        $rows = array();
        while ($rs = $this->db->next_record()) {
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
            $obj->realClass = $rs ["realClass"];
            $obj->bookLong = $rs ["bookLong"];
            $obj->bookLat = $rs ["bookLat"];
            $obj->map_address = $rs ["map_address"];
            $obj->diy_name = $rs ["diy_name"];
            $obj->diy_value = $rs ["diy_value"];
            $obj->class_record_id = $rs ["class_record_id"];
            $obj->isopen = is_null($rs['jop'])?'yes':'no';
            $obj->checkIn = is_null($rs['checkIn'])?'no':'yes';
            $obj->img_url=$rs['img_url'];
            $obj->is_image=$rs['is_image'];
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 获取1个MainSchedule对象
     *
     * @param unknown $obj
     * @return multitype:MainSchedule
     */
    function GetSingle($obj)
    {
        $query = '';
        if ($obj->mascId != '')
            $query .= " AND MS.mascId = '" . $obj->mascId . "'";
        if ($obj->jobNoNew != '')
            $query .= " AND jobNoNew = '{$obj->jobNoNew}'";
        $query .= " LIMIT 1";

        $sql = "SELECT * FROM Survey_MainSchedule " . " WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // echo "{$sql}<br>";
        $rows = array();
        if ($rs = $this->db->next_record()) {
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
            return $obj;
        }
        return null;
    }

    /**
     * 取得RawData File
     *
     * @param obj $obj
     * @return obj
     */
    function GetListSearchForRawFile($obj)
    {
        $query = '';
        if ($obj->mascId != '')
            $query .= " AND mascId = '" . $obj->mascId . "'";
        if ($obj->weekNo != '')
            $query .= " AND weekNo = '" . $obj->weekNo . "'";
        if ($obj->jobNo != '')
            $query .= " AND jobNo LIKE '" . $obj->jobNo . "%'";
        if ($obj->jobNoNew != '')
            $query .= " AND MS.jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
        if ($obj->plannedSurveyDate != '')
            $query .= " AND plannedSurveyDate = '" . $obj->plannedSurveyDate . "'";
        if ($obj->tdFileNo != '')
            $query .= " AND tdFileNo = '" . $obj->tdFileNo . "'";
        if ($obj->receivedDate != '')
            $query .= " AND receivedDate = '" . $obj->receivedDate . "'";
        if ($obj->dueDate != '')
            $query .= " AND dueDate = '" . $obj->dueDate . "'";
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
                $query .= " OR MS.jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
            }
            $query .= ")";
        }

        if ($this->order != '')
            $query .= $this->order;
        if ($this->pageLimit != '')
            $query .= $this->pageLimit;

        $sql = "SELECT MS.*,RF.fileName FROM {$this->tableName} MS" . " LEFT JOIN Survey_MainScheduleRawFile RF ON RF.jobNoNew=MS.jobNoNew" . " WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print "{$sql}<br />";
        $rows = array();
        while ($rs = $this->db->next_record()) {
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
            $obj->direction = $rs ["direction"];
            $obj->surveyLocationCn = $rs ["surveyLocationCn"];
            $obj->rawFile = $rs ["fileName"];
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 取得RawData File
     *
     * @param obj $obj
     * @return obj
     */
    function GetListSearchUnfinishedAll($obj)
    {
        $query = '';
        if ($obj->mascId != '')
            $query .= " AND mascId = '" . $obj->mascId . "'";
        if ($obj->weekNo != '')
            $query .= " AND weekNo = '" . $obj->weekNo . "'";
        if ($obj->jobNo != '')
            $query .= " AND jobNo LIKE '" . $obj->jobNo . "%'";
        if ($obj->jobNoNew != '')
            $query .= " AND MS.jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
        if ($obj->plannedSurveyDate != '')
            $query .= " AND plannedSurveyDate = '" . $obj->plannedSurveyDate . "'";
        if ($obj->tdFileNo != '')
            $query .= " AND tdFileNo = '" . $obj->tdFileNo . "'";
        if ($obj->receivedDate != '')
            $query .= " AND receivedDate = '" . $obj->receivedDate . "'";
        if ($obj->dueDate != '')
            $query .= " AND dueDate = '" . $obj->dueDate . "'";
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
        if ($obj->receiveDate !== NULL) {
            if ($obj->receiveDate == "<>''") {
                $query .= " AND receiveDate <> ''";
            } else {
                $query .= " AND receiveDate = '" . $obj->receiveDate . "'";
            }
        }
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
                $query .= " OR MS.jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
            }
            $query .= ")";
        }
        if ($obj->report !== NULL)
            $query .= " AND report = '" . $obj->report . "'";
        if ($obj->entryDate !== NULL) {
            if ($obj->entryDate == "IS NULL") {
                $query .= " AND SP.inputTime IS NULL";
            } else if ($obj->entryDate == "<>''") {
                $query .= " AND SP.inputTime <> ''";
            } else {
                $query .= " AND SP.inputTime = '" . $obj->entryDate . "'";
            }
        }
        if ($obj->noSS == true)
            $query .= " AND MS.jobNoNew NOT LIKE '%ss'"; // 去掉end with ss

        if ($this->order != '')
            $query .= $this->order;
        if ($this->pageLimit != '')
            $query .= $this->pageLimit;

        $sql = "SELECT MS.*
				,RF.fileName,SP.inputTime AS entryDate
				,MSC.mscId,MSC.company
				FROM Survey_MainSchedule MS" . " LEFT JOIN Survey_MainScheduleRawFile RF ON RF.jobNoNew=MS.jobNoNew" . " LEFT JOIN Survey_SurveyPart SP ON SP.refNo=MS.jobNoNew" . " LEFT JOIN Survey_MainScheduleContractor MSC ON MSC.delFlag='no' AND MSC.jobNoNew=MS.jobNoNew" . " WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print "{$sql}<br />";
        $rows = array();
        while ($rs = $this->db->next_record()) {
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
            $obj->direction = $rs ["direction"];
            $obj->surveyLocationCn = $rs ["surveyLocationCn"];
            $obj->rawFile = $rs ["fileName"];
            $obj->entryDate = $rs ["entryDate"];
            $obj->mscId = $rs ["mscId"];
            $obj->company = $rs ["company"];
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 取得RawData File
     *
     * @param obj $obj
     * @return obj
     */
    function GetListSearchUnfinishedAllCount($obj)
    {
        $query = '';
        if ($obj->mascId != '')
            $query .= " AND mascId = '" . $obj->mascId . "'";
        if ($obj->weekNo != '')
            $query .= " AND weekNo = '" . $obj->weekNo . "'";
        if ($obj->jobNo != '')
            $query .= " AND jobNo LIKE '" . $obj->jobNo . "%'";
        if ($obj->jobNoNew != '')
            $query .= " AND MS.jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
        if ($obj->plannedSurveyDate != '')
            $query .= " AND plannedSurveyDate = '" . $obj->plannedSurveyDate . "'";
        if ($obj->tdFileNo != '')
            $query .= " AND tdFileNo = '" . $obj->tdFileNo . "'";
        if ($obj->receivedDate != '')
            $query .= " AND receivedDate = '" . $obj->receivedDate . "'";
        if ($obj->dueDate != '')
            $query .= " AND dueDate = '" . $obj->dueDate . "'";
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
        if ($obj->receiveDate !== NULL) {
            if ($obj->receiveDate == "<>''") {
                $query .= " AND receiveDate <> ''";
            } else {
                $query .= " AND receiveDate = '" . $obj->receiveDate . "'";
            }
        }
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
                $query .= " OR MS.jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
            }
            $query .= ")";
        }
        if ($obj->report !== NULL)
            $query .= " AND report = '" . $obj->report . "'";
        if ($obj->entryDate !== NULL) {
            if ($obj->entryDate == "IS NULL") {
                $query .= " AND SP.inputTime IS NULL";
            } else if ($obj->entryDate == "<>''") {
                $query .= " AND SP.inputTime <> ''";
            } else {
                $query .= " AND SP.inputTime = '" . $obj->entryDate . "'";
            }
        }
        if ($obj->noSS == true)
            $query .= " AND MS.jobNoNew NOT LIKE '%ss'"; // 去掉end with ss

        $sql = "SELECT COUNT(*) AS rowNum FROM Survey_MainSchedule MS" . " LEFT JOIN Survey_MainScheduleRawFile RF ON RF.jobNoNew=MS.jobNoNew" . " LEFT JOIN Survey_SurveyPart SP ON SP.refNo=MS.jobNoNew" . " WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print "{$sql}<br />";
        $rowNum = 0;
        if ($rs = $this->db->next_record()) {
            $rowNum = $rs ["rowNum"];
        }
        return $rowNum;
    }

    /**
     * 查找所有的jobNo
     *
     * @param unknown_type $obj
     * @return unknown
     */
    function GetListSearchScarcity($obj)
    {
        $query = '';
        if ($this->order != '')
            $query .= $this->order;
        if ($this->pageLimit != '')
            $query .= $this->pageLimit;

        $sql = "SELECT * FROM Survey_MainSchedule " . " WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print $sql;
        $rows = array();
        while ($rs = $this->db->next_record()) {
            $obj = new MainSchedule ();
            $obj->mascId = $rs ["mascId"];
            $obj->jobNo = $rs ["jobNo"];
            $obj->jobNoNew = $rs ["jobNoNew"];
            $rows [] = $obj;
        }
        return $rows;
    }

    function GetListSearchCount($obj)
    {
        $query = '';
        if ($obj->mascId != '')
            $query .= " AND mascId = '" . $obj->mascId . "'";
        if ($obj->weekNo != '')
            $query .= " AND weekNo = '" . $obj->weekNo . "'";
        if ($obj->jobNo != '')
            $query .= " AND jobNo = '" . $obj->jobNo . "'";
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
        if ($obj->fromTD != '')
            $query .= " AND fromTD like '%" . $obj->fromTD . "%'";
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
            $tempDoDist = explode(",", $obj->doDistrict);
            $query .= " AND (1=2 ";
            for ($i = 1; $i < count($tempDoDist); $i++) {
                $query .= " OR jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
            }
            $query .= ")";
        }
        if ($obj->isAssigned === false) {
            $query .= " AND surveyorCode = ''";
        } else if ($obj->isAssigned === true) {
            $query .= " AND surveyorCode <> ''";
        }
        if ($obj->isSelected === true) {
            $query .= " AND surveyorCode = ''
            AND jobNoNew IN (SELECT jobNoNew FROM Survey_MainScheduleOpen WHERE delFlag='no' AND auditUserId=0 AND applySurvId>0)";
        }

        $sql = "SELECT COUNT(*) AS rowNum FROM Survey_MainSchedule " . " WHERE 1=1 ";
        $sql = $sql . $query;

        $this->db->query($sql);
        $rowNum = 0;
        if ($rs = $this->db->next_record()) {
            $rowNum = $rs ["rowNum"];
        }
        return $rowNum;
    }

    /**
     * 仅供给有报告搜索结果用
     *
     * @param MainSchedule $obj
     * @return array
     */
    function GetListSearchForReport($obj)
    {
        $subQuery = '';
        if ($obj->mascId != '')
            $subQuery .= " AND mascId = '" . $obj->mascId . "'";
        if ($obj->weekNo != '')
            $subQuery .= " AND weekNo = '" . $obj->weekNo . "'";
        if ($obj->jobNo != '')
            $subQuery .= " AND ms.jobNo LIKE '%" . $obj->jobNo . "%'";
        if ($obj->jobNoNew != '')
            $subQuery .= " AND ms.jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
        if ($obj->routeItems != '')
            $subQuery .= " AND routeItems LIKE '%" . $obj->routeItems . "%'";
        if ($obj->reportDateStart != '')
            $subQuery .= " AND report >= '" . $obj->reportDateStart . "'";
        if ($obj->reportDateEnd != '')
            $subQuery .= " AND report < '" . $obj->reportDateEnd . "'";
        if ($obj->plannedSurveyDateStart != '')
            $subQuery .= " AND plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
        if ($obj->plannedSurveyDateEnd != '')
            $subQuery .= " AND plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
        if ($obj->doDistrict != "") {
            $tempDoDist = explode(",", $obj->doDistrict);
            $subQuery .= " AND (1=2 ";
            for ($i = 1; $i < count($tempDoDist); $i++) {
                $subQuery .= " OR jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
            }
            $subQuery .= ")";
        }
        if ($obj->firstSender == "NULL") {
            $subQuery .= " AND msrd.inputUserId IS NULL";
        } else if ($obj->firstSender == "all") {
            $subQuery .= " AND msrd.inputUserId IS NOT NULL";
        } else if ($obj->firstSender != "") {
            $subQuery .= " AND msrd.inputUserId='{$obj->firstSender}'";
        }
        $subQuery .= " GROUP BY ms.jobNo ";
        if ($obj->order != '')
            $subQuery .= $obj->order;
        if ($this->pageLimit != '')
            $subQuery .= $this->pageLimit;

        $sql = "SELECT ms.jobNo,MAX(msrd.inputUserId) as firstSender
		FROM Survey_MainSchedule ms
		LEFT JOIN Survey_MainScheduleReportDate msrd ON msrd.isFirst='yes' AND msrd.jobNo = ms.jobNo
		WHERE 1=1 {$subQuery}";
        $this->db->query($sql);
        // echo $sql;exit();
        $jobNos = "'000'";
        $firstSenders = array();
        while ($rs = $this->db->next_record()) {
            $jobNos .= ",'{$rs['jobNo']}'";
            $firstSenders [$rs ['jobNo']] = $rs ['firstSender'];
        }

        $query = '';
        // ssss結尾的不計入Report List中. by ryan 2012-09-11
        $query .= " AND jobNoNew NOT LIKE '%ss'";
        $query .= "GROUP BY jobNo ";

        $sql = "SELECT jobNo,MIN(dueDate) AS dueDate,SUM(estimatedManHour) AS estimatedManHour,SUM(onBoardCostFare*noOfTrips) AS onBoardCostFare
				,COUNT(*) as noOfPages,MAX(report) AS report,MAX(complateJobNo) AS complateJobNo
				FROM Survey_MainSchedule " . " WHERE 1=1 
					AND jobNo IN ({$jobNos})";
        $sql = $sql . $query;
        $this->db->query($sql);
        // echo $sql;exit();
        $rows = array();
        while ($rs = $this->db->next_record()) {
            $obj = new MainSchedule ();
            $obj->jobNo = $rs ["jobNo"];
            $obj->dueDate = $rs ["dueDate"];
            $obj->estimatedManHour = $rs ["estimatedManHour"];
            $obj->onBoardCostFare = $rs ["onBoardCostFare"];
            $obj->noOfPages = $rs ["noOfPages"];
            $obj->report = $rs ["report"];
            $obj->complateJobNo = $rs ["complateJobNo"];
            $obj->firstSender = $firstSenders [$obj->jobNo];
            // $obj->reportSentTimes = $rs["reportSentTimes"];
            global $conf;
            $db2 = new DataBase ($conf ["dbConnectStr"] ["BusSurvey"]);
            $sql2 = "SELECT DISTINCT plannedSurveyDate
					FROM Survey_MainSchedule  WHERE jobNo = '" . $obj->jobNo . "'";
            // ssss結尾的不計入Report List中. by ryan 2012-09-11
            $sql2 .= " AND jobNoNew NOT LIKE '%ss'";
            $db2->query($sql2);
            $plannedSurveyDates = "";
            while ($rs2 = $db2->next_record()) {
                $plannedSurveyDates .= "," . $rs2 ["plannedSurveyDate"];
            }
            $obj->plannedSurveyDate = $plannedSurveyDates;
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 仅供给有报告搜索结果用
     *
     * @param MainShcedule $obj
     * @return array
     */
    function GetListSearchForReportCount($obj)
    {
        $subQuery = '';
        if ($obj->mascId != '')
            $subQuery .= " AND mascId = '" . $obj->mascId . "'";
        if ($obj->weekNo != '')
            $subQuery .= " AND weekNo = '" . $obj->weekNo . "'";
        if ($obj->jobNo != '')
            $subQuery .= " AND ms.jobNo LIKE '%" . $obj->jobNo . "%'";
        if ($obj->jobNoNew != '')
            $subQuery .= " AND ms.jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
        if ($obj->routeItems != '')
            $subQuery .= " AND routeItems LIKE '%" . $obj->routeItems . "%'";
        if ($obj->reportDateStart != '')
            $subQuery .= " AND report >= '" . $obj->reportDateStart . "'";
        if ($obj->reportDateEnd != '')
            $subQuery .= " AND report < '" . $obj->reportDateEnd . "'";
        if ($obj->plannedSurveyDateStart != '')
            $subQuery .= " AND plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
        if ($obj->plannedSurveyDateEnd != '')
            $subQuery .= " AND plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
        if ($obj->doDistrict != "") {
            $tempDoDist = explode(",", $obj->doDistrict);
            $subQuery .= " AND (1=2 ";
            for ($i = 1; $i < count($tempDoDist); $i++) {
                $subQuery .= " OR jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
            }
            $subQuery .= ")";
        }
        if ($obj->firstSender == "NULL") {
            $subQuery .= " AND msrd.inputUserId IS NULL";
        } else if ($obj->firstSender != "") {
            $subQuery .= " AND msrd.inputUserId='{$obj->firstSender}'";
        }
        $subQuery .= " GROUP BY ms.jobNo ";

        $sql = "SELECT ms.jobNo,MAX(msrd.inputUserId) as firstSender
		FROM Survey_MainSchedule ms
		LEFT JOIN Survey_MainScheduleReportDate msrd ON msrd.isFirst='yes' AND msrd.jobNo = ms.jobNo
		WHERE 1=1 {$subQuery}";
        $this->db->query($sql);
        $rowNum = $this->db->num_rows();
        return $rowNum;
    }

    /**
     * 仅供出图表时候使用.
     *
     * @param unknown_type $obj
     * @return unknown
     */
    function GetListSearchByProgress($obj)
    {
        $query = '';
        if ($obj->mascId != '')
            $query .= " AND mascId = '" . $obj->mascId . "'";
        if ($obj->weekNo != '')
            $query .= " AND weekNo = '" . $obj->weekNo . "'";
        if ($obj->jobNo != '')
            $query .= " AND jobNo = '" . $obj->jobNo . "'";
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
        if ($obj->report != '')
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
        $query .= " AND jobNoNew NOT LIKE '%ss'"; // 去掉end with ss
        if ($this->order != '')
            $query .= $this->order;
        // $query .= " AND jobNoNew NOT LIKE '%ss'";
        $sql = "SELECT * FROM Survey_MainSchedule " . " WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print $sql;exit();
        $rows = array();
        while ($rs = $this->db->next_record()) {
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
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 得到未认领的记录
     *
     * @param unknown_type $obj
     * @return unknown
     */
    function GetListSearchNoClaim($obj)
    {
        $query = '';
        if ($obj->mascId != '')
            $query .= " AND mascId = '" . $obj->mascId . "'";
        if ($obj->weekNo != '')
            $query .= " AND weekNo = '" . $obj->weekNo . "'";
        if ($obj->jobNo != '')
            $query .= " AND jobNo = '" . $obj->jobNo . "'";
        if ($obj->jobNoNew != '')
            $query .= " AND MS.jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
        if ($obj->plannedSurveyDate != '')
            $query .= " AND plannedSurveyDate = '" . $obj->plannedSurveyDate . "'";
        if ($obj->tdFileNo != '')
            $query .= " AND tdFileNo = '" . $obj->tdFileNo . "'";
        if ($obj->receivedDate != '')
            $query .= " AND receivedDate = '" . $obj->receivedDate . "'";
        if ($obj->dueDate != '')
            $query .= " AND dueDate = '" . $obj->dueDate . "'";
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
        if ($obj->report != '')
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
                $query .= " OR MS.jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
            }
            $query .= ")";
        }
        if ($this->order != '')
            $query .= $this->order;

        $sql = "SELECT MS.*,S.* FROM Survey_MainSchedule MS" . " LEFT JOIN Survey_SurveyorMainSchedule SMS ON SMS.jobNoNew = MS.jobNoNew" . " LEFT JOIN Survey_Surveyor S ON S.survId = SMS.survId" . " WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print $sql;
        $rows = array();
        while ($rs = $this->db->next_record()) {
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
            // $obj->surveyorCode = $rs["surveyorCode"];
            // $obj->surveyorName = $rs["surveyorName"];
            // $obj->surveyorTelephone = $rs["surveyorTelephone"];
            $obj->surveyorCode = $rs ["survId"];
            $obj->surveyorName = $rs ["engName"];
            $obj->surveyorTelephone = $rs ["contact"];
            $obj->complateJobNo = $rs ["complateJobNo"];
            $obj->distributedToLeader = $rs ["distributedToLeader"];
            $obj->reportWeek = $rs ["reportWeek"];
            $obj->surveyLocationCn = $rs ["surveyLocationCn"];
            $obj->direction = $rs ["direction"];
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 得到调查员不一样的job
     *
     * @return array
     */
    function GetDiffSurveyor($obj)
    {
        $query = '';
        if ($obj->plannedSurveyDateStart != '')
            $query .= " AND MS.plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
        if ($obj->plannedSurveyDateEnd != '')
            $query .= " AND MS.plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
        if ($this->order != '')
            $query .= $this->order;

        $sql = "SELECT MS.*,RF.fileName,SP.survId,SMS.survId AS mySurvId FROM Survey_MainScheduleBackup MS
                LEFT JOIN Survey_MainScheduleRawFile RF ON RF.jobNoNew=MS.jobNoNew
				LEFT JOIN Survey_SurveyPart SP ON MS.jobNoNew = SP.refNo AND SP.delFlag='no'
				LEFT JOIN Survey_SurveyorMainSchedule SMS ON SMS.jobNoNew = MS.jobNoNew AND SMS.delFlag='no'
				WHERE ( (SP.survId<>MS.surveyorCode AND SP.survId IS NOT NULL) OR (SMS.survId<>MS.surveyorCode) )
										";
        $sql = $sql . $query;
        $this->db->query($sql);
// 		echo $sql;
        $rows = array();
        while ($rs = $this->db->next_record()) {
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
            $obj->survId = $rs ["survId"];
            $obj->mySurvId = $rs ["mySurvId"];
            $obj->rawFile = $rs ["fileName"];
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 获取调查员自选的项目
     *
     * @return array
     */
    function GetSelfSelect($obj)
    {
        $query = '';
        if ($obj->jobNoNew != '')
            $query .= " AND MS.jobNoNew LIKE '%" . $obj->jobNoNew . "%'";
        if ($obj->surveyorCode != '')
            $query .= " AND MS.surveyorCode = '" . $obj->surveyorCode . "'";
        if ($obj->plannedSurveyDateStart != '')
            $query .= " AND MS.plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
        if ($obj->plannedSurveyDateEnd != '')
            $query .= " AND MS.plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
        if ($this->order != '')
            $query .= $this->order;

        $sql = "SELECT MS.*,RF.fileName,MSO.inputTime,MSO.applyTime,MSO.auditTime FROM Survey_MainSchedule MS
                LEFT JOIN Survey_MainScheduleRawFile RF ON RF.jobNoNew=MS.jobNoNew
				INNER JOIN Survey_MainScheduleOpen MSO ON MSO.jobNoNew=MS.jobNoNew
				WHERE MS.surveyorCode=MSO.applySurvId AND MSO.delFlag='no'";
        $sql = $sql . $query;
        $this->db->query($sql);
// 		echo $sql;
        $rows = array();
        while ($rs = $this->db->next_record()) {
            $rows [] = $rs;
        }
        return $rows;
    }


    /**
     * 對出歷史記錄得到调查员不一样的job
     *
     * @return unknown
     */
    function GetDiffSurveyorHistory($obj)
    {
        $query = '';
        if ($obj->plannedSurveyDateStart != '')
            $query .= " AND MS.plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
        if ($obj->plannedSurveyDateEnd != '')
            $query .= " AND MS.plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
        if ($this->order != '')
            $query .= $this->order;
        $historyTable = "Survey_MainSchedule_" . date("Ym", strtotime($obj->plannedSurveyDateStart));

        $sql = "SELECT MS.*,MSH.surveyorCode AS mySurvId 
				FROM Survey_MainSchedule MS
				LEFT JOIN {$historyTable} MSH ON MSH.jobNoNew=MS.jobNoNew
				WHERE MS.surveyorCode <> MSH.surveyorCode ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // echo $sql;
        $rows = array();
        while ($rs = $this->db->next_record()) {
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
            $obj->survId = $rs ["survId"];
            $obj->mySurvId = $rs ["mySurvId"];
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 得到调查阿头输入时间跟本身MainSchedule的不同
     *
     * @return unknown
     */
    function GetDiffPlannedDate($obj)
    {
        $query = '';
        if ($obj->plannedSurveyDateStart != '')
            $query .= " AND MS.plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
        if ($obj->plannedSurveyDateEnd != '')
            $query .= " AND MS.plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
        if ($this->order != '')
            $query .= $this->order;

        $sql = "SELECT MS.*,RF.fileName,MSB.plannedSurveyDate AS myPlannedSurveyDate FROM Survey_MainSchedule MS
                LEFT JOIN Survey_MainScheduleRawFile RF ON RF.jobNoNew=MS.jobNoNew
				INNER JOIN Survey_MainScheduleBackup MSB ON MSB.jobNoNew = MS.jobNoNew
				WHERE DATE_FORMAT(MSB.plannedSurveyDate,'%Y-%m-%d') <> DATE_FORMAT(MS.plannedSurveyDate,'%Y-%m-%d') ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print $sql;
        $rows = array();
        while ($rs = $this->db->next_record()) {
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
            $obj->survId = $rs ["survId"];
            $obj->mySurvId = $rs ["mySurvId"];
            $obj->myPlannedSurveyDate = $rs ["myPlannedSurveyDate"];
            $obj->rawFile = $rs ["fileName"];
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 得到报表更新时间跟本身MainSchedule的不同
     *
     * @return unknown
     */
    function GetDiffReportDate($obj)
    {
        $query = '';
        if ($obj->reportDateStart != '')
            $query .= " AND MS.report >= '" . $obj->reportDateStart . "'";
        if ($obj->reportDateEnd != '')
            $query .= " AND MS.report < '" . $obj->reportDateEnd . "'";
        if ($this->order != '')
            $query .= $this->order;

        $sql = "SELECT MS.*,MSB.report AS myReportate
				FROM Survey_MainSchedule MS
						INNER JOIN Survey_MainScheduleBackup MSB ON MSB.jobNoNew = MS.jobNoNew
								WHERE DATE_FORMAT(MSB.report,'%Y-%m-%d') <> DATE_FORMAT(MS.report,'%Y-%m-%d') ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print $sql;
        $rows = array();
        while ($rs = $this->db->next_record()) {
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
            $obj->survId = $rs ["survId"];
            $obj->myReportDate = $rs ["myReport"];
            $rows [] = $obj;
        }
        return $rows;
    }

    /**
     * 得到最大星期数
     *
     * @param
     *            $obj:实体类
     * @return 最大星期数字
     */
    function GetWeekNo($obj)
    {
        $query = '';
        if ($obj->complateJobNo != '')
            $query .= " AND complateJobNo = '" . $obj->complateJobNo . "'";
        if ($obj->doDistrict != "") {
            $tempDoDist = explode(",", $obj->doDistrict);
            $query .= " AND (1=2 ";
            for ($i = 1; $i < count($tempDoDist); $i++) {
                $query .= " OR jobNoNew LIKE '" . $tempDoDist [$i] . "%'";
            }
            $query .= ")";
        }
        $query .= " AND jobNoNew NOT LIKE '%ss'"; // 去掉end with ss

        $sql = "SELECT MAX(CONVERT( weekNo, SIGNED )) AS maxWeekNo
				FROM Survey_MainSchedule
						WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print $sql;
        $maxWeekNo = 0;
        if ($rs = $this->db->next_record()) {
            $maxWeekNo = $rs ["maxWeekNo"];
        }
        return $maxWeekNo;
    }

    /**
     * 获取总的估计时间数
     *
     * @param MainSchedule $obj
     * @return float estimateManHour 估计时间总数
     */
    function GetEstimatedManHour($obj)
    {
        $query = '';
        if (!empty ($obj->jobNoNew)) {
            if (is_array($obj->jobNoNew)) {
                $query .= " AND jobNoNew IN(" . implodeSqlIn($obj->jobNoNew) . ")";
            } else {
                $query .= " AND jobNoNew = '" . $obj->jobNoNew . "'";
            }
        }
        if ($obj->plannedSurveyDateStart != '')
            $query .= " AND plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
        if ($obj->plannedSurveyDateEnd != '')
            $query .= " AND plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";

        $sql = "SELECT IFNULL(SUM(estimatedManHour),0) AS estimatedManHour FROM Survey_MainSchedule
		WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print "{$sql}<br />";
        $estimatedManHour = 0;
        if ($rs = $this->db->next_record()) {
            $estimatedManHour = $rs ["estimatedManHour"];
        }
        return $estimatedManHour;
    }

    /**
     * 获取总的未委派的时间数
     *
     * @param MainSchedule $obj
     * @return float estimateManHour 估计时间总数
     */
    function GetNoAssignEstimatedManHour($obj)
    {
        $query = '';
        if ($obj->plannedSurveyDateStart != '')
            $query .= " AND plannedSurveyDate >= '" . $obj->plannedSurveyDateStart . "'";
        if ($obj->plannedSurveyDateEnd != '')
            $query .= " AND plannedSurveyDate < '" . $obj->plannedSurveyDateEnd . "'";
        $query .= " AND surveyorCode = ''";

        $sql = "SELECT IFNULL(SUM(estimatedManHour),0) AS estimatedManHour FROM Survey_MainSchedule
		WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print $sql;
        $estimatedManHour = 0;
        if ($rs = $this->db->next_record()) {
            $estimatedManHour = $rs ["estimatedManHour"];
        }
        return $estimatedManHour;
    }

    /**
     * 判断当前时间是否有空
     *
     * @param array $assignedTime
     * @param array $currTime
     */
    function IsAssignTime($assignedTime, $currTime)
    {
        if (empty ($assignedTime)) {
            return false;
        }
        $isAssign = false;
        foreach ($currTime as $ct) {
            foreach ($assignedTime as $v) {
//                 var_dump($v);
//                 echo "<br />";
//                 var_dump($ct);
//                 echo "<br />";
//                 echo "(strtotime({$ct['startTime']}) >= strtotime({$v['startTime']}) && strtotime({$ct['startTime']}) <= strtotime({$v['endTime']}))"."::::<br />";
//                 echo (strtotime($ct['startTime']) >= strtotime($v['startTime']) && strtotime($ct['startTime']) <= strtotime($v['endTime']))."::::<br />";
//                 echo "(strtotime({$ct['endTime']}) >= strtotime({$v['startTime']}) && strtotime({$ct['endTime']}) <= strtotime({$v['endTime']}))"."::::<br />";
//                 echo (strtotime($ct['endTime']) >= strtotime($v['startTime']) && strtotime($ct['endTime']) <= strtotime($v['endTime']))."::::<br />";
                if (strtotime($ct ['endTime']) == strtotime($v ['startTime'])){
//                    $isAssign = false;
                }else if(strtotime($ct ['startTime']) == strtotime($v ['endTime'])){
//                    $isAssign = false;
                } else if (strtotime($ct ['startTime']) >= strtotime($v ['startTime']) && strtotime($ct ['startTime']) <= strtotime($v ['endTime'])) {
                    $isAssign = true;
                    break;
                } else if (strtotime($ct ['endTime']) >= strtotime($v ['startTime']) && strtotime($ct ['endTime']) <= strtotime($v ['endTime'])) {
                    $isAssign = true;
                    break;
                } else if (strtotime($ct ['endTime']) >= strtotime($v ['startTime']) && strtotime($ct ['startTime']) <= strtotime($v ['startTime'])) {
                    $isAssign = true;
                    break;
                }
            }
        }
        return $isAssign;
    }

    /**
     * 委派給調查員
     *
     * @param Surveyor $sur
     * @param string /array $jobNoNew
     */
    function Assign2Surveyor($sur, $jobNoNew,$selfOperate = false,$record_surveyor = false)
    {

        $sql = "UPDATE Survey_MainSchedule " . " SET surveyorCode = '{$sur->survId}'" . " ,surveyorName = '{$sur->engName}'" . " ,surveyorTelephone = '{$sur->contact}'";
        if (is_array($jobNoNew)) {
            $infoSql = "SELECT realClass FROM Survey_MainSchedule where jobNoNew In (".implodeSqlIn($jobNoNew) .")";

            $sql .= " WHERE 1=1  AND jobNoNew IN (" . implodeSqlIn($jobNoNew) . ")";
        } else {
            $infoSql = "SELECT realClass FROM Survey_MainSchedule where jobNoNew = '{$jobNoNew}'";

            $sql .= " WHERE 1=1  AND jobNoNew = '{$jobNoNew}'";
        }
        $this->db->query($sql);

        $this->db->query($infoSql);
        $relClass = array();
        while($rs = $this->db->next_record ()){
            if($rs['realClass'] == 1){
                $relClass[] = $rs['realClass'];
            }
        }
        $class_num = count($relClass);
        $sql2 = "UPDATE Survey_Surveyor SET class_remain=class_remain-$class_num WHERE survId='{$sur->survId}'" ;
        $this->db->query($sql2);

        $name = '';
        if($record_surveyor !== false){
            $name = empty($record_surveyor->chiName)?'('.$record_surveyor->engName.')':'('.$record_surveyor->chiName.')';
        }
        $record_surveyor_id = $record_surveyor->survId;
        $remark = $selfOperate === true?'學員自選課堂':$name.'分配課堂';
        $this->addClassRecord($sur->survId,$jobNoNew,0-$class_num,$sur->class_remain-$class_num,$remark,$record_surveyor_id);
    }


    function addClassRecord($surveyor_id,$jobNoNew,$use_class,$class_remain,$remark,$record_surveyor_id,$status = 1,$time = false){
        global $db;

        if($time == false){
            $record_time = date('Y-m-d H:i:s');
        }else{
            $record_time = $time;
        }


        $sql = "INSERT into Survey_SurveyorClassRecord(surveyor_id,jobNoNew,use_class,class_remain,remark,record_time,record_surveyor_id,status) values ('$surveyor_id','$jobNoNew','$use_class','$class_remain','$remark','$record_time','$record_surveyor_id','$status')";
        $res = $db->query($sql);

        if($status == 1){
            $sql2 = "SELECT last_insert_id() ";
            $db->query($sql2);
            if($lastid = $db->next_record ()){
                $lastid = $lastid[0];
            }
            $ss_sql = "UPDATE Survey_MainSchedule set class_record_id = '$lastid'  where jobNoNew = '$jobNoNew'";
        }elseif($status == 0){
            $ss_sql = "UPDATE Survey_MainSchedule set class_record_id = '' where jobNoNew = '$jobNoNew'";
        }else{

        }

        $ss_res = $db->query($ss_sql);

        return $ss_res;

    }

    /**
     * 撤消委派給調查員
     *
     * @param Surveyor $sur
     * @param string $jobNoNew
     */
    function UnAssign2Surveyor($sur, $jobNoNew,$record_surveyor = false)
    {
        $old_remain_sql = "select class_remain from Survey_Surveyor where survId=$sur->survId";
        $this->db->query($old_remain_sql);
        $old_remain = 0;
        while($old_remain_rs = $this->db->next_record ()){
            $old_remain = $old_remain_rs['class_remain'];
        }

        $name = '';
        if($record_surveyor !== false){
            $name = empty($record_surveyor->chiName)?'('.$record_surveyor->engName.')':'('.$record_surveyor->chiName.')';
        }

        $sql = "UPDATE Survey_MainSchedule " . " SET surveyorCode = ''" . " ,surveyorName = ''" . " ,surveyorTelephone = ''" . " WHERE 1=1  AND jobNoNew = '{$jobNoNew}' AND surveyorCode = '{$sur->survId}'";
        $this->db->query($sql);
        $sql2 = "UPDATE Survey_MainScheduleOpen " . " SET applySurvId = 0" . " WHERE 1=1  AND jobNoNew = '{$jobNoNew}' ";
        $this->db->query($sql2);

        $infoSql = "SELECT realClass FROM Survey_MainSchedule where jobNoNew = '{$jobNoNew}'";
        $this->db->query($infoSql);
        $relClass = array();
        while($rs = $this->db->next_record ()){
            if($rs['realClass'] == 1){
                $relClass[] = $rs['realClass'];
            }
        }
        $class_num = count($relClass);

        //TODO check jobNo Time is out?
        /*$isTimeOut_sql = "SELECT ";
        $isTimeOut = '';
        if($isTimeOut){*/
        $sql3 = "UPDATE Survey_Surveyor SET class_remain=class_remain+$class_num WHERE survId='{$sur->survId}'" ;
        $this->db->query($sql3);
        //}
        $record_surveyor_id = $record_surveyor->survId;
        $remark = $name.'已取消';

        return $this->addClassRecord($sur->survId,$jobNoNew,$class_num,$old_remain+$class_num,$remark,$record_surveyor_id,0);
    }

    function cancel_confirm_pdf($cancel_survId,$cancel_id){
        global $db;

        $sql = "SELECT confirm_pdf FROM Survey_SurveyorClassRecord "." WHERE 1=1 AND id = '{$cancel_id}'";
        $rs = $this->db->query($sql);
        $res = array();
        while ($rs = $this->db->next_record()){
            $res = $rs;
        }
        if(empty($res['confirm_pdf'])){
            $pdfid = $res['confirm_pdf'];
            $cancel_time = date('Y-m-d H:i:s');
            //更新课堂记录的确认PDF
            $sql1 = "UPDATE Survey_SurveyorClassRecord SET confirm_pdf = '',
        cancel_confirm_pdf_by = '{$cancel_survId}',confirm_pdf_create_time='{$cancel_time}'
         where id='{$cancel_id}' and is_del = 0";
            $updateRes1 = $db->query ( $sql1 );

            //更新PDF的剩余课堂数
            $sql2 = "UPDATE Survey_SurveyorClassPDF SET class_remain = class_remain+1
         where id='{$pdfid}' and is_del = 0";
            $updateRes2 = $db->query ( $sql2 );
            return $updateRes2;
        }else{
            return true;
        }

    }

    /**
     * 獲取未帶finished的Raw data.
     */
    function GetNoFinishedRawData()
    {
        $sql = "SELECT * FROM Survey_MainSchedule " . " WHERE 1=1 " . " AND jobNoNew IN (
						SELECT jobNoNew FROM Survey_MainScheduleRawFile WHERE fileName NOT LIKE '%finished%')
								ORDER BY jobNoNew ASC";
        $sql = $sql . $query;
        $this->db->query($sql);
        // echo $sql;exit();
        $rows = array();
        while ($rs = $this->db->next_record()) {
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
            $rows [] = $obj;
        }
        return $rows;
    }


    /**
     * 獲取時間是否有衝突.
     * @param $survId
     * @param $plannedSurveyDate
     * @param $startTime1
     * @param $endTime1
     * @return bool
     */
    function IsBusyTime($survId,$plannedSurveyDate,$startTime1,$endTime1)
    {
        //如果结束时间是跨天的，加上24小时
        if($startTime1 > $endTime1){
            $endTime1 = TimeAddHour($endTime1,24);
        }
        //判断已委派的有没有直接时间冲突的
        $sql = "SELECT * FROM Survey_MainSchedule
            WHERE surveyorCode='{$survId}'
            AND plannedSurveyDate = '{$plannedSurveyDate}'
            AND (
                (startTime_1 > '{$startTime1}' AND startTime_1 < '{$endTime1}')
                OR (endTime_1 > '{$startTime1}' AND endTime_1 < '{$endTime1}')
                OR (startTime_1 = '{$startTime1}' AND endTime_1 = '{$endTime1}')
                OR (endTime_1 > '{$startTime1}' AND startTime_1 < '{$startTime1}')
                OR (startTime_1 > endTime_1 AND startTime_1<'{$endTime1}')
             )";

        $this->db->query($sql);
//        echo $sql;exit;
        if ($this->db->next_record()) {
            return true;
        }
        //判断认领里面有没有时间冲突的
        $sql = "SELECT * FROM Survey_MainSchedule ms
            INNER JOIN Survey_MainScheduleOpen mso ON mso.jobNoNew=ms.jobNoNew
            WHERE mso.applySurvId='{$survId}' AND delFlag='no'
            AND ms.plannedSurveyDate = '{$plannedSurveyDate}'
            AND (
                (ms.startTime_1 > '{$startTime1}' AND ms.startTime_1 < '{$endTime1}')
                OR (ms.endTime_1 > '{$startTime1}' AND ms.endTime_1 < '{$endTime1}')
                OR (ms.startTime_1 = '{$startTime1}' AND ms.endTime_1 = '{$endTime1}')
                OR (ms.endTime_1 > '{$startTime1}' AND ms.startTime_1 < '{$startTime1}')
                OR (ms.startTime_1 > ms.endTime_1 AND ms.startTime_1<'{$endTime1}')
             )";

        $this->db->query($sql);
//         echo $sql;exit();
        if ($this->db->next_record()) {
            return true;
        }
        return false;
    }
}

?>