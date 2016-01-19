(function() {
'use strict';

	/**
	 * Logger Service
	 */
	 
	angular.module('app').factory('loggerService', ['$http', function ($http) {
		
		var env;
		
		function init(_env){
			if(_env!="prod"){
				env 	= true;
			}
			log("loggerService","init("+_env+")");
		}
		
		function log(emitter, msg,json){
			if(env){
				if(json){
					console.log(emitter,"->",msg,json);
				}else{
					console.log(emitter,"->",msg);
				}
				
			}
		}
	
		function warn(emitter, msg){
			if(env){
				console.warn(emitter,"->",msg);
			}
		}
		
		function error(emitter, msg){
			if(env){
				console.error(emitter,"->",msg);
			}
		}
	
		var dataFactory = {
			init		: init,
			log			: log,
			warn		: warn,
			error		: error	
		};

	
		return dataFactory;
		
		
	}])

})();
