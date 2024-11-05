<?php
session_start();
@include 'config.php';

// Hanya admin yang bisa mengakses
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin'){
    header('location:login.php');
    exit();
}

// Tambah User Baru
if(isset($_POST['add_user'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Cek apakah username sudah ada
    $check_username = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if(mysqli_num_rows($check_username) > 0){
        $message[] = 'Username already exists!';
    } else {
        $insert_user = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        $result = mysqli_query($conn, $insert_user);
        if($result){
            $message[] = 'New user added successfully';
        } else {
            $message[] = 'Failed to add user';
        }
    }
}

// Hapus User
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    // Cek apakah ID yang ingin dihapus adalah milik admin yang sedang login
    if($id == $_SESSION['user_id']){
        echo "<script>alert('Anda tidak bisa menghapus akun Anda sendiri!!!');</script>";
    } else {
        mysqli_query($conn, "DELETE FROM users WHERE id = $id");
        header('location:add_users.php');
    }
}

// Ambil Data User
$users = mysqli_query($conn, "SELECT * FROM users WHERE username != 'admin'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Users</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Header Navigation -->
<header>
   <nav>
      <ul>
         <li><a href="admin_page.php">Product</a></li>
         <li><a href="add_users.php">Add Users</a></li>
         <li><p class="header-message">Hari yang Indah & Stay Positif <?php echo $_SESSION['username']; ?>!</p></li>
         <li style="float:right;"><a href="logout.php">Log Out</a></li>
      </ul>
   </nav>
</header>

<div class="container">
   <?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
   ?>
   <form action="" method="post">
      <h3>Add New User</h3>
      <input type="text" name="username" placeholder="Enter username" class="box" required>
      <input type="password" name="password" placeholder="Enter password" class="box" required>
      <select name="role" class="box" required>
         <option value="admin">Admin</option>
         <option value="inventory">Inventory</option>
      </select>
      <input type="submit" name="add_user" value="Add User" class="btn">
   </form>

   <!-- Tabel User -->
   
      <table class="user-display-table">
        <br>
        <h2>List Akun Karyawan UrFood:</h2>
         <thead>
            <tr>
               <th>Username</th>
               <th>Role</th>
               <th>Action</th>
            </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($users)){ ?>
         <tr>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td>
               <!-- Cek apakah admin yang login mencoba mengedit/menghapus dirinya sendiri -->
               <?php if($row['id'] == $_SESSION['user_id']) { ?>
                  <a href="#" onclick="alert('Anda tidak bisa mengedit akun Anda sendiri!!!')" class="btn">Edit</a>
                  <a href="#" onclick="alert('Anda tidak bisa menghapus akun Anda sendiri!!!')" class="btn">Delete</a>
               <?php } else { ?>
                  <a href="edit_user.php?edit=<?php echo $row['id']; ?>" class="btn">Edit</a>
                  <a href="add_users.php?delete=<?php echo $row['id']; ?>" class="btn btn-delete">Delete</a>
               <?php } ?>
            </td>
         </tr>
         <?php } ?>
      </table>
   
</div>

</body>
</html>

<style>
      body {
          font-family: Arial, sans-serif;
          background-color: #f2f2f2;
          margin: 0;
          padding: 0;
      }

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

      .container {
          display: flex;
          flex-direction: column;
          align-items: center;
          margin-top: 20px;
      }

      .user-display-table {
          width: 80%;
          border-collapse: collapse;
          margin-top: 20px;
      }

      .user-display-table th, .user-display-table td {
          border: 1px solid #ccc;
          padding: 10px;
          text-align: left;
      }

      .user-display-table th {
          background-color: #4CAF50;
          color: white;
      }

      .message {
          color: red;
          margin-bottom: 15px;
          font-weight: bold;
      }

      .box {
          width: 300px;
          padding: 10px;
          margin: 10px 0;
          border: 1px solid #ccc;
          border-radius: 4px;
      }

      .btn {
          background-color: green;
          color: white;
          border: none;
          padding: 10px;
          cursor: pointer;
          border-radius: 4px;
          transition: background-color 0.3s;
      }

      .btn:hover {
          background-color: #45a049;
      }

      .btn-delete {
          background-color: red; /* Warna latar belakang merah */
    }

      .btn-delete:hover {
          background-color: darkred; /* Warna latar belakang saat hover */
    }

      h3 {
          margin-bottom: 20px;
          color: #333;
      }
   </style>