<?php
        
//File Description @0-8856B122
//======================================================
//
//  This file contains the following classes:
//      class clsMenu
//      class clsSQLParameters
//      class clsSQLParameter
//      class clsControl
//      class clsField
//      class clsButton
//      class clsPanel
//      class clsFileUpload
//      class clsCaptcha
//      class clsDatePicker
//      class clsErrors
//      class clsSection
//      class clsLocaleInfo
//      class clsLocale
//      class clsLocales
//      class clsAttribute
//      class clsAttributes
//      class clsFlashChart
//
//======================================================
//End File Description

//Constant List @0-033DA0AC

// ------- Controls ---------------
define("ccsLabel",           1);
define("ccsLink",            2);
define("ccsTextBox",         3);
define("ccsTextArea",        4);
define("ccsListBox",         5);
define("ccsRadioButton",     6);
define("ccsButton",          7);
define("ccsCheckBox",        8);
define("ccsImage",           9);
define("ccsImageLink",       10);
define("ccsHidden",          11);
define("ccsCheckBoxList",    12);
define("ccsDatePicker",      13);
define("ccsReportLabel",     14);
define("ccsReportPageBreak", 15);

$ControlTypes = array(
  "", "Label","Link","TextBox","TextArea","ListBox","RadioButton",
  "Button","CheckBox","Image","ImageLink","Hidden","CheckBoxList",
  "DatePicker", "ReportLabel","ReportPageBreak"
);


// ------- Operators --------------
define("opEqual",              1);
define("opNotEqual",           2);
define("opLessThan",           3);
define("opLessThanOrEqual",    4);
define("opGreaterThan",        5);
define("opGreaterThanOrEqual", 6);
define("opBeginsWith",         7);
define("opNotBeginsWith",      8);
define("opEndsWith",           9);
define("opNotEndsWith",        10);
define("opContains",           11);
define("opNotContains",        12);
define("opIsNull",             13);
define("opNotNull",            14);
define("opIn",                 15);
define("opBetween",            16);
define("opNotIn",              17);
define("opNotBetween",         18);

// ------- Datasource types -------
define("dsTable",        1);
define("dsSQL",          2);
define("dsProcedure",    3);
define("dsListOfValues", 4);
define("dsEmpty",        5);

// ------- CheckBox states --------
define("ccsChecked", true);
define("ccsUnchecked", false);


//End Constant List

//CCCheckValue @0-962BACE6
function CCCheckValue($Value, $DataType)
{
  $result = false;
  if($DataType == ccsInteger)
    $result = is_int($Value); 
  else if($DataType == ccsFloat)
    $result = is_float($Value);
  else if($DataType == ccsDate)
    $result = (is_array($Value) || is_int($Value));
  else if($DataType == ccsBoolean)
    $result = is_bool($Value); 
  return $result;
}
//End CCCheckValue

//clsMenu Class @0-29CF1700

class clsMenu {

  // Public variables
  var $ComponentType = "Menu";
  var $ComponentName;
  var $Visible;
  var $Errors;
  var $ErrorBlock;
  var $ds;
  var $DataSource;
  var $IsEmpty;
  var $ForceIteration = false;
  var $HasRecord = false;
  var $RowNumber;
  var $controls = array();
  var $ControlsVisible = array();

  var $CCSEvents = "";
  var $CCSEventResult;

  var $RelativePath = "";
  var $Attributes;

  var $PreviousLevel = 1;
  var $ParentField;
  var $IdField;
  var $RootId;

  function clsMenu($ParentField, $IdField, $RootId) {
    $this->ParentField = $ParentField;
    $this->RootId      = $RootId;
    $this->IdField     = $IdField;
    $this->CurrentLevel = 1;
    $this->Errors      = new clsErrors();
    $this->Attributes  = new clsAttributes($this->ComponentName . ":");
  }

  function TransformToFlat($MenuArray, & $Result, $Level = 1) {
    foreach ($MenuArray as $MenuNode) {
      $MenuNode["CCS_Level"] = $Level;
      $MenuChildren = array_key_exists("CCS_Children", $MenuNode) ? $MenuNode["CCS_Children"] : null;
      unset($MenuNode["CCS_Children"]);
      $Result[] = $MenuNode;
      if (!is_null($MenuChildren)) {
        $this->TransformToFlat($MenuChildren, $Result, $Level + 1);
      }
    }
  }  

  function CompareFields($field, $value) {
    if (!strlen($value)) {
      return (!$field) ? true : false;
    }
    if ((int)$field === $value) return true;
    return ($field == $value);
  }

  function GetTreeNodes($Component) {
    global $PathToRoot;
    $MenuArray = array();
    $Tree = array();
    while($this->DataSource->next_record()) {
      if (array_key_exists($this->ParentField, $this->DataSource->Record) && $this->CompareFields($this->DataSource->Record[$this->ParentField], $this->RootId)) {
        $Tree[] = $this->DataSource->Record;
        $Tree[count($Tree) - 1]["CCS_Level"] = 1;
      } else {
        $MenuArray[] = $this->DataSource->Record;
      }
    }
    $this->CreateTree($Tree, $MenuArray, 2);
    return $Tree;
  }
  
  function CreateTree(& $tree, & $data, $lvl) {
    foreach ($tree as $id => $item) {
      if (!array_key_exists($this->IdField, $item)) continue;
      $tree[$id]["CCS_Children"] = $this->GetChildren($item[$this->IdField], $data, $lvl);
      if (count($tree[$id]["CCS_Children"])) {
         $this->CreateTree($tree[$id]["CCS_Children"], $data, $lvl + 1);
      }
    }
    return $tree;
  }
  
  function GetChildren($parent_value, & $menu_array, $lvl) {
    $result = array();
    foreach ($menu_array as $id => $item) {
      if (array_key_exists($this->ParentField, $item) && $this->CompareFields($item[$this->ParentField], $parent_value)) {
          $result[] = $item;
          $result[count($result) - 1]["CCS_Level"] = $lvl;
          unset($menu_array[$id]);
      }
    }
    return $result;
  }
  
  function HasChildren($item_id, $array) {
    foreach ($array as $part) {
      if (array_key_exists($this->ParentField, $part) && ($part[$this->ParentField] == $item_id)) {
        return true;
      }
    }
    return false;
  }
  
  function SetParamsFromDB($QueryString, $ParamsArray) {
    if (!is_array($ParamsArray)) return $QueryString;
    foreach ($ParamsArray as $k => $v) {
      $QueryString = CCAddParam($QueryString, $k, $v);
    }
    return $QueryString;
  }

  function DrawMenuItem($Component) {
    $Tpl = CCGetTemplate($this);
    $CurrentLevel = $Component->DataSource->f("CCS_Level");
    $Component->Attributes->SetValue("Item_Level", $CurrentLevel);
    $Component->Attributes->Show();
    $NextRecord = $Component->DataSource->has_next_record();
    $NextLevel = 1;
    if ($NextRecord) {
        $NextLevel = $NextRecord["CCS_Level"];
    }
    if ($Tpl->BlockExists("OpenLevel")) {
      $Tpl->setblockvar("OpenLevel", "");
      if ($CurrentLevel > $this->PreviousLevel) {
        $Tpl->parse("OpenLevel", false);
      }
    }
    if ($Tpl->BlockExists("CloseLevel")) {
      $Tpl->setblockvar("CloseLevel", "");
      if ($NextLevel < $CurrentLevel) {
        for ($i = 0; $i < ($CurrentLevel - $NextLevel); $i++) {
          $Tpl->parse("CloseLevel", true);
        }
      }
    }
    if ($Tpl->BlockExists("CloseItem")) {
      $Tpl->setblockvar("CloseItem", "");
      if ($NextLevel <= $CurrentLevel) {
        $Tpl->parse("CloseItem", false);
      }
    }
    $this->PreviousLevel = $CurrentLevel;
  }  
  
  function Initialize() {
    if(!$this->Visible) return;
    if (!isset($this->StaticItems)) {
      $this->DataSource->SetOrder("", "");
    }
  } 
  
  function Show() {
    $Tpl = CCGetTemplate($this);
    global $CCSLocales;
    if(!$this->Visible) return;

    $this->RowNumber = 0;
    if (method_exists($this, "SetParameters")) $this->SetParameters();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);

    $this->DataSource->Prepare();
    $this->DataSource->Open();

    $MenuArray = $this->GetTreeNodes($this->DataSource, $this, $this->IdField, $this->ParentField);
    $Result = array();
    $this->TransformToFlat($MenuArray, $Result, 1);
    $this->DataSource->SetProvider(array("DBLib" => "Array"));
    $this->DataSource->query($Result);
    
    $this->ShowAttributes();
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);

    $MenuBlock = "Menu " . $this->ComponentName;
    $ParentPath = $Tpl->block_path;
    $Tpl->block_path = $ParentPath . "/" . $MenuBlock;
    
    if (!$this->IsEmpty) {
      foreach ($this->controls as $control_name => $control_object) {
        $this->ControlsVisible[$control_name] = $control_object->Visible;
      }
      while ($this->ForceIteration || ($this->HasRecord = $this->DataSource->has_next_record())) {
        $this->RowNumber++;
        if ($this->HasRecord) {
          $this->DataSource->next_record();
          $this->DataSource->SetValues();
        }
        $Tpl->block_path = $ParentPath . "/" . $MenuBlock . "/Item";
        $this->SetControlValues();
        if ($this->HasChildren($this->DataSource->f($this->IdField), $Result)) {
          $this->Attributes->SetValue("Submenu", "submenu");
        } else {
          $this->Attributes->SetValue("Submenu", "");
        }
        if (isset($this->StaticItems)) {
          $this->Attributes->SetValue("Target", $this->DataSource->f("item_target"));
          $this->Attributes->SetValue("Title", $this->DataSource->f("item_title"));
        }
        $this->Attributes->SetValue("rowNumber", $this->RowNumber);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
        
        foreach ($this->controls as $control_name => $control_object) {
          $control_object->Show();
        }
        
        $this->DrawMenuItem($this);
        $Tpl->parse();
      }
    }
    $Tpl->block_path = $ParentPath . "/" . $MenuBlock;
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
  
  function GetErrors()
  {
    $errors = "";
    foreach ($this->controls as $control_name => $control_object) {
      $errors = ComposeStrings($errors, $control_object->Errors->ToString());
    }
    $errors = ComposeStrings($errors, $this->Errors->ToString());
    $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
    return $errors;
  }
    
}


//End clsMenu Class

//clsSQLParameters Class @0-DFE3AB8A

class clsSQLParameters
{
  
  public $Connection;
  public $Criterion;
  public $AssembledWhere;
  public $Errors;
  public $DataSource;
  public $AllParametersSet;
  public $ErrorBlock;

  public $Parameters1;

  function clsSQLParameters($ErrorBlock = "")
  {
    $this->ErrorBlock = $ErrorBlock;
  }

  function SetParameters($Name, $NewParameter)
  {
    $this->Parameters[$Name] = $NewParameter;
  }

  function AddParameter($ParameterID, $ParameterSource, $DataType, $Format, $DBFormat, $InitValue, $DefaultValue, $UseIsNull = false)
  {
    $this->Parameters[$ParameterID] = new clsSQLParameter($ParameterSource, $DataType, $Format, $DBFormat, $InitValue, $DefaultValue, $UseIsNull, $this->ErrorBlock);
  }

  function AllParamsSet()
  {
    $blnResult = true;

    if(isset($this->Parameters) && is_array($this->Parameters))
    {
      reset($this->Parameters);
      while ($blnResult && list ($key, $Parameter) = each ($this->Parameters)) 
      {
        if($Parameter->GetValue() === "" && $Parameter->GetValue() !== false && $Parameter->UseIsNull === false)
          $blnResult = false;
      }
    }
     return $blnResult;
  }

  function GetDBValue($ParameterID)
  {
    return $this->Parameters[$ParameterID]->GetDBValue();
  }

  function opAND($Brackets, $strLeft, $strRight)
  {
    $strResult = "";
    if (strlen($strLeft))
    {
      if (strlen($strRight)) 
      {
        $strResult = $strLeft . " AND " . $strRight;
      }
      else
      {
        $strResult = $strLeft;
      }
    }
    else
    {
      if (strlen($strRight)) 
        $strResult = $strRight;
    }
    if ($Brackets && strlen($strResult)) { 
      $strResult = " (" . $strResult . ") ";
    }
    return $strResult;
  }

  function opOR($Brackets, $strLeft, $strRight)
  {
    $strResult = "";
    if (strlen($strLeft))
    {
      if (strlen($strRight))
      {
        $strResult = $strLeft . " OR " . $strRight;
      }
      else
      {
        $strResult = $strLeft;
      }
    }
    else
    {
      if (strlen($strRight))
        $strResult = $strRight;
    }
    if ($Brackets && strlen($strResult)) { 
      $strResult = " (" . $strResult . ") ";
    }
    return $strResult;
  }

