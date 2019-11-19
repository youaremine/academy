<?php
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	// 检查是否登录
	if ($_GET ['sn'] != base64_encode ( date ( "Y-m-d" ) )) {
		if (! empty ( $_GET ['sn'] )) {
			print 'sn is error.';
			exit ();
		} else {
			header ( "Location:login.php" );
			exit ();
		}
	}
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "notification.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "UrgentRow", "UrgentRows" );
$t->set_var ( "UrgentRows", "" );
$t->set_block ( "HdIndex", "UrgentFirstRow", "UrgentFirstRows" );
$t->set_var ( "UrgentFirstRows", "" );
$t->set_block ( "HdIndex", "WarningRow", "WarningRows" );
$t->set_var ( "WarningRows", "" );
$t->set_block ( "HdIndex", "WarningFirstRow", "WarningFirstRows" );
$t->set_var ( "WarningFirstRows", "" );
$t->set_block ( "HdIndex", "DueDateRow", "DueDateRows" );
$t->set_var ( "DueDateRows", "" );
$t->set_block ( "HdIndex", "DueDateFirstRow", "DueDateFirstRows" );
$t->set_var ( "DueDateFirstRows", "" );

$hkHoliday = getArray ( 'hk-holiday' );

$warningDay = 2;
$urgentDay = 6;
$dueDateDay = 2;
$warningDayStart = "";
$urgentDayStart = "";
$workDay = 0;
for($i = 0; $i < 60; $i ++) {
	$time = time () - 86400 * $i;
	if (date ( "w", $time ) == 0) 	// 周日不計工作日
	{
		continue;
	}
	$currDate = date ( $conf ['date'] ['format'], $time );
	if ($hkHoliday [$currDate] == 1) 	// 節假日不計工作日
	{
		continue;
	}
	$workDay ++;
	if ($workDay == $warningDay) {
		$warningDayStart = $currDate;
	}
	if ($workDay == $urgentDay) {
		$urgentDayStart = $currDate;
		break;
	}
}

$t->set_var ( array (
		"warningDay" => $warningDay,
		"urgentDay" => $urgentDay,
		"dueDateDay" => $dueDateDay 
) );

$noUrgentStyle = "";
$noWarningStyle = "";

// Unfinished JobNo.
$ms = new MainSchedule ();
$ms->noSS = true;
$ms->noPlannedSurveyDate = true;
$ms->plannedSurveyDateStart = $warningDayStart;
$msa = new MainScheduleAccess ( $db );
$rs = $msa->GetListSearch ( $ms );
$rsNum = count ( $rs );
$unFinishedJobNo = array ();
foreach ( $rs as $k => $v ) {
	$ms = $v;
	if (! in_array ( $ms->jobNo, $unFinishedJobNo ))
		$unFinishedJobNo [] = $ms->jobNo;
}

