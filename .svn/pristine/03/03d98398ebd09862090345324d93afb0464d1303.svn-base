<?php
/**
 *
 *
 * @create 2011-4-30
 * @author James Wu<jamblues@gmail.com>
 * @version 1.0
 */
include_once ("../includes/config.inc.php");

/**
 * 判斷兩個JobNo是否一樣
 * 
 * @param
 *        	$jobNo1
 * @param
 *        	$jobNo2
 */
function IsSameJobNo($jobNo1, $jobNo2) {
	$jobNo1 = trim ( $jobNo1 );
	$jobNo2 = trim ( $jobNo2 );
	if ($jobNo1 == $jobNo2) {
		return true;
	} else {
		$jobNo1Tmp = explode ( "(", $jobNo1 );
		$jobNo2Tmp = explode ( "(", $jobNo2 );
		if ($jobNo1Tmp [0] = $jobNo2Tmp [2]) {
			return true;
		} else {
			return false;
		}
	}
}

// 检查是否登录
// if(!UserLogin::IsLogin())
// {
// header("Location:../login.php");
// exit();
// }

$t = new CacheTemplate ( "../templates/progress-report" );
$t->set_file ( "HdIndex", "survey_pr.html" );
// $t->set_caching($conf["cache"]["valid"]);
$t->set_caching ( false );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$oneDayTime = 86400; // 60*60*24
$oneWeekTime = 604800; // $oneDayTime*7

$t->set_block ( "HdIndex", "OnBoardFareRow", "OnBoardFareRows" );
$t->set_block ( "HdIndex", "SurveyRow", "SurveyRows" );
$t->set_block ( "HdIndex", "SummaryRow", "SummaryRows" );
$t->set_var ( "OnBoardFareRows", "" );
$t->set_var ( "SummaryRows", "" );
$t->set_var ( "SurveyRows", "" );
if ($_GET ['complateJobNo'] != "") {
	$complateJobNo = $_GET ['complateJobNo'];
} else {
	print "complateJobNo is NULL";
	exit ();
}
$districtName = $conf ['districtName'] [$complateJobNo];
$feeHour = $conf ['feeHour'] [$complateJobNo];
$surveytime = $conf ['surveytime'] [$complateJobNo];
$reportNo = $_GET ['reportNo'];
$reportDate = $_GET ['reportDate'];
$reportDateStamp = strtotime ( $reportDate );
$reportDate = date ( "j", $reportDateStamp ) . "<sup>st</sup> " . date ( "F Y", $reportDateStamp );
$startWeekNo = $_GET ['startWeekNo'];
$endWeekNo = $_GET ['endWeekNo'];
$surveyStartDate = $conf ['survey_start_date'] [$complateJobNo];
$surveyStartDate = date ( "j F Y", strtotime ( $surveyStartDate ) );
$startIncludeDateStamp = strtotime ( $surveyStartDate ) + ($startWeekNo - 1) * $oneWeekTime;
$startIncludeDate = date ( "j F Y", $startIncludeDateStamp );
$endIncludeDateStamp = strtotime ( $surveyStartDate ) + $endWeekNo * $oneWeekTime - $oneDayTime;
$endIncludeDate = date ( "j F Y", $endIncludeDateStamp );
$startWeekNoProgressChart = $startWeekNo - 2;
$startWeekNoProgressChart = $startWeekNoProgressChart > 0 ? $startWeekNoProgressChart : 0;
$endWeekNoProgressChart = $endWeekNo;
$t->set_var ( array (
		'complateJobNo' => $complateJobNo,
		'districtName' => $districtName,
		'feeHour' => $feeHour,
		'reportNo' => $reportNo,
		'reportDate' => $reportDate,
		'surveyStartDate' => $surveyStartDate,
		'startIncludeDate' => $startIncludeDate,
		'endIncludeDate' => $endIncludeDate,
		'endWeekNo' => $endWeekNo,
		'startWeekNoProgressChart' => $startWeekNoProgressChart,
		'endWeekNoProgressChart' => $endWeekNoProgressChart,
		'surveytime' => $surveytime 
) );