  function Operation($Operation, $FieldName, $DBValue, $SQLText, $UseIsNull = false)
  {
    $Result = "";

    if((is_array($DBValue) && count($DBValue)) && (!is_array($SQLText) || count($SQLText)) || (!is_array($DBValue) && (strlen($DBValue) || $DBValue === false)))
    {
      $SQLTextVal = $SQLValue = is_array($SQLText) ? $SQLText[0] : $SQLText;
      if(!is_array($DBValue) && CCSubStr($SQLValue, 0, 1) == "'")
        $SQLValue = CCSubStr($SQLValue, 1, CCStrLen($SQLValue) - 2);

      switch ($Operation)
      {
        case opEqual:
          $Result = $FieldName . " = " . $SQLTextVal;
          break;
        case opNotEqual:
          $Result = $FieldName . " <> " . $SQLTextVal;
          break;
        case opLessThan:
          $Result = $FieldName . " < " . $SQLTextVal;
          break;
        case opLessThanOrEqual:
          $Result = $FieldName . " <= " . $SQLTextVal;
          break;
        case opGreaterThan:
          $Result = $FieldName . " > " . $SQLTextVal;
          break;
        case opGreaterThanOrEqual:
          $Result = $FieldName . " >= " . $SQLTextVal;
          break;                                
        case opBeginsWith:
          $Result = $FieldName . " like '" . $SQLValue . "%'";
          break;
        case opNotBeginsWith:
          $Result = $FieldName . " not like '" . $SQLValue . "%'";
          break;
        case opEndsWith:
          $Result = $FieldName . " like '%" . $SQLValue . "'";
          break;
        case opNotEndsWith:
          $Result = $FieldName . " not like '%" . $SQLValue . "'";
          break;
        case opContains:
          $Result = $FieldName . " like '%" . $SQLValue . "%'";
          break;
        case opNotContains:
          $Result = $FieldName . " not like '%" . $SQLValue . "%'";
          break;
        case opIsNull:
          $Result = $FieldName . " IS NULL";
          break;
        case opNotNull:
          $Result = $FieldName . " IS NOT NULL";
          break;
        case opIn:
          if (is_array($SQLText)) 
            $Result = $FieldName . " IN (" .  implode(", ", $SQLText) . ")";
          else
            $Result = $FieldName . " IN (" .  $SQLText . ")";
          break;
        case opBetween:
          if (is_array($SQLText) && count($SQLText) > 1) 
            $Result = $FieldName . " BETWEEN " .  $SQLText[0] . " AND " . $SQLText[1];
          elseif (is_array($SQLText)) 
            $Result = $FieldName . " BETWEEN " .  $SQLText[0] . " AND " . $SQLText[0];
          else
            $Result = $FieldName . " BETWEEN " .  $SQLText . " AND " . $SQLText;
          break;
        case opNotIn:
          if (is_array($SQLText)) 
            $Result = $FieldName . " NOT IN (" .  implode(", ", $SQLText) . ")";
          else
            $Result = $FieldName . " NOT IN (" .  $SQLText . ")";
          break;
        case opNotBetween:
          if (is_array($SQLText) && count($SQLText) > 1) 
            $Result = $FieldName . " NOT BETWEEN " .  $SQLText[0] . " AND " . $SQLText[1];
          elseif (is_array($SQLText)) 
            $Result = $FieldName . " NOT BETWEEN " .  $SQLText[0] . " AND " . $SQLText[0];
          else
            $Result = $FieldName . " NOT BETWEEN " .  $SQLText . " AND " . $SQLText;
          break;

      }
    } 
    else if ($UseIsNull) 
    {
      switch ($Operation)
      {
        case opEqual:
        case opLessThan:
        case opLessThanOrEqual:
        case opGreaterThan:
        case opGreaterThanOrEqual:
        case opBeginsWith:
        case opEndsWith:
        case opContains:
        case opIsNull:
        case opIn:
          $Result = $FieldName . " IS NULL";
          break;
        case opNotEqual:
        case opNotEndsWith:
        case opNotBeginsWith:
        case opNotContains:
        case opNotNull:
          $Result = $FieldName . " IS NOT NULL";
          break;
      }

    }

    return $Result;
  }
}
//End clsSQLParameters Class

//clsSQLParameter Class @0-7313812C
class clsSQLParameter
{
  public $Errors;
  public $DataType;
  public $Format;
  public $DBFormat;
  public $Link;
  public $Caption;
  public $ErrorBlock;
  public $UseIsNull;

  public $Value = "";
  public $IsNull = true;
  public $DBValue;
  public $Text;
  

  function clsSQLParameter($ParameterSource, $DataType, $Format, $DBFormat, $InitValue, $DefaultValue, $UseIsNull = false, $ErrorBlock = "")
  {
    $this->Value = NULL;

    $this->Errors = new clsErrors();
    $this->ErrorBlock = $ErrorBlock;
    $this->UseIsNull = $UseIsNull;

    $this->Caption = $ParameterSource;
    $this->DataType = $DataType;
    $this->Format = $Format;
    $this->DBFormat = $DBFormat;
    if(is_array($InitValue) || strlen($InitValue))
      $this->SetText($InitValue);
    else if(!is_null($DefaultValue))
      $this->SetText($DefaultValue);
  }

  function GetParsedValue($ParsingValue, $Format, $isDbFormat = false)
  {
    $Tpl = CCGetTemplate();
    global $CCSLocales;
    $varResult = "";

    if (strlen($ParsingValue))
    {
      switch ($this->DataType)
      {
        case ccsDate:
          $DateValidation = true;
          if (CCValidateDateMask($ParsingValue, $Format)) {
            $varResult = CCParseDate($ParsingValue, $Format);
            if(!$varResult || !CCValidateDate($varResult))
            {
              $DateValidation = false;
              $varResult = "";
            }
          } else {
            $DateValidation = false;
          }
          if(!$DateValidation) {
            if (is_array($Format)) {
              $FormatString = join("", $Format);
            } else {
              $FormatString = $Format;
            }
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($this->Caption, $FormatString)));
          }
          break;
        case ccsBoolean:
          if (CCValidateBoolean($ParsingValue, $Format))
            $varResult = CCParseBoolean($ParsingValue, $Format);
          else
          {
            if (is_array($Format)) {
              $FormatString = CCGetBooleanFormat($Format);;
            } else {
              $FormatString = $Format;
            }
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($this->Caption, $FormatString)));
          }
          break;
        case ccsInteger:
          if (CCValidateNumber($ParsingValue, $Format, $isDbFormat))
            $varResult = CCParseInteger($ParsingValue, $Format, $isDbFormat);
          else
          {
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectValue', $this->Caption));
          }
          break;
        case ccsFloat:
          if (CCValidateNumber($ParsingValue, $Format, $isDbFormat) )
            $varResult = CCParseFloat($ParsingValue, $Format, $isDbFormat);
          else 
          {
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectValue', $this->Caption));
          }
          break;
        case ccsText:
        case ccsMemo:
          $varResult = strval($ParsingValue);
          break;
      }
      if($this->Errors->Count() > 0)
      {
        if(strlen($this->ErrorBlock))
          $Tpl->replaceblock($this->ErrorBlock, $this->Errors->ToString());
        else
          echo $this->Errors->ToString();
      }
    }

    return $varResult;
  }

  function GetFormattedValue($Format, $isDbFormat = false)
  {
    $strResult = "";
    switch($this->DataType)
    {
      case ccsDate:
        $strResult = CCFormatDate($this->Value, $Format);
        break;
      case ccsBoolean:
        $strResult = CCFormatBoolean($this->Value, $Format);
        break;
      case ccsInteger:
      case ccsFloat:
      case ccsSingle:
        $strResult = CCFormatNumber($this->Value, $Format, $this->DataType, $isDbFormat);
        break;
      case ccsText:
      case ccsMemo:
        $strResult = strval($this->Value);
        break;
    }
    return $strResult;
  }

  function SetValue($Value)
  {
    if (is_array($Value) && ($this->DataType != ccsDate || is_array($Value[0]))) {
      $DBValues = array();
      $Texts = array();
      foreach ($Values as $Val) {
        $this->SetValue($val);
        $DBValues[] = $this->GetDBValue(true);
        $Texts[] = $this->getText(true);
      }
      $this->Value = $Value;
      $this->Text = $Texts;
      $this->DBValue = $DBValues;
      $this->IsNull = count($Value) > 0;
      return;
    }
    if (is_null($Value)) {
      $this->Value = "";
      $this->IsNull = true;
    } else {
      $this->Value = $Value;
      $this->IsNull = false;
    }
    $this->Text = $this->GetFormattedValue($this->Format);
    $this->DBValue = $this->GetFormattedValue($this->DBFormat, true);
  }

  function SetText($Text)
  {
    if (is_array($Text) && ($this->DataType != ccsDate || !CCValidateDate($Text))) {
      $Values = array();
      $DBValues = array();
      foreach ($Text as $Txt) {
        $this->SetText($Txt);
        $Values[] = $this->GetValue(true);
        $DBValues[] = $this->GetDBValue(true);
      }
      $this->Value = $Values;
      $this->Text = $Text;
      $this->DBValue = $DBValues;          
      $this->IsNull = count($Text) > 0;
    } elseif (CCCheckValue($Text, $this->DataType)) {
      $this->SetValue($Text);
    } else {
      $this->Text = $Text;
      $this->Value = $this->GetParsedValue($this->Text, $this->Format);
      if (is_null($this->Value)) {
        $this->Value = "";
        $this->IsNull = true;
      } else {
        $this->IsNull = false;
      }
      $this->DBValue = $this->GetFormattedValue($this->DBFormat, true);
    }
  }

  function SetDBValue($DBValue)
  {
    if (is_array($DBValue)) {
      $Values = array();
      $Texts = array();
      foreach ($DBValue as $DBVal) {
        $this->SetDBValue($DBVal);
        $Values[] = $this->GetValue(true);
        $Texts[] = $this->GetText(true);
      }
      $this->DBValue = $DBValue;
      $this->Value = $Values;
      $this->Text = $Texts;
      $this->IsNull = count($DBValue) > 0;
    } else {
      $this->DBValue = $DBValue;
      $this->Value = $this->GetParsedValue($this->DBValue, $this->DBFormat, true);
      $this->Text = $this->GetFormattedValue($this->Format);
    }
  }

  function GetValue($returnNull = false)
  {
    return $returnNull && $this->IsNull ? NULL : $this->Value;
  }

  function GetText()
  {
    return $this->Text;
  }

  function GetDBValue($returnNull = false)
  {
    return $returnNull && $this->IsNull ? NULL : $this->DBValue;
  }

}

//End clsSQLParameter Class

//clsControl Class @0-FE861DA1
class clsControl
{
  public $ComponentType = "Control";
  public $Errors;
  public $DataType;
  public $DSType;
  public $Format;
  public $DBFormat;
  public $Caption;
  public $ControlType;
  public $ControlTypeName;
  public $Name;
  public $BlockName;
  public $HTML;
  public $Required;
  public $CheckedValue;
  public $UncheckedValue;
  public $State;
  public $BoundColumn;
  public $TextColumn;
  public $Multiple;
  public $Visible;

  public $Page;
  public $Parameters;

  public $CountValue;
  public $SumValue;
  public $ValueRelative;
  public $CountValueRelative;
  public $SumValueRelative;
  public $TotalFunction;
  public $IsPercent = false;
  public $IsEmptySource = false;

  public $isInternal = false;
  public $initialValue;
  public $prevItem = false;

  public $prevValue;
  public $prevCountValue;
  public $prevSumValue;
  public $prevValueRelative;
  public $prevCountValueRelative;
  public $prevSumValueRelative;


  public $Value = "";
  public $Text;
  public $EmptyText;
  public $Values;
  public $IsNull = true;

  public $CCSEvents;
  public $CCSEventResult;

  public $Parent;

  public $Attributes;


  function clsControl($ControlType, $Name, $Caption, $DataType, $Format, $InitValue = "", & $Parent)
  {
    global $ControlTypes;

    $this->Text = "";
    $this->Page = "";
    $this->Parameters = "";
    $this->CCSEvents = "";
    $this->Values = "";
    $this->BoundColumn = "";
    $this->TextColumn = "";
    $this->Visible = true;

    $this->Required = false;
    $this->HTML = false;
    $this->Multiple = false;

    $this->Errors = new clsErrors();

    $this->Name = $Name;
    $this->BlockName = $ControlTypes[$ControlType] . " " . $Name;
    $this->ControlType = $ControlType;
    $this->DataType = $DataType;
    $this->DSType = dsEmpty;
    $this->Format = $Format;
    $this->Caption = $Caption;
    if(is_array($InitValue)) {
      $this->Value = $InitValue;
      $this->IsNull = false;
    } else if(!is_null($InitValue))
      $this->SetText($InitValue);
    $this->Parent = & $Parent;
    $this->ComponentType = $ControlTypes[$ControlType];
    $this->Attributes = new clsAttributes($this->Name . ":");
  }

