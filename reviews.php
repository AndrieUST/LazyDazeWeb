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

  <!-- Reviews Container -->
  <div class="reviews-container">
    
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
                    echo "<i class='fas fa-star'></i>";
                } else {
                    echo "<i class='far fa-star'></i>";
                }
            }
            echo "</div>";
            echo "<div class='review-text'>";
            echo "<p><strong>Review:</strong> " . $row['Review_Message'] . "</p>";
            echo "</div>";
            echo "<div class='customer-info'>";
            echo "<p><strong>Customer Name:</strong> " . $row['Customer_Name'] . "</p>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "No reviews found.";
    }
    ?>
  </div>

  <!-- Add Review Button -->
  <div class="review-button">
    <button class="add-review" data-toggle="modal" data-target="#addReviewModal">Add Review</button>
  </div>
</div>

<!-- Add Review Modal -->
<div class="modal fade" id="addReviewModal" tabindex="-1" role="dialog" aria-labelledby="addReviewModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="addReviewModalLabel">Add Review</h4>
      </div>
      <div class="modal-body">
        <!-- Replace this form tag -->
        <form action="submit_review.php" method="post">
          <div class="form-group">
            <label for="customerName">Your Name:</label>
            <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Enter your name">
          </div>
          <div class="form-group">
            <label for="starRating">Your Rating:</label>
            <div class="starability-grow">
                <i class="far fa-star" data-rating="1"></i>
                <i class="far fa-star" data-rating="2"></i>
                <i class="far fa-star" data-rating="3"></i>
                <i class="far fa-star" data-rating="4"></i>
                <i class="far fa-star" data-rating="5"></i>
            </div>
            <input type="hidden" name="rating" id="rating">
          </div>
          <div class="form-group">
            <label for="reviewText">Your Review:</label>
            <textarea class="form-control" id="reviewText" name="reviewText" rows="5"></textarea>
          </div>
          <input type="hidden" name="submit" value="submit_review"> <!-- Add a hidden input field to identify the form submission -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Submit Review</button> <!-- Move the submit button inside the form -->
          </div>
        </form>
        <!-- End of replaced form tag -->
      </div>
    </div>
  </div>
</div>

<!-- Script for star rating -->
<script>
    $(document).ready(function() {
        $('#addReviewModal').on('shown.bs.modal', function () {
            $('.fa-star').on('click', function() {
                var rating = $(this).data('rating');
                $('.fa-star').removeClass('fas').addClass('far');
                $(this).prevAll('.fa-star').addBack().removeClass('far').addClass('fas');
                $('#rating').val(rating);
            });
        });
    });
</script>

</body>
</html>
