<?php
session_start();

include('header.php');
include('mysqli_connect.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 6) {

    header('Location: login.php');
    exit();
}

if (isset($_POST['return']) && isset($_POST['item_id'])) {
    $bookId = mysqli_real_escape_string($dbc, trim($_POST['item_id']));
    $updateQuery = "UPDATE items SET checked_out_by_id = NULL WHERE item_id = $bookId";
    $updateResult = mysqli_query($dbc, $updateQuery);

    if ($updateResult) {
        echo '<p>Book return successful!</p>';
    } else {

        echo '<p>Could not return book: ' . mysqli_error($dbc) . '</p>';
    }
}

$query = "SELECT items.item_id, items.item_name, items.item_upc, users.user_id, users.first_name, users.last_name, users.email FROM items JOIN users ON items.checked_out_by_id = users.user_id WHERE items.checked_out_by_id IS NOT NULL";
$results = mysqli_query($dbc, $query);

if (!$results) {
    die("Error: " . mysqli_error($dbc));
}

echo '<h2>Checked Out Books</h2>';
echo '<form method="post" action="admin_uncheck.php">';

if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
        echo '<div>';
        echo '<strong>Title:</strong> ' . $row['item_name'] . '<br>';
        echo '<strong>ISBN:</strong> ' . $row['item_upc'] . '<br>';
        echo '<strong>Checked Out By:</strong> ' . $row['first_name'] . ' ' . $row['last_name'] . ' (Email Address: ' . $row['email'] . ')<br>';
        echo '<input type="hidden" name="item_id" value="' . $row['item_id'] . '">';
        echo '<input type="submit" name="return" value="Return">';
        echo '</div><br>';
    }

    echo '</form>';
} else{
    echo '<p>There are no books currently checked out.</p>';
}

include('footer.php');
?>
