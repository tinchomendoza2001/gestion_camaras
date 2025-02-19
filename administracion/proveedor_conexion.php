<?php
//Include Common Files @1-846F418A
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "proveedor_conexion.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsGridcamera_providers_connexio { //camera_providers_connexio class @4-F82668A5

//Variables @4-044ABAFF

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
    public $Sorter_location;
    public $Sorter_phone;
    public $Sorter_email;
    public $Sorter_person_responsible;
    public $Sorter_cellphone;
    public $Sorter_person_mail;
//End Variables

//Class_Initialize Event @4-04F214E0
    function clsGridcamera_providers_connexio($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_providers_connexio";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_providers_connexio";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_providers_connexioDataSource($this);
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
        $this->SorterName = CCGetParam("camera_providers_connexioOrder", "");
        $this->SorterDirection = CCGetParam("camera_providers_connexioDir", "");

        $this->description = new clsControl(ccsLink, "description", "description", ccsText, "", CCGetRequestParam("description", ccsGet, NULL), $this);
        $this->description->Page = "";
        $this->location = new clsControl(ccsLabel, "location", "location", ccsText, "", CCGetRequestParam("location", ccsGet, NULL), $this);
        $this->phone = new clsControl(ccsLabel, "phone", "phone", ccsText, "", CCGetRequestParam("phone", ccsGet, NULL), $this);
        $this->email = new clsControl(ccsLabel, "email", "email", ccsText, "", CCGetRequestParam("email", ccsGet, NULL), $this);
        $this->person_responsible = new clsControl(ccsLabel, "person_responsible", "person_responsible", ccsText, "", CCGetRequestParam("person_responsible", ccsGet, NULL), $this);
        $this->cellphone = new clsControl(ccsLabel, "cellphone", "cellphone", ccsText, "", CCGetRequestParam("cellphone", ccsGet, NULL), $this);
        $this->person_mail = new clsControl(ccsLabel, "person_mail", "person_mail", ccsText, "", CCGetRequestParam("person_mail", ccsGet, NULL), $this);
        $this->proyectos = new clsControl(ccsLabel, "proyectos", "proyectos", ccsText, "", CCGetRequestParam("proyectos", ccsGet, NULL), $this);
        $this->proyectos->HTML = true;
        $this->personal = new clsControl(ccsLabel, "personal", "personal", ccsText, "", CCGetRequestParam("personal", ccsGet, NULL), $this);
        $this->personal->HTML = true;
        $this->correos = new clsControl(ccsLabel, "correos", "correos", ccsText, "", CCGetRequestParam("correos", ccsGet, NULL), $this);
        $this->correos->HTML = true;
        $this->cm_asociados = new clsControl(ccsLabel, "cm_asociados", "cm_asociados", ccsText, "", CCGetRequestParam("cm_asociados", ccsGet, NULL), $this);
        $this->cm_asociados->HTML = true;
        $this->host_remoto = new clsControl(ccsLabel, "host_remoto", "host_remoto", ccsText, "", CCGetRequestParam("host_remoto", ccsGet, NULL), $this);
        $this->webservice = new clsControl(ccsLabel, "webservice", "webservice", ccsText, "", CCGetRequestParam("webservice", ccsGet, NULL), $this);
        $this->Sorter_description = new clsSorter($this->ComponentName, "Sorter_description", $FileName, $this);
        $this->Sorter_location = new clsSorter($this->ComponentName, "Sorter_location", $FileName, $this);
        $this->Sorter_phone = new clsSorter($this->ComponentName, "Sorter_phone", $FileName, $this);
        $this->Sorter_email = new clsSorter($this->ComponentName, "Sorter_email", $FileName, $this);
        $this->Sorter_person_responsible = new clsSorter($this->ComponentName, "Sorter_person_responsible", $FileName, $this);
        $this->Sorter_cellphone = new clsSorter($this->ComponentName, "Sorter_cellphone", $FileName, $this);
        $this->Sorter_person_mail = new clsSorter($this->ComponentName, "Sorter_person_mail", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->camera_providers_connexio_Insert = new clsControl(ccsLink, "camera_providers_connexio_Insert", "camera_providers_connexio_Insert", ccsText, "", CCGetRequestParam("camera_providers_connexio_Insert", ccsGet, NULL), $this);
        $this->camera_providers_connexio_Insert->Parameters = CCGetQueryString("QueryString", array("id", "ccsForm"));
        $this->camera_providers_connexio_Insert->Page = "proveedor_conexion.php";
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

//Show Method @4-2D93084B
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
            $this->ControlsVisible["location"] = $this->location->Visible;
            $this->ControlsVisible["phone"] = $this->phone->Visible;
            $this->ControlsVisible["email"] = $this->email->Visible;
            $this->ControlsVisible["person_responsible"] = $this->person_responsible->Visible;
            $this->ControlsVisible["cellphone"] = $this->cellphone->Visible;
            $this->ControlsVisible["person_mail"] = $this->person_mail->Visible;
            $this->ControlsVisible["proyectos"] = $this->proyectos->Visible;
            $this->ControlsVisible["personal"] = $this->personal->Visible;
            $this->ControlsVisible["correos"] = $this->correos->Visible;
            $this->ControlsVisible["cm_asociados"] = $this->cm_asociados->Visible;
            $this->ControlsVisible["host_remoto"] = $this->host_remoto->Visible;
            $this->ControlsVisible["webservice"] = $this->webservice->Visible;
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
                $this->location->SetValue($this->DataSource->location->GetValue());
                $this->phone->SetValue($this->DataSource->phone->GetValue());
                $this->email->SetValue($this->DataSource->email->GetValue());
                $this->person_responsible->SetValue($this->DataSource->person_responsible->GetValue());
                $this->cellphone->SetValue($this->DataSource->cellphone->GetValue());
                $this->person_mail->SetValue($this->DataSource->person_mail->GetValue());
                $this->host_remoto->SetValue($this->DataSource->host_remoto->GetValue());
                $this->webservice->SetValue($this->DataSource->webservice->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->description->Show();
                $this->location->Show();
                $this->phone->Show();
                $this->email->Show();
                $this->person_responsible->Show();
                $this->cellphone->Show();
                $this->person_mail->Show();
                $this->proyectos->Show();
                $this->personal->Show();
                $this->correos->Show();
                $this->cm_asociados->Show();
                $this->host_remoto->Show();
                $this->webservice->Show();
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
        $this->Sorter_location->Show();
        $this->Sorter_phone->Show();
        $this->Sorter_email->Show();
        $this->Sorter_person_responsible->Show();
        $this->Sorter_cellphone->Show();
        $this->Sorter_person_mail->Show();
        $this->Navigator->Show();
        $this->camera_providers_connexio_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @4-3C323AE2
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->description->Errors->ToString());
        $errors = ComposeStrings($errors, $this->location->Errors->ToString());
        $errors = ComposeStrings($errors, $this->phone->Errors->ToString());
        $errors = ComposeStrings($errors, $this->email->Errors->ToString());
        $errors = ComposeStrings($errors, $this->person_responsible->Errors->ToString());
        $errors = ComposeStrings($errors, $this->cellphone->Errors->ToString());
        $errors = ComposeStrings($errors, $this->person_mail->Errors->ToString());
        $errors = ComposeStrings($errors, $this->proyectos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->personal->Errors->ToString());
        $errors = ComposeStrings($errors, $this->correos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->cm_asociados->Errors->ToString());
        $errors = ComposeStrings($errors, $this->host_remoto->Errors->ToString());
        $errors = ComposeStrings($errors, $this->webservice->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_providers_connexio Class @4-FCB6E20C

class clscamera_providers_connexioDataSource extends clsDBminseg {  //camera_providers_connexioDataSource Class @4-9BC1E535

//DataSource Variables @4-135E8C10
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $description;
    public $location;
    public $phone;
    public $email;
    public $person_responsible;
    public $cellphone;
    public $person_mail;
    public $host_remoto;
    public $webservice;
//End DataSource Variables

//DataSourceClass_Initialize Event @4-8C5E2728
    function clscamera_providers_connexioDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_providers_connexio";
        $this->Initialize();
        $this->description = new clsField("description", ccsText, "");
        
        $this->location = new clsField("location", ccsText, "");
        
        $this->phone = new clsField("phone", ccsText, "");
        
        $this->email = new clsField("email", ccsText, "");
        
        $this->person_responsible = new clsField("person_responsible", ccsText, "");
        
        $this->cellphone = new clsField("cellphone", ccsText, "");
        
        $this->person_mail = new clsField("person_mail", ccsText, "");
        
        $this->host_remoto = new clsField("host_remoto", ccsText, "");
        
        $this->webservice = new clsField("webservice", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @4-2D26A102
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_description" => array("description", ""), 
            "Sorter_location" => array("location", ""), 
            "Sorter_phone" => array("phone", ""), 
            "Sorter_email" => array("email", ""), 
            "Sorter_person_responsible" => array("person_responsible", ""), 
            "Sorter_cellphone" => array("cellphone", ""), 
            "Sorter_person_mail" => array("person_mail", "")));
    }
//End SetOrder Method

//Prepare Method @4-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @4-0F282A7C
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM camera_providers_connexions";
        $this->SQL = "SELECT id, description, location, phone, email, person_responsible, cellphone, person_mail, host_remoto, webservice \n\n" .
        "FROM camera_providers_connexions {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @4-05051769
    function SetValues()
    {
        $this->description->SetDBValue($this->f("description"));
        $this->location->SetDBValue($this->f("location"));
        $this->phone->SetDBValue($this->f("phone"));
        $this->email->SetDBValue($this->f("email"));
        $this->person_responsible->SetDBValue($this->f("person_responsible"));
        $this->cellphone->SetDBValue($this->f("cellphone"));
        $this->person_mail->SetDBValue($this->f("person_mail"));
        $this->host_remoto->SetDBValue($this->f("host_remoto"));
        $this->webservice->SetDBValue($this->f("webservice"));
    }
//End SetValues Method

} //End camera_providers_connexioDataSource Class @4-FCB6E20C

class clsRecordcamera_providers_connexio1 { //camera_providers_connexio1 Class @32-34E6295D

//Variables @32-9E315808

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

//Class_Initialize Event @32-93C06422
    function clsRecordcamera_providers_connexio1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_providers_connexio1/Error";
        $this->DataSource = new clscamera_providers_connexio1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_providers_connexio1";
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
            $this->description = new clsControl(ccsTextBox, "description", "Nombre de la Empresa", ccsText, "", CCGetRequestParam("description", $Method, NULL), $this);
            $this->description->Required = true;
            $this->location = new clsControl(ccsTextBox, "location", "Location", ccsText, "", CCGetRequestParam("location", $Method, NULL), $this);
            $this->location->Required = true;
            $this->phone = new clsControl(ccsTextBox, "phone", "Telefono Empresa", ccsText, "", CCGetRequestParam("phone", $Method, NULL), $this);
            $this->phone->Required = true;
            $this->email = new clsControl(ccsTextBox, "email", "Email", ccsText, "", CCGetRequestParam("email", $Method, NULL), $this);
            $this->person_responsible = new clsControl(ccsTextBox, "person_responsible", "Person Responsible", ccsText, "", CCGetRequestParam("person_responsible", $Method, NULL), $this);
            $this->cellphone = new clsControl(ccsTextBox, "cellphone", "telefono persona responsable", ccsText, "", CCGetRequestParam("cellphone", $Method, NULL), $this);
            $this->person_mail = new clsControl(ccsTextBox, "person_mail", "e-mail persona responsable", ccsText, "", CCGetRequestParam("person_mail", $Method, NULL), $this);
            $this->CheckBoxList1 = new clsControl(ccsCheckBoxList, "CheckBoxList1", "CheckBoxList1", ccsText, "", CCGetRequestParam("CheckBoxList1", $Method, NULL), $this);
            $this->CheckBoxList1->Multiple = true;
            $this->CheckBoxList1->DSType = dsTable;
            $this->CheckBoxList1->DataSource = new clsDBminseg();
            $this->CheckBoxList1->ds = & $this->CheckBoxList1->DataSource;
            $this->CheckBoxList1->DataSource->SQL = "SELECT * \n" .
"FROM camera_projects {SQL_Where} {SQL_OrderBy}";
            list($this->CheckBoxList1->BoundColumn, $this->CheckBoxList1->TextColumn, $this->CheckBoxList1->DBFormat) = array("camera_project_id", "camera_project_descrip", "");
            $this->CheckBoxList1->HTML = true;
            $this->lista_correos = new clsControl(ccsLabel, "lista_correos", "lista_correos", ccsText, "", CCGetRequestParam("lista_correos", $Method, NULL), $this);
            $this->lista_correos->HTML = true;
            $this->Link1 = new clsControl(ccsLink, "Link1", "Link1", ccsText, "", CCGetRequestParam("Link1", $Method, NULL), $this);
            $this->Link1->Page = "";
            $this->CheckBoxList3 = new clsControl(ccsCheckBoxList, "CheckBoxList3", "CheckBoxList3", ccsText, "", CCGetRequestParam("CheckBoxList3", $Method, NULL), $this);
            $this->CheckBoxList3->Multiple = true;
            $this->CheckBoxList3->DSType = dsTable;
            $this->CheckBoxList3->DataSource = new clsDBminseg();
            $this->CheckBoxList3->ds = & $this->CheckBoxList3->DataSource;
            $this->CheckBoxList3->DataSource->SQL = "SELECT * \n" .
"FROM camera_monitoring_center {SQL_Where} {SQL_OrderBy}";
            list($this->CheckBoxList3->BoundColumn, $this->CheckBoxList3->TextColumn, $this->CheckBoxList3->DBFormat) = array("id", "long_descrip", "");
            $this->CheckBoxList3->DataSource->wp = new clsSQLParameters();
            $this->CheckBoxList3->DataSource->wp->Criterion[1] = "( NOT ISNULL(long_descrip) )";
            $this->CheckBoxList3->DataSource->Where = 
                 $this->CheckBoxList3->DataSource->wp->Criterion[1];
            $this->CheckBoxList3->HTML = true;
            $this->host_remoto = new clsControl(ccsTextBox, "host_remoto", "host_remoto", ccsText, "", CCGetRequestParam("host_remoto", $Method, NULL), $this);
            $this->TextBox2 = new clsControl(ccsListBox, "TextBox2", "TextBox2", ccsText, "", CCGetRequestParam("TextBox2", $Method, NULL), $this);
            $this->TextBox2->DSType = dsListOfValues;
            $this->TextBox2->Values = array(array("0", "NO"), array("1", "SI"));
        }
    }
