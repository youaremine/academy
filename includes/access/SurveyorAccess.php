<?php
/*
 * Header: 
 * Create: 2007-08-12 
 * Auther: Jamblues.
 */
class SurveyorAccess
{
	var $db;
	function SurveyorAccess($db)
	{
		$this->db = $db;
	}
	
	/**
	 * 添加
	 * @param Surveyor $obj
	 */
	function Add($obj)
	{
		$sql = "INSERT INTO Survey_Surveyor(				
				upSurvId,
				ozzoCode,
				chiName,
				engName, 
				contact, 
				survHome, 
				dipaCode, 
				IsSupervisor, 
				personalRecord, 
				bank, 
				accountNo, 
				VIP, 
				whatsAPP, 
				email, 
				fax, 
				remarks,
				company,
				birthday,
				survType,
				status,
				selfBefore,
				lastYearSurveyTimes,
				inputUserId,
				vip_level,
				avatar,
				inputTime
				) VALUES('{$obj->upSurvId}','{$obj->ozzoCode}','{$obj->chiName}','{$obj->engName}','{$obj->contact}','{$obj->survHome}','{$obj->dipaCode}','{$obj->IsSupervisor}'
				,'{$obj->personalRecord}','{$obj->bank}','{$obj->accountNo}','{$obj->VIP}','{$obj->whatsAPP}','{$obj->email}'
				,'{$obj->fax}','{$obj->remarks}','{$obj->company}','{$obj->birthday}','{$obj->survType}','{$obj->status}'
				,'{$obj->selfBefore}','{$obj->lastYearSurveyTimes}','{$obj->inputUserId}','{$obj->vip_level}','{$obj->avatar}','{$obj->inputTime}')";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}
	
	/**
	 * 更新
	 * @param Surveyor $obj
	 */
	function Update($obj)
	{
		$sql = "UPDATE Survey_Surveyor 
					SET upSurvId = '{$obj->upSurvId}',ozzoCode = '{$obj->ozzoCode}',chiName = '{$obj->chiName}',engName = '{$obj->engName}',contact = '{$obj->contact}',survHome = '{$obj->survHome}'
					,dipaCode = '{$obj->dipaCode}',IsSupervisor = '{$obj->IsSupervisor}',personalRecord = '{$obj->personalRecord}',bank = '{$obj->bank}'
					,accountNo = '{$obj->accountNo}',VIP = '{$obj->VIP}',whatsAPP = '{$obj->whatsAPP}',email = '{$obj->email}',fax = '{$obj->fax}'
					,remarks = '{$obj->remarks}',birthday = '{$obj->birthday}',company = '{$obj->company}',status = '{$obj->status}',survType = '{$obj->survType}',vip_level = '{$obj->vip_level}',avatar = '{$obj->avatar}'
					,updateUserId = '{$obj->updateUserId}',updateTime = '{$obj->updateTime}',selfBefore = '{$obj->selfBefore}',lastYearSurveyTimes = '{$obj->lastYearSurveyTimes}' WHERE 1=1  AND survId = '{$obj->survId}'";
		$this->db->query($sql);
	}

	function InsertAdd($oldDb, $currDb, $obj)
	{
		$sql = "REPLACE INTO {$oldDb}.Survey_Surveyor
				SELECT * FROM {$currDb}.Survey_Surveyor 
				WHERE 1=1 AND survId = '" . $obj->survId . "'";
		$this->db->query($sql);
	}
	
