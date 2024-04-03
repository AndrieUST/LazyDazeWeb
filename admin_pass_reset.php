<?php
include('connect.php');

if(isset($_POST["submit"])) {
     // Get the new password submitted by the admin
     $new_password = isset($_POST["new_password"]) ? $_POST["new_password"] : '';
     $Confirmpassword = isset($_POST["Confirmpassword"]) ? $_POST["Confirmpassword"] : '';
 
     // Retrieve the admin's email from the session
     $admin_email = 'johnlinga0949@gmail.com'; // Admin email
 
     if(empty($new_password) || empty($admin_email)) {
         echo "New password or admin email is missing.";
         exit();
     }
 
     // Check if the new password matches the confirmation password
     if ($new_password !== $Confirmpassword) {
         echo "New password and confirmation password do not match.";
         exit();
     }
 
     // Hash the new password
     $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
 
     // Update the admin's password in the database
     $update_query = "UPDATE admin SET Admin_PW = ? WHERE Admin_Email = ?";
     $stmt = mysqli_prepare($conn, $update_query);
     mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $admin_email);
     if(mysqli_stmt_execute($stmt)) {
         // Redirect to admin_mainpage.php after successful password reset
         header("Location: admin_mainpage.php");
         exit();
     } else {
         echo "Error updating password: " . mysqli_error($conn);
     }
 }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Verification</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Register CSS -->
    <link href="pass-reset.css" rel="stylesheet" type="text/css"/>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  <!-- Background Image -->
<div class = "bg">
  <!-- Navigation Bar -->
<header class="topnav">
        <a href="homepage.php">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
  </header>

  <h1>Admin Password Reset</h1>
    <div class = "email-center">
    <form id = "email"  action = "admin_pass_reset.php" method ="post">
        
        <label>New Password</label>
        <input type = "password" class = "password-input"  name ="new_password" minlength="8" required>
        <label>Confirm Password</label>
        <input type = "password" class = "password-input"   name ="Confirmpassword" required>
        <button type= "submit" class = "submit-btn" name = "submit" value = "Login">Confirm</button>
    
    </form>
    </div>
    </div>
	</body>
</html>
