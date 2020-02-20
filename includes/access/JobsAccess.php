<?php

/**
 * Created by PhpStorm.
 * User: James
 * Date: 2018-02-13
 * Time: 00:25
 */
class JobsAccess {
    var $db = '';

    function JobsAccess($db) {
        $this->db = $db;
    }

    function singleDelete($jobNoNew) {
        global $conf;
        $sql = "DELETE FROM {$conf['table']['prefix']}MainSchedule WHERE jobNoNew LIKE '{$jobNoNew}%'";
        $this->db->query($sql);
        $sql = "DELETE FROM Survey_SurveyPart " .
            " WHERE 1=1  AND refNo LIKE '{$jobNoNew}'";
        $this->db->query($sql);
        $sql = "DELETE FROM Survey_MainScheduleOpen " .
            " WHERE 1=1  AND jobNoNew LIKE '{$jobNoNew}'";
        $this->db->query($sql);
        $sql = "DELETE FROM Survey_SurveyorMainSchedule " .
            " WHERE 1=1  AND jobNoNew LIKE '{$jobNoNew}'";
        $this->db->query($sql);
    }

    function hadAssignSurveryor($jobNo, $jobNoNew = '') {
        if ($jobNoNew == '') {
            $sql = "SELECT jobNo FROM Survey_MainSchedule WHERE jobNo = '{$jobNo}' and surveyorCode != '' Limit 1";
            $this->db->query($sql);
            if ($dr = $this->db->next_record()) {
                return true;
            } else {
                return false;
            }
        } else {

        }
    }

    function batchDelete($jobNo) {
        global $conf;
        $sql = "DELETE FROM {$conf['table']['prefix']}MainSchedule WHERE jobNo LIKE '{$jobNo}%'";
        $this->db->query($sql);
        $sql = "DELETE FROM Survey_SurveyPart " .
            " WHERE 1=1  AND refNo LIKE '{$jobNo}%'";
        $this->db->query($sql);
        $sql = "DELETE FROM Survey_MainScheduleOpen " .
            " WHERE 1=1  AND jobNoNew LIKE '{$jobNo}%'";
        $this->db->query($sql);
        $sql = "DELETE FROM Survey_SurveyorMainSchedule " .
            " WHERE 1=1  AND jobNoNew LIKE '{$jobNo}%'";
        $this->db->query($sql);
        $sql = "DELETE FROM Survey_SurveyJobOpen " .
            " WHERE 1=1  AND jobNo LIKE '{$jobNo}'";
        $this->db->query($sql);
    }

    function isExistJobNo($jobNo) {
        global $conf;
        $sql = "SELECT * FROM {$conf['table']['prefix']}MainSchedule WHERE jobNo='{$jobNo}' LIMIT 1;";
        $this->db->query($sql);
        if ($dr = $this->db->next_record()) {
            return true;
        }
        return false;
    }

