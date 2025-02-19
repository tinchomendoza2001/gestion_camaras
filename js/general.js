/* Funciones
----------------------------------------------------------------------------- */
/**
 * Bloquea el elemento indicado en la UI con el mensaje indicado
 * @param  {string} element Elemento/s a bloquear
 * @param  {string} message Mensaje a mostrar
 * @return {void}
 */
function blockUIElement( element, showMessage, time ) {
  // parámetros por defecto
  showMessage = typeof showMessage != 'undefined' ? showMessage : 'Espere por favor...';
  time = typeof time != 'undefined' ? time : 0;

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
    message: showMessage,
    timeout: time
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
  if ( $('#NewRecord1camera_marca_id').val() ) URL = URL + '&camera_marca_id=' + $('#NewRecord1camera_marca_id').val();
  if ( MinSeg.selectedCamera ) URL = URL + '&selected=' + MinSeg.selectedCamera;

  $.get( URL, function( data ) {
	  
      // reemplaza el listado de cámaras
      MinSeg.cameras = data.data;
		//console.log(MinSeg.cameras);
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
				  //console.log(value);
                  if ( value.selected == '1') status = 'selected';
                  addCameraMarker( value.coord_x, value.coord_y, value.id, index, status );
              }
          });

          // si está seleccionado ajustar vista hace zoom al extent de gráficos
          if ( elemCount > 1 ) {
              // si hay más de una cámara hace un zoom extent
              if ( $('#selAdjust').is(":checked") ) {
				  var extend = getGraphicsExtent( map.graphics.graphics );
				  var zoom = 500;
				  extend.xmin = extend.xmin - zoom;
				  extend.ymin = extend.ymin - zoom;
				  extend.xmax = extend.xmax + zoom;
				  extend.ymax = extend.ymax + zoom;
                  map.setExtent( extend );
              }
          } else {
              // si hay solo una centra el mapa en el punto
              if ( $('#selAdjust').is(":checked") ) {
                  centerAtPoint( MinSeg.cameras[0].coord_x, MinSeg.cameras[0].coord_y );
              }
          }
		  //--------------------------------------------------------------------------------------------------------------------------------------------
		  //traer cantidades
		  $.getJSON( "cantidades_estados.php" , function(result){
			  	document.getElementById("estado_camara_1").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_en_funcionamiento + "</font>";
				document.getElementById("estado_camara_2").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_con_falla + "</font>";
				document.getElementById("estado_camara_3").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_fuera_de_servicio + "</font>";
				document.getElementById("estado_camara_4").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_libre + "</font>";
			  /*			  
				document.getElementById("estado_camara_1").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_1 + "</font>";
				document.getElementById("estado_camara_2").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_2 + "</font>";
				document.getElementById("estado_camara_3").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_3 + "</font>";
				document.getElementById("estado_camara_4").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_4 + "</font>";
				document.getElementById("estado_camara_7").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_7 + "</font>";
				document.getElementById("estado_camara_8").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_8 + "</font>";
				document.getElementById("estado_camara_9").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_9 + "</font>";
				document.getElementById("estado_camara_10").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_10 + "</font>";
				document.getElementById("estado_camara_11").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_11 + "</font>";
				document.getElementById("estado_camara_12").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_12 + "</font>";
				document.getElementById("estado_camara_13").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_13 + "</font>";
				document.getElementById("estado_camara_14").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_14 + "</font>";
				document.getElementById("estado_camara_15").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_15 + "</font>";
				document.getElementById("estado_camara_quitada").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_quitada + "</font>";
				document.getElementById("estado_camara_libre").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_libre + "</font>";
				document.getElementById("estado_camara_prevista").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_prevista + "</font>";
				*/
		  });
		  $( "#dialog_cant" ).dialog("open");
      } else {
			//-----------------------------------------------------------
			$( "#dialog_cant" ).dialog("close");
			document.getElementById("estado_camara_1").innerHTML = "<font size='1' color='blue'>S|D</font>";
			document.getElementById("estado_camara_2").innerHTML = "<font size='1' color='blue'>S|D</font>";
			document.getElementById("estado_camara_3").innerHTML = "<font size='1' color='blue'>S|D</font>";
			document.getElementById("estado_camara_4").innerHTML = "<font size='1' color='blue'>S|D</font>";			
			/*
			document.getElementById("estado_camara_1").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_2").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_3").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_4").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_7").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_8").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_9").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_10").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_11").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_12").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_13").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_14").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_15").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_quitada").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_libre").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_prevista").innerHTML = "<font size='1'>S|D</font>";
			*/
		//----------------------------------------------------------------------------------------		  
          alert('El filtro no devolvió ninguna cámara...');
      }

  });
}

