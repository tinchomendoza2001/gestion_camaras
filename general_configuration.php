<?php
/*
 * Configuraciones para el proyecto Gestión de Videovigilancia
 */
define('APP_ENVIRONMENT', 'test'); // entorno de funcionamiento ('test' para el entorno de pruebas, 'production' para entorno de producción)


/* ArcGIS
----------------------------------------------------------------------------- */
define('JSAPI_URL', 'http://192.168.62.7/arcgis_js_api/library/3.3/jsapi');
define('CAMERAS_FEATURESERVER_PATH', 'http://192.168.62.7/ArcGIS/rest/services/Videovigilancia/Videovigilancia/FeatureServer/0/');
define('SERVICES_SECURED', false);
define('SERVICES_ACCESS_TOKEN', 'bvfAV2oThxYjbtr6i6o71ioPlH2nUHaBink3R9F7yuTmXKFEmdzqWi26fwxiGLt2dSAfSbapYy_9-enNGO-WSw..');