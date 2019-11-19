<?php
/**
 *
 * @copyright 2007-2013 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2014-11-21
 */
include_once ("../includes/config.inc.php");

$query = $_REQUEST ['q'];

switch ($query) {
	case "audit" :
		$otId = $_REQUEST["otId"];
		$auditStatus = "audited";
		$o = new OtherSalary();
		$oa = new OtherSalaryAccess($db);
		$oa->UpdateStatus($otId, $auditStatus);
				
		$message = array (
				'sucess' => 'true' 
		);
		echo json_encode ( $message );
		break;
}