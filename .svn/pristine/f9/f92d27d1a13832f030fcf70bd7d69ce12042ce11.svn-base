<?php
/*
 * Header: Create: 2008-01-31 Auther: Jamblues.
 */
class QuestionairnTaxiDetailAccess {
	var $db;
	function QuestionairnTaxiDetailAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_QuestionairnTaxiDetail(qutaId,surveyTime,taxiFare,tips,chargeableLuggage,radioCallSurcharge,tunnelFee,tunnelSurcharge,taxiType,interceptInterview)" . " VALUES('" . $obj->qutaId . "'" . ",'" . $obj->surveyTime . "'" . ",'" . $obj->taxiFare . "'" . ",'" . $obj->tips . "'" . ",'" . $obj->chargeableLuggage . "'" . ",'" . $obj->radioCallSurcharge . "'" . ",'" . $obj->tunnelFee . "'" . ",'" . $obj->tunnelSurcharge . "'" . ",'" . $obj->taxiType . "'" . ",'" . $obj->interceptInterview . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_QuestionairnTaxiDetail " . " SET qutaId = '" . $obj->qutaId . "'" . " ,surveyTime = '" . $obj->surveyTime . "'" . " ,taxiFare = '" . $obj->taxiFare . "'" . " ,tips = '" . $obj->tips . "'" . " ,chargeableLuggage = '" . $obj->chargeableLuggage . "'" . " ,radioCallSurcharge = '" . $obj->radioCallSurcharge . "'" . " ,tunnelFee = '" . $obj->tunnelFee . "'" . " ,tunnelSurcharge = '" . $obj->tunnelSurcharge . "'" . " ,taxiType = '" . $obj->taxiType . "'" . " ,interceptInterview = '" . $obj->interceptInterview . "'" . " WHERE 1=1  AND qutdId = '" . $obj->qutdId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_QuestionairnTaxiDetail " . " SET delFlag='yes' " . " WHERE 1=1  AND qutdId = '" . $obj->qutdId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_QuestionairnTaxiDetail " . " WHERE 1=1  AND qutdId = '" . $obj->qutdId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->qutdId != '')
			$query .= " AND qutdId = '" . $obj->qutdId . "'";
		if ($obj->qutaId != '')
			$query .= " AND qutaId = '" . $obj->qutaId . "'";
		if ($obj->surveyTime != '')
			$query .= " AND surveyTime = '" . $obj->surveyTime . "'";
		if ($obj->taxiFare != '')
			$query .= " AND taxiFare = '" . $obj->taxiFare . "'";
		if ($obj->tips != '')
			$query .= " AND tips = '" . $obj->tips . "'";
		if ($obj->chargeableLuggage != '')
			$query .= " AND chargeableLuggage = '" . $obj->chargeableLuggage . "'";
		if ($obj->radioCallSurcharge != '')
			$query .= " AND radioCallSurcharge = '" . $obj->radioCallSurcharge . "'";
		if ($obj->tunnelFee != '')
			$query .= " AND tunnelFee = '" . $obj->tunnelFee . "'";
		if ($obj->tunnelSurcharge != '')
			$query .= " AND tunnelSurcharge = '" . $obj->tunnelSurcharge . "'";
		if ($obj->taxiType != '')
			$query .= " AND taxiType = '" . $obj->taxiType . "'";
		if ($obj->interceptInterview != '')
			$query .= " AND interceptInterview = '" . $obj->interceptInterview . "'";
		$query .= "ORDER BY surveyTime";
		
		$sql = "SELECT * FROM Survey_QuestionairnTaxiDetail " . " WHERE 1=1 ";
		
		$sql = $sql . $query;
		$this->db->query ( $sql );
		// print $sql;
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new QuestionairnTaxiDetail ();
			$obj->qutdId = $rs ["qutdId"];
			$obj->qutaId = $rs ["qutaId"];
			$obj->surveyTime = $rs ["surveyTime"];
			$obj->taxiFare = $rs ["taxiFare"];
			$obj->tips = $rs ["tips"];
			$obj->chargeableLuggage = $rs ["chargeableLuggage"];
			$obj->radioCallSurcharge = $rs ["radioCallSurcharge"];
			$obj->tunnelFee = $rs ["tunnelFee"];
			$obj->tunnelSurcharge = $rs ["tunnelSurcharge"];
			$obj->taxiType = $rs ["taxiType"];
			$obj->interceptInterview = $rs ["interceptInterview"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>