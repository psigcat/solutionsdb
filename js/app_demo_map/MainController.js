(function() {
'use strict';

/**
 * Main Controller
 */
angular.module('app').controller('mainController', Controller);

Controller.$inject = [
    'mapService', 
    '$timeout', 
    '$rootScope'
];

	function Controller(mapService, $timeout, $rootScope) {
		var vm 					= this;
	
	
		// map initialisation
		mapService.init();
		
	}

})();