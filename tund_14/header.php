<?php

  if(isset($_SESSION["userId"])){
	  readprofilecolors();
  } else {
		$_SESSION["bgcolor"] = "#FFFFFF";
		$_SESSION["bgtext"] = "#000000";
	}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title><?php echo $pageTitle; ?></title>
	<style>
		body {
			background: <?php echo $_SESSION["bgcolor"]; ?>;
			color:  <?php echo $_SESSION["bgtext"]; ?>;
		}
	</style>
		<?php
      if(isset($scripts)){
        echo $scripts;  
      }
    ?>
  </head>
  <body>
	
	<div>
	  <a href="Main.php">
	  <img src="../vp_picfiles/vp_logo_w135_h90.png" alt="VP logo">
	  </a>
	  <img src="../vp_picfiles/vp_banner.png" alt="VP 2018 banner">
	</div>
    <h1><?php echo $pageTitle; ?></h1>