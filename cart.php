<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteProduct'])) {
        $productId = $_POST['productId'];
        
        // Ensure that the productId is properly sanitized to prevent SQL injection
        $productId = mysqli_real_escape_string($conn, $_POST['productId']);
        
        // Delete the product from the cart based on its unique ID
        $query = "DELETE FROM managecart WHERE id = $productId";
        $result = mysqli_query($conn, $query);
        
        if ($result) {
            // Product deleted successfully, redirect to the cart page
            header("Location: cart.php");
            exit();
        } else {
            // Error occurred while deleting the product
            echo "Error deleting product: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['updateProduct'])) {
        $productId = $_POST['productId'];
        $Quantity = $_POST['Quantity'];
        $size = $_POST['size'];

        // Ensure that the productId is properly sanitized to prevent SQL injection
        $productId = mysqli_real_escape_string($conn, $_POST['productId']);

        // Get the available quantity for the selected size
        $availableQuantity = $_POST["availableQuantity_$size"];

        // Ensure the new quantity does not exceed the available quantity
        if ($Quantity <= $availableQuantity && $Quantity > 0) { // Check if quantity is within bounds
            // Update the quantity if it's within the available quantity
            $updateQuery = "UPDATE managecart SET Quantity = $Quantity, Size = '$size' WHERE id = $productId";

            $updateResult = mysqli_query($conn, $updateQuery);
            if ($updateResult) {
                // Quantity updated successfully
                header("Location: payment.php");
                exit();
            } else {
                // Error updating quantity
                echo "Error updating product quantity: " . mysqli_error($conn);
            }
        } else {
            echo "Error: Invalid quantity or quantity exceeds available quantity for selected size.";
        }
    }
}

// Check if 'registered_email' is set in the $_SESSION array
if (isset($_SESSION['registered_email'])) {
    $customer_email = $_SESSION['registered_email'];
    $totalPrice = 0; // Initialize total price here
} else {
    // If 'registered_email' is not set in the $_SESSION array, redirect the user to the login page
    header("Location: login.php");
    exit(); // Ensure no further code execution after redirection
}

// Fetch products details including the available quantity for each item
$query = "SELECT mc.id, mc.Customer_Email, mc.Quantity, mc.Price, mc.Product_Name, mc.img, mc.Size,
                mp.Quantity_Small, mp.Quantity_Medium, mp.Quantity_Large, mp.Quantity_XL, mp.Price, mp.ProductID, mp.Description
          FROM managecart mc
          INNER JOIN manageprod mp ON mc.Product_Name = mp.Product_Name
          WHERE mc.Customer_Email = '$customer_email'";
