<?php
include('connect.php');

// Initialize customer email as null
$Customer_Email = null;

// Fetch reviews from the database
if (isset($_SESSION['registered_email'])) {
    $Customer_Email = $_SESSION['registered_email'];
    $reviews_query = "SELECT * FROM managereview WHERE Customer_Email = '$Customer_Email'";
    $reviews_result = mysqli_query($conn, $reviews_query);
} else {
    // Handle the case where the user is not logged in
    echo "Please log in to view reviews.";
}

// Check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Retrieve product information from the submitted form
    $Product_Name = $_POST["product_name"];
    $Quantity = $_POST["quantity"];
    $Price = $_POST["price"];
    $image = $_POST["image"];
    
    // Check if the customer name is provided in the form
    $Customer_Name = isset($_POST["customer_name"]) ? $_POST["customer_name"] : null;

    // Insert review into database if all required fields are present
    if (isset($_SESSION['registered_email']) && isset($_POST["review_message"]) && isset($_POST["rating"])) { // Check if user is logged in and required fields are set
        $Customer_Email = $_SESSION['registered_email']; // Get the current logged-in user's email
        $Review_Message = $_POST["review_message"];
        $Rating = $_POST["rating"];
        $query = "INSERT INTO managereview (Customer_Email, Customer_Name, Review_Message, Rating) VALUES ('$Customer_Email', '$Customer_Name', '$Review_Message', '$Rating')";
        if (mysqli_query($conn, $query)) {
            // Review inserted successfully
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } elseif (!isset($_SESSION['registered_email'])) {
        // Handle the case where the user is not logged in
        echo "Please log in to submit a review.";
    }

    
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
    }

    // Function to fetch and display reviews
    function fetchReviews() {
        $.ajax({
            url: 'fetch_reviews.php',
            type: 'GET',
            success: function(data) {
                $('.review-container').html(data);
            }
        });
    }

    // Fetch and display reviews when the page is loaded
    $(document).ready(function() {
        fetchReviews();
    });
    </script>
   
</head>
<body>
  <!-- Background Image -->
<div class = "bg">
  <!-- Navigation Bar -->
  <div class="topnav">
    <a href="homepage.php"> <!-- Updated href attribute here -->
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
    <!-- Banner -->
  <div class = "bg2"></div>
  <!-- Item -->
  <div class="h-layout">
        <img class="prod-img" src="<?php echo $image; ?>" alt="<?php echo htmlspecialchars($Product_Name); ?>"/>
        <div class="v-layout">
            <div>
                <!-- Display product name and price -->
                <h1><?php echo htmlspecialchars($Product_Name); ?></h1>
                <h2><?php echo number_format($Price, 2, '.', ','); ?> PHP</h2>
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
                        <?php for ($i = 1; $i <= $Quantity; $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                     <!-- will submit the product_name and echo the name of the product -->
                     <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($Product_Name); ?>">
                    <!-- will submit the price and echo the price -->
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($Price); ?>">
                    <input type="hidden" name="quantity" value="<?php echo $Quantity; ?>">
                    <input type="submit" class="submit-btn" name="submit" value="Add to Cart" />
                </form>
            </div>
        </div>
    </div>
    <form method="POST" class="form-container1">
    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($Product_Name); ?>">
    <input type="hidden" name="quantity" value="<?php echo $Quantity; ?>">
    <input type="hidden" name="price" value="<?php echo htmlspecialchars($Price); ?>">
    <input type="hidden" name="image" value="<?php echo htmlspecialchars($image); ?>">
    <input type="text" name="customer_name" placeholder="Your Name (Optional)">
    <textarea name="review_message" placeholder="Write your review..." required></textarea>
    <label for="rating">Rating:</label>
    <select name="rating" id="rating" required>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    <button type="submit" name="submit">Submit Review</button>
</form>

<div class="review-container">
    <!-- Reviews will be dynamically fetched and displayed here -->
</div>
</div>
</body>
</html>
