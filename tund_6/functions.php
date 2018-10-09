<?php
  //laen andmebaasi info
  require ("../../../config.php");
  //echo $GLOBALS["serverUsername"];
  $database = "if18_steven_sa_1";
  
  //võtan kasutusele sessiooni
  session_start();
  
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