(function() {
'use strict';

	/**
	 * Search Service
	 */
	 
	angular.module('app').factory('alertsService', ['$http', function ($http) {
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
			console.log("alertsService init("+_baseHref+","+_token+")");
			baseHref		= _baseHref;
			token			= _token;
		}
		
		//list all provinces
		dataFactory.listAlerts	= function(period,type){
			var vars2send 			= {};
			vars2send.what			= "LIST_ALERTS";
			vars2send.period		= period;
			vars2send.type			= type;
			vars2send.token			= token;
			return $http.post(baseHref+'ajax.alerts.php', vars2send);
		}
		
				
		return dataFactory;
		
		
	}])

})();
