<?php
  //echo "See on minu esimene PHP!";
  $firstname = "Steven";
  $lastname = "Saluri";
  $datetoday = date("d.m.Y");
  $weekdaynow = date("N");
  $weekdaynamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  //echo $weekdaynamesET[1];
  //var_dump($weekdaynamesET);
  //echo $weekdaynow;
  $hournow = date("G");
  $partofday = "";
  if ($hournow <  8){
	  $partofday = "varane hommik";
  }
  if ($hournow >= 8 and $hournow < 16){
	  $partofday = "koolipäev";
  }
  if ($hournow >= 16){
	  $partofday = "ilmselt vaba aeg";
  }
  
  $picNum = mt_rand(2, 43);
  //echo $picNum;
  $picURL = "http://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
  $picEXT = ".jpg";
  $picfile = $picURL .$picNum .$picEXT;
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
	<p>Testing testing 1-2-3</p>
	<p>Tundides tehtu: <a href="photo.php" target="_blank">photo.php</a> <a href="page.php" target="_blank">page.php</a><p>
	<?php
	  //echo "<p>Tänane kuupäev on: " .$datetoday .".</p> \n";
	  //echo "<p>Täna on " .$weekdaynow .", ".$datetoday .".</p> \n";
	  echo "<p>Täna on " .$weekdaynamesET[$weekdaynow - 1] .", ".$datetoday .".</p> \n";
	  echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .". Käes oli " .$partofday .".</p> \n";
	?>
	<!--<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_2.jpg" alt="TLÜ Terra õppehoone">-->
	<!--<img src="../../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_2.jpg" alt="TLÜ Terra õppehoone">-->
	<img src="<?php echo $picfile; ?>" alt="TLÜ õppehooned">
	<p>Mul on ka sõber, kes teeb ka oma <a href="../../../~rasmlii " target="_blank">veebi.</a></p>


</body>
</html>