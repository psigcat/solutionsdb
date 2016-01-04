<footer>
	
</footer>

	<script type="text/javascript">
	//	http://blog.themearmada.com/off-canvas-slide-menu-for-bootstrap/
	$(document).ready(function(){												
		//Navigation Menu Slider      
		$('#nav-expander').on('click',function(e){
			e.preventDefault();
			$('body').toggleClass('nav-expanded');
			if (!$('body').hasClass('nav-expanded')){
				$('.panel-collapse').removeClass('in');
			}
		});

		$('.panel-accordion').on('click', function(e){
			e.preventDefault();  	
			if (!$('body').hasClass('nav-expanded')){
				$('body').toggleClass('nav-expanded');
			}
		});
	});	
	</script>
</body>
</html>