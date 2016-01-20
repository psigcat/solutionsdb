(function() {
'use strict';

	/**
	 * Search Service
	 */
	 
	angular.module('app').factory('placesService', ['$http', function ($http) {
		var baseHref,
			token;
	
	
		var dataFactory = {};
		
		dataFactory.init	= function(_baseHref,_token){
			console.log("placesServices init("+_baseHref+","+_token+")");
			baseHref		= _baseHref;
			token			= _token;
		}
		
		dataFactory.listProvinces	= function(){
			var vars2send 			= {};
			vars2send.what			= "LIST_PROVINCES";
			vars2send.token			= token;
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		
		dataFactory.listTowns	= function(id){
			var vars2send 			= {};
			vars2send.id			= id;
			vars2send.what			= "LIST_TOWNS";
			vars2send.token			= token;
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		dataFactory.getTown	= function(id){
			var vars2send 			= {};
			vars2send.id			= id;
			vars2send.what			= "TOWN_INFO";
			vars2send.token			= token;
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		dataFactory.updateTown	= function(vars2send){
			vars2send.what			= "UPDATE_TOWN";
			vars2send.token			= token;
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		return dataFactory;
		
		
	}])

})();