    /***
     * 根据jobNoNew获取单条信息
     * @param $data
     * @return array
     */
    function getInfo($data) {
        global $conf;
        $result = array();
        $sql = "SELECT * FROM {$conf['table']['prefix']}MainSchedule WHERE jobNoNew='{$data['jobNoNew']}' LIMIT 1;";
        $this->db->query($sql);
        if ($dr = $this->db->next_record()) {
            $result['mascId'] = $dr['mascId'];
            $result['weekNo'] = $dr['weekNo'];
            $result['jobNoShort'] = $dr['jobNoShort'];
            $result['jobNo'] = $dr['jobNo'];
            $result['jobNoNew'] = $dr['jobNoNew'];
            $result['plannedSurveyDate'] = $dr['plannedSurveyDate'];
            $result['tdFileNo'] = $dr['tdFileNo'];
            $result['receivedDate'] = $dr['receivedDate'];
            $result['dueDate'] = $dr['dueDate'];
            $result['fromTD'] = $dr['fromTD'];
            $result['actualSurveyDate'] = $dr['actualSurveyDate'];
            $result['startTime_1'] = $dr['startTime_1'];
            $result['endTime_1'] = $dr['endTime_1'];
            $result['startTime_2'] = $dr['startTime_2'];
            $result['endTime_2'] = $dr['endTime_2'];
            $result['startTime_3'] = $dr['startTime_3'];
            $result['endTime_3'] = $dr['endTime_3'];
            $result['startTime_4'] = $dr['startTime_4'];
            $result['endTime_4'] = $dr['endTime_4'];
            $result['totalHours'] = $dr['totalHours'];
            $result['surveyTimeHours'] = $dr['surveyTimeHours'];
            $result['stCode'] = $dr['stCode'];
            $result['surveyType'] = $dr['surveyType'];
            $result['vehCode'] = $dr['vehCode'];
            $result['vehicle'] = $dr['vehicle'];
            $result['isHoliday'] = $dr['isHoliday'];
            $result['bonusHours'] = $dr['bonusHours'];
            $result['surveyLocationDistrict'] = $dr['surveyLocationDistrict'];
            $result['surveyLocation'] = $dr['surveyLocation'];
            $result['routeItems'] = $dr['routeItems'];
            $result['noOfSurveyors'] = $dr['noOfSurveyors'];
            $result['estimatedManHour'] = $dr['estimatedManHour'];
            $result['receiveDate'] = $dr['receiveDate'];
            $result['dataInputNo'] = $dr['dataInputNo'];
            $result['dataInputBy'] = $dr['dataInputBy'];
            $result['entryFormTypeNo'] = $dr['entryFormTypeNo'];
            $result['noOfPages'] = $dr['noOfPages'];
            $result['report'] = $dr['report'];
            $result['hourlyRate'] = $dr['hourlyRate'];
            $result['surveyFinding'] = $dr['surveyFinding'];
            $result['am'] = $dr['am'];
            $result['periodHour_1'] = $dr['periodHour_1'];
            $result['periodWagesHr_1'] = $dr['periodWagesHr_1'];
            $result['periodHour_2'] = $dr['periodHour_2'];
            $result['periodWagesHr_2'] = $dr['periodWagesHr_2'];
            $result['totalWages'] = $dr['totalWages'];
            $result['onBoardCostFare'] = $dr['onBoardCostFare'];
            $result['noOfTrips'] = $dr['noOfTrips'];
            $result['transportAllowanceAm'] = $dr['transportAllowanceAm'];
            $result['transportAllowanceNoon'] = $dr['transportAllowanceNoon'];
            $result['transportAllowancePm'] = $dr['transportAllowancePm'];
            $result['transportAllowanceOvernight'] = $dr['transportAllowanceOvernight'];
            $result['taTotal'] = $dr['taTotal'];
            $result['wagesTaOnBoard'] = $dr['wagesTaOnBoard'];
            $result['onBoardTranportAllowanceTotal'] = $dr['onBoardTranportAllowanceTotal'];
            $result['surveyorCode'] = $dr['surveyorCode'];
            $result['surveyorName'] = $dr['surveyorName'];
            $result['surveyorTelephone'] = $dr['surveyorTelephone'];
            $result['complateJobNo'] = $dr['complateJobNo'];
            $result['distributedToLeader'] = $dr['distributedToLeader'];
            $result['reportWeek'] = $dr['reportWeek'];
            $result['surveyLocationCn'] = $dr['surveyLocationCn'];
            $result['direction'] = $dr['direction'];
            //是否开放工作
            $result['isOpen'] = '0';
            $result['applySurvId'] = '';
            $result['inputUserId'] = '';
            $sql = "SELECT * FROM {$conf['table']['prefix']}MainScheduleOpen WHERE delFlag='no' AND jobNoNew='{$data['jobNoNew']}' LIMIT 1";
            $this->db->query($sql);
            if ($drOpen = $this->db->next_record()) {
                $result['isOpen'] = '1';
                $result['applySurvId'] = $drOpen['applySurvId'];
                $result['inputUserId'] = $drOpen['inputUserId'];

            }
        }
        return $result;
    }

    /***
     * 根据jobNo获取信息
     * @param $data
     * @return array
     */
    function getInfoByJobNo($data) {
        global $conf;
        $result = array();
        $sql = "SELECT * FROM {$conf['table']['prefix']}MainSchedule WHERE jobNo='{$data}'";
        $this->db->query($sql);
        if ($dr = $this->db->next_record()) {
            $result['mascId'] = $dr['mascId'];
            $result['weekNo'] = $dr['weekNo'];
            $result['jobNoShort'] = $dr['jobNoShort'];
            $result['jobNo'] = $dr['jobNo'];
            $result['jobNoNew'] = $dr['jobNoNew'];
            $result['plannedSurveyDate'] = $dr['plannedSurveyDate'];
            $result['tdFileNo'] = $dr['tdFileNo'];
            $result['receivedDate'] = $dr['receivedDate'];
            $result['dueDate'] = $dr['dueDate'];
            $result['fromTD'] = $dr['fromTD'];
            $result['actualSurveyDate'] = $dr['actualSurveyDate'];
            $result['startTime_1'] = $dr['startTime_1'];
            $result['endTime_1'] = $dr['endTime_1'];
            $result['startTime_2'] = $dr['startTime_2'];
            $result['endTime_2'] = $dr['endTime_2'];
            $result['startTime_3'] = $dr['startTime_3'];
            $result['endTime_3'] = $dr['endTime_3'];
            $result['startTime_4'] = $dr['startTime_4'];
            $result['endTime_4'] = $dr['endTime_4'];
            $result['totalHours'] = $dr['totalHours'];
            $result['surveyTimeHours'] = $dr['surveyTimeHours'];
            $result['stCode'] = $dr['stCode'];
            $result['surveyType'] = $dr['surveyType'];
            $result['vehCode'] = $dr['vehCode'];
            $result['vehicle'] = $dr['vehicle'];
            $result['isHoliday'] = $dr['isHoliday'];
            $result['bonusHours'] = $dr['bonusHours'];
            $result['surveyLocationDistrict'] = $dr['surveyLocationDistrict'];
            $result['surveyLocation'] = $dr['surveyLocation'];
            $result['routeItems'] = $dr['routeItems'];
            $result['noOfSurveyors'] = $dr['noOfSurveyors'];
            $result['estimatedManHour'] = $dr['estimatedManHour'];
            $result['receiveDate'] = $dr['receiveDate'];
            $result['dataInputNo'] = $dr['dataInputNo'];
            $result['dataInputBy'] = $dr['dataInputBy'];
            $result['entryFormTypeNo'] = $dr['entryFormTypeNo'];
            $result['noOfPages'] = $dr['noOfPages'];
            $result['report'] = $dr['report'];
            $result['hourlyRate'] = $dr['hourlyRate'];
            $result['surveyFinding'] = $dr['surveyFinding'];
            $result['am'] = $dr['am'];
            $result['periodHour_1'] = $dr['periodHour_1'];
            $result['periodWagesHr_1'] = $dr['periodWagesHr_1'];
            $result['periodHour_2'] = $dr['periodHour_2'];
            $result['periodWagesHr_2'] = $dr['periodWagesHr_2'];
            $result['totalWages'] = $dr['totalWages'];
            $result['onBoardCostFare'] = $dr['onBoardCostFare'];
            $result['noOfTrips'] = $dr['noOfTrips'];
            $result['transportAllowanceAm'] = $dr['transportAllowanceAm'];
            $result['transportAllowanceNoon'] = $dr['transportAllowanceNoon'];
            $result['transportAllowancePm'] = $dr['transportAllowancePm'];
            $result['transportAllowanceOvernight'] = $dr['transportAllowanceOvernight'];
            $result['taTotal'] = $dr['taTotal'];
            $result['wagesTaOnBoard'] = $dr['wagesTaOnBoard'];
            $result['onBoardTranportAllowanceTotal'] = $dr['onBoardTranportAllowanceTotal'];
            $result['surveyorCode'] = $dr['surveyorCode'];
            $result['surveyorName'] = $dr['surveyorName'];
            $result['surveyorTelephone'] = $dr['surveyorTelephone'];
            $result['complateJobNo'] = $dr['complateJobNo'];
            $result['distributedToLeader'] = $dr['distributedToLeader'];
            $result['reportWeek'] = $dr['reportWeek'];
            $result['surveyLocationCn'] = $dr['surveyLocationCn'];
            $result['direction'] = $dr['direction'];
            //是否开放工作
            $result['isOpen'] = '0';
            $result['applySurvId'] = '';
            $result['inputUserId'] = '';
            $sql = "SELECT * FROM {$conf['table']['prefix']}MainScheduleOpen WHERE delFlag='no' AND jobNoNew like' {$data}%'";
            $this->db->query($sql);
            if ($drOpen = $this->db->next_record()) {
                $result['isOpen'] = '1';
                $result['applySurvId'] = $drOpen['applySurvId'];
                $result['inputUserId'] = $drOpen['inputUserId'];

            }
        }
        return $result;
    }

