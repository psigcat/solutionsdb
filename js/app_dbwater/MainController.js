(function() {
'use strict';

/**
 * Main Controller
 */
angular.module('app').controller('mainController', Controller);

Controller.$inject = [
    'mapService', 
    'loggerService',
    '$timeout', 
    '$scope'
];

	function Controller(mapService, loggerService, $timeout, $scope) {

		//****************************************************************
    	//***********************     APP SETUP      *********************
    	//****************************************************************
		
		var mc 								= this;
		//active Layer
		$scope.activeLayer					= "manager_grup";
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
	

			
			// map initialisation
			mapService.init(urlWMS,$scope.backgroundmap,$scope.activeLayer);

			

		}
		
		

		//****************************************************************
    	//********************      END APP SETUP      *******************
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