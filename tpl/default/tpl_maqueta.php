<div class="navbar navbar-inverse navbar-fixed-top">      
    <!--Include your brand here-->
    <a class="navbar-brand" href="#">
	    <!--img src="tpl/<?php echo $skin; ?>/img/logo.png" alt="logo" width="32" height="31" /--> SolutionsDB
    </a>
</div>


<nav>
	<ul class="list-unstyled main-menu">
	    <!--Include your navigation here-->
	    <li class="menu-home"><a href="#" id="nav-expander"><i class="fa fa-bars"></i> <span>Mapas</span></a></li>
	    <li>
			<div class="panel-group" id="accordion-search" role="tablist" aria-multiselectable="false">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingSearch">
						<a class="panel-accordion" data-toggle="collapse" data-parent="#accordion-search" href="#collapseSearch" aria-expanded="true" aria-controls="collapseSearch"><i class="fa fa-search"></i> <span>Buscador</span></a>
					</div>
					<div id="collapseSearch" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSearch">
						<div class="panel-body">
							<form>
								<div class="form-group">
									<label for="province"><?php echo FORM_PROVINCE; ?></label>
									<select class="form-control" id="province" name="province">
										<option value="08">Barcelona</option>
									</select>
								</div>
								<div class="form-group">
									<label for="county"><?php echo FORM_COUNTY; ?></label>
									<select class="form-control" id="county" name="county">
										<option value="08">Baix Llobregat</option>
									</select>
								</div>
								<div class="form-group">
									<label for="city"><?php echo FORM_CITY; ?></label>
									<select class="form-control" id="city" name="city">
										<option value="08">Gavà</option>
									</select>
								</div>
								<div class="form-group">
									<label for="ine"><?php echo FORM_INE; ?></label>
									<p>08-0193</p>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
	    </li>
	    <li>
			<div class="panel-group" id="accordion-caption" role="tablist" aria-multiselectable="false">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingCaption">
						<a class="panel-accordion" data-toggle="collapse" data-parent="#accordion-caption" href="#collapseCaption" aria-expanded="true" aria-controls="collapseCaption"><i class="fa fa-map-marker"></i> <span>Leyenda</span></a>
					</div>
					<div id="collapseCaption" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingCaption">
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
			<div class="panel-group" id="accordion-contact" role="tablist" aria-multiselectable="false">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingContact">
						<a class="panel-accordion" data-toggle="collapse" data-parent="#accordion-contact" href="#collapseContact" aria-expanded="true" aria-controls="collapseContact"><i class="fa fa-envelope"></i> <span>Contacto</span></a>
					</div>
					<div id="collapseContact" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingContact">
						<div class="panel-body">
							<address>
								<span>Nombre y Apellidos</span><br />
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