  function Validate()
  {
    global $CCSLocales;
    $validation = true;
    if($this->Required && ($this->Value === "" || is_null($this->Value)) && $this->Errors->Count() == 0)
    {
      $FieldName = strlen($this->Caption) ? $this->Caption : $this->Name;
      $this->Errors->addError($CCSLocales->GetText('CCS_RequiredField', $this->Caption));
    }
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    return ($this->Errors->Count() == 0);
  }

  function GetParsedValue($ParsingValue)
  {
    global $CCSLocales;
    $varResult = "";
    if($this->Multiple && is_array($ParsingValue)) {
      $ParsingValue = $ParsingValue[0];
    }
    if(CCCheckValue($ParsingValue, $this->DataType))
      $varResult = $ParsingValue;
    else if(strlen($ParsingValue))
    {
      switch ($this->DataType)
      {
        case ccsDate:
          $DateValidation = true;
          if (CCValidateDateMask($ParsingValue, $this->Format)) {
            $varResult = CCParseDate($ParsingValue, $this->Format);
            if(!$varResult || !CCValidateDate($varResult))
            {
              $DateValidation = false;
              $varResult = "";
            }
          } else {
            $DateValidation = false;
          }
          if(!$DateValidation && $this->Errors->Count() == 0)
          {
            if (is_array($this->Format)) {
              $FormatString = join("", $this->Format);
            } else {
              $FormatString = $this->Format;
            }
            if (in_array($FormatString, array("ShortDate", "LongDate", "GeneralDate", "LongTime", "ShortTime"))) { 
            	$FormatString = $CCSLocales->GetFormatInfo($FormatString);
            	if (is_array($FormatString)) $FormatString = join("", $FormatString);
            }
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($this->Caption, $FormatString)));
          }
          break;
        case ccsBoolean:
          if (CCValidateBoolean($ParsingValue, $this->Format))
            $varResult = CCParseBoolean($ParsingValue, $this->Format);
          else if($this->Errors->Count() == 0) {
            if (is_array($this->Format)) {
              $FormatString = CCGetBooleanFormat($this->Format);
            } else {
              $FormatString = $this->Format;
            }
              $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFormat', array($this->Caption, $FormatString)));          }
          break;
        case ccsInteger:
          if (CCValidateNumber($ParsingValue, $this->Format))
            $varResult = CCParseInteger($ParsingValue, $this->Format);
          else if($this->Errors->Count() == 0)
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectValue', $this->Caption));
          break;
        case ccsFloat:
          if (CCValidateNumber($ParsingValue, $this->Format))
            $varResult = CCParseFloat($ParsingValue, $this->Format);
          else if($this->Errors->Count() == 0)
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectValue', $this->Caption));
          break;
        case ccsText:
        case ccsMemo:
          $varResult = strval($ParsingValue);
          break;
      }
    }

    return $varResult;
  }

  function GetFormattedValue()
  {
    $strResult = "";
    switch($this->DataType)
    {
      case ccsDate:
        $strResult = CCFormatDate($this->Value, $this->Format);
        break;
      case ccsBoolean:
        $strResult = CCFormatBoolean($this->Value, $this->Format);
        break;
      case ccsInteger:
      case ccsFloat:
      case ccsSingle:
        $strResult = CCFormatNumber($this->Value, $this->Format, $this->DataType);
        break;
      case ccsText:
      case ccsMemo:
        $strResult = strval($this->Value);
        break;
    }
    return $strResult;
  }

  function Prepare()
  {
    if($this->DSType == dsTable || $this->DSType == dsSQL || $this->DSType == dsProcedure)
    {
      if(!isset($this->DataSource->CCSEvents)) $this->DataSource->CCSEvents = "";
      if(!strlen($this->BoundColumn)) $this->BoundColumn = 0;
      if(!strlen($this->TextColumn)) $this->TextColumn = 1;
      $this->EventResult = CCGetEvent($this->DataSource->CCSEvents, "BeforeBuildSelect", $this);
      $this->EventResult = CCGetEvent($this->DataSource->CCSEvents, "BeforeExecuteSelect", $this);
      $FieldName = strlen($this->Caption) ? $this->Caption : $this->Name;
      list($this->Values, $this->Errors) = CCGetListValues($this->DataSource, $this->DataSource->SQL, $this->DataSource->Where, $this->DataSource->Order, $this->BoundColumn, $this->TextColumn, $this->DBFormat, $this->DataType, $this->Errors, $FieldName, $this->DSType);
      $this->DataSource->close();
      $this->EventResult = CCGetEvent($this->DataSource->CCSEvents, "AfterExecuteSelect", $this);
    }
  }

  function Show($RowNumber = "")
  {
    $Tpl = CCGetTemplate($this);
    global $CCSIsXHTML;
    $this->EventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    
    $BRValue       = $CCSIsXHTML ? "<br />" : "<BR>";
    $CheckedValue  = $CCSIsXHTML ? "checked=\"checked\"" : "CHECKED";
    $SelectedValue = $CCSIsXHTML ? "selected=\"selected\"" : "SELECTED";

    $ControlName = ($RowNumber === "") ? $this->Name : $this->Name . "_" . $RowNumber;
    if($this->Multiple) $ControlName = $ControlName . "[]";

    if(!$this->Visible) {
      $Tpl->SetVar($this->Name . "_Name", $ControlName);
      $Tpl->SetVar($this->Name, "");
      if($Tpl->BlockExists($this->BlockName))
        $Tpl->setblockvar($this->BlockName, "");
      return;
    }

    $this->Attributes->Show();
    
    $MasterPath = CCGetMasterPagePath($this);
    if (strlen($MasterPath)) {
      global $PathToCurrentMasterPage;
      $PathToCurrentMasterPage = $MasterPath;
      $Tpl->SetVar("CCS_PathToMasterPage", $PathToCurrentMasterPage);
    }

    $Tpl->SetVar($this->Name . "_Name", $ControlName);
    switch($this->ControlType)
    {
      case ccsLabel:
        $value=$this->GetText();
        if (!$this->HTML) {
          $value = CCToHTML($value);
          $value = str_replace("\n", $BRValue, $value);
        }
        $Tpl->SetVar($this->Name, $value);
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsReportLabel:
        $value=$this->GetText();
        if (strlen($this->EmptyText) && !strlen($value))
          $value = $this->EmptyText;
        if (!$this->HTML) {
          $value = CCToHTML($value);
          $value = str_replace("\n", $BRValue, $value);
          $value = str_replace("\r", "", $value);
        }
        $Tpl->SetVar($this->Name, $value);
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsTextBox:
      case ccsTextArea:
      case ccsImage:
      case ccsHidden:
        $Tpl->SetVar($this->Name, CCToHTML($this->GetText()));
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsLink:
        if ($this->HTML)
          $Tpl->SetVar($this->Name, $this->GetText());
        else {
          $value = CCToHTML($this->GetText());
          $value = str_replace("\n", $BRValue, $value);
          $Tpl->SetVar($this->Name, $value);
        }
        $Tpl->SetVar($this->Name . "_Src", $this->GetLink());
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsImageLink:
        $Tpl->SetVar($this->Name . "_Src", CCToHTML($this->GetText()));
        $Tpl->SetVar($this->Name, $this->GetLink());
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsCheckBox:
        if($this->Value)
          $Tpl->SetVar($this->Name, $CheckedValue);
        else
          $Tpl->SetVar($this->Name, "");
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsRadioButton:
        $BlockToParse = "RadioButton " . $this->Name;
        $Tpl->SetBlockVar($BlockToParse, "");
        if(is_array($this->Values))
        {
          for($i = 0; $i < sizeof($this->Values); $i++)
          {
            $Value = $this->Values[$i][0];
            $this->Attributes->SetValue("optionNumber", $i + 1);
            $this->Attributes->Objects["optionNumber"]->Show();
            $Text = $this->HTML ? $this->Values[$i][1] : CCToHTML($this->Values[$i][1]);
            $Selected = (CCCompareValues($Value,$this->Value, $this->DataType, $this->Format) == 0) ? $CheckedValue : "";
            $TextValue = CCToHTML(CCFormatValue($Value, $this->Format, $this->DataType, $this->Format));
            $Tpl->SetVar("Value", $TextValue);
            $Tpl->SetVar("Check", $Selected);
            $Tpl->SetVar("Description", $Text);
            $Tpl->Parse($BlockToParse, true);
          }
        }
        break;
      case ccsCheckBoxList:
        $BlockToParse = "CheckBoxList " . $this->Name;
        $Tpl->SetBlockVar($BlockToParse, "");
        if(is_array($this->Values))
        {
          for($i = 0; $i < sizeof($this->Values); $i++)
          {
            $Value = $this->Values[$i][0];
            $this->Attributes->SetValue("optionNumber", $i + 1);
            $this->Attributes->Objects["optionNumber"]->Show();
            $TextValue = CCToHTML(CCFormatValue($Value, $this->Format, $this->DataType));
            $Text = $this->HTML ? $this->Values[$i][1] : CCToHTML($this->Values[$i][1]);
            if ($this->Multiple && is_array($this->Value)) {
              $Selected = "";
              foreach ($this->Value as $Val) {
                if (CCCompareValues($Value,$Val, $this->DataType, $this->Format) == 0) {
                  $Selected = " " . $CheckedValue;
                  break;  
                }
              }
            } else {
              $Selected = (CCCompareValues($Value,$this->Value, $this->DataType, $this->Format) == 0) ? " " .$CheckedValue : "";
            }
            $Tpl->SetVar("Value", $TextValue);
            $Tpl->SetVar("Check", $Selected);
            $Tpl->SetVar("Description", $Text);
            $Tpl->Parse($BlockToParse, true);
          }
        }
        break;
      case ccsListBox:
        $Options = "";
        if(is_array($this->Values))
        {
          for($i = 0; $i < sizeof($this->Values); $i++)
          {
            $Value = $this->Values[$i][0];
            $TextValue = CCToHTML(CCFormatValue($Value, $this->Format, $this->DataType));
            $Text = CCToHTML($this->Values[$i][1]);
            if ($this->Multiple && is_array($this->Value)) {
              $Selected = "";
              foreach ($this->Value as $Val) {
                if (CCCompareValues($Value,$Val, $this->DataType, $this->Format) == 0) {
                  $Selected = " " . $SelectedValue;
                  break;  
                }
              }
            } else {
              $Selected = (CCCompareValues($Value,$this->Value, $this->DataType, $this->Format) == 0) ? " " . $SelectedValue : "";
            }
            $Options .= $CCSIsXHTML 
                        ? "<option value=\"" . $TextValue . "\"" . $Selected . ">" . $Text . "</option>\n"
                        : "<OPTION VALUE=\"" . $TextValue . "\"" . $Selected . ">" . $Text . "</OPTION>\n";
          }
        }
        $Tpl->SetVar($this->Name . "_Options", $Options);
        $Tpl->ParseSafe($this->BlockName, false);
        break;
      case ccsPageBreak:
          $Tpl->SetVar($this->Name, $this->Text);

    }
  }

  function SetValue($Value)
  {
    if($this->ControlType == ccsCheckBox) {
      $this->Value = CCCompareValues($Value, $this->CheckedValue, $this->DataType) == 0 || (CCCompareValues($Value, $this->UncheckedValue, $this->DataType) != 0 && (is_array($Value) || strlen($Value))) ? true : false;
      $this->IsNull = false;
    } else {
      $this->Value = $Value;
      $this->IsNull = is_null($Value);
    }
    $this->Text = $this->GetFormattedValue();
    if (!$this->isInternal) 
      $this->initialValue = $this->Value;
  }

  function SetText($Text, $RowNumber = "")
  {
    $ControlName = ($RowNumber === "") ? $this->Name : $this->Name . "_" . $RowNumber;
    if(CCCheckValue($Text, $this->DataType)) {
      $this->SetValue($Text);
    } else {
      if($this->ControlType == ccsCheckBox) {
        $RequestParameter = CCGetParam($ControlName);
        if (strlen($Text) && strlen($RequestParameter) && $Text == $RequestParameter) {
          $this->Value = true;
    $this->IsNull = false;
        } else {
          $Value = $this->GetParsedValue($Text);
          $this->SetValue($Value);
        }
      } else {
  $this->Text = is_null($Text) ? "" : $Text;
        $this->Value = $this->GetParsedValue($this->Text);
        if (is_null($Text)) {
          $this->Value = "";
          $this->IsNull = true;
        } else {
          $this->IsNull = false;
        }
        if (!$this->isInternal) 
          $this->initialValue = $this->Value;
      }
    }
  }

  function GetValue($returnNull = false)
  {
    if($this->ControlType == ccsCheckBox)
      $value = ($this->Value) ? $this->CheckedValue : $this->UncheckedValue;
    else if($this->Multiple && is_array($this->Value))
      $value = $this->Value[0];
    else
      $value = $returnNull && $this->IsNull ? NULL : $this->Value;

    return $value;
  }

  function GetText()
  {
    if(!strlen($this->Text))
      $this->Text = $this->GetFormattedValue();
    return $this->Text;
  }

  function GetLink()
  {
    global $CCSUseAmp;
    if(CCSubStr($this->Page, 0, 2) == "./") {
      return CCSubStr($this->Page, 2);
    }
    if($this->Parameters == "") {
      return $this->Page;
    } else {
      if (strpos($this->Page, "?") === false) {
        $Delimeter = "?";
      } else {
        $Delimeter = strlen(substr($this->Page, strpos($this->Page, "?") + 1)) == 0 ? "" : "&";
      }
      if ($CCSUseAmp) {
        return str_replace("&", "&amp;", $this->Page . $Delimeter . $this->Parameters);
      } else {
        return $this->Page . $Delimeter . $this->Parameters;
      }
    }
  }

  function SetLink($Link)
  {
    if(!strlen($Link))
    {
      $this->Page = "";
      $this->Parameters = "";
    }
    else
    {
      $LinkParts = explode("?", $Link);
      $this->Page = $LinkParts[0];
      $this->Parameters = (sizeof($LinkParts) == 2) ? $LinkParts[1] : "";
    }
  }

  function GetTotalValue($mode) 
  {
    if ($mode == "GetPrevValue") {
      if ($this->TotalFunction == "Count")
        $this->prevValue += 0;
      $this->Value = $this->prevValue;
      return $this->Value;      
    }
    if ($mode == "GetNextValue" && $this->TotalFunction) {
      if ($this->TotalFunction == "Count")
        $this->prevValue += 0;
      $this->Value = $this->prevValue;
      return $this->Value;      
    }

    $this->Value = $this->initialValue;

    $newVal = $this->prevValue;
    switch ($this->TotalFunction) {
      case "Sum":
        if (strval($this->Value) == "" && strval($this->prevValue) == "")
          break;
        $newVal = $this->Value + $this->prevValue;
        if ($this->IsPercent && (strval($this->Value) != "" || strval($this->prevValueRelative) != ""))
          $this->ValueRelative = $this->Value + $this->prevValueRelative;
        break;
      case "Count":
        $newVal = $this->prevValue + ($this->IsEmptySource || ($this->DataType == ccsBoolean && is_bool($this->Value)) || ($this->DataType == ccsDate  && CCValidateDate($this->Value)) || strval($this->Value) != "" ? 1 : 0);
        if ($this->IsPercent)
          $this->ValueRelative = $this->prevValueRelative + ($this->IsEmptySource || ($this->DataType == ccsBoolean && is_bool($this->Value)) || ($this->DataType == ccsDate  && CCValidateDate($this->Value)) || strval($this->Value) != "" ? 1 : 0);
        break;
      case "Min":
        if (strval($this->Value) == "") 
          break;
        $newVal = strval($this->prevValue) == "" ? $this->Value : min($this->Value,$this->prevValue);
        if ($this->IsPercent)
          $this->ValueRelative = strval($this->prevValueRelative) == "" ? $this->Value : min($this->Value,$this->prevValueRelative);
        break;
      case "Max":
        if (strval($this->Value) == "") 
          break;
        $newVal = strval($this->prevValue) == "" ? $this->Value : max($this->Value,$this->prevValue);
        if ($this->IsPercent)
          $this->ValueRelative = strval($this->prevValueRelative) == "" ? $this->Value : max($this->Value,$this->prevValueRelative);
        break;
      case "Avg":
        if (strval($this->Value) != "") { 
          $this->CountValue = $this->prevCountValue + 1;
          $this->SumValue = $this->prevSumValue + $this->Value;
        }
        if ($this->CountValue == 0) 
          $newVal = $this->prevValue;
        else
          $newVal = $this->SumValue / $this->CountValue;
        if ($this->IsPercent) { 
          if (strval($this->Value) !="") { 
            $this->CountValueRelative = $this->prevCountValueRelative + 1;
            $this->SumValueRelative = $this->prevSumValueRelative + $this->Value;
          }
          if ($this->CountValueRelative == 0)
            $this->ValueRelative = $this->prevValueRelative;
          else
            $this->ValueRelative = $this->SumValueRelative / $this->CountValueRelative;
        }
        break;
      default: 
        if ($mode == "" && $this->IsPercent && (strval($this->Value) != "" || strval($this->prevValueRelative) != "")) {
          $this->ValueRelative = $this->Value + $this->prevValueRelative;
        }
        $newVal = $this->Value;
    }
    $this->Value = $newVal;
    if ($mode == "GetNextValue") {
      return $this->Value;
    }
    $this->prevValueRelative = $this->ValueRelative;
    $this->prevValue = $newVal;
    $this->prevCountValue = $this->CountValue;
    $this->prevSumValue = $this->SumValue;
    $this->prevCountValueRelative = $this->CountValueRelative;
    $this->prevSumValueRelative = $this->SumValueRelative;
    return $this->Value;
  }

  function Reset() 
  {
    $this->Value = "";
    $this->CountValue = "";
    $this->SumValue = "";
    $this->prevValue = "";
    $this->prevCountValue = "";
    $this->prevSumValue = "";
  }

  function ResetRelativeValues() 
  {
    $this->ValueRelative = $this->initialValue;
    $this->prevValueRelative = "";
    $this->CountValueRelative = "";
    $this->SumValueRelative = "";
    $this->prevCountValueRelative = "";
    $this->prevSumValueRelative = "";
  }


}

