<?php
	require("functions.php");
	  //echo $senttitle;
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
	
	require("classes/NEWS.class.php");
	if(isset($_POST["newsTitle"] and $_POST["newsEditor"] and $_POST["expiredate"]{
		
		new NEWS($GLOBALS["serverHost"],$GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$senttitle = $_POST["newsTitle"];
		$sentnews = $_POST["newsEditor"];
		$expiredate = $_POST["expiredate"];
		$userid = $_SESSION["userId"];
		
	}
	//echo $senttitle;
	//echo $sentnews;
	//echo $expiredate;
	$pageTitle = "Uudised";
	$scripts = '<script type="text/javascript" src="javascript/setrandompic.js" defer></script>' ."\n";
	require("header.php")
	
?>
<!DOCTYPE html>
<html>

	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim väljanäha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	<!-- Lisame tekstiredaktory TinyMCE -->
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script>
		tinymce.init({
			selector:'textarea#newsEditor',
			plugins: "link",
			menubar: 'edit',
		});
	</script>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Uudise pealkiri:</label><br><input type="text" name="newsTitle" id="newsTitle" style="width: 100%;" value=""><br>
	<label>Uudise sisu:</label><br>
	<textarea name="newsEditor" id="newsEditor"></textarea>
	<br>
	<label>Uudis nähtav kuni (kaasaarvatud)</label>
	<input type="date" name="expiredate" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" value="2018-12-10">
	
	<input name="newsBtn" id="newsBtn" type="submit" value="Salvesta uudis!">
	</form>
	<ul>
	   <li><a href="Main.php">Pealehele</a></li>
	</ul>
	<hr>

</body>
</html>