<?php
/*
 * Header: 
 * Create: 2017-04-19
 * Auther: James Wu<jamblues@gmail.com>.
 */
class SurveyorApplyAccess
{
	var $db;

	function SurveyorApplyAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_SurveyorApply(upSurvId,ozzoCode,chiName,engName,contact,survHome,dipaCode,IsSupervisor,personalRecord,bank,accountNo,VIP,whatsAPP,email,fax,remarks,birthday,company,survType,status,selfBefore,lastYearSurveyTimes,inputUserId,inputTime,updateUserId,updateTime)".
			" VALUES('".$obj->upSurvId."'".
			",'".$obj->ozzoCode."'".
			",'".$obj->chiName."'".
			",'".$obj->engName."'".
			",'".$obj->contact."'".
			",'".$obj->survHome."'".
			",'".$obj->dipaCode."'".
			",'".$obj->IsSupervisor."'".
			",'".$obj->personalRecord."'".
			",'".$obj->bank."'".
			",'".$obj->accountNo."'".
			",'".$obj->VIP."'".
			",'".$obj->whatsAPP."'".
			",'".$obj->email."'".
			",'".$obj->fax."'".
			",'".$obj->remarks."'".
			",'".$obj->birthday."'".
			",'".$obj->company."'".
			",'".$obj->survType."'".
			",'".$obj->status."'".
			",'".$obj->selfBefore."'".
			",'".$obj->lastYearSurveyTimes."'".
			",'".$obj->inputUserId."'".
			",'".$obj->inputTime."'".
			",'".$obj->updateUserId."'".
			",'".$obj->updateTime."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_SurveyorApply ".
			" SET upSurvId = '".$obj->upSurvId."'".
			" ,ozzoCode = '".$obj->ozzoCode."'".
			" ,chiName = '".$obj->chiName."'".
			" ,engName = '".$obj->engName."'".
			" ,contact = '".$obj->contact."'".
			" ,survHome = '".$obj->survHome."'".
			" ,dipaCode = '".$obj->dipaCode."'".
			" ,IsSupervisor = '".$obj->IsSupervisor."'".
			" ,personalRecord = '".$obj->personalRecord."'".
			" ,bank = '".$obj->bank."'".
			" ,accountNo = '".$obj->accountNo."'".
			" ,VIP = '".$obj->VIP."'".
			" ,whatsAPP = '".$obj->whatsAPP."'".
			" ,email = '".$obj->email."'".
			" ,fax = '".$obj->fax."'".
			" ,remarks = '".$obj->remarks."'".
			" ,birthday = '".$obj->birthday."'".
			" ,company = '".$obj->company."'".
			" ,survType = '".$obj->survType."'".
			" ,status = '".$obj->status."'".
			" ,selfBefore = '".$obj->selfBefore."'".
			" ,lastYearSurveyTimes = '".$obj->lastYearSurveyTimes."'".
			" ,inputUserId = '".$obj->inputUserId."'".
			" ,inputTime = '".$obj->inputTime."'".
			" ,updateUserId = '".$obj->updateUserId."'".
			" ,updateTime = '".$obj->updateTime."'".
			" WHERE 1=1  AND survId = '".$obj->survId."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_SurveyorApply ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND survId = '".$obj->survId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_SurveyorApply ".
			" WHERE 1=1  AND survId = '".$obj->survId."'";
		$this->db->query($sql);
	}

	function GetListSearch($obj)
	{
		$query = '';
		if($obj->survId != '')
			$query .= " AND survId = '".$obj->survId."'";
		if($obj->upSurvId != '')
			$query .= " AND upSurvId = '".$obj->upSurvId."'";
		if($obj->ozzoCode != '')
			$query .= " AND ozzoCode = '".$obj->ozzoCode."'";
		if($obj->chiName != '')
			$query .= " AND chiName = '".$obj->chiName."'";
		if($obj->engName != '')
			$query .= " AND engName = '".$obj->engName."'";
		if($obj->contact != '')
			$query .= " AND contact = '".$obj->contact."'";
		if($obj->survHome != '')
			$query .= " AND survHome = '".$obj->survHome."'";
		if($obj->dipaCode != '')
			$query .= " AND dipaCode = '".$obj->dipaCode."'";
		if($obj->IsSupervisor != '')
			$query .= " AND IsSupervisor = '".$obj->IsSupervisor."'";
		if($obj->personalRecord != '')
			$query .= " AND personalRecord = '".$obj->personalRecord."'";
		if($obj->bank != '')
			$query .= " AND bank = '".$obj->bank."'";
		if($obj->accountNo != '')
			$query .= " AND accountNo = '".$obj->accountNo."'";
		if($obj->VIP != '')
			$query .= " AND VIP = '".$obj->VIP."'";
		if($obj->whatsAPP != '')
			$query .= " AND whatsAPP = '".$obj->whatsAPP."'";
		if($obj->email != '')
			$query .= " AND email = '".$obj->email."'";
		if($obj->fax != '')
			$query .= " AND fax = '".$obj->fax."'";
		if($obj->remarks != '')
			$query .= " AND remarks = '".$obj->remarks."'";
		if($obj->birthday != '')
			$query .= " AND birthday = '".$obj->birthday."'";
		if($obj->company != '')
			$query .= " AND company = '".$obj->company."'";
		if($obj->survType != '')
			$query .= " AND survType = '".$obj->survType."'";
		if($obj->status != '')
			$query .= " AND status = '".$obj->status."'";
		if($obj->selfBefore != '')
			$query .= " AND selfBefore = '".$obj->selfBefore."'";
		if($obj->lastYearSurveyTimes != '')
			$query .= " AND lastYearSurveyTimes = '".$obj->lastYearSurveyTimes."'";
		if($obj->inputUserId != '')
			$query .= " AND inputUserId = '".$obj->inputUserId."'";
		if($obj->inputTime != '')
			$query .= " AND inputTime = '".$obj->inputTime."'";
		if($obj->updateUserId != '')
			$query .= " AND updateUserId = '".$obj->updateUserId."'";
		if($obj->updateTime != '')
			$query .= " AND updateTime = '".$obj->updateTime."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

		$sql = "SELECT * FROM Survey_SurveyorApply ".
			" WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new SurveyorApply();
			$obj->survId = $rs["survId"];
			$obj->upSurvId = $rs["upSurvId"];
			$obj->ozzoCode = $rs["ozzoCode"];
			$obj->chiName = $rs["chiName"];
			$obj->engName = $rs["engName"];
			$obj->contact = $rs["contact"];
			$obj->survHome = $rs["survHome"];
			$obj->dipaCode = $rs["dipaCode"];
			$obj->IsSupervisor = $rs["IsSupervisor"];
			$obj->personalRecord = $rs["personalRecord"];
			$obj->bank = $rs["bank"];
			$obj->accountNo = $rs["accountNo"];
			$obj->VIP = $rs["VIP"];
			$obj->whatsAPP = $rs["whatsAPP"];
			$obj->email = $rs["email"];
			$obj->fax = $rs["fax"];
			$obj->remarks = $rs["remarks"];
			$obj->birthday = $rs["birthday"];
			$obj->company = $rs["company"];
			$obj->survType = $rs["survType"];
			$obj->status = $rs["status"];
			$obj->selfBefore = $rs["selfBefore"];
			$obj->lastYearSurveyTimes = $rs["lastYearSurveyTimes"];
			$obj->inputUserId = $rs["inputUserId"];
			$obj->inputTime = $rs["inputTime"];
			$obj->updateUserId = $rs["updateUserId"];
			$obj->updateTime = $rs["updateTime"];
			$rows[] = $obj;
		}
		return $rows;
	}

}
?>