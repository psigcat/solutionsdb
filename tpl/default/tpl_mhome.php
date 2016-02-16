	<link href="js/libs/fadeshow/jquery.fadeshow-0.1.1.min.css" type="text/css" rel="stylesheet" />
	<div class="background"></div>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12 panel-home">
				<div class="row">
					<div class="col-xs-6 col-md-4">
						<?php
						if($dbenergy){	
						?>
							<a href="https://n4.opendomo.com/admin/login" target="_blank">
						<?php
						}else{
						?>
							<a href="#">
						<?php
						}
						?>
							<i class="dblogo dbenergy"></i>
							<p><strong>DbEnergy</strong></p>
							<p>DbEnergy Módulo de gestión y análisis energético</p>
						</a>
					</div>
					<div class="col-xs-6 col-md-4">
						<?php
						if($dbwater){
						?>
							<a href="<?php echo $baseHref?>dbwater">
						<?php
						}else{
						?>
							<a href="#">
						<?php
						}
						?>
							<i class="dblogo dbwater"></i>
							<p><strong>DbWater</strong></p>
							<p>energyDb módulo de gestión de redes de abastecimiento de agua</p>
						</a>
					</div>
					<div class="col-xs-6 col-md-4">
						<?php
						if($dbconsumer){	
						?>
							<a href="<?php echo $baseHref?>dbconsumer">
						<?php
						}else{
						?>
							<a href="#" class="dbdisconnect">
						<?php
						}
						?>
							<i class="dblogo dbconsumer"></i>
							<p><strong>DbConsumer</strong></p>
							<p>DbConsumer módulo de gestión de grandes consumidores</p>
						</a>
					</div>
					<div class="col-xs-6 col-md-4">
						<?php
						if($dbsmartmeter){	
						?>
							<a href="<?php echo $baseHref?>dbsmartmeter">
						<?php
						}else{
						?>
							<a href="#">
						<?php
						}
						?>
							<i class="dblogo dbsmartmeter"></i>
							<p><strong>DbSmartMeter</strong></p>
							<p>DbSmartMeter módulo de gestión de redes inteligentes (smartcity)</p>
						</a>
					</div>
					<div class="col-xs-6 col-md-4">
						<?php
						if($dbquality){	
						?>
							<a href="<?php echo $baseHref?>dbquality">
						<?php
						}else{
						?>
							<a href="#">
						<?php
						}
						?>
							<i class="dblogo dbquality"></i>
							<p><strong>DbQuality</strong></p>
							<p>DbQuality módulo de gestión y análisis de sistemas de calidad del agua</p>
						</a>
					</div>
					<div class="col-xs-6 col-md-4">
						<?php
						if($dbmanager){	
						?>
							<a href="<?php echo $baseHref?>dbmanager">
						<?php
						}else{
						?>
							<a href="#">
						<?php
						}
						?>
							<i class="dblogo dbmanager"></i>
							<p><strong>DbManager</strong></p>
							<p>DbManager módulo de gestión comercial y concesiones</p>
						</a>
					</div>
				</div>
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