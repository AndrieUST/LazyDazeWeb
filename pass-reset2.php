<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['submit'])) {
        
        $Customer_PW = $_POST['new_password'];
        $ConfirmPassword = $_POST['Confirmpassword'];
        
       
        if ($Customer_PW ===  $ConfirmPassword) {
           
          
            
            
           
            $hashed_password = password_hash($Customer_PW, PASSWORD_DEFAULT);
            
           
            $sql = "UPDATE users SET Customer_PW = '$hashed_password' WHERE register_email = '$Customer_Email'";
            if (mysqli_query($conn, $sql)) {
                echo "Password updated successfully.";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "Passwords do not match.";
        }
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
    <link href="./pass-reset.css" rel="stylesheet" type="text/css"/>
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

    <h1>Reset password</h1>
    <div class = "email-center">
    <form id = "email"  action = "pass-reset2.php" method ="post">
        
        <label>New Password</label>
        <input type = "password" class = "password-input"  name ="new_password" required>
        <label>ConfirmPassword</label>
        <input type = "password" class = "password-input"   name ="Confirmpassword" required>
        <button type= "submit" class = "submit-btn" name = "submit" value = "Login">confirm</button>
    
    </form>
    </div>
    </div>
	</body>
</html>