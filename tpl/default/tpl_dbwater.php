tpl a maquetar
<div id="angularAppContainer" ng-app="app" ng-controller="mainController as mc" ng-init="initApp('<?php echo $baseHref; ?>','<?php echo $urlWMS; ?>','<?php echo $env; ?>','<?php echo $token; ?>','<?php echo $isMobile; ?>')">
	<div id="map"><!-- map container --></div>
</div>


	
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