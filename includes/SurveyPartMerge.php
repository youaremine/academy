<?php
/*
 * Header: Create: 2007-6-26 Auther: Jamblues.
 */
class SurveyPartMerge
{
	var $db;
	var $supmId;
	var $newSupaId;
	var $oldSupaId;
	var $mergeDate;
	var $mergeUserId;
	var $mergeUserName;
	var $delFlag = 'no';
	function SurveyPartMerge($db)
	{
		$this->db = $db;
		$this->mergeDate = date("Y-m-d H:i:s");
	}
	
	/**
	 * 合并资料
	 *
	 * @return unknown
	 */
	function Save()
	{
		$sql = "INSERT INTO  Survey_SurveyPartMerge(newSupaId,oldSupaId,mergeDate,mergeUserId,mergeUserName,delFlag) " . " VALUES('" . $this->newSupaId . "'" . ",'" . $this->oldSupaId . "'" . ",'" . $this->mergeDate . "'" . ",'" . $this->mergeUserId . "'" . ",'" . $this->mergeUserName . "'" . ",'" . $this->delFlag . "')";
		// print($sql);
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}
	function Modify()
	{
		// $sql = "";
		// $this->db->query($sql);
	}
	
	/*
	 * 标记为删除
	 */
	function Del()
	{
		$sql = "UPDATE  Survey_SurveyPartMerge " . "SET delFlag = '" . $this->delFlag . "'" . "WHERE supmId = " . $this->supmId;
		$this->db->query($sql);
	}
	
	/*
	 * 标记为删除
	 */
	function DelByNew()
	{
		$sql = "UPDATE  Survey_SurveyPartMerge " . "SET delFlag = '" . $this->delFlag . "'" . "WHERE newSupaId = " . $this->newSupaId;
		// print $sql;
		$this->db->query($sql);
	}
	/*
	 * 恢复合并前的记录
	 */
	function RestoreMerge()
	{
		$sql = "SELECT oldSupaId FROM Survey_SurveyPartMerge " . " WHERE newSupaId=" . $this->newSupaId;
		$this->db->query($sql);
// 		echo $sql;
		$oldSupaIds = 0;
		while ( $row = $this->db->next_record () )
		{
			$oldSupaIds .= "," . $row['oldSupaId'];
		}
		$sql = "UPDATE Survey_SurveyPart " . " SET delFlag='no' " . " WHERE supaId IN (" . $oldSupaIds . ")";
// 		echo $sql;exit();
		$this->db->query($sql);
	}
	
	/*
	 * 彻底删除资料，不能恢复
	 */
	function RealDel()
	{
		$sql = "DELETE FROM Survey_SurveyPartMerge " . "WHERE supmId = " . $this->supmId;
		$this->db->query($sql);
	}
	
	/*
	 * 彻底删除资料，不能恢复
	 */
	function RealDelByNew()
	{
		$sql = "DELETE FROM Survey_SurveyPartMerge " . "WHERE newSupaId = " . $this->newSupaId;
		$this->db->query($sql);
	}
	
	/*
	 * 撤消合并
	 */
	function UnMerge()
	{
		$this->RestoreMerge();
		$this->DelByNew();
	}
}
?>
