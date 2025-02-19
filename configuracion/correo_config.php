<?php
//Include Common Files @1-32D5B747
define("RelativePath", "..");
define("PathToCurrentPage", "/configuracion/");
define("FileName", "correo_config.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsRecordcamera_email_config { //camera_email_config Class @3-378D5286

//Variables @3-9E315808

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

//Class_Initialize Event @3-7639BA8C
    function clsRecordcamera_email_config($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record camera_email_config/Error";
        $this->DataSource = new clscamera_email_configDataSource($this);
        $this->ds = & $this->DataSource;
        $this->UpdateAllowed = true;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "camera_email_config";
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
            $this->Button_Cancel = new clsButton("Button_Cancel", $Method, $this);
            $this->EMAIL = new clsControl(ccsTextBox, "EMAIL", $CCSLocales->GetText("EMAIL"), ccsText, "", CCGetRequestParam("EMAIL", $Method, NULL), $this);
            $this->NAME = new clsControl(ccsTextBox, "NAME", $CCSLocales->GetText("NAME"), ccsText, "", CCGetRequestParam("NAME", $Method, NULL), $this);
            $this->HOST = new clsControl(ccsTextBox, "HOST", $CCSLocales->GetText("HOST"), ccsText, "", CCGetRequestParam("HOST", $Method, NULL), $this);
            $this->PORT = new clsControl(ccsTextBox, "PORT", $CCSLocales->GetText("PORT"), ccsInteger, "", CCGetRequestParam("PORT", $Method, NULL), $this);
            $this->SMTPSECURE = new clsControl(ccsTextBox, "SMTPSECURE", $CCSLocales->GetText("SMTPSECURE"), ccsText, "", CCGetRequestParam("SMTPSECURE", $Method, NULL), $this);
            $this->USERNAME = new clsControl(ccsTextBox, "USERNAME", $CCSLocales->GetText("USERNAME"), ccsText, "", CCGetRequestParam("USERNAME", $Method, NULL), $this);
            $this->PASSWORD = new clsControl(ccsTextBox, "PASSWORD", $CCSLocales->GetText("PASSWORD"), ccsText, "", CCGetRequestParam("PASSWORD", $Method, NULL), $this);
            $this->SMTPAUTH = new clsControl(ccsTextBox, "SMTPAUTH", $CCSLocales->GetText("SMTPAUTH"), ccsText, "", CCGetRequestParam("SMTPAUTH", $Method, NULL), $this);
            $this->AUTHTYPE = new clsControl(ccsTextBox, "AUTHTYPE", $CCSLocales->GetText("AUTHTYPE"), ccsText, "", CCGetRequestParam("AUTHTYPE", $Method, NULL), $this);
            $this->CHARSET = new clsControl(ccsTextBox, "CHARSET", $CCSLocales->GetText("CHARSET"), ccsText, "", CCGetRequestParam("CHARSET", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @3-14A378B1
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["expr19"] = 1;
    }
//End Initialize Method

//Validate Method @3-D9972D15
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->EMAIL->Validate() && $Validation);
        $Validation = ($this->NAME->Validate() && $Validation);
        $Validation = ($this->HOST->Validate() && $Validation);
        $Validation = ($this->PORT->Validate() && $Validation);
        $Validation = ($this->SMTPSECURE->Validate() && $Validation);
        $Validation = ($this->USERNAME->Validate() && $Validation);
        $Validation = ($this->PASSWORD->Validate() && $Validation);
        $Validation = ($this->SMTPAUTH->Validate() && $Validation);
        $Validation = ($this->AUTHTYPE->Validate() && $Validation);
        $Validation = ($this->CHARSET->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->EMAIL->Errors->Count() == 0);
        $Validation =  $Validation && ($this->NAME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->HOST->Errors->Count() == 0);
        $Validation =  $Validation && ($this->PORT->Errors->Count() == 0);
        $Validation =  $Validation && ($this->SMTPSECURE->Errors->Count() == 0);
        $Validation =  $Validation && ($this->USERNAME->Errors->Count() == 0);
        $Validation =  $Validation && ($this->PASSWORD->Errors->Count() == 0);
        $Validation =  $Validation && ($this->SMTPAUTH->Errors->Count() == 0);
        $Validation =  $Validation && ($this->AUTHTYPE->Errors->Count() == 0);
        $Validation =  $Validation && ($this->CHARSET->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @3-FAD75446
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->EMAIL->Errors->Count());
        $errors = ($errors || $this->NAME->Errors->Count());
        $errors = ($errors || $this->HOST->Errors->Count());
        $errors = ($errors || $this->PORT->Errors->Count());
        $errors = ($errors || $this->SMTPSECURE->Errors->Count());
        $errors = ($errors || $this->USERNAME->Errors->Count());
        $errors = ($errors || $this->PASSWORD->Errors->Count());
        $errors = ($errors || $this->SMTPAUTH->Errors->Count());
        $errors = ($errors || $this->AUTHTYPE->Errors->Count());
        $errors = ($errors || $this->CHARSET->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//Operation Method @3-5B06BA55
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
            $this->PressedButton = $this->EditMode ? "Button_Update" : "Button_Cancel";
            if($this->Button_Update->Pressed) {
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

//UpdateRow Method @3-F21742B5
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate", $this);
        if(!$this->UpdateAllowed) return false;
        $this->DataSource->EMAIL->SetValue($this->EMAIL->GetValue(true));
        $this->DataSource->NAME->SetValue($this->NAME->GetValue(true));
        $this->DataSource->HOST->SetValue($this->HOST->GetValue(true));
        $this->DataSource->PORT->SetValue($this->PORT->GetValue(true));
        $this->DataSource->SMTPSECURE->SetValue($this->SMTPSECURE->GetValue(true));
        $this->DataSource->USERNAME->SetValue($this->USERNAME->GetValue(true));
        $this->DataSource->PASSWORD->SetValue($this->PASSWORD->GetValue(true));
        $this->DataSource->SMTPAUTH->SetValue($this->SMTPAUTH->GetValue(true));
        $this->DataSource->AUTHTYPE->SetValue($this->AUTHTYPE->GetValue(true));
        $this->DataSource->CHARSET->SetValue($this->CHARSET->GetValue(true));
        $this->DataSource->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate", $this);
        return (!$this->CheckErrors());
    }
//End UpdateRow Method

//Show Method @3-7AE3C9BC
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
                    $this->EMAIL->SetValue($this->DataSource->EMAIL->GetValue());
                    $this->NAME->SetValue($this->DataSource->NAME->GetValue());
                    $this->HOST->SetValue($this->DataSource->HOST->GetValue());
                    $this->PORT->SetValue($this->DataSource->PORT->GetValue());
                    $this->SMTPSECURE->SetValue($this->DataSource->SMTPSECURE->GetValue());
                    $this->USERNAME->SetValue($this->DataSource->USERNAME->GetValue());
                    $this->PASSWORD->SetValue($this->DataSource->PASSWORD->GetValue());
                    $this->SMTPAUTH->SetValue($this->DataSource->SMTPAUTH->GetValue());
                    $this->AUTHTYPE->SetValue($this->DataSource->AUTHTYPE->GetValue());
                    $this->CHARSET->SetValue($this->DataSource->CHARSET->GetValue());
                }
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->EMAIL->Errors->ToString());
            $Error = ComposeStrings($Error, $this->NAME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->HOST->Errors->ToString());
            $Error = ComposeStrings($Error, $this->PORT->Errors->ToString());
            $Error = ComposeStrings($Error, $this->SMTPSECURE->Errors->ToString());
            $Error = ComposeStrings($Error, $this->USERNAME->Errors->ToString());
            $Error = ComposeStrings($Error, $this->PASSWORD->Errors->ToString());
            $Error = ComposeStrings($Error, $this->SMTPAUTH->Errors->ToString());
            $Error = ComposeStrings($Error, $this->AUTHTYPE->Errors->ToString());
            $Error = ComposeStrings($Error, $this->CHARSET->Errors->ToString());
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
        $this->Button_Cancel->Show();
        $this->EMAIL->Show();
        $this->NAME->Show();
        $this->HOST->Show();
        $this->PORT->Show();
        $this->SMTPSECURE->Show();
        $this->USERNAME->Show();
        $this->PASSWORD->Show();
        $this->SMTPAUTH->Show();
        $this->AUTHTYPE->Show();
        $this->CHARSET->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End camera_email_config Class @3-FCB6E20C

class clscamera_email_configDataSource extends clsDBminseg {  //camera_email_configDataSource Class @3-D7591332

//DataSource Variables @3-ECD51FEB
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
    public $EMAIL;
    public $NAME;
    public $HOST;
    public $PORT;
    public $SMTPSECURE;
    public $USERNAME;
    public $PASSWORD;
    public $SMTPAUTH;
    public $AUTHTYPE;
    public $CHARSET;
//End DataSource Variables

//DataSourceClass_Initialize Event @3-5D60A470
    function clscamera_email_configDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record camera_email_config/Error";
        $this->Initialize();
        $this->EMAIL = new clsField("EMAIL", ccsText, "");
        
        $this->NAME = new clsField("NAME", ccsText, "");
        
        $this->HOST = new clsField("HOST", ccsText, "");
        
        $this->PORT = new clsField("PORT", ccsInteger, "");
        
        $this->SMTPSECURE = new clsField("SMTPSECURE", ccsText, "");
        
        $this->USERNAME = new clsField("USERNAME", ccsText, "");
        
        $this->PASSWORD = new clsField("PASSWORD", ccsText, "");
        
        $this->SMTPAUTH = new clsField("SMTPAUTH", ccsText, "");
        
        $this->AUTHTYPE = new clsField("AUTHTYPE", ccsText, "");
        
        $this->CHARSET = new clsField("CHARSET", ccsText, "");
        

        $this->UpdateFields["EMAIL"] = array("Name" => "EMAIL", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["NAME"] = array("Name" => "NAME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["HOST"] = array("Name" => "HOST", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["PORT"] = array("Name" => "PORT", "Value" => "", "DataType" => ccsInteger, "OmitIfEmpty" => 1);
        $this->UpdateFields["SMTPSECURE"] = array("Name" => "SMTPSECURE", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["USERNAME"] = array("Name" => "USERNAME", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["PASSWORD"] = array("Name" => "PASSWORD", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["SMTPAUTH"] = array("Name" => "SMTPAUTH", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["AUTHTYPE"] = array("Name" => "AUTHTYPE", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
        $this->UpdateFields["CHARSET"] = array("Name" => "CHARSET", "Value" => "", "DataType" => ccsText, "OmitIfEmpty" => 1);
    }
//End DataSourceClass_Initialize Event

//Prepare Method @3-BDA2D06D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "expr19", ccsInteger, "", "", $this->Parameters["expr19"], 1, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "camera_email_config_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @3-A4193AAA
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_email_config {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @3-134A3FBB
    function SetValues()
    {
        $this->EMAIL->SetDBValue($this->f("EMAIL"));
        $this->NAME->SetDBValue($this->f("NAME"));
        $this->HOST->SetDBValue($this->f("HOST"));
        $this->PORT->SetDBValue(trim($this->f("PORT")));
        $this->SMTPSECURE->SetDBValue($this->f("SMTPSECURE"));
        $this->USERNAME->SetDBValue($this->f("USERNAME"));
        $this->PASSWORD->SetDBValue($this->f("PASSWORD"));
        $this->SMTPAUTH->SetDBValue($this->f("SMTPAUTH"));
        $this->AUTHTYPE->SetDBValue($this->f("AUTHTYPE"));
        $this->CHARSET->SetDBValue($this->f("CHARSET"));
    }
//End SetValues Method

//Update Method @3-5F8190D1
    function Update()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->CmdExecution = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate", $this->Parent);
        $this->UpdateFields["EMAIL"]["Value"] = $this->EMAIL->GetDBValue(true);
        $this->UpdateFields["NAME"]["Value"] = $this->NAME->GetDBValue(true);
        $this->UpdateFields["HOST"]["Value"] = $this->HOST->GetDBValue(true);
        $this->UpdateFields["PORT"]["Value"] = $this->PORT->GetDBValue(true);
        $this->UpdateFields["SMTPSECURE"]["Value"] = $this->SMTPSECURE->GetDBValue(true);
        $this->UpdateFields["USERNAME"]["Value"] = $this->USERNAME->GetDBValue(true);
        $this->UpdateFields["PASSWORD"]["Value"] = $this->PASSWORD->GetDBValue(true);
        $this->UpdateFields["SMTPAUTH"]["Value"] = $this->SMTPAUTH->GetDBValue(true);
        $this->UpdateFields["AUTHTYPE"]["Value"] = $this->AUTHTYPE->GetDBValue(true);
        $this->UpdateFields["CHARSET"]["Value"] = $this->CHARSET->GetDBValue(true);
        $this->SQL = CCBuildUpdate("camera_email_config", $this->UpdateFields, $this);
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

} //End camera_email_configDataSource Class @3-FCB6E20C

//Initialize Page @1-9E61E0C5
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
$TemplateFileName = "correo_config.html";
$BlockToParse = "main";
$TemplateEncoding = "UTF-8";
$ContentType = "text/html";
$PathToRoot = "../";
$PathToRootOpt = "../";
$Scripts = "|js/jquery/jquery.js|js/jquery/event-manager.js|js/jquery/selectors.js|";
$Charset = $Charset ? $Charset : "utf-8";
//End Initialize Page

//Authenticate User @1-7FABC906
CCSecurityRedirect("1", "../mylogin.php");
//End Authenticate User

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-7998F0FC
$DBminseg = new clsDBminseg();
$MainPage->Connections["minseg"] = & $DBminseg;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$mymenu = new clsmymenu("../", "mymenu", $MainPage);
$mymenu->Initialize();
$camera_email_config = new clsRecordcamera_email_config("", $MainPage);
$MainPage->mymenu = & $mymenu;
$MainPage->camera_email_config = & $camera_email_config;
$camera_email_config->Initialize();
$ScriptIncludes = "";
$SList = explode("|", $Scripts);
foreach ($SList as $Script) {
    if ($Script != "") $ScriptIncludes = $ScriptIncludes . "<script src=\"" . $PathToRoot . $Script . "\" type=\"text/javascript\"></script>\n";
}
$Attributes->SetValue("scriptIncludes", $ScriptIncludes);

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

//Execute Components @1-A3081C86
$camera_email_config->Operation();
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-67D93330
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_email_config);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-79A0DDFC
$mymenu->Show();
$camera_email_config->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$AMOO4M10J2G = explode("|", "<center><font face=\"Ar|ial\"><small>Gen&#101;|ra&#116;e&#100; <!-- |CCS -->wit&#104; <!|-- CCS -->&#67;&#111;|d&#101;&#67;h&#97;&#114|;ge <!-- SCC -->Studi|&#111;.</small></f|ont></center>");
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", join($AMOO4M10J2G,"") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", join($AMOO4M10J2G,"") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= join($AMOO4M10J2G,"");
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-E5345732
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_email_config);
unset($Tpl);
//End Unload Page


?>