// Warning
$ms = new MainSchedule ();
// $lastWeekDate = date($conf['date']['format'],strtotime($urgentDayStart)-86400*14);
// $ms->plannedSurveyDateStart = $lastWeekDate;
$ms->plannedSurveyDateStart = $urgentDayStart;
$ms->plannedSurveyDateEnd = $warningDayStart;
$ms->report = '';
$msa = new MainScheduleAccess ( $db );
$msa->order = "	ORDER BY complateJobNo DESC, plannedSurveyDate ASC,jobNoNew ASC";
$rs = $msa->GetListSearchNoSS ( $ms );
$rsNum = count ( $rs );
$warningJobNos = array ();
$warningJobNosDetail = array ();
foreach ( $rs as $k => $v ) {
	$ms = $v;
	if (in_array ( $ms->jobNo, $unFinishedJobNo ))
		continue;
	if (empty ( $ms->receiveDate )) {
		// echo "$ms->jobNoNew - $ms->receiveDate <br />";
		$no = str_replace ( $ms->jobNo, "", $ms->jobNoNew );
		$warningJobNos [$ms->jobNo] .= ",{$no}";
		$warningJobNosDetail [$ms->jobNo] .= "&#10;{$ms->jobNoNew},{$ms->surveyorName}({$ms->surveyorCode}),{$ms->surveyorTelephone}";
		// echo "\$warningJobNos[\$ms->jobNo]:".var_dump($warningJobNos)."<br />";
	}
}
$lastFirstWord = "";
$realWarningjobNos = array ();
foreach ( $rs as $k => $v ) {
	$ms = $v;
	if (in_array ( $ms->jobNo, $unFinishedJobNo ))
		continue;
	if (! in_array ( $ms->jobNo, $realWarningjobNos )) {
		$firstWord = substr ( $ms->jobNo, 0, 1 );
		// PANDA 2013年05月02號提出,A的不顯示在列表中.
		// Molly 2013年09月17号提出,L的也不显示在列表中.
		// Molly 2013年12月19日提出,P的也不显示在列表中.
		if ($firstWord == 'A' || $firstWord == 'L' || $firstWord == 'P')
			continue;
		// Meg 2016年5月17日提出，O开头的，只要收齐form就不显示在列表中。
		if ($firstWord == 'O' && empty($urgentJobNos[$ms->jobNo] ))
			continue;

		if (! empty ( $lastFirstWord ) && $lastFirstWord != $firstWord) {
			$lastFirstWord = $firstWord;
			$t->parse ( "WarningFirstRows", "WarningFirstRow", true );
			$t->set_var ( "WarningRows" );
		}
		if (empty ( $lastFirstWord )) {
			$lastFirstWord = $firstWord;
		}
		$realWarningjobNos [] = $ms->jobNo;
		
		if (empty ( $warningJobNos [$ms->jobNo] )) {
			$unreceiveJobNo = "";
			$unreceiveJobNoCode = "";
		} else {
			$warningJobNos [$ms->jobNo] = substr ( $warningJobNos [$ms->jobNo], 1 );
			$unreceiveJobNoCode = $warningJobNos [$ms->jobNo];
			$warningJobNosDetail [$ms->jobNo] = substr ( $warningJobNosDetail [$ms->jobNo], 5 );
			$unreceiveJobNo = "(<span style=\"color:#F90; font-weight:bold;\" title=\"{$warningJobNosDetail[$ms->jobNo]}\">{$warningJobNos[$ms->jobNo]}</span>)";
		}
		$divisionWorkUser = GetDivisionWorkUser ( $ms->jobNo );
		$t->set_var ( array (
				"jobNo" => $ms->jobNo,
				"plannedSurveyDate" => $ms->plannedSurveyDate,
				"unreceiveJobNoCode" => $unreceiveJobNoCode,
				"unreceiveJobNo" => $unreceiveJobNo,
				"divisionWorkUser" => $divisionWorkUser 
		) );
		$t->parse ( "WarningRows", "WarningRow", true );
	}
}
$t->parse ( "WarningFirstRows", "WarningFirstRow", true );
$t->set_var ( "WarningRows" );
if (count ( $realWarningjobNos ) > 0) {
	$noWarningStyle = "display:none;";
}

