<?php
/*
 * Header: Create: 2008-08-10 Auther: Jamblues@gmail.com.
 */
class FlowMovementDetailTotalAccess {
	var $db;
	function FlowMovementDetailTotalAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_FlowMovementDetailTotal(moveId,movementChiName,startTime,endTime,TYPE1Quantity,TYPE2Quantity,TYPE3Quantity,TYPE4Quantity,TYPE5Quantity,TYPE6Quantity,TYPE7Quantity,TYPE8Quantity,TYPE9Quantity,TYPE10Quantity,TYPE11Quantity,TYPE12Quantity,TYPE13Quantity,TYPE14Quantity,TYPE15Quantity,TYPE16Quantity,TYPE17Quantity,TYPE18Quantity,TYPE19Quantity,TYPE20Quantity,TYPE21Quantity,TYPE22Quantity,TYPE23Quantity,TYPE24Quantity,TYPE25Quantity,totalHourPCUQuantity,totalPCUQuantity,delFlag)" . " VALUES('" . $obj->moveId . "'" . ",'" . $obj->movementChiName . "'" . ",'" . $obj->startTime . "'" . ",'" . $obj->endTime . "'" . ",'" . $obj->TYPE1Quantity . "'" . ",'" . $obj->TYPE2Quantity . "'" . ",'" . $obj->TYPE3Quantity . "'" . ",'" . $obj->TYPE4Quantity . "'" . ",'" . $obj->TYPE5Quantity . "'" . ",'" . $obj->TYPE6Quantity . "'" . ",'" . $obj->TYPE7Quantity . "'" . ",'" . $obj->TYPE8Quantity . "'" . ",'" . $obj->TYPE9Quantity . "'" . ",'" . $obj->TYPE10Quantity . "'" . ",'" . $obj->TYPE11Quantity . "'" . ",'" . $obj->TYPE12Quantity . "'" . ",'" . $obj->TYPE13Quantity . "'" . ",'" . $obj->TYPE14Quantity . "'" . ",'" . $obj->TYPE15Quantity . "'" . ",'" . $obj->TYPE16Quantity . "'" . ",'" . $obj->TYPE17Quantity . "'" . ",'" . $obj->TYPE18Quantity . "'" . ",'" . $obj->TYPE19Quantity . "'" . ",'" . $obj->TYPE20Quantity . "'" . ",'" . $obj->TYPE21Quantity . "'" . ",'" . $obj->TYPE22Quantity . "'" . ",'" . $obj->TYPE23Quantity . "'" . ",'" . $obj->TYPE24Quantity . "'" . ",'" . $obj->TYPE25Quantity . "'" . ",'" . $obj->totalHourPCUQuantity . "'" . ",'" . $obj->totalPCUQuantity . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_FlowMovementDetailTotal " . " SET moveId = '" . $obj->moveId . "'" . " ,movementChiName = '" . $obj->movementChiName . "'" . " ,startTime = '" . $obj->startTime . "'" . " ,endTime = '" . $obj->endTime . "'" . " ,TYPE1Quantity = '" . $obj->TYPE1Quantity . "'" . " ,TYPE2Quantity = '" . $obj->TYPE2Quantity . "'" . " ,TYPE3Quantity = '" . $obj->TYPE3Quantity . "'" . " ,TYPE4Quantity = '" . $obj->TYPE4Quantity . "'" . " ,TYPE5Quantity = '" . $obj->TYPE5Quantity . "'" . " ,TYPE6Quantity = '" . $obj->TYPE6Quantity . "'" . " ,TYPE7Quantity = '" . $obj->TYPE7Quantity . "'" . " ,TYPE8Quantity = '" . $obj->TYPE8Quantity . "'" . " ,TYPE9Quantity = '" . $obj->TYPE9Quantity . "'" . " ,TYPE10Quantity = '" . $obj->TYPE10Quantity . "'" . " ,TYPE11Quantity = '" . $obj->TYPE11Quantity . "'" . " ,TYPE12Quantity = '" . $obj->TYPE12Quantity . "'" . " ,TYPE13Quantity = '" . $obj->TYPE13Quantity . "'" . " ,TYPE14Quantity = '" . $obj->TYPE14Quantity . "'" . " ,TYPE15Quantity = '" . $obj->TYPE15Quantity . "'" . " ,TYPE16Quantity = '" . $obj->TYPE16Quantity . "'" . " ,TYPE17Quantity = '" . $obj->TYPE17Quantity . "'" . " ,TYPE18Quantity = '" . $obj->TYPE18Quantity . "'" . " ,TYPE19Quantity = '" . $obj->TYPE19Quantity . "'" . " ,TYPE20Quantity = '" . $obj->TYPE20Quantity . "'" . " ,TYPE21Quantity = '" . $obj->TYPE21Quantity . "'" . " ,TYPE22Quantity = '" . $obj->TYPE22Quantity . "'" . " ,TYPE23Quantity = '" . $obj->TYPE23Quantity . "'" . " ,TYPE24Quantity = '" . $obj->TYPE24Quantity . "'" . " ,TYPE25Quantity = '" . $obj->TYPE25Quantity . "'" . " ,totalPCUQuantity = '" . $obj->totalHourPCUQuantity . "'" . " ,totalPCUQuantity = '" . $obj->totalPCUQuantity . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND modeId = '" . $obj->modeId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_FlowMovementDetailTotal " . " SET delFlag='yes' " . " WHERE 1=1  AND modeId = '" . $obj->modeId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_FlowMovementDetailTotal " . " WHERE 1=1  AND modeId = '" . $obj->modeId . "'";
		$this->db->query ( $sql );
	}
	
