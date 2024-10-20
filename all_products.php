<?php
@include 'config.php';

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

    <!-- All Products Page -->
    <section class="all-products-page">
        <h2>Our Products</h2>
        <div class="container">
            <div class="row">
                <?php
                $counter = 0;
                if ($result_all->num_rows > 0) {
                    while ($row = $result_all->fetch_assoc()) {
                        if ($counter % 3 == 0 && $counter != 0) {
                            echo "</div><div class='row'>";
                        }
                        echo "<div class='col-lg-4'>";
                        echo "<div class='card'>";
                        echo "<img src='uploaded_img/" . $row['image'] . "' class='card-img-top' alt='" . $row['name'] . "'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . $row['name'] . "</h5>";
                        echo "<p class='card-text'>Price: $" . $row['price'] . "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        $counter++;
                    }
                } else {
                    echo "<p>No products available.</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 UrFood. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
