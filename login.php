<?php
session_start();
@include 'config.php';

// Cek jika user sudah login
if(isset($_SESSION['username'])){
    header('location:admin_page.php');
    exit();
}

if(isset($_POST['login'])){
    // Gunakan koneksi untuk users_db
    $username = mysqli_real_escape_string($conn_users, $_POST['username']);
    $password = mysqli_real_escape_string($conn_users, $_POST['password']);

    if(empty($username) || empty($password)){
        $message[] = 'Please fill out all fields';
    } else {
        // Query ke users_db untuk mencocokkan username dan password
        $select = mysqli_query($conn_users, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
        if(mysqli_num_rows($select) > 0){
            $row = mysqli_fetch_assoc($select);
            $_SESSION['user_id'] = $row['id']; // Simpan user_id ke dalam sesi
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect ke halaman admin_page.php untuk semua role
            header('location:admin_page.php');
            exit();
        } else {
            $message[] = 'Invalid username or password';
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
   <title>Login</title>

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

<div class="login-container">
    <form action="" method="post">
        <h3>Login</h3>
        <input type="text" name="username" placeholder="Enter your username" class="box" required>
        <input type="password" name="password" placeholder="Enter your password" class="box" required>
        <input type="submit" name="login" class="btn" value="Login">
    </form>
</div>

</body>
</html>

<style>
      body {
          font-family: Arial, sans-serif;
          background-color: #f2f2f2;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          margin: 0;
      }

      .login-container {
          background-color: #fff;
          padding: 30px;
          border-radius: 8px;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
          width: 300px;
          text-align: center;
      }

      .login-container h3 {
          margin-bottom: 20px;
          color: #333;
      }

      .box {
          width: 100%;
          padding: 10px;
          margin: 10px 0;
          border: 1px solid #ccc;
          border-radius: 4px;
      }

      .btn {
          background-color: #4CAF50;
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

      .message {
          color: red;
          margin-bottom: 15px;
          font-weight: bold;
      }
   </style>