	/**
	 * 清空旧数据
	 *
	 * @param
	 *        	$obj
	 */
	function EmptyData($obj) {
		$sql = "DELETE FROM Survey_FlowMovementDetailTotal " . " WHERE 1=1  AND moveId = '" . $obj->moveId . "'";
		$this->db->query ( $sql );
	}
	
	/**
	 * 计算总数
	 *
	 * @param
	 *        	$obj
	 */
	function CalculateTotal($obj) {
		// $sql = "DELETE FROM Survey_FlowMovementDetailTotal ".
		// " WHERE 1=1 AND moveId = '".$obj->moveId."'";
		$sql = "INSERT INTO Survey_FlowMovementDetailTotal(modeId, moveId,movementChiName, startTime, endTime, 
						TYPE1Quantity,
						TYPE2Quantity, 
						TYPE3Quantity, 
						TYPE4Quantity, 
						TYPE5Quantity, 
						TYPE6Quantity, 
						TYPE7Quantity, 
						TYPE8Quantity, 
						TYPE9Quantity, 
						TYPE10Quantity, 
						TYPE11Quantity, 
						TYPE12Quantity, 
						TYPE13Quantity, 
						TYPE14Quantity, 
						TYPE15Quantity, 
						TYPE16Quantity, 
						TYPE17Quantity, 
						TYPE18Quantity, 
						TYPE19Quantity, 
						TYPE20Quantity, 
						TYPE21Quantity, 
						TYPE22Quantity, 
						TYPE23Quantity, 
						TYPE24Quantity, 
						TYPE25Quantity, 
						totalPCUQuantity)
					SELECT  MD.modeId,MD.moveId, M.chiName AS movementChiName, MD.startTime, MD.endTime, 
						MD.TYPE1Quantity*PF.TYPE1Quantity AS TYPE1Quantity,
						MD.TYPE2Quantity*PF.TYPE2Quantity AS TYPE2Quantity, 
						MD.TYPE3Quantity*PF.TYPE3Quantity AS TYPE3Quantity, 
						MD.TYPE4Quantity*PF.TYPE4Quantity AS TYPE4Quantity, 
						MD.TYPE5Quantity*PF.TYPE5Quantity AS TYPE5Quantity, 
						MD.TYPE6Quantity*PF.TYPE6Quantity AS TYPE6Quantity, 
						MD.TYPE7Quantity*PF.TYPE7Quantity AS TYPE7Quantity, 
						MD.TYPE8Quantity*PF.TYPE8Quantity AS TYPE8Quantity, 
						MD.TYPE9Quantity*PF.TYPE9Quantity AS TYPE9Quantity, 
						MD.TYPE10Quantity*PF.TYPE10Quantity AS TYPE10Quantity, 
						MD.TYPE11Quantity*PF.TYPE11Quantity AS TYPE11Quantity, 
						MD.TYPE12Quantity*PF.TYPE12Quantity AS TYPE12Quantity, 
						MD.TYPE13Quantity*PF.TYPE13Quantity AS TYPE13Quantity, 
						MD.TYPE14Quantity*PF.TYPE14Quantity AS TYPE14Quantity, 
						MD.TYPE15Quantity*PF.TYPE15Quantity AS TYPE15Quantity, 
						MD.TYPE16Quantity*PF.TYPE16Quantity AS TYPE16Quantity, 
						MD.TYPE17Quantity*PF.TYPE17Quantity AS TYPE17Quantity, 
						MD.TYPE18Quantity*PF.TYPE18Quantity AS TYPE18Quantity, 
						MD.TYPE19Quantity*PF.TYPE19Quantity AS TYPE19Quantity, 
						MD.TYPE20Quantity*PF.TYPE20Quantity AS TYPE20Quantity, 
						MD.TYPE21Quantity*PF.TYPE21Quantity AS TYPE21Quantity, 
						MD.TYPE22Quantity*PF.TYPE22Quantity AS TYPE22Quantity, 
						MD.TYPE23Quantity*PF.TYPE23Quantity AS TYPE23Quantity, 
						MD.TYPE24Quantity*PF.TYPE24Quantity AS TYPE24Quantity, 
						MD.TYPE25Quantity*PF.TYPE25Quantity AS TYPE25Quantity,
						NULL AS totalPCUQuantity
						FROM Survey_FlowMovementDetail MD
						INNER JOIN Survey_FlowMovement M ON M.moveId = MD.moveId
						INNER JOIN Survey_FlowPcuFactor PF ON PF.pcfaId = M.pcfaId
						WHERE M.moveId = '" . $obj->moveId . "'";
		$this->db->query ( $sql );
		
