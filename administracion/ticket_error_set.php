<?php
//Include Common Files @1-CFB2D2C0
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "ticket_error_set.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsGridcamera_tickets_error { //camera_tickets_error class @4-3BF75F70

//Variables @4-99946C28

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
    public $Sorter_camera_tickets_error_descrip;
    public $Sorter_camera_state_type_id;
//End Variables

//Class_Initialize Event @4-A36D564E
    function clsGridcamera_tickets_error($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_tickets_error";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_tickets_error";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_tickets_errorDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 50;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("camera_tickets_errorOrder", "");
        $this->SorterDirection = CCGetParam("camera_tickets_errorDir", "");

        $this->camera_tickets_error_id = new clsControl(ccsImageLink, "camera_tickets_error_id", "camera_tickets_error_id", ccsInteger, "", CCGetRequestParam("camera_tickets_error_id", ccsGet, NULL), $this);
        $this->camera_tickets_error_id->Page = "";
        $this->camera_tickets_error_descrip = new clsControl(ccsLabel, "camera_tickets_error_descrip", "camera_tickets_error_descrip", ccsText, "", CCGetRequestParam("camera_tickets_error_descrip", ccsGet, NULL), $this);
        $this->camera_state_type_id = new clsControl(ccsLabel, "camera_state_type_id", "camera_state_type_id", ccsText, "", CCGetRequestParam("camera_state_type_id", ccsGet, NULL), $this);
        $this->multiple = new clsControl(ccsLabel, "multiple", "multiple", ccsText, "", CCGetRequestParam("multiple", ccsGet, NULL), $this);
        $this->active = new clsControl(ccsLabel, "active", "active", ccsText, "", CCGetRequestParam("active", ccsGet, NULL), $this);
        $this->Sorter_camera_tickets_error_descrip = new clsSorter($this->ComponentName, "Sorter_camera_tickets_error_descrip", $FileName, $this);
        $this->Sorter_camera_state_type_id = new clsSorter($this->ComponentName, "Sorter_camera_state_type_id", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->camera_tickets_error_Insert = new clsControl(ccsLink, "camera_tickets_error_Insert", "camera_tickets_error_Insert", ccsText, "", CCGetRequestParam("camera_tickets_error_Insert", ccsGet, NULL), $this);
        $this->camera_tickets_error_Insert->Parameters = CCGetQueryString("QueryString", array("camera_tickets_error_id", "ccsForm"));
        $this->camera_tickets_error_Insert->Page = "ticket_error_set.php";
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

//Show Method @4-8FB028C1
    function Show()
    {
        $Tpl = CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;


        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


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
            $this->ControlsVisible["camera_tickets_error_id"] = $this->camera_tickets_error_id->Visible;
            $this->ControlsVisible["camera_tickets_error_descrip"] = $this->camera_tickets_error_descrip->Visible;
            $this->ControlsVisible["camera_state_type_id"] = $this->camera_state_type_id->Visible;
            $this->ControlsVisible["multiple"] = $this->multiple->Visible;
            $this->ControlsVisible["active"] = $this->active->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->camera_tickets_error_id->SetValue($this->DataSource->camera_tickets_error_id->GetValue());
                $this->camera_tickets_error_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->camera_tickets_error_id->Parameters = CCAddParam($this->camera_tickets_error_id->Parameters, "camera_tickets_error_id", $this->DataSource->f("camera_tickets_error_id"));
                $this->camera_tickets_error_descrip->SetValue($this->DataSource->camera_tickets_error_descrip->GetValue());
                $this->camera_state_type_id->SetValue($this->DataSource->camera_state_type_id->GetValue());
                $this->multiple->SetValue($this->DataSource->multiple->GetValue());
                $this->active->SetValue($this->DataSource->active->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->camera_tickets_error_id->Show();
                $this->camera_tickets_error_descrip->Show();
                $this->camera_state_type_id->Show();
                $this->multiple->Show();
                $this->active->Show();
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
        $this->Sorter_camera_tickets_error_descrip->Show();
        $this->Sorter_camera_state_type_id->Show();
        $this->Navigator->Show();
        $this->camera_tickets_error_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-AE9AEE03
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->camera_tickets_error_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_tickets_error_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_state_type_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->multiple->Errors->ToString());
        $errors = ComposeStrings($errors, $this->active->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_tickets_error Class @4-FCB6E20C

class clscamera_tickets_errorDataSource extends clsDBminseg {  //camera_tickets_errorDataSource Class @4-5FAAEA5B

//DataSource Variables @4-76986974
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $camera_tickets_error_id;
    public $camera_tickets_error_descrip;
    public $camera_state_type_id;
    public $multiple;
    public $active;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-6937A368
    function clscamera_tickets_errorDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_tickets_error";
        $this->Initialize();
        $this->camera_tickets_error_id = new clsField("camera_tickets_error_id", ccsInteger, "");
        
        $this->camera_tickets_error_descrip = new clsField("camera_tickets_error_descrip", ccsText, "");
        
        $this->camera_state_type_id = new clsField("camera_state_type_id", ccsText, "");
        
        $this->multiple = new clsField("multiple", ccsText, "");
        
        $this->active = new clsField("active", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-C274C38F
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_camera_tickets_error_descrip" => array("camera_tickets_error_descrip", ""), 
            "Sorter_camera_state_type_id" => array("camera_state_type_id", "")));
    }
//End SetOrder Method

//Prepare Method @4-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @4-5291A5E6
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM camera_tickets_error LEFT JOIN camera_states_types ON\n\n" .
        "camera_tickets_error.camera_state_type_id = camera_states_types.id";
        $this->SQL = "SELECT camera_tickets_error_id, camera_tickets_error_descrip, camera_state_type_id, description, multiple, active \n\n" .
        "FROM camera_tickets_error LEFT JOIN camera_states_types ON\n\n" .
        "camera_tickets_error.camera_state_type_id = camera_states_types.id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-AC380D81
    function SetValues()
    {
        $this->camera_tickets_error_id->SetDBValue(trim($this->f("camera_tickets_error_id")));
        $this->camera_tickets_error_descrip->SetDBValue($this->f("camera_tickets_error_descrip"));
        $this->camera_state_type_id->SetDBValue($this->f("description"));
        $this->multiple->SetDBValue($this->f("multiple"));
        $this->active->SetDBValue($this->f("active"));
    }
//End SetValues Method

} //End camera_tickets_errorDataSource Class @4-FCB6E20C

class clsRecordcamera_tickets_error1 { //camera_tickets_error1 Class @19-62551323

//Variables @19-9E315808

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

//Class_Initialize Event @19-AA55E6F1
    function clsRecordcamera_tickets_error1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_tickets_error1/Error";
        $this->DataSource = new clscamera_tickets_error1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_tickets_error1";
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
            $this->camera_tickets_error_descrip = new clsControl(ccsTextBox, "camera_tickets_error_descrip", $CCSLocales->GetText("camera_tickets_error_descrip"), ccsText, "", CCGetRequestParam("camera_tickets_error_descrip", $Method, NULL), $this);
            $this->camera_tickets_error_descrip->Required = true;
            $this->camera_state_type_id = new clsControl(ccsListBox, "camera_state_type_id", $CCSLocales->GetText("camera_state_type_id"), ccsInteger, "", CCGetRequestParam("camera_state_type_id", $Method, NULL), $this);
            $this->camera_state_type_id->DSType = dsTable;
            $this->camera_state_type_id->DataSource = new clsDBminseg();
            $this->camera_state_type_id->ds = & $this->camera_state_type_id->DataSource;
            $this->camera_state_type_id->DataSource->SQL = "SELECT * \n" .
"FROM camera_states_types {SQL_Where} {SQL_OrderBy}";
            list($this->camera_state_type_id->BoundColumn, $this->camera_state_type_id->TextColumn, $this->camera_state_type_id->DBFormat) = array("id", "description", "");
            $this->camera_state_type_id->DataSource->Parameters["expr91"] = 1;
            $this->camera_state_type_id->DataSource->wp = new clsSQLParameters();
            $this->camera_state_type_id->DataSource->wp->AddParameter("1", "expr91", ccsInteger, "", "", $this->camera_state_type_id->DataSource->Parameters["expr91"], "", false);
            $this->camera_state_type_id->DataSource->wp->Criterion[1] = $this->camera_state_type_id->DataSource->wp->Operation(opEqual, "ticket", $this->camera_state_type_id->DataSource->wp->GetDBValue("1"), $this->camera_state_type_id->DataSource->ToSQL($this->camera_state_type_id->DataSource->wp->GetDBValue("1"), ccsInteger),false);
            $this->camera_state_type_id->DataSource->Where = 
                 $this->camera_state_type_id->DataSource->wp->Criterion[1];
            $this->camera_state_type_id->Required = true;
            $this->multiple = new clsControl(ccsListBox, "multiple", "multiple", ccsText, "", CCGetRequestParam("multiple", $Method, NULL), $this);
            $this->multiple->Multiple = true;
            $this->multiple->DSType = dsListOfValues;
            $this->multiple->Values = array(array("0", "NO"), array("1", "SI"));
            $this->active = new clsControl(ccsListBox, "active", "active", ccsText, "", CCGetRequestParam("active", $Method, NULL), $this);
            $this->active->DSType = dsListOfValues;
            $this->active->Values = array(array("1", "SI"), array("2", "NO"));
            if(!$this->FormSubmitted) {
                if(!is_array($this->multiple->Value) && !strlen($this->multiple->Value) && $this->multiple->Value !== false)
                    $this->multiple->SetText(0);
                if(!is_array($this->active->Value) && !strlen($this->active->Value) && $this->active->Value !== false)
                    $this->active->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @19-18622516
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlcamera_tickets_error_id"] = CCGetFromGet("camera_tickets_error_id", NULL);
    }
//End Initialize Method

//Validate Method @19-AAF6C019
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->camera_tickets_error_descrip->SetValue($this->camera_tickets_error_descrip->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_tickets_error", "camera_tickets_error_descrip=" . $this->DataSource->ToSQL($this->DataSource->camera_tickets_error_descrip->GetDBValue(), $this->DataSource->camera_tickets_error_descrip->DataType) . $Where, $this->DataSource) > 0)
            $this->camera_tickets_error_descrip->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", $CCSLocales->GetText("camera_tickets_error_descrip")));
        $Validation = ($this->camera_tickets_error_descrip->Validate() && $Validation);
        $Validation = ($this->camera_state_type_id->Validate() && $Validation);
        $Validation = ($this->multiple->Validate() && $Validation);
        $Validation = ($this->active->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->camera_tickets_error_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->camera_state_type_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->multiple->Errors->Count() == 0);
        $Validation =  $Validation && ($this->active->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @19-523E25EE
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->camera_tickets_error_descrip->Errors->Count());
        $errors = ($errors || $this->camera_state_type_id->Errors->Count());
        $errors = ($errors || $this->multiple->Errors->Count());
        $errors = ($errors || $this->active->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @19-0BF2B389
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

//InsertRow Method @19-1FDA726A
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->camera_tickets_error_descrip->SetValue($this->camera_tickets_error_descrip->GetValue(true));
        $this->DataSource->camera_state_type_id->SetValue($this->camera_state_type_id->GetValue(true));
        $this->DataSource->multiple->SetValue($this->multiple->GetValue(true));
        $this->DataSource->active->SetValue($this->active->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @19-F796C43F
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->camera_tickets_error_descrip->SetValue($this->camera_tickets_error_descrip->GetValue(true));
        $this->DataSource->camera_state_type_id->SetValue($this->camera_state_type_id->GetValue(true));
        $this->DataSource->multiple->SetValue($this->multiple->GetValue(true));
        $this->DataSource->active->SetValue($this->active->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @19-546DC69E
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

        $this->camera_state_type_id->Prepare();
        $this->multiple->Prepare();
        $this->active->Prepare();

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
                    $this->camera_tickets_error_descrip->SetValue($this->DataSource->camera_tickets_error_descrip->GetValue());
                    $this->camera_state_type_id->SetValue($this->DataSource->camera_state_type_id->GetValue());
                    $this->multiple->SetValue($this->DataSource->multiple->GetValue());
                    $this->active->SetValue($this->DataSource->active->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->camera_tickets_error_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->camera_state_type_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->multiple->Errors->ToString());
            $Error = ComposeStrings($Error, $this->active->Errors->ToString());
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
        $this->camera_tickets_error_descrip->Show();
        $this->camera_state_type_id->Show();
        $this->multiple->Show();
        $this->active->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End camera_tickets_error1 Class @19-FCB6E20C

class clscamera_tickets_error1DataSource extends clsDBminseg {  //camera_tickets_error1DataSource Class @19-12E52FDA

//DataSource Variables @19-42ECB493
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
    public $camera_tickets_error_descrip;
    public $camera_state_type_id;
    public $multiple;
    public $active;
//End DataSource Variables

//DataSourceClass_Initialize Event @19-3E8AA42D
    function clscamera_tickets_error1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record camera_tickets_error1/Error";
        $this->Initialize();
        $this->camera_tickets_error_descrip = new clsField("camera_tickets_error_descrip", ccsText, "");
        
        $this->camera_state_type_id = new clsField("camera_state_type_id", ccsInteger, "");
        
        $this->multiple = new clsField("multiple", ccsText, "");
        
        $this->active = new clsField("active", ccsText, "");
        

        $this->InsertFields["camera_tickets_error_descrip"] = array("Name" => "camera_tickets_error_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["camera_state_type_id"] = array("Name" => "camera_state_type_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["multiple"] = array("Name" => "multiple", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["active"] = array("Name" => "active", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["camera_tickets_error_descrip"] = array("Name" => "camera_tickets_error_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["camera_state_type_id"] = array("Name" => "camera_state_type_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["multiple"] = array("Name" => "multiple", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["active"] = array("Name" => "active", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @19-6BEEBE43
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlcamera_tickets_error_id", ccsInteger, "", "", $this->Parameters["urlcamera_tickets_error_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "camera_tickets_error_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @19-B07ACC4D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_tickets_error {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @19-FF8D7D8A
    function SetValues()
    {
        $this->camera_tickets_error_descrip->SetDBValue($this->f("camera_tickets_error_descrip"));
        $this->camera_state_type_id->SetDBValue(trim($this->f("camera_state_type_id")));
        $this->multiple->SetDBValue($this->f("multiple"));
        $this->active->SetDBValue($this->f("active"));
    }
//End SetValues Method

//Insert Method @19-786D3628
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["camera_tickets_error_descrip"]["Value"] = $this->camera_tickets_error_descrip->GetDBValue(true);
        $this->InsertFields["camera_state_type_id"]["Value"] = $this->camera_state_type_id->GetDBValue(true);
        $this->InsertFields["multiple"]["Value"] = $this->multiple->GetDBValue(true);
        $this->InsertFields["active"]["Value"] = $this->active->GetDBValue(true);
        $this->SQL = CCBuildInsert("camera_tickets_error", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @19-84FA3BB2
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["camera_tickets_error_descrip"]["Value"] = $this->camera_tickets_error_descrip->GetDBValue(true);
        $this->UpdateFields["camera_state_type_id"]["Value"] = $this->camera_state_type_id->GetDBValue(true);
        $this->UpdateFields["multiple"]["Value"] = $this->multiple->GetDBValue(true);
        $this->UpdateFields["active"]["Value"] = $this->active->GetDBValue(true);
        $this->SQL = CCBuildUpdate("camera_tickets_error", $this->UpdateFields, $this);
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

} //End camera_tickets_error1DataSource Class @19-FCB6E20C

//Initialize Page @1-E960960B
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
$TemplateFileName = "ticket_error_set.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$PathToRootOpt = "../";
$Scripts = "|js/jquery/jquery.js|js/jquery/event-manager.js|js/jquery/selectors.js|js/jquery/ui/jquery.ui.core.js|js/jquery/ui/jquery.ui.widget.js|js/jquery/ui/jquery.ui.mouse.js|js/jquery/ui/jquery.ui.draggable.js|js/jquery/ui/jquery.ui.position.js|js/jquery/ui/jquery.ui.resizable.js|js/jquery/ui/jquery.ui.button.js|js/jquery/ui/jquery.ui.dialog.js|js/jquery/dialog/ccs-dialog.js|js/jquery/updatepanel/ccs-update-panel.js|";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-7FABC906
CCSecurityRedirect("1", "../mylogin.php");
//End Authenticate User

//Include events file @1-4E958A4C
include_once("./ticket_error_set_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-F762B76B
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
$camera_tickets_error = new clsGridcamera_tickets_error("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$Panel2->GenerateDiv = true;
$Panel2->PanelId = "Panel1Panel2";
$camera_tickets_error1 = new clsRecordcamera_tickets_error1("", $MainPage);
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$MainPage->mymenu = & $mymenu;
$MainPage->Panel1 = & $Panel1;
$MainPage->camera_tickets_error = & $camera_tickets_error;
$MainPage->Panel2 = & $Panel2;
$MainPage->camera_tickets_error1 = & $camera_tickets_error1;
$MainPage->app_environment_class = & $app_environment_class;
$Panel1->AddComponent("camera_tickets_error", $camera_tickets_error);
$Panel1->AddComponent("Panel2", $Panel2);
$Panel2->AddComponent("camera_tickets_error1", $camera_tickets_error1);
$camera_tickets_error->Initialize();
$camera_tickets_error1->Initialize();
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

//Execute Components @1-A272211C
$camera_tickets_error1->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-F348D75A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_tickets_error);
    unset($camera_tickets_error1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-76B474E9
$mymenu->Show();
$Panel1->Show();
$app_environment_class->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$MMLNKC3I9G2M5G4R = array("<center><font face=\"Arial\"><small>G&#101;&#110;e&#","114;&#97;ted <!-- SCC -->w&#105;th <!-- SCC -->&#6","7;ode&#67;&#104;a&#114;&#103;e <!-- SCC -->&#83;","t&#117;&#100;i&#111;.</small></font></center>","");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($MMLNKC3I9G2M5G4R,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($MMLNKC3I9G2M5G4R,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($MMLNKC3I9G2M5G4R,"");
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-55C09C1C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_tickets_error);
unset($camera_tickets_error1);
unset($Tpl);
//End Unload Page


?>
