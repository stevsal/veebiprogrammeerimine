<?php
  //echo "See on minu esimene PHP!";
  $firstname = "Steven";
  $lastname = "Saluri";
  $datetoday = date("d.m.Y");
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
	<li><a href="tund_3">Tund_3</a></li>
	<li><a href="tund_4">Tund_4</a></li>
	<li><a href="tund_5">Tund_5</a></li>
	<li><a href="tund_6">Tund_6</a></li>
	<li><a href="tund_7/Main.php">Tund_7</a></li>
	<?php
	  echo "<p>Tänane kuupäev on: " .$datetoday .".</p> \n";
	  echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .". Käes oli " .$partofday .".</p> \n";
	?>
	<!--<img src="http://greeny.cs.tlu.ee/~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_2.jpg" alt="TLÜ Terra õppehoone">-->
	<img src="../../~rinde/veebiprogrammeerimine2018s/tlu_terra_600x400_2.jpg" alt="TLÜ Terra õppehoone">
	<p>Mul on ka sõber, kes teeb ka oma <a href="../../~rasmlii " target="_blank">veebi.</a></p>


</body>
</html>