		$sql = "UPDATE Survey_FlowMovementDetailTotal 
				SET totalPCUQuantity=IFNULL(TYPE1Quantity,0)+IFNULL(TYPE2Quantity,0)
							+IFNULL(TYPE3Quantity,0)+IFNULL(TYPE4Quantity,0)
							+IFNULL(TYPE5Quantity,0)+IFNULL(TYPE6Quantity,0)
							+IFNULL(TYPE7Quantity,0)+IFNULL(TYPE8Quantity,0)
							+IFNULL(TYPE9Quantity,0)+IFNULL(TYPE10Quantity,0)
							+IFNULL(TYPE11Quantity,0)+IFNULL(TYPE12Quantity,0)
							+IFNULL(TYPE13Quantity,0)+IFNULL(TYPE14Quantity,0)
							+IFNULL(TYPE15Quantity,0)+IFNULL(TYPE16Quantity,0)
							+IFNULL(TYPE17Quantity,0)+IFNULL(TYPE18Quantity,0)
							+IFNULL(TYPE19Quantity,0)+IFNULL(TYPE20Quantity,0)
							+IFNULL(TYPE21Quantity,0)+IFNULL(TYPE22Quantity,0)
							+IFNULL(TYPE23Quantity,0)+IFNULL(TYPE24Quantity,0)
				WHERE moveId = '" . $obj->moveId . "'";
		$this->db->query ( $sql );
	}
	
	/**
	 * 处理/统计数据
	 *
	 * @param
	 *        	$obj
	 */
	function ProcessTotal($obj) {
		$this->EmptyData ( $obj );
		$this->CalculateTotal ( $obj );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->modeId != '')
			$query .= " AND modeId = '" . $obj->modeId . "'";
		if ($obj->moveId != '')
			$query .= " AND FMDT.moveId = '" . $obj->moveId . "'";
		if ($obj->movementChiName != '')
			$query .= " AND movementChiName = '" . $obj->movementChiName . "'";
		if ($obj->startTime != '')
			$query .= " AND startTime = '" . $obj->startTime . "'";
		if ($obj->endTime != '')
			$query .= " AND endTime = '" . $obj->endTime . "'";
		if ($obj->TYPE1Quantity != '')
			$query .= " AND TYPE1Quantity = '" . $obj->TYPE1Quantity . "'";
		if ($obj->TYPE2Quantity != '')
			$query .= " AND TYPE2Quantity = '" . $obj->TYPE2Quantity . "'";
		if ($obj->TYPE3Quantity != '')
			$query .= " AND TYPE3Quantity = '" . $obj->TYPE3Quantity . "'";
		if ($obj->TYPE4Quantity != '')
			$query .= " AND TYPE4Quantity = '" . $obj->TYPE4Quantity . "'";
		if ($obj->TYPE5Quantity != '')
			$query .= " AND TYPE5Quantity = '" . $obj->TYPE5Quantity . "'";
		if ($obj->TYPE6Quantity != '')
			$query .= " AND TYPE6Quantity = '" . $obj->TYPE6Quantity . "'";
		if ($obj->TYPE7Quantity != '')
			$query .= " AND TYPE7Quantity = '" . $obj->TYPE7Quantity . "'";
		if ($obj->TYPE8Quantity != '')
			$query .= " AND TYPE8Quantity = '" . $obj->TYPE8Quantity . "'";
		if ($obj->TYPE9Quantity != '')
			$query .= " AND TYPE9Quantity = '" . $obj->TYPE9Quantity . "'";
		if ($obj->TYPE10Quantity != '')
			$query .= " AND TYPE10Quantity = '" . $obj->TYPE10Quantity . "'";
		if ($obj->TYPE11Quantity != '')
			$query .= " AND TYPE11Quantity = '" . $obj->TYPE11Quantity . "'";
		if ($obj->TYPE12Quantity != '')
			$query .= " AND TYPE12Quantity = '" . $obj->TYPE12Quantity . "'";
		if ($obj->TYPE13Quantity != '')
			$query .= " AND TYPE13Quantity = '" . $obj->TYPE13Quantity . "'";
		if ($obj->TYPE14Quantity != '')
			$query .= " AND TYPE14Quantity = '" . $obj->TYPE14Quantity . "'";
		if ($obj->TYPE15Quantity != '')
			$query .= " AND TYPE15Quantity = '" . $obj->TYPE15Quantity . "'";
		if ($obj->TYPE16Quantity != '')
			$query .= " AND TYPE16Quantity = '" . $obj->TYPE16Quantity . "'";
		if ($obj->TYPE17Quantity != '')
			$query .= " AND TYPE17Quantity = '" . $obj->TYPE17Quantity . "'";
		if ($obj->TYPE18Quantity != '')
			$query .= " AND TYPE18Quantity = '" . $obj->TYPE18Quantity . "'";
		if ($obj->TYPE19Quantity != '')
			$query .= " AND TYPE19Quantity = '" . $obj->TYPE19Quantity . "'";
		if ($obj->TYPE20Quantity != '')
			$query .= " AND TYPE20Quantity = '" . $obj->TYPE20Quantity . "'";
		if ($obj->TYPE21Quantity != '')
			$query .= " AND TYPE21Quantity = '" . $obj->TYPE21Quantity . "'";
		if ($obj->TYPE22Quantity != '')
			$query .= " AND TYPE22Quantity = '" . $obj->TYPE22Quantity . "'";
		if ($obj->TYPE23Quantity != '')
			$query .= " AND TYPE23Quantity = '" . $obj->TYPE23Quantity . "'";
		if ($obj->TYPE24Quantity != '')
			$query .= " AND TYPE24Quantity = '" . $obj->TYPE24Quantity . "'";
		if ($obj->TYPE25Quantity != '')
			$query .= " AND TYPE25Quantity = '" . $obj->TYPE25Quantity . "'";
		if ($obj->totalPCUQuantity != '')
			$query .= " AND totalPCUQuantity = '" . $obj->totalPCUQuantity . "'";
		if ($obj->totalHourPCUQuantity != '')
			$query .= " AND totalHourPCUQuantity = '" . $obj->totalHourPCUQuantity . "'";
		if ($obj->delFlag != '')
			$query .= " AND FMDT.delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		if ($obj->joinId != '')
			$query .= " AND FM.joinId = " . $obj->joinId;
		
		$sql = "SELECT FMDT.* FROM Survey_FlowMovementDetailTotal FMDT
		 INNER JOIN Survey_FlowMovement FM ON FM.moveId =  FMDT.moveId";
		" WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
