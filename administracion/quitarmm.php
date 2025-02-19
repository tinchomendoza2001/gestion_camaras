<?php
header('Content-Type: application/json');
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$make_model_id = $_POST['make_model_id'];
if(CCGetUserID() && $make_model_id){
	$db = new clsDBminseg();
	$user_id = CCGetUserID();
	$SQL = "DELETE FROM makes_models WHERE make_model_id = $make_model_id";
	$db->query($SQL);
	$db->close();
	echo json_encode(1); 
}else{
	echo json_encode(0); 
}
?>