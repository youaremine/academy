<?php
/*
 * Header: Create: 2009-04-07 Auther: Jamblues@gmail.com
 */
class MainScheduleRawFileAccess {
	var $db;
	function MainScheduleRawFileAccess($db) {
		$this->db = $db;
	}
	function Add($obj) {
		$sql = "INSERT INTO  Survey_MainScheduleRawFile(jobNoNew,fileType,fileName,downloadTimes,modifyUserId,modifyUsername,modifyTime,delFlag)" . " VALUES('" . $obj->jobNoNew . "'" . ",'" . $obj->fileType . "'" . ",'" . $obj->fileName . "'" . ",'" . $obj->downloadTimes . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyUsername . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $this->db->last_insert_id ();
	}
	
	/**
	 * 完整插入,包括自增量ID
	 *
	 * @param obj $obj        	
	 * @return mrsfId
	 */
	function AddFull($obj) {
		$sql = "INSERT INTO  Survey_MainScheduleRawFile(msrfId,jobNoNew,fileType,fileName,downloadTimes,modifyUserId,modifyUsername,modifyTime,delFlag)" . " VALUES('" . $obj->msrfId . "'" . ",'" . $obj->jobNoNew . "'" . ",'" . $obj->fileType . "'" . ",'" . $obj->fileName . "'" . ",'" . $obj->downloadTimes . "'" . ",'" . $obj->modifyUserId . "'" . ",'" . $obj->modifyUsername . "'" . ",'" . $obj->modifyTime . "'" . ",'" . $obj->delFlag . "'" . ")";
		$this->db->query ( $sql );
		return $obj->msrfId;
	}
	function Update($obj) {
		$sql = "UPDATE Survey_MainScheduleRawFile " . " SET jobNoNew = '" . $obj->jobNoNew . "'" . " ,fileType = '" . $obj->fileType . "'" . " ,fileName = '" . $obj->fileName . "'" . " ,downloadTimes = '" . $obj->downloadTimes . "'" . " ,modifyUserId = '" . $obj->modifyUserId . "'" . " ,modifyUsername = '" . $obj->modifyUsername . "'" . " ,modifyTime = '" . $obj->modifyTime . "'" . " ,delFlag = '" . $obj->delFlag . "'" . " WHERE 1=1  AND msrfId = '" . $obj->msrfId . "'";
		$this->db->query ( $sql );
	}
	function Del($obj) {
		$sql = "UPDATE Survey_MainScheduleRawFile " . " SET delFlag='yes' " . " WHERE 1=1  AND msrfId = '" . $obj->msrfId . "'";
		$this->db->query ( $sql );
	}
	function RealDel($obj) {
		$sql = "DELETE FROM Survey_MainScheduleRawFile " . " WHERE 1=1  AND msrfId = '" . $obj->msrfId . "'";
		$this->db->query ( $sql );
	}
	function GetListSearch($obj) {
		$query = '';
		if ($obj->msrfId != '')
			$query .= " AND msrfId = '" . $obj->msrfId . "'";
		if ($obj->jobNoNew != '')
			$query .= " AND jobNoNew = '" . $obj->jobNoNew . "'";
		if ($obj->fileType != '')
			$query .= " AND fileType = '" . $obj->fileType . "'";
		if ($obj->fileName != '')
			$query .= " AND fileName = '" . $obj->fileName . "'";
		if ($obj->downloadTimes != '')
			$query .= " AND downloadTimes = '" . $obj->downloadTimes . "'";
		if ($obj->modifyUserId != '')
			$query .= " AND modifyUserId = '" . $obj->modifyUserId . "'";
		if ($obj->modifyUsername != '')
			$query .= " AND modifyUsername = '" . $obj->modifyUsername . "'";
		if ($obj->modifyTime != '')
			$query .= " AND modifyTime = '" . $obj->modifyTime . "'";
		if ($obj->delFlag != '')
			$query .= " AND delFlag = '" . $obj->delFlag . "'";
		if ($obj->order != '')
			$query .= " " . $obj->order;
		if ($obj->pageLimit != '')
			$query .= " " . $obj->pageLimit;
		
		$sql = "SELECT * FROM Survey_MainScheduleRawFile " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query ( $sql );
		$rows = array ();
		while ( $rs = $this->db->next_record () ) {
			$obj = new MainScheduleRawFile ();
			$obj->msrfId = $rs ["msrfId"];
			$obj->jobNoNew = $rs ["jobNoNew"];
			$obj->fileType = $rs ["fileType"];
			$obj->fileName = $rs ["fileName"];
			$obj->downloadTimes = $rs ["downloadTimes"];
			$obj->modifyUserId = $rs ["modifyUserId"];
			$obj->modifyUsername = $rs ["modifyUsername"];
			$obj->modifyTime = $rs ["modifyTime"];
			$obj->delFlag = $rs ["delFlag"];
			$rows [] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 更新远程服务器上的资料
	 *
	 * @param obj $obj        	
	 */
	function UpdateRomoteData($obj) {
		global $conf;
		$queryString = "form=ozzomap";
		$queryString .= "&msrfId=" . $obj->msrfId;
		$queryString .= "&jobNoNew=" . $obj->jobNoNew;
		$queryString .= "&fileType=" . $obj->fileType;
		$queryString .= "&fileName=" . urlencode ( $obj->fileName );
		$queryString .= "&downloadTimes=" . $obj->downloadTimes;
		$queryString .= "&modifyUserId=" . $obj->modifyUserId;
		$queryString .= "&modifyUsername=" . urlencode ( $obj->modifyUsername );
		$queryString .= "&modifyTime=" . urlencode ( $obj->modifyTime );
		$queryString .= "&delFlag=" . $obj->delFlag;
		$url = $conf ["plugin"] ["romote_pdf_url"] . "?" . $queryString;
		// echo $url."<br />";
		return file_get_contents ( $url );
		
		// $ch = curl_init();
		// $timeout = 8;
		// curl_setopt ($ch, CURLOPT_URL, $url);
		// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		// curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/6.0");
		// $file_contents = curl_exec($ch);
		// curl_close($ch);
		// return $file_contents;
	}
}
?>