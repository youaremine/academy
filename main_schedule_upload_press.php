<?php
include_once ('./includes/config.inc.php');
include_once ("../library/init.php");
require_once '../library/Spreadsheet/Excel/Reader.php';
function ExpressReplace($str) {
	$str = str_replace ( "'", "\'", $str );
	return $str;
}
// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
// 上传文件位置
$uploadFile = $conf ["path"] ["main_schedule"] . $conf ["file"] ["main_schedule"];
// print $uploadFile;
// print $_FILES['fileMainSchedule']['tmp_name'];
// exit();
if ($_FILES ['fileMainSchedule'] != "") {
	$message = "";
	if (move_uploaded_file ( $_FILES ['fileMainSchedule'] ['tmp_name'], $uploadFile )) {
		$message = "File is valid, and was successfully uploaded.\n";
	} else {
		$message = "Possible file upload attack!\n";
	}
}

// 上传文件最后导入到mysql时间
$importTimeFile = $conf ["path"] ["main_schedule"] . $conf ["file"] ["main_schedule_import_time"];
$lastImportTime = "";
$fp = fopen ( $importTimeFile, "r" );
$lastImportTime = fread ( $fp, filesize ( $importTimeFile ) );
fclose ( $fp );

// 当前文件修改的时间
$currImportTime = "";
if (file_exists ( $uploadFile )) {
	$currImportTime = date ( $conf ['dateTime'] ['format'], filemtime ( $uploadFile ) );
}

