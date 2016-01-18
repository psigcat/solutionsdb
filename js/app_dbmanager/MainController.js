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
    'responsiveService',
    '$timeout', 
    '$scope'
];

	function Controller(mapService, loggerService,placesService, responsiveService,$timeout, $scope) {
		var vm 						= this;
		$scope.search				= false;

		$scope.provinceList			= [];
		$scope.townList				= [];
		$scope.town_ine				= "";
		$scope.town_province		= "";
		$scope.town_name			= "";
		$scope.water_provider		= "";
		$scope.contract_init		= "";
		$scope.contract_end			= "";
		
		
		var baseHref;
		$scope.initApp	= function(_baseHref,urlWMS,_environment,_token){
		
			baseHref		= _baseHref;
			//logger service init
			loggerService.init(_environment);
			loggerService.log("app_dbmanager -> MainController.js","init("+_baseHref+","+urlWMS+","+_token+","+_environment+")");
				//console.log("app_dbmanager-> Maincontroller.js","initApp('"+_baseHref+"','"+urlWMS+"'+,'"+_environment+"')");
			//responsive initialization
			responsiveService.init();
			// map initialisation
			mapService.init(urlWMS);
			// search initialisation
			placesService.init(baseHref);
			//fill provinces on page load
			placesService.listProvinces().success(function(data) {
				console.log("app_dbmanager-> Maincontroller.js",data);
				if(data.total>0){
					$scope.search					= true;	
					$scope.provinceList 			= data.message;
					console.log(data.message[0])
				}
			})
			.error(function (error) {
			   console.log("app_dbmanager-> Maincontroller.js","error in listProvinces");
		    });	
		}
		
		
		//map resized event for responsive features
		$scope.$on('mapResized', function(event, data) {
			mapService.resize();
	    });
	    
	    //search click, launchs request for filling provinces select options
		$scope.searchClick	= function(){
			console.log("app_dbmanager-> Maincontroller.js","searchClick()");
				
		}
		
		//select province changed, event. launchs request for filling towns select options
		$scope.provinceChanged	= function (province){
			console.log("app_dbmanager-> Maincontroller.js","provinceChanged",province);
			placesService.listTowns(province).success(function(data) {
				console.log("app_dbmanager-> Maincontroller.js",data);
				if(data.total>0){
					$scope.townList 			= data.message;
				}
			})
			.error(function (error) {
			   console.log("app_dbmanager-> Maincontroller.js","error in listProvinces");
		    });	
		}
		
		$scope.townChanged	= function (town){
			console.log("app_dbmanager-> Maincontroller.js","townChanged",town);
			$scope.town_ine 	= town;
			//here launch map request
			placesService.getTown(town).success(function(data) {
				console.log("app_dbmanager-> Maincontroller.js",data);
				/*if(data.total>0){
					$scope.townList 			= data.message;
				}*/
				console.log(data.message.bbox)
				//console.log(data.message.poly)
				mapService.zoomToTown(JSON.parse(data.message.bbox),JSON.parse(data.message.poly));
			})
			.error(function (error) {
			   console.log("app_dbmanager-> Maincontroller.js","error in listProvinces");
		    });		
		}	
		
		$scope.$on('featureInfoReceived', function(event, data) {
			loggerService.log("app_dbmanager -> MainController.js","featureInfoReceived");
			//console.log(data)
			$scope.town_ine				= data.cpro_ine;
			$scope.town_province		= data.cpro_ine;
			$scope.town_name			= data.nmun_cc;
			$scope.water_provider		= data.sub_aqp;
			$scope.contract_init		= data.cla_data_ini;
			$scope.contract_end			= data.cla_data_fi;
			//deploy info colapse
			$('.collapseInfo').collapse();
	    });

	}

})();