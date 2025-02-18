<?php
/* Archivo de configuración proyecto Gestión Cármaras Videovigilancia
----------------------------------------------------------------------------- */

// Configuración para el back-end
$appConfig = array(
    'environment' => 'dev', // entorno activo ('dev', 'test', 'production' o 'demo')
    'defaultReferer' => 'http://192.168.62.7',
    'database' => array(
      'host' => 'localhost',
      'database' => 'minseg_novedades',
      'username' => 'php_user',
      'password' => 'phpuser',
      'port' => '3306',
    ),
    'arcgis' => array(
        'jsapi_url' => 'http://192.168.62.7/arcgis_js_api/library/3.3/jsapi',
        'services_secured' => true,
        'services_access_token' => 'bvfAV2oThxYjbtr6i6o71ioPlH2nUHaBink3R9F7yuTmXKFEmdzqWi26fwxiGLt2dSAfSbapYy_9-enNGO-WSw..',
        'services' => array(
          'cameras_features' => 'http://192.168.62.7/ArcGIS/rest/services/Videovigilancia/Videovigilancia/FeatureServer/0/',
          'locator' => 'http://192.168.62.7/ArcGIS/rest/services/Cartografia_base/USUARIO3.LOCALIZADOR/GeocodeServer'
        )
    ),
);

// Configuración para el front-end
$appConfigJs = array(
    'environment' => 'test', // entorno activo ('dev', 'test', 'production' o 'demo')
    // guarda los estados de la aplicación
    'statuses' => array(
      'addCamera' => false,
      'editCamera' => false,
      'recordMode' => false,
      'addFormError' => false,
      'removeFormError' => false,
    ),
    // listado de estados para las cámaras
    'cameraStatuses' => array(
      'projected' => 'Proyectada',
      'free' => 'Retirada',
      'selected' => 'Seleccionada',
      'failure' => 'Con fallas',
      'withdrawn' => 'Retirada',
	  'moved' => 'movida',
	  'lost' => 'extraviada',
	  'available' => 'disponible',
      'inactive' => 'Inactiva',
	  'inactive2' => 'Sin Funcionamiento',
      'active' => 'Activa',
      'damaged' => 'Dañada',
	  'damaged2' => 'Problema de Movimiento',
      'deleted' => 'Eliminada',
	  'fixed' => 'Fija',
	  'offline' => 'Fuera de Servicio',
	  'movement_problem' => 'Problema de Movimiento',
	  'movement_record' => 'Problema de Grabacion'
    ),
    // guardar los handlers vinculados a eventos del mapa
    'handlers' => array(),
    // guarda el listado de cámaras a dibujar
    'cameras' => array(),
    // guarda la cámara a visualizar / centrar
    'selectedCamera' => false,
    // servicios cartográficos
    'arcgis' => array(
      'api' => $appConfig['arcgis']['jsapi_url'],
      'services' => 'http://192.168.62.7/ArcGIS/rest/services/',
	  'geometry' => 'Geometry/GeometryServer',
      'locator' => 'Cartografia_base/USUARIO3.LOCALIZADOR/GeocodeServer',
      'isSecured' => $appConfig['arcgis']['services_secured'],
      'accessToken' => $appConfig['arcgis']['services_access_token'],
      'accessString' => '',
      'spatialReferenceId' => 22182,
      'layers' => array(
        'streets' => 'Videovigilancia/calles_sat/MapServer',
        'images' => 'Imagenes_Satelitales/imagenes_satelitales_2/MapServer',
        'cameras' => 'Videovigilancia/Videovigilancia/MapServer',
        'neighborhoods' => 'Cartografia_base/Barrios/MapServer',
      ),
      'extents' => array(
        'initial' => array(
            'xMin' => 2513960.6644516,
            'yMin' => 6360975.8178074,
            'xMax' => 2515132.7709624,
            'yMax' => 6361893.3377428
        )
      )
    ),
    // otros recursos
    'baseURL' => '/gestion_camaras',
    'streetsSearchURL' => 'http://192.168.62.7/ws_servgis/callesmza.php',
	'streetsIntersecSearchURL' => 'http://192.168.62.7/ws_servgis/calleinterseccmza.php',
    'neighborhoodsSearchURL' => 'http://192.168.62.7/ws_servgis/barriosmza.php'
);