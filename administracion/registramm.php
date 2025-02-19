<?php
header('Content-Type: application/json');
define("RelativePath", "..");
include(RelativePath . "/Common.php");
$make_id = $_POST['make_id'];
$model_id = $_POST['model_id'];
if(CCGetUserID() && $make_id && model_id){
	$db = new clsDBminseg();
	$user_id = CCGetUserID();
	$count = CCDLookUp("COUNT(*)","makes_models","make_id = $make_id AND model_id = $model_id",$db);
	if($count == 0){
		$SQL = "INSERT INTO makes_models SET make_id = $make_id, model_id = $model_id, make_model_c_f = NOW(), make_model_u_id = $user_id";
		$db->query($SQL);
		echo json_encode(1);
	}else{
		echo json_encode(0); 	
	}
	$db->close();	 
}else{
	echo json_encode(0); 
}
?>