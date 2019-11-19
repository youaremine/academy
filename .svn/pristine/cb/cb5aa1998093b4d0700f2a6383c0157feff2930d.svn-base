<?php
/*
 * Header: Create: 2008-06-01 Auther: Jamblues@gmail.com.
 */
class SendMailHistoryAccess {
	var $db;
	function SendMailHistoryAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_SendMailHistory(sendType,keyId,receiverUserId,receiverName,receiverMail,senderUserId,senderName,senderMail,sendTime,sendSubject,sendContent)" . " VALUES('" . $obj->sendType . "'" . ",'" . $obj->keyId . "'" . ",'" . $obj->receiverUserId . "'" . ",'" . $obj->receiverName . "'" . ",'" . $obj->receiverMail . "'" . ",'" . $obj->senderUserId . "'" . ",'" . $obj->senderName . "'" . ",'" . $obj->senderMail . "'" . ",'" . $obj->sendTime . "'" . ",'" . $obj->sendSubject . "'" . ",'" . $obj->sendContent . "'" . ")";
		$this->db->query ( $sql );
		// print $sql;
		return $this->db->last_insert_id ();
	}
	function Update($obj) {
		$sql = "UPDATE Survey_SendMailHistory " . " SET sendType = '" . $obj->sendType . "'" . " ,keyId = '" . $obj->keyId . "'" . " ,receiverUserId = '" . $obj->receiverUserId . "'" . " ,receiverName = '" . $obj->receiverName . "'" . " ,receiverMail = '" . $obj->receiverMail . "'" . " ,senderUserId = '" . $obj->senderUserId . "'" . " ,senderName = '" . $obj->senderName . "'" . " ,senderMail = '" . $obj->senderMail . "'" . " ,sendTime = '" . $obj->sendTime . "'" . " ,sendSubject = '" . $obj->sendSubject . "'" . " ,sendContent = '" . $obj->sendContent . "'" . " WHERE 1=1  AND semhId = '" . $obj->semhId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_SendMailHistory " . " SET delFlag='yes' " . " WHERE 1=1  AND semhId = '" . $obj->semhId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_SendMailHistory " . " WHERE 1=1  AND semhId = '" . $obj->semhId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->semhId != '')
			$query .= " AND semhId = '" . $obj->semhId . "'";
		if ($obj->sendType != '')
			$query .= " AND sendType = '" . $obj->sendType . "'";
		if ($obj->keyId != '')
			$query .= " AND keyId = '" . $obj->keyId . "'";
		if ($obj->receiverUserId != '')
			$query .= " AND receiverUserId = '" . $obj->receiverUserId . "'";
		if ($obj->receiverName != '')
			$query .= " AND receiverName = '" . $obj->receiverName . "'";
		if ($obj->receiverMail != '')
			$query .= " AND receiverMail = '" . $obj->receiverMail . "'";
		if ($obj->senderUserId != '')
			$query .= " AND senderUserId = '" . $obj->senderUserId . "'";
		if ($obj->senderName != '')
			$query .= " AND senderName = '" . $obj->senderName . "'";
		if ($obj->senderMail != '')
			$query .= " AND senderMail = '" . $obj->senderMail . "'";
		if ($obj->sendTime != '')
			$query .= " AND sendTime = '" . $obj->sendTime . "'";
		if ($obj->sendSubject != '')
			$query .= " AND sendSubject = '" . $obj->sendSubject . "'";
		if ($obj->sendContent != '')
			$query .= " AND sendContent = '" . $obj->sendContent . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_SendMailHistory " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new SendMailHistory ();
			$obj->semhId = $rs ["semhId"];
			$obj->sendType = $rs ["sendType"];
			$obj->keyId = $rs ["keyId"];
			$obj->receiverUserId = $rs ["receiverUserId"];
			$obj->receiverName = $rs ["receiverName"];
			$obj->receiverMail = $rs ["receiverMail"];
			$obj->senderUserId = $rs ["senderUserId"];
			$obj->senderName = $rs ["senderName"];
			$obj->senderMail = $rs ["senderMail"];
			$obj->sendTime = $rs ["sendTime"];
			$obj->sendSubject = $rs ["sendSubject"];
			$obj->sendContent = $rs ["sendContent"];
			$rows [] = $obj;
		}
		return $rows;
	}
}
?>