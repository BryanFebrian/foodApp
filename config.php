<?php

$conn = mysqli_connect('mysql-db', 'root', 'root', 'cart_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Cek apakah database "test_db" sudah ada
$db_check = $conn->query("SHOW DATABASES LIKE '$db_name'");
if ($db_check->num_rows === 0) {
    // Buat database jika belum ada
    $conn->query("CREATE DATABASE $db_name");
}

// Pilih database "test_db"
$conn->select_db($db_name); // Setelah database dibuat, pilih database

// Cek apakah tabel "products" sudah ada
$product_table_check = $conn->query("SHOW TABLES LIKE 'products'");
if ($product_table_check->num_rows === 0) {
    // Buat tabel "products" jika belum ada
    $conn->query("CREATE TABLE products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        price INT(255) NOT NULL,
        image VARCHAR(255) NOT NULL
    )");
}

// Cek apakah tabel "user" sudah ada
$user_table_check = $conn->query("SHOW TABLES LIKE 'users'");
if ($user_table_check->num_rows === 0) {
    // Buat tabel "user" jika belum ada
    $conn->query("CREATE TABLE users (
        id INT(255) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(255) NOT NULL
    )");

    // Tambahkan data admin ke tabel "user"
    $conn->query("INSERT INTO users (username, password, role) VALUES ('admin', 'admin123', 'admin')");
} else {
    // Cek apakah data admin sudah ada
    $admin_check = $conn->query("SELECT * FROM users WHERE username = 'admin'");
    if ($admin_check->num_rows === 0) {
        // Tambahkan data admin jika belum ada
        $conn->query("INSERT INTO users (username, password, role) VALUES ('admin', 'admin123', 'admin')");
    }
}
?>
