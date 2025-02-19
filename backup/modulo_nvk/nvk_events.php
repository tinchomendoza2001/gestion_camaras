<?php
//BindEvents Method @1-AD5BED6A
function BindEvents()
{
    global $nvk2;
    global $Panel2;
    global $nvk1;
    global $Panel4;
    global $nvk3;
    global $Panel5;
    global $Panel6;
    global $Panel3;
    global $Panel1;
    global $CCSEvents;
    $nvk2->CCSEvents["AfterInsert"] = "nvk2_AfterInsert";
    $nvk2->CCSEvents["AfterUpdate"] = "nvk2_AfterUpdate";
    $Panel2->CCSEvents["BeforeShow"] = "Panel2_BeforeShow";
    $nvk1->CCSEvents["BeforeShow"] = "nvk1_BeforeShow";
    $Panel4->CCSEvents["BeforeShow"] = "Panel4_BeforeShow";
    $nvk3->CCSEvents["BeforeShow"] = "nvk3_BeforeShow";
    $Panel5->CCSEvents["BeforeShow"] = "Panel5_BeforeShow";
    $Panel6->CCSEvents["BeforeShow"] = "Panel6_BeforeShow";
    $Panel3->CCSEvents["BeforeShow"] = "Panel3_BeforeShow";
    $Panel1->CCSEvents["BeforeShow"] = "Panel1_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
    $CCSEvents["BeforeOutput"] = "Page_BeforeOutput";
    $CCSEvents["BeforeUnload"] = "Page_BeforeUnload";
}
//End BindEvents Method

//nvk2_AfterInsert @30-EA1A3843
function nvk2_AfterInsert(& $sender)
{
    $nvk2_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nvk2; //Compatibility
//End nvk2_AfterInsert

//Custom Code @150-2A29BDB7
// -------------------------
    $db = new clsDBminseg();
    $nvk_id = CCDLookUp("MAX(nvk_id)","nvk","",$db);
    if($nvk_id){
    	/*
    	$usuario_id = CCGetUserID();
    	if(!$usuario_id){
    		$usuario_id = 7;
    	}
    	*/
    	$usuario_id = 7;
    	$SQL = "UPDATE nvk SET usuario_creacion_id = $usuario_id,
							fecha_creacion = NOW(),
							usuario_modificacion_id = $usuario_id,
							fecha_modificacion = NOW()
							WHERE nvk_id = $nvk_id";
		$db->query($SQL);
    }
    $db->close();
// -------------------------
//End Custom Code

//Close nvk2_AfterInsert @30-73826D85
    return $nvk2_AfterInsert;
}
//End Close nvk2_AfterInsert

//nvk2_AfterUpdate @30-7497FE87
function nvk2_AfterUpdate(& $sender)
{
    $nvk2_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nvk2; //Compatibility
//End nvk2_AfterUpdate

//Custom Code @176-2A29BDB7
// -------------------------
    $db = new clsDBminseg();
    $nvk_id = CCGetParam('s_nvk_id');
    if($nvk_id){
    	/*
    	$usuario_id = CCGetUserID();
    	if(!$usuario_id){
    		$usuario_id = 7;
    	}
    	*/
    	$usuario_id = 7;
    	$SQL = "UPDATE nvk SET usuario_modificacion_id = $usuario_id,
							fecha_modificacion = NOW()
							WHERE nvk_id = $nvk_id";
		$db->query($SQL);
    }
    $db->close();
// -------------------------
//End Custom Code

//Close nvk2_AfterUpdate @30-BCABAC0A
    return $nvk2_AfterUpdate;
}
//End Close nvk2_AfterUpdate

//Panel2_BeforeShow @29-96696C3D
function Panel2_BeforeShow(& $sender)
{
    $Panel2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel2; //Compatibility
//End Panel2_BeforeShow

//Close Panel2_BeforeShow @29-AE7F9FB3
    return $Panel2_BeforeShow;
}
//End Close Panel2_BeforeShow

