<?php
include('connect.php');

// Fetch order details from the database
$order_query = "SELECT * FROM manageorders ORDER BY Order_Date DESC";
$order_result = mysqli_query($conn, $order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="./Payment.css" rel="stylesheet" type="text/css"/>
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
                    <a href="cart.php">
                        <i class="fa-solid fa-cart-shopping fa-xl"></i>
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
           <div class="row">
               <div class="col-md-12">
                   <h2>View Orders</h2>
                   <table class="table">
                       <thead>
                           <tr>
                               <th>Order ID</th>
                               <th>Customer Email</th>
                               <th>Product Name</th>
                               <th>Quantity</th>
                               <th>Total Price</th>
                               <th>Order</th>
                               <th>Status</th>
                               <th>Order Date</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php
                           // Loop through each order and display its details
                           while($row = mysqli_fetch_assoc($order_result)) {
                               echo "<tr>";
                               echo "<td>".$row['OrderRefID']."</td>";
                               echo "<td>".$row['Customer_Email']."</td>";
                               echo "<td>".$row['Product_Name']."</td>";
                               echo "<td>".$row['Quantity']."</td>";
                               echo "<td>".$row['TotalPrice']."</td>";
                               echo '<td><img src="' . $row['img'] . '" class="item-image" alt="Product Image"></td>';
                               echo "<td>".$row['Status']."</td>";
                               echo "<td>".$row['Order_Date']."</td>";
                               echo "</tr>";
                           }
                           ?>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>

</body>
</html>
