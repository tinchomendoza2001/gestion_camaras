/* Funciones
----------------------------------------------------------------------------- */
/**
 * Inicialización de la API de Arc Gis
 */
function init() {

  var layersLoaded = 0;  //varible to keep track of when all layers have been loaded.

  // Configuración
  var initExtent = new esri.geometry.Extent(
    {
      "xmin": MinSeg.arcgis.extents.initial.xMin,
      "ymin": MinSeg.arcgis.extents.initial.yMin,
      "xmax": MinSeg.arcgis.extents.initial.xMax,
      "ymax": MinSeg.arcgis.extents.initial.yMax,
      "spatialReference": {
        "wkid": MinSeg.arcgis.spatialReferenceId
      }
    }
  );

  // Si los servicios tienen implementada la seguridad genera el parametro con el token
  if (MinSeg.arcgis.isSecured === true) {
    //MinSeg.arcgis.accessString = '?token=' + MinSeg.arcgis.accessToken;
    MinSeg.arcgis.accessString = '?token=' + MinSeg.arcgis.accessToken;
  }

  // Crea el mapa
  map = new esri.Map("map", { nav:false, extent: initExtent, logo:false } );

  // Crea el locator
  locator = new esri.tasks.Locator( MinSeg.arcgis.services + MinSeg.arcgis.locator + MinSeg.arcgis.accessString );

  // agregar layers
  var calles = new esri.layers.ArcGISDynamicMapServiceLayer(
    MinSeg.arcgis.services + MinSeg.arcgis.layers.streets  + MinSeg.arcgis.accessString,
    { "opacity": 0.8 }
  );
  /* var cartografia = new esri.layers.ArcGISTiledMapServiceLayer(
    MinSeg.arcgis.services + MinSeg.arcgis.layers.images
  );*/
  /*var camaras = new esri.layers.ArcGISDynamicMapServiceLayer(
    MinSeg.arcgis.services + MinSeg.arcgis.layers.cameras,
    { "opacity": 1 }
  );*/

  map.addLayers( [calles] );

  // Agrega layers de gráficos para no interferir con los de dibujo de las cám
  newCameraLayer = map.addLayer( new esri.layers.GraphicsLayer() );
  searchLayer = map.addLayer( new esri.layers.GraphicsLayer() );


  // Eventos
  dojo.connect(map, "onLoad", function(map) {
    dojo.connect(dijit.byId("map"), "resize", map, map.resize);

    // Verifica y ejecuta si existe algo para ejecutar en la página que se está cargando
    if ( typeof(initPageMap) == "function" ) {
      initPageMap();
    }

    // Conecta los gráficos con el evento de hacerles click
    dojo.connect(map, "onClick", function(e) {
      if ( e.graphic !== null && e.graphic !== undefined && e.graphic ) {
        window.location = MinSeg.baseURL + '/gestion/gestion_camara.php?camera_location_id=' + e.graphic.attributes.recordId;
      }
    });

    // Conecta los gráficos con el evento de mouseover
    function showTooltip(evt){
      closeTooltip();
      var cameraStatuses = '';
      var tipContent = "<b>ID</b>: " + evt.graphic.attributes.id +
      "<br><b>Estado</b>: " + MinSeg.cameraStatuses[evt.graphic.attributes.status] +
      // "<br><b>Estado</b>: " + eval( 'MinSeg.cameraStatuses.' + evt.graphic.attributes.status ) +
      "<br><b>Cámara</b>: " + evt.graphic.attributes.camera_description;
      var dialog = new dijit.TooltipDialog({
        id: "tooltipDialog",
        content: tipContent,
        style: "position: absolute; width: 300px; font: normal normal normal 8pt Tahoma;z-index:100"
      });
      dialog.startup();
      dojo.style(dialog.domNode, "opacity", 0.85);
      dijit.placeOnScreen(dialog.domNode, {x: evt.pageX, y: evt.pageY}, ["TL", "BL"], {x: 10, y: 10});
    }

    function closeTooltip() {
      var widget = dijit.byId("tooltipDialog");
      if (widget) {
        widget.destroy();
      }
    }

    dojo.connect(map.graphics, "onMouseOver", function(evt) {
      showTooltip(evt);
      //var content = $(evt.graphic).tooltip( "option", "content" );
    });
    dojo.connect(map.graphics, "onMouseOut", function() { closeTooltip(); } );

/*    dojo.connect(map.graphics, "onMouseMove", function(evt) {
      var g = evt.graphic;
      console.log(g);
    });
    dojo.connect(map.graphics, "onMouseOut", function() { console.log('mouse out'); } );*/

  });
}


