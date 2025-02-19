<?php
header('Content-Type: application/json');
define("RelativePath", "..");
include(RelativePath . "/Common.php");
if(CCGetUserID() && $_POST['motivo_id'] && $_POST['value_rol'] && !empty($_POST['marcado'])){
	$motivo_id = $_POST['motivo_id'];
	$value_rol = $_POST['value_rol'];
	$marcado = $_POST['marcado'];
	if($marcado == 'true'){
		$pasa = 1;
	}elseif($marcado == 'false'){
		$pasa = 0;
	}
	$db = new clsDBminseg();
	$cant = CCDLookUp("COUNT(*)","camera_reason_event_groups","reason_event_id = $motivo_id AND group_id = $value_rol",$db);
	if($pasa == 1){//si marcó
		if(!$cant){//verificar sino está
			//registrar
			$SQL = "INSERT INTO camera_reason_event_groups SET
							reason_event_id = $motivo_id,
							group_id = $value_rol";
			$db->query($SQL);
		}
		echo json_encode(1);
	}elseif($pasa == 0){
		if($cant){//verificar si está
			//desregistrar
			$SQL = "DELETE FROM camera_reason_event_groups WHERE reason_event_id = $motivo_id AND group_id = $value_rol";
			$db->query($SQL);
		}
		echo json_encode(0);
	}
	$db->close();
}
?>