$ms = new MainSchedule ();
$msa = new MainScheduleAccess ( $db );
$ms->complateJobNo = $complateJobNo;
$msa->order = " ORDER BY plannedSurveyDate ASC,jobNo ASC,surveyLocation ASC,routeItems ASC";
$accuSummary = 0;
$onBoardCostTotal = 0;
$onBoardCostIncludeTotal = 0;
$estimatedManHourTotal = 0;
$requestNoTotal = 0;
$reportHoursTotal = 0;
$estimatedManHourIncludeTotal = 0;
$requestNoIncludeTotal = 0;
for($i = 1; $i <= $endWeekNo; $i ++) {
	$ms->weekNo = $i;
	// Table 2-2 Summary of Total Man-hours Used & Survey Hours Remained
	$beforeJobNoShorts = $msa->GetWeekJobNoShorts ( $i, $complateJobNo, false );
	// Table 2-3 Summary of On-board fare
	$afterJobNoShorts = $msa->GetWeekJobNoShorts ( $i, $complateJobNo, true );
	$rsBefore = $msa->GetWeekList ( $i, $complateJobNo, $afterJobNoShorts, false );
	$rsBeforeNum = count ( $rsBefore );
	$arrBeforeOnBoardFare = array ();
	for($m = 0; $m < $rsBeforeNum; $m ++) {
		$msb = $rsBefore [$m];
		$arrBeforeOnBoardFare [$msb->jobNoShort] = $msb->onBoardCostFare;
	}
	
	$estimatedManHourSummary = 0;
	$onBoardCostSummary = 0;
	$onBoardCostIncludeSummary = 0;
	$requestNoSummary = 0;
	$rs = $msa->GetListSearchNoSS ( $ms );
	$rsNo = count ( $rs );
	$mse = new MainSchedule ();
	$mstmp = new MainSchedule ();
	$mstmpl = new MainSchedule ();
	$k = 0;
	$isPrint = false;
	for($j = 0; $j < $rsNo; $j ++) {
		$mse = $rs [$j];
		$estimatedManHourSummary += $mse->estimatedManHour;
		$accuSummary += $mse->estimatedManHour;
		if ($mse->report != "" && DateDiffDay ( $startIncludeDate, $mse->report ) >= 0 && DateDiffDay ( $mse->report, $endIncludeDate ) >= 0) {
			$reportHoursTotal += $mse->estimatedManHour;
		}
		if ($j == 0) {
			$mstmp = $mse;
			$k ++;
		} else if ($j > 0) {
			$msel = $rs [$j - 1];
			// 如果跟一条记录属于同一分类，则继续
			if (strtotime ( $mse->plannedSurveyDate ) == strtotime ( $msel->plannedSurveyDate ) && trim ( $mse->jobNo ) == trim ( $msel->jobNo )) {
				$mstmp->noOfSurveyors += $mse->noOfSurveyors;
				$mstmp->estimatedManHour += $mse->estimatedManHour;
				$mstmp->onBoardCostFare += $mse->onBoardCostFare * $mse->noOfTrips;
				$isPrint = false;
				continue;
			} else {
				if (! in_array ( $mstmp->jobNoShort, $afterJobNoShorts )) {
					$mstmp->onBoardCostFare += $arrBeforeOnBoardFare [$mstmp->jobNoShort];
					$costHour = CalcOnBoardCostFare2Hour ( $complateJobNo, $mstmp->onBoardCostFare );
					$onBoardCostSummary += $costHour;
				}
				if ($i >= $startWeekNo) {
					$t->set_var ( array (
							'weekNo' => $mstmp->weekNo,
							"jobNo" => $mstmp->jobNo,
							"plannedSurveyDate" => $mstmp->plannedSurveyDate,
							"estimatedManHour" => round ( $mstmp->estimatedManHour, 1 ) 
					) );
					$t->parse ( "SurveyRows", "SurveyRow", true );
					// Table 2-3 Summary of On-board fare
					if ($costHour > 0 && ! in_array ( $mstmp->jobNoShort, $afterJobNoShorts )) {
						$t->set_var ( array (
								'weekNoOnBoardFare' => $mstmp->weekNo,
								"jobNoOnBoardFare" => $mstmp->jobNoShort,
								"onBoardFare" => $costHour 
						) );
						$t->parse ( "OnBoardFareRows", "OnBoardFareRow", true );
						$onBoardCostIncludeSummary += $costHour;
					}
				}
				$isPrint = true;
				$mstmpl = $mstmp;
				$mstmp = $mse;
				$mstmp->onBoardCostFare = $mse->onBoardCostFare * $mse->noOfTrips;
				$k ++;
			}
			// N001,N001(I),N001(II)都算作一份
			if (! in_array ( $mse->jobNoShort, $beforeJobNoShorts ) && ! IsSameJobNo ( $mse->jobNo, $msel->jobNo )) {
				$requestNoSummary ++;
			}
		}
	}
	if (! $isPrint) {
		if (! in_array ( $mstmp->jobNoShort, $afterJobNoShorts )) {
			$mstmp->onBoardCostFare += $arrBeforeOnBoardFare [$mstmp->jobNoShort];
			$costHour = CalcOnBoardCostFare2Hour ( $complateJobNo, $mstmp->onBoardCostFare );
			$onBoardCostSummary += $costHour;
		}
		// 因为要比较，所以最后一次一定要打印一次.不用判断！
		if ($i >= $startWeekNo) {
			$t->set_var ( array (
					'weekNo' => $mstmp->weekNo,
					"jobNo" => $mstmp->jobNo,
					"plannedSurveyDate" => $mstmp->plannedSurveyDate,
					"estimatedManHour" => round ( $mstmp->estimatedManHour, 1 ) 
			) );
			$t->parse ( "SurveyRows", "SurveyRow", true );
			// Table 2-3 Summary of On-board fare
			if ($costHour > 0 && ! in_array ( $mstmp->jobNoShort, $afterJobNoShorts )) {
				$t->set_var ( array (
						'weekNoOnBoardFare' => $mstmp->weekNo,
						"jobNoOnBoardFare" => $mstmp->jobNoShort,
						"onBoardFare" => $costHour 
				) );
				$t->parse ( "OnBoardFareRows", "OnBoardFareRow", true );
				$onBoardCostIncludeSummary += $costHour;
			}
		}
	}
	
	$estimatedManHourSummary = round ( $estimatedManHourSummary, 1 );
	
	// 統計表格(歷史記錄)
	$weekNoSummary = "Week " . sprintf ( "%02d", $i );
	$onBoardCostTotal += $onBoardCostSummary;
	$onBoardCostIncludeTotal += $onBoardCostIncludeSummary;
	$estimatedManHourTotal += $estimatedManHourSummary;
	$requestNoTotal += $requestNoSummary;
	if ($i >= $startWeekNo) {
		$estimatedManHourIncludeTotal += $estimatedManHourSummary;
		$requestNoIncludeTotal += $requestNoSummary;
	}
	$accuSummary = round ( $accuSummary, 1 );
	$remainingHour = $surveytime - $accuSummary - $onBoardCostTotal;
	$remainingHour = round ( $remainingHour, 1 );
	$t->set_var ( array (
			"weekNoWeek" => $weekNoSummary,
			"estimatedManHourWeek" => $estimatedManHourSummary,
			"accuWeek" => $accuSummary,
			"onBoardCostWeek" => $onBoardCostSummary,
			"requestNoWeek" => $requestNoSummary 
	) );
	$t->parse ( "SummaryRows", "SummaryRow", true );
}
$t->set_var ( "requestNoIncludeTotal", $requestNoIncludeTotal );
$t->set_var ( "estimatedManHourIncludeTotal", $estimatedManHourIncludeTotal );
$t->set_var ( "onBoardFareSummaryTotal", $onBoardCostIncludeTotal );

$t->set_var ( "estimatedManHourWeekTotal", $estimatedManHourTotal );
$t->set_var ( "onBoardCostWeekTotal", $onBoardCostTotal );
$t->set_var ( "requestNoWeekTotal", $requestNoTotal );
$reportHoursTotal = round ( $reportHoursTotal, 1 );
$t->set_var ( "reportHoursTotal", $reportHoursTotal );

$remainedManHourTotal = $surveytime - $estimatedManHourTotal - $onBoardCostTotal;
$t->set_var ( "remainedManHourTotal", $remainedManHourTotal );

$t->pparse ( "Output", "HdIndex" );