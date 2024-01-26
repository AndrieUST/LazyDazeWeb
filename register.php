<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Login CSS -->
    <link href="./register.css" rel="stylesheet" type="text/css"/>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<header class="topnav">
        <div class="topnav-left">
        <a target="_blank" href="">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
        </div>
  </header>

    <!-- Login Page -->
    <h1>Create an account</h1>
    <div class = "register-center">
    <form id = "register" method ="post">
        <label>Email</label>
        <input type = "text" class = "email-input" name ="register_email" required>
        <label>Password</label>
        <input type = "password" class = "password-input" name ="register_password" required>
        <button type= "submit" class = "submit-btn" name = "submit_login" value = "Login">Sign Up</button>
        <div class = "center">
        <p>Already have an account? <a href="login.php" class = "sign-in-text">Sign In</a>!</p>
        </div>
    </form>
    </div>
	</body>
</html>
