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
  
  $pageTitle = "Pealeht";
  require("header.php");
  
?>


	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstname"] ." " .$_SESSION["lastname"] ."."; ?></p>
	<ul>
       <li><a href="userprofile">Profiili muutmine.</a></li>
	   <li><a href="users.php">Kasutajate süsteem</a></li>
	   <li><a href="validatemsg.php">Valideeri anonüümseid sõnumeid</a></li>
	   <li>Näita valideerituid <a href="validatedmsg.php">sõnumeid</a> valideerijate kaupa!</li>
	   <li>Fotode <a href="photoupload.php">üleslaadimine</a>.</li>
	   <li><a href="?logout=1">Logi välja!</a></li>
	</ul>
	
  </body>
</html>