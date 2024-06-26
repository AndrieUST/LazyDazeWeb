<?php
include('connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Lazy Daze!</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./mainpage.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
<header class="topnav">
        <a href="index.php">
          <img align="left" class="ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
        <!-- Icons -->
        <div class="nav-h-layout">
            <!-- Logout Icon -->
            <div class="nav-icon">
                <a href="logout.php">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
                </a>
            </div>
            <div class="nav-line"></div>
            <!-- Cart Icon -->
            <div class="nav-icon" id="cart-icon">
                <a <?php if (!isset($_SESSION['registered_email'])) echo 'class="disabled-link"'; ?> href="<?php if (isset($_SESSION['registered_email'])) echo 'cart.php'; ?>">
                    <i class="fa-solid fa-cart-shopping fa-xl"></i>
                    <span id="cart-notification" class="cart-notification">0</span> <!-- Notification badge -->
                </a>
            </div>
            <div class="nav-line"></div>
            <!-- Reviews Icon -->
            <div class="nav-icon" id="reviews-icon">
            <a href="reviews.php">
                    <i class="fa-solid fa-star fa-xl"></i>
                </a>
            </div>
            <div class="nav-line"></div>
            <!-- Info Icon -->
            <div class="nav-icon" id="inquiries-icon">
                <a <?php if (!isset($_SESSION['registered_email'])) echo 'class="disabled-link"'; ?> href="<?php if (isset($_SESSION['registered_email'])) echo 'inquiries.php'; ?>">
                    <i class="fa-solid fa-circle-info fa-xl"></i>
                </a>
            </div>
            <div class="nav-line"></div>
        </div>
  </header>
  <div class="intro">
    <h2>Welcome to LazyDaze!</h2>
    <?php
    if (isset($_SESSION['registered_email'])) {
        $email_parts = explode('@', $_SESSION['registered_email']);
        $display_name = $email_parts[0];
        
        // Fetch confirmed status from the database
        $query = "SELECT Confirmed FROM users WHERE Customer_Email = '{$_SESSION['registered_email']}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $confirmed_status = $row['Confirmed'];
        
        // Check if the account is confirmed
        if ($confirmed_status == 1) {
            echo '<h1>' . htmlspecialchars($display_name) . '</h1>';
        } else {
            // Account is not confirmed, display default message
            echo '<h1>Get your apparel now!</h1>';
            // Disable links for inquiries, reviews, and cart
            echo "<script>
                    $('#inquiries-icon a').removeAttr('href');
                   
                    $('#cart-icon a').removeAttr('href');
                 </script>";
        }
    } else {
        echo '<h1>Get your apparel now!</h1>';
    }
    ?>
    <a href="products.php">
        <button class="go-products" name="go-to-products" value="Go-Products">View Products</button>
    </a>
    <button class="orders-btn" onclick="ViewOrders()">Your Orders</button>
</div>
<img class="biglogo" src="LDAssets/biglogo.png" alt="Big Lazy Logo"/>
</div>
</body>
</html>

<!-- JavaScript for live search with debounce -->
<script>
function ViewOrders() {
    <?php
    if (!isset($_SESSION['registered_email'])) {
        // User is not logged in, redirect to login page
        echo 'window.location.href = "login.php";';
    } else {
        // User is logged in, check if the account is confirmed
        $query = "SELECT Confirmed FROM users WHERE Customer_Email = '{$_SESSION['registered_email']}'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $confirmed_status = $row['Confirmed'];

        if ($confirmed_status != 1) {
            // Account is not confirmed, redirect to login page
            echo 'window.location.href = "login.php";';
        } else {
            // Account is confirmed, redirect to View Orders page
            echo 'window.location.href = "View_Order.php";';
        }
    }
    ?>
}

$(document).ready(function(){
    var typingTimer;
    var doneTypingInterval = 300; // 300 milliseconds

    // On keyup, start the countdown
    $("#searchInput").on("keyup", function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    // On keydown, clear the countdown
    $("#searchInput").on("keydown", function() {
        clearTimeout(typingTimer);
    });

    // User is finished typing, perform search
    function doneTyping() {
        var searchQuery = $(".search-input").val().trim();
        if (searchQuery !== '') {
            $.ajax({
                type: "GET",
                url: "products.php",
                data: { search: searchQuery },
                success: function(response) {
                    // Update itemsWrapper with search results
                    $("#itemsWrapper").html(response);
                }
            });
        }
    }
});
function updateCartNotification() {
        $.ajax({
            url: 'fetch_cart_count.php', // Endpoint to fetch cart count
            type: 'GET',
            success: function(count) {
                $('#cart-notification').text(count);
            }
        });
    }

    // Call updateCartNotification() when the page is loaded
    $(document).ready(function() {
        updateCartNotification();
    });

    // Call fetchReviews() when the page is loaded
    $(document).ready(function() {
        fetchReviews();
    });
</script>
