<?php
  //laen andmebaasi info
  require ("../../../config.php");
  //echo $GLOBALS["thumbDir"];
  $database = "if18_steven_sa_1";
  
  //võtan kasutusele sessiooni
  session_start();
  
  
  function findTotalPublicImages(){
	$privacy = 2;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT COUNT(*) FROM vpphotos WHERE privacy<=? AND deleted IS NULL");
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($imageCount);
	$stmt->execute();
	$stmt->fetch();
	$stmt->close();
	$mysqli->close();
	return $imageCount;	
  }
  
  
  
  function listuserprofilephotos($userid){
	  $html = "";
	//<img src=kataloog/fail alt="tekst">
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT filename FROM vp_user_pic WHERE userid=? AND id!=? AND deleted IS NULL ");
	echo $conn->error;
	$stmt->bind_param("ii",$_SESSION["userId"],$_SESSION["avatar"]);
	$stmt->bind_result($filenamefromDB);
	$stmt->execute();
	while($stmt->fetch()){
		//<img src=kataloog/fail alt="tekst">
		$html .= '<img src="' .$GLOBALS["userpicDir"] .$filenamefromDB .'">' ."\n";
	}
	if(empty($html)){
		$html = "<p>Kahjuks eelmiseid profiili pilte pole!</p> \n";
	}
	$stmt->close();
	$conn->close();
	return $html;
  }
  
  
  function listuserphotos($privacy,$userid){
	  $html = "";
	//<img src=kataloog/fail alt="tekst">
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE userid=? AND privacy>=? AND deleted IS NULL ");
	echo $conn->error;
	$stmt->bind_param("ii", $userid, $privacy);
	$stmt->bind_result($filenamefromDB, $alttextfromDB);
	$stmt->execute();
	while($stmt->fetch()){
		//<img src=kataloog/fail alt="tekst">
		$html .= '<img src="' .$GLOBALS["thumbDir"] .$filenamefromDB .'" alt="' .$alttextfromDB .'">' ."\n";
	}
	if(empty($html)){
		$html = "<p>Kahjuks privaat pilte pole!</p> \n";
	}
	$stmt->close();
	$conn->close();
	return $html;
  }
  
  
  function listpublicphotospage($page, $limit){
	$html = "";
	$privacy = 2;
	$skip = ($page-1) * $limit;
	//<img src=kataloog/fail alt="tekst">
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//$stmt = $mysqli->prepare("SELECT id,filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL LIMIT 6");
	$stmt = $mysqli->prepare("SELECT vpphotos.id, vpusers.firstname, vpusers.lastname, vpphotos.filename, vpphotos.alttext, AVG(vpphotoratings.rating) as AvgValue FROM vpphotos JOIN vpusers ON vpphotos.userid = vpusers.id LEFT JOIN vpphotoratings ON vpphotoratings.photoid = vpphotos.id WHERE vpphotos.privacy < ? AND deleted IS NULL GROUP BY vpphotos.id DESC LIMIT ?,?");
	echo $mysqli->error;
	$stmt->bind_param("iii", $privacy, $skip, $limit);
	$stmt->bind_result($idfromDB, $firstnamefromDB, $lastnamefromDB, $filenamefromDB, $alttextfromDB, $avgratingfromDB);
	$stmt->execute();
	while($stmt->fetch()){
		$html .= '<div class="thumbGallery">'
		.'<img src="' .$GLOBALS["thumbDir"]. $filenamefromDB. '" alt="' .$alttextfromDB .'" data-id="' .$idfromDB .'" data-fn="' .$filenamefromDB . '">' .
		'<p>'. $firstnamefromDB.' '. $lastnamefromDB.'</p>' . 
		'<p id="score' .$idfromDB . '">Hinne:'. $avgratingfromDB. '</p>' . 
		'</div>' ."\n";
	}
	if(empty($html)){
		$html = "<p>Kahjuks avalikke pilte pole!</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	return $html;
  }
  
  function listpublicphotos($privacy){
	$html = "";
	//<img src=kataloog/fail alt="tekst">
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy<=? AND deleted IS NULL");
	echo $mysqli->error;
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($filenamefromDB, $alttextfromDB);
	$stmt->execute();
	while($stmt->fetch()){
		//<img src=kataloog/fail alt="tekst">
		$html .= '<img src="' .$GLOBALS["thumbDir"] .$filenamefromDB .'" alt="' .$alttextfromDB .'">' ."/n";
	}
	if(empty($html)){
		$html = "<p>Kahjuks avalikke pilte pole!</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	return $html;
  }
  
  function latestPicture($privacy){
	  $html = "";
	  //<img src=kataloog/fail alt="tekst">
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT filename, alttext FROM vpphotos WHERE id=(SELECT MAX(id) FROM vpphotos WHERE privacy=? AND deleted IS NULL)");
	echo $mysqli->error;
	$stmt->bind_param("i", $privacy);
	$stmt->bind_result($filenamefromDB, $alttextfromDB);
	$stmt->execute();
	if($stmt->fetch()){
		$html = '<img src="' .$GLOBALS["picDir"] .$filenamefromDB .'" alt="' .$alttextfromDB .'">' ."\n";
	} else {
		$html = "<p>Kahjuks avalikke pilte pole!</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	return $html;
  }
  
  function addUserPhotoData($fileName){
	$addedId = null;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare("INSERT INTO vp_user_pic (userid, filename) VALUES (?, ?)");
	echo $mysqli->error;
	$stmt->bind_param("is", $_SESSION["userId"], $fileName);
	if($stmt->execute()){
	  $addedId = $mysqli->insert_id;
	  //echo $addedId;
	} else {
	  echo $stmt->error;
	}
	return $addedId;
	$stmt->close();
	$mysqli->close();
  }
  
  
  //
  function addPhotoData($filename, $alttext, $privacy){
	  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $mysqli->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES(?, ?, ?, ?)");
	  echo $mysqli->error;
	  if(empty($privacy)){
		$privacy = 3;
	  }
	  $stmt->bind_param("issi",$_SESSION["userId"], $filename, $alttext, $privacy);
	  if($stmt->execute()){
		  echo "Andmebaasiga on ka korras";
	  } else {
		  echo "Andmebaasiga läks kehvasti";
	  }
	  $stmt->close();
	  $mysqli->close();
  }
  
    function readprofilecolors(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT description, bgcolor, bgtext FROM vpuserprofiles WHERE userid=?");
		echo $mysqli->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
		$stmt->bind_result($description, $bgcolor, $bgtext);
		$stmt->execute();
		if($stmt->fetch()){
			$_SESSION["description"] = $description;
			$_SESSION["bgcolor"] = $bgcolor;
			$_SESSION["bgtext"] = $bgtext;
		} else {
			$_SESSION["description"] = "Palun lisa tutvustus!";
			$_SESSION["bgcolor"] = "#FFFFFF";
			$_SESSION["bgtext"] = "#000000";
		}
		
		$stmt->close();
		$mysqli->close();
		readuserpic();
	}
	
	function readuserpic(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT filename FROM vp_user_pic WHERE userid=? ORDER BY id DESC");
		echo $mysqli->error;
		$stmt->bind_param("i", $_SESSION["userId"]);
		$stmt->bind_result($filename);
		$stmt->execute();
		$profile = new Stdclass();
		if($stmt->fetch()){
			$_SESSION["avatar"] = "../vp_userpics/" . $filename;
		} else {
			$_SESSION["avatar"] = "../vp_userpics/vp_user_generic.png";
		}
		$stmt->close();
		$mysqli->close();
	}
  
  
  //Kasutaja profiili funktsioon
  function createprofile($description, $bgcolor, $bgtext){
	  echo $description .$bgcolor .$bgtext;
	  $notice = "";
	  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $mysqli->prepare("SELECT description, bgcolor, bgtext FROM vpuserprofiles WHERE userid=?");
	  echo $mysqli->error;
	  $stmt->bind_param("i", $_SESSION["userId"]);
	  $stmt->bind_result($descriptionfromDB,$bgcolorfromDB,$bgtextfromDB);
	  $stmt->execute();
		  if($stmt->fetch()){
			$stmt->close();
			$stmt = $mysqli->prepare("UPDATE vpuserprofiles SET description=?, bgcolor=?, bgtext=? WHERE userid = ?");
			echo $mysqli->error;
		    $stmt->bind_param("sssi",$description,$bgcolor,$bgtext,$_SESSION["userId"]);
			if($stmt->execute()){
				$notice ="Profiil edukalt uuendatud!";
				$_SESSION["bgcolor"] = $bgcolor;
				$_SESSION["bgtext"] = $bgtext;
			} else {
				$notice ="Profiili uuendamisel tekkis tõrge!" .$stmt->error;
			}
		  } else {
			//$stmt-close();
			$stmt = $mysqli->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, bgtext) VALUES (?, ?, ?, ?)");
			echo $mysqli->error;
			$stmt->bind_param("isss",$_SESSION["userId"],$description,$bgcolor,$bgtext);
			if($stmt->execute()){
			$notice = "Profiili tekitamine õnnestus";
			$_SESSION["bgcolor"] = $bgcolor;
			$_SESSION["bgtext"] = $bgtext;
			} else {
				$notice ="Profiili salvestamisel tekkis viga!" .$stmt->error;
			}
			
		  }
	  
	  $stmt->close();
	 $mysqli->close();
	 return $notice;
  }
  
  
  //Kõigi valideeritud sõnumite lugemine kasutajate kaupa
  function readallvalidatedmessagesbyuser(){
	  $totalhtml = "";
	  $msghtml = "";
	  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $mysqli->prepare("SELECT id, firstname, lastname from vpusers");
	  echo $mysqli->error;
	  $stmt->bind_result($idfromDB, $firstnamefromDB, $lastnamefromDB);
	  
	  $stmt2 = $mysqli->prepare("SELECT message, accepted FROM vpamsg WHERE acceptedby=?");
	  echo $mysqli->error;
	  $stmt2->bind_param("i",$idfromDB);
	  $stmt2->bind_result($msgfromDB, $acceptedfromDB);
	  $stmt->execute();
	  //et hoida andmebaasist loetud andmeid pisut kauem mälus, saaks edasi kasutada
	  $stmt->store_result();
	  
	  while($stmt->fetch()){
		  //$msghtml = "";
		  $counter = 0;
		  $msghtml = "<h3>" .$firstnamefromDB ." " .$lastnamefromDB ."</h3> \n";
		  $stmt2->execute();
		  while($stmt2->fetch()){
			  $msghtml .= "<p><b>";
			  if($acceptedfromDB == 1){
				  $msghtml .= "Lubatud: ";
			  } else {
					$msghtml.= "Keelatud: ";
			  }
			  $msghtml.= "</b>" .$msgfromDB ."</p> \n";
			  $counter ++;
		  }
		  if ($counter > 0){
			  $totalhtml .= $msghtml;
		  }
	  }	  
	  //echo $counter;
	  $stmt2->close();
	  $stmt->close();
	  $mysqli->close();
	  return $totalhtml;
  }
  
  //kasutajate väljakutsumise funkstioon
  function getUsers(){
	  $usersHTML = "";
	  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $mysqli->prepare("SELECT firstname, lastname, email FROM vpusers WHERE id != ?");
	  echo $mysqli->error;
	  $stmt->bind_param("i",$_SESSION["userId"]);
	  $stmt->bind_result($firstname,$lastname,$email);
	  $stmt->execute();
	  while($stmt->fetch()){
		  $usersHTML .= "<p>" .$firstname." ".$lastname." ".$email ."</p> \n";
	  }
	  $stmt->close();
	  $mysqli->close();
	  return $usersHTML;
  }
  
  //Valideeritud sõnumite näitamine
  function allvalidmessages(){
	  $msgHTML = "";
	  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE accepted=1");
	  echo $mysqli->error;
	  $stmt->bind_result($msg);
	  $stmt->execute();
	  while($stmt->fetch()){
		  $msgHTML .= "<p>" .$msg ."</p> \n";
	  }
	  $stmt->close();
	  $mysqli->close();
	  return $msgHTML;
	  
  }
  
  //Valideerin sõnumi
  function valdiatemsg($acceptedby, $accepted, $msgid){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE vpamsg SET acceptedby=?, accepted=?, accepttime=now() WHERE id=?");
	echo $mysqli->error;
	$stmt->bind_param("iii",$acceptedby, $accepted, $msgid);
	$stmt->execute();
	
	
	$notice .= "Sõnum valideeritud";
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  
  //valideerimate sõnumite lugemine
  function readallunvalidatedmessages(){
	$notice = "<ul> \n";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, message FROM vpamsg WHERE accepted IS NULL ORDER BY id DESC");
	echo $mysqli->error;
	$stmt->bind_result($id, $msg);
	$stmt->execute();
	
	while($stmt->fetch()){
		$notice .= "<li>" .$msg .'<br><a href="validatemessage.php?id=' .$id .'">Valideeri</a>' ."</li> \n";
	}
	$notice .= "</ul> \n";
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
    //loen sõnumi valideerimiseks
  function readmsgforvalidation($editId){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
	$stmt->bind_param("i", $editId);
	$stmt->bind_result($msg);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = $msg;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  //lokaalsed muutujad mis kutsutakse välja. nimed ei ole olulised kuid andmed tulevad järjekorras mis leheküljel määratud
  function signup($firstname,$lastname,$birthDate,$gender,$email,$password){
	  $notice = "";
	  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
	  echo $mysqli->error;
	  //valmistame parooli ette salvestamiseks, krüpteerime, teeme räsi(hash)
	  $options = [
	  "cost" => 12,
	  "salt" => substr(sha1(rand()),0, 22),];
	  $pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	  $stmt->bind_param("sssiss",$firstname,$lastname,$birthDate,$gender,$email,$pwdhash);
	  if($stmt->execute()){
		  $notice = "Uue kastuaja lisamine õnnestus";
	  } else {
		  $notice = "Kasutaja lisamisel tekkis viga" .$stmt->error;
	  }
	  
	  $stmt->close();
	 $mysqli->close();
	 return $notice;
  }
  
  //Sisselogimine
  function signin($email, $password){
	  $notice = "";
	  $mysqli = new mysqli ($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	 $stmt = $mysqli->prepare("SELECT id, firstname, lastname, password FROM vpusers WHERE email=?");
	 $mysqli->error;
	 $stmt->bind_param("s", $email);
	 $stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb, $passwordFromDb);
	 if ($stmt->execute()){
		 //kui õnnestus andmebaasist lugemine
		 if($stmt->fetch()){
			 //leiti selline kasutaja
			 if(password_verify($password, $passwordFromDb)){
			 //parool õige
				 $notice = "Logisite õnnelikult sisse!";
				 $_SESSION["userId"] = $idFromDb;
				 $_SESSION["firstname"] = $firstnameFromDb;
				 $_SESSION["lastname"] = $lastnameFromDb;
				 $stmt->close();
				 $mysqli->close();
				 header("Location: Main.php");
				 exit();
				 
			 } else {
				 $notice = "Sisestasite vale salasõna!";
			 }
		 } else {
			 $notice="Sellist kasutajat (".$email .") ei leitud!";
		 }
	 } else {
		 $notice = "Sisselogimisel tekkis tehniline viga!" .$stmt->error;
	 }
	 $stmt->close();
	 $mysqli->close();
	 return $notice;
  }
  
  //anonüümse sõnnumi salvestamine
  function saveamsg($msg){
	 $notice = "";
	 //serveri ühendus (server,kasutaja,parool,andmebaas
     $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	 //valmistan ette SQL käsu
	 $stmt = $mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
	 echo $mysqli->error;
	 //asendame SQL käsus küsimärgi päris infoga (andmetüüp, andmed ise)
	 //s - string(tekst); i - integer(täisarv); d - decimal(murdarv);
	 $stmt->bind_param("s",$msg);
	 if ($stmt->execute()) {
		 $notice = 'Sõnum: "' .$msg .'" on salvestatud.';
	 } else {
		 $notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
	 }	
	 
  }  
  
  function listallmessages(){
	  $msgHTML = "";
	  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $mysqli->prepare("SELECT message FROM vpamsg");
	  echo $mysqli->error;
	  $stmt->bind_result($msg);
	  $stmt->execute();
	  while($stmt->fetch()){
		  $msgHTML .= "<p>" .$msg ."</p> \n";
	  }
	  $stmt->close();
	  $mysqli->close();
	  return $msgHTML;
	  
  }

  //Tekstsisestuse kontroll
  //echo "toimib";
  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
  
  function savekass($nimi, $v2rv, $saba) {
    $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
    $stmt = $mysqli->prepare('INSERT INTO kass (nimi, v2rv, saba) VALUES (:nimi, :v2rv, :saba)');
	echo $mysqli->error;
	$stmt->bind_param("s",$msg);
	 if ($stmt->execute()) {
		 $notice = 'Sõnum: "' .$msg .'" on salvestatud.';
	 } else {
		 $notice = "Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
	 }	
	 $stmt->close();
	 $mysqli->close();
	 return $notice;

  }
	function readkass() {
	  $msgHTML = "";
	  $mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"], $GLOBALS["database"]);
	  $stmt = $mysqli->prepare('SELECT nimi, v2rv, saba FROM kass');
	  echo $mysqli->error;
	  $stmt->bind_result($msg);
	  $stmt->execute();
	  while($stmt->fetch()){
		  $msgHTML .= "<p>" .$msg ."</p> \n";
	  }
	  $stmt->close();
	  $mysqli->close();
    return $stmt->fetchAll();
  }
?>