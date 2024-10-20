<?php
session_start();
@include 'config.php';

// Cek jika user belum login atau bukan admin/inventory
if(!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'inventory')){
    header('location:login.php');
    exit();
}

if(isset($_POST['add_product'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'uploaded_img/'.$product_image;

   if(empty($product_name) || empty($product_price) || empty($product_image)){
      $message[] = 'please fill out all';
   }else{
      $insert = "INSERT INTO products(name, price, image) VALUES('$product_name', '$product_price', '$product_image')";
      $upload = mysqli_query($conn,$insert);
      if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         $message[] = 'new product added successfully';
      }else{
         $message[] = 'could not add the product';
      }
   }

};

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM products WHERE id = $id");
   header('location:admin_page.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}
?>

<!-- Header Navigation -->
<header>
   <nav>
      <ul>
         <li><a href="admin_page.php">Product</a></li>
         <?php if($_SESSION['role'] == 'admin'): ?>
         <li><a href="add_users.php">Add Users</a></li>
         <li><p class="header-message">Hari yang Indah & Stay Positif <?php echo $_SESSION['username']; ?>!</p></li>
         <?php endif; ?>
         <li style="float:right;"><a href="logout.php">Log Out</a></li>
      </ul>
   </nav>
</header>

<div class="container">
   <div class="admin-product-form-container">
      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
         <h3>add a new product</h3>
         <input type="text" placeholder="enter product name" name="product_name" class="box">
         <input type="number" placeholder="enter product price" name="product_price" class="box">
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
         <input type="submit" class="btn" name="add_product" value="add product">
      </form>
   </div>

   <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th>Product Image</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Action</th>
         </tr>
         </thead>
         <?php
         $select = mysqli_query($conn, "SELECT * FROM products");
         while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo $row['price']; ?>/-</td>
            <td>
               <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
               <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
            </td>
         </tr>
         <?php } ?>
      </table>
   </div>
</div>
</body>
</html>

<!-- Menambahkan style langsung di sini -->
<style>
      /* Style untuk header */
      header {
          background-color: #333;
          padding: 15px 0;
      }
      .header-message {
         text-align: center;
         font-size: 12px;
         color: yellow; /* Ubah warna sesuai kebutuhan */
      }

      nav {
          max-width: 1200px;
          margin: 0 auto;
      }

      nav ul {
          list-style: none;
          display: flex;
          justify-content: space-between;
          padding: 0;
          margin: 0;
      }

      nav ul li {
          display: inline;
          margin-right: 20px;
      }

      nav ul li a {
          color: #fff;
          text-decoration: none;
          padding: 10px 20px;
          background-color: #555;
          border-radius: 5px;
          transition: background-color 0.3s ease;
      }

      nav ul li a:hover {
          background-color: #777;
      }

      /* Float "Log Out" to the right */
      nav ul li[style="float:right;"] {
          margin-left: auto;
      }

      .message {
          color: red;
          font-weight: bold;
          margin: 10px 0;
      }
   </style>