//End Class_Initialize Event

//Initialize Method @32-2832F4DC
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlid"] = CCGetFromGet("id", NULL);
    }
//End Initialize Method

//Validate Method @32-57E68812
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->description->SetValue($this->description->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_providers_connexions", "description=" . $this->DataSource->ToSQL($this->DataSource->description->GetDBValue(), $this->DataSource->description->DataType) . $Where, $this->DataSource) > 0)
            $this->description->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "Nombre de la Empresa"));
        if(strlen($this->email->GetText()) && !preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $this->email->GetText())) {
            $this->email->Errors->addError($CCSLocales->GetText("CCS_MaskValidation", "Email"));
        }
        if(strlen($this->person_mail->GetText()) && !preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $this->person_mail->GetText())) {
            $this->person_mail->Errors->addError($CCSLocales->GetText("CCS_MaskValidation", "e-mail persona responsable"));
        }
        $Validation = ($this->description->Validate() && $Validation);
        $Validation = ($this->location->Validate() && $Validation);
        $Validation = ($this->phone->Validate() && $Validation);
        $Validation = ($this->email->Validate() && $Validation);
        $Validation = ($this->person_responsible->Validate() && $Validation);
        $Validation = ($this->cellphone->Validate() && $Validation);
        $Validation = ($this->person_mail->Validate() && $Validation);
        $Validation = ($this->CheckBoxList1->Validate() && $Validation);
        $Validation = ($this->CheckBoxList3->Validate() && $Validation);
        $Validation = ($this->host_remoto->Validate() && $Validation);
        $Validation = ($this->TextBox2->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->description->Errors->Count() == 0);
        $Validation =  $Validation && ($this->location->Errors->Count() == 0);
        $Validation =  $Validation && ($this->phone->Errors->Count() == 0);
        $Validation =  $Validation && ($this->email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->person_responsible->Errors->Count() == 0);
        $Validation =  $Validation && ($this->cellphone->Errors->Count() == 0);
        $Validation =  $Validation && ($this->person_mail->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBoxList1->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CheckBoxList3->Errors->Count() == 0);
        $Validation =  $Validation && ($this->host_remoto->Errors->Count() == 0);
        $Validation =  $Validation && ($this->TextBox2->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @32-67A9A086
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->description->Errors->Count());
        $errors = ($errors || $this->location->Errors->Count());
        $errors = ($errors || $this->phone->Errors->Count());
        $errors = ($errors || $this->email->Errors->Count());
        $errors = ($errors || $this->person_responsible->Errors->Count());
        $errors = ($errors || $this->cellphone->Errors->Count());
        $errors = ($errors || $this->person_mail->Errors->Count());
        $errors = ($errors || $this->CheckBoxList1->Errors->Count());
        $errors = ($errors || $this->lista_correos->Errors->Count());
        $errors = ($errors || $this->Link1->Errors->Count());
        $errors = ($errors || $this->CheckBoxList3->Errors->Count());
        $errors = ($errors || $this->host_remoto->Errors->Count());
        $errors = ($errors || $this->TextBox2->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @32-0BF2B389
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

//InsertRow Method @32-57E719B9
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->description->SetValue($this->description->GetValue(true));
        $this->DataSource->location->SetValue($this->location->GetValue(true));
        $this->DataSource->phone->SetValue($this->phone->GetValue(true));
        $this->DataSource->email->SetValue($this->email->GetValue(true));
        $this->DataSource->person_responsible->SetValue($this->person_responsible->GetValue(true));
        $this->DataSource->cellphone->SetValue($this->cellphone->GetValue(true));
        $this->DataSource->person_mail->SetValue($this->person_mail->GetValue(true));
        $this->DataSource->CheckBoxList1->SetValue($this->CheckBoxList1->GetValue(true));
        $this->DataSource->lista_correos->SetValue($this->lista_correos->GetValue(true));
        $this->DataSource->Link1->SetValue($this->Link1->GetValue(true));
        $this->DataSource->CheckBoxList3->SetValue($this->CheckBoxList3->GetValue(true));
        $this->DataSource->host_remoto->SetValue($this->host_remoto->GetValue(true));
        $this->DataSource->TextBox2->SetValue($this->TextBox2->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @32-CF6B2695
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->description->SetValue($this->description->GetValue(true));
        $this->DataSource->location->SetValue($this->location->GetValue(true));
        $this->DataSource->phone->SetValue($this->phone->GetValue(true));
        $this->DataSource->email->SetValue($this->email->GetValue(true));
        $this->DataSource->person_responsible->SetValue($this->person_responsible->GetValue(true));
        $this->DataSource->cellphone->SetValue($this->cellphone->GetValue(true));
        $this->DataSource->person_mail->SetValue($this->person_mail->GetValue(true));
        $this->DataSource->CheckBoxList1->SetValue($this->CheckBoxList1->GetValue(true));
        $this->DataSource->lista_correos->SetValue($this->lista_correos->GetValue(true));
        $this->DataSource->Link1->SetValue($this->Link1->GetValue(true));
        $this->DataSource->CheckBoxList3->SetValue($this->CheckBoxList3->GetValue(true));
        $this->DataSource->host_remoto->SetValue($this->host_remoto->GetValue(true));
        $this->DataSource->TextBox2->SetValue($this->TextBox2->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @32-E8D0C25B
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

        $this->CheckBoxList1->Prepare();
        $this->CheckBoxList3->Prepare();
        $this->TextBox2->Prepare();

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
                    $this->location->SetValue($this->DataSource->location->GetValue());
                    $this->phone->SetValue($this->DataSource->phone->GetValue());
                    $this->email->SetValue($this->DataSource->email->GetValue());
                    $this->person_responsible->SetValue($this->DataSource->person_responsible->GetValue());
                    $this->cellphone->SetValue($this->DataSource->cellphone->GetValue());
                    $this->person_mail->SetValue($this->DataSource->person_mail->GetValue());
                    $this->host_remoto->SetValue($this->DataSource->host_remoto->GetValue());
                    $this->TextBox2->SetValue($this->DataSource->TextBox2->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }
        $this->Link1->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
        $this->Link1->Parameters = CCAddParam($this->Link1->Parameters, "camera_user_id", $this->DataSource->f("id"));

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->description->Errors->ToString());
            $Error = ComposeStrings($Error, $this->location->Errors->ToString());
            $Error = ComposeStrings($Error, $this->phone->Errors->ToString());
            $Error = ComposeStrings($Error, $this->email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->person_responsible->Errors->ToString());
            $Error = ComposeStrings($Error, $this->cellphone->Errors->ToString());
            $Error = ComposeStrings($Error, $this->person_mail->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBoxList1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->lista_correos->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Link1->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CheckBoxList3->Errors->ToString());
            $Error = ComposeStrings($Error, $this->host_remoto->Errors->ToString());
            $Error = ComposeStrings($Error, $this->TextBox2->Errors->ToString());
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
        $this->location->Show();
        $this->phone->Show();
        $this->email->Show();
        $this->person_responsible->Show();
        $this->cellphone->Show();
        $this->person_mail->Show();
        $this->CheckBoxList1->Show();
        $this->lista_correos->Show();
        $this->Link1->Show();
        $this->CheckBoxList3->Show();
        $this->host_remoto->Show();
        $this->TextBox2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End camera_providers_connexio1 Class @32-FCB6E20C

class clscamera_providers_connexio1DataSource extends clsDBminseg {  //camera_providers_connexio1DataSource Class @32-B82B088A

//DataSource Variables @32-7E9702D0
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
    public $location;
    public $phone;
    public $email;
    public $person_responsible;
    public $cellphone;
    public $person_mail;
    public $CheckBoxList1;
    public $lista_correos;
    public $Link1;
    public $CheckBoxList3;
    public $host_remoto;
    public $TextBox2;
//End DataSource Variables

//DataSourceClass_Initialize Event @32-4ABB36ED
    function clscamera_providers_connexio1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record camera_providers_connexio1/Error";
        $this->Initialize();
        $this->description = new clsField("description", ccsText, "");
        
        $this->location = new clsField("location", ccsText, "");
        
        $this->phone = new clsField("phone", ccsText, "");
        
        $this->email = new clsField("email", ccsText, "");
        
        $this->person_responsible = new clsField("person_responsible", ccsText, "");
        
        $this->cellphone = new clsField("cellphone", ccsText, "");
        
        $this->person_mail = new clsField("person_mail", ccsText, "");
        
        $this->CheckBoxList1 = new clsField("CheckBoxList1", ccsText, "");
        
        $this->lista_correos = new clsField("lista_correos", ccsText, "");
        
        $this->Link1 = new clsField("Link1", ccsText, "");
        
        $this->CheckBoxList3 = new clsField("CheckBoxList3", ccsText, "");
        
        $this->host_remoto = new clsField("host_remoto", ccsText, "");
        
        $this->TextBox2 = new clsField("TextBox2", ccsText, "");
        

        $this->InsertFields["description"] = array("Name" => "description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["location"] = array("Name" => "location", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["phone"] = array("Name" => "phone", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["email"] = array("Name" => "email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["person_responsible"] = array("Name" => "person_responsible", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["cellphone"] = array("Name" => "cellphone", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["person_mail"] = array("Name" => "person_mail", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["host_remoto"] = array("Name" => "host_remoto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["webservice"] = array("Name" => "webservice", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["description"] = array("Name" => "description", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["location"] = array("Name" => "location", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["phone"] = array("Name" => "phone", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["email"] = array("Name" => "email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["person_responsible"] = array("Name" => "person_responsible", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["cellphone"] = array("Name" => "cellphone", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["person_mail"] = array("Name" => "person_mail", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["host_remoto"] = array("Name" => "host_remoto", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["webservice"] = array("Name" => "webservice", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @32-35B33087
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

//Open Method @32-09E0D608
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_providers_connexions {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @32-A3077B07
    function SetValues()
    {
        $this->description->SetDBValue($this->f("description"));
        $this->location->SetDBValue($this->f("location"));
        $this->phone->SetDBValue($this->f("phone"));
        $this->email->SetDBValue($this->f("email"));
        $this->person_responsible->SetDBValue($this->f("person_responsible"));
        $this->cellphone->SetDBValue($this->f("cellphone"));
        $this->person_mail->SetDBValue($this->f("person_mail"));
        $this->host_remoto->SetDBValue($this->f("host_remoto"));
        $this->TextBox2->SetDBValue($this->f("webservice"));
    }
//End SetValues Method

//Insert Method @32-29EA31FA
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["description"]["Value"] = $this->description->GetDBValue(true);
        $this->InsertFields["location"]["Value"] = $this->location->GetDBValue(true);
        $this->InsertFields["phone"]["Value"] = $this->phone->GetDBValue(true);
        $this->InsertFields["email"]["Value"] = $this->email->GetDBValue(true);
        $this->InsertFields["person_responsible"]["Value"] = $this->person_responsible->GetDBValue(true);
        $this->InsertFields["cellphone"]["Value"] = $this->cellphone->GetDBValue(true);
        $this->InsertFields["person_mail"]["Value"] = $this->person_mail->GetDBValue(true);
        $this->InsertFields["host_remoto"]["Value"] = $this->host_remoto->GetDBValue(true);
        $this->InsertFields["webservice"]["Value"] = $this->TextBox2->GetDBValue(true);
        $this->SQL = CCBuildInsert("camera_providers_connexions", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @32-377C4D37
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["description"]["Value"] = $this->description->GetDBValue(true);
        $this->UpdateFields["location"]["Value"] = $this->location->GetDBValue(true);
        $this->UpdateFields["phone"]["Value"] = $this->phone->GetDBValue(true);
        $this->UpdateFields["email"]["Value"] = $this->email->GetDBValue(true);
        $this->UpdateFields["person_responsible"]["Value"] = $this->person_responsible->GetDBValue(true);
        $this->UpdateFields["cellphone"]["Value"] = $this->cellphone->GetDBValue(true);
        $this->UpdateFields["person_mail"]["Value"] = $this->person_mail->GetDBValue(true);
        $this->UpdateFields["host_remoto"]["Value"] = $this->host_remoto->GetDBValue(true);
        $this->UpdateFields["webservice"]["Value"] = $this->TextBox2->GetDBValue(true);
        $this->SQL = CCBuildUpdate("camera_providers_connexions", $this->UpdateFields, $this);
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

} //End camera_providers_connexio1DataSource Class @32-FCB6E20C

class clsRecordcamera_users_emails { //camera_users_emails Class @111-A603488B

//Variables @111-9E315808

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

//Class_Initialize Event @111-07F580A9
    function clsRecordcamera_users_emails($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_users_emails/Error";
        $this->DataSource = new clscamera_users_emailsDataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_users_emails";
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
            $this->camera_user_email = new clsControl(ccsTextBox, "camera_user_email", "CORREO", ccsText, "", CCGetRequestParam("camera_user_email", $Method, NULL), $this);
            $this->camera_user_email->Required = true;
            $this->Button1 = new clsButton("Button1", $Method, $this);
            $this->camera_user_id = new clsControl(ccsHidden, "camera_user_id", "camera_user_id", ccsText, "", CCGetRequestParam("camera_user_id", $Method, NULL), $this);
            $this->Button2 = new clsButton("Button2", $Method, $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @111-955AAD2C
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlcamera_user_email_id"] = CCGetFromGet("camera_user_email_id", NULL);
    }
//End Initialize Method

//Validate Method @111-D1C25506
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        if($this->EditMode && strlen($this->DataSource->Where))
            $Where = " AND NOT (" . $this->DataSource->Where . ")";
        $this->DataSource->camera_user_email->SetValue($this->camera_user_email->GetValue());
        if(CCDLookUp("COUNT(*)", "camera_users_emails", "camera_user_email=" . $this->DataSource->ToSQL($this->DataSource->camera_user_email->GetDBValue(), $this->DataSource->camera_user_email->DataType) . $Where, $this->DataSource) > 0)
            $this->camera_user_email->Errors->addError($CCSLocales->GetText("CCS_UniqueValue", "CORREO"));
        if(strlen($this->camera_user_email->GetText()) && !preg_match ("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $this->camera_user_email->GetText())) {
            $this->camera_user_email->Errors->addError($CCSLocales->GetText("CCS_MaskValidation", "CORREO"));
        }
        $Validation = ($this->camera_user_email->Validate() && $Validation);
        $Validation = ($this->camera_user_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->camera_user_email->Errors->Count() == 0);
        $Validation =  $Validation && ($this->camera_user_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @111-C451ABA8
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->camera_user_email->Errors->Count());
        $errors = ($errors || $this->camera_user_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @111-C88CE163
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
            } else if($this->Button1->Pressed) {
                $this->PressedButton = "Button1";
            } else if($this->Button2->Pressed) {
                $this->PressedButton = "Button2";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Cancel") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "camera_user_email_id"));
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button1") {
            $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm", "camera_user_email_id"));
            if(!CCGetEvent($this->Button1->CCSEvents, "OnClick", $this->Button1)) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button2") {
            if(!CCGetEvent($this->Button2->CCSEvents, "OnClick", $this->Button2) || !$this->DeleteRow()) {
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

//InsertRow Method @111-981A8F8E
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->camera_user_email->SetValue($this->camera_user_email->GetValue(true));
        $this->DataSource->camera_user_id->SetValue($this->camera_user_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @111-E8D5F2D2
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->camera_user_email->SetValue($this->camera_user_email->GetValue(true));
        $this->DataSource->camera_user_id->SetValue($this->camera_user_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @111-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @111-BFEB9AEC
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
                    $this->camera_user_email->SetValue($this->DataSource->camera_user_email->GetValue());
                    $this->camera_user_id->SetValue($this->DataSource->camera_user_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->camera_user_email->Errors->ToString());
            $Error = ComposeStrings($Error, $this->camera_user_id->Errors->ToString());
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
        $this->Button2->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Cancel->Show();
        $this->camera_user_email->Show();
        $this->Button1->Show();
        $this->camera_user_id->Show();
        $this->Button2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End camera_users_emails Class @111-FCB6E20C

class clscamera_users_emailsDataSource extends clsDBminseg {  //camera_users_emailsDataSource Class @111-F4FE0737

//DataSource Variables @111-501941B7
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $InsertParameters;
    public $UpdateParameters;
    public $DeleteParameters;
    public $wp;
    public $AllParametersSet;

    public $InsertFields = array();
    public $UpdateFields = array();

    // Datasource fields
    public $camera_user_email;
    public $camera_user_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @111-FF402732
    function clscamera_users_emailsDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record camera_users_emails/Error";
        $this->Initialize();
        $this->camera_user_email = new clsField("camera_user_email", ccsText, "");
        
        $this->camera_user_id = new clsField("camera_user_id", ccsText, "");
        

        $this->InsertFields["camera_user_email"] = array("Name" => "camera_user_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["camera_user_id"] = array("Name" => "camera_user_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["camera_user_email"] = array("Name" => "camera_user_email", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["camera_user_id"] = array("Name" => "camera_user_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @111-153F1203
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlcamera_user_email_id", ccsInteger, "", "", $this->Parameters["urlcamera_user_email_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "camera_user_email_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @111-104BAE65
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_users_emails {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @111-B60068C2
    function SetValues()
    {
        $this->camera_user_email->SetDBValue($this->f("camera_user_email"));
        $this->camera_user_id->SetDBValue($this->f("camera_user_id"));
    }
//End SetValues Method

//Insert Method @111-298DC04E
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["camera_user_email"]["Value"] = $this->camera_user_email->GetDBValue(true);
        $this->InsertFields["camera_user_id"]["Value"] = $this->camera_user_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("camera_users_emails", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @111-980C5DFF
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["camera_user_email"]["Value"] = $this->camera_user_email->GetDBValue(true);
        $this->UpdateFields["camera_user_id"]["Value"] = $this->camera_user_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("camera_users_emails", $this->UpdateFields, $this);
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

//Delete Method @111-3FE9F55C
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM camera_users_emails";
        $this->SQL = CCBuildSQL($this->SQL, $this->Where, "");
        if (!strlen($this->Where) && $this->Errors->Count() == 0) 
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete", $this->Parent);
        }
    }
//End Delete Method

} //End camera_users_emailsDataSource Class @111-FCB6E20C

class clsGridcamera_users_emails1 { //camera_users_emails1 class @118-4F15C2A9

//Variables @118-94C9B6D9

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
    public $Sorter_camera_user_email;
//End Variables

//Class_Initialize Event @118-4381D5E0
    function clsGridcamera_users_emails1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_users_emails1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_users_emails1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_users_emails1DataSource($this);
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
        $this->SorterName = CCGetParam("camera_users_emails1Order", "");
        $this->SorterDirection = CCGetParam("camera_users_emails1Dir", "");

        $this->camera_user_email_id = new clsControl(ccsImageLink, "camera_user_email_id", "camera_user_email_id", ccsInteger, "", CCGetRequestParam("camera_user_email_id", ccsGet, NULL), $this);
        $this->camera_user_email_id->Page = "";
        $this->camera_user_email = new clsControl(ccsLabel, "camera_user_email", "camera_user_email", ccsText, "", CCGetRequestParam("camera_user_email", ccsGet, NULL), $this);
        $this->Sorter_camera_user_email = new clsSorter($this->ComponentName, "Sorter_camera_user_email", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @118-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @118-80183E91
    function Show()
    {
        $Tpl = CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlcamera_user_id"] = CCGetFromGet("camera_user_id", NULL);
        $this->DataSource->Parameters["expr156"] = 1;

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
            $this->ControlsVisible["camera_user_email_id"] = $this->camera_user_email_id->Visible;
            $this->ControlsVisible["camera_user_email"] = $this->camera_user_email->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->camera_user_email_id->SetValue($this->DataSource->camera_user_email_id->GetValue());
                $this->camera_user_email_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->camera_user_email_id->Parameters = CCAddParam($this->camera_user_email_id->Parameters, "camera_user_email_id", $this->DataSource->f("camera_user_email_id"));
                $this->camera_user_email->SetValue($this->DataSource->camera_user_email->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->camera_user_email_id->Show();
                $this->camera_user_email->Show();
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
        $this->Sorter_camera_user_email->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @118-B2E12887
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->camera_user_email_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->camera_user_email->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_users_emails1 Class @118-FCB6E20C

class clscamera_users_emails1DataSource extends clsDBminseg {  //camera_users_emails1DataSource Class @118-564A5644

//DataSource Variables @118-4C2D219F
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $camera_user_email_id;
    public $camera_user_email;
//End DataSource Variables

//DataSourceClass_Initialize Event @118-FA657CFD
    function clscamera_users_emails1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_users_emails1";
        $this->Initialize();
        $this->camera_user_email_id = new clsField("camera_user_email_id", ccsInteger, "");
        
        $this->camera_user_email = new clsField("camera_user_email", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @118-4AE155FE
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_camera_user_email" => array("camera_user_email", "")));
    }
//End SetOrder Method

//Prepare Method @118-69664B19
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlcamera_user_id", ccsInteger, "", "", $this->Parameters["urlcamera_user_id"], 0, false);
        $this->wp->AddParameter("2", "expr156", ccsInteger, "", "", $this->Parameters["expr156"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "camera_user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "type_user", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]);
    }
//End Prepare Method

//Open Method @118-04898EC0
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM camera_users_emails";
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_users_emails {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @118-30D7FEA7
    function SetValues()
    {
        $this->camera_user_email_id->SetDBValue(trim($this->f("camera_user_email_id")));
        $this->camera_user_email->SetDBValue($this->f("camera_user_email"));
    }
//End SetValues Method

} //End camera_users_emails1DataSource Class @118-FCB6E20C

//Initialize Page @1-C410C10E
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
$TemplateFileName = "proveedor_conexion.html";
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

//Include events file @1-91C9695B
include_once("./proveedor_conexion_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-5027F09D
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
$camera_providers_connexio = new clsGridcamera_providers_connexio("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$Panel2->GenerateDiv = true;
$Panel2->PanelId = "Panel1Panel2";
$camera_providers_connexio1 = new clsRecordcamera_providers_connexio1("", $MainPage);
$Panel3 = new clsPanel("Panel3", $MainPage);
$Panel3->GenerateDiv = true;
$Panel3->PanelId = "Panel1Panel3";
$camera_users_emails = new clsRecordcamera_users_emails("", $MainPage);
$camera_users_emails1 = new clsGridcamera_users_emails1("", $MainPage);
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$MainPage->mymenu = & $mymenu;
$MainPage->Panel1 = & $Panel1;
$MainPage->camera_providers_connexio = & $camera_providers_connexio;
$MainPage->Panel2 = & $Panel2;
$MainPage->camera_providers_connexio1 = & $camera_providers_connexio1;
$MainPage->Panel3 = & $Panel3;
$MainPage->camera_users_emails = & $camera_users_emails;
$MainPage->camera_users_emails1 = & $camera_users_emails1;
$MainPage->app_environment_class = & $app_environment_class;
$Panel1->AddComponent("camera_providers_connexio", $camera_providers_connexio);
$Panel1->AddComponent("Panel2", $Panel2);
$Panel1->AddComponent("Panel3", $Panel3);
$Panel2->AddComponent("camera_providers_connexio1", $camera_providers_connexio1);
$Panel3->AddComponent("camera_users_emails", $camera_users_emails);
$Panel3->AddComponent("camera_users_emails1", $camera_users_emails1);
$camera_providers_connexio->Initialize();
$camera_providers_connexio1->Initialize();
$camera_users_emails->Initialize();
$camera_users_emails1->Initialize();
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

//Execute Components @1-D7664834
$camera_users_emails->Operation();
$camera_providers_connexio1->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-60018889
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_providers_connexio);
    unset($camera_providers_connexio1);
    unset($camera_users_emails);
    unset($camera_users_emails1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-8A7DBEE3
$mymenu->Show();
$Panel1->Show();
$app_environment_class->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font fa" . "ce=\"Arial\"><smal" . "l>&#71;e&#110;er&#" . "97;t&#101;d <!-- SCC" . " -->&#119;it&#10" . "4; <!-- SCC -->C" . "odeC&#104;&#97;r&#10" . "3;e <!-- CCS --" . ">S&#116;&#117;d&" . "#105;o.</small></f" . "ont></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font fa" . "ce=\"Arial\"><smal" . "l>&#71;e&#110;er&#" . "97;t&#101;d <!-- SCC" . " -->&#119;it&#10" . "4; <!-- SCC -->C" . "odeC&#104;&#97;r&#10" . "3;e <!-- CCS --" . ">S&#116;&#117;d&" . "#105;o.</small></f" . "ont></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font fa" . "ce=\"Arial\"><smal" . "l>&#71;e&#110;er&#" . "97;t&#101;d <!-- SCC" . " -->&#119;it&#10" . "4; <!-- SCC -->C" . "odeC&#104;&#97;r&#10" . "3;e <!-- CCS --" . ">S&#116;&#117;d&" . "#105;o.</small></f" . "ont></center>";
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-4D4FEAB8
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_providers_connexio);
unset($camera_providers_connexio1);
unset($camera_users_emails);
unset($camera_users_emails1);
unset($Tpl);
//End Unload Page


?>
