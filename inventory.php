<?php
include('connect.php');

// Check if search parameter is provided in the URL
if(isset($_GET['search'])) {
    // Sanitize the search input to prevent SQL injection
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    // Construct the SQL query to filter results based on the search input
    $sql = "SELECT * FROM manageprod WHERE Product_Name LIKE '%$search%'";
} else {
    // If no search parameter provided, retrieve all products
    $sql = "SELECT * FROM manageprod";
}

$result = mysqli_query($conn, $sql);
$counter = 1; // Counter for numbering items

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inventory</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./inventory.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Website Icon -->
    <link rel="icon" href="./LDAssets/lz logo.png">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
  <!-- Background Image -->
<div class="bg">
  <!-- Navigation Bar -->
  <div class="topnav">
    <a href="homepage.php">
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
      <!-- Search -->
      <div class="nav-search">
        <form class="search-form" method="get">
          <button class="search-btn" type="submit"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
          <input type="text" class="search-input" id="searchInput" name="search" value="<?php echo isset($search) ? $search : ''; ?>" placeholder="Search Product">
        </form>
      </div>
      <div class="nav-line"></div>
    </div><!-- Navigation bar content -->
  </div>
  <div class="container">
    <h1>Inventory</h1>
    <div class="items-wrapper" id="itemsWrapper">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="item">
        <img class="item-image" src="<?php echo $row['img']; ?>" alt="<?php echo $row['Product_Name']; ?>">
            <h3 class="item-title"><?php echo $row['Product_Name']; ?></h3>
            <ul class="item-details">
                <li>Description: <?php echo $row['Description']; ?></li>
                        <!-- Check each size individually for out of stock -->
                        <?php if ($row['Quantity_Small'] == 0) { ?>
                          <div class="item-deets">Small: Out of stock</div>
                        <?php } else { ?>
                           <div class="item-deets">Small: <?php echo $row['Quantity_Small']; ?></div>
                        <?php } ?>
                        <?php if ($row['Quantity_Medium'] == 0) { ?>
                          <div class="item-deets">Medium: Out of stock</div>
                        <?php } else { ?>
                           <div class="item-deets">Medium: <?php echo $row['Quantity_Medium']; ?></div>
                        <?php } ?>
                        <?php if ($row['Quantity_Large'] == 0) { ?>
                           <div class="item-deets">Large: Out of stock</div>
                        <?php } else { ?>
                           <div class="item-deets">Large: <?php echo $row['Quantity_Large']; ?></div>
                        <?php } ?>
                        <?php if ($row['Quantity_XL'] == 0) { ?>
                           <div class="item-deets">XL: Out of stock</div>
                        <?php } else { ?>
                           <div class="item-deets">XL: <?php echo $row['Quantity_XL']; ?></div>
                        <?php } ?>
                <li>Price: <?php echo number_format($row['Price'], 2, '.', ','); ?> PHP</li>
            </ul>
        </div>
        <?php
        }
        ?>
    </div>
</div>
</div>

<!-- JavaScript for live search with debounce -->
<script>
// Function to debounce search input
function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

$(document).ready(function(){
    $("#searchInput").on("keyup", debounce(function() {
        var value = $(this).val().toLowerCase();
        $("#itemsWrapper .item").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    }, 300)); // 300 milliseconds debounce time
});
</script>

</body>
</html>
