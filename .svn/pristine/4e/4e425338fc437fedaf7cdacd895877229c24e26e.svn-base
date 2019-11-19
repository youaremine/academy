<?php
/*
 * Header: 从main schedule导出周时间表 Create: 2013-04-16 @Ozzo Technology(HK) LTD Auther: Jamblues.
 */
include_once ("../includes/config.inc.php");

$complateJobNo = $_REQUEST ['complateJobNo'];

$shortDistrictName = $conf ['districtName'] [$complateJobNo];

$fileName = "main_schedule_week_to_excel_default.php";
if (! empty ( $shortDistrictName )) {
	$tempFileName = "main_schedule_week_to_excel_" . strtolower ( $shortDistrictName ) . ".php";
	if (file_exists ( $tempFileName )) {
		$fileName = $tempFileName;
	}
}
// echo $tempFileName;exit();
include ($fileName);
exit ();