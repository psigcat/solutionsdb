(function() {
'use strict';

/**
 * Main Controller
 */
angular.module('app').controller('mainController', Controller);

Controller.$inject = [
    'mapService', 
    'placesService', 
    'responsiveService',
    '$timeout', 
    '$scope'
];

	function Controller(mapService, placesService, responsiveService,$timeout, $scope) {
		var vm 						= this;
		$scope.search				= false;

		$scope.provinceList			= [];
		$scope.townList				= [];
		$scope.town_ine				= "";
		var baseHref;
		$scope.initApp	= function(_baseHref){
			console.log("app_dbmanager-> Maincontroller.js","initApp('"+_baseHref+"')");
			baseHref		= _baseHref;
			//responsive initialization
			responsiveService.init();
			// map initialisation
			mapService.init();
			// search initialisation
			placesService.init(baseHref);
		}
		
		
		//map resized event for responsive features
		$scope.$on('mapResized', function(event, data) {
			mapService.resize();
	    });
	    
	    //search click, launchs request for filling provinces select options
		$scope.searchClick	= function(){
			console.log("app_dbmanager-> Maincontroller.js","searchClick()");
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
		}	
	}

})();