    function save($data) {
        global $conf;
        $sql = makeSql($data, 'insert');
        $sql = "INSERT INTO {$conf['table']['prefix']}MainSchedule {$sql}";
        $this->db->query($sql);
//		 echo $sql."<br />";
        return $this->db->last_insert_id();
    }

    function update($data, $mascId) {
        global $conf;
        $sql = makeSql($data, 'update');
        $sql = "UPDATE {$conf['table']['prefix']}MainSchedule SET {$sql} WHERE mascId={$mascId}";
        $this->db->query($sql);
//        echo $sql."<br />";
    }

    function updateByJobNo($data, $jobNo) {
        global $conf;
        $sql = makeSql($data, 'update');
        $sql = "UPDATE {$conf['table']['prefix']}MainSchedule SET {$sql} WHERE jobNo='{$jobNo}'";
        $this->db->query($sql);
//        echo $sql."<br />";
    }

    function delete($mascId) {
        global $conf;

        $sql = "DELETE FROM {$conf['table']['prefix']}MainSchedule WHERE mascId={$mascId}";
        $this->db->query($sql);
//        echo $sql."<br />";
    }

    function getList2($filter, $other = '', $limit = '', $is_goods = false) {
        global $conf;
        $where = makeSql($filter, 'where');
        $sql = "SELECT s1.jobNo,s1.class_record_id,s1.jobNoNew,s1.realClass,MIN(surveyType) AS surveyType,MIN(vehicle) AS vehicle
                    ,MIN(surveyTimeHours) AS surveyTimeHours,MIN(startTime_1) AS startTime,MIN(endTime_1) AS endTime,surveyLocationDistrict
                    ,MIN(surveyLocation) AS surveyLocation,MIN(plannedSurveyDate) AS plannedSurveyDate,s2.isOpen2,s3.isOpen,s1.bookLat,s1.bookLong,s1.map_address,s1.diy_name,s1.diy_value,s1.`img_url`,s1.`is_image`
                FROM {$conf['table']['prefix']}MainSchedule as s1
left join (SELECT count(*) as isOpen2,jobNoNew FROM Survey_MainScheduleOpen where delFlag='no' group by jobNoNew) as s2 on s2.jobNoNew=s1.jobNoNew
left join (SELECT count(*) as isOpen,jobNo FROM Survey_SurveyJobOpen where delFlag='no' group by jobNo) as s3 on s3.jobNo=s1.jobNo
                WHERE 1=1 {$where}";
        if ($is_goods) {
            $sql .= " AND s1.is_image='1' ";
        }
        $sql .= "GROUP BY jobNo,vehicle {$other} {$limit}";
        $this->db->query($sql);
//		 echo $sql."<br />";
//		 exit();
        $result = array();
        $jobNoArray = array();
        $index = 0;
        $jobNoIndex = array();
        while ($dr = $this->db->next_record()) {
            $row = array();
            $jobNoArray[] = "'" . $dr['jobNo'] . "'";
            $row['jobNoNew'] = $dr['jobNoNew'];
            $row['jobNo'] = $dr['jobNo'];
            $row['surveyType'] = $dr['surveyType'];
            $row['vehicle'][] = $dr['vehicle'];
            $row['surveyLocation'] = $dr['surveyLocation'];

            $row['plannedSurveyDate'] = $dr['plannedSurveyDate'];
            $row['surveyLocationDistrict'] = $dr['surveyLocationDistrict'];
            $row['surveyTimeHours'] = $dr['surveyTimeHours'];
            $row['signNumbers'] = 0;
            $row['startTime'] = date('H:i', strtotime(date('Y-m-d') . $dr['startTime']));
            $row['endTime'] = date('H:i', strtotime(date('Y-m-d') . $dr['endTime']));
            $row['isOpen'] = $dr['isOpen'] == 1 ? 'yes' : 'no';
            $row['isOpen2'] = $dr['isOpen2'] == 1 ? 'yes' : 'no';
            $row['realClass'] = $dr['realClass'];
            $row['bookLong'] = $dr['bookLong'];
            $row['bookLat'] = $dr['bookLat'];
            $row['map_address'] = $dr['map_address'];
            $row['diy_name'] = $dr['diy_name'];
            $row['diy_value'] = $dr['diy_value'];
            $row['class_record_id'] = $dr['class_record_id'];
            $row['is_image'] = $dr['is_image'];
            if (empty($dr['img_url'])) {
                $row['img_url'] = "";
            } else {
                $row['img_url'] = $dr['img_url'];
            }


            if (!array_key_exists($dr['jobNo'], $jobNoIndex)) {
                $jobNoIndex[$dr['jobNo']] = $index;
                $result[$index] = $row;
                $index++;
            } else {
                $vehicle1 = $result[$jobNoIndex[$dr['jobNo']]]['vehicle'][0];
                $result[$jobNoIndex[$dr['jobNo']]]['vehicle'] = array();
                $result[$jobNoIndex[$dr['jobNo']]]['vehicle'][] = $vehicle1;
                $result[$jobNoIndex[$dr['jobNo']]]['vehicle'][] = $dr['vehicle'];
            }
        }
        if (count($jobNoArray) > 0) {
            $jobNoStr = implode(',', $jobNoArray);
            $sql = "SELECT jobNo,COUNT(*) AS signNumbers
                    FROM Survey_MainSchedule m
                    INNER JOIN Survey_SurveyPart sp ON sp.refNo = m.jobNoNew AND sp.delFlag='no'
                    WHERE m.jobNo IN ({$jobNoStr})
                    GROUP BY jobNo";
            $this->db->query($sql);
            while ($dr = $this->db->next_record()) {
                $index = $jobNoIndex[$dr['jobNo']];
                $result[$index]['signNumbers'] = $dr['signNumbers'];
            }
        }
        return $result;
    }

