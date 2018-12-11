<?php
	require ("../../../config.php");
	$database = "if18_steven_sa_1";
	$privacy = 2;
	$limit = 10;
	$photoList = [];
	$html = NULL;
	$conn = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy <= ? AND deleted IS NULL ORDER BY id DESC LIMIT ? ");
	echo $conn->error;
	$stmt->bind_param("ii", $privacy, $limit);
	$stmt->bind_result($filenamefromDB, $alttextfromDB);
	$stmt->execute();
	while($stmt->fetch()){
		$myPhoto = new StdClass();
		$myPhoto->filename = $filenamefromDB;
		$myPhoto->alttext = $alttextfromDB;
		array_push($photoList, $myPhoto);
		
	}
	
	$picCount = count($photoList);
	$picNum = mt_rand(0, $picCount - 1);
	$html = '<img src="' .$picDir .$photoList[$picNum]->filename .'" alt="' .$photoList[$picNum]->alttext .'">' ."\n";
	
	$stmt->close();
	$conn->close();
	echo $html;
	
?>