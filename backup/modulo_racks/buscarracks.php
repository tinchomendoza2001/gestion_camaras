<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$nombreid = CCGetParam('nombreid');
$db = new clsDBminseg();
$racks_id = CCDLookUp("rack_id","racks","rack_id='$nombreid'",$db);
$db->close();
echo $racks_id;
?>