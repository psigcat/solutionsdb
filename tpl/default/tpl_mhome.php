	<link href="js/libs/fadeshow/jquery.fadeshow-0.1.1.min.css" type="text/css" rel="stylesheet" />
	<div class="background"></div>
	
	<div class="container">
		<div class="row">
			<div class="col-xs-12 panel-home">
				<div class="row">
					<div class="col-xs-6 col-md-3">
						<a href="#">
							<i class="dblogo dbmanager"></i>
							<span>DB MANAGER</span>
						</a>
					</div>
					<div class="col-xs-6 col-md-3">
						<a href="#">
							<i class="dblogo dbquality"></i>
							<span>DB QUALITY</span>
						</a>
					</div>
					<div class="col-xs-6 col-md-3">
						<a href="#">
							<i class="dblogo dbwater"></i>
							<span>DB WATER</span>
						</a>
					</div>
					<div class="col-xs-6 col-md-3">
						<a href="#">
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