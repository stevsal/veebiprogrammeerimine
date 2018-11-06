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
  
  $description = "Pole tutvustust lisanud";
  $bgcolor = "#FFFFFF";
  $bgtext = "#000000";
  $notice = "";
  
  $descriptionError = "";
  $bgcolorError = "";
  $bgtextError = "";
  
  if (isset($_POST["submitprofile"])){
  if ($_POST["description"] != "Siia sisesta oma sõnum ..." and !empty($_POST["description"])){
	 $description = $_POST["description"];
     $notice = createprofile($description, $bgcolor, $bgtext);
   } else {
	  $descriptionError = "Palun kirjuta sõnum!";   
   }
   if (isset($_POST["bgtext"])) {
            $bgtextError['bgtext'] = 'Palun vali tekstivärv';
        } else {
            $bgtext = $_POST['bgtext'];
        }
        if (isset($_POST['bgcolor'])) {
            $bgcolorError['bgcolor'] = 'Palun vali taustavärv';
        } else {
            $bgcolor = $_POST['bgcolor'];
        }
	if (empty($descriptionError) and empty($bgtextError) and empty($bgcolorError)){
		$notice = createprofile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
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
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<textarea rows="10" cols="80" name="description" placeholder="Kirjuta endast midagi"><?php echo $description; ?></textarea><br>
		<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $bgcolor; ?>">
		<label>Minu valitud tekstivärv: </label><input name="bgtext" type="color" value="<?php echo $bgtext; ?>"><br>
		<input type="submit" name="submitprofile" value="Salvesta profiil">
	</form>
	<ul>
	   <li><a href="Main.php">Pealehele</a></li>
	</ul>
	
  </body>
</html>