
<?php
// menu lateral responsive ocultable
// http://www.christopheryee.ca/pushy/
// fet amb bootstrap :D
// http://www.jasny.net/bootstrap/examples/navmenu/
// http://www.jonathanbriehl.com/2014/01/17/vertical-menu-for-bootstrap-3/
?>

<nav>
  <ul class="list-unstyled main-menu">

    <!--Include your navigation here-->
    <li class="text-left"><a href="#" id="nav-close">X</a></li>
    <li><a href="#">Menu One <span class="icon"></span></a></li>
    <li><a href="#">Menu Two <span class="icon"></span></a></li>
    <li><a href="#">Menu Three <span class="icon"></span></a></li>
    <li><a href="#">Dropdown</a>
      <ul class="list-unstyled">
          <li class="sub-nav"><a href="#">Sub Menu One <span class="icon"></span></a></li>
          <li class="sub-nav"><a href="#">Sub Menu Two <span class="icon"></span></a></li>
          <li class="sub-nav"><a href="#">Sub Menu Three <span class="icon"></span></a></li>
          <li class="sub-nav"><a href="#">Sub Menu Four <span class="icon"></span></a></li>
          <li class="sub-nav"><a href="#">Sub Menu Five <span class="icon"></span></a></li>
      </ul>
    </li>
    <li><a href="#">Menu Four <span class="icon"></span></a></li>
    <li><a href="#">Menu Five <span class="icon"></span></a></li>
  </ul>
</nav>

<div class="navbar navbar-inverse navbar-fixed-top">      

    <!--Include your brand here-->
    
    <div class="navbar-header pull-left">
      <a id="nav-expander" class="nav-expander">
        MENU &nbsp;<i class="fa fa-bars fa-lg white"></i>
      </a>
    </div>
    <a class="navbar-brand" href="#">Off Canvas Menu</a>
</div>
