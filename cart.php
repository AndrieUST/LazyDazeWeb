<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteProduct'])) {
    // Get product ID from POST
    $productId = $_POST['productId'];

    // Delete the product from the database
    $query = "DELETE FROM managecart WHERE id = $productId"; // managecart/ID NOTE: $id to $productId
    $result = mysqli_query($conn, $query);

    if ($result) {
        // To Check if na delete
        echo "Product deleted successfully.";
        // Reload the page or any other action you want to perform after deletion
        header("Location: cart.php");
        exit(); // Ensure that no further code execution occurs after redirection
    } else {
        // Error occurred while deleting the product
        echo "Error deleting product: " . mysqli_error($conn);
    }
}

// Fetch cart items from the database
$query = "SELECT * FROM managecart";
$result = mysqli_query($conn, $query);
$totalPrice = 0;
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Lazy Daze!</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./cart.css" rel="stylesheet" type="text/css"/>
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
        <a href="homepage.php">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
        </a>
        <!-- Icons -->
        <div class="nav-h-layout">
            <!-- Logout Icon -->
            <div class="nav-icon">
                <a href="logout.php">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
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
        </div>
        </div>
  <!-- Cart Header -->
  <section class="section-2"></section>
  <!-- Cart -->
  <section class = "container">
  <form id="cart-form" name="cart-form" method="get">
        <div class="grid">
        <div class="row">
        <?php
// Loop through each product and display its product of user
while ($row = mysqli_fetch_assoc($result)) {?>
<?php
            // Calculate total price for each product
            $productPrice = $row['Price'];
            // Add the product price to the total price
            $totalPrice += $productPrice;
            ?>
    <!-- Cart Row -->
    <div class="h-layout h-flex-block">
    <form method="post" action="cart.php">
    <input type="hidden" name="productId" value="<?php echo $row['id']; ?>">
    <button type="submit" name="deleteProduct" class="rm-btn">
        <i class="fa-solid fa-xmark fa-2xl"></i>
    </button>
</form>
        <img src="<?php echo $row['img']; ?>" alt="<?php echo $row['Product_Name']; ?>" class="item-image" />
        <!-- Product Details Column -->
        <div class="v-layout v-flex-block">
            <h3><?php echo htmlspecialchars($row['Product_Name']); ?></h3>
            
            <!-- Size Dropdown and retrieved back from the database -->
            <select class="select-field" id="size-field" name="s-field">
                <option value="First" <?php if ($row['Size'] == "First") echo "selected"; ?>>S</option>
                <option value="Second" <?php if ($row['Size'] == "Second") echo "selected"; ?>>M</option>
                <option value="Third" <?php if ($row['Size'] == "Third") echo "selected"; ?>>L</option>
            </select>
            <h4><?php echo $row['Price']; ?> PHP</h4>
        </div>
        <!-- Quantity Column -->
        <div class = "v-layout-2 v-flex-block-2">
            <h4>Quantity</h4>
            <div class="qty">
                <span class="minus"><i class="fa-solid fa-minus fa-xl"></i></span>
                <span class="num"><?php echo $row['Quantity']; ?></span>
                <span class="plus"><i class="fa-solid fa-plus fa-xl"></i></span>
            </div>
        </div>
    </div>
<?php
}
?>
            </div>
        </div>
        <section class = "total-container">
        <!-- Total Row -->
        <div class = "h-layout-2 h-flex-block-2">
            <h1>TOTAL</h1>
            
            <h2>: <?php echo $totalPrice; ?> PHP</h2>
        </div>
        <input type="submit" class="submit-btn" value="Proceed to payment."/>
        </section>
    </form>
</section>
</div>	
<script>
    const plusButtons = document.querySelectorAll(".plus");
    const minusButtons = document.querySelectorAll(".minus");
    const numFields = document.querySelectorAll(".num");

    plusButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
            let num = parseInt(numFields[index].innerText);
            num++;
            numFields[index].innerText = num < 10 ? "0" + num : num;
        });
    });

    minusButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
            let num = parseInt(numFields[index].innerText);
            if (num > 1) {
                num--;
                numFields[index].innerText = num < 10 ? "0" + num : num;
            }
        });
    });
</script>
</body>
</html>