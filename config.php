<?php

$conn = mysqli_connect('127.0.0.1:8111', 'root', '', 'cart_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
