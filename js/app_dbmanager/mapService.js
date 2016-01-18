(function() {
'use strict';

/**
 * Map Service
 */
angular.module('app').factory('mapService', map_service);

var map				= null;
var customLayer		= null;
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
			   //console.log("hago el request a: ",url);
			   var parser = new ol.format.GeoJSON();
			   $http.get(url).success(function(response){
				   //console.log(response);
					var result = parser.readFeatures(response);
					//console.log(result[0].G);
					var returnData	= {
							'cpro_ine'		: result[0].G.cpro_ine,
							'sub_aqp'		: result[0].G.sub_aqp,
							'nmun_cc'		: result[0].G.nmun_cc,
							'cla_data_fi'	: result[0].G.cla_data_fi,
							'cla_data_ini'	: result[0].G.cla_data_ini,
							'cpro_ine'		: result[0].G.cpro_ine
					}
					//console.log(returnData);
					//Broadcast event for data rendering
					$rootScope.$broadcast('featureInfoReceived',returnData);
				});
        	}
    	});


    	//****************************************************************
    	//***********************   END CLICK EVENT  *********************
    	//****************************************************************
	 
	 
	}
	
	function zoomToTown(extend, poly){
		console.log("zoomToTown",extend);
		console.log("bbox from database",extend.coordinates);
		var extent    	= [extend.coordinates[0][0][0],extend.coordinates[0][0][1],extend.coordinates[0][2][0],extend.coordinates[0][2][1]];
		/*console.log("town extent",extent);
		console.log("town polygon from database",poly.coordinates);
		var polygon 	= poly.coordinates[0][0];
		console.log(poly.coordinates[0][0].length)*/
	/*	for (var i=0;i<poly.coordinates[0][0].length;i++){
	
			//polygon.push(poly.coordinates[0][0][i][0]);
			//polygon.push(poly.coordinates[0][0][i][1]);
	//lo que sea
}	*/
		
		//var polygon		= [poly.coordinates[0][0][0],poly.coordinates[0][0][0]]
		//console.log("town polygon",polygon);
		/*console.log(geometry.coordinates[0][0])
		console.log(geometry.coordinates[0][0][0])
		console.log(geometry.coordinates[0][1])
		console.log(geometry.coordinates[0][1][0])
		console.log(geometry.coordinates[0][2])
		console.log(geometry.coordinates[0][2][0])
		console.log(geometry.coordinates[0][3])
		console.log(geometry.coordinates[0][3][0])
		console.log(geometry.coordinates[0])*/
		map.getView().fit(extent, map.getSize()); 
		//console.log(customLayer.getSource().getProperties())
		/*var polyFeat = new ol.Feature({
			//geometry: new ol.geom.Polygon(polygon)
			geometry: ol.geom.Polygon(polygon, 'XY')
		});

		var polyStyle = new ol.style.Style({
    fill: new ol.style.Fill({
      color: 'blue'
    }),
    stroke: new ol.style.Stroke({
      color: 'red',
      width: 2
    })
  });

  polyFeat.setStyle(polyStyle);

  var vectorSource = new ol.source.Vector({
    features: [polyFeat]
  });

  var vectorLayer = new ol.layer.Vector({
    source: vectorSource
  });
map.addLayer(vectorLayer);*/

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