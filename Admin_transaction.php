<?php
include('connect.php');

// Fetch unconfirmed orders from the manageorders table, sorted by Order Date in descending order
$order_query = "SELECT * FROM manageorders WHERE Confirmed = 0 ORDER BY Order_Date DESC";
$order_result = mysqli_query($conn, $order_query);

// Fetch confirmed orders from the manageorders table, sorted by Order Date in descending order
$confirmed_order_query = "SELECT * FROM manageorders WHERE Confirmed = 1 ORDER BY Order_Date DESC";
$confirmed_order_result = mysqli_query($conn, $confirmed_order_query);

// Fetch cancelled orders from the manageorders table, sorted by Order Date in descending order
$cancelled_order_query = "SELECT * FROM manageorders WHERE Confirmed = 2 ORDER BY Order_Date DESC";
$cancelled_order_result = mysqli_query($conn, $cancelled_order_query);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check out your orders!</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link href="./Admin_Transaction.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="icon" href="./LDAssets/lz logo.png">
</head>
<body>
    <div class="bg">
        <div class="topnav">
            <a href="admin_mainpage.php">
                <img align="left" class="ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
            </a>
            <div class="nav-h-layout">
                <div class="nav-icon">
                    <a href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket fa-xl"></i>
                    </a>
                </div>
                 <div class="nav-line"></div>
            </div>
        </div>
        <div class="container">
            <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#Orders">Orders <span id="newOrderNotification" class="badge">0</span></a></li>
            <li><a data-toggle="tab" href="#confirmedOrders">Confirmed Orders <span id="confirmedOrderNotification" class="badge">0</span></a></li>
