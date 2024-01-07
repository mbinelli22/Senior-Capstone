<?php

session_start();

if (!isset($_SESSION['agent']) OR ($_SESSION['agent'] != md5($_SERVER['HTTP_USER_AGENT']) )) {
	require ('includes/login_functions.inc.php');
	redirect_user();	
}

$page_title = 'Logged In!';
include ('header.php');

echo "<h1>Logged In!</h1>
<p>You are now logged in, {$_SESSION['first_name']}!</p>
<p><a href=\"logout.php\">Logout</a></p>";

include ('footer.php');
?>