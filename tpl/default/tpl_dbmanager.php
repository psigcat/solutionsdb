<div id="angularAppContainer" ng-app="app" ng-controller="mainController as mc" ng-init="initApp('<?php echo $baseHref; ?>','<?php echo $urlWMS; ?>','<?php echo $env; ?>','<?php echo $token; ?>','<?php echo $update; ?>')">
	<div class="navbar navbar-inverse navbar-fixed-top " >      
	    <!--Include your brand here-->
	    <a class="navbar-brand" href="<?php echo $baseHref?>home.php"> SolutionsDB </a>
	    
	    <div class="pull-right panel-alerts ng-cloak" ng-cloak>
		    <a href="#" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<i class="fa fa-2x" ng-class="{'fa-exclamation-triangle': alertCount > 0}"></i> <span class="badge warn">{{alertCount}}</span>
			</a>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li ng-repeat="item in alerts track by $index"><a href="#" ng-click="townSelected(item.name)">{{item.name}}</a></li>
			</ul>
	    </div>
	</div>
	
	<div>
	
		<nav>
			<ul class="list-unstyled main-menu">
			    <!--Include your navigation here-->
			    <li class="menu-home "><a href="#" id="nav-expander"><i class="fa fa-bars"></i> <span><?php echo MENU_MENU; ?></span></a></li>
			    
			    <?php if ($isMobile == 1){ ?>
			    <!-- Menu Item SEARCH -->
			    <li>
				    <div class="panel-group" id="accordion-search-mb" role="tablist" aria-multiselectable="false">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingSearch-mb">
								<a class="panel-accordion" data-toggle="collapse" data-parent="#accordion-search-mb" href="#collapseSearch-mb" aria-expanded="true" aria-controls="collapseSearch-mb" ng-click="searchClick()"><i class="fa fa-search"></i> <span><?php echo MENU_SEARCHER; ?></span></a>
							</div>
							
							<div id="collapseSearch-mb" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSearch-mb">
								<div class="panel-body">
									<form>
										<label for="city"><?php echo FORM_CITY; ?></label>
										<input 
											type="text" 
											ng-model="asyncSelected" 
											typeahead-min-length="3" 
											placeholder="" 
											uib-typeahead="name for name in getTownsFromName($viewValue)" 
											typeahead-on-select="townSelected($item, $model, $label)"
											typeahead-loading="loadingLocations" 
											typeahead-no-results="noResults" 
											class="form-control">
											<i ng-show="loadingLocations" class="glyphicon glyphicon-refresh"></i>
											<div ng-show="noResults">
												<i class="glyphicon glyphicon-remove"></i> <?php echo NO_RESULTS; ?>
											</div>									
									</form>
								</div>
							</div>
						</div>
					</div>
			    </li>
			    
			    <!-- END SEARCH -->
			    <!-- Menu Item CAPTION -->
			    
			    <li>	
					<div class="panel-group ng-cloak" id="accordion-caption-mb" role="tablist" aria-multiselectable="false" ng-cloak>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingCaption-mb">
								<a class="panel-accordion " data-toggle="collapse" data-parent="#accordion-caption-mb" href="#collapseCaption-mb" aria-expanded="true" aria-controls="collapseCaption-mb"><i class="fa fa-map"></i> <span><?php echo MENU_LEGEND; ?></span></a>
							</div>
							<div id="collapseCaption-mb" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingCaption-mb">
								<div class="panel-body">
									<img ng-src="{{legendUrl}}">
								</div>
							</div>
						</div>
					</div>
			    </li>
	
			    <!-- END CAPTION -->
			    <?php } ?>
			    
			    <!-- Menu Item INFO -->
			    <li>
			    	<div class="panel-group" id="accordion-info" role="tablist" aria-multiselectable="false">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingInfo">
								<a class="panel-accordion" data-toggle="collapse" data-parent="#accordion-info" href="#collapsesInfo"  aria-expanded="true" aria-controls="collapsesInfo"><i class="fa fa-info"></i> <span><?php echo MENU_INFORMATION; ?></span></a>
							</div>
							<div id="collapsesInfo" class="panel-collapse collapse collapseInfo" role="tabpanel" aria-labelledby="headingInfo">
								<div class="panel-body">
									<div ng-show="display_info">
										<div class="form-group">
											<p><b><?php echo TOWN_DATA; ?></b></p>
											<label for="ine"><?php echo TOWN; ?></label>
											<p class="ng-cloak" ng-cloak><b>{{town_name}}</b></p>
										</div>
										<div class="form-group">
											<label for="ine"><?php echo PROVINCE; ?></label>
											<p class="ng-cloak" ng-cloak><b>{{town_province}}</b></p>
										</div>
										<div class="form-group">
											<label for="ine"><?php echo SURFACE; ?></label>
											<p class="ng-cloak" ng-cloak><b>{{town_surface}}</b></p>
										</div>
										<div class="form-group">
											<label for="ine"><?php echo POPULATION; ?></label>
											<p class="ng-cloak" ng-cloak><b>{{town_population}}</b></p>
										</div>

										<!-- Button trigger modal -->
										 <?php if ($isMobile == 1){ ?>
										 <button type="button" class="btn btn-default mobile-trigger" target="#formInfoContainer" source="#formInfo"><?php echo SHOW_FORM; ?></button>
										 <div id="formInfoContainer" display="none">
										 </div>
										 <?php } else{ ?>
										 
										 <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modalInfo" ng-click="collapseMenu()"><?php echo SHOW_FORM; ?></button>
										 <?php } ?>
									</div>
									
								</div>
							</div>
						</div>
					</div> 
				
			    </li>
			    
			    <!-- END INFO -->
			    <!-- Menu Item SETUP -->
			    
			    <li>
					<div class="panel-group" id="accordion-report" role="tablist" aria-multiselectable="false">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingConfig">
								<a class="panel-accordion" data-toggle="collapse" data-parent="#accordion-config" href="#collapseConfig" aria-expanded="true" aria-controls="collapseConfig"><i class="fa fa-cog"></i> <span><?php echo MENU_CONFIGURATION; ?></span></a>
							</div>
							<div id="collapseConfig" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingConfig">
								<div class="panel-body">
									<form>
										<label for="province"><?php echo SEE; ?></label>
										<div class="form-group">
											<label>
										    	<input type="radio" name="activeLayer" value="manager_grup" ng-model="activeLayer" ng-change="changeActiveLayer()" checked>
												<?php echo SEE_DRINK_WATER_PROVIDER; ?>
											</label>
											<label>
										    	<input type="radio" name="activeLayer" value="dbmanager_sane" ng-model="activeLayer" ng-change="changeActiveLayer()">
												<?php echo SEE_SANITY_WATER_PROVIDER; ?>
											</label>
										</div>
										<label for="province"><?php echo BACKGROUND_MAP; ?></label>
										<div class="form-group">
											<label>
										    	<input type="radio" name="backgroundmap" id="backgroundmap_1" value="1" ng-model="backgroundmap" ng-change="changeBackgroundMap()" checked>
												<?php echo BACKGROUND_MAP_1; ?>
											</label>
											<label>
										    	<input type="radio" name="backgroundmap" id="backgroundmap_2" value="2" ng-model="backgroundmap" ng-change="changeBackgroundMap()">
												<?php echo BACKGROUND_MAP_2; ?>
											</label>
										</div>
										<div class="form-group">
										<label for="alarm_drink_water"><?php echo ALARM_TIME; ?> - <?php echo DRINK_WATER; ?></label>
										<select class="form-control" ng-model="period_alarm_drink_water" ng-change="peridoAlertDrinkWaterChanged()" >
											<option value="6" ><?php echo SIX_MONTHS; ?></option>
											<option value="10"><?php echo TEN_MONTHS; ?></option>
											<option value="12"><?php echo TWELVE_MONTHS; ?></option>
										</select>
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</li>
	
	
			    <!-- END SETUP -->
			    <!-- Menu Item REPORT -->
			    
			    <li>
			    	
			    <?php if ($isMobile == 1){ ?>
					<div class="panel-group ng-cloak" id="accordion-report-mb" role="tablist" aria-multiselectable="false" ng-cloak>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingReport-mb">
								<a class="panel-accordion mobile-trigger" target="#formReportContainer" source="#formReport" data-toggle="collapse" data-parent="#accordion-report-mb" href="#collapseReport-mb" aria-expanded="true" aria-controls="collapseReport-mb"><i class="fa fa-file-text-o"></i> <span><?php echo MENU_REPORT; ?></span></a>
							</div>
							<div id="collapseReport-mb" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingReport-mb">
								<div class="panel-body" id="formReportContainer">
								</div>
							</div>
						</div>
					</div>
					
					<?php } else{ ?>
					<a href="#" data-toggle="modal" data-target="#modalReport" ng-click="collapseMenu()"><i class="fa fa-file-text-o"></i> <span><?php echo MENU_REPORT; ?></span></a>
					<?php } ?>
	 
				</li>
				
			    <!-- END REPORT -->
	
			</ul>
		</nav>
		
		<div>
			<div id="map"><div id="info" class="ng-cloak" ng-cloak>{{toolTip.title}}<br><small>{{toolTip.suministrador}}</small></div></div>
			
			<?php if ($isMobile == 0){ ?>	
			<div class="panel-group" id="accordion-search" role="tablist" aria-multiselectable="false">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingSearch">
						<a class="panel-accordion" data-toggle="collapse" data-parent="#accordion-search" href="#collapseSearch" aria-expanded="true" aria-controls="collapseSearch" ng-click="searchClick()"><i class="fa fa-search"></i> <span><?php echo MENU_SEARCHER; ?></span></a>
					</div>
					
					<div id="collapseSearch" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSearch">
						<div class="panel-body">
							<form>
								<label for="city"><?php echo FORM_CITY; ?></label>
								<input 
									type="text" 
									ng-model="asyncSelected" 
									typeahead-min-length="3" 
									placeholder="" 
									uib-typeahead="name for name in getTownsFromName($viewValue)" 
									typeahead-on-select="townSelected($item, $model, $label)"
									typeahead-loading="loadingLocations" 
									typeahead-no-results="noResults" 
									class="form-control">
									<i ng-show="loadingLocations" class="glyphicon glyphicon-refresh"></i>
									<div ng-show="noResults">
										<i class="glyphicon glyphicon-remove"></i> <?php echo NO_RESULTS; ?>
									</div>									
							</form>
						</div>
					</div>
				</div>
			</div>
			
			<div class="panel-group ng-cloak" id="accordion-caption" role="tablist" aria-multiselectable="false" ng-cloak>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingCaption">
						<a class="panel-accordion " data-toggle="collapse" data-parent="#accordion-caption" href="#collapseCaption" aria-expanded="true" aria-controls="collapseCaption"><i class="fa fa-map"></i> <span><?php echo MENU_LEGEND; ?></span></a>
					</div>
					<div id="collapseCaption" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCaption">
						<div class="panel-body">
							<img ng-src="{{legendUrl}}">
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	

										
	<!-- Modal Information -->
	<div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><?php echo TOWN_DATA; ?></h4>
				</div>

				<div class="modal-body">
					<form id="formInfo">
						<fieldset>
							<legend><?php echo BASIC_DATA; ?></legend>
							<div class="row">
								<div class="col-xs-6 col-sm-3">
									<div class="form-group">
										<label for="town"><?php echo TOWN; ?></label>
										<input name="town" id="town" type="text" class="form-control ng-cloak" ng-cloak value="{{town_name}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-3">
									<div class="form-group">
										<label for="province"><?php echo PROVINCE; ?></label>
										<input name="province" id="province" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-3">
									<div class="form-group">
										<label for="surface"><?php echo SURFACE; ?></label>
										<input name="surface" id="surface" type="text" class="form-control ng-cloak" ng-cloak value="{{town_surface}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-3">
									<div class="form-group">
										<label for="population"><?php echo POPULATION; ?></label>
										<input name="population" id="population" type="text" class="form-control ng-cloak" ng-cloak value="{{town_population}}">
									</div>
								</div>
							</div>
						</fieldset>
					
						<fieldset>
							<legend><?php echo COMERCIAL_DATA; ?></legend>
							<div class="row">
								<div class="col-sm-12 col-md-4">
									<div class="form-group">
										<label for="edit_town_water_provider"><?php echo WATER_PROVIDER; ?></label>
										<input type="text" class="form-control" id="edit_town_water_provider" name="edit_town_water_provider" ng-model="edit_town_water_provider">
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="form-group">
										<label for="message"><?php echo CONTRACT_INIT; ?>:</label>
										<!--Datepicker-->
										<div class="input-group">
											<input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="edit_town_w_contract_init" is-open="dp_w_contract_init.opened"  ng-required="true" alt-input-formats="altInputFormats" show-button-bar="false" />
											<span class="input-group-btn">
												<button type="button" class="btn btn-default" ng-click="dp_w_contract_init_open()"><i class="glyphicon glyphicon-calendar"></i></button>
											</span>
	            						</div>
										<!-- end Datepicker-->
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="form-group">
										<label for="message"><?php echo CONTRACT_END; ?></label>																		<!--Datepicker-->
										<div class="input-group">
											<input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="edit_town_w_contract_end" is-open="dp_w_contract_end.opened"  ng-required="true" alt-input-formats="altInputFormats" show-button-bar="false" />
											<span class="input-group-btn">
												<button type="button" class="btn btn-default" ng-click="dp_w_contract_end_open()"><i class="glyphicon glyphicon-calendar"></i></button>
											</span>
	            						</div>
										<!-- end Datepicker-->
									</div>
								</div>
								<div class="col-sm-12 col-md-4">	
									<div class="form-group">
										<label for="edit_town_sanity_provider"><?php echo SANITY_PROVIDER; ?></label>
										<input type="text" class="form-control" id="edit_town_sanity_provider" name="edit_town_sanity_provider" ng-model="edit_town_sanity_provider">
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="form-group">
										<label for="message"><?php echo CONTRACT_INIT; ?></label>																		<!--Datepicker-->
										<div class="input-group">
											<input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="edit_town_s_contract_init" is-open="dp_s_contract_init.opened"  ng-required="true" alt-input-formats="altInputFormats" show-button-bar="false" />
											<span class="input-group-btn">
												<button type="button" class="btn btn-default" ng-click="dp_s_contract_init_open()"><i class="glyphicon glyphicon-calendar"></i></button>
											</span>
	            						</div>
	            						<!-- end Datepicker-->
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="form-group">
										<label for="message"><?php echo CONTRACT_END; ?></label>
										<!--Datepicker-->
										<div class="input-group">
											<input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="edit_town_s_contract_end" is-open="dp_s_contract_end.opened"  ng-required="true" alt-input-formats="altInputFormats" show-button-bar="false" />
											<span class="input-group-btn">
												<button type="button" class="btn btn-default" ng-click="dp_s_contract_end_open()"><i class="glyphicon glyphicon-calendar"></i></button>
											</span>
	            						</div>
										<!-- end Datepicker-->
									</div>
								</div>
								
								<div class="col-sm-4 col-md-3">
									<div class="form-group">
										<label for="dummy">Próximo concurso</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								<div class="col-sm-4 col-md-3">
									<div class="form-group">
										<label for="dummy">Próxima prórroga</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								<div class="col-sm-4 col-md-3">
									<div class="form-group">
										<label for="dummy">Futuras prórrogas</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>	
								</div>
								<div class="col-sm-12 col-md-3">
									<div class="form-group">
										<label for="subject"><?php echo GOVERN; ?></label>
										<input type="text" class="form-control" id="edit_town_govern" name="edit_town_govern" ng-model="edit_town_govern">
									</div>
								</div>
								
								<div class="col-xs-12">
									<p class="lead">Cifras de negocio</p>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2016</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_name}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2017</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2018</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_surface}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">Resto</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_population}}">
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">Cartera Próxima Prórroga</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_name}}">
									</div>
								</div>
								
								<div class="col-xs-12">
									<p class="lead">Inversión Necesaria</p>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2016</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_name}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2017</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2018</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_surface}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">Resto</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_population}}">
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">Total</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_name}}">
									</div>
								</div>
								
								<div class="col-sm-12">
									<div class="form-group">
										<label for="dummy"><?php echo OBSERVATIONS; ?></label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								
							</div>
						</fieldset>
					</form>
					
				</div>

				<div class="modal-footer">
					<div class="pull-left">
						<button type="button" class="btn btn-default" ng-click="updateInfo()"><?php echo FORM_SEND; ?></button>
						<button type="button" class="btn btn-default" ng-click="cancel_editForm()"><?php echo FORM_CANCEL; ?></button>
					</div>

					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	
	
	<!-- Modal Report -->
	<div class="modal fade" id="modalReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel"><?php echo MENU_REPORT; ?></h4>
				</div>

				<div class="modal-body">
					<form id="formReport">
						<fieldset>
							<legend><?php echo BASIC_DATA; ?></legend>
							<div class="row">
								<div class="col-xs-6 col-sm-3">
									<div class="form-group">
										<label for="town"><?php echo TOWN; ?></label>
										<input name="town" id="town" type="text" class="form-control ng-cloak" ng-cloak value="{{town_name}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-3">
									<div class="form-group">
										<label for="province"><?php echo PROVINCE; ?></label>
										<input name="province" id="province" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-3">
									<div class="form-group">
										<label for="surface"><?php echo SURFACE; ?></label>
										<input name="surface" id="surface" type="text" class="form-control ng-cloak" ng-cloak value="{{town_surface}}">
									</div>
								</div>
								<div class="col-xs-6 col-sm-3">
									<div class="form-group">
										<label for="population"><?php echo POPULATION; ?></label>
										<input name="population" id="population" type="text" class="form-control ng-cloak" ng-cloak value="{{town_population}}">
									</div>
								</div>
							</div>
						</fieldset>
					
						<fieldset>
							<legend><?php echo COMERCIAL_DATA; ?></legend>
							<div class="row">
								<div class="col-sm-12 col-md-4">
									<div class="form-group">
										<label for="edit_town_water_provider"><?php echo WATER_PROVIDER; ?></label>
										<input type="text" class="form-control" id="edit_town_water_provider" name="edit_town_water_provider" ng-model="edit_town_water_provider">
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="form-group">
										<label for="message"><?php echo CONTRACT_INIT; ?>:</label>
										<!--Datepicker-->
										<div class="input-group">
											<input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="edit_town_w_contract_init" is-open="dp_w_contract_init.opened"  ng-required="true" alt-input-formats="altInputFormats" show-button-bar="false" />
											<span class="input-group-btn">
												<button type="button" class="btn btn-default" ng-click="dp_w_contract_init_open()"><i class="glyphicon glyphicon-calendar"></i></button>
											</span>
	            						</div>
										<!-- end Datepicker-->
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="form-group">
										<label for="message"><?php echo CONTRACT_END; ?></label>																		<!--Datepicker-->
										<div class="input-group">
											<input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="edit_town_w_contract_end" is-open="dp_w_contract_end.opened"  ng-required="true" alt-input-formats="altInputFormats" show-button-bar="false" />
											<span class="input-group-btn">
												<button type="button" class="btn btn-default" ng-click="dp_w_contract_end_open()"><i class="glyphicon glyphicon-calendar"></i></button>
											</span>
	            						</div>
										<!-- end Datepicker-->
									</div>
								</div>
								<div class="col-sm-12 col-md-4">	
									<div class="form-group">
										<label for="edit_town_sanity_provider"><?php echo SANITY_PROVIDER; ?></label>
										<input type="text" class="form-control" id="edit_town_sanity_provider" name="edit_town_sanity_provider" ng-model="edit_town_sanity_provider">
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="form-group">
										<label for="message"><?php echo CONTRACT_INIT; ?></label>																		<!--Datepicker-->
										<div class="input-group">
											<input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="edit_town_s_contract_init" is-open="dp_s_contract_init.opened"  ng-required="true" alt-input-formats="altInputFormats" show-button-bar="false" />
											<span class="input-group-btn">
												<button type="button" class="btn btn-default" ng-click="dp_s_contract_init_open()"><i class="glyphicon glyphicon-calendar"></i></button>
											</span>
	            						</div>
	            						<!-- end Datepicker-->
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="form-group">
										<label for="message"><?php echo CONTRACT_END; ?></label>
										<!--Datepicker-->
										<div class="input-group">
											<input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="edit_town_s_contract_end" is-open="dp_s_contract_end.opened"  ng-required="true" alt-input-formats="altInputFormats" show-button-bar="false" />
											<span class="input-group-btn">
												<button type="button" class="btn btn-default" ng-click="dp_s_contract_end_open()"><i class="glyphicon glyphicon-calendar"></i></button>
											</span>
	            						</div>
										<!-- end Datepicker-->
									</div>
								</div>
								
								<div class="col-sm-4 col-md-3">
									<div class="form-group">
										<label for="dummy">Próximo concurso</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								<div class="col-sm-4 col-md-3">
									<div class="form-group">
										<label for="dummy">Próxima prórroga</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								<div class="col-sm-4 col-md-3">
									<div class="form-group">
										<label for="dummy">Futuras prórrogas</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>	
								</div>
								<div class="col-sm-4 col-md-3">
									<div class="form-group">
										<label for="dummy">Cartera Próxima Prórroga</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_name}}">
									</div>
								</div>
								
								<div class="col-xs-12">
									<p class="lead">Cifras de negocio</p>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2016</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_name}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2017</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2018</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_surface}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">Resto</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_population}}">
									</div>
								</div>

								
								<div class="col-xs-12">
									<p class="lead">Inversión Necesaria</p>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2016</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_name}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2017</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_province}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">2018</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_surface}}">
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">Resto</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_population}}">
									</div>
								</div>
								
								<div class="col-sm-3">
									<div class="form-group">
										<label for="dummy">Total</label>
										<input name="dummy" id="dummy" type="text" class="form-control ng-cloak" ng-cloak value="{{town_name}}">
									</div>
								</div>
								
								
							</div>
						</fieldset>
					</form>
					
				</div>

				<div class="modal-footer">
					<div class="pull-left">
						<button type="button" class="btn btn-default">Exportar</button>
					</div>

					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
	  
	  
	<!-- Open layers -->
	<script src="http://openlayers.org/en/v3.12.1/build/ol.js"></script> 
    <link rel="stylesheet" href="http://openlayers.org/en/master/css/ol.css" />
    <!--<script src="http://cdnjs.cloudflare.com/ajax/libs/proj4js/2.2.1/proj4.js" type="text/javascript"></script>-->
    <!-- End Open layers -->
    
    <!-- angular-bootstrap-ui -->
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular-animate.js"></script>
	<link rel="stylesheet" href="js/libs/angular-bootstrap-ui/ui-bootstrap-custom-1.1.0-csp.css" />
    <script src="js/libs/angular-bootstrap-ui/ui-bootstrap-custom-1.1.0.min.js"></script> 
    <script src="js/libs/angular-bootstrap-ui/ui-bootstrap-custom-tpls-1.1.0.min.js"></script> 
    <script src="js/libs/angular-bootstrap-ui/angular-locale_es.es.js"></script> 
 <!--   <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-1.1.0.js"></script>-->
    <!-- end angular-bootstrap-ui -->
    <!-- Application -->
	
	<script src="js/app_dbmanager/app.js"></script>
	<script src="js/app_dbmanager/MainController.js"></script>
	<script src="js/app_dbmanager/mapService.js"></script>
	<script src="js/common/placesService.js"></script>
	<script src="js/common/alertsService.js"></script>
	<script src="js/common/responsiveService.js"></script>

	<script src="js/common/loggerService.js"></script>
	
	<script type="text/javascript">

	</script>
</div>
