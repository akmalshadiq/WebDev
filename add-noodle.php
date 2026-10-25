<?php
include("services/auth.php");
session_start();
include("services/connection2.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type = $_POST['type'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $image_url = $_POST['image_url'];

    $sql = "INSERT INTO Noodles (type, name, description, price, status, image_url, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssssds", $type, $name, $description, $price, $status, $image_url);

    if ($stmt->execute()) {
        header("Location: manage-items.php?noodle-added=1");
    } else {
        header("Location: manage-items.php?error=1");
    }

    $stmt->close();
    $conn->close();
}
