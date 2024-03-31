<?php
include('connect.php'); // Include database connection file

// Retrieve reviews from the database
$query = "SELECT * FROM managereview";
$result = mysqli_query($conn, $query);
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
                <input type="text" class="search-input" name="search" value="" placeholder="Search Product">
            </form>
            </div>
            <div class="nav-line"></div>
        </div>
  </div>
<div class="whole-container">
  <!-- Reviews Container -->
  <div class="reviews-container">
    <!-- Reviews Horizontal Flex Box -->
    <div class="h-layout h-flex-block">
        <!-- Reviews Grid -->
      <div class="reviews-grid">
    <?php
    // Check if there are any reviews
    if (mysqli_num_rows($result) > 0) {
        // Loop through each row to display the reviews
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
    } else {
        echo "No reviews found.";
    }
    ?>
      </div>
      <img src="LDAssets/reviews-img-1.png" alt="Image 1" class="image-1"/>
    </div>
  </div>
  <div class="divider"></div>
    <div class="reviews-container-2">
        <div class="h-layout h-flex-block">
            <img src="LDAssets/reviews-img-2.png" alt="Image 2" class="image-2"/>
             <div class="reviews-grid-2">
                <div class="review">
                    <div class="rating">
                        <i class="fas fa-star fa-xl"></i>
                        <i class="fas fa-star fa-xl"></i>
                        <i class="fas fa-star fa-xl"></i>
                        <i class="fas fa-star fa-xl"></i>
                        <i class="fas fa-star fa-xl"></i>
                        </div>
                        <div class="review-text">
                            <p>Hello</p>
                        </div>
                        <div class="customer-info">
                            <p>Toto</p>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
