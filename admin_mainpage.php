<?php
include('connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to LazyDaze!</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Homepage CSS -->
    <link href="./admin_mainpage.css" rel="stylesheet" type="text/css"/>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- jQuery UI Datepicker -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
        <a href="">
          <img align = "left" class = "ld-icon" src="LDAssets/lz logo.png" alt="LazyDaze">
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
        </div>
  </div>
  <div class="intro">
  <h2>Welcome!</h2>
  <h1>Have any changes?</h1>
  <a href="prod.php">
  <button class = "main-btn" name = "add-products" value = "Add-Products">Products</button>
</a>
<a href="inventory.php">
  <button class = "main-btn" name = "Inventory" value = "Inventory">Inventory</button>
</a>
<a href="Admin_transaction.php">
  <button class = "main-btn" name = "Transaction" value = "Transaction">Transactions</button>
</a>
<a href="Admin_payment.php">
  <button class = "main-btn" name = "Payment" value = "Payment">Payment</button>
</a>
<a href="#" data-toggle="modal" data-target="#reportSalesModal"> <!-- Add a data-toggle and data-target attribute -->
  <button class = "main-btn" name = "Sales" value = "Sales">Report Sales</button>
</a>
<!-- Report Sales Modal -->
<div id="reportSalesModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Date Range</h4>
            </div>
            <div class="modal-body">
                <label for="start_datepicker">Start Date:</label>
                <input type="text" id="start_datepicker" name="start_date">
                <label for="end_datepicker">End Date:</label>
                <input type="text" id="end_datepicker" name="end_date">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>
<img class="biglogo" src="LDAssets/biglogo.png" alt="Big Lazy Logo"/>
</div>

<<script>
$(function() {
    // Initialize Datepickers for start and end dates
    $("#start_datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(dateText) {
            // When a date is selected, update the minDate of end_datepicker
            $("#end_datepicker").datepicker("option", "minDate", dateText);
        }
    });

    $("#end_datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(dateText) {
            // When a date is selected, update the maxDate of start_datepicker
            $("#start_datepicker").datepicker("option", "maxDate", dateText);
            // Construct the URL with selected dates and redirect to Report_sales.php
            var startDate = $("#start_datepicker").val();
            var endDate = $("#end_datepicker").val();
            window.location.href = "Report_sales.php?date=" + startDate + "&end_date=" + endDate;
        }
    });
});
</script>

</body>
</html>