    function getList($filter, $other = '', $limit = '') {
        global $conf;
        $where = makeSql($filter, 'where');
        $sql = "SELECT jobNo,s1.jobNoNew,MIN(surveyType) AS surveyType,MIN(vehicle) AS vehicle
                    ,MIN(surveyTimeHours) AS surveyTimeHours,MIN(startTime_1) AS startTime,MIN(endTime_1) AS endTime,surveyLocationDistrict
                    ,MIN(surveyLocation) AS surveyLocation,MIN(plannedSurveyDate) AS plannedSurveyDate,s2.isOpen2
                FROM {$conf['table']['prefix']}MainSchedule as s1
left join (SELECT count(*) as isOpen2,jobNoNew FROM Survey_MainScheduleOpen where delFlag='no' group by jobNoNew) as s2 on s2.jobNoNew=s1.jobNoNew
                WHERE 1=1 {$where}
            GROUP BY jobNo
            {$other} {$limit}";
        $this->db->query($sql);
//		 echo $sql."<br />";
        $result = array();
        $jobNoArray = array();
        $index = 0;
        $jobNoIndex = array();
        while ($dr = $this->db->next_record()) {
            $row = array();
            $jobNoArray[] = "'" . $dr['jobNo'] . "'";
            $row['jobNoNew'] = $dr['jobNoNew'];
            $row['jobNo'] = $dr['jobNo'];
            $row['surveyType'] = $dr['surveyType'];
            $row['vehicle'] = $dr['vehicle'];
            $row['surveyLocation'] = $dr['surveyLocation'];

            $row['plannedSurveyDate'] = $dr['plannedSurveyDate'];
            $row['surveyLocationDistrict'] = $dr['surveyLocationDistrict'];
            $row['surveyTimeHours'] = $dr['surveyTimeHours'];
            $row['signNumbers'] = 0;
            $row['startTime'] = date('H:i', strtotime(date('Y-m-d') . $dr['startTime']));
            $row['endTime'] = date('H:i', strtotime(date('Y-m-d') . $dr['endTime']));
            $row['isOpen'] = 'no';
            $row['isOpen2'] = $dr['isOpen2'] == 1 ? 'yes' : 'no';

            $jobNoIndex[$dr['jobNo']] = $index;
            $result[$index] = $row;
            $index++;
        }

        if (count($jobNoArray) > 0) {
            $jobNoStr = implode(',', $jobNoArray);
            $sql = "SELECT jobNo,COUNT(*) AS signNumbers
                    FROM Survey_MainSchedule m
                    INNER JOIN Survey_SurveyPart sp ON sp.refNo = m.jobNoNew AND sp.delFlag='no'
                    WHERE m.jobNo IN ({$jobNoStr})
                    GROUP BY jobNo";
            $this->db->query($sql);
            while ($dr = $this->db->next_record()) {
                $index = $jobNoIndex[$dr['jobNo']];
                $result[$index]['signNumbers'] = $dr['signNumbers'];
            }
            $sql = "SELECT jobNo,isOpen FROM Survey_SurveyJobOpen WHERE delFlag='no' AND jobNo IN ({$jobNoStr}) ";
            $this->db->query($sql);
            while ($dr = $this->db->next_record()) {
                $index = $jobNoIndex[$dr['jobNo']];
                $result[$index]['isOpen'] = $dr['isOpen'];
            }
        }
        return $result;
    }

