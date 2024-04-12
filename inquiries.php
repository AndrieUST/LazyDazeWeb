<?php
include('connect.php');
if(isset($_SESSION['registered_email']) && isset($_SESSION['email_verified_at']) && $_SESSION['email_verified_at'] !== null) {
    $cartPage = "cart.php"; // Set the cart page URL
    $inquiriespage = "inquiries.php";
} else {
    $cartPage = "#"; 
    $inquiriespage = "#";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Have any inquiries?</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./inquiries.css" rel="stylesheet" type="text/css"/>
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
    <div class="topnav">
        <a href="mainpage.php">
            <img align="left" class="ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
        <!-- Icons -->
        <div class="nav-h-layout">
            <!-- Logout Icon -->
            <div class="nav-icon">
                <a href="./homepage.php">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
                </a>
            </div>
            <div class="nav-line"></div>
            <!-- Cart Icon -->
            <div class="nav-icon">
            <a href="<?php echo $cartPage; ?>">
                <i class="fa-solid fa-cart-shopping fa-xl"></i>
                <span id="cart-notification" class="cart-notification">0</span> <!-- Notification badge -->
            </a>
        </div>
            <div class="nav-line"></div>
            <!-- Reviews Icon -->
            <div class="nav-icon">
                <a href="reviews.php">
                    <i class="fa-solid fa-star fa-xl"></i>
                </a>
            </div>
            <div class="nav-line"></div>
            <!-- Search -->
            <div class="nav-search">
                <form class="search-form" method="get">
                    <button class="search-btn" type="submit"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
                    <input type="text" class="search-input" name="search" value="" placeholder="Search Product">
                </form>
            </div>
            <div class="nav-line"></div>
        </div>
    </div>
    <!-- Inquiry Page -->
    <h1>Inquiries</h1>
    <div class="container">
        <form class="inquiry-form" id="inquiry" method="post" action="submit_inquiry.php">
            <label for="name-in">Name</label>
            <input type="text" id="name-in" class="name-input" name="name-text-box" notrequired>
            <label for="inquiry-text">Inquiry</label>
            <textarea id="inquiry-text" class="inquiry-input" name="inquiry-text-box" required></textarea>
            <button class="back-btn" onclick="history.back()">Go Back</button>
            <button type="submit" class="submit-btn" name="submit_inquiry" value="submit-inquiry">Submit</button>
        </form>
    </div>
</div>
</body>
</html>
<script>
    $(document).ready(function() {
     // Function to update cart notification badge
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
    updateCartNotification();

    // Call fetchReviews() when the page is loaded
    fetchReviews();
});

</script>