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
        <div class="topnav">
            <a href="homepage.php">
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
                        <input type="text" class="search-input" id="searchInput" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Search Product">
                    </form>
                </div>
                <div class="nav-line"></div>
            </div>
        </div>
        <!-- Banner -->
        <div class="bg2"></div>
        <div class="intro">
            <h1>Ninja X Manila</h1>
            <h2>2024 Summer Collab Limited Collection</h2>
        </div>
        <div class="container">
            <div class="items-wrapper">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="item">
                        <img class="item-image" src="<?php echo $row['img']; ?>" alt="<?php echo htmlspecialchars($row['Product_Name']); ?>">
                        <h3 class="item-title"><?php echo htmlspecialchars($row['Product_Name']); ?></h3>
                        <div class="item-deets"><?php echo htmlspecialchars($row['Description']); ?></div>
                        <div class="item-deets">Quantity: <?php echo $row['Quantity']; ?></div>
                        <div class="item-deets">Price: <?php echo number_format($row['Price'], 2, '.', ','); ?> PHP</div>
                        <form method="post" action="viewprod.php">
                            <!-- get the value and pass to the viewprod.php -->
                            <input type="hidden" name="image" value="<?php echo $row['img']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['Product_Name']); ?>">
                            <input type="hidden" name="quantity" value="<?php echo $row['Quantity']; ?>">
                            <input type="hidden" name="price" value="<?php echo $row['Price']; ?>">
                            <button class="item-btn" type="submit" name="submit" value="check">Check Item</button>
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>

<!-- JavaScript for live search with debounce -->
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