<?php
/*
 * Header: Create: 2008-9-18 Auther: Jamblues.
 */
class SurveyorLogin
{
	var $db;
	var $userName;
	var $passWord;
	var $surveyor;
	function SurveyorLogin($db)
	{
		$this->db = $db;
		$this->surveyor = new Surveyor();
	}
	
	/**
	 * 用户登录
	 * 
	 * @access public
	 */
	function Login($userName, $passWord)
	{
		$this->userName = $userName;
		$this->passWord = $passWord;
		if (trim($this->userName == '') && trim($this->passWord) == '')
		{
			return false;
		}

		global $conf;
		$db = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
		$db2 = new DataBase($conf["dbConnectStr"]["BusSurvey"]);
		$sql = "SELECT S.*,SP.password FROM Survey_Surveyor S
		 LEFT JOIN Survey_SurveyorPassword SP on SP.survId=S.survId
		 WHERE status='active' AND contact = '{$this->userName}' ";
		$db->query($sql);

		if ( $a = $db->next_record() )
		{

			$this->surveyor->survId = $db->Record['survId'];
			if ($db->Record['password'] == "") // 未设置过密码，还是原来密码的
			{
				$firstCheck = substr(substr($this->userName,0,4)*666,0,3);
				if($firstCheck == $this->passWord){
					$sql = "SELECT * FROM  Survey_Surveyor " . "WHERE contact = '" . $this->userName . "'";
					$db2->query($sql);
					if ($rs = $db2->next_record() )
					{
						$this->surveyor->selfBefore = $rs['selfBefore'];
						//檢測是否做過5次以上的調查,沒有做過標記爲不允許做
						$ms = new MainSchedule();
						$msa = new MainScheduleAccess($db);
						$ms->surveyorCode = $this->surveyor->survId;
						$rsJob = $msa->GetListSearch($ms);
						$rsNum = count($rsJob);
						$rsNum = $rsNum + $rs['lastYearSurveyTimes']; //加上一年的做的次數
						if($rsNum < 5){
							$this->surveyor->selfBefore = date("Y-m-d",time()+846000);
						}
						// 将登录后的信息保存到session.
						$this->SaveSession();
						return true;
					}
				}

// 				echo $db2->num_rows()."<br />";
// 				print $sql;exit();


			}
			else // 已设置过自己的密码
			{
				// 输入的密码与自己设置的密码相同
				if ($db->Record['password'] == $this->passWord)
				{
					$this->SaveSession();
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * 将登录后的信息保存到session.
	 * 
	 * @access private
	 */
	function SaveSession()
	{
		$_SESSION['surveyorId'] = $this->surveyor->survId;
		$_SESSION['surveyorSelfBefore'] = $this->surveyor->selfBefore;
	}
	
	/**
	 * 得到登录人的ID
	 */
	function GetLoginId()
	{
		return $_SESSION['surveyorId'];
	}
	
	/**
	 * 清除所有session
	 * 
	 * @access public
	 */
	function Logout()
	{
		unset($_SESSION['surveyorId']);
	}
	
	/**
	 * 更改密码
	 * 
	 * @access public
	 */
	function UpdatePassword($surveyorId, $newPassword)
	{
		$sql = "SELECT * FROM Survey_SurveyorPassword " . " WHERE survId = '" . $surveyorId . "'";
		$this->db->query($sql);
		if ($this->db->num_rows() > 0)
		{
			$sql = "UPDATE  Survey_SurveyorPassword " . " SET password = '" . $newPassword . "'" . " WHERE survId = '" . $surveyorId . "'";
			;
		}
		else
		{
			$sql = "INSERT INTO  Survey_SurveyorPassword(survId,password) " . " VALUES('" . $surveyorId . "','" . $newPassword . "')";
		}
		$this->db->query($sql);
	}
	
	/**
	 * 重置密码
	 *
	 * @param number $surveyorId        	
	 */
	function ResetPassword($surveyorId)
	{
		$sql = "DELETE FROM Survey_SurveyorPassword " . " WHERE survId = '" . $surveyorId . "'";
		$this->db->query($sql);
	}
	
	/**
	 * 检查是否已经登录
	 * 
	 * @access public
	 */
	static function IsLogin()
	{
		if (isset($_SESSION['surveyorId']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>