/**
 * Alterna entre el modo de agregar cámara y el modo normal
 * @return boolean true si se puso activo, false si se desactivó
 */
function toggleCameraAdd() {
  if ( MinSeg.statuses.addCamera === false ) {
    // cambia el estado de la aplicación
    MinSeg.statuses.addCamera = true;
    // crea un handler para el click en el mapa (los tengo que guardar en algun lado para despues poder desconectarlos)
    MinSeg.handlers.addCameraClick = dojo.connect(map, 'onClick', function(evt) {
      if ( evt ) {
        // agrega el marcador
        addCameraMarker(evt.mapPoint.x, evt.mapPoint.y, false, false, 'selected', true, newCameraLayer);
        // carga las coordenadas en los campos
        $('#cameras2coord_x').val( evt.mapPoint.x );
        $('#coord_x_display').html( evt.mapPoint.x );
        $('#cameras2coord_y').val( evt.mapPoint.y );
        $('#coord_y_display').html( evt.mapPoint.y );
        $('#localization-status').html('<span style="color:green">Ubicado</span>');
        // intenta capturar la dirección
        reverseGeolocate( evt.mapPoint, setAddress );
      }
    });
    return true;
  } else if ( MinSeg.statuses.addCamera === true ) {
    // limpia el layer de agregar cámara
    newCameraLayer.clear();
    // limpia los campos
    $('#localization-status').html('<span>Sin seleccionar</span>');
    $('#cameras2coord_x').val('');
    $('#coord_x_display').html('');
    $('#cameras2coord_y').val('');
    $('#coord_y_display').html('');
    $('#cameras2department_id').val('');
    $('#cameras2street_name').val('');
    $('#cameras2street_number').val('');
    // cambia el estado de la aplicación
    MinSeg.statuses.addCamera = false;
    // desconecta el handler y lo borra del objeto
    dojo.disconnect( MinSeg.handlers.addCameraClick );
    delete( MinSeg.handlers.addCameraClick );
    return false;
  }
}


/**
 * Alterna entre el modo de editar cámara y el modo normal
 * @return boolean true si se puso activo, false si se desactivó
 */
function toggleCameraEdit(id) {
  if ( MinSeg.statuses.editCamera === false ) {
    // cambia el estado de la aplicación
    MinSeg.statuses.editCamera = true;

    // crea un handler para el click en el mapa (los tengo que guardar en algun lado para despues poder desconectarlos)
    MinSeg.handlers.editCameraClick = dojo.connect(map, 'onClick', function(evt) {
      if ( evt ) {
        // quita el gráfico actual del mapa
        map.graphics.remove( MinSeg.cameras[id].graphic );
        map.graphics.remove( MinSeg.cameras[id].graphicLabel );
        // agrega el marcador
        var label = $('#cameras2old_name').val();
        var marker = addCameraMarker(evt.mapPoint.x, evt.mapPoint.y, label, id, 'selected', true, newCameraLayer);

        // carga las coordenadas en los campos
        $('#cameras2coord_x').val( evt.mapPoint.x );
        $('#coord_x_display').html( evt.mapPoint.x );
        $('#cameras2coord_y').val( evt.mapPoint.y );
        $('#coord_y_display').html( evt.mapPoint.y );
        $('#localization-status').html('<span style="color:green">Ubicado</span>');
        // intenta capturar la dirección
        reverseGeolocate( evt.mapPoint, setAddress );
      }
    });
    return true;
  } else if ( MinSeg.statuses.editCamera === true ) {
    // cambia el estado de la aplicación
    MinSeg.statuses.editCamera = false;
    // desconecta el handler y lo borra del objeto
    dojo.disconnect( MinSeg.handlers.editCameraClick );
    delete( MinSeg.handlers.editCameraClick );
    return false;
  }
}



