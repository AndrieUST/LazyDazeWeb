<?php
include('connect.php'); // Include database connection file

// Initialize SQL query
$query = "SELECT * FROM managereview";

// Check if search query is set
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    // Modify SQL query to include search condition
    $query .= " WHERE Product_Name LIKE '%$search%'";
}

$result = mysqli_query($conn, $query);

// Calculate the number of reviews
$total_reviews = mysqli_num_rows($result);

// Calculate the number of reviews for each container
$reviews_per_container = ceil($total_reviews / 2);

// Move the pointer to the beginning of the result set
mysqli_data_seek($result, 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./reviews.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- Starability CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/starability-all/css/starability-all.min.css">
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
                <input type="text" class="search-input" id="search-input" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" placeholder="Search Product">
            </form>
            </div>
            <div class="nav-line"></div>
        </div>
  </div>
  <div class="whole-container">
  <!-- Reviews Container 1 -->
  <div class="reviews-container">
    <!-- Reviews Horizontal Flex Box -->
    <div class="h-layout h-flex-block">
        <!-- Reviews Grid for Container 1 -->
      <div class="reviews-grid">
    <?php
    // Loop through each row to display the reviews for container 1
    for ($i = 0; $i < $reviews_per_container && $row = mysqli_fetch_assoc($result); $i++) {
        // Display review information
        echo "<div class='review'>";
        echo "<div class='product_name'>";
        echo "<p><strong>" . $row['Product_Name'] . "</strong></p>";
        echo "</div>";
        echo "<div class='rating'>";
        // Convert numerical rating to star icons
        $rating = intval($row['Rating']);
        for ($j = 1; $j <= 5; $j++) {
            if ($j <= $rating) {
                echo "<i class='fas fa-star fa-xl'></i>";
            } else {
                echo "";
            }
        }
        echo "</div>";
        echo "<div class='review-text'>";
        echo "<p>" . $row['Review_Message'] . "</p>";
        echo "</div>";
        echo "<div class='customer-info'>";
        echo "<p><strong>" . $row['Customer_Name'] . "</strong></p>";
        echo "</div>";
        echo "</div>";
    }
    ?>
      </div>
      <img src="LDAssets/reviews-img-1.png" alt="Image 1" class="image-1"/>
    </div>
  </div>
  <div class="divider"></div>
    <!-- Reviews Container 2 -->
    <div class="reviews-container-2">
        <!-- Reviews Horizontal Flex Box -->
        <div class="h-layout-2 h-flex-block-2">
            <img src="LDAssets/reviews-img-2.png" alt="Image 2" class="image-2"/>
             <!-- Reviews Grid for Container 2 -->
             <div class="reviews-grid-2">
                <?php
                // Loop through each row to display the reviews for container 2
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display review information
                    echo "<div class='review'>";
                    echo "<div class='rating'>";
                    // Convert numerical rating to star icons
                    $rating = intval($row['Rating']);
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            echo "<i class='fas fa-star fa-xl'></i>";
                        } else {
                            echo "";
                        }
                    }
                    echo "</div>";
                    echo "<div class='review-text'>";
                    echo "<p>" . $row['Review_Message'] . "</p>";
                    echo "</div>";
                    echo "<div class='customer-info'>";
                    echo "<p><strong>" . $row['Customer_Name'] . "</strong></p>";
                    echo "</div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
// Debounce function
function debounce(func, wait, immediate) {
    var timeout;
    return function() {
        var context = this,
            args = arguments;
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

// Function to handle search
var handleSearch = debounce(function() {
    var searchQuery = $('#search-input').val();
    window.location.href = 'reviews.php?search=' + searchQuery;
}, 500); // Adjust debounce time as needed

$(document).ready(function() {
    // Bind debounce function to input change event
    $('#search-input').on('input', handleSearch);
});
</script>

</body>
</html>
