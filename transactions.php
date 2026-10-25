<?php
include("services/auth.php");
session_start();
include("services/connection2.php");

//Fetch orders and their associated payments
$transactionQuery = "
    SELECT o.id AS order_id, o.user_id, o.status AS order_status, o.total_amount, o.created_at AS order_date, 
           p.payment_method, p.payment_status, p.payment_date, p.payment_reference
    FROM Orders o
    LEFT JOIN Payments p ON o.id = p.order_id
    ORDER BY o.created_at DESC
";
$transactionResult = $conn->query($transactionQuery);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0EBC17A1;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Transaction Report</a>
            <img src="images/MemLogo.png" alt="Logo" class="img-fluid" style="width: 100px; height: auto ;">
        </div>
    </nav>
	<!-- Back Button -->
	<a href="adminpage.php" class="btn" style="background-color: #0EBC17A1; color: white ; position: absolute; top: 100px; left: 300px;">Back</a>
    <div class="container my-5">
        <h2 class="text-center mb-4">Transaction Report</h2>

        <!-- Transaction Table -->
        <div class="mb-4">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Order Status</th>
                        <th>Total Amount (RM)</th>
                        <th>Order Date</th>
                        <th>Payment Date</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any results and display them
                    if ($transactionResult->num_rows > 0) {
                        while ($row = $transactionResult->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['order_id']}</td>
                                    <td>{$row['user_id']}</td>
                                    <td>{$row['order_status']}</td>
                                    <td>{$row['total_amount']}</td>
                                    <td>{$row['order_date']}</td>
                                    <td>{$row['payment_date']}</td>
                                    <td>{$row['payment_status']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No transactions found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Download Report Button -->
        <div class="text-center">
            <a href="download-transaction-report.php" class="btn btn-success" target='_blank'>Download Transaction Report</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