$result = mysqli_query($conn, $query);

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
            <form method="post" action="cart.php">
                <section class="container">
                    <div class="grid">
                        <div class="row">
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {?>
                                <?php
                                $productPrice = $row['Price'];
                                $totalPrice += $productPrice;

                                // Determine the maximum quantity based on size
                                $maxQuantity = 0;
                                switch ($row['Size']) {
                                    case 'Small':
                                        $maxQuantity = $row['Quantity_Small'];
                                        break;
                                    case 'Medium':
                                        $maxQuantity = $row['Quantity_Medium'];
                                        break;
                                    case 'Large':
                                        $maxQuantity = $row['Quantity_Large'];
                                        break;
                                    case 'XL':
                                        $maxQuantity = $row['Quantity_XL'];
                                        break;
                                    default:
                                        $maxQuantity = $row['Quantity'];
                                        break;
                                }
                                ?>
                                <div class="h-layout h-flex-block">
    <form method="post" action="cart.php">
        <input type="hidden" name="deleteProduct" value="1">
        <input type="hidden" name="productId" value="<?php echo $row['id']; ?>">
        <button type="submit" class="rm-btn">
            <i class="fa-solid fa-xmark fa-2xl"></i>
        </button>
    </form>
                                    <img src="<?php echo $row['img']; ?>" alt="<?php echo $row['Product_Name']; ?>" class="item-image" />
                                    <div class="v-layout v-flex-block">
                                        <h3><?php echo htmlspecialchars($row['Product_Name']); ?></h3>
                                        <select class="select-field" name="size">
                                            <option value="Small" <?php if ($row['Size'] == "Small") echo "selected"; ?>>S</option>
                                            <option value="Medium" <?php if ($row['Size'] == "Medium") echo "selected"; ?>>M</option>
                                            <option value="Large" <?php if ($row['Size'] == "Large") echo "selected"; ?>>L</option>
                                            <option value="XL" <?php if ($row['Size'] == "XL") echo "selected"; ?>>XL</option>
                                        </select>
                                        <h4><?php echo $row['Price']; ?> PHP</h4>
                                    </div>
                                    <div class="v-layout-2 v-flex-block-2">
                                        <h4>Quantity</h4>
                                        <div class="qty" data-max-quantity="<?php echo $maxQuantity; ?>">
                                            <span class="minus"><i class="fa-solid fa-minus fa-xl"></i></span>
                                            <input type="number" class="num" name="Quantity" value="<?php echo min($row['Quantity'], $maxQuantity); ?>" max="<?php echo $maxQuantity; ?>">
                                            <span class="plus"><i class="fa-solid fa-plus fa-xl"></i></span>
                                        </div>
                                    </div>
                                    <!-- Hidden inputs for maximum quantity -->
                                    <input type="hidden" name="availableQuantity_Small" value="<?php echo $row['Quantity_Small']; ?>">
                                    <input type="hidden" name="availableQuantity_Medium" value="<?php echo $row['Quantity_Medium']; ?>">                                  
                                    <input type="hidden" name="availableQuantity_Large" value="<?php echo $row['Quantity_Large']; ?>">                                 
                                    <input type="hidden" name="availableQuantity_XL" value="<?php echo $row['Quantity_XL']; ?>">
                                  
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <section class="total-container">
                        <div class="h-layout-2 h-flex-block-2">
                            <h1>TOTAL</h1>
                            <h2>: <?php echo $totalPrice; ?> PHP</h2>
                        </div>
                        <input type="submit" class="submit-btn" name="updateProduct" value="Proceed to Payment">
                    </section>
                </section>
            </form>
        </section>
    </div>
</body>
</html>




<script>
    $(document).ready(function() {
        // Function to update the maximum quantity for a given size
        function updateMaxQuantity(size, maxQuantityElement) {
    $.ajax({
        url: 'fetch_max_quantity.php', // Path to fetch_max_quantity.php
        type: 'POST', // HTTP method
        data: { size: size }, // Data to send
        success: function(response) { // On success
            // Update the maximum quantity element with the retrieved value
            maxQuantityElement.attr('data-available-quantity', response);
            // Update quantity buttons availability
            updateQuantityButtons();
        },
        error: function() { // On error
            console.log('Error fetching maximum quantity for size ' + size);
        }
    });
}
        // Call updateMaxQuantity() when the page is loaded for each product
        $(".select-field").each(function() {
            var size = $(this).val();
            var maxQuantityElement = $(this).closest(".h-layout").find(".qty");
            updateMaxQuantity(size, maxQuantityElement);
        });

        // Function to handle quantity changes
        $(document).on("click", ".qty .plus, .qty .minus", function() {
            // Your existing code
        });

        // Function to reset quantity to 1 when size is changed
        $(".select-field").change(function() {
            var size = $(this).val();
            var maxQuantityElement = $(this).closest(".h-layout").find(".qty");
            updateMaxQuantity(size, maxQuantityElement);
        });

        // Initialize quantity buttons
        updateQuantityButtons();

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

        // Function to update total price based on quantity changes
        function updateTotalPrice() {
            var totalPrice = 0;

            // Loop through each item in the cart
            $(".qty").each(function() {
                // Get the quantity and price of the current item
                var quantity = parseInt($(this).find(".num").val());
                var price = parseFloat($(this).closest(".h-layout").find("h4").text());

                // Calculate the subtotal for the current item
                var subtotal = quantity * price;

                // Add the subtotal to the total price
                totalPrice += subtotal;

                // Log quantity and subtotal for debugging
                console.log("Quantity:", quantity);
                console.log("Subtotal:", subtotal);
            });

            // Update the total price displayed on the page
            $(".total-container h2").text(": " + totalPrice.toFixed(2) + " PHP");
        }

        // Call updateTotalPrice() when the page is loaded
        updateTotalPrice();

        // Function to update quantity buttons based on availability
        function updateQuantityButtons() {
            $(".qty").each(function() {
                // Get the current quantity and maximum quantity
                var quantity = parseInt($(this).find(".num").val());
                var maxQuantity = parseInt($(this).attr('data-max-quantity'));

                // Log quantity and maxQuantity for debugging
                console.log("Quantity:", quantity);
                console.log("Max Quantity:", maxQuantity);

                // Disable the plus button if maximum quantity is reached
                if (quantity >= maxQuantity) {
                    $(this).find(".plus").addClass("disabled");
                } else {
                    $(this).find(".plus").removeClass("disabled");
                }
            });
        }
        // Function to handle size change
$(".select-field").change(function() {
    var size = $(this).val();
    var maxQuantityElement = $(this).closest(".h-layout").find(".qty");
    updateMaxQuantity(size, maxQuantityElement);
});

        // Function to handle quantity changes
        $(document).on("click", ".qty .plus, .qty .minus", function() {
            // Find the quantity element within the same item
            var quantityField = $(this).closest(".qty").find(".num");

            // Get the current quantity as an integer
            var quantity = parseInt(quantityField.val());

            // Get the maximum quantity available for this item
            var maxQuantity = parseInt($(this).closest(".qty").attr('data-max-quantity'));

            // Log quantity and maxQuantity for debugging
            console.log("Quantity:", quantity);
            console.log("Max Quantity:", maxQuantity);

            // Determine if the button clicked was the plus or minus
            if ($(this).hasClass("plus")) {
                // Increment the quantity by 1 if it's less than the maximum quantity
                if (quantity < maxQuantity) {
                    quantity++;
                } else {
                    // Display an alert if the maximum quantity is reached
                    alert("Maximum quantity reached for this item.");
                    return; // Stop further execution
                }
            } else {
                // Ensure the quantity is not less than 1 before decrementing
                if (quantity > 1) {
                    quantity--;
                }
            }

            // Update the quantity text with the new value
            quantityField.val(quantity);

            // Update the total price based on the new quantity
            updateTotalPrice();

            // Update quantity buttons availability
            updateQuantityButtons();
        });

        function updateMaxQuantity(size, maxQuantityElement) {
    var availableQuantityInput = $('[name="availableQuantity_' + size + '"]');
    var availableQuantity = availableQuantityInput.val();
    maxQuantityElement.attr('data-available-quantity', availableQuantity);

    // Reset quantity if it exceeds the new maximum
    var quantityField = maxQuantityElement.find(".num");
    var quantity = parseInt(quantityField.val());
    if (quantity > availableQuantity) {
        quantityField.val(availableQuantity); // Update displayed quantity
        updateTotalPrice(); // Update total price
    }

    // Update quantity buttons availability
    updateQuantityButtons();
}
    });
</script>
