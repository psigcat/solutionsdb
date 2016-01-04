	<link href="js/libs/fadeshow/jquery.fadeshow-0.1.1.min.css" type="text/css" rel="stylesheet" />
	<div class="background"></div>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-10 col-sm-6 col-md-4 col-xs-offset-1 col-sm-offset-3 col-md-offset-4 panel-login">
				<h1><img src="tpl/<?php echo $skin; ?>/img/logo_lg.png" alt="logo_lg" width="45" height="46" />SolutionsDB</h1>
				<p class="subtitle">Acceda a su cuenta</p>
				<form>
					<div class="form-group">
						<label class="sr-only" for="exampleInputEmail3">Email address</label>
						<input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
					</div>
					<div class="form-group">
						<label class="sr-only" for="exampleInputPassword3">Password</label>
						<input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
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
							<button type="submit" class="btn btn-default btn-block">Acceder 
<i class="fa fa-lg fa-arrow-circle-o-right"></i></button>
						</div>
					</div>
				</form>
				<p class="restore subtitle">¿Olvidó su contraseña?</p>
				<p class="restore">No hay problema, haga click aquí para restablecerla</p>
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