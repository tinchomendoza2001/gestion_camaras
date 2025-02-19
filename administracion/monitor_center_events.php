<?php
//BindEvents Method @1-B8A7353D
function BindEvents()
{
    global $camera_monitoring_center;
    global $camera_monitoring_center1;
    global $Panel2;
    global $Panel1;
    global $CCSEvents;
    $camera_monitoring_center->CCSEvents["BeforeShowRow"] = "camera_monitoring_center_BeforeShowRow";
    $camera_monitoring_center1->CCSEvents["BeforeShow"] = "camera_monitoring_center1_BeforeShow";
    $camera_monitoring_center1->CCSEvents["AfterInsert"] = "camera_monitoring_center1_AfterInsert";
    $camera_monitoring_center1->CCSEvents["AfterUpdate"] = "camera_monitoring_center1_AfterUpdate";
    $Panel2->CCSEvents["BeforeShow"] = "Panel2_BeforeShow";
    $Panel1->CCSEvents["BeforeShow"] = "Panel1_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
    $CCSEvents["BeforeOutput"] = "Page_BeforeOutput";
    $CCSEvents["BeforeUnload"] = "Page_BeforeUnload";
}
//End BindEvents Method

//camera_monitoring_center_BeforeShowRow @4-7DAAAF04
function camera_monitoring_center_BeforeShowRow(& $sender)
{
    $camera_monitoring_center_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_monitoring_center; //Compatibility
//End camera_monitoring_center_BeforeShowRow

//Custom Code @97-2A29BDB7
// -------------------------
	$db = new clsDBminseg();
	$monitor_center_id = $camera_monitoring_center->DataSource->f('id');
	$SQL = "SELECT camera_projects.camera_project_descrip AS camera_project_descrip
			FROM camera_monitoring_center_projects 
			LEFT JOIN camera_projects ON camera_monitoring_center_projects.camera_project_id = camera_projects.camera_project_id
			WHERE monitor_center_id = $monitor_center_id";
	$db->query($SQL);
	while($db->next_record()){
		$lista_proyectos[] = $db->f('camera_project_descrip');
	}
	$camera_monitoring_center->proyecto->SetValue(implode("<br>",$lista_proyectos));
	$SQL = "SELECT areas.areas_descript AS areas_descript
			FROM camera_monitoring_center_areas 
			LEFT JOIN areas ON camera_monitoring_center_areas.area_id = areas.area_id
			WHERE monitor_center_id = $monitor_center_id";
	$db->query($SQL);
	while($db->next_record()){
		$lista_areas[] = $db->f('areas_descript');
	}
	$stock = $camera_monitoring_center->DataSource->f('stock');
	if($stock == 1){
		$camera_monitoring_center->stock->SetValue("SI");
	}else{
		$camera_monitoring_center->stock->SetValue("NO");
	}
	$camera_monitoring_center->areas->SetValue(implode("<br>",$lista_areas));	
	$db->close();
// -------------------------
//End Custom Code

//Close camera_monitoring_center_BeforeShowRow @4-6DB78CD9
    return $camera_monitoring_center_BeforeShowRow;
}
//End Close camera_monitoring_center_BeforeShowRow

//camera_monitoring_center1_BeforeShow @17-06821D6E
function camera_monitoring_center1_BeforeShow(& $sender)
{
    $camera_monitoring_center1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_monitoring_center1; //Compatibility
//End camera_monitoring_center1_BeforeShow

//Custom Code @91-2A29BDB7
// -------------------------
   if(CCGetParam('id')){
   		$db = new clsDBminseg();
		$SQL = "SELECT * 
				FROM camera_monitoring_center_projects 
				WHERE monitor_center_id = " . CCGetParam(id);
		$db->query($SQL);
		while($db->next_record()){
			$a[] = $db->f('camera_project_id');
		}
		$Component->CheckBoxList1->Value = $a;
		$SQL = "SELECT * 
				FROM camera_monitoring_center_areas 
				WHERE monitor_center_id = " . CCGetParam(id);
		$db->query($SQL);
		while($db->next_record()){
			$b[] = $db->f('area_id');
		}
		$Component->CheckBoxList2->Value = $b;		
		$db->close();
    }
// -------------------------
//End Custom Code

//Close camera_monitoring_center1_BeforeShow @17-A93437C3
    return $camera_monitoring_center1_BeforeShow;
}
//End Close camera_monitoring_center1_BeforeShow

