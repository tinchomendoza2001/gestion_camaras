<?php
//Include Common Files @1-24972702
define("RelativePath", "..");
define("PathToCurrentPage", "/modulo_nvk/");
define("FileName", "nvk.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordnvkSearch { //nvkSearch Class @25-478F8FEF

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

//Class_Initialize Event @25-D98D22F1
    function clsRecordnvkSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record nvkSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "nvkSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->s_nvk_id = new clsControl(ccsTextBox, "s_nvk_id", "Nkv Id", ccsInteger, "", CCGetRequestParam("s_nvk_id", $Method, NULL), $this);
            $this->s_nvk_nro_serie = new clsControl(ccsTextBox, "s_nvk_nro_serie", "Nvk Nro Serie", ccsInteger, "", CCGetRequestParam("s_nvk_nro_serie", $Method, NULL), $this);
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
        }
    }
//End Class_Initialize Event

//Validate Method @25-A09C8FF7
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_nvk_id->Validate() && $Validation);
        $Validation = ($this->s_nvk_nro_serie->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_nvk_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_nvk_nro_serie->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @25-6676E2F6
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->s_nvk_id->Errors->Count());
        $errors = ($errors || $this->s_nvk_nro_serie->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @25-1A6C2DD7
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
        $Redirect = "nvk.php";
        if($this->PressedButton == "Button_Cancel") {
            if(!CCGetEvent($this->Button_Cancel->CCSEvents, "OnClick", $this->Button_Cancel)) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "nvk.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y", "Button_Cancel", "Button_Cancel_x", "Button_Cancel_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @25-E45BC98F
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
            $Error = ComposeStrings($Error, $this->s_nvk_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_nvk_nro_serie->Errors->ToString());
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

        $this->s_nvk_id->Show();
        $this->s_nvk_nro_serie->Show();
        $this->Button_DoSearch->Show();
        $this->Button_Cancel->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End nvkSearch Class @25-FCB6E20C

class clsRecordnvk2 { //nvk2 Class @30-5ED51301

//Variables @30-9E315808

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

//Class_Initialize Event @30-932B315E
    function clsRecordnvk2($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record nvk2/Error";
        $this->DataSource = new clsnvk2DataSource($this);
        $this->ds = & $this->DataSource;
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "nvk2";
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
            $this->nvk_marca = new clsControl(ccsTextBox, "nvk_marca", "Nvk Marca", ccsText, "", CCGetRequestParam("nvk_marca", $Method, NULL), $this);
            $this->nvk_modelo = new clsControl(ccsTextBox, "nvk_modelo", "Nvk Modelo", ccsText, "", CCGetRequestParam("nvk_modelo", $Method, NULL), $this);
            $this->nvk_nro_serie = new clsControl(ccsTextBox, "nvk_nro_serie", "Nvk Nro Serie", ccsInteger, "", CCGetRequestParam("nvk_nro_serie", $Method, NULL), $this);
            $this->nvk_capacidad = new clsControl(ccsTextBox, "nvk_capacidad", "Nvk Capacidad", ccsInteger, "", CCGetRequestParam("nvk_capacidad", $Method, NULL), $this);
            $this->proveedor_id = new clsControl(ccsListBox, "proveedor_id", "Proveedor Id", ccsInteger, "", CCGetRequestParam("proveedor_id", $Method, NULL), $this);
            $this->proveedor_id->DSType = dsTable;
            $this->proveedor_id->DataSource = new clsDBminseg();
            $this->proveedor_id->ds = & $this->proveedor_id->DataSource;
            $this->proveedor_id->DataSource->SQL = "SELECT * \n" .
"FROM proveedores {SQL_Where} {SQL_OrderBy}";
            list($this->proveedor_id->BoundColumn, $this->proveedor_id->TextColumn, $this->proveedor_id->DBFormat) = array("proveedor_id", "proveedor_razon_social", "");
            $this->centro_visualizacion_id = new clsControl(ccsListBox, "centro_visualizacion_id", "centro_visualizacion_id", ccsText, "", CCGetRequestParam("centro_visualizacion_id", $Method, NULL), $this);
            $this->centro_visualizacion_id->DSType = dsTable;
            $this->centro_visualizacion_id->DataSource = new clsDBminseg();
            $this->centro_visualizacion_id->ds = & $this->centro_visualizacion_id->DataSource;
            $this->centro_visualizacion_id->DataSource->SQL = "SELECT * \n" .
"FROM centros_visualizacion {SQL_Where} {SQL_OrderBy}";
            list($this->centro_visualizacion_id->BoundColumn, $this->centro_visualizacion_id->TextColumn, $this->centro_visualizacion_id->DBFormat) = array("centro_visualizacion_id", "centro_visualizacion_ident", "");
        }
    }
//End Class_Initialize Event

//Initialize Method @30-C402E538
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urls_nvk_id"] = CCGetFromGet("s_nvk_id", NULL);
    }
//End Initialize Method

//Validate Method @30-BB8E50B5
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->nvk_marca->Validate() && $Validation);
        $Validation = ($this->nvk_modelo->Validate() && $Validation);
        $Validation = ($this->nvk_nro_serie->Validate() && $Validation);
        $Validation = ($this->nvk_capacidad->Validate() && $Validation);
        $Validation = ($this->proveedor_id->Validate() && $Validation);
        $Validation = ($this->centro_visualizacion_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->nvk_marca->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nvk_modelo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nvk_nro_serie->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nvk_capacidad->Errors->Count() == 0);
        $Validation =  $Validation && ($this->proveedor_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->centro_visualizacion_id->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @30-0E90A720
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->nvk_marca->Errors->Count());
        $errors = ($errors || $this->nvk_modelo->Errors->Count());
        $errors = ($errors || $this->nvk_nro_serie->Errors->Count());
        $errors = ($errors || $this->nvk_capacidad->Errors->Count());
        $errors = ($errors || $this->proveedor_id->Errors->Count());
        $errors = ($errors || $this->centro_visualizacion_id->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @30-288F0419
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

//InsertRow Method @30-6B678FC0
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert", $this);
        if(!$this->InsertAllowed) return false;
        $this->DataSource->nvk_marca->SetValue($this->nvk_marca->GetValue(true));
        $this->DataSource->nvk_modelo->SetValue($this->nvk_modelo->GetValue(true));
        $this->DataSource->nvk_nro_serie->SetValue($this->nvk_nro_serie->GetValue(true));
        $this->DataSource->nvk_capacidad->SetValue($this->nvk_capacidad->GetValue(true));
        $this->DataSource->proveedor_id->SetValue($this->proveedor_id->GetValue(true));
        $this->DataSource->centro_visualizacion_id->SetValue($this->centro_visualizacion_id->GetValue(true));
        $this->DataSource->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert", $this);
        return (!$this->CheckErrors());
    }
