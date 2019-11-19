<?php
/*
 * Header: 
 * Create: 2017-03-22
 * Auther: James Wu<jamblues@gmail.com>.
 */
class PostsAccess
{
	var $db;

	function PostsAccess($db)
	{
		$this->db = $db;
	}

	function Add($obj)
	{
		$sql = "INSERT INTO Survey_Posts(parentId,categoryId,format,jobNoNew,title,content,survId,userId,inputip,inputTime,delFlag,voiceTime,had_reply,group_sending)".
			" VALUES('".$obj->parentId."'".
			",'".$obj->categoryId."'".
			",'".$obj->format."'".
			",'".$obj->jobNoNew."'".
			",'".$obj->title."'".
			",'".$obj->content."'".
			",'".$obj->survId."'".
			",'".$obj->userId."'".
			",'".$obj->inputip."'".
			",'".$obj->inputTime."'".
			",'".$obj->delFlag."'".
            ",'".$obj->voiceTime."'".
            ",'".$obj->had_reply."'".
            ",'".$obj->group_sending."'".
			")";
		$this->db->query($sql);
		return $this->db->last_insert_id();
	}

	function Update($obj)
	{
		$sql = "UPDATE Survey_Posts ".
			" SET parentId = '".$obj->parentId."'".
			" ,categoryId = '".$obj->categoryId."'".
			" ,format = '".$obj->format."'".
			" ,jobNoNew = '".$obj->jobNoNew."'".
			" ,title = '".$obj->title."'".
			" ,content = '".$obj->content."'".
			" ,survId = '".$obj->survId."'".
			" ,userId = '".$obj->userId."'".
			" ,inputip = '".$obj->inputip."'".
			" ,inputTime = '".$obj->inputTime."'".
			" ,delFlag = '".$obj->delFlag."'".
			" WHERE 1=1  AND postId = '".$obj->postId."'";
		$this->db->query($sql);
	}

	function Del($obj)
	{
		$sql = "UPDATE Survey_Posts ".
			" SET delFlag='yes' ".
			" WHERE 1=1  AND postId = '".$obj->postId."'";
		$this->db->query($sql);
	}

	function RealDel($obj)
	{
		$sql = "DELETE FROM Survey_Posts ".
			" WHERE 1=1  AND postId = '".$obj->postId."'";
		$this->db->query($sql);
	}

	function GetListSearch($obj)
	{
		$query = '';
		if($obj->postId != '')
			$query .= " AND postId = '".$obj->postId."'";
		if($obj->startPostId != '')
			$query .= " AND postId > '".$obj->startPostId."'";
		if($obj->endPostId != '')
			$query .= " AND postId < '".$obj->endPostId."'";
		if($obj->parentId != '')
			$query .= " AND parentId = '".$obj->parentId."'";
		if($obj->categoryId != '')
			$query .= " AND categoryId = '".$obj->categoryId."'";
//		if($obj->format != '')
//			$query .= " AND format = '".$obj->format."'";
		if($obj->jobNoNew != '')
			$query .= " AND jobNoNew = '".$obj->jobNoNew."'";
		if($obj->title != '')
			$query .= " AND title = '".$obj->title."'";
		if($obj->content != '')
			$query .= " AND content = '".$obj->content."'";
		if($obj->survId != '')
			$query .= " AND survId = '".$obj->survId."'";
		if($obj->userId != '')
			$query .= " AND userId = '".$obj->userId."'";
		if($obj->inputip != '')
			$query .= " AND inputip = '".$obj->inputip."'";
		if($obj->inputTime != '')
			$query .= " AND inputTime = '".$obj->inputTime."'";
		if($obj->delFlag != '')
			$query .= " AND sp.delFlag = '".$obj->delFlag."'";
		if($obj->order != '')
			$query .= " ".$obj->order;
		if($obj->pageLimit != '')
			$query .= " ".$obj->pageLimit;

        $sql = "SELECT sp.*,ss.chiName as deluser_chiName,ss.engName as deluser_engName FROM Survey_Posts as sp left join Survey_Users as ss on ss.userId = sp.delUserId".
            " WHERE 1=1 ";
		$sql = $sql.$query;
		$this->db->query($sql);
		$rows = array();
		while($rs = $this->db->next_record())
		{
			$obj = new Posts();
			$obj->postId = $rs["postId"];
			$obj->parentId = $rs["parentId"];
			$obj->categoryId = $rs["categoryId"];
			$obj->format = $rs["format"];
			$obj->jobNoNew = $rs["jobNoNew"];
			$obj->title = $rs["title"];
			$obj->content = $rs["content"];
			$obj->survId = $rs["survId"];
			$obj->userId = $rs["userId"];
			$obj->inputip = $rs["inputip"];
			$obj->inputTime = $rs["inputTime"];
			$obj->delFlag = $rs["delFlag"];
            $obj->voiceTime = $rs["voiceTime"];
            $obj->group_sending = $rs["group_sending"];
            $obj->delTime = $rs["delTime"];
            $obj->deluser_chiName = $rs["deluser_chiName"];
            $obj->deluser_engName = $rs["deluser_engName"];
			$rows[] = $obj;
		}
		return $rows;
	}

