<?php
//BindEvents Method @1-840D9395
function BindEvents()
{
    global $racksSearch;
    global $Panel2;
    global $proveedores1;
    global $proveedores2;
    global $Panel6;
    global $Proveedor;
    global $racks1;
    global $racks2;
    global $Panel5;
    global $Panel3;
    global $Panel1;
    global $CCSEvents;
    $racksSearch->CCSEvents["OnValidate"] = "racksSearch_OnValidate";
    $Panel2->CCSEvents["BeforeShow"] = "Panel2_BeforeShow";
    $proveedores1->CCSEvents["BeforeShow"] = "proveedores1_BeforeShow";
    $proveedores2->Button_Insert->CCSEvents["OnClick"] = "proveedores2_Button_Insert_OnClick";
    $proveedores2->Borrar->CCSEvents["OnClick"] = "proveedores2_Borrar_OnClick";
    $Panel6->CCSEvents["BeforeShow"] = "Panel6_BeforeShow";
    $Proveedor->CCSEvents["BeforeShow"] = "Proveedor_BeforeShow";
    $racks1->CCSEvents["BeforeShow"] = "racks1_BeforeShow";
    $racks2->Button_Insert->CCSEvents["OnClick"] = "racks2_Button_Insert_OnClick";
    $racks2->Button_Update->CCSEvents["OnClick"] = "racks2_Button_Update_OnClick";
    $Panel5->CCSEvents["BeforeShow"] = "Panel5_BeforeShow";
    $Panel3->CCSEvents["BeforeShow"] = "Panel3_BeforeShow";
    $Panel1->CCSEvents["BeforeShow"] = "Panel1_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
    $CCSEvents["BeforeOutput"] = "Page_BeforeOutput";
    $CCSEvents["BeforeUnload"] = "Page_BeforeUnload";
}
//End BindEvents Method

//DEL  // -------------------------
//DEL      $proveedores2->Visible = false;
//DEL  // -------------------------

//racksSearch_OnValidate @16-C88EB1B3
function racksSearch_OnValidate(& $sender)
{
    $racksSearch_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $racksSearch; //Compatibility
//End racksSearch_OnValidate

//Custom Code @79-2A29BDB7
// -------------------------
    $texto = $racksSearch->s_num_serie->GetValue();
    $id = $racksSearch->s_num_serie->GetValue();
    $db = new clsDBminseg();
    if(is_numeric($texto)){
    	$existe = CCDLookUp("COUNT(*)","racks","rack_id=$texto OR num_serie=$texto",$db);
    	if(!$existe){
    		$racksSearch->Errors->addError("No existe el rack buscado");
    	}
    	
    	if($existe > 1){
    		//$racksSearch->Errors->addError("Existe más de un rack para la carga. Elegir de la lista el rack correspondiente.");
    	}else{
    		// Funciona
    	}/**/
    } else{
    	$racksSearch->Errors->addError("Por favor ingrese caracteres numéricos.");
    }
// -------------------------
//End Custom Code

//Close racksSearch_OnValidate @16-9A580DD9
    return $racksSearch_OnValidate;
}
//End Close racksSearch_OnValidate

//Panel2_BeforeShow @20-96696C3D
function Panel2_BeforeShow(& $sender)
{
    $Panel2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel2; //Compatibility
//End Panel2_BeforeShow

//Close Panel2_BeforeShow @20-AE7F9FB3
    return $Panel2_BeforeShow;
}
//End Close Panel2_BeforeShow

//DEL  // -------------------------
//DEL  	// Visibilidad de agregar proveedores
//DEL      /*$s_rack_id = CCGetParam("s_rack_id");
//DEL  	$db = new clsDBminseg();
//DEL  	$existe = CCDLookUp("COUNT(*)","racks","rack_id = $s_rack_id",$db);
//DEL  	$db->close();*/
//DEL  	$proveedores->Visible = false;
//DEL  	/*if($existe == 1){
//DEL  		$proveedores->Visible = false;
//DEL  	}*/
//DEL  // -------------------------

//DEL  // -------------------------
//DEL      $s_rack_id = CCGetParam("s_rack_id");
//DEL  	$db = new clsDBminseg();
//DEL  	$existe = CCDLookUp("COUNT(*)","racks","rack_id = $s_rack_id",$db);
//DEL  	$db->close();
//DEL  	$proveedores_racks_proveed->Visible = false;
//DEL  	if($existe == 1){
//DEL  		$proveedores_racks_proveed->Visible = true;
//DEL  	}
//DEL  // -------------------------