//End InsertRow Method

//UpdateRow Method @30-AEFA708A
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->nvk_marca->SetValue($this->nvk_marca->GetValue(true));
        $this->DataSource->nvk_modelo->SetValue($this->nvk_modelo->GetValue(true));
        $this->DataSource->nvk_nro_serie->SetValue($this->nvk_nro_serie->GetValue(true));
        $this->DataSource->nvk_capacidad->SetValue($this->nvk_capacidad->GetValue(true));
        $this->DataSource->proveedor_id->SetValue($this->proveedor_id->GetValue(true));
        $this->DataSource->centro_visualizacion_id->SetValue($this->centro_visualizacion_id->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//DeleteRow Method @30-299D98C3
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete", $this);
        if(!$this->DeleteAllowed) return false;
        $this->DataSource->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete", $this);
        return (!$this->CheckErrors());
    }
//End DeleteRow Method

//Show Method @30-7CD3BCEE
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

        $this->proveedor_id->Prepare();
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
                    $this->nvk_marca->SetValue($this->DataSource->nvk_marca->GetValue());
                    $this->nvk_modelo->SetValue($this->DataSource->nvk_modelo->GetValue());
                    $this->nvk_nro_serie->SetValue($this->DataSource->nvk_nro_serie->GetValue());
                    $this->nvk_capacidad->SetValue($this->DataSource->nvk_capacidad->GetValue());
                    $this->proveedor_id->SetValue($this->DataSource->proveedor_id->GetValue());
                    $this->centro_visualizacion_id->SetValue($this->DataSource->centro_visualizacion_id->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->nvk_marca->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nvk_modelo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nvk_nro_serie->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nvk_capacidad->Errors->ToString());
            $Error = ComposeStrings($Error, $this->proveedor_id->Errors->ToString());
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
        $this->nvk_marca->Show();
        $this->nvk_modelo->Show();
        $this->nvk_nro_serie->Show();
        $this->nvk_capacidad->Show();
        $this->proveedor_id->Show();
        $this->centro_visualizacion_id->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End nvk2 Class @30-FCB6E20C

class clsnvk2DataSource extends clsDBminseg {  //nvk2DataSource Class @30-A54E35F2

//DataSource Variables @30-AA5EAD14
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
    public $nvk_marca;
    public $nvk_modelo;
    public $nvk_nro_serie;
    public $nvk_capacidad;
    public $proveedor_id;
    public $centro_visualizacion_id;
//End DataSource Variables

//DataSourceClass_Initialize Event @30-3BA37954
    function clsnvk2DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record nvk2/Error";
        $this->Initialize();
        $this->nvk_marca = new clsField("nvk_marca", ccsText, "");
        
        $this->nvk_modelo = new clsField("nvk_modelo", ccsText, "");
        
        $this->nvk_nro_serie = new clsField("nvk_nro_serie", ccsInteger, "");
        
        $this->nvk_capacidad = new clsField("nvk_capacidad", ccsInteger, "");
        
        $this->proveedor_id = new clsField("proveedor_id", ccsInteger, "");
        
        $this->centro_visualizacion_id = new clsField("centro_visualizacion_id", ccsText, "");
        