/**
 * Agrega un marcador en el mapa
 * @param {double}  x         Coordenada x del punto
 * @param {double}  y         Coordenada y del punto
 * @param {string}  id        Descripción a mostrar
 * @param {string}  status    Tipo de la cámara a mostrar
 * @param {boolean} clear     Si es true limpia los elementos gráficos del mapa
 * @param {object}  layer     Si no se indica un objeto layer se usa map.graphics
 */
function addCameraMarker( x, y, id, cameraId, status, clear, layer ) {
  var markerSymbol;
  // determina el layer donde agregar el punto
  var resultLayer;
  if ( typeof layer === 'object' ) {
    resultLayer = layer;
  } else {
    resultLayer = map.graphics;
  }

  // si se indicó limpiar
  if ( clear === true ) resultLayer.clear();

  // define aspecto y punto
  switch( status ) {
    case 'search':
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_search_location.png', 25, 25);
      break;
    case 'selected':
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_camera_selected_sm.png', 20, 20);
      break;
    /*case 'free':
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_camera_free_sm.png', 20, 20);
      break;*/
    case 'projected':
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_camera_projected_sm.png', 20, 20);
      break;
    case 'failure':
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_camera_broken_sm.png', 20, 20);
      break;
    case 'damaged':
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_camera_broken_inactive_sm.png', 20, 20);
      break;
    case 'free':
    case 'withdrawn':
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_camera_retired_sm.png', 20, 20);
      break;
    case 'inactive':
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_camera_inactive_sm.png', 20, 20);
      break;
    case 'active':
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_camera_active_sm.png', 20, 20);
      break;
    case 'deleted':
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_camera_deleted_sm.png', 20, 20);
      break;
    default:
      markerSymbol = new esri.symbol.PictureMarkerSymbol('../img/icon_camera_unknow_sm.png', 20, 20);
  }

  var recordId;
  var point = new esri.geometry.Point(x, y, new esri.SpatialReference({ wkid: MinSeg.arcgis.spatialReferenceId }) ); //console.log(point);
  if ( cameraId !== null && cameraId !== undefined && cameraId !== false ) {
    recordId = (MinSeg.cameras[cameraId].recordId !== '') ? MinSeg.cameras[cameraId].recordId : false;
  } else {
    recordId = false;
  }

  var cameraDesc;
  if ( cameraId !== null && cameraId !== undefined && cameraId !== false ) {
    cameraDesc = (MinSeg.cameras[cameraId].camera_description !== '') ? MinSeg.cameras[cameraId].camera_description : false;
  } else {
    cameraDesc = false;
  }

  var attributes = { "id": id, "status": status, "recordId": recordId, "camera_description": cameraDesc };

  // si no se ha borrado y si se ha indicado el ID de la cámera asocia el gráfico al objecto correspondiente
  if ( status !== 'deleted' ) {
    if ( cameraId !== null && cameraId !== undefined && cameraId !== false ) {
      MinSeg.cameras[cameraId].graphic = new esri.Graphic( point, markerSymbol, attributes); //console.log( graphic );
      resultLayer.add( MinSeg.cameras[cameraId].graphic );
    } else {
      var graphic = new esri.Graphic( point, markerSymbol, attributes); //console.log( graphic );
      resultLayer.add( graphic );
    }

    // si se pasó algo como ID lo agrega como símbolo de texto
    if ( id !== null || id !== undefined || id !== false  )  {
      var font = new esri.symbol.Font('12px', esri.symbol.Font.STYLE_NORMAL, esri.symbol.Font.VARIANT_NORMAL,esri.symbol.Font.WEIGHT_BOLD, 'Arial');
      var markerText = new esri.symbol.TextSymbol(id, font, new dojo.Color([128,128,128]));
      markerText.setOffset(0,-21);
      if ( cameraId !== null && cameraId !== undefined && cameraId !== false ) {
        MinSeg.cameras[cameraId].graphicLabel = new esri.Graphic( point, markerText, attributes);
        resultLayer.add( MinSeg.cameras[cameraId].graphicLabel );
      } else {
        var graphicText = new esri.Graphic( point, markerText, attributes);
        resultLayer.add( graphicText );
      }
    }
  }
}


