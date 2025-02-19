/* Funciones
----------------------------------------------------------------------------- */
/**
 * Bloquea el elemento indicado en la UI con el mensaje indicado
 * @param  {string} element Elemento/s a bloquear
 * @param  {string} message Mensaje a mostrar
 * @return {void}
 */
function blockUIElement( element, showMessage ) {
  // parámetros por defecto
  showMessage = typeof showMessage != 'undefined' ? showMessage : 'Espere por favor...';

  $(element).block({
    css: {
      backgroundColor: '#000',
      border: 'none',
      color: '#fff',
      padding: '10px'
    },
    overlayCSS: {
      backgroundColor: '#fff',
      opacity: 0.7
    },
    message: showMessage
  });
}


/**
 * Desbloquea el elemento de la UI indicado
 * @param  {string} element Elemento/s a desbloquer
 * @return {void}
 */
function unblockUIElement( element ) {
  $(element).unblock();
}


function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
}

/**
 * Obtiene el ID en el array de cámaras Javascript de la cámara marcada como seleccionada
 * @return mixed Índice del array de la cámara seleccionada o false si no hay
 */
function getSelectedCamera() {
  var sel = false;
  $.each(MinSeg.cameras, function(key, value) {
    if ( value.selected == "1" ) {
      sel = key;
    }
  });
  return sel;
}


/**
 * Devuelve el índice del array de cámaras buscando por el recordID
 * FIXME: esto se podría mejorar usando direcamente los índices de registro en el array JS
 * @param  integer recordId ID del registro de la cámara
 * @return mixed            Índice del array de la cámara seleccionada o false si no hay
 */
function getCameraIndex(recordId) {
  var sel = false;
  $.each(MinSeg.cameras, function(key, value) {
    if ( value.recordId == recordId ) {
      sel = key;
    }
  });
  return sel;
}

/**
 * Filtra las cámaras en el mapa según los parámetros del buscador
 * @return void
 */
function filterCameras() {
  // obtiene los datos
  var URL = '../services/gestion_camara_lista_camaras.php?';
  if ( $('#selCenter').val() ) URL = URL + '&center=' + $('#selCenter').val();
  if ( $('#selIdentification').val() ) URL = URL + '&identification=' + $('#selIdentification').val();
  if ( $('#selOwner').val() ) URL = URL + '&owner=' + $('#selOwner').val();
  if ( $('#selDepartment').val() ) URL = URL + '&department=' + $('#selDepartment').val();
  if ( $('#selStatus').val() ) URL = URL + '&status=' + $('#selStatus').val();
  if ( MinSeg.selectedCamera ) URL = URL + '&selected=' + MinSeg.selectedCamera;

  $.get( URL, function( data ) {
      // reemplaza el listado de cámaras
      MinSeg.cameras = data.data;

      // limpia la capa con cámaras
      map.graphics.clear();

      var elemCount = $(data.data).size();

      if ( elemCount > 0 ) {
          // redibuja los puntos en el mapa
          jQuery.each( MinSeg.cameras, function(index, value) {
              // prepara los datos de las càmaras
              if (
                  ( value.coord_x !== null && value.coord_x !== undefined )
                  && ( value.coord_y !== null && value.coord_y !== undefined )
                  && ( value.coord_x !== '' && value.coord_y !== '' )
              ) {
                  var status = value.status;
                  if ( value.selected == '1') status = 'selected';
                  addCameraMarker( value.coord_x, value.coord_y, value.id, index, status );
              }
          });

          // si está seleccionado ajustar vista hace zoom al extent de gráficos
          if ( elemCount > 1 ) {
              // si hay más de una cámara hace un zoom extent
              if ( $('#selAdjust').is(":checked") ) {
                  map.setExtent( getGraphicsExtent( map.graphics.graphics ) );
              }
          } else {
              // si hay solo una centra el mapa en el punto
              if ( $('#selAdjust').is(":checked") ) {
                  centerAtPoint( MinSeg.cameras[0].coord_x, MinSeg.cameras[0].coord_y );
              }
          }

      } else {
          alert('El filtro no devolvió ninguna cámara...');
      }

  });
}

function medir(){
	$( "#measurement" ).dialog("open");
	midiendo = true;
}

function capas(){
	$( "#capas_vista" ).dialog("open");
}
/* Main
----------------------------------------------------------------------------- */
/*var MinSeg = {
  // guarda los estados de la aplicación
  statuses: {
    addCamera: false,
    editCamera: false,
    recordMode: false,
    addFormError: false,
    removeFormError: false
  },
  // listado de estados para las cámaras
  cameraStatuses: {
    projected: 'Proyectada',
    free: 'Libre',
    selected: 'Seleccionada',
    failure: 'Con fallas',
    withdrawn: 'Retirada',
    inactive: 'Inactiva',
    active: 'Activa',
    damaged: 'Dañada',
    deleted: 'Eliminada'
  },
  // guardar los handlers vinculados a eventos del mpa
  handlers: {},
  // guarda el listado de cámaras a dibujar
  cameras: {},
  // guarda la cámara a visualizar / centrar
  selectedCamera: false,
  // opciones y configuraciones de ArcGis
  arcgis: {
    api: 'http://192.168.62.1/arcgis_js_api/library/3.3/jsapicompact_local',
    services: 'http://192.168.62.1/ArcGIS/rest/services/',
    locator: 'mdzcalles/DBO.LOCALIZADOR_DESA/GeocodeServer',
    isSecured: false, // sobreescrito desde PHP
    accessToken: '', // sobreescrito desde PHP
    accessString: '',
    spatialReferenceId: 22182,
    layers: {
        streets: 'mdzcalles/mdzCalles_mapa/MapServer',
        images: 'mdzcalles/mdzImagenes_sat/MapServer',
        cameras: 'mdzcalles/Videovigilancia/MapServer',
        neighborhoods: 'mdzcalles/barrios/MapServer'
    },
    extents: {
        initial: {
            xMin: 2513960.66445156,
            yMin: 6360975.8178074,
            xMax: 2515132.77096244,
            yMax: 6361893.3377428
        }
    }
  },
  // otros recursos
  baseURL: '/gestion_camaras',
  streetsSearchURL: 'http://minseg.v1/streets/search/',
  neighborhoodsSearchURL: 'http://minseg.v1/geoneighborhoods/search/'
};
*/
