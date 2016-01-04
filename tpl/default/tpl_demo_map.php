<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Demo openlayers 3</title>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <style>
	    html, body, #map {
			padding: 0;
			margin: 0;
		}
		 
		#map {
			width: 100%;
			height: 600px;
		}
		#buscador{
			cursor: pointer;
		}
	</style>
  </head>
  <body>
	  <div ng-app="app" ng-controller="mainController as mc" ng-init="initApp('<?php echo $baseHref; ?>')">
	 	 <div ><span ng-click="searchClick()" id="buscador">Buscador (clica para iniciarlo)</span><br>
		 	 <span  ng-show="search">
		 	 <br>
		 	 Provincia: 
		 	 <select
		 	     id="province" 
				 ng-model="selectedProvince" 
				 ng-change="provinceChanged(selectedProvince)" 
				 data-ng-options="item.id as item.name for item in provinceList">
			 	 <option value="" selected="selected">Seleccionar...</option>
		 	 </select>
		 	 Municipio: 
		 	 <select 
			     id="town" 
				 ng-model="selectedTown"
				 ng-change="townChanged(selectedTown)"
				 data-ng-options="item.id as item.name for item in townList" >
			 	 <option value="" selected="selected">Seleccionar...</option>
		 	 </select>
		 	 <br>
		 	 </span>
	 	 </div>
		 <div id="map"></div>
	  </div>
    
    
    
    <script src="http://openlayers.org/en/v3.11.2/build/ol.js"></script> 
    <link rel="stylesheet" href="http://openlayers.org/en/master/css/ol.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.4/angular.min.js"></script>
    
    <!-- Application -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/proj4js/2.2.1/proj4.js" type="text/javascript"></script>
    <script src="http://www.icc.cat/extension/icc/design/icc/javascript/25831.js" type="text/javascript"></script>


  <script src="js/app_demo_map/app.js"></script>
  <script src="js/app_demo_map/MainController.js"></script>
  <script src="js/app_demo_map/mapService.js"></script>
  <script src="js/app_demo_map/placesService.js"></script>
  </body>
</html>




