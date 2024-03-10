<?php
include('connect.php');

if(isset($_POST['submit'])) {
    // Escape user inputs for security
    $Product_Name = isset($_POST['Prod-name']) ? mysqli_real_escape_string($conn, $_POST['Prod-name']) : '';
    $Description = isset($_POST['Description']) ? mysqli_real_escape_string($conn, $_POST['Description']) : '';
    $Quantity = isset($_POST['Quantity']) ? mysqli_real_escape_string($conn, $_POST['Quantity']) : '';
    $Price = isset($_POST['Price']) ? mysqli_real_escape_string($conn, $_POST['Price']) : '';

    // File upload handling
    if(isset($_FILES["img"])) {
        $target_file = basename($_FILES["img"]["name"]);

        // Move uploaded file to the desired directory
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
            // Insert query with image path
            $sql = "INSERT INTO manageprod (Product_Name, Description, Quantity, Price, img) VALUES ('$Product_Name', '$Description', '$Quantity', '$Price', '$target_file')";

            if(mysqli_query($conn, $sql)){
                // Redirect to prod.php if records added successfully
                header("Location: prod.php");
                exit();
            } else{
                echo "ERROR: Could not able to execute query. Please try again later."; // A more user-friendly error message
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Product</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./addprod.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Website Icon -->
    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
  <!-- Background Image -->
<div class = "bg">
  <!-- Navigation Bar -->
  <header class="topnav">
        <a href="homepage.php">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
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
            <!-- Reviews Icon -->
            <div class="nav-icon">
                <a href="reviews.php">
                    <i class="fa-solid fa-star fa-xl"></i>
                </a>
            </div>
            <div class="nav-line"></div>
            <!-- Search -->
            <div class="nav-search">
            <form class="search-form" method="get">
                <button class="search-btn" type="submit"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
                <input type="text" class="search-input" name="search" value="" placeholder="Search Product">
            </form>
            </div>
            <div class="nav-line"></div>
        </div>
  </header>
  <h1>Add Product</h1>
      <div class="container">
    <form class="prod-form" id="prod" method="post" action="" enctype="multipart/form-data">
        <label>Product Name</label>
        <input type="text" class="name-input" name="Prod-name" required>

        <label>Description</label>
        <textarea class="Description-input" name="Description" required></textarea>

        <label>Quantity</label>
        <input type="number" class="Quantity" name="Quantity" required>

        <label>Price (PHP)</label>
        <input type="number" class="Price" name="Price" required>

        <label for="file-upload">Choose File:</label>
        <input type="file" id="file-upload" name="img">

        <button type="submit" class="submit-btn" name="submit" value="submit">Confirm</button>
    </form>
</div>
</div>
</body>
</html>
