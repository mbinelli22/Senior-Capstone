<?php
session_start();
$page_title = 'Profile';
include('header.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Include the database connection file
include('mysqli_connect.php');

// Fetch user information
$user_id = $_SESSION['user_id'];
$query_user = "SELECT first_name, last_name, email FROM users WHERE user_id = $user_id";
$result_user = mysqli_query($dbc, $query_user);

if ($result_user && mysqli_num_rows($result_user) > 0) {
    $row_user = mysqli_fetch_assoc($result_user);
    $first_name = $row_user['first_name'];
    $last_name = $row_user['last_name'];
    $email = $row_user['email'];

    // Fetch checked out books for the user
    $query_books = "SELECT item_name FROM items WHERE checked_out_by_id = $user_id";
    $result_books = mysqli_query($dbc, $query_books);

    if ($result_books) {
        // Display user information
        echo "<h1>Welcome, $first_name $last_name!</h1>";
        echo "<p>Email: $email</p>";

        // Display checked out books
        echo '<h2>Your Checked Out Books:</h2>';
        echo '<ul class="checked-out-books">';
        while ($book_row = mysqli_fetch_assoc($result_books)) {
            echo '<li>' . $book_row['item_name'] . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p class="error">Error fetching checked out books: ' . mysqli_error($dbc) . '</p>';
    }
} else {
    echo '<p class="error">Error fetching user information.</p>';
}

mysqli_close($dbc);

include('footer.php');
?>
