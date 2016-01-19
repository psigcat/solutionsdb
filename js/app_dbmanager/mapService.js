(function() {
'use strict';

/**
 * Map Service
 */
angular.module('app').factory('mapService', map_service);

var map				= null;		//map
var customLayer		= null;		//wms layer
var highLightLayer	= null;		//layer for highlighted town
var highLightSource	= null;		//source for highlifgted polygon
var viewProjection 	= null;
var viewResolution 	= null;
map_service.$inject 	= [ 
    '$http',
    '$rootScope'
];

function map_service($http,$rootScope){
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
						
		//background raster
		var raster 			= new ol.layer.Tile({
		        							source: new ol.source.MapQuest({layer: 'osm'})
      								});

	  	/*var raster 			= new ol.layer.Tile({
								source: new ol.source.XYZ({
															url: 'http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png',
															attributions: [
																new ol.Attribution({ 
																	html: ['&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> 								contributors, &copy; <a href="http://cartodb.com/attributions">CartoDB</a>'
																	]
																})
															]
														})
		        				});*/
		        			
        //customLayer (WMS service Aqualia)
   
		customLayer 		= new ol.layer.Tile({
									source: new ol.source.TileWMS({
													url: 		urlWMS,
													tileOptions: {crossOriginKeyword: 'anonymous'},
													//crossOrigin: 'anonymous',
													params: {
																'LAYERS'		: 'manager_grup',
																'tiled'			: true,
																'tilesorigin'	: -1.757+","+40.306
																
            										},
            										serverType: 'geoserver'
            								
            										
            								})
        						})
		
		var view = new ol.View({
								projection: projection,
		
		  						//extent: extent,
		  						center: [1.753, 41.600],
		  						zoom: 9
		});
        						
		//view

		map 				= new ol.Map({
						        			/*controls: ol.control.defaults().extend([
												new ol.control.ScaleLine({
												units: 'degrees'
											})
										]),*/
										 layers: [raster, customLayer],
								target: 'map'
        					});

       // map.addLayer(raster);
        //map.addLayer(customLayer);
        map.setView(view);
		viewProjection = view.getProjection();
		viewResolution = view.getResolution();
        //****************************************************************
    	//***********************    END LOAD MAP    *********************
    	//****************************************************************       
    	
    	//****************************************************************
    	//***********************     CLICK EVENT  ***********************
    	//****************************************************************
    
		map.on('click', function(evt) {
			selectTown(evt.coordinate);
		});

    	//****************************************************************
    	//***********************   END CLICK EVENT  *********************
    	//****************************************************************
	 
	 
	}
	
	
	function selectTown(coordinates){
		console.log("coordinates received from map:",coordinates);
		if(highLightSource){
		    	highLightSource.clear();
		    }
				var url = customLayer.getSource().getGetFeatureInfoUrl(
											coordinates, viewResolution, viewProjection,
											{'INFO_FORMAT': 'application/json'}
				  	);
				  	
			//console.log("evt",evt);
			/*var pixel = evt.pixel;
			console.log(pixel)
			var fl = map.forEachFeatureAtPixel(pixel, function(feature, manager_grup) {
				debugger;
				return feature;
			});
*/

			if (url) {
			   console.log("url",url);
			  // layer.drawFeature(feature, yourStyle);
			    var parser = new ol.format.GeoJSON();
			    $http.get(url).success(function(response){
				  // console.log("response",response);
				   var result = parser.readFeatures(response);
				
				   //************** Highlight town
				   var feature = new ol.Feature(result[0].G.geometry);
				   // Create vector source and the feature to it.
				   highLightSource = new ol.source.Vector();
				   highLightSource.addFeature(feature);
				   // Create vector layer attached to the vector source.
				   highLightLayer = new ol.layer.Vector({source: highLightSource});
				   // Add the vector layer to the map.
				   map.addLayer(highLightLayer);
				   //************** END Highlight town
					
				   //************** Send data to DOM
				  //console.log(result[0].G);
				   var returnData	= {
					   		'id'			: result[0].G.id,
							'cmun_inem'		: result[0].G.cmun_inem,
							'sub_aqp'		: result[0].G.sub_aqp,
							'nmun_cc'		: result[0].G.nmun_cc,
							'cla_data_fi'	: result[0].G.cla_data_fi,
							'cla_data_ini'	: result[0].G.cla_data_ini,
							'cpro_ine'		: result[0].G.cpro_ine,
							'sub_cla'		: result[0].G.sub_cla,
							'ap_data_ini'	: result[0].G.ap_data_ini,
							'ap_data_fi'	: result[0].G.ap_data_fi,
							'sub_cla'		: result[0].G.sub_cla,
							'habitantes'	: result[0].G.habitantes,
							'area_km2'		: result[0].G.area_km2
				   }

				   //Broadcast event for data rendering
				   $rootScope.$broadcast('featureInfoReceived',returnData);
				   //************** END Send data to DOM
				});
        	}	
	}
	
	function zoomToTown(extend,coords){
		//console.log("zoomToTown extend",extend);
		//console.log("zoomToTown coords",coords);
		var extent    	= [extend.coordinates[0][0][0],extend.coordinates[0][0][1],extend.coordinates[0][2][0],extend.coordinates[0][2][1]];
		map.getView().fit(extent, map.getSize()); 
		selectTown(coords.coordinates);
	}
	
	// public API	
	var returnFactory 	= {
					    		map				: map, // ol.Map
								init			: init,
								zoomToTown		: zoomToTown,
								resize			: resize
						};
	return returnFactory;
}
})();