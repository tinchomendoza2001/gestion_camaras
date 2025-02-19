<?php
//Include Common Files @1-1F85112E
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "monitor_center.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsGridcamera_monitoring_center { //camera_monitoring_center class @4-9914C71E

//Variables @4-935F39DD

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
    public $Sorter_acronym;
    public $Sorter_long_descrip;
    public $Sorter_num_places;
//End Variables

//Class_Initialize Event @4-AC79AB24
    function clsGridcamera_monitoring_center($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_monitoring_center";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_monitoring_center";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_monitoring_centerDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 25;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("camera_monitoring_centerOrder", "");
        $this->SorterDirection = CCGetParam("camera_monitoring_centerDir", "");

        $this->description = new clsControl(ccsLink, "description", "description", ccsText, "", CCGetRequestParam("description", ccsGet, NULL), $this);
        $this->description->Page = "";
        $this->acronym = new clsControl(ccsLabel, "acronym", "acronym", ccsText, "", CCGetRequestParam("acronym", ccsGet, NULL), $this);
        $this->long_descrip = new clsControl(ccsLabel, "long_descrip", "long_descrip", ccsText, "", CCGetRequestParam("long_descrip", ccsGet, NULL), $this);
        $this->num_places = new clsControl(ccsLabel, "num_places", "num_places", ccsText, "", CCGetRequestParam("num_places", ccsGet, NULL), $this);
        $this->type_proyect_descrip = new clsControl(ccsLabel, "type_proyect_descrip", "type_proyect_descrip", ccsText, "", CCGetRequestParam("type_proyect_descrip", ccsGet, NULL), $this);
        $this->camera_zone_descrip = new clsControl(ccsLabel, "camera_zone_descrip", "camera_zone_descrip", ccsText, "", CCGetRequestParam("camera_zone_descrip", ccsGet, NULL), $this);
        $this->proyecto = new clsControl(ccsLabel, "proyecto", "proyecto", ccsText, "", CCGetRequestParam("proyecto", ccsGet, NULL), $this);
        $this->proyecto->HTML = true;
        $this->latitud = new clsControl(ccsLabel, "latitud", "latitud", ccsText, "", CCGetRequestParam("latitud", ccsGet, NULL), $this);
        $this->longitud = new clsControl(ccsLabel, "longitud", "longitud", ccsText, "", CCGetRequestParam("longitud", ccsGet, NULL), $this);
        $this->areas = new clsControl(ccsLabel, "areas", "areas", ccsText, "", CCGetRequestParam("areas", ccsGet, NULL), $this);
        $this->areas->HTML = true;
        $this->Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $this);
        $this->stock = new clsControl(ccsLabel, "stock", "stock", ccsText, "", CCGetRequestParam("stock", ccsGet, NULL), $this);
        $this->stock->HTML = true;
        $this->Sorter_description = new clsSorter($this->ComponentName, "Sorter_description", $FileName, $this);
        $this->Sorter_acronym = new clsSorter($this->ComponentName, "Sorter_acronym", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->camera_monitoring_center_Insert = new clsControl(ccsLink, "camera_monitoring_center_Insert", "camera_monitoring_center_Insert", ccsText, "", CCGetRequestParam("camera_monitoring_center_Insert", ccsGet, NULL), $this);
        $this->camera_monitoring_center_Insert->Parameters = CCGetQueryString("QueryString", array("id", "ccsForm"));
        $this->camera_monitoring_center_Insert->Page = "monitor_center.php";
        $this->Sorter_long_descrip = new clsSorter($this->ComponentName, "Sorter_long_descrip", $FileName, $this);
        $this->Sorter_num_places = new clsSorter($this->ComponentName, "Sorter_num_places", $FileName, $this);
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

//Show Method @4-B7841BB6
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
            $this->ControlsVisible["acronym"] = $this->acronym->Visible;
            $this->ControlsVisible["long_descrip"] = $this->long_descrip->Visible;
            $this->ControlsVisible["num_places"] = $this->num_places->Visible;
            $this->ControlsVisible["type_proyect_descrip"] = $this->type_proyect_descrip->Visible;
            $this->ControlsVisible["camera_zone_descrip"] = $this->camera_zone_descrip->Visible;
            $this->ControlsVisible["proyecto"] = $this->proyecto->Visible;
            $this->ControlsVisible["latitud"] = $this->latitud->Visible;
            $this->ControlsVisible["longitud"] = $this->longitud->Visible;
            $this->ControlsVisible["areas"] = $this->areas->Visible;
            $this->ControlsVisible["Label1"] = $this->Label1->Visible;
            $this->ControlsVisible["stock"] = $this->stock->Visible;
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
                $this->acronym->SetValue($this->DataSource->acronym->GetValue());
                $this->long_descrip->SetValue($this->DataSource->long_descrip->GetValue());
                $this->num_places->SetValue($this->DataSource->num_places->GetValue());
                $this->type_proyect_descrip->SetValue($this->DataSource->type_proyect_descrip->GetValue());
                $this->camera_zone_descrip->SetValue($this->DataSource->camera_zone_descrip->GetValue());
                $this->latitud->SetValue($this->DataSource->latitud->GetValue());
                $this->longitud->SetValue($this->DataSource->longitud->GetValue());
                $this->Label1->SetValue($this->DataSource->Label1->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->description->Show();
                $this->acronym->Show();
                $this->long_descrip->Show();
                $this->num_places->Show();
                $this->type_proyect_descrip->Show();
                $this->camera_zone_descrip->Show();
                $this->proyecto->Show();
                $this->latitud->Show();
                $this->longitud->Show();
                $this->areas->Show();
                $this->Label1->Show();
                $this->stock->Show();
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
        $this->Sorter_acronym->Show();
        $this->Navigator->Show();
        $this->camera_monitoring_center_Insert->Show();
        $this->Sorter_long_descrip->Show();
        $this->Sorter_num_places->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-4E961B74
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->description->Errors->ToString());
        $errors = ComposeStrings($errors, $this->acronym->Errors->ToString());
        $errors = ComposeStrings($errors, $this->long_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->num_places->Errors->ToString());
        $errors = ComposeStrings($errors, $this->type_proyect_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_zone_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->proyecto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->latitud->Errors->ToString());
        $errors = ComposeStrings($errors, $this->longitud->Errors->ToString());
        $errors = ComposeStrings($errors, $this->areas->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Label1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->stock->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_monitoring_center Class @4-FCB6E20C

class clscamera_monitoring_centerDataSource extends clsDBminseg {  //camera_monitoring_centerDataSource Class @4-B2AE1DA1

//DataSource Variables @4-1EC5CC73
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $description;
    public $acronym;
    public $long_descrip;
    public $num_places;
    public $type_proyect_descrip;
    public $camera_zone_descrip;
    public $latitud;
    public $longitud;
    public $Label1;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-2C00A8A6
    function clscamera_monitoring_centerDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_monitoring_center";
        $this->Initialize();
        $this->description = new clsField("description", ccsText, "");
        
        $this->acronym = new clsField("acronym", ccsText, "");
        
        $this->long_descrip = new clsField("long_descrip", ccsText, "");
        
        $this->num_places = new clsField("num_places", ccsText, "");
        
        $this->type_proyect_descrip = new clsField("type_proyect_descrip", ccsText, "");
        
        $this->camera_zone_descrip = new clsField("camera_zone_descrip", ccsText, "");
        
        $this->latitud = new clsField("latitud", ccsText, "");
        
        $this->longitud = new clsField("longitud", ccsText, "");
        
        $this->Label1 = new clsField("Label1", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-5ED98F48
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_description" => array("description", ""), 
            "Sorter_acronym" => array("acronym", ""), 
            "Sorter_long_descrip" => array("long_descrip", ""), 
            "Sorter_num_places" => array("num_places", "")));
    }
//End SetOrder Method

//Prepare Method @4-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @4-277040D2
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ((camera_monitoring_center LEFT JOIN camera_zone ON\n\n" .
        "camera_monitoring_center.camera_zone_id = camera_zone.camera_zone_id) LEFT JOIN camera_type_proyect ON\n\n" .
        "camera_monitoring_center.type_proyect_id = camera_type_proyect.type_proyect_id) LEFT JOIN camera_providers_connexions ON\n\n" .
        "camera_monitoring_center.provider_connexion_id = camera_providers_connexions.id";
        $this->SQL = "SELECT camera_monitoring_center.*, type_proyect_descrip, camera_zone_descrip, camera_providers_connexions.description AS camera_providers_connexions_description \n\n" .
        "FROM ((camera_monitoring_center LEFT JOIN camera_zone ON\n\n" .
        "camera_monitoring_center.camera_zone_id = camera_zone.camera_zone_id) LEFT JOIN camera_type_proyect ON\n\n" .
        "camera_monitoring_center.type_proyect_id = camera_type_proyect.type_proyect_id) LEFT JOIN camera_providers_connexions ON\n\n" .
        "camera_monitoring_center.provider_connexion_id = camera_providers_connexions.id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-95129547
    function SetValues()
    {
        $this->description->SetDBValue($this->f("description"));
        $this->acronym->SetDBValue($this->f("acronym"));
        $this->long_descrip->SetDBValue($this->f("long_descrip"));
        $this->num_places->SetDBValue($this->f("num_places"));
        $this->type_proyect_descrip->SetDBValue($this->f("type_proyect_descrip"));
        $this->camera_zone_descrip->SetDBValue($this->f("camera_zone_descrip"));
        $this->latitud->SetDBValue($this->f("latitud"));
        $this->longitud->SetDBValue($this->f("longitud"));
        $this->Label1->SetDBValue($this->f("camera_providers_connexions_description"));
    }
//End SetValues Method

} //End camera_monitoring_centerDataSource Class @4-FCB6E20C

class clsRecordcamera_monitoring_center1 { //camera_monitoring_center1 Class @17-0C60D80D

//Variables @17-9E315808

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

//Class_Initialize Event @17-91660298
    function clsRecordcamera_monitoring_center1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_monitoring_center1/Error";
        $this->DataSource = new clscamera_monitoring_center1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_monitoring_center1";
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
            $this->acronym = new clsControl(ccsTextBox, "acronym", "Siglas", ccsText, "", CCGetRequestParam("acronym", $Method, NULL), $this);
            $this->acronym->Required = true;
            $this->long_descrip = new clsControl(ccsTextBox, "long_descrip", "long_descrip", ccsText, "", CCGetRequestParam("long_descrip", $Method, NULL), $this);
            $this->long_descrip->Required = true;
            $this->num_places = new clsControl(ccsTextBox, "num_places", "num_places", ccsText, "", CCGetRequestParam("num_places", $Method, NULL), $this);
            $this->type_proyect_id = new clsControl(ccsListBox, "type_proyect_id", "type_proyect_id", ccsText, "", CCGetRequestParam("type_proyect_id", $Method, NULL), $this);
            $this->type_proyect_id->DSType = dsTable;
            $this->type_proyect_id->DataSource = new clsDBminseg();
            $this->type_proyect_id->ds = & $this->type_proyect_id->DataSource;
            $this->type_proyect_id->DataSource->SQL = "SELECT * \n" .
"FROM camera_type_proyect {SQL_Where} {SQL_OrderBy}";
            list($this->type_proyect_id->BoundColumn, $this->type_proyect_id->TextColumn, $this->type_proyect_id->DBFormat) = array("type_proyect_id", "type_proyect_descrip", "");
            $this->camera_zone_id = new clsControl(ccsListBox, "camera_zone_id", "camera_zone_id", ccsText, "", CCGetRequestParam("camera_zone_id", $Method, NULL), $this);
            $this->camera_zone_id->DSType = dsTable;
            $this->camera_zone_id->DataSource = new clsDBminseg();
            $this->camera_zone_id->ds = & $this->camera_zone_id->DataSource;
            $this->camera_zone_id->DataSource->SQL = "SELECT * \n" .
"FROM camera_zone {SQL_Where} {SQL_OrderBy}";
            list($this->camera_zone_id->BoundColumn, $this->camera_zone_id->TextColumn, $this->camera_zone_id->DBFormat) = array("camera_zone_id", "camera_zone_descrip", "");
            $this->longitud = new clsControl(ccsTextBox, "longitud", "longitud", ccsText, "", CCGetRequestParam("longitud", $Method, NULL), $this);
            $this->latitud = new clsControl(ccsTextBox, "latitud", "latitud", ccsText, "", CCGetRequestParam("latitud", $Method, NULL), $this);
            $this->coordendas = new clsControl(ccsTextBox, "coordendas", "coordendas", ccsText, "", CCGetRequestParam("coordendas", $Method, NULL), $this);
            $this->CheckBoxList2 = new clsControl(ccsCheckBoxList, "CheckBoxList2", "CheckBoxList2", ccsText, "", CCGetRequestParam("CheckBoxList2", $Method, NULL), $this);
            $this->CheckBoxList2->Multiple = true;
            $this->CheckBoxList2->DSType = dsTable;
            $this->CheckBoxList2->DataSource = new clsDBminseg();
            $this->CheckBoxList2->ds = & $this->CheckBoxList2->DataSource;
            $this->CheckBoxList2->DataSource->SQL = "SELECT * \n" .
"FROM areas {SQL_Where} {SQL_OrderBy}";
            list($this->CheckBoxList2->BoundColumn, $this->CheckBoxList2->TextColumn, $this->CheckBoxList2->DBFormat) = array("area_id", "areas_descript", "");
            $this->CheckBoxList2->HTML = true;
            $this->CheckBoxList1 = new clsControl(ccsCheckBoxList, "CheckBoxList1", "CheckBoxList1", ccsText, "", CCGetRequestParam("CheckBoxList1", $Method, NULL), $this);
            $this->CheckBoxList1->Multiple = true;
            $this->CheckBoxList1->DSType = dsTable;
            $this->CheckBoxList1->DataSource = new clsDBminseg();
            $this->CheckBoxList1->ds = & $this->CheckBoxList1->DataSource;
            $this->CheckBoxList1->DataSource->SQL = "SELECT * \n" .
"FROM camera_projects {SQL_Where} {SQL_OrderBy}";
            list($this->CheckBoxList1->BoundColumn, $this->CheckBoxList1->TextColumn, $this->CheckBoxList1->DBFormat) = array("camera_project_id", "camera_project_descrip", "");
            $this->CheckBoxList1->HTML = true;
            $this->provider_connexion_id = new clsControl(ccsListBox, "provider_connexion_id", "provider_connexion_id", ccsText, "", CCGetRequestParam("provider_connexion_id", $Method, NULL), $this);
            $this->provider_connexion_id->DSType = dsTable;
            $this->provider_connexion_id->DataSource = new clsDBminseg();
            $this->provider_connexion_id->ds = & $this->provider_connexion_id->DataSource;
            $this->provider_connexion_id->DataSource->SQL = "SELECT * \n" .
"FROM camera_providers_connexions {SQL_Where} {SQL_OrderBy}";
            list($this->provider_connexion_id->BoundColumn, $this->provider_connexion_id->TextColumn, $this->provider_connexion_id->DBFormat) = array("id", "description", "");
            $this->stock = new clsControl(ccsListBox, "stock", "stock", ccsText, "", CCGetRequestParam("stock", $Method, NULL), $this);
            $this->stock->DSType = dsListOfValues;
            $this->stock->Values = array(array("0", "NO"), array("1", "SI"));
        }
    }
//End Class_Initialize Event

//Initialize Method @17-2832F4DC
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid"] = CCGetFromGet("id", NULL);
    }
