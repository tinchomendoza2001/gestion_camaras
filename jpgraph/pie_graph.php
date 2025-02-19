<?php 
require_once ('jpgraph.php');
require_once ('jpgraph_pie.php');

$data = array(90,30,11,3);

$graph = new PieGraph(279,220);
$graph->legend->SetPos('rigth','top');
$graph->legend->SetColumns(2);
$graph->legend->SetShadow('gray',0);

$p1 = new PiePlot($data);
$p1->SetGuideLines(true,true,true,true);
$p1->SetSliceColors(array("#008C23","#FF8000","#D90000","#D9D9D9"));
$p1->SetCenter(0.5,0.55); 
$legends = array('En Funcionamiento(%d)','Con Falla(%d)','No Funciona(%d)','Retirada(%d)');
$p1->SetSize(0.3);
$p1->SetLegends($legends); 

$graph->Add($p1);
$graph->Stroke();
?>