//camera_monitoring_center1_AfterInsert @17-B15C78F3
function camera_monitoring_center1_AfterInsert(& $sender)
{
    $camera_monitoring_center1_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_monitoring_center1; //Compatibility
//End camera_monitoring_center1_AfterInsert

//Custom Code @92-2A29BDB7
// -------------------------
	$db = new clsDBminseg();
    $id = mysql_insert_id();
    if(!$id){
    	$id = CCDLookUp("MAX(id)","camera_monitoring_center","",$db);
    }
	if(CCGetParam('CheckBoxList1') && $id){
		$s = CCGetParam('CheckBoxList1');
		while (list ($clave, $val) = each ($s)) {
	 	   $SQL = "INSERT INTO camera_monitoring_center_projects SET
						monitor_center_id = $id,
						camera_project_id = $val";	
		   $db->query($SQL);
		}
	}
	if(CCGetParam('CheckBoxList2') && $id){
		$t = CCGetParam('CheckBoxList2');
		while (list ($clave, $val) = each ($t)) {
	 	   $SQL = "INSERT INTO camera_monitoring_center_areas SET
						monitor_center_id = $id,
						area_id = $val";	
		   $db->query($SQL);
		}
	}
	if($camera_monitoring_center1->longitud->GetValue() < -10 && $camera_monitoring_center1->latitud->GetValue() < -10){
		global $appConfigJs;
		$spatialReferenceId = $appConfigJs['arcgis']['spatialReferenceId'];		
		$longitud = $camera_monitoring_center1->longitud->GetValue();
		$latitud = $camera_monitoring_center1->latitud->GetValue();
		$URL = $appConfigJs['arcgis']['services']."Geometry/GeometryServer/project?inSR=4326&outSR=$spatialReferenceId&geometries=%7B%0D%0A%22geometryType%22%3A%22esriGeometryPoint%22%2C%0D%0A%22geometries%22%3A%5B%7B%22x%22%3A$longitud%2C%22y%22%3A$latitud%7D%5D%0D%0A%7D&f=pjson";
		$json = file_get_contents($URL);
		$obj = json_decode($json);
		$x = $obj->geometries[0]->x;
		$y = $obj->geometries[0]->y;
		$SQL = "UPDATE camera_monitoring_center SET coord_x = $x, coord_y = $y WHERE id = $id";
		$db->query($SQL);
	}		
	$db->close();
// -------------------------
//End Custom Code

//Close camera_monitoring_center1_AfterInsert @17-7B699DF2
    return $camera_monitoring_center1_AfterInsert;
}
//End Close camera_monitoring_center1_AfterInsert

