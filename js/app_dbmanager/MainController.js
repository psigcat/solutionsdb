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
		$scope.form_edit			= false;
		$scope.display_info			= true;
		
		
		var baseHref;
		$scope.initApp	= function(_baseHref,urlWMS,_environment,_token){
		
			baseHref		= _baseHref;
			//logger service init
			loggerService.init(_environment);
			loggerService.log("app_dbmanager -> MainController.js","init("+_baseHref+","+urlWMS+","+_environment+","+_token+")");
			//responsive initialization
			responsiveService.init();
			// map initialisation
			mapService.init(urlWMS);
			// search initialisation
			placesService.init(baseHref);
			//fill provinces on page load
			placesService.listProvinces().success(function(data) {
				loggerService.log("app_dbmanager -> MainController.js init()","listProvinces success",data);
				if(data.total>0){
					$scope.search					= true;	
					$scope.provinceList 			= data.message;
					console.log(data.message[0])
				}
			})
			.error(function (error) {
			   loggerService.log("app_dbmanager -> MainController.js init()","error in listProvinces");
		    });	
		}
		
		
		//map resized event for responsive features
		$scope.$on('mapResized', function(event, data) {
			mapService.resize();
	    });
	    
	      //search click, launchs request for filling provinces select options
		$scope.edit_formClick	= function(){
			loggerService.log("app_dbmanager -> MainController.js","edit_formClick");	
			$scope.form_edit			= true;	
			$scope.display_info			= false;
		}
		
		$scope.cancel_editForm	=  function(){
			loggerService.log("app_dbmanager -> MainController.js","cancel_editForm");	
			$scope.form_edit			= false;	
			$scope.display_info			= true;
		}


	    //search click, launchs request for filling provinces select options
		$scope.searchClick	= function(){
			loggerService.log("app_dbmanager -> MainController.js","searchClick");		
		}
		
		//select province changed, event. launchs request for filling towns select options
		$scope.provinceChanged	= function (province){
			loggerService.log("app_dbmanager -> MainController.js","provinceChanged: "+province);

			placesService.listTowns(province).success(function(data) {
				loggerService.log("app_dbmanager -> MainController.js init()","listTowns success",data);
				if(data.total>0){
					$scope.townList 			= data.message;
				}
			})
			.error(function (error) {
			  loggerService.log("app_dbmanager -> MainController.js","error in listTowns");
		    });	
		}
		
		$scope.townChanged	= function (town){
			loggerService.log("app_dbmanager -> MainController.js","townChanged: "+town);
			$scope.town_ine 	= town;
			//here launch map request
			placesService.getTown(town).success(function(data) {
				loggerService.log("app_dbmanager -> MainController.js","getTown: ",data);
				
				/*if(data.total>0){
					$scope.townList 			= data.message;
				}*/
				//console.log(data.message.bbox)
				//console.log(data.message.poly)
				
				mapService.zoomToTown(JSON.parse(data.message.bbox),JSON.parse(data.message.coords));
			})
			.error(function (error) {
			  loggerService.log("app_dbmanager -> MainController.js","error in getTown");
		    });		
		}	
		
		$scope.$on('featureInfoReceived', function(event, data) {
			loggerService.log("app_dbmanager -> MainController.js","featureInfoReceived",data);
			//console.log(data)
			$scope.town_ine				= data.cmun_inem;
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