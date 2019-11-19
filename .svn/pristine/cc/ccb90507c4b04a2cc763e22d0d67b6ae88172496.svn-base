<?php
/*
 * Header: Create: 2008-06-29 Auther: Jamblues@gmail.com.
 */
class FlowMovementDetailAccess {
	var $db;
	function FlowMovementDetailAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_FlowMovementDetail(moveId,startTime,endTime,TYPE1Quantity,TYPE2Quantity,TYPE3Quantity
			,TYPE4Quantity,TYPE5Quantity,TYPE6Quantity,TYPE7Quantity,TYPE8Quantity,TYPE9Quantity,TYPE10Quantity,TYPE11Quantity
			,TYPE12Quantity,TYPE13Quantity,TYPE14Quantity,TYPE15Quantity,TYPE16Quantity,TYPE17Quantity,TYPE18Quantity,TYPE19Quantity
			,TYPE20Quantity,TYPE21Quantity,TYPE22Quantity,TYPE23Quantity,TYPE24Quantity,TYPE25Quantity,delFlag)
		 VALUES('" . $obj->moveId . "'" . ",'" . $obj->startTime . "'" . ",'" . $obj->endTime . "'" . "
		 ," . $obj->TYPE1Quantity . "" . "," . $obj->TYPE2Quantity . "" . "," . $obj->TYPE3Quantity . "" . "
		 ," . $obj->TYPE4Quantity . "" . "," . $obj->TYPE5Quantity . "" . "," . $obj->TYPE6Quantity . "" . "
		 ," . $obj->TYPE7Quantity . "" . "," . $obj->TYPE8Quantity . "" . "," . $obj->TYPE9Quantity . "" . "
		 ," . $obj->TYPE10Quantity . "" . "," . $obj->TYPE11Quantity . "" . "," . $obj->TYPE12Quantity . "" . "
		 ," . $obj->TYPE13Quantity . "" . "," . $obj->TYPE14Quantity . "" . "," . $obj->TYPE15Quantity . "" . "
		 ," . $obj->TYPE16Quantity . "" . "," . $obj->TYPE17Quantity . "" . "," . $obj->TYPE18Quantity . "" . "
		 ," . $obj->TYPE19Quantity . "" . "," . $obj->TYPE20Quantity . "" . "," . $obj->TYPE21Quantity . "" . "
		 ," . $obj->TYPE22Quantity . "" . "," . $obj->TYPE23Quantity . "" . "," . $obj->TYPE24Quantity . "" . "
		 ," . $obj->TYPE25Quantity . "" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_FlowMovementDetail " . " SET moveId = '" . $obj->moveId . "'" . " ,startTime = '" . $obj->startTime . "'" . " ,endTime = '" . $obj->endTime . "'" . " ,TYPE1Quantity = " . $obj->TYPE1Quantity . "" . " ,TYPE2Quantity = " . $obj->TYPE2Quantity . "" . " ,TYPE3Quantity = " . $obj->TYPE3Quantity . "" . " ,TYPE4Quantity = " . $obj->TYPE4Quantity . "" . " ,TYPE5Quantity = " . $obj->TYPE5Quantity . "" . " ,TYPE6Quantity = " . $obj->TYPE6Quantity . "" . " ,TYPE7Quantity = " . $obj->TYPE7Quantity . "" . " ,TYPE8Quantity = " . $obj->TYPE8Quantity . "" . " ,TYPE9Quantity = " . $obj->TYPE9Quantity . "" . " ,TYPE10Quantity = " . $obj->TYPE10Quantity . "" . " ,TYPE11Quantity = " . $obj->TYPE11Quantity . "" . " ,TYPE12Quantity = " . $obj->TYPE12Quantity . "" . " ,TYPE13Quantity = " . $obj->TYPE13Quantity . "" . " ,TYPE14Quantity = " . $obj->TYPE14Quantity . "" . " ,TYPE15Quantity = " . $obj->TYPE15Quantity . "" . " ,TYPE16Quantity = " . $obj->TYPE16Quantity . "" . " ,TYPE17Quantity = " . $obj->TYPE17Quantity . "" . " ,TYPE18Quantity = " . $obj->TYPE18Quantity . "" . " ,TYPE19Quantity = " . $obj->TYPE19Quantity . "" . " ,TYPE20Quantity = " . $obj->TYPE20Quantity . "" . " ,TYPE21Quantity = " . $obj->TYPE21Quantity . "" . " ,TYPE22Quantity = " . $obj->TYPE22Quantity . "" . " ,TYPE23Quantity = " . $obj->TYPE23Quantity . "" . " ,TYPE24Quantity = " . $obj->TYPE24Quantity . "" . " ,TYPE25Quantity = " . $obj->TYPE25Quantity . "" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND modeId = '" . $obj->modeId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_FlowMovementDetail " . " SET delFlag='yes' " . " WHERE 1=1  AND modeId = '" . $obj->modeId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_FlowMovementDetail " . " WHERE 1=1  AND modeId = '" . $obj->modeId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->modeId != '')
			$query .= " AND modeId = '" . $obj->modeId . "'";
		if ($obj->moveId != '')
			$query .= " AND moveId = '" . $obj->moveId . "'";
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
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_FlowMovementDetail " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
//		echo $sql;
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new FlowMovementDetail ();
			$obj->modeId = $rs ["modeId"];
			$obj->moveId = $rs ["moveId"];
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
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>