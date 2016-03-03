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
	'alertsService',
    'responsiveService',
    '$timeout', 
    '$scope'
];

	function Controller(mapService, loggerService,placesService,alertsService, responsiveService,$timeout, $scope) {

		//****************************************************************
    	//***********************     APP SETUP      *********************
    	//****************************************************************
		
		var vm 								= this;
		$scope.search						= false;

		$scope.provinceList					= [];
		$scope.townList						= [];
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
		$scope.town_observations			= "";
		$scope.town_govern					= "";
		$scope.edit_town_govern				= "";
		$scope.edit_town_observations		= "";
		$scope.edit_town_water_provider		= "";
		$scope.edit_town_w_contract_init	= "";
		$scope.edit_town_w_contract_end		= "";
		$scope.edit_town_sanity_provider	= "";
		$scope.edit_town_s_contract_init	= "";
		$scope.edit_town_s_contract_end		= "";
		$scope.prox_prorroga				= "";
		$scope.prox_concurso				= "";
		$scope.fut_prorroga					= "";
		$scope.cartera						= "";
		$scope.neg_2016						= "";
		$scope.neg_2017						= "";
		$scope.neg_2018						= "";
		$scope.inv_2016						= "";
		$scope.inv_2017						= "";
		$scope.inv_2018						= "";
		$scope.neg_resto					= "";
		$scope.inv_resto					= "";
		$scope.inv_total					= "";
		$scope.cmun_ine						= "";
		$scope.cpro_ine						= "";
		$scope.formNoteDisplay				= false; 	//form add note display status in more info modal 
		$scope.btAddNoteDisplay				= true;		//button display form add node
		
		$scope.notes						= Array();
		$scope.form_edit					= false;
		$scope.display_info					= true;
		$scope.toolTip						= {};
		$scope.createReportButton 			= false;
		$scope.reportDownload				= false;
		$scope.canUpdate					= false;
		$scope.backgroundmap				= 1; //default backgroundmap (1=light, 2 dark)
		
		
		//alerts
		$scope.alertCount					= 0;
		$scope.period_alarm_drink_water		= "6";
		$scope.alerts 						= Array();

		//active Layer
		$scope.activeLayer					= "manager_grup";
		$scope.legendUrl					= null;
		var baseHref,
			token,
			urlWMS,
			canUpdate,
			mouseX,
			mouseY,
			toolTipInstant,
			isMobile,
			provinceForReport;
			
		$scope.initApp	= function(_baseHref,_urlWMS,_environment,_token,_canUpdate,_isMobile){
		
			baseHref			= _baseHref;
			token				= _token;
			urlWMS				= _urlWMS;
			isMobile			= parseInt(_isMobile);
			canUpdate			= parseInt(_canUpdate);
			canUpdate			
			if(canUpdate===1){
				$scope.canUpdate	= false;
			}else{
				$scope.canUpdate	= true;
			}

			//logger service init
			loggerService.init(_environment);
			loggerService.log("app_dbmanager -> MainController.js","init("+_baseHref+","+urlWMS+","+_environment+","+_token+","+_canUpdate+","+_isMobile+")");
			//responsive initialization
			responsiveService.init();

			
			// map initialisation
			mapService.init(urlWMS,$scope.backgroundmap,$scope.activeLayer);
			loadLegend();
			// search initialisation
			placesService.init(baseHref,_token);
			//fill provinces on page load
			placesService.listProvinces().success(function(data) {
				loggerService.log("app_dbmanager -> MainController.js init()","listProvinces success",data);
				if(data.total>0){
					$scope.search					= true;	
					$scope.provinceList 			= data.message;
				}
			})
			.error(function (error) {
			   loggerService.log("app_dbmanager -> MainController.js init()","error in listProvinces");
		    });	

			// alert initialisation
			alertsService.init(baseHref,_token);
			loadAlerts();

		    $('#info').hide();
		}
		
		//****************************************************************
    	//********************      END APP SETUP      *******************
    	//****************************************************************

		//****************************************************************
    	//***********************        SEARCH        *******************
    	//****************************************************************
	    
		$scope.getTownsFromName	= function(val) {
			loggerService.log("app_dbmanager -> MainController.js","getTownsFromName("+val+")");
			return placesService.getTownsFromName(val);
		};
				
		$scope.townSelected	= function ($item, $model, $label){
			loggerService.log("app_dbmanager -> MainController.js","townChanged: "+$item);
			placesService.getTownByName($item).success(function(data) {
				loggerService.log("app_dbmanager -> MainController.js","townSelected: ",data);
				mapService.zoomToTown(JSON.parse(data.message.bbox),JSON.parse(data.message.coords));
			})
			.error(function (error) {
			  loggerService.log("app_dbmanager -> MainController.js","error in townSelected");
		    });		
		}		
		
		//****************************************************************
    	//***********************       END SEARCH     *******************
    	//****************************************************************
    	
		//****************************************************************
    	//***********************        REPORT        *******************
    	//****************************************************************
			
		$scope.createReport		= function(){
			loggerService.log("app_dbmanager -> MainController.js","createReport");
			console.log($scope.selectedProvinceForReport)
			/*$scope.createReportButton 	= false;
			placesService.createReport(provinceForReport).success(function(data) {
				loggerService.log("app_dbmanager -> MainController.js","createReport: ",data);
				
				if(data.status==="Accepted"){
					$scope.reportDownload	= true;
					$scope.fileToDownload	= data.message;
				}
				
	
			})
			.error(function (error) {
			  loggerService.log("app_dbmanager -> MainController.js","error in createReport");
		    });	*/		
		}
		
		$scope.previewReport	= function(){
			loggerService.log("app_dbmanager -> MainController.js","previewReport");
			var vars2send					= {};
			vars2send.nmun_cc				= $scope.townForReport;
			vars2send.cpro_dgc				= $scope.selectedProvinceForReport;
			vars2send.area_km2				= $scope.area_km2;
			vars2send.habitantes			= $scope.habitantes;
			vars2send.sub_aqp				= $scope.sub_aqp;
			vars2send.ap_data_ini			= $scope.ap_data_ini;
			vars2send.ap_data_fi			= $scope.ap_data_fi;
			vars2send.sub_cla				= $scope.sub_cla;
			vars2send.cla_data_ini			= $scope.cla_data_ini;
			vars2send.cla_data_fi			= $scope.cla_data_fi;
			vars2send.prox_concurso			= $scope.prox_concurso;
			vars2send.fut_prorroga			= $scope.fut_prorroga;
			vars2send.cartera				= $scope.cartera;
			vars2send.neg_2016				= $scope.neg_2016;
			vars2send.neg_2017				= $scope.neg_2017;
			vars2send.neg_2018				= $scope.neg_2018;
			vars2send.neg_resto				= $scope.neg_resto;
			vars2send.inv_2016				= $scope.inv_2016;
			vars2send.inv_2017				= $scope.inv_2017;
			vars2send.inv_2018				= $scope.inv_2018;
			vars2send.inv_resto				= $scope.inv_resto;
			vars2send.inv_total				= $scope.inv_total;
			placesService.previewReport(vars2send).success(function(data) {
				loggerService.log("app_dbmanager -> MainController.js","previewReport: ",data);
				
				if(data.status==="Accepted"){
					
				}
				
	
			})
			.error(function (error) {
			  loggerService.log("app_dbmanager -> MainController.js","error in previewReport");
		    });	
			
			
		}
		
		$scope.townSelectedForReport	= function ($item, $model, $label){
			loggerService.log("app_dbmanager -> MainController.js","townSelectedForReport: "+$item);
			$scope.townForReport		= $item;
		}		
		
		//****************************************************************
    	//***********************     END REPORT        ******************
    	//****************************************************************
    	
    	//****************************************************************
    	//***********************     CONFIGURATION    *******************
    	//****************************************************************
    	
		$scope.changeBackgroundMap	= function(){
			loggerService.log("app_dbmanager -> MainController.js","changeBackgroundMap: "+$scope.backgroundmap);
			mapService.setBackground($scope.backgroundmap);
		}

		$scope.changeActiveLayer	= function(){
			loggerService.log("app_dbmanager -> MainController.js","changeActiveLayer: "+$scope.activeLayer);
			mapService.renderWMS($scope.activeLayer);
			loadLegend();
		}

    	//****************************************************************
    	//***********************  END CONFIGURATION    ******************
    	//****************************************************************
    	
		//****************************************************************
    	//***********************        ALERTS        *******************
    	//****************************************************************
    	
		function loadAlerts(){
			$scope.alertCount	= 0;
			$scope.alerts 		= Array();
			//fill alerts
			alertsService.listAlerts($scope.period_alarm_drink_water	).success(function(data) {
				loggerService.log("app_dbmanager -> MainController.js init()","listAlerts success",data);
				if(data.status==="Accepted"){
					$scope.alertCount 	= data.total;
					$scope.alerts 		= data.message;
				}
			})
			.error(function (error) {
			   loggerService.log("app_dbmanager -> MainController.js init()","error in listAlerts");
		    });	

		}

		$scope.peridoAlertDrinkWaterChanged	= function(){
			loggerService.log("app_dbmanager -> MainController.js peridoAlertDrinkWaterChanged() "+$scope.period_alarm_drink_water);
			loadAlerts();
		}

		//****************************************************************
    	//***********************     END ALERTS       *******************
    	//****************************************************************
    	
		//****************************************************************
    	//***********************        MODALS        *******************
    	//****************************************************************
	
		$('.mobile-trigger').on('click', function(e){
			e.preventDefault();			
			var source = $(this).attr('source');			
			var target = $(this).attr('target');
		
			$(source).clone(true).appendTo(target);			
		});
	
		$scope.closeModal		= function(){
			if(isMobile===0){
				responsiveService.expandMenu();
			}
		}
		
		$scope.collapseMenu		= function(){
			responsiveService.collapseMenu();
		}
		
		//****************************************************************
    	//******************     TOWN INFO & UPDATE       ****************
    	//****************************************************************	

		$scope.cleanMoreInfo	= function(){
			loggerService.log("app_dbmanager -> MainController.js","cleanMoreInfo");
			if(isMobile===1){
				$("#formInfoContainer").html('');
			}
		}
		
		$scope.$on('featureInfoReceived', function(event, data) {
			$scope.cleanMoreInfo();
			loggerService.log("app_dbmanager -> MainController.js","featureInfoReceived",data);
			//console.log(data)
			$scope.id_town						= data.id;
			$scope.town_ine						= data.cmun_inem;
			$scope.cmun_ine						= data.cmun_ine;
			$scope.cpro_ine						= data.cpro_ine;
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
			$scope.town_observations			= data.observaciones;
			$scope.edit_town_observations		= data.observaciones;
			$scope.town_govern					= data.gobierno;
			$scope.edit_town_govern				= data.gobierno;

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
			$('.collapseInfo').collapse('show');
			responsiveService.expandMenu();
	    });
		
		$scope.updateInfo = function(){
			if(canUpdate){
				
				var vars2send					= {};
				vars2send.id_town				= $scope.id_town;
				vars2send.town_water_provider	= $scope.edit_town_water_provider;
				vars2send.town_w_contract_init	= $scope.edit_town_w_contract_init;
				vars2send.town_w_contract_end	= $scope.edit_town_w_contract_end;
				vars2send.town_sanity_provider	= $scope.edit_town_sanity_provider;
				vars2send.town_s_contract_init	= $scope.edit_town_s_contract_init;
				vars2send.town_s_contract_end	= $scope.edit_town_s_contract_end;
				vars2send.town_observations		= $scope.edit_town_observations;
				vars2send.town_govern			= $scope.edit_town_govern;
				vars2send.prox_prorroga			= $scope.prox_prorroga;
				vars2send.prox_concurso			= $scope.prox_concurso;
				vars2send.fut_prorroga			= $scope.fut_prorroga;
				vars2send.cartera				= $scope.cartera;
				vars2send.neg_2016				= $scope.neg_2016;
				vars2send.neg_2017				= $scope.neg_2017;
				vars2send.neg_2018				= $scope.neg_2018;
				vars2send.inv_2016				= $scope.inv_2016;
				vars2send.inv_2017				= $scope.inv_2017;
				vars2send.inv_2018				= $scope.inv_2018;
				vars2send.neg_resto				= $scope.neg_resto;
				vars2send.inv_resto				= $scope.inv_resto;
				vars2send.inv_total				= $scope.inv_total;
				vars2send.cmun5_ine				= $scope.town_ine;

				placesService.updateTown(vars2send).success(function(data) {
					loggerService.log("app_dbmanager -> MainController.js","updateTown success: ",data);
					$scope.cleanMoreInfo();
					if(data.status==="Accepted"){
						$scope.form_edit			= false;	
						$scope.display_info			= true;	
						$scope.town_water_provider	= $scope.edit_town_water_provider;
						$scope.town_w_contract_init	= formatDateFromDb($scope.edit_town_w_contract_init);
						$scope.town_w_contract_end	= formatDateFromDb($scope.edit_town_w_contract_end);
						$scope.town_sanity_provider	= $scope.edit_town_sanity_provider;
						$scope.town_s_contract_init	= formatDateFromDb($scope.edit_town_s_contract_init);
						$scope.town_s_contract_end	= formatDateFromDb($scope.edit_town_s_contract_end);
						$scope.town_observations	= $scope.edit_town_observations;
						$scope.town_govern			= $scope.edit_town_govern;
					}else{
						
					}
					if(isMobile===0){
						responsiveService.expandMenu();
						$('#modalInfo').modal('hide');
					}
				})
				.error(function (error) {
				  loggerService.log("app_dbmanager -> MainController.js","error in updateTown");
			    });	
			}
			
		}
		
		$scope.getTownExtraInfo	= function(){
			loggerService.log("app_dbmanager -> MainController.js","getTownExtraInfo("+$scope.id_town+")");
			$scope.notes		= Array();
			if(isMobile===0){
				responsiveService.collapseMenu();
			}
			if($scope.id_town){
				var codi_ine5	= $scope.cpro_ine+$scope.cmun_ine //codi_ine5=cpro_ine+ cmun_ine
				placesService.getTownExtraInfo($scope.town_ine,codi_ine5).success(function(data) {
					loggerService.log("app_dbmanager -> MainController.js","getTownExtraInfo success: ",data);
					if(data.status==="Accepted"){
						$scope.prox_prorroga		= data.message.prox_prorroga;
						$scope.prox_concurso		= data.message.prox_concurso;
						$scope.fut_prorroga			= data.message.fut_prorroga;
						$scope.cartera				= data.message.cartera;
						$scope.neg_2016				= data.message.neg_2016;
						$scope.neg_2017				= data.message.neg_2018;
						$scope.neg_2018				= data.message.neg_2018;
						$scope.neg_resto			= data.message.neg_resto;
						$scope.inv_2016				= data.message.inv_2016;
						$scope.inv_2017				= data.message.inv_2017;
						$scope.inv_2018				= data.message.inv_2018;
						$scope.inv_resto			= data.message.inv_resto;
						$scope.inv_total			= data.message.inv_total;
						$scope.notes				= data.message.notes;
					}else{
						
					}
				})
				.error(function (error) {
				  loggerService.log("app_dbmanager -> MainController.js","error in getTownExtraInfo");
			    });		
			}		
		}
		
		//****************************************************************
    	//****************     END TOWN INFO & UPDATE      	**************
    	//****************************************************************	
    	
    	//****************************************************************
    	//******************          SEGUIMIENTO         ****************
    	//****************************************************************	
		
		$scope.showFormNote	= function(){
			loggerService.log("app_dbmanager -> MainController.js","showFormNote()");
			if(!$scope.formNoteDisplay){
				$scope.mensaje			= "";
				$scope.formNoteDisplay 	= true;
				$scope.btAddNoteDisplay	= false;
			}
		}
   
		$scope.hideFormNote	= function(){
			loggerService.log("app_dbmanager -> MainController.js","hideFormNote()");
			if($scope.formNoteDisplay){
				$scope.formNoteDisplay 	= false;
				$scope.btAddNoteDisplay	= true;
			}
		}
   
    	$scope.addNote		= function(){
	    	loggerService.log("app_dbmanager -> MainController.js","addNote()");
	    	if($scope.mensaje!=""){
		    	var vars2send					= {};
					vars2send.municipio_id			= $scope.cpro_ine+$scope.cmun_ine //codi_ine5=cpro_ine+ cmun_ine
					vars2send.mensaje				= $scope.mensaje;
					placesService.addNote(vars2send).success(function(data) {
						loggerService.log("app_dbmanager -> MainController.js","addNote success: ",data);
						$scope.notes.push(data.message);
						//reset
						$scope.mensaje		= "";
					})
					.error(function (error) {
					  loggerService.log("app_dbmanager -> MainController.js","error in addNote");
				    });	
			}
    	}
    	
    	//****************************************************************
    	//******************          SEGUIMIENTO         ****************
    	//****************************************************************    	
    	
    	//****************************************************************
    	//****************            TOOLTIP     	        **************
    	//****************************************************************
		
		$scope.$on('displayToolTip', function(event, data) {
			//loggerService.log("app_dbmanager -> MainController.js","displayToolTip",data);
			if(data.show){
				$('#info').css({
							left: (mouseX) + 'px',
							top: (mouseY) + 'px'
						})
				$scope.toolTip.title 			= data.nmun_cc;
				$scope.toolTip.suministrador	= data.sub_aqp;
				$('#info').show();
				toolTipInstant			= new Date().getTime();
				setTimeout(function(){
					$('#info').hide('fast');
				}, 6000);
			}else{
				$('#info').hide('fast');
			}
		});
		
		$scope.$on('hideToolTip', function(event, data) {
			//loggerService.log("app_dbmanager -> MainController.js","hideToolTip");
			if(toolTipInstant+2000<new Date().getTime()){
				$('#info').hide('fast');
			}		
		});
		
		function getMousePos(evt) {
		    var doc = document.documentElement || document.body;
		    var pos = {
		        x: evt ? evt.pageX : window.event.clientX + doc.scrollLeft - doc.clientLeft,
		        y: evt ? evt.pageY : window.event.clientY + doc.scrollTop - doc.clientTop
		    };
		    return pos;	
		}
		
		function moveMouse(evt) {
			var pos 	= getMousePos(evt)
			mouseX		= pos.x;
			mouseY 		= pos.y;
		}
		
		document.onmousemove = moveMouse;
		
    	//****************************************************************
    	//****************           END TOOLTIP     	    **************
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
		
		function loadLegend(){
			var legendUrl	= urlWMS+"?Service=WMS&REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=12&HEIGHT=12&LAYER="+$scope.activeLayer+"&TRANSPARENT=true&legend_options=fontAntiAliasing:true;fontColor:0x000033;fontSize:6;bgColor:0xFFFFEE;dpi:180&excludefromlegend=rule1etiquetes,rule2limit";		
			loggerService.log("app_dbmanager -> MainController.js","loadLegend: "+legendUrl);
			$scope.legendUrl= legendUrl;
		}

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
		
		function formatDateFromDb(date){
			var d = new Date(date),
		        month = '' + (d.getMonth() + 1),
		        day = '' + d.getDate(),
		        year = d.getFullYear();
		    if (month.length < 2) month = '0' + month;
		    if (day.length < 2) day = '0' + day;
		    return [day, month, year].join('-');		
		}
		
		$scope.formatDate 		= function(date){
			return formatDateFromDb(date);
		}
		
		//map resized event for responsive features
		$scope.$on('mapResized', function(event, data) {
			mapService.resize();
	    });
		
		//log event
		$scope.$on('logEvent', function (event, data){
			if(data.extradata){
				loggerService.log("app_dbmanager -> "+data.file,data.evt,data.extradata);
			}else{
				loggerService.log("app_dbmanager -> "+data.file,data.evt);	
			}			
		});
		
		//****************************************************************
    	//********************   END HELPER METHODS  *********************
    	//****************************************************************	
	}
})();