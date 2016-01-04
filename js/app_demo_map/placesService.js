(function() {
'use strict';

	/**
	 * Search Service
	 */
	 
	angular.module('app').factory('placesService', ['$http', function ($http) {
		var baseHref;
	
	
		var dataFactory = {};
		
		dataFactory.init	= function(_baseHref){
			console.log("placesServices init("+_baseHref+")");
			baseHref		= _baseHref;
		}
		
		dataFactory.listProvinces	= function(){
			var vars2send 			= {};
			vars2send.what			= "LIST_PROVINCES";
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		
		dataFactory.listTowns	= function(id){
			var vars2send 			= {};
			vars2send.id			= id;
			vars2send.what			= "LIST_TOWNS";
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		
		return dataFactory;
		
		
	}])

})();