        $this->InsertFields["nvk_marca"] = array("Name" => "nvk_marca", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["nvk_modelo"] = array("Name" => "nvk_modelo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->InsertFields["nvk_nro_serie"] = array("Name" => "nvk_nro_serie", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["nvk_capacidad"] = array("Name" => "nvk_capacidad", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["proveedor_id"] = array("Name" => "proveedor_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->InsertFields["centro_visualizacion_id"] = array("Name" => "centro_visualizacion_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["nvk_marca"] = array("Name" => "nvk_marca", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["nvk_modelo"] = array("Name" => "nvk_modelo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["nvk_nro_serie"] = array("Name" => "nvk_nro_serie", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["nvk_capacidad"] = array("Name" => "nvk_capacidad", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["proveedor_id"] = array("Name" => "proveedor_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["centro_visualizacion_id"] = array("Name" => "centro_visualizacion_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @30-FBE0F8C9
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_nvk_id", ccsInteger, "", "", $this->Parameters["urls_nvk_id"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "nvk_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @30-5518ECF5
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM nvk {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @30-BC4689BB
    function SetValues()
    {
        $this->nvk_marca->SetDBValue($this->f("nvk_marca"));
        $this->nvk_modelo->SetDBValue($this->f("nvk_modelo"));
        $this->nvk_nro_serie->SetDBValue(trim($this->f("nvk_nro_serie")));
        $this->nvk_capacidad->SetDBValue(trim($this->f("nvk_capacidad")));
        $this->proveedor_id->SetDBValue(trim($this->f("proveedor_id")));
        $this->centro_visualizacion_id->SetDBValue($this->f("centro_visualizacion_id"));
    }
//End SetValues Method

//Insert Method @30-960AE6DB
    function Insert()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert", $this->Parent);
        $this->InsertFields["nvk_marca"]["Value"] = $this->nvk_marca->GetDBValue(true);
        $this->InsertFields["nvk_modelo"]["Value"] = $this->nvk_modelo->GetDBValue(true);
        $this->InsertFields["nvk_nro_serie"]["Value"] = $this->nvk_nro_serie->GetDBValue(true);
        $this->InsertFields["nvk_capacidad"]["Value"] = $this->nvk_capacidad->GetDBValue(true);
        $this->InsertFields["proveedor_id"]["Value"] = $this->proveedor_id->GetDBValue(true);
        $this->InsertFields["centro_visualizacion_id"]["Value"] = $this->centro_visualizacion_id->GetDBValue(true);
        $this->SQL = CCBuildInsert("nvk", $this->InsertFields, $this);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert", $this->Parent);
        }
    }
//End Insert Method

//Update Method @30-F8961138
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["nvk_marca"]["Value"] = $this->nvk_marca->GetDBValue(true);
        $this->UpdateFields["nvk_modelo"]["Value"] = $this->nvk_modelo->GetDBValue(true);
        $this->UpdateFields["nvk_nro_serie"]["Value"] = $this->nvk_nro_serie->GetDBValue(true);
        $this->UpdateFields["nvk_capacidad"]["Value"] = $this->nvk_capacidad->GetDBValue(true);
        $this->UpdateFields["proveedor_id"]["Value"] = $this->proveedor_id->GetDBValue(true);
        $this->UpdateFields["centro_visualizacion_id"]["Value"] = $this->centro_visualizacion_id->GetDBValue(true);
        $this->SQL = CCBuildUpdate("nvk", $this->UpdateFields, $this);
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

//Delete Method @30-9A47A8A9
    function Delete()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete", $this->Parent);
        $this->SQL = "DELETE FROM nvk";
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

} //End nvk2DataSource Class @30-FCB6E20C

class clsGridnvk1 { //nvk1 class @3-F1E93EC9

//Variables @3-7ECBE9DD

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
    public $Sorter_nkv_id;
    public $Sorter_nvk_marca;
    public $Sorter_nvk_modelo;
    public $Sorter_nvk_nro_serie;
    public $Sorter_nvk_capacidad;
//End Variables

//Class_Initialize Event @3-8699E181
    function clsGridnvk1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "nvk1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid nvk1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsnvk1DataSource($this);
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
        $this->SorterName = CCGetParam("nvk1Order", "");
        $this->SorterDirection = CCGetParam("nvk1Dir", "");

        $this->nvk_id = new clsControl(ccsLink, "nvk_id", "nvk_id", ccsInteger, "", CCGetRequestParam("nvk_id", ccsGet, NULL), $this);
        $this->nvk_id->Page = "";
        $this->nvk_marca = new clsControl(ccsLabel, "nvk_marca", "nvk_marca", ccsText, "", CCGetRequestParam("nvk_marca", ccsGet, NULL), $this);
        $this->nvk_modelo = new clsControl(ccsLabel, "nvk_modelo", "nvk_modelo", ccsText, "", CCGetRequestParam("nvk_modelo", ccsGet, NULL), $this);
        $this->nvk_nro_serie = new clsControl(ccsLabel, "nvk_nro_serie", "nvk_nro_serie", ccsInteger, "", CCGetRequestParam("nvk_nro_serie", ccsGet, NULL), $this);
        $this->nvk_capacidad = new clsControl(ccsLabel, "nvk_capacidad", "nvk_capacidad", ccsInteger, "", CCGetRequestParam("nvk_capacidad", ccsGet, NULL), $this);
        $this->Sorter_nkv_id = new clsSorter($this->ComponentName, "Sorter_nkv_id", $FileName, $this);
        $this->Sorter_nvk_marca = new clsSorter($this->ComponentName, "Sorter_nvk_marca", $FileName, $this);
        $this->Sorter_nvk_modelo = new clsSorter($this->ComponentName, "Sorter_nvk_modelo", $FileName, $this);
        $this->Sorter_nvk_nro_serie = new clsSorter($this->ComponentName, "Sorter_nvk_nro_serie", $FileName, $this);
        $this->Sorter_nvk_capacidad = new clsSorter($this->ComponentName, "Sorter_nvk_capacidad", $FileName, $this);
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

//Show Method @3-E888FD0C
    function Show()
    {
        $Tpl = CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_nvk_id"] = CCGetFromGet("s_nvk_id", NULL);

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
            $this->ControlsVisible["nvk_id"] = $this->nvk_id->Visible;
            $this->ControlsVisible["nvk_marca"] = $this->nvk_marca->Visible;
            $this->ControlsVisible["nvk_modelo"] = $this->nvk_modelo->Visible;
            $this->ControlsVisible["nvk_nro_serie"] = $this->nvk_nro_serie->Visible;
            $this->ControlsVisible["nvk_capacidad"] = $this->nvk_capacidad->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->nvk_id->SetValue($this->DataSource->nvk_id->GetValue());
                $this->nvk_id->Parameters = CCGetQueryString("QueryString", array("ccsForm"));
                $this->nvk_id->Parameters = CCAddParam($this->nvk_id->Parameters, "s_nvk_id", $this->DataSource->f("nvk_id"));
                $this->nvk_marca->SetValue($this->DataSource->nvk_marca->GetValue());
                $this->nvk_modelo->SetValue($this->DataSource->nvk_modelo->GetValue());
                $this->nvk_nro_serie->SetValue($this->DataSource->nvk_nro_serie->GetValue());
                $this->nvk_capacidad->SetValue($this->DataSource->nvk_capacidad->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->nvk_id->Show();
                $this->nvk_marca->Show();
                $this->nvk_modelo->Show();
                $this->nvk_nro_serie->Show();
                $this->nvk_capacidad->Show();
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
        $this->Sorter_nkv_id->Show();
        $this->Sorter_nvk_marca->Show();
        $this->Sorter_nvk_modelo->Show();
        $this->Sorter_nvk_nro_serie->Show();
        $this->Sorter_nvk_capacidad->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @3-12EADD66
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->nvk_id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nvk_marca->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nvk_modelo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nvk_nro_serie->Errors->ToString());
        $errors = ComposeStrings($errors, $this->nvk_capacidad->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End nvk1 Class @3-FCB6E20C

class clsnvk1DataSource extends clsDBminseg {  //nvk1DataSource Class @3-E1EF10EA

//DataSource Variables @3-75654998
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $nvk_id;
    public $nvk_marca;
    public $nvk_modelo;
    public $nvk_nro_serie;
    public $nvk_capacidad;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-A8ECF40A
    function clsnvk1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid nvk1";
        $this->Initialize();
        $this->nvk_id = new clsField("nvk_id", ccsInteger, "");
        
        $this->nvk_marca = new clsField("nvk_marca", ccsText, "");
        
        $this->nvk_modelo = new clsField("nvk_modelo", ccsText, "");
        
        $this->nvk_nro_serie = new clsField("nvk_nro_serie", ccsInteger, "");
        
        $this->nvk_capacidad = new clsField("nvk_capacidad", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @3-3038B7FB
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_nkv_id" => array("nkv_id", ""), 
            "Sorter_nvk_marca" => array("nvk_marca", ""), 
            "Sorter_nvk_modelo" => array("nvk_modelo", ""), 
            "Sorter_nvk_nro_serie" => array("nvk_nro_serie", ""), 
            "Sorter_nvk_capacidad" => array("nvk_capacidad", "")));
    }
//End SetOrder Method

//Prepare Method @3-7F0721F3
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_nvk_id", ccsInteger, "", "", $this->Parameters["urls_nvk_id"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "nvk_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @3-951899CD
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM nvk";
        $this->SQL = "SELECT * \n\n" .
        "FROM nvk {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-7BA54865
    function SetValues()
    {
        $this->nvk_id->SetDBValue(trim($this->f("nvk_id")));
        $this->nvk_marca->SetDBValue($this->f("nvk_marca"));
        $this->nvk_modelo->SetDBValue($this->f("nvk_modelo"));
        $this->nvk_nro_serie->SetDBValue(trim($this->f("nvk_nro_serie")));
        $this->nvk_capacidad->SetDBValue(trim($this->f("nvk_capacidad")));
    }
//End SetValues Method

} //End nvk1DataSource Class @3-FCB6E20C

class clsRecordnvk4 { //nvk4 Class @114-088FB487

//Variables @114-9E315808

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

//Class_Initialize Event @114-86065E77
    function clsRecordnvk4($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record nvk4/Error";
        $this->DataSource = new clsnvk4DataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "nvk4";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->nvk_marca = new clsControl(ccsTextBox, "nvk_marca", "Nvk Marca", ccsText, "", CCGetRequestParam("nvk_marca", $Method, NULL), $this);
            $this->nvk_modelo = new clsControl(ccsTextBox, "nvk_modelo", "Nvk Modelo", ccsText, "", CCGetRequestParam("nvk_modelo", $Method, NULL), $this);
            $this->nvk_nro_serie = new clsControl(ccsTextBox, "nvk_nro_serie", "Nvk Nro Serie", ccsInteger, "", CCGetRequestParam("nvk_nro_serie", $Method, NULL), $this);
            $this->nvk_capacidad = new clsControl(ccsTextBox, "nvk_capacidad", "Nvk Capacidad", ccsInteger, "", CCGetRequestParam("nvk_capacidad", $Method, NULL), $this);
            $this->nvk_id = new clsControl(ccsTextBox, "nvk_id", "nvk_id", ccsText, "", CCGetRequestParam("nvk_id", $Method, NULL), $this);
            $this->centro_visualizacion_ident = new clsControl(ccsTextBox, "centro_visualizacion_ident", "centro_visualizacion_ident", ccsText, "", CCGetRequestParam("centro_visualizacion_ident", $Method, NULL), $this);
            $this->tipo_estado_id = new clsControl(ccsTextBox, "tipo_estado_id", "Tipo Estado Id", ccsInteger, "", CCGetRequestParam("tipo_estado_id", $Method, NULL), $this);
            $this->proveedor_razon_social = new clsControl(ccsTextBox, "proveedor_razon_social", "proveedor_razon_social", ccsText, "", CCGetRequestParam("proveedor_razon_social", $Method, NULL), $this);
            $this->ultimo_mantenimiento = new clsControl(ccsTextBox, "ultimo_mantenimiento", "ultimo_mantenimiento", ccsText, "", CCGetRequestParam("ultimo_mantenimiento", $Method, NULL), $this);
            $this->nvk1_Insert = new clsControl(ccsLink, "nvk1_Insert", "nvk1_Insert", ccsText, "", CCGetRequestParam("nvk1_Insert", $Method, NULL), $this);
            $this->nvk1_Insert->Parameters = CCGetQueryString("QueryString", array("nkv_id", "ccsForm"));
            $this->nvk1_Insert->Page = "nvk.php";
        }
    }
//End Class_Initialize Event

//Initialize Method @114-C402E538
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urls_nvk_id"] = CCGetFromGet("s_nvk_id", NULL);
    }
//End Initialize Method

//Validate Method @114-404C5D55
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->nvk_marca->Validate() && $Validation);
        $Validation = ($this->nvk_modelo->Validate() && $Validation);
        $Validation = ($this->nvk_nro_serie->Validate() && $Validation);
        $Validation = ($this->nvk_capacidad->Validate() && $Validation);
        $Validation = ($this->nvk_id->Validate() && $Validation);
        $Validation = ($this->centro_visualizacion_ident->Validate() && $Validation);
        $Validation = ($this->tipo_estado_id->Validate() && $Validation);
        $Validation = ($this->proveedor_razon_social->Validate() && $Validation);
        $Validation = ($this->ultimo_mantenimiento->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->nvk_marca->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nvk_modelo->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nvk_nro_serie->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nvk_capacidad->Errors->Count() == 0);
        $Validation =  $Validation && ($this->nvk_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->centro_visualizacion_ident->Errors->Count() == 0);
        $Validation =  $Validation && ($this->tipo_estado_id->Errors->Count() == 0);
        $Validation =  $Validation && ($this->proveedor_razon_social->Errors->Count() == 0);
        $Validation =  $Validation && ($this->ultimo_mantenimiento->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @114-FC920CA4
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->nvk_marca->Errors->Count());
        $errors = ($errors || $this->nvk_modelo->Errors->Count());
        $errors = ($errors || $this->nvk_nro_serie->Errors->Count());
        $errors = ($errors || $this->nvk_capacidad->Errors->Count());
        $errors = ($errors || $this->nvk_id->Errors->Count());
        $errors = ($errors || $this->centro_visualizacion_ident->Errors->Count());
        $errors = ($errors || $this->tipo_estado_id->Errors->Count());
        $errors = ($errors || $this->proveedor_razon_social->Errors->Count());
        $errors = ($errors || $this->ultimo_mantenimiento->Errors->Count());
        $errors = ($errors || $this->nvk1_Insert->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @114-17DC9883
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

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//UpdateRow Method @114-9BB6E410
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->nvk_marca->SetValue($this->nvk_marca->GetValue(true));
        $this->DataSource->nvk_modelo->SetValue($this->nvk_modelo->GetValue(true));
        $this->DataSource->nvk_nro_serie->SetValue($this->nvk_nro_serie->GetValue(true));
        $this->DataSource->nvk_capacidad->SetValue($this->nvk_capacidad->GetValue(true));
        $this->DataSource->nvk_id->SetValue($this->nvk_id->GetValue(true));
        $this->DataSource->centro_visualizacion_ident->SetValue($this->centro_visualizacion_ident->GetValue(true));
        $this->DataSource->tipo_estado_id->SetValue($this->tipo_estado_id->GetValue(true));
        $this->DataSource->proveedor_razon_social->SetValue($this->proveedor_razon_social->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @114-5840BBF4
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
                    $this->nvk_marca->SetValue($this->DataSource->nvk_marca->GetValue());
                    $this->nvk_modelo->SetValue($this->DataSource->nvk_modelo->GetValue());
                    $this->nvk_nro_serie->SetValue($this->DataSource->nvk_nro_serie->GetValue());
                    $this->nvk_capacidad->SetValue($this->DataSource->nvk_capacidad->GetValue());
                    $this->nvk_id->SetValue($this->DataSource->nvk_id->GetValue());
                    $this->centro_visualizacion_ident->SetValue($this->DataSource->centro_visualizacion_ident->GetValue());
                    $this->tipo_estado_id->SetValue($this->DataSource->tipo_estado_id->GetValue());
                    $this->proveedor_razon_social->SetValue($this->DataSource->proveedor_razon_social->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->nvk_marca->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nvk_modelo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nvk_nro_serie->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nvk_capacidad->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nvk_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->centro_visualizacion_ident->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_estado_id->Errors->ToString());
            $Error = ComposeStrings($Error, $this->proveedor_razon_social->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ultimo_mantenimiento->Errors->ToString());
            $Error = ComposeStrings($Error, $this->nvk1_Insert->Errors->ToString());
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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->nvk_marca->Show();
        $this->nvk_modelo->Show();
        $this->nvk_nro_serie->Show();
        $this->nvk_capacidad->Show();
        $this->nvk_id->Show();
        $this->centro_visualizacion_ident->Show();
        $this->tipo_estado_id->Show();
        $this->proveedor_razon_social->Show();
        $this->ultimo_mantenimiento->Show();
        $this->nvk1_Insert->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End nvk4 Class @114-FCB6E20C

class clsnvk4DataSource extends clsDBminseg {  //nvk4DataSource Class @114-2C0C7FC2

//DataSource Variables @114-40E3CE58
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
    public $nvk_marca;
    public $nvk_modelo;
    public $nvk_nro_serie;
    public $nvk_capacidad;
    public $nvk_id;
    public $centro_visualizacion_ident;
    public $tipo_estado_id;
    public $proveedor_razon_social;
    public $ultimo_mantenimiento;
    public $nvk1_Insert;
//End DataSource Variables

//DataSourceClass_Initialize Event @114-9F397825
    function clsnvk4DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record nvk4/Error";
        $this->Initialize();
        $this->nvk_marca = new clsField("nvk_marca", ccsText, "");
        
        $this->nvk_modelo = new clsField("nvk_modelo", ccsText, "");
        
        $this->nvk_nro_serie = new clsField("nvk_nro_serie", ccsInteger, "");
        
        $this->nvk_capacidad = new clsField("nvk_capacidad", ccsInteger, "");
        
        $this->nvk_id = new clsField("nvk_id", ccsText, "");
        
        $this->centro_visualizacion_ident = new clsField("centro_visualizacion_ident", ccsText, "");
        
        $this->tipo_estado_id = new clsField("tipo_estado_id", ccsInteger, "");
        
        $this->proveedor_razon_social = new clsField("proveedor_razon_social", ccsText, "");
        
        $this->ultimo_mantenimiento = new clsField("ultimo_mantenimiento", ccsText, "");
        
        $this->nvk1_Insert = new clsField("nvk1_Insert", ccsText, "");
        

        $this->UpdateFields["nvk_marca"] = array("Name" => "nvk_marca", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["nvk_modelo"] = array("Name" => "nvk_modelo", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["nvk_nro_serie"] = array("Name" => "nvk_nro_serie", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["nvk_capacidad"] = array("Name" => "nvk_capacidad", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["nvk_id"] = array("Name" => "nvk_id", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["centro_visualizacion_ident"] = array("Name" => "centro_visualizacion_ident", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["tipo_estado_id"] = array("Name" => "tipo_estado_id", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["proveedor_razon_social"] = array("Name" => "proveedor_razon_social", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @114-018CE0D9
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_nvk_id", ccsInteger, "", "", $this->Parameters["urls_nvk_id"], 0, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "nvk.nvk_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @114-EA46E6EF
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT nvk.*, proveedor_razon_social, centro_visualizacion_ident \n\n" .
        "FROM (nvk LEFT JOIN proveedores ON\n\n" .
        "nvk.proveedor_id = proveedores.proveedor_id) LEFT JOIN centros_visualizacion ON\n\n" .
        "nvk.centro_visualizacion_id = centros_visualizacion.centro_visualizacion_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @114-F846D5D2
    function SetValues()
    {
        $this->nvk_marca->SetDBValue($this->f("nvk_marca"));
        $this->nvk_modelo->SetDBValue($this->f("nvk_modelo"));
        $this->nvk_nro_serie->SetDBValue(trim($this->f("nvk_nro_serie")));
        $this->nvk_capacidad->SetDBValue(trim($this->f("nvk_capacidad")));
        $this->nvk_id->SetDBValue($this->f("nvk_id"));
        $this->centro_visualizacion_ident->SetDBValue($this->f("centro_visualizacion_ident"));
        $this->tipo_estado_id->SetDBValue(trim($this->f("tipo_estado_id")));
        $this->proveedor_razon_social->SetDBValue($this->f("proveedor_razon_social"));
    }
//End SetValues Method

//Update Method @114-BA67CEF9
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->cp["nvk_marca"] = new clsSQLParameter("ctrlnvk_marca", ccsText, "", "", $this->nvk_marca->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["nvk_modelo"] = new clsSQLParameter("ctrlnvk_modelo", ccsText, "", "", $this->nvk_modelo->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["nvk_nro_serie"] = new clsSQLParameter("ctrlnvk_nro_serie", ccsInteger, "", "", $this->nvk_nro_serie->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["nvk_capacidad"] = new clsSQLParameter("ctrlnvk_capacidad", ccsInteger, "", "", $this->nvk_capacidad->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["nvk_id"] = new clsSQLParameter("ctrlnvk_id", ccsText, "", "", $this->nvk_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["centro_visualizacion_ident"] = new clsSQLParameter("ctrlcentro_visualizacion_ident", ccsText, "", "", $this->centro_visualizacion_ident->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["tipo_estado_id"] = new clsSQLParameter("ctrltipo_estado_id", ccsInteger, "", "", $this->tipo_estado_id->GetValue(true), NULL, false, $this->ErrorBlock);
        $this->cp["proveedor_razon_social"] = new clsSQLParameter("ctrlproveedor_razon_social", ccsText, "", "", $this->proveedor_razon_social->GetValue(true), NULL, false, $this->ErrorBlock);
        $wp = new clsSQLParameters($this->ErrorBlock);
        $wp->AddParameter("1", "urls_nvk_id", ccsInteger, "", "", CCGetFromGet("s_nvk_id", NULL), 0, false);
        if(!$wp->AllParamsSet()) {
            $this->Errors->addError($CCSLocales->GetText("CCS_CustomOperationError_MissingParameters"));
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        if (!is_null($this->cp["nvk_marca"]->GetValue()) and !strlen($this->cp["nvk_marca"]->GetText()) and !is_bool($this->cp["nvk_marca"]->GetValue())) 
            $this->cp["nvk_marca"]->SetValue($this->nvk_marca->GetValue(true));
        if (!is_null($this->cp["nvk_modelo"]->GetValue()) and !strlen($this->cp["nvk_modelo"]->GetText()) and !is_bool($this->cp["nvk_modelo"]->GetValue())) 
            $this->cp["nvk_modelo"]->SetValue($this->nvk_modelo->GetValue(true));
        if (!is_null($this->cp["nvk_nro_serie"]->GetValue()) and !strlen($this->cp["nvk_nro_serie"]->GetText()) and !is_bool($this->cp["nvk_nro_serie"]->GetValue())) 
            $this->cp["nvk_nro_serie"]->SetValue($this->nvk_nro_serie->GetValue(true));
        if (!is_null($this->cp["nvk_capacidad"]->GetValue()) and !strlen($this->cp["nvk_capacidad"]->GetText()) and !is_bool($this->cp["nvk_capacidad"]->GetValue())) 
            $this->cp["nvk_capacidad"]->SetValue($this->nvk_capacidad->GetValue(true));
        if (!is_null($this->cp["nvk_id"]->GetValue()) and !strlen($this->cp["nvk_id"]->GetText()) and !is_bool($this->cp["nvk_id"]->GetValue())) 
            $this->cp["nvk_id"]->SetValue($this->nvk_id->GetValue(true));
        if (!is_null($this->cp["centro_visualizacion_ident"]->GetValue()) and !strlen($this->cp["centro_visualizacion_ident"]->GetText()) and !is_bool($this->cp["centro_visualizacion_ident"]->GetValue())) 
            $this->cp["centro_visualizacion_ident"]->SetValue($this->centro_visualizacion_ident->GetValue(true));
        if (!is_null($this->cp["tipo_estado_id"]->GetValue()) and !strlen($this->cp["tipo_estado_id"]->GetText()) and !is_bool($this->cp["tipo_estado_id"]->GetValue())) 
            $this->cp["tipo_estado_id"]->SetValue($this->tipo_estado_id->GetValue(true));
        if (!is_null($this->cp["proveedor_razon_social"]->GetValue()) and !strlen($this->cp["proveedor_razon_social"]->GetText()) and !is_bool($this->cp["proveedor_razon_social"]->GetValue())) 
            $this->cp["proveedor_razon_social"]->SetValue($this->proveedor_razon_social->GetValue(true));
        $wp->Criterion[1] = $wp->Operation(opEqual, "nvk.nvk_id", $wp->GetDBValue("1"), $this->ToSQL($wp->GetDBValue("1"), ccsInteger),false);
        $Where = 
             $wp->Criterion[1];
        $this->UpdateFields["nvk_marca"]["Value"] = $this->cp["nvk_marca"]->GetDBValue(true);
        $this->UpdateFields["nvk_modelo"]["Value"] = $this->cp["nvk_modelo"]->GetDBValue(true);
        $this->UpdateFields["nvk_nro_serie"]["Value"] = $this->cp["nvk_nro_serie"]->GetDBValue(true);
        $this->UpdateFields["nvk_capacidad"]["Value"] = $this->cp["nvk_capacidad"]->GetDBValue(true);
        $this->UpdateFields["nvk_id"]["Value"] = $this->cp["nvk_id"]->GetDBValue(true);
        $this->UpdateFields["centro_visualizacion_ident"]["Value"] = $this->cp["centro_visualizacion_ident"]->GetDBValue(true);
        $this->UpdateFields["tipo_estado_id"]["Value"] = $this->cp["tipo_estado_id"]->GetDBValue(true);
        $this->UpdateFields["proveedor_razon_social"]["Value"] = $this->cp["proveedor_razon_social"]->GetDBValue(true);
        $this->SQL = CCBuildUpdate("nvk", $this->UpdateFields, $this);
        $this->SQL .= strlen($Where) ? " WHERE " . $Where : $Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate", $this->Parent);
        if($this->Errors->Count() == 0 && $this->CmdExecution) {
            $this->query($this->SQL);
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate", $this->Parent);
        }
    }
//End Update Method

} //End nvk4DataSource Class @114-FCB6E20C

class clsGridnvk3 { //nvk3 class @104-C3DF5C4B

//Variables @104-6E51DF5A

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
//End Variables

//Class_Initialize Event @104-BC91E8E4
    function clsGridnvk3($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "nvk3";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid nvk3";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsnvk3DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 1;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<BR>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->uc_usuario_nombre = new clsControl(ccsLabel, "uc_usuario_nombre", "uc_usuario_nombre", ccsText, "", CCGetRequestParam("uc_usuario_nombre", ccsGet, NULL), $this);
        $this->fecha_creacion = new clsControl(ccsLabel, "fecha_creacion", "fecha_creacion", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "H", ":", "nn"), CCGetRequestParam("fecha_creacion", ccsGet, NULL), $this);
        $this->um_usuario_nombre = new clsControl(ccsLabel, "um_usuario_nombre", "um_usuario_nombre", ccsText, "", CCGetRequestParam("um_usuario_nombre", ccsGet, NULL), $this);
        $this->fecha_modificacion = new clsControl(ccsLabel, "fecha_modificacion", "fecha_modificacion", ccsDate, array("dd", "/", "mm", "/", "yyyy", " ", "H", ":", "nn"), CCGetRequestParam("fecha_modificacion", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @104-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @104-C893B4B6
    function Show()
    {
        $Tpl = CCGetTemplate($this);
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_nvk_id"] = CCGetFromGet("s_nvk_id", NULL);

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
            $this->ControlsVisible["uc_usuario_nombre"] = $this->uc_usuario_nombre->Visible;
            $this->ControlsVisible["fecha_creacion"] = $this->fecha_creacion->Visible;
            $this->ControlsVisible["um_usuario_nombre"] = $this->um_usuario_nombre->Visible;
            $this->ControlsVisible["fecha_modificacion"] = $this->fecha_modificacion->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->uc_usuario_nombre->SetValue($this->DataSource->uc_usuario_nombre->GetValue());
                $this->fecha_creacion->SetValue($this->DataSource->fecha_creacion->GetValue());
                $this->um_usuario_nombre->SetValue($this->DataSource->um_usuario_nombre->GetValue());
                $this->fecha_modificacion->SetValue($this->DataSource->fecha_modificacion->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->uc_usuario_nombre->Show();
                $this->fecha_creacion->Show();
                $this->um_usuario_nombre->Show();
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
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @104-2F406452
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->uc_usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->fecha_creacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->um_usuario_nombre->Errors->ToString());
        $errors = ComposeStrings($errors, $this->fecha_modificacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End nvk3 Class @104-FCB6E20C

class clsnvk3DataSource extends clsDBminseg {  //nvk3DataSource Class @104-992ED6FA

//DataSource Variables @104-005ABCA9
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $uc_usuario_nombre;
    public $fecha_creacion;
    public $um_usuario_nombre;
    public $fecha_modificacion;
//End DataSource Variables

//DataSourceClass_Initialize Event @104-1D91CE8C
    function clsnvk3DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid nvk3";
        $this->Initialize();
        $this->uc_usuario_nombre = new clsField("uc_usuario_nombre", ccsText, "");
        
        $this->fecha_creacion = new clsField("fecha_creacion", ccsDate, $this->DateFormat);
        
        $this->um_usuario_nombre = new clsField("um_usuario_nombre", ccsText, "");
        
        $this->fecha_modificacion = new clsField("fecha_modificacion", ccsDate, $this->DateFormat);
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @104-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @104-883212AA
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_nvk_id", ccsInteger, "", "", $this->Parameters["urls_nvk_id"], 0, false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "nvk.nvk_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @104-290CA350
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM (nvk LEFT JOIN usuarios uc ON\n\n" .
        "nvk.usuario_creacion_id = uc.usuario_id) LEFT JOIN usuarios um ON\n\n" .
        "nvk.usuario_modificacion_id = um.usuario_id";
        $this->SQL = "SELECT nvk.*, uc.usuario_nombre AS uc_usuario_nombre, um.usuario_nombre AS um_usuario_nombre \n\n" .
        "FROM (nvk LEFT JOIN usuarios uc ON\n\n" .
        "nvk.usuario_creacion_id = uc.usuario_id) LEFT JOIN usuarios um ON\n\n" .
        "nvk.usuario_modificacion_id = um.usuario_id {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @104-CB2890AB
    function SetValues()
    {
        $this->uc_usuario_nombre->SetDBValue($this->f("uc_usuario_nombre"));
        $this->fecha_creacion->SetDBValue(trim($this->f("fecha_creacion")));
        $this->um_usuario_nombre->SetDBValue($this->f("um_usuario_nombre"));
        $this->fecha_modificacion->SetDBValue(trim($this->f("fecha_modificacion")));
    }
//End SetValues Method

} //End nvk3DataSource Class @104-FCB6E20C

//Initialize Page @1-8DD69EDF
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
$TemplateFileName = "nvk.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$PathToRootOpt = "../";
$Scripts = "|js/jquery/jquery.js|js/jquery/event-manager.js|js/jquery/selectors.js|js/jquery/ui/jquery.ui.core.js|js/jquery/ui/jquery.ui.widget.js|js/jquery/ui/jquery.ui.position.js|js/jquery/ui/jquery.ui.menu.js|js/jquery/ui/jquery.ui.autocomplete.js|js/jquery/autocomplete/ccs-autocomplete.js|js/jquery/ui/jquery.ui.mouse.js|js/jquery/ui/jquery.ui.draggable.js|js/jquery/ui/jquery.ui.resizable.js|js/jquery/ui/jquery.ui.button.js|js/jquery/ui/jquery.ui.dialog.js|js/jquery/dialog/ccs-dialog.js|js/jquery/external/jquery.cookie.js|js/jquery/ui/jquery.ui.tabs.js|js/jquery/tab/ccs-tabs.js|js/jquery/updatepanel/ccs-update-panel.js|";
//End Initialize Page

//Include events file @1-C808DA5A
include_once("./nvk_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-CE0F147D
$DBminseg = new clsDBminseg();
$MainPage->Connections["minseg"] = & $DBminseg;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$Panel1 = new clsPanel("Panel1", $MainPage);
$Panel1->GenerateDiv = true;
$Panel1->PanelId = "Panel1";
$nvkSearch = new clsRecordnvkSearch("", $MainPage);
$Panel2 = new clsPanel("Panel2", $MainPage);
$Panel2->GenerateDiv = true;
$Panel2->PanelId = "Panel1Panel2";
$nvk2 = new clsRecordnvk2("", $MainPage);
$Panel3 = new clsPanel("Panel3", $MainPage);
$Panel3->GenerateDiv = true;
$Panel3->PanelId = "Panel1Panel3";
$Panel4 = new clsPanel("Panel4", $MainPage);
$Panel4->GenerateDiv = true;
$Panel4->PanelId = "Panel1Panel3Panel4";
$nvk1 = new clsGridnvk1("", $MainPage);
$nvk4 = new clsRecordnvk4("", $MainPage);
$Panel5 = new clsPanel("Panel5", $MainPage);
$Panel5->GenerateDiv = true;
$Panel5->PanelId = "Panel1Panel3Panel5";
$nvk3 = new clsGridnvk3("", $MainPage);
$Panel6 = new clsPanel("Panel6", $MainPage);
$Panel6->GenerateDiv = true;
$Panel6->PanelId = "Panel1Panel3Panel6";
$MainPage->Panel1 = & $Panel1;
$MainPage->nvkSearch = & $nvkSearch;
$MainPage->Panel2 = & $Panel2;
$MainPage->nvk2 = & $nvk2;
$MainPage->Panel3 = & $Panel3;
$MainPage->Panel4 = & $Panel4;
$MainPage->nvk1 = & $nvk1;
$MainPage->nvk4 = & $nvk4;
$MainPage->Panel5 = & $Panel5;
$MainPage->nvk3 = & $nvk3;
$MainPage->Panel6 = & $Panel6;
$Panel1->AddComponent("nvkSearch", $nvkSearch);
$Panel1->AddComponent("Panel2", $Panel2);
$Panel1->AddComponent("Panel3", $Panel3);
$Panel2->AddComponent("nvk2", $nvk2);
$Panel3->AddComponent("Panel4", $Panel4);
$Panel3->AddComponent("Panel5", $Panel5);
$Panel3->AddComponent("Panel6", $Panel6);
$Panel4->AddComponent("nvk1", $nvk1);
$Panel4->AddComponent("nvk4", $nvk4);
$Panel5->AddComponent("nvk3", $nvk3);
$nvk2->Initialize();
$nvk1->Initialize();
$nvk4->Initialize();
$nvk3->Initialize();
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

//Execute Components @1-70B3F7B4
$nvk4->Operation();
$nvk2->Operation();
$nvkSearch->Operation();
//End Execute Components

//Go to destination page @1-24BC630A
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    unset($nvkSearch);
    unset($nvk2);
    unset($nvk1);
    unset($nvk4);
    unset($nvk3);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-A04F8110
$Panel1->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", "<center><font face=\"Arial\"><small>Gen&#101;&#114;ated <!-- SCC -->wit&#104; <!-- SCC -->CodeCh&#97;r&#103;&#101; <!-- SCC -->&#83;&#116;u&#100;i&#111;.</small></font></center>" . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", "<center><font face=\"Arial\"><small>Gen&#101;&#114;ated <!-- SCC -->wit&#104; <!-- SCC -->CodeCh&#97;r&#103;&#101; <!-- SCC -->&#83;&#116;u&#100;i&#111;.</small></font></center>" . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= "<center><font face=\"Arial\"><small>Gen&#101;&#114;ated <!-- SCC -->wit&#104; <!-- SCC -->CodeCh&#97;r&#103;&#101; <!-- SCC -->&#83;&#116;u&#100;i&#111;.</small></font></center>";
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $TemplateEncoding);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-0A476313
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
unset($nvkSearch);
unset($nvk2);
unset($nvk1);
unset($nvk4);
unset($nvk3);
unset($Tpl);
//End Unload Page


?>
