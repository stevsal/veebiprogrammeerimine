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
	   //profiilipildi laadimine
	if(!empty($_FILES["fileToUpload"]["name"])){
			$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
			$timeStamp = microtime(1) * 10000;
			$target_file_name = "vpuser_" .$timeStamp ."." .$imageFileType;
			$target_file = $profilePicDirectory .$target_file_name;
						
			// kas on pilt, kontrollin pildi suuruse küsimise kaudu
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				//echo "Fail on pilt - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "Fail ei ole pilt.";
				$uploadOk = 0;
			}
			
			// faili suurus
			if ($_FILES["fileToUpload"]["size"] > 2500000) {
				echo "Kahjuks on fail liiga suur!";
				$uploadOk = 0;
			}
			
			// kindlad failitüübid
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Kahjuks on lubatud vaid JPG, JPEG, PNG ja GIF failid!";
				$uploadOk = 0;
			}
			
			// kui on tekkinud viga
			if ($uploadOk == 0) {
				echo "Vabandame, faili ei laetud üles!";
			// kui kõik korras, laeme üles
			} else {
				//sõltuvalt failitüübist, loome pildiobjekti
				if($imageFileType == "jpg" or $imageFileType == "jpeg"){
					$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
				}
				if($imageFileType == "png"){
					$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
				}
				if($imageFileType == "gif"){
					$myTempImage = imagecreatefromgif($_FILES["fileToUpload"]["tmp_name"]);
				}
				
				//vaatame pildi originaalsuuruse
				$imageWidth = imagesx($myTempImage);
				$imageHeight = imagesy($myTempImage);
				//leian vajaliku suurendusfaktori, siin arvestan, et lõikan ruuduks!!!
				if($imageWidth > $imageHeight){
					$sizeRatio = $imageHeight / 300;//ruuduks lõikamisel jagan vastupidi
				} else {
					$sizeRatio = $imageWidth / 300;
				}
				
				$newWidth = round($imageWidth / $sizeRatio);
				$newHeight = $newWidth;
				$myImage = resizeImagetoSquare($myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
				
				//lisame vesimärgi
				$waterMark = imagecreatefrompng("../vp_picfiles/vp_logo_w100_overlay.png");
				$waterMarkWidth = imagesx($waterMark);
				$waterMarkHeight = imagesy($waterMark);
				$waterMarkPosX = $newWidth - $waterMarkWidth - 10;
				$waterMarkPosY = $newHeight - $waterMarkHeight - 10;
				//kopeerin vesimärgi pikslid pildile
				imagecopy($myImage, $waterMark, $waterMarkPosX, $waterMarkPosY, 0, 0, $waterMarkWidth, $waterMarkHeight);
				
				//muudetud suurusega pilt kirjutatakse pildifailiks
				if($imageFileType == "jpg" or $imageFileType == "jpeg"){
				  if(imagejpeg($myImage, $target_file, 90)){
                    //echo "Korras!";
					//ja kohe see uus profiilipilt
		            $profilePic = $target_file;
					//kui pilt salvestati, siis lisame andmebaasi
					$addedPhotoId = addUserPhotoData($target_file_name);
					//echo "Lisatud pildi ID: " .$addedPhotoId;
				  } else {
					//echo "Pahasti!";
				  }
				}
				
				imagedestroy($myTempImage);
				imagedestroy($myImage);
				imagedestroy($waterMark);
				
			}
		}//pildi laadimine lõppes
		//profiili salvestamine koos pildiga
	   
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
	<img src="<?php echo $profilePic; ?>" alt="<?php echo $_SESSION["firstname"] ." " .$_SESSION["lastname"]; ?>" >
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<textarea rows="10" cols="80" name="description" ><?php echo $description; ?></textarea><br>
		<label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $bgcolor; ?>">
		<label>Minu valitud tekstivärv: </label><input name="bgtext" type="color" value="<?php echo $bgtext; ?>"><br>
		<input type="file" name="fileToUpload" id="fileToUpload">
	    <br>
		<input type="submit" name="submitprofile" value="Salvesta profiil"><?php echo $notice; ?>
		
	</form>
	<ul>
	   <li><a href="Main.php">Pealehele</a></li>
	</ul>
	
  </body>
</html>