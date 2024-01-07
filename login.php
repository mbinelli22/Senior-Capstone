<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require ('login_functions.inc.php');
	require ('mysqli_connect.php');

	list ($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);
	
	if ($check) {
		session_start();
		$_SESSION['user_id'] = $data['user_id'];
		$_SESSION['first_name'] = $data['first_name'];
		$_SESSION['last_name'] = $data['last_name'];
		$_SESSION['email'] = $data['email'];
		$_SESSION['registration_date'] = $data['registration_date'];
		$_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);

		redirect_user('loggedin.php');
			
	} else {
		$errors = $data;

	}
		
	mysqli_close($dbc);
}
include ('login_page.inc.php');
?>