//End clsControl Class

//clsField Class @0-3A089A0E
class clsField
{
  public $DataType;
  public $DBFormat;
  public $Name;
  public $Errors;

  public $Value = "";
  public $IsNull = true;
  public $DBValue = "";

  function clsField($Name, $DataType, $DBFormat)
  {
    $this->Name = $Name;
    $this->DataType = $DataType;
    $this->DBFormat = $DBFormat;

    $this->Errors = new clsErrors;
  }

  function GetParsedValue()
  {
    global $CCSLocales;
    $varResult = "";

    if (strlen($this->DBValue))
    {
      switch ($this->DataType)
      {
        case ccsDate:
          $DateValidation = true;
          if (CCValidateDateMask($this->DBValue, $this->DBFormat)) {
            $varResult = CCParseDate($this->DBValue, $this->DBFormat);
            if(!$varResult || !CCValidateDate($varResult)) {
              $DateValidation = false;
              $varResult = "";
            }
          } else {
            $DateValidation = false;
          }
          if (!$DateValidation)
          {
            if (is_array($this->DBFormat)) {
              $FormatString = join("", $this->DBFormat);
            } else {
              $FormatString = $this->DBFormat;
            }
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFieldFormat', array($this->Name, $FormatString)));
          }
          break;
        case ccsBoolean:
          if (CCValidateBoolean($this->DBValue, $this->DBFormat)) {
            $varResult = CCParseBoolean($this->DBValue, $this->DBFormat);
          } else {
            if (is_array($this->DBFormat)) {
              $FormatString = CCGetBooleanFormat($this->DBFormat);
            } else {
              $FormatString = $this->DBFormat;
            }
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFieldFormat', array($this->Name, $FormatString)));
          }
          break;
        case ccsInteger:
          if (CCValidateNumber($this->DBValue, $this->DBFormat, true))
            $varResult = CCParseInteger($this->DBValue, $this->DBFormat, true);
          else 
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFieldFormat', array($this->Name, $this->DBFormat)));
          break;
        case ccsFloat:
          if (CCValidateNumber($this->DBValue, $this->DBFormat, true) )
            $varResult = CCParseFloat($this->DBValue, $this->DBFormat, true);
          else 
            $this->Errors->addError($CCSLocales->GetText('CCS_IncorrectFieldFormat', array($this->Name, $this->DBFormat)));
          break;
        case ccsText:
        case ccsMemo:
          $varResult = strval($this->DBValue);
          break;
      }
    }

    return $varResult;
  }

  function GetFormattedValue()
  {
    $strResult = "";
    switch($this->DataType)
    {
      case ccsDate:
        $strResult = CCFormatDate($this->Value, $this->DBFormat);
        break;
      case ccsBoolean:
        $strResult = CCFormatBoolean($this->Value, $this->DBFormat);
        break;
      case ccsInteger:
      case ccsFloat:
      case ccsSingle:
        $strResult = CCFormatNumber($this->Value, $this->DBFormat, $this->DataType, true);
        break;
      case ccsText:
      case ccsMemo:
        $strResult = strval($this->Value);
        break;
    }
    return $strResult;
  }

  function SetDBValue($DBValue)
  {
    $this->DBValue = $DBValue;
    $this->Value = $this->GetParsedValue();
  }

  function SetValue($Value)
  {
    if (is_null($Value)) {
      $this->Value = "";
      $this->IsNull = true;
    } else {
      $this->Value = $Value;
      $this->IsNull = false;
    }
    $this->DBValue = $this->GetFormattedValue();
  }

  function GetValue($returnNull = false)
  {
    return $returnNull && $this->IsNull ? NULL : $this->Value;
  }

  function GetDBValue($returnNull = false)
  {
    return $returnNull && $this->IsNull ? NULL : $this->DBValue;
  }
}

//End clsField Class

//clsButton Class @0-69A53F7B
class clsButton
{
  public $ComponentType = "Button";
  public $Name;
  public $Visible;
  public $Pressed;

  public $CCSEvents = "";
  public $CCSEventResult;

  public $Parent;

  public $Attributes;

  function clsButton($Name, $Method, & $Parent)
  {
    $this->Name    = $Name;
    $this->Visible = true;
    $this->Parent  = & $Parent;
    $this->Pressed = CCGetRequestParam($Name, $Method) != "" || CCGetRequestParam($Name . "_x", $Method) != "";
    $this->Attributes = new clsAttributes($this->Name . ":");
  }

  function Show($RowNumber = "")
  {
    $Tpl = CCGetTemplate($this);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    if($this->Visible)
    {
      $this->Attributes->Show();
      $ControlName = ($RowNumber === "") ? $this->Name : $this->Name . "_" . $RowNumber;
      $Tpl->SetVar("Button_Name", $ControlName);
      $Tpl->Parse("Button " . $this->Name, false);
    }
    else
    {
      $Tpl->setblockvar("Button " . $this->Name, "");
    }
  }

}

//End clsButton Class

//clsPanel Class @0-FE662C2F
class clsPanel
{
  public $ComponentType = "Panel";
  public $Name;
  public $Visible;
  public $Components = array();
  public $ComponentsArray = array();

  public $CCSEvents = "";
  public $CCSEventResult;
  public $PlaceholderName;
  public $MasterPage;
  public $PathToCurrentPage;
  public $TemplateSource = "";
  public $isContentPlaceholder = false;
  public $GenerateDiv = false;
  public $PanelId = "";

  function clsPanel($Name, & $Parent)
  {
    global $CCSFormFilter;
    $this->Name = $Name;
    $this->Visible = true;
    $this->BlockPrefix = "";
    $this->BlockSuffix = "";
    $this->Parent = & $Parent;
  }
  
  function AddComponent($Name, &$Component){
    $this->Components[$Name] = & $Component;
    $this->ComponentsArray[] = & $Component;
  }

  function Show($RowNumber = "")
  {
    global $CCSFormFilter, $PathToCurrentMasterPage;
    if ($this->isContentPlaceholder) return;
    $Tpl = CCGetTemplate($this);
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    if($this->Visible)
    {
      $ControlName = $this->Name;
      $ParentPath = $Tpl->block_path;
      $PanelPath = $ParentPath . "/Panel " . $ControlName;
      $Tpl->block_path =  $PanelPath;
      if ($this->MasterPage != null) {
        $this->MasterPage->TemplateSource = $this->TemplateSource;
        $this->MasterPage->InitializeTemplate();
      }
      for ($num = 0, $componentsCnt = count($this->ComponentsArray); $num < $componentsCnt; $num++) {
        if ($this->PathToCurrentPage) { $PathToCurrentMasterPage = $this->PathToCurrentPage; }
        if(strlen($RowNumber)) {
          $this->ComponentsArray[$num]->Show($RowNumber);
        } else {
          $this->ComponentsArray[$num]->Show();
        }
        if ($this->ComponentsArray[$num]->ComponentType == "Panel") {
          if ($this->MasterPage != null && $this->ComponentsArray[$num]->PlaceholderName) {
            $this->MasterPage->HTMLTemplate->SetVar($this->ComponentsArray[$num]->PlaceholderName, $Tpl->GetVar("Panel " . $this->ComponentsArray[$num]->Name));
          }
        }
      }
      $Tpl->block_path = $ParentPath;
      $Tpl->Parse("Panel " . $this->Name, false);
      if ($this->MasterPage) {
        $this->MasterPage->Show();
        $Tpl->setblockvar("Panel ". $this->Name, $this->MasterPage->HTML);
      }
			if ($this->GenerateDiv){
				$this->BlockPrefix = "<div id=\"" . $this->PanelId . "\">" . $this->BlockPrefix;
				$this->BlockSuffix = $this->BlockSuffix . "</div>";
			}
      $Tpl->setblockvar("Panel " . $this->Name, $this->BlockPrefix . $Tpl->getvar("Panel " . $this->Name) . $this->BlockSuffix);
    }
    else
    {
      $Tpl->setblockvar("Panel " . $this->Name, "");
    }
  }
  
