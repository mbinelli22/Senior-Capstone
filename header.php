<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');

// if (isset($_SESSION['user_id']) && (basename($_SERVER['PHP_SELF']) != 'logout.php')) {
// 	echo '<a href="logout.php">Logout</a><br>';
// } else {
// 	echo '<a href="login.php">Login</a>';
// } 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Guestbook</title>
        <meta name = "viewport" content = "width=device-width, initial-scale = 1">
        <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    </head>
    <body>
        <div class="header">
            <img src="logo.png" alt="Logo">
        </div>
        <div class="navbar" style="background-color:#000080;">
            <a href = "index.php">Homepage</a>
            <a href = "register.php">Add New Account</a>
            <?php
            if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 6)) {
                echo '<a href = "view_users.php">Find Account</a>';
                echo '<a href = "checked_items.php">View Added Titles</a>';
                echo '<a href = "add_items.php">Add New Title</a>';
                echo '<a href = "admin_uncheck.php">Return Title</a>';
                echo '<a href = "delete.php">Delete Account</a>';
            }
            if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] > 0)) {
                echo '<a href = "profile.php">Profile</a>';
                echo '<a href = "checkout.php">Checkout</a>';
            }
            if (isset($_SESSION['user_id']) && (basename($_SERVER['PHP_SELF']) != 'logout.php')) {
                echo '<a href="logout.php" class="right">Logout</a>';}
            else{
                echo '<a href="login.php" class="right">Login</a>';}
            ?>
        </div>
        