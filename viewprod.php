<?php
include('connect.php');

// Check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Retrieve product information from the submitted form
    $product_name = $_POST["product_name"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check it out!</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./viewprod.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Website Icon -->
    <script>
    // Function to validate the form before submission
    function validateForm() {
        var size = document.getElementById("size-field").value;
        var quantity = document.getElementById("quantity-field").value;

        // Check if both size and quantity are empty
        if (size === "" && quantity === "") {
            alert("Please Input Size and Quantity");
            return false;
        }
        // Check if size is empty
        else if (size === "") {
            alert("Please Input Size");
            return false;
        }
        // Check if quantity is empty
        else if (quantity === "") {
            alert("Please Input Quantity");
            return false;
        }
        // If both fields have input. 
        return true;
    }</script>

    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
  <!-- Background Image -->
<div class = "bg">
  <!-- Navigation Bar -->
<header class="topnav">
        <a href="">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
        <!-- Icons -->
        <div class="topnav-right">
            <!-- Logout Icon -->
            <div class="nav-icon">
                <a href="./homepage.php">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
                </a>
            </div>
            <div class="nav-line"></div>
            <!-- Cart Icon -->
            <div class="nav-icon">
                <a href="">
                    <i class="fa-solid fa-cart-shopping fa-xl"></i>
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
            <!-- Info Icon -->
            <div class="nav-icon">
                <a href="inquiries.php">
                    <i class="fa-solid fa-circle-info fa-xl"></i>
                </a>
            </div>
            <div class="nav-line"></div>
            <!-- Search -->
            <div class="nav-search">
            <form method="get">
                <button class="search-btn" type="submit"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
                <input type="text" class="search-input" name="search" value="" placeholder="Search Product">
            </form>
            </div>
            <div class="nav-line"></div>
        </div>
  </header>
    <!-- Banner -->
  <div class = "bg2"></div>
  <!-- Item -->
  <div class="h-layout"><img class="prod-img" src="./LDAssets/sample-shirt.png" alt="Shirt"/>
        <div class="v-layout">
            <div>
                <!-- Display product name from products.php SQL -->
                <h1><?php echo htmlspecialchars($product_name); ?></h1>
                <!-- Display product price deom products.php SQL -->
                <h2><?php echo number_format($price, 2, '.', ','); ?> PHP</h2>
            </div>
            <div class="form">
            <form id="prod-form" name="prod-form" method="get" action="cart.php" onsubmit="return validateForm()">
                    <!-- Provide options for quantity -->
                    <label for="size-field">Size</label>
                    <select class="select-field" id="size-field" name="s-field">
                        <option value=""></option>
                        <option value="First">S</option>
                        <option value="Second">M</option>
                        <option value="Third">L</option>
                    </select>
                    <label for="quantity-field">Quantity</label>
                    <select class="select-field" id="quantity-field" name="q-field">
                        <option value=""></option>
                        <!-- Loop to provide quantity options base on the number input in SQL -->
                        <?php for ($i = 1; $i <= $quantity; $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                    <input type="submit" class="submit-btn" name="submit" value="Add to Cart" />
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