//		echo $sql;exit();
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new FlowMovementDetailTotal ();
			$obj->modeId = $rs ["modeId"];
			$obj->moveId = $rs ["moveId"];
			$obj->movementChiName = $rs ["movementChiName"];
			$obj->startTime = $rs ["startTime"];
			$obj->endTime = $rs ["endTime"];
			$obj->TYPE1Quantity = $rs ["TYPE1Quantity"];
			$obj->TYPE2Quantity = $rs ["TYPE2Quantity"];
			$obj->TYPE3Quantity = $rs ["TYPE3Quantity"];
			$obj->TYPE4Quantity = $rs ["TYPE4Quantity"];
			$obj->TYPE5Quantity = $rs ["TYPE5Quantity"];
			$obj->TYPE6Quantity = $rs ["TYPE6Quantity"];
			$obj->TYPE7Quantity = $rs ["TYPE7Quantity"];
			$obj->TYPE8Quantity = $rs ["TYPE8Quantity"];
			$obj->TYPE9Quantity = $rs ["TYPE9Quantity"];
			$obj->TYPE10Quantity = $rs ["TYPE10Quantity"];
			$obj->TYPE11Quantity = $rs ["TYPE11Quantity"];
			$obj->TYPE12Quantity = $rs ["TYPE12Quantity"];
			$obj->TYPE13Quantity = $rs ["TYPE13Quantity"];
			$obj->TYPE14Quantity = $rs ["TYPE14Quantity"];
			$obj->TYPE15Quantity = $rs ["TYPE15Quantity"];
			$obj->TYPE16Quantity = $rs ["TYPE16Quantity"];
			$obj->TYPE17Quantity = $rs ["TYPE17Quantity"];
			$obj->TYPE18Quantity = $rs ["TYPE18Quantity"];
			$obj->TYPE19Quantity = $rs ["TYPE19Quantity"];
			$obj->TYPE20Quantity = $rs ["TYPE20Quantity"];
			$obj->TYPE21Quantity = $rs ["TYPE21Quantity"];
			$obj->TYPE22Quantity = $rs ["TYPE22Quantity"];
			$obj->TYPE23Quantity = $rs ["TYPE23Quantity"];
			$obj->TYPE24Quantity = $rs ["TYPE24Quantity"];
			$obj->TYPE25Quantity = $rs ["TYPE25Quantity"];
			$obj->totalHourPCUQuantity = $rs ["totalHourPCUQuantity"];
			$obj->totalPCUQuantity = $rs ["totalPCUQuantity"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 处理/统计 每小时数据
	 * 
	 * @access public
	 * @param unknown_type $obj        	
	 */
	function CalculateHourTotal($obj) {
		$obj->order = " ORDER BY modeId";
		$rs = $this->GetListSearch ( $obj );
		$rsNo = count ( $rs );
		$intervalMinutes = 15;
		$interval = 60 / $intervalMinutes;
		$interval = $interval - 1;
		for($i = 0; $i < $rsNo - $interval; $i ++) {
			$myObj = $rs [$i];
			$start = $i;
			$end = $i + $interval;
			$totalHourPCUQuantity = $this->CalculateOneHourTotal ( $rs, $start, $end );
			$sql = "UPDATE Survey_FlowMovementDetailTotal " . " SET totalHourPCUQuantity= " . $totalHourPCUQuantity . " " . " WHERE 1=1  AND modeId = '" . $myObj->modeId . "'";
			// echo $sql."<br />";
			$this->db->query ( $sql );
		}
	}
	
	/**
	 * 处理/统计 一个小时的数据
	 *
	 * @access private
	 * @param array $rs        	
	 * @param int $start        	
	 * @param int $end        	
	 */
	function CalculateOneHourTotal(&$rs, $start, $end) {
		// if($rs[$start]->totalPCUQuantity <= 0 || $rs[$end]->totalPCUQuantity <= 0)
		if ($rs [$start]->totalPCUQuantity == NULL || $rs [$end]->totalPCUQuantity === NULL)
			return 'NULL';
		$totalHourPCUQuantity = 0;
		for($i = $start; $i <= $end; $i ++) {
			$obj = $rs [$i];
			$totalHourPCUQuantity += $obj->totalPCUQuantity;
		}
		return $totalHourPCUQuantity;
	}
}
?>