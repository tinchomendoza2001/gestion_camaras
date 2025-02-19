<?php
//BindEvents Method @1-1D044DAA
function BindEvents()
{
    global $camera_providers_connexio;
    global $camera_providers_connexio1;
    global $Panel2;
    global $Panel3;
    global $Panel1;
    global $CCSEvents;
    $camera_providers_connexio->webservice->CCSEvents["BeforeShow"] = "camera_providers_connexio_webservice_BeforeShow";
    $camera_providers_connexio->CCSEvents["BeforeShowRow"] = "camera_providers_connexio_BeforeShowRow";
    $camera_providers_connexio1->CCSEvents["BeforeShow"] = "camera_providers_connexio1_BeforeShow";
    $camera_providers_connexio1->CCSEvents["AfterInsert"] = "camera_providers_connexio1_AfterInsert";
    $camera_providers_connexio1->CCSEvents["AfterUpdate"] = "camera_providers_connexio1_AfterUpdate";
    $Panel2->CCSEvents["BeforeShow"] = "Panel2_BeforeShow";
    $Panel3->CCSEvents["BeforeShow"] = "Panel3_BeforeShow";
    $Panel1->CCSEvents["BeforeShow"] = "Panel1_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
    $CCSEvents["BeforeOutput"] = "Page_BeforeOutput";
    $CCSEvents["BeforeUnload"] = "Page_BeforeUnload";
}
//End BindEvents Method

//camera_providers_connexio_webservice_BeforeShow @199-ABB7C815
function camera_providers_connexio_webservice_BeforeShow(& $sender)
{
    $camera_providers_connexio_webservice_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_providers_connexio; //Compatibility
//End camera_providers_connexio_webservice_BeforeShow

//Custom Code @200-2A29BDB7
// -------------------------
	$valor = $camera_providers_connexio->webservice->GetValue();
	if($valor == 1){
		$camera_providers_connexio->webservice->SetValue("SI");
	}else{
    	$camera_providers_connexio->webservice->SetValue("NO");
	}
// -------------------------
//End Custom Code

//Close camera_providers_connexio_webservice_BeforeShow @199-FD2E2AA1
    return $camera_providers_connexio_webservice_BeforeShow;
}
//End Close camera_providers_connexio_webservice_BeforeShow

//camera_providers_connexio_BeforeShowRow @4-484B007C
function camera_providers_connexio_BeforeShowRow(& $sender)
{
    $camera_providers_connexio_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_providers_connexio; //Compatibility
//End camera_providers_connexio_BeforeShowRow

//Custom Code @161-2A29BDB7
// -------------------------
	$id = $camera_providers_connexio->DataSource->f('id');
	$db = new clsDBminseg();
	$SQL = "SELECT camera_projects.camera_project_descrip AS camera_project_descrip
				FROM camera_providers_projects
				LEFT JOIN camera_projects ON camera_providers_projects.camera_project_id = camera_projects.camera_project_id
				WHERE camera_provider_connexion_id = $id";
	$db->query($SQL);
	if($db->num_rows() > 0){
		while($db->next_record()){
			$proyectos[] = $db->f('camera_project_descrip');
		}
		$camera_providers_connexio->proyectos->SetValue(implode("<br>",$proyectos));
	}else{
		$camera_providers_connexio->proyectos->SetValue('');
	}
	$SQL = "SELECT camera_user_email
				FROM camera_users_emails
				WHERE camera_user_id = $id AND type_user = 1";
	$db->query($SQL);
	if($db->num_rows() > 0){
		while($db->next_record()){
			$correos[] = $db->f('camera_user_email');
		}
		$camera_providers_connexio->correos->SetValue(implode("<br>",$correos));
	}else{
		$camera_providers_connexio->correos->SetValue('');
	}
	//cm_asociados
	$SQL = "SELECT camera_monitoring_center.long_descrip AS long_descrip
			FROM camera_providers_mc INNER JOIN camera_monitoring_center ON camera_providers_mc.monitoring_center_id = camera_monitoring_center.id
			WHERE camera_providers_mc.provider_connexion_id = $id";
	$db->query($SQL);
	if($db->num_rows() > 0){
		while($db->next_record()){
			$cm_asociados[] = $db->f('long_descrip');
		}
		$camera_providers_connexio->cm_asociados->SetValue(implode("<br>",$cm_asociados));
	}else{
		$camera_providers_connexio->cm_asociados->SetValue('');
	}
	$db->close();
	
// -------------------------
//End Custom Code

//Close camera_providers_connexio_BeforeShowRow @4-0F4B4214
    return $camera_providers_connexio_BeforeShowRow;
}
//End Close camera_providers_connexio_BeforeShowRow

