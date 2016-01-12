(function() {
'use strict';

/**
 * Map Service
 */
angular.module('app').factory('mapService', service);

var map				= null,
	demoLayer,
	layer1			= false,
	activatePoint	= false,
	drawType		= "none",
	draw,
	modify,
	features,
	featureOverlay;

function service($http){

  if (!ol) return {};
  
  		features 				= new ol.Collection();
  		featureOverlay 		= new ol.layer.Vector({
	  								source: 	new ol.source.Vector({features: features}),
	  								style: 		new ol.style.Style({
	  													fill: new ol.style.Fill({
	  													color: 'rgba(255, 255, 255, 0.2)'
	    										}),
												stroke: 	new ol.style.Stroke({
																	color: '#ffcc33',
																	width: 2
				    										}),
												image: 		new ol.style.Circle({
															radius: 7,
															fill: new ol.style.Fill({
															color: '#ffcc33'
				      										})
				    									})
	  								})
						});



 
		// public API
  		var ms 				= {
					    	map: map, // ol.Map
							init: 					init,
							resize: 					resize
						};
		return ms;

}
  
  
	function resize(){
		console.log("mapService.js-> resize()");
		if(map){
			map.updateSize();
		}
	}
  

	function init(){
	
		var projection 		= ol.proj.get('EPSG:4258');
		var extent 			= [-1.757,40.306,3.335,42.829];

		var demoLayer 		= new ol.layer.Tile({
									source: new ol.source.TileWMS({
											url: 'http://80.36.225.111:8181/geoserver/aqualia/wms',
											params: {
												'LAYERS': 'manager_grup'
            								}
          							})
        						})
							

		map 				= new ol.Map({
						        controls: ol.control.defaults().extend([
									new ol.control.ScaleLine({
										units: 'degrees'
          							})
		  						]),
		  						//layers: layers,
		  						target: 'map',
		  						view: new ol.View({
		  							projection: projection,
		  							//extent: extent,
		  							center: [1.753, 41.600],
		  							zoom: 3
        						})
        					});
        map.addLayer(demoLayer); 
	}

})();