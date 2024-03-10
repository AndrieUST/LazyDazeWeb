<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST['submit'])) {
        $Customer_Email = $_SESSION['registered_email']; // Assuming you're storing the email in a session
        $Customer_PW = $_POST['new_password'];
        $ConfirmPassword = $_POST['Confirmpassword'];
        
        if (strlen($Customer_PW) < 8) {
            echo "<script>alert('Password must be at least 8 characters long.');</script>";
            
        }
       
        if ($Customer_PW ===  $ConfirmPassword) {
           
            // Hash the new password
            $hashed_password = password_hash($Customer_PW, PASSWORD_DEFAULT);
            
            // Use prepared statement to prevent SQL injection
            $sql = "UPDATE users SET Customer_PW = ? WHERE Customer_Email = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $Customer_Email);
            
            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                echo "Password updated successfully.";
              
                header("Location: login.php");
                
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
        <input type = "password" class = "password-input"  name ="new_password" minlength="8" required>
        <label>Confirm Password</label>
        <input type = "password" class = "password-input"   name ="Confirmpassword" required>
        <button type= "submit" class = "submit-btn" name = "submit" value = "Login">Confirm</button>
    
    </form>
    </div>
    </div>
	</body>
</html>
