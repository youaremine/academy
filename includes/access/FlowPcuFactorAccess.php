<?php
/*
 * Header: Create: 2008-06-29 Auther: Jamblues@gmail.com.
 */
class FlowPcuFactorAccess {
	var $db;
	function FlowPcuFactorAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_FlowPcuFactor(porjId,PCUFactor,TYPE1Quantity,TYPE1IncludeCar,TYPE2Quantity,TYPE2IncludeCar,TYPE3Quantity,TYPE3IncludeCar,TYPE4Quantity,TYPE4IncludeCar,TYPE5Quantity,TYPE5IncludeCar,TYPE6Quantity,TYPE6IncludeCar,TYPE7Quantity,TYPE7IncludeCar,TYPE8Quantity,TYPE8IncludeCar,TYPE9Quantity,TYPE9IncludeCar,TYPE10Quantity,TYPE10IncludeCar,TYPE11Quantity,TYPE11IncludeCar,TYPE12Quantity,TYPE12IncludeCar,TYPE13Quantity,TYPE13IncludeCar,TYPE14Quantity,TYPE14IncludeCar,TYPE15Quantity,TYPE15IncludeCar,TYPE16Quantity,TYPE16IncludeCar,TYPE17Quantity,TYPE17IncludeCar,TYPE18Quantity,TYPE18IncludeCar,TYPE19Quantity,TYPE19IncludeCar,TYPE20Quantity,TYPE20IncludeCar,TYPE21Quantity,TYPE21IncludeCar,TYPE22Quantity,TYPE22IncludeCar,TYPE23Quantity,TYPE23IncludeCar,TYPE24Quantity,TYPE24IncludeCar,TYPE25Quantity,TYPE25IncludeCar,delFlag)" . " VALUES('" . $obj->porjId . "'" . ",'" . $obj->PCUFactor . "'" . ",'" . $obj->TYPE1Quantity . "'" . ",'" . $obj->TYPE1IncludeCar . "'" . ",'" . $obj->TYPE2Quantity . "'" . ",'" . $obj->TYPE2IncludeCar . "'" . ",'" . $obj->TYPE3Quantity . "'" . ",'" . $obj->TYPE3IncludeCar . "'" . ",'" . $obj->TYPE4Quantity . "'" . ",'" . $obj->TYPE4IncludeCar . "'" . ",'" . $obj->TYPE5Quantity . "'" . ",'" . $obj->TYPE5IncludeCar . "'" . ",'" . $obj->TYPE6Quantity . "'" . ",'" . $obj->TYPE6IncludeCar . "'" . ",'" . $obj->TYPE7Quantity . "'" . ",'" . $obj->TYPE7IncludeCar . "'" . ",'" . $obj->TYPE8Quantity . "'" . ",'" . $obj->TYPE8IncludeCar . "'" . ",'" . $obj->TYPE9Quantity . "'" . ",'" . $obj->TYPE9IncludeCar . "'" . ",'" . $obj->TYPE10Quantity . "'" . ",'" . $obj->TYPE10IncludeCar . "'" . ",'" . $obj->TYPE11Quantity . "'" . ",'" . $obj->TYPE11IncludeCar . "'" . ",'" . $obj->TYPE12Quantity . "'" . ",'" . $obj->TYPE12IncludeCar . "'" . ",'" . $obj->TYPE13Quantity . "'" . ",'" . $obj->TYPE13IncludeCar . "'" . ",'" . $obj->TYPE14Quantity . "'" . ",'" . $obj->TYPE14IncludeCar . "'" . ",'" . $obj->TYPE15Quantity . "'" . ",'" . $obj->TYPE15IncludeCar . "'" . ",'" . $obj->TYPE16Quantity . "'" . ",'" . $obj->TYPE16IncludeCar . "'" . ",'" . $obj->TYPE17Quantity . "'" . ",'" . $obj->TYPE17IncludeCar . "'" . ",'" . $obj->TYPE18Quantity . "'" . ",'" . $obj->TYPE18IncludeCar . "'" . ",'" . $obj->TYPE19Quantity . "'" . ",'" . $obj->TYPE19IncludeCar . "'" . ",'" . $obj->TYPE20Quantity . "'" . ",'" . $obj->TYPE20IncludeCar . "'" . ",'" . $obj->TYPE21Quantity . "'" . ",'" . $obj->TYPE21IncludeCar . "'" . ",'" . $obj->TYPE22Quantity . "'" . ",'" . $obj->TYPE22IncludeCar . "'" . ",'" . $obj->TYPE23Quantity . "'" . ",'" . $obj->TYPE23IncludeCar . "'" . ",'" . $obj->TYPE24Quantity . "'" . ",'" . $obj->TYPE24IncludeCar . "'" . ",'" . $obj->TYPE25Quantity . "'" . ",'" . $obj->TYPE25IncludeCar . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_FlowPcuFactor " . " SET porjId = '" . $obj->porjId . "'" . " ,PCUFactor = '" . $obj->PCUFactor . "'" . " ,TYPE1Quantity = '" . $obj->TYPE1Quantity . "'" . " ,TYPE1IncludeCar = '" . $obj->TYPE1IncludeCar . "'" . " ,TYPE2Quantity = '" . $obj->TYPE2Quantity . "'" . " ,TYPE2IncludeCar = '" . $obj->TYPE2IncludeCar . "'" . " ,TYPE3Quantity = '" . $obj->TYPE3Quantity . "'" . " ,TYPE3IncludeCar = '" . $obj->TYPE3IncludeCar . "'" . " ,TYPE4Quantity = '" . $obj->TYPE4Quantity . "'" . " ,TYPE4IncludeCar = '" . $obj->TYPE4IncludeCar . "'" . " ,TYPE5Quantity = '" . $obj->TYPE5Quantity . "'" . " ,TYPE5IncludeCar = '" . $obj->TYPE5IncludeCar . "'" . " ,TYPE6Quantity = '" . $obj->TYPE6Quantity . "'" . " ,TYPE6IncludeCar = '" . $obj->TYPE6IncludeCar . "'" . " ,TYPE7Quantity = '" . $obj->TYPE7Quantity . "'" . " ,TYPE7IncludeCar = '" . $obj->TYPE7IncludeCar . "'" . " ,TYPE8Quantity = '" . $obj->TYPE8Quantity . "'" . " ,TYPE8IncludeCar = '" . $obj->TYPE8IncludeCar . "'" . " ,TYPE9Quantity = '" . $obj->TYPE9Quantity . "'" . " ,TYPE9IncludeCar = '" . $obj->TYPE9IncludeCar . "'" . " ,TYPE10Quantity = '" . $obj->TYPE10Quantity . "'" . " ,TYPE10IncludeCar = '" . $obj->TYPE10IncludeCar . "'" . " ,TYPE11Quantity = '" . $obj->TYPE11Quantity . "'" . " ,TYPE11IncludeCar = '" . $obj->TYPE11IncludeCar . "'" . " ,TYPE12Quantity = '" . $obj->TYPE12Quantity . "'" . " ,TYPE12IncludeCar = '" . $obj->TYPE12IncludeCar . "'" . " ,TYPE13Quantity = '" . $obj->TYPE13Quantity . "'" . " ,TYPE13IncludeCar = '" . $obj->TYPE13IncludeCar . "'" . " ,TYPE14Quantity = '" . $obj->TYPE14Quantity . "'" . " ,TYPE14IncludeCar = '" . $obj->TYPE14IncludeCar . "'" . " ,TYPE15Quantity = '" . $obj->TYPE15Quantity . "'" . " ,TYPE15IncludeCar = '" . $obj->TYPE15IncludeCar . "'" . " ,TYPE16Quantity = '" . $obj->TYPE16Quantity . "'" . " ,TYPE16IncludeCar = '" . $obj->TYPE16IncludeCar . "'" . " ,TYPE17Quantity = '" . $obj->TYPE17Quantity . "'" . " ,TYPE17IncludeCar = '" . $obj->TYPE17IncludeCar . "'" . " ,TYPE18Quantity = '" . $obj->TYPE18Quantity . "'" . " ,TYPE18IncludeCar = '" . $obj->TYPE18IncludeCar . "'" . " ,TYPE19Quantity = '" . $obj->TYPE19Quantity . "'" . " ,TYPE19IncludeCar = '" . $obj->TYPE19IncludeCar . "'" . " ,TYPE20Quantity = '" . $obj->TYPE20Quantity . "'" . " ,TYPE20IncludeCar = '" . $obj->TYPE20IncludeCar . "'" . " ,TYPE21Quantity = '" . $obj->TYPE21Quantity . "'" . " ,TYPE21IncludeCar = '" . $obj->TYPE21IncludeCar . "'" . " ,TYPE22Quantity = '" . $obj->TYPE22Quantity . "'" . " ,TYPE22IncludeCar = '" . $obj->TYPE22IncludeCar . "'" . " ,TYPE23Quantity = '" . $obj->TYPE23Quantity . "'" . " ,TYPE23IncludeCar = '" . $obj->TYPE23IncludeCar . "'" . " ,TYPE24Quantity = '" . $obj->TYPE24Quantity . "'" . " ,TYPE24IncludeCar = '" . $obj->TYPE24IncludeCar . "'" . " ,TYPE25Quantity = '" . $obj->TYPE25Quantity . "'" . " ,TYPE25IncludeCar = '" . $obj->TYPE25IncludeCar . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND pcfaId = '" . $obj->pcfaId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_FlowPcuFactor " . " SET delFlag='yes' " . " WHERE 1=1  AND pcfaId = '" . $obj->pcfaId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_FlowPcuFactor " . " WHERE 1=1  AND pcfaId = '" . $obj->pcfaId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->pcfaId != '')
			$query .= " AND pcfaId = '" . $obj->pcfaId . "'";
		if ($obj->porjId != '')
			$query .= " AND porjId = '" . $obj->porjId . "'";
		if ($obj->PCUFactor != '')
			$query .= " AND PCUFactor = '" . $obj->PCUFactor . "'";
		if ($obj->TYPE1Quantity != '')
			$query .= " AND TYPE1Quantity = '" . $obj->TYPE1Quantity . "'";
		if ($obj->TYPE1IncludeCar != '')
			$query .= " AND TYPE1IncludeCar = '" . $obj->TYPE1IncludeCar . "'";
		if ($obj->TYPE2Quantity != '')
			$query .= " AND TYPE2Quantity = '" . $obj->TYPE2Quantity . "'";
		if ($obj->TYPE2IncludeCar != '')
			$query .= " AND TYPE2IncludeCar = '" . $obj->TYPE2IncludeCar . "'";
		if ($obj->TYPE3Quantity != '')
			$query .= " AND TYPE3Quantity = '" . $obj->TYPE3Quantity . "'";
		if ($obj->TYPE3IncludeCar != '')
			$query .= " AND TYPE3IncludeCar = '" . $obj->TYPE3IncludeCar . "'";
		if ($obj->TYPE4Quantity != '')
			$query .= " AND TYPE4Quantity = '" . $obj->TYPE4Quantity . "'";
		if ($obj->TYPE4IncludeCar != '')
			$query .= " AND TYPE4IncludeCar = '" . $obj->TYPE4IncludeCar . "'";
		if ($obj->TYPE5Quantity != '')
			$query .= " AND TYPE5Quantity = '" . $obj->TYPE5Quantity . "'";
		if ($obj->TYPE5IncludeCar != '')
			$query .= " AND TYPE5IncludeCar = '" . $obj->TYPE5IncludeCar . "'";
		if ($obj->TYPE6Quantity != '')
			$query .= " AND TYPE6Quantity = '" . $obj->TYPE6Quantity . "'";
		if ($obj->TYPE6IncludeCar != '')
			$query .= " AND TYPE6IncludeCar = '" . $obj->TYPE6IncludeCar . "'";
		if ($obj->TYPE7Quantity != '')
			$query .= " AND TYPE7Quantity = '" . $obj->TYPE7Quantity . "'";
		if ($obj->TYPE7IncludeCar != '')
			$query .= " AND TYPE7IncludeCar = '" . $obj->TYPE7IncludeCar . "'";
		if ($obj->TYPE8Quantity != '')
			$query .= " AND TYPE8Quantity = '" . $obj->TYPE8Quantity . "'";
		if ($obj->TYPE8IncludeCar != '')
			$query .= " AND TYPE8IncludeCar = '" . $obj->TYPE8IncludeCar . "'";
		if ($obj->TYPE9Quantity != '')
			$query .= " AND TYPE9Quantity = '" . $obj->TYPE9Quantity . "'";
		if ($obj->TYPE9IncludeCar != '')
			$query .= " AND TYPE9IncludeCar = '" . $obj->TYPE9IncludeCar . "'";
		if ($obj->TYPE10Quantity != '')
			$query .= " AND TYPE10Quantity = '" . $obj->TYPE10Quantity . "'";
		if ($obj->TYPE10IncludeCar != '')
			$query .= " AND TYPE10IncludeCar = '" . $obj->TYPE10IncludeCar . "'";
		if ($obj->TYPE11Quantity != '')
			$query .= " AND TYPE11Quantity = '" . $obj->TYPE11Quantity . "'";
		if ($obj->TYPE11IncludeCar != '')
			$query .= " AND TYPE11IncludeCar = '" . $obj->TYPE11IncludeCar . "'";
		if ($obj->TYPE12Quantity != '')
			$query .= " AND TYPE12Quantity = '" . $obj->TYPE12Quantity . "'";
		if ($obj->TYPE12IncludeCar != '')
			$query .= " AND TYPE12IncludeCar = '" . $obj->TYPE12IncludeCar . "'";
		if ($obj->TYPE13Quantity != '')
			$query .= " AND TYPE13Quantity = '" . $obj->TYPE13Quantity . "'";
		if ($obj->TYPE13IncludeCar != '')
			$query .= " AND TYPE13IncludeCar = '" . $obj->TYPE13IncludeCar . "'";
		if ($obj->TYPE14Quantity != '')
			$query .= " AND TYPE14Quantity = '" . $obj->TYPE14Quantity . "'";
		if ($obj->TYPE14IncludeCar != '')
			$query .= " AND TYPE14IncludeCar = '" . $obj->TYPE14IncludeCar . "'";
		if ($obj->TYPE15Quantity != '')
			$query .= " AND TYPE15Quantity = '" . $obj->TYPE15Quantity . "'";
		if ($obj->TYPE15IncludeCar != '')
			$query .= " AND TYPE15IncludeCar = '" . $obj->TYPE15IncludeCar . "'";
		if ($obj->TYPE16Quantity != '')
			$query .= " AND TYPE16Quantity = '" . $obj->TYPE16Quantity . "'";
		if ($obj->TYPE16IncludeCar != '')
			$query .= " AND TYPE16IncludeCar = '" . $obj->TYPE16IncludeCar . "'";
		if ($obj->TYPE17Quantity != '')
			$query .= " AND TYPE17Quantity = '" . $obj->TYPE17Quantity . "'";
		if ($obj->TYPE17IncludeCar != '')
			$query .= " AND TYPE17IncludeCar = '" . $obj->TYPE17IncludeCar . "'";
		if ($obj->TYPE18Quantity != '')
			$query .= " AND TYPE18Quantity = '" . $obj->TYPE18Quantity . "'";
		if ($obj->TYPE18IncludeCar != '')
			$query .= " AND TYPE18IncludeCar = '" . $obj->TYPE18IncludeCar . "'";
		if ($obj->TYPE19Quantity != '')
			$query .= " AND TYPE19Quantity = '" . $obj->TYPE19Quantity . "'";
		if ($obj->TYPE19IncludeCar != '')
			$query .= " AND TYPE19IncludeCar = '" . $obj->TYPE19IncludeCar . "'";
		if ($obj->TYPE20Quantity != '')
			$query .= " AND TYPE20Quantity = '" . $obj->TYPE20Quantity . "'";
		if ($obj->TYPE20IncludeCar != '')
			$query .= " AND TYPE20IncludeCar = '" . $obj->TYPE20IncludeCar . "'";
		if ($obj->TYPE21Quantity != '')
			$query .= " AND TYPE21Quantity = '" . $obj->TYPE21Quantity . "'";
		if ($obj->TYPE21IncludeCar != '')
			$query .= " AND TYPE21IncludeCar = '" . $obj->TYPE21IncludeCar . "'";
		if ($obj->TYPE22Quantity != '')
			$query .= " AND TYPE22Quantity = '" . $obj->TYPE22Quantity . "'";
		if ($obj->TYPE22IncludeCar != '')
			$query .= " AND TYPE22IncludeCar = '" . $obj->TYPE22IncludeCar . "'";
		if ($obj->TYPE23Quantity != '')
			$query .= " AND TYPE23Quantity = '" . $obj->TYPE23Quantity . "'";
		if ($obj->TYPE23IncludeCar != '')
			$query .= " AND TYPE23IncludeCar = '" . $obj->TYPE23IncludeCar . "'";
		if ($obj->TYPE24Quantity != '')
			$query .= " AND TYPE24Quantity = '" . $obj->TYPE24Quantity . "'";
		if ($obj->TYPE24IncludeCar != '')
			$query .= " AND TYPE24IncludeCar = '" . $obj->TYPE24IncludeCar . "'";
		if ($obj->TYPE25Quantity != '')
			$query .= " AND TYPE25Quantity = '" . $obj->TYPE25Quantity . "'";
		if ($obj->TYPE25IncludeCar != '')
			$query .= " AND TYPE25IncludeCar = '" . $obj->TYPE25IncludeCar . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_FlowPcuFactor " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new FlowPcuFactor ();
			$obj->pcfaId = $rs ["pcfaId"];
			$obj->porjId = $rs ["porjId"];
			$obj->PCUFactor = $rs ["PCUFactor"];
			$obj->TYPE1Quantity = $rs ["TYPE1Quantity"];
			$obj->TYPE1IncludeCar = $rs ["TYPE1IncludeCar"];
			$obj->TYPE2Quantity = $rs ["TYPE2Quantity"];
			$obj->TYPE2IncludeCar = $rs ["TYPE2IncludeCar"];
			$obj->TYPE3Quantity = $rs ["TYPE3Quantity"];
			$obj->TYPE3IncludeCar = $rs ["TYPE3IncludeCar"];
			$obj->TYPE4Quantity = $rs ["TYPE4Quantity"];
			$obj->TYPE4IncludeCar = $rs ["TYPE4IncludeCar"];
			$obj->TYPE5Quantity = $rs ["TYPE5Quantity"];
			$obj->TYPE5IncludeCar = $rs ["TYPE5IncludeCar"];
			$obj->TYPE6Quantity = $rs ["TYPE6Quantity"];
			$obj->TYPE6IncludeCar = $rs ["TYPE6IncludeCar"];
			$obj->TYPE7Quantity = $rs ["TYPE7Quantity"];
			$obj->TYPE7IncludeCar = $rs ["TYPE7IncludeCar"];
			$obj->TYPE8Quantity = $rs ["TYPE8Quantity"];
			$obj->TYPE8IncludeCar = $rs ["TYPE8IncludeCar"];
			$obj->TYPE9Quantity = $rs ["TYPE9Quantity"];
			$obj->TYPE9IncludeCar = $rs ["TYPE9IncludeCar"];
			$obj->TYPE10Quantity = $rs ["TYPE10Quantity"];
			$obj->TYPE10IncludeCar = $rs ["TYPE10IncludeCar"];
			$obj->TYPE11Quantity = $rs ["TYPE11Quantity"];
			$obj->TYPE11IncludeCar = $rs ["TYPE11IncludeCar"];
			$obj->TYPE12Quantity = $rs ["TYPE12Quantity"];
			$obj->TYPE12IncludeCar = $rs ["TYPE12IncludeCar"];
			$obj->TYPE13Quantity = $rs ["TYPE13Quantity"];
			$obj->TYPE13IncludeCar = $rs ["TYPE13IncludeCar"];
			$obj->TYPE14Quantity = $rs ["TYPE14Quantity"];
			$obj->TYPE14IncludeCar = $rs ["TYPE14IncludeCar"];
			$obj->TYPE15Quantity = $rs ["TYPE15Quantity"];
			$obj->TYPE15IncludeCar = $rs ["TYPE15IncludeCar"];
			$obj->TYPE16Quantity = $rs ["TYPE16Quantity"];
			$obj->TYPE16IncludeCar = $rs ["TYPE16IncludeCar"];
			$obj->TYPE17Quantity = $rs ["TYPE17Quantity"];
			$obj->TYPE17IncludeCar = $rs ["TYPE17IncludeCar"];
			$obj->TYPE18Quantity = $rs ["TYPE18Quantity"];
			$obj->TYPE18IncludeCar = $rs ["TYPE18IncludeCar"];
			$obj->TYPE19Quantity = $rs ["TYPE19Quantity"];
			$obj->TYPE19IncludeCar = $rs ["TYPE19IncludeCar"];
			$obj->TYPE20Quantity = $rs ["TYPE20Quantity"];
			$obj->TYPE20IncludeCar = $rs ["TYPE20IncludeCar"];
			$obj->TYPE21Quantity = $rs ["TYPE21Quantity"];
			$obj->TYPE21IncludeCar = $rs ["TYPE21IncludeCar"];
			$obj->TYPE22Quantity = $rs ["TYPE22Quantity"];
			$obj->TYPE22IncludeCar = $rs ["TYPE22IncludeCar"];
			$obj->TYPE23Quantity = $rs ["TYPE23Quantity"];
			$obj->TYPE23IncludeCar = $rs ["TYPE23IncludeCar"];
			$obj->TYPE24Quantity = $rs ["TYPE24Quantity"];
			$obj->TYPE24IncludeCar = $rs ["TYPE24IncludeCar"];
			$obj->TYPE25Quantity = $rs ["TYPE25Quantity"];
			$obj->TYPE25IncludeCar = $rs ["TYPE25IncludeCar"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>