<?php
  class Photoupload 
	{
		private $tempname;
		private $imagefiletype;
		private $myTempImage;
		private $myImage;
		public $timdat;
		
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
			
			public function readExif(){
				//vältimaks probleeme [warning], kasutan @ märki
				@$exif = exif_read_data($this->tempname, "ANY_TAG", 0, false);
				//var_dump($exif);
				echo $exif["DateTimeOriginal"];
				$this->timdat = $exif["DateTimeOriginal"];
				
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
				//kui on läbipaistvusega png pildid, siis on vaja säilitada läbipastvus
				imagesavealpha($newImage, true);
				$transColor = imagecolorallocatealpha($newImage, 0,0,0,127);
				imagefill($newImage, 0, 0, $transColor);
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
				$textToimage = $this->timdat;
				$textColor = imagecolorallocatealpha($this->myImage, 255, 255, 255, 70);
				//Mis pilt R,G,B ,ALPHA 0-127
				imagettftext($this->myImage, 20, 0, 10, 30, $textColor ,"../vp_picfiles/ARIALBD.TTF", $textToimage);
			}
			
			public function createThumbnail($filename, $size){
				$imageWidth = imagesx($this->myTempImage);
				$imageHeight = imagesy($this->myTempImage);
				if($imageWidth > $imageHeight){
					$cutSize = $imageHeight;
					$cutX = round(($imageWidth-$cutSize) / 2);
					$cutY = 0;
				} else {
					$cutSize = $imageWidth;
					$cutX = 0;
					$cutY = (($imageHeight-$cutSize) / 2);
				}
				//loome pildiobjeki
				$myThumbnail = imagecreatetruecolor($size, $size);
				imagecopyresampled($myThumbnail, $this->myTempImage, 0, 0, $cutX, $cutY, $size, $size, $cutSize, $cutSize);
				//salvestan
				if ($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
					imagejpeg($myThumbnail, $filename, 90);

				}
				if ($this->imageFileType == "png"){
					imagepng($myThumbnail, $filename, 6);
				}
				if ($this->imageFileType == "gif"){
					imagegif($myThumbnail, $filename);
				}
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