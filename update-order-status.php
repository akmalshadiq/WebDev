<?php
include("services/auth.php");
session_start();
include("services/connection2.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    $updateQuery = "UPDATE Order_items SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('si', $newStatus, $orderId);

    if ($stmt->execute()) {
        header("Location: orders.php?success=Order marked as ready");
        exit;
    } else {
        header("Location: orders.php?error=Failed to update order status");
        exit;
    }
}
?>
