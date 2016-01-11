<footer class="footer">
	
	<div class="pull-left">
		<span>&copy 2015 dummytext.org</span>
	</div>
	<div class="pull-right">
		<a href="#">aviso legal</a>
	</div>
</footer>

	<script type="text/javascript">
	//	http://blog.themearmada.com/off-canvas-slide-menu-for-bootstrap/
	$(document).ready(function(){	

		var mapwidth = $(document).width();	
		var newheight = parseInt($('nav').css('height'))-parseInt($('.navbar').css('height'))-parseInt($('.footer').css('height'));
		var menuwidth = $('.main-menu').css('width');
		var menuclose = $('#map').css('margin-left');
		
		$('nav').css('height', newheight+'px');

		if ($('body').hasClass('nav-expanded')){
			setupMap(true);
		}
			
		//Navigation Menu Slider      
		$('#nav-expander').on('click',function(e){
			e.preventDefault();
			$('body').toggleClass('nav-expanded');
			if (!$('body').hasClass('nav-expanded')){
				$('.panel-collapse').removeClass('in');
				setupMap(false);
			}
			else{
				setupMap(true);
			}

		});

		$('.panel-accordion').on('click', function(e){
			e.preventDefault();  	
			if (!$('body').hasClass('nav-expanded')){
				$('body').toggleClass('nav-expanded');
				setupMap(true);
			}

		});
		
		function setupMap(expand){
			if (expand === true){
				ml = menuwidth;
			}
			else{
				ml = menuclose;
			}
			newmapwidth = mapwidth - parseInt(ml);
			$("#map").animate({
				marginLeft: ml,
				width : newmapwidth+'px',
				height: newheight+'px'
			}, 300, function(){
				console.log('cridem el mapa amb el nou css');
			});
		}
	});	
	</script>
</body>
</html>