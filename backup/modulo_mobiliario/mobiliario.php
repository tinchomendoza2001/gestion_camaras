<?php
//Include Common Files @1-0CF110B0
define("RelativePath", "..");
define("PathToCurrentPage", "/modulo_mobiliario/");
define("FileName", "mobiliario.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordmobiliariosSearch { //mobiliariosSearch Class @32-7D93C361

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

//Class_Initialize Event @32-6B011199
    function clsRecordmobiliariosSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record mobiliariosSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "mobiliariosSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->s_mobiliario_id = new clsControl(ccsTextBox, "s_mobiliario_id", "Mobiliario Id", ccsInteger, "", CCGetRequestParam("s_mobiliario_id", $Method, NULL), $this);
            $this->s_tipo_mobiliario_id = new clsControl(ccsTextBox, "s_tipo_mobiliario_id", "Tipo Mobiliario Id", ccsInteger, "", CCGetRequestParam("s_tipo_mobiliario_id", $Method, NULL), $this);
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @32-222D7786
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_mobiliario_id->Validate() && $Validation);
        $Validation = ($this->s_tipo_mobiliario_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_mobiliario_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_mobiliario_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @32-6B5388D1
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_mobiliario_id->Errors->Count());
        $errors = ($errors || $this->s_tipo_mobiliario_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @32-E4A73E41
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
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = "mobiliario.php";
        if($this->PressedButton == "Button_Cancel") {
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "mobiliario.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button_Cancel", "Button_Cancel_x", "Button_Cancel_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @32-907AA201
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
            $Error = ComposeStrings($Error, $this->s_mobiliario_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_mobiliario_id->Errors->ToString());
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

        $this->s_mobiliario_id->Show();
        $this->s_tipo_mobiliario_id->Show();
        $this->Button_DoSearch->Show();
        $this->Button_Cancel->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End mobiliariosSearch Class @32-FCB6E20C

class clsRecordmobiliarios1 { //mobiliarios1 Class @46-E0D8A9DE

//Variables @46-9E315808

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

//Class_Initialize Event @46-2B2D278F
    function clsRecordmobiliarios1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record mobiliarios1/Error";
        $this->DataSource = new clsmobiliarios1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "mobiliarios1";
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
            $this->Button_Delete = new clsButton("Button_Delete", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->tipo_mobiliario_id = new clsControl(ccsListBox, "tipo_mobiliario_id", "Tipo Mobiliario Id", ccsInteger, "", CCGetRequestParam("tipo_mobiliario_id", $Method, NULL), $this);
            $this->tipo_mobiliario_id->DSType = dsTable;
            $this->tipo_mobiliario_id->DataSource = new clsDBminseg();
            $this->tipo_mobiliario_id->ds = & $this->tipo_mobiliario_id->DataSource;
            $this->tipo_mobiliario_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_mobiliarios {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_mobiliario_id->BoundColumn, $this->tipo_mobiliario_id->TextColumn, $this->tipo_mobiliario_id->DBFormat) = array("tipo_estado_mobiliario_id", "tipo_estado_mobiliario_descrip", "");
            $this->tipo_estado_mobiliario_id = new clsControl(ccsListBox, "tipo_estado_mobiliario_id", "Tipo Estado Mobiliario Id", ccsInteger, "", CCGetRequestParam("tipo_estado_mobiliario_id", $Method, NULL), $this);
            $this->tipo_estado_mobiliario_id->DSType = dsTable;
            $this->tipo_estado_mobiliario_id->DataSource = new clsDBminseg();
            $this->tipo_estado_mobiliario_id->ds = & $this->tipo_estado_mobiliario_id->DataSource;
            $this->tipo_estado_mobiliario_id->DataSource->SQL = "SELECT * \n" .
"FROM tipos_estados_mobiliarios {SQL_Where} {SQL_OrderBy}";
            list($this->tipo_estado_mobiliario_id->BoundColumn, $this->tipo_estado_mobiliario_id->TextColumn, $this->tipo_estado_mobiliario_id->DBFormat) = array("tipo_estado_mobiliario_id", "tipo_estado_mobiliario_descrip", "");
            $this->proveedor_mantenimiento_id = new clsControl(ccsListBox, "proveedor_mantenimiento_id", "Proveedor Mantenimiento Id", ccsInteger, "", CCGetRequestParam("proveedor_mantenimiento_id", $Method, NULL), $this);
            $this->proveedor_mantenimiento_id->DSType = dsTable;
            $this->proveedor_mantenimiento_id->DataSource = new clsDBminseg();
            $this->proveedor_mantenimiento_id->ds = & $this->proveedor_mantenimiento_id->DataSource;
            $this->proveedor_mantenimiento_id->DataSource->SQL = "SELECT * \n" .
"FROM proveedores {SQL_Where} {SQL_OrderBy}";
            list($this->proveedor_mantenimiento_id->BoundColumn, $this->proveedor_mantenimiento_id->TextColumn, $this->proveedor_mantenimiento_id->DBFormat) = array("proveedor_id", "proveedor_razon_social", "");
            $this->centro_visualizacion_id = new clsControl(ccsListBox, "centro_visualizacion_id", "Centro Visualizacion Id", ccsInteger, "", CCGetRequestParam("centro_visualizacion_id", $Method, NULL), $this);
            $this->centro_visualizacion_id->DSType = dsTable;
            $this->centro_visualizacion_id->DataSource = new clsDBminseg();
            $this->centro_visualizacion_id->ds = & $this->centro_visualizacion_id->DataSource;
            $this->centro_visualizacion_id->DataSource->SQL = "SELECT * \n" .
"FROM centros_visualizacion {SQL_Where} {SQL_OrderBy}";
            list($this->centro_visualizacion_id->BoundColumn, $this->centro_visualizacion_id->TextColumn, $this->centro_visualizacion_id->DBFormat) = array("centro_visualizacion_id", "centro_visualizacion_ident", "");
        }
    }
//End Class_Initialize Event

//Initialize Method @46-F5980B9C
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urls_mobiliario_id"] = CCGetFromGet("s_mobiliario_id", NULL);
    }
//End Initialize Method

//Validate Method @46-3D0D3446
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_mobiliario_id->Validate() && $Validation);
        $Validation = ($this->tipo_estado_mobiliario_id->Validate() && $Validation);
        $Validation = ($this->proveedor_mantenimiento_id->Validate() && $Validation);
        $Validation = ($this->centro_visualizacion_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_mobiliario_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_mobiliario_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->proveedor_mantenimiento_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->centro_visualizacion_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @46-0321EA75
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_mobiliario_id->Errors->Count());
        $errors = ($errors || $this->tipo_estado_mobiliario_id->Errors->Count());
        $errors = ($errors || $this->proveedor_mantenimiento_id->Errors->Count());
        $errors = ($errors || $this->centro_visualizacion_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @46-288F0419
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
            } else if($this->Button_Delete->Pressed) {
                $this->PressedButton = "Button_Delete";
            } else if($this->Button_Cancel->Pressed) {
                $this->PressedButton = "Button_Cancel";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->PressedButton == "Button_Delete") {
            if(!CCGetEvent($this->Button_Delete->CCSEvents, "OnClick", $this->Button_Delete) || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Button_Cancel") {
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

//InsertRow Method @46-D77EE420
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->tipo_mobiliario_id->SetValue($this->tipo_mobiliario_id->GetValue(true));
        $this->DataSource->tipo_estado_mobiliario_id->SetValue($this->tipo_estado_mobiliario_id->GetValue(true));
        $this->DataSource->proveedor_mantenimiento_id->SetValue($this->proveedor_mantenimiento_id->GetValue(true));
        $this->DataSource->centro_visualizacion_id->SetValue($this->centro_visualizacion_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @46-62485615
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->tipo_mobiliario_id->SetValue($this->tipo_mobiliario_id->GetValue(true));
        $this->DataSource->tipo_estado_mobiliario_id->SetValue($this->tipo_estado_mobiliario_id->GetValue(true));
        $this->DataSource->proveedor_mantenimiento_id->SetValue($this->proveedor_mantenimiento_id->GetValue(true));
        $this->DataSource->centro_visualizacion_id->SetValue($this->centro_visualizacion_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @46-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @46-C380AAEC
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

        $this->tipo_mobiliario_id->Prepare();
        $this->tipo_estado_mobiliario_id->Prepare();
        $this->proveedor_mantenimiento_id->Prepare();
        $this->centro_visualizacion_id->Prepare();

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
                    $this->tipo_mobiliario_id->SetValue($this->DataSource->tipo_mobiliario_id->GetValue());
                    $this->tipo_estado_mobiliario_id->SetValue($this->DataSource->tipo_estado_mobiliario_id->GetValue());
                    $this->proveedor_mantenimiento_id->SetValue($this->DataSource->proveedor_mantenimiento_id->GetValue());
                    $this->centro_visualizacion_id->SetValue($this->DataSource->centro_visualizacion_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_mobiliario_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_mobiliario_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->proveedor_mantenimiento_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->centro_visualizacion_id->Errors->ToString());
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
        $this->Button_Delete->Visible = $this->EditMode && $this->DeleteAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Insert->Show();
        $this->Button_Update->Show();
        $this->Button_Delete->Show();
        $this->Button_Cancel->Show();
        $this->tipo_mobiliario_id->Show();
        $this->tipo_estado_mobiliario_id->Show();
        $this->proveedor_mantenimiento_id->Show();
        $this->centro_visualizacion_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End mobiliarios1 Class @46-FCB6E20C

class clsmobiliarios1DataSource extends clsDBminseg {  //mobiliarios1DataSource Class @46-6F872F0A

//DataSource Variables @46-94579865
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
    public $tipo_mobiliario_id;
    public $tipo_estado_mobiliario_id;
    public $proveedor_mantenimiento_id;
    public $centro_visualizacion_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @46-AEED187A
    function clsmobiliarios1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record mobiliarios1/Error";
        $this->Initialize();
        $this->tipo_mobiliario_id = new clsField("tipo_mobiliario_id", ccsInteger, "");
        
        $this->tipo_estado_mobiliario_id = new clsField("tipo_estado_mobiliario_id", ccsInteger, "");
        
        $this->proveedor_mantenimiento_id = new clsField("proveedor_mantenimiento_id", ccsInteger, "");
        
        $this->centro_visualizacion_id = new clsField("centro_visualizacion_id", ccsInteger, "");
        

        $this->InsertFields["tipo_mobiliario_id"] = array("Name" => "tipo_mobiliario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["tipo_estado_mobiliario_id"] = array("Name" => "tipo_estado_mobiliario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["proveedor_mantenimiento_id"] = array("Name" => "proveedor_mantenimiento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["centro_visualizacion_id"] = array("Name" => "centro_visualizacion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_mobiliario_id"] = array("Name" => "tipo_mobiliario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_mobiliario_id"] = array("Name" => "tipo_estado_mobiliario_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["proveedor_mantenimiento_id"] = array("Name" => "proveedor_mantenimiento_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["centro_visualizacion_id"] = array("Name" => "centro_visualizacion_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @46-261D891C
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_mobiliario_id", ccsInteger, "", "", $this->Parameters["urls_mobiliario_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mobiliario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @46-2F650C04
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM mobiliarios {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @46-C7E566AE
    function SetValues()
    {
        $this->tipo_mobiliario_id->SetDBValue(trim($this->f("tipo_mobiliario_id")));
        $this->tipo_estado_mobiliario_id->SetDBValue(trim($this->f("tipo_estado_mobiliario_id")));
        $this->proveedor_mantenimiento_id->SetDBValue(trim($this->f("proveedor_mantenimiento_id")));
        $this->centro_visualizacion_id->SetDBValue(trim($this->f("centro_visualizacion_id")));
    }
//End SetValues Method

//Insert Method @46-96BD52EB
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["tipo_mobiliario_id"]["Value"] = $this->tipo_mobiliario_id->GetDBValue(true);
        $this->InsertFields["tipo_estado_mobiliario_id"]["Value"] = $this->tipo_estado_mobiliario_id->GetDBValue(true);
        $this->InsertFields["proveedor_mantenimiento_id"]["Value"] = $this->proveedor_mantenimiento_id->GetDBValue(true);
        $this->InsertFields["centro_visualizacion_id"]["Value"] = $this->centro_visualizacion_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("mobiliarios", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @46-B867D758
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["tipo_mobiliario_id"]["Value"] = $this->tipo_mobiliario_id->GetDBValue(true);
        $this->UpdateFields["tipo_estado_mobiliario_id"]["Value"] = $this->tipo_estado_mobiliario_id->GetDBValue(true);
        $this->UpdateFields["proveedor_mantenimiento_id"]["Value"] = $this->proveedor_mantenimiento_id->GetDBValue(true);
        $this->UpdateFields["centro_visualizacion_id"]["Value"] = $this->centro_visualizacion_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("mobiliarios", $this->UpdateFields, $this);
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

//Delete Method @46-44A92B50
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM mobiliarios";
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

} //End mobiliarios1DataSource Class @46-FCB6E20C

class clsGridmobiliarios { //mobiliarios class @3-98B7BFCC

//Variables @3-A66F8B06

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
    public $Sorter_mobiliario_id;
    public $Sorter_tipo_mobiliario_id;
    public $Sorter_tipo_estado_mobiliario_id;
    public $Sorter_proveedor_mantenimiento_id;
    public $Sorter_centro_visualizacion_id;
//End Variables

//Class_Initialize Event @3-D7CAA1A6
    function clsGridmobiliarios($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "mobiliarios";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid mobiliarios";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmobiliariosDataSource($this);
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
        $this->SorterName = CCGetParam("mobiliariosOrder", "");
        $this->SorterDirection = CCGetParam("mobiliariosDir", "");

        $this->mobiliario_id = new clsControl(ccsLink, "mobiliario_id", "mobiliario_id", ccsInteger, "", CCGetRequestParam("mobiliario_id", ccsGet, NULL), $this);
        $this->mobiliario_id->Page = "";
        $this->tipo_mobiliario_descrip = new clsControl(ccsLabel, "tipo_mobiliario_descrip", "tipo_mobiliario_descrip", ccsText, "", CCGetRequestParam("tipo_mobiliario_descrip", ccsGet, NULL), $this);
        $this->tipo_estado_mobiliario_descrip = new clsControl(ccsLabel, "tipo_estado_mobiliario_descrip", "tipo_estado_mobiliario_descrip", ccsText, "", CCGetRequestParam("tipo_estado_mobiliario_descrip", ccsGet, NULL), $this);
        $this->proveedor_razon_social = new clsControl(ccsLabel, "proveedor_razon_social", "proveedor_razon_social", ccsText, "", CCGetRequestParam("proveedor_razon_social", ccsGet, NULL), $this);
        $this->centro_visualizacion_ident = new clsControl(ccsLabel, "centro_visualizacion_ident", "centro_visualizacion_ident", ccsText, "", CCGetRequestParam("centro_visualizacion_ident", ccsGet, NULL), $this);
        $this->Sorter_mobiliario_id = new clsSorter($this->ComponentName, "Sorter_mobiliario_id", $FileName, $this);
        $this->Sorter_tipo_mobiliario_id = new clsSorter($this->ComponentName, "Sorter_tipo_mobiliario_id", $FileName, $this);
        $this->Sorter_tipo_estado_mobiliario_id = new clsSorter($this->ComponentName, "Sorter_tipo_estado_mobiliario_id", $FileName, $this);
        $this->Sorter_proveedor_mantenimiento_id = new clsSorter($this->ComponentName, "Sorter_proveedor_mantenimiento_id", $FileName, $this);
        $this->Sorter_centro_visualizacion_id = new clsSorter($this->ComponentName, "Sorter_centro_visualizacion_id", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @3-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @3-0E4EF1D7
    function Show()
    {
        $Tpl = CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_mobiliario_id"] = CCGetFromGet("s_mobiliario_id", NULL);

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
            $this->ControlsVisible["mobiliario_id"] = $this->mobiliario_id->Visible;
            $this->ControlsVisible["tipo_mobiliario_descrip"] = $this->tipo_mobiliario_descrip->Visible;
            $this->ControlsVisible["tipo_estado_mobiliario_descrip"] = $this->tipo_estado_mobiliario_descrip->Visible;
            $this->ControlsVisible["proveedor_razon_social"] = $this->proveedor_razon_social->Visible;
            $this->ControlsVisible["centro_visualizacion_ident"] = $this->centro_visualizacion_ident->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->mobiliario_id->SetValue($this->DataSource->mobiliario_id->GetValue());
                $this->mobiliario_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->mobiliario_id->Parameters = CCAddParam($this->mobiliario_id->Parameters, "s_mobiliario_id", $this->DataSource->f("mobiliario_id"));
                $this->tipo_mobiliario_descrip->SetValue($this->DataSource->tipo_mobiliario_descrip->GetValue());
                $this->tipo_estado_mobiliario_descrip->SetValue($this->DataSource->tipo_estado_mobiliario_descrip->GetValue());
                $this->proveedor_razon_social->SetValue($this->DataSource->proveedor_razon_social->GetValue());
                $this->centro_visualizacion_ident->SetValue($this->DataSource->centro_visualizacion_ident->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->mobiliario_id->Show();
                $this->tipo_mobiliario_descrip->Show();
                $this->tipo_estado_mobiliario_descrip->Show();
                $this->proveedor_razon_social->Show();
                $this->centro_visualizacion_ident->Show();
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
        $this->Sorter_mobiliario_id->Show();
        $this->Sorter_tipo_mobiliario_id->Show();
        $this->Sorter_tipo_estado_mobiliario_id->Show();
        $this->Sorter_proveedor_mantenimiento_id->Show();
        $this->Sorter_centro_visualizacion_id->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @3-A5B0AF51
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->mobiliario_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_mobiliario_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_estado_mobiliario_descrip->Errors->ToString());
        $errors = ComposeStrings($errors, $this->proveedor_razon_social->Errors->ToString());
        $errors = ComposeStrings($errors, $this->centro_visualizacion_ident->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End mobiliarios Class @3-FCB6E20C

class clsmobiliariosDataSource extends clsDBminseg {  //mobiliariosDataSource Class @3-3A348BD4

//DataSource Variables @3-AE982ACA
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $mobiliario_id;
    public $tipo_mobiliario_descrip;
    public $tipo_estado_mobiliario_descrip;
    public $proveedor_razon_social;
    public $centro_visualizacion_ident;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-1F9A8821
    function clsmobiliariosDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid mobiliarios";
        $this->Initialize();
        $this->mobiliario_id = new clsField("mobiliario_id", ccsInteger, "");
        
        $this->tipo_mobiliario_descrip = new clsField("tipo_mobiliario_descrip", ccsText, "");
        
        $this->tipo_estado_mobiliario_descrip = new clsField("tipo_estado_mobiliario_descrip", ccsText, "");
        
        $this->proveedor_razon_social = new clsField("proveedor_razon_social", ccsText, "");
        
        $this->centro_visualizacion_ident = new clsField("centro_visualizacion_ident", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-2E07AD1D
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_mobiliario_id" => array("mobiliario_id", ""), 
            "Sorter_tipo_mobiliario_id" => array("tipo_mobiliario_id", ""), 
            "Sorter_tipo_estado_mobiliario_id" => array("tipo_estado_mobiliario_id", ""), 
            "Sorter_proveedor_mantenimiento_id" => array("proveedor_mantenimiento_id", ""), 
            "Sorter_centro_visualizacion_id" => array("centro_visualizacion_id", "")));
    }
//End SetOrder Method

//Prepare Method @3-D573EBD2
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_mobiliario_id", ccsInteger, "", "", $this->Parameters["urls_mobiliario_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mobiliarios.mobiliario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @3-543BD5C7
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (((mobiliarios LEFT JOIN tipos_mobiliarios ON\n\n" .
        "mobiliarios.tipo_mobiliario_id = tipos_mobiliarios.tipo_mobiliario_id) LEFT JOIN tipos_estados_mobiliarios ON\n\n" .
        "mobiliarios.tipo_estado_mobiliario_id = tipos_estados_mobiliarios.tipo_estado_mobiliario_id) LEFT JOIN proveedores ON\n\n" .
        "mobiliarios.proveedor_mantenimiento_id = proveedores.proveedor_id) LEFT JOIN centros_visualizacion ON\n\n" .
        "mobiliarios.centro_visualizacion_id = centros_visualizacion.centro_visualizacion_id";
        $this->SQL = "SELECT mobiliario_id, mobiliarios.tipo_mobiliario_id AS mobiliarios_tipo_mobiliario_id, mobiliarios.tipo_estado_mobiliario_id AS mobiliarios_tipo_estado_mobiliario_id,\n\n" .
        "proveedor_mantenimiento_id, mobiliarios.centro_visualizacion_id AS mobiliarios_centro_visualizacion_id, tipo_mobiliario_descrip,\n\n" .
        "tipo_estado_mobiliario_descrip, proveedor_razon_social, centro_visualizacion_ident \n\n" .
        "FROM (((mobiliarios LEFT JOIN tipos_mobiliarios ON\n\n" .
        "mobiliarios.tipo_mobiliario_id = tipos_mobiliarios.tipo_mobiliario_id) LEFT JOIN tipos_estados_mobiliarios ON\n\n" .
        "mobiliarios.tipo_estado_mobiliario_id = tipos_estados_mobiliarios.tipo_estado_mobiliario_id) LEFT JOIN proveedores ON\n\n" .
        "mobiliarios.proveedor_mantenimiento_id = proveedores.proveedor_id) LEFT JOIN centros_visualizacion ON\n\n" .
        "mobiliarios.centro_visualizacion_id = centros_visualizacion.centro_visualizacion_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-9FD4A0DB
    function SetValues()
    {
        $this->mobiliario_id->SetDBValue(trim($this->f("mobiliario_id")));
        $this->tipo_mobiliario_descrip->SetDBValue($this->f("tipo_mobiliario_descrip"));
        $this->tipo_estado_mobiliario_descrip->SetDBValue($this->f("tipo_estado_mobiliario_descrip"));
        $this->proveedor_razon_social->SetDBValue($this->f("proveedor_razon_social"));
        $this->centro_visualizacion_ident->SetDBValue($this->f("centro_visualizacion_ident"));
    }
//End SetValues Method

} //End mobiliariosDataSource Class @3-FCB6E20C



class clsRecordmobiliarios2 { //mobiliarios2 Class @124-CBF5FA1D

//Variables @124-9E315808

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

//Class_Initialize Event @124-BB19BD4F
    function clsRecordmobiliarios2($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record mobiliarios2/Error";
        $this->DataSource = new clsmobiliarios2DataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "mobiliarios2";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->Button_Update = new clsButton("Button_Update", $Method, $this);
            $this->tipo_mobiliario_descrip = new clsControl(ccsTextBox, "tipo_mobiliario_descrip", "Tipo Mobiliario Id", ccsText, "", CCGetRequestParam("tipo_mobiliario_descrip", $Method, NULL), $this);
            $this->tipo_estado_mobiliario_descrip = new clsControl(ccsTextBox, "tipo_estado_mobiliario_descrip", "Tipo Estado Mobiliario Id", ccsText, "", CCGetRequestParam("tipo_estado_mobiliario_descrip", $Method, NULL), $this);
            $this->mobiliario_id = new clsControl(ccsTextBox, "mobiliario_id", "mobiliario_id", ccsText, "", CCGetRequestParam("mobiliario_id", $Method, NULL), $this);
            $this->proveedor_razon_social = new clsControl(ccsTextBox, "proveedor_razon_social", "Proveedor Mantenimiento Id", ccsText, "", CCGetRequestParam("proveedor_razon_social", $Method, NULL), $this);
            $this->centro_visualizacion_ident = new clsControl(ccsTextBox, "centro_visualizacion_ident", "Centro Visualizacion Id", ccsText, "", CCGetRequestParam("centro_visualizacion_ident", $Method, NULL), $this);
            $this->mobiliarios_Insert = new clsControl(ccsLink, "mobiliarios_Insert", "mobiliarios_Insert", ccsText, "", CCGetRequestParam("mobiliarios_Insert", $Method, NULL), $this);
            $this->mobiliarios_Insert->Parameters = CCGetQueryString("QueryString", array("s_mobiliario_id", "ccsForm"));
            $this->mobiliarios_Insert->Page = "mobiliario.php";
        }
    }
//End Class_Initialize Event

//Initialize Method @124-F5980B9C
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urls_mobiliario_id"] = CCGetFromGet("s_mobiliario_id", NULL);
    }
//End Initialize Method

//Validate Method @124-89DCEA70
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->tipo_mobiliario_descrip->Validate() && $Validation);
        $Validation = ($this->tipo_estado_mobiliario_descrip->Validate() && $Validation);
        $Validation = ($this->mobiliario_id->Validate() && $Validation);
        $Validation = ($this->proveedor_razon_social->Validate() && $Validation);
        $Validation = ($this->centro_visualizacion_ident->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->tipo_mobiliario_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_mobiliario_descrip->Errors->Count() == 0);
        $Validation =  $Validation && ($this->mobiliario_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->proveedor_razon_social->Errors->Count() == 0);
        $Validation =  $Validation && ($this->centro_visualizacion_ident->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @124-4F4378D4
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->tipo_mobiliario_descrip->Errors->Count());
        $errors = ($errors || $this->tipo_estado_mobiliario_descrip->Errors->Count());
        $errors = ($errors || $this->mobiliario_id->Errors->Count());
        $errors = ($errors || $this->proveedor_razon_social->Errors->Count());
        $errors = ($errors || $this->centro_visualizacion_ident->Errors->Count());
        $errors = ($errors || $this->mobiliarios_Insert->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @124-517B5C36
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "";
            if($this->Button_Update->Pressed) {
                $this->PressedButton = "Button_Update";
            }
        }
        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Button_Update") {
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

//UpdateRow Method @124-92E06AB0
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @124-5039CC42
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
                    $this->tipo_mobiliario_descrip->SetValue($this->DataSource->tipo_mobiliario_descrip->GetValue());
                    $this->tipo_estado_mobiliario_descrip->SetValue($this->DataSource->tipo_estado_mobiliario_descrip->GetValue());
                    $this->mobiliario_id->SetValue($this->DataSource->mobiliario_id->GetValue());
                    $this->proveedor_razon_social->SetValue($this->DataSource->proveedor_razon_social->GetValue());
                    $this->centro_visualizacion_ident->SetValue($this->DataSource->centro_visualizacion_ident->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->tipo_mobiliario_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_mobiliario_descrip->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mobiliario_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->proveedor_razon_social->Errors->ToString());
            $Error = ComposeStrings($Error, $this->centro_visualizacion_ident->Errors->ToString());
            $Error = ComposeStrings($Error, $this->mobiliarios_Insert->Errors->ToString());
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
        $this->Button_Update->Visible = $this->EditMode && $this->UpdateAllowed;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->Button_Update->Show();
        $this->tipo_mobiliario_descrip->Show();
        $this->tipo_estado_mobiliario_descrip->Show();
        $this->mobiliario_id->Show();
        $this->proveedor_razon_social->Show();
        $this->centro_visualizacion_ident->Show();
        $this->mobiliarios_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End mobiliarios2 Class @124-FCB6E20C

class clsmobiliarios2DataSource extends clsDBminseg {  //mobiliarios2DataSource Class @124-2B260A12

//DataSource Variables @124-9582CB23
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $UpdateParameters;
    public $wp;
    public $AllParametersSet;

    public $UpdateFields = array();

    // Datasource fields
    public $tipo_mobiliario_descrip;
    public $tipo_estado_mobiliario_descrip;
    public $mobiliario_id;
    public $proveedor_razon_social;
    public $centro_visualizacion_ident;
    public $mobiliarios_Insert;
//End DataSource Variables

//DataSourceClass_Initialize Event @124-94EDDE75
    function clsmobiliarios2DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record mobiliarios2/Error";
        $this->Initialize();
        $this->tipo_mobiliario_descrip = new clsField("tipo_mobiliario_descrip", ccsText, "");
        
        $this->tipo_estado_mobiliario_descrip = new clsField("tipo_estado_mobiliario_descrip", ccsText, "");
        
        $this->mobiliario_id = new clsField("mobiliario_id", ccsText, "");
        
        $this->proveedor_razon_social = new clsField("proveedor_razon_social", ccsText, "");
        
        $this->centro_visualizacion_ident = new clsField("centro_visualizacion_ident", ccsText, "");
        
        $this->mobiliarios_Insert = new clsField("mobiliarios_Insert", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//Prepare Method @124-F1570126
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_mobiliario_id", ccsInteger, "", "", $this->Parameters["urls_mobiliario_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mobiliarios.mobiliario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @124-6709A0D8
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT mobiliarios.*, tipo_mobiliario_descrip, tipo_estado_mobiliario_descrip, proveedor_razon_social, centro_visualizacion_ident \n\n" .
        "FROM (((mobiliarios LEFT JOIN tipos_mobiliarios ON\n\n" .
        "mobiliarios.tipo_mobiliario_id = tipos_mobiliarios.tipo_mobiliario_id) LEFT JOIN tipos_estados_mobiliarios ON\n\n" .
        "mobiliarios.tipo_estado_mobiliario_id = tipos_estados_mobiliarios.tipo_estado_mobiliario_id) LEFT JOIN proveedores ON\n\n" .
        "mobiliarios.proveedor_mantenimiento_id = proveedores.proveedor_id) LEFT JOIN centros_visualizacion ON\n\n" .
        "mobiliarios.centro_visualizacion_id = centros_visualizacion.centro_visualizacion_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @124-1BFD512F
    function SetValues()
    {
        $this->tipo_mobiliario_descrip->SetDBValue($this->f("tipo_mobiliario_descrip"));
        $this->tipo_estado_mobiliario_descrip->SetDBValue($this->f("tipo_estado_mobiliario_descrip"));
        $this->mobiliario_id->SetDBValue($this->f("mobiliario_id"));
        $this->proveedor_razon_social->SetDBValue($this->f("proveedor_razon_social"));
        $this->centro_visualizacion_ident->SetDBValue($this->f("centro_visualizacion_ident"));
    }
//End SetValues Method

//Update Method @124-CD16A591
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "dss_mobiliario_id", ccsInteger, "", "", $this->CachedColumns["s_mobiliario_id"], "", false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $wp->Criterion[1] = $wp->Operation(opEqual, "mobiliario_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->SQL = CCBuildUpdate("mobiliarios", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End mobiliarios2DataSource Class @124-FCB6E20C

class clsGridmobiliarios3 { //mobiliarios3 class @169-BF3FBB10

//Variables @169-7A629867

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
    public $Sorter_usuario_creacion_id;
    public $Sorter_fecha_creacion;
    public $Sorter_usuario_modificacion_id;
    public $Sorter_fecha_modificacion;
//End Variables

//Class_Initialize Event @169-1AB23039
    function clsGridmobiliarios3($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "mobiliarios3";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid mobiliarios3";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmobiliarios3DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("mobiliarios3Order", "");
        $this->SorterDirection = CCGetParam("mobiliarios3Dir", "");

        $this->usuario_creacion_id = new clsControl(ccsLabel, "usuario_creacion_id", "usuario_creacion_id", ccsInteger, "", CCGetRequestParam("usuario_creacion_id", ccsGet, NULL), $this);
        $this->fecha_creacion = new clsControl(ccsLabel, "fecha_creacion", "fecha_creacion", ccsDate, $DefaultDateFormat, CCGetRequestParam("fecha_creacion", ccsGet, NULL), $this);
        $this->usuario_modificacion_id = new clsControl(ccsLabel, "usuario_modificacion_id", "usuario_modificacion_id", ccsInteger, "", CCGetRequestParam("usuario_modificacion_id", ccsGet, NULL), $this);
        $this->fecha_modificacion = new clsControl(ccsLabel, "fecha_modificacion", "fecha_modificacion", ccsDate, $DefaultDateFormat, CCGetRequestParam("fecha_modificacion", ccsGet, NULL), $this);
        $this->Sorter_usuario_creacion_id = new clsSorter($this->ComponentName, "Sorter_usuario_creacion_id", $FileName, $this);
        $this->Sorter_fecha_creacion = new clsSorter($this->ComponentName, "Sorter_fecha_creacion", $FileName, $this);
        $this->Sorter_usuario_modificacion_id = new clsSorter($this->ComponentName, "Sorter_usuario_modificacion_id", $FileName, $this);
        $this->Sorter_fecha_modificacion = new clsSorter($this->ComponentName, "Sorter_fecha_modificacion", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @169-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @169-34D5FACF
    function Show()
    {
        $Tpl = CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_mobiliario_id"] = CCGetFromGet("s_mobiliario_id", NULL);

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
            $this->ControlsVisible["usuario_creacion_id"] = $this->usuario_creacion_id->Visible;
            $this->ControlsVisible["fecha_creacion"] = $this->fecha_creacion->Visible;
            $this->ControlsVisible["usuario_modificacion_id"] = $this->usuario_modificacion_id->Visible;
            $this->ControlsVisible["fecha_modificacion"] = $this->fecha_modificacion->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->usuario_creacion_id->SetValue($this->DataSource->usuario_creacion_id->GetValue());
                $this->fecha_creacion->SetValue($this->DataSource->fecha_creacion->GetValue());
                $this->usuario_modificacion_id->SetValue($this->DataSource->usuario_modificacion_id->GetValue());
                $this->fecha_modificacion->SetValue($this->DataSource->fecha_modificacion->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->usuario_creacion_id->Show();
                $this->fecha_creacion->Show();
                $this->usuario_modificacion_id->Show();
                $this->fecha_modificacion->Show();
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
        $this->Sorter_usuario_creacion_id->Show();
        $this->Sorter_fecha_creacion->Show();
        $this->Sorter_usuario_modificacion_id->Show();
        $this->Sorter_fecha_modificacion->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @169-A1ED3EB6
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->usuario_creacion_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->fecha_creacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->usuario_modificacion_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->fecha_modificacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End mobiliarios3 Class @169-FCB6E20C

class clsmobiliarios3DataSource extends clsDBminseg {  //mobiliarios3DataSource Class @169-1746E91A

//DataSource Variables @169-C5573BCE
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $usuario_creacion_id;
    public $fecha_creacion;
    public $usuario_modificacion_id;
    public $fecha_modificacion;
//End DataSource Variables

//DataSourceClass_Initialize Event @169-E89E558F
    function clsmobiliarios3DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid mobiliarios3";
        $this->Initialize();
        $this->usuario_creacion_id = new clsField("usuario_creacion_id", ccsInteger, "");
        
        $this->fecha_creacion = new clsField("fecha_creacion", ccsDate, $this->DateFormat);
        
        $this->usuario_modificacion_id = new clsField("usuario_modificacion_id", ccsInteger, "");
        
        $this->fecha_modificacion = new clsField("fecha_modificacion", ccsDate, $this->DateFormat);
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @169-752AEBD5
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_usuario_creacion_id" => array("usuario_creacion_id", ""), 
            "Sorter_fecha_creacion" => array("fecha_creacion", ""), 
            "Sorter_usuario_modificacion_id" => array("usuario_modificacion_id", ""), 
            "Sorter_fecha_modificacion" => array("fecha_modificacion", "")));
    }
//End SetOrder Method

//Prepare Method @169-22052182
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_mobiliario_id", ccsInteger, "", "", $this->Parameters["urls_mobiliario_id"], 0, false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "mobiliario_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @169-25F4581E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (mobiliarios LEFT JOIN usuarios uc ON\n\n" .
        "mobiliarios.usuario_creacion_id = uc.usuario_id) LEFT JOIN usuarios um ON\n\n" .
        "mobiliarios.usuario_modificacion_id = um.usuario_id";
        $this->SQL = "SELECT mobiliarios.*, uc.usuario_nombre AS uc_usuario_nombre, um.usuario_nombre AS um_usuario_nombre \n\n" .
        "FROM (mobiliarios LEFT JOIN usuarios uc ON\n\n" .
        "mobiliarios.usuario_creacion_id = uc.usuario_id) LEFT JOIN usuarios um ON\n\n" .
        "mobiliarios.usuario_modificacion_id = um.usuario_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @169-DAD0B62D
    function SetValues()
    {
        $this->usuario_creacion_id->SetDBValue(trim($this->f("usuario_creacion_id")));
        $this->fecha_creacion->SetDBValue(trim($this->f("fecha_creacion")));
        $this->usuario_modificacion_id->SetDBValue(trim($this->f("usuario_modificacion_id")));
        $this->fecha_modificacion->SetDBValue(trim($this->f("fecha_modificacion")));
    }
//End SetValues Method

} //End mobiliarios3DataSource Class @169-FCB6E20C

//Initialize Page @1-879335D2
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
$TemplateFileName = "mobiliario.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$PathToRootOpt = "../";
$Scripts = "|js/jquery/jquery.js|js/jquery/event-manager.js|js/jquery/selectors.js|js/jquery/ui/jquery.ui.core.js|js/jquery/ui/jquery.ui.widget.js|js/jquery/ui/jquery.ui.position.js|js/jquery/ui/jquery.ui.menu.js|js/jquery/ui/jquery.ui.autocomplete.js|js/jquery/autocomplete/ccs-autocomplete.js|js/jquery/ui/jquery.ui.mouse.js|js/jquery/ui/jquery.ui.draggable.js|js/jquery/ui/jquery.ui.resizable.js|js/jquery/ui/jquery.ui.button.js|js/jquery/ui/jquery.ui.dialog.js|js/jquery/dialog/ccs-dialog.js|js/jquery/external/jquery.cookie.js|js/jquery/ui/jquery.ui.tabs.js|js/jquery/tab/ccs-tabs.js|js/jquery/updatepanel/ccs-update-panel.js|";
//End Initialize Page

//Include events file @1-2239BFA3
include_once("./mobiliario_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-A6027F41
$DBminseg = new clsDBminseg();
$MainPage->Connections["minseg"] = & $DBminseg;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$Panel1 = new clsPanel("Panel1", $MainPage);
$Panel1->GenerateDiv = true;
$Panel1->PanelId = "Panel1";
$mobiliariosSearch = new clsRecordmobiliariosSearch("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$Panel2->GenerateDiv = true;
$Panel2->PanelId = "Panel1Panel2";
$mobiliarios1 = new clsRecordmobiliarios1("", $MainPage);
$Panel3 = new clsPanel("Panel3", $MainPage);
$Panel3->GenerateDiv = true;
$Panel3->PanelId = "Panel1Panel3";
$Panel4 = new clsPanel("Panel4", $MainPage);
$Panel4->GenerateDiv = true;
$Panel4->PanelId = "Panel1Panel3Panel4";
$mobiliarios = new clsGridmobiliarios("", $MainPage);
$mobiliarios2 = new clsRecordmobiliarios2("", $MainPage);
$Panel5 = new clsPanel("Panel5", $MainPage);
$Panel5->GenerateDiv = true;
$Panel5->PanelId = "Panel1Panel3Panel5";
$mobiliarios3 = new clsGridmobiliarios3("", $MainPage);
$Panel6 = new clsPanel("Panel6", $MainPage);
$Panel6->GenerateDiv = true;
$Panel6->PanelId = "Panel1Panel3Panel6";
$MainPage->Panel1 = & $Panel1;
$MainPage->mobiliariosSearch = & $mobiliariosSearch;
$MainPage->Panel2 = & $Panel2;
$MainPage->mobiliarios1 = & $mobiliarios1;
$MainPage->Panel3 = & $Panel3;
$MainPage->Panel4 = & $Panel4;
$MainPage->mobiliarios = & $mobiliarios;
$MainPage->mobiliarios2 = & $mobiliarios2;
$MainPage->Panel5 = & $Panel5;
$MainPage->mobiliarios3 = & $mobiliarios3;
$MainPage->Panel6 = & $Panel6;
$Panel1->AddComponent("mobiliariosSearch", $mobiliariosSearch);
$Panel1->AddComponent("Panel2", $Panel2);
$Panel1->AddComponent("Panel3", $Panel3);
$Panel2->AddComponent("mobiliarios1", $mobiliarios1);
$Panel3->AddComponent("Panel4", $Panel4);
$Panel3->AddComponent("Panel5", $Panel5);
$Panel3->AddComponent("Panel6", $Panel6);
$Panel4->AddComponent("mobiliarios", $mobiliarios);
$Panel4->AddComponent("mobiliarios2", $mobiliarios2);
$Panel5->AddComponent("mobiliarios3", $mobiliarios3);
$mobiliarios1->Initialize();
$mobiliarios->Initialize();
$mobiliarios2->Initialize();
$mobiliarios3->Initialize();
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

//Initialize HTML Template @1-7D7DF5BA
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
if (strlen($TemplateSource)) {
    $Tpl->LoadTemplateFromStr($TemplateSource, $BlockToParse, "CP1252");
} else {
    $Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
}
$Tpl->SetVar("CCS_PathToRoot", $PathToRoot);
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "../");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-6951D17B
$mobiliarios2->Operation();
$mobiliarios1->Operation();
$mobiliariosSearch->Operation();
//End Execute Components

//Go to destination page @1-682C539F
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    unset($mobiliariosSearch);
    unset($mobiliarios1);
    unset($mobiliarios);
    unset($mobiliarios2);
    unset($mobiliarios3);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-0B3B8AB3
$Panel1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"" . "Arial\"><small>&#71" . ";enera&#116;&#101;d <" . "!-- SCC -->w&#105;&#" . "116;&#104; <!-- SCC --" . ">Code&#67;&#104;&#97;&#" . "114;&#103;&#101; <!" . "-- CCS -->St&#117;dio.<" . "/small></font></ce" . "nter>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"" . "Arial\"><small>&#71" . ";enera&#116;&#101;d <" . "!-- SCC -->w&#105;&#" . "116;&#104; <!-- SCC --" . ">Code&#67;&#104;&#97;&#" . "114;&#103;&#101; <!" . "-- CCS -->St&#117;dio.<" . "/small></font></ce" . "nter>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"" . "Arial\"><small>&#71" . ";enera&#116;&#101;d <" . "!-- SCC -->w&#105;&#" . "116;&#104; <!-- SCC --" . ">Code&#67;&#104;&#97;&#" . "114;&#103;&#101; <!" . "-- CCS -->St&#117;dio.<" . "/small></font></ce" . "nter>";
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-1DC2FFBD
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
unset($mobiliariosSearch);
unset($mobiliarios1);
unset($mobiliarios);
unset($mobiliarios2);
unset($mobiliarios3);
unset($Tpl);
//End Unload Page


?>