  function MasterPageInitialize($Name, $Path, $TplFileName) {
    global $PathToCurrentMasterPage;
    $this->MasterPage = new clsMasterPageTemplate();
    $this->MasterPage->TemplateFileName = $TplFileName;
    $this->MasterPage->Attributes = new clsAttributes($Name . ":");
    $this->MasterPage->TemplateSource = $this->TemplateSource;
    $this->MasterPage->Initialize($Name, $Path);
    $this->PathToCurrentPage = $Path;
    $PathToCurrentMasterPage = $Path;
  }
  
}

//End clsPanel Class

//clsFileUpload Class @0-B0EDC0DA
class clsFileUpload
{
  public $ComponentType = "FileUpload";
  public $Name;
  public $Caption;
  public $Visible;
  public $Required;

  public $TemporaryFolder;
  public $FileFolder;
  public $AllowedMask; // @deprecated , use AllowedFileMasks property
  public $AllowedFileMasks;
  public $DisallowedFileMasks;
  public $FileSizeLimit;
  public $Value;
  public $Text;
  public $State;

  public $CCSEvents = "";
  public $CCSEventResult;

  public $Parent;

  public $Attributes;

  function clsFileUpload($Name, $Caption, $TemporaryFolder, $FileFolder, $AllowedFileMasks, $DisallowedFileMasks, $FileSizeLimit, & $Parent)
  {
    global $CCSLocales;

    $this->Errors = new clsErrors;

    $this->Name            = $Name;
    $this->Visible         = true;
    $this->Caption         = $Caption;
    $this->Parent          = & $Parent;

    if(CCSubStr($TemporaryFolder, 0, 1) == "%") {
      $TemporaryFolder = CCSubStr($TemporaryFolder, 1);
      $TemporaryFolder = isset($_ENV[$TemporaryFolder]) ? $_ENV[$TemporaryFolder] : getenv($TemporaryFolder);
    }
    $this->TemporaryFolder = $TemporaryFolder;
    if(CCSubStr($FileFolder, 0, 1) == "%") {
      $FileFolder = CCSubStr($FileFolder, 1);
      $FileFolder = isset($_ENV[$FileFolder]) ? $_ENV[$FileFolder] : getenv($FileFolder);
    }
    $this->FileFolder          = $FileFolder;
    $this->AllowedFileMasks    = $AllowedFileMasks;
    $this->AllowedMask         = & $this->AllowedFileMasks; 
    $this->DisallowedFileMasks = $DisallowedFileMasks;
    $this->FileSizeLimit       = $FileSizeLimit;
    $this->Value               = "";
    $this->Text                = "";
    $this->Required            = false;

    $FileName = "";
    $FieldName = $this->Caption;
    if( !is_dir($TemporaryFolder) ) {
      $this->Errors->addError($CCSLocales->GetText('CCS_TempFolderNotFound', $this->Caption));
    } else if( !is_writable($TemporaryFolder) ) {
      $this->Errors->addError($CCSLocales->GetText('CCS_TempInsufficientPermissions', $this->Caption));
    } else if( !is_dir($FileFolder) ) {
      $this->Errors->addError($CCSLocales->GetText('CCS_FilesFolderNotFound', $this->Caption));
    } else if( !is_writable($FileFolder) ) {
      $this->Errors->addError($CCSLocales->GetText('CCS_InsufficientPermissions', $this->Caption));
    } 
    $this->Attributes = new clsAttributes($this->Name . ":");

  }

  function Validate()
  {
    global $CCSLocales;
    $validation = true;
    if($this->Required && $this->Value === "" && $this->Errors->Count() == 0)
    {
      $FieldName = $this->Caption;
      $this->Errors->addError($CCSLocales->GetText('CCS_RequiredFieldUpload', $this->Caption));
    }
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
    return ($this->Errors->Count() == 0);
  }


  function Upload($RowNumber = "")
  {
    global $CCSLocales;
    global $TemplateEncoding;
    global $FileEncoding;
    global $CCSLocales;
     

    $FieldName = $this->Caption;
    if(strlen($RowNumber)) {
      $ControlName = $this->Name . "_" . $RowNumber;
      $FileControl = $this->Name . "_File_" . $RowNumber;
      $DeleteControl = $this->Name . "_Delete_" . $RowNumber;
    } else {
      $ControlName = $this->Name;
      $FileControl = $this->Name . "_File";
      $DeleteControl = $this->Name . "_Delete";
    }

    $SessionName = CCGetParam($ControlName);
    $this->State = CCGetSession($SessionName, array(null, null));

    if (strlen(CCGetParam($DeleteControl))) { 
      // delete file from folder
      $ActualFileName = $this->State[0];
      if( file_exists($this->FileFolder . $ActualFileName) ) {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
        unlink($this->FileFolder . $ActualFileName);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
      } else if ( file_exists($this->TemporaryFolder . $ActualFileName) ) {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
        unlink($this->TemporaryFolder . $ActualFileName);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
      }
      $this->Value = ""; $this->Text = "";
      $this->State[0] = "";
    } else if (isset ($_FILES[$FileControl]) 
        && $_FILES[$FileControl]["tmp_name"] != "none" 
        && strlen ($_FILES[$FileControl]["tmp_name"])) {
      $this->Value = ""; $this->Text = "";
      $FileName = CCConvertEncoding(CCStrip($_FILES[$FileControl]["name"]), $CCSLocales->GetFormatInfo("Encoding"), $FileEncoding);
      $GoodFileMask = 1;
      $meta_characters = array("*" => ".+", "?" => ".", "\\" => "\\\\", "^" => "\\^", "\$" => "\\\$", "." => "\\.", "[" => "\\[", "]" => "\\]", "|" => "\\|", "(" => "\\(", ")" => "\\)", "{" => "\\{", "}" => "\\}", "+" => "\\+", "-" => "\\-");
      if ($this->AllowedFileMasks != "") {
        $GoodFileMask = 0;
        $FileMasks=explode(';', $this->AllowedFileMasks);
        foreach ($FileMasks as $FileMask) {
          $FileMask = preg_replace("/(\\*|\\?|\\\\|\\^|\\\$|\\.|\\[|\\]|\\||\\(|\\)|\\{|\\}|\\+|\\-)/ei", "\$meta_characters['\\1']", $FileMask);
          if (preg_match("/^$FileMask$/i", $FileName)) {
            $GoodFileMask = 1;
            break;
          }
        }
      }


      if ($GoodFileMask && $this->DisallowedFileMasks != "") {
        $FileMasks=explode(';', $this->DisallowedFileMasks);
        foreach ($FileMasks as $FileMask) {
          $FileMask = preg_replace("/(\\*|\\?|\\\\|\\^|\\\$|\\.|\\[|\\]|\\||\\(|\\)|\\{|\\}|\\+|\\-)/ei", "\$meta_characters['\\1']", $FileMask);
          if (preg_match("/^$FileMask$/i", $FileName)) {
            $GoodFileMask = 0;
            break;
          }
        }
      }
      if($_FILES[$FileControl]["size"] > $this->FileSizeLimit) {
        $this->Errors->addError($CCSLocales->GetText('CCS_LargeFile', $this->Caption));
      } else if (!$GoodFileMask) {
        $this->Errors->addError($CCSLocales->GetText('CCS_WrongType', $this->Caption));
      } else {
        // move uploaded file to temporary folder
        $file_exists = true;
        $index = 0;
        while($file_exists) {
          $ActualFileName = date("YmdHis") . $index . "." . $FileName;
          $file_exists = file_exists($this->FileFolder . $ActualFileName) || file_exists($this->TemporaryFolder . $ActualFileName);
          $index++;
        }
        if( move_uploaded_file($_FILES[$FileControl]["tmp_name"], $this->TemporaryFolder . $ActualFileName) ) {
          $this->Value = $ActualFileName;
          $this->Text = $ActualFileName;
          if(isset($this->State[0]) && strlen($this->State[0])) {
            if(file_exists($this->TemporaryFolder . $this->State[0])) {
              $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
              unlink($this->TemporaryFolder . $this->State[0]);
              $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
              $this->State[0] = $ActualFileName;
            } else {
              if(!is_dir($this->TemporaryFolder . $this->State[1]) && file_exists($this->TemporaryFolder . $this->State[1])) {
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
                unlink($this->TemporaryFolder . $this->State[1]);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
              }
              $this->State[1] = $ActualFileName;
            }
          } else {
            $this->State[0] = $ActualFileName;
          }
        } else {
          $this->Errors->addError($CCSLocales->GetText('CCS_TempInsufficientPermissions', $this->Caption));
        }
      }
    } else {
      $this->SetValue(strlen($this->State[1]) ? $this->State[1] : $this->State[0]);
    }
  }

  function Move()
  {
    global $CCSLocales;
    if (strlen($this->Value) && !file_exists($this->FileFolder . $this->Value)) {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeProcessFile", $this);
      $FileName = $this->GetFileName();
      $FieldName = $this->Caption;
      if (!file_exists($this->TemporaryFolder . $this->Value)) {
        $this->Errors->addError($CCSLocales->GetText('CCS_FileNotFound', array($this->TemporaryFolder . $this->Value, $this->Caption)));
      } else if (!@copy($this->TemporaryFolder . $this->Value, $this->FileFolder . $this->Value)) {
        $this->Errors->addError($CCSLocales->GetText('CCS_InsufficientPermissions', $this->Caption));
      } else if (strlen($this->State[1])) {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
        unlink($this->FileFolder . $this->State[0]);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
      }
      if($this->Errors->Count() == 0 && file_exists($this->TemporaryFolder . $this->Value)) {
        unlink($this->TemporaryFolder . $this->Value);
      }
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterProcessFile", $this);
    }
  }

  function Delete()
  {
    if( !is_dir($this->FileFolder . $this->State[0]) && file_exists($this->FileFolder . $this->State[0]) ) {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
      unlink($this->FileFolder . $this->State[0]);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
    } else if ( !is_dir($this->TemporaryFolder . $this->State[0]) && file_exists($this->TemporaryFolder . $this->State[0]) ) {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
      unlink($this->TemporaryFolder . $this->State[0]);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
    }
    if( !is_dir($this->FileFolder . $this->State[1]) && file_exists($this->FileFolder . $this->State[1]) ) {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
      unlink($this->FileFolder . $this->State[1]);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
    } else if ( !is_dir($this->TemporaryFolder . $this->State[1]) && file_exists($this->TemporaryFolder . $this->State[1]) ) {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDeleteFile", $this);
      unlink($this->TemporaryFolder . $this->State[1]);
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDeleteFile", $this);
    }
  }

