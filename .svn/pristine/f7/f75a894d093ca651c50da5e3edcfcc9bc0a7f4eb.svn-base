<?php
/*
 * Header: Create: 2007-09-08 Auther: Jamblues.
 */
include_once ("progress_data_slow.php");
// include_once ("progress_data_fast.php");
include_once ("../library/jpgraph/jpgraph.php");
include_once ("../library/jpgraph/jpgraph_line.php");

// 检查是否登录
if (! UserLogin::IsLogin ()) {
	header ( "Location:login.php" );
	exit ();
}
// Create the graph. These two calls are always required
$graph = new Graph ( 800, 400, "auto" );
$graph->SetScale ( "textlin" );
$graph->img->SetMargin ( 50, 40, 40, 50 );
$graph->title->Set ( "Progress Chart" );
// $graph->xaxis->title->setFont(FF_FONT1,FS_BOLD);
// $graph->xaxis->title->Set("Week No");
// $graph->legend->Pos(0.06,0.65);
$graph->legend->Pos ( 0.75, 0.15 );
// $graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetTickLabels ( $datax );
$graph->xaxis->SetTextTickInterval ( 1 );

// print_r($receivedHoursData);exit();

$nullYData = array (
		0 => 0,
		1 => 0 
);
// Create the linear plot Received Hours
if ($_GET ['chkReceivedHours'] == "1") {
	if (count ( $receivedHoursData ) >= 1) {
		// $receivedHoursData = CustomerArray($receivedHoursData,4,6);
		// print_r($receivedHoursData);exit();
		$lineplotReceivedHours = new LinePlot ( $receivedHoursData, true );
		$lineplotReceivedHours->value->Show ();
	} else {
		$lineplotReceivedHours = new LinePlot ( $nullYData, true );
	}
	
	$lineplotReceivedHours->mark->SetType ( MARK_FILLEDCIRCLE );
	$lineplotReceivedHours->mark->SetFillColor ( "green" );
	$lineplotReceivedHours->mark->SetWidth ( 2 );
	$lineplotReceivedHours->value->SetColor ( "green" );
	$lineplotReceivedHours->value->SetFormat ( "%d" );
	$lineplotReceivedHours->SetLegend ( "Received Hours" );
	$lineplotReceivedHours->SetColor ( "green" );
	$graph->Add ( $lineplotReceivedHours );
}

// Create the linear plot Forms Prepared
if ($_GET ['chkFormsPrepared'] == "1") {
	if (count ( $formsPreparedData ) >= 1) {
		$lineplotFormsPrepared = new LinePlot ( $formsPreparedData );
		$lineplotFormsPrepared->value->Show ();
	} else {
		$lineplotFormsPrepared = new LinePlot ( $nullYData );
	}
	$lineplotFormsPrepared->mark->SetType ( MARK_FILLEDCIRCLE );
	$lineplotFormsPrepared->mark->SetFillColor ( "purple3" );
	$lineplotFormsPrepared->mark->SetWidth ( 2 );
	$lineplotFormsPrepared->value->SetColor ( "purple3" );
	$lineplotFormsPrepared->value->SetFormat ( "%d" );
	$lineplotFormsPrepared->SetLegend ( "Forms Prepared" );
	$lineplotFormsPrepared->SetColor ( "purple3" );
	$graph->Add ( $lineplotFormsPrepared );
}

// Create the linear plot Arranged Hours
if ($_GET ['chkArrangedHours'] == "1") {
	if (count ( $arrangedHoursData ) >= 1) {
		$lineplotArrangedHours = new LinePlot ( $arrangedHoursData );
		$lineplotArrangedHours->value->Show ();
	} else {
		$lineplotArrangedHours = new LinePlot ( $nullYData );
	}
	$lineplotArrangedHours->mark->SetType ( MARK_FILLEDCIRCLE );
	$lineplotArrangedHours->mark->SetFillColor ( "bisque4" );
	$lineplotArrangedHours->mark->SetWidth ( 2 );
	$lineplotArrangedHours->value->SetColor ( "bisque4" );
	$lineplotArrangedHours->value->SetFormat ( "%d" );
	$lineplotArrangedHours->SetLegend ( "Arranged Hours" );
	$lineplotArrangedHours->SetColor ( "bisque4" );
	$graph->Add ( $lineplotArrangedHours );
}

// Create the linear plot Survey Hours
if ($_GET ['chkSurveyedHours'] == "1") {
	if (count ( $surveyHoursData ) >= 1) {
		$lineplotSurveyHours = new LinePlot ( $surveyHoursData );
		$lineplotSurveyHours->value->Show ();
	} else {
		$lineplotSurveyHours = new LinePlot ( $nullYData );
	}
	$lineplotSurveyHours->mark->SetType ( MARK_FILLEDCIRCLE );
	$lineplotSurveyHours->mark->SetFillColor ( "salmon1" );
	$lineplotSurveyHours->mark->SetWidth ( 2 );
	$lineplotSurveyHours->value->SetColor ( "salmon1" );
	$lineplotSurveyHours->value->SetFormat ( "%d" );
	$lineplotSurveyHours->SetLegend ( "Surveyed Hours" );
	$lineplotSurveyHours->SetColor ( "salmon1" );
	$graph->Add ( $lineplotSurveyHours );
}

// Create the linear plot Received Forms
if ($_GET ['chkReceivedForms'] == "1") {
	if (count ( $receivedFormsData ) >= 1) {
		$lineplotReceivedForms = new LinePlot ( $receivedFormsData );
		$lineplotReceivedForms->value->Show ();
	} else {
		$lineplotReceivedForms = new LinePlot ( $nullYData );
	}
	$lineplotReceivedForms->mark->SetType ( MARK_FILLEDCIRCLE );
	$lineplotReceivedForms->mark->SetFillColor ( "blue" );
	$lineplotReceivedForms->mark->SetWidth ( 2 );
	$lineplotReceivedForms->value->SetColor ( "blue" );
	$lineplotReceivedForms->value->SetFormat ( "%d" );
	$lineplotReceivedForms->SetLegend ( "Received Forms" );
	$lineplotReceivedForms->SetColor ( "blue" );
	$graph->Add ( $lineplotReceivedForms );
}

// Create the linear plot Reported Hours
if ($_GET ['chkReportedHours'] == "1") {
	if (count ( $reportedHoursData ) >= 1) {
		$lineplotReportedHours = new LinePlot ( $reportedHoursData );
		$lineplotReportedHours->value->Show ();
	} else {
		$lineplotReportedHours = new LinePlot ( $nullYData );
	}
	$lineplotReportedHours->mark->SetType ( MARK_FILLEDCIRCLE );
	$lineplotReportedHours->mark->SetFillColor ( "red" );
	$lineplotReportedHours->mark->SetWidth ( 2 );
	$lineplotReportedHours->value->SetColor ( "red" );
	$lineplotReportedHours->value->SetFormat ( "%d" );
	$lineplotReportedHours->SetLegend ( "Reported Hours" );
	$lineplotReportedHours->SetColor ( "red" );
	$graph->Add ( $lineplotReportedHours );
}

// Display the graph
$graph->Stroke ();

?>