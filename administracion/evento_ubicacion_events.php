<?php
//BindEvents Method @1-C765B399
function BindEvents()
{
    global $camera_reasons_events;
    global $Panel2;
    global $Panel1;
    global $CCSEvents;
    $camera_reasons_events->Label1->CCSEvents["BeforeShow"] = "camera_reasons_events_Label1_BeforeShow";
    $camera_reasons_events->Label2->CCSEvents["BeforeShow"] = "camera_reasons_events_Label2_BeforeShow";
    $camera_reasons_events->Label3->CCSEvents["BeforeShow"] = "camera_reasons_events_Label3_BeforeShow";
    $Panel2->CCSEvents["BeforeShow"] = "Panel2_BeforeShow";
    $Panel1->CCSEvents["BeforeShow"] = "Panel1_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
    $CCSEvents["BeforeOutput"] = "Page_BeforeOutput";
    $CCSEvents["BeforeUnload"] = "Page_BeforeUnload";
}
//End BindEvents Method

//camera_reasons_events_Label1_BeforeShow @78-CC9373BA
function camera_reasons_events_Label1_BeforeShow(& $sender)
{
    $camera_reasons_events_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_reasons_events; //Compatibility
//End camera_reasons_events_Label1_BeforeShow

//Custom Code @81-2A29BDB7
// -------------------------
    $Label1 = $camera_reasons_events->Label1->GetValue();
    if($Label1 == '1'){
    	$camera_reasons_events->Label1->SetValue("SI");
    }else{
    	$camera_reasons_events->Label1->SetValue("NO");
    }
// -------------------------
//End Custom Code

//Close camera_reasons_events_Label1_BeforeShow @78-E2ED5B7D
    return $camera_reasons_events_Label1_BeforeShow;
}
//End Close camera_reasons_events_Label1_BeforeShow

//camera_reasons_events_Label2_BeforeShow @79-7229B707
function camera_reasons_events_Label2_BeforeShow(& $sender)
{
    $camera_reasons_events_Label2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_reasons_events; //Compatibility
//End camera_reasons_events_Label2_BeforeShow

//Custom Code @82-2A29BDB7
// -------------------------
	$Label2 = $camera_reasons_events->Label2->GetValue();
    if($Label2 == '1'){
    	$camera_reasons_events->Label2->SetValue("SI");
    }else{
    	$camera_reasons_events->Label2->SetValue("NO");
    }
// -------------------------
//End Custom Code

//Close camera_reasons_events_Label2_BeforeShow @79-9E8C7EA6
    return $camera_reasons_events_Label2_BeforeShow;
}
//End Close camera_reasons_events_Label2_BeforeShow

//camera_reasons_events_Label3_BeforeShow @80-18400B6C
function camera_reasons_events_Label3_BeforeShow(& $sender)
{
    $camera_reasons_events_Label3_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_reasons_events; //Compatibility
//End camera_reasons_events_Label3_BeforeShow

//Custom Code @83-2A29BDB7
// -------------------------
	$Label3 = $camera_reasons_events->Label3->GetValue();
    if($Label3 == '1'){
    	$camera_reasons_events->Label3->SetValue("SI");
    }else{
    	$camera_reasons_events->Label3->SetValue("NO");
    }
// -------------------------
//End Custom Code

//Close camera_reasons_events_Label3_BeforeShow @80-03839FD0
    return $camera_reasons_events_Label3_BeforeShow;
}
//End Close camera_reasons_events_Label3_BeforeShow

//Panel2_BeforeShow @13-96696C3D
function Panel2_BeforeShow(& $sender)
{
    $Panel2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel2; //Compatibility
//End Panel2_BeforeShow

//Close Panel2_BeforeShow @13-AE7F9FB3
    return $Panel2_BeforeShow;
}
//End Close Panel2_BeforeShow

