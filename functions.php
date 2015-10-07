<?php

	require_once("configGlobal.php");
	$database = "if15_hendval";

	// tekitatakse sessioon, mida hoitakse serveris
	// kõik session muutujad on kättesaadavad kuni viimase brauseri akna sulgemiseni
	session_start();
	
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
	}
  
	// võtab andmed ja sisestab ab'i
	function createUser($create_email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		// ss - s on string email, s on string password
		$stmt->bind_param("ss", $create_email, $hash);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	
	function loginUser($email, $hash){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample where email=? and password=?");
		$stmt->bind_param("ss", $email, $hash);
		//muutujad tulemustele
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()){
			//ab oli midagi
			echo "Email ja parool õiged!, kasutaja id =".$id_from_db;
		
			// tekitan sessiooni muutujad
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $email_from_db;
			
			// suunan data.php lehele
			header("Location: data.php");
		
		} else {
		//ei leidnud
		echo "Email ja parool valed!";
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function addCarPlate($number_plate, $color, $user_id){
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO car_plates (number_plate, color, user_id) VALUES (?,?,?)");
		$stmt->bind_param("ssi", $number_plate, $color, $user_id);
		
		//sõnum
		$message = "";
		
		if($stmt->execute()){
			$message = "Sai edukalt lisatud!";
			
		}else{
			echo $stmt->error;
		}
		
		return $message;

		$stmt->close();
		$mysqli->close();
	}
	
	//paneme ühenduse kinni
?>