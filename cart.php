<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if the required fields are set
    if (isset($_GET["s-field"]) && isset($_GET["q-field"])) {
        // Retrieve selected size and quantity from the database
        $selectedSize = $_GET["s-field"];
        $selectedQuantity = $_GET["q-field"];
        
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Lazy Daze!</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./cart.css" rel="stylesheet" type="text/css"/>
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
<div class = "bg">
  <!-- Navigation Bar -->
<header class="topnav">
        <a href="homepage.php">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
        <!-- Icons -->
        <div class="topnav-right">
            <!-- Logout Icon -->
            <div class="nav-icon">
                <a href="logout.php">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
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
        </div>
  </header>
  <!-- Cart Header -->
  <section class="section-2"></section>
  <!-- Cart -->
  <section class = "container">
  <form id="cart-form" name="cart-form" method="get">
        <div class="grid">
            <div class="row">
                    <!-- Cart Row -->
                    <div class="h-layout h-flex-block">
                        <a href="#" class="rm-btn">
                            <i class="fa-solid fa-xmark fa-2xl"></i>
                        </a>
                        <img src="LDAssets/sample-shirt.png" alt="Shirt" class="item-image" />
                        <!-- Product Details Column -->
                        <div class="v-layout v-flex-block">
                            <h3>NINJA from MANILA Tee - Black</h3>
                            <select class="select-field" id="size-field" name="s-field">
                                <option value="First">S</option>
                                <option value="Second">M</option>
                                <option value="Third">L</option>
                            </select>
                            <h4>PHP 000</h4>
                        </div>
                        <!-- Quantity Column -->
                        <div class = "v-layout-2 v-flex-block-2">
                            <h4>Quantity</h4>
                        <div class="qty">
                            <span class="minus"><i class="fa-solid fa-minus fa-xl"></i></span>
                            <span class="num">01</span>
                            <span class="plus"><i class="fa-solid fa-plus fa-xl"></i></span>
                        </div>
                        </div>
                    </div>
            </div>
            <div class="row">
                    <!-- Cart Row -->
                    <div class="h-layout h-flex-block">
                        <a href="#" class="rm-btn">
                            <i class="fa-solid fa-xmark fa-2xl"></i>
                        </a>
                        <img src="LDAssets/sample-shirt.png" alt="Shirt" class="item-image" />
                        <!-- Product Details Column -->
                        <div class="v-layout v-flex-block">
                            <h3>NINJA from MANILA Tee - Black</h3>
                            <!-- Size Dropdown and retrieved back from the database -->
                            <select class="select-field" id="size-field" name="s-field">
                                <option value="First" <?php if ($selectedSize == "First") echo "selected"; ?>>S</option>
                                <option value="Second" <?php if ($selectedSize == "Second") echo "selected"; ?>>M</option>
                                <option value="Third" <?php if ($selectedSize == "Third") echo "selected"; ?>>L</option>
                            </select>
                            <h4>PHP 000</h4>
                        </div>
                        <!-- Quantity Column -->
                        <div class = "v-layout-2 v-flex-block-2">
                            <h4>Quantity</h4>
                        <div class="qty">
                            <span class="minus"><i class="fa-solid fa-minus fa-xl"></i></span>
                            <span class="num"><?php echo $selectedQuantity; ?></span>
                            <span class="plus"><i class="fa-solid fa-plus fa-xl"></i></span>
                        </div>
                        </div>
                    </div>
            </div>
        </div>
        <section class = "total-container">
        <!-- Total Row -->
        <div class = "h-layout-2 h-flex-block-2">
            <h1>TOTAL</h1>
            
            <h2>PHP 000</h2>
        </div>
        <input type="submit" class="submit-btn" value="Proceed to payment."/>
        </section>
    </form>
</section>
</div>	
<script>
    const plusButtons = document.querySelectorAll(".plus");
    const minusButtons = document.querySelectorAll(".minus");
    const numFields = document.querySelectorAll(".num");

    plusButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
            let num = parseInt(numFields[index].innerText);
            num++;
            numFields[index].innerText = num < 10 ? "0" + num : num;
        });
    });

    minusButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
            let num = parseInt(numFields[index].innerText);
            if (num > 1) {
                num--;
                numFields[index].innerText = num < 10 ? "0" + num : num;
            }
        });
    });
</script>
</body>
</html>
