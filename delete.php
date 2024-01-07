<?php 

include('header.php');
include('mysqli_connect.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user_email = $_POST['email'];
    echo "User account has been deleted<br>";


$query = "DELETE FROM users WHERE email = '$user_email'";

$results = mysqli_query($dbc,$query);

if ($results) { 
    echo " ";
} else {
    echo "There was an error" . mysqli_error($dbc);
}
}
?>



<form action = "delete.php" method = "POST">

<fieldset>
    <legend>: Enter customer email address:</legend>

    Email Address: <br/>
    <input type = "text" name = "email" />
    <br><br>


    <input type = "submit" name = "submit" value = "Delete" />

</fieldset>
</form>

<?php include('footer.php'); ?>