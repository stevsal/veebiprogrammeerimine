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
  $bgcolor = $_SESSION["bgcolor"];
  $bgtext = $_SESSION["bgtext"];
  $notice = "";
  
  $descriptionError = "";
  $bgcolorError = "";
  $bgtextError = "";
  
  if (isset($_POST["submitprofile"])){
	  if ($_POST["description"] != "Pole tutvustust lisanud" and !empty($_POST["description"])){
		 $description = $_POST["description"];
		 //$notice = createprofile($_POST["description"] ,$_POST['bgcolor'] ,$_POST["bgtext"]);
	   } else {
		  $descriptionError = "Palun kirjuta sõnum!";   
	   }
	   if (isset($_POST["bgtext"])) {
				$bgtext = $_POST['bgtext'];
			} else {
				$bgtextError['bgtext'] = 'Palun vali tekstivärv';
			}
			if (isset($_POST['bgcolor'])) {
				$bgcolor = $_POST['bgcolor'];
			} else {
				$bgcolorError['bgcolor'] = 'Palun vali taustavärv';
			}
		if (empty($descriptionError) and empty($bgtextError) and empty($bgcolorError)){
			$notice = createprofile($description, $bgcolor, $bgtext);
		}

  }
  $pageTitle = "Kasutajaprofiil";
  require("header.php");
  
?>

	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstname"] ." " .$_SESSION["lastname"] ."."; ?></p>
	<img src="../vp_picfiles/vp_user_generic.png" alt="Profiili pilt" >
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<textarea rows="10" cols="80" name="description" ><?php echo $description; ?></textarea><br>
		<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $bgcolor; ?>">
		<label>Minu valitud tekstivärv: </label><input name="bgtext" type="color" value="<?php echo $bgtext; ?>"><br>
		<input type="submit" name="submitprofile" value="Salvesta profiil"><?php echo $notice; ?>
	</form>
	<ul>
	   <li><a href="Main.php">Pealehele</a></li>
	</ul>
	
  </body>
</html>