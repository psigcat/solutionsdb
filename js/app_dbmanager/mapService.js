(function() {
'use strict';

/**
 * Map Service
 */
angular.module('app').factory('mapService', map_service);

var map					= null;		//map
var backgroundMap		= null;		//backgroundMap 1- CartoDB light, 2- CartoDB dark
var backgroundMapUrl	= 'http://{1-4}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png';
var customLayer			= null;		//wms layer
var highLightLayer		= null;		//layer for highlighted town
var highLightSource		= null;		//source for highlifgted polygon
var viewProjection 		= null;
var viewResolution 		= null;
var raster				= null;		//background raster
var filename 			= "mapService.js";
var lastMouseMove		= new Date().getTime()+5000;
var currentLayer		= null;		//current WMS layer
var urlWMS				= null;		//WMS service url
map_service.$inject 	= [ 
    '$http',
    '$rootScope'
];

function map_service($http,$rootScope){
	if (!ol) return {};

	function resize(){
		log("resize()");
		if(map){
			map.updateSize();
		}
	}
	

	function init(_urlWMS,_backgroundMap,_layer){
		log("init("+_urlWMS+","+backgroundMap+","+_layer+")");
		//****************************************************************
    	//***********************      LOAD MAP    ***********************
    	//****************************************************************
		backgroundMap		= _backgroundMap;
		urlWMS				= _urlWMS;
		var projection 		= ol.proj.get('EPSG:4326');
		var extent    		= [-1.757,40.306,3.335,42.829];

	
		//background raster
		raster 					= new ol.layer.Tile({ });
		setBackground(backgroundMap);
		//view
		var view = new ol.View({
								projection: projection,
		
		  						//extent: extent,
		  						center: [1.753, 41.600],
		  						zoom: 9
		});
        						

		//map
		map 				= new ol.Map({
						        			/*controls: ol.control.defaults().extend([
												new ol.control.ScaleLine({
												units: 'degrees'
											})
										]),*/
				
								target: 'map'
        					});

        map.addLayer(raster);
        map.setView(view);
		viewProjection = view.getProjection();
		viewResolution = view.getResolution();
				
		//WMS Layer
		renderWMS(_layer);  							

        //****************************************************************
    	//***********************    END LOAD MAP    *********************
    	//****************************************************************       
    	
    	//****************************************************************
    	//***********************     CLICK EVENT  ***********************
    	//****************************************************************
    
		map.on('click', function(evt) {
			log("click coordinates: "+evt.coordinate);
			selectTown(evt.coordinate);
		});

    	//****************************************************************
    	//***********************   END CLICK EVENT  *********************
    	//****************************************************************
		
		//****************************************************************
    	//***********************   MOUSE MOVE EVENT  ********************
    	//****************************************************************
		
		map.on('pointermove', function(evt) {
			
			if (evt.dragging) {
				var returnData	= {
							'show'			: false
				}
				$rootScope.$broadcast('displayToolTip',returnData);
				return;
			}
			if(lastMouseMove+1000<new Date().getTime()){
				lastMouseMove = new Date().getTime();
				displayFeatureInfo(evt.coordinate);
			}else{
				$rootScope.$broadcast('hideToolTip',{});
			}
		});
		//****************************************************************
    	//*******************   END MOUSE MOVE EVENT  ********************
    	//****************************************************************
	}

	function renderWMS(layer){
		log("renderWMS("+layer+")");
		if(currentLayer){
			map.removeLayer(customLayer);
		}
		currentLayer		= layer;
	    //customLayer (WMS service Aqualia)
		customLayer 		= new ol.layer.Tile({
								source: new ol.source.TileWMS({
												url: 		urlWMS,
												tileOptions: {crossOriginKeyword: 'anonymous'},
												crossOrigin: 'anonymous',
												params: {
															'LAYERS'		: currentLayer,
															'tiled'			: true,
															'tilesorigin'	: -1.757+","+40.306
															
        										},
        										serverType: 'geoserver'      										
        								})
    						});
		map.addLayer(customLayer);
	}


	function displayFeatureInfo(coordinates) {
		var url		= customLayer.getSource().getGetFeatureInfoUrl(
							coordinates, viewResolution, viewProjection,
							{'INFO_FORMAT': 'application/json'}
					);
		if (url) {
			//log("url",url);
			var parser = new ol.format.GeoJSON();
			$http.get(url).success(function(response){
				var result = parser.readFeatures(response);
				if(result.length>0){
					var returnData	= {
							'nmun_cc'		: result[0].G.nmun_cc,
							'sub_aqp'		: result[0].G.sub_aqp,
							'show'			: true
					}	
				}else{
					var returnData	= {
							'show'			: false
					}
				}
				//Broadcast event for data rendering
				$rootScope.$broadcast('displayToolTip',returnData);
			});		
		}
	}
		
		
    	
	function selectTown(coordinates){
		log("selectTown()",coordinates);
		if(highLightSource){
		    	highLightSource.clear();
		    }
			var url = customLayer.getSource().getGetFeatureInfoUrl(
											coordinates, viewResolution, viewProjection,
											{'INFO_FORMAT': 'application/json'}
			);

			if (url) {
			   log("url",url);
			    var parser = new ol.format.GeoJSON();
			    $http.get(url).success(function(response){
				   var result = parser.readFeatures(response);
				   if(result.length>0){
					  	console.log(result[0].G)
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
					   var returnData	= result[0].G;
	
					   //Broadcast event for data rendering
					   $rootScope.$broadcast('featureInfoReceived',returnData);
					   //************** END Send data to DOM
				   }
				});
        	}	
	}
	
	function zoomToTown(extend,coords){
		var extent    	= [extend.coordinates[0][0][0],extend.coordinates[0][0][1],extend.coordinates[0][2][0],extend.coordinates[0][2][1]];
		map.getView().fit(extent, map.getSize()); 
		selectTown(coords.coordinates);
	}
	
	function setBackground(id){
		log("setBackground("+id+")");
		id = parseInt(id);
		if(id===1){
			backgroundMapUrl = 'http://{1-4}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png';
		}else if(id===2){
			backgroundMapUrl = 'http://{1-4}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png';
		}
		backgroundMap 	= id;
		var source 		= new ol.source.XYZ({url:backgroundMapUrl});
		raster.setSource(source);
	}

	//log function
	function log(evt,data){
		$rootScope.$broadcast('logEvent',{evt:evt,extradata:data,file:filename});
	}
	
	// public API	
	var returnFactory 	= {
					    		map				: map, // ol.Map
								init			: init,
								zoomToTown		: zoomToTown,
								resize			: resize,
								setBackground	: setBackground,
								renderWMS		: renderWMS
						};
	return returnFactory;
}
})();