<!DOCTYPE html>
<html>
	<head>
		<title>DBWater</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="tpl/default/css/dbwater.css" type="text/css" charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8" />
	</head>
	<body>
    	
        <div id="angularAppContainer" ng-app="app" ng-controller="mainController as mc" ng-init="initApp('<?php echo $baseHref; ?>','<?php echo $urlWMS; ?>','<?php echo $env; ?>','<?php echo $token; ?>','<?php echo $isMobile; ?>')">
            
            <div class="window main">
                <div class="content">
                    <ul class="list-unstyled list-inline">
                        <li><a href="#"><img src="tpl/default/img/dbwater/logo.jpg" class="hidden-xs" /><img src="tpl/default/img/dbwater/logo-xs.jpg" class="visible-xs" /></a></li>
                        <li><div class="vertical-line"></div></li>
                        <li><a href="#"><img src="tpl/default/img/dbwater/ic-informe.jpg" /></a></li>
                        <li><a href="#"><img src="tpl/default/img/dbwater/ic-graphic.jpg" /></a></li>
                        <li><a href="#"><img src="tpl/default/img/dbwater/ic-layers.jpg" /></a></li>
                        <li><a href="#"><img src="tpl/default/img/dbwater/ic-config.jpg" /></a></li>
                        <li><a href="#"><img src="tpl/default/img/dbwater/ic-danger.jpg" /></a></li>
                        <li><a href="#"><img src="tpl/default/img/dbwater/ic-search.jpg" /></a></li>
                    </ul>
                </div>
            </div>

            <div class="window right-side">
                <h2>Sector 43</h2>
                <div class="content">
                    <h3>Rendimiento teórico</h3>
                    <div class="row list-of-donuts">
                        <div class="col-xs-4" align="center">
                            <img src="http://placehold.it/60x60" />
                            <p class="title">Día</p>
                        </div>
                        <div class="col-xs-4" align="center">
                            <img src="http://placehold.it/60x60" />
                            <p class="title">Semana</p>
                        </div>
                        <div class="col-xs-4" align="center">
                            <img src="http://placehold.it/60x60" />
                            <p class="title">Mes</p>
                        </div>
                    </div>
                    <h3>Tendéncia últimos 7 días</h3>
                    <img src="http://placehold.it/215x90" class="full-width" />
                    <h3>Información</h3>
                    <div class="list-with-icon">
                        <div class="icon-container">
                            <img src="tpl/default/img/dbwater/ic-water.jpg" class="icon" />
                        </div>
                        <ul class="list-unstyled list-left-bordered">
                            <li>Volumen suministrado <span class="pull-right custom-badge">324</span></li>
                            <li>Caudal mínimo <span class="pull-right custom-badge">324</span></li>
                            <li>Volumen caudal medio total <span class="pull-right custom-badge">324</span></li>
                            <li>Volumen de pérdida diaria <span class="pull-right custom-badge">324</span></li>
                        </ul>
                    </div>
                    <h3>Consumos mínimos nocturnos</h3>
                    <img src="http://placehold.it/215x90" class="full-width" />
                    <h3>Información real</h3>
                    <div class="list-with-donut">
                        <div class="icon-container">
                            <img src="http://placehold.it/110x55" class="donut" />
                        </div>
                        <ul class="list-unstyled list-left-bordered">
                            <li>Mensual <span class="pull-right custom-badge">12,1%</span></li>
                            <li>Interanual <span class="pull-right custom-badge">12,1%</span></li>
                            <li>Totalizador <span class="pull-right custom-badge">12345</span></li>
                        </ul>
                    </div>
                    <hr />
                    <a href="#" class="btn btn-sm btn-primary">Ficha</a> Ver ficha completa
                </div>
            </div>
            
        	<div id="map"><!-- map container --></div>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
        <script>
            $(window).ready(function(){
                function adjustWindows(){
                    var width = $(window).width();
                    var height = $(window).height();
                    $(".window.right-side").css("max-height", height-30);
                }
                
                adjustWindows();
                
                $(window).resize(function(){
                    adjustWindows();
                });
            });
        </script>
        
    	<!-- Angular js -->
    	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    	
    	<!-- Open layers -->
    	<script src="http://openlayers.org/en/v3.12.1/build/ol.js"></script> 
        <link rel="stylesheet" href="http://openlayers.org/en/master/css/ol.css" />
        <!-- End Open layers -->
        
        <!-- Application -->
    	<script src="js/app_dbwater/app.js"></script>
    	<script src="js/app_dbwater/MainController.js"></script>
    	<script src="js/app_dbwater/mapService.js"></script>
    	<script src="js/common/loggerService.js"></script>
    	 <!-- End Application -->
    	 
	</body>
</html>






	