//End Initialize Method

//Validate Method @17-91D361F0
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->description->SetValue($this->description->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_monitoring_center", "description=" . $this->DataSource->ToSQL($this->DataSource->description->GetDBValue(), $this->DataSource->description->DataType) . $Where, $this->DataSource) > 0)
            $this->description->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Descripcion"));
        $this->DataSource->acronym->SetValue($this->acronym->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_monitoring_center", "acronym=" . $this->DataSource->ToSQL($this->DataSource->acronym->GetDBValue(), $this->DataSource->acronym->DataType) . $Where, $this->DataSource) > 0)
            $this->acronym->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Siglas"));
        $this->DataSource->long_descrip->SetValue($this->long_descrip->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_monitoring_center", "long_descrip=" . $this->DataSource->ToSQL($this->DataSource->long_descrip->GetDBValue(), $this->DataSource->long_descrip->DataType) . $Where, $this->DataSource) > 0)
            $this->long_descrip->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "long_descrip"));
        $Validation = ($this->description->Validate() && $Validation);
        $Validation = ($this->acronym->Validate() && $Validation);
        $Validation = ($this->long_descrip->Validate() && $Validation);
        $Validation = ($this->num_places->Validate() && $Validation);
        $Validation = ($this->type_proyect_id->Validate() && $Validation);
        $Validation = ($this->camera_zone_id->Validate() && $Validation);
        $Validation = ($this->longitud->Validate() && $Validation);
        $Validation = ($this->latitud->Validate() && $Validation);
        $Validation = ($this->coordendas->Validate() && $Validation);
        $Validation = ($this->CheckBoxList2->Validate() && $Validation);
        $Validation = ($this->CheckBoxList1->Validate() && $Validation);
        $Validation = ($this->provider_connexion_id->Validate() && $Validation);
        $Validation = ($this->stock->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->description->Errors->Count() == 0);
        $Validation =  $Validation && ($this->acronym->Errors->Count() == 0);
        $Validation =  $Validation && ($this->long_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->num_places->Errors->Count() == 0);
        $Validation =  $Validation && ($this->type_proyect_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->camera_zone_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->longitud->Errors->Count() == 0);
        $Validation =  $Validation && ($this->latitud->Errors->Count() == 0);
        $Validation =  $Validation && ($this->coordendas->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBoxList2->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBoxList1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->provider_connexion_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->stock->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @17-20742342
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->description->Errors->Count());
        $errors = ($errors || $this->acronym->Errors->Count());
        $errors = ($errors || $this->long_descrip->Errors->Count());
        $errors = ($errors || $this->num_places->Errors->Count());
        $errors = ($errors || $this->type_proyect_id->Errors->Count());
        $errors = ($errors || $this->camera_zone_id->Errors->Count());
        $errors = ($errors || $this->longitud->Errors->Count());
        $errors = ($errors || $this->latitud->Errors->Count());
        $errors = ($errors || $this->coordendas->Errors->Count());
        $errors = ($errors || $this->CheckBoxList2->Errors->Count());
        $errors = ($errors || $this->CheckBoxList1->Errors->Count());
        $errors = ($errors || $this->provider_connexion_id->Errors->Count());
        $errors = ($errors || $this->stock->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @17-0BF2B389
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

//InsertRow Method @17-CA4332C2
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->description->SetValue($this->description->GetValue(true));
        $this->DataSource->acronym->SetValue($this->acronym->GetValue(true));
        $this->DataSource->long_descrip->SetValue($this->long_descrip->GetValue(true));
        $this->DataSource->num_places->SetValue($this->num_places->GetValue(true));
        $this->DataSource->type_proyect_id->SetValue($this->type_proyect_id->GetValue(true));
        $this->DataSource->camera_zone_id->SetValue($this->camera_zone_id->GetValue(true));
        $this->DataSource->longitud->SetValue($this->longitud->GetValue(true));
        $this->DataSource->latitud->SetValue($this->latitud->GetValue(true));
        $this->DataSource->coordendas->SetValue($this->coordendas->GetValue(true));
        $this->DataSource->CheckBoxList2->SetValue($this->CheckBoxList2->GetValue(true));
        $this->DataSource->CheckBoxList1->SetValue($this->CheckBoxList1->GetValue(true));
        $this->DataSource->provider_connexion_id->SetValue($this->provider_connexion_id->GetValue(true));
        $this->DataSource->stock->SetValue($this->stock->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @17-391D28D0
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->description->SetValue($this->description->GetValue(true));
        $this->DataSource->acronym->SetValue($this->acronym->GetValue(true));
        $this->DataSource->long_descrip->SetValue($this->long_descrip->GetValue(true));
        $this->DataSource->num_places->SetValue($this->num_places->GetValue(true));
        $this->DataSource->type_proyect_id->SetValue($this->type_proyect_id->GetValue(true));
        $this->DataSource->camera_zone_id->SetValue($this->camera_zone_id->GetValue(true));
        $this->DataSource->longitud->SetValue($this->longitud->GetValue(true));
        $this->DataSource->latitud->SetValue($this->latitud->GetValue(true));
        $this->DataSource->coordendas->SetValue($this->coordendas->GetValue(true));
        $this->DataSource->CheckBoxList2->SetValue($this->CheckBoxList2->GetValue(true));
        $this->DataSource->CheckBoxList1->SetValue($this->CheckBoxList1->GetValue(true));
        $this->DataSource->provider_connexion_id->SetValue($this->provider_connexion_id->GetValue(true));
        $this->DataSource->stock->SetValue($this->stock->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @17-BCD297EA
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

        $this->type_proyect_id->Prepare();
        $this->camera_zone_id->Prepare();
        $this->CheckBoxList2->Prepare();
        $this->CheckBoxList1->Prepare();
        $this->provider_connexion_id->Prepare();
        $this->stock->Prepare();

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
                    $this->acronym->SetValue($this->DataSource->acronym->GetValue());
                    $this->long_descrip->SetValue($this->DataSource->long_descrip->GetValue());
                    $this->num_places->SetValue($this->DataSource->num_places->GetValue());
                    $this->type_proyect_id->SetValue($this->DataSource->type_proyect_id->GetValue());
                    $this->camera_zone_id->SetValue($this->DataSource->camera_zone_id->GetValue());
                    $this->longitud->SetValue($this->DataSource->longitud->GetValue());
                    $this->latitud->SetValue($this->DataSource->latitud->GetValue());
                    $this->provider_connexion_id->SetValue($this->DataSource->provider_connexion_id->GetValue());
                    $this->stock->SetValue($this->DataSource->stock->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->description->Errors->ToString());
            $Error = ComposeStrings($Error, $this->acronym->Errors->ToString());
            $Error = ComposeStrings($Error, $this->long_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->num_places->Errors->ToString());
            $Error = ComposeStrings($Error, $this->type_proyect_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->camera_zone_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->longitud->Errors->ToString());
            $Error = ComposeStrings($Error, $this->latitud->Errors->ToString());
            $Error = ComposeStrings($Error, $this->coordendas->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBoxList2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBoxList1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->provider_connexion_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->stock->Errors->ToString());
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
        $this->acronym->Show();
        $this->long_descrip->Show();
        $this->num_places->Show();
        $this->type_proyect_id->Show();
        $this->camera_zone_id->Show();
        $this->longitud->Show();
        $this->latitud->Show();
        $this->coordendas->Show();
        $this->CheckBoxList2->Show();
        $this->CheckBoxList1->Show();
        $this->provider_connexion_id->Show();
        $this->stock->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End camera_monitoring_center1 Class @17-FCB6E20C

class clscamera_monitoring_center1DataSource extends clsDBminseg {  //camera_monitoring_center1DataSource Class @17-4F60302F

//DataSource Variables @17-FE3C1DB2
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
    public $acronym;
    public $long_descrip;
    public $num_places;
    public $type_proyect_id;
    public $camera_zone_id;
    public $longitud;
    public $latitud;
    public $coordendas;
    public $CheckBoxList2;
    public $CheckBoxList1;
    public $provider_connexion_id;
    public $stock;
//End DataSource Variables

//DataSourceClass_Initialize Event @17-B3E7A77E
    function clscamera_monitoring_center1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record camera_monitoring_center1/Error";
        $this->Initialize();
        $this->description = new clsField("description", ccsText, "");
        
        $this->acronym = new clsField("acronym", ccsText, "");
        
        $this->long_descrip = new clsField("long_descrip", ccsText, "");
        
        $this->num_places = new clsField("num_places", ccsText, "");
        
        $this->type_proyect_id = new clsField("type_proyect_id", ccsText, "");
        
        $this->camera_zone_id = new clsField("camera_zone_id", ccsText, "");
        
        $this->longitud = new clsField("longitud", ccsText, "");
        
        $this->latitud = new clsField("latitud", ccsText, "");
        
        $this->coordendas = new clsField("coordendas", ccsText, "");
        
        $this->CheckBoxList2 = new clsField("CheckBoxList2", ccsText, "");
        
        $this->CheckBoxList1 = new clsField("CheckBoxList1", ccsText, "");
        
        $this->provider_connexion_id = new clsField("provider_connexion_id", ccsText, "");
        
        $this->stock = new clsField("stock", ccsText, "");
        

        $this->InsertFields["description"] = array("Name" => "description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["acronym"] = array("Name" => "acronym", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["long_descrip"] = array("Name" => "long_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["num_places"] = array("Name" => "num_places", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["type_proyect_id"] = array("Name" => "type_proyect_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["camera_zone_id"] = array("Name" => "camera_zone_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["longitud"] = array("Name" => "longitud", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["latitud"] = array("Name" => "latitud", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["provider_connexion_id"] = array("Name" => "provider_connexion_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["stock"] = array("Name" => "stock", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["description"] = array("Name" => "description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["acronym"] = array("Name" => "acronym", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["long_descrip"] = array("Name" => "long_descrip", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["num_places"] = array("Name" => "num_places", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["type_proyect_id"] = array("Name" => "type_proyect_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["camera_zone_id"] = array("Name" => "camera_zone_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["longitud"] = array("Name" => "longitud", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["latitud"] = array("Name" => "latitud", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["provider_connexion_id"] = array("Name" => "provider_connexion_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["stock"] = array("Name" => "stock", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @17-35B33087
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

//Open Method @17-0EA51370
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_monitoring_center {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @17-79217212
    function SetValues()
    {
        $this->description->SetDBValue($this->f("description"));
        $this->acronym->SetDBValue($this->f("acronym"));
        $this->long_descrip->SetDBValue($this->f("long_descrip"));
        $this->num_places->SetDBValue($this->f("num_places"));
        $this->type_proyect_id->SetDBValue($this->f("type_proyect_id"));
        $this->camera_zone_id->SetDBValue($this->f("camera_zone_id"));
        $this->longitud->SetDBValue($this->f("longitud"));
        $this->latitud->SetDBValue($this->f("latitud"));
        $this->provider_connexion_id->SetDBValue($this->f("provider_connexion_id"));
        $this->stock->SetDBValue($this->f("stock"));
    }
//End SetValues Method

//Insert Method @17-F668438F
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["description"]["Value"] = $this->description->GetDBValue(true);
        $this->InsertFields["acronym"]["Value"] = $this->acronym->GetDBValue(true);
        $this->InsertFields["long_descrip"]["Value"] = $this->long_descrip->GetDBValue(true);
        $this->InsertFields["num_places"]["Value"] = $this->num_places->GetDBValue(true);
        $this->InsertFields["type_proyect_id"]["Value"] = $this->type_proyect_id->GetDBValue(true);
        $this->InsertFields["camera_zone_id"]["Value"] = $this->camera_zone_id->GetDBValue(true);
        $this->InsertFields["longitud"]["Value"] = $this->longitud->GetDBValue(true);
        $this->InsertFields["latitud"]["Value"] = $this->latitud->GetDBValue(true);
        $this->InsertFields["provider_connexion_id"]["Value"] = $this->provider_connexion_id->GetDBValue(true);
        $this->InsertFields["stock"]["Value"] = $this->stock->GetDBValue(true);
        $this->SQL = CCBuildInsert("camera_monitoring_center", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @17-D3DA3C8E
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["description"]["Value"] = $this->description->GetDBValue(true);
        $this->UpdateFields["acronym"]["Value"] = $this->acronym->GetDBValue(true);
        $this->UpdateFields["long_descrip"]["Value"] = $this->long_descrip->GetDBValue(true);
        $this->UpdateFields["num_places"]["Value"] = $this->num_places->GetDBValue(true);
        $this->UpdateFields["type_proyect_id"]["Value"] = $this->type_proyect_id->GetDBValue(true);
        $this->UpdateFields["camera_zone_id"]["Value"] = $this->camera_zone_id->GetDBValue(true);
        $this->UpdateFields["longitud"]["Value"] = $this->longitud->GetDBValue(true);
        $this->UpdateFields["latitud"]["Value"] = $this->latitud->GetDBValue(true);
        $this->UpdateFields["provider_connexion_id"]["Value"] = $this->provider_connexion_id->GetDBValue(true);
        $this->UpdateFields["stock"]["Value"] = $this->stock->GetDBValue(true);
        $this->SQL = CCBuildUpdate("camera_monitoring_center", $this->UpdateFields, $this);
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

} //End camera_monitoring_center1DataSource Class @17-FCB6E20C

//Initialize Page @1-1FE35291
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
$TemplateFileName = "monitor_center.html";
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

//Include events file @1-34808D67
include_once("./monitor_center_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-97EBD9BE
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
$camera_monitoring_center = new clsGridcamera_monitoring_center("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$Panel2->GenerateDiv = true;
$Panel2->PanelId = "Panel1Panel2";
$camera_monitoring_center1 = new clsRecordcamera_monitoring_center1("", $MainPage);
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$MainPage->mymenu = & $mymenu;
$MainPage->Panel1 = & $Panel1;
$MainPage->camera_monitoring_center = & $camera_monitoring_center;
$MainPage->Panel2 = & $Panel2;
$MainPage->camera_monitoring_center1 = & $camera_monitoring_center1;
$MainPage->app_environment_class = & $app_environment_class;
$Panel1->AddComponent("camera_monitoring_center", $camera_monitoring_center);
$Panel1->AddComponent("Panel2", $Panel2);
$Panel2->AddComponent("camera_monitoring_center1", $camera_monitoring_center1);
$camera_monitoring_center->Initialize();
$camera_monitoring_center1->Initialize();
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

//Execute Components @1-2FD9003F
$camera_monitoring_center1->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-F2387BBC
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_monitoring_center);
    unset($camera_monitoring_center1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-7A892DBD
$mymenu->Show();
$Panel1->Show();
$app_environment_class->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$KCNBJ2B4P4G5O = "<center><font face=\"Arial\"><small>G&#101;&#110;e&#114;a&#116;e&#100; <!-- CCS -->w&#105;&#116;h <!-- CCS -->&#67;&#111;d&#101;C&#104;a&#114;g&#101; <!-- SCC -->St&#117;&#100;io.</small></font></center>";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", $KCNBJ2B4P4G5O . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", $KCNBJ2B4P4G5O . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= $KCNBJ2B4P4G5O;
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-DBB288D4
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_monitoring_center);
unset($camera_monitoring_center1);
unset($Tpl);
//End Unload Page


?>
