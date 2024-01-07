<?php
session_start();
if (isset($_SESSION['user_id'])) {
	include ('header.php');
	echo 'You are logged in!<br>
	<form>
	<textarea name = "comment" cols = "40" rows = "5">	
	</textarea>
	<br><br>
	<input type = "submit" name = "submit" value = "Submit" />
	</form>';
} else { 
	header('Location: https://kaderab6.uwmsois.com/infost440/finalproject/index.php');
}
?>