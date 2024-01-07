<?php

$page_title = 'Add New Account';
include('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require('mysqli_connect.php');

    $errors = array();

    // Validate input fields
    $fn = validateInput('first_name', 'Please enter your first name.');
    $ln = validateInput('last_name', 'Please enter your last name.');
    $e = validateInput('email', 'Please enter your email address.');
    $p = validatePassword('pass1', 'pass2', 'Please make sure passwords match.');

    if (empty($errors)) {
        $hashed_password = password_hash($p, PASSWORD_BCRYPT);

        $q = "INSERT INTO users (first_name, last_name, email, pass, registration_date) 
              VALUES ('$fn', '$ln', '$e', '$hashed_password', NOW() )";

        $r = @mysqli_query($dbc, $q);
        if ($r) {
            echo '<h1>Thank you!</h1>
                  <p>Customer is now registered</p<br/>';
        } else {
            echo '<h1>System Error</h1>
                  <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
        }

        mysqli_close($dbc);
        include('footer.php');
        exit();
    } else {
        echo '<h1>Error!</h1>
              <p class="error">The following error(s) occurred:<br />';
        foreach ($errors as $msg) {
            echo " - $msg<br />\n";
        }
        echo '</p><p>Please try again.</p><p><br /></p>';
    }

    mysqli_close($dbc);
}

function validateInput($field, $errorMessage)
{
    global $dbc, $errors;

    if (empty($_POST[$field])) {
        $errors[] = $errorMessage;
    } else {
        return mysqli_real_escape_string($dbc, trim($_POST[$field]));
    }

    return null;
}

function validatePassword($pass1Field, $pass2Field, $errorMessage)
{
    global $errors,$dbc;

    if (!empty($_POST[$pass1Field])) {
        if ($_POST[$pass1Field] != $_POST[$pass2Field]) {
            $errors[] = $errorMessage;
        } else {
             $p = mysqli_real_escape_string($dbc, trim($_POST[$pass1Field]));
             return $p;
        }
    } else {
        $errors[] = 'Please enter your password.';
    }

    return null;
}

?>

<h1>Sign Up</h1>
<form action="register.php" method="post">
    <p>First Name: <input type="text" name="first_name" size="15" maxlength="20"
            value="<?= isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : '' ?>" /></p>
    <p>Last Name: <input type="text" name="last_name" size="15" maxlength="40"
            value="<?= isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : '' ?>" /></p>
    <p>Email Address: <input type="text" name="email" size="20" maxlength="60"
            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" /> </p>
    <p>Password: <input type="password" name="pass1" size="10" maxlength="20"
            value="<?= isset($_POST['pass1']) ? htmlspecialchars($_POST['pass1']) : '' ?>" /></p>
    <p>Confirm Password: <input type="password" name="pass2" size="10" maxlength="20"
            value="<?= isset($_POST['pass2']) ? htmlspecialchars($_POST['pass2']) : '' ?>" /></p>
    <p><input type="submit" name="submit" value="Register" /></p>
</form>

<?php include('footer.php'); ?>
