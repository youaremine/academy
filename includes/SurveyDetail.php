<?php
/*
 * Header: Create: 2007-1-2 Auther: Jamblues.
 */
class SurveyDetail
{
	var $db;
	var $sudeId;
	var $supaId;
	var $supaIdNew;
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
	var $routeItem;
	var $remarks;
	var $userId = 0;
	var $userName;
	var $inputTime;
	var $modifyTime;
	var $modifyUserId = 0;
	var $modifyUserName;
	var $delFlag = 'no';
	var $leftRoleFlag = 'no';
	var $regiId; // 政府车牌数据
	var $aId; // 车牌网车牌数据
	function SurveyDetail($db)
	{
		$this->db = $db;
		$this->inputTime = date("Y-m-d H:i:s");
		$this->modifyTime = date("Y-m-d H:i:s");
	}
	function Save()
	{
		$sql = "INSERT INTO  Survey_SurveyDetail(supaId,displayBoard,skippedStop,regplateNo,fleetNo,pslNo,arrivalTime,departureTime
				,onArrival,setDown,pickup,onDept,leftBehind,inputTime,userId,userName,delFlag
				,leftRoleFlag,routeItem,remarks)
				 VALUES('{$this->supaId}','{$this->displayBoard}','{$this->skippedStop}','{$this->regplateNo}','{$this->fleetNo}','{$this->pslNo}','{$this->arrivalTime}','{$this->departureTime}'
				,'{$this->onArrival}','{$this->setDown}','{$this->pickup}','{$this->onDept}','{$this->leftBehind}','{$this->inputTime}','{$this->userId}','{$this->userName}','{$this->delFlag}'
				,'{$this->leftRoleFlag}','{$this->routeItem}','{$this->remarks}')";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}
	function Copy()
	{
		$sql = "INSERT INTO Survey_SurveyDetail(supaId,displayBoard,skippedStop,regplateNo,fleetNo,pslNo,arrivalTime,departureTime,onArrival,setDown,pickup,onDept,leftBehind,userId,userName,inputTime,leftRoleFlag,routeItem,remarks)
				SELECT " . $this->supaIdNew . ",displayBoard,skippedStop,regplateNo,fleetNo,pslNo,arrivalTime,departureTime,onArrival,setDown,pickup,onDept,leftBehind,userId,userName,inputTime,leftRoleFlag,routeItem,remarks
				FROM Survey_SurveyDetail
				WHERE supaId = " . $this->supaId;
		$this->db->query($sql);
		// return $this->db->last_insert_id();
	}
	function Modify()
	{
		$sql = "UPDATE  Survey_SurveyDetail " . "SET supaId = '" . $this->supaId . "'" . ",displayBoard = '" . $this->displayBoard . "'" . ",skippedStop = '" . $this->skippedStop . "'"
				. ",regplateNo = '" . $this->regplateNo . "'" . ",fleetNo = '" . $this->fleetNo . "'" . ",pslNo = '" . $this->pslNo . "'" . ",arrivalTime = '" . $this->arrivalTime . "'"
				. ",departureTime = '" . $this->departureTime . "'" . ",onArrival = '" . $this->onArrival . "'" . ",setDown = '" . $this->setDown . "'" . ",pickup = '" . $this->pickup . "'"
				. ",onDept = '" . $this->onDept . "'" . ",leftBehind = '" . $this->leftBehind . "'" . ",modifyTime = '" . $this->modifyTime . "'" . ",modifyUserId = '" . $this->modifyUserId . "'"
				. ",modifyUserName = '" . $this->modifyUserName . "'" . ",delFlag = '" . $this->delFlag . "'" . ",leftRoleFlag = '" . $this->leftRoleFlag . "'"
				. ",routeItem = '" . $this->routeItem . "'" . ",remarks = '" . $this->remarks . "'"
				. " WHERE sudeId = " . $this->sudeId;
		// echo $sql;exit();
		$this->db->query($sql);
	}
	function Del()
	{
		$sql = "UPDATE  Survey_SurveyDetail " . " SET delFlag = '" . $this->delFlag . "'" . " WHERE sudeId = " . $this->sudeId;
		$this->db->query($sql);
	}
	function RealDel()
	{
		$sql = "DELETE FROM Survey_SurveyDetail " . " WHERE sudeId = " . $this->sudeId;
		$this->db->query($sql);
	}
	
	/**
	 * 合并指定的资料
	 */
	function Merge()
	{
		if ($this->supaIds != "" && $this->supaId != "")
		{
			$rows = array();
			$sql = "INSERT INTO Survey_SurveyDetail(supaId,displayBoard,skippedStop,regplateNo,fleetNo,pslNo,arrivalTime,departureTime,onArrival,setDown,pickup,onDept,leftBehind,userId,userName,inputTime,modifyTime,modifyUserId,modifyUserName,leftRoleFlag,routeItem,remarks)
					  SELECT " . $this->supaId . ",displayBoard,skippedStop,regplateNo,fleetNo,pslNo,arrivalTime,departureTime,onArrival,setDown,pickup,onDept,leftBehind,userId,userName,inputTime,modifyTime,modifyUserId,modifyUserName,leftRoleFlag,routeItem,remarks
					    FROM Survey_SurveyDetail 
					    WHERE supaId IN (" . $this->supaIds . ")";
			// print $sql;
			$this->db->query($sql);
		}
	}
}
?>
