	<link href="js/libs/fadeshow/jquery.fadeshow-0.1.1.min.css" type="text/css" rel="stylesheet" />
	<div class="background"></div>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-10 col-sm-6 col-md-4 col-xs-offset-1 col-sm-offset-3 col-md-offset-4 panel-login">
				<h1><span>SolutionsDB</span></h1>
				<p class="text-center">Departamento técnico<br>Delegación Nordeste</p>
				<p class="subtitle"><?php echo PASSWORD_FORGOT; ?></p>
				

					
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-lg-12">
							
							<?php 

									echo NO_HASH;
							?>
							<br><bR>
						</div>
					</div>
				
				
				
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
