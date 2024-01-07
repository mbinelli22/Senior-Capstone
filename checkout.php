<?php

session_start();

include('header.php');
include('mysqli_connect.php');

$q = "SELECT item_name AS name, item_upc AS dr, item_id AS id FROM items ORDER BY item_name ASC";    
$r = @mysqli_query($dbc, $q); 

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
    } else {
        echo "Error: " . mysqli_error($dbc);
    }
}

$query = "SELECT * FROM items WHERE checked_out_by_id IS NULL ORDER BY item_name ASC";

// Search functionality
// $searchCondition = "";
// if (isset($_GET['search'])) {
//     $searchTerm = mysqli_real_escape_string($dbc, trim($_GET['search']));
//     $searchCondition = " AND item_name LIKE '%$searchTerm%'";
// }

// $query .= $searchCondition;

$results = mysqli_query($dbc, $query);
if (!$results) {
    die("Query failed: " . mysqli_error($dbc));
}

echo '<div style="text-align: center;">';
echo '<h2 style="font-size: 24px;">Available Books for Checkout</h2>';

// Search form
// echo '<form method="get" action="checkout.php" style="margin-bottom: 20px;">';
// echo '<label for="search">Search:</label>';
// echo '<input type="text" name="search" id="search" placeholder="Enter book title">';
// echo '<input type="submit" value="Search" style="background-color: #000080; color: #fff; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer;">';
// echo '</form>';

while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
    // Check if the book has been checked out
    if ($row['checked_out_by_id'] === null) {
        echo '<form method="post" action="checkout.php">';
        echo '<div style="background-color: #f4f4f4; border-radius: 10px; padding: 10px; margin-bottom: 15px;">';
        echo '<strong style="font-size: 18px;">Title:</strong> ' . $row['item_name'] . '<br>';
        echo '<strong>ISBN:</strong> ' . $row['item_upc'] . '<br>';
        echo '<input type="hidden" name="item_id" value="' . $row['item_id'] . '">';
        echo '<input type="submit" name="checkout" value="Checkout" style="background-color: #000080; color: #fff; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer;">';
        echo '</div>';
        echo '</form>';
    }
}

echo '</div>';

include('footer.php');
?>