function filterEstadosTikets() {
  // obtiene los datos
  var URL = '../services/lista_camaras_estado_ticket.php?';
  if ( $('#selCenter').val() ) URL = URL + '&center=' + $('#selCenter').val();
  if ( $('#selIdentification').val() ) URL = URL + '&identification=' + $('#selIdentification').val();
  if ( $('#selOwner').val() ) URL = URL + '&owner=' + $('#selOwner').val();
  if ( $('#selDepartment').val() ) URL = URL + '&department=' + $('#selDepartment').val();
  if ( $('#selStatus').val() ) URL = URL + '&status=' + $('#selStatus').val();
  if ( $('#NewRecord1camera_marca_id').val() ) URL = URL + '&camera_marca_id=' + $('#NewRecord1camera_marca_id').val();
  if ( $('#NewRecord1estados_tickets').val() ) URL = URL + '&estados_tickets=' + $('#NewRecord1estados_tickets').val();
  if ( MinSeg.selectedCamera ) URL = URL + '&selected=' + MinSeg.selectedCamera;

  //console.log(URL);
  $.get( URL, function( data ) {
      // reemplaza el listado de cámaras
      MinSeg.cameras = data.data;
		//console.log(MinSeg.cameras);
      var elemCount = $(data.data).size();
	  //console.log(elemCount);
	  //map.graphics.clear();
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
				  //console.log(value);
                  if ( value.selected == '1') status = 'selected';
                  addCameraMarker( value.coord_x, value.coord_y, value.id, index, status );
              }
          });

          // si está seleccionado ajustar vista hace zoom al extent de gráficos
          if ( elemCount > 1 ) {
              // si hay más de una cámara hace un zoom extent
              if ( $('#selAdjust').is(":checked") ) {				  
				  var extend = getGraphicsExtent( map.graphics.graphics );
				  var zoom = 500;
				  extend.xmin = extend.xmin - zoom;
				  extend.ymin = extend.ymin - zoom;
				  extend.xmax = extend.xmax + zoom;
				  extend.ymax = extend.ymax + zoom;
                  map.setExtent( extend );
              }
          } else {
              // si hay solo una centra el mapa en el punto
              if ( $('#selAdjust').is(":checked") ) {
                  centerAtPoint( MinSeg.cameras[0].coord_x, MinSeg.cameras[0].coord_y );
              }
          }
		  //--------------------------------------------------------------------------------------------------------------------------------------------
		  //traer cantidades

		  $.getJSON( "cantidades_estados.php" , function(result){
			  	document.getElementById("estado_camara_1").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_en_funcionamiento + "</font>";
				document.getElementById("estado_camara_2").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_con_falla + "</font>";
				document.getElementById("estado_camara_3").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_fuera_de_servicio + "</font>";
				document.getElementById("estado_camara_4").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_libre + "</font>";
			  /*
				document.getElementById("estado_camara_1").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_1 + "</font>";
				document.getElementById("estado_camara_2").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_2 + "</font>";
				document.getElementById("estado_camara_3").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_3 + "</font>";
				document.getElementById("estado_camara_4").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_4 + "</font>";
				document.getElementById("estado_camara_7").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_7 + "</font>";
				document.getElementById("estado_camara_8").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_8 + "</font>";
				document.getElementById("estado_camara_9").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_9 + "</font>";
				document.getElementById("estado_camara_10").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_10 + "</font>";
				document.getElementById("estado_camara_11").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_11 + "</font>";
				document.getElementById("estado_camara_12").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_12 + "</font>";
				document.getElementById("estado_camara_13").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_13 + "</font>";
				document.getElementById("estado_camara_14").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_14 + "</font>";
				document.getElementById("estado_camara_15").innerHTML = "<font size='1' color='blue'>" + result.cant_cam_15 + "</font>";
				document.getElementById("estado_camara_quitada").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_quitada + "</font>";
				document.getElementById("estado_camara_libre").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_libre + "</font>";
				document.getElementById("estado_camara_prevista").innerHTML = "<font size='1' color='blue'>" + result.cant_ubi_prevista + "</font>";
				*/
		  });
		  $( "#dialog_cant" ).dialog("open");
      } else {
			//-----------------------------------------------------------
			// limpia la capa con cámaras
			
			$( "#dialog_cant" ).dialog("close");
			document.getElementById("estado_camara_1").innerHTML = "<font size='1' color='blue'>S|D</font>";
			document.getElementById("estado_camara_2").innerHTML = "<font size='1' color='blue'>S|D</font>";
			document.getElementById("estado_camara_3").innerHTML = "<font size='1' color='blue'>S|D</font>";
			document.getElementById("estado_camara_4").innerHTML = "<font size='1' color='blue'>S|D</font>";			
			/*
			document.getElementById("estado_camara_1").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_2").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_3").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_4").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_7").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_8").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_9").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_10").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_11").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_12").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_13").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_14").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_15").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_quitada").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_libre").innerHTML = "<font size='1'>S|D</font>";
			document.getElementById("estado_camara_prevista").innerHTML = "<font size='1'>S|D</font>";
			*/
		//----------------------------------------------------------------------------------------		  
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

function imagen(){
	$( "#camera_users_view" ).dialog("open");
}

function filtrar_cam(){
	$( "#camera_filter_view" ).dialog("open");
}