<?php
  //kutsume välja funktsioonide faili
  require ("functions.php");
  
  //echo "See on minu esimene PHP!";
  $firstname = "Kodanik";
  $lastname = "Tundmatu";
  $currentmonth = date("n") - "";
  
  //kontrollime, kas kasutaja on midagi kirjutanud
  //var_dump($_POST);
  if (isset($_POST["firstname"])){
	  //$firstname = $_POST["firstname"];
	  $firstname = test_input($_POST["firstname"]);
  }	
  if (isset($_POST["lastname"])){
	  $lastname = test_input($_POST["lastname"]);
  }
  
  
//täiesti mõttetu, harjutamiseks funktsioon
function fullname(){
	$GLOBALS["fullname"] = $GLOBALS["firstname"] ." " .$GLOBALS["lastname"];
  }
  $fullname = "";
  fullname ();
  
  
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>
	  <?php echo $firstname;
	        echo " ";
			echo $lastname;
	  ?>
	  , õppetöö</title>
</head>
<body>
	<h1>
	   <?php
	     echo $firstname ." " .$lastname;
	   ?>, IF18</h1>
	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim väljanäha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Eesnimi:</label>
	<input type="text" name="firstname" placeholder="Firstname">
	<label>Perekonnanimi:</label>
	<input type="text" name="lastname" placeholder="Lastname">
	<label>Sünniaasta: </label>
	<input type="number" min="1914" max="2000" value="1999" name="birthYear">
	<select name="birthMonth">
      <option value="1"<?php if ($currentmonth == 1) echo 'selected'; ?> >jaanuar</option>
      <option value="2"<?php if ($currentmonth == 2) echo 'selected'; ?>>veebruar</option>
      <option value="3"<?php if ($currentmonth == 3) echo 'selected'; ?>>märts</option>
      <option value="4"<?php if ($currentmonth == 4) echo 'selected'; ?>>aprill</option>
      <option value="5"<?php if ($currentmonth == 5) echo 'selected'; ?>>mai</option>
      <option value="6"<?php if ($currentmonth == 6) echo 'selected'; ?>>juuni</option>
      <option value="7"<?php if ($currentmonth == 7) echo 'selected'; ?>>juuli</option>
      <option value="8"<?php if ($currentmonth == 8) echo 'selected'; ?>>august</option>
      <option value="9"<?php if ($currentmonth == 9) echo 'selected'; ?>>september</option>
      <option value="10"<?php if ($currentmonth == 10) echo 'selected'; ?>>oktoober</option>
      <option value="11"<?php if ($currentmonth == 11) echo 'selected'; ?>>november</option>
      <option value="12"<?php if ($currentmonth == 12) echo 'selected'; ?>>detsember</option>
	  <br>
</select>
	<input type="submit" name="submitUserData" value="Saada andmed">
	</form>
	<hr>
	<?php
	if (isset($_POST["firstname"])){
	  echo "<p>" .$fullname .", olete elanud järgnevatel aastatel: </p> \n";
	  echo"<ol> \n";
	    for ($i = $_POST["birthYear"]; $i <= date("Y"); $i++) {
			echo "<li>" .$i ."</li> \n";
		}
	  echo "</ol> \n";
    }	 

	
	?>

</body>
</html>