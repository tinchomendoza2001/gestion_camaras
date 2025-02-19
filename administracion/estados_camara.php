<?php
//Include Common Files @1-2EED5305
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "estados_camara.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsGridcamera_states_types { //camera_states_types class @4-11700C93

//Variables @4-9C13A829

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
    public $Sorter_description;
//End Variables

//Class_Initialize Event @4-41DD03FC
    function clsGridcamera_states_types($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_states_types";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_states_types";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_states_typesDataSource($this);
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
        $this->SorterName = CCGetParam("camera_states_typesOrder", "");
        $this->SorterDirection = CCGetParam("camera_states_typesDir", "");

        $this->description = new clsControl(ccsLink, "description", "description", ccsText, "", CCGetRequestParam("description", ccsGet, NULL), $this);
        $this->description->Page = "";
        $this->id = new clsControl(ccsLabel, "id", "id", ccsText, "", CCGetRequestParam("id", ccsGet, NULL), $this);
        $this->predecessor_id = new clsControl(ccsLabel, "predecessor_id", "predecessor_id", ccsText, "", CCGetRequestParam("predecessor_id", ccsGet, NULL), $this);
        $this->image_url = new clsControl(ccsLabel, "image_url", "image_url", ccsText, "", CCGetRequestParam("image_url", ccsGet, NULL), $this);
        $this->corte = new clsControl(ccsLabel, "corte", "corte", ccsText, "", CCGetRequestParam("corte", ccsGet, NULL), $this);
        $this->estado_ticket_inst = new clsControl(ccsLabel, "estado_ticket_inst", "estado_ticket_inst", ccsText, "", CCGetRequestParam("estado_ticket_inst", ccsGet, NULL), $this);
        $this->estado_ticket = new clsControl(ccsLabel, "estado_ticket", "estado_ticket", ccsText, "", CCGetRequestParam("estado_ticket", ccsGet, NULL), $this);
        $this->estado = new clsControl(ccsLabel, "estado", "estado", ccsText, "", CCGetRequestParam("estado", ccsGet, NULL), $this);
        $this->level = new clsControl(ccsLabel, "level", "level", ccsText, "", CCGetRequestParam("level", ccsGet, NULL), $this);
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $this);
        $this->Label1->HTML = true;
        $this->estado_novedad = new clsControl(ccsLabel, "estado_novedad", "estado_novedad", ccsText, "", CCGetRequestParam("estado_novedad", ccsGet, NULL), $this);
        $this->estado_novedad->HTML = true;
        $this->reserva = new clsControl(ccsLabel, "reserva", "reserva", ccsText, "", CCGetRequestParam("reserva", ccsGet, NULL), $this);
        $this->Sorter_description = new clsSorter($this->ComponentName, "Sorter_description", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->camera_states_types_Insert = new clsControl(ccsLink, "camera_states_types_Insert", "camera_states_types_Insert", ccsText, "", CCGetRequestParam("camera_states_types_Insert", ccsGet, NULL), $this);
        $this->camera_states_types_Insert->Parameters = CCGetQueryString("QueryString", array("id", "ccsForm"));
        $this->camera_states_types_Insert->Page = "estados_camara.php";
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

//Show Method @4-6FA86CB7
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
            $this->ControlsVisible["description"] = $this->description->Visible;
            $this->ControlsVisible["id"] = $this->id->Visible;
            $this->ControlsVisible["predecessor_id"] = $this->predecessor_id->Visible;
            $this->ControlsVisible["image_url"] = $this->image_url->Visible;
            $this->ControlsVisible["corte"] = $this->corte->Visible;
            $this->ControlsVisible["estado_ticket_inst"] = $this->estado_ticket_inst->Visible;
            $this->ControlsVisible["estado_ticket"] = $this->estado_ticket->Visible;
            $this->ControlsVisible["estado"] = $this->estado->Visible;
            $this->ControlsVisible["level"] = $this->level->Visible;
            $this->ControlsVisible["Label1"] = $this->Label1->Visible;
            $this->ControlsVisible["estado_novedad"] = $this->estado_novedad->Visible;
            $this->ControlsVisible["reserva"] = $this->reserva->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->description->SetValue($this->DataSource->description->GetValue());
                $this->description->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->description->Parameters = CCAddParam($this->description->Parameters, "id", $this->DataSource->f("id"));
                $this->id->SetValue($this->DataSource->id->GetValue());
                $this->predecessor_id->SetValue($this->DataSource->predecessor_id->GetValue());
                $this->image_url->SetValue($this->DataSource->image_url->GetValue());
                $this->corte->SetValue($this->DataSource->corte->GetValue());
                $this->estado_ticket_inst->SetValue($this->DataSource->estado_ticket_inst->GetValue());
                $this->estado_ticket->SetValue($this->DataSource->estado_ticket->GetValue());
                $this->estado->SetValue($this->DataSource->estado->GetValue());
                $this->level->SetValue($this->DataSource->level->GetValue());
                $this->Label1->SetValue($this->DataSource->Label1->GetValue());
                $this->estado_novedad->SetValue($this->DataSource->estado_novedad->GetValue());
                $this->reserva->SetValue($this->DataSource->reserva->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->description->Show();
                $this->id->Show();
                $this->predecessor_id->Show();
                $this->image_url->Show();
                $this->corte->Show();
                $this->estado_ticket_inst->Show();
                $this->estado_ticket->Show();
                $this->estado->Show();
                $this->level->Show();
                $this->Label1->Show();
                $this->estado_novedad->Show();
                $this->reserva->Show();
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
        $this->Sorter_description->Show();
        $this->Navigator->Show();
        $this->camera_states_types_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-188E15A8
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->description->Errors->ToString());
        $errors = ComposeStrings($errors, $this->id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->predecessor_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->image_url->Errors->ToString());
        $errors = ComposeStrings($errors, $this->corte->Errors->ToString());
        $errors = ComposeStrings($errors, $this->estado_ticket_inst->Errors->ToString());
        $errors = ComposeStrings($errors, $this->estado_ticket->Errors->ToString());
        $errors = ComposeStrings($errors, $this->estado->Errors->ToString());
        $errors = ComposeStrings($errors, $this->level->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Label1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->estado_novedad->Errors->ToString());
        $errors = ComposeStrings($errors, $this->reserva->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_states_types Class @4-FCB6E20C

class clscamera_states_typesDataSource extends clsDBminseg {  //camera_states_typesDataSource Class @4-8D694C3B

//DataSource Variables @4-6A574899
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $description;
    public $id;
    public $predecessor_id;
    public $image_url;
    public $corte;
    public $estado_ticket_inst;
    public $estado_ticket;
    public $estado;
    public $level;
    public $Label1;
    public $estado_novedad;
    public $reserva;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-6FF72997
    function clscamera_states_typesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_states_types";
        $this->Initialize();
        $this->description = new clsField("description", ccsText, "");
        
        $this->id = new clsField("id", ccsText, "");
        
        $this->predecessor_id = new clsField("predecessor_id", ccsText, "");
        
        $this->image_url = new clsField("image_url", ccsText, "");
        
        $this->corte = new clsField("corte", ccsText, "");
        
        $this->estado_ticket_inst = new clsField("estado_ticket_inst", ccsText, "");
        
        $this->estado_ticket = new clsField("estado_ticket", ccsText, "");
        
        $this->estado = new clsField("estado", ccsText, "");
        
        $this->level = new clsField("level", ccsText, "");
        
        $this->Label1 = new clsField("Label1", ccsText, "");
        
        $this->estado_novedad = new clsField("estado_novedad", ccsText, "");
        
        $this->reserva = new clsField("reserva", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-3B7581E1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_description" => array("description", "")));
    }
//End SetOrder Method

//Prepare Method @4-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @4-A828D051
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM camera_states_types";
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_states_types {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-E399337D
    function SetValues()
    {
        $this->description->SetDBValue($this->f("description"));
        $this->id->SetDBValue($this->f("id"));
        $this->predecessor_id->SetDBValue($this->f("predecessor_id"));
        $this->image_url->SetDBValue($this->f("image_url"));
        $this->corte->SetDBValue($this->f("corte"));
        $this->estado_ticket_inst->SetDBValue($this->f("estado_ticket_inst"));
        $this->estado_ticket->SetDBValue($this->f("estado_ticket"));
        $this->estado->SetDBValue($this->f("estado"));
        $this->level->SetDBValue($this->f("level"));
        $this->Label1->SetDBValue($this->f("image_url"));
        $this->estado_novedad->SetDBValue($this->f("estado_novedad"));
        $this->reserva->SetDBValue($this->f("reserva"));
    }
//End SetValues Method

} //End camera_states_typesDataSource Class @4-FCB6E20C

class clsRecordcamera_states_types1 { //camera_states_types1 Class @14-5CCE29BB

//Variables @14-9E315808

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

//Class_Initialize Event @14-783559F0
    function clsRecordcamera_states_types1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_states_types1/Error";
        $this->DataSource = new clscamera_states_types1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_states_types1";
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
            $this->description = new clsControl(ccsTextBox, "description", "Descripcion", ccsText, "", CCGetRequestParam("description", $Method, NULL), $this);
            $this->description->Required = true;
            $this->predecessor_id = new clsControl(ccsTextBox, "predecessor_id", "predecessor_id", ccsText, "", CCGetRequestParam("predecessor_id", $Method, NULL), $this);
            $this->description_html = new clsControl(ccsTextBox, "description_html", "description_html", ccsText, "", CCGetRequestParam("description_html", $Method, NULL), $this);
            $this->level = new clsControl(ccsTextBox, "level", "level", ccsText, "", CCGetRequestParam("level", $Method, NULL), $this);
            $this->ListBox1 = new clsControl(ccsListBox, "ListBox1", "ListBox1", ccsText, "", CCGetRequestParam("ListBox1", $Method, NULL), $this);
            $this->ListBox1->DSType = dsListOfValues;
            $this->ListBox1->Values = array(array("0", "NO"), array("1", "SI"));
            $this->ListBox2 = new clsControl(ccsListBox, "ListBox2", "ListBox2", ccsText, "", CCGetRequestParam("ListBox2", $Method, NULL), $this);
            $this->ListBox2->DSType = dsListOfValues;
            $this->ListBox2->Values = array(array("0", "NO"), array("1", "SI"));
            $this->ListBox3 = new clsControl(ccsListBox, "ListBox3", "ListBox3", ccsText, "", CCGetRequestParam("ListBox3", $Method, NULL), $this);
            $this->ListBox3->DSType = dsListOfValues;
            $this->ListBox3->Values = array(array("0", "NO"), array("1", "SI"));
            $this->ListBox4 = new clsControl(ccsListBox, "ListBox4", "ListBox4", ccsText, "", CCGetRequestParam("ListBox4", $Method, NULL), $this);
            $this->ListBox4->DSType = dsListOfValues;
            $this->ListBox4->Values = array(array("0", "NO"), array("1", "SI"));
            $this->estado_novedad = new clsControl(ccsListBox, "estado_novedad", "estado_novedad", ccsText, "", CCGetRequestParam("estado_novedad", $Method, NULL), $this);
            $this->estado_novedad->DSType = dsListOfValues;
            $this->estado_novedad->Values = array(array("0", "NO"), array("1", "SI"));
        }
    }
//End Class_Initialize Event

//Initialize Method @14-2832F4DC
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid"] = CCGetFromGet("id", NULL);
    }
//End Initialize Method

//Validate Method @14-4AE6DF0E
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->description->SetValue($this->description->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_states_types", "description=" . $this->DataSource->ToSQL($this->DataSource->description->GetDBValue(), $this->DataSource->description->DataType) . $Where, $this->DataSource) > 0)
            $this->description->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripcion"));
        $Validation = ($this->description->Validate() && $Validation);
        $Validation = ($this->predecessor_id->Validate() && $Validation);
        $Validation = ($this->description_html->Validate() && $Validation);
        $Validation = ($this->level->Validate() && $Validation);
        $Validation = ($this->ListBox1->Validate() && $Validation);
        $Validation = ($this->ListBox2->Validate() && $Validation);
        $Validation = ($this->ListBox3->Validate() && $Validation);
        $Validation = ($this->ListBox4->Validate() && $Validation);
        $Validation = ($this->estado_novedad->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->description->Errors->Count() == 0);
        $Validation =  $Validation && ($this->predecessor_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->description_html->Errors->Count() == 0);
        $Validation =  $Validation && ($this->level->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ListBox1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ListBox2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ListBox3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ListBox4->Errors->Count() == 0);
        $Validation =  $Validation && ($this->estado_novedad->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @14-4751DEDC
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->description->Errors->Count());
        $errors = ($errors || $this->predecessor_id->Errors->Count());
        $errors = ($errors || $this->description_html->Errors->Count());
        $errors = ($errors || $this->level->Errors->Count());
        $errors = ($errors || $this->ListBox1->Errors->Count());
        $errors = ($errors || $this->ListBox2->Errors->Count());
        $errors = ($errors || $this->ListBox3->Errors->Count());
        $errors = ($errors || $this->ListBox4->Errors->Count());
        $errors = ($errors || $this->estado_novedad->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @14-0BF2B389
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

//InsertRow Method @14-27821615
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->description->SetValue($this->description->GetValue(true));
        $this->DataSource->predecessor_id->SetValue($this->predecessor_id->GetValue(true));
        $this->DataSource->description_html->SetValue($this->description_html->GetValue(true));
        $this->DataSource->level->SetValue($this->level->GetValue(true));
        $this->DataSource->ListBox1->SetValue($this->ListBox1->GetValue(true));
        $this->DataSource->ListBox2->SetValue($this->ListBox2->GetValue(true));
        $this->DataSource->ListBox3->SetValue($this->ListBox3->GetValue(true));
        $this->DataSource->ListBox4->SetValue($this->ListBox4->GetValue(true));
        $this->DataSource->estado_novedad->SetValue($this->estado_novedad->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @14-F085A796
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->description->SetValue($this->description->GetValue(true));
        $this->DataSource->predecessor_id->SetValue($this->predecessor_id->GetValue(true));
        $this->DataSource->description_html->SetValue($this->description_html->GetValue(true));
        $this->DataSource->level->SetValue($this->level->GetValue(true));
        $this->DataSource->ListBox1->SetValue($this->ListBox1->GetValue(true));
        $this->DataSource->ListBox2->SetValue($this->ListBox2->GetValue(true));
        $this->DataSource->ListBox3->SetValue($this->ListBox3->GetValue(true));
        $this->DataSource->ListBox4->SetValue($this->ListBox4->GetValue(true));
        $this->DataSource->estado_novedad->SetValue($this->estado_novedad->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @14-D4776D46
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

        $this->ListBox1->Prepare();
        $this->ListBox2->Prepare();
        $this->ListBox3->Prepare();
        $this->ListBox4->Prepare();
        $this->estado_novedad->Prepare();

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
                    $this->description->SetValue($this->DataSource->description->GetValue());
                    $this->predecessor_id->SetValue($this->DataSource->predecessor_id->GetValue());
                    $this->description_html->SetValue($this->DataSource->description_html->GetValue());
                    $this->level->SetValue($this->DataSource->level->GetValue());
                    $this->ListBox1->SetValue($this->DataSource->ListBox1->GetValue());
                    $this->ListBox2->SetValue($this->DataSource->ListBox2->GetValue());
                    $this->ListBox3->SetValue($this->DataSource->ListBox3->GetValue());
                    $this->ListBox4->SetValue($this->DataSource->ListBox4->GetValue());
                    $this->estado_novedad->SetValue($this->DataSource->estado_novedad->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->description->Errors->ToString());
            $Error = ComposeStrings($Error, $this->predecessor_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->description_html->Errors->ToString());
            $Error = ComposeStrings($Error, $this->level->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ListBox1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ListBox2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ListBox3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ListBox4->Errors->ToString());
            $Error = ComposeStrings($Error, $this->estado_novedad->Errors->ToString());
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
        $this->description->Show();
        $this->predecessor_id->Show();
        $this->description_html->Show();
        $this->level->Show();
        $this->ListBox1->Show();
        $this->ListBox2->Show();
        $this->ListBox3->Show();
        $this->ListBox4->Show();
        $this->estado_novedad->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End camera_states_types1 Class @14-FCB6E20C

class clscamera_states_types1DataSource extends clsDBminseg {  //camera_states_types1DataSource Class @14-5F858D24

//DataSource Variables @14-66C9B7D4
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
    public $description;
    public $predecessor_id;
    public $description_html;
    public $level;
    public $ListBox1;
    public $ListBox2;
    public $ListBox3;
    public $ListBox4;
    public $estado_novedad;
//End DataSource Variables

//DataSourceClass_Initialize Event @14-F54D5753
    function clscamera_states_types1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record camera_states_types1/Error";
        $this->Initialize();
        $this->description = new clsField("description", ccsText, "");
        
        $this->predecessor_id = new clsField("predecessor_id", ccsText, "");
        
        $this->description_html = new clsField("description_html", ccsText, "");
        
        $this->level = new clsField("level", ccsText, "");
        
        $this->ListBox1 = new clsField("ListBox1", ccsText, "");
        
        $this->ListBox2 = new clsField("ListBox2", ccsText, "");
        
        $this->ListBox3 = new clsField("ListBox3", ccsText, "");
        
        $this->ListBox4 = new clsField("ListBox4", ccsText, "");
        
        $this->estado_novedad = new clsField("estado_novedad", ccsText, "");
        

        $this->InsertFields["description"] = array("Name" => "description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["predecessor_id"] = array("Name" => "predecessor_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["description_html"] = array("Name" => "description_html", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["level"] = array("Name" => "level", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["estado"] = array("Name" => "estado", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["estado_ticket"] = array("Name" => "estado_ticket", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["estado_ticket_inst"] = array("Name" => "estado_ticket_inst", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["corte"] = array("Name" => "corte", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["estado_novedad"] = array("Name" => "estado_novedad", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["description"] = array("Name" => "description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["predecessor_id"] = array("Name" => "predecessor_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["description_html"] = array("Name" => "description_html", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["level"] = array("Name" => "level", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["estado"] = array("Name" => "estado", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["estado_ticket"] = array("Name" => "estado_ticket", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["estado_ticket_inst"] = array("Name" => "estado_ticket_inst", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["corte"] = array("Name" => "corte", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["estado_novedad"] = array("Name" => "estado_novedad", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @14-35B33087
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

//Open Method @14-33BE9FF3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_states_types {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @14-FF0E8B1D
    function SetValues()
    {
        $this->description->SetDBValue($this->f("description"));
        $this->predecessor_id->SetDBValue($this->f("predecessor_id"));
        $this->description_html->SetDBValue($this->f("description_html"));
        $this->level->SetDBValue($this->f("level"));
        $this->ListBox1->SetDBValue($this->f("estado"));
        $this->ListBox2->SetDBValue($this->f("estado_ticket"));
        $this->ListBox3->SetDBValue($this->f("estado_ticket_inst"));
        $this->ListBox4->SetDBValue($this->f("corte"));
        $this->estado_novedad->SetDBValue($this->f("estado_novedad"));
    }
//End SetValues Method

//Insert Method @14-A4D4D6A8
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["description"]["Value"] = $this->description->GetDBValue(true);
        $this->InsertFields["predecessor_id"]["Value"] = $this->predecessor_id->GetDBValue(true);
        $this->InsertFields["description_html"]["Value"] = $this->description_html->GetDBValue(true);
        $this->InsertFields["level"]["Value"] = $this->level->GetDBValue(true);
        $this->InsertFields["estado"]["Value"] = $this->ListBox1->GetDBValue(true);
        $this->InsertFields["estado_ticket"]["Value"] = $this->ListBox2->GetDBValue(true);
        $this->InsertFields["estado_ticket_inst"]["Value"] = $this->ListBox3->GetDBValue(true);
        $this->InsertFields["corte"]["Value"] = $this->ListBox4->GetDBValue(true);
        $this->InsertFields["estado_novedad"]["Value"] = $this->estado_novedad->GetDBValue(true);
        $this->SQL = CCBuildInsert("camera_states_types", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @14-8007EEC0
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["description"]["Value"] = $this->description->GetDBValue(true);
        $this->UpdateFields["predecessor_id"]["Value"] = $this->predecessor_id->GetDBValue(true);
        $this->UpdateFields["description_html"]["Value"] = $this->description_html->GetDBValue(true);
        $this->UpdateFields["level"]["Value"] = $this->level->GetDBValue(true);
        $this->UpdateFields["estado"]["Value"] = $this->ListBox1->GetDBValue(true);
        $this->UpdateFields["estado_ticket"]["Value"] = $this->ListBox2->GetDBValue(true);
        $this->UpdateFields["estado_ticket_inst"]["Value"] = $this->ListBox3->GetDBValue(true);
        $this->UpdateFields["corte"]["Value"] = $this->ListBox4->GetDBValue(true);
        $this->UpdateFields["estado_novedad"]["Value"] = $this->estado_novedad->GetDBValue(true);
        $this->SQL = CCBuildUpdate("camera_states_types", $this->UpdateFields, $this);
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

} //End camera_states_types1DataSource Class @14-FCB6E20C

//Initialize Page @1-D95F2348
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
$TemplateFileName = "estados_camara.html";
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

//Include events file @1-C4315058
include_once("./estados_camara_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-ACC73066
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
$camera_states_types = new clsGridcamera_states_types("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$Panel2->GenerateDiv = true;
$Panel2->PanelId = "Panel1Panel2";
$camera_states_types1 = new clsRecordcamera_states_types1("", $MainPage);
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$MainPage->mymenu = & $mymenu;
$MainPage->Panel1 = & $Panel1;
$MainPage->camera_states_types = & $camera_states_types;
$MainPage->Panel2 = & $Panel2;
$MainPage->camera_states_types1 = & $camera_states_types1;
$MainPage->app_environment_class = & $app_environment_class;
$Panel1->AddComponent("camera_states_types", $camera_states_types);
$Panel1->AddComponent("Panel2", $Panel2);
$Panel2->AddComponent("camera_states_types1", $camera_states_types1);
$camera_states_types->Initialize();
$camera_states_types1->Initialize();
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

//Execute Components @1-C5E81A59
$camera_states_types1->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-6CCAF79B
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_states_types);
    unset($camera_states_types1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-1B38EC7F
$mymenu->Show();
$Panel1->Show();
$app_environment_class->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$BRDCSI8I1S5E = "<center><font face=\"Arial\"><small>&#71;e&#110;e&#114;&#97;&#116;&#101;d <!-- SCC -->&#119;&#105;th <!-- CCS -->C&#111;&#100;&#101;Ch&#97;&#114;g&#101; <!-- SCC -->S&#116;&#117;&#100;&#105;o.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", $BRDCSI8I1S5E . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", $BRDCSI8I1S5E . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= $BRDCSI8I1S5E;
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-B9F3BEB7
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_states_types);
unset($camera_states_types1);
unset($Tpl);
//End Unload Page


?>
