<?php
header('Content-Type: application/json');
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$usuario_id = $_POST['user_id'];
$cm_id = $_POST['cm_id'];
if(CCGetUserID() && $usuario_id){
	$db = new clsDBminseg();
	$user_id = CCGetUserID();
	if($cm_id > 0){
		$SQL = "UPDATE camera_users SET monitor_center_p_id = '$cm_id', user_chance_f = NOW(), user_chance_id = $user_id WHERE id = '$usuario_id'";
	}else{
		$SQL = "UPDATE camera_users SET monitor_center_p_id = NULL, user_chance_f = NOW(), user_chance_id = $user_id WHERE id = '$usuario_id'";		
	}
	$db->query($SQL);
	$db->close();
	echo json_encode(1); 
}else{
	echo json_encode(0); 
}
?>