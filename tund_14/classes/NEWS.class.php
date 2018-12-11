<?php
  class News 
	{
		//omadused ehk muutujad
		//private $secretnumber;
		private $serverHost;
		private $serverUsername;
		private $serverPassword;
		private $database;
		
		//eriline funktsioon ehk constructor on see, mis käivitatakse kohe, klassi kasutuselevõtmisel ehk objekti loomisel
		function __construct($host, $username, $password, $database){
			$this->serverHost = $host;
			$this->serverUsername = $username;
			$this->serverPassword = $password;
			$this->database = $database;
			
		}
		
		public function savenews($userid,$senttitle, $sentnews, $expiredate ){
	 $notice = "";
	 //serveri ühendus (server,kasutaja,parool,andmebaas
     $mysqli = new mysqli($this->serverHost, $this->serverUsername ,$this->serverPassword, $this->database);
	 //valmistan ette SQL käsu
	 $stmt = $mysqli->prepare("INSERT INTO vpnews (userid, title, content, expire) VALUES (?, ?, ?, ?)");
	 echo $mysqli->error;
	 //asendame SQL käsus küsimärgi päris infoga (andmetüüp, andmed ise)
	 //s - string(tekst); i - integer(täisarv); d - decimal(murdarv);
	 $stmt->bind_param("issi",$userid,$senttitle,$sentnews,$expiredate);
	 if ($stmt->execute()) {
		 $notice = 'Uudis on salvestatud.';
	 } else {
		 $notice = "Uudise salvestamisel tekkis tõrge: " .$stmt->error;
	 }	
	 return $notice;
  }  
		
		
	}//class lõppeb

?>