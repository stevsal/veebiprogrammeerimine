<?php
  //echo "See on minu esimene PHP!";
  $firstname = "Kodanik";
  $lastname = "Tundmatu";
  
  //kontrollime, kas kasutaja on midagi kirjutanud
  //var_dump($_POST);
  if (isset($_POST["firstname"])){
	  $firstname = $_POST["firstname"];
  }	
  if (isset($_POST["lastname"])){
	  $lastname = $_POST["lastname"];
  }
 
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
	<form method="POST">
	<label>Eesnimi:</label>
	<input type="text" name="firstname">
	<label>Perekonnanimi:</label>
	<input type="text" name="lastname">
	<label>Sünniaasta: </label>
	<input type="number" min="1914" max="2000" value="1999" name="birthYear">
	<br>
	<input type="submit" name="submitUserData" value="Saada andmed">
	</form>
	<hr>
	<?php
	if (isset($_POST["firstname"])){
	  echo "<p>Olete elanud järgnevatel aastatel: </p> \n";
	  echo"<ol> \n";
	    for ($i = $_POST["birthYear"]; $i <= date("Y"); $i++) {
			echo "<li>" .$i ."</li> \n";
		}
	  echo "</ol> \n";
    }	 
	
	?>

</body>
</html>