    function deleteF($postId,$userId){
        $time = date('Y-m-d H:i:s');
        $sql = "UPDATE Survey_Posts ".
            " SET delUserId = '".$userId."'".
            " ,delFlag = 'yes'".
            " ,delTime = '".$time."'".
            " WHERE 1=1  AND postId = '".$postId."'";
        return $this->db->query($sql);
    }


    function getDeletedItem($jobNoNew,$limitTime = false){
        $limitTime = $limitTime == false?date('Y-m-d H:i:s',strtotime('-7 day')):$limitTime;
        $sql = "SELECT sp.postId,sp.delUserId,sp.delTime,ss.chiName as deluser_chiName,ss.engName as deluser_engName  FROM Survey_Posts as sp LEFT JOIN Survey_Users as ss on sp.delUserId = ss.userId".
            " WHERE 1=1 AND sp.jobNoNew = '{$jobNoNew}' AND sp.delFlag = 'yes' AND sp.delTime >= '{$limitTime}'";

        $this->db->query($sql);
        $rows = array();
        while($rs = $this->db->next_record())
        {
            $tmp = array();
            $tmp['postId'] = $rs["postId"];
            $tmp['delTime'] = $rs["delTime"];
            $tmp['deluser_chiName'] = $rs["deluser_chiName"];
            $tmp['deluser_engName'] = $rs["deluser_engName"];
            $rows[] = $tmp;
        }
        return $rows;
    }

	function GetUnReplyList($obj,$type='all')
	{
		$query = '';
		if($type=="unreply"){
			$query .= " AND had_reply=0";
		}

		$sql1 = "SELECT jobNo FROM Survey_MainSchedule where";

		$lastMonthDay = date("Y-m-d",strtotime("-1 month"));
		$sql = "SELECT ss2.chiName as s_chiName, ss2.engName as s_engName,sm.surveyType as type,sm2.surveyType as type2,p.*,ss.chiName,ss.engName FROM Survey_Posts p left join Survey_Surveyor ss on ss.survId=p.survId
            left join Survey_Surveyor ss2 on p.jobNoNew = ss2.contact
			INNER JOIN (
			SELECT jobNoNew,MAX(postId) AS maxPostId FROM Survey_Posts
			WHERE delFlag='no'
			GROUP BY jobNoNew) pm ON pm.jobNoNew = p.jobNoNew AND pm.maxPostId=p.postId
			LEFT JOIN Survey_MainSchedule as sm on p.jobNoNew=sm.jobNoNew
			 LEFT JOIN Survey_MainSchedule as sm2 on p.jobNoNew=sm2.jobNo
			 WHERE 1=1 ";
		$sql = $sql.$query." GROUP BY postId ";
        if($obj->order != '')
            $sql .= " ".$obj->order;
        if($obj->pageLimit != '')
            $sql .= " ".$obj->pageLimit;
		$this->db->query($sql);

//		echo $sql;
		$rows = array();

		while($rs = $this->db->next_record())
		{
			$obj = new Posts();
			$obj->postId = $rs["postId"];
            $obj->surveyType = empty($rs["type"])?$rs["type2"]:$rs["type"];
			$obj->parentId = $rs["parentId"];
			$obj->categoryId = $rs["categoryId"];
			$obj->format = $rs["format"];
			$obj->jobNoNew = $rs["jobNoNew"];
			$obj->title = $rs["title"];
			$obj->content = $rs["content"];
			$obj->survId = $rs["survId"];
			$obj->userId = $rs["userId"];
			$obj->inputip = $rs["inputip"];
			$obj->inputTime = $rs["inputTime"];
			$obj->delFlag = $rs["delFlag"];
            $obj->voiceTime = $rs["voiceTime"];
            $obj->chiName = $rs["chiName"];
            $obj->engName = $rs["engName"];
            $obj->s_chiName = $rs["s_chiName"];
            $obj->s_engName = $rs["s_engName"];
			$rows[] = $obj;
		}

		return $rows;
	}
}
?>