<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");

// 记录下载日志
$uh = new UserHistory ();
$uha = new UserHistoryAccess ( $db );
$uh->jobId = $_GET ['jobNoNew'];
// print $uh->jobId;exit();
$uh->type = 'Monitoring Survey';
$uh->action = 'RawData Download';
$uh->userId = $_GET ['userId'];
$uh->endTime = date ( $conf ['dateTime'] ['format'] );
$uha->Add ( $uh );

header ( "location:" . $_GET ['downloadUrl'] );

?>