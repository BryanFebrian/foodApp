<?php
// Koneksi ke database - Cara 1:
//$servername = "localhost"; // ganti dengan server database Anda
//$username = "username"; // ganti dengan username database Anda
//$password = "password"; // ganti dengan password database Anda
//$dbname = "cart_db"; // ganti dengan nama database Anda

//Koneksi ke Database - Cara 2:
@include 'config.php';

/// Ambil produk unggulan (3 produk)
$sql_best = "SELECT image, name, price FROM products WHERE id IN (1, 2, 3)"; // Ganti dengan ID produk yang ingin ditampilkan
$result_best = $conn->query($sql_best);

// Ambil semua produk
$sql_all = "SELECT image, name, price FROM products";
$result_all = $conn->query($sql_all);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UrFood</title>
    <link rel="stylesheet" href="css/home_style.css"> <!-- Link ke file CSS -->
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">UrFood</div>
        <div class="search-bar">
            <input type="text" placeholder="Search products...">
            <button type="button">Search</button>
        </div>
        <button class="about-us" onclick="location.href='about.php'">About Us</button>
    </header>

    <!-- Our Best Products -->
    <section class="best-products">
        <h2>Our Best Products</h2>
        <div class="products">
            <?php
            if ($result_best->num_rows > 0) {
                while ($row = $result_best->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='uploaded_img/" . $row['image'] . "' alt='" . $row['name'] . "'>";
                    echo "<h3>" . $row['name'] . "</h3>";
                    echo "<p>Price: $" . $row['price'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "Tidak ada produk unggulan.";
            }
            ?>
        </div>
    </section>

    <!-- All Products -->
    <section class="all-products">
        <h2>All Products</h2>
        <div class="products">
            <?php
            if ($result_all->num_rows > 0) {
                while ($row = $result_all->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='uploaded_img/" . $row['image'] . "' alt='" . $row['name'] . "'>";
                    echo "<h3>" . $row['name'] . "</h3>";
                    echo "<p>Price: $" . $row['price'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "Tidak ada produk.";
            }
            ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 UrFood. All rights reserved.</p>
    </footer>

    <?php
    $conn->close(); // Tutup koneksi
    ?>
</body>
</html>
