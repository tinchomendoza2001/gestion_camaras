<?php

//BindEvents Method @1-AA114E7F
function BindEvents()
{
    global $camera_reasons_events;
    global $CCSEvents;
    $camera_reasons_events->CCSEvents["BeforeShow"] = "camera_reasons_events_BeforeShow";
    $camera_reasons_events->CCSEvents["BeforeShowRow"] = "camera_reasons_events_BeforeShowRow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//camera_reasons_events_BeforeShow @7-67CF6E4E
function camera_reasons_events_BeforeShow(& $sender)
{
    $camera_reasons_events_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_reasons_events; //Compatibility
//End camera_reasons_events_BeforeShow

//Custom Code @28-2A29BDB7
// -------------------------
    global $linea;
    $linea = 1;
// -------------------------
//End Custom Code

//Close camera_reasons_events_BeforeShow @7-2F5F58D2
    return $camera_reasons_events_BeforeShow;
}
//End Close camera_reasons_events_BeforeShow

//camera_reasons_events_BeforeShowRow @7-150F177E
function camera_reasons_events_BeforeShowRow(& $sender)
{
    $camera_reasons_events_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_reasons_events; //Compatibility
//End camera_reasons_events_BeforeShowRow

//Custom Code @29-2A29BDB7
// -------------------------
    global $linea;
    $camera_reasons_events->linea->SetValue($linea);
    $linea = $linea + 1;
    $id = $camera_reasons_events->DataSource->f('id');
    $camera_reasons_events->CheckBox1->SetValue(FALSE);
    $camera_reasons_events->CheckBox2->SetValue(FALSE);
    $camera_reasons_events->CheckBox3->SetValue(FALSE);
    $camera_reasons_events->CheckBox4->SetValue(FALSE);
    $db = new clsDBminseg();
    //si hay para administrador
    $cant = CCDLookUp("COUNT(*)","camera_reason_event_groups","reason_event_id = $id AND group_id = 1",$db);
    if($cant){
    	$camera_reasons_events->CheckBox1->SetValue(TRUE);
    }
    //si hay para operador
    $cant = CCDLookUp("COUNT(*)","camera_reason_event_groups","reason_event_id = $id AND group_id = 2",$db);
    if($cant){
    	$camera_reasons_events->CheckBox2->SetValue(TRUE);
    }
    //si hay para consulta
    $cant = CCDLookUp("COUNT(*)","camera_reason_event_groups","reason_event_id = $id AND group_id = 3",$db);
    if($cant){
    	$camera_reasons_events->CheckBox3->SetValue(TRUE);
    }
    //si hay para directivo
    $cant = CCDLookUp("COUNT(*)","camera_reason_event_groups","reason_event_id = $id AND group_id = 4",$db);
    if($cant){
    	$camera_reasons_events->CheckBox4->SetValue(TRUE);
    }
    $db->close();
// -------------------------
//End Custom Code

//Close camera_reasons_events_BeforeShowRow @7-D570B51E
    return $camera_reasons_events_BeforeShowRow;
}
//End Close camera_reasons_events_BeforeShowRow

//Page_BeforeInitialize @1-7B53FC6B
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $motivo_grupo; //Compatibility
//End Page_BeforeInitialize

//Custom Code @2-2A29BDB7
// -------------------------
	include_once(RelativePath . "/scripts/functions.php");

	// Incluye el archivo de configuraciones generales
    global $appConfig;
    global $appConfigJs;
	include_once(RelativePath . "/configuration.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

//Page_AfterInitialize @1-7A2D08BC
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $motivo_grupo; //Compatibility
//End Page_AfterInitialize

//Custom Code @3-2A29BDB7
// -------------------------
    global $appConfig;
	// Asigna valores de acuerdo al entorno en el que corre la aplicacion
    $Component->app_environment_class->SetValue('app-environment-' . $appConfig['environment']);
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize


?>
