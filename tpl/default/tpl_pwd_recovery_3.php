	<link href="js/libs/fadeshow/jquery.fadeshow-0.1.1.min.css" type="text/css" rel="stylesheet" />
	<div class="background"></div>
	
	<div class="container">
		<div class="row" ng-app="app" ng-controller="mainController as mc">
			<div class="col-xs-10 col-sm-6 col-md-4 col-xs-offset-1 col-sm-offset-3 col-md-offset-4 panel-login">
				<h1><span>SolutionsDB</span></h1>
				<p class="text-center">Departamento técnico<br>Delegación Nordeste</p>
				<p class="subtitle"><?php echo PASSWORD_FORGOT; ?></p>
				<form action="recovery.php" method="post" id="recoveryForm" name="recoveryForm" ng-model="recoveryForm">
					<div class="alert alert-danger ng-cloak" ng-cloak role="alert" ng-show="err_pwds"><?php echo PASSWORD_NOT_MATCH; ?></div>
					<div class="form-group">
						<label for="exampleInputEmail3"><?php echo PASSWORD1; ?></label>
						<input type="text" class="form-control"  placeholder="Password" name="pwd1" id="pwd1" ng-model="pwd1" required>
					</div>
					<div class="form-group">
						<label for="exampleInputEmail3"><?php echo PASSWORD2; ?></label>
						<input type="text" class="form-control"  placeholder="Repetir Password" name="pwd2" id="pwd2" ng-model="pwd2" required>
					</div>
					
					<div class="row">
						<div class="col-xs-6 col-sm-5 col-lg-4">
							<input type="hidden" name="token" value="<?php echo $token; ?>">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<button type="button" class="btn btn-default" ng-click="setNewPassword()"><?php echo REGENERATE; ?> 
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