// Urgent
$ms = new MainSchedule ();
$ms->plannedSurveyDateStart = $conf ['survey'] ['start_date'];
$ms->plannedSurveyDateEnd = $urgentDayStart;
$ms->report = '';
$msa = new MainScheduleAccess ( $db );
$msa->order = " ORDER BY complateJobNo DESC, plannedSurveyDate ASC,jobNoNew ASC";
$rs = $msa->GetListSearchNoSS ( $ms );
$rsNum = count ( $rs );
$urgentJobNos = array ();
$urgentJobNosDetail = array ();
foreach ( $rs as $k => $v ) {
	$ms = $v;
	if (in_array ( $ms->jobNo, $unFinishedJobNo )) // 已在未完成列表中的
		continue;
	if (empty ( $ms->receiveDate )) {
		// echo "$ms->jobNoNew - $ms->receiveDate <br />";
		$no = str_replace ( $ms->jobNo, "", $ms->jobNoNew );
		$urgentJobNos [$ms->jobNo] .= ",{$no}";
		$urgentJobNosDetail [$ms->jobNo] .= "&#10;{$ms->jobNoNew},{$ms->surveyorName}({$ms->surveyorCode}),{$ms->surveyorTelephone}";
		// echo "\$urgentJobNos[\$ms->jobNo]:".var_dump($urgentJobNos)."<br />";
	}
}
$realUrgentjobNos = array ();
$lastFirstWord = "";
foreach ( $rs as $k => $v ) {
	$ms = $v;
	if (in_array ( $ms->jobNo, $unFinishedJobNo )) // 已在未完成列表中的
		continue;
	if (in_array ( $ms->jobNo, $realWarningjobNos )) // 已在警告列表中的
		continue;
	if (! in_array ( $ms->jobNo, $realUrgentjobNos )) {
		$firstWord = substr ( $ms->jobNo, 0, 1 );
		// PANDA 2013年05月02號提出,A的不顯示在列表中.
		// Molly 2013年09月17号提出,L的也不显示在列表中.
		// Molly 2013年12月19日提出,P的也不显示在列表中.
		if ($firstWord == 'A' || $firstWord == 'L' || $firstWord == 'P')
			continue;
		// Meg 2016年5月17日提出，O开头的，只要收齐form就不显示在列表中。
		if ($firstWord == 'O' && empty($urgentJobNos[$ms->jobNo] ))
			continue;
		if (! empty ( $lastFirstWord ) && $lastFirstWord != $firstWord) {
			$lastFirstWord = $firstWord;
			$t->parse ( "UrgentFirstRows", "UrgentFirstRow", true );
			$t->set_var ( "UrgentRows" );
		}
		if (empty ( $lastFirstWord )) {
			$lastFirstWord = $firstWord;
		}
		$realUrgentjobNos [] = $ms->jobNo;
		if (empty ( $urgentJobNos [$ms->jobNo] )) {
			$unreceiveJobNo = "";
			$unreceiveJobNoCode = "無";
		} else {
			$urgentJobNos [$ms->jobNo] = substr ( $urgentJobNos [$ms->jobNo], 1 );
			$unreceiveJobNoCode = $urgentJobNos [$ms->jobNo];
			$urgentJobNosDetail [$ms->jobNo] = substr ( $urgentJobNosDetail [$ms->jobNo], 5 );
			$unreceiveJobNo = "(<span style=\"color:#F00; font-weight:bold;\" title=\"{$urgentJobNosDetail[$ms->jobNo]}\">{$urgentJobNos[$ms->jobNo]}</span>)";
		}
		$divisionWorkUser = GetDivisionWorkUser ( $ms->jobNo );
		$t->set_var ( array (
				"jobNo" => $ms->jobNo,
				"plannedSurveyDate" => $ms->plannedSurveyDate,
				"unreceiveJobNoCode" => $unreceiveJobNoCode,
				"unreceiveJobNo" => $unreceiveJobNo,
				"divisionWorkUser" => $divisionWorkUser 
		) );
		$t->parse ( "UrgentRows", "UrgentRow", true );
	}
}
$t->parse ( "UrgentFirstRows", "UrgentFirstRow", true );
$t->set_var ( "UrgentRows" );
if (count ( $realUrgentjobNos ) > 0) {
	$noUrgentStyle = "display:none;";
}

