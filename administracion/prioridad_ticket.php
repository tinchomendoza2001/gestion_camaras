<?php
//Include Common Files @1-D60B452C
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "prioridad_ticket.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsGridcamera_ticket_prioritys { //camera_ticket_prioritys class @4-001D5B05

//Variables @4-B799BFB3

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
    public $Sorter_camera_ticket_priority_id;
    public $Sorter_camera_ticket_priority_descrip;
    public $Sorter_camera_ticket_priority_level;
    public $Sorter_camera_ticket_priority_html;
//End Variables

//Class_Initialize Event @4-62843B20
    function clsGridcamera_ticket_prioritys($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_ticket_prioritys";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_ticket_prioritys";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_ticket_prioritysDataSource($this);
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
        $this->SorterName = CCGetParam("camera_ticket_prioritysOrder", "");
        $this->SorterDirection = CCGetParam("camera_ticket_prioritysDir", "");

        $this->camera_ticket_priority_id = new clsControl(ccsImageLink, "camera_ticket_priority_id", "camera_ticket_priority_id", ccsInteger, "", CCGetRequestParam("camera_ticket_priority_id", ccsGet, NULL), $this);
        $this->camera_ticket_priority_id->Page = "";
        $this->camera_ticket_priority_descrip = new clsControl(ccsLabel, "camera_ticket_priority_descrip", "camera_ticket_priority_descrip", ccsText, "", CCGetRequestParam("camera_ticket_priority_descrip", ccsGet, NULL), $this);
        $this->camera_ticket_priority_level = new clsControl(ccsLabel, "camera_ticket_priority_level", "camera_ticket_priority_level", ccsInteger, "", CCGetRequestParam("camera_ticket_priority_level", ccsGet, NULL), $this);
        $this->camera_ticket_priority_html = new clsControl(ccsLabel, "camera_ticket_priority_html", "camera_ticket_priority_html", ccsText, "", CCGetRequestParam("camera_ticket_priority_html", ccsGet, NULL), $this);
        $this->camera_ticket_priority_html->HTML = true;
        $this->Sorter_camera_ticket_priority_id = new clsSorter($this->ComponentName, "Sorter_camera_ticket_priority_id", $FileName, $this);
        $this->Sorter_camera_ticket_priority_descrip = new clsSorter($this->ComponentName, "Sorter_camera_ticket_priority_descrip", $FileName, $this);
        $this->Sorter_camera_ticket_priority_level = new clsSorter($this->ComponentName, "Sorter_camera_ticket_priority_level", $FileName, $this);
        $this->Sorter_camera_ticket_priority_html = new clsSorter($this->ComponentName, "Sorter_camera_ticket_priority_html", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->camera_ticket_prioritys_Insert = new clsControl(ccsLink, "camera_ticket_prioritys_Insert", "camera_ticket_prioritys_Insert", ccsText, "", CCGetRequestParam("camera_ticket_prioritys_Insert", ccsGet, NULL), $this);
        $this->camera_ticket_prioritys_Insert->Parameters = CCGetQueryString("QueryString", array("camera_ticket_priority_id", "ccsForm"));
        $this->camera_ticket_prioritys_Insert->Page = "prioridad_ticket.php";
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

//Show Method @4-B9649FB3
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
            $this->ControlsVisible["camera_ticket_priority_id"] = $this->camera_ticket_priority_id->Visible;
            $this->ControlsVisible["camera_ticket_priority_descrip"] = $this->camera_ticket_priority_descrip->Visible;
            $this->ControlsVisible["camera_ticket_priority_level"] = $this->camera_ticket_priority_level->Visible;
            $this->ControlsVisible["camera_ticket_priority_html"] = $this->camera_ticket_priority_html->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->camera_ticket_priority_id->SetValue($this->DataSource->camera_ticket_priority_id->GetValue());
                $this->camera_ticket_priority_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->camera_ticket_priority_id->Parameters = CCAddParam($this->camera_ticket_priority_id->Parameters, "camera_ticket_priority_id", $this->DataSource->f("camera_ticket_priority_id"));
                $this->camera_ticket_priority_descrip->SetValue($this->DataSource->camera_ticket_priority_descrip->GetValue());
                $this->camera_ticket_priority_level->SetValue($this->DataSource->camera_ticket_priority_level->GetValue());
                $this->camera_ticket_priority_html->SetValue($this->DataSource->camera_ticket_priority_html->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->camera_ticket_priority_id->Show();
                $this->camera_ticket_priority_descrip->Show();
                $this->camera_ticket_priority_level->Show();
                $this->camera_ticket_priority_html->Show();
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
        $this->Sorter_camera_ticket_priority_id->Show();
        $this->Sorter_camera_ticket_priority_descrip->Show();
        $this->Sorter_camera_ticket_priority_level->Show();
        $this->Sorter_camera_ticket_priority_html->Show();
        $this->Navigator->Show();
        $this->camera_ticket_prioritys_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-EB5DE2DB
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->camera_ticket_priority_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_ticket_priority_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_ticket_priority_level->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_ticket_priority_html->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_ticket_prioritys Class @4-FCB6E20C

class clscamera_ticket_prioritysDataSource extends clsDBminseg {  //camera_ticket_prioritysDataSource Class @4-C18EA18F

//DataSource Variables @4-1441906F
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $camera_ticket_priority_id;
    public $camera_ticket_priority_descrip;
    public $camera_ticket_priority_level;
    public $camera_ticket_priority_html;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-1D50E01D
    function clscamera_ticket_prioritysDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_ticket_prioritys";
        $this->Initialize();
        $this->camera_ticket_priority_id = new clsField("camera_ticket_priority_id", ccsInteger, "");
        
        $this->camera_ticket_priority_descrip = new clsField("camera_ticket_priority_descrip", ccsText, "");
        
        $this->camera_ticket_priority_level = new clsField("camera_ticket_priority_level", ccsInteger, "");
        
        $this->camera_ticket_priority_html = new clsField("camera_ticket_priority_html", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-B6CC9E86
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_camera_ticket_priority_id" => array("camera_ticket_priority_id", ""), 
            "Sorter_camera_ticket_priority_descrip" => array("camera_ticket_priority_descrip", ""), 
            "Sorter_camera_ticket_priority_level" => array("camera_ticket_priority_level", ""), 
            "Sorter_camera_ticket_priority_html" => array("camera_ticket_priority_html", "")));
    }
//End SetOrder Method

//Prepare Method @4-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @4-14938FD1
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM camera_ticket_prioritys";
        $this->SQL = "SELECT camera_ticket_priority_id, camera_ticket_priority_descrip, camera_ticket_priority_level, camera_ticket_priority_html \n\n" .
        "FROM camera_ticket_prioritys {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-E3FF47B6
    function SetValues()
    {
        $this->camera_ticket_priority_id->SetDBValue(trim($this->f("camera_ticket_priority_id")));
        $this->camera_ticket_priority_descrip->SetDBValue($this->f("camera_ticket_priority_descrip"));
        $this->camera_ticket_priority_level->SetDBValue(trim($this->f("camera_ticket_priority_level")));
        $this->camera_ticket_priority_html->SetDBValue($this->f("camera_ticket_priority_html"));
    }
//End SetValues Method

} //End camera_ticket_prioritysDataSource Class @4-FCB6E20C

class clsRecordcamera_ticket_prioritys1 { //camera_ticket_prioritys1 Class @22-B99D2364

//Variables @22-9E315808

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

//Class_Initialize Event @22-3D819BC7
    function clsRecordcamera_ticket_prioritys1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_ticket_prioritys1/Error";
        $this->DataSource = new clscamera_ticket_prioritys1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_ticket_prioritys1";
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
            $this->camera_ticket_priority_descrip = new clsControl(ccsTextBox, "camera_ticket_priority_descrip", $CCSLocales->GetText("camera_ticket_priority_descrip"), ccsText, "", CCGetRequestParam("camera_ticket_priority_descrip", $Method, NULL), $this);
            $this->camera_ticket_priority_level = new clsControl(ccsTextBox, "camera_ticket_priority_level", $CCSLocales->GetText("camera_ticket_priority_level"), ccsInteger, "", CCGetRequestParam("camera_ticket_priority_level", $Method, NULL), $this);
            $this->camera_ticket_priority_html = new clsControl(ccsTextBox, "camera_ticket_priority_html", $CCSLocales->GetText("camera_ticket_priority_html"), ccsText, "", CCGetRequestParam("camera_ticket_priority_html", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @22-BFB48ABF
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlcamera_ticket_priority_id"] = CCGetFromGet("camera_ticket_priority_id", NULL);
    }
//End Initialize Method

//Validate Method @22-7C197A9A
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->camera_ticket_priority_descrip->Validate() && $Validation);
        $Validation = ($this->camera_ticket_priority_level->Validate() && $Validation);
        $Validation = ($this->camera_ticket_priority_html->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->camera_ticket_priority_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->camera_ticket_priority_level->Errors->Count() == 0);
        $Validation =  $Validation && ($this->camera_ticket_priority_html->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @22-F878E9DB
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->camera_ticket_priority_descrip->Errors->Count());
        $errors = ($errors || $this->camera_ticket_priority_level->Errors->Count());
        $errors = ($errors || $this->camera_ticket_priority_html->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @22-0BF2B389
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

//InsertRow Method @22-7660F30C
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->camera_ticket_priority_descrip->SetValue($this->camera_ticket_priority_descrip->GetValue(true));
        $this->DataSource->camera_ticket_priority_level->SetValue($this->camera_ticket_priority_level->GetValue(true));
        $this->DataSource->camera_ticket_priority_html->SetValue($this->camera_ticket_priority_html->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @22-60219607
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->camera_ticket_priority_descrip->SetValue($this->camera_ticket_priority_descrip->GetValue(true));
        $this->DataSource->camera_ticket_priority_level->SetValue($this->camera_ticket_priority_level->GetValue(true));
        $this->DataSource->camera_ticket_priority_html->SetValue($this->camera_ticket_priority_html->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @22-C1DC34BF
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
                    $this->camera_ticket_priority_descrip->SetValue($this->DataSource->camera_ticket_priority_descrip->GetValue());
                    $this->camera_ticket_priority_level->SetValue($this->DataSource->camera_ticket_priority_level->GetValue());
                    $this->camera_ticket_priority_html->SetValue($this->DataSource->camera_ticket_priority_html->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->camera_ticket_priority_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->camera_ticket_priority_level->Errors->ToString());
            $Error = ComposeStrings($Error, $this->camera_ticket_priority_html->Errors->ToString());
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
        $this->camera_ticket_priority_descrip->Show();
        $this->camera_ticket_priority_level->Show();
        $this->camera_ticket_priority_html->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End camera_ticket_prioritys1 Class @22-FCB6E20C

class clscamera_ticket_prioritys1DataSource extends clsDBminseg {  //camera_ticket_prioritys1DataSource Class @22-93C51D5C

//DataSource Variables @22-10DCFCA0
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
    public $camera_ticket_priority_descrip;
    public $camera_ticket_priority_level;
    public $camera_ticket_priority_html;
//End DataSource Variables

//DataSourceClass_Initialize Event @22-C72FC804
    function clscamera_ticket_prioritys1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record camera_ticket_prioritys1/Error";
        $this->Initialize();
        $this->camera_ticket_priority_descrip = new clsField("camera_ticket_priority_descrip", ccsText, "");
        
        $this->camera_ticket_priority_level = new clsField("camera_ticket_priority_level", ccsInteger, "");
        
        $this->camera_ticket_priority_html = new clsField("camera_ticket_priority_html", ccsText, "");
        

        $this->InsertFields["camera_ticket_priority_descrip"] = array("Name" => "camera_ticket_priority_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["camera_ticket_priority_level"] = array("Name" => "camera_ticket_priority_level", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["camera_ticket_priority_html"] = array("Name" => "camera_ticket_priority_html", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["camera_ticket_priority_descrip"] = array("Name" => "camera_ticket_priority_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["camera_ticket_priority_level"] = array("Name" => "camera_ticket_priority_level", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["camera_ticket_priority_html"] = array("Name" => "camera_ticket_priority_html", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @22-DD9F57CA
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlcamera_ticket_priority_id", ccsInteger, "", "", $this->Parameters["urlcamera_ticket_priority_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "camera_ticket_priority_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @22-DABD8D5E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_ticket_prioritys {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @22-ECBAEB39
    function SetValues()
    {
        $this->camera_ticket_priority_descrip->SetDBValue($this->f("camera_ticket_priority_descrip"));
        $this->camera_ticket_priority_level->SetDBValue(trim($this->f("camera_ticket_priority_level")));
        $this->camera_ticket_priority_html->SetDBValue($this->f("camera_ticket_priority_html"));
    }
//End SetValues Method

//Insert Method @22-504468B7
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["camera_ticket_priority_descrip"]["Value"] = $this->camera_ticket_priority_descrip->GetDBValue(true);
        $this->InsertFields["camera_ticket_priority_level"]["Value"] = $this->camera_ticket_priority_level->GetDBValue(true);
        $this->InsertFields["camera_ticket_priority_html"]["Value"] = $this->camera_ticket_priority_html->GetDBValue(true);
        $this->SQL = CCBuildInsert("camera_ticket_prioritys", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @22-41635AC3
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["camera_ticket_priority_descrip"]["Value"] = $this->camera_ticket_priority_descrip->GetDBValue(true);
        $this->UpdateFields["camera_ticket_priority_level"]["Value"] = $this->camera_ticket_priority_level->GetDBValue(true);
        $this->UpdateFields["camera_ticket_priority_html"]["Value"] = $this->camera_ticket_priority_html->GetDBValue(true);
        $this->SQL = CCBuildUpdate("camera_ticket_prioritys", $this->UpdateFields, $this);
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

} //End camera_ticket_prioritys1DataSource Class @22-FCB6E20C

//Initialize Page @1-09DF907B
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
$TemplateFileName = "prioridad_ticket.html";
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

//Include events file @1-1F85C7F0
include_once("./prioridad_ticket_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-40C0FCDC
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
$camera_ticket_prioritys = new clsGridcamera_ticket_prioritys("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$Panel2->GenerateDiv = true;
$Panel2->PanelId = "Panel1Panel2";
$camera_ticket_prioritys1 = new clsRecordcamera_ticket_prioritys1("", $MainPage);
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$MainPage->mymenu = & $mymenu;
$MainPage->Panel1 = & $Panel1;
$MainPage->camera_ticket_prioritys = & $camera_ticket_prioritys;
$MainPage->Panel2 = & $Panel2;
$MainPage->camera_ticket_prioritys1 = & $camera_ticket_prioritys1;
$MainPage->app_environment_class = & $app_environment_class;
$Panel1->AddComponent("camera_ticket_prioritys", $camera_ticket_prioritys);
$Panel1->AddComponent("Panel2", $Panel2);
$Panel2->AddComponent("camera_ticket_prioritys1", $camera_ticket_prioritys1);
$camera_ticket_prioritys->Initialize();
$camera_ticket_prioritys1->Initialize();
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

//Execute Components @1-D9413EAD
$camera_ticket_prioritys1->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-8B7DE4B4
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_ticket_prioritys);
    unset($camera_ticket_prioritys1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-959AC121
$mymenu->Show();
$Panel1->Show();
$app_environment_class->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$OQAJJHF4I9E2T9G = explode("|", "<center><font face=\"|Arial\"><small>&#71;e|&#110;era&#116;&#10|1;d <!-- SCC -->&#119|;&#105;&#116;&#104; <|!-- CCS -->&#67;&#111;|d&#101;&#67;ha&#114;&#|103;&#101; <!-- SCC| -->&#83;&#116;&#117;|di&#111;.</small></f|ont></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($OQAJJHF4I9E2T9G,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($OQAJJHF4I9E2T9G,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($OQAJJHF4I9E2T9G,"");
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-C7AB3C11
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_ticket_prioritys);
unset($camera_ticket_prioritys1);
unset($Tpl);
//End Unload Page


?>
