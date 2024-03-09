<?php
include('connect.php');

// Retrieve products from the database
$sql = "SELECT * FROM manageprod";
$result = mysqli_query($conn, $sql);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take a look at our items!</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./products.css" rel="stylesheet" type="text/css"/>
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
            <a href="homepage.php">
                <img align="left" class="ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
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
        <div class="bg2"></div>
        <div class="intro">
            <h1>Ninja X Manila</h1>
            <h2>2024 Summer Collab Limited Collection</h2>
            <div class="container"> <div class="row">
         <?php
         // Loop through each product and display its information
         while ($row = mysqli_fetch_assoc($result)) {
         ?>
         <div class="col-sm-4">
            <div class="thumbnail">
               <img src="<?php echo $row['img']; ?>" alt="<?php echo htmlspecialchars($row['Product_Name']); ?>">
               <div class="product-details"> <h3><?php echo htmlspecialchars($row['Product_Name']); ?></h3>
                  <p><?php echo htmlspecialchars($row['Description']); ?></p>
                  <p>Quantity: <?php echo $row['Quantity']; ?></p>
                  <p>Price: <?php echo number_format($row['Price'], 2, '.', ','); ?> PHP</p>
                  <form class="product-form" method="post" action="viewprod.php">
                     <button type="submit" class="add-btn" name="submit" value="check">Check Item</button>
                  </form>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
