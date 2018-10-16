<?php
  //echo "See on minu esimene PHP!";
  $firstname = "Steven";
  $lastname = "Saluri";
  //loeme piltide kataloogi sisu
  $dirToRead = "../../pics/";
  $allFiles = scandir($dirToRead);
  $picfiles = array_slice($allFiles, 2);
  //var_dump($picfiles);
 
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
	
	<?php
	  //<img src="../../pics/" alt="pilt">
	  for ($i = 0; $i < count($picfiles); $i ++){
	    echo '<img src="' .$dirToRead .$picfiles[$i] .'" alt="pilt"><br>' ."\n";
	  }
	?>

</body>
</html>