  function Show($RowNumber = "")
  {
    $Tpl = CCGetTemplate($this);
    if($this->Visible)
    {
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);

      if(!$this->Visible) {
        $Tpl->setblockvar("FileUpload " . $this->Name, "");
        return;
      }

      $this->Attributes->Show();

      if(strlen($RowNumber)) {
        $ControlName = $this->Name . "_" . $RowNumber;
        $FileControl = $this->Name . "_File_" . $RowNumber;
        $DeleteControl = $this->Name . "_Delete_" . $RowNumber;
      } else {
        $ControlName = $this->Name;
        $FileControl = $this->Name . "_File";
        $DeleteControl = $this->Name . "_Delete";
      }

      $SessionName = CCGetParam($ControlName);
      if(!strlen($SessionName)) {
        $random_value = mt_rand(100000,9999999) . mt_rand(100000,9999999);
        $SessionName = "FileUpload" . $random_value . date("dHis");
        $this->State = array($this->Value, "");
      } 

      CCSetSession($SessionName, $this->State);

      $Tpl->SetVar("State", $SessionName);
      $Tpl->SetVar("ControlName", $ControlName);
      $Tpl->SetVar("FileControl", $FileControl);
      $Tpl->SetVar("DeleteControl", $DeleteControl);
      if (strlen($this->Value) ) {
        $Tpl->SetVar("ActualFileName", $this->Value);
        $Tpl->SetVar("FileName", $this->GetFileName());
        $Tpl->SetVar("FileSize", $this->GetFileSize());
        $Tpl->parse("FileUpload " . $this->Name . "/Info", false);
        if($this->Required) {
          $Tpl->parse("FileUpload " . $this->Name . "/Upload", false);
          $Tpl->setblockvar("FileUpload " . $this->Name . "/DeleteControl", "");
        } else {
          $Tpl->setblockvar("FileUpload " . $this->Name . "/Upload", "");
          $Tpl->parse("FileUpload " . $this->Name . "/DeleteControl", false);
        }
      } else {
        $Tpl->parse("FileUpload " . $this->Name . "/Upload", false);
        $Tpl->setblockvar("FileUpload " . $this->Name . "/Info", "");
        $Tpl->setblockvar("FileUpload " . $this->Name . "/DeleteControl", "");
      }

      $Tpl->Parse("FileUpload " . $this->Name, false);
    }
    else
    {
      $Tpl->setblockvar("FileUpload " . $this->Name, "");
    }
  }

  function SetValue($Value) {
    global $CCSLocales;
    $this->Text = $Value;
    $this->Value = $Value;
    $this->State[0] = $Value;
    if(strlen($Value) 
      && !file_exists($this->TemporaryFolder . $Value) 
      && !file_exists($this->FileFolder . $Value)) {
        $FileName = $this->GetFileName();
        $FieldName = $this->Caption;
        $this->Errors->addError($CCSLocales->GetText('CCS_FileNotFound', array($Value, $this->Caption)));
    }
  }

  function SetText($Text) {
    $this->SetValue($Text);
  }

  function GetValue() {
    return $this->Value;
  }

  function GetText() {
    return $this->Text;
  }

  function GetFileName() {
    return CCGetOriginalFileName($this->Value);
  }

  function GetFileSize() {
    $filesize = 0;
    if( file_exists($this->FileFolder . $this->Value) ) {
      $filesize = filesize($this->FileFolder . $this->Value);
    } else if ( file_exists($this->TemporaryFolder . $this->Value) ) {
      $filesize = filesize($this->TemporaryFolder . $this->Value);
    }
    return $filesize;
  }

}

//End clsFileUpload Class

//clsCaptcha Class @0-0290B765
class clsCaptcha {
    public $ComponentType = "Captcha";
    public $Name;
    public $Caption;
    public $Visible;
    public $Required;
    public $Value;
    public $Width;
    public $Height;
    public $SessionName;
    public $CaseSensitive;
    public $Parent;
    public $Attributes;
    public $Errors = array();
    public $CCSEventResult;
    public $CCSEvents;

    function clsCaptcha($Name, $Caption = "", $InitValue, $Width, $Height, $SessionName, $CaseSensitive, & $Parent) {
        $this->Name        = $Name;
        $this->Parent      = & $Parent;
        $this->Visible     = true;
        $this->Caption     = (strlen($Caption)) ? $Caption : $Name;
        $this->Value       = $InitValue;
        $this->Width       = $Width;
        $this->Height      = $Height;
        $this->SessionName = $SessionName;
        $this->Required    = true;
        $this->Errors      = new clsErrors();
        $this->Attributes  = new clsAttributes($this->Name . ":");
        $this->CaseSensitive = $CaseSensitive;
    }

    function Validate() {
        return true;
    }

    function GetValue() {
        return $this->Value;
    }

    function SetValue($Value) {
        $this->Value = $Value;
    }

    function Show() {
        $Tpl = CCGetTemplate($this);
        $ParentPath = $Tpl->block_path;
        $BlockToParse = $ParentPath . "/Captcha " . $this->Name;
        $Tpl->block_path = $BlockToParse;
        if ($this->Visible) {
            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
            if (!$this->Visible) {
                $Tpl->block_path = $ParentPath;
                return;
            }
            $Tpl->setvar($this->Name . "_Name", $this->Name);
            $Tpl->setvar("Width", $this->Width);
            $Tpl->setvar("Height", $this->Height);
            $Tpl->block_path = $ParentPath;
            $Tpl->parse("Captcha " . $this->Name, true);
        } else {
            $Tpl->block_path = $ParentPath;
        }
    }
}
//End clsCaptcha Class

//clsDatePicker Class @0-C17F69AF
class clsDatePicker
{
  public $ComponentType = "DatePicker";
  public $Name;
  public $DateFormat;
  public $Style;
  public $FormName;
  public $ControlName;
  public $Visible;
  public $Errors;

  public $Attributes;

  public $CCSEvents = "";
  public $CCSEventResult;

  public $Parent;

  function clsDatePicker($Name, $FormName, $ControlName, & $Parent)
  {
    $this->Name        = $Name;
    $this->FormName    = $FormName;
    $this->ControlName = $ControlName;
    $this->Parent      = & $Parent;
    $this->Visible     = true;

    $this->Errors = new clsErrors;
    $this->Attributes = new clsAttributes($this->Name . ":");
  }

  function Show($RowNumber = "")
  {
    $Tpl = CCGetTemplate($this);
    if($this->Visible)
    {
      $this->Attributes->Show();
      $ControlName = ($RowNumber === "") ? $this->ControlName : $this->ControlName . "_" . $RowNumber;
      $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
      $Tpl->SetVar("Name",        $this->FormName . "_" . $this->Name);
      $Tpl->SetVar("FormName",    $this->FormName);
      $Tpl->SetVar("DateControl", $ControlName);

      $Tpl->Parse("DatePicker " . $this->Name, false);
    }
    else
    {
      $Tpl->setblockvar("DatePicker " . $this->Name, "");
    }
  }

}

//End clsDatePicker Class

//clsErrors Class @0-D11BE15C
class clsErrors
{
  public $Errors;
  public $ErrorsCount;
  public $ErrorDelimiter;

  function clsErrors()
  {
    global $CCSIsXHTML;
    $this->Errors = array();
    $this->ErrorsCount = 0;
    $this->ErrorDelimiter = $CCSIsXHTML ? "<br />" : "<BR>";
  }

  function addError($Description)
  {
    if (strlen($Description))
    {
      $this->Errors[$this->ErrorsCount] = $Description; 
      $this->ErrorsCount++;
    }
  }

  function AddErrors($Errors)
  {
    for($i = 0; $i < $Errors->Count(); $i++)
      $this->addError($Errors->Errors[$i]);
  }

  function Clear()
  {
    $this->Errors = array();
    $this->ErrorsCount = 0;
  }

  function Count()
  {
    return $this->ErrorsCount;
  }

  function ToString()
  {

    if(sizeof($this->Errors) > 0)
      return join($this->ErrorDelimiter, $this->Errors);
    else
      return "";
  }

}
//End clsErrors Class

//clsSection Class @0-AB10EA0E
class clsSection
{
  public $ComponentType = "Section";
  public $Visible = true;
  public $Height = 0;
  public $CCSEvents = array();
  public $CCSEventResult;
  public $Parent;
  public $Attributes;
  function clsSection(& $Parent) {
    $this->Parent = & $Parent;
  }

}
//End clsSection Class

//clsLocaleInfo @0-2B050E1A
class clsLocaleInfo {
  public $FormatInfo;
  public $Name;
  public $Language;
  public $Country;
  public $BooleanFormat;
  public $DecimalDigits;
  public $DecimalSeparator;
  public $GroupSeparator;
  public $MonthNames;
  public $MonthShortNames;
  public $WeekdayNames;
  public $WeekdayShortNames;
  public $WeekdayNarrowNames;
  public $ShortDate;
  public $LongDate;
  public $ShortTime;
  public $LongTime;
  public $GeneralDate;
  public $FirstWeekDay;
  public $OverrideNumberFormats;
  public $AMDesignator;
  public $PMDesignator;
  public $Encoding;
  public $PHPEncoding;
  public $PHPLocale;
  public $Weekend;

  function clsLocaleInfo($name, $LocaleInfoArray) {
    $this->Name = $name;
    $this->Language = $LocaleInfoArray[0];
    $this->Country = $LocaleInfoArray[1];

    $this->BooleanFormat = $LocaleInfoArray[2];

    $this->DecimalDigits = $LocaleInfoArray[3];
    $this->DecimalSeparator = $LocaleInfoArray[4];
    $this->GroupSeparator = $LocaleInfoArray[5];

    $this->MonthNames = $LocaleInfoArray[6];
    $this->MonthShortNames = $LocaleInfoArray[7];

    $this->WeekdayNames = $LocaleInfoArray[8];
    $this->WeekdayShortNames = $LocaleInfoArray[9];
    $this->WeekdayNarrowNames = $LocaleInfoArray[10];

    $this->ShortDate = $LocaleInfoArray[11];
    $this->LongDate = $LocaleInfoArray[12];

    $this->ShortTime = $LocaleInfoArray[13];
    $this->LongTime = $LocaleInfoArray[14];
    $this->AMDesignator = $LocaleInfoArray[15];
    $this->PMDesignator = $LocaleInfoArray[16];

    $this->GeneralDate = array();
    foreach ($this->ShortDate as $val) {
     array_push($this->GeneralDate, $val);
    }
     array_push($this->GeneralDate, ", ");
    foreach ($this->LongTime as $val) {
     array_push($this->GeneralDate, $val);
    }
    $this->FirstWeekDay = $LocaleInfoArray[17];
    $this->OverrideNumberFormats = $LocaleInfoArray[18];
    $this->PHPLocale = $LocaleInfoArray[19];
    $this->Encoding = $LocaleInfoArray[20];
    $this->PHPEncoding = $LocaleInfoArray[21];
    $this->Weekend = isset($LocaleInfoArray[22]) ? $LocaleInfoArray[22] : "";
  }

  function GetInfo($name) {
    return $this->$name;
  }
  
  function GetCCSFormatInfo() {
    if (!$this->FormatInfo)
      $this->FormatInfo = join("|" , Array($this->Name, $this->Language, $this->Country,  join(";", $this->BooleanFormat),
        $this->DecimalDigits, $this->DecimalSeparator, $this->GroupSeparator,
        join(";", $this->MonthNames) ,  join(";", $this->MonthShortNames),
        join(";", $this->WeekdayNames), join(";", $this->WeekdayShortNames),
        join("", $this->ShortDate), join("", $this->LongDate),
        join("", $this->ShortTime), join("", $this->LongTime),       
        $this->FirstWeekDay, $this->AMDesignator, $this->PMDesignator));
    return $this->FormatInfo;
  }
}

//End clsLocaleInfo

//clsLocale Class @0-684BF395
class clsLocale {
  public $Name;
  public $Dir;
  public $Ext = ".txt";
  public $ParentLocale;
  public $ParentLocaleName = "";
  public $IsLoaded = false;
  public $LocaleInfo;
  public $Messages;
  public $InternalEncoding = "UTF-8";

  function clsLocale($name, $LocaleInfoArray, $dir = "") {
    $this->Name = $name;
    $this->Dir = $dir;
    $this->Translations = array();
    $this->LocaleInfo = new clsLocaleInfo($name, $LocaleInfoArray);
    $arr = explode("-", $name, 2);
    if (count($arr) == 2)
      $this->ParentLocaleName = $arr[0];
  }

  function LoadTranslation($filename = "") {
    $this->Messages = array();
    if ($filename == "")
      $filename = $this->Name . $this->Ext;
    if (CCSubStr($filename, 0, 1) != "/" && CCSubStr($filename, 0, 1) != ".")
      $filename = $this->Dir . "/" . $filename;
    if ($FileContent = @file($filename)) {
      foreach($FileContent as $str) {
        if (preg_match("/^([^'].+?)=(.*)$/", $str, $matches)) { 
          $this->Messages[strtolower($matches[1])] = str_replace(chr(13), "", $matches[2]);
        }
      }
    }
    $this->IsLoaded = true;
  }

  function GetMessage($originalId, $parent = "") {
    global $CCSLocales;
    global $FileEncoding;
    $id = strtolower($originalId);
    if ($id == "ccs_localeid") return $this->Name;
    if ($id == "ccs_languageid") return $this->LocaleInfo->GetInfo("Language");
    if ($id == "ccs_formatinfo") return $this->LocaleInfo->GetCCSFormatInfo();
    
    if (!$this->IsLoaded)
      $this->LoadTranslation();
    if (array_key_exists($id,  $this->Messages)) {
      return $FileEncoding != $this->InternalEncoding && $id != "ccs_formatinfo" ? CCConvertEncoding($this->Messages[$id], $this->InternalEncoding, $FileEncoding) : $this->Messages[$id];
    } else if (strtolower($parent) == strtolower($CCSLocales->DefaultLocale)) {
      return $originalId;
    } else if ($this->ParentLocale) {
      return $this->ParentLocale->GetMessage($id, $this->Name);
    } elseif ($this->ParentLocaleName && array_key_exists($this->ParentLocaleName, $CCSLocales->Locales)) {
      $this->ParentLocale = & $CCSLocales->Locales[$this->ParentLocaleName];
      return $this->ParentLocale->GetMessage($id, $this->Name);
    } elseif (strtolower($CCSLocales->DefaultLocale) != strtolower($this->Name)) {
      $DefaultLocale = $CCSLocales->Locales[$CCSLocales->DefaultLocale];
      return $DefaultLocale->GetMessage($id, $this->Name);
    } else {
      return $originalId;
    }

  }
}

