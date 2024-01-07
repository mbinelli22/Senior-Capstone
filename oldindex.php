<?php

session_start();

include('header.php');
include('mysqli_connect.php');

	if (isset($_SESSION['first_name'])) {
		echo "You currently logged in as {$_SESSION['first_name']}.";
}

if (isset($_GET['delete_id']) && (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 6))) {
    $delete_id = mysqli_real_escape_string($dbc, trim($_GET['delete_id']));
    $delete_query = "DELETE FROM items WHERE item_id = " . $delete_id;
    $delete_results = mysqli_query($dbc, $delete_query);
    if ($delete_results){
        echo "<h3 style = \"background-color:blue;\">COMMENT DELETED</h3><br>";
}

}else{
    $delete_id = "";
}

$display = 5;

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

?>

<?php
$query = "SELECT * FROM items ORDER BY $order_by LIMIT $start, $display";
$results = mysqli_query($dbc, $query);

    if ($results) {
        echo "Database loaded successfully<br><br>";
    } else {
        echo "There was an error";
    }
    ?>
Recently Added Titles: <----what is this?

<?php
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
  echo "<div class=\"w3-card4\" style=\width:85%;\">";
  echo "<header class = \"w3-container w3-blue\">";
  echo "<h2>" . $row["item_name"]. " </h1>";
  echo "<div class=\"w3-card4\" style=\width:85%;\">";
  echo "</header>";
  echo "</div>";
  echo "<footer class = \"w3-container w3-blue\">";
  echo "<h5> Item ID: ". $row['item_id'] . "<br>ISBN: ". $row['item_upc'] . "</h5>";
  echo "<h5>";
  echo "</footer>";
  echo "<br><br>";
}

?>

<?php

if ($pages > 1) {

	echo '<br /><p>';
	$current_page = ($start/$display) + 1;
	
	if ($current_page != 1) {
	echo '<a href="?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}
	for ($i = 1; $i <= $pages; $i++) {
	if ($i != $current_page) {
	echo '<a href="?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
	} else {
	echo $i . ' ';
	}
	} 
	if ($current_page != $pages) {
	echo '<a href="?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</p>';
	
	} 
include('footer.php');
?>
