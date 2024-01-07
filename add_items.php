<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Item Addition';
include ('header.php');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('mysqli_connect.php'); // Connect to the db.
		
	$errors = array(); // Initialize an error array.
	
	// Check for a first name:
	if (empty($_POST['item_name'])) {
		$errors[] = 'You forgot to enter item name.';
	} else {
		$fn = mysqli_real_escape_string($dbc, trim($_POST['item_name']));
	}
	
	// Check for a last name:
	if (empty($_POST['item_upc'])) {
		$errors[] = 'You forgot to enter item ISBN';
	} else {
		$ln = mysqli_real_escape_string($dbc, trim($_POST['item_upc']));
	}
	
	
	if (empty($errors)) { // If everything's OK.
	
		// Register the user in the database...
		
		// Make the query:
		$q = "INSERT INTO items (item_name, item_upc) VALUES ('$fn', '$ln')";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>Item added!</p><p><br /></p>';	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
			
			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.
		
		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('footer.php'); 
		exit();
		
	} else { // Report the errors.
	
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<h1>Add new title</h1>
<form action="add_items.php" method="post">
	<p>Book Name: <input type="text" name="item_name" size="15" maxlength="20" value="<?php if (isset($_POST['item_name'])) echo $_POST['item_name']; ?>" /></p>
	<p>ISBN: <input type="text" name="item_upc" size="15" maxlength="40" value="<?php if (isset($_POST['item_upc'])) echo $_POST['item_upc']; ?>" /></p>
	<p><input type="submit" name="submit" value="Submit" /></p>
</form>
<?php include ('footer.php'); ?>