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
    // Prompt user to log in to view reviews
    echo "Please log in to view reviews.";
}

// Check if product ID is provided in the URL
if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    // Fetch product details from the database
    $product_query = "SELECT * FROM manageprod WHERE ProductID = $product_id"; // Updated query
    $product_result = mysqli_query($conn, $product_query);
    $product_row = mysqli_fetch_assoc($product_result);
    
    // Check if product details are fetched successfully
    if($product_row) {
        // Extract product details
        $Product_Name = $product_row['Product_Name'];
        $Quantity = $product_row['Quantity'];
        $Price = $product_row['Price'];
        $image = $product_row['img'];
    } else {
        // Inform the user that the product is not found
        echo "Oops! The product you are looking for is not found.";
        exit(); // Stop further execution
    }
} else {
    // Prompt user to provide a product ID
    echo "Product ID is not provided. Please provide a valid product ID.";
    exit(); // Stop further execution
}

// Check if the review form is submitted
if(isset($_POST['submit_review'])) {
    // Get form data
    $customer_email = $_SESSION['registered_email']; // Assuming the email is stored in the session
    $customer_name = $_POST['customer_name']; // Optional field, adjust accordingly
    $review_message = $_POST['review_message'];
    $rating = $_POST['rating'];
    $product_name = $_POST['product_name'];

    // Insert data into managereview table
    $insert_review_query = "INSERT INTO managereview (Customer_Email, Customer_Name, Review_Message, Rating, Product_Name) VALUES ('$customer_email', '$customer_name', '$review_message', $rating, '$product_name')";
    $insert_review_result = mysqli_query($conn, $insert_review_query);

    if($insert_review_result) {
        // Notify the user that the review has been submitted successfully
        echo "Thank you for your review! It has been submitted successfully.";
    } else {
        // Notify the user if an error occurred while submitting the review
        echo "Oops! Something went wrong while submitting your review. Please try again later.";
    }
}

// Check if the add to cart form is submitted
if(isset($_POST['submit_cart'])) {
    // Get form data
    $size = $_POST['size'];
    $quantity = $_POST['quantity'];
    $product_name = $_POST['product_name'];
    $base_price = $_POST['price']; // Fetch the base price
    $image = $_POST['image'];

    // Calculate the total price based on quantity
    $total_price = $base_price * $quantity;

    // Insert data into managecart table
    $insert_cart_query = "INSERT INTO managecart (Size, Quantity, Product_Name, Price, img) VALUES ('$size', $quantity, '$product_name', $total_price, '$image')";
    $insert_cart_result = mysqli_query($conn, $insert_cart_query);

    if($insert_cart_result) {
        // Notify the user that the item has been added to the cart successfully
        echo "The item has been added to your cart successfully.";
    } else {
        // Notify the user if an error occurred while adding to cart
        echo "Oops! Something went wrong while adding the item to your cart. Please try again later.";
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
            <a href="cart.php">
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
                <form id="prod-form" name="prod-form" method="post" action="">
                    <!-- Provide options for quantity -->
                    <label for="size-field">Size</label>
                    <select class="select-field" id="size-field" name="size">
                        <option value=""></option>
                        <option value="First">S</option>
                        <option value="Second">M</option>
                        <option value="Third">L</option>
                    </select>
                    <label for="quantity-field">Quantity</label>
                    <select class="select-field" id="quantity-field" name="quantity">
                        <option value=""></option>
                        <!-- Loop to provide quantity options base on the number input in SQL -->
                        <?php for ($i = 1; $i <= $Quantity; $i++) { ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                    <!-- Hidden input fields for other product details -->
                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($Product_Name); ?>">
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($Price); ?>">
                    <input type="hidden" name="image" value="<?php echo htmlspecialchars($image); ?>">
                    <!-- Submit button for adding to cart -->
                    <input type="submit" class="submit-btn" name="submit_cart" value="Add to Cart" />
                </form>
            </div>
        </div>
    </div>
    <!-- Review Form -->
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
        <button type="submit" name="submit_review">Submit Review</button>
    </form>

    <!-- Review Container -->
    <div class="review-container">
        <!-- Reviews will be dynamically fetched and displayed here -->
    </div>
</div>

<!-- JavaScript block moved here -->
<script>
    // Function to fetch and display reviews
    function fetchReviews() {
        var productName = "<?php echo $Product_Name; ?>"; // Get the product name from PHP
        $.ajax({
            url: 'fetch_reviews.php',
            type: 'POST',
            data: { product_name: productName },
            success: function(data) {
                $('.review-container').html(data);
            }
        });
    }
    // Call fetchReviews() when the page is loaded
    $(document).ready(function() {
        fetchReviews();
    });
</script>
</body>
</html>