//camera_providers_connexio1_BeforeShow @32-EC5857E5
function camera_providers_connexio1_BeforeShow(& $sender)
{
    $camera_providers_connexio1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_providers_connexio1; //Compatibility
//End camera_providers_connexio1_BeforeShow

//Custom Code @140-2A29BDB7
// -------------------------
	if(CCGetParam('id')){
		$html = array();
		$db = new clsDBminseg();
		$SQL = "SELECT camera_user_email FROM camera_users_emails WHERE camera_user_id = ".CCGetParam('id')." AND type_user = 1";
		$db->query($SQL);
		if($db->num_rows() > 0){
			while($db->next_record()){
				$html[] = $db->f('camera_user_email');
			}
			$camera_providers_connexio1->lista_correos->SetValue(implode("<br>",$html));
		}

		$SQL = "SELECT camera_project_id FROM camera_providers_projects WHERE camera_provider_connexion_id = ".CCGetParam('id');
		$db->query($SQL);
		while($db->next_record()){
			$a[] = $db->f('camera_project_id');
		}
		if(count($a) > 0){
			$Component->CheckBoxList1->Value = $a;
		}
		
		$SQL = "SELECT monitoring_center_id FROM camera_providers_mc WHERE provider_connexion_id = ".CCGetParam('id');
		$db->query($SQL);
		while($db->next_record()){
			$b[] = $db->f('monitoring_center_id');
		}
		if(count($b) > 0){
			$Component->CheckBoxList3->Value = $b;
		}
		
		$db->close();		
	}else{
	 $camera_providers_connexio1->Link1->Visible = False;
	}
// -------------------------
//End Custom Code

//Close camera_providers_connexio1_BeforeShow @32-CED2DEF7
    return $camera_providers_connexio1_BeforeShow;
}
//End Close camera_providers_connexio1_BeforeShow

//camera_providers_connexio1_AfterInsert @32-CCA77D05
function camera_providers_connexio1_AfterInsert(& $sender)
{
    $camera_providers_connexio1_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_providers_connexio1; //Compatibility
//End camera_providers_connexio1_AfterInsert

//Custom Code @159-2A29BDB7
// -------------------------
    $db = new clsDBminseg();
    if(mysql_insert_id()){
    	$camera_provider_connexion_id = mysql_insert_id();
    }else{
    	$camera_provider_connexion_id = CCDLookUp("MAX(id)","camera_providers_connexions","",$db);
    }
    if($camera_provider_connexion_id){
		$usuario_id = CCGetUserID();
		if(CCGetParam('CheckBoxList1')){
			$s = CCGetParam('CheckBoxList1');
			while (list ($clave, $val) = each ($s)) {
		 	   $SQL = "INSERT INTO camera_providers_projects SET
							camera_provider_connexion_id = $camera_provider_connexion_id,
							camera_project_id = $val";
			   $db->query($SQL);
			}
		}
		if(CCGetParam('CheckBoxList3')){
			$t = CCGetParam('CheckBoxList3');
			while (list ($clave, $val) = each ($t)) {
		 	   $SQL = "INSERT INTO camera_providers_mc SET
							provider_connexion_id = $camera_provider_connexion_id,
							monitoring_center_id = $val";
			   $db->query($SQL);
			}
		}		
    }
    $db->close();
// -------------------------
//End Custom Code

//Close camera_providers_connexio1_AfterInsert @32-5ABA8FAE
    return $camera_providers_connexio1_AfterInsert;
}
//End Close camera_providers_connexio1_AfterInsert

