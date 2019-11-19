<?php
/**
 * about main schedule's me
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01 , 2015-01-22
 */
include_once ("../includes/config.inc.php");

$query = $_REQUEST ['q'];

switch ($query)
{
	case 'backupOtherSalary' :
		$oshl = new OtherSalaryHistoryLog ();
		$oshl->backupMonth = $_REQUEST ['backupMonth'];
		$oshl->backupType = $_REQUEST ['backupType'];
		$oshl->inputUserId = $_SESSION ['userId'];
		$oshl->inputTime = date ( "Y-m-d H:i:s" );
		$oshla = new OtherSalaryHistoryLogAccess ( $db );
		$oshl->oshlId = $oshla->BackupMonthOtherSalary ( $oshl );
		$message = array (
				'success' => 'true',
				'oshlId' => $oshl->oshlId 
		);
		echo json_encode ( $message );
		break;
	case 'unbackupOtherSalary' :
		$oshl = new OtherSalaryHistoryLog ();
		$oshl->oshlId = $_REQUEST ['oshlId'];
		$oshl->modifyUserId = $_SESSION ['userId'];
		$oshl->modifyTime = date ( "Y-m-d H:i:s" );
		$oshla = new OtherSalaryHistoryLogAccess ( $db );
		$oshla->Del ( $oshl );
		$message = array (
				'success' => 'true',
				'oshlId' => $oshl->oshlId 
		);
		echo json_encode ( $message );
		break;
	case 'approvalBackupOtherSalary' :
		$oshl = new OtherSalaryHistoryLog ();
		$oshl->oshlId = $_REQUEST ['oshlId'];
		$oshl->isApproval = 'yes';
		$oshl->modifyUserId = $_SESSION ['userId'];
		$oshl->modifyTime = date ( "Y-m-d H:i:s" );
		$oshla = new OtherSalaryHistoryLogAccess ( $db );
		$oshla->ApprovalBackupMonthOtherSalary ( $oshl );
		$message = array (
				'success' => 'true',
				'oshlId' => $oshl->oshlId 
		);
		echo json_encode ( $message );
		break;
	case 'unapprovalOtherSalary' :
		$oshl = new OtherSalaryHistoryLog ();
		$oshl->oshlId = $_REQUEST ['oshlId'];
		$oshl->isApproval = 'no';
		$oshl->modifyUserId = $_SESSION ['userId'];
		$oshl->modifyTime = date ( "Y-m-d H:i:s" );
		$oshla = new OtherSalaryHistoryLogAccess ( $db );
		$oshla->ApprovalBackupMonthOtherSalary ( $oshl );
		$message = array (
				'success' => 'true',
				'oshlId' => $oshl->oshlId 
		);
		echo json_encode ( $message );
		break;
}