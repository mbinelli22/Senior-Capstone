<?php
session_start();

$page_title = 'View the Current Users';
include ('header.php');
require ('mysqli_connect.php');

echo '<h2>Welcome to your profile, ' . $_SESSION['first_name'] . '!</h2><br>';
echo '<strong>First Name: </strong>' . ($_SESSION['first_name'] ?? '') . '<br>';
echo '<strong>Last Name: </strong>' . ($_SESSION['last_name'] ?? '') . '<br>';
echo '<strong>Email: </strong>' . ($_SESSION['email'] ?? '') . '<br>';
echo '<strong>Signup Date: </strong>' . ($_SESSION['registration_date'] ?? '<br>') . '';

$query = "SELECT item_name, item_upc FROM items WHERE checked_out_by_id = {$_SESSION['user_id']}";
$result = mysqli_query($dbc, $query);

if ($result) {
    echo '<h3><strong>Checked Out Books:</strong></h3>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<strong>Title: </strong>' . $row['item_name'] . ', <strong>ISBN: </strong>' . $row['item_upc'] . '<br>';
}mysqli_free_result($result);
} else {
    echo 'Error retrieving checked books: ' . mysqli_error($dbc);
}

mysqli_close($dbc);
include ('footer.php');
?>