/**
 * Devuelve el extent de un set de gràficos de la cartografìa
 * @param  {object} graphics Conjunto de gráficos
 * @return {object}          Extent
 */
function getGraphicsExtent( graphics ) {
  var geometry, extent, ext;
  dojo.forEach(graphics, function(graphic, i) {
    geometry = graphic.geometry;

    if (geometry instanceof esri.geometry.Point) {
      ext = new esri.geometry.Extent(geometry.x - 1, geometry.y - 1, geometry.x + 1, geometry.y + 1, geometry.spatialReference);
    }
    else if (geometry instanceof esri.geometry.Extent) {
      ext = geometry;
    }
    else {
      ext = geometry.getExtent();
    }

    if (extent) {
      extent = extent.union(ext);
    }
    else {
      extent = new esri.geometry.Extent(ext);
    }
  });
  return extent;
}


/**
 * Devuelve el extent de un set de features
 * @param  {object} graphics Conjunto de features
 * @return {object}          Extent
 */
function getFeaturesExtent( features ) {
  var geometry, extent, ext;
  dojo.forEach(features, function(feature, i) {
    geometry = feature.geometry;

    if (geometry instanceof esri.geometry.Point) {
      ext = new esri.geometry.Extent(geometry.x - 1, geometry.y - 1, geometry.x + 1, geometry.y + 1, geometry.spatialReference);
    }
    else if (geometry instanceof esri.geometry.Extent) {
      ext = geometry;
    }
    else {
      ext = geometry.getExtent();
    }

    if (extent) {
      extent = extent.union(ext);
    }
    else {
      extent = new esri.geometry.Extent(ext);
    }
  });
  return extent;
}


/**
 * Separa número y calle de la dirección devuelta por el locator
 * @param  {object} address Dirección devuelta por el locator
 * @return {object}         Dirección separada
 */
function splitAddress( address ) {
  var data = { number: '', address: '' };
  if ( address !== '' ) {
    // busco el primer espacio
    dividerPos = address.indexOf(' ');
    if ( dividerPos > -1 ) {
      // busco desde el inicio hasta la pos. del espacio para el nro
      data.number = address.substr(0,dividerPos);
      // busco desde el la pos. del espacio en adelante para la calle
      data.street = address.substr(dividerPos + 1);
      return data;
    } else {
      return false;
    }
  } else {
    return false;
  }
}


/**
 * Hace geocoding reverso para encontrar una dirección en base a un punto geográfico
 * @param  object     eventData Objeto devuelto por el click en el mapa
 * @param  function   callback  Función a ejecutar con el resultado del event handler
 * @return mixed
 */