//Panel1_BeforeShow @3-AAD8AF72
function Panel1_BeforeShow(& $sender)
{
    $Panel1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel1; //Compatibility
//End Panel1_BeforeShow

//Panel1UpdatePanel1 Page BeforeShow @22-546243CA
    global $CCSFormFilter;
    if ($CCSFormFilter == "Panel1") {
        $Component->BlockPrefix = "";
        $Component->BlockSuffix = "";
    } else {
        $Component->BlockPrefix = "<div id=\"Panel1\">";
        $Component->BlockSuffix = "</div>";
    }
//End Panel1UpdatePanel1 Page BeforeShow

//Close Panel1_BeforeShow @3-D21EBA68
    return $Panel1_BeforeShow;
}
//End Close Panel1_BeforeShow

//Page_BeforeInitialize @1-C29605EE
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $evento_ubicacion; //Compatibility
//End Page_BeforeInitialize

//Custom Code @71-2A29BDB7
// -------------------------
	include_once(RelativePath . "/scripts/functions.php");

	// Incluye el archivo de configuraciones generales
    global $appConfig;
    global $appConfigJs;
	include_once(RelativePath . "/configuration.php");
// -------------------------
//End Custom Code

//Panel1UpdatePanel1 PageBeforeInitialize @22-37A82194
    if (CCGetFromGet("FormFilter") == "Panel1" && CCGetFromGet("IsParamsEncoded") != "true") {
        global $CCSLocales, $CCSIsParamsEncoded;
        CCConvertDataArrays("UTF-8", $CCSLocales->GetFormatInfo("PHPEncoding"));
        $CCSIsParamsEncoded = true;
    }
//End Panel1UpdatePanel1 PageBeforeInitialize

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

//Page_AfterInitialize @1-0D633B2C
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $evento_ubicacion; //Compatibility
//End Page_AfterInitialize

//Custom Code @72-2A29BDB7
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

//Page_BeforeShow @1-E3164F16
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $evento_ubicacion; //Compatibility
//End Page_BeforeShow

//Panel1UpdatePanel1 Page BeforeShow @22-9F5F0EA1
    global $CCSFormFilter;
    if (CCGetFromGet("FormFilter") == "Panel1") {
        $CCSFormFilter = CCGetFromGet("FormFilter");
        unset($_GET["FormFilter"]);
        if (isset($_GET["IsParamsEncoded"])) unset($_GET["IsParamsEncoded"]);
    }
//End Panel1UpdatePanel1 Page BeforeShow

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow

//Page_BeforeOutput @1-CC646D8B
function Page_BeforeOutput(& $sender)
{
    $Page_BeforeOutput = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $evento_ubicacion; //Compatibility
//End Page_BeforeOutput

//Panel1UpdatePanel1 PageBeforeOutput @22-0DFF2749
    global $CCSFormFilter, $Tpl, $main_block;
    if ($CCSFormFilter == "Panel1") {
        $main_block = $_SERVER["REQUEST_URI"] . "|" . $Tpl->getvar("/Panel Panel1");
    }
//End Panel1UpdatePanel1 PageBeforeOutput

//Close Page_BeforeOutput @1-8964C188
    return $Page_BeforeOutput;
}
//End Close Page_BeforeOutput

//Page_BeforeUnload @1-07A4FB71
function Page_BeforeUnload(& $sender)
{
    $Page_BeforeUnload = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $evento_ubicacion; //Compatibility
//End Page_BeforeUnload

//Panel1UpdatePanel1 PageBeforeUnload @22-483BFCB6
    global $Redirect, $CCSFormFilter, $CCSIsParamsEncoded;
    if ($Redirect && $CCSFormFilter == "Panel1") {
        if ($CCSIsParamsEncoded) $Redirect = CCAddParam($Redirect, "IsParamsEncoded", "true");
        $Redirect = CCAddParam($Redirect, "FormFilter", $CCSFormFilter);
    }
//End Panel1UpdatePanel1 PageBeforeUnload

//Close Page_BeforeUnload @1-CFAEC742
    return $Page_BeforeUnload;
}
//End Close Page_BeforeUnload


?>