    function getJobNoNewList($filter, $other = '', $limit = '') {
        global $conf;
        $where = makeSql($filter, 'where', 'm');
        if (!empty($where)) {
            $where = 'AND ' . $where;
        }
        $sql = "SELECT m.*,s.chiName,s.profilePhoto FROM {$conf['table']['prefix']}MainSchedule m
                LEFT JOIN {$conf['table']['prefix']}Surveyor s ON s.survId = m.surveyorCode
                WHERE 1=1 {$where}
            {$other} {$limit}  ORDER BY m.vehicle,s.survId";
        $this->db->query($sql);
//		 echo $sql."<br />";
        $result = array();
        while ($dr = $this->db->next_record()) {
            if (!empty($dr['profilePhoto'])) {
                $dr['profilePhoto'] = 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . $dr['profilePhoto'];
            }
            $row = array();
            $row['jobNo'] = $dr['jobNo'];
            $row['mascId'] = $dr['mascId'];
            $row['jobNoNew'] = $dr['jobNoNew'];
            //$row['plannedSurveyDate'] = $dr['plannedSurveyDate'];
            //$row['surveyTimeHours'] = $dr['surveyTimeHours'];
            //$row['surveyType'] = $dr['surveyType'];
            $row['surveyorCode'] = $dr['surveyorCode'];
            $row['surveyorName'] = $dr['surveyorName'];
            $row['surveyorChiName'] = $dr['chiName'];
            $row['surveyorProfilePhoto'] = $dr['profilePhoto'];
            $row['class_record_id'] = $dr['class_record_id'];
            $row['vehicle'] = $dr['vehicle'];
            //$row['surveyorTelephone'] = $dr['surveyorTelephone'];
            $result[] = $row;
        }
        return $result;
    }


    /**
     * 管理员设置学员状态（已到，缺席，迟到，替代者，病假）
     * @param $data
     */
    function setDataEntryNew($data){
        global $conf;
        $signJobInfos = $data['signJobInfos'];
        $_tmpInfos = explode(',',$signJobInfos);
        $signInfos = array();
        foreach($_tmpInfos as $v){
            $signInfo = array();
            $_tmpInfo = explode('|',$v);
            $signInfo['jobNoNew'] = $_tmpInfo[0];
            $signInfo['surveyorCode'] = $_tmpInfo[1];
            $signInfos[] = $signInfo;
        }
        if(count($signInfos) <= 0){
            return false;
        }
        $inputTime = date("Y-m-d H:i:s");
        foreach($signInfos as $v){
            $newData = array();
            $newData['inputTime'] = $inputTime;
            $newData['userId'] = $data['survId'];
            $newData['userName'] = $data['engName'];
            $newData['refNo'] = $v['jobNoNew'];
            if(strtolower($v['jobNoNew']) == 'new'){
                //如果检测到是新job，则把最新没排期的加进来
                $sql = "SELECT m.jobNo,m.jobNoNew FROM {$conf['table']['prefix']}MainSchedule m
                     LEFT JOIN {$conf['table']['prefix']}SurveyPart sp ON sp.refNo = m.jobNoNew AND sp.delFlag='no'
                     WHERE m.jobNo = '{$data['jobNo']}'
                        AND m.surveyorCode<=0 AND sp.survId IS NULL
                     ORDER BY m.jobNoNew ASC
                     LIMIT 1";
                $this->db->query($sql);
                if($dr = $this->db->next_record()) {
                    $newData['refNo'] = $dr['jobNoNew'];
                }else{
                    //TODO 报名名额已经用完的情况
                }
            }
            $newData['survId'] = $v['surveyorCode'];
            $sql = "UPDATE {$conf['table']['prefix']}SurveyPart
                    SET delFlag='yes',modifyUserId='{$data['survId']}'
                    ,modifyUserName='{$data['engName']}',modifyTime='{$inputTime}'
                    WHERE refNo='{$newData['refNo']}'";
            $this->db->query($sql);
            if(strtolower($newData['survId']) == 'delete'){
                continue;
            }
            $newData['status'] = $data['status'];
            $newData['status_mark'] = $data['status_mark'];

            $sql = makeSql($newData);
            $sql = "INSERT INTO {$conf['table']['prefix']}SurveyPart".$sql;
            $this->db->query($sql);
        }
        return true;
    }

