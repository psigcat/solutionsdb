<div class="navbar navbar-inverse navbar-fixed-top">      
    <!--Include your brand here-->
    <a class="navbar-brand" href="#">Off Canvas Menu</a>
</div>


<nav>
	<ul class="list-unstyled main-menu">
	    <!--Include your navigation here-->
	    <li class="menu-home"><a href="#" id="nav-expander"><i class="fa fa-bars"></i> <span>Mapas</span></a></li>
	    <li><a href="#"><i class="fa fa-search"></i> <span>Buscador</span></a></li>

	    <li>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<a class="panel-accordion" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-map-marker"></i> <span>Leyenda</span></a>
					</div>
					<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="panel-body">
Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
						</div>
					</div>
				</div>
			</div>
	    </li>
	    <li><a href="#"><i class="fa fa-list"></i> <span>Herramientas</span></a></li>
	    <li><a href="#"><i class="fa fa-cog"></i> <span>Configuración</span></a></li>
	    <li>
			<div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="false">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo">
						<a class="panel-accordion" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"><i class="fa fa-envelope"></i> <span>Contacto</span></a>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div class="panel-body">
							<address>
								<strong>Nombre y Apellidos</strong><br />
								<a href="mailto:#">first.last@example.com</a><br />
								<span>+34 600 000 000</span>
							</address>
							<form>
								<div class="form-group">
									<label for="name"><?php echo FORM_NAME; ?></label>
									<input type="text" class="form-control" id="name" name="name">
								</div>
								<div class="form-group">
									<label for="email"><?php echo FORM_EMAIL; ?></label>
									<input type="email" class="form-control" id="email" name="email">
								</div>
								<div class="form-group">
									<label for="subject"><?php echo FORM_SUBJECT; ?></label>
									<input type="text" class="form-control" id="subject" name="subject">
								</div>
								<div class="form-group">
									<label for="message"><?php echo FORM_MESSAGE; ?></label>
									<textarea class="form-control" id="message" name="message"></textarea>
								</div>
								<button type="submit" class="btn btn-default"><?php echo FORM_SEND; ?></button>
							</form>
						</div>
					</div>
				</div>
			</div>	    
	    
	    
		</li>
	</ul>
</nav>