(function() {
'use strict';

/**
 * Main Controller
 */
angular.module('app').controller('mainController', Controller);

Controller.$inject = [
    'mapService', 
    'placesService', 
    '$timeout', 
    '$scope'
];

	function Controller(mapService, placesService, $timeout, $scope) {
		var vm 						= this;
		$scope.search				= false;
		
		$scope.provinceList			= [];
		$scope.townList				= [];
		var baseHref;
		$scope.initApp	= function(_baseHref){
			console.log("initApp('"+_baseHref+"')");
			baseHref		= _baseHref;
			// map initialisation
			mapService.init();
			// search initialisation
			placesService.init(baseHref);
		}
		
		$scope.searchClick	= function(){
			console.log("searchClick()");
			placesService.listProvinces().success(function(data) {
				console.log(data);
				if(data.total>0){
					$scope.search					= true;	
					$scope.provinceList 			= data.message;
					console.log(data.message[0])
				}
			})
			.error(function (error) {
			   console.log("error in listProvinces");
		    });		
		}
		
		$scope.provinceChanged	= function (province){
			console.log("provinceChanged",province);
			placesService.listTowns(province).success(function(data) {
				console.log(data);
				if(data.total>0){
					$scope.townList 			= data.message;
				}
			})
			.error(function (error) {
			   console.log("error in listProvinces");
		    });	
		}
		
		$scope.townChanged	= function (town){
			console.log("townChanged",town);
		}
		
	}

})();