<?php
  //kutsume välja funktsioonide faili
  require ("functions.php");
  
  //echo "See on minu esimene PHP!";
  $notice="";
  $firstname = "";
  $lastname = "";
  $birthMonth = null;
  $birthDay = null;
  $birthYear = null;
  $birthDate = null;
  $gender = null;
  $email = "";
  
  $firstnameError = "";
  $lastnameError = "";
  $birthMonthError = "";
  $birthDayError = "";
  $birthYearError = "";
  $birthDateError = "";
  $genderError = "";
  $emailError = "";
  $passwordError = "";
  
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
  
  //kontrollime, kas kasutaja on nuppu vajutanud
  if (isset($_POST["submitUserData"])) {
  //var_dump($_POST);
  if (isset($_POST["firstname"])and !empty($_POST["firstname"])){
	  //$firstname = $_POST["firstname"];
	  $firstname = test_input($_POST["firstname"]);
  }	else {
	  $firstnameError = "Palun sisesta oma eesnimi";
  }
  }
  
  if (isset($_POST["lastname"])){
	  $lastname = test_input($_POST["lastname"]);
  } else {
	  $lastnameError = "Palun sisesta oma perekonnanimi";  
  }  
  if (isset($_POST["gender"])and !empty($_POST["gender"])){
	  $gender = intval($_POST["gender"]);
  } else {
	  $genderError = "Palun määra sugu";
  }
  if (isset($_POST["email"])and !empty($_POST["email"])){
	  $email = test_input($_POST["email"]);
  } else {
	  $emailError = "Palun sisesta email";
  }

  
  //kui päev,kuu ja aasta on olemas, kontrollitud
  //võiks ju hoopis kontrollida kas kuupäevadega seotud error muutujad on nullid
  if(isset($_POST["birthDay"]) and isset($_POST["birthMonth"]) and isset($_POST["birthYear"])){
	  //kas oodatav kuupäev on üldse võimalik
	  //checkdate(kuu,päev,aasta) tahab täisarve
	  if(checkdate(intval($_POST["birthMonth"]), intval($_POST["birthDay"]), intval($_POST["birthYear"]))){
		  //kui on võimalik
	  $birthDate = date_create($_POST["birthMonth"] ."/" .$_POST["birthDay"] ."/" .$_POST["birthYear"]);
	  $birthDate = date_format ($birthDate, "Y-m-d");
	  //echo $birthDate;
	  } else {
	  $birthDateError = "Palun sisestage võimalik kuupäev";
	  }
	  //kui errorit pole
	  if(empty($firstnameError) and empty($lastnameError) and empty($birthMonthError) and empty($birthDayError) and empty($birthYearError) and empty($birthDateError) and empty($genderError) and empty($emailError) and empty($passwordError));{
		$notice = signup($firstname,$lastname,$birthDate,$gender,$email,$_POST["password"]);
		  
	  }
  } //kas vajutati nuppu
  
  
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Uue kasutaja loomine</title>
</head>
<body>
	<h1>
	   <?php
	     echo $firstname ." " .$lastname;
	   ?>, IF18</h1>
	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim väljanäha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Eesnimi:</label><br>
	<input type="text" name="firstname" placeholder="Firstname" value="<?php echo $firstname ?>"><span><?php echo $firstnameError ?></span><br>
	<label>Perekonnanimi:</label><br>
	<input type="text" name="lastname" placeholder="Lastname" value="<?php echo $lastname ?>"><span><?php echo $lastnameError ?></span><br>
	<label>Sünnipäev: </label>
	  <?php
	    echo '<select name="birthDay">' ."\n";
		for ($i = 1; $i < 32; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthDay){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label>Sünnikuu: </label>
	  <?php
	    echo '<select name="birthMonth">' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthMonth){
				echo " selected ";
			}
			echo ">" .$monthNamesET[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label>Sünniaasta: </label>
	  <!--<input name="birthYear" type="number" min="1914" max="2003" value="1998">-->
	  <?php
	    echo '<select name="birthYear">' ."\n";
		for ($i = date("Y") - 15; $i >= date("Y") - 90; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthYear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>

	  <br>
	  <input type="radio" name="gender" value="2" <?php if($gender == 2){echo "checked";} ?>><label>naine</label><br>
	  <input type="radio" name="gender" value="1" <?php if($gender == 1){echo "checked";} ?>><label>mees</label><br>
	  <span><?php echo $genderError ?></span>
	  <br>
	  <label>E-postiaadress (kasutajatunnuseks):</label><br>
      <input name="email" type="email">
	  <br>
	  
	  <label> (Salasõna min 8 märki):</label>
	  <input name="password" type="password">
	  <br>
	  
	  <input type="submit" name="submitUserData" value="Loo kasutaja">
	</form>
	<hr>
	<p><?php echo $notice; ?></p>

</body>
</html>