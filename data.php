<?php
	require_once("functions.php");

	// kui kasutaja ei ole sisse logitud
	// siis suunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?>
	<br><a href="?logout=1">Logi välja</a>
</p>