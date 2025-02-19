<?php
//BindEvents Method @1-2EE61F24
function BindEvents()
{
    global $camera_users;
    global $CCSEvents;
    $camera_users->CCSEvents["BeforeShow"] = "camera_users_BeforeShow";
    $camera_users->CCSEvents["AfterUpdate"] = "camera_users_AfterUpdate";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//camera_users_BeforeShow @3-7C43AA35
function camera_users_BeforeShow(& $sender)
{
    $camera_users_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_users; //Compatibility
//End camera_users_BeforeShow

//Custom Code @22-2A29BDB7
// -------------------------
    $db = new clsDBminseg();
    $UserID = CCGetUserID();
    $camera_users->contrasenia->SetValue(CCDLookUp("password","camera_users","id=$UserID",$db));
    $db->close();
// -------------------------
//End Custom Code

//Close camera_users_BeforeShow @3-12BCEC23
    return $camera_users_BeforeShow;
}
//End Close camera_users_BeforeShow

//camera_users_AfterUpdate @3-5B78959E
function camera_users_AfterUpdate(& $sender)
{
    $camera_users_AfterUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $camera_users; //Compatibility
//End camera_users_AfterUpdate

//Custom Code @28-2A29BDB7
// -------------------------
    $db = new clsDBminseg();
    $UserID = CCGetUserID();
    $SQL="UPDATE camera_users SET modified = NOW() WHERE id = $UserID";
    $db->query($SQL);
    $db->close();
// -------------------------
//End Custom Code

//Close camera_users_AfterUpdate @3-14F136DE
    return $camera_users_AfterUpdate;
}
//End Close camera_users_AfterUpdate

//Page_BeforeInitialize @1-17243B8E
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $cuenta; //Compatibility
//End Page_BeforeInitialize

//Custom Code @29-2A29BDB7
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

//Page_AfterInitialize @1-D6B29C18
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $cuenta; //Compatibility
//End Page_AfterInitialize

//Custom Code @30-2A29BDB7
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


?>
