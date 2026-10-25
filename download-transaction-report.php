<?php
include("services/auth.php");
session_start();
include("services/connection2.php");

echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Transaction Report</title>";
echo "<style>";
echo "table { border-collapse: collapse; width: 100%; }";
echo "th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }";
echo "th { background-color: #f2f2f2; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<h1>Transaction Report</h1>";
echo "<table>";
echo "<thead>";
echo "<tr>";
echo "<th>Order ID</th>";
echo "<th>Customer Name</th>";
echo "<th>Order Status</th>";
echo "<th>Total Amount</th>";
echo "<th>Order Date</th>";
echo "<th>Payment Status</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

// Fetch data using the query
$transactionQuery = "
    SELECT o.id AS order_id, o.user_id, o.status AS order_status, o.total_amount, o.created_at AS order_date, 
           p.payment_method, p.payment_status, p.payment_date, p.payment_reference
    FROM Orders o
    LEFT JOIN Payments p ON o.id = p.order_id
    ORDER BY o.created_at DESC
";
$result = $conn->query($transactionQuery);

while ($row = $result->fetch_assoc()) {
    // Fetch user name
    $userQuery = "SELECT full_name FROM Users WHERE id = " . $row['user_id'];
    $userResult = $conn->query($userQuery);
    $user = $userResult->fetch_assoc();

    // Output row data
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
    echo "<td>" . htmlspecialchars($user['full_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['order_status']) . "</td>";
    echo "<td>" . number_format($row['total_amount'], 2) . "</td>";
    echo "<td>" . htmlspecialchars(date('Y-m-d H:i:s', strtotime($row['order_date']))) . "</td>";
    echo "<td>" . htmlspecialchars($row['payment_status']) . "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</body>";
echo "</html>";
?>
