<?php
header('Content-Type: application/json');
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$provider_connexion_id = $_POST['provider_connexion_id'];
$cms = array();
if(CCGetUserID() && $provider_connexion_id){
	$db = new clsDBminseg();
	$SQL = "SELECT monitoring_center_id FROM camera_providers_mc WHERE provider_connexion_id = $provider_connexion_id";
	$db->query($SQL);
	while($db->next_record()){
		$cms[] = $db->f('monitoring_center_id');
	}
	$db->close();
}
echo json_encode($cms);
?>