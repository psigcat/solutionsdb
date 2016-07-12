	<link href="js/libs/fadeshow/jquery.fadeshow-0.1.1.min.css" type="text/css" rel="stylesheet" />
	<div class="background"></div>
	
	<div class="container">
		<div class="row" ng-app="app" ng-controller="mainController as mc">
			<div class="col-xs-10 col-sm-6 col-md-4 col-xs-offset-1 col-sm-offset-3 col-md-offset-4 panel-login">
				<h1><span>SolutionsDB</span></h1>
				<p class="text-center">Departamento técnico<br>Delegación Nordeste</p>
				<p class="subtitle"><?php 
					if($type==="regenerate"){
						echo PASSWORD_OUTOFDATE;
					}else{
						echo PASSWORD_FORGOT;
					} 
					?></p>
				<form action="pwd_recovery.php" method="post">
					<div class="form-group">
						<label for="exampleInputEmail3"><?php 
							if($type==="regenerate"){
								echo INTRODUCE_EMAIL_FOR_PWD_REGENERATE;
							}else{	
								echo INTRODUCE_EMAIL_FOR_PWD_RECOVERY;
							} 
							?></label>
						<input type="text" class="form-control" id="exampleInputEmail3" placeholder="Email" name="email" id="email" ng-model="loginForm.email" required>
					</div>
					
					<div class="row">
						<div class="col-xs-6 col-sm-5 col-lg-4">
							<input type="hidden" name="token" value="<?php echo $token; ?>">
							<button type="submit" class="btn btn-default" ng-submit="loginForm.requestRecovery()" ng-disabled="loginForm.$invalid"><?php echo REQUEST; ?> 
<i class="fa fa-lg fa-arrow-circle-o-right"></i></button>
						</div>
					</div>
				</form>
				
				
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