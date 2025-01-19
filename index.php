<?php
// Koneksi ke database - Cara 1:
//$servername = "localhost"; // ganti dengan server database Anda
//$username = "username"; // ganti dengan username database Anda
//$password = "password"; // ganti dengan password database Anda
//$dbname = "cart_db"; // ganti dengan nama database Anda
require_once 'init_db.php';
//Koneksi ke Database - Cara 2:
@include 'config.php';

/// Ambil produk scr acak / random
/// Ambil produk secara acak / random dengan gambar unik
$query_all_products = "SELECT DISTINCT image, name, price FROM products ORDER BY RAND() LIMIT 6"; // Mengambil 6 produk dengan gambar unik
$result_all = $conn->query($query_all_products);
$products = []; // Array untuk menyimpan produk
if ($result_all->num_rows > 0) {
    while ($row = $result_all->fetch_assoc()) {
        $products[] = $row; // Simpan produk ke dalam array
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UrFood</title>

    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home_style.css"> <!-- Link ke file CSS -->
</head>
<body>

    <!-- Header -->
    <header>
    <a href="index.php" class="logo">UrFood</a>
    <div class="header-buttons">
        <button class="about-us" onclick="location.href='about.php'">About Us</button>
        <button class="about-us" onclick="location.href='login.php'">Login</button>
    </div>
</header>

    <!-- Know Us More Section -->
    <section class="know-us-more">
        <h2>Know Us More :)</h2>
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/slide1.jpg" class="d-block w-100" alt="Image 1">
                </div>
                <div class="carousel-item">
                    <img src="images/slide2.jpg" class="d-block w-100" alt="Image 2">
                </div>
                <div class="carousel-item">
                    <img src="images/slide3.jpg" class="d-block w-100" alt="Image 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <!-- Products -->
<section class="all-products">
    <h2>Rekomendasi Kami~</h2>
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="row">
                    <?php
                    // Menampilkan 3 produk di slide pertama
                    for ($i = 0; $i < min(3, count($products)); $i++) {
                        echo "<div class='col-lg-4'>";
                        echo "<div class='card all-product-card'>";
                        echo "<img src='uploaded_img/" . $products[$i]['image'] . "' class='card-img-top' alt='" . $products[$i]['name'] . "'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . $products[$i]['name'] . "</h5>";
                        echo "<p class='card-text'>Price: $" . $products[$i]['price'] . "</p>";
                        echo "<div class='star-icon'>&#9733;</div>"; // Bintang di bagian kanan card
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
            <!-- Slide kedua untuk produk keempat dan kelima -->
            <div class="carousel-item">
                <div class="row">
                    <?php
                    // Menampilkan produk keempat dan kelima
                    for ($i = 3; $i < count($products); $i++) {
                            echo "<div class='col-lg-4'>";
                            echo "<div class='card all-product-card'>";
                            echo "<img src='uploaded_img/" . $products[$i]['image'] . "' class='card-img-top' alt='" . $products[$i]['name'] . "'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>" . $products[$i]['name'] . "</h5>";
                            echo "<p class='card-text'>Price: $" . $products[$i]['price'] . "</p>";
                            echo "<div class='star-icon'>&#9733;</div>"; // Bintang di bagian kanan card
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Button untuk menuju all_products.php -->
    <a href="all_products.php" class="view-all-btn">Click to view all our products</a>
</section>


    <!-- Footer -->
    <footer>
        <p>&copy; 2024 UrFood. All rights reserved.</p>
    </footer>

    <?php
    $conn->close(); // Tutup koneksi
    ?>

    <!-- Link ke Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
