	<link href="js/libs/fadeshow/jquery.fadeshow-0.1.1.min.css" type="text/css" rel="stylesheet" />
	<div class="background"></div>
	
	<div class="container">
		<div class="row" ng-app="app" ng-controller="mainController as mc">
			<div class="col-xs-10 col-sm-6 col-md-4 col-xs-offset-1 col-sm-offset-3 col-md-offset-4 panel-login">
				<h1><span>SolutionsDB</span></h1>
				<p class="text-center">Departamento técnico<br>Delegación Nordeste</p>
				<p class="subtitle">Acceda a su cuenta</p>
				<form action="login.php" method="post">
					<div class="form-group">
						<label class="sr-only" for="exampleInputEmail3">Email address</label>
						<input type="text" class="form-control" id="exampleInputEmail3" placeholder="User name" name="user" ng-model="loginForm.user" required>
					</div>
					<div class="form-group">
						<label class="sr-only" for="exampleInputPassword3">Password</label>
						<input type="password" class="form-control" ng-model="loginForm.pwd" name="pwd" ng-minlength="5" required placeholder="Password">
					</div>
					<div class="row">
						<div class="form-group col-xs-6 col-sm-7 col-lg-8">
							<div class="checkbox">
								<label>
									<input type="checkbox"> Recordarme
								</label>
							</div>
						</div>
						<div class="col-xs-6 col-sm-5 col-lg-4">
							<input type="hidden" name="token" value="<?php echo $token; ?>">
							<button type="submit" class="btn btn-default btn-block" g-submit="loginForm.submitTheForm()" ng-disabled="loginForm.$invalid">Acceder 
<i class="fa fa-lg fa-arrow-circle-o-right"></i></button>
						</div>
					</div>
				</form>
				<p class="restore"><big>¿Olvidó su contraseña?</big></p>
				<p class="restore">No hay problema, haga click aquí para restablecerla</p>
				
				<p class="text-center"><a href="http://www.solutionsdb.net" target="_blank">www.solutionsdb.net</a></p>
			</div>
		</div>
	</div>
	
	<script src="js/libs/fadeshow/jquery.fadeshow-0.1.1.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(function(){
		var fadeShow = $(".background").fadeShow({
			correctRatio: true,
			shuffle: true,
			speed: 10000,
			images: [
<?php foreach ($background as $item){
	echo "'".$item."',\n";
} ?>			
			]		
		});
	});
	</script>
	<script src="js/app_login/app.js"></script>
	<script src="js/app_login/MainController.js"></script>