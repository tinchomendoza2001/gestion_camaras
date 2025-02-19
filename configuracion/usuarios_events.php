<?php
//BindEvents Method @1-CE51C32D
function BindEvents()
{
    global $camera_users;
    global $Panel1;
    global $CCSEvents;
    $camera_users->activo->CCSEvents["BeforeShow"] = "camera_users_activo_BeforeShow";
    $camera_users->CCSEvents["BeforeShowRow"] = "camera_users_BeforeShowRow";
    $Panel1->CCSEvents["BeforeShow"] = "Panel1_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
    $CCSEvents["BeforeOutput"] = "Page_BeforeOutput";
    $CCSEvents["BeforeUnload"] = "Page_BeforeUnload";
}
//End BindEvents Method

//camera_users_activo_BeforeShow @130-C6C17B0C
function camera_users_activo_BeforeShow(& $sender)
{
    $camera_users_activo_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_users; //Compatibility
//End camera_users_activo_BeforeShow

//Custom Code @131-2A29BDB7
// -------------------------

// -------------------------
//End Custom Code

//Close camera_users_activo_BeforeShow @130-004BAA51
    return $camera_users_activo_BeforeShow;
}
//End Close camera_users_activo_BeforeShow

//camera_users_BeforeShowRow @4-7881022C
function camera_users_BeforeShowRow(& $sender)
{
    $camera_users_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_users; //Compatibility
//End camera_users_BeforeShowRow

//Custom Code @160-2A29BDB7
// -------------------------
    $active = $camera_users->DataSource->f('active');
    $ticket = $camera_users->DataSource->f('ticket');
    $nota = $camera_users->DataSource->f('nota');
    if($active == 1){
    	$camera_users->activo->SetValue("SI");
    }else{
    	$camera_users->activo->SetValue("NO");
    }
    if($ticket == 1){
    	$camera_users->ticket->SetValue("SI");
    }else{
    	$camera_users->ticket->SetValue("NO");
    }
    if($nota == 1){
    	$camera_users->nota->SetValue("SI");
    }else{
    	$camera_users->nota->SetValue("NO");
    }
    $camera_users_id = $camera_users->DataSource->f('camera_users_id');
    $db = new clsDBminseg();
    //perfiles
    $SQL = "SELECT camera_profiles.camera_profile_descrip AS camera_profile_descrip
					FROM camera_users_profiles
					INNER JOIN camera_profiles ON camera_users_profiles.camera_profile_id = camera_profiles.camera_profile_id
					WHERE camera_users_profiles.camera_user_id = $camera_users_id";
    $db->query($SQL);
    while($db->next_record()){
    	$perfiles[] = $db->f('camera_profile_descrip');
    }
    $camera_users->perfil->SetValue(implode("<br>", (array)$perfiles));
    //centos de monitoreo
    $SQL = "SELECT camera_monitoring_center.long_descrip AS long_descrip
					FROM camera_cm_users
					INNER JOIN camera_monitoring_center ON camera_cm_users.camera_monitor_center_id = camera_monitoring_center.id
					WHERE camera_cm_users.camera_user_id = $camera_users_id";
    $db->query($SQL);
    if($db->num_rows() > 0){
		while($db->next_record()){
			$cms[] = $db->f('long_descrip');
		}
		$camera_users->cm->SetValue(implode("<br>", (array)$cms));
	}else{
		$camera_users->cm->SetValue("");
	}
// -------------------------
//End Custom Code

//Close camera_users_BeforeShowRow @4-D8DC74BA
    return $camera_users_BeforeShowRow;
}
//End Close camera_users_BeforeShowRow

//Panel1_BeforeShow @3-AAD8AF72
function Panel1_BeforeShow(& $sender)
{
    $Panel1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel1; //Compatibility
//End Panel1_BeforeShow

//Panel1UpdatePanel1 Page BeforeShow @42-546243CA
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

//Page_BeforeShow @1-69E7FD74
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $usuarios; //Compatibility
//End Page_BeforeShow

//Custom Code @126-2A29BDB7
// -------------------------
	$user_id = CCGetUserID();
	$db = new clsDBminseg();
	$paso = CCDLookUp("ges_user","camera_users","id=$user_id",$db);
	$db->close();
    if($paso != 1){
    	global $Redirect;
    	$Redirect="denegado.php";
    }
// -------------------------
//End Custom Code

//Panel1UpdatePanel1 Page BeforeShow @42-9F5F0EA1
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

//Page_BeforeInitialize @1-CF211080
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $usuarios; //Compatibility
//End Page_BeforeInitialize

//Custom Code @127-2A29BDB7
// -------------------------
	include_once(RelativePath . "/scripts/functions.php");

	// Incluye el archivo de configuraciones generales
    global $appConfig;
    global $appConfigJs;
	include_once(RelativePath . "/configuration.php");
// -------------------------
//End Custom Code

//Panel1UpdatePanel1 PageBeforeInitialize @42-37A82194
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

//Page_AfterInitialize @1-A088CAC1
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $usuarios; //Compatibility
//End Page_AfterInitialize

//Custom Code @128-2A29BDB7
// -------------------------
    global $appConfig;
	// Asigna valores de acuerdo al entorno en el que corre la aplicación
    $Component->app_environment_class->SetValue('app-environment-' . $appConfig['environment']);
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeOutput @1-3C75A041
function Page_BeforeOutput(& $sender)
{
    $Page_BeforeOutput = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $usuarios; //Compatibility
//End Page_BeforeOutput

//Panel1UpdatePanel1 PageBeforeOutput @42-0DFF2749
    global $CCSFormFilter, $Tpl, $main_block;
    if ($CCSFormFilter == "Panel1") {
        $main_block = $_SERVER["REQUEST_URI"] . "|" . $Tpl->getvar("/Panel Panel1");
    }
//End Panel1UpdatePanel1 PageBeforeOutput

//Close Page_BeforeOutput @1-8964C188
    return $Page_BeforeOutput;
}
//End Close Page_BeforeOutput

//Page_BeforeUnload @1-8267D8B6
function Page_BeforeUnload(& $sender)
{
    $Page_BeforeUnload = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $usuarios; //Compatibility
//End Page_BeforeUnload

//Panel1UpdatePanel1 PageBeforeUnload @42-483BFCB6
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