function reverseGeolocate( eventData, callback ) {
  if ( eventData !== null || eventData !== undefined ) {
    // handlers
    var handleError = dojo.connect(locator, "onError", function(error) {
      console.log(error);
    });

    var handle = dojo.connect(locator, "onLocationToAddressComplete", function(candidate) {
      // procesa la dirección candidata
      if ( callback !== undefined ) {
        callback( candidate );
      } else {
        return candidate;
      }
      // desconecta el event listener para que no siga tirando direcciones
      dojo.disconnect(handle);
    });

    // intenta geocodificar una dirección con el punto
    locator.locationToAddress(eventData, 50, null, function(){
        alert( 'No se pudo encontrar una dirección válida de acuerdo al punto marcado.');
    } );
  }

  return false;
}



function geolocateAddress( context ) {
  context = typeof context != 'undefined' ? $(context) : $('.location-panel');

  // Si NO es una dirección flexible intenta geolocalizar
  var streetElem = $('.location-panel-street', context);
  var intersectionElem = $('.location-panel-intersection', context);
  var numberElem = $('.location-panel-street-number', context);
  var departmentElem = $('.location-panel-department', context);

  // limpia las coordenadas
  //setCoordFields( '', '' );

  // determina si buscar por intersección o número
  if ( intersectionElem.val() !== '' ) {
    addressStreet = ', ' + streetElem.val() + ' @ ' + intersectionElem.val();
  } else {
    addressStreet = numberElem.val() + ', ' + streetElem.val();
  }

  var theAddress = {
    Street: addressStreet,
    State: departmentElem.val()
  };

  // si estan los datos mìnimos intenta geocodificar
  if ( streetElem.val() !== '' && ( numberElem.val() !== '' || intersectionElem.val() !== '' ) && departmentElem.val() !== '' ) {
    var handle = dojo.connect(locator, "onAddressToLocationsComplete", function(candidates) {
      // chequea si se devolvieron direcciones
      if ( ! $.isEmptyObject(candidates) ) {
        $.each(candidates, function(key, value) {
          if ( value.address !== '' ) {
            // carga las coordenadas en los campos
            //setCoordFields( value.location.x, value.location.y );
            // elimina gráficos por si había otro antes
            searchLayer.clear();
            // agrega el marcador y hace zoom
            addCameraMarker( value.location.x, value.location.y, false, false, 'search', true, searchLayer );
            ext = new esri.geometry.Extent( value.location.x - 300, value.location.y - 300, value.location.x + 300, value.location.y + 300, new esri.SpatialReference({wkid:MinSeg.arcgis.spatialReferenceId}) ); //console.log( ext );
            map.setExtent( ext );
            // desbloquea la UI
            unblockUIElement('.blockable-on-search');
            // cierra el diálogo
            $('#searchAddressDialog').dialog('close');
            return false;
          }
        });
      } else {
        // desbloquea la UI
        unblockUIElement('.blockable-on-search');
        alert( 'No se pudo encontrar la dirección indicada. Inténtelo nuevamente.');
      }
      // cancela el eventHandler
      dojo.disconnect(handle);
    });

    // bloquea la UI
    blockUIElement('.blockable-on-search', 'Geolocalizando dirección...');

    // geolocaliza
    locator.addressToLocations( {address: theAddress} );
  } else {
    alert('Los campos Departamento, Calle y Número o Intersección son obligatorios.');
  }

}


/**
 * Centra el mapa en las coordenadas indicadas y define extent con la distancia indicada
 * @param  mixed   x        Coordenada x
 * @param  mixed   y        Coordenada y
 * @param  integer distance Distancia para definir el extent
 * @return void
 */
function centerAtPoint( x, y, distance ) {
  // parsea las coordenadas para asegurarnos que son números
  x = parseFloat(x);
  y = parseFloat(y);
  // crea un objecto de punto
  var thePoint = new esri.geometry.Point(x, y, new esri.SpatialReference({wkid:MinSeg.arcgis.spatialReferenceId})); //console.log(thePoint);
  map.centerAt(thePoint);
  var ext = new esri.geometry.Extent( x - 300, y - 300, x + 300, y + 300, new esri.SpatialReference({wkid:MinSeg.arcgis.spatialReferenceId}) ); //console.log( ext );
  map.setExtent( ext );
}


