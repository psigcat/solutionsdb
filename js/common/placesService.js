(function() {
'use strict';

	/**
	 * Search Service
	 */
	 
	angular.module('app').factory('placesService', ['$http', function ($http) {
		var baseHref,
			token;
		
		//****************************************************************
    	//***********************   HELPER METHODS   *********************
    	//****************************************************************
    	
		function formatDateForDb(date){
			var d = new Date(date),
		        month = '' + (d.getMonth() + 1),
		        day = '' + d.getDate(),
		        year = d.getFullYear();
		    if (month.length < 2) month = '0' + month;
		    if (day.length < 2) day = '0' + day;
		    return [year, month, day].join('-');		
		}
	
		//****************************************************************
    	//***********************   END HELPER METHODS   *****************
    	//****************************************************************
    	
		var dataFactory = {};
		
		dataFactory.init	= function(_baseHref,_token){
			console.log("placesServices init("+_baseHref+","+_token+")");
			baseHref		= _baseHref;
			token			= _token;
		}
		
		//list all provinces
		dataFactory.listProvinces	= function(){
			var vars2send 			= {};
			vars2send.what			= "LIST_PROVINCES";
			vars2send.token			= token;
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		
		//list town from a given province
		dataFactory.listTowns	= function(id){
			var vars2send 			= {};
			vars2send.id			= id;
			vars2send.what			= "LIST_TOWNS";
			vars2send.token			= token;
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		
		//list towns by name (used in suggested search)
		dataFactory.getTownsFromName	= function(town_name){
			var vars2send 				= {};
			vars2send.town_name			= town_name;
			vars2send.what				= "LIST_TOWNS_FROM_NAME";
			vars2send.token				= token;
			return $http.post(baseHref+'ajax.places.php', vars2send).then(function(response){
				return response.data.message.map(function(item){
					console.log(item)
					return item.name;
				});
    		});
		}
		
		//gets town info by ID
		dataFactory.getTown	= function(id){
			var vars2send 			= {};
			vars2send.id			= id;
			vars2send.what			= "TOWN_INFO";
			vars2send.token			= token;
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		
		
		//gets town info by name
		dataFactory.getTownByName	= function(town_name){
			var vars2send 			= {};
			vars2send.town_name		= town_name;
			vars2send.what			= "TOWN_INFO";
			vars2send.token			= token;
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		
		dataFactory.updateTown	= function(data){
			var vars2send 					= {};
			vars2send.what					= "UPDATE_TOWN";
			vars2send.token					= token;
			vars2send.id_town				= data.id_town;
			vars2send.town_water_provider	= data.town_water_provider;
			vars2send.town_sanity_provider	= data.town_sanity_provider;
			vars2send.town_water_provider	= data.town_water_provider;
			vars2send.town_sanity_provider	= data.town_sanity_provider;
			vars2send.town_observations		= data.town_observations		
			vars2send.town_govern			= data.town_govern;
			if(data.town_w_contract_init!=""){
				vars2send.town_w_contract_init	= formatDateForDb(data.town_w_contract_init);
			}
			if(data.town_w_contract_end!=""){
				vars2send.town_w_contract_end	= formatDateForDb(data.town_w_contract_end);
			}
			if(data.town_s_contract_init!=""){
				vars2send.town_s_contract_init	= formatDateForDb(data.town_s_contract_init);
			}
			if(data.town_s_contract_end!=""){
				vars2send.town_s_contract_end	= formatDateForDb(data.town_s_contract_end);
			}
			console.log("updateTown data",vars2send);
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		
		dataFactory.createReport	= function(province_id){
			var vars2send 			= {};
			vars2send.what			= "CREATE_REPORT";
			vars2send.province_id	= province_id;
			vars2send.token			= token;
			return $http.post(baseHref+'ajax.places.php', vars2send);
		}
		
		return dataFactory;
		
		
	}])

})();
