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
    <title>Admin Product</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./prod.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Website Icon -->
    <link rel="icon" href="./LDAssets/lz logo.png"><!-- Head content -->
</head>
<body>
  <!-- Background Image -->
<div class="bg">
  <!-- Navigation Bar -->
  <div class="topnav">
    <a href="homepage.php">
      <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
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
        <form class="search-form" method="get">
          <button class="search-btn" type="submit"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
          <input type="text" class="search-input" name="search" value="" placeholder="Search Product">
        </form>
      </div>
      <div class="nav-line"></div>
    </div><!-- Navigation bar content -->
  </div>
  <div class="bg2"></div>
  <div class="container">
    <h1>Products</h1>
    <div class="items-wrapper">
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div>
            <img class = "item-image" src="<?php echo $row['img']; ?>" alt="<?php echo $row['Product_Name']; ?>">
              <h3 class = "item-title"><?php echo $row['Product_Name']; ?></h3>
              <div class = "item-deets"><?php echo $row['Description']; ?></div>
              <div class = "item-deets">Quantity: <?php echo $row['Quantity']; ?></div>
              <div class = "item-deets">Price: <?php echo number_format($row['Price'], 2, '.', ','); ?> PHP</div>
              <!-- Edit Button -->
              <a href="editprod.php?product_id=<?php echo $row['ProductID']; ?>">
              <button class = "edit-btn" type="submit" name="submit" value="check">Edit Item</button>
              </a>
              <!-- Remove Button -->
              <form method="post" action="removeprod.php" onsubmit="return confirm('Are you sure you want to remove this item?');">
              <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
              <button type="submit" class="rm-btn" name="action" value="remove">Remove</button>
              </form>
        </div>
      <?php } ?>
    </div>
  </div>
  <!-- Add Product Button -->
  <div class="add-btn-container">
    <form id="prod" method="post" action="addprod.php">
      <button type="submit" class="add-btn" name="submit" value="add">Add a Product</button>
    </form>
  </div>
</div>
</body>
</html>
