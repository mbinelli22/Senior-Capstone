<?php

function redirect_user ($page = 'index.php') {
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	$url = rtrim($url, '/\\');
	$url .= '/' . $page;

	header("Location: $url");
	exit();
}

function check_login($dbc, $email = '', $pass = '') {
	$errors = array();

	if (empty($email)) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($email));
	}

	if (empty($pass)) {
		$errors[] = 'You forgot to enter your password.';
	} else {
		$p = mysqli_real_escape_string($dbc, trim($pass));
	}

	if (empty($errors)) {
		$q = "SELECT * FROM users WHERE email='$e' AND pass=SHA2('$p',256)";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		
		if (mysqli_num_rows($r) == 1) {

			$row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
	
			return array(true, $row);
			
		} else {
			$errors[] = 'The email address and password entered do not match those on file.';
		}
		
	}
	return array(false, $errors);

}