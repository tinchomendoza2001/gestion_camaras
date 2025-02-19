<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$nombre = CCGetParam('nombre');
$db = new clsDBminseg();
$nkv_id = CCDLookUp("nvk_id","nvk","nvk_nro_serie='$nombre'",$db);
if(!$nkv_id){
	$nkv_id = CCDLookUp("nvk_id","nvk","nvk_id='$nombre'",$db);;
}
$db->close();
echo $nkv_id;
?>