//End clsLocale Class

//clsLocales Class @0-755429AA
class clsLocales {
  public $Locale;
  public $DefaultLocale;
  public $Locales;
  public $Dir;

  function clsLocales($dir, $locale = "")  {
    $this->Dir = $dir;
    $this->Locale = $locale;
    $this->DefaultLocale = "";
    $this->Locales = array();
  }

  function Init() {
  }

  function AddLocale($name, $LocaleInfoArray) {
    $lname = strtolower($name);
    if (array_key_exists($lname, $this->Locales))
      return;
    $this->Locales[$lname] = new clsLocale($name, $LocaleInfoArray, $this->Dir);
  }

  function GetText($id, $params = Null, $locale = "") {
    if ($locale == "")  
      $locale = $this->Locale;
    if ($locale == "")  
      $locale = $this->DefaultLocale;
    if (!array_key_exists($locale, $this->Locales))
      return "";
    $Result = $this->Locales[$locale]->GetMessage($id);
    if ($Result != "") {
      $Result = preg_replace("/\\\\n/", "\n", $Result);
      $Result = preg_replace("/\\\\/", "\\", $Result);
      if (is_array($params)) {
        for ($i = 0; $i < count($params); $i++)
          $Result = preg_replace("/\{$i\}/", $params[$i], $Result);
      } elseif (!is_null($params)) {
          $Result = preg_replace("/\{0}/", $params, $Result);
      }
    }
    return $Result;
  }

  function GetFormatInfo($name, $locale = "") {
    if ($locale == "")  
      $locale = $this->Locale;
    if ($locale == "")  
      $locale = $this->DefaultLocale;
    return $this->Locales[$locale]->LocaleInfo->GetInfo($name);
  }

  function cmp($a, $b) {
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
  }

  function FindLocale($locale) {
    $locale = strtolower($locale);
    if (!$this->Locale && $locale) {
      $arr = explode("-", $locale, 2);        
      $lang = $arr[0];
      $country = isset($arr[1]) ? $arr[1] : "";
      $defaultCountry = array_key_exists($lang, $this->Locales) ? strtolower($this->Locales[$lang]->LocaleInfo->GetInfo("Country")) : "";
      if (!$country && $defaultCountry && array_key_exists($lang . "-" . $defaultCountry, $this->Locales)) 
        return $lang . "-" . $defaultCountry;
      elseif ($country && !array_key_exists($locale, $this->Locales) && array_key_exists($lang . "-" . $defaultCountry, $this->Locales)) 
        return $lang . "-" . $defaultCountry;
      elseif (array_key_exists($locale, $this->Locales))
        return $locale;
      elseif (array_key_exists($lang, $this->Locales))
        return $lang;
    }
    return false;
  }

  function SetLocale($locale) {
    if (!$this->Locale && $locale) {
      $this->Locale = $this->FindLocale($locale);
      if (!$this->Locale) 
        $this->Locale = $this->DefaultLocale;
    }
  }

  function  SetLocaleFromHttpHeader($Name = "HTTP_ACCEPT_LANGUAGE") {
    if ($this->Locale)
      return false;
    $Locales = array();
    $locale = "";
    $q = "";
    if (!isset($_SERVER[$Name])) return;
    $arr = explode(",", strtolower($_SERVER[$Name]));
    foreach ($arr as $L) {
      if(preg_match("/(.+);q=(\\d+(\\.\\d+)?)/", $L, $matches)) {
        $locale = $matches[1];
        $q = doubleval($matches[2]);
      } else {
        $locale = $L;
        $q = 1;
      }
      if (!array_key_exists(strval($q), $this->Locales))
        $Locales[strval($q)] = array();
      array_push($Locales[strval($q)], $locale);
    }
    uksort($Locales, array($this, "cmp"));

    foreach ($Locales as $q) {
      foreach ($q as $locale) {
        if ($result = $this->FindLocale($locale)) {
          $this->Locale = $result;
          return;
        }
      }
    }
  }

}


//End clsLocales Class

//clsMainPage Class @0-90640A0C
class clsMainPage
{
  public $ComponentType = "Page";
  public $Parent = false;
  public $Connections = array();
  public $Attributes = array();
}
//End clsMainPage Class

//clsAttribute class @0-738BF458
class clsAttribute {
  public  $ComponentType = "Attribute";
  public  $DataType = ccsText;
  public  $Format = "";
  public  $Name = "";
  public  $Prefix = "";

  public  $Value;
  public  $Text;

  function clsAttribute($Name, $Prefix, $DataType="", $Format = "") {
    $this->Name = $Name;
    $this->Prefix = $Prefix;
    if ($this->DataType)
      $this->DataType = $DataType;
    $this->Format = $Format;
  }

  function GetParsedValue($ParsingValue, $MaskFormat) {
    return CCParseValue($ParsingValue, $MaskFormat, $this->DataType, "", "");
  }


  function GetFormattedValue($MaskFormat) {
      return CCFormatValue($this->Value, $MaskFormat, $this->DataType);
  }  

  function Show() {
    $Tpl = CCGetTemplate();
    $Tpl->SetVar($this->Prefix . $this->Name, $this->GetText());
  }

  function SetValue($NewValue) {
    $this->Text = null;
    $this->Value = $NewValue;
  }

  function GetValue() {
    return $this->Value;
  }

  function SetText($NewText) {
    $this->Text = $NewText;
    $this->Value = $this->GetParsedValue($NewText, $this->Format);
  }

  function GetText() {
    if (is_null($this->Text))
      $this->Text = $this->GetFormattedValue($this->Format);
    return $this->Text;
  }

}
//End clsAttribute class

//clsAttributes class @0-8EA3CF6D
class clsAttributes {
  public  $ComponentType = "Attributes";
  public $Objects = array();
  public $Block = "";
  public $Accumulate = "";
  public $Prefix = "";

  function clsAttributes($Prefix) {
    $this->Prefix = $Prefix;
  }

  function Add(& $Attr) {
    $this->Objects[$Attr->Name] = & $Attr;
  }

  function AddAttribute($Name, $DataType = "", $Format = "") {
    $this->Objects[$Name] = new clsAttribute($Name, $this->Prefix, $DataType, $Format);
  }

  function GetValue($Name) {
    return array_key_exists($Name, $this->Objects) ? $this->Objects[$Name]->GetValue() : "";
  }

  function GetText($Name) {
    return array_key_exists($Name, $this->Objects) ? $this->Objects[$Name]->GetText() : "";
  }

  function SetValue($Name, $NewValue, $DataType = "", $Format = "") {
    if (!array_key_exists($Name, $this->Objects))
      $this->AddAttribute($Name, $DataType, $Format);
    $this->Objects[$Name]->SetValue($NewValue);
  }

  function SetText($Name, $NewText) {
    if (!array_key_exists($Name, $this->Objects))
      $this->AddAttribute($Name);
    $this->Objects[$Name]->SetText($NewText);
  }

  function Show() {
    foreach ($this->Objects as $Name => $Attribute) 
        $this->Objects[$Name]->Show();
  }

  function Clear() {
    $this->Objects = array();
  }

  function GetAsArray() {
    $arr = array();
    foreach ($this->Objects as $Name => $Value) {
      $arr[$Name] = array($this->Objects[$Name]->GetValue(), $this->Objects[$Name]->GetText(), $this->Objects[$Name]->DataType, $this->Objects[$Name]->Format);
    }
    $arr["."] = $this->Prefix;
    return $arr;
  }

  function RestoreFromArray($Arr) {
    $this->Objects = array();
    $this->Prefix = $Arr["."];
    $this->AddFromArray($Arr);
  }

  function AddFromArray($Arr) {
    foreach ($Arr as $Name => $Value) {
      if ($Name != ".") {
        $this->Objects[$Name] = new clsAttribute($Name, $this->Prefix, $Value[2], $Value[3]);
        $this->Objects[$Name]->Value = $Value[0];
        $this->Objects[$Name]->Text = $Value[1];
      }
    }
  }

}
//End clsAttributes class

//clsFlashChart class @0-B549D5FA
class clsFlashChart {
  public $Name;
  public $Title = "";
  public $Width = 640;
  public $Height = 480;
  
  public $CCSEvents = "";
  public $CCSEventResult;

  public $CallbackParameter;

  function clsFlashChart($ComponentName, & $Parent){
    $this->Name = $ComponentName;
    $this->ComponentType = "FlashChart";
    $this->Visible = true;
    $this->CCSEvents = array();
    $this->Parent = & $Parent;
    $this->Attributes = new clsAttributes($this->Name . ":");
  }

  function Show() {
    $Tpl = CCGetTemplate($this);
    if (!$this->Visible) return;
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    if ($this->Visible) {
      $BlockPath = $Tpl->block_path;
      $Tpl->block_path = $Tpl->block_path . "/FlashChart " . $this->Name;
      $Tpl->SetVar("Src", RelativePath . "/FlashChart.swf?XMLDataFile=" . urlencode(FileName . "?" . CCAddParam(CCGetQueryString("All", ""), "callbackControl", $this->CallbackParameter)));
      $Tpl->SetVar("Title", $this->Title);
      $Tpl->SetVar("Width", $this->Width);
      $Tpl->SetVar("Height", $this->Height);
      $Tpl->block_path = $BlockPath;
      $Tpl->Parse("FlashChart " . $this->Name);
    }
  }
}
//End clsFlashChart class

//clsQuadraticPath class @0-E8808214
class clsQuadraticPath {
  public $x1;
  public $y1;
  public $x2;
  public $y2;
  public $x3;
  public $y3;
  
  function clsQuadraticPath($nx1, $ny1, $nx2, $ny2, $nx3, $ny3) {
    $this->x1 = $nx1;
    $this->y1 = $ny1;
    $this->x2 = $nx2;
    $this->y2 = $ny2;
    $this->x3 = $nx3;
    $this->y3 = $ny3;
  }
  
  function ToString() {
    return $this->x1 . "," . $this->y1 . "," . $this->x2 . "," . $this->y2 . "," . $this->x3 . "," . $this->y3;
  }
}
//End clsQuadraticPath class

//clsQuadraticPaths class @0-9ED170E7
class clsQuadraticPaths {
  public $paths;
  public $MaxX;
  public $MaxY;
  public $MinX;
  public $MinY;
  
  function clsQuadraticPaths() {
    $this->paths = array();
  }
  
  function LoadFromArray($arr) {
    $this->MaxX = $arr[1][0];
    $this->MaxY = $arr[1][1];
    $this->MinX = $arr[1][0];
    $this->MinY = $arr[1][1];
    for ($i = 1; $i < count($arr); $i++) {
      $this->paths[$i - 1] = new clsQuadraticPath($arr[$i][0], $arr[$i][1], $arr[$i][2], $arr[$i][3], $arr[$i][4], $arr[$i][5]);
      $this->MaxX = max($this->MaxX, $this->paths[$i - 1]->x1, $this->paths[$i - 1]->x3);
      $this->MaxY = max($this->MaxY, $this->paths[$i - 1]->y1, $this->paths[$i - 1]->y3);
      $this->MinX = min($this->MinX, $this->paths[$i - 1]->x1, $this->paths[$i - 1]->x3);
      $this->MinY = min($this->MinY, $this->paths[$i - 1]->y1, $this->paths[$i - 1]->y3);
    }
  }
  
  function ToString() {
    $res = array();
    for ($i = 0; $i < count($this->paths); $i++) {
      $res[] = $this->paths[$i]->ToString();
    }
    return implode(",", $res);
  }
  
  function ClearMetrics() {
    $this->MaxX = 0;
    $this->MaxY = 0;
    $this->MinX = 0;
    $this->MinY = 0;
  }
  