/**
 * Actualiza el marcador en el mapa y hace zoom de acuerdo a los campos de coords
 * @param  string context Selector con el elemento del panel de localización
 * @return void
 */
function updateMarker( context ) {
  context = typeof container != 'undefined' ? $(container) : $('.location-panel');
  // toma los valores
  var coordX = parseFloat( $('.location-panel-coordx', context).val() );
  var coordY = parseFloat( $('.location-panel-coordy', context).val() );
  // actualiza el display de coordenadas
  setCoordFields( coordX, coordY );
  // agrega el marcador y hace zoom
  addCaseMarker( coordX, coordY, false, true );
  var thePoint = new esri.geometry.Point(coordX, coordY, new esri.SpatialReference({wkid:MinSegApp.jsVars.Arcgis.spatialReferenceId})); //console.log(thePoint);
  map.centerAt(thePoint);
  var ext = new esri.geometry.Extent( coordX - 300, coordY - 300, coordX + 300, coordY + 300, new esri.SpatialReference({wkid:MinSegApp.jsVars.Arcgis.spatialReferenceId}) ); //console.log( ext );
  map.setExtent( ext );
}


/**
 * Setea la dirección devuelta en los campos del formulario
 * @param object candidate Dirección candidata devuelta por el locator
 */
function setAddress(candidate) {
  if ( candidate !== null && candidate !== undefined  ) {
    $('#cameras2department_id').val(candidate.address.State);
    address = splitAddress(candidate.address.Street);
    $('#cameras2street_name').val(address.street);
    $('#cameras2street_number').val(address.number);
  } else {
    return false;
  }
}



function searchByNeighborhood( context ) {
  var nameElem = $('.location-panel-neighborhood', context);
  var departmentElem = $('.location-panel-department', context);

  // si están los datos necesarios ejecuta el query
  if ( nameElem.val() !== '' && departmentElem.val() !== '' ) {
      var qTask, q, extent;

    blockUIElement('.blockable-on-search', 'Buscando barrio...');

    // crea la tarea para el query y un query
    qTask = new esri.tasks.QueryTask( MinSeg.arcgis.services + MinSeg.arcgis.layers.neighborhoods + '/0' + MinSeg.arcgis.accessString );
    q = new esri.tasks.Query();
    q.where = "BARRIO = '" + nameElem.val() + "'";
    q.where += " AND DPTO_CAT = '" + departmentElem.val() + "'";
    q.returnGeometry = true;
    q.outFields = ['*'];

    // ejecuta la consulta
    qTask.execute(q, function(results){
      if (results.features.length > 0) {
        extent = getFeaturesExtent(results.features);
        map.setExtent(extent);

        $('#searchNeighborhoodDialog').dialog('close');
      } else {
        // desbloquea la UI
        unblockUIElement('.blockable-on-search');
        alert( 'No se pudo encontrar el barrio indicado. Inténtelo nuevamente.');
      }
      // desbloquea la UI
      unblockUIElement('.blockable-on-search');
    });
  }

}



/* Inicialización
----------------------------------------------------------------------------- */
dojo.require("esri.map");
dojo.require("esri.tasks.locator");
dojo.require("dijit.Dialog");
dojo.require("dijit.form.TextBox");
dojo.require("dijit.form.Button");
dojo.require("dijit.form.ToggleButton");
dojo.require("dijit.Toolbar");
dojo.require("dijit.layout.BorderContainer");
dojo.require("dijit.layout.ContentPane");
dojo.require("esri.toolbars.navigation");
dojo.require("esri.dijit.Measurement");
dojo.require("esri.tasks.query");

var map, calles, locator, newExt, navToolbar, measurement, midiendo = false, visible = [];

dojo.addOnLoad(init);