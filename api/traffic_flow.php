<?php
/**
 *
 * @copyright 2007-2013 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2016-02-18
 */
include_once ("../includes/config.inc.php");

function IsNullData($str) {
	if (empty($str))
		return 'NULL';
	else
		return $str;
}


$rawJson = file_get_contents('php://input','r');

if(empty($rawJson)){
	$data['q'] = $_REQUEST ['q'];
	$data['callback'] = $_REQUEST ['callback'];
	$data['username'] = $_REQUEST ['username'];
	$data['password'] = $_REQUEST ['password'];
	$data['channel'] = 0;
}else{
	$data = json_decode($rawJson,TRUE);
	if(empty($data['q'])){
		$data['q'] = $_REQUEST ['q'];
	}
	$filename = '../data/'.date("YmdHis").rand(1000,9999).'.txt';
	file_put_contents($filename,$rawJson);
}

switch ($data['q']) {
	case "update" :

		//判断是否有唯一标识
		if(empty($data['uniqueId'])){
			$jsonData = array (
					'success' => 'false',
					'msg' => '唯一标识不能为空！'
			);
			die(json_encode($jsonData));
		}
		//判断数据是否存在（joinId是否为空）
		$fjia = new FlowJobInfoAccess($db);
		$fjiObj = $fjia->GetSingleByUniqueId($data['uniqueId']);
		//添加项目
		$fji = new FlowJobInfo();
		$fji->joinId = $fjiObj->joinId;
//		$fji->porjId = $data->refNO;
//		$fji->jobTitle = $_POST ['jobTitle'];
		$fji->jobNo = $data['refNO'];
		$fji->surveyDate = $data['partDate'];
		$fji->periodStartTime = $data['surveyTimeSart'];
		$fji->periodEndTime = $data['surveyTimeEnd'];
		if ($fji->joinId == "") {
			$fji->inputTime = date('Y-m-d H:i:s');
			$fji->joinId = $fjia->Add($fji);
		} else {
			$fji->updateTime = date('Y-m-d H:i:s');
			$fjia->Update ($fji);
		}
		if(is_array($data['data'])){
			//添加分部
			$fma = new FlowMovementAccess($db);
			$fmda = new FlowMovementDetailAccess($db);
			foreach($data['data'] as $v) {
				foreach($v['partdata'] as $v2){
					$fm = new FlowMovement();
					$fm->joinId = $fji->joinId;
					$fm->chiName = $v2['direction'];
					$rs = $fma->GetListSearch($fm);
					if(count($rs)>0){
						$dr = $rs[0];
						$fm->moveId = $dr->moveId;
					}else{
						$fm->moveId = '';
					}
					$fm->pcfaId = 1;
					$fm->inputUserId = '';
					$fm->inputTime = date($conf['dateTime']['format']);
					$fm->updateUserId = '';
					$fm->updateTime = date($conf['dateTime']['format']);
					if ($fm->moveId == "") {
						$fm->moveId = $fma->Add($fm);
					} else {
						$fma->Update($fm);
					}

					//添加分部详情
					$fmd = new FlowMovementDetail();
					$fmd->moveId = $fm->moveId;
					$parttime = strtotime($v['parttime']);
					$fmd->startTime = date("H:i",$parttime);
					$fmd->endTime= date("H:i",$parttime+$data['interval']*60);
					$rs = $fmda->GetListSearch($fmd);
					if(count($rs)>0){
						$dr = $rs[0];
						$fmd->modeId = $dr->modeId;
					}else{
						$fmd->modeId = '';
					}
					$fmd->TYPE1Quantity = IsNullData($v2['type1']);
					$fmd->TYPE2Quantity = IsNullData($v2['type2']);
					$fmd->TYPE3Quantity = IsNullData($v2['type3']);
					$fmd->TYPE4Quantity = IsNullData($v2['type4']);
					$fmd->TYPE5Quantity = IsNullData($v2['type5']);
					$fmd->TYPE6Quantity = IsNullData($v2['type6']);
					$fmd->TYPE7Quantity = IsNullData($v2['type7']);
					$fmd->TYPE8Quantity = IsNullData($v2['type8']);
					$fmd->TYPE9Quantity = IsNullData($v2['type9']);
					$fmd->TYPE10Quantity = IsNullData($v2['type10']);
					$fmd->TYPE11Quantity = IsNullData($v2['type11']);
					$fmd->TYPE12Quantity = IsNullData($v2['type12']);
					$fmd->TYPE13Quantity = IsNullData($v2['type13']);
					$fmd->TYPE14Quantity = IsNullData($v2['type14']);
					$fmd->TYPE15Quantity = IsNullData($v2['type15']);
					$fmd->TYPE16Quantity = IsNullData($v2['type16']);
					$fmd->TYPE17Quantity = IsNullData($v2['type17']);
					$fmd->TYPE18Quantity = IsNullData($v2['type18']);
					$fmd->TYPE19Quantity = IsNullData($v2['type19']);
					$fmd->TYPE20Quantity = IsNullData($v2['type20']);
					$fmd->TYPE21Quantity = IsNullData($v2['type21']);
					$fmd->TYPE22Quantity = IsNullData($v2['type22']);
					$fmd->TYPE23Quantity = IsNullData($v2['type23']);
					$fmd->TYPE24Quantity = IsNullData($v2['type24']);
					$fmd->TYPE25Quantity = IsNullData($v2['type25']);
					if ($fmd->modeId == ""){
						$fmda->Add ( $fmd );
					}else{
						$fmda->Update ( $fmd );
					}


					// 更新到统计表
//					$fmdt = new FlowMovementDetailTotal();
//					$fmdta = new FlowMovementDetailTotalAccess($db);
//					$fmdt->moveId = $fm->moveId;
//					$fmdta->ProcessTotal($fmdt);
//					$fmdta->CalculateHourTotal($fmdt);
				}
			}

		}

		$message = array (
				'success' => 'true',
				'msg' => '添加成功！'
		);
		echo json_encode ( $message );
		break;
}