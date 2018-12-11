<?php
  require("functions.php");
  
  //kui pole sisseloginud, siis logimise lehele
  if(!isset($_SESSION["userId"])){
	  header("Location: index_1.php");
	  exit();
  }
  
  //logime välja
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: index_1.php");
	  exit();
  }
  
  //$users = getUsers();
  //$thubmslist= listpublicphotos(2);
  $thumbslist= listuserphotos(3,$_SESSION["userId"]);
  $pageTitle = "Privaat fotod";
  require("header.php");
?>

	<?php echo $thumbslist ?>
	<hr>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstname"] ." " .$_SESSION["lastname"] ."."; ?></p>
	<ul>
       <li><a href="?logout=1">Logi välja!</a></li>
	   <li><a href="Main.php">Tagasi pealehele</a></li>
	</ul>
	
  </body>
</html>