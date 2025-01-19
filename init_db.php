<?php

require_once 'config.php';

// Function to check if a table exists
function tableExists($conn, $tableName) {
    $query = "SHOW TABLES LIKE '$tableName';";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// Function to check if a user exists
function userExists($conn, $username) {
    $query = "SELECT * FROM users WHERE username = '$username';";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

// Create 'products' table if it doesn't exist
if (!tableExists($conn, 'products')) {
    $createProductsTable = "CREATE TABLE products (
        id INT(255) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        price VARCHAR(255) NOT NULL,
        image VARCHAR(255) NOT NULL
    );";

    if (mysqli_query($conn, $createProductsTable)) {
        echo "Table 'products' created successfully.\n";
    } else {
        echo "Error creating 'products' table: " . mysqli_error($conn) . "\n";
    }
}

// Create 'users' table if it doesn't exist
if (!tableExists($conn, 'users')) {
    $createUsersTable = "CREATE TABLE users (
        id INT(255) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role VARCHAR(255) NOT NULL
    );";

    if (mysqli_query($conn, $createUsersTable)) {
        echo "Table 'users' created successfully.\n";
    } else {
        echo "Error creating 'users' table: " . mysqli_error($conn) . "\n";
    }
}

// Insert default admin user if not exists
if (!userExists($conn, 'Admin')) {
    $defaultPassword = 'Admin'; // Use plain text password
    $insertAdmin = "INSERT INTO users (username, password, role) VALUES ('Admin', '$defaultPassword', 'admin');";

    if (mysqli_query($conn, $insertAdmin)) {
        echo "Default admin user created successfully.\n";
    } else {
        echo "Error inserting default admin user: " . mysqli_error($conn) . "\n";
    }
}

// Close the connection
mysqli_close($conn);

?>
