<?php

$conn = mysqli_connect('mysql-db', 'root', 'root', 'cart_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