// Due Date
$dueDayEnd = date ( $conf ['date'] ['format'], time () + 86400 * 3 );
$ms = new MainSchedule ();
$ms->dueDateStart = $conf ['survey_start_date'] ['all'];
$ms->dueDateEnd = $dueDayEnd;
$ms->report = '';
$msa = new MainScheduleAccess ( $db );
$msa->order = "	ORDER BY complateJobNo DESC, plannedSurveyDate ASC,jobNoNew ASC";
$rs = $msa->GetListSearchNoSS ( $ms );
$rsNum = count ( $rs );
$dueDateJobNos = array ();
$dueDateJobNosDetail = array ();
foreach ( $rs as $k => $v ) {
	$ms = $v;
	// if(in_array($ms->jobNo,$unFinishedJobNo))
	// continue;
	if (empty ( $ms->receiveDate )) {
		// echo "$ms->jobNoNew - $ms->receiveDate <br />";
		$no = str_replace ( $ms->jobNo, "", $ms->jobNoNew );
		$dueDateJobNos [$ms->jobNo] .= ",{$no}";
		$dueDateJobNosDetail [$ms->jobNo] .= "&#10;{$ms->jobNoNew},{$ms->surveyorName}({$ms->surveyorCode}),{$ms->surveyorTelephone}";
		// echo "\$warningJobNos[\$ms->jobNo]:".var_dump($warningJobNos)."<br />";
	}
}
// var_dump($dueDateJobNos);exit();
$lastFirstWord = "";
$realDueDateJobNos = array ();
foreach ( $rs as $k => $v ) {
	$ms = $v;
	// if(in_array($ms->jobNo,$unFinishedJobNo))
	// continue;
	if (! in_array ( $ms->jobNo, $realDueDateJobNos )) {
		$firstWord = substr ( $ms->jobNo, 0, 1 );
		// PANDA 2013年05月02號提出,A的不顯示在列表中.
		// Molly 2013年09月17号提出,L的也不显示在列表中.
		// Molly 2013年12月19日提出,P的也不显示在列表中.
		if ($firstWord == 'A' || $firstWord == 'L' || $firstWord == 'P')
			continue;
		if (! empty ( $lastFirstWord ) && $lastFirstWord != $firstWord) {
			$lastFirstWord = $firstWord;
			$t->parse ( "DueDateFirstRows", "DueDateFirstRow", true );
			$t->set_var ( "DueDateRows" );
		}
		if (empty ( $lastFirstWord )) {
			$lastFirstWord = $firstWord;
		}
		$realDueDateJobNos [] = $ms->jobNo;
		if (empty ( $dueDateJobNos [$ms->jobNo] )) {
			$unreceiveJobNo = "";
			$unreceiveJobNoCode = "";
		} else {
			$dueDateJobNos [$ms->jobNo] = substr ( $dueDateJobNos [$ms->jobNo], 1 );
			$unreceiveJobNoCode = $dueDateJobNos [$ms->jobNo];
			$dueDateJobNosDetail [$ms->jobNo] = substr ( $dueDateJobNosDetail [$ms->jobNo], 5 );
			$unreceiveJobNo = "(<span style=\"color:#F00; font-weight:bold;\" title=\"{$dueDateJobNosDetail[$ms->jobNo]}\">{$dueDateJobNos[$ms->jobNo]}</span>)";
		}
		$divisionWorkUser = GetDivisionWorkUser ( $ms->jobNo );
		$t->set_var ( array (
				"jobNo" => $ms->jobNo,
				"plannedSurveyDate" => $ms->plannedSurveyDate,
				"dueDate" => $ms->dueDate,
				"unreceiveJobNoCode" => $unreceiveJobNoCode,
				"unreceiveJobNo" => $unreceiveJobNo,
				"divisionWorkUser" => $divisionWorkUser 
		) );
		$t->parse ( "DueDateRows", "DueDateRow", true );
	}
}
$t->parse ( "DueDateFirstRows", "DueDateFirstRow", true );
$t->set_var ( "DueDateRows" );
if (count ( $realDueDateJobNos ) > 0) {
	$noDueDateStyle = "display:none;";
}

$lastSplit = strrpos ( $_SERVER ["PHP_SELF"], "/" );
$floder = substr ( $_SERVER ["PHP_SELF"], 0, $lastSplit );
$siteUrl = $_SERVER ["HTTP_HOST"] . $floder;

$t->set_var ( array (
		"siteUrl" => $siteUrl,
		"noUrgentStyle" => $noUrgentStyle,
		"noWarningStyle" => $noWarningStyle,
		"noDueDateStyle" => $noDueDateStyle 
) );

$t->pparse ( "Output", "HdIndex" );
?>