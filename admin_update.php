<?php

@include 'config.php';

$id = $_GET['edit'];

if(isset($_POST['update_product'])){

   // Mendapatkan nilai saat ini dari database
   $select = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
   $row = mysqli_fetch_assoc($select);

   // Menangkap nilai input, atau menggunakan nilai yang sudah ada jika kosong
   $product_name = !empty($_POST['product_name']) ? $_POST['product_name'] : $row['name'];
   $product_price = !empty($_POST['product_price']) ? $_POST['product_price'] : $row['price'];

   // Jika file image diupload, maka perbarui, jika tidak biarkan yang lama
   if (!empty($_FILES['product_image']['name'])) {
      $product_image = $_FILES['product_image']['name'];
      $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
      $product_image_folder = 'uploaded_img/'.$product_image;
      move_uploaded_file($product_image_tmp_name, $product_image_folder); // Pindahkan file yang baru
   } else {
      $product_image = $row['image']; // Gunakan image lama jika tidak ada yang diupload
   }

   // Perbarui produk dengan data yang baru atau yang lama (jika tidak diubah)
   $update_data = "UPDATE products SET name='$product_name', price='$product_price', image='$product_image' WHERE id = '$id'";
   $upload = mysqli_query($conn, $update_data);

   if($upload){
      header('location:admin_page.php');
   } else {
      $message[] = 'Error occurred while updating product!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<div class="container">

<div class="admin-product-form-container centered">

   <?php
      
      $select = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">Update the Product</h3>
      <input type="text" class="box" name="product_name" value="<?php echo $row['name']; ?>" placeholder="Enter the product name">
      <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['price']; ?>" placeholder="Enter the product price">
      <input type="file" class="box" name="product_image" accept="image/png, image/jpeg, image/jpg">
      <input type="submit" value="Update Product" name="update_product" class="btn">
      <a href="admin_page.php" class="btn">Go back!</a>
   </form>

   <?php }; ?>

</div>

</div>

</body>
</html>
