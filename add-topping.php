<?php
include("services/auth.php");
session_start();
include("services/connection2.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];

    $sql = "INSERT INTO Toppings (name, price, image_url) 
            VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $name, $price, $image_url);

    if ($stmt->execute()) {
        header("Location: manage-items.php?topping-added=1");
    } else {
        header("Location: manage-items.php?error=1");
    }

    $stmt->close();
    $conn->close();
}
?>
