(function() {
'use strict';

/**
 * Main Controller
 */
angular.module('app').controller('mainController', Controller);

Controller.$inject = [
    'mapService', 
    'loggerService',
    'placesService', 
    '$timeout', 
    '$scope'
];

	function Controller(mapService, loggerService, placesService, $timeout, $scope) {

		//****************************************************************
    	//***********************     APP SETUP      *********************
    	//****************************************************************
		
		var mc 								= this;
		//active Layer
		$scope.activeLayer					= "dbwater_rend";
		$scope.legendUrl					= null;
		$scope.backgroundmap				= 1;
		var baseHref,
			token,
			urlWMS,
			isMobile,
			version							= "1.0.0";
			
		$scope.initApp	= function(_baseHref,_urlWMS,_environment,_token,_isMobile){
		
			baseHref			= _baseHref;
			token				= _token;
			urlWMS				= _urlWMS;
			isMobile			= parseInt(_isMobile);
			//logger service init
			loggerService.init(_environment);
			log("init("+_baseHref+","+urlWMS+","+_environment+","+_token+","+_isMobile+")");
	
			// search initialisation
			placesService.init(baseHref,_token);
			
			// map initialisation
			mapService.init(urlWMS,$scope.backgroundmap,$scope.activeLayer);

			

		}
		
		$scope.searchResultsContainer = window.document.querySelector('.window.search');
		

		//****************************************************************
    	//********************      END APP SETUP      *******************
    	//****************************************************************


	
		

		//****************************************************************
    	//***********************        SEARCH        *******************
    	//****************************************************************
	    
		$scope.getTownsFromName	= function(val) {
			log("getTownsFromName("+val+")");
			return placesService.getTownsFromName(val,"dbWater");
		};
				
		$scope.townSelected	= function ($item, $model, $label){
			log("townChanged: "+$item);
			placesService.getTownByName($item).success(function(data) {
				log("townSelected: ",data);
				mapService.zoomToTown(JSON.parse(data.message.bbox),JSON.parse(data.message.coords));
			})
			.error(function (error) {
			  log("error in townSelected");
		    });		
		}		
		
		//****************************************************************
    	//***********************       END SEARCH     *******************
    	//****************************************************************


	
		


		
	

		//****************************************************************
    	//***********************   HELPER METHODS   *********************
    	//****************************************************************
		

		
		//log event
		$scope.$on('logEvent', function (event, data){
			if(data.extradata){
				log(data.evt,data.extradata);
			}else{
				log(data.file+" "+data.evt);	
			}			
		});
		
		function log(evt,extradata){
			if(extradata){
				loggerService.log("app_dbwater -> MainController.js v."+version,evt,extradata);
			}else{
				loggerService.log("app_dbwater -> MainController.js v."+version,evt);	
			}			
		}	
		//****************************************************************
    	//********************   END HELPER METHODS  *********************
    	//****************************************************************	
	}
})();