//proveedores1_BeforeShow @213-6F946FC5
function proveedores1_BeforeShow(& $sender)
{
    $proveedores1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $proveedores1; //Compatibility
//End proveedores1_BeforeShow

//Custom Code @312-2A29BDB7
// -------------------------
    $s_rack_id = CCGetParam("s_rack_id");
	$db = new clsDBminseg();
	$existe = CCDLookUp("COUNT(*)","racks","rack_id = $s_rack_id",$db);
	$db->close();
	$proveedores1->Visible = false;
	//$proveedores2->Visible = false;
	if($existe == 1){
		$proveedores1->Visible = true;
		//$proveedores2->Visible = true;
	}
// -------------------------
//End Custom Code

//Close proveedores1_BeforeShow @213-74598C5C
    return $proveedores1_BeforeShow;
}
//End Close proveedores1_BeforeShow

//proveedores2_Button_Insert_OnClick @228-7400806C
function proveedores2_Button_Insert_OnClick(& $sender)
{
    $proveedores2_Button_Insert_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $proveedores2; //Compatibility
//End proveedores2_Button_Insert_OnClick

//Custom Code @324-2A29BDB7
// -------------------------	
	$RazonSocial = $_POST['razon_social_proveedor'];
	$Rack_id = $_POST['id_rack'];
	
	$db = new clsDBminseg();	
	$Proveedor_id = CCDLookUp("proveedor_id","proveedores","proveedor_razon_social = '$RazonSocial'",$db);			
	
	$query = "INSERT INTO proveedores_racks (proveedor_id, rack_id, fecha_agreg) VALUES ( $Proveedor_id, $Rack_id, NOW());";
	$db->query($query);
	$db->close();
// -------------------------
//End Custom Code

//Close proveedores2_Button_Insert_OnClick @228-056FA33B
    return $proveedores2_Button_Insert_OnClick;
}
//End Close proveedores2_Button_Insert_OnClick

//proveedores2_Borrar_OnClick @331-8A0F1C07
function proveedores2_Borrar_OnClick(& $sender)
{
    $proveedores2_Borrar_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $proveedores2; //Compatibility
//End proveedores2_Borrar_OnClick

//Custom Code @332-2A29BDB7
// -------------------------
	$RazonSocial = $_POST['razon_social_proveedor'];
	$Rack_id = $_POST['id_rack'];
	
	$db = new clsDBminseg();	
	$Proveedor_id = CCDLookUp("proveedor_id","proveedores","proveedor_razon_social = '$RazonSocial'",$db);			
	
	$query = "DELETE FROM proveedores_racks WHERE proveedor_id = $Proveedor_id";
	$db->query($query);
	$db->close();
// -------------------------
//End Custom Code

//Close proveedores2_Borrar_OnClick @331-1E80FC9A
    return $proveedores2_Borrar_OnClick;
}
//End Close proveedores2_Borrar_OnClick

//Panel6_BeforeShow @225-71049516
function Panel6_BeforeShow(& $sender)
{
    $Panel6_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel6; //Compatibility
//End Panel6_BeforeShow

//Close Panel6_BeforeShow @225-B7D310A8
    return $Panel6_BeforeShow;
}
//End Close Panel6_BeforeShow

//Proveedor_BeforeShow @150-045BBA70
function Proveedor_BeforeShow(& $sender)
{
    $Proveedor_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Proveedor; //Compatibility
//End Proveedor_BeforeShow

//Close Proveedor_BeforeShow @150-14E2BE9A
    return $Proveedor_BeforeShow;
}
//End Close Proveedor_BeforeShow

//racks1_BeforeShow @3-31D31CA3
function racks1_BeforeShow(& $sender)
{
    $racks1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $racks1; //Compatibility
//End racks1_BeforeShow

//Custom Code @180-2A29BDB7
	// Visibilidad de grilla al seleccionar y deseleccionar
    $s_rack_id = CCGetParam("s_rack_id");
	$db = new clsDBminseg();
	$existe = CCDLookUp("COUNT(*)","racks","rack_id = $s_rack_id",$db);
	$db->close();
	$racks1->Visible = true;
	if($existe == 1){
		$racks1->Visible = false;
	}
// -------------------------
//End Custom Code

//Close racks1_BeforeShow @3-A2F8C3E6
    return $racks1_BeforeShow;
}
//End Close racks1_BeforeShow

