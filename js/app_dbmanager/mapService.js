(function() {
'use strict';

/**
 * Map Service
 */
angular.module('app').factory('mapService', service);

var map				= null;
function service($http){
	if (!ol) return {};

	// public API
	var returnFactory 	= {
					    		map				: map, // ol.Map
								init			: init,
								resize			: resize
						};
	return returnFactory;
}
  
  
	function resize(){
		console.log("mapService.js-> resize()");
		if(map){
			map.updateSize();
		}
	}
  

	function init(){

		// select interaction working on "click"
		var selectClick = new ol.interaction.Select({
			condition: ol.events.condition.click
		});
	
		selectClick.on('select', function(e) {
			console.log("mapService.js-> click on map");
			console.log(e);
    	});
	
	
	
	
		var projection 		= ol.proj.get('EPSG:4258');
		var extent 			= [-1.757,40.306,3.335,42.829];
		
		//bakcground raster
		var raster 			= new ol.layer.Tile({
		        				source: new ol.source.MapQuest({layer: 'sat'})
      	});
      	//customLayer
		var customLayer 		= new ol.layer.Tile({
									source: new ol.source.TileWMS({
											url: 'http://80.36.225.111:8181/geoserver/aqualia/wms',
											params: {
												'LAYERS': 'manager_grup'
            								}
          							})
        						})
			
		//map
		map 				= new ol.Map({
						        controls: ol.control.defaults().extend([
									new ol.control.ScaleLine({
										units: 'degrees'
          							})
		  						]),
		  						target: 'map'
        					});
        					
		//view
		var view = new ol.View({
								projection: projection,
		  						//extent: extent,
		  						center: [1.753, 41.600],
		  						zoom: 3
		});
        map.addLayer(raster);
        map.addLayer(customLayer);
        map.setView(view);
		map.addInteraction(selectClick);
	 
	}

})();