<?php
/**
 *
 * @copyright 2007-2013 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2013-12-11
 */
include_once ("../includes/config.inc.php");

$query = $_REQUEST ['q'];

switch ($query) {
	case "update" :
		$ac = new Across ();
		$aca = new AcrossAccess ( $db );
		$ac->aId = $_REQUEST ['aId'];
		$ac->company = $_REQUEST ['company'];
		$ac->plateNo = $_REQUEST ['plateNo'];
		$ac->fleetNo = $_REQUEST ['fleetNo'];
		$ac->capacity = $_REQUEST ['capacity'];
		$ac->sch = $_REQUEST ['sch'];
		$ac->plateNo = str_replace ( " ", "", $ac->plateNo );
		$aca->ReplaceInto ( $ac );
		$message = array (
				'sucess' => 'true' 
		);
		echo json_encode ( $message );
		break;
}