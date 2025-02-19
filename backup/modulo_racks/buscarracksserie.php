<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$nombreserie = CCGetParam('nombreserie');
$db = new clsDBminseg();
$racks_id = CCDLookUp("rack_id","racks","num_serie='$nombreserie'",$db);
$db->close();
echo $racks_id;
?>