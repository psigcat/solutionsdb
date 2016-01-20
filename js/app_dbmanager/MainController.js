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

		//****************************************************************
    	//***********************     APP SETUP      *********************
    	//****************************************************************
		
		var vm 								= this;
		$scope.search						= false;

		$scope.provinceList					= [];
		$scope.townList						= [];
		$scope.selectedTownDisabled			= true;
		$scope.id_town						= "";
		$scope.town_ine						= "";
		$scope.town_province				= "";
		$scope.town_name					= "";
		$scope.town_surface					= "";
		$scope.town_population				= "";
		$scope.town_water_provider			= "";
		$scope.town_w_contract_init			= "";
		$scope.town_w_contract_end			= "";
		$scope.town_sanity_provider			= "";
		$scope.town_s_contract_init			= "";
		$scope.town_s_contract_end			= "";
		$scope.edit_town_water_provider		= "";
		$scope.edit_town_w_contract_init	= "";
		$scope.edit_town_w_contract_end		= "";
		$scope.edit_town_sanity_provider	= "";
		$scope.edit_town_s_contract_init	= "";
		$scope.edit_town_s_contract_end		= "";
		$scope.form_edit					= false;
		$scope.display_info					= true;
		
		
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
			placesService.init(baseHref,_token);
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
		
		//****************************************************************
    	//***********************      END APP SETUP   *******************
    	//****************************************************************

		//****************************************************************
    	//***********************      UI EVENTS       *******************
    	//****************************************************************
	    
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
			$scope.selectedTownDisabled			= true;
			placesService.listTowns(province).success(function(data) {
				loggerService.log("app_dbmanager -> MainController.js init()","listTowns success",data);
				if(data.total>0){
					$scope.townList 			= data.message;
					$scope.selectedTownDisabled	= false;
				}
			})
			.error(function (error) {
			  loggerService.log("app_dbmanager -> MainController.js","error in listTowns");
		    });	
		}
		
		$scope.townChanged	= function (town){
			loggerService.log("app_dbmanager -> MainController.js","townChanged: "+town);
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
		
		//****************************************************************
    	//***********************      UI EVENTS       *******************
    	//****************************************************************
	
		//****************************************************************
    	//******************     TOWN INFO & UPDATE       ****************
    	//****************************************************************	
		
		$scope.$on('featureInfoReceived', function(event, data) {
			loggerService.log("app_dbmanager -> MainController.js","featureInfoReceived",data);
			//console.log(data)
			$scope.id_town						= data.id;
			$scope.town_ine						= data.cmun_inem;
			$scope.town_province				= giveMeProvinceName(data.cpro_ine);
			$scope.town_name					= data.nmun_cc;
			$scope.town_water_provider			= data.sub_aqp;
			$scope.town_w_contract_init			= data.ap_data_ini;
			$scope.town_w_contract_end			= data.ap_data_fi;
			$scope.town_sanity_provider			= data.sub_cla;
			$scope.town_s_contract_end			= data.cla_data_ini;
			$scope.town_s_contract_end			= data.cla_data_fi;
			$scope.town_population				= data.habitantes;
			$scope.town_surface					= data.area_km2;
			$scope.edit_town_water_provider		= data.sub_aqp;
			$scope.edit_town_sanity_provider	= data.sub_cla;
			if(data.ap_data_ini){
				$scope.edit_town_w_contract_init	= new Date(data.ap_data_ini);
				$scope.town_w_contract_init			= formatDate(data.ap_data_ini);
			}else{
				$scope.edit_town_w_contract_init	= "";
				$scope.town_w_contract_init			= "";
			}
			if(data.ap_data_fi){
				$scope.edit_town_w_contract_end		= new Date(data.ap_data_fi);
				$scope.town_w_contract_end			= formatDate(data.ap_data_fi);
			}else{
				$scope.edit_town_w_contract_end		= "";
				$scope.town_w_contract_end			= "";
			}
			if(data.cla_data_ini){
				$scope.edit_town_s_contract_init	= new Date(data.cla_data_ini);
				$scope.town_s_contract_init			= formatDate(data.cla_data_ini);
			}else{
				$scope.edit_town_s_contract_init	= "";
				$scope.town_s_contract_init			= "";
			}
			if(data.cla_data_fi){
				$scope.edit_town_s_contract_end		= new Date(data.cla_data_fi);
				$scope.town_s_contract_end			= formatDate(data.cla_data_fi);	
			}else{
				$scope.edit_town_s_contract_end		= "";	
				$scope.town_s_contract_end			= "";	
			}
			
			//deploy info colapse
			$('.collapseInfo').collapse();
	    });
		
		$scope.updateInfo = function(){
			var vars2send					= {};
			vars2send.id_town				= $scope.id_town;
			vars2send.town_water_provider	= $scope.edit_town_water_provider;
			vars2send.town_w_contract_init	= $scope.edit_town_w_contract_init;
			vars2send.town_w_contract_end	= $scope.edit_town_w_contract_end;
			vars2send.town_sanity_provider	= $scope.edit_town_sanity_provider;
			vars2send.town_s_contract_init	= $scope.edit_town_s_contract_init;
			vars2send.town_s_contract_end	= $scope.edit_town_s_contract_end;
			placesService.updateTown(vars2send).success(function(data) {
				loggerService.log("app_dbmanager -> MainController.js","updateTown success: ",data);	
			})
			.error(function (error) {
			  loggerService.log("app_dbmanager -> MainController.js","error in updateTown");
		    });	
			
		}
		
		//****************************************************************
    	//****************     END TOWN INFO & UPDATE      	**************
    	//****************************************************************	
		
		//****************************************************************
    	//***********************     DATEPICKERS    *********************
    	//****************************************************************

		$scope.dp_w_contract_init_open = function() {
			$scope.dp_w_contract_init.opened = true;
		};
		$scope.dp_w_contract_init = {
			opened: true
		};
		
		$scope.dp_w_contract_end_open = function() {
			$scope.dp_w_contract_end.opened = true;
		};
		
		$scope.dp_w_contract_end = {
			opened: true
		};
		
		$scope.dp_s_contract_init_open = function() {
			$scope.dp_s_contract_init.opened = true;
		};
		
		$scope.dp_s_contract_init = {
			opened: true
		};
		
		$scope.dp_s_contract_end_open = function() {
			$scope.dp_s_contract_end.opened = true;
		};
		$scope.dp_s_contract_end = {
			opened: true
		};
		
		$scope.dateOptions = {
			formatYear: 'yyyy',
			startingDay: 1
		};
		
		$scope.formats 			= ['dd-MM-yyyy'];
		$scope.format 			= 'dd-MM-yyyy';
		$scope.altInputFormats 	= ['M!/d!/yyyy'];
		// Disable weekend selection
		$scope.disabled = function(date, mode) {
			return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
		};


		
		//****************************************************************
    	//***********************    END DATEPICKERS    ******************
    	//****************************************************************

		//****************************************************************
    	//***********************   HELPER METHODS   *********************
    	//****************************************************************
		
		function giveMeProvinceName(cpro_ine){
			var result = $.grep($scope.provinceList, function(e){ return e.id == cpro_ine; });
			return result[0].name;
		}
		
		function formatDate(date) {
			if(date.substr(date.length - 1)==="Z"){
				date = date.substring(0, date.length - 1);
			}
			var strDate	= date.split("-");
			return strDate[2]+"-"+strDate[1]+"-"+strDate[0];
		}
		
		//map resized event for responsive features
		$scope.$on('mapResized', function(event, data) {
			mapService.resize();
	    });
		
		//****************************************************************
    	//********************   END HELPER METHODS  *********************
    	//****************************************************************
		
		
	}
	
	

})();