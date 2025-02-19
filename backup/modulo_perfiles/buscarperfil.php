<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");
//$nombre = utf8_decode(CCGetParam('nombre'));
$nombre = mb_convert_encoding(CCGetParam('nombre'), 'UTF-8', 'ISO-8859-1');
$db = new clsDBminseg();
$tipo_perfil_id = CCDLookUp("tipo_perfil_id","tipos_perfiles","tipo_perfil_descrip='$nombre'",$db);
$db->close();
echo $tipo_perfil_id;
?>

