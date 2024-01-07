<?php
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_USER', 'kaderab6_finalprojectadmin');
DEFINE ('DB_PASSWORD', '[D-VPsFjtc4-');
DEFINE ('DB_NAME', 'kaderab6_finalproject');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect');
?>