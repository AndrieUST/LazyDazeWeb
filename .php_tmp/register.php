<?php
include('connect.php');

if(!empty($_SESSION["id"])){
    header("Location: login.php");
   
}

if(isset($_POST["submit"])) {
    $Customer_Email = $_POST["register_email"]; 
    $Customer_PW = $_POST["register_password"]; 
    $ConfirmPassword = $_POST["Confirmpassword"]; 
    
  
    $hashedPassword = password_hash($Customer_PW, PASSWORD_DEFAULT);
    
    $duplicate = mysqli_query($conn, "SELECT * FROM users WHERE Customer_Email = '$Customer_Email'");
    if(mysqli_num_rows($duplicate) > 0){
        echo "<script> alert('Email Has Already Taken'); </script>";
    } else {
        if($Customer_PW == $ConfirmPassword){
           
            $query = "INSERT INTO users (Customer_Email, Customer_PW) VALUES ('$Customer_Email', '$hashedPassword')"; 
            mysqli_query($conn, $query);
            echo "<script> alert('Registration Successful'); </script>";
        } else {
            echo "<script> alert('Password Does Not Match'); </script>";
        }
    }
}
?>




<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Register CSS -->
    <link href="./register.css" rel="stylesheet" type="text/css"/>
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

    <!-- Register Page -->
    <h1>Create an account</h1>
    <div class = "register-center">
    <form id = "register"  action = "register.php" method ="post">
        <label>Email</label>
        <input type = "text" class = "email-input"  name ="register_email" required>
        <label>Password</label>
        <input type = "password" class = "password-input"  name ="register_password" required>
        <label>Confirm Password</label>
        <input type = "password" class = "password-input"   name ="Confirmpassword" required>
        <button type= "submit" class = "submit-btn" name = "submit" value = "Login">Sign Up</button>
        <div class = "center">
        <p>Already have an account? <a href="login.php" class = "sign-in-text">Sign In</a>!</p>
        </div>
    </form>
    </div>
    </div>
	</body>
</html>
