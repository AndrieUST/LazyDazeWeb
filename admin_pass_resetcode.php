<?php
include('connect.php');

if(isset($_POST["confirm"])) {
    // Get the verification code submitted by the admin
    $verification_code = isset($_POST["code_input"]) ? $_POST["code_input"] : '';

    // Retrieve the admin's email from the session
    $admin_email = 'doffy.dualpass12@gmail.com'; // Admin email

    if(empty($verification_code) || empty($admin_email)) {
        echo "Verification code or admin email is missing.";
        exit();
    }

    // Check if the verification code matches the one sent to the admin
    $query = "SELECT verification_code FROM admin WHERE Admin_Email = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $admin_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $stored_verification_code = $row['verification_code'];

        if($stored_verification_code === $verification_code) {
            // Redirect the admin to the password reset page
            header("Location: admin_pass_reset.php");
            exit();
        } else {
            echo "Invalid verification code. Please try again.";
        }
    } else {
        echo "Admin not found or multiple admins with the same email. Please contact support.";
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mail Verification Code</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Register CSS -->
    <link href="./email.css" rel="stylesheet" type="text/css"/>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  <!-- Background Image -->
<div class = "bg">
  <!-- Navigation Bar -->
<div class="topnav">
        <a href="index.php">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
  </div>

    <h1>Verify Account</h1>
    <div class = "email-center">
    <form id="email" action="admin_pass_resetcode.php" method="post">
    <label>Verification Code</label>
    <input type="text" class="email-input" name="code_input">
    <button type="resend" class="resend-btn" name="resend" value="resend">Resend Code</button>
    <button type="submit" class="confirm-btn" name="confirm" value="confirm">Confirm</button>
</form>

    </div>
    </div>
	</body>
</html>