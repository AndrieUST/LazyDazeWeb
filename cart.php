<?php
include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
            <a href="mainpage.php">
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
        <div class="container">
            <div class="grid">
                <?php
                // Check if the user is logged in
                if(isset($_SESSION['registered_email']) && isset($_SESSION['email_verified_at']) && $_SESSION['email_verified_at'] !== null) {
                    // User is logged in and email is verified
                    $customer_email = $_SESSION['registered_email'];
                    $total_price = 0; // Initialize total price

                    // Fetch products from managecart table for the logged-in user
                    $cart_query = "SELECT * FROM managecart WHERE Customer_Email = '$customer_email'";
                    $cart_result = mysqli_query($conn, $cart_query);

                    // Check if there are products in the cart
                    if(mysqli_num_rows($cart_result) > 0) {
                        // Display cart items
                        while($row = mysqli_fetch_assoc($cart_result)) {
                            $product_id = $row['id'];
                            $product_name = $row['Product_Name'];
                            $size = $row['Size'];
                            $quantity = $row['Quantity'];
                            $price = $row['Price'];
                            $image = $row['img'];
                            
                            // Calculate total price for this item
                            $total_item_price = $price * $quantity;
                            $total_price += $total_item_price; // Accumulate total price

                            // Output cart item HTML
                            echo "<div class='row-item'>";
                            echo "<div class='col-md-4'>";
                            echo "<div class='cart-item'>";
                            echo "<img src='$image' alt='$product_name' class='cart-item-image'>";
                            echo "</div>";
                            echo "</div>";
                            echo "<div class='row-details'>";
                            echo "<div class='cart-item-name'>$product_name</div>";
                            echo "<div class='cart-item-size'>SIZE: <div class='size'>$size</div></div>";
                            echo "<div class='cart-item-quantity'>QTY: <div class='qty'>$quantity</div></div>";
                            echo "<div class='cart-item-price'>$price PHP</div>";
                            echo "<div class='cart-item-total-price'>Total Price: <div class='total-item-price'>$total_item_price PHP</div></div>"; // Display total price for this item
                            echo "</div>";
                            echo "<button class='edit-btn' data-toggle='modal' data-target='#editModal$product_id'>Edit</button>";
                            echo "</div>";

                           // Edit Modal
                            echo "<div class='modal fade' id='editModal$product_id' tabindex='-1' role='dialog' aria-labelledby='editModalLabel$product_id'>";
                            echo "<div class='modal-dialog' role='document'>";
                            echo "<div class='modal-content'>";
                            echo "<div class='modal-header'>";
                            echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>";
                            echo "<h4 class='modal-title' id='editModalLabel$product_id'>Edit Product</h4>";
                            echo "</div>";
                            echo "<div class='modal-body'>";

                            // Note to display in the modal
                            echo "<p class='note'>Please refer to the following Quantity per Sizes. Thank you.</p>";

                            echo "<form action='editcart.php' method='post'>";
                            echo "<div class='form-group'>";
                            echo "<label for='size'>Size:</label>";
                            echo "<select name='size' id='size' class='form-control'>";
                            echo "<option value='Small' ". ($size == 'Small' ? 'selected' : '') .">Small</option>";
                            echo "<option value='Medium' ". ($size == 'Medium' ? 'selected' : '') .">Medium</option>";
                            echo "<option value='Large' ". ($size == 'Large' ? 'selected' : '') .">Large</option>";
                            echo "<option value='XL' ". ($size == 'XL' ? 'selected' : '') .">XL</option>";
                            echo "</select>";
                            echo "</div>";
                            echo "<div class='form-group'>";
                            echo "<label for='quantity'>Quantity:</label>";
                            echo "<input type='number' name='quantity' id='quantity' value='$quantity' min='1' class='form-control'>";
                            echo "</div>";

                            // Fetch quantity sizes per product from manageprod table
                            $manageprod_query = "SELECT Quantity_Small, Quantity_Medium, Quantity_Large, Quantity_XL FROM manageprod WHERE Product_Name = '$product_name'";
                            $manageprod_result = mysqli_query($conn, $manageprod_query);
                            $manageprod_row = mysqli_fetch_assoc($manageprod_result);
                            $quantity_small = $manageprod_row['Quantity_Small'];
                            $quantity_medium = $manageprod_row['Quantity_Medium'];
                            $quantity_large = $manageprod_row['Quantity_Large'];
                            $quantity_xl = $manageprod_row['Quantity_XL'];

                            // Display quantity sizes per product inside the modal
                            echo "<div class='quantity-per-size'>";
                            echo "<label>Quantity per Size:</label>";
                            echo "<ul class='list-unstyled'>";
                            if ($quantity_small == 0) {
                                echo "<li>Small: Out of Stock</li>";
                            } else {
                                echo "<li>Small: $quantity_small</li>";
                            }
                            if ($quantity_medium == 0) {
                                echo "<li>Medium: Out of Stock</li>";
                            } else {
                                echo "<li>Medium: $quantity_medium</li>";
                            }
                            if ($quantity_large == 0) {
                                echo "<li>Large: Out of Stock</li>";
                            } else {
                                echo "<li>Large: $quantity_large</li>";
                            }
                            if ($quantity_xl == 0) {
                                echo "<li>XL: Out of Stock</li>";
                            } else {
                                echo "<li>XL: $quantity_xl</li>";
                            }
                            echo "</ul>";
                            echo "</div>";

                            echo "<input type='hidden' name='product_id' value='$product_id'>";
                            echo "<div class='buttons'>";
                            echo "<button type='submit' class='save-changes-btn'>Save Changes</button>";
                            echo "<button type='button' class='remove-btn' data-product-id='$product_id' data-dismiss='modal'>Remove</button>";   
                         
   
                            echo "</div>";
                            echo "</form>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No items in the cart</p>";
                    }

                    // Display total price for all items in the cart
                    echo "<div class='cart-total-price'><p>Total Price for all items: $total_price PHP</p></div>";
                } else {
                    // User is not logged in or email is not verified
                    echo "<p>Please log in to view your cart</p>";
                }
                ?>
                <button class="submit-btn" onclick="proceedToPayment()">Proceed to Payment</button>
            </div>
        </div>
    </div>
</body>
</html>
<script>
function proceedToPayment() {
    // Redirect to payment.php
    window.location.href = 'Payment.php';
}

$(document).ready(function(){
    // Add click event listener to remove buttons
    $(".remove-btn").click(function(){
        var product_id = $(this).data('product-id');
        // Send AJAX request to remove_cart.php
        $.ajax({
            url: 'remove_cart.php',
            type: 'POST',
            data: { product_id: product_id },
            success: function(response){
                // Reload the page after successful removal
                location.reload();
            },
            error: function(xhr, status, error){
                // Handle errors
                console.error(error);
            }
        });
    });
});
// Function to update cart notification badge
function updateCartNotification() {
            $.ajax({
                url: 'fetch_cart_count.php',
                type: 'GET',
                success: function(response) {
                    var cartCount = JSON.parse(response);
                    $('#cart-notification').text(cartCount);
                },
                error: function() {
                    console.log('Error fetching cart count');
                }
            });
        }

        // Call updateCartNotification() when the page is loaded
        updateCartNotification();

</script>