    function setDataEntry($data) {
        global $conf;
        $signJobInfos = $data['signJobInfos'];
        $_tmpInfos = explode(',', $signJobInfos);
        $signInfos = array();
        foreach ($_tmpInfos as $v) {
            $signInfo = array();
            $_tmpInfo = explode('|', $v);
            $signInfo['jobNoNew'] = $_tmpInfo[0];
            $signInfo['surveyorCode'] = $_tmpInfo[1];
            $signInfos[] = $signInfo;
        }
        if (count($signInfos) <= 0) {
            return false;
        }
        $inputTime = date("Y-m-d H:i:s");
        foreach ($signInfos as $v) {
            $newData = array();
            $newData['inputTime'] = $inputTime;
            $newData['userId'] = $data['survId'];
            $newData['userName'] = $data['engName'];
            $newData['refNo'] = $v['jobNoNew'];
            if (strtolower($v['jobNoNew']) == 'new') {
                //如果检测到是新job，则把最新没排期的加进来
                $sql = "SELECT m.jobNo,m.jobNoNew FROM {$conf['table']['prefix']}MainSchedule m
                     LEFT JOIN {$conf['table']['prefix']}SurveyPart sp ON sp.refNo = m.jobNoNew AND sp.delFlag='no'
                     WHERE m.jobNo = '{$data['jobNo']}'
                        AND m.surveyorCode<=0 AND sp.survId IS NULL
                     ORDER BY m.jobNoNew ASC
                     LIMIT 1";
                $this->db->query($sql);
                if ($dr = $this->db->next_record()) {
                    $newData['refNo'] = $dr['jobNoNew'];
                } else {
                    //TODO 报名名额已经用完的情况
                }
            }
            $newData['survId'] = $v['surveyorCode'];
            $sql = "UPDATE {$conf['table']['prefix']}SurveyPart
                    SET delFlag='yes',modifyUserId='{$data['survId']}'
                    ,modifyUserName='{$data['engName']}',modifyTime='{$inputTime}'
                    WHERE refNo='{$newData['refNo']}'";
            $this->db->query($sql);
            if (strtolower($newData['survId']) == 'delete') {
                continue;
            }
            $sql = makeSql($newData);
            $sql = "INSERT INTO {$conf['table']['prefix']}SurveyPart" . $sql;
            $this->db->query($sql);
        }
        return true;
    }

    function getFamilysInJob($jobNo, $phone) {
        $familys = array();


        $sql = "SELECT m.jobNo,m.jobNoNew,m.plannedSurveyDate,m.surveyTimeHours,
                m.surveyType,m.surveyorCode,m.surveyorName,m.surveyorTelephone,
                s.chiName as surveyorChiName,s.profilePhoto,
                s.survId,s.engName,s.contact
                FROM Survey_MainSchedule m 
                LEFT JOIN Survey_Surveyor s on s.survId = m.surveyorCode
                WHERE jobNo = '{$jobNo}' and surveyorTelephone like '{$phone}%'";

        /*$sql = "SELECT m.jobNo,m.jobNoNew,m.plannedSurveyDate,m.surveyTimeHours,
                m.surveyType,m.surveyorCode,m.surveyorName,m.surveyorTelephone,
                s.chiName as surveyorChiName,s.profilePhoto,
                s.survId,s.engName,s.contact
                FROM Survey_MainSchedule m
                LEFT JOIN Survey_SurveyPart sp  ON sp.refNo = m.jobNoNew AND sp.delFlag='no'
                LEFT JOIN Survey_Surveyor s on s.survId = sp.survId
                WHERE jobNo = '{$jobNo}' and surveyorTelephone like '{$phone}%'";*/

        $this->db->query($sql);

        while ($dr = $this->db->next_record()) {
            $tmp = array();
            $tmp['jobNo'] = $dr['jobNo'];
            $tmp['jobNoNew'] = $dr['jobNoNew'];
            $tmp['plannedSurveyDate'] = $dr['plannedSurveyDate'];
            $tmp['surveyTimeHours'] = $dr['surveyTimeHours'];
            $tmp['surveyType'] = $dr['surveyType'];
            $tmp['surveyorCode'] = $dr['surveyorCode'];
            $tmp['surveyorChiName'] = $dr['surveyorChiName'];
            $tmp['surveyorName'] = $dr['surveyorName'];
            $tmp['surveyorTelephone'] = $dr['surveyorTelephone'];
            $tmp['profilePhoto'] = !empty($dr['profilePhoto']) ? 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . $dr['profilePhoto'] : '';
            $tmp['survId'] = null;
            $tmp['chiName'] = null;
            $tmp['engName'] = null;
            $tmp['contact'] = null;
            $tmp['isOpen'] = 0;//TODO DELETE??
            $familys[] = $tmp;
        }
        foreach ($familys as $k => $one) {
            $sql2 = "SELECT refNo FROM  Survey_SurveyPart WHERE refNo = '{$one['jobNoNew']}' and delFlag = 'no' and survId = '{$one['surveyorCode']}'";
            $this->db->query($sql2);
            if ($checkIn = $this->db->next_record()) {
                $familys[$k]['survId'] = $one['surveyorCode'];
                $familys[$k]['chiName'] = $one['surveyorChiName'];
                $familys[$k]['engName'] = $one['surveyorName'];
                $familys[$k]['contact'] = $one['contact'];
            }
        }
        return $familys;
    }

