<?php

include('connect.php');


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
<header class="topnav">
        <a href="homepage.php">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
  </header>

    <h1>Verify Account</h1>
    <div class = "email-center">
    <form id = "email"  action = "mainpage.php" method ="post">
        <label>Verification Code</label>
        <input type = "text" class = "email-input"  name ="email_input" required>
        <button type= "resend" class = "resend-btn" name = "resend" value = "resend">Resend Code</button>
        <button type= "confirm" class = "confirm-btn" name = "confirm" value = "confirm">Confirm</button>
       
    </form>
    </div>
    </div>
	</body>
</html>