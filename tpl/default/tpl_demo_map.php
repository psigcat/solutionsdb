<!DOCTYPE html>
<html ng-app="app">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Demo openlayers 3</title>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Bootstrap -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
	    html, body, #map {
			padding: 0;
			margin: 0;
		}
		 
		#map {
			width: 100%;
			height: 600px;
		}
	</style>
  </head>
  <body ng-controller="mainController as mc">
	  <div id="map"></div>
    
    
    
    
    <script src="http://openlayers.org/en/v3.11.2/build/ol.js"></script> 
    <link rel="stylesheet" href="http://openlayers.org/en/master/css/ol.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.4/angular.min.js"></script>
    
    <!-- Application -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/proj4js/2.2.1/proj4.js" type="text/javascript"></script>
    <script src="http://www.icc.cat/extension/icc/design/icc/javascript/25831.js" type="text/javascript"></script>


  <script src="js/app_demo_map/app.js"></script>
  <script src="js/app_demo_map/MainController.js"></script>
  <script src="js/app_demo_map/mapService.js"></script>
  </body>
</html>




