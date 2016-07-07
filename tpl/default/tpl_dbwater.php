<!DOCTYPE html>
<html>
	<head>
		<title>DBWater</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
		<link rel="stylesheet" href="tpl/default/css/dbwater.css" type="text/css" charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8" />
	</head>
	<body>
    	
        <div id="angularAppContainer" ng-app="app" ng-controller="mainController as mc" ng-init="initApp('<?php echo $baseHref; ?>','<?php echo $urlWMS; ?>','<?php echo $env; ?>','<?php echo $token; ?>','<?php echo $isMobile; ?>')">
            
            <div class="window main">
                <div class="content">
                    <ul id="menu" class="list-unstyled list-inline">
                        <li><a href="<?php echo $baseHref?>home.php"><img src="tpl/default/img/dbwater/logo.jpg" class="hidden-xs" /><img src="tpl/default/img/dbwater/logo-xs.jpg" class="visible-xs" /></a></li>
                        <li><div class="vertical-line"></div></li>
                        <li><a href="#" class="expedient"><img src="tpl/default/img/dbwater/ic-expedient.jpg" /></a></li>
                        <li><a href="#" class=""><img src="tpl/default/img/dbwater/ic-graphic.jpg" /></a></li>
                        <li><a href="#" class="layers"><img src="tpl/default/img/dbwater/ic-layers.jpg" /></a></li>
                        <li><a href="#" class=""><img src="tpl/default/img/dbwater/ic-config.jpg" /></a></li>
                        <li><a href="#" class=""><img src="tpl/default/img/dbwater/ic-danger.jpg" /></a></li>
                        <li><a href="#" class="search"><img src="tpl/default/img/dbwater/ic-search.jpg" /></a></li>
                    </ul>
                </div>
            </div>

            <div class="window right-side">
                <h2>Sector 43</h2>
                <div class="content">
                    <h3>Rendimiento teórico</h3>
                    <div class="row list-of-donuts">
                        <div class="col-xs-4" align="center">
                            <img src="http://placehold.it/60x60" />
                            <p class="title">Día</p>
                        </div>
                        <div class="col-xs-4" align="center">
                            <img src="http://placehold.it/60x60" />
                            <p class="title">Semana</p>
                        </div>
                        <div class="col-xs-4" align="center">
                            <img src="http://placehold.it/60x60" />
                            <p class="title">Mes</p>
                        </div>
                    </div>
                    <h3>Tendéncia últimos 7 días</h3>
                    <img src="http://placehold.it/215x90" class="full-width" />
                    <h3>Información</h3>
                    <div class="list-with-icon">
                        <div class="icon-container">
                            <img src="tpl/default/img/dbwater/ic-water.jpg" class="icon" />
                        </div>
                        <ul class="list-unstyled list-left-bordered">
                            <li>Volumen suministrado <span class="pull-right custom-badge">324</span></li>
                            <li>Caudal mínimo <span class="pull-right custom-badge">324</span></li>
                            <li>Volumen caudal medio total <span class="pull-right custom-badge">324</span></li>
                            <li>Volumen de pérdida diaria <span class="pull-right custom-badge">324</span></li>
                        </ul>
                    </div>
                    <h3>Consumos mínimos nocturnos</h3>
                    <img src="http://placehold.it/215x90" class="full-width" />
                    <h3>Información real</h3>
                    <div class="list-with-donut">
                        <div class="icon-container">
                            <img src="http://placehold.it/110x55" class="donut" />
                        </div>
                        <ul class="list-unstyled list-left-bordered">
                            <li>Mensual <span class="pull-right custom-badge">12,1%</span></li>
                            <li>Interanual <span class="pull-right custom-badge">12,1%</span></li>
                            <li>Totalizador <span class="pull-right custom-badge">12345</span></li>
                        </ul>
                    </div>
                    <hr />
                    <a href="#" class="btn btn-sm btn-primary open-expedient">Ficha</a> Ver ficha completa
                </div>
            </div>
            
            <div class="window search">
                <form>
                    <label>Municipio</label>
                    <input type="text" value="Mol" class="form-control">
                </form>
                <ul class="list-unstyled">
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                    <li><a href="#">Alcocero de <strong>Mol</strong>a</a></li>
                </ul>
            </div>
            
            <div class="window layers">
                <h2>
                    <img src="tpl/default/img/dbwater/ic-layers-20.jpg" class="ic" />
                    Gestor de capas
                    <a href="#" class="pull-right"><i class="fa fa-fw fa-times"></i></a>
                </h2>
                <div class="content">
                    <h3>Capas temáticas</h3>
                    <ul class="list-unstyled layers">
                        <li class="open">
                            <a href="#">
                                <i class="fa fa-lg fa-fw fa-caret-down"></i>
                                <i class="fa fa-lg fa-fw fa-caret-right"></i>
                            </a>
                            <input type="checkbox" />  Barcelona
                            <ul class="list-unstyled">
                                <li class="open">
                                    <a href="#">
                                        <i class="fa fa-lg fa-fw fa-caret-down"></i>
                                        <i class="fa fa-lg fa-fw fa-caret-right"></i>
                                    </a>
                                    <input type="checkbox" /> Molins de rey
                                    <ul class="list-unstyled">
                                        <li><input type="checkbox" /> Sensores</li>
                                        <li><input type="checkbox" /> Depósito</li>
                                        <li><input type="checkbox" /> Red de agua</li>
                                    </ul>
                                </li>
                                <li class="open">
                                    <a href="#">
                                        <i class="fa fa-lg fa-fw fa-caret-down"></i>
                                        <i class="fa fa-lg fa-fw fa-caret-right"></i>
                                    </a>
                                    <input type="checkbox" /> Tordera
                                    <ul class="list-unstyled">
                                        <li><input type="checkbox" /> Sensores</li>
                                        <li><input type="checkbox" /> Depósito</li>
                                        <li><input type="checkbox" /> Red de agua</li>
                                    </ul>
                                </li>
                                <li class="closed">
                                    <a href="#">
                                        <i class="fa fa-lg fa-fw fa-caret-down"></i>
                                        <i class="fa fa-lg fa-fw fa-caret-right"></i>
                                    </a>
                                    <input type="checkbox" /> Sant Fost de Capmcentelles
                                    <ul class="list-unstyled">
                                        <li><input type="checkbox" /> Sensores</li>
                                        <li><input type="checkbox" /> Depósito</li>
                                        <li><input type="checkbox" /> Red de agua</li>
                                    </ul>
                                </li>
                                <li class="closed">
                                    <a href="#">
                                        <i class="fa fa-lg fa-fw fa-caret-down"></i>
                                        <i class="fa fa-lg fa-fw fa-caret-right"></i>
                                    </a>
                                    <input type="checkbox" /> Sant Andreu de la Barca
                                    <ul class="list-unstyled">
                                        <li><input type="checkbox" /> Sensores</li>
                                        <li><input type="checkbox" /> Depósito</li>
                                        <li><input type="checkbox" /> Red de agua</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    
                    <h3>Capas de referéncia</h3>
                    <ul class="list-unstyled">
                        <li><input type="radio" name="reference" checked /> Open Street Map</li>
                        <li><input type="radio" name="reference" /> Open Street Map, estilo Positron (by cartoDb)</li>
                        <li><input type="radio" name="reference" /> Open Street Map, estilo Dark Matter (by cartoDb)</li>
                        <li><input type="radio" name="reference" /> PNOA</li>
                    </ul>
                </div>
            </div>
            
            <div class="window expedient">
                <h2>
                    Ficha de sector 43
                    <a href="#" class="pull-right"><i class="fa fa-fw fa-times"></i></a>
                </h2>
                <div class="content">
                    <div class="row">
                        <div class="col-xs-9">
                            <div class="row">
                                <div class="col-xs-4">
                                    <ul class="list-unstyled list-expedient-location">
                                        <li><strong>Provincia: </strong> Barcelona</li>
                                        <li><strong>Municipio: </strong> Molins de Rei</li>
                                    </ul>
                                </div>
                                <div class="col-xs-4">
                                    <ul class="list-unstyled list-expedient-sumatory">
                                        <li><img src="tpl/default/img/dbwater/ic-people.jpg" /> Número de clientes <span class="custom-badge pull-right">3200</span></li>
                                        <li><img src="tpl/default/img/dbwater/ic-pipe.jpg" /> Kilómetros de red <span class="custom-badge pull-right">6700</span></li>
                                    </ul>
                                </div>
                                <div class="col-xs-4">
                                    <h3>Información real</h3>
                                    <div class="list-with-donut">
                                        <div class="icon-container">
                                            <img src="http://placehold.it/110x55" class="donut" />
                                        </div>
                                        <ul class="list-unstyled list-left-bordered">
                                            <li>Mensual <span class="pull-right custom-badge">12,1%</span></li>
                                            <li>Interanual <span class="pull-right custom-badge">12,1%</span></li>
                                            <li>Totalizador <span class="pull-right custom-badge">12345</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="spacer-20"></div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#mensual" data-toggle="tab">Mensual</a></li>
                                <li><a href="#anual" data-toggle="tab">Anual</a></li>
                                <li><a href="#xxx1" data-toggle="tab">Xxxxxxx</a></li>
                                <li><a href="#xxx2" data-toggle="tab">Xxxxxxx</a></li>
                                <li><a href="#xxx3" data-toggle="tab">Xxxxxxx</a></li>
                            </ul>
                            
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="mensual">
                                    <div class="row">
                                        <div class="col-xs-4" align="center">
                                            <div class="table-list">
                                                <h4>Volumen suministrado</h4>
                                                <ul class="list-unstyled">
                                                    <?php for($i=0; $i<12; $i++): ?>
                                                    <li><?php echo date('F Y', strtotime("+".$i." month", time())); ?> <span class="custom-badge pull-right"><?php echo rand(100, 50); ?></span></li>
                                                    <?php endfor; ?>
                                                    <li class="shoe">Total <span class="custom-badge pull-right"><?php echo rand(100, 50); ?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-xs-4" align="center">
                                            <div class="table-list">
                                                <h4>Volumen registrado</h4>
                                                <ul class="list-unstyled">
                                                    <?php for($i=0; $i<12; $i++): ?>
                                                    <li><?php echo date('F Y', strtotime("+".$i." month", time())); ?> <span class="custom-badge pull-right"><?php echo rand(100, 50); ?></span></li>
                                                    <?php endfor; ?>
                                                    <li class="shoe">Total <span class="custom-badge pull-right"><?php echo rand(100, 50); ?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-xs-4" align="center">
                                            <div class="table-list">
                                                <h4>Volumen pérdidas</h4>
                                                <ul class="list-unstyled">
                                                    <?php for($i=0; $i<12; $i++): ?>
                                                    <li><?php echo date('F Y', strtotime("+".$i." month", time())); ?> <span class="custom-badge pull-right"><?php echo rand(100, 50); ?></span></li>
                                                    <?php endfor; ?>
                                                    <li class="shoe">Total <span class="custom-badge pull-right"><?php echo rand(100, 50); ?></span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="anual">Anual</div>
                                <div role="tabpanel" class="tab-pane" id="xxx1">xxx1</div>
                                <div role="tabpanel" class="tab-pane" id="xxx2">xxx2</div>
                                <div role="tabpanel" class="tab-pane" id="xxx3">xxx3</div>
                            </div>
                            
                            <div class="spacer-20"></div>
                            
                            <img src="http://placehold.it/690x230" class="img-responsive center-block" />
                        </div>
                        <div class="col-xs-3">
                            <img src="http://placehold.it/225x125" class="full-width" />
                            <hr />
                            <div class="alarms-number">
                                <span class="text">Número de alarmas</span>
                                <div class="ico">
                                    <span class="number">3</span>
                                    <i class="fa fa-fw fa-exclamation-triangle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        	<div id="map"><!-- map container --></div>
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

        <script>
            $(window).ready(function(){
                
                // z-index of each window is incremented when is open,
                // in order to let the last window be ever visible.
                
                var lastZIndex = 1;
                
                // Gutter is the standard separator space (15 is the Bootstrap default)
                // Is used around the layout
                
                var gutter = 15;

                // Tabs system (uses Bootstrap script)
                // Used in expedient window
                
                $('.nav.nav-tabs a').click(function (e) {
                    e.preventDefault()
                    $(this).tab('show')
                });
                
                // Adjust the right window.
                // Used when window is loaded and resized.
                
                function adjustBaseWindows(){
                    var width = $(window).width();
                    var height = $(window).height();
                    $(".window.right-side").css("max-height", height-(gutter*2));
                }

                adjustBaseWindows();
                                
                $(window).resize(function(){
                    adjustBaseWindows();
                });
                
                // Adjust the search window position.
                // Used when the window is opened.
                
                function setSearchWindowPosition(){
                    var mainWindowPosition  = $(".window.main").position();
                    var mainWindowWidth     = $(".window.main").outerWidth();
                    var mainWindowHeight    = $(".window.main").outerHeight();
                    
                    var searchWindowWidth   = $(".window.search").outerWidth();
                    
                    var top  = mainWindowPosition.top + mainWindowHeight + gutter;
                    var left = mainWindowPosition.left + mainWindowWidth - searchWindowWidth;
                    
                    $(".window.search").css({
                        "top": top,
                        "left": left,
                        "z-index": lastZIndex++
                    });
                }

                // Adjust the layers window position.
                // Used when the window is opened.
                
                function setLayersWindowPosition(){
                    var mainWindowPosition  = $(".window.main").position();
                    var mainWindowHeight    = $(".window.main").outerHeight();
                    
                    var top  = mainWindowPosition.top + mainWindowHeight + gutter;
                    var left = gutter;
                    
                    $(".window.layers").css({
                        "top": top,
                        "left": left,
                        "z-index": lastZIndex++
                    });
                }
                
                // Adjust the expedient window position.
                // Used when the window is opened.
                
                function setExpedientWindowPosition(){
                    var mainWindowPosition  = $(".window.main").position();
                    var mainWindowHeight    = $(".window.main").outerHeight();
                    
                    var top  = mainWindowPosition.top + mainWindowHeight + gutter;
                    var left = gutter;
                    
                    $(".window.expedient").css({
                        "top": top,
                        "left": left,
                        "max-height": $(window).height() - top - gutter,
                        "z-index": lastZIndex++
                    });
                }
                
                
                // Toggle the search window when the menu icon is pressed
                
                $("#menu").on("click", ".search", function(){
                    $(".window.search").toggle();
                    setSearchWindowPosition();
                    return false;
                });
                
                // Toggle the layers window when the menu icon is pressed

                $("#menu").on("click", ".layers", function(){
                    $(".window.layers").toggle();
                    setLayersWindowPosition();
                    return false;
                });
                
                // Toggle the expedient window when the menu icon or
                // the right window button is pressed

                $("#menu").on("click", ".expedient", function(){
                    $(".window.expedient").toggle();
                    setExpedientWindowPosition();
                    return false;
                });

                $(document).on("click", '.open-expedient', function(){
                    $(".window.expedient").toggle();
                    setExpedientWindowPosition();
                    return false;
                });

                // Close the current window when press the times icon on the top right corner.
                
                $(".window").on("click", "h2 .fa-times", function(){
                    $(this).closest(".window").toggle();
                });
                
                // Collapse and expand the layers list on the layers window.
                            
                $(".window.layers").on("click", "ul.layers li > a", function(){
                    $(this).parent('li').toggleClass("open closed");
                    return false;
                });
                
            });
        </script>
        
    	<!-- Angular js -->
    	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    	
    	<!-- Open layers -->
    	<script src="http://openlayers.org/en/v3.12.1/build/ol.js"></script> 
        <link rel="stylesheet" href="http://openlayers.org/en/master/css/ol.css" />
        <!-- End Open layers -->
        
        <!-- Application -->
    	<script src="js/app_dbwater/app.js"></script>
    	<script src="js/app_dbwater/MainController.js"></script>
    	<script src="js/app_dbwater/mapService.js"></script>
    	<script src="js/common/loggerService.js"></script>
    	 <!-- End Application -->
    	 
	</body>
</html>






	
