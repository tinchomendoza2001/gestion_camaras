<?php
//Include Common Files @1-8E0E3637
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "estados_ticket.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsGridcamera_status_ticket { //camera_status_ticket class @4-00162FD4

//Variables @4-ABA8CBEB

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
    public $Sorter_camera_status_ticket_id;
    public $Sorter_camera_status_ticket_descrip;
    public $Sorter_status_orden;
//End Variables

//Class_Initialize Event @4-0DC75074
    function clsGridcamera_status_ticket($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_status_ticket";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_status_ticket";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_status_ticketDataSource($this);
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
        $this->SorterName = CCGetParam("camera_status_ticketOrder", "");
        $this->SorterDirection = CCGetParam("camera_status_ticketDir", "");

        $this->camera_status_ticket_id = new clsControl(ccsImageLink, "camera_status_ticket_id", "camera_status_ticket_id", ccsInteger, "", CCGetRequestParam("camera_status_ticket_id", ccsGet, NULL), $this);
        $this->camera_status_ticket_id->Page = "";
        $this->camera_status_ticket_descrip = new clsControl(ccsLabel, "camera_status_ticket_descrip", "camera_status_ticket_descrip", ccsText, "", CCGetRequestParam("camera_status_ticket_descrip", ccsGet, NULL), $this);
        $this->status_orden = new clsControl(ccsLabel, "status_orden", "status_orden", ccsInteger, "", CCGetRequestParam("status_orden", ccsGet, NULL), $this);
        $this->avance = new clsControl(ccsLabel, "avance", "avance", ccsText, "", CCGetRequestParam("avance", ccsGet, NULL), $this);
        $this->Sorter_camera_status_ticket_id = new clsSorter($this->ComponentName, "Sorter_camera_status_ticket_id", $FileName, $this);
        $this->Sorter_camera_status_ticket_descrip = new clsSorter($this->ComponentName, "Sorter_camera_status_ticket_descrip", $FileName, $this);
        $this->Sorter_status_orden = new clsSorter($this->ComponentName, "Sorter_status_orden", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->camera_status_ticket_Insert = new clsControl(ccsLink, "camera_status_ticket_Insert", "camera_status_ticket_Insert", ccsText, "", CCGetRequestParam("camera_status_ticket_Insert", ccsGet, NULL), $this);
        $this->camera_status_ticket_Insert->Parameters = CCGetQueryString("QueryString", array("camera_status_ticket_id", "ccsForm"));
        $this->camera_status_ticket_Insert->Page = "estados_ticket.php";
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

//Show Method @4-56DEF426
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
            $this->ControlsVisible["camera_status_ticket_id"] = $this->camera_status_ticket_id->Visible;
            $this->ControlsVisible["camera_status_ticket_descrip"] = $this->camera_status_ticket_descrip->Visible;
            $this->ControlsVisible["status_orden"] = $this->status_orden->Visible;
            $this->ControlsVisible["avance"] = $this->avance->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->camera_status_ticket_id->SetValue($this->DataSource->camera_status_ticket_id->GetValue());
                $this->camera_status_ticket_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->camera_status_ticket_id->Parameters = CCAddParam($this->camera_status_ticket_id->Parameters, "camera_status_ticket_id", $this->DataSource->f("camera_status_ticket_id"));
                $this->camera_status_ticket_descrip->SetValue($this->DataSource->camera_status_ticket_descrip->GetValue());
                $this->status_orden->SetValue($this->DataSource->status_orden->GetValue());
                $this->avance->SetValue($this->DataSource->avance->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->camera_status_ticket_id->Show();
                $this->camera_status_ticket_descrip->Show();
                $this->status_orden->Show();
                $this->avance->Show();
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
        $this->Sorter_camera_status_ticket_id->Show();
        $this->Sorter_camera_status_ticket_descrip->Show();
        $this->Sorter_status_orden->Show();
        $this->Navigator->Show();
        $this->camera_status_ticket_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-A7D9C402
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->camera_status_ticket_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_status_ticket_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->status_orden->Errors->ToString());
        $errors = ComposeStrings($errors, $this->avance->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_status_ticket Class @4-FCB6E20C

class clscamera_status_ticketDataSource extends clsDBminseg {  //camera_status_ticketDataSource Class @4-FA0A90B1

//DataSource Variables @4-F521D8C5
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $camera_status_ticket_id;
    public $camera_status_ticket_descrip;
    public $status_orden;
    public $avance;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-2C972EA7
    function clscamera_status_ticketDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_status_ticket";
        $this->Initialize();
        $this->camera_status_ticket_id = new clsField("camera_status_ticket_id", ccsInteger, "");
        
        $this->camera_status_ticket_descrip = new clsField("camera_status_ticket_descrip", ccsText, "");
        
        $this->status_orden = new clsField("status_orden", ccsInteger, "");
        
        $this->avance = new clsField("avance", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-A5E7F6DC
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "status_orden";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_camera_status_ticket_id" => array("camera_status_ticket_id", ""), 
            "Sorter_camera_status_ticket_descrip" => array("camera_status_ticket_descrip", ""), 
            "Sorter_status_orden" => array("status_orden", "")));
    }
//End SetOrder Method

//Prepare Method @4-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @4-8422794D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM camera_status_ticket";
        $this->SQL = "SELECT camera_status_ticket_id, camera_status_ticket_descrip, status_orden, avance \n\n" .
        "FROM camera_status_ticket {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-BF8377A4
    function SetValues()
    {
        $this->camera_status_ticket_id->SetDBValue(trim($this->f("camera_status_ticket_id")));
        $this->camera_status_ticket_descrip->SetDBValue($this->f("camera_status_ticket_descrip"));
        $this->status_orden->SetDBValue(trim($this->f("status_orden")));
        $this->avance->SetDBValue($this->f("avance"));
    }
//End SetValues Method

} //End camera_status_ticketDataSource Class @4-FCB6E20C

class clsRecordcamera_status_ticket1 { //camera_status_ticket1 Class @19-B3D595A2

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

//Class_Initialize Event @19-8EB34783
    function clsRecordcamera_status_ticket1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_status_ticket1/Error";
        $this->DataSource = new clscamera_status_ticket1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_status_ticket1";
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
            $this->camera_status_ticket_descrip = new clsControl(ccsTextBox, "camera_status_ticket_descrip", "DESCRIPCION", ccsText, "", CCGetRequestParam("camera_status_ticket_descrip", $Method, NULL), $this);
            $this->camera_status_ticket_descrip->Required = true;
            $this->status_orden = new clsControl(ccsTextBox, "status_orden", "ORDEN", ccsInteger, "", CCGetRequestParam("status_orden", $Method, NULL), $this);
            $this->status_orden->Required = true;
            $this->avance = new clsControl(ccsTextBox, "avance", "avance", ccsText, "", CCGetRequestParam("avance", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @19-38386846
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlcamera_status_ticket_id"] = CCGetFromGet("camera_status_ticket_id", NULL);
    }
//End Initialize Method

//Validate Method @19-C7D8122F
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->camera_status_ticket_descrip->SetValue($this->camera_status_ticket_descrip->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_status_ticket", "camera_status_ticket_descrip=" . $this->DataSource->ToSQL($this->DataSource->camera_status_ticket_descrip->GetDBValue(), $this->DataSource->camera_status_ticket_descrip->DataType) . $Where, $this->DataSource) > 0)
            $this->camera_status_ticket_descrip->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "DESCRIPCION"));
        $this->DataSource->status_orden->SetValue($this->status_orden->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_status_ticket", "status_orden=" . $this->DataSource->ToSQL($this->DataSource->status_orden->GetDBValue(), $this->DataSource->status_orden->DataType) . $Where, $this->DataSource) > 0)
            $this->status_orden->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "ORDEN"));
        $Validation = ($this->camera_status_ticket_descrip->Validate() && $Validation);
        $Validation = ($this->status_orden->Validate() && $Validation);
        $Validation = ($this->avance->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->camera_status_ticket_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->status_orden->Errors->Count() == 0);
        $Validation =  $Validation && ($this->avance->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @19-C94DF170
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->camera_status_ticket_descrip->Errors->Count());
        $errors = ($errors || $this->status_orden->Errors->Count());
        $errors = ($errors || $this->avance->Errors->Count());
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

//InsertRow Method @19-4A431885
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->camera_status_ticket_descrip->SetValue($this->camera_status_ticket_descrip->GetValue(true));
        $this->DataSource->status_orden->SetValue($this->status_orden->GetValue(true));
        $this->DataSource->avance->SetValue($this->avance->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @19-9DAA8B6E
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->camera_status_ticket_descrip->SetValue($this->camera_status_ticket_descrip->GetValue(true));
        $this->DataSource->status_orden->SetValue($this->status_orden->GetValue(true));
        $this->DataSource->avance->SetValue($this->avance->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @19-F820DA7C
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
                    $this->camera_status_ticket_descrip->SetValue($this->DataSource->camera_status_ticket_descrip->GetValue());
                    $this->status_orden->SetValue($this->DataSource->status_orden->GetValue());
                    $this->avance->SetValue($this->DataSource->avance->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->camera_status_ticket_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->status_orden->Errors->ToString());
            $Error = ComposeStrings($Error, $this->avance->Errors->ToString());
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
        $this->camera_status_ticket_descrip->Show();
        $this->status_orden->Show();
        $this->avance->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End camera_status_ticket1 Class @19-FCB6E20C

class clscamera_status_ticket1DataSource extends clsDBminseg {  //camera_status_ticket1DataSource Class @19-529F84C6

//DataSource Variables @19-9540EF3D
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
    public $camera_status_ticket_descrip;
    public $status_orden;
    public $avance;
//End DataSource Variables

//DataSourceClass_Initialize Event @19-6EBC4325
    function clscamera_status_ticket1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record camera_status_ticket1/Error";
        $this->Initialize();
        $this->camera_status_ticket_descrip = new clsField("camera_status_ticket_descrip", ccsText, "");
        
        $this->status_orden = new clsField("status_orden", ccsInteger, "");
        
        $this->avance = new clsField("avance", ccsText, "");
        

        $this->InsertFields["camera_status_ticket_descrip"] = array("Name" => "camera_status_ticket_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["status_orden"] = array("Name" => "status_orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["avance"] = array("Name" => "avance", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["camera_status_ticket_descrip"] = array("Name" => "camera_status_ticket_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["status_orden"] = array("Name" => "status_orden", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["avance"] = array("Name" => "avance", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @19-9711715A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlcamera_status_ticket_id", ccsInteger, "", "", $this->Parameters["urlcamera_status_ticket_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "camera_status_ticket_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @19-E18625C1
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_status_ticket {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @19-5E0A0BA3
    function SetValues()
    {
        $this->camera_status_ticket_descrip->SetDBValue($this->f("camera_status_ticket_descrip"));
        $this->status_orden->SetDBValue(trim($this->f("status_orden")));
        $this->avance->SetDBValue($this->f("avance"));
    }
//End SetValues Method

//Insert Method @19-9198DACB
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["camera_status_ticket_descrip"]["Value"] = $this->camera_status_ticket_descrip->GetDBValue(true);
        $this->InsertFields["status_orden"]["Value"] = $this->status_orden->GetDBValue(true);
        $this->InsertFields["avance"]["Value"] = $this->avance->GetDBValue(true);
        $this->SQL = CCBuildInsert("camera_status_ticket", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @19-9F637E0F
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["camera_status_ticket_descrip"]["Value"] = $this->camera_status_ticket_descrip->GetDBValue(true);
        $this->UpdateFields["status_orden"]["Value"] = $this->status_orden->GetDBValue(true);
        $this->UpdateFields["avance"]["Value"] = $this->avance->GetDBValue(true);
        $this->SQL = CCBuildUpdate("camera_status_ticket", $this->UpdateFields, $this);
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

} //End camera_status_ticket1DataSource Class @19-FCB6E20C

//Initialize Page @1-BAA5694E
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
$TemplateFileName = "estados_ticket.html";
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

//Include events file @1-8B286A94
include_once("./estados_ticket_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-BC1426A1
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
$camera_status_ticket = new clsGridcamera_status_ticket("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$Panel2->GenerateDiv = true;
$Panel2->PanelId = "Panel1Panel2";
$camera_status_ticket1 = new clsRecordcamera_status_ticket1("", $MainPage);
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$MainPage->mymenu = & $mymenu;
$MainPage->Panel1 = & $Panel1;
$MainPage->camera_status_ticket = & $camera_status_ticket;
$MainPage->Panel2 = & $Panel2;
$MainPage->camera_status_ticket1 = & $camera_status_ticket1;
$MainPage->app_environment_class = & $app_environment_class;
$Panel1->AddComponent("camera_status_ticket", $camera_status_ticket);
$Panel1->AddComponent("Panel2", $Panel2);
$Panel2->AddComponent("camera_status_ticket1", $camera_status_ticket1);
$camera_status_ticket->Initialize();
$camera_status_ticket1->Initialize();
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

//Execute Components @1-59A196D8
$camera_status_ticket1->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-3DD53D2A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_status_ticket);
    unset($camera_status_ticket1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-7CCCD28B
$mymenu->Show();
$Panel1->Show();
$app_environment_class->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>Ge&#110;&#101;ra&#116;&#101;d <!-- CCS -->&#119;it&#104; <!-- SCC -->&#67;&#111;&#100;&#101;C&#104;a&#114;g&#101; <!-- CCS -->&#83;&#116;u&#100;&#105;&#111;.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>Ge&#110;&#101;ra&#116;&#101;d <!-- CCS -->&#119;it&#104; <!-- SCC -->&#67;&#111;&#100;&#101;C&#104;a&#114;g&#101; <!-- CCS -->&#83;&#116;u&#100;&#105;&#111;.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>Ge&#110;&#101;ra&#116;&#101;d <!-- CCS -->&#119;it&#104; <!-- SCC -->&#67;&#111;&#100;&#101;C&#104;a&#114;g&#101; <!-- CCS -->&#83;&#116;u&#100;&#105;&#111;.</small></font></center>";
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-C05B771C
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_status_ticket);
unset($camera_status_ticket1);
unset($Tpl);
//End Unload Page


?>
