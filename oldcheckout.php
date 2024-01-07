<?php

session_start();

include('header.php');
include('mysqli_connect.php');

$q = "SELECT item_name AS name, item_upc AS dr, item_id AS id FROM items ORDER BY item_name ASC";	
$r = @mysqli_query ($dbc, $q); 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['checkout']) && isset($_POST['item_id'])) {
    $bookId = mysqli_real_escape_string($dbc, trim($_POST['item_id']));
    $updateQuery = "UPDATE items SET checked_out_by_id = {$_SESSION['user_id']} WHERE item_id = $bookId";
    $updateResult = mysqli_query($dbc, $updateQuery);
    if ($updateResult) {
        echo '<script>
                setTimeout(function(){
                    window.location.href = "checkout_redirect.php";
                }, 1000); // 1000 milliseconds delay (1 second)
            </script>';
        exit();
}   else {
        echo "Error: " . mysqli_error($dbc);
}
}

$query = "SELECT * FROM items WHERE checked_out_by_id IS NULL ORDER BY item_name ASC";
$results = mysqli_query($dbc, $query);
if (!$results) {
    die("Query failed: " . mysqli_error($dbc));
}

echo '<h2 style="text-align: center;">Available Books for Checkout</h2>';
echo '<form method="post" action="checkout.php">';
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) { 
    echo '<div>';
    echo '<strong>Title:</strong> ' . $row['item_name'] . '<br>';
    echo '<strong>ISBN:</strong> ' . $row['item_upc'] . '<br>';
    echo '<input type="hidden" name="item_id" value="' . $row['item_id'] . '">';
    echo '<input type="submit" name="checkout" value="Checkout">';
    echo '</div><br>';
}
echo '</form>';

include('footer.php');
?>