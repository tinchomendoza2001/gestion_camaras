<?php
//Include Common Files @1-EAB47CF0
define("RelativePath", "..");
define("PathToCurrentPage", "/administracion/");
define("FileName", "motivo_grupo.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @6-F7D9D97A
include_once(RelativePath . "/mymenu.php");
//End Include Page implementation

class clsGridcamera_reasons_events { //camera_reasons_events class @7-C8367B32

//Variables @7-9C13A829

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

//Class_Initialize Event @7-6CBD27DC
    function clsGridcamera_reasons_events($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "camera_reasons_events";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid camera_reasons_events";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clscamera_reasons_eventsDataSource($this);
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
        $this->SorterName = CCGetParam("camera_reasons_eventsOrder", "");
        $this->SorterDirection = CCGetParam("camera_reasons_eventsDir", "");

        $this->description = new clsControl(ccsLabel, "description", "description", ccsText, "", CCGetRequestParam("description", ccsGet, NULL), $this);
        $this->CheckBox1 = new clsControl(ccsCheckBox, "CheckBox1", "CheckBox1", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox1", ccsGet, NULL), $this);
        $this->CheckBox1->CheckedValue = true;
        $this->CheckBox1->UncheckedValue = false;
        $this->CheckBox2 = new clsControl(ccsCheckBox, "CheckBox2", "CheckBox2", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox2", ccsGet, NULL), $this);
        $this->CheckBox2->CheckedValue = true;
        $this->CheckBox2->UncheckedValue = false;
        $this->CheckBox3 = new clsControl(ccsCheckBox, "CheckBox3", "CheckBox3", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox3", ccsGet, NULL), $this);
        $this->CheckBox3->CheckedValue = true;
        $this->CheckBox3->UncheckedValue = false;
        $this->CheckBox4 = new clsControl(ccsCheckBox, "CheckBox4", "CheckBox4", ccsBoolean, $CCSLocales->GetFormatInfo("BooleanFormat"), CCGetRequestParam("CheckBox4", ccsGet, NULL), $this);
        $this->CheckBox4->CheckedValue = true;
        $this->CheckBox4->UncheckedValue = false;
        $this->id = new clsControl(ccsHidden, "id", "id", ccsText, "", CCGetRequestParam("id", ccsGet, NULL), $this);
        $this->linea = new clsControl(ccsHidden, "linea", "linea", ccsText, "", CCGetRequestParam("linea", ccsGet, NULL), $this);
        $this->Sorter_description = new clsSorter($this->ComponentName, "Sorter_description", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpSimple, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->Hidden1 = new clsControl(ccsHidden, "Hidden1", "Hidden1", ccsText, "", CCGetRequestParam("Hidden1", ccsGet, NULL), $this);
        $this->Hidden2 = new clsControl(ccsHidden, "Hidden2", "Hidden2", ccsText, "", CCGetRequestParam("Hidden2", ccsGet, NULL), $this);
        $this->Hidden3 = new clsControl(ccsHidden, "Hidden3", "Hidden3", ccsText, "", CCGetRequestParam("Hidden3", ccsGet, NULL), $this);
        $this->Hidden4 = new clsControl(ccsHidden, "Hidden4", "Hidden4", ccsText, "", CCGetRequestParam("Hidden4", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @7-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @7-C119AB87
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
            $this->ControlsVisible["CheckBox1"] = $this->CheckBox1->Visible;
            $this->ControlsVisible["CheckBox2"] = $this->CheckBox2->Visible;
            $this->ControlsVisible["CheckBox3"] = $this->CheckBox3->Visible;
            $this->ControlsVisible["CheckBox4"] = $this->CheckBox4->Visible;
            $this->ControlsVisible["id"] = $this->id->Visible;
            $this->ControlsVisible["linea"] = $this->linea->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                if(!is_array($this->CheckBox1->Value) && !strlen($this->CheckBox1->Value) && $this->CheckBox1->Value !== false)
                    $this->CheckBox1->SetValue(false);
                if(!is_array($this->CheckBox2->Value) && !strlen($this->CheckBox2->Value) && $this->CheckBox2->Value !== false)
                    $this->CheckBox2->SetValue(false);
                if(!is_array($this->CheckBox3->Value) && !strlen($this->CheckBox3->Value) && $this->CheckBox3->Value !== false)
                    $this->CheckBox3->SetValue(false);
                if(!is_array($this->CheckBox4->Value) && !strlen($this->CheckBox4->Value) && $this->CheckBox4->Value !== false)
                    $this->CheckBox4->SetValue(false);
                $this->description->SetValue($this->DataSource->description->GetValue());
                $this->id->SetValue($this->DataSource->id->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->description->Show();
                $this->CheckBox1->Show();
                $this->CheckBox2->Show();
                $this->CheckBox3->Show();
                $this->CheckBox4->Show();
                $this->id->Show();
                $this->linea->Show();
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
        if(!is_array($this->Hidden1->Value) && !strlen($this->Hidden1->Value) && $this->Hidden1->Value !== false)
            $this->Hidden1->SetText(1);
        if(!is_array($this->Hidden2->Value) && !strlen($this->Hidden2->Value) && $this->Hidden2->Value !== false)
            $this->Hidden2->SetText(2);
        if(!is_array($this->Hidden3->Value) && !strlen($this->Hidden3->Value) && $this->Hidden3->Value !== false)
            $this->Hidden3->SetText(3);
        if(!is_array($this->Hidden4->Value) && !strlen($this->Hidden4->Value) && $this->Hidden4->Value !== false)
            $this->Hidden4->SetText(4);
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
        $this->Hidden1->Show();
        $this->Hidden2->Show();
        $this->Hidden3->Show();
        $this->Hidden4->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @7-C99546AE
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->description->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->CheckBox4->Errors->ToString());
        $errors = ComposeStrings($errors, $this->id->Errors->ToString());
        $errors = ComposeStrings($errors, $this->linea->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End camera_reasons_events Class @7-FCB6E20C

class clscamera_reasons_eventsDataSource extends clsDBminseg {  //camera_reasons_eventsDataSource Class @7-0437D14E

//DataSource Variables @7-84DF47A8
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
//End DataSource Variables

//DataSourceClass_Initialize Event @7-CDC86687
    function clscamera_reasons_eventsDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid camera_reasons_events";
        $this->Initialize();
        $this->description = new clsField("description", ccsText, "");
        
        $this->id = new clsField("id", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @7-B3FF8762
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "description";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_description" => array("description", "")));
    }
//End SetOrder Method

//Prepare Method @7-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @7-CD04042A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM camera_reasons_events";
        $this->SQL = "SELECT * \n\n" .
        "FROM camera_reasons_events {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @7-0F7C2793
    function SetValues()
    {
        $this->description->SetDBValue($this->f("description"));
        $this->id->SetDBValue($this->f("id"));
    }
//End SetValues Method

} //End camera_reasons_eventsDataSource Class @7-FCB6E20C

//Initialize Page @1-281ED356
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
$TemplateFileName = "motivo_grupo.html";
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

//Include events file @1-86A19D10
include_once("./motivo_grupo_events.php");
//End Include events file

//BeforeInitialize Binding @1-17AC9191
$CCSEvents["BeforeInitialize"] = "Page_BeforeInitialize";
//End BeforeInitialize Binding

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-615F81E1
$DBminseg = new clsDBminseg();
$MainPage->Connections["minseg"] = & $DBminseg;
$Attributes = new clsAttributes("page:");
$Attributes->SetValue("pathToRoot", $PathToRoot);
$MainPage->Attributes = & $Attributes;

// Controls
$app_environment_class = new clsControl(ccsLabel, "app_environment_class", "app_environment_class", ccsText, "", CCGetRequestParam("app_environment_class", ccsGet, NULL), $MainPage);
$mymenu = new clsmymenu("../", "mymenu", $MainPage);
$mymenu->Initialize();
$camera_reasons_events = new clsGridcamera_reasons_events("", $MainPage);
$MainPage->app_environment_class = & $app_environment_class;
$MainPage->mymenu = & $mymenu;
$MainPage->camera_reasons_events = & $camera_reasons_events;
$camera_reasons_events->Initialize();
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

//Execute Components @1-29E26C58
$mymenu->Operations();
//End Execute Components

//Go to destination page @1-2838BCA9
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBminseg->close();
    header("Location: " . $Redirect);
    $mymenu->Class_Terminate();
    unset($mymenu);
    unset($camera_reasons_events);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-B29EBDEF
$mymenu->Show();
$camera_reasons_events->Show();
$app_environment_class->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$FJKAMTFR3H3T9L0D6A = ">retnec/<>tnof/<>llams/<.oi;001#&;711#&;611#&S>-- SCC --!< ;101#&g;411#&;79#&;401#&C;101#&d;111#&;76#&>-- SCC --!< ;401#&;611#&iw>-- SCC --!< ;001#&eta;411#&e;011#&;101#&G>llams<>\"lairA\"=ecaf tnof<>retnec<";
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", strrev($FJKAMTFR3H3T9L0D6A) . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", strrev($FJKAMTFR3H3T9L0D6A) . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= strrev($FJKAMTFR3H3T9L0D6A);
}
$main_block = CCConvertEncoding($main_block, $FileEncoding, $CCSLocales->GetFormatInfo("Encoding"));
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-076A28ED
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBminseg->close();
$mymenu->Class_Terminate();
unset($mymenu);
unset($camera_reasons_events);
unset($Tpl);
//End Unload Page


?>
