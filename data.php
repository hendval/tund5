<?php
	require_once("functions.php");
	// kui kasutaja ei ole sisse logitud
	// siis suunan data.php lehele
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	// kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		// kustutame kõik session muutujad ja peateme sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	$number_plate = "";
	$color = "";
	$number_plate_error = "";
	$color_error = "";
	
	// keegi vajutas add plate nuppu
	if(isset($_POST["add_plate"])){
		if (empty($_POST["number_plate"])) {
				$number_plate_error = "See väli on kohustuslik";
		}else{
			$number_plate = cleanInput($_POST["number_plate"]);
		}
		if (empty($_POST["color"])) {
				$color_error = "See väli on kohustuslik";
		}else{
			$color = cleanInput($_POST["color"]);
		}
		if ($number_plate_error == "" and $color_error == ""){
			$msg = addCarPlate($number_plate, $color, $_SESSION["logged_in_user_id"]);	
		
			if($msg != ""){
				$number_plate = "";
				$color = "";
				echo $msg;
			}
		}
	}
	
	
?>
<p>
	Tere, <?=$_SESSION["logged_in_user_email"];?>
	<br><a href="?logout=1">Logi välja</a>
</p>
<br>
<h2>Lisa autonumbrimärk</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="number_plate">Auto numbrimärk</label><br>
  	<input name="number_plate" id="number_plate" type="text" value="<?php echo $number_plate; ?>"> <?php echo $number_plate_error; ?><br><br>
	<label for="color">Auto värv</label><br>
  	<input name="color" id="color" type="text" value="<?php echo $color; ?>"> <?php echo $color_error; ?><br><br>
  	<input type="submit" name="add_plate" value="Salvesta">
 </form>