<?php
  class Test 
	{
		//omadused ehk muutujad
		private $secretnumber;
		public $publicnumber;
		
		//eriline funktsioon ehk constructor on see, mis käivitatakse kohe, klassi kasutuselevõtmisel ehk objekti loomisel
		function __construct($sentnumber){
			$this->secretnumber = 5;
			$this->publicnumber = $this->secretnumber * $sentnumber;
			$this->tellsecret();
		}
		
		//eriline funktsioon mida kasutatakse, kui klass suletakse/objekt eemaldatakse.
		function __destruct(){
			echo "Lõpetame !";
		}
		
		private function tellsecret(){
			echo "Salajane number on: " .$this->secretnumber;
		}
		
		public function tellinfo(){
			echo "Saladusi ei paljasta!";
		}
		
	}//class lõppeb

?>