    function getDataEntryList($filter, $other = '', $limit = '') {
        global $conf;
        $where = makeSql($filter, 'where', 'm');
        if (!empty($where)) {
            $where = 'AND ' . $where;
        }
        $sql = "SELECT m.jobNo,m.jobNoNew,m.class_record_id,m.plannedSurveyDate,m.surveyTimeHours,m.surveyType
                    ,m.surveyorCode,m.surveyorName,m.surveyorTelephone
                    ,s.survId,s.chiName,s.engName,s.contact,s.profilePhoto
                FROM {$conf['table']['prefix']}MainSchedule m
                LEFT JOIN {$conf['table']['prefix']}SurveyPart sp ON sp.refNo = m.jobNoNew AND sp.delFlag='no'
                LEFT JOIN {$conf['table']['prefix']}Surveyor s ON s.survId = sp.survId
                WHERE 1=1 {$where}
            {$other} {$limit}";
        $this->db->query($sql);
//		 echo $sql."<br />";
        $result = array();
        $noEnterSurveyors = array();
        while ($dr = $this->db->next_record()) {
            if (empty($dr['survId']) && !empty($dr['surveyorCode'])) {
                $noEnterSurveyors[] = $dr['surveyorCode'];
            }
            $row = array();
            $row['jobNo'] = $dr['jobNo'];
            $row['jobNoNew'] = $dr['jobNoNew'];
            $row['plannedSurveyDate'] = $dr['plannedSurveyDate'];
            $row['surveyTimeHours'] = $dr['surveyTimeHours'];
            $row['surveyType'] = $dr['surveyType'];
            $row['surveyorCode'] = $dr['surveyorCode'];
            $row['surveyorChiName'] = $dr['chiName'];
            $row['surveyorName'] = $dr['surveyorName'];
            $row['surveyorTelephone'] = $dr['surveyorTelephone'];
            $row['survId'] = $dr['survId'];
            $row['chiName'] = $dr['chiName'];
            $row['engName'] = $dr['engName'];
            $row['contact'] = $dr['contact'];
            $row['profilePhoto'] = !empty($dr['profilePhoto']) ? 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . $dr['profilePhoto'] : '';
            $row['isOpen'] = '';
            $row['class_record_id'] = $dr['class_record_id'];
            $row['status'] = $dr['status'];
            $row['status_mark'] = $dr['status_mark'];
            $result[] = $row;
        }
        if (count($noEnterSurveyors) > 0) {
            //加上未点名的中文名，头像
            $where = "AND survId IN (" . implode(',', $noEnterSurveyors) . ")";
            $sql = "SELECT survId,chiName,engName,contact,profilePhoto
                FROM {$conf['table']['prefix']}Surveyor
                WHERE 1=1 {$where}";
            $this->db->query($sql);
//            echo $sql."<br />";
            $noEnterSurveyorArray = array();
            while ($dr = $this->db->next_record()) {
                $noEnterSurveyorArray[$dr['survId']]['chiName'] = $dr['chiName'];
                $noEnterSurveyorArray[$dr['survId']]['engName'] = $dr['engName'];
                $noEnterSurveyorArray[$dr['survId']]['contact'] = $dr['contact'];
                $noEnterSurveyorArray[$dr['survId']]['profilePhoto'] = $dr['profilePhoto'];
            }
            foreach ($result as $k => $v) {
                if (empty($v['survId']) && !empty($v['surveyorCode'])) {
                    $surveyorCode = $v['surveyorCode'];
                    $v['surveyorChiName'] = $noEnterSurveyorArray[$surveyorCode]['chiName'];
                    $v['profilePhoto'] = !empty($noEnterSurveyorArray[$surveyorCode]['profilePhoto']) ? 'http://' . $_SERVER['SERVER_NAME'] . '/' . PROJECTNAME . $noEnterSurveyorArray[$surveyorCode]['profilePhoto'] : '';
                }
                /*if(!empty($v['profilePhoto'])){
                    if(strpos($v['profilePhoto'],'http') !== false){
                        $v['profilePhoto'] = "http://www.ozzotec.com/".PROJECTNAME.$v['profilePhoto'];
                    }
                }*/
                $result[$k] = $v;
            }
        }
        return $result;
    }

