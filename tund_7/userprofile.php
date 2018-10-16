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
  
  if (isset($_POST["submitprofile"])){
  if ($_POST["description"] != "Siia sisesta oma sõnum ..." and !empty($_POST["message"])){
	 $message = test_input($_POST["message"]);
     $notice = createprofile($message);
   } else {
	  $notice = "Palun kirjuta sõnum!";   
   }
  }
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Profiili loomine</title>
  </head>
  <body>
    <h1>Profiili loomine</h1>
	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstname"] ." " .$_SESSION["lastname"] ."."; ?></p>
	<textarea rows="10" cols="80" name="description"><?php echo $description; ?></textarea><br>
	<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $bgcolor; ?>">
	<label>Minu valitud tekstivärv: </label><input name="bgcolor" type="color" value="<?php echo $txtcolor; ?>"><br>
	<input type="submit" name="submitprofile" value="Salvesta profiil">
	<ul>
	   <li><a href="Main.php">Pealehele</a></li>
	</ul>
	
  </body>
</html>