//camera_providers_connexio1_AfterUpdate @32-18A4328B
function camera_providers_connexio1_AfterUpdate(& $sender)
{
    $camera_providers_connexio1_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_providers_connexio1; //Compatibility
//End camera_providers_connexio1_AfterUpdate

//Custom Code @160-2A29BDB7
// -------------------------
    $db = new clsDBminseg();
	$usuario_id = CCGetUserID();
	if(CCGetParam('id') > 0){
		$camera_provider_connexion_id = CCGetParam('id');	
		$SQL = "DELETE FROM camera_providers_projects WHERE camera_provider_connexion_id = $camera_provider_connexion_id";
		$db->query($SQL);	
		if(CCGetParam('CheckBoxList1')){
			$s = CCGetParam('CheckBoxList1');
			while (list ($clave, $val) = each ($s)) {
		 	   $SQL = "INSERT INTO camera_providers_projects SET
							camera_provider_connexion_id = $camera_provider_connexion_id,
							camera_project_id = $val";
			   $db->query($SQL);
			}
		}
		$SQL = "DELETE FROM camera_providers_mc WHERE provider_connexion_id = $camera_provider_connexion_id";
		$db->query($SQL);		
		if(CCGetParam('CheckBoxList3')){
			$t = CCGetParam('CheckBoxList3');
			while (list ($clave, $val) = each ($t)) {
		 	   $SQL = "INSERT INTO camera_providers_mc SET
							provider_connexion_id = $camera_provider_connexion_id,
							monitoring_center_id = $val";
			   $db->query($SQL);
			}
		}
	}
    $db->close();
// -------------------------
//End Custom Code

//Close camera_providers_connexio1_AfterUpdate @32-95934E21
    return $camera_providers_connexio1_AfterUpdate;
}
//End Close camera_providers_connexio1_AfterUpdate

//Panel2_BeforeShow @31-96696C3D
function Panel2_BeforeShow(& $sender)
{
    $Panel2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel2; //Compatibility
//End Panel2_BeforeShow

//Close Panel2_BeforeShow @31-AE7F9FB3
    return $Panel2_BeforeShow;
}
//End Close Panel2_BeforeShow

//Panel3_BeforeShow @103-34D6D0C7
function Panel3_BeforeShow(& $sender)
{
    $Panel3_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel3; //Compatibility
//End Panel3_BeforeShow

//Close Panel3_BeforeShow @103-33707EC5
    return $Panel3_BeforeShow;
}
//End Close Panel3_BeforeShow

//Panel1_BeforeShow @3-AAD8AF72
function Panel1_BeforeShow(& $sender)
{
    $Panel1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel1; //Compatibility
//End Panel1_BeforeShow

//Panel1UpdatePanel1 Page BeforeShow @45-546243CA
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

//Page_BeforeInitialize @1-235765E3
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $proveedor_conexion; //Compatibility
//End Page_BeforeInitialize

//Custom Code @94-2A29BDB7
// -------------------------
	include_once(RelativePath . "/scripts/functions.php");

	// Incluye el archivo de configuraciones generales
    global $appConfig;
    global $appConfigJs;
	include_once(RelativePath . "/configuration.php");
// -------------------------
//End Custom Code

//Panel1UpdatePanel1 PageBeforeInitialize @45-37A82194
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

//Page_AfterInitialize @1-1BFA0271
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $proveedor_conexion; //Compatibility
//End Page_AfterInitialize

//Custom Code @95-2A29BDB7
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

//Page_BeforeShow @1-693B8758
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $proveedor_conexion; //Compatibility
//End Page_BeforeShow

//Panel1UpdatePanel1 Page BeforeShow @45-9F5F0EA1
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

//Page_BeforeOutput @1-78B41D99
function Page_BeforeOutput(& $sender)
{
    $Page_BeforeOutput = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $proveedor_conexion; //Compatibility
//End Page_BeforeOutput

//Panel1UpdatePanel1 PageBeforeOutput @45-0DFF2749
    global $CCSFormFilter, $Tpl, $main_block;
    if ($CCSFormFilter == "Panel1") {
        $main_block = $_SERVER["REQUEST_URI"] . "|" . $Tpl->getvar("/Panel Panel1");
    }
//End Panel1UpdatePanel1 PageBeforeOutput

//Close Page_BeforeOutput @1-8964C188
    return $Page_BeforeOutput;
}
//End Close Page_BeforeOutput

//Page_BeforeUnload @1-8F8BE91F
function Page_BeforeUnload(& $sender)
{
    $Page_BeforeUnload = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $proveedor_conexion; //Compatibility
//End Page_BeforeUnload

//Panel1UpdatePanel1 PageBeforeUnload @45-483BFCB6
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
