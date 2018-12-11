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
  
  //$users = getUsers();
  //$thubmslist= listpublicphotos(2);
  $page = 1;
  $totalImages = findTotalPublicImages();
  //echo $totalImages;
  $limit = 10;
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;
  } elseif (round(($_GET["page"] - 1) * $limit) > $totalImages){
	  $page = round($totalImages / $limit);
  } else {
	  $page = $_GET["page"];
  }
  //$thumbslist = listpublicphotos();
  $thumbslist = listpublicphotospage($page, $limit);
  
  $pageTitle = "Avalikud fotod";
  $scripts = '<link rel="stylesheet" type="text/css" href="style/modal.css">' ."\n";
  $scripts .= '<script type="text/javascript" src="javascript/modal.js" defer></script>' ."\n";
  require("header.php");
  //$thumbslist= listpublicphotospage(1);
  //$pageTitle = "Avalikud fotod";
?>

	<hr>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstname"] ." " .$_SESSION["lastname"] ."."; ?></p>
	<ul>
	   <li><a href="Main.php">Tagasi pealehele</a></li>
	</ul>
	<hr>
	
	<!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- The Close Button -->
        <span class="close">&times;</span>

        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="modalImg">

        <!-- Modal Caption (Image Text) -->
        <div id="caption" class="caption"></div>
		<div id="ratingbox" style="color: white">
			<label><input type="radio" id="rate1" value="1">1</label>
			<label><input type="radio" id="rate2" value="2">2</label>
			<label><input type="radio" id="rate3" value="3" checked="checked">3</label>
			<label><input type="radio" id="rate4" value="4">4</label>
			<label><input type="radio" id="rate5" value="5">5</label>
			<input type="button" value="Salvesta hinnang!" id="storeRating">
			<span id="avgRating"></span>
		</div>
    </div>
    <div id="gallery">
	<?php
		echo "<p>";
		if ($page > 1){
			echo '<a href="?page=' .($page - 1) .'">Eelmised pildid</a> ';
		} else {
			echo "<span>Eelmised pildid</span> ";
		}
		if ($page * $limit < $totalImages){
			echo '| <a href="?page=' .($page + 1) .'">Järgmised pildid</a>';
		} else {
			echo "| <span>Järgmised pildid</span>";
		}
		echo "</p> \n";
		echo $thumbslist;
	?>
	</div>
	
  </body>
</html>