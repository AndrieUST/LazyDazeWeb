<?php
include('connect.php');

// Initialize variables to store user information
$registered_email = '';
$confirmed = 0;
$customer_email = '';

// Check if the user is logged in and fetch user information from the database
if(isset($_SESSION['registered_email'])) {
    
    $registered_email = $_SESSION['registered_email'];

    // Fetch confirmed status from the database
    $query = "SELECT Confirmed FROM users WHERE Customer_Email = '$registered_email'";
    $result = mysqli_query($conn, $query);
    
    // Check if the query was successful
    if($result) {
        // Fetch the confirmed status
        $row = mysqli_fetch_assoc($result);
        $confirmed = $row['Confirmed'];

        // Determine the cart and inquiries page URLs based on user confirmation status
        if($confirmed == 1) {
            $cartPage = "cart.php"; // Set the cart page URL
            $inquiriesPage = "inquiries.php"; // Set the inquiries page URL
        } else {
            $cartPage = "#"; // Set a placeholder URL for the cart page
            $inquiriesPage = "#"; // Set a placeholder URL for the inquiries page
            
        }
        
        

    } else {
        // Handle the case where the query fails
        echo "<div class='error'>Error fetching user confirmation status.</div>";
    }
} else {
    // Prompt a warning message or handle the case where user is not logged in
    echo "<div class='warning'>Only verified users can submit reviews and add items to the cart.</div>";
}

