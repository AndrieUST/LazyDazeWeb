<?php
include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Lazy Daze!</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="./cart.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
    <div class="bg">
        <div class="topnav">
            <a href="homepage.php">
                <img align="left" class="ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
            </a>
            <div class="nav-h-layout">
                <div class="nav-icon">
                    <a href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
                    </a>
                </div>
                <div class="nav-line"></div>
                <div class="nav-icon">
                    <a href="reviews.php">
                        <i class="fa-solid fa-star fa-xl"></i>
                    </a>
                </div>
                <div class="nav-line"></div>
                <div class="nav-icon">
                    <a href="inquiries.php">
                        <i class="fa-solid fa-circle-info fa-xl"></i>
                    </a>
                </div>
                <div class="nav-line"></div>
            </div>
        </div>
        <section class="section-2"></section>
        <section class="container">
            <form method="post" action="Payment.php">
                <section class="container">
                    <div class="grid">
                        <?php
                        // Check if the user is logged in
                        if(isset($_SESSION['registered_email']) && isset($_SESSION['email_verified_at']) && $_SESSION['email_verified_at'] !== null) {
                            // User is logged in and email is verified
                            $customer_email = $_SESSION['registered_email'];
                            $total_price = 0; // Initialize total price

                            // Fetch products from managecart table for the logged-in user
                            $cart_query = "SELECT id, Product_Name, Size, Quantity, img FROM managecart WHERE Customer_Email = '$customer_email'";
                            $cart_result = mysqli_query($conn, $cart_query);

                            // Check if there are products in the cart
                            if(mysqli_num_rows($cart_result) > 0) {
                                // Display cart items
                                while($row = mysqli_fetch_assoc($cart_result)) {
                                    $id = $row['id']; // Retrieve the id
                                    $product_name = $row['Product_Name'];
                                    $size = $row['Size'];
                                    $quantity = $row['Quantity'];
                                    $image = $row['img'];

                                    // Fetch price from manageprod table based on product name
                                    
                                        $price_query = "SELECT Price, Quantity_$size as AvailableQuantity FROM manageprod WHERE Product_Name = '$product_name'";
                                    
                                    $price_result = mysqli_query($conn, $price_query);
                                    $price_row = mysqli_fetch_assoc($price_result);
                                    $price = $price_row['Price'];
                                    $available_quantity = $price_row['AvailableQuantity'];

                                    // Calculate total price for each product
                                    $total_price += $price * $quantity;

                                    // Check if the quantity exceeds the available quantity
                                    if($quantity > $available_quantity) {
                                        echo "<p style='color: red;'>Maximum quantity has been reached for $product_name!</p>";
                                    }

                                    // Output cart item HTML
                                    echo "<div class='row'>";
                                    echo "<div class='col-md-4'>";
                                    echo "<div class='cart-item'>";
                                    echo "<img src='$image' alt='$product_name' class='cart-item-image'>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "<div class='col-md-8'>";
                                    echo "<div class='cart-item-details'>";
                                    echo "<p>$product_name</p>";
                                    echo "<div class='row'>";
                                    echo "<p>Size: $size</p>";
                                    echo "<p>Quantity: $quantity</p>";
                                    echo "<p>Price: $price PHP</p>";
                                    // Add button to trigger modal
                                    echo "<button type='button' class='btn btn-primary edit-btn' data-toggle='modal' data-target='#editModal_$id' data-product='$product_name' data-size='$size' data-quantity='$quantity' data-id='$id'>Edit</button>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";

                                    // Add modal template for each product
                                    echo "<div id='editModal_$id' class='modal fade' role='dialog' data-product-name='$product_name'>"; // Add data attribute for product name
                                    echo "<div class='modal-dialog'>";
                                    echo "<div class='modal-content'>";
                                    echo "<div class='modal-header'>";
                                    echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
                                    echo "<h4 class='modal-title'>Edit Product</h4>";
                                    echo "</div>";
                                    echo "<div class='modal-body'>";
                                    echo "<label for='edit_size_$id'>Size:</label>";
                                    echo "<select id='edit_size_$id' class='edit-size'>";
                                    echo "<option value='Small'>Small</option>";
                                    echo "<option value='Medium'>Medium</option>";
                                    echo "<option value='Large'>Large</option>";
                                    echo "<option value='XL'>XL</option>";
                                    echo "</select>";
                                    echo "<label for='edit_quantity_$id'>Quantity:</label>";
                                    echo "<input type='number' id='edit_quantity_$id' class='edit-quantity'>";
                                    echo "<div id='available-quantity-$id'></div>"; // Display available quantity for each size here
                                    echo "<button type='button' class='btn btn-success save-btn' data-id='$id'>Save Changes</button>";
                                    echo "<button type='button' class='btn btn-danger delete-btn' data-id='$id'>Delete</button>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                                }

                                // Display total price
                                echo "<p>Total Price: $total_price PHP</p>";

                                echo "<form method='post' action='Payment.php'>";
                                
                                echo "<button type='submit' class='btn btn-success'>Proceed to Payment</button>";
                                echo "</form>";
                            } else {
                                echo "<p>No items in the cart</p>";
                            }
                        } else {
                            // User is not logged in or email is not verified
                            echo "<p>Please log in to view your cart</p>";
                        }
                        ?>
                    </div>
                </section>
            </form>
        </section>
    </div>

</body>
</html>

<script>
$(document).ready(function() {
    // Function to handle size change
    $('.edit-size').on('change', function() {
        var id = $(this).closest('.modal').attr('id').split('_')[1]; // Get product ID from modal ID
        var selectedSize = $(this).val(); // Get selected size
        var productName = $('#editModal_' + id).data('product-name'); // Get product name
        var modal = $(this).closest('.modal'); // Get the current modal

        // Fetch available quantity for the selected size and product name using AJAX
        $.ajax({
            url: 'fetch_available_quantity.php',
            method: 'POST',
            data: {
                productName: productName,
                size: selectedSize
            },
            success: function(response) {
                // Clear the content of the available quantity element
                $('#available-quantity-' + id).empty();
                // Update available quantity in the modal
                $('#available-quantity-' + id).text('Available Quantity (' + selectedSize + '): ' + response);
            },
            error: function() {
                console.log('Error fetching available quantity');
            }
        });
    });

    // Function to handle edit button click
    $('.edit-btn').on('click', function(event) {
        var id = $(this).data('id'); // Get product ID
        var size = $(this).data('size'); // Get product size
        var quantity = $(this).data('quantity'); // Get product quantity
        // Set modal fields with product details
        $('#edit_size_' + id).val(size);
        $('#edit_quantity_' + id).val(quantity);
    });

    // Function to handle save button click
    $('.save-btn').on('click', function(event) {
        var id = $(this).data('id'); // Get product ID
        var size = $('#edit_size_' + id).val(); // Get selected size
        var quantity = $('#edit_quantity_' + id).val(); // Get entered quantity
        var availableQuantity = $('#editModal_' + id).data('available-quantity'); // Get available quantity
        // Check if quantity exceeds available quantity
        if (quantity > availableQuantity) {
            alert('The requested quantity exceeds the available stock.');
            return; // Stop execution if quantity exceeds available quantity
        }
        // Send AJAX request to edit_cart.php
        $.ajax({
            url: 'editcart.php',
            method: 'POST',
            data: {
                id: id,
                size: size,
                quantity: quantity
            },
            success: function(response) {
                // Handle success response
                alert('Product updated successfully.'); // Display success message or perform any necessary actions
                // Redirect to cart page or update the display as needed
                window.location.reload(); // Reload the page after successful edit
            },
            error: function() {
                // Handle error
                alert('Failed to edit product. Please try again.');
            }
        });
    });

    // Function to handle delete button click
    $('.delete-btn').on('click', function(event) {
        var id = $(this).data('id'); // Get product ID
        // Show confirmation dialog
        if (confirm('Are you sure you want to delete this product?')) {
            // User confirmed, send AJAX request to remove_cart.php
            $.ajax({
                url: 'remove_cart.php',
                method: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    // Handle success response
                    alert(response); // Display success message or perform any necessary actions
                    // Refresh the page or update the cart display as needed
                    window.location.reload(); // Reload the page after successful deletion
                },
                error: function() {
                    // Handle error
                    alert('Failed to delete product. Please try again.');
                }
            });
        } else {
            // User canceled, do nothing
            // Optionally, you can close any related modals or perform other actions here
        }
    });
});

</script>
