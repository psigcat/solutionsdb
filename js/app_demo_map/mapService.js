(function() {
'use strict';

/**
 * Map Service
 */
angular.module('app').factory('mapService', service);

var map,
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
							init: 					init
						};
		return ms;
}
  

  


  function init(){
	  var BCNLonLat 		= [2.17,41.38];
	  var BCNWebMercator 	= ol.proj.fromLonLat(BCNLonLat);
	  
	  var projection 		= ol.proj.get('EPSG:25831');
	 
	 
	//  projection.setExtent([257904,4484796,535907,4751795]);
	  var extent 			= [257904,4484796,535907,4751795];
	  
	  
	  var layers = [
	  				new ol.layer.Tile({
	  					source: new ol.source.OSM()
	  				})	  ]
//interactions: ol.interaction.defaults({mouseWheelZoom:false})
	   map = new ol.Map({
	   				layers: layers,
	   				target: 'map',
	   				view: new ol.View({
		   				projection: projection,
		   				center: [396905,4618292],
		   				resolutions: [275,100,50,25,10,5,2,1,0.5,],
		   				extent: extent,
		   				zoom: 0
  					})
		});

	demoLayer			= new ol.layer.Tile({
		  							extent: extent,
		  							source: new ol.source.TileWMS({
			  							url: 'http://80.36.225.111:8080/geoserver/aqualia/wms?service=WMS&version=1.3.0&request=GetMap&layers=aqualia:municipios&styles=&bbox=-9.36966323852539,35.1250267028809,4.39593172073364,43.8355026245117&width=521&height=330&srs=EPSG:4258&format=application/openlayers',
			  							params: {
		  									'LAYERS': 'topo'
                      					}
                    				})
                    			});
                    			map.addLayer(demoLayer); 
	}
	
	






})();