<li><a data-toggle="tab" href="#cancelledOrders">Cancelled Orders <span id="cancelledOrderNotification" class="badge">0</span></a></li>
             
            </ul>
            

            <div class="tab-content">
                <div id="Orders" class="tab-pane fade in active">
                    <h2>Orders</h2>
                    
                    <form action="Confirm_Order.php" method="post">
                        <table class="table">
                            <thead>
                                <tr class="order-headers">
                                    <th>OrderRefID</th>
                                    <th>Customer Email</th>
                                    <th>Customer Name</th>
                                    <th> House Number</th>
                                    <th> Street</th>
                                    <th> Barangay</th>
                                    <th> City</th>
                                    <th> Postal</th>
                                    <th> Number</th>
                                    <th>Product Name</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Image</th>
                                    <th>Receipt Image</th>
                                    <th>Order Date</th>
                                    <th>Action</th> <!-- Header for action buttons -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while ($row = mysqli_fetch_assoc($order_result)) {
                                        // Add the class 'confirmed' if the order is confirmed
                                        $class = ($row['Confirmed'] == 1) ? 'confirmed' : '';
                                        
                                        echo "<tr class='orders $class'>"; 
                                        // Echo order details in each column
                                        echo "<td>" . $row['OrderRefID'] . "</td>";
                                        echo "<td>" . $row['Customer_Email'] . "</td>";
                                        echo "<td>" . $row['Customer_Name'] . "</td>";
                                        echo "<td>" . $row['Customer_HouseNumber'] . "</td>";
                                        echo "<td>" . $row['Customer_Street'] . "</td>";
                                        echo "<td>" . $row['Customer_Barangay'] . "</td>";
                                        echo "<td>" . $row['Customer_City'] . "</td>";
                                        echo "<td>" . $row['Customer_Postal'] . "</td>";
                                        echo "<td>" . $row['Customer_Number'] . "</td>";
                                        echo "<td>" . $row['Product_Name'] . "</td>";
                                       
                                        echo "<td>" . $row['Size'] . "</td>";
                                        echo "<td>" . $row['Quantity'] . "</td>";
                                        echo "<td>" . $row['TotalPrice'] . "</td>";
                                        echo "<td><img src='" . $row['img'] . "' alt='Product Image' width='135px'></td>";
                                        echo "<td><img src='" . $row['Receipt_img'] . "' width='100' onclick='showLargerImage(this.src)' style='cursor:pointer'></td>"; 
                                        echo "<td>" . $row['Order_Date'] . "</td>";
                                        echo "<td>";

                                        
                                           
                                            echo "<form action='Confirm_Order.php' method='post' onsubmit='return confirmOrder()'>";
                                            echo "<button type='submit' name='confirm' class='confirm-btn' value='" . $row['OrderRefID'] . "'>Confirm</button>";
                                            echo "</form>";
                                            echo "<form action='Deny_Order.php' method='post' onsubmit='return confirmDeny()'>";
                                            echo "<input type='hidden' name='reason' id='reason'>";
                                            echo "<button type='submit' class='deny-btn' name='deny' value='" . $row['OrderRefID'] . "'>Cancel</button>";
                                            echo "</form>";;
                                        
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <!-- Confirmed Orders Tab Content -->
                <div id="confirmedOrders" class="tab-pane fade">
    <h2>Confirmed Orders</h2>
    <table class="table">
        <thead>
            <tr class="order-headers">
                <th>OrderRefID</th>
                <th>Customer Email</th>
                <th>Customer Name</th>
                <th> House Number</th>
                <th> Street</th>
                <th> Barangay</th>
                <th> City</th>
                <th> Postal</th>
                <th> Number</th>
                <th>Product Name</th>
                
                <th>Size</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Image</th>
                <th>Receipt Image</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Date Completed</th>
                <th>Action</th> <!-- Header for action buttons -->
            </tr>
        </thead>
        <tbody>
            <?php
           // Check if there are confirmed orders
           if ($confirmed_order_result) {
               while ($row = mysqli_fetch_assoc($confirmed_order_result)) {
                $isCompleted = !empty($row['Date_Completed']);
                echo "<tr>"; 
                echo "<td>" . $row['OrderRefID'] . "</td>";
                echo "<td>" . $row['Customer_Email'] . "</td>";
                echo "<td>" . $row['Customer_Name'] . "</td>";
                echo "<td>" . $row['Customer_HouseNumber'] . "</td>";
                echo "<td>" . $row['Customer_Street'] . "</td>";
                echo "<td>" . $row['Customer_Barangay'] . "</td>";
                echo "<td>" . $row['Customer_City'] . "</td>";
                echo "<td>" . $row['Customer_Postal'] . "</td>";
                echo "<td>" . $row['Customer_Number'] . "</td>";
                echo "<td>" . $row['Product_Name'] . "</td>";
                
                echo "<td>" . $row['Size'] . "</td>";
                echo "<td>" . $row['Quantity'] . "</td>";
                echo "<td>" . $row['TotalPrice'] . "</td>";
                echo "<td><img src='" . $row['img'] . "' alt='Product Image' width='135px'></td>";
                echo "<td><img src='" . $row['Receipt_img'] . "' width='100' onclick='showLargerImage(this.src)' style='cursor:pointer'></td>"; 
                echo "<td>" . $row['Status'] . "</td>";
                echo "<td>" . $row['Order_Date'] . "</td>";
                echo "<td>" . $row['Date_Completed'] . "</td>";
                echo "<td>";
                if ($isCompleted) {
                    echo "Order Completed";
                } else {
                    echo "<form action='Deliver.php' method='post'>";
                    echo "<button type='submit' class='deliver-btn' name='deliver' value='" . $row['OrderRefID'] . "'>Deliver</button>";
                    echo "</form>";
                    echo "<form action='Received.php' method='post'>";
                    echo '<button type="submit" class="received-btn" name="received" value="' . $row['OrderRefID'] . '" onclick="return confirmReceive();">Received</button>';
                    echo "</form>";
                }
                echo "</td>";
                echo "</tr>";
            } } else {
                echo "<tr><td colspan='16'>No confirmed orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
                <!-- Cancelled Orders Tab Content -->
                <div id="cancelledOrders" class="tab-pane fade">
    <h2>Cancelled Orders</h2>
    
    <table class="table">
        <thead>
            <tr class="order-headers">
                <th>OrderRefID</th>
                <th>Customer Email</th>
                <th>Customer Name</th>
                <th> House Number</th>
                <th> Street</th>
                <th> Barangay</th>
                <th> City</th>
                <th> Postal</th>
                <th> Number</th>
                <th>Product Name</th>
                
                <th>Size</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Image</th>
                <th>Receipt Image</th>
                <th>Status</th>
                <th>Order Date</th>
                <th>Date Completed</th>  <!-- Added Status column -->
                <th>Action</th> <!-- Header for action buttons -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are cancelled orders
            if ($cancelled_order_result) {
                while ($row = mysqli_fetch_assoc($cancelled_order_result)) {
                    // Echo order details in each row
                    $isCompleted = !empty($row['Date_Completed']);
                    echo "<tr>"; 
                    echo "<td>" . $row['OrderRefID'] . "</td>";
                    echo "<td>" . $row['Customer_Email'] . "</td>";
                    echo "<td>" . $row['Customer_Name'] . "</td>";
                    echo "<td>" . $row['Customer_HouseNumber'] . "</td>";
                    echo "<td>" . $row['Customer_Street'] . "</td>";
                    echo "<td>" . $row['Customer_Barangay'] . "</td>";
                    echo "<td>" . $row['Customer_City'] . "</td>";
                    echo "<td>" . $row['Customer_Postal'] . "</td>";
                    echo "<td>" . $row['Customer_Number'] . "</td>";
                    echo "<td>" . $row['Product_Name'] . "</td>";
                   
                    echo "<td>" . $row['Size'] . "</td>";
                    echo "<td>" . $row['Quantity'] . "</td>";
                    echo "<td>" . $row['TotalPrice'] . "</td>";
                   
                    echo "<td><img src='" . $row['img'] . "' alt='Product Image' width='135px'></td>";
                    echo "<td><img src='" . $row['Receipt_img'] . "' width='100' onclick='showLargerImage(this.src)' style='cursor:pointer'></td>"; 
                    echo "<td>" . $row['Status'] . "</td>"; // Display status
                    echo "<td>" . $row['Order_Date'] . "</td>";
                    echo "<td>" . $row['Date_Completed'] . "</td>";
                    echo "<td>";
                    if ($isCompleted) {
                        echo "Refund Completed";
                    } else {
                        echo "<form action='Refund_Order.php' method='post'>";
                        echo "<button type='submit' class='refund-btn' name='Refund' value='" . $row['OrderRefID'] . "'>Refund</button>";
                        echo "</form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='17'>No cancelled orders found.</td></tr>";
            }
            
            ?>
            
        </tbody>
  
    </table>
 
</div>

            </div>
        </div>
    </div>
    <script>
        function showLargerImage(imageSrc) {
            var modal = document.createElement('div');
            modal.classList.add('modal');
            modal.style.display = 'block';
            modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            modal.style.position = 'fixed';
            modal.style.zIndex = '999';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100%';
            modal.style.height = '100%';
            modal.style.overflow = 'auto';
            modal.onclick = function() { modal.style.display = 'none'; };

            var modalContent = document.createElement('div');
            modalContent.classList.add('modal-content');
            modalContent.style.margin = 'auto';
            modalContent.style.display = 'block';
            modalContent.style.width = '80%';
            modalContent.style.maxWidth = '700px';
            modalContent.style.position = 'relative';
            modal.appendChild(modalContent);

            var img = document.createElement('img');
            img.src = imageSrc;
            img.style.width = '100%';
            img.style.height = '75%';
            img.style.cursor = 'pointer';
            img.onclick = function(event) { event.stopPropagation(); };
            modalContent.appendChild(img);

            document.body.appendChild(modal);
        }

        // Add click event listener to all confirm buttons
        function confirmOrder() {
            // Your confirmation logic here
            return true;
        }

        // Function to prompt admin for reason when cancelling order
        function confirmDeny() {
            var reason = prompt("Please enter the reason for cancelling the order:");
            if (reason != null && reason != "") {
                // Set the value of the hidden input field to the reason provided
                document.getElementById("reason").value = reason;
                return true; // Submit the form
            }
            return false; // Cancel submission if admin cancels the prompt or provides no reason
        }
        $('.deliver-btn').click(function() {
    // Prompt admin for a message
    var message = prompt("Enter a message for the user:");

    // Check if the admin provided a message
    if (message !== null) {
        // If a message is provided, submit the form with the orderRefID and message
        $(this).closest('form').append('<input type="hidden" name="message" value="' + message + '">');
        return true;
    }
    // If the admin cancels the prompt, prevent form submission
    return false;
});
// Add click event listener to all refund buttons
$('.refund-btn').click(function() {
    // Prompt admin for a message
    var message = prompt("Enter a message for the user:");

    // Check if the admin provided a message
    if (message !== null) {
        // If a message is provided, submit the form with the orderRefID and message
        $(this).closest('form').append('<input type="hidden" name="message" value="' + message + '">');
        return true;
    }
    // If the admin cancels the prompt, prevent form submission
    return false;
});
 // Function to confirm receiving the order
 function confirmReceive() {
    // Prompt the admin with the confirmation message
    var confirmation = confirm("Are you sure that this order has been received by the customer?");
    // If admin confirms, return true to proceed with the form submission
    // Else, return false to cancel the submission
    return confirmation;
}
$(document).ready(function() {
            // Function to check for new orders periodically
            function checkForNewOrders() {
                $.ajax({
                    url: 'check_for_new_orders.php', // Path to a PHP script to check for new orders
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.newOrders > 0) {
                            // Update the notification count and display it
                            $('#newOrderNotification').text(response.newOrders).show();
                        } else {
                            // Hide the notification if no new orders
                            $('#newOrderNotification').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error checking for new orders:', error);
                    }
                });
            }

            // Call the function initially
            checkForNewOrders();

            // Call the function every 60 seconds to check for new orders
            setInterval(checkForNewOrders, 10000); // 10 seconds
        });
        $(document).ready(function() {
    // Function to check for new orders periodically
    function checkForNewOrders() {
        $.ajax({
            url: 'check_new_orders.php', // Path to a PHP script to check for new orders
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Update the notification count for confirmed orders
                $('#confirmedOrderNotification').text(response.confirmedCount);

                // Update the notification count for cancelled orders
                $('#cancelledOrderNotification').text(response.cancelledCount);
            },
            error: function(xhr, status, error) {
                console.error('Error checking for new orders:', error);
            }
        });
    }

    // Call the function initially
    checkForNewOrders();

    // Call the function every 5 seconds to check for new orders
    setInterval(checkForNewOrders, 5000); // 5 seconds
});


    </script>
</body>
</html>