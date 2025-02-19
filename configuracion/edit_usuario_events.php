<?php

//BindEvents Method @1-27BA4011
function BindEvents()
{
    global $camera_users;
    global $CCSEvents;
    $camera_users->CCSEvents["BeforeShow"] = "camera_users_BeforeShow";
    $camera_users->CCSEvents["AfterInsert"] = "camera_users_AfterInsert";
    $camera_users->CCSEvents["AfterUpdate"] = "camera_users_AfterUpdate";
    $camera_users->CCSEvents["OnValidate"] = "camera_users_OnValidate";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//camera_users_BeforeShow @6-7C43AA35
function camera_users_BeforeShow(& $sender)
{
    $camera_users_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_users; //Compatibility
//End camera_users_BeforeShow

//Custom Code @50-2A29BDB7
// -------------------------
    if(CCGetParam('id')){
    	$camera_user_id = CCGetParam('id');
    	$db = new clsDBminseg();
		$SQL = "SELECT * 
				FROM camera_users_profiles 
				WHERE camera_user_id = $camera_user_id";
		$db->query($SQL);
		while($db->next_record()){
			$a[] = $db->f('camera_profile_id');
		}
		if(count($a) > 0){
			$Component->CheckBoxList1->Value = $a;
		}
		$SQL = "SELECT * 
				FROM camera_cm_users 
				WHERE camera_user_id = $camera_user_id";
		$db->query($SQL);
		while($db->next_record()){
			$b[] = $db->f('camera_monitor_center_id');
		}
		if(count($b) > 0){
			$Component->CheckBoxList2->Value = $b;
		}		
		$db->close();
    }
// -------------------------
//End Custom Code

//Close camera_users_BeforeShow @6-12BCEC23
    return $camera_users_BeforeShow;
}
//End Close camera_users_BeforeShow

//camera_users_AfterInsert @6-2AE88578
function camera_users_AfterInsert(& $sender)
{
    $camera_users_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_users; //Compatibility
//End camera_users_AfterInsert

//Custom Code @53-2A29BDB7
// -------------------------
    $db = new clsDBminseg();
    $camera_user_id = mysql_insert_id();
    $es_grupo_proveedor = FALSE;
    $proveedor_id = CCDLookUp("camera_profile_id","camera_profiles","UPPER(camera_profile_descrip)='PROVEEDOR'",$db);
	if(CCGetParam('CheckBoxList1')){
		$s = CCGetParam('CheckBoxList1');
		while (list ($clave, $val) = each ($s)) {
			$SQL = "INSERT INTO camera_users_profiles SET
				camera_profile_id = $val,
				camera_user_id = $camera_user_id";
			$db->query($SQL);
			if($proveedor_id == $val){
				$es_grupo_proveedor = TRUE;
			}
		}
	}
	if(CCGetParam('CheckBoxList2')){
		$s = CCGetParam('CheckBoxList2');
		while (list ($clave, $val) = each ($s)) {
	 	   $SQL = "INSERT INTO camera_cm_users SET
						camera_monitor_center_id = $val,
						camera_user_id = $camera_user_id";
		   $db->query($SQL);
		}
	}
	$page_init_menu = "";
	if($es_grupo_proveedor){//si el usuario es un proveedor inicia con el listado de ticket y es operador
		$page_id = CCDLookUp("id","camera_menu","link='../gestion/tickets.php'",$db);
		$group_id = 2;
		$page_init_menu = ", page_init_menu = $page_id, group_id = $group_id";
	}
    $SQL="UPDATE camera_users SET created = NOW(), modified = NOW() $page_init_menu WHERE id = $camera_user_id";
    $db->query($SQL);
	$db->close();
// -------------------------
//End Custom Code

//Close camera_users_AfterInsert @6-DBD8F751
    return $camera_users_AfterInsert;
}
//End Close camera_users_AfterInsert

//camera_users_AfterUpdate @6-5B78959E
function camera_users_AfterUpdate(& $sender)
{
    $camera_users_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_users; //Compatibility
//End camera_users_AfterUpdate

//Custom Code @54-2A29BDB7
// -------------------------
    $db = new clsDBminseg();
    $camera_user_id = CCGetParam('id');
    $es_grupo_proveedor = FALSE;
    $proveedor_id = CCDLookUp("camera_profile_id","camera_profiles","UPPER(camera_profile_descrip)='PROVEEDOR'",$db);    
	if(CCGetParam('CheckBoxList1')){
		$s = CCGetParam('CheckBoxList1');
		$SQL = "DELETE FROM camera_users_profiles WHERE camera_user_id = $camera_user_id";
		$db->query($SQL);	
		while (list ($clave, $val) = each ($s)) {
	 	   $SQL = "INSERT INTO camera_users_profiles SET
						camera_profile_id = $val,
						camera_user_id = $camera_user_id";
		   $db->query($SQL);
			if($proveedor_id == $val){
				$es_grupo_proveedor = TRUE;
			}
		}
	}else{
		$SQL = "DELETE FROM camera_users_profiles WHERE camera_user_id = $camera_user_id";
		$db->query($SQL);
	}
	if(CCGetParam('CheckBoxList2')){
		$s = CCGetParam('CheckBoxList2');
		$SQL = "DELETE FROM camera_cm_users WHERE camera_user_id = $camera_user_id";
		$db->query($SQL);
		while (list ($clave, $val) = each ($s)) {
	 	   $SQL = "INSERT INTO camera_cm_users SET
						camera_monitor_center_id = $val,
						camera_user_id = $camera_user_id";
		   $db->query($SQL);
		}
	}else{
		$SQL = "DELETE FROM camera_cm_users WHERE camera_user_id = $camera_user_id";
		$db->query($SQL);
	}
	$page_init_menu = "";
	if($es_grupo_proveedor){//si el usuario es un proveedor inicia con el listado de ticket y es operador
		$page_id = CCDLookUp("id","camera_menu","link='../gestion/tickets.php'",$db);
		$group_id = 2;
		$page_init_menu = ", page_init_menu = $page_id, group_id = $group_id";
	}
    $SQL="UPDATE camera_users SET created = NOW(), modified = NOW() $page_init_menu WHERE id = $camera_user_id";
    $db->query($SQL);
    $db->close();
// -------------------------
//End Custom Code

//Close camera_users_AfterUpdate @6-14F136DE
    return $camera_users_AfterUpdate;
}
//End Close camera_users_AfterUpdate

//camera_users_OnValidate @6-CA0B4751
function camera_users_OnValidate(& $sender)
{
    $camera_users_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_users; //Compatibility
//End camera_users_OnValidate

//Custom Code @56-2A29BDB7
// -------------------------
	$db = new clsDBminseg();
	if(CCGetParam('CheckBoxList1')){
		$s = CCGetParam('CheckBoxList1');
		while (list ($clave, $val) = each ($s)){
			$proveedor = CCDLookUp("UPPER(camera_profile_descrip)","camera_profiles","camera_profile_id=$val",$db);
			if($proveedor == "PROVEEDOR" && !$camera_users->provider_connexion_id->GetValue()){
				$camera_users->Errors->addError("Debe seleccionar la Empresa si es perfil proveedor.");
			}
		}
	}
	if(trim($camera_users->email->GetValue()) != ''){
		$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
		$emailaddress = trim($camera_users->email->GetValue());
		if (preg_match($pattern, $emailaddress) === 1) {
	    // emailaddress is valid
		}else{
			$camera_users->Errors->addError("Formato del e-mail es invalido");
		}
	}
	
	$db->close();
// -------------------------
//End Custom Code

//Close camera_users_OnValidate @6-2D4788AA
    return $camera_users_OnValidate;
}
//End Close camera_users_OnValidate

//Page_BeforeInitialize @1-4F3D6B08
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $edit_usuario; //Compatibility
//End Page_BeforeInitialize

//Custom Code @3-2A29BDB7
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

//Page_AfterInitialize @1-4E439FDF
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $edit_usuario; //Compatibility
//End Page_AfterInitialize

//Custom Code @4-2A29BDB7
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
