<?php

session_start(); 

if (!isset($_SESSION['user_id'])) {
	require ('login_functions.inc.php');
	redirect_user();	
	
} else {
	$_SESSION = array();
	session_destroy();
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0);
}

$page_title = 'Logged Out!';
include ('header.php');

echo "<h1>Logged Out!</h1>
<p>You are now logged out!</p>";

include ('footer.php');
?>