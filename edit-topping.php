<?php
include("services/auth.php");
session_start();
include("services/connection2.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    $updateQuery = "UPDATE Toppings SET name=?, price=?, image_url=? WHERE id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('sdsi', $name, $price, $image_url, $id);

    if ($stmt->execute()) {
        header("Location: manage-items.php?topping-edited=1");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
