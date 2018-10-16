<?php
  //kutsume välja funktsioonide faili
  require ("functions.php");
  
  $lamp = null;
  
  if (isset($_POST["name"])){
  if ($_POST["nimi"] != !empty($_POST["message"])){
	 $nimi = test_input($_POST["nimi"]);
     $lamp = kass($message);
   } else {
	  $lamp = "Palun kirjuta nimi!";   
   }
   if ($_POST["v2rv"] != !empty($_POST["v2rv"])){
	 $v2rv = test_input($_POST["v2rv"]);
     $lamp = kass($message);
   } else {
	  $lamp = "Palun kirjuta värv!";   
   }
   if ($_POST["saba"] != !empty($_POST["message"])){
	 $saba = test_input($_POST["saba"]);
     $lamp = kass($message);
   } else {
	  $lamp = "Palun kirjuta sabapikkus!";   
   }
   
  }
  
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Kasside lisamine</title>
</head>
<body>
	<h1>kasside lisamine</h1>
	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim väljanäha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Sisesta kass:</label>
	  <br>
	  <input type="text" name="nimi" placeholder="name">
	  <input type="text" name="värv" placeholder="color">
	  <input type="text" name="saba pikkus" placeholder="tail lenght">
	  <br>
	  <input type="submit" name="submitMessage" value="Salvesta kass">
	</form>
	<hr>
	<p><?php echo $lamp; ?></p>

</body>
</html>