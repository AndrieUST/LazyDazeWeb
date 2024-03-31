<?php
// include('connect.php');

// // Function to get the dynamic path for the uploads folder
// function getUploadsPath() {
//     return './uploads/';
// }

// // Check if product_id is provided in the URL
// if(isset($_GET['product_id'])) {
//     // Retrieve the product details based on the product_id
//     $product_id = $_GET['product_id'];
//     $sql = "SELECT * FROM manageprod WHERE ProductID = '$product_id'";
//     $result = mysqli_query($conn, $sql);

//     if(mysqli_num_rows($result) > 0) {
//         // Fetch product details
//         $row = mysqli_fetch_assoc($result);
//         $Product_Name = $row['Product_Name'];
//         $Description = $row['Description'];
//         $Quantity = $row['Quantity'];
//         $Price = $row['Price'];
//         $img = $row['img'];
//     } else {
//         echo "Product not found.";
//         exit();
//     }
// } else {
//     echo "Product ID is missing.";
//     exit();
// }

// // Handle form submission
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Retrieve updated product details from the form
//     $new_Product_Name = isset($_POST['Prod-name']) ? mysqli_real_escape_string($conn, $_POST['Prod-name']) : '';
//     $new_Description = isset($_POST['Description']) ? mysqli_real_escape_string($conn, $_POST['Description']) : '';
//     $new_Quantity = isset($_POST['Quantity']) ? mysqli_real_escape_string($conn, $_POST['Quantity']) : '';
//     $new_Price = isset($_POST['Price']) ? mysqli_real_escape_string($conn, $_POST['Price']) : '';

//     // Check if a new image is uploaded
//     if(isset($_FILES['img']['name']) && !empty($_FILES['img']['name'])) {
//         // Image upload
//         $fileTmpPath = $_FILES['img']['tmp_name'];
//         $fileName = $_FILES['img']['name'];
//         $fileSize = $_FILES['img']['size'];
//         $fileType = $_FILES['img']['type'];
//         $fileNameCmps = explode(".", $fileName);
//         $fileExtension = strtolower(end($fileNameCmps));

//         // Allowed file types
//         $allowedExtensions = array('jpg', 'jpeg', 'png');

//         if (in_array($fileExtension, $allowedExtensions)) {
//             // Set the target path dynamically
//             $uploadFileDir = getUploadsPath();
//             $dest_path = $uploadFileDir . $fileName;

//             // Move the uploaded file to the destination path
//             if(move_uploaded_file($fileTmpPath, $dest_path)) {
//                 $img = $fileName; // Update the image name
//             } else {
//                 echo "Error uploading image.";
//             }
//         } else {
//             echo "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
//         }
//     }

//     // Update the product details in the database
//     $update_sql = "UPDATE manageprod SET Product_Name = '$new_Product_Name', Description = '$new_Description', Quantity = '$new_Quantity', Price = '$new_Price', img = '$img' WHERE ProductID = '$product_id'";

//     if (mysqli_query($conn, $update_sql)) {
//         // Product details updated successfully
//         header("Location: prod.php"); // Redirect back to the product management page
//         exit();
//     } else {
//         // Error updating product details
//         echo "Error: " . mysqli_error($conn);
//     }
// }
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
    <link href="./editprod.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Website Icon -->
    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
  <!-- Background Image -->
<div class="bg">
  <!-- Navigation Bar -->
  <div class="topnav">
        <a href="homepage.php">
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
            <!-- Search -->
            <div class="nav-search">
            <form class="search-form" method="get">
                <button class="search-btn" type="submit"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
                <input type="text" class="search-input" name="search" value="" placeholder="Search Product">
            </form>
            </div>
            <div class="nav-line"></div>
        </div>
  </div>
  <h1>Update Products</h1>
  <div class="container">
    <form class="prod-form" id="prod" method="post" action="" enctype="multipart/form-data">
        <label>Product Name</label>
        <input type="text" class="name-input" name="Prod-name" value="" required>

        <label>Description</label>
        <textarea class="Description-input" name="Description" required></textarea>

        <label>Quantity</label>
        <input type="number" class="Quantity" name="Quantity" value="" required>

        <label>Price (PHP)</label>
        <input type="number" class="Price" name="Price" value="" required>

        <label for="update_image">Update Image:</label>
        <input type="file" id="update_image" name="img">

        <!-- Hidden input field to store the original image path -->
        <input type="hidden" name="original_img" value="">

        <button type="submit" class="submit-btn" name="submit" value="submit">Confirm</button>
    </form>
  </div>
</div>
</body>
</html>
