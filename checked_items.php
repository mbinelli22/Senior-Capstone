<?php # Script 9.6 - view_users.php #2
// This script retrieves all the records from the users table.

$page_title = 'Checked Out';
include ('header.php');

// Page header:
echo '<h1>Added Items</h1>';

require ('mysqli_connect.php'); // Connect to the db.
		
// Make the query:
$q = "SELECT item_name AS name, item_upc AS dr FROM items ORDER BY item_name ASC";		
$r = @mysqli_query ($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

	// Print how many users there are:
	echo "<p>There are currently $num items in the online database.</p>\n";
    echo "<p>To search for an item or ISBN, please use CTRL + F.</p>\n";

	// Table header.
	echo '<table align="center" cellspacing="3" cellpadding="3" width="75%">
	<tr><td align="left"><b>Item Name</b></td><td align="left"><b>Item ISBN</b></td></tr>
';
	
	// Fetch and print all the records:
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr><td align="left">' . $row['name'] . '</td><td align="left">' . $row['dr'] . '</td></tr>
		';
	}

	echo '</table>'; // Close the table.
	
	mysqli_free_result ($r); // Free up the resources.	

} else { // If no records were returned.

	echo '<p class="error">There are currently no checked items.</p>';

}

mysqli_close($dbc); // Close the database connection.

include ('footer.php');
?>