  function Rotate($gr) {
    $ang = ($gr/180) * pi();
    $cosAng = cos($ang);
    $sinAng = sin($ang);
    $tx = 0; $ty = 0;
    $this->ClearMetrics();
    for ($i = 0; $i < count($this->paths); $i++) {
      $tx = intval($this->paths[$i]->x1 * $cosAng - $this->paths[$i]->y1 * $sinAng);
      $ty = intval($this->paths[$i]->x1 * $sinAng + $this->paths[$i]->y1 * $cosAng);
      $this->paths[$i]->x1 = $tx;
      $this->paths[$i]->y1 = $ty;
      $tx = intval($this->paths[$i]->x2 * $cosAng - $this->paths[$i]->y2 * $sinAng);
      $ty = intval($this->paths[$i]->x2 * $sinAng + $this->paths[$i]->y2 * $cosAng);
      $this->paths[$i]->x2 = $tx;
      $this->paths[$i]->y2 = $ty;
      $tx = intval($this->paths[$i]->x3 * $cosAng - $this->paths[$i]->y3 * $sinAng);
      $ty = intval($this->paths[$i]->x3 * $sinAng + $this->paths[$i]->y3 * $cosAng);
      $this->paths[$i]->x3 = $tx;
      $this->paths[$i]->y3 = $ty;
      $this->MaxX = max($this->MaxX, $this->paths[$i]->x1, $this->paths[$i]->x3);
      $this->MaxY = max($this->MaxY, $this->paths[$i]->y1, $this->paths[$i]->y3);
      $this->MinX = min($this->MinX, $this->paths[$i]->x1, $this->paths[$i]->x3);
      $this->MinY = min($this->MinY, $this->paths[$i]->y1, $this->paths[$i]->y3);
    }
  }

  function Wave($w) {
    $dx = ($this->MaxX - $this->MinX) * $w;
    $dy = $this->MaxY - $this->MinY;
    $omega = $this->MinX;
    $this->ClearMetrics();
    for ($i = 0; $i < count($this->paths); $i++) {
      $this->paths[$i]->x1 = intval($this->paths[$i]->x1 + $dx * cos(pi() * ($this->paths[$i]->y1 - $omega) / $dy));
      $this->paths[$i]->y1 = intval($this->paths[$i]->y1);
      $this->paths[$i]->x2 = intval($this->paths[$i]->x2 + $dx * cos(pi() * ($this->paths[$i]->y2 - $omega) / $dy));
      $this->paths[$i]->y2 = intval($this->paths[$i]->y2);
      $this->paths[$i]->x3 = intval($this->paths[$i]->x3 + $dx * cos(pi() * ($this->paths[$i]->y3 - $omega) / $dy));
      $this->paths[$i]->y3 = intval($this->paths[$i]->y3);
      $this->MaxX = max($this->MaxX, $this->paths[$i]->x1, $this->paths[$i]->x3);
      $this->MaxY = max($this->MaxY, $this->paths[$i]->y1, $this->paths[$i]->y3);
      $this->MinX = min($this->MinX, $this->paths[$i]->x1, $this->paths[$i]->x3);
      $this->MinY = min($this->MinY, $this->paths[$i]->y1, $this->paths[$i]->y3);
    }
  }

  function Broke($dx, $dy) {
    $rx = 0; $ry = 0;
    $this->ClearMetrics();
    for ($i = 0; $i < count($this->paths); $i++) {
      $rx = 2 * $dx * (mt_rand(0, 99)/100) - $dx;
      $ry = 2 * $dy * (mt_rand(0, 99)/100) - $dy;
      $this->paths[$i]->x1 = intval($this->paths[$i]->x1 + $rx);
      $this->paths[$i]->y1 = intval($this->paths[$i]->y1 + $ry);
      $rx = 2 * $dx * (mt_rand(0, 99)/100) - $dx;
      $ry = 2 * $dy * (mt_rand(0, 99)/100) - $dy;
      $this->paths[$i]->x3 = intval($this->paths[$i]->x3 + $rx);
      $this->paths[$i]->y3 = intval($this->paths[$i]->y3 + $ry);
      $this->MaxX = max($this->MaxX, $this->paths[$i]->x1, $this->paths[$i]->x3);
      $this->MaxY = max($this->MaxY, $this->paths[$i]->y1, $this->paths[$i]->y3);
      $this->MinX = min($this->MinX, $this->paths[$i]->x1, $this->paths[$i]->x3);
      $this->MinY = min($this->MinY, $this->paths[$i]->y1, $this->paths[$i]->y3);
    }
  }
  
  function Normalize($mx, $my) {
    $kx = $mx / ($this->MaxX - $this->MinX);
    $ky = $my / ($this->MaxY - $this->MinY);
    if ($kx == 0) $kx = $ky;
    if ($ky == 0) $ky = $kx;
    $dx = $this->MinX;
    $dy = $this->MinY;
    $this->ClearMetrics();
    for ($i = 0; $i < count($this->paths); $i++) {
      $this->paths[$i]->x1 = intval(($this->paths[$i]->x1 - $dx) * $kx);
      $this->paths[$i]->y1 = intval(($this->paths[$i]->y1 - $dy) * $ky);
      $this->paths[$i]->x2 = intval(($this->paths[$i]->x2 - $dx) * $kx);
      $this->paths[$i]->y2 = intval(($this->paths[$i]->y2 - $dy) * $ky);
      $this->paths[$i]->x3 = intval(($this->paths[$i]->x3 - $dx) * $kx);
      $this->paths[$i]->y3 = intval(($this->paths[$i]->y3 - $dy) * $ky);
      $this->MaxX = max($this->MaxX, $this->paths[$i]->x1, $this->paths[$i]->x3);
      $this->MaxY = max($this->MaxY, $this->paths[$i]->y1, $this->paths[$i]->y3);
      $this->MinX = min($this->MinX, $this->paths[$i]->x1, $this->paths[$i]->x3);
      $this->MinY = min($this->MinY, $this->paths[$i]->y1, $this->paths[$i]->y3);
    }
  }
  
  function Addition($cx, $cy) {
    for ($i = 0; $i < count($this->paths); $i++) {
      $this->paths[$i]->x1 = intval($this->paths[$i]->x1 + $cx);
      $this->paths[$i]->y1 = intval($this->paths[$i]->y1 + $cy);
      $this->paths[$i]->x2 = intval($this->paths[$i]->x2 + $cx);
      $this->paths[$i]->y2 = intval($this->paths[$i]->y2 + $cy);
      $this->paths[$i]->x3 = intval($this->paths[$i]->x3 + $cx);
      $this->paths[$i]->y3 = intval($this->paths[$i]->y3 + $cy);
    }
    $this->MaxX = $this->MaxX + $cx;
    $this->MaxY = $this->MaxY + $cy;
    $this->MinX = $this->MinX + $cx;
    $this->MinY = $this->MinY + $cy;
  }

  function Mul($cx, $cy) {
    for ($i = 0; $i < count($this->paths); $i++) {
      $this->paths[$i]->x1 = intval($this->paths[$i]->x1 * $cx);
      $this->paths[$i]->y1 = intval($this->paths[$i]->y1 * $cy);
      $this->paths[$i]->x2 = intval($this->paths[$i]->x2 * $cx);
      $this->paths[$i]->y2 = intval($this->paths[$i]->y2 * $cy);
      $this->paths[$i]->x3 = intval($this->paths[$i]->x3 * $cx);
      $this->paths[$i]->y3 = intval($this->paths[$i]->y3 * $cy);
    }
    $this->MaxX = $this->MaxX * $cx;
    $this->MaxY = $this->MaxY * $cy;
    $this->MinX = $this->MinX * $cx;
    $this->MinY = $this->MinY * $cy;
    if ($this->MaxX < $this->MinX) {
      $t = $this->MaxX;
      $this->MaxX = $this->MinX;
      $this->MinX = $t;
    }
    if ($this->MaxY < $this->MinY) {
      $t = $this->MaxY;
      $this->MaxY = $this->MinY;
      $this->MinY = $t;
    }
  }
  
  function Mix() {
    $r = 0; $t = 0;
    for ($i = 0; $i < count($this->paths); $i++) {
      $r = intval((mt_rand(0, 99)/100)*(count($this->paths)));
      $t = $this->paths[$i]->x1;
      $this->paths[$i]->x1 = $this->paths[$r]->x1;
      $this->paths[$r]->x1 = $t;
      $t = $this->paths[$i]->y1;
      $this->paths[$i]->y1 = $this->paths[$r]->y1;
      $this->paths[$r]->y1 = $t;
      $t = $this->paths[$i]->x2;
      $this->paths[$i]->x2 = $this->paths[$r]->x2;
      $this->paths[$r]->x2 = $t;
      $t = $this->paths[$i]->y2;
      $this->paths[$i]->y2 = $this->paths[$r]->y2;
      $this->paths[$r]->y2 = $t;
      $t = $this->paths[$i]->x3;
      $this->paths[$i]->x3 = $this->paths[$r]->x3;
      $this->paths[$r]->x3 = $t;
      $t = $this->paths[$i]->y3;
      $this->paths[$i]->y3 = $this->paths[$r]->y3;
      $this->paths[$r]->y3 = $t;
    }
  }
  
  function Noise() {
    $this->paths[] = new clsQuadraticPath(0, 0, 0, 0, 0, 0);
    $last = count($this->paths) - 1;
    $this->paths[$last]->x1 = $this->MinX + intval((mt_rand(0, 99)/100)*($this->MaxX - $this->MinX));
    $this->paths[$last]->y1 = $this->MinY + intval((mt_rand(0, 99)/100)*($this->MaxY - $this->MinY));
    $this->paths[$last]->x3 = $this->MinX + intval((mt_rand(0, 99)/100)*($this->MaxX - $this->MinX));
    $this->paths[$last]->y3 = $this->MinY + intval((mt_rand(0, 99)/100)*($this->MaxY - $this->MinY));
    $this->paths[$last]->x2 = min($this->paths[$last]->x3, $this->paths[$last]->x1) + intval((mt_rand(0, 99)/100) * abs($this->paths[$last]->x1 - $this->paths[$last]->x3));
    $this->paths[$last]->y2 = min($this->paths[$last]->y3, $this->paths[$last]->y1) + intval((mt_rand(0, 99)/100) * abs($this->paths[$last]->y1 - $this->paths[$last]->y3));
  }
    
  function Noises($n) {
    for ($i = 0; $i < $n; $i++) {
      $this->Noise();
    }
  }
  
  function AddPaths($p) {
    for ($i = 0; $i < count($p->paths); $i++) {
      $this->paths[] = new clsQuadraticPath($p->paths[$i]->x1, $p->paths[$i]->y1, $p->paths[$i]->x2, $p->paths[$i]->y2, $p->paths[$i]->x3, $p->paths[$i]->y3);
      $last = count($this->paths) - 1;
      $this->MaxX = max($this->MaxX, $this->paths[$last]->x1, $this->paths[$last]->x3);
      $this->MaxY = max($this->MaxY, $this->paths[$last]->y1, $this->paths[$last]->y3);
      $this->MinX = min($this->MinX, $this->paths[$last]->x1, $this->paths[$last]->x3);
      $this->MinY = min($this->MinY, $this->paths[$last]->y1, $this->paths[$last]->y3);
    }
  }
    
}
//End clsQuadraticPaths class

//clsMasterPageTemplate class @0-CFFF2CB7
class clsMasterPageTemplate {

  public $Redirect;
  public $Tpl;
  public $HTMLTemplate;
  public $TemplateFileName;
  public $ComponentName;
  public $Attributes;
  public $HTML;
  
  public $CCSEvents;
  public $CCSEventResult;
  
  public $Visible;
  public $Page;
  public $Name;
  public $CacheAction;
  public $TemplateSource = "";
  public $TemplatePathValue;
  
  function clsMasterPageTemplate() {
    $this->Visible = true;
    $this->Redirect = "";
  }
  
  function Operation() {
    if (!$this->Visible) return;
  }
  
  function Initialize($Name, $Path) {
    $this->Name = $Name;
    $this->TemplatePathValue = $Path;
    if (!$this->Visible) return;
  }
  
  function InitializeTemplate() {
    global $PathToRoot, $Tpl, $TemplateEncoding;
    $this->HTMLTemplate = new clsTemplate();
    if (!strlen($this->TemplateSource)) {
      $this->HTMLTemplate->LoadTemplate($this->TemplatePathValue . $this->TemplateFileName, "main", $TemplateEncoding);
    } else {
      $this->HTMLTemplate->LoadTemplateFromStr($this->TemplateSource, "main", $TemplateEncoding);
    }
    $this->HTMLTemplate->SetVar("CCS_PathToRoot", $PathToRoot);
    $this->HTMLTemplate->block_path = "/main";
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnInitializeView", $this);
  }
  
  function Show() {
    $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
    if (!$this->Visible) return;
    $this->HTMLTemplate->SetVar("CCS_PathToCurrentPage", RelativePath . $this->TemplatePathValue);
    $this->HTMLTemplate->SetVar("page:pathToCurrentPage", RelativePath . $this->TemplatePathValue);
    $this->Attributes->SetValue("PathToCurrentPage", RelativePath . $this->TemplatePathValue);
    $this->Attributes->Show();
    $this->HTMLTemplate->block_path = "";
    $this->HTMLTemplate->parse("main", false);
    $this->HTML = $this->HTMLTemplate->GetVar("main");
  }
  
}
//End clsMasterPageTemplate class


?>
