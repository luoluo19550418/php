<?php
//---------------lookbad.php---------------//
//created by csluo, 2021.01.30

header ("Content-type:text/html;charset=utf-8" ); 
include ("../jpgraph-4.2.8/src/jpgraph.php"); 
include ("../jpgraph-4.2.8/src/jpgraph_line.php");  
include ("../jpgraph-4.2.8/src/jpgraph_scatter.php");
include ("../jpgraph-4.2.8/src/jpgraph_date.php");
include ("../jpgraph-4.2.8/src/jpgraph_mgraph.php");

//----------------------readfile---------------------------//

function readtxtfile($filename){
  $lines=file($filename);
  $arr_date=array(); $arr_num=array();
  $arr_b1=array(); $arr_b4=array(); $arr_b7=array();
  $arr_b2=array(); $arr_b5=array(); $arr_b8=array();
  $arr_b3=array(); $arr_b6=array(); $arr_b9=array();
  foreach ($lines as $line) {
    $line_delspa1=preg_replace ("/\s(?=\s)/","\\1", $line); $line_delspa2=trim($line_delspa1); //get only one space by delete
    $values=explode(" ",$line_delspa2,12); //use 12 because last column not only num, and space
    array_push($arr_date,$values[0]); array_push($arr_num,$values[1]);
    array_push($arr_b1,$values[2]); array_push($arr_b4,$values[5]); array_push($arr_b7,$values[8]);
    array_push($arr_b2,$values[3]); array_push($arr_b5,$values[6]); array_push($arr_b8,$values[9]);
    array_push($arr_b3,$values[4]); array_push($arr_b6,$values[7]); array_push($arr_b9,$values[10]);
  }
  return array($arr_date,$arr_b1,$arr_b2,$arr_b3,$arr_b4,$arr_b5,$arr_b6,$arr_b7,$arr_b8,$arr_b9); //return multi dimension array
}
$filename_beamu="obsrecord/badtongji/badbeam_day2020-2021usb.txt";
$filename_beaml="obsrecord/badtongji/badbeam_day2020-2021lsb.txt";
$filename_lineu="obsrecord/badtongji/badline_day2020-2021usb.txt";
$filename_linel="obsrecord/badtongji/badline_day2020-2021lsb.txt";
$arr_beamu=readtxtfile($filename_beamu);
$arr_beaml=readtxtfile($filename_beaml);
$arr_lineu=readtxtfile($filename_lineu);
$arr_linel=readtxtfile($filename_linel);

//----------------------plot---------------------------//

function plotaa($beam,$date,$beamu,$beaml,$lineu,$linel) {
  $graph=new Graph(1000,500);
  $graph->SetScale("textlin",0,110);
  $graph->img->SetMargin(50,50,20,70); 
  $graph->xaxis->SetLabelAngle(90);
  $graph->xaxis->SetTickLabels($date);
  $graph->xaxis->SetTextLabelInterval(5);
  $graph->xaxis->title->Set("date(mmdd)");
  $graph->xaxis->title->SetMargin(20); 
  $graph->xgrid->Show(); //display grid
  $graph->yaxis->SetTickPositions(array(0,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100,105,110));
  $graph->yaxis->HideZeroLabel();
  $graph->yaxis->SetTitle("delete rate(%)",middle);
  $graph->title->Set($beam);
  $graph->legend->Pos(0,0);
  $graph->legend->SetColumns(1);

  $lineplot1=new LinePlot($beamu);
  $graph->Add($lineplot1);
  $lineplot1->SetLegend("badbeam_usb");
  $lineplot1->SetStepStyle();
  $lineplot1->SetColor("black");

  $lineplot2=new LinePlot($beaml);
  $graph->Add($lineplot2);
  $lineplot2->SetLegend("badbeam_lsb");
  $lineplot2->SetStepStyle();
  $lineplot2->SetColor("red");

  $lineplot3=new LinePlot($lineu);
  $graph->Add($lineplot3);
  $lineplot3->SetLegend("badline_usb");
  $lineplot3->SetStepStyle();
  $lineplot3->SetColor("blue");

  $lineplot4=new LinePlot($linel);
  $graph->Add($lineplot4);
  $lineplot4->SetLegend("badline_lsb");
  $lineplot4->SetStepStyle();
  $lineplot4->SetColor("green");

  return $graph;
}
$graph1=plotaa("beam1",$arr_beaml[0],$arr_beamu[1],$arr_beaml[1],$arr_lineu[1],$arr_linel[1]);
$graph2=plotaa("beam2",$arr_beaml[0],$arr_beamu[2],$arr_beaml[2],$arr_lineu[2],$arr_linel[2]);
$graph3=plotaa("beam3",$arr_beaml[0],$arr_beamu[3],$arr_beaml[3],$arr_lineu[3],$arr_linel[3]);
$graph4=plotaa("beam4",$arr_beaml[0],$arr_beamu[4],$arr_beaml[4],$arr_lineu[4],$arr_linel[4]);
$graph5=plotaa("beam5",$arr_beaml[0],$arr_beamu[5],$arr_beaml[5],$arr_lineu[5],$arr_linel[5]);
$graph6=plotaa("beam6",$arr_beaml[0],$arr_beamu[6],$arr_beaml[6],$arr_lineu[6],$arr_linel[6]);
$graph7=plotaa("beam7",$arr_beaml[0],$arr_beamu[7],$arr_beaml[7],$arr_lineu[7],$arr_linel[7]);
$graph8=plotaa("beam8",$arr_beaml[0],$arr_beamu[8],$arr_beaml[8],$arr_lineu[8],$arr_linel[8]);
$graph9=plotaa("beam9",$arr_beaml[0],$arr_beamu[9],$arr_beaml[9],$arr_lineu[9],$arr_linel[9]);

$mgraph = new MGraph();
$mgraph->SetMargin(20,1,70,50); //set graph margin
$mgraph->SetFrame(true,"lightcyan",10);
$mgraph->Add($graph1,0,0);
$mgraph->Add($graph2,1000,0);
$mgraph->Add($graph3,2000,0);
$mgraph->Add($graph4,0,500);
$mgraph->Add($graph5,1000,500);
$mgraph->Add($graph6,2000,500);
$mgraph->Add($graph7,0,1000);
$mgraph->Add($graph8,1000,1000);
$mgraph->Add($graph9,2000,1000);
$mgraph->title->Set("Variation of different deletion rate with date in 2020-2021");
$mgraph->title->SetFont(FF_ARIAL,FS_BOLD,20);
$mgraph->title->SetMargin(30); //left margin about 20
$mgraph->Stroke();
                                               
?>  
