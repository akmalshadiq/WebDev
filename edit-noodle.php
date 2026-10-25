<?php
include("services/auth.php");
session_start();
include("services/connection2.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $image_url = $_POST['image_url'];

    $updateQuery = "UPDATE Noodles SET type=?, name=?, description=?, price=?, status=?, image_url=? WHERE id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('ssssssi', $type, $name, $description, $price, $status, $image_url, $id);

    if ($stmt->execute()) {
        header("Location: manage-items.php?noodle-edited=1");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
