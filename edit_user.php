<?php
session_start();
@include 'config.php';

// Cek jika user belum login atau bukan admin
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header('location:login.php');
    exit();
}

// Mendapatkan ID user dari URL
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $select_user = mysqli_query($conn_users, "SELECT * FROM users WHERE id = $id");

    // Jika user ditemukan
    if(mysqli_num_rows($select_user) > 0){
        $user_data = mysqli_fetch_assoc($select_user);
    } else {
        header('location:add_users.php');
        exit();
    }
}

// Mengupdate data user
if(isset($_POST['update_user'])){
    $username = mysqli_real_escape_string($conn_users, $_POST['username']);
    $password = mysqli_real_escape_string($conn_users, $_POST['password']);
    $role = mysqli_real_escape_string($conn_users, $_POST['role']);

    // Cek apakah username sudah digunakan oleh user lain
    $check_username = mysqli_query($conn_users, "SELECT * FROM users WHERE username = '$username' AND id != $id");
    if(mysqli_num_rows($check_username) > 0){
        $message[] = 'Username already exists!';
    } else {
        $update = "UPDATE users SET username = '$username', password = '$password', role = '$role' WHERE id = $id";
        $result = mysqli_query($conn_users, $update);
        if($result){
            $message[] = 'User updated successfully';
            header('location:add_users.php');
            exit();
        } else {
            $message[] = 'Failed to update user';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Users</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
   <?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
   ?>
   
   <form action="" method="post">
      <h3>Edit User</h3>
      <input type="text" name="username" value="<?php echo $user_data['username']; ?>" placeholder="Enter username" class="box" required>
      <input type="password" name="password" value="<?php echo $user_data['password']; ?>" placeholder="Enter new password" class="box" required>
      <select name="role" class="box" required>
         <option value="admin" <?php if($user_data['role'] == 'admin') echo 'selected'; ?>>Admin</option>
         <option value="inventory" <?php if($user_data['role'] == 'inventory') echo 'selected'; ?>>Inventory</option>
      </select>
      <input type="submit" name="update_user" value="Update User" class="btn">
   </form>
</div>

</body>
</html>

<style>
      body {
         font-family: Arial, sans-serif;
         background-color: #f4f4f4;
         margin: 0;
         padding: 20px;
      }

      .container {
         max-width: 600px;
         margin: auto;
         background: white;
         padding: 20px;
         border-radius: 8px;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      }

      h3 {
         text-align: center;
         margin-bottom: 20px;
      }

      .box {
         width: 100%;
         padding: 10px;
         margin: 10px 0;
         border: 1px solid #ccc;
         border-radius: 4px;
      }

      .btn {
         background-color: #28a745;
         color: white;
         border: none;
         padding: 10px;
         border-radius: 4px;
         cursor: pointer;
         width: 100%;
         margin-top: 10px;
      }

      .btn:hover {
         background-color: #218838;
      }

      .message {
         color: red;
         text-align: center;
         margin-bottom: 20px;
      }
   </style>