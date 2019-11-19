<?php
/*
 * Header: Create: 2007-09-16 Auther: Jamblues.
 */
include_once ("up_to_date_bar_data.php");
include_once ("../library/jpgraph/jpgraph.php");
include_once ("../library/jpgraph/jpgraph_bar.php");

if (! UserLogin::IsLogin ()) {
	// header("Location:login.php");
	exit ();
}

$graph = new Graph ( 1024, 500, 'auto' );
$graph->SetScale ( "textlin" );
$graph->SetShadow ();
$graph->img->SetMargin ( 40, 30, 40, 40 );
$graph->legend->Pos ( 0.06, 0.10 );
$districtNames = array ();
foreach ( $conf ['districtName'] as $v ) {
	$districtNames [] = $v;
}
$graph->xaxis->SetTickLabels ( $districtNames );

$graph->xaxis->title->Set ( 'Project' );
$graph->xaxis->title->SetFont ( FF_FONT1, FS_BOLD );

$graph->title->Set ( 'Progress Bar Chart' );
$graph->title->SetFont ( FF_FONT1, FS_BOLD );

$bplot0 = new BarPlot ( $dataReceivedHours );
$bplot0->SetFillColor ( "green" );
$bplot0->value->Show ();
$bplot0->value->SetColor ( "blue" );
$bplot0->SetLegend ( 'Received Hours' );
$bplot0->SetShadow ();

$bplot1 = new BarPlot ( $dataFormsPrepared );
$bplot1->SetFillColor ( "purple3" );
$bplot1->value->Show ();
$bplot1->value->SetColor ( "blue" );
$bplot1->SetLegend ( 'Forms Prepared' );
$bplot1->SetShadow ();

$bplot2 = new BarPlot ( $dataArrangedHours );
$bplot2->SetFillColor ( "bisque4" );
$bplot2->value->Show ();
$bplot2->value->SetColor ( "blue" );
$bplot2->SetLegend ( 'Arranged Hours' );
$bplot2->SetShadow ();

$bplot3 = new BarPlot ( $dataSurveyHours );
$bplot3->SetFillColor ( "darkgreen" );
$bplot3->value->Show ();
$bplot3->value->SetColor ( "blue" );
$bplot3->SetLegend ( 'Surveyed Hours' );
$bplot3->SetShadow ();

$bplot4 = new BarPlot ( $dataReceivedForms );
$bplot4->SetFillColor ( "salmon1" );
$bplot4->value->Show ();
$bplot4->value->SetColor ( "blue" );
$bplot4->SetLegend ( 'Received Forms' );
$bplot4->SetShadow ();

$bplot5 = new BarPlot ( $dataReportedHours );
$bplot5->SetFillColor ( "blue" );
$bplot5->value->Show ();
$bplot5->value->SetColor ( "blue" );
$bplot5->SetLegend ( 'Reported Hours' );
$bplot5->SetShadow ();

$gbarplot = new GroupBarPlot ( array (
		$bplot0,
		$bplot1,
		$bplot2,
		$bplot3,
		$bplot4,
		$bplot5 
) );
$gbarplot->SetWidth ( 0.6 );
$graph->Add ( $gbarplot );

$graph->Stroke ();

?>