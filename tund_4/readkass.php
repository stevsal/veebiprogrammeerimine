<?php
  //kutsume välja funktsioonide faili
  require ("functions.php");
  
  $lamp = listallmessages();
  
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Kasside lugemine</title>
</head>
<body>
	<h1>kassid</h1>
	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim väljanäha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	
	<hr>
	<?php
	   echo $lamp; 
	?>

</body>
</html>