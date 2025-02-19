<?php
header('Content-type: application/json');
define("RelativePath", "..");
include(RelativePath . "/Common.php");

$geojson = array(
   'type'      => 'FeatureCollection',
   'features'  => array()
);
$db = new clsDBminseg();
$SQL = "SELECT * FROM vCamaras";
$db->query($SQL);
while($db->next_record()){
	$feature = array(
		'id' => $db->f('OBJECTID'),
		'type' => 'Feature', 
		'geometry' => array(
			'type' => 'Point',
			'coordinates' => array($db->f('longitud'),$db->f('latitud'))
		),
		'properties' => array(
			'centro_monitoreo' => iconv("WINDOWS-1252","UTF-8",$db->f('centro_monitoreo')),
			'codigo_centro_monitoreo' => iconv("WINDOWS-1252","UTF-8",$db->f('codigo_centro_monitoreo')),
			'identificacion' => iconv("WINDOWS-1252","UTF-8",$db->f('identificacion')),
			'proyecto' => iconv("WINDOWS-1252","UTF-8",$db->f('proyecto')),
			'etapa' => iconv("WINDOWS-1252","UTF-8",$db->f('etapa')),
			'tipo_provicion' => iconv("WINDOWS-1252","UTF-8",$db->f('tipo_provicion')),
			'department_name' => iconv("WINDOWS-1252","UTF-8",$db->f('department_name')),
			'proveedor_conexion' => iconv("WINDOWS-1252","UTF-8",$db->f('proveedor_conexion')),
			'estado_ubicacion' => iconv("WINDOWS-1252","UTF-8",$db->f('estado_ubicacion')),
			'estado_fecha_ubicacion' => iconv("WINDOWS-1252","UTF-8",$db->f('estado_fecha_ubicacion')),
			'camera_id' => iconv("WINDOWS-1252","UTF-8",$db->f('camera_id')),
			'camara_modelo' => iconv("WINDOWS-1252","UTF-8",$db->f('camara_modelo')),
			'camara_nro_serie' => iconv("WINDOWS-1252","UTF-8",$db->f('camara_nro_serie')),
			'estado_camara' => iconv("WINDOWS-1252","UTF-8",$db->f('estado_camara')),
			'coord_x' => iconv("WINDOWS-1252","UTF-8",$db->f('coord_x')),
			'coord_y' => iconv("WINDOWS-1252","UTF-8",$db->f('coord_y'))
			)
	);
	array_push($geojson['features'], $feature);
}
$db->close();
echo json_encode($geojson, JSON_NUMERIC_CHECK);
?>