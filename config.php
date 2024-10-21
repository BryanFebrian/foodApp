<?php

$conn = mysqli_connect('127.0.0.1:8111', 'root', '', 'cart_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Koneksi ke database users_db
$conn_users = mysqli_connect('127.0.0.1:8111', 'root', '', 'user_db');

// Cek koneksi ke users_db
if (!$conn_users) {
    die("Connection failed to user_db: " . mysqli_connect_error());
}
?>
