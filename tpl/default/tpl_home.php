<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>SolutionsDB</title>

  </head>
  <body>
	  
	  <?php
		  if($consumerdb){
		  ?>
		  <a href="<?php echo $baseHref?>dbconsumer">dbConsumer</a><br>
		  <?php
			  }else{
		?>
			dbConsumer<br>
		<?php
		}
		?>
		
		 <?php
		  if($dbmanager){
		  ?>
		 <a href="<?php echo $baseHref?>dbmanager">dbmanager</a><br>
		  <?php
			  }else{
		?>
			dbmanager<br>
		<?php
		}
		?>
		
		 <?php
		  if($dbquality){
		  ?>
		   <a href="<?php echo $baseHref?>dbquality">dbquality</a><br>
		  <?php
			  }else{
		?>
			dbquality<br>
		<?php
		}
		?>
		
		
		 <?php
		  if($dbwater){
		  ?>
		   <a href="<?php echo $baseHref?>dbwater">dbwater</a><br>
		  <?php
			  }else{
		?>
			dbwater<br>
		<?php
		}
		?>
		
		 <?php
		  if($dbbnergy){
		  ?>
		   <a href="https://n4.opendomo.com/admin/login">dbEnergy</a><br>
		  <?php
			  }else{
		?>
			dbEnergy<br>
		<?php
		}
		?>
		
	  
	 
	 
	  
	  <br><br>
	  <a href="<?php echo $baseHref?>logout.php">Log out</a><br>
  </body>
</html>




