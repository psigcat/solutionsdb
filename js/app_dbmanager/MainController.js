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

		$scope.provinceList					= Array();
		$scope.townList						= Array();
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
		$scope.canUpdate					= false;
		$scope.backgroundmap				= 1; //default backgroundmap (1=light, 2 dark)
		//report
		$scope.previewReportItems			= Array();
		$scope.showExportBT					= false; 	//hide export report button
		$scope.reportDownload				= false;
		$scope.showDownloadBT				= false;
		$scope.generatingReport				= false;
		$scope.showPreviewBT				= true;
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
			version							= "1.0.0",
			provinceForReport,
			moreInfoDisplayed				= false,
			reportDisplayed					= false;
			
		$scope.initApp	= function(_baseHref,_urlWMS,_environment,_token,_canUpdate,_isMobile){
		
			baseHref			= _baseHref;
			token				= _token;
			urlWMS				= _urlWMS;
			isMobile			= parseInt(_isMobile);
			canUpdate			= parseInt(_canUpdate);			
			if(canUpdate===1){
				$scope.canUpdate	= false;
			}else{
				$scope.canUpdate	= true;
			}

			//logger service init
			loggerService.init(_environment);
			log("init("+_baseHref+","+urlWMS+","+_environment+","+_token+","+_canUpdate+","+_isMobile+")");
			//responsive initialization
			responsiveService.init();

			
			// map initialisation
			mapService.init(urlWMS,$scope.backgroundmap,$scope.activeLayer);
			loadLegend();
			// search initialisation
			placesService.init(baseHref,_token);
			//fill provinces on page load
			placesService.listProvinces().success(function(data) {
				log("init() listProvinces success",data);
				if(data.total>0){
					$scope.search					= true;	
					$scope.provinceList 			= data.message;
				}
			})
			.error(function (error) {
			   log("init() error in listProvinces");
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
			log("getTownsFromName("+val+")");
			return placesService.getTownsFromName(val,"dbManager");
		};
				
		$scope.townSelected	= function ($item, $model, $label){
			log("townChanged: "+$item);
			placesService.getTownByName($item).success(function(data) {
				log("townSelected: ",data);
				mapService.zoomToTown(JSON.parse(data.message.bbox),JSON.parse(data.message.coords));
			})
			.error(function (error) {
			  log("error in townSelected");
		    });		
		}		
		
		//****************************************************************
    	//***********************       END SEARCH     *******************
    	//****************************************************************
    	
		//****************************************************************
    	//***********************        REPORT        *******************
    	//****************************************************************
		
		$scope.exportReport		= function(){
			log("exportReport");
			$scope.showDownloadBT			= false;
			$scope.showExportBT				= false;
			$scope.generatingReport			= true;
			$scope.showPreviewBT			= false;
			createReport(true);		
		}
		
		$scope.displayReport	= function(){
			reportDisplayed	= true;
			$scope.collapseMenu();
			if(moreInfoDisplayed){
				$('#modalInfo').modal('hide');
				moreInfoDisplayed = false;
			}
		}
		
		$scope.closeReport		= function(){
			reportDisplayed	= false;
			$scope.closeModal();
			$('#modalReport').modal('hide');
		}
		
		$('#modalReport').on('hidden.bs.modal', function () {
			reportDisplayed = false;
		});
		
		function createReport(file){
			log("createReport("+file+")");
			$scope.showDownloadBT			= false;
			$scope.showExportBT				= false;
			//$scope.generatingReport			= false;
			var vars2send					= {};
			vars2send.cpro_dgc				= $scope.selectedProvinceForReport;
			vars2send.area_km2				= $scope.area_km2;
			vars2send.habitantes			= $scope.habitantes;
			vars2send.sub_aqp				= $scope.sub_aqp;
			vars2send.ap_data_ini			= $scope.ap_data_ini_rep;
			vars2send.ap_data_fi			= $scope.ap_data_fi_rep;
			vars2send.sub_cla				= $scope.sub_cla;
			vars2send.cla_data_ini			= $scope.cla_data_ini_rep;
			vars2send.cla_data_fi			= $scope.cla_data_fi_rep;
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
			vars2send.createFile			= file;	
			if(!file){
				$scope.previewReportItems		= Array();
				vars2send.limit					= 10;	
				$scope.generatingReport			= false;	
			}
			placesService.previewReport(vars2send).success(function(data) {
				log("previewReport: ",data);
				
				if(data.status==="Accepted"){
					$scope.generatingReport			= false;
					$scope.showPreviewBT			= true;
					if(data.message.length>0 && !file){
						$scope.showExportBT			= true;
						$scope.showDonwloadBT		= false;
						$scope.previewReportItems	= data.message;
					}else{
						$scope.showExportBT		= false;
						$scope.showDownloadBT	= true;
						$scope.fileToDownload	= data.file;
					}		
				}
			})
			.error(function (error) {
			  log("error in previewReport");
		    });	
		}
		$scope.previewReport	= function(){
			log("previewReport");
			createReport(false);
		}
			
		//****************************************************************
    	//***********************     END REPORT        ******************
    	//****************************************************************
    	
    	//****************************************************************
    	//***********************     CONFIGURATION    *******************
    	//****************************************************************
    	
		$scope.changeBackgroundMap	= function(){
			log("changeBackgroundMap: "+$scope.backgroundmap);
			mapService.setBackground($scope.backgroundmap);
		}

		$scope.changeActiveLayer	= function(){
			log("changeActiveLayer: "+$scope.activeLayer);
			mapService.renderWMS($scope.activeLayer);
			loadLegend();
			loadAlerts();	
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
			alertsService.listAlerts($scope.period_alarm_drink_water,$scope.activeLayer).success(function(data) {
				log("listAlerts success",data);
				if(data.status==="Accepted"){
					$scope.alertCount 	= data.total;
					$scope.alerts 		= data.message;
				}
			})
			.error(function (error) {
			   log("error in listAlerts");
		    });	

		}

		$scope.peridoAlertDrinkWaterChanged	= function(){
			log("peridoAlertDrinkWaterChanged() "+$scope.period_alarm_drink_water);
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

		$scope.infoClicked		= function(){
			log("infoClicked");
			if($scope.id_town){
				if($('.collapseInfo').hasClass('in')){
					$('.collapseInfo').collapse('hide');
				}else{
					$('.collapseInfo').collapse('show');
				}			
			}
		}
		
		$('#modalInfo').on('hidden.bs.modal', function () {
			moreInfoDisplayed = false;
		});
		
		$scope.cleanMoreInfo	= function(){
			log("cleanMoreInfo");
			if(isMobile===1){
				$("#formInfoContainer").html('');
			}
		}
		
		$scope.$on('featureInfoReceived', function(event, data) {
			$scope.cleanMoreInfo();
			log("featureInfoReceived",data);
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
				var codi_ine5	= $scope.cpro_ine+$scope.cmun_ine //codi_ine5=cpro_ine+ cmun_ine
				vars2send.cmun5_ine				= $scope.codi_ine5;
		
				placesService.updateTown(vars2send).success(function(data) {
					log("updateTown success: ",data);
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
				  log("error in updateTown");
			    });	
			}			
		}
		
		$scope.getTownExtraInfo	= function(){
			log("getTownExtraInfo("+$scope.id_town+")");
			$scope.notes		= Array();
			moreInfoDisplayed	= true;
			if(reportDisplayed){
				$scope.closeReport();
			}
			
			if(isMobile===0){
				responsiveService.collapseMenu();
			}
			if($scope.id_town){
				var codi_ine5	= $scope.cpro_ine+$scope.cmun_ine //codi_ine5=cpro_ine+ cmun_ine
				placesService.getTownExtraInfo(codi_ine5).success(function(data) {
					log("getTownExtraInfo success: ",data);
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
				  log("error in getTownExtraInfo");
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
			log("showFormNote()");
			if(!$scope.formNoteDisplay){
				$scope.mensaje			= "";
				$scope.formNoteDisplay 	= true;
				$scope.btAddNoteDisplay	= false;
			}
		}
   
		$scope.hideFormNote	= function(){
			log("hideFormNote()");
			if($scope.formNoteDisplay){
				$scope.formNoteDisplay 	= false;
				$scope.btAddNoteDisplay	= true;
			}
		}
   
    	$scope.addNote		= function(){
	    	log("addNote()");
	    	if($scope.mensaje!=""){
		    	var vars2send					= {};
					vars2send.municipio_id			= $scope.cpro_ine+$scope.cmun_ine //codi_ine5=cpro_ine+ cmun_ine
					vars2send.mensaje				= $scope.mensaje;
					placesService.addNote(vars2send).success(function(data) {
						log("addNote success: ",data);
						$scope.notes.push(data.message);
						//reset
						$scope.mensaje		= "";
					})
					.error(function (error) {
					  log("error in addNote");
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
			//log("displayToolTip",data);
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
			//log("hideToolTip");
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
    	//*****************            DATEPICKERS      ******************
    	//****************************************************************

		$scope.dp_w_contract_init_open = function() {
			$scope.dp_w_contract_init.opened 		= true;
			$scope.dp_w_contract_init_repo.opened	= true;
		};
		

		$scope.dp_w_contract_end_open = function() {
			$scope.dp_w_contract_end.opened 		= true;
			$scope.dp_w_contract_end_repo.opened 	= true;
			
		};
		
		$scope.dp_s_contract_init_open = function() {
			$scope.dp_s_contract_init.opened 			= true;
			$scope.dp_s_contract_init_repo.opened		= true;
			
		};
		
		$scope.dp_s_contract_end_open = function() {
			$scope.dp_s_contract_end.opened 		= true;
			$scope.dp_s_contract_end_repo.opened 	= true;		
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
		
		//Datepicker initialization
		//more info
		$scope.dp_w_contract_init = {
			opened: true
		};
		
		$scope.dp_w_contract_end = {
			opened: true
		};
		
		$scope.dp_s_contract_init = {
			opened: true
		};
		
		$scope.dp_s_contract_end = {
			opened: true
		};
		//end info
		
		//report
		$scope.dp_w_contract_init_repo = {
			opened: true
		};
		$scope.dp_w_contract_end_repo = {
			opened: true
		};
		$scope.dp_s_contract_init_repo = {
			opened: true
		};
		
		$scope.dp_s_contract_end_repo = {
			opened: true
		};
		//end report
		
		//****************************************************************
    	//***************        END DATEPICKERS        ******************
    	//****************************************************************
		


	
		


		
	

		//****************************************************************
    	//***********************   HELPER METHODS   *********************
    	//****************************************************************
		
		function loadLegend(){
			var legendUrl	= urlWMS+"?Service=WMS&REQUEST=GetLegendGraphic&VERSION=1.0.0&FORMAT=image/png&WIDTH=12&HEIGHT=12&LAYER="+$scope.activeLayer+"&TRANSPARENT=true&legend_options=fontAntiAliasing:true;fontColor:0x000033;fontSize:6;bgColor:0xFFFFEE;dpi:180&excludefromlegend=rule1etiquetes,rule2limit";		
			log("loadLegend: "+legendUrl);
			$scope.legendUrl= legendUrl;
		}

		$scope.giveMeProvinceName 	= function(cpro_ine){
			return giveMeProvinceName(cpro_ine);
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

		function formatDateTime(date) {
			if(date){
				var strDate	= date.split(" ");
				var onlyDate= strDate[0].split("-");
				return onlyDate[2]+"-"+onlyDate[1]+"-"+onlyDate[0]+" "+strDate[1];
			}else{
				return "";
			}
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
		
		$scope.formatDateTime 		= function(date){
			return formatDateTime(date);
		}
		
		$scope.cleanQuotes		= function(str){
			str		= str.replace(/QT/g, "'");
			str		= str.replace(/QS/g, '"');
			return str;
		}
		
		//map resized event for responsive features
		$scope.$on('mapResized', function(event, data) {
			mapService.resize();
	    });
		
		//log event
		$scope.$on('logEvent', function (event, data){
			if(data.extradata){
				log(data.evt,data.extradata);
			}else{
				log(data.file+" "+data.evt);	
			}			
		});
		
		function log(evt,extradata){
			if(extradata){
				loggerService.log("app_dbmanager -> MainController.js v."+version,evt,extradata);
			}else{
				loggerService.log("app_dbmanager -> MainController.js v."+version,evt);	
			}			
		}	
		//****************************************************************
    	//********************   END HELPER METHODS  *********************
    	//****************************************************************	
	}
})();