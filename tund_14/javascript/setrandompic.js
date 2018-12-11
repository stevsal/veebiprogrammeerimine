window.onload = function(){
	//document.getElementById("pic").innerHTML = "<p>Siia tuleb pilt!</p> \n";
	setRandPic();
	document.getElementById("pic").addEventListener("click", setRandPic);
	
}

function setRandPic(){
	//AJAX, loome veebipäringu, määrame mis juhtub, kui see edukalt tehtud saab ja saadud vastust kasutame lehel javascripti abil sisu muutmiseks
	let request = new XMLHttpRequest();
	request.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			//Järgmisena on asjad, mida javascript teab tulemusega tegema
			document.getElementById("pic").innerHTML = this.responseText;
		}
	}
	//siin määrate veebiaadressi ja parameetrid
	request.open("GET", "setrandompic.php", true);
	request.send();
	//AJAX lõppeb
}