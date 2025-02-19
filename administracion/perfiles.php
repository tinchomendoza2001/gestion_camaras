<?php
//Include Common Files @1-EB86478C
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "perfiles.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @7-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsGridcamera_profiles { //camera_profiles class @9-14B70BB9

//Variables @9-3486455F

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
    public $Sorter_camera_profile_descrip;
    public $Sorter_active;
//End Variables

//Class_Initialize Event @9-76543D55
    function clsGridcamera_profiles($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_profiles";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_profiles";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_profilesDataSource($this);
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
        $this->SorterName = CCGetParam("camera_profilesOrder", "");
        $this->SorterDirection = CCGetParam("camera_profilesDir", "");

        $this->camera_profile_id = new clsControl(ccsLink, "camera_profile_id", "camera_profile_id", ccsInteger, "", CCGetRequestParam("camera_profile_id", ccsGet, NULL), $this);
        $this->camera_profile_descrip = new clsControl(ccsLabel, "camera_profile_descrip", "camera_profile_descrip", ccsText, "", CCGetRequestParam("camera_profile_descrip", ccsGet, NULL), $this);
        $this->active = new clsControl(ccsLabel, "active", "active", ccsInteger, "", CCGetRequestParam("active", ccsGet, NULL), $this);
        $this->ticket = new clsControl(ccsLabel, "ticket", "ticket", ccsText, "", CCGetRequestParam("ticket", ccsGet, NULL), $this);
        $this->Sorter_camera_profile_descrip = new clsSorter($this->ComponentName, "Sorter_camera_profile_descrip", $FileName, $this);
        $this->Sorter_active = new clsSorter($this->ComponentName, "Sorter_active", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->camera_profiles_Insert = new clsControl(ccsLink, "camera_profiles_Insert", "camera_profiles_Insert", ccsText, "", CCGetRequestParam("camera_profiles_Insert", ccsGet, NULL), $this);
        $this->camera_profiles_Insert->Parameters = CCGetQueryString("QueryString", array("camera_profile_id", "ccsForm"));
        $this->camera_profiles_Insert->Page = "perfiles.php";
    }
//End Class_Initialize Event

//Initialize Method @9-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @9-49DD3FEE
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
            $this->ControlsVisible["camera_profile_id"] = $this->camera_profile_id->Visible;
            $this->ControlsVisible["camera_profile_descrip"] = $this->camera_profile_descrip->Visible;
            $this->ControlsVisible["active"] = $this->active->Visible;
            $this->ControlsVisible["ticket"] = $this->ticket->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->camera_profile_id->SetValue($this->DataSource->camera_profile_id->GetValue());
                $this->camera_profile_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->camera_profile_id->Parameters = CCAddParam($this->camera_profile_id->Parameters, "camera_profile_id", $this->DataSource->f("camera_profile_id"));
                $this->camera_profile_id->Page = $this->DataSource->f("");
                $this->camera_profile_descrip->SetValue($this->DataSource->camera_profile_descrip->GetValue());
                $this->ticket->SetValue($this->DataSource->ticket->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->camera_profile_id->Show();
                $this->camera_profile_descrip->Show();
                $this->active->Show();
                $this->ticket->Show();
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
        $this->Sorter_camera_profile_descrip->Show();
        $this->Sorter_active->Show();
        $this->Navigator->Show();
        $this->camera_profiles_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @9-D099B935
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->camera_profile_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_profile_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->active->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ticket->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_profiles Class @9-FCB6E20C

class clscamera_profilesDataSource extends clsDBminseg {  //camera_profilesDataSource Class @9-D4841E0F

//DataSource Variables @9-40065643
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $camera_profile_id;
    public $camera_profile_descrip;
    public $ticket;
//End DataSource Variables

//DataSourceClass_Initialize Event @9-4AB10B3C
    function clscamera_profilesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_profiles";
        $this->Initialize();
        $this->camera_profile_id = new clsField("camera_profile_id", ccsInteger, "");
        
        $this->camera_profile_descrip = new clsField("camera_profile_descrip", ccsText, "");
        
        $this->ticket = new clsField("ticket", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @9-F927D10A
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_camera_profile_descrip" => array("camera_profile_descrip", ""), 
            "Sorter_active" => array("active", "")));
    }
//End SetOrder Method

//Prepare Method @9-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @9-810313FA
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM camera_profiles";
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_profiles {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @9-17F58EAA
    function SetValues()
    {
        $this->camera_profile_id->SetDBValue(trim($this->f("camera_profile_id")));
        $this->camera_profile_descrip->SetDBValue($this->f("camera_profile_descrip"));
        $this->ticket->SetDBValue($this->f("ticket"));
    }
//End SetValues Method

} //End camera_profilesDataSource Class @9-FCB6E20C

class clsRecordcamera_profiles1 { //camera_profiles1 Class @24-83F93AFB

//Variables @24-9E315808

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

//Class_Initialize Event @24-0DF7B52B
    function clsRecordcamera_profiles1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_profiles1/Error";
        $this->DataSource = new clscamera_profiles1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_profiles1";
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
            $this->camera_profile_descrip = new clsControl(ccsTextBox, "camera_profile_descrip", "DESCRIPCION", ccsText, "", CCGetRequestParam("camera_profile_descrip", $Method, NULL), $this);
            $this->camera_profile_descrip->Required = true;
            $this->active = new clsControl(ccsListBox, "active", $CCSLocales->GetText("active"), ccsInteger, "", CCGetRequestParam("active", $Method, NULL), $this);
            $this->active->DSType = dsListOfValues;
            $this->active->Values = array(array("1", "SI"), array("2", "NO"));
            $this->ticket = new clsControl(ccsCheckBox, "ticket", "ticket", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("ticket", $Method, NULL), $this);
            $this->ticket->CheckedValue = true;
            $this->ticket->UncheckedValue = false;
            if(!$this->FormSubmitted) {
                if(!is_array($this->ticket->Value) && !strlen($this->ticket->Value) && $this->ticket->Value !== false)
                    $this->ticket->SetValue(false);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @24-A18274A2
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlcamera_profile_id"] = CCGetFromGet("camera_profile_id", NULL);
    }
//End Initialize Method

//Validate Method @24-E348CC50
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->camera_profile_descrip->SetValue($this->camera_profile_descrip->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_profiles", "camera_profile_descrip=" . $this->DataSource->ToSQL($this->DataSource->camera_profile_descrip->GetDBValue(), $this->DataSource->camera_profile_descrip->DataType) . $Where, $this->DataSource) > 0)
            $this->camera_profile_descrip->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "DESCRIPCION"));
        $Validation = ($this->camera_profile_descrip->Validate() && $Validation);
        $Validation = ($this->active->Validate() && $Validation);
        $Validation = ($this->ticket->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->camera_profile_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->active->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ticket->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @24-DF63B87A
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->camera_profile_descrip->Errors->Count());
        $errors = ($errors || $this->active->Errors->Count());
        $errors = ($errors || $this->ticket->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @24-0BF2B389
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

//InsertRow Method @24-DE67D984
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->camera_profile_descrip->SetValue($this->camera_profile_descrip->GetValue(true));
        $this->DataSource->active->SetValue($this->active->GetValue(true));
        $this->DataSource->ticket->SetValue($this->ticket->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @24-A53421D3
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->camera_profile_descrip->SetValue($this->camera_profile_descrip->GetValue(true));
        $this->DataSource->active->SetValue($this->active->GetValue(true));
        $this->DataSource->ticket->SetValue($this->ticket->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @24-EC6EBDCD
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
                    $this->camera_profile_descrip->SetValue($this->DataSource->camera_profile_descrip->GetValue());
                    $this->active->SetValue($this->DataSource->active->GetValue());
                    $this->ticket->SetValue($this->DataSource->ticket->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->camera_profile_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->active->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ticket->Errors->ToString());
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
        $this->camera_profile_descrip->Show();
        $this->active->Show();
        $this->ticket->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End camera_profiles1 Class @24-FCB6E20C

class clscamera_profiles1DataSource extends clsDBminseg {  //camera_profiles1DataSource Class @24-7E6894C3

//DataSource Variables @24-2EEC3755
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
    public $camera_profile_descrip;
    public $active;
    public $ticket;
//End DataSource Variables

//DataSourceClass_Initialize Event @24-681A8CFB
    function clscamera_profiles1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record camera_profiles1/Error";
        $this->Initialize();
        $this->camera_profile_descrip = new clsField("camera_profile_descrip", ccsText, "");
        
        $this->active = new clsField("active", ccsInteger, "");
        
        $this->ticket = new clsField("ticket", ccsBoolean, $this->BooleanFormat);
        

        $this->InsertFields["camera_profile_descrip"] = array("Name" => "camera_profile_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["active"] = array("Name" => "active", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["ticket"] = array("Name" => "ticket", "Value" => "", "DataType" => ccsBoolean);
        $this->UpdateFields["camera_profile_descrip"] = array("Name" => "camera_profile_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["active"] = array("Name" => "active", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["ticket"] = array("Name" => "ticket", "Value" => "", "DataType" => ccsBoolean);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @24-FC1D4400
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlcamera_profile_id", ccsInteger, "", "", $this->Parameters["urlcamera_profile_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "camera_profile_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @24-A692BE63
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_profiles {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @24-6A080A9E
    function SetValues()
    {
        $this->camera_profile_descrip->SetDBValue($this->f("camera_profile_descrip"));
        $this->active->SetDBValue(trim($this->f("active")));
        $this->ticket->SetDBValue(trim($this->f("ticket")));
    }
//End SetValues Method

//Insert Method @24-B61ACF03
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["camera_profile_descrip"]["Value"] = $this->camera_profile_descrip->GetDBValue(true);
        $this->InsertFields["active"]["Value"] = $this->active->GetDBValue(true);
        $this->InsertFields["ticket"]["Value"] = $this->ticket->GetDBValue(true);
        $this->SQL = CCBuildInsert("camera_profiles", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @24-62A6EFAF
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["camera_profile_descrip"]["Value"] = $this->camera_profile_descrip->GetDBValue(true);
        $this->UpdateFields["active"]["Value"] = $this->active->GetDBValue(true);
        $this->UpdateFields["ticket"]["Value"] = $this->ticket->GetDBValue(true);
        $this->SQL = CCBuildUpdate("camera_profiles", $this->UpdateFields, $this);
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

} //End camera_profiles1DataSource Class @24-FCB6E20C



//Initialize Page @1-45410BF8
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
$TemplateFileName = "perfiles.html";
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

//Include events file @1-C62787EF
include_once("./perfiles_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-86F6B507
$DBminseg = new clsDBminseg();
$MainPage->Connections["minseg"] = & $DBminseg;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$mymenu = new clsmymenu("../", "mymenu", $MainPage);
$mymenu->Initialize();
$Panel1 = new clsPanel("Panel1", $MainPage);
$Panel1->GenerateDiv = true;
$Panel1->PanelId = "Panel1";
$camera_profiles = new clsGridcamera_profiles("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$Panel2->GenerateDiv = true;
$Panel2->PanelId = "Panel1Panel2";
$camera_profiles1 = new clsRecordcamera_profiles1("", $MainPage);
$MainPage->app_environment_class = & $app_environment_class;
$MainPage->mymenu = & $mymenu;
$MainPage->Panel1 = & $Panel1;
$MainPage->camera_profiles = & $camera_profiles;
$MainPage->Panel2 = & $Panel2;
$MainPage->camera_profiles1 = & $camera_profiles1;
$Panel1->AddComponent("camera_profiles", $camera_profiles);
$Panel1->AddComponent("Panel2", $Panel2);
$Panel2->AddComponent("camera_profiles1", $camera_profiles1);
$camera_profiles->Initialize();
$camera_profiles1->Initialize();
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

//Execute Components @1-503A432B
$camera_profiles1->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-CCB6A7B2
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_profiles);
    unset($camera_profiles1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-EF9BE7DE
$mymenu->Show();
$app_environment_class->Show();
$Panel1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Arial\"><s", "mall>&#71;&#101;&#110;e&#114;&#9", "7;ted <!-- SCC -->with <!--", " CCS -->&#67;o&#100;&#101;&", "#67;&#104;&#97;&#114;ge <!-- SC", "C -->&#83;tudi&#111;.</small></", "font></center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Arial\"><s", "mall>&#71;&#101;&#110;e&#114;&#9", "7;ted <!-- SCC -->with <!--", " CCS -->&#67;o&#100;&#101;&", "#67;&#104;&#97;&#114;ge <!-- SC", "C -->&#83;tudi&#111;.</small></", "font></center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font face=\"Arial\"><s", "mall>&#71;&#101;&#110;e&#114;&#9", "7;ted <!-- SCC -->with <!--", " CCS -->&#67;o&#100;&#101;&", "#67;&#104;&#97;&#114;ge <!-- SC", "C -->&#83;tudi&#111;.</small></", "font></center>"), "");
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-015CDE98
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_profiles);
unset($camera_profiles1);
unset($Tpl);
//End Unload Page


?>
