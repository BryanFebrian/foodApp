<?php
@include 'config.php';

// Inisialisasi variabel untuk pencarian dan pengurutan
$search = '';
$sort = '';

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = isset($_POST['search']) ? $_POST['search'] : '';
    $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
}

// Bangun query SQL berdasarkan pencarian dan pengurutan
$sql_all = "SELECT image, name, price FROM products WHERE name LIKE '%$search%'";

if ($sort == 'low_to_high') {
    $sql_all .= " ORDER BY price ASC";
} elseif ($sort == 'high_to_low') {
    $sql_all .= " ORDER BY price DESC";
}

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
        <button class="about-us" onclick="location.href='about.php'">About Us</button>
    </header>

    <!-- All Products Page -->
    <section class="all-products-page">
        <h2>Rekomendasi kami untuk kalian!!!</h2>
        <div class="container">
            <!-- Form Pencarian dan Sortir -->
            <form method="POST" class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="sort" class="form-select">
                            <option value="">Sort By</option>
                            <option value="low_to_high" <?php echo ($sort == 'low_to_high') ? 'selected' : ''; ?>>Price: Low to High</option>
                            <option value="high_to_low" <?php echo ($sort == 'high_to_low') ? 'selected' : ''; ?>>Price: High to Low</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>

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