// Check if product ID is provided in the URL
if(isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    // Fetch product details from the database
    $product_query = "SELECT * FROM manageprod WHERE ProductID = $product_id"; // Updated query
    $product_result = mysqli_query($conn, $product_query);

    // Check for errors
    if (!$product_result) {
        // If there's an error, print the SQL query and the error message
        echo "Error in SQL query: " . $product_query . "<br>";
        echo "Error message: " . mysqli_error($conn);
        exit(); // Stop further execution
    }

    // Fetch product details
    $product_row = mysqli_fetch_assoc($product_result);
    
    // Check if product details are fetched successfully
    if($product_row) {
        // Extract product details
        $Product_Name = $product_row['Product_Name'];
        $Price = $product_row['Price'];
        $image = $product_row['img'];
        // Default to Quantity_Small if size is not selected
        $Quantity_Small = $product_row['Quantity_Small'];
        $Quantity_Medium = $product_row['Quantity_Medium'];
        $Quantity_Large = $product_row['Quantity_Large'];
        $Quantity_XL = $product_row['Quantity_XL'];
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

// Fetch reviews from the database
if (isset($_SESSION['registered_email'])) {
    $customer_email = $_SESSION['registered_email'];
    $reviews_query = "SELECT * FROM managereview WHERE Customer_Email = '$customer_email'";
    $reviews_result = mysqli_query($conn, $reviews_query);
} else {
    // Prompt user to log in to view reviews
    echo "<div class='warning'>Please login and Buy products to submit reviews.</div>";
}

// Check if the review form is submitted
if(isset($_POST['submit_review'])) {
    // Check if the user's email is verified
    // Initialize variables to store user information
    $registered_email = '';
    $confirmed = 0;
    $customer_email = isset($_SESSION['registered_email']) ? $_SESSION['registered_email'] : ''; // Add this line to define $customer_email
    // Check if the user is logged in and fetch user information from the database
    if(isset($_SESSION['registered_email'])) {
        $registered_email = $_SESSION['registered_email'];

        // Fetch confirmed status from the database
        $query = "SELECT Confirmed FROM users WHERE Customer_Email = '$registered_email'";
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if($result) {
            // Fetch the confirmed status
            $row = mysqli_fetch_assoc($result);
            $confirmed = $row['Confirmed'];
        }


        // Determine the cart and inquiries page URLs based on user confirmation status
        if($confirmed == 1) {
            $cartPage = "cart.php"; // Set the cart page URL
            $inquiriesPage = "inquiries.php"; // Set the inquiries page URL
        } else {
            $cartPage = "#"; // Set a placeholder URL for the cart page
            $inquiriesPage = "#"; // Set a placeholder URL for the inquiries page
        }
        $purchase_query = "SELECT * FROM manageorders WHERE Customer_Email = '$customer_email' AND Product_Name = '$Product_Name' AND Status = 'Received'";
        $purchase_result = mysqli_query($conn, $purchase_query);

        if(mysqli_num_rows($purchase_result) > 0) {

            // Get form data
            $customer_name = $_POST['customer_name']; // Optional field, adjust accordingly
            $review_message = $_POST['review_message'];
            $rating = $_POST['rating'];
            $product_name = $_POST['product_name'];

            // Insert data into managereview table
            $insert_review_query = "INSERT INTO managereview (Customer_Email, Customer_Name, Review_Message, Rating, Product_Name) VALUES ('$customer_email', '$customer_name', '$review_message', $rating, '$Product_Name')";
            $insert_review_result = mysqli_query($conn, $insert_review_query);

            if($insert_review_result) {
                // Notify the user that the review has been submitted successfully
                echo "<div class='success'>Thank you for your review! It has been submitted successfully.</div>";
                // Redirect to viewprod.php to prevent form resubmission prompt
                header('Location: viewprod.php?product_id=' . $product_id);
                exit();
            } 
        } else {
            // Inform the user that they can only review products they have received
            echo "<div class='warning'>You can only submit a review for products you have received.</div>";

        } 
    }
}

/// Check if the add to cart form is submitted
if(isset($_POST['submit_cart'])) {
    // Check if the user is logged in and fetch user information from the database
    if(isset($_SESSION['registered_email'])) {
        $registered_email = $_SESSION['registered_email'];

        // Fetch confirmed status from the database
        $query = "SELECT Confirmed FROM users WHERE Customer_Email = '$registered_email'";
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if($result) {
            // Fetch the confirmed status
            $row = mysqli_fetch_assoc($result);
            $confirmed = $row['Confirmed'];

            // Determine the cart and inquiries page URLs based on user confirmation status
            if($confirmed == 1) {
                
                $cartPage = "cart.php"; // Set the cart page URL
                $inquiriesPage = "inquiries.php"; // Set the inquiries page URL
                echo "<div class='success'>Product added successfully.</div>";
                // Get form data
                $size = $_POST['size'];
                $quantity = $_POST['quantity'];
                $Quantity_Small = $product_row['Quantity_Small'];
                $Quantity_Medium = $product_row['Quantity_Medium'];
                $Quantity_Large = $product_row['Quantity_Large'];
                $Quantity_XL = $product_row['Quantity_XL'];
                $product_name = $_POST['product_name'];
                $base_price = $product_row['Price'];
                $image = $_POST['image'];

                // Calculate the total price based on quantity
                $TotalPrice = $base_price * $quantity;
                
                // Insert data into managecart table with user's email and ID
                $insert_cart_query = "INSERT INTO managecart (Customer_Email, Size, Quantity, Product_Name, Price, TotalPrice, img) 
                              VALUES ('$registered_email', '$size', $quantity, '$product_name', $base_price, $TotalPrice, '$image')";
                $insert_cart_result = mysqli_query($conn, $insert_cart_query);
                if($insert_cart_result) {
                    // Redirect to viewprod.php to prevent form resubmission prompt
                    echo "<div class='success'>Product added successfully.</div>";
                    header('Location: viewprod.php?product_id=' . $product_id);
                    exit();
                } else {
                    // Notify the user if an error occurred while adding to cart
                    echo "<div class='error'>Oops! Something went wrong while adding the item to your cart. Please try again later.</div>";
                }
            } else {
                // Prompt a warning message
                echo "<script>alert('Only verified users can add to cart.'); window.location.href = 'viewprod.php?product_id=$product_id';</script>";
                exit(); // Stop further execution
            }
        }
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
    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
  <!-- Background Image -->
<div class = "bg">
  <!-- Navigation Bar -->
  <div class="topnav">
  <a href="products.php">  <!-- Updated href attribute here -->
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
        <a <?php if (!isset($_SESSION['registered_email'])) echo 'class="disabled-link"'; ?> href="<?php echo $cartPage; ?>">
                <i class="fa-solid fa-cart-shopping fa-xl"></i>
                <span id="cart-notification" class="cart-notification">0</span> <!-- Notification badge -->
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
        <div class="nav-line"></div>
                <!-- Info Icon -->
                <div class="nav-icon">
                    <a href="<?php echo $inquiriesPage; ?>">
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
                 <!-- Provide options for size -->


<!-- Quantity options for Small size -->
<label for="size-field">Size</label>
          <select class="select-field" id="size-field" name="size">
            <option value=""></option>
            <option value="Small">S</option>
            <option value="Medium">M</option>
            <option value="Large">L</option>
            <option value="XL">XL</option>
          </select>
          <!-- Quantity selection dropdown -->
          <label for="quantity-field">Quantity</label>
          <select class="select-field" id="quantity-field" name="quantity">
            <!-- Quantity options will be dynamically updated based on the selected size -->
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
    <div class="v-layout-reviews v-flex-block-reviews">
        <div class="reviews-grid"> 
        <!-- Reviews will be dynamically fetched and displayed here -->
        </div>
    </div>
</div>
<!-- JavaScript block -->
<script>
    $(document).ready(function() {
         // Function to fetch and display reviews
    function fetchReviews() {
        var productName = "<?php echo $Product_Name; ?>"; // Get the product name from PHP
        $.ajax({
            url: 'fetch_reviews.php',
            type: 'POST',
            data: { product_name: productName },
            success: function(data) {
                $('.reviews-grid').html(data);
            }
        });
    }

    // Function to update cart notification badge
    function updateCartNotification() {
        $.ajax({
            url: 'fetch_cart_count.php', // Endpoint to fetch cart count
            type: 'GET',
            success: function(count) {
                $('#cart-notification').text(count);
            }
        });
    }

    // Call updateCartNotification() when the page is loaded
    updateCartNotification();

    // Call fetchReviews() when the page is loaded
    fetchReviews();

    // Function to validate the form before submission
    $('#prod-form').submit(function(event) {
        // Get the selected size and quantity
        var size = $('#size-field').val();
        var quantity = $('#quantity-field').val();

        // Check if size and quantity are not selected
        if (size === "" || quantity === "") {
            // Prevent the form from submitting
            event.preventDefault();
            // Display a prompt to the user
            alert("Please select size and quantity before adding to cart.");
        }
    });

      // Function to update quantity dropdown options based on the selected size
      $('#size-field').change(function() {
        var selectedSize = $(this).val();
        var quantityOptions = [];

        // Clear previous options
        $('#quantity-field').empty();

        // Determine quantity options based on the selected size
        if (selectedSize === "Small") {
            quantityOptions = <?php echo $Quantity_Small > 0 ? json_encode(range(1, $Quantity_Small)) : '["Out of Stock"]'; ?>;
        } else if (selectedSize === "Medium") {
          quantityOptions = <?php echo $Quantity_Medium > 0 ? json_encode(range(1, $Quantity_Medium)) : '["Out of Stock"]'; ?>;
        } else if (selectedSize === "Large") {
          quantityOptions = <?php echo $Quantity_Large > 0 ? json_encode(range(1, $Quantity_Large)) : '["Out of Stock"]'; ?>;
        } else if (selectedSize === "XL") {
          quantityOptions = <?php echo $Quantity_XL > 0 ? json_encode(range(1, $Quantity_XL)) : '["Out of Stock"]'; ?>;
        }

        // Add quantity options to the dropdown
        $.each(quantityOptions, function(index, value) {
          $('#quantity-field').append($('<option>').text(value).attr('value', value));
        });
      });
    });
  </script>

</body>
</html>