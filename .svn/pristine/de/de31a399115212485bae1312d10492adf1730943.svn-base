<?php
/*
 * Header: Create: 2008-9-2 Auther: Jamblues.
 */
include_once ("./includes/config.inc.php");

// 检查是否登录
if (SurveyorLogin::IsLogin () || UserLogin::IsLogin ()) {
	// TODO
} else {
	header ( "Location:login.php" );
	exit ();
}

$t = new CacheTemplate ( "./templates" );
$t->set_file ( "HdIndex", "main_schedule_scarcity_list.html" );
$t->set_caching ( $conf ["cache"] ["valid"] );
$t->set_cache_dir ( $conf ["cache"] ["dir"] );
$t->set_expire_time ( $conf ["cache"] ["timeout"] );
$t->print_cache ();
$t->set_block ( "HdIndex", "Row", "Rows" );
$t->set_block ( "HdIndex", "MonthRow", "MonthRows" );
$t->set_var ( "Rows", "" );

// 详细信息
$ms = new MainSchedule ();
$msa = new MainScheduleAccess ( $db );
$rowNum = $msa->GetListSearchCount ( $ms );
$msa->order = "	ORDER BY jobNoNew ASC";

$j = 0;

$pageSize = 1000;
$pageNo = ceil ( $rowNum / 1000 );

for($m = 1; $m <= $pageNo; $m ++) {
	$msa->pageLimit = " LIMIT " . ($pageSize * ($m - 1)) . "," . $pageSize;
	$rs = $msa->GetListSearchScarcity ( $ms );
	$rsNum = count ( $rs );
	if ($m == 1) {
		$ms = $rs [0];
		$jobNoPreOld = substr ( $ms->jobNo, 0, 1 );
		$jobNoOld = ( int ) substr ( $ms->jobNo, 1 );
	}
	for($i = 0; $i < $rsNum; $i ++) {
		
		$ms = $rs [$i];
		$jobNoPre = substr ( $ms->jobNo, 0, 1 );
		$jobNo = ( int ) substr ( $ms->jobNo, 1 );
		$jobNoFix = substr ( $ms->jobNo, 4 );
		if ($jobNoPreOld == $jobNoPre) {
			if ($jobNo > ($jobNoOld + 1)) {
				for($k = $jobNoOld + 1; $k < $jobNo; $k ++) {
					if ($j % 2 == 0)
						$listStyle = "AlternatingItemStyle";
					else
						$listStyle = "DgItemStyle";
					$t->set_var ( array (
							"listStyle" => $listStyle,
							"jobNo" => $jobNoPre . sprintf ( "%03d", $k ) . $jobNoFix 
					) );
					$t->parse ( "Rows", "Row", true );
					$j ++;
				}
			}
		}
		$jobNoPreOld = substr ( $ms->jobNo, 0, 1 );
		$jobNoOld = ( int ) substr ( $ms->jobNo, 1 );
	}
}

$t->pparse ( "Output", "HdIndex" );
?>