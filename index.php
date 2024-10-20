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

    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/home_style.css"> <!-- Link ke file CSS -->
</head>
<body>

    <!-- Header -->
    <header>
        <a href="index.php" class="logo">UrFood</a>
        <div class="search-bar">
            <input type="text" placeholder="Search products...">
            <button type="button">Search</button>
        </div>
        <button class="about-us" onclick="location.href='about.php'">About Us</button>
    </header>

    <!-- Know Us More Section -->
    <section class="know-us-more">
        <h2>Know Us More :)</h2>
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/pic1.jpg" class="d-block w-100" alt="Image 1">
                </div>
                <div class="carousel-item">
                    <img src="images/pic2.jpg" class="d-block w-100" alt="Image 2">
                </div>
                <div class="carousel-item">
                    <img src="images/pic3.jpg" class="d-block w-100" alt="Image 3">
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

    <!-- Our Best Products -->
    <section class="best-products">
        <h2>Our Best Products</h2>
        <div class="row">
            <?php
            if ($result_best->num_rows > 0) {
                while ($row = $result_best->fetch_assoc()) {
                    echo "<div class='col-lg-4'>";
                    echo "<div class='card best-product-card'>";
                    echo "<img src='uploaded_img/" . $row['image'] . "' class='card-img-top' alt='" . $row['name'] . "'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row['name'] . "</h5>";
                    echo "<p class='card-text'>Price: $" . $row['price'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No featured products available.</p>";
            }
            ?>
        </div>
    </section>

    <!--  Products -->
    <section class="all-products">
        <h2>Enjoy Your Meal, Enjoy Your Day~</h2>
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <?php
                        $counter = 0;
                        if ($result_all->num_rows > 0) {
                            while ($row = $result_all->fetch_assoc()) {
                                if ($counter % 3 == 0 && $counter != 0) {
                                    echo "</div></div><div class='carousel-item'><div class='row'>";
                                }
                                echo "<div class='col-lg-4'>";
                                echo "<div class='card all-product-card'>";
                                echo "<img src='uploaded_img/" . $row['image'] . "' class='card-img-top' alt='" . $row['name'] . "'>";
                                echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>" . $row['name'] . "</h5>";
                                echo "<p class='card-text'>Price: $" . $row['price'] . "</p>";
                                echo "<div class='star-icon'>&#9733;</div>"; // Bintang di bagian kanan card
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                $counter++;
                            }
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
        <a href="all_products.php" class="view-all-btn">View All</a>
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
