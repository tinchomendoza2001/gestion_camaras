<?php
//Include Common Files @1-A58120AD
define("RelativePath", "..");
define("PathToCurrentPage", "/configuracion/");
define("FileName", "edit_usuario.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsRecordcamera_users { //camera_users Class @6-AE15262E

//Variables @6-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @6-DBD0E510
    function clsRecordcamera_users($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_users/Error";
        $this->DataSource = new clscamera_usersDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_users";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->realname = new clsControl(ccsTextBox, "realname", "DENOMINACION", ccsText, "", CCGetRequestParam("realname", $Method, NULL), $this);
            $this->realname->Required = true;
            $this->username_edit = new clsControl(ccsTextBox, "username_edit", "LOGIN", ccsText, "", CCGetRequestParam("username_edit", $Method, NULL), $this);
            $this->username_edit->Required = true;
            $this->contrasenia_pass = new clsControl(ccsTextBox, "contrasenia_pass", "PASSWORD", ccsText, "", CCGetRequestParam("contrasenia_pass", $Method, NULL), $this);
            $this->email = new clsControl(ccsTextBox, "email", "E-MAIL", ccsText, "", CCGetRequestParam("email", $Method, NULL), $this);
            $this->email->Required = true;
            $this->group_id = new clsControl(ccsListBox, "group_id", $CCSLocales->GetText("group_id"), ccsInteger, "", CCGetRequestParam("group_id", $Method, NULL), $this);
            $this->group_id->DSType = dsTable;
            $this->group_id->DataSource = new clsDBminseg();
            $this->group_id->ds = & $this->group_id->DataSource;
            $this->group_id->DataSource->SQL = "SELECT * \n" .
"FROM camera_users_groups {SQL_Where} {SQL_OrderBy}";
            list($this->group_id->BoundColumn, $this->group_id->TextColumn, $this->group_id->DBFormat) = array("id", "description", "");
            $this->active = new clsControl(ccsCheckBox, "active", "active", ccsInteger, "", CCGetRequestParam("active", $Method, NULL), $this);
            $this->active->CheckedValue = $this->active->GetParsedValue(1);
            $this->active->UncheckedValue = $this->active->GetParsedValue(0);
            $this->ticket = new clsControl(ccsCheckBox, "ticket", "ticket", ccsInteger, "", CCGetRequestParam("ticket", $Method, NULL), $this);
            $this->ticket->CheckedValue = $this->ticket->GetParsedValue(1);
            $this->ticket->UncheckedValue = $this->ticket->GetParsedValue(0);
            $this->nota = new clsControl(ccsCheckBox, "nota", "nota", ccsInteger, "", CCGetRequestParam("nota", $Method, NULL), $this);
            $this->nota->CheckedValue = $this->nota->GetParsedValue(1);
            $this->nota->UncheckedValue = $this->nota->GetParsedValue(0);
            $this->cartografia = new clsControl(ccsCheckBox, "cartografia", "cartografia", ccsInteger, "", CCGetRequestParam("cartografia", $Method, NULL), $this);
            $this->cartografia->CheckedValue = $this->cartografia->GetParsedValue(1);
            $this->cartografia->UncheckedValue = $this->cartografia->GetParsedValue(0);
            $this->ges_user = new clsControl(ccsCheckBox, "ges_user", "ges_user", ccsInteger, "", CCGetRequestParam("ges_user", $Method, NULL), $this);
            $this->ges_user->CheckedValue = $this->ges_user->GetParsedValue(1);
            $this->ges_user->UncheckedValue = $this->ges_user->GetParsedValue(0);
            $this->ticket_cerrado = new clsControl(ccsCheckBox, "ticket_cerrado", "ticket_cerrado", ccsInteger, "", CCGetRequestParam("ticket_cerrado", $Method, NULL), $this);
            $this->ticket_cerrado->CheckedValue = $this->ticket_cerrado->GetParsedValue(1);
            $this->ticket_cerrado->UncheckedValue = $this->ticket_cerrado->GetParsedValue(0);
            $this->novedad_s_ticket = new clsControl(ccsCheckBox, "novedad_s_ticket", "novedad_s_ticket", ccsInteger, "", CCGetRequestParam("novedad_s_ticket", $Method, NULL), $this);
            $this->novedad_s_ticket->CheckedValue = $this->novedad_s_ticket->GetParsedValue(1);
            $this->novedad_s_ticket->UncheckedValue = $this->novedad_s_ticket->GetParsedValue(0);
            $this->camara = new clsControl(ccsCheckBox, "camara", "camara", ccsInteger, "", CCGetRequestParam("camara", $Method, NULL), $this);
            $this->camara->CheckedValue = $this->camara->GetParsedValue(1);
            $this->camara->UncheckedValue = $this->camara->GetParsedValue(0);
            $this->provider_connexion_id = new clsControl(ccsListBox, "provider_connexion_id", "Empresa Proveedora", ccsInteger, "", CCGetRequestParam("provider_connexion_id", $Method, NULL), $this);
            $this->provider_connexion_id->DSType = dsTable;
            $this->provider_connexion_id->DataSource = new clsDBminseg();
            $this->provider_connexion_id->ds = & $this->provider_connexion_id->DataSource;
            $this->provider_connexion_id->DataSource->SQL = "SELECT * \n" .
"FROM camera_providers_connexions {SQL_Where} {SQL_OrderBy}";
            list($this->provider_connexion_id->BoundColumn, $this->provider_connexion_id->TextColumn, $this->provider_connexion_id->DBFormat) = array("id", "description", "");
            $this->monitor_center_p_id = new clsControl(ccsListBox, "monitor_center_p_id", $CCSLocales->GetText("monitor_center_p_id"), ccsInteger, "", CCGetRequestParam("monitor_center_p_id", $Method, NULL), $this);
            $this->monitor_center_p_id->DSType = dsTable;
            $this->monitor_center_p_id->DataSource = new clsDBminseg();
            $this->monitor_center_p_id->ds = & $this->monitor_center_p_id->DataSource;
            $this->monitor_center_p_id->DataSource->SQL = "SELECT * \n" .
"FROM camera_monitoring_center {SQL_Where} {SQL_OrderBy}";
            list($this->monitor_center_p_id->BoundColumn, $this->monitor_center_p_id->TextColumn, $this->monitor_center_p_id->DBFormat) = array("id", "long_descrip", "");
            $this->monitor_center_p_id->DataSource->wp = new clsSQLParameters();
            $this->monitor_center_p_id->DataSource->wp->Criterion[1] = "( NOT ISNULL(long_descrip) )";
            $this->monitor_center_p_id->DataSource->Where = 
                 $this->monitor_center_p_id->DataSource->wp->Criterion[1];
            $this->page_init_menu = new clsControl(ccsListBox, "page_init_menu", "PAGINA DE INICIO", ccsInteger, "", CCGetRequestParam("page_init_menu", $Method, NULL), $this);
            $this->page_init_menu->DSType = dsTable;
            $this->page_init_menu->DataSource = new clsDBminseg();
            $this->page_init_menu->ds = & $this->page_init_menu->DataSource;
            $this->page_init_menu->DataSource->SQL = "SELECT * \n" .
"FROM camera_menu {SQL_Where} {SQL_OrderBy}";
            list($this->page_init_menu->BoundColumn, $this->page_init_menu->TextColumn, $this->page_init_menu->DBFormat) = array("id", "description", "");
            $this->page_init_menu->DataSource->Parameters["expr41"] = 1;
            $this->page_init_menu->DataSource->wp = new clsSQLParameters();
            $this->page_init_menu->DataSource->wp->AddParameter("1", "expr41", ccsInteger, "", "", $this->page_init_menu->DataSource->Parameters["expr41"], "", false);
            $this->page_init_menu->DataSource->wp->Criterion[1] = $this->page_init_menu->DataSource->wp->Operation(opEqual, "usuario", $this->page_init_menu->DataSource->wp->GetDBValue("1"), $this->page_init_menu->DataSource->ToSQL($this->page_init_menu->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->page_init_menu->DataSource->Where = 
                 $this->page_init_menu->DataSource->wp->Criterion[1];
            $this->page_init_menu->Required = true;
            $this->CheckBoxList1 = new clsControl(ccsCheckBoxList, "CheckBoxList1", "CheckBoxList1", ccsText, "", CCGetRequestParam("CheckBoxList1", $Method, NULL), $this);
            $this->CheckBoxList1->Multiple = true;
            $this->CheckBoxList1->DSType = dsTable;
            $this->CheckBoxList1->DataSource = new clsDBminseg();
            $this->CheckBoxList1->ds = & $this->CheckBoxList1->DataSource;
            $this->CheckBoxList1->DataSource->SQL = "SELECT * \n" .
"FROM camera_profiles {SQL_Where} {SQL_OrderBy}";
            list($this->CheckBoxList1->BoundColumn, $this->CheckBoxList1->TextColumn, $this->CheckBoxList1->DBFormat) = array("camera_profile_id", "camera_profile_descrip", "");
            $this->CheckBoxList1->HTML = true;
            $this->CheckBoxList2 = new clsControl(ccsCheckBoxList, "CheckBoxList2", "CheckBoxList2", ccsText, "", CCGetRequestParam("CheckBoxList2", $Method, NULL), $this);
            $this->CheckBoxList2->Multiple = true;
            $this->CheckBoxList2->DSType = dsTable;
            $this->CheckBoxList2->DataSource = new clsDBminseg();
            $this->CheckBoxList2->ds = & $this->CheckBoxList2->DataSource;
            $this->CheckBoxList2->DataSource->SQL = "SELECT * \n" .
"FROM camera_monitoring_center {SQL_Where} {SQL_OrderBy}";
            $this->CheckBoxList2->DataSource->Order = "long_descrip";
            list($this->CheckBoxList2->BoundColumn, $this->CheckBoxList2->TextColumn, $this->CheckBoxList2->DBFormat) = array("id", "long_descrip", "");
            $this->CheckBoxList2->DataSource->wp = new clsSQLParameters();
            $this->CheckBoxList2->DataSource->wp->Criterion[1] = "( NOT ISNULL(long_descrip) )";
            $this->CheckBoxList2->DataSource->Where = 
                 $this->CheckBoxList2->DataSource->wp->Criterion[1];
            $this->CheckBoxList2->DataSource->Order = "long_descrip";
            $this->CheckBoxList2->HTML = true;
            $this->pass_word = new clsControl(ccsHidden, "pass_word", "PASSWORD", ccsText, "", CCGetRequestParam("pass_word", $Method, NULL), $this);
            $this->pass_word->Required = true;
            $this->visible = new clsControl(ccsHidden, "visible", "visible", ccsInteger, "", CCGetRequestParam("visible", $Method, NULL), $this);
            $this->CheckBox1 = new clsControl(ccsCheckBox, "CheckBox1", "CheckBox1", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox1", $Method, NULL), $this);
            $this->CheckBox1->CheckedValue = true;
            $this->CheckBox1->UncheckedValue = false;
            $this->CheckBox2 = new clsControl(ccsCheckBox, "CheckBox2", "CheckBox2", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox2", $Method, NULL), $this);
            $this->CheckBox2->CheckedValue = true;
            $this->CheckBox2->UncheckedValue = false;
            $this->CheckBox3 = new clsControl(ccsCheckBox, "CheckBox3", "CheckBox3", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox3", $Method, NULL), $this);
            $this->CheckBox3->CheckedValue = true;
            $this->CheckBox3->UncheckedValue = false;
            $this->CheckBox4 = new clsControl(ccsCheckBox, "CheckBox4", "CheckBox4", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox4", $Method, NULL), $this);
            $this->CheckBox4->CheckedValue = true;
            $this->CheckBox4->UncheckedValue = false;
            $this->CheckBox5 = new clsControl(ccsCheckBox, "CheckBox5", "CheckBox5", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox5", $Method, NULL), $this);
            $this->CheckBox5->CheckedValue = true;
            $this->CheckBox5->UncheckedValue = false;
            $this->CheckBox6 = new clsControl(ccsCheckBox, "CheckBox6", "CheckBox6", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox6", $Method, NULL), $this);
            $this->CheckBox6->CheckedValue = true;
            $this->CheckBox6->UncheckedValue = false;
            $this->CheckBox7 = new clsControl(ccsCheckBox, "CheckBox7", "CheckBox7", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox7", $Method, NULL), $this);
            $this->CheckBox7->CheckedValue = true;
            $this->CheckBox7->UncheckedValue = false;
            $this->ver_mapa = new clsControl(ccsCheckBox, "ver_mapa", "ver_mapa", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("ver_mapa", $Method, NULL), $this);
            $this->ver_mapa->CheckedValue = true;
            $this->ver_mapa->UncheckedValue = false;
            $this->cam_disponible = new clsControl(ccsCheckBox, "cam_disponible", "cam_disponible", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("cam_disponible", $Method, NULL), $this);
            $this->cam_disponible->CheckedValue = true;
            $this->cam_disponible->UncheckedValue = false;
            $this->excel_ticket = new clsControl(ccsListBox, "excel_ticket", "excel_ticket", ccsText, "", CCGetRequestParam("excel_ticket", $Method, NULL), $this);
            $this->excel_ticket->DSType = dsListOfValues;
            $this->excel_ticket->Values = array(array("0", "NO"), array("1", "SI"));
            $this->repor_x_depto = new clsControl(ccsListBox, "repor_x_depto", "repor_x_depto", ccsText, "", CCGetRequestParam("repor_x_depto", $Method, NULL), $this);
            $this->repor_x_depto->DSType = dsListOfValues;
            $this->repor_x_depto->Values = array(array("0", "NO"), array("1", "SI"));
            $this->es_centro_visual = new clsControl(ccsListBox, "es_centro_visual", "es_centro_visual", ccsText, "", CCGetRequestParam("es_centro_visual", $Method, NULL), $this);
            $this->es_centro_visual->DSType = dsListOfValues;
            $this->es_centro_visual->Values = array(array("0", "NO"), array("1", "SI"));
            if(!$this->FormSubmitted) {
                if(!is_array($this->active->Value) && !strlen($this->active->Value) && $this->active->Value !== false)
                    $this->active->SetValue(true);
                if(!is_array($this->ticket->Value) && !strlen($this->ticket->Value) && $this->ticket->Value !== false)
                    $this->ticket->SetValue(false);
                if(!is_array($this->nota->Value) && !strlen($this->nota->Value) && $this->nota->Value !== false)
                    $this->nota->SetValue(false);
                if(!is_array($this->cartografia->Value) && !strlen($this->cartografia->Value) && $this->cartografia->Value !== false)
                    $this->cartografia->SetValue(false);
                if(!is_array($this->ges_user->Value) && !strlen($this->ges_user->Value) && $this->ges_user->Value !== false)
                    $this->ges_user->SetValue(false);
                if(!is_array($this->ticket_cerrado->Value) && !strlen($this->ticket_cerrado->Value) && $this->ticket_cerrado->Value !== false)
                    $this->ticket_cerrado->SetValue(false);
                if(!is_array($this->novedad_s_ticket->Value) && !strlen($this->novedad_s_ticket->Value) && $this->novedad_s_ticket->Value !== false)
                    $this->novedad_s_ticket->SetValue(false);
                if(!is_array($this->camara->Value) && !strlen($this->camara->Value) && $this->camara->Value !== false)
                    $this->camara->SetValue(false);
                if(!is_array($this->visible->Value) && !strlen($this->visible->Value) && $this->visible->Value !== false)
                    $this->visible->SetText(1);
                if(!is_array($this->CheckBox1->Value) && !strlen($this->CheckBox1->Value) && $this->CheckBox1->Value !== false)
                    $this->CheckBox1->SetValue(false);
                if(!is_array($this->CheckBox2->Value) && !strlen($this->CheckBox2->Value) && $this->CheckBox2->Value !== false)
                    $this->CheckBox2->SetValue(false);
                if(!is_array($this->CheckBox3->Value) && !strlen($this->CheckBox3->Value) && $this->CheckBox3->Value !== false)
                    $this->CheckBox3->SetValue(true);
                if(!is_array($this->CheckBox4->Value) && !strlen($this->CheckBox4->Value) && $this->CheckBox4->Value !== false)
                    $this->CheckBox4->SetValue(false);
                if(!is_array($this->CheckBox5->Value) && !strlen($this->CheckBox5->Value) && $this->CheckBox5->Value !== false)
                    $this->CheckBox5->SetValue(false);
                if(!is_array($this->CheckBox6->Value) && !strlen($this->CheckBox6->Value) && $this->CheckBox6->Value !== false)
                    $this->CheckBox6->SetValue(false);
                if(!is_array($this->CheckBox7->Value) && !strlen($this->CheckBox7->Value) && $this->CheckBox7->Value !== false)
                    $this->CheckBox7->SetValue(false);
                if(!is_array($this->ver_mapa->Value) && !strlen($this->ver_mapa->Value) && $this->ver_mapa->Value !== false)
                    $this->ver_mapa->SetValue(true);
                if(!is_array($this->cam_disponible->Value) && !strlen($this->cam_disponible->Value) && $this->cam_disponible->Value !== false)
                    $this->cam_disponible->SetValue(false);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @6-2832F4DC
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid"] = CCGetFromGet("id", NULL);
    }
//End Initialize Method

//Validate Method @6-AAE0830C
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->username_edit->SetValue($this->username_edit->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_users", "username=" . $this->DataSource->ToSQL($this->DataSource->username_edit->GetDBValue(), $this->DataSource->username_edit->DataType) . $Where, $this->DataSource) > 0)
            $this->username_edit->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "LOGIN"));
        if(strlen($this->email->GetText()) && !preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $this->email->GetText())) {
            $this->email->Errors->addError($CCSLocales->GetText("CCS_MaskValidation", "E-MAIL"));
        }
        $Validation = ($this->realname->Validate() && $Validation);
        $Validation = ($this->username_edit->Validate() && $Validation);
        $Validation = ($this->contrasenia_pass->Validate() && $Validation);
        $Validation = ($this->email->Validate() && $Validation);
        $Validation = ($this->group_id->Validate() && $Validation);
        $Validation = ($this->active->Validate() && $Validation);
        $Validation = ($this->ticket->Validate() && $Validation);
        $Validation = ($this->nota->Validate() && $Validation);
        $Validation = ($this->cartografia->Validate() && $Validation);
        $Validation = ($this->ges_user->Validate() && $Validation);
        $Validation = ($this->ticket_cerrado->Validate() && $Validation);
        $Validation = ($this->novedad_s_ticket->Validate() && $Validation);
        $Validation = ($this->camara->Validate() && $Validation);
        $Validation = ($this->provider_connexion_id->Validate() && $Validation);
        $Validation = ($this->monitor_center_p_id->Validate() && $Validation);
        $Validation = ($this->page_init_menu->Validate() && $Validation);
        $Validation = ($this->CheckBoxList1->Validate() && $Validation);
        $Validation = ($this->CheckBoxList2->Validate() && $Validation);
        $Validation = ($this->pass_word->Validate() && $Validation);
        $Validation = ($this->visible->Validate() && $Validation);
        $Validation = ($this->CheckBox1->Validate() && $Validation);
        $Validation = ($this->CheckBox2->Validate() && $Validation);
        $Validation = ($this->CheckBox3->Validate() && $Validation);
        $Validation = ($this->CheckBox4->Validate() && $Validation);
        $Validation = ($this->CheckBox5->Validate() && $Validation);
        $Validation = ($this->CheckBox6->Validate() && $Validation);
        $Validation = ($this->CheckBox7->Validate() && $Validation);
        $Validation = ($this->ver_mapa->Validate() && $Validation);
        $Validation = ($this->cam_disponible->Validate() && $Validation);
        $Validation = ($this->excel_ticket->Validate() && $Validation);
        $Validation = ($this->repor_x_depto->Validate() && $Validation);
        $Validation = ($this->es_centro_visual->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->realname->Errors->Count() == 0);
        $Validation =  $Validation && ($this->username_edit->Errors->Count() == 0);
        $Validation =  $Validation && ($this->contrasenia_pass->Errors->Count() == 0);
        $Validation =  $Validation && ($this->email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->group_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->active->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ticket->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nota->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cartografia->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ges_user->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ticket_cerrado->Errors->Count() == 0);
        $Validation =  $Validation && ($this->novedad_s_ticket->Errors->Count() == 0);
        $Validation =  $Validation && ($this->camara->Errors->Count() == 0);
        $Validation =  $Validation && ($this->provider_connexion_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->monitor_center_p_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->page_init_menu->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBoxList1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBoxList2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->pass_word->Errors->Count() == 0);
        $Validation =  $Validation && ($this->visible->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBox1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBox2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBox3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBox4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBox5->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBox6->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBox7->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ver_mapa->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cam_disponible->Errors->Count() == 0);
        $Validation =  $Validation && ($this->excel_ticket->Errors->Count() == 0);
        $Validation =  $Validation && ($this->repor_x_depto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->es_centro_visual->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @6-B36F3004
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->realname->Errors->Count());
        $errors = ($errors || $this->username_edit->Errors->Count());
        $errors = ($errors || $this->contrasenia_pass->Errors->Count());
        $errors = ($errors || $this->email->Errors->Count());
        $errors = ($errors || $this->group_id->Errors->Count());
        $errors = ($errors || $this->active->Errors->Count());
        $errors = ($errors || $this->ticket->Errors->Count());
        $errors = ($errors || $this->nota->Errors->Count());
        $errors = ($errors || $this->cartografia->Errors->Count());
        $errors = ($errors || $this->ges_user->Errors->Count());
        $errors = ($errors || $this->ticket_cerrado->Errors->Count());
        $errors = ($errors || $this->novedad_s_ticket->Errors->Count());
        $errors = ($errors || $this->camara->Errors->Count());
        $errors = ($errors || $this->provider_connexion_id->Errors->Count());
        $errors = ($errors || $this->monitor_center_p_id->Errors->Count());
        $errors = ($errors || $this->page_init_menu->Errors->Count());
        $errors = ($errors || $this->CheckBoxList1->Errors->Count());
        $errors = ($errors || $this->CheckBoxList2->Errors->Count());
        $errors = ($errors || $this->pass_word->Errors->Count());
        $errors = ($errors || $this->visible->Errors->Count());
        $errors = ($errors || $this->CheckBox1->Errors->Count());
        $errors = ($errors || $this->CheckBox2->Errors->Count());
        $errors = ($errors || $this->CheckBox3->Errors->Count());
        $errors = ($errors || $this->CheckBox4->Errors->Count());
        $errors = ($errors || $this->CheckBox5->Errors->Count());
        $errors = ($errors || $this->CheckBox6->Errors->Count());
        $errors = ($errors || $this->CheckBox7->Errors->Count());
        $errors = ($errors || $this->ver_mapa->Errors->Count());
        $errors = ($errors || $this->cam_disponible->Errors->Count());
        $errors = ($errors || $this->excel_ticket->Errors->Count());
        $errors = ($errors || $this->repor_x_depto->Errors->Count());
        $errors = ($errors || $this->es_centro_visual->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @6-029C6A10
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Insert";
            if($this->Button_Insert->Pressed) {
                $this->PressedButton = "Button_Insert";
            } else if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = "usuarios.php" . "?" . CCGetQueryString("QueryString", array("ccsForm"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_Insert") {
                if(!CCGetEvent($this->Button_Insert->CCSEvents, "OnClick", $this->Button_Insert) || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Button_Update") {
                if(!CCGetEvent($this->Button_Update->CCSEvents, "OnClick", $this->Button_Update) || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//InsertRow Method @6-5C098DE4
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->realname->SetValue($this->realname->GetValue(true));
        $this->DataSource->username_edit->SetValue($this->username_edit->GetValue(true));
        $this->DataSource->contrasenia_pass->SetValue($this->contrasenia_pass->GetValue(true));
        $this->DataSource->email->SetValue($this->email->GetValue(true));
        $this->DataSource->group_id->SetValue($this->group_id->GetValue(true));
        $this->DataSource->active->SetValue($this->active->GetValue(true));
        $this->DataSource->ticket->SetValue($this->ticket->GetValue(true));
        $this->DataSource->nota->SetValue($this->nota->GetValue(true));
        $this->DataSource->cartografia->SetValue($this->cartografia->GetValue(true));
        $this->DataSource->ges_user->SetValue($this->ges_user->GetValue(true));
        $this->DataSource->ticket_cerrado->SetValue($this->ticket_cerrado->GetValue(true));
        $this->DataSource->novedad_s_ticket->SetValue($this->novedad_s_ticket->GetValue(true));
        $this->DataSource->camara->SetValue($this->camara->GetValue(true));
        $this->DataSource->provider_connexion_id->SetValue($this->provider_connexion_id->GetValue(true));
        $this->DataSource->monitor_center_p_id->SetValue($this->monitor_center_p_id->GetValue(true));
        $this->DataSource->page_init_menu->SetValue($this->page_init_menu->GetValue(true));
        $this->DataSource->CheckBoxList1->SetValue($this->CheckBoxList1->GetValue(true));
        $this->DataSource->CheckBoxList2->SetValue($this->CheckBoxList2->GetValue(true));
        $this->DataSource->pass_word->SetValue($this->pass_word->GetValue(true));
        $this->DataSource->visible->SetValue($this->visible->GetValue(true));
        $this->DataSource->CheckBox1->SetValue($this->CheckBox1->GetValue(true));
        $this->DataSource->CheckBox2->SetValue($this->CheckBox2->GetValue(true));
        $this->DataSource->CheckBox3->SetValue($this->CheckBox3->GetValue(true));
        $this->DataSource->CheckBox4->SetValue($this->CheckBox4->GetValue(true));
        $this->DataSource->CheckBox5->SetValue($this->CheckBox5->GetValue(true));
        $this->DataSource->CheckBox6->SetValue($this->CheckBox6->GetValue(true));
        $this->DataSource->CheckBox7->SetValue($this->CheckBox7->GetValue(true));
        $this->DataSource->ver_mapa->SetValue($this->ver_mapa->GetValue(true));
        $this->DataSource->cam_disponible->SetValue($this->cam_disponible->GetValue(true));
        $this->DataSource->excel_ticket->SetValue($this->excel_ticket->GetValue(true));
        $this->DataSource->repor_x_depto->SetValue($this->repor_x_depto->GetValue(true));
        $this->DataSource->es_centro_visual->SetValue($this->es_centro_visual->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @6-C48AAB4F
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->realname->SetValue($this->realname->GetValue(true));
        $this->DataSource->username_edit->SetValue($this->username_edit->GetValue(true));
        $this->DataSource->contrasenia_pass->SetValue($this->contrasenia_pass->GetValue(true));
        $this->DataSource->email->SetValue($this->email->GetValue(true));
        $this->DataSource->group_id->SetValue($this->group_id->GetValue(true));
        $this->DataSource->active->SetValue($this->active->GetValue(true));
        $this->DataSource->ticket->SetValue($this->ticket->GetValue(true));
        $this->DataSource->nota->SetValue($this->nota->GetValue(true));
        $this->DataSource->cartografia->SetValue($this->cartografia->GetValue(true));
        $this->DataSource->ges_user->SetValue($this->ges_user->GetValue(true));
        $this->DataSource->ticket_cerrado->SetValue($this->ticket_cerrado->GetValue(true));
        $this->DataSource->novedad_s_ticket->SetValue($this->novedad_s_ticket->GetValue(true));
        $this->DataSource->camara->SetValue($this->camara->GetValue(true));
        $this->DataSource->provider_connexion_id->SetValue($this->provider_connexion_id->GetValue(true));
        $this->DataSource->monitor_center_p_id->SetValue($this->monitor_center_p_id->GetValue(true));
        $this->DataSource->page_init_menu->SetValue($this->page_init_menu->GetValue(true));
        $this->DataSource->CheckBoxList1->SetValue($this->CheckBoxList1->GetValue(true));
        $this->DataSource->CheckBoxList2->SetValue($this->CheckBoxList2->GetValue(true));
        $this->DataSource->pass_word->SetValue($this->pass_word->GetValue(true));
        $this->DataSource->visible->SetValue($this->visible->GetValue(true));
        $this->DataSource->CheckBox1->SetValue($this->CheckBox1->GetValue(true));
        $this->DataSource->CheckBox2->SetValue($this->CheckBox2->GetValue(true));
        $this->DataSource->CheckBox3->SetValue($this->CheckBox3->GetValue(true));
        $this->DataSource->CheckBox4->SetValue($this->CheckBox4->GetValue(true));
        $this->DataSource->CheckBox5->SetValue($this->CheckBox5->GetValue(true));
        $this->DataSource->CheckBox6->SetValue($this->CheckBox6->GetValue(true));
        $this->DataSource->CheckBox7->SetValue($this->CheckBox7->GetValue(true));
        $this->DataSource->ver_mapa->SetValue($this->ver_mapa->GetValue(true));
        $this->DataSource->cam_disponible->SetValue($this->cam_disponible->GetValue(true));
        $this->DataSource->excel_ticket->SetValue($this->excel_ticket->GetValue(true));
        $this->DataSource->repor_x_depto->SetValue($this->repor_x_depto->GetValue(true));
        $this->DataSource->es_centro_visual->SetValue($this->es_centro_visual->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @6-9928EEB7
    function Show()
    {
        global $CCSUseAmp;
        $Tpl = CCGetTemplate($this);
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->group_id->Prepare();
        $this->provider_connexion_id->Prepare();
        $this->monitor_center_p_id->Prepare();
        $this->page_init_menu->Prepare();
        $this->CheckBoxList1->Prepare();
        $this->CheckBoxList2->Prepare();
        $this->excel_ticket->Prepare();
        $this->repor_x_depto->Prepare();
        $this->es_centro_visual->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                if(!$this->FormSubmitted){
                    $this->realname->SetValue($this->DataSource->realname->GetValue());
                    $this->username_edit->SetValue($this->DataSource->username_edit->GetValue());
                    $this->email->SetValue($this->DataSource->email->GetValue());
                    $this->group_id->SetValue($this->DataSource->group_id->GetValue());
                    $this->active->SetValue($this->DataSource->active->GetValue());
                    $this->ticket->SetValue($this->DataSource->ticket->GetValue());
                    $this->nota->SetValue($this->DataSource->nota->GetValue());
                    $this->cartografia->SetValue($this->DataSource->cartografia->GetValue());
                    $this->ges_user->SetValue($this->DataSource->ges_user->GetValue());
                    $this->ticket_cerrado->SetValue($this->DataSource->ticket_cerrado->GetValue());
                    $this->novedad_s_ticket->SetValue($this->DataSource->novedad_s_ticket->GetValue());
                    $this->camara->SetValue($this->DataSource->camara->GetValue());
                    $this->provider_connexion_id->SetValue($this->DataSource->provider_connexion_id->GetValue());
                    $this->monitor_center_p_id->SetValue($this->DataSource->monitor_center_p_id->GetValue());
                    $this->page_init_menu->SetValue($this->DataSource->page_init_menu->GetValue());
                    $this->pass_word->SetValue($this->DataSource->pass_word->GetValue());
                    $this->visible->SetValue($this->DataSource->visible->GetValue());
                    $this->CheckBox3->SetValue($this->DataSource->CheckBox3->GetValue());
                    $this->CheckBox4->SetValue($this->DataSource->CheckBox4->GetValue());
                    $this->CheckBox5->SetValue($this->DataSource->CheckBox5->GetValue());
                    $this->CheckBox6->SetValue($this->DataSource->CheckBox6->GetValue());
                    $this->CheckBox7->SetValue($this->DataSource->CheckBox7->GetValue());
                    $this->ver_mapa->SetValue($this->DataSource->ver_mapa->GetValue());
                    $this->cam_disponible->SetValue($this->DataSource->cam_disponible->GetValue());
                    $this->excel_ticket->SetValue($this->DataSource->excel_ticket->GetValue());
                    $this->repor_x_depto->SetValue($this->DataSource->repor_x_depto->GetValue());
                    $this->es_centro_visual->SetValue($this->DataSource->es_centro_visual->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->realname->Errors->ToString());
            $Error = ComposeStrings($Error, $this->username_edit->Errors->ToString());
            $Error = ComposeStrings($Error, $this->contrasenia_pass->Errors->ToString());
            $Error = ComposeStrings($Error, $this->email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->group_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->active->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ticket->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nota->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cartografia->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ges_user->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ticket_cerrado->Errors->ToString());
            $Error = ComposeStrings($Error, $this->novedad_s_ticket->Errors->ToString());
            $Error = ComposeStrings($Error, $this->camara->Errors->ToString());
            $Error = ComposeStrings($Error, $this->provider_connexion_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->monitor_center_p_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->page_init_menu->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBoxList1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBoxList2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->pass_word->Errors->ToString());
            $Error = ComposeStrings($Error, $this->visible->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBox2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBox3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBox4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBox5->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBox6->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBox7->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ver_mapa->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cam_disponible->Errors->ToString());
            $Error = ComposeStrings($Error, $this->excel_ticket->Errors->ToString());
            $Error = ComposeStrings($Error, $this->repor_x_depto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->es_centro_visual->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);
        $this->Button_Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->realname->Show();
        $this->username_edit->Show();
        $this->contrasenia_pass->Show();
        $this->email->Show();
        $this->group_id->Show();
        $this->active->Show();
        $this->ticket->Show();
        $this->nota->Show();
        $this->cartografia->Show();
        $this->ges_user->Show();
        $this->ticket_cerrado->Show();
        $this->novedad_s_ticket->Show();
        $this->camara->Show();
        $this->provider_connexion_id->Show();
        $this->monitor_center_p_id->Show();
        $this->page_init_menu->Show();
        $this->CheckBoxList1->Show();
        $this->CheckBoxList2->Show();
        $this->pass_word->Show();
        $this->visible->Show();
        $this->CheckBox1->Show();
        $this->CheckBox2->Show();
        $this->CheckBox3->Show();
        $this->CheckBox4->Show();
        $this->CheckBox5->Show();
        $this->CheckBox6->Show();
        $this->CheckBox7->Show();
        $this->ver_mapa->Show();
        $this->cam_disponible->Show();
        $this->excel_ticket->Show();
        $this->repor_x_depto->Show();
        $this->es_centro_visual->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End camera_users Class @6-FCB6E20C

class clscamera_usersDataSource extends clsDBminseg {  //camera_usersDataSource Class @6-89C582E4

//DataSource Variables @6-6E82FC5C
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $realname;
    public $username_edit;
    public $contrasenia_pass;
    public $email;
    public $group_id;
    public $active;
    public $ticket;
    public $nota;
    public $cartografia;
    public $ges_user;
    public $ticket_cerrado;
    public $novedad_s_ticket;
    public $camara;
    public $provider_connexion_id;
    public $monitor_center_p_id;
    public $page_init_menu;
    public $CheckBoxList1;
    public $CheckBoxList2;
    public $pass_word;
    public $visible;
    public $CheckBox1;
    public $CheckBox2;
    public $CheckBox3;
    public $CheckBox4;
    public $CheckBox5;
    public $CheckBox6;
    public $CheckBox7;
    public $ver_mapa;
    public $cam_disponible;
    public $excel_ticket;
    public $repor_x_depto;
    public $es_centro_visual;
//End DataSource Variables

//DataSourceClass_Initialize Event @6-67C2FC03
    function clscamera_usersDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record camera_users/Error";
        $this->Initialize();
        $this->realname = new clsField("realname", ccsText, "");
        
        $this->username_edit = new clsField("username_edit", ccsText, "");
        
        $this->contrasenia_pass = new clsField("contrasenia_pass", ccsText, "");
        
        $this->email = new clsField("email", ccsText, "");
        
        $this->group_id = new clsField("group_id", ccsInteger, "");
        
        $this->active = new clsField("active", ccsInteger, "");
        
        $this->ticket = new clsField("ticket", ccsInteger, "");
        
        $this->nota = new clsField("nota", ccsInteger, "");
        
        $this->cartografia = new clsField("cartografia", ccsInteger, "");
        
        $this->ges_user = new clsField("ges_user", ccsInteger, "");
        
        $this->ticket_cerrado = new clsField("ticket_cerrado", ccsInteger, "");
        
        $this->novedad_s_ticket = new clsField("novedad_s_ticket", ccsInteger, "");
        
        $this->camara = new clsField("camara", ccsInteger, "");
        
        $this->provider_connexion_id = new clsField("provider_connexion_id", ccsInteger, "");
        
        $this->monitor_center_p_id = new clsField("monitor_center_p_id", ccsInteger, "");
        
        $this->page_init_menu = new clsField("page_init_menu", ccsInteger, "");
        
        $this->CheckBoxList1 = new clsField("CheckBoxList1", ccsText, "");
        
        $this->CheckBoxList2 = new clsField("CheckBoxList2", ccsText, "");
        
        $this->pass_word = new clsField("pass_word", ccsText, "");
        
        $this->visible = new clsField("visible", ccsInteger, "");
        
        $this->CheckBox1 = new clsField("CheckBox1", ccsBoolean, $this->BooleanFormat);
        
        $this->CheckBox2 = new clsField("CheckBox2", ccsBoolean, $this->BooleanFormat);
        
        $this->CheckBox3 = new clsField("CheckBox3", ccsBoolean, $this->BooleanFormat);
        
        $this->CheckBox4 = new clsField("CheckBox4", ccsBoolean, $this->BooleanFormat);
        
        $this->CheckBox5 = new clsField("CheckBox5", ccsBoolean, $this->BooleanFormat);
        
        $this->CheckBox6 = new clsField("CheckBox6", ccsBoolean, $this->BooleanFormat);
        
        $this->CheckBox7 = new clsField("CheckBox7", ccsBoolean, $this->BooleanFormat);
        
        $this->ver_mapa = new clsField("ver_mapa", ccsBoolean, $this->BooleanFormat);
        
        $this->cam_disponible = new clsField("cam_disponible", ccsBoolean, $this->BooleanFormat);
        
        $this->excel_ticket = new clsField("excel_ticket", ccsText, "");
        
        $this->repor_x_depto = new clsField("repor_x_depto", ccsText, "");
        
        $this->es_centro_visual = new clsField("es_centro_visual", ccsText, "");
        

        $this->InsertFields["realname"] = array("Name" => "realname", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["username"] = array("Name" => "username", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["email"] = array("Name" => "email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["group_id"] = array("Name" => "group_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["active"] = array("Name" => "active", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["ticket"] = array("Name" => "ticket", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["nota"] = array("Name" => "nota", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["cartografia"] = array("Name" => "cartografia", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["ges_user"] = array("Name" => "ges_user", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["ticket_cerrado"] = array("Name" => "ticket_cerrado", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["novedad_s_ticket"] = array("Name" => "novedad_s_ticket", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["camara"] = array("Name" => "camara", "Value" => "", "DataType" => ccsInteger);
        $this->InsertFields["provider_connexion_id"] = array("Name" => "provider_connexion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["monitor_center_p_id"] = array("Name" => "monitor_center_p_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["page_init_menu"] = array("Name" => "page_init_menu", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["password"] = array("Name" => "password", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["visible"] = array("Name" => "visible", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["stock_in"] = array("Name" => "stock_in", "Value" => "", "DataType" => ccsBoolean);
        $this->InsertFields["stock_out"] = array("Name" => "stock_out", "Value" => "", "DataType" => ccsBoolean);
        $this->InsertFields["stock_stk"] = array("Name" => "stock_stk", "Value" => "", "DataType" => ccsBoolean);
        $this->InsertFields["stock_elemt"] = array("Name" => "stock_elemt", "Value" => "", "DataType" => ccsBoolean);
        $this->InsertFields["stock_oc"] = array("Name" => "stock_oc", "Value" => "", "DataType" => ccsBoolean);
        $this->InsertFields["ver_mapa"] = array("Name" => "ver_mapa", "Value" => "", "DataType" => ccsBoolean);
        $this->InsertFields["cam_disponible"] = array("Name" => "cam_disponible", "Value" => "", "DataType" => ccsBoolean);
        $this->InsertFields["excel_ticket"] = array("Name" => "excel_ticket", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["estadistica_por_depto"] = array("Name" => "estadistica_por_depto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["es_centro_visual"] = array("Name" => "es_centro_visual", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["realname"] = array("Name" => "realname", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["username"] = array("Name" => "username", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["email"] = array("Name" => "email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["group_id"] = array("Name" => "group_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["active"] = array("Name" => "active", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["ticket"] = array("Name" => "ticket", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["nota"] = array("Name" => "nota", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["cartografia"] = array("Name" => "cartografia", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["ges_user"] = array("Name" => "ges_user", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["ticket_cerrado"] = array("Name" => "ticket_cerrado", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["novedad_s_ticket"] = array("Name" => "novedad_s_ticket", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["camara"] = array("Name" => "camara", "Value" => "", "DataType" => ccsInteger);
        $this->UpdateFields["provider_connexion_id"] = array("Name" => "provider_connexion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["monitor_center_p_id"] = array("Name" => "monitor_center_p_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["page_init_menu"] = array("Name" => "page_init_menu", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["password"] = array("Name" => "password", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["visible"] = array("Name" => "visible", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["stock_in"] = array("Name" => "stock_in", "Value" => "", "DataType" => ccsBoolean);
        $this->UpdateFields["stock_out"] = array("Name" => "stock_out", "Value" => "", "DataType" => ccsBoolean);
        $this->UpdateFields["stock_stk"] = array("Name" => "stock_stk", "Value" => "", "DataType" => ccsBoolean);
        $this->UpdateFields["stock_elemt"] = array("Name" => "stock_elemt", "Value" => "", "DataType" => ccsBoolean);
        $this->UpdateFields["stock_oc"] = array("Name" => "stock_oc", "Value" => "", "DataType" => ccsBoolean);
        $this->UpdateFields["ver_mapa"] = array("Name" => "ver_mapa", "Value" => "", "DataType" => ccsBoolean);
        $this->UpdateFields["cam_disponible"] = array("Name" => "cam_disponible", "Value" => "", "DataType" => ccsBoolean);
        $this->UpdateFields["excel_ticket"] = array("Name" => "excel_ticket", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["estadistica_por_depto"] = array("Name" => "estadistica_por_depto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["es_centro_visual"] = array("Name" => "es_centro_visual", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @6-35B33087
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlid", ccsInteger, "", "", $this->Parameters["urlid"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @6-B341C67C
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_users {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @6-4E0A85D2
    function SetValues()
    {
        $this->realname->SetDBValue($this->f("realname"));
        $this->username_edit->SetDBValue($this->f("username"));
        $this->email->SetDBValue($this->f("email"));
        $this->group_id->SetDBValue(trim($this->f("group_id")));
        $this->active->SetDBValue(trim($this->f("active")));
        $this->ticket->SetDBValue(trim($this->f("ticket")));
        $this->nota->SetDBValue(trim($this->f("nota")));
        $this->cartografia->SetDBValue(trim($this->f("cartografia")));
        $this->ges_user->SetDBValue(trim($this->f("ges_user")));
        $this->ticket_cerrado->SetDBValue(trim($this->f("ticket_cerrado")));
        $this->novedad_s_ticket->SetDBValue(trim($this->f("novedad_s_ticket")));
        $this->camara->SetDBValue(trim($this->f("camara")));
        $this->provider_connexion_id->SetDBValue(trim($this->f("provider_connexion_id")));
        $this->monitor_center_p_id->SetDBValue(trim($this->f("monitor_center_p_id")));
        $this->page_init_menu->SetDBValue(trim($this->f("page_init_menu")));
        $this->pass_word->SetDBValue($this->f("password"));
        $this->visible->SetDBValue(trim($this->f("visible")));
        $this->CheckBox3->SetDBValue(trim($this->f("stock_in")));
        $this->CheckBox4->SetDBValue(trim($this->f("stock_out")));
        $this->CheckBox5->SetDBValue(trim($this->f("stock_stk")));
        $this->CheckBox6->SetDBValue(trim($this->f("stock_elemt")));
        $this->CheckBox7->SetDBValue(trim($this->f("stock_oc")));
        $this->ver_mapa->SetDBValue(trim($this->f("ver_mapa")));
        $this->cam_disponible->SetDBValue(trim($this->f("cam_disponible")));
        $this->excel_ticket->SetDBValue($this->f("excel_ticket"));
        $this->repor_x_depto->SetDBValue($this->f("estadistica_por_depto"));
        $this->es_centro_visual->SetDBValue($this->f("es_centro_visual"));
    }
//End SetValues Method

//Insert Method @6-B1113DFA
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["realname"]["Value"] = $this->realname->GetDBValue(true);
        $this->InsertFields["username"]["Value"] = $this->username_edit->GetDBValue(true);
        $this->InsertFields["email"]["Value"] = $this->email->GetDBValue(true);
        $this->InsertFields["group_id"]["Value"] = $this->group_id->GetDBValue(true);
        $this->InsertFields["active"]["Value"] = $this->active->GetDBValue(true);
        $this->InsertFields["ticket"]["Value"] = $this->ticket->GetDBValue(true);
        $this->InsertFields["nota"]["Value"] = $this->nota->GetDBValue(true);
        $this->InsertFields["cartografia"]["Value"] = $this->cartografia->GetDBValue(true);
        $this->InsertFields["ges_user"]["Value"] = $this->ges_user->GetDBValue(true);
        $this->InsertFields["ticket_cerrado"]["Value"] = $this->ticket_cerrado->GetDBValue(true);
        $this->InsertFields["novedad_s_ticket"]["Value"] = $this->novedad_s_ticket->GetDBValue(true);
        $this->InsertFields["camara"]["Value"] = $this->camara->GetDBValue(true);
        $this->InsertFields["provider_connexion_id"]["Value"] = $this->provider_connexion_id->GetDBValue(true);
        $this->InsertFields["monitor_center_p_id"]["Value"] = $this->monitor_center_p_id->GetDBValue(true);
        $this->InsertFields["page_init_menu"]["Value"] = $this->page_init_menu->GetDBValue(true);
        $this->InsertFields["password"]["Value"] = $this->pass_word->GetDBValue(true);
        $this->InsertFields["visible"]["Value"] = $this->visible->GetDBValue(true);
        $this->InsertFields["stock_in"]["Value"] = $this->CheckBox3->GetDBValue(true);
        $this->InsertFields["stock_out"]["Value"] = $this->CheckBox4->GetDBValue(true);
        $this->InsertFields["stock_stk"]["Value"] = $this->CheckBox5->GetDBValue(true);
        $this->InsertFields["stock_elemt"]["Value"] = $this->CheckBox6->GetDBValue(true);
        $this->InsertFields["stock_oc"]["Value"] = $this->CheckBox7->GetDBValue(true);
        $this->InsertFields["ver_mapa"]["Value"] = $this->ver_mapa->GetDBValue(true);
        $this->InsertFields["cam_disponible"]["Value"] = $this->cam_disponible->GetDBValue(true);
        $this->InsertFields["excel_ticket"]["Value"] = $this->excel_ticket->GetDBValue(true);
        $this->InsertFields["estadistica_por_depto"]["Value"] = $this->repor_x_depto->GetDBValue(true);
        $this->InsertFields["es_centro_visual"]["Value"] = $this->es_centro_visual->GetDBValue(true);
        $this->SQL = CCBuildInsert("camera_users", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @6-011F21FA
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["realname"]["Value"] = $this->realname->GetDBValue(true);
        $this->UpdateFields["username"]["Value"] = $this->username_edit->GetDBValue(true);
        $this->UpdateFields["email"]["Value"] = $this->email->GetDBValue(true);
        $this->UpdateFields["group_id"]["Value"] = $this->group_id->GetDBValue(true);
        $this->UpdateFields["active"]["Value"] = $this->active->GetDBValue(true);
        $this->UpdateFields["ticket"]["Value"] = $this->ticket->GetDBValue(true);
        $this->UpdateFields["nota"]["Value"] = $this->nota->GetDBValue(true);
        $this->UpdateFields["cartografia"]["Value"] = $this->cartografia->GetDBValue(true);
        $this->UpdateFields["ges_user"]["Value"] = $this->ges_user->GetDBValue(true);
        $this->UpdateFields["ticket_cerrado"]["Value"] = $this->ticket_cerrado->GetDBValue(true);
        $this->UpdateFields["novedad_s_ticket"]["Value"] = $this->novedad_s_ticket->GetDBValue(true);
        $this->UpdateFields["camara"]["Value"] = $this->camara->GetDBValue(true);
        $this->UpdateFields["provider_connexion_id"]["Value"] = $this->provider_connexion_id->GetDBValue(true);
        $this->UpdateFields["monitor_center_p_id"]["Value"] = $this->monitor_center_p_id->GetDBValue(true);
        $this->UpdateFields["page_init_menu"]["Value"] = $this->page_init_menu->GetDBValue(true);
        $this->UpdateFields["password"]["Value"] = $this->pass_word->GetDBValue(true);
        $this->UpdateFields["visible"]["Value"] = $this->visible->GetDBValue(true);
        $this->UpdateFields["stock_in"]["Value"] = $this->CheckBox3->GetDBValue(true);
        $this->UpdateFields["stock_out"]["Value"] = $this->CheckBox4->GetDBValue(true);
        $this->UpdateFields["stock_stk"]["Value"] = $this->CheckBox5->GetDBValue(true);
        $this->UpdateFields["stock_elemt"]["Value"] = $this->CheckBox6->GetDBValue(true);
        $this->UpdateFields["stock_oc"]["Value"] = $this->CheckBox7->GetDBValue(true);
        $this->UpdateFields["ver_mapa"]["Value"] = $this->ver_mapa->GetDBValue(true);
        $this->UpdateFields["cam_disponible"]["Value"] = $this->cam_disponible->GetDBValue(true);
        $this->UpdateFields["excel_ticket"]["Value"] = $this->excel_ticket->GetDBValue(true);
        $this->UpdateFields["estadistica_por_depto"]["Value"] = $this->repor_x_depto->GetDBValue(true);
        $this->UpdateFields["es_centro_visual"]["Value"] = $this->es_centro_visual->GetDBValue(true);
        $this->SQL = CCBuildUpdate("camera_users", $this->UpdateFields, $this);
        $this->SQL .= strlen($this->Where) ? " WHERE " . $this->Where : $this->Where;
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End camera_usersDataSource Class @6-FCB6E20C

//Initialize Page @1-00D7C070
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";
$TemplateSource = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "edit_usuario.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$PathToRootOpt = "../";
$Scripts = "|js/jquery/jquery.js|js/jquery/event-manager.js|js/jquery/selectors.js|";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-7FABC906
CCSecurityRedirect("1", "../mylogin.php");
//End Authenticate User

//Include events file @1-C83EF410
include_once("./edit_usuario_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-A32023DA
$DBminseg = new clsDBminseg();
$MainPage->Connections["minseg"] = & $DBminseg;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$mymenu = new clsmymenu("../", "mymenu", $MainPage);
$mymenu->Initialize();
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$camera_users = new clsRecordcamera_users("", $MainPage);
$MainPage->mymenu = & $mymenu;
$MainPage->app_environment_class = & $app_environment_class;
$MainPage->camera_users = & $camera_users;
$camera_users->Initialize();
$ScriptIncludes = "";
$SList = explode("|", $Scripts);
foreach ($SList as $Script) {
    if ($Script != "") $ScriptIncludes = $ScriptIncludes . "<script src=\"" . $PathToRoot . $Script . "\" type=\"text/javascript\"></script>\n";
}
$Attributes->SetValue("scriptIncludes", $ScriptIncludes);

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-7B7D0F52
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
if (strlen($TemplateSource)) {
    $Tpl->LoadTemplateFromStr($TemplateSource, $BlockToParse, "UTF-8", "replace");
} else {
    $Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "UTF-8", "replace");
}
$Tpl->SetVar("CCS_PathToRoot", $PathToRoot);
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "../");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-5896CA9D
$camera_users->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-40B298DB
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_users);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-327555C2
$mymenu->Show();
$camera_users->Show();
$app_environment_class->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$RRPL5E9Q2P9N7K = "<center><font face=\"Arial\"><small>Gene&#114;ate&#100; <!-- CCS -->w&#105;t&#104; <!-- CCS -->C&#111;&#100;e&#67;h&#97;&#114;g&#101; <!-- CCS -->Studio.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", $RRPL5E9Q2P9N7K . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", $RRPL5E9Q2P9N7K . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= $RRPL5E9Q2P9N7K;
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-9BC43A47
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_users);
unset($Tpl);
//End Unload Page


?>
