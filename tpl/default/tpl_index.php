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
	</style>
  </head>
  <body>
	  
	  <div ng-app="app" ng-controller="mainController as mc">
			<form action="login.php" method="post">
			 User:<br>
			 <input type="text" name="user" ng-model="loginForm.email" required>
			 <input type="hidden" name="token" value="<?php echo $token; ?>">
			  <br>
			 Pwd:<br>
			 <input type="password" ng-model="loginForm.pwd" name="pwd" ng-minlength="5" required>
			 <br><br>
			
			 <button type="submit" ng-submit="loginForm.submitTheForm()" ng-disabled="loginForm.$invalid">Submit</button>

		</form>
	  </div>
    
    
    
    
    <script src="http://openlayers.org/en/v3.11.2/build/ol.js"></script> 
    <link rel="stylesheet" href="http://openlayers.org/en/master/css/ol.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.4/angular.min.js"></script>
    
    <!-- Application -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/proj4js/2.2.1/proj4.js" type="text/javascript"></script>
    <script src="http://www.icc.cat/extension/icc/design/icc/javascript/25831.js" type="text/javascript"></script>
	

	<script src="js/app_login/app.js"></script>
	<script src="js/app_login/MainController.js"></script>
  </body>
</html>