//racks2_Button_Insert_OnClick @23-A0F2FFEA
function racks2_Button_Insert_OnClick(& $sender)
{
    $racks2_Button_Insert_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $racks2; //Compatibility
//End racks2_Button_Insert_OnClick

//Custom Code @328-2A29BDB7
// -------------------------
    $Fecha_Creac = date('Y-m-d H:i:s');
   	$racks2->fecha_creac->SetValue($Fecha_Creac);
   	$racks2->fecha_modif->SetValue($Fecha_Creac);
// -------------------------
//End Custom Code

//Close racks2_Button_Insert_OnClick @23-E4573025
    return $racks2_Button_Insert_OnClick;
}
//End Close racks2_Button_Insert_OnClick

//racks2_Button_Update_OnClick @24-14AE1B8B
function racks2_Button_Update_OnClick(& $sender)
{
    $racks2_Button_Update_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $racks2; //Compatibility
//End racks2_Button_Update_OnClick

//Custom Code @330-2A29BDB7
// -------------------------
    $Fecha_Modif = date('Y-m-d H:i:s');
   	$racks2->fecha_modif->SetValue($Fecha_Modif);
// -------------------------
//End Custom Code

//Close racks2_Button_Update_OnClick @24-4FC01898
    return $racks2_Button_Update_OnClick;
}
//End Close racks2_Button_Update_OnClick

//Panel5_BeforeShow @152-4DB55659
function Panel5_BeforeShow(& $sender)
{
    $Panel5_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel5; //Compatibility
//End Panel5_BeforeShow

//Close Panel5_BeforeShow @152-CBB23573
    return $Panel5_BeforeShow;
}
//End Close Panel5_BeforeShow

//Panel3_BeforeShow @148-34D6D0C7
function Panel3_BeforeShow(& $sender)
{
    $Panel3_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel3; //Compatibility
//End Panel3_BeforeShow

//Close Panel3_BeforeShow @148-33707EC5
    return $Panel3_BeforeShow;
}
//End Close Panel3_BeforeShow

//Panel1_BeforeShow @2-AAD8AF72
function Panel1_BeforeShow(& $sender)
{
    $Panel1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel1; //Compatibility
//End Panel1_BeforeShow

//Panel1UpdatePanel1 Page BeforeShow @30-546243CA
    global $CCSFormFilter;
    if ($CCSFormFilter == "Panel1") {
        $Component->BlockPrefix = "";
        $Component->BlockSuffix = "";
    } else {
        $Component->BlockPrefix = "<div id=\"Panel1\">";
        $Component->BlockSuffix = "</div>";
    }
//End Panel1UpdatePanel1 Page BeforeShow

//Close Panel1_BeforeShow @2-D21EBA68
    return $Panel1_BeforeShow;
}
//End Close Panel1_BeforeShow

//Page_BeforeInitialize @1-6AC2C388
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $racks; //Compatibility
//End Page_BeforeInitialize

//Panel1UpdatePanel1 PageBeforeInitialize @30-B4F71FC5
    if (CCGetFromGet("FormFilter") == "Panel1" && CCGetFromGet("IsParamsEncoded") != "true") {
        global $TemplateEncoding, $CCSIsParamsEncoded;
        CCConvertDataArrays("UTF-8", $TemplateEncoding);
        $CCSIsParamsEncoded = true;
    }
//End Panel1UpdatePanel1 PageBeforeInitialize

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

//Page_AfterInitialize @1-9D78FEB6
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $racks; //Compatibility
//End Page_AfterInitialize

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeShow @1-C3D9BF6D
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $racks; //Compatibility
//End Page_BeforeShow

//Panel1UpdatePanel1 Page BeforeShow @30-9F5F0EA1
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

//Page_BeforeOutput @1-BC48E781
function Page_BeforeOutput(& $sender)
{
    $Page_BeforeOutput = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $racks; //Compatibility
//End Page_BeforeOutput

//Panel1UpdatePanel1 PageBeforeOutput @30-0DFF2749
    global $CCSFormFilter, $Tpl, $main_block;
    if ($CCSFormFilter == "Panel1") {
        $main_block = $_SERVER["REQUEST_URI"] . "|" . $Tpl->getvar("/Panel Panel1");
    }
//End Panel1UpdatePanel1 PageBeforeOutput

//Close Page_BeforeOutput @1-8964C188
    return $Page_BeforeOutput;
}
//End Close Page_BeforeOutput

//Page_BeforeUnload @1-B66D6407
function Page_BeforeUnload(& $sender)
{
    $Page_BeforeUnload = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $racks; //Compatibility
//End Page_BeforeUnload

//Panel1UpdatePanel1 PageBeforeUnload @30-483BFCB6
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
