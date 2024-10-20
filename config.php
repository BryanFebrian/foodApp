<?php

$conn = mysqli_connect('127.0.0.1:8111', 'root', '', 'cart_db');

//$conn = mysqli_connect('localhost', 'root', '', 'cart_db',3307); //ini punya david

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