    /**
     * @param $case 参数为1是，获取开放的物品资料，参数为2时，获取指定物品ID资料，参数3时获取已购买物品资料
     * @param null $jobNoShort 当参数1等于2时，此参数代表指定的物品ID。当参数1等于3是,此参数代表用户id
     * @param null $userId 用户id;
     * @return false|string
     */
    function getGoodsUrl($case, $jobNoShort = null, $userId = null) {
        global $conf;
        switch ($case) {
            case 1:
                $sql = "SELECT
    `jobNoShort`,
    min(`jobNoNew`) as `jobNoNew`,
    `img_url`,
    `surveyType`,
    `vehicle`
FROM
    Survey_MainSchedule
WHERE
    1 = 1 AND jobNoNew NOT LIKE '%ss' AND jobNoNew NOT LIKE '%tt' AND jobNoNew NOT LIKE '%uu' AND jobNoNew IN(
    SELECT
        `jobNoNew`
    FROM
        Survey_MainScheduleOpen
    WHERE
        delFlag = 'no' AND applySurvId = 0 
) AND is_image = 1 AND `surveyorCode` = '' AND `surveyorName` = '' AND `surveyorTelephone` = ''
GROUP BY `jobNoShort` ASC";
                break;
            case 2:
                $sql = "SELECT
    `jobNoNew`,
    `jobNoShort`,
    `vehicle`,
    `img_url`,
    `surveyType`,
    (SELECT COUNT(*) FROM Survey_MainSchedule WHERE `jobNoShort` = '{$jobNoShort}') as 'total',
    (SELECT COUNT(*) FROM Survey_MainSchedule WHERE `jobNoShort` = '{$jobNoShort}' AND `surveyorCode` = '' AND `surveyorName` = '' AND `surveyorTelephone` = '') as 'surplus'
FROM
    Survey_MainSchedule
WHERE
        `jobNoShort` = '{$jobNoShort}' AND `surveyorCode` = '' AND `surveyorName` = '' AND `surveyorTelephone` = ''
    GROUP BY
        `jobNoNew`
    LIMIT 1
";
                break;
            case 3:
                $sql = "SELECT
    `jobNo`,
    `jobNoNew`
FROM
      `Survey_MainSchedule`
WHERE
    `jobNo` = '{$jobNoShort}' AND `surveyorCode` = '{$userId}'
                ";
                break;
        }

        $datas = $this->db->query($sql);
        while ($data = mysqli_fetch_assoc($datas)) {
            $arr[] = $data;
        }
        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

<<<<<<< HEAD
    /**广告图Url 存储和获取
     * @param $case
     * @param $arr
     * @return array
     */
    function advImage($case, $arr=null) {
        global $conf;
        switch ($case) {
            case 1:
                $setSql = "SELECT `id` FROM `Survey_AdvImage` WHERE `rate`='{$arr['rate']}' AND `ranking`='{$arr['ranking']}' AND `start`=1";
                $info = $this->db->query($setSql);
                $result = mysqli_fetch_array($info);
                if (!empty($result)) {
                    $id = $result['id'];
                    $upeSql = "UPDATE `Survey_AdvImage` SET `start`=0 WHERE `id`='{$id}'";
                    $this->db->query($upeSql);
                }
                $sql = "INSERT INTO `Survey_AdvImage`(`path`,`condense_path`,`file_name`,`resolution`,`rate`,`ranking`,`upload_time`,`start`) 
                VALUES ('{$arr['path']}','{$arr['condense_path']}','{$arr['file_name']}','{$arr['resolution']}','{$arr['rate']}','{$arr['ranking']}','{$arr['upload_time']}','{$arr['start']}')";

                $judge = $this->db->query($sql);

                return $judge;
                break;
            case 2:
                $sql="SELECT `resolution`,`file_name`,`path` FROM `Survey_AdvImage` WHERE `rate`='{$arr['rate']}'  AND `start`=1 GROUP BY `ranking`";
                $datas=$this->db->query($sql);
                while ($data = mysqli_fetch_assoc($datas)) {
                    $arrs[] =$data;
                }
                if (!empty($arrs)) {
                    $infoArr=array(
                        'status'=>'success',
                        'msg'=>'',
                        'data'=>$arrs
                    );
                }else{
                    $infoArr=array(
                        'status'=>'failed',
                        'data'=>''
                    );
                }
                return $infoArr;
                break;
            case 3:
                $sql="SELECT `file_name` FROM `Survey_AdvImage` WHERE `start`=1 AND `rate`='9:16'";
                $datas=$this->db->query($sql);
                while ($data = mysqli_fetch_assoc($datas)) {
                    $arrs[] =$data;
                }
                if (!empty($arrs)) {
                    $infoArr=array(
                        'status'=>'success',
                        'msg'=>'',
                        'data'=>$arrs
                    );
                }else {
                    $infoArr = array(
                        'status' => 'failed',
                        'data' => ''
                    );
                }
                return $infoArr;
                break;
            case 4:
                $sql="SELECT `condense_path` FROM `Survey_AdvImage` WHERE `ranking`='{$arr['ranking']}' AND `start`=1";
                $urlArr=$this->db->query($sql);
                while ( $url = mysqli_fetch_assoc($urlArr)) {
                    $urls[] = $url;
                }
                if (!empty($urls)) {
                    $urlInfo=array(
                        'status'=>'success',
                        'msg'=>'',
                        'data'=>$urls
                    );
                }else{
                    $urlInfo=array(
                        'status'=>'failed',
                        'data'=>''
                    );
                }
                return $urlInfo;
                break;
        }
    }
}

=======
    function advImage($case,$arr){
        global $conf;
        switch ($case){
            case 1:
                $sql="INSERT INTO `Survey_AdvImage`(`path`,`file_name`,`resolution`,`rate`) VALUES ('{$arr['path']}','{$arr['file_name']}','{$arr['resolution']}','{$arr['rate']}')";
                $this->db->query($sql);
        }
    }
}
>>>>>>> bdb0a73f25fcf3f28b28b3cfd0044c90fd988b1c
