<?php

/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */

class SurveyDetailList
{
    var $db;
    var $sudeId;
    var $supaId;
    var $supaIds;
    var $displayBoard;
    var $skippedStop;
    var $regplateNo;
    var $fleetNo;
    var $pslNo;
    var $arrivalTime;
    var $departureTime;
    var $onArrival = 0;
    var $setDown = 0;
    var $pickup = 0;
    var $onDept = 0;
    var $leftBehind = 0;
    var $userId = 0;
    var $userName;
    var $inputTime;
    var $modifyTime;
    var $modifyUserId = 0;
    var $modifyUserName;
    var $delFlag = 'no';
    var $leftRoleFlag = 'no';
    var $order = " ORDER BY departureTime ASC,arrivalTime ASC ";
    var $butyId;
    var $limit;

    function SurveyDetailList($db)
    {
        $this->db = $db;
    }

    function GetListSearch()
    {
        if ($this->supaId != "")
            $query .= "AND supaId = " . $this->supaId;
        if ($this->order != "")
            $query .= $this->order;

        $rows = array();
        $sql = "SELECT * FROM  Survey_SurveyDetail WHERE 1=1 ";
        $sql = $sql . $query;
//        echo $sql;
        $this->db->query($sql);
        while ($rs = $this->db->next_record()) {
            $sd = new SurveyDetail ($this->db);
            $sd->sudeId = $rs ['sudeId'];
            $sd->supaId = $rs ['supaId'];
            $sd->displayBoard = $rs ['displayBoard'];
            $sd->skippedStop = $rs ['skippedStop'];
            $sd->regplateNo = $rs ['regplateNo'];
            $sd->fleetNo = strtoupper($rs['fleetNo']);
            $sd->pslNo = $rs ['pslNo'];
            $sd->arrivalTime = $rs ['arrivalTime'];
            $sd->departureTime = $rs ['departureTime'];
            $sd->onArrival = $rs ['onArrival'];
            $sd->setDown = $rs ['setDown'];
            $sd->pickup = $rs ['pickup'];
            $sd->onDept = $rs ['onDept'];
            $sd->leftBehind = $rs ['leftBehind'];
            $sd->userId = $rs ['userId'];
            $sd->userName = $rs ['userName'];
            $sd->inputTime = $rs ['inputTime'];
            $sd->modifyTime = $rs ['modifyTime'];
            $sd->modifyUserId = $rs ['modifyUserId'];
            $sd->modifyUserName = $rs ['modifyUserName'];
            $sd->delFlag = $rs ['delFlag'];
            $sd->leftRoleFlag = $rs ['leftRoleFlag'];
            $rows [] = $sd;
        }
        return $rows;
    }

    /**
     * 搜索结果总记录数
     */
    function GetListSearchCount()
    {
        if ($this->supaId != "")
            $query .= "AND supaId = " . $this->supaId;
        if ($this->supaIds != "")
            $query .= "AND supaId IN(" . $this->supaIds . ")";
        if ($this->order != "")
            $query .= $this->order;

        $rows = array();
        $sql = "SELECT COUNT(*) as totalNum FROM  Survey_SurveyDetail WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        // print $sql;
        if ($rs = $this->db->next_record()) {
            return $rs ['totalNum'];
        }
        return 0;
    }

    /**
     * 得到车牌号的状态
     */
    function GetFleetNoStatListSearch()
    {
        $query = "";
        $subQuery = "";
        $initQuery = "";
        if ($this->supaId != "")
            $query .= " AND SD.supaId = " . $this->supaId;

        if ($this->order != "")
            $query .= $this->order;

        if ($this->butyId != "") {
            $subQuery .= " AND R.butyId = " . $this->butyId;
            // 如果選擇了巴士類型,才將數據輸入進來;
            $initQuery = ",(SELECT R.regiId FROM Survey_Registration R WHERE (R.plateNo=SD.fleetNo OR R.fleetNo=SD.fleetNo) {$subQuery} LIMIT 1) AS regiId
					,(SELECT aId FROM Survey_Across A WHERE (A.plateNo=SD.fleetNo OR A.fleetNo=SD.fleetNo) LIMIT 1) AS aId
					";
        }

        $rows = array();
        $sql = "SELECT SD.*
					{$initQuery}
					FROM  Survey_SurveyDetail SD
				    WHERE 1=1 ";
        $sql = $sql . $query;
        // print $sql;
        $this->db->query($sql);
        while ($rs = $this->db->next_record()) {
            $sd = new SurveyDetail ($this->db);
            $sd->sudeId = $rs ['sudeId'];
            $sd->supaId = $rs ['supaId'];
            $sd->displayBoard = $rs ['displayBoard'];
            $sd->skippedStop = $rs ['skippedStop'];
            $sd->regplateNo = $rs ['regplateNo'];
            $sd->fleetNo = strtoupper($rs['fleetNo']);
            $sd->pslNo = $rs ['pslNo'];
            $sd->arrivalTime = $rs ['arrivalTime'];
            $sd->departureTime = $rs ['departureTime'];
            $sd->onArrival = $rs ['onArrival'];
            $sd->setDown = $rs ['setDown'];
            $sd->pickup = $rs ['pickup'];
            $sd->onDept = $rs ['onDept'];
            $sd->leftBehind = $rs ['leftBehind'];
            $sd->userId = $rs ['userId'];
            $sd->userName = $rs ['userName'];
            $sd->inputTime = $rs ['inputTime'];
            $sd->modifyTime = $rs ['modifyTime'];
            $sd->modifyUserId = $rs ['modifyUserId'];
            $sd->modifyUserName = $rs ['modifyUserName'];
            $sd->delFlag = $rs ['delFlag'];
            $sd->leftRoleFlag = $rs ['leftRoleFlag'];
            $sd->routeItem = $rs ['routeItem'];
            $sd->remarks = $rs ['remarks'];
            $sd->regiId = $rs ['regiId'];
            $sd->aId = $rs ['aId'];
            $rows [] = $sd;
        }
        return $rows;
    }

    /**
     * 得到参考历史记录
     */
    function GetCacpcityHistory()
    {
        if ($this->supaId != "")
            $query .= "AND supaId = " . $this->supaId;
        if ($this->fleetNo != "")
            $query .= "AND fleetNo = '" . $this->fleetNo . "'";
        if ($this->order != "")
            $query .= $this->order;
        if ($this->limit != "")
            $query .= " LIMIT " . $this->limit;

        $rows = array();
        $sql = "SELECT DISTINCT fleetNo,pslNo" . " FROM  Survey_SurveyDetail WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        while ($rs = $this->db->next_record()) {
            $sd = new SurveyDetail ($this->db);
            $sd->fleetNo = strtoupper($rs['fleetNo']);
            $sd->pslNo = $rs ['pslNo'];
            $rows [] = $sd;
        }

        $query = "";
        if ($this->supaId != "")
            $query .= "AND supaId = " . $this->supaId;
        if ($this->fleetNo != "")
            $query .= "AND fleetNo = '" . $this->fleetNo . "'";
        if ($this->limit != "")
            $query .= " LIMIT " . $this->limit;

        $sql = "SELECT DISTINCT fleetNo,pslNo" . " FROM  Survey_SurveyDetailLastYear WHERE 1=1 ";
        $sql = $sql . $query;
        $this->db->query($sql);
        while ($rs = $this->db->next_record()) {
            $sd = new SurveyDetail ($this->db);
            $sd->fleetNo = strtoupper($rs['fleetNo']);
            $sd->pslNo = $rs ['pslNo'];
            $rows [] = $sd;
        }

        return $rows;
    }
}

?>