//nvk1_BeforeShow @3-8F68962B
function nvk1_BeforeShow(& $sender)
{
    $nvk1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nvk1; //Compatibility
//End nvk1_BeforeShow

//Custom Code @148-2A29BDB7
// -------------------------
    if(CCGetParam('s_nvk_id')){
    	$nvk1->Visible = FALSE;
    }
// -------------------------
//End Custom Code

//Close nvk1_BeforeShow @3-53984855
    return $nvk1_BeforeShow;
}
//End Close nvk1_BeforeShow

//Panel4_BeforeShow @98-EF0AEAA3
function Panel4_BeforeShow(& $sender)
{
    $Panel4_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel4; //Compatibility
//End Panel4_BeforeShow

//Close Panel4_BeforeShow @98-56BDD405
    return $Panel4_BeforeShow;
}
//End Close Panel4_BeforeShow

//nvk3_BeforeShow @104-F832FAF5
function nvk3_BeforeShow(& $sender)
{
    $nvk3_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nvk3; //Compatibility
//End nvk3_BeforeShow

//Custom Code @149-2A29BDB7
// -------------------------
    if(!CCGetParam('s_nvk_id')){
    	$nvk3->Visible = FALSE;
    }
// -------------------------
//End Custom Code

//Close nvk3_BeforeShow @104-B2F68CF8
    return $nvk3_BeforeShow;
}
//End Close nvk3_BeforeShow

//Panel5_BeforeShow @100-4DB55659
function Panel5_BeforeShow(& $sender)
{
    $Panel5_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel5; //Compatibility
//End Panel5_BeforeShow

//Close Panel5_BeforeShow @100-CBB23573
    return $Panel5_BeforeShow;
}
//End Close Panel5_BeforeShow

//Panel6_BeforeShow @102-71049516
function Panel6_BeforeShow(& $sender)
{
    $Panel6_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel6; //Compatibility
//End Panel6_BeforeShow

//Close Panel6_BeforeShow @102-B7D310A8
    return $Panel6_BeforeShow;
}
//End Close Panel6_BeforeShow

//Panel3_BeforeShow @96-34D6D0C7
function Panel3_BeforeShow(& $sender)
{
    $Panel3_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel3; //Compatibility
//End Panel3_BeforeShow

//Close Panel3_BeforeShow @96-33707EC5
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

//Panel1UpdatePanel1 Page BeforeShow @44-546243CA
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

//Page_BeforeInitialize @1-7ACB8C77
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nvk; //Compatibility
//End Page_BeforeInitialize

//Panel1UpdatePanel1 PageBeforeInitialize @44-B4F71FC5
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

//Page_AfterInitialize @1-1D83C2DF
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nvk; //Compatibility
//End Page_AfterInitialize

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeShow @1-CF5B0193
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nvk; //Compatibility
//End Page_BeforeShow

//Panel1UpdatePanel1 Page BeforeShow @44-9F5F0EA1
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

//Page_BeforeOutput @1-4E4028CC
function Page_BeforeOutput(& $sender)
{
    $Page_BeforeOutput = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nvk; //Compatibility
//End Page_BeforeOutput

//Panel1UpdatePanel1 PageBeforeOutput @44-0DFF2749
    global $CCSFormFilter, $Tpl, $main_block;
    if ($CCSFormFilter == "Panel1") {
        $main_block = $_SERVER["REQUEST_URI"] . "|" . $Tpl->getvar("/Panel Panel1");
    }
//End Panel1UpdatePanel1 PageBeforeOutput

//Close Page_BeforeOutput @1-8964C188
    return $Page_BeforeOutput;
}
//End Close Page_BeforeOutput

//Page_BeforeUnload @1-0C33067E
function Page_BeforeUnload(& $sender)
{
    $Page_BeforeUnload = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $nvk; //Compatibility
//End Page_BeforeUnload

//Panel1UpdatePanel1 PageBeforeUnload @44-483BFCB6
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
