<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Login CSS -->
    <link href="./login.css" rel="stylesheet" type="text/css"/>
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
    <h1>Login Page</h1>
    <div class = "login-center">
    <form id = "login" method ="post">
        <label>Email</label>
        <input type = "text" class = "email-input" name ="login_email" required>
        <label>Password</label>
        <input type = "password" class = "password-input" name ="login_password" required>
        <button type= "submit" class = "submit-btn" name = "submit_login" value = "Login">Sign In</button>
        <div class = "center">
        <p>Don't have an account? <a href="register.php" class = "sign-up-text">Sign Up</a>!</p>
        <a href="" class = "forgot-password-text">Forgot Password</a>
        </div>
    </form>
    </div>
	</body>
</html>
