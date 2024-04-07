<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteProduct'])) {
        $productId = $_POST['productId'];
        $query = "DELETE FROM managecart WHERE id = $productId";
        $result = mysqli_query($conn, $query);
        if ($result) {
            header("Location: cart.php");
            exit();
        } else {
            echo "Error deleting product: " . mysqli_error($conn);
        }
    }
} 

$customer_email = $_SESSION['registered_email'];
$totalPrice = 0; // Initialize total price here

// Fetch products details including the maximum quantity available for each item
$query = "SELECT mc.id, mc.Customer_Email, mc.Quantity, mc.Price, mc.Product_Name, mc.img, mc.Size,
                mp.Quantity_Small, mp.Quantity_Medium, mp.Quantity_Large, mp.Quantity_XL
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
                                    <input type="hidden" name="productId" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="deleteProduct" class="rm-btn">
                                        <i class="fa-solid fa-xmark fa-2xl"></i>
                                    </button>
                                    <img src="<?php echo $row['img']; ?>" alt="<?php echo $row['Product_Name']; ?>" class="item-image" />
                                    <div class="v-layout v-flex-block">
                                        <h3><?php echo htmlspecialchars($row['Product_Name']); ?></h3>
                                        <select class="select-field" id="size-field" name="s-field">
                                            <option value="Small" <?php if ($row['Size'] == "Small") echo "selected"; ?>>S</option>
                                            <option value="Medium" <?php if ($row['Size'] == "Medium") echo "selected"; ?>>M</option>
                                            <option value="Large" <?php if ($row['Size'] == "Large") echo "selected"; ?>>L</option>
                                            <option value="XL" <?php if ($row['Size'] == "Fourth") echo "XL"; ?>>XL</option>
                                        </select>
                                        <h4><?php echo $row['Price']; ?> PHP</h4>
                                    </div>
                                    <div class="v-layout-2 v-flex-block-2">
                                        <h4>Quantity</h4>
                                        <div class="qty" data-max-quantity="<?php echo $maxQuantity; ?>">
                                           <span class="minus"><i class="fa-solid fa-minus fa-xl"></i></span>
                                           <span class="num"><?php echo min($row['Quantity'], $row['Quantity']); ?></span>
                                           <span class="plus"><i class="fa-solid fa-plus fa-xl"></i></span>
                                          </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <section class="total-container">
                        <div class="h-layout-2 h-flex-block-2">
                            <h1>TOTAL</h1>
                            <h2>: <?php echo $totalPrice; ?> PHP</h2>
                        </div>
                        <input type="submit" class="submit-btn" value="Proceed to payment."/>
                    </section>
                </section>
            </form>
        </section>
    </div>
</body>
</html>

<script>
    $(document).ready(function() {
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

        // Function to handle quantity changes
        $(document).on("click", ".qty .plus, .qty .minus", function() {
    // Find the quantity element within the same item
    var quantityField = $(this).siblings(".num");

    // Get the current quantity as an integer
    var quantity = parseInt(quantityField.text());

    // Get the maximum quantity available for this item
    var maxQuantity = parseInt(quantityField.parent().attr('data-max-quantity'));

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
    quantityField.text(quantity);

    // Update the total price based on the new quantity
    updateTotalPrice();
});
    });
</script>
