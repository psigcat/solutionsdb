(function() {
'use strict';

/**
 * Map Service
 */
angular.module('app').factory('mapService', service);

var map				= null;
service.$inject 	= [ 
    '$http'
];

function service($http){
	if (!ol) return {};

	function resize(){
		console.log("mapService.js-> resize()");
		if(map){
			map.updateSize();
		}
	}
	

	function init(urlWMS){

		//****************************************************************
    	//***********************      LOAD MAP    ***********************
    	//****************************************************************
	
		var projection 		= ol.proj.get('EPSG:4326');
		var extent    		= [-1.757,40.306,3.335,42.829];

		
		//map
		map 				= new ol.Map({
						        			controls: ol.control.defaults().extend([
												new ol.control.ScaleLine({
												units: 'degrees'
											})
										]),
								target: 'map'
        					});
				
		//background raster
				var raster 			= new ol.layer.Tile({
		        				source: new ol.source.MapQuest({layer: 'osm'})
      	});

/*		var raster 			= new ol.layer.Tile({
								source: new ol.source.XYZ(d{
															url: 'http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',
															attributions: [
																new ol.Attribution({ 
																	html: ['&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> 								contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>'
																	]
																})
															]
														})
		        				});
		        			*/
        //customLayer (WMS service Aqualia)
		var customLayer 		= new ol.layer.Tile({
									source: new ol.source.TileWMS({
													url: 		urlWMS,
													params: {
																'LAYERS': 'manager_grup'
            										}
            								})
        						})
		
		//view
		var view = new ol.View({
								projection: projection,
		
		  						//extent: extent,
		  						center: [1.753, 41.600],
		  						zoom: 9
		});
		
        map.addLayer(raster);
        map.addLayer(customLayer);
        map.setView(view);
        
        //****************************************************************
    	//***********************    END LOAD MAP    *********************
    	//****************************************************************       
        
		/*
		//map.addInteraction(selectClick);
		// select interaction working on "click"
		var selectClick = new ol.interaction.Select({
			condition: ol.events.condition.click
		});
	
		selectClick.on('select', function(e) {
			console.log("mapService.js-> click on map");
			console.log(e);
    	});*/
    	
    	//****************************************************************
    	//***********************     CLICK EVENT  ***********************
    	//****************************************************************
    	
    	var viewProjection = view.getProjection();
		var viewResolution = view.getResolution();
		map.on('click', function(evt) {
			var url = customLayer.getSource().getGetFeatureInfoUrl(
                  			evt.coordinate, viewResolution, viewProjection,
				  			{'INFO_FORMAT': 'application/json'}
				  	);
     
			if (url) {
			   console.log("hago el request a: ",url);
			   //var parser = new ol.format.GeoJSON();

			   $.ajax({
			   	url: url,
			   	dataType: 'jsonp',
			   	jsonpCallback: 'parseResponse'
        		}).then(function(response) {
	        			console.log(response);
						var result = parser.readFeatures(response);
						console.log(result);
          
        		});
        	}
			 /*
		
			   
			   
			  // var parser = new ol.format.GeoJSON();
		/*	   $http.jsonp(url+"&format_options=callback:processJSON").success(function(data) {
				   console.log(data);
				})
				.error(function (error) {
					console.log(error);
		    	});		
		   }
		   
		   function processJSON(data) {
			   console.log("processJSON",data)
		   }*/
    	});
    	
    	//****************************************************************
    	//***********************   END CLICK EVENT  *********************
    	//****************************************************************
	 
	 
	}
	
	
	// public API	
	var returnFactory 	= {
					    		map				: map, // ol.Map
								init			: init,
								resize			: resize
						};
	return returnFactory;
}
})();