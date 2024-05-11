
<?php
include('connect.php');

// Initialize SQL query
$sql = "SELECT * FROM manageprod";

// Check if search query is set
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    // Modify SQL query to include search condition
    $sql .= " WHERE Product_Name LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Inventory products!</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./inventory.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Website Icon -->
    <link rel="icon" href="./LDAssets/lz logo.png">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
   <!-- Background Image -->
<div class="bg">
  <!-- Navigation Bar -->
  <div class="topnav">
    <a href="admin_mainpage.php">
      <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
    </a>
    <!-- Icons -->
    <div class="nav-h-layout">
      <!-- Logout Icon -->
      <div class="nav-icon">
        <a href="./logout.php">
          <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
        </a>
      </div>
      <div class="nav-line"></div>
      <!-- Search -->
      <div class="nav-search">
        <form class="search-form" method="get">
        <button class="search-btn" type="submit"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
        <input type="text" class="search-input" id="searchInput" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Search Product">
        </form>
      </div>
      <div class="nav-line"></div>
    </div><!-- Navigation bar content -->
    </div>
        <div class="container">
            <h1>Inventory Products</h1>
            <div class="items-wrapper">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="item">
                        <img class="item-image" src="<?php echo $row['img']; ?>" alt="<?php echo $row['Product_Name']; ?>">
                        <div class="item-details">
                        <h3 class="item-title"><?php echo $row['Product_Name']; ?></h3>
                        <div class="item-desc"><?php echo $row['Description']; ?></div>
                        <!-- Check each size individually for out of stock -->
                        <?php if ($row['Quantity_Small'] == 0) { ?>
                            <div class="item-quantity">S: Out of stock</div>
                        <?php } else { ?>
                            <div class="item-quantity">S: <?php echo $row['Quantity_Small']; ?></div>
                        <?php } ?>
                        <?php if ($row['Quantity_Medium'] == 0) { ?>
                            <div class="item-quantity">M: Out of stock</div>
                        <?php } else { ?>
                            <div class="item-quantity">M: <?php echo $row['Quantity_Medium']; ?></div>
                        <?php } ?>
                        <?php if ($row['Quantity_Large'] == 0) { ?>
                            <div class="item-quantity">L: Out of stock</div>
                        <?php } else { ?>
                            <div class="item-quantity">L: <?php echo $row['Quantity_Large']; ?></div>
                        <?php } ?>
                        <?php if ($row['Quantity_XL'] == 0) { ?>
                            <div class="item-quantity">XL: Out of stock</div>
                        <?php } else { ?>
                            <div class="item-quantity">XL: <?php echo $row['Quantity_XL']; ?></div>
                            
                        <?php } ?>
                        <div class="item-cost">Cost: <?php echo number_format($row['Prod_Cost'], 2, '.', ','); ?> PHP</div>
                        <div class="item-price">Price: <?php echo number_format($row['Price'], 2, '.', ','); ?> PHP</div>
                        </div>
                        <!-- Edit Button -->
                        <a href="editprod.php?product_id=<?php echo $row['ProductID']; ?>">
                            <button class="edit-btn" type="submit" name="submit" value="check">Edit Item</button>
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
        <div class="add-btn-container">
            <form id="prod" method="post" action="addprod.php">
                <button type="submit" class="add-btn" name="submit" value="add">Add a Product</button>
            </form>
        </div>
    </div>
</body>
</html>

<script>
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
        var searchQuery = $("#searchInput").val().toLowerCase();
        $(".item").each(function() {
            var productName = $(this).find(".item-title").text().toLowerCase();
            if (productName.includes(searchQuery)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        // If the search query is empty, show all items
        if (searchQuery === '') {
            $(".item").show();
        }
    }
});
</script>