	function Del($obj)
	{
		$sql = "UPDATE Survey_Surveyor " . " SET delFlag='yes' " . " WHERE 1=1  AND survId = '" . $obj->survId . "'";
		$this->db->query($sql);
	}
	
	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_Surveyor " . " WHERE 1=1  AND survId = '" . $obj->survId . "'";
		$this->db->query($sql);
	}
	
	function EmptyTable()
	{
		$sql = "TRUNCATE TABLE Survey_Surveyor ";
		$this->db->query($sql);
	}
	
	/**
	 * 
	 * @param Surveyor $obj
	 * @return array:Surveyor
	 */
	function GetListSearch($obj)
	{

		$query = '';
		if ($obj->survId != '')
			$query .= " AND s.survId = '" . $obj->survId . "'";
		if ($obj->upSurvId != '')
			$query .= " AND s.upSurvId = '" . $obj->upSurvId . "'";
		if ($obj->ozzoCode != '')
			$query .= " AND s.ozzoCode = '" . $obj->ozzoCode . "'";
		if ($obj->engName != '')
		{
			$query .= " AND (s.engName LIKE '%{$obj->engName}%' OR s.chiName LIKE '%{$obj->engName}%')";
		}
		if ($obj->singleContact != '')
			$query .= " AND s.contact = '" . $obj->singleContact . "'";
		elseif ($obj->contact != '')
			$query .= " AND s.contact LIKE '%" . $obj->contact . "%'";
		if ($obj->survHome != '')
			$query .= " AND s.survHome = '" . $obj->survHome . "'";
		if ($obj->dipaCode != '')
			$query .= " AND s.dipaCode = '" . $obj->dipaCode . "'";
		if ($obj->IsSupervisor != '')
			$query .= " AND s.IsSupervisor = '" . $obj->IsSupervisor . "'";
		if ($obj->bank != '')
			$query .= " AND s.bank = '" . $obj->bank . "'";
		if ($obj->whatsAPP != '')
			$query .= " AND s.whatsAPP = '" . $obj->whatsAPP . "'";
		if ($obj->email != '')
			$query .= " AND s.email = '" . $obj->email . "'";
		if ($obj->fax != '')
			$query .= " AND s.fax = '" . $obj->fax . "'";
		if ($obj->company != '')
			$query .= " AND s.company = '" . $obj->company . "'";
		if ($obj->status != '')
			$query .= " AND s.status = '" . $obj->status . "'";
		if ($obj->survType != '')
			$query .= " AND s.survType = '" . $obj->survType . "'";
		if ($obj->survMultiType != '')
			$query .= " AND s.survType IN(" . $obj->survMultiType . ")";
		if ($obj->order != '')
			$query .= $obj->order;
		if ($obj->pageLimit != '')
			$query .= $obj->pageLimit;
		
		$sql = "SELECT s.*,u.engName AS inputUsername,u2.engName AS updateUsername
					FROM Survey_Surveyor s
				LEFT JOIN Survey_Users u ON s.inputUserId = u.userId 
				LEFT JOIN Survey_Users u2 ON s.updateUserId = u2.userId
				WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query($sql);
// 		echo $sql;
// 		exit();
		$rows = array();
		while ( $rs = $this->db->next_record() )
		{
			$obj = new Surveyor();
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
			$obj->status = $rs["status"];
			$obj->survType = $rs["survType"];
			$obj->inputUserId = $rs["inputUsername"];
			$obj->inputTime = $rs["inputTime"];
			$obj->updateUserId = $rs["updateUsername"];
			$obj->updateTime = $rs["updateTime"];
			$obj->selfBefore = $rs["selfBefore"];
			$obj->lastYearSurveyTimes = $rs["lastYearSurveyTimes"];
			$obj->profilePhoto = $rs["profilePhoto"];
            $obj->class_sum = $rs["class_sum"];
            $obj->vip_level = $rs["vip_level"];
            $obj->class_remain = $rs["class_remain"];
            $obj->avatar = $rs["avatar"];
			$rows[] = $obj;
		}

		return $rows;
	}
	
	/**
	 * 是否存在
	 * 
	 * @param Surveyor $obj        	
	 * @return int
	 */
	function IsExist($obj)
	{
		$query = '';
		if ($obj->survId != '')
			$query .= " AND survId != '" . $obj->survId . "'";
		if ($obj->engName != '' && $obj->contact != '')
		{
			$query .= " AND (engName = '" . $obj->engName . "' OR contact = '" . $obj->contact . "')";
		}
		else
		{
			if ($obj->engName != '')
				$query .= " AND engName = '" . $obj->engName . "'";
			if ($obj->contact != '')
				$query .= " AND contact = '" . $obj->contact . "'";
		}
		if ($obj->survType != '')
			$query .= " AND survType = '{$obj->survType}'";
		
		$sql = "SELECT * FROM Survey_Surveyor " . " WHERE 1=1 ";

		$sql = $sql . $query;
		$this->db->query($sql);

		$had = false;

		if ($rs = $this->db->next_record() )
		{
            $had = true;
			return $rs["survId"];
		}
		else{
            return $had;
        }

	}
	
	/**
	 *
	 * @param Sruveyor $obj        	
	 * @param string $workMonth        	
	 * @return array:Surveyor
	 */
	function GetFullListSearch($obj, $workMonth)
	{
		$query = '';
		if ($obj->survId != '')
			$query .= " AND s.survId = '" . $obj->survId . "'";
		if ($obj->chiName != '')
			$query .= " AND s.chiName LIKE '%" . $obj->chiName . "%'";
		if ($obj->engName != ''){
			$query .= " AND (engName LIKE '%{$obj->engName}%' OR chiName LIKE '%{$obj->engName}%' )";
		}
		if ($obj->contact != '')
			$query .= " AND s.contact LIKE '%" . $obj->contact . "%'";
		if ($obj->survHome != '')
			$query .= " AND s.survHome = '" . $obj->survHome . "'";
		if ($obj->dipaCode != '')
			$query .= " AND s.dipaCode = '" . $obj->dipaCode . "'";
		if ($obj->company != '')
			$query .= " AND s.company = '" . $obj->company . "'";
		if ($obj->status != '')
			$query .= " AND s.status = '" . $obj->status . "'";
		if ($obj->survType != '')
			$query .= " AND s.survType = '" . $obj->survType . "'";
		if ($obj->IsSupervisor != '')
		{
			if ($obj->IsSupervisor == '000')
			{
				$query .= " AND s.IsSupervisor = ''";
			}
			else
			{
				$query .= " AND s.IsSupervisor = '" . $obj->IsSupervisor . "'";
			}
		}
		if ($obj->bank != '')
			$query .= " AND bank = '" . $obj->bank . "'";
		if ($obj->whatsAPP != '')
			$query .= " AND whatsAPP = '" . $obj->whatsAPP . "'";
		if ($obj->email != '')
			$query .= " AND email = '" . $obj->email . "'";
		if ($obj->fax != '')
			$query .= " AND fax = '" . $obj->fax . "'";
		if ($obj->order != '')
			$query .= $obj->order;
		if ($obj->pageLimit != '')
			$query .= $obj->pageLimit;
		
		$sql = "SELECT s.* FROM Survey_Surveyor s
		LEFT JOIN Survey_SurveyorWorkHour swh ON swh.survId=s.survId AND workMonth='{$workMonth}'" . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query($sql);
		// echo $sql;
		$rows = array();
		while ( $rs = $this->db->next_record() )
		{
			$obj = new Surveyor();
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
			$obj->company = $rs["company"];
			$obj->status = $rs["status"];
			$obj->survType = $rs["survType"];
			$obj->inputUserId = $rs["inputUserId"];
			$obj->inputTime = $rs["inputTime"];
			$obj->updateUserId = $rs["updateUserId"];
			$obj->updateTime = $rs["updateTime"];
			$rows[] = $obj;
		}
		return $rows;
	}
	
	function GetListSearchCount($obj)
	{
		$query = '';
		if ($obj->survId != '')
			$query .= " AND survId = '" . $obj->survId . "'";
		if ($obj->chiName != '')
			$query .= " AND chiName LIKE '%" . $obj->chiName . "%'";
		if ($obj->engName != ''){
			$query .= " AND (engName LIKE '%{$obj->engName}%' OR chiName LIKE '%{$obj->engName}%' )";
		}
		if ($obj->contact != '')
			$query .= " AND contact LIKE '%" . $obj->contact . "%'";
		if ($obj->survHome != '')
			$query .= " AND survHome = '" . $obj->survHome . "'";
		if ($obj->dipaCode != '')
			$query .= " AND dipaCode = '" . $obj->dipaCode . "'";
		if ($obj->company != '')
			$query .= " AND company = '" . $obj->company . "'";
		if ($obj->status != '')
			$query .= " AND status = '" . $obj->status . "'";
		if ($obj->survType != '')
			$query .= " AND survType = '" . $obj->survType . "'";
		if ($obj->IsSupervisor != '')
		{
			if ($obj->IsSupervisor == '000')
			{
				$query .= " AND IsSupervisor = ''";
			}
			else
			{
				$query .= " AND IsSupervisor = '" . $obj->IsSupervisor . "'";
			}
		}
		if ($obj->bank != '')
			$query .= " AND bank = '" . $obj->bank . "'";
		if ($obj->whatsAPP != '')
			$query .= " AND whatsAPP = '" . $obj->whatsAPP . "'";
		if ($obj->email != '')
			$query .= " AND email = '" . $obj->email . "'";
		if ($obj->fax != '')
			$query .= " AND fax = '" . $obj->fax . "'";
		
		$sql = "SELECT COUNT(*) AS rowNum FROM Survey_Surveyor " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query($sql);
		$rowNum = 0;
		if ($rs = $this->db->next_record())
		{
			$rowNum = $rs['rowNum'];
		}
		return $rowNum;
	}
	
	/**
	 *
	 * Get surveyor free time.
	 * 
	 * @param $obj Surveyor        	
	 */
	function GetTimeListSearch($obj)
	{
		$query = '';
		if ($obj->survId != '')
			$query .= " AND s.survId = '" . $obj->survId . "'";
		if ($obj->chiName != '')
			$query .= " AND s.chiName LIKE '%" . $obj->chiName . "%'";
		if ($obj->engName != ''){
			$query .= " AND (s.engName LIKE '%{$obj->engName}%' OR s.chiName LIKE '%{$obj->engName}%' )";
		}
		if ($obj->contact != '')
			$query .= " AND s.contact = '" . $obj->contact . "'";
		if ($obj->survHome != '')
			$query .= " AND s.survHome = '" . $obj->survHome . "'";
		if ($obj->dipaCode != '')
			$query .= " AND s.dipaCode = '" . $obj->dipaCode . "'";
		if ($obj->startTime != '')
			$query .= " AND sft.startTime >= '" . $obj->startTime . "'";
		if ($obj->endTime != '')
			$query .= " AND sft.endTime < '" . $obj->endTime . "'";
		if ($obj->order != '')
			$query .= $obj->order;
		
		$sql = "SELECT s.*,sft.sftiId,sft.startTime,sft.endTime,sft.isFree,sft.remarks AS freeTimeRemarks FROM Survey_Surveyor s
		INNER JOIN Survey_SurveyorFreeTime sft ON sft.survId = s.survId
		WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query($sql);
//		 echo $sql;
//		 exit();
		$rows = array();
		while ( $rs = $this->db->next_record() )
		{
			$obj = new Surveyor();
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
			$obj->company = $rs["company"];
			$obj->status = $rs["status"];
			$obj->sftiId = $rs["sftiId"];
			$obj->startTime = $rs["startTime"];
			$obj->endTime = $rs["endTime"];
			$obj->isFree = $rs["isFree"];
			$obj->survType = $rs["survType"];
			$obj->freeTimeRemarks = $rs["freeTimeRemarks"];
			$rows[] = $obj;
		}
		return $rows;
	}
	
	/**
	 * 计算分数
	 * 
	 * @param array $arrMainSchedule
	 *        	MainSchedule信息
	 * @param array $arrSurveyor
	 *        	调查员信息
	 * @param array $arrScale
	 *        	计分比例
	 */
	function CalcSource($arrMainSchedule, $arrSurveyor, $arrScale)
	{
		$source = 0;
		// 跨區車費津貼
		$arrFee = getArray('location-district-fee');
		$source -= $arrFee['day'][$arrMainSchedule["surveyLocationDistrict"] . "->" . $arrSurveyor["dipaCode"]] * $arrScale["surveyLocationDistrict"];
		// 余下小時數
		$leaveHour = $arrSurveyor["lastMonthWorkHour"] - $arrSurveyor["currMonthWorkHour"];
		if ($leaveHour <= 0)
		{
			$leaveHour = 0;
		}
		else
		{
			$source += ($leaveHour / $arrMainSchedule["currMonthEstimatedManHour"]) * $arrScale["monthWorkHour"];
		}
		// 是否優先排序(如長工之類)
		if (!empty($arrSurveyor["order"]))
		{
			$source += $arrSurveyor["order"] * $arrScale["surveyorOrder"];
		}
		return round($source, 1);
	}
	
	/**
	 * 根据月份获取工作时间
	 * 
	 * @param string $survId
	 *        	调查员ID
	 * @param string $workMonth
	 *        	工作月份(如:2012-03)
	 * @return number totalWorkHour 当前月份已委派时间
	 */
	function GetWorkHour($survId, $workMonth)
	{
		$query = '';
		$query .= " AND survId = '{$survId}'";
		$query .= " AND workMonth = '{$workMonth}'";
		
		$sql = "SELECT totalWorkHour,lastTotalWorkHour,canAssignHour FROM Survey_SurveyorWorkHour " . " WHERE 1=1 ";
		$sql = $sql . $query;
		// echo "{$sql}<br />";
		$this->db->query($sql);
		$monthWorkHour = array();
		if ($rs = $this->db->next_record())
		{
			$monthWorkHour["totalWorkHour"] = $rs['totalWorkHour'];
			$monthWorkHour["lastTotalWorkHour"] = $rs['lastTotalWorkHour'];
			$monthWorkHour["canAssignHour"] = $rs['canAssignHour'];
		}
		return $monthWorkHour;
	}


	function assign_new($sur, $jobNoNew,$surInfo){
        $infoSql = "SELECT realClass FROM Survey_MainSchedule where jobNoNew = '{$jobNoNew}'";
        $this->db->query($infoSql);
        /*if($this->db->next_record () == 1){
            if($sur->class_remain <=0 ) {
                return array('msg'=>'剩餘課堂數不足，選取失敗','status'=>'failed');
            }
        }*/

        $sql = "INSERT INTO Survey_SurveyorMainSchedule(survId,jobNoNew,inputUserId,inputTime)" . " VALUES('" . $sur->survId . "'" . ",'" . $jobNoNew . "'" . ",'0'" . ",'" . date("Y-m-d H:i:s") . "'" . ")";
        $this->db->query($sql);
        $msa = new MainScheduleAccess($this->db);
        $msa->Assign2Surveyor($sur, $jobNoNew,false,$surInfo);
        return true;
    }

	/**
	 * 委派工作
	 * 
	 * @param Surveyor $sur
	 * @param int $mascId
	 */
	function Assign($sur, $jobNoNew,$jobNo = false,$editId = false,$surInfo = false)
	{
        if($sur->class_remain <=0 ){
            $message = array (
                'status' => 'failed',
                'msg' => '剩餘課堂數不足，選取失敗',
                'data' => array()
            );
            die(json_encode($message));
        }/*else{
            $used_class_num_sql = "SELECT count(mascId) as class_num_sql FROM Survey_MainSchedule " . " WHERE 1=1  AND surveyorCode = ".$sur->survId ." and (actualSurveyDate < '".date('Y-m-d')."' or (actualSurveyDate = '".date('Y-m-d')."' and endTime_1 <= '".date('H:i:s')."'))";
            $this->db->query ( $used_class_num_sql );
            while ( $rs = $this->db->next_record () ) {
                $used_class_num = $sur->class_sum - $rs['class_num_sql'];
            }
            if($used_class_num <= 0 ){
                $message = array (
                    'status' => 'failed',
                    'msg' => '剩餘課堂數不足，選取失敗',
                    'data' => array()
                );
                die(json_encode($message));
            }
        }*/

		//$assignHour = 0;
		//$delSql = "UPDATE Survey_SurveyorMainSchedule SET delFlag='yes' WHERE ";
		if($jobNo != false){

            $selectSql = 'SELECT mascId FROM Survey_MainSchedule WHERE jobNo= "'.$jobNo.'" and surveyorCode='.$sur->survId;
            $this->db->query ( $selectSql );
            $rows = array ();
            while ( $this->db->next_record () ) {
                $rows = $this->db->Record;
            }
            if(!empty($rows)){
                return false;
            }
        }
		if (is_array($jobNoNew))
		{
			$sql = "INSERT INTO Survey_SurveyorMainSchedule(survId,jobNoNew,inputUserId,inputTime)" . " VALUES";
			$i = 0;
			//$delSqlWhere = "jobNoNew IN ('0'";
			foreach ( $jobNoNew as $v )
			{
				if ($i > 0)
				{
					$sql .= ",";
				}
				$sql .= "('{$sur->survId}','{$v}','{$_SESSION['userId']}','" . date("Y-m-d H:i:s") . "')";
				//$delSqlWhere .= ",'{$v}'";
				$i++;
			}
			//$delSqlWhere .= ")";
		}
		else
		{
			$sql = "INSERT INTO Survey_SurveyorMainSchedule(survId,jobNoNew,inputUserId,inputTime)" . " VALUES('" . $sur->survId . "'" . ",'" . $jobNoNew . "'" . ",'" . $_SESSION['userId'] . "'" . ",'" . date("Y-m-d H:i:s") . "'" . ")";
			//$delSqlWhere = " jobNoNew='{$jobNoNew}'";
		}
		//$delSql .= $delSqlWhere;
// 		echo $delSql;exit();
		//$this->db->query($delSql);
		$this->db->query($sql);
		
		// 更新MainSchedule
		//$ms = new MainSchedule();
		//$ms->jobNoNew = $jobNoNew;
		$msa = new MainScheduleAccess($this->db);
		$msa->Assign2Surveyor($sur, $jobNoNew,false,$surInfo);
		//$assignHour = $msa->GetEstimatedManHour($ms);
		//$assignHour = 0 - $assignHour;

		// 更新MainScheduleOpen
		//$msoa = new MainScheduleOpenAccess($this->db);
		//$msoa->UpdateAllStatus($sur->survId, $jobNoNew);
		
		// 更新統計時間
		//$this->UpdateSingleSurveyorWorkHour($sur->survId, $assignHour);
		
		return $this->db->last_insert_id();
	}

    /*
     * 取消分配課堂（）
     *
     * */
    function UnAssign_new($sur, $jobNoNew,$record_surveyor = false)
    {

        // 更新MainSchedule
        $ms = new MainSchedule();
        $ms->jobNoNew = $jobNoNew;
        $msa = new MainScheduleAccess($this->db);
        $res = $msa->UnAssign2Surveyor($sur, $jobNoNew,$record_surveyor);


        if($res != false){
            $sql = "UPDATE Survey_SurveyorMainSchedule SET delFlag='yes'
		WHERE survId ='{$sur->survId}' AND jobNoNew='{$jobNoNew}'";
            $this->db->query($sql);
        }else{
            return false;
        }
        // 更新MainSchedule
        //$ms = new MainSchedule();
        //$ms->jobNoNew = $jobNoNew;
        //$msa = new MainScheduleAccess($this->db);
        //$msa->UnAssign2Surveyor($sur, $jobNoNew);
        //$assignHour = $msa->GetEstimatedManHour($ms);

        // 更新統計時間
        //$this->UpdateSingleSurveyorWorkHour($sur->survId, $assignHour);
    }

	/**
	 * 撤消委派工作
	 * 
	 * @param Surveyor $sur        	
	 * @param int $mascId        	
	 */
	function UnAssign($sur, $jobNoNew)
	{
		$sql = "UPDATE Survey_SurveyorMainSchedule SET delFlag='yes'
		WHERE survId ='{$sur->survId}' AND jobNoNew='{$jobNoNew}'";
		$this->db->query($sql);
		
		// 更新MainSchedule
		$ms = new MainSchedule();
		$ms->jobNoNew = $jobNoNew;
		$msa = new MainScheduleAccess($this->db);
		$msa->UnAssign2Surveyor($sur, $jobNoNew);
		//$assignHour = $msa->GetEstimatedManHour($ms);
		
		// 更新統計時間
		//$this->UpdateSingleSurveyorWorkHour($sur->survId, $assignHour);
	}
	
	/**
	 * 更新SurveyorWorkHour本月的统计
	 */
	function UpdateSurveyorWorkHour()
	{
		$workMonth = date("Y-m");
		$sql = "DELETE FROM Survey_SurveyorWorkHour WHERE workMonth='{$workMonth}'";
		$this->db->query($sql);
		
		$lastWorkMonthTime = mktime(0, 0, 0, date("m") - 1, 1, date("Y"));
		$lastWorkMonthStart = date("Y-m-d", $lastWorkMonthTime);
		$currWorkMonthStart = date("Y-m") . "-01";
		$nextWorkMonthTime = mktime(0, 0, 0, date("m") + 1, 1, date("Y"));
		$nextWorkMonthStart = date("Y-m-d", $nextWorkMonthTime);
		
		$sql = "INSERT INTO Survey_SurveyorWorkHour(survId,workMonth,lastTotalWorkHour)
		SELECT surveyorCode,'{$workMonth}',SUM(estimatedManHour) AS lastTotalWorkHour
		FROM Survey_MainSchedule
		WHERE plannedSurveyDate >= '{$lastWorkMonthStart}' AND plannedSurveyDate < '{$currWorkMonthStart}' AND surveyorCode <> ''
		GROUP BY surveyorCode
		ORDER BY CAST(surveyorCode AS SIGNED)";
		$this->db->query($sql);
		
		$sql = "UPDATE Survey_SurveyorWorkHour swh
		SET swh.totalWorkHour = IFNULL((SELECT SUM(estimatedManHour) FROM Survey_MainSchedule WHERE plannedSurveyDate >= '{$currWorkMonthStart}' AND plannedSurveyDate < '{$nextWorkMonthStart}' AND surveyorCode = swh.survId),0)
		WHERE workMonth = '{$workMonth}'";
		$this->db->query($sql);
		
		// 可委派的時間數
		$ms = new MainSchedule();
		$msa = new MainScheduleAccess($this->db);
		$ms->plannedSurveyDateStart = $currWorkMonthStart;
		$ms->plannedSurveyDateEnd = $nextWorkMonthStart;
		// 当月未委派时间数
		$currMonthNoAssignEstimatedManHour = $msa->GetNoAssignEstimatedManHour($ms);
		
		// 上月总共时间数
		$msLast = new MainSchedule();
		$msLast->plannedSurveyDateStart = $lastWorkMonthStart;
		$msLast->plannedSurveyDateEnd = $currWorkMonthStart;
		$lastMonthEstimatedManHour = $msa->GetEstimatedManHour($msLast);
		
		$sql = "UPDATE Survey_SurveyorWorkHour
			SET canAssignHour = {$currMonthNoAssignEstimatedManHour}*(lastTotalWorkHour-totalWorkHour)/{$lastMonthEstimatedManHour}
		WHERE workMonth = '{$workMonth}'";
		$this->db->query($sql);
	}
	
	/**
	 *
	 * 更新單個SurveyorWorkHour本月的统计
	 * 
	 * @param number $survId        	
	 */
	function UpdateSingleSurveyorWorkHour($survId, $assignHour = 0)
	{
		$workMonth = date("Y-m");
		$sql = "SELECT swhoId FROM Survey_SurveyorWorkHour WHERE workMonth='{$workMonth}' AND survId='{$survId}'";
		$this->db->query($sql);
		$swhoId = 0;
		if ($rs = $this->db->next_record())
		{
			$swhoId = $rs["swhoId"];
		}
		
		$lastWorkMonthTime = mktime(0, 0, 0, date("m") - 1, 1, date("Y"));
		$lastWorkMonthStart = date("Y-m-d", $lastWorkMonthTime);
		$currWorkMonthStart = date("Y-m") . "-01";
		$nextWorkMonthTime = mktime(0, 0, 0, date("m") + 1, 1, date("Y"));
		$nextWorkMonthStart = date("Y-m-d", $nextWorkMonthTime);
		
		if ($swhoId > 0)
		{
			$sql = "UPDATE Survey_SurveyorWorkHour swh
			SET swh.lastTotalWorkHour = IFNULL((SELECT SUM(estimatedManHour) FROM Survey_MainSchedule WHERE surveyorCode='{$survId}' AND plannedSurveyDate >= '{$lastWorkMonthStart}' AND plannedSurveyDate < '{$currWorkMonthStart}'),0)
			WHERE workMonth = '{$workMonth}' AND survId='{$survId}'";
		}
		else
		{
			$sql = "INSERT INTO Survey_SurveyorWorkHour(survId,workMonth,lastTotalWorkHour)
			SELECT {$survId} AS surveyorCode,'{$workMonth}',IFNULL(SUM(estimatedManHour),0) AS lastTotalWorkHour
			FROM Survey_MainSchedule
			WHERE surveyorCode='{$survId}' AND plannedSurveyDate >= '{$lastWorkMonthStart}' AND plannedSurveyDate < '{$currWorkMonthStart}'";
		}
		$this->db->query($sql);
		
		$sql = "UPDATE Survey_SurveyorWorkHour swh
		SET swh.totalWorkHour = IFNULL((SELECT SUM(estimatedManHour) FROM Survey_MainSchedule WHERE surveyorCode='{$survId}' AND plannedSurveyDate >= '{$currWorkMonthStart}' AND plannedSurveyDate < '{$nextWorkMonthStart}'),0)
		WHERE workMonth = '{$workMonth}' AND survId='{$survId}'";
		$this->db->query($sql);
		
		if ($assignHour != 0)
		{
			$sql = "UPDATE Survey_SurveyorWorkHour
			SET canAssignHour = canAssignHour+{$assignHour}
			WHERE workMonth = '{$workMonth}' AND survId='{$survId}'";
			$this->db->query($sql);
		}
	}
	
	/**
	 * 获取调查员在系统中委派的列表
	 * 
	 * @param number $survId        	
	 * @return number
	 */
	function GetSystemAssignJobNoNew($survId)
	{
		$query = '';
		$query .= " AND survId = '{$survId}'";
		
		$sql = "SELECT * FROM Survey_SurveyorMainSchedule " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query($sql);
		$jobNoNews = array();
		while ( $rs = $this->db->next_record() )
		{
			$jobNoNews[] = $rs['jobNoNew'];
		}
		return $jobNoNews;
	}
	
	/**
	 * 获取调查员在系统中委派的列表
	 * 
	 * @param string $jobNoNews        	
	 * @return number
	 */
	function GetSystemAssignJobNoNews($jobNoNews)
	{
		$query = '';
		if (empty($jobNoNews))
		{
			return array();
		}
		$query .= " AND JobNoNew IN ({$jobNoNews})";
		
		$sql = "SELECT * FROM Survey_SurveyorMainSchedule
				  WHERE 1=1 AND delFlag='no'";
		$sql = $sql . $query;
		$this->db->query($sql);
		$jobNoNews = array();
		while ( $rs = $this->db->next_record() )
		{
			$jobNoNews[$rs['jobNoNew']]['survId'] = $rs['survId'];
			$jobNoNews[$rs['jobNoNew']]['inputUserId'] = $rs['inputUserId'];
			$jobNoNews[$rs['jobNoNew']]['inputTime'] = $rs['inputTime'];
		}
		return $jobNoNews;
	}
	
	/**
	 * 获取调查员最後一次系統委派時間
	 * 
	 * @param number $survId        	
	 * @return datetime
	 */
	function GetLastSystemAssignTime($survId)
	{
		$query = '';
		$query .= " AND survId = '{$survId}'";
		
		$sql = "SELECT MAX(inputTime) AS inputTime FROM Survey_SurveyorMainSchedule " . " WHERE 1=1 ";
		$sql = $sql . $query;
		$this->db->query($sql);
		while ( $rs = $this->db->next_record() )
		{
			return $rs['inputTime'];
		}
	}
	
	/**
	 * 是否更改过密码
	 * 
	 * @param number $surveyorId        	
	 * @access public
	 */
	function IsUpdatedPassword($surveyorId)
	{
		$sql = "SELECT * FROM Survey_SurveyorPassword " . " WHERE survId = '" . $surveyorId . "'";
		$this->db->query($sql);
		if ($this->db->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * 设置调查员用户的头像
	 * @param $survId
	 * @param $profilePhoto
	 */
	function setProfilePhoto($survId,$profilePhoto){
		$sql = "UPDATE Survey_Surveyor SET profilePhoto = '{$profilePhoto}'
			WHERE survId='{$survId}'";
		$this->db->query($sql);
	}
}