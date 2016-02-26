(function() {
'use strict';

	/**
	 * Search Service
	 */
	 
	angular.module('app').factory('responsiveService', ['$rootScope', function ($rootScope) {
		
		var mapwidth,
			newheight,
			menuwidth,
			menuclose,
			ml,
			newheight,
			newmapwidth,
			expand;

		function setupMap(){
			
			if (expand === true){
				ml = menuwidth;
			}
			else{
				ml = menuclose;
			}
			newmapwidth = mapwidth - parseInt(ml);
				$("#map").animate({
					marginLeft: ml,
					width : newmapwidth+'px',
					height: newheight+'px'
				}, 300, function(){
				//	ARA CRIDEM EL MAPA
				console.log('responsiveService.js-> setupMap()');
				$rootScope.$broadcast('mapResized',{});
			});
			
			
		}

	
		var dataFactory = {};
		
		dataFactory.init	= function(){
			mapwidth = $(document).width();	
			newheight = parseInt($('nav').css('height'))-parseInt($('.navbar').css('height'));
			menuwidth = $('.main-menu').css('width');
			menuclose = $('#map').css('margin-left');
		
			//$('nav').css('height', newheight+'px');

			if ($('body').hasClass('nav-expanded')){
				expand = true;
				setupMap();
			}
			
			//Navigation Menu Slider      
			$('#nav-expander').on('click',function(e){
				e.preventDefault();
				toggleMenu();
				
				
			});

			$('.panel-accordion').on('click', function(e){
				e.preventDefault();  	
				if (!$('body').hasClass('nav-expanded')){
					$('body').toggleClass('nav-expanded');
					expand = true;
					setupMap();
				}
			});
		}
		
		function toggleMenu(){
			$('body').toggleClass('nav-expanded');
			if (!$('body').hasClass('nav-expanded')){
				$('.panel-collapse').removeClass('in');
				expand = false;
				setupMap();
			}else{
				expand = true;
				setupMap();
			}
		}
		
		function collapseMenu(){
			if ($('body').hasClass('nav-expanded')){
				$('.panel-collapse').removeClass('in');
				$('body').removeClass('nav-expanded');
				expand = false;
				setupMap();
			}	
		}

		function expandMenu(){
			if (!$('body').hasClass('nav-expanded')){
				$('body').addClass('nav-expanded');
				expand = true;
				setupMap();
			}	
		}
		
		dataFactory.expandMenu		= expandMenu;		
		dataFactory.collapseMenu	= collapseMenu;
		dataFactory.toggleMenu		= toggleMenu;
		dataFactory.setupMap		= setupMap;		
		return dataFactory;
		
		
	}])

})();