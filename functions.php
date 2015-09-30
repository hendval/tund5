<?php

	require_once("configGlobal.php");
	$database = "if15_hendval";
	$mysqli = new mysqli($servername, $server_username, $server_password, $database);

	// võtab andmed ja sisestab ab'i
	function createUser(){
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		// ss - s on string email, s on string password
		$stmt->bind_param("ss", $create_email, $hash);
		$stmt->execute();
		$stmt->close();
	}
	
	function loginUser(){
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample where email=? and password=?");
		$stmt->bind_param("ss", $email, $hash);
		
		//muutujad tulemustele
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
	
	
	
	if($stmt->fetch()){
		//ab oli midagi
		echo "Email ja parool õiged!, kasutaja id =".$id_from_db;
		} else {
		//ei leidnud
		echo "Email ja parool valed!";
		}
	$stmt->close();
	}
	
	//paneme ühenduse kinni
	$mysqli->close();
?>