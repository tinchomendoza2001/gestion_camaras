<?php
//Include Common Files @1-3D26EFC2
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "areas.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsGridareas1 { //areas1 class @8-8CFDEF38

//Variables @8-BECF7E82

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
    public $Sorter_area_id;
    public $Sorter_areas_descript;
    public $Sorter_state_type_id;
//End Variables

//Class_Initialize Event @8-BD93B79E
    function clsGridareas1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "areas1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid areas1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsareas1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 100;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("areas1Order", "");
        $this->SorterDirection = CCGetParam("areas1Dir", "");

        $this->area_id = new clsControl(ccsImageLink, "area_id", "area_id", ccsInteger, "", CCGetRequestParam("area_id", ccsGet, NULL), $this);
        $this->area_id->Page = "";
        $this->areas_descript = new clsControl(ccsLabel, "areas_descript", "areas_descript", ccsText, "", CCGetRequestParam("areas_descript", ccsGet, NULL), $this);
        $this->tipo_estado_html = new clsControl(ccsLabel, "tipo_estado_html", "tipo_estado_html", ccsText, "", CCGetRequestParam("tipo_estado_html", ccsGet, NULL), $this);
        $this->tipo_estado_html->HTML = true;
        $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", ccsGet, NULL), $this);
        $this->Link1->Page = "";
        $this->Sorter_area_id = new clsSorter($this->ComponentName, "Sorter_area_id", $FileName, $this);
        $this->Sorter_areas_descript = new clsSorter($this->ComponentName, "Sorter_areas_descript", $FileName, $this);
        $this->Sorter_state_type_id = new clsSorter($this->ComponentName, "Sorter_state_type_id", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->areas1_Insert = new clsControl(ccsLink, "areas1_Insert", "areas1_Insert", ccsText, "", CCGetRequestParam("areas1_Insert", ccsGet, NULL), $this);
        $this->areas1_Insert->Parameters = CCGetQueryString("QueryString", array("area_id", "ccsForm"));
        $this->areas1_Insert->Page = "areas.php";
    }
//End Class_Initialize Event

//Initialize Method @8-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @8-A83B8D54
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
            $this->ControlsVisible["area_id"] = $this->area_id->Visible;
            $this->ControlsVisible["areas_descript"] = $this->areas_descript->Visible;
            $this->ControlsVisible["tipo_estado_html"] = $this->tipo_estado_html->Visible;
            $this->ControlsVisible["Link1"] = $this->Link1->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->area_id->SetValue($this->DataSource->area_id->GetValue());
                $this->area_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->area_id->Parameters = CCAddParam($this->area_id->Parameters, "area_id", $this->DataSource->f("area_id"));
                $this->areas_descript->SetValue($this->DataSource->areas_descript->GetValue());
                $this->tipo_estado_html->SetValue($this->DataSource->tipo_estado_html->GetValue());
                $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "area_id", $this->DataSource->f("area_id"));
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->area_id->Show();
                $this->areas_descript->Show();
                $this->tipo_estado_html->Show();
                $this->Link1->Show();
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
        $this->Sorter_area_id->Show();
        $this->Sorter_areas_descript->Show();
        $this->Sorter_state_type_id->Show();
        $this->Navigator->Show();
        $this->areas1_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @8-B18881B0
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->area_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->areas_descript->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_html->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Link1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End areas1 Class @8-FCB6E20C

class clsareas1DataSource extends clsDBminseg {  //areas1DataSource Class @8-D385BEAF

//DataSource Variables @8-AD7FACFA
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $area_id;
    public $areas_descript;
    public $tipo_estado_html;
//End DataSource Variables

//DataSourceClass_Initialize Event @8-88A10E42
    function clsareas1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid areas1";
        $this->Initialize();
        $this->area_id = new clsField("area_id", ccsInteger, "");
        
        $this->areas_descript = new clsField("areas_descript", ccsText, "");
        
        $this->tipo_estado_html = new clsField("tipo_estado_html", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @8-5686CBD0
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_area_id" => array("area_id", ""), 
            "Sorter_areas_descript" => array("areas_descript", ""), 
            "Sorter_state_type_id" => array("state_type_id", "")));
    }
//End SetOrder Method

//Prepare Method @8-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @8-3CE95DA8
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM areas LEFT JOIN camera_type_states ON\n\n" .
        "areas.state_type_id = camera_type_states.tipo_estado_id";
        $this->SQL = "SELECT area_id, areas_descript, tipo_estado_html \n\n" .
        "FROM areas LEFT JOIN camera_type_states ON\n\n" .
        "areas.state_type_id = camera_type_states.tipo_estado_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @8-811622B7
    function SetValues()
    {
        $this->area_id->SetDBValue(trim($this->f("area_id")));
        $this->areas_descript->SetDBValue($this->f("areas_descript"));
        $this->tipo_estado_html->SetDBValue($this->f("tipo_estado_html"));
    }
//End SetValues Method

} //End areas1DataSource Class @8-FCB6E20C

class clsRecordareas2 { //areas2 Class @23-F399BD1A

//Variables @23-9E315808

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

//Class_Initialize Event @23-16311564
    function clsRecordareas2($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record areas2/Error";
        $this->DataSource = new clsareas2DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "areas2";
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
            $this->areas_descript = new clsControl(ccsTextBox, "areas_descript", "NOMBRE", ccsText, "", CCGetRequestParam("areas_descript", $Method, NULL), $this);
            $this->areas_descript->Required = true;
            $this->state_type_id = new clsControl(ccsListBox, "state_type_id", "Estado", ccsInteger, "", CCGetRequestParam("state_type_id", $Method, NULL), $this);
            $this->state_type_id->DSType = dsTable;
            $this->state_type_id->DataSource = new clsDBminseg();
            $this->state_type_id->ds = & $this->state_type_id->DataSource;
            $this->state_type_id->DataSource->SQL = "SELECT * \n" .
"FROM camera_type_states {SQL_Where} {SQL_OrderBy}";
            list($this->state_type_id->BoundColumn, $this->state_type_id->TextColumn, $this->state_type_id->DBFormat) = array("tipo_estado_id", "tipo_estado_descrip", "");
            if(!$this->FormSubmitted) {
                if(!is_array($this->state_type_id->Value) && !strlen($this->state_type_id->Value) && $this->state_type_id->Value !== false)
                    $this->state_type_id->SetText(1);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @23-83311241
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlarea_id"] = CCGetFromGet("area_id", NULL);
    }
//End Initialize Method

//Validate Method @23-DEB0453C
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->areas_descript->SetValue($this->areas_descript->GetValue());
        if(CCDLookUp("COUNT(*)", "areas", "areas_descript=" . $this->DataSource->ToSQL($this->DataSource->areas_descript->GetDBValue(), $this->DataSource->areas_descript->DataType) . $Where, $this->DataSource) > 0)
            $this->areas_descript->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "NOMBRE"));
        $Validation = ($this->areas_descript->Validate() && $Validation);
        $Validation = ($this->state_type_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->areas_descript->Errors->Count() == 0);
        $Validation =  $Validation && ($this->state_type_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @23-D3A40E58
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->areas_descript->Errors->Count());
        $errors = ($errors || $this->state_type_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @23-0BF2B389
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

//InsertRow Method @23-64E864DD
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->areas_descript->SetValue($this->areas_descript->GetValue(true));
        $this->DataSource->state_type_id->SetValue($this->state_type_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @23-6FA0359C
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->areas_descript->SetValue($this->areas_descript->GetValue(true));
        $this->DataSource->state_type_id->SetValue($this->state_type_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @23-427AAB04
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

        $this->state_type_id->Prepare();

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
                    $this->areas_descript->SetValue($this->DataSource->areas_descript->GetValue());
                    $this->state_type_id->SetValue($this->DataSource->state_type_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->areas_descript->Errors->ToString());
            $Error = ComposeStrings($Error, $this->state_type_id->Errors->ToString());
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
        $this->areas_descript->Show();
        $this->state_type_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End areas2 Class @23-FCB6E20C

class clsareas2DataSource extends clsDBminseg {  //areas2DataSource Class @23-97249BB7

//DataSource Variables @23-D2C3FECB
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
    public $areas_descript;
    public $state_type_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @23-44E44361
    function clsareas2DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record areas2/Error";
        $this->Initialize();
        $this->areas_descript = new clsField("areas_descript", ccsText, "");
        
        $this->state_type_id = new clsField("state_type_id", ccsInteger, "");
        

        $this->InsertFields["areas_descript"] = array("Name" => "areas_descript", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["state_type_id"] = array("Name" => "state_type_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["areas_descript"] = array("Name" => "areas_descript", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["state_type_id"] = array("Name" => "state_type_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @23-FA1A1D52
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlarea_id", ccsInteger, "", "", $this->Parameters["urlarea_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "area_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @23-5EE6A67F
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM areas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @23-2747E1DC
    function SetValues()
    {
        $this->areas_descript->SetDBValue($this->f("areas_descript"));
        $this->state_type_id->SetDBValue(trim($this->f("state_type_id")));
    }
//End SetValues Method

//Insert Method @23-4CB9D2B6
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["areas_descript"]["Value"] = $this->areas_descript->GetDBValue(true);
        $this->InsertFields["state_type_id"]["Value"] = $this->state_type_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("areas", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @23-4A908503
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["areas_descript"]["Value"] = $this->areas_descript->GetDBValue(true);
        $this->UpdateFields["state_type_id"]["Value"] = $this->state_type_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("areas", $this->UpdateFields, $this);
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

} //End areas2DataSource Class @23-FCB6E20C

class clsGridcamera_users_areas { //camera_users_areas class @94-D40B32A9

//Variables @94-886531B5

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
    public $Sorter_camera_user_id;
    public $Sorter_camera_user_area_id;
//End Variables

//Class_Initialize Event @94-5E7FD970
    function clsGridcamera_users_areas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_users_areas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_users_areas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_users_areasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 15;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("camera_users_areasOrder", "");
        $this->SorterDirection = CCGetParam("camera_users_areasDir", "");

        $this->camera_user_id = new clsControl(ccsLabel, "camera_user_id", "camera_user_id", ccsInteger, "", CCGetRequestParam("camera_user_id", ccsGet, NULL), $this);
        $this->camera_user_area_id = new clsControl(ccsImageLink, "camera_user_area_id", "camera_user_area_id", ccsInteger, "", CCGetRequestParam("camera_user_area_id", ccsGet, NULL), $this);
        $this->camera_user_area_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->camera_user_area_id->Page = "";
        $this->Sorter_camera_user_id = new clsSorter($this->ComponentName, "Sorter_camera_user_id", $FileName, $this);
        $this->Sorter_camera_user_area_id = new clsSorter($this->ComponentName, "Sorter_camera_user_area_id", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @94-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @94-022F32BE
    function Show()
    {
        $Tpl = CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_area_id"] = CCGetFromGet("s_area_id", NULL);
        $this->DataSource->Parameters["urls_camera_user_id"] = CCGetFromGet("s_camera_user_id", NULL);

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
            $this->ControlsVisible["camera_user_id"] = $this->camera_user_id->Visible;
            $this->ControlsVisible["camera_user_area_id"] = $this->camera_user_area_id->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->camera_user_id->SetValue($this->DataSource->camera_user_id->GetValue());
                $this->camera_user_area_id->SetValue($this->DataSource->camera_user_area_id->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->camera_user_id->Show();
                $this->camera_user_area_id->Show();
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
        $this->Sorter_camera_user_id->Show();
        $this->Sorter_camera_user_area_id->Show();
        $this->Navigator->Show();
        $this->Label1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @94-391ADE89
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->camera_user_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_user_area_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_users_areas Class @94-FCB6E20C

class clscamera_users_areasDataSource extends clsDBminseg {  //camera_users_areasDataSource Class @94-CB976978

//DataSource Variables @94-71B00CC0
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $camera_user_id;
    public $camera_user_area_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @94-98B09CD3
    function clscamera_users_areasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_users_areas";
        $this->Initialize();
        $this->camera_user_id = new clsField("camera_user_id", ccsInteger, "");
        
        $this->camera_user_area_id = new clsField("camera_user_area_id", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @94-567BD8B5
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "camera_user_area_id desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_camera_user_id" => array("camera_user_id", ""), 
            "Sorter_camera_user_area_id" => array("camera_user_area_id", "")));
    }
//End SetOrder Method

//Prepare Method @94-481B0091
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_area_id", ccsInteger, "", "", $this->Parameters["urls_area_id"], "", false);
        $this->wp->AddParameter("2", "urls_camera_user_id", ccsInteger, "", "", $this->Parameters["urls_camera_user_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "camera_users_areas.area_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "camera_users_areas.camera_user_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @94-784F59AF
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM camera_users_areas INNER JOIN camera_users ON\n\n" .
        "camera_users_areas.camera_user_id = camera_users.id";
        $this->SQL = "SELECT camera_users_areas.*, realname, username \n\n" .
        "FROM camera_users_areas INNER JOIN camera_users ON\n\n" .
        "camera_users_areas.camera_user_id = camera_users.id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @94-A9EDE263
    function SetValues()
    {
        $this->camera_user_id->SetDBValue(trim($this->f("camera_user_id")));
        $this->camera_user_area_id->SetDBValue(trim($this->f("camera_user_area_id")));
    }
//End SetValues Method

} //End camera_users_areasDataSource Class @94-FCB6E20C

class clsRecordcamera_users_areasSearch { //camera_users_areasSearch Class @103-3E68D912

//Variables @103-9E315808

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

//Class_Initialize Event @103-6B4BD7D6
    function clsRecordcamera_users_areasSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_users_areasSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_users_areasSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_area_id = new clsControl(ccsHidden, "s_area_id", $CCSLocales->GetText("area_id"), ccsInteger, "", CCGetRequestParam("s_area_id", $Method, NULL), $this);
            $this->s_camera_user_id = new clsControl(ccsTextBox, "s_camera_user_id", $CCSLocales->GetText("camera_user_id"), ccsInteger, "", CCGetRequestParam("s_camera_user_id", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Validate Method @103-D441ADE3
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_area_id->Validate() && $Validation);
        $Validation = ($this->s_camera_user_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_area_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_camera_user_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @103-C647817E
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_area_id->Errors->Count());
        $errors = ($errors || $this->s_camera_user_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @103-B1407AA7
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
            }
        }
        $Redirect = "areas.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "areas.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @103-1C0A4810
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

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->s_area_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_camera_user_id->Errors->ToString());
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
        $this->s_area_id->Show();
        $this->s_camera_user_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End camera_users_areasSearch Class @103-FCB6E20C

//Initialize Page @1-9FBA6601
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
$TemplateFileName = "areas.html";
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

//Include events file @1-01407A39
include_once("./areas_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-EF0C7968
$DBminseg = new clsDBminseg();
$MainPage->Connections["minseg"] = & $DBminseg;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$mymenu = new clsmymenu("../", "mymenu", $MainPage);
$mymenu->Initialize();
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$Panel1 = new clsPanel("Panel1", $MainPage);
$Panel1->GenerateDiv = true;
$Panel1->PanelId = "Panel1";
$areas1 = new clsGridareas1("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$Panel2->GenerateDiv = true;
$Panel2->PanelId = "Panel1Panel2";
$areas2 = new clsRecordareas2("", $MainPage);
$Panel3 = new clsPanel("Panel3", $MainPage);
$Panel3->GenerateDiv = true;
$Panel3->PanelId = "Panel1Panel3";
$camera_users_areas = new clsGridcamera_users_areas("", $MainPage);
$camera_users_areasSearch = new clsRecordcamera_users_areasSearch("", $MainPage);
$MainPage->mymenu = & $mymenu;
$MainPage->app_environment_class = & $app_environment_class;
$MainPage->Panel1 = & $Panel1;
$MainPage->areas1 = & $areas1;
$MainPage->Panel2 = & $Panel2;
$MainPage->areas2 = & $areas2;
$MainPage->Panel3 = & $Panel3;
$MainPage->camera_users_areas = & $camera_users_areas;
$MainPage->camera_users_areasSearch = & $camera_users_areasSearch;
$Panel1->AddComponent("areas1", $areas1);
$Panel1->AddComponent("Panel2", $Panel2);
$Panel1->AddComponent("Panel3", $Panel3);
$Panel2->AddComponent("areas2", $areas2);
$Panel3->AddComponent("camera_users_areas", $camera_users_areas);
$Panel3->AddComponent("camera_users_areasSearch", $camera_users_areasSearch);
$areas1->Initialize();
$areas2->Initialize();
$camera_users_areas->Initialize();
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

//Execute Components @1-59ADDFFC
$camera_users_areasSearch->Operation();
$areas2->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-91FED73E
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($areas1);
    unset($areas2);
    unset($camera_users_areas);
    unset($camera_users_areasSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-034BCE14
$mymenu->Show();
$app_environment_class->Show();
$Panel1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Aria", "l\"><small>&#71;e&#110;era&#", "116;ed <!-- CCS -->&#119;i", "th <!-- SCC -->Cod&#101;Ch&#9", "7;&#114;g&#101; <!-- CCS -->&", "#83;&#116;&#117;&#100;&#105", ";o.</small></font></center>", ""), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Aria", "l\"><small>&#71;e&#110;era&#", "116;ed <!-- CCS -->&#119;i", "th <!-- SCC -->Cod&#101;Ch&#9", "7;&#114;g&#101; <!-- CCS -->&", "#83;&#116;&#117;&#100;&#105", ";o.</small></font></center>", ""), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font face=\"Aria", "l\"><small>&#71;e&#110;era&#", "116;ed <!-- CCS -->&#119;i", "th <!-- SCC -->Cod&#101;Ch&#9", "7;&#114;g&#101; <!-- CCS -->&", "#83;&#116;&#117;&#100;&#105", ";o.</small></font></center>", ""), "");
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-A9D39CBD
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($areas1);
unset($areas2);
unset($camera_users_areas);
unset($camera_users_areasSearch);
unset($Tpl);
//End Unload Page


?>
