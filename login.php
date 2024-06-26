<?php
include('connect.php');

$max_attempts = 3;
$lockout_duration = 30; // Lockout duration in seconds

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if (!isset($_SESSION['last_attempt_time'])) {
    $_SESSION['last_attempt_time'] = 0;
}

if (!isset($_SESSION['lockout_start_time'])) {
    $_SESSION['lockout_start_time'] = 0;
}

if (!empty($_SESSION["id"])) {
    header("Location: mainpage.php");
}

if (isset($_POST["submit"])) {
    // Check if user is currently locked out
    if (time() - $_SESSION['lockout_start_time'] < $lockout_duration) {
        $remaining_lockout_time = $lockout_duration - (time() - $_SESSION['lockout_start_time']);
        echo "<script> alert('You are currently locked out. Please try again after $remaining_lockout_time seconds.'); </script>";
    }

    // Check if lockout duration has passed since last attempt
    if (time() - $_SESSION['last_attempt_time'] >= $lockout_duration) {
        $_SESSION['login_attempts'] = 0; // Reset login attempts
    }

    // Check if user has reached maximum attempts
    if ($_SESSION['login_attempts'] >= $max_attempts) {
        $_SESSION['lockout_start_time'] = time(); // Set lockout start time
        echo "<script> alert('You have exceeded the maximum number of attempts. Please try again after $lockout_duration seconds.'); </script>";
    }

    $Customer_Email = $_POST["login_email"];
    $Customer_PW = $_POST["login_password"];

    if ($Customer_Email === 'doffy.dualpass12@gmail.com') {
        $query = "SELECT * FROM admin WHERE Admin_Email = '$Customer_Email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $admin_password = $row['Admin_PW'];
            // Verify entered password against hashed password
            if (password_verify($Customer_PW, $admin_password)) {
                // Admin login
                $_SESSION["login"] = true;
                $_SESSION["admin"] = true; 
                header("Location: admin_mainpage.php");
                exit; // Exit after successful login
           }  else {
            echo "<script> alert('Wrong Admin Password. Attempts left: ". ($max_attempts - $_SESSION['login_attempts']) ."'); </script>";
                $_SESSION['login_attempts']++; // Increase login attempts
            }
        } else {
            echo "<script> alert('Admin account not found.'); </script>";
        }
        // Admin login logic
        // Omitted for brevity
    } else {
        // Customer login logic
        $result = mysqli_query($conn, "SELECT * FROM users WHERE Customer_Email = '$Customer_Email'");
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) > 0) {
            if ($row['Confirmed'] == 0) {
                
                
            }

            if (password_verify($Customer_PW, $row['Customer_PW'])) {
                if (!empty($row['email_verified_at'])) { // Check if email is verified
                    $_SESSION["login"] = true;
                    $_SESSION["id"] = $row["id"];
                    $_SESSION['registered_email'] = $Customer_Email; // Add this line
                    $_SESSION['email_verified_at'] = date('Y-m-d H:i:s'); // Add this line
                    header("Location: mainpage.php");
                    exit; // Exit after successful login
                } else {
                    echo "<script> alert('Your account is not confirmed. Please verify your email.'); </script>";
                }
            } else {
                echo "<script> alert('Wrong Password. Attempts left: ". ($max_attempts - $_SESSION['login_attempts']) ."'); </script>";
                $_SESSION['login_attempts']++;
            }
        } else {
            echo "<script> alert('User Not Registered'); </script>";
        }
    }

    // Update last attempt time
    $_SESSION['last_attempt_time'] = time();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Login CSS -->
    <link href="./login.css" rel="stylesheet" type="text/css" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Website Icon -->
    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
    <!-- Background Image -->
    <div class="bg">
        <!-- Navigation Bar -->
        <div class="topnav">
            <a href="index.php">
                <img align="left" class="ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
            </a>
        </div>
        <!-- Login Page -->
        <h1>Login Page</h1>
        <div class="login-center">
            <form id="login" method="post">
                <label>Email</label>
                <input type="text" class="email-input" name="login_email" required>
                <label>Password</label>
                <input type="password" class="password-input" name="login_password" required>
                <button type="submit" class="submit-btn" name="submit" value="Login">Sign In</button>
                <div class="center">
                    <?php
                    // Display remaining lockout time if user is currently locked out
                    if (time() - $_SESSION['lockout_start_time'] < $lockout_duration) {
                        $remaining_lockout_time = $lockout_duration - (time() - $_SESSION['lockout_start_time']);
                        echo "<p>You are currently locked out. Please try again after <span id='countdown'>$remaining_lockout_time</span> seconds.</p>";
                        echo "<script> $('button[name=\"submit\"]').prop('disabled', true); </script>";
                    }
                    ?>
                    <p>Don't have an account? <a href="register.php" class="sign-up-text">Sign Up</a>!</p>
                    <p>Do you want to verify your account? <a href="verify_email_again.php" class="sign-up-text">Click here</a>!</p>
                    <!-- new class for href="password-reset.php -->
                    <a href="password-reset.php" class="forgot-password-text">Forgot Password</a> 
                </div>
            </form>
        </div>
    </div>
    <script>
        // Countdown timer
        $(document).ready(function() {
            var remainingLockoutTime = <?php echo isset($remaining_lockout_time) ? $remaining_lockout_time : 0; ?>;
            if (remainingLockoutTime > 0) {
                var countdownInterval = setInterval(function() {
                    remainingLockoutTime--;
                    $('#countdown').text(remainingLockoutTime);
                    if (remainingLockoutTime <= 0) {
                        clearInterval(countdownInterval);
                        $('button[name="submit"]').prop('disabled', false);
                    }
                }, 1000);
            }
        });
    </script>
</body>
</html>
