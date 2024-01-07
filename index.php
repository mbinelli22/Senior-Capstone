<?php
session_start();

include('header.php');
include('mysqli_connect.php');

// Check if the user is logged in
if (isset($_SESSION['first_name'])) {
    echo "You are currently logged in as {$_SESSION['first_name']}.";
}

// Delete operation
if (isset($_GET['delete_id']) && (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 6))) {
    $delete_id = mysqli_real_escape_string($dbc, trim($_GET['delete_id']));
    $delete_query = "DELETE FROM items WHERE item_id = " . $delete_id;
    $delete_results = mysqli_query($dbc, $delete_query);
    if ($delete_results) {
        echo "<h3 style=\"background-color:blue;\">COMMENT DELETED</h3><br>";
    }
} else {
    $delete_id = "";
}

$display = 10;

// Pagination and sorting logic
if (isset($_GET['p']) && is_numeric($_GET['p'])) {
$pages = $_GET['p'];
} else { 
$q = "SELECT COUNT(item_id) FROM items";
$r = mysqli_query ($dbc, $q);
$rowp = mysqli_fetch_array ($r, MYSQLI_NUM);
$records = $rowp[0];

if ($records > $display) { 
$pages = ceil ($records/$display);
} else {
$pages = 1;
}
}

if (isset($_GET['s']) && is_numeric($_GET['s'])) {
$start = $_GET['s'];
} else {
$start = 0;
}
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'title';
switch ($sort) {

case 'oldest':
$order_by = 'item_name ASC';
break;

default:
$order_by = 'item_name DESC';
$sort = 'recent';
break;
}

$query = "SELECT * FROM items ORDER BY $order_by LIMIT $start, $display";
$results = mysqli_query($dbc, $query);

if ($results) {
    echo "...Database loaded successfully...<br><br>";
} else {
    echo "There was an error";
}
?>

<!-- HTML Markup -->

<?php while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)): ?>
    <div class="books-container">
    <div class="book-card">
        <div class="book-content">
        	<div class="book-title">
            	<h2><?= $row["item_name"] ?></h2>
        	</div>
        	<div class="book-data">
            	<h5> Item ID: <?= $row['item_id'] ?><br>ISBN: <?= $row['item_upc'] ?></h5>
        	</div>
    	</div>
    </div>	
    </div>
<?php endwhile; ?>

<!-- Pagination Links -->
<?php if ($pages > 1): ?>
    <br/><p>
        <?php
        // Pagination links logic
        $current_page = ($start/$display) + 1;
		if ($current_page != 1) {
			echo '<a href="?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
		}
		for ($i = 1; $i <= $pages; $i++) {
			if ($i != $current_page) {
				echo '<a href="?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
			} else {
				echo $i . ' ';}
		} 
		if ($current_page != $pages) {
			echo '<a href="?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
		}
        ?>
    </p>
<?php endif; ?>

<?php include('footer.php'); ?>