// 判断是否是较新的文件并将数据加入到mysql中
if ($currImportTime > $lastImportTime) {
	$data = new Spreadsheet_Excel_Reader ();
	$data->setOutputEncoding ( 'UTF-8' ); // 设置为utf-8
	                                   // $data->setOutputEncoding('BIG5');//设置为BIG5
	                                   // $data->setUTFEncoder();
	$data->read ( $uploadFile );
	
	$msa = new MainScheduleAccess ( $db );
	$msa->EmptyTable (); // 清空原表格
	                    // print $data->sheets[0]['numRows'];exit();
	for($i = 3; $i <= $data->sheets [0] ['numRows']; $i ++) {
		if ($data->sheets [0] ['cells'] [$i] [2] == '')
			continue;
			// print_r($data->sheets[0]['cells'][$i]);
			// if($i > 10)
			// exit();
		$ms = new MainSchedule ();
		$ms->weekNo = $data->sheets [0] ['cells'] [$i] [1];
		$ms->jobNo = $data->sheets [0] ['cells'] [$i] [2];
		$ms->jobNoNew = $data->sheets [0] ['cells'] [$i] [3];
		$ms->plannedSurveyDate = ExcelNumberToDate ( $data->sheets [0] ['cells'] [$i] [4] );
		$ms->tdFileNo = $data->sheets [0] ['cells'] [$i] [5];
		$ms->receivedDate = ExcelNumberToDate ( $data->sheets [0] ['cells'] [$i] [6] );
		$ms->dueDate = ExcelNumberToDate ( $data->sheets [0] ['cells'] [$i] [7] );
		$ms->fromTD = $data->sheets [0] ['cells'] [$i] [8];
		$ms->actualSurveyDate = ExcelNumberToDate ( $data->sheets [0] ['cells'] [$i] [9] );
		$ms->startTime_1 = $data->sheets [0] ['cells'] [$i] [10];
		$ms->endTime_1 = $data->sheets [0] ['cells'] [$i] [11];
		$ms->startTime_2 = $data->sheets [0] ['cells'] [$i] [12];
		$ms->endTime_2 = $data->sheets [0] ['cells'] [$i] [13];
		$ms->startTime_3 = $data->sheets [0] ['cells'] [$i] [14];
		$ms->endTime_3 = $data->sheets [0] ['cells'] [$i] [15];
		$ms->startTime_4 = $data->sheets [0] ['cells'] [$i] [16];
		$ms->endTime_4 = $data->sheets [0] ['cells'] [$i] [17];
		$ms->totalHours = $data->sheets [0] ['cells'] [$i] [18];
		$ms->surveyTimeHours = $data->sheets [0] ['cells'] [$i] [19];
		$ms->stCode = $data->sheets [0] ['cells'] [$i] [20];
		$ms->surveyType = $data->sheets [0] ['cells'] [$i] [21];
		$ms->vehCode = $data->sheets [0] ['cells'] [$i] [22];
		$ms->vehicle = $data->sheets [0] ['cells'] [$i] [23];
		$ms->isHoliday = $data->sheets [0] ['cells'] [$i] [24];
		$ms->bonusHours = $data->sheets [0] ['cells'] [$i] [25];
		$ms->surveyLocationDistrict = $data->sheets [0] ['cells'] [$i] [26];
		$ms->surveyLocation = ExpressReplace ( $data->sheets [0] ['cells'] [$i] [27] );
		$ms->routeItems = $data->sheets [0] ['cells'] [$i] [28];
		$ms->noOfSurveyors = $data->sheets [0] ['cells'] [$i] [29];
		$ms->estimatedManHour = $data->sheets [0] ['cells'] [$i] [30];
		$ms->receiveDate = ExcelNumberToDate ( $data->sheets [0] ['cells'] [$i] [31] );
		$ms->dataInputNo = $data->sheets [0] ['cells'] [$i] [32];
		$ms->dataInputBy = $data->sheets [0] ['cells'] [$i] [33];
		$ms->entryFormTypeNo = $data->sheets [0] ['cells'] [$i] [34];
		$ms->noOfPages = $data->sheets [0] ['cells'] [$i] [35];
		$ms->report = ExcelNumberToDate ( $data->sheets [0] ['cells'] [$i] [36] );
		$ms->hourlyRate = $data->sheets [0] ['cells'] [$i] [37];
		$ms->surveyFinding = $data->sheets [0] ['cells'] [$i] [38];
		$ms->am = $data->sheets [0] ['cells'] [$i] [39];
		$ms->periodHour_1 = $data->sheets [0] ['cells'] [$i] [40];
		$ms->periodWagesHr_1 = $data->sheets [0] ['cells'] [$i] [41];
		$ms->periodHour_2 = $data->sheets [0] ['cells'] [$i] [42];
		$ms->periodWagesHr_2 = $data->sheets [0] ['cells'] [$i] [43];
		$ms->totalWages = $data->sheets [0] ['cells'] [$i] [44];
		$ms->onBoardCostFare = $data->sheets [0] ['cells'] [$i] [45];
		$ms->noOfTrips = $data->sheets [0] ['cells'] [$i] [46];
		$ms->transportAllowanceAm = $data->sheets [0] ['cells'] [$i] [47];
		$ms->transportAllowanceNoon = $data->sheets [0] ['cells'] [$i] [48];
		$ms->transportAllowancePm = $data->sheets [0] ['cells'] [$i] [49];
		$ms->transportAllowanceOvernight = $data->sheets [0] ['cells'] [$i] [50];
		$ms->taTotal = $data->sheets [0] ['cells'] [$i] [51];
		$ms->wagesTaOnBoard = $data->sheets [0] ['cells'] [$i] [52];
		$ms->onBoardTranportAllowanceTotal = $data->sheets [0] ['cells'] [$i] [53];
		$ms->surveyorCode = $data->sheets [0] ['cells'] [$i] [54];
		$ms->surveyorName = $data->sheets [0] ['cells'] [$i] [55];
		$ms->surveyorTelephone = $data->sheets [0] ['cells'] [$i] [56];
		$ms->complateJobNo = $data->sheets [0] ['cells'] [$i] [58];
		$ms->distributedToLeader = str_replace ( "\\", "", $data->sheets [0] ['cells'] [$i] [82] );
		$ms->reportWeek = $data->sheets [0] ['cells'] [$i] [89];
		// 是否是数字即是否是调查员列表
		if ($ms->jobNo != "") {
			$msa->Add ( $ms );
		}
	}
	// 更改导入的时间
	$handle = fopen ( $importTimeFile, 'w' );
	fwrite ( $handle, $currImportTime );
	fclose ( $handle );
}

$url = "";
if ($_GET ["url"] == "") {
	$url = "main_schedule_list.php";
} else {
	$url = $_GET ["url"];
	header ( "Location:" . $url );
	exit ();
}
?>
<table
	style="FONT-SIZE: 12px; WIDTH: 300px; LINE-HEIGHT: 120%; FONT-FAMILY: Tahoma, Georgia; BORDER-COLLAPSE: collapse; HEIGHT: 150px"
	align="center">
	<tr>
		<td
			style="BORDER-RIGHT: #cfcfff 0px solid; BORDER-TOP: #cfcfff 0px solid; BORDER-LEFT: #cfcfff 0px solid; BORDER-BOTTOM: #cfcfff 0px solid; HEIGHT: 20px; BACKGROUND-COLOR: #ada001"
			height="20"><FONT color=#333333><STRONG>message</STRONG></FONT></td>
	</tr>
	<tr>
		<td
			style="BORDER-RIGHT: #cfcfcf 1px solid; BORDER-TOP: #cfcfcf 1px solid; BORDER-LEFT: #cfcfcf 1px solid; BORDER-BOTTOM: #cfcfcf 1px solid"
			align="middle" bgColor="#f9f6e7">
			<P><?php print $message; ?></P>
		</td>
	</tr>
</table>
<!-- <SCRIPT language=javascript>setTimeout('document.location="<?php print $url; ?>";',2500)</SCRIPT>  -->
