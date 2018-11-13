<?php
  class Photoupload 
	{
		private $tempname;
		private $imagefiletype;
		private $myTempImage;
		private $myImage;
		
		//eriline funktsioon ehk constructor on see, mis käivitatakse kohe, klassi kasutuselevõtmisel ehk objekti loomisel
		function __construct($name, $type){
			$this->tempname = $name;
			$this->imageFileType = $type;
			$this->createImageFromFile();
		}
		

		function __destruct(){
			imagedestroy($this->myTempImage);
			imagedestroy($this->myImage);
		}
		
		private function createimagefromfile(){
				//sõltuvalt faili tüübist loon sobiva pildiobjekti
				if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
					$this->myTempImage = imagecreatefromjpeg($this->tempname);
				}
				if($this->imageFileType == "png"){
					$this->myTempImage = imagecreatefrompng($this->tempname);
				}
				if($this->imageFileType == "gif"){
					$this->myTempImage = imagecreatefromgif($this->tempname);
				}
			}
			
			public function changephotosize($width, $height){
				//pildi orginaalsuurus
				$imageWidth = imagesx($this->myTempImage);
				$imageHeight = imagesy($this->myTempImage);
				//leian suuruse muutmise suhtarvu
				if($imageWidth > $imageHeight){
					$sizeRatio = $imageWidth / $width;
				} else {
					$sizeRatio = $imageHeight / $height;
				}
				
				$newWidth = round($imageWidth / $sizeRatio);
				$newHeight = round($imageHeight / $sizeRatio);
				
				$this->myImage = $this->resizeImage($this->myTempImage, $imageWidth, $imageHeight, $newWidth, $newHeight);
				
			}
			
			private function resizeImage($image, $ow, $oh, $w, $h){
				$newImage = imagecreatetruecolor($w, $h);
				imagecopyresampled($newImage, $image, 0, 0, 0, 0, $w, $h, $ow, $oh);
				return $newImage;
			}
			
			public function addWatermark(){
				//vesimärgi lisamine pildile
				$watermark = imagecreatefrompng("../vp_picfiles/vp_logo_w100_overlay.png");
				$watermarkWidth = imagesx($watermark);
				$watermarkHeight = imagesy($watermark);
				$watermarkPosx = imagesx($this->myImage) - $watermarkWidth - 10;
				$watermarkPosy = imagesy($this->myImage) - $watermarkHeight - 10;
				imagecopy($this->myImage, $watermark, $watermarkPosx, $watermarkPosy, 0, 0, $watermarkWidth ,$watermarkHeight);
			}
			
			public function addtextToImage(){
				//tekst vesimärgina
				$textToimage = "Veebiprogrammeerimine";
				$textColor = imagecolorallocatealpha($this->myImage, 255, 255, 255, 90);
				//Mis pilt R,G,B ,ALPHA 0-127
				imagettftext($this->myImage, 20, 0, 10, 30, $textColor ,"../vp_picfiles/ARIALBD.TTF", $textToimage);
			}
			
			public function savephoto($target_file){
				$notice = null;
				//faili salvestamine, jälle sõltuvalt failitüübist
				if ($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
					if(imagejpeg($this->myImage, $target_file, 90)){
						$notice = 1;
					} else {
						$notice = 0;
					}
				}
				if ($this->imageFileType == "png"){
					if(imagepng($this->myImage, $target_file, 6)){
						$notice = 1;
					} else {
						$notice = 0;
					}
				}
				if ($this->imageFileType == "gif"){
					if(imagegif($this->myImage, $target_file)){
						$notice = 1;
					} else {
						$notice = 0;
					}
				}
				return $notice;
			}
			
		

	}//class lõppeb

?>