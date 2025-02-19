<?php
//BindEvents Method @1-E66A37A3
function BindEvents()
{
    global $camera_states_types;
    global $Panel2;
    global $Panel1;
    global $CCSEvents;
    $camera_states_types->corte->CCSEvents["BeforeShow"] = "camera_states_types_corte_BeforeShow";
    $camera_states_types->estado_ticket_inst->CCSEvents["BeforeShow"] = "camera_states_types_estado_ticket_inst_BeforeShow";
    $camera_states_types->estado_ticket->CCSEvents["BeforeShow"] = "camera_states_types_estado_ticket_BeforeShow";
    $camera_states_types->estado->CCSEvents["BeforeShow"] = "camera_states_types_estado_BeforeShow";
    $camera_states_types->Label1->CCSEvents["BeforeShow"] = "camera_states_types_Label1_BeforeShow";
    $camera_states_types->estado_novedad->CCSEvents["BeforeShow"] = "camera_states_types_estado_novedad_BeforeShow";
    $camera_states_types->reserva->CCSEvents["BeforeShow"] = "camera_states_types_reserva_BeforeShow";
    $Panel2->CCSEvents["BeforeShow"] = "Panel2_BeforeShow";
    $Panel1->CCSEvents["BeforeShow"] = "Panel1_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
    $CCSEvents["BeforeOutput"] = "Page_BeforeOutput";
    $CCSEvents["BeforeUnload"] = "Page_BeforeUnload";
}
//End BindEvents Method

//camera_states_types_corte_BeforeShow @76-A8558D43
function camera_states_types_corte_BeforeShow(& $sender)
{
    $camera_states_types_corte_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_states_types; //Compatibility
//End camera_states_types_corte_BeforeShow

//Custom Code @84-2A29BDB7
// -------------------------
	$corte = $camera_states_types->corte->GetValue();
	if($corte == 1){
		$camera_states_types->corte->SetValue("SI");
	}else{
		$camera_states_types->corte->SetValue("NO");
	}
// -------------------------
//End Custom Code

//Close camera_states_types_corte_BeforeShow @76-6D6E2603
    return $camera_states_types_corte_BeforeShow;
}
//End Close camera_states_types_corte_BeforeShow

//camera_states_types_estado_ticket_inst_BeforeShow @77-FEFBBCE1
function camera_states_types_estado_ticket_inst_BeforeShow(& $sender)
{
    $camera_states_types_estado_ticket_inst_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_states_types; //Compatibility
//End camera_states_types_estado_ticket_inst_BeforeShow

//Custom Code @85-2A29BDB7
// -------------------------
	$estado_ticket_inst = $camera_states_types->estado_ticket_inst->GetValue();
	if($estado_ticket_inst == 1){
		$camera_states_types->estado_ticket_inst->SetValue("SI");
	}else{
		$camera_states_types->estado_ticket_inst->SetValue("NO");
	}
// -------------------------
//End Custom Code

//Close camera_states_types_estado_ticket_inst_BeforeShow @77-FD3C1FCC
    return $camera_states_types_estado_ticket_inst_BeforeShow;
}
//End Close camera_states_types_estado_ticket_inst_BeforeShow

//camera_states_types_estado_ticket_BeforeShow @78-FD5E1A20
function camera_states_types_estado_ticket_BeforeShow(& $sender)
{
    $camera_states_types_estado_ticket_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_states_types; //Compatibility
//End camera_states_types_estado_ticket_BeforeShow

//Custom Code @86-2A29BDB7
// -------------------------
	$estado_ticket = $camera_states_types->estado_ticket->GetValue();
	if($estado_ticket == 1){
		$camera_states_types->estado_ticket->SetValue("SI");
	}else{
		$camera_states_types->estado_ticket->SetValue("NO");
	}
// -------------------------
//End Custom Code

//Close camera_states_types_estado_ticket_BeforeShow @78-D7AE3D5A
    return $camera_states_types_estado_ticket_BeforeShow;
}
//End Close camera_states_types_estado_ticket_BeforeShow

//camera_states_types_estado_BeforeShow @79-1E3CB62A
function camera_states_types_estado_BeforeShow(& $sender)
{
    $camera_states_types_estado_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_states_types; //Compatibility
//End camera_states_types_estado_BeforeShow

//Custom Code @87-2A29BDB7
// -------------------------
	$estado = $camera_states_types->estado->GetValue();
	if($estado == 1){
		$camera_states_types->estado->SetValue("SI");
	}else{
		$camera_states_types->estado->SetValue("NO");
	}
// -------------------------
//End Custom Code

//Close camera_states_types_estado_BeforeShow @79-6F974400
    return $camera_states_types_estado_BeforeShow;
}
//End Close camera_states_types_estado_BeforeShow

//camera_states_types_Label1_BeforeShow @95-65B87DE8
function camera_states_types_Label1_BeforeShow(& $sender)
{
    $camera_states_types_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_states_types; //Compatibility
//End camera_states_types_Label1_BeforeShow

//Custom Code @96-2A29BDB7
// -------------------------
	$Label1 = $camera_states_types->Label1->GetValue();
	if(trim($Label1) != ''){
		$camera_states_types->Label1->SetValue("<img src='".$camera_states_types->Label1->GetValue()."' />");
	}else{
		$camera_states_types->Label1->SetValue("");
	}
// -------------------------
//End Custom Code

//Close camera_states_types_Label1_BeforeShow @95-FB6AA83A
    return $camera_states_types_Label1_BeforeShow;
}
//End Close camera_states_types_Label1_BeforeShow

//camera_states_types_estado_novedad_BeforeShow @97-9485F1E7
function camera_states_types_estado_novedad_BeforeShow(& $sender)
{
    $camera_states_types_estado_novedad_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_states_types; //Compatibility
//End camera_states_types_estado_novedad_BeforeShow

//Custom Code @102-2A29BDB7
// -------------------------
	$estado_novedad = $camera_states_types->estado_novedad->GetValue();
	if($estado_novedad == 1){
		$camera_states_types->estado_novedad->SetValue("SI");
	}else{
		$camera_states_types->estado_novedad->SetValue("NO");
	}
// -------------------------
//End Custom Code

//Close camera_states_types_estado_novedad_BeforeShow @97-676A82FB
    return $camera_states_types_estado_novedad_BeforeShow;
}
//End Close camera_states_types_estado_novedad_BeforeShow

//camera_states_types_reserva_BeforeShow @103-F0168680
function camera_states_types_reserva_BeforeShow(& $sender)
{
    $camera_states_types_reserva_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_states_types; //Compatibility
//End camera_states_types_reserva_BeforeShow

//Custom Code @105-2A29BDB7
// -------------------------
	$reserva = $camera_states_types->reserva->GetValue();
	if($reserva == 1){
		$camera_states_types->reserva->SetValue("SI");
	}else{
		$camera_states_types->reserva->SetValue("NO");
	}
// -------------------------
//End Custom Code

//Close camera_states_types_reserva_BeforeShow @103-8AACD76F
    return $camera_states_types_reserva_BeforeShow;
}
//End Close camera_states_types_reserva_BeforeShow

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

//Panel1UpdatePanel1 Page BeforeShow @21-546243CA
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

//Page_BeforeInitialize @1-E4FC4867
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $estados_camara; //Compatibility
//End Page_BeforeInitialize

//Custom Code @70-2A29BDB7
// -------------------------
	include_once(RelativePath . "/scripts/functions.php");

	// Incluye el archivo de configuraciones generales
    global $appConfig;
    global $appConfigJs;
	include_once(RelativePath . "/configuration.php");
// -------------------------
//End Custom Code

//Panel1UpdatePanel1 PageBeforeInitialize @21-37A82194
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

//Page_AfterInitialize @1-90552CC4
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $estados_camara; //Compatibility
//End Page_AfterInitialize

//Custom Code @71-2A29BDB7
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

//Page_BeforeShow @1-3468800E
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $estados_camara; //Compatibility
//End Page_BeforeShow

//Panel1UpdatePanel1 Page BeforeShow @21-9F5F0EA1
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

//Page_BeforeOutput @1-DD62D81E
function Page_BeforeOutput(& $sender)
{
    $Page_BeforeOutput = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $estados_camara; //Compatibility
//End Page_BeforeOutput

//Panel1UpdatePanel1 PageBeforeOutput @21-0DFF2749
    global $CCSFormFilter, $Tpl, $main_block;
    if ($CCSFormFilter == "Panel1") {
        $main_block = $_SERVER["REQUEST_URI"] . "|" . $Tpl->getvar("/Panel Panel1");
    }
//End Panel1UpdatePanel1 PageBeforeOutput

//Close Page_BeforeOutput @1-8964C188
    return $Page_BeforeOutput;
}
//End Close Page_BeforeOutput

//Page_BeforeUnload @1-298716BF
function Page_BeforeUnload(& $sender)
{
    $Page_BeforeUnload = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $estados_camara; //Compatibility
//End Page_BeforeUnload

//Panel1UpdatePanel1 PageBeforeUnload @21-483BFCB6
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