//camera_monitoring_center1_AfterUpdate @17-D7DBD1CE
function camera_monitoring_center1_AfterUpdate(& $sender)
{
    $camera_monitoring_center1_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_monitoring_center1; //Compatibility
//End camera_monitoring_center1_AfterUpdate

//Custom Code @94-2A29BDB7
// -------------------------
	$db = new clsDBminseg();
	if(CCGetParam('CheckBoxList1') && CCGetParam('id')){
		$id = CCGetParam('id');
		$s = CCGetParam('CheckBoxList1');
		$SQL = "DELETE FROM camera_monitoring_center_projects WHERE monitor_center_id = $id";
		$db->query($SQL);		
		while (list ($clave, $val) = each ($s)) {
	 	   $SQL = "INSERT INTO camera_monitoring_center_projects SET
						monitor_center_id = $id,
						camera_project_id = $val";	
		   $db->query($SQL);
		}
	}else{
		$SQL = "DELETE FROM camera_monitoring_center_projects WHERE monitor_center_id = $id";
		$db->query($SQL);
	}
	if(CCGetParam('CheckBoxList2') && CCGetParam('id')){
		$id = CCGetParam('id');
		$t = CCGetParam('CheckBoxList2');
		$SQL = "DELETE FROM camera_monitoring_center_areas WHERE monitor_center_id = $id";
		$db->query($SQL);		
		while (list ($clave, $val) = each ($t)) {
	 	   $SQL = "INSERT INTO camera_monitoring_center_areas SET
						monitor_center_id = $id,
						area_id = $val";	
		   $db->query($SQL);
		}
	}else{
		$SQL = "DELETE FROM camera_monitoring_center_areas WHERE monitor_center_id = $id";
		$db->query($SQL);
	}	
	if($camera_monitoring_center1->longitud->GetValue() < -10 && $camera_monitoring_center1->latitud->GetValue() < -10){
		global $appConfigJs;
		$spatialReferenceId = $appConfigJs['arcgis']['spatialReferenceId'];		
		$longitud = $camera_monitoring_center1->longitud->GetValue();
		$latitud = $camera_monitoring_center1->latitud->GetValue();
		$URL = $appConfigJs['arcgis']['services']."Geometry/GeometryServer/project?inSR=4326&outSR=$spatialReferenceId&geometries=%7B%0D%0A%22geometryType%22%3A%22esriGeometryPoint%22%2C%0D%0A%22geometries%22%3A%5B%7B%22x%22%3A$longitud%2C%22y%22%3A$latitud%7D%5D%0D%0A%7D&f=pjson";
		$json = file_get_contents($URL);
		$obj = json_decode($json);
		$x = $obj->geometries[0]->x;
		$y = $obj->geometries[0]->y;
		$SQL = "UPDATE camera_monitoring_center SET coord_x = $x, coord_y = $y WHERE id = ".CCGetParam('id');
		$db->query($SQL);
	}	
	$db->close();
// -------------------------
//End Custom Code

//Close camera_monitoring_center1_AfterUpdate @17-B4405C7D
    return $camera_monitoring_center1_AfterUpdate;
}
//End Close camera_monitoring_center1_AfterUpdate

//Panel2_BeforeShow @16-96696C3D
function Panel2_BeforeShow(& $sender)
{
    $Panel2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel2; //Compatibility
//End Panel2_BeforeShow

//Close Panel2_BeforeShow @16-AE7F9FB3
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

//Panel1UpdatePanel1 Page BeforeShow @25-546243CA
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

//Page_BeforeInitialize @1-44403C83
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $monitor_center; //Compatibility
//End Page_BeforeInitialize

//Custom Code @74-2A29BDB7
// -------------------------
	include_once(RelativePath . "/scripts/functions.php");

	// Incluye el archivo de configuraciones generales
    global $appConfig;
    global $appConfigJs;
	include_once(RelativePath . "/configuration.php");
// -------------------------
//End Custom Code

//Panel1UpdatePanel1 PageBeforeInitialize @25-37A82194
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

//Page_AfterInitialize @1-30E95820
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $monitor_center; //Compatibility
//End Page_AfterInitialize

//Custom Code @75-2A29BDB7
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

//Page_BeforeShow @1-94D4F4EA
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $monitor_center; //Compatibility
//End Page_BeforeShow

//Panel1UpdatePanel1 Page BeforeShow @25-9F5F0EA1
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

//Page_BeforeOutput @1-7DDEACFA
function Page_BeforeOutput(& $sender)
{
    $Page_BeforeOutput = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $monitor_center; //Compatibility
//End Page_BeforeOutput

//Panel1UpdatePanel1 PageBeforeOutput @25-0DFF2749
    global $CCSFormFilter, $Tpl, $main_block;
    if ($CCSFormFilter == "Panel1") {
        $main_block = $_SERVER["REQUEST_URI"] . "|" . $Tpl->getvar("/Panel Panel1");
    }
//End Panel1UpdatePanel1 PageBeforeOutput

//Close Page_BeforeOutput @1-8964C188
    return $Page_BeforeOutput;
}
//End Close Page_BeforeOutput

//Page_BeforeUnload @1-893B625B
function Page_BeforeUnload(& $sender)
{
    $Page_BeforeUnload = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $monitor_center; //Compatibility
//End Page_BeforeUnload

//Panel1UpdatePanel1 PageBeforeUnload @25-483BFCB6
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
