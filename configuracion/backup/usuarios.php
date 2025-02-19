<?php
//Include Common Files @1-C218FB3E
define("RelativePath", "..");
define("PathToCurrentPage", "/configuracion/");
define("FileName", "usuarios.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsGridcamera_users { //camera_users class @4-C3C45662

//Variables @4-6F95CDD9

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
    public $Sorter_realname;
    public $Sorter_username;
    public $Sorter_email;
    public $Sorter_group_id;
//End Variables

//Class_Initialize Event @4-BB18E2E3
    function clsGridcamera_users($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_users";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_users";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_usersDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 35;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("camera_usersOrder", "");
        $this->SorterDirection = CCGetParam("camera_usersDir", "");

        $this->realname = new clsControl(ccsLink, "realname", "realname", ccsText, "", CCGetRequestParam("realname", ccsGet, NULL), $this);
        $this->realname->Page = "edit_usuario.php";
        $this->username = new clsControl(ccsLabel, "username", "username", ccsText, "", CCGetRequestParam("username", ccsGet, NULL), $this);
        $this->email = new clsControl(ccsLabel, "email", "email", ccsText, "", CCGetRequestParam("email", ccsGet, NULL), $this);
        $this->group_id = new clsControl(ccsLabel, "group_id", "group_id", ccsText, "", CCGetRequestParam("group_id", ccsGet, NULL), $this);
        $this->activo = new clsControl(ccsLabel, "activo", "activo", ccsText, "", CCGetRequestParam("activo", ccsGet, NULL), $this);
        $this->ticket = new clsControl(ccsLabel, "ticket", "ticket", ccsText, "", CCGetRequestParam("ticket", ccsGet, NULL), $this);
        $this->perfil = new clsControl(ccsLabel, "perfil", "perfil", ccsText, "", CCGetRequestParam("perfil", ccsGet, NULL), $this);
        $this->perfil->HTML = true;
        $this->cm = new clsControl(ccsLabel, "cm", "cm", ccsText, "", CCGetRequestParam("cm", ccsGet, NULL), $this);
        $this->cm->HTML = true;
        $this->camera_menu_description = new clsControl(ccsLabel, "camera_menu_description", "camera_menu_description", ccsText, "", CCGetRequestParam("camera_menu_description", ccsGet, NULL), $this);
        $this->nota = new clsControl(ccsLabel, "nota", "nota", ccsText, "", CCGetRequestParam("nota", ccsGet, NULL), $this);
        $this->monitor_center_p_id = new clsControl(ccsListBox, "monitor_center_p_id", "monitor_center_p_id", ccsText, "", CCGetRequestParam("monitor_center_p_id", ccsGet, NULL), $this);
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
        $this->camera_users_id = new clsControl(ccsHidden, "camera_users_id", "camera_users_id", ccsText, "", CCGetRequestParam("camera_users_id", ccsGet, NULL), $this);
        $this->Sorter_realname = new clsSorter($this->ComponentName, "Sorter_realname", $FileName, $this);
        $this->Sorter_username = new clsSorter($this->ComponentName, "Sorter_username", $FileName, $this);
        $this->Sorter_email = new clsSorter($this->ComponentName, "Sorter_email", $FileName, $this);
        $this->Sorter_group_id = new clsSorter($this->ComponentName, "Sorter_group_id", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->camera_users_Insert = new clsControl(ccsLink, "camera_users_Insert", "camera_users_Insert", ccsText, "", CCGetRequestParam("camera_users_Insert", ccsGet, NULL), $this);
        $this->camera_users_Insert->Parameters = CCGetQueryString("QueryString", array("id", "ccsForm"));
        $this->camera_users_Insert->Page = "edit_usuario.php";
    }
//End Class_Initialize Event

//Initialize Method @4-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @4-C66BF227
    function Show()
    {
        $Tpl = CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_realname"] = CCGetFromGet("s_realname", NULL);
        $this->DataSource->Parameters["urls_username"] = CCGetFromGet("s_username", NULL);
        $this->DataSource->Parameters["urls_group_id"] = CCGetFromGet("s_group_id", NULL);
        $this->DataSource->Parameters["expr236"] = 1;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

        $this->monitor_center_p_id->Prepare();

        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["realname"] = $this->realname->Visible;
            $this->ControlsVisible["username"] = $this->username->Visible;
            $this->ControlsVisible["email"] = $this->email->Visible;
            $this->ControlsVisible["group_id"] = $this->group_id->Visible;
            $this->ControlsVisible["activo"] = $this->activo->Visible;
            $this->ControlsVisible["ticket"] = $this->ticket->Visible;
            $this->ControlsVisible["perfil"] = $this->perfil->Visible;
            $this->ControlsVisible["cm"] = $this->cm->Visible;
            $this->ControlsVisible["camera_menu_description"] = $this->camera_menu_description->Visible;
            $this->ControlsVisible["nota"] = $this->nota->Visible;
            $this->ControlsVisible["monitor_center_p_id"] = $this->monitor_center_p_id->Visible;
            $this->ControlsVisible["camera_users_id"] = $this->camera_users_id->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->realname->SetValue($this->DataSource->realname->GetValue());
                $this->realname->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->realname->Parameters = CCAddParam($this->realname->Parameters, "id", $this->DataSource->f("camera_users_id"));
                $this->username->SetValue($this->DataSource->username->GetValue());
                $this->email->SetValue($this->DataSource->email->GetValue());
                $this->group_id->SetValue($this->DataSource->group_id->GetValue());
                $this->activo->SetValue($this->DataSource->activo->GetValue());
                $this->camera_menu_description->SetValue($this->DataSource->camera_menu_description->GetValue());
                $this->monitor_center_p_id->SetValue($this->DataSource->monitor_center_p_id->GetValue());
                $this->camera_users_id->SetValue($this->DataSource->camera_users_id->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->realname->Show();
                $this->username->Show();
                $this->email->Show();
                $this->group_id->Show();
                $this->activo->Show();
                $this->ticket->Show();
                $this->perfil->Show();
                $this->cm->Show();
                $this->camera_menu_description->Show();
                $this->nota->Show();
                $this->monitor_center_p_id->Show();
                $this->camera_users_id->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if (($this->Navigator->TotalPages <= 1 && $this->Navigator->PageNumber == 1) || $this->Navigator->PageSize == "") {
            $this->Navigator->Visible = false;
        }
        $this->Sorter_realname->Show();
        $this->Sorter_username->Show();
        $this->Sorter_email->Show();
        $this->Sorter_group_id->Show();
        $this->Navigator->Show();
        $this->camera_users_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-474AFFDA
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->realname->Errors->ToString());
        $errors = ComposeStrings($errors, $this->username->Errors->ToString());
        $errors = ComposeStrings($errors, $this->email->Errors->ToString());
        $errors = ComposeStrings($errors, $this->group_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->activo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ticket->Errors->ToString());
        $errors = ComposeStrings($errors, $this->perfil->Errors->ToString());
        $errors = ComposeStrings($errors, $this->cm->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_menu_description->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nota->Errors->ToString());
        $errors = ComposeStrings($errors, $this->monitor_center_p_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_users_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_users Class @4-FCB6E20C

class clscamera_usersDataSource extends clsDBminseg {  //camera_usersDataSource Class @4-89C582E4

//DataSource Variables @4-B0E75D4D
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $realname;
    public $username;
    public $email;
    public $group_id;
    public $activo;
    public $camera_menu_description;
    public $monitor_center_p_id;
    public $camera_users_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-43CCFF62
    function clscamera_usersDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_users";
        $this->Initialize();
        $this->realname = new clsField("realname", ccsText, "");
        
        $this->username = new clsField("username", ccsText, "");
        
        $this->email = new clsField("email", ccsText, "");
        
        $this->group_id = new clsField("group_id", ccsText, "");
        
        $this->activo = new clsField("activo", ccsText, "");
        
        $this->camera_menu_description = new clsField("camera_menu_description", ccsText, "");
        
        $this->monitor_center_p_id = new clsField("monitor_center_p_id", ccsText, "");
        
        $this->camera_users_id = new clsField("camera_users_id", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-28B20038
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "realname";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_realname" => array("realname", ""), 
            "Sorter_username" => array("username", ""), 
            "Sorter_email" => array("email", ""), 
            "Sorter_group_id" => array("group_id", "")));
    }
//End SetOrder Method

//Prepare Method @4-23629D82
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_realname", ccsText, "", "", $this->Parameters["urls_realname"], "", false);
        $this->wp->AddParameter("2", "urls_username", ccsText, "", "", $this->Parameters["urls_username"], "", false);
        $this->wp->AddParameter("3", "urls_group_id", ccsInteger, "", "", $this->Parameters["urls_group_id"], "", false);
        $this->wp->AddParameter("4", "expr236", ccsInteger, "", "", $this->Parameters["expr236"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "camera_users.realname", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "camera_users.username", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "camera_users.group_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "visible", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]);
    }
//End Prepare Method

//Open Method @4-111238DC
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (camera_users LEFT JOIN camera_users_groups ON\n\n" .
        "camera_users.group_id = camera_users_groups.id) LEFT JOIN camera_menu ON\n\n" .
        "camera_users.page_init_menu = camera_menu.id";
        $this->SQL = "SELECT camera_users.id AS camera_users_id, realname, username, email, group_id, camera_users_groups.description AS camera_users_groups_description,\n\n" .
        "active, ticket, camera_menu.description AS camera_menu_description, nota, monitor_center_p_id \n\n" .
        "FROM (camera_users LEFT JOIN camera_users_groups ON\n\n" .
        "camera_users.group_id = camera_users_groups.id) LEFT JOIN camera_menu ON\n\n" .
        "camera_users.page_init_menu = camera_menu.id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-95B4615E
    function SetValues()
    {
        $this->realname->SetDBValue($this->f("realname"));
        $this->username->SetDBValue($this->f("username"));
        $this->email->SetDBValue($this->f("email"));
        $this->group_id->SetDBValue($this->f("camera_users_groups_description"));
        $this->activo->SetDBValue($this->f("active"));
        $this->camera_menu_description->SetDBValue($this->f("camera_menu_description"));
        $this->monitor_center_p_id->SetDBValue($this->f("monitor_center_p_id"));
        $this->camera_users_id->SetDBValue($this->f("camera_users_id"));
    }
//End SetValues Method

} //End camera_usersDataSource Class @4-FCB6E20C

class clsRecordcamera_usersSearch { //camera_usersSearch Class @25-97A92B1C

//Variables @25-9E315808

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

//Class_Initialize Event @25-2C2CE087
    function clsRecordcamera_usersSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_usersSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_usersSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_realname = new clsControl(ccsTextBox, "s_realname", $CCSLocales->GetText("realname"), ccsText, "", CCGetRequestParam("s_realname", $Method, NULL), $this);
            $this->s_username = new clsControl(ccsTextBox, "s_username", $CCSLocales->GetText("username"), ccsText, "", CCGetRequestParam("s_username", $Method, NULL), $this);
            $this->s_group_id = new clsControl(ccsListBox, "s_group_id", "Grupo", ccsInteger, "", CCGetRequestParam("s_group_id", $Method, NULL), $this);
            $this->s_group_id->DSType = dsTable;
            $this->s_group_id->DataSource = new clsDBminseg();
            $this->s_group_id->ds = & $this->s_group_id->DataSource;
            $this->s_group_id->DataSource->SQL = "SELECT * \n" .
"FROM camera_users_groups {SQL_Where} {SQL_OrderBy}";
            list($this->s_group_id->BoundColumn, $this->s_group_id->TextColumn, $this->s_group_id->DBFormat) = array("id", "description", "");
            $this->Button1 = new clsButton("Button1", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @25-A7AB226C
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_realname->Validate() && $Validation);
        $Validation = ($this->s_username->Validate() && $Validation);
        $Validation = ($this->s_group_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_realname->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_username->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_group_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @25-7A3B7B7D
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_realname->Errors->Count());
        $errors = ($errors || $this->s_username->Errors->Count());
        $errors = ($errors || $this->s_group_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @25-2FF37B46
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            }
        }
        $Redirect = "usuarios.php";
        if($this->PressedButton == "Button1") {
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "usuarios.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button1", "Button1_x", "Button1_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @25-C09F5DFF
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

        $this->s_group_id->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_realname->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_username->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_group_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_DoSearch->Show();
        $this->s_realname->Show();
        $this->s_username->Show();
        $this->s_group_id->Show();
        $this->Button1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End camera_usersSearch Class @25-FCB6E20C



//DEL      function clsRecordcamera_users1($RelativePath, & $Parent)
//DEL      {
//DEL  
//DEL          global $FileName;
//DEL          global $CCSLocales;
//DEL          global $DefaultDateFormat;
//DEL          $this->Visible = true;
//DEL          $this->Parent = & $Parent;
//DEL          $this->RelativePath = $RelativePath;
//DEL          $this->Errors = new clsErrors();
//DEL          $this->ErrorBlock = "Record camera_users1/Error";
//DEL          $this->DataSource = new clscamera_users1DataSource($this);
//DEL          $this->ds = & $this->DataSource;
//DEL          $this->InsertAllowed = true;
//DEL          $this->UpdateAllowed = true;
//DEL          $this->ReadAllowed = true;
//DEL          if($this->Visible)
//DEL          {
//DEL              $this->ComponentName = "camera_users1";
//DEL              $this->Attributes = new clsAttributes($this->ComponentName . ":");
//DEL              $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
//DEL              if(sizeof($CCSForm) == 1)
//DEL                  $CCSForm[1] = "";
//DEL              list($FormName, $FormMethod) = $CCSForm;
//DEL              $this->EditMode = ($FormMethod == "Edit");
//DEL              $this->FormEnctype = "application/x-www-form-urlencoded";
//DEL              $this->FormSubmitted = ($FormName == $this->ComponentName);
//DEL              $Method = $this->FormSubmitted ? ccsPost : ccsGet;
//DEL              $this->Button_Insert = new clsButton("Button_Insert", $Method, $this);
//DEL              $this->Button_Update = new clsButton("Button_Update", $Method, $this);
//DEL              $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
//DEL              $this->realname = new clsControl(ccsTextBox, "realname", "Nombres", ccsText, "", CCGetRequestParam("realname", $Method, NULL), $this);
//DEL              $this->realname->Required = true;
//DEL              $this->username = new clsControl(ccsTextBox, "username", "Usuario", ccsText, "", CCGetRequestParam("username", $Method, NULL), $this);
//DEL              $this->username->Required = true;
//DEL              $this->password = new clsControl(ccsHidden, "password", "ContraseÃƒÂ±a", ccsText, "", CCGetRequestParam("password", $Method, NULL), $this);
//DEL              $this->password->Required = true;
//DEL              $this->email = new clsControl(ccsTextBox, "email", "E-Mail", ccsText, "", CCGetRequestParam("email", $Method, NULL), $this);
//DEL              $this->group_id = new clsControl(ccsListBox, "group_id", "Grupo", ccsInteger, "", CCGetRequestParam("group_id", $Method, NULL), $this);
//DEL              $this->group_id->DSType = dsTable;
//DEL              $this->group_id->DataSource = new clsDBminseg();
//DEL              $this->group_id->ds = & $this->group_id->DataSource;
//DEL              $this->group_id->DataSource->SQL = "SELECT id, description \n" .
//DEL  "FROM camera_users_groups {SQL_Where} {SQL_OrderBy}";
//DEL              list($this->group_id->BoundColumn, $this->group_id->TextColumn, $this->group_id->DBFormat) = array("id", "description", "");
//DEL              $this->group_id->Required = true;
//DEL              $this->contrasenia = new clsControl(ccsTextBox, "contrasenia", "contrasenia", ccsText, "", CCGetRequestParam("contrasenia", $Method, NULL), $this);
//DEL          }
//DEL      }



//Initialize Page @1-DE104D7D
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
$TemplateFileName = "usuarios.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$PathToRootOpt = "../";
$Scripts = "|js/jquery/jquery.js|js/jquery/event-manager.js|js/jquery/selectors.js|js/jquery/updatepanel/ccs-update-panel.js|";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-7FABC906
CCSecurityRedirect("1", "../mylogin.php");
//End Authenticate User

//Include events file @1-4864330B
include_once("./usuarios_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-9840F432
$DBminseg = new clsDBminseg();
$MainPage->Connections["minseg"] = & $DBminseg;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$mymenu = new clsmymenu("../", "mymenu", $MainPage);
$mymenu->Initialize();
$Panel1 = new clsPanel("Panel1", $MainPage);
$Panel1->GenerateDiv = true;
$Panel1->PanelId = "Panel1";
$camera_users = new clsGridcamera_users("", $MainPage);
$camera_usersSearch = new clsRecordcamera_usersSearch("", $MainPage);
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$MainPage->mymenu = & $mymenu;
$MainPage->Panel1 = & $Panel1;
$MainPage->camera_users = & $camera_users;
$MainPage->camera_usersSearch = & $camera_usersSearch;
$MainPage->app_environment_class = & $app_environment_class;
$Panel1->AddComponent("camera_users", $camera_users);
$Panel1->AddComponent("camera_usersSearch", $camera_usersSearch);
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

//Execute Components @1-76EAFF2D
$camera_usersSearch->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-5FD01136
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_users);
    unset($camera_usersSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-03CB2781
$mymenu->Show();
$Panel1->Show();
$app_environment_class->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>&#71;e&#110;" . "&#101;rat&#101;&#100; <!-- SCC -->&#119;i&#116;" . "h <!-- CCS -->&#67;&#111;d&#101;&#67;&#104;arg&#" . "101; <!-- SCC -->&#83;t&#117;&#100;i&#111;.</sma" . "ll></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>&#71;e&#110;" . "&#101;rat&#101;&#100; <!-- SCC -->&#119;i&#116;" . "h <!-- CCS -->&#67;&#111;d&#101;&#67;&#104;arg&#" . "101; <!-- SCC -->&#83;t&#117;&#100;i&#111;.</sma" . "ll></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>&#71;e&#110;" . "&#101;rat&#101;&#100; <!-- SCC -->&#119;i&#116;" . "h <!-- CCS -->&#67;&#111;d&#101;&#67;&#104;arg&#" . "101; <!-- SCC -->&#83;t&#117;&#100;i&#111;.</sma" . "ll></font></center>";
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-FA8A4413
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_users);
unset($camera_usersSearch);
unset($Tpl);
//End Unload Page


?>
