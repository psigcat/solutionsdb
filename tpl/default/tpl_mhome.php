	<link href="js/libs/fadeshow/jquery.fadeshow-0.1.1.min.css" type="text/css" rel="stylesheet" />
	<div class="background"></div>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12 panel-home">
				<div class="row">
					<div class="col-xs-6 col-md-3">
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
							<span>DB MANAGER</span>
						</a>
					</div>
					<div class="col-xs-6 col-md-3">
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
							<span>DB QUALITY</span>
						</a>
					</div>
					<div class="col-xs-6 col-md-3">
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
							<span>DB WATER</span>
						</a>
					</div>
					<div class="col-xs-6 col-md-3">
						<?php
						if($dbbnergy){	
						?>
							<a href="https://n4.opendomo.com/admin/login">
						<?php
						}else{
						?>
							<a href="#">
						<?php
						}
						?>
							<i class="dblogo dbenergy"></i>
							<span>DB ENERGY</span>
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