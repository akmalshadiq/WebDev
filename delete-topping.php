<?php
include("services/auth.php");
session_start();
include("services/connection2.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Delete the topping
    $sql = "DELETE FROM Toppings WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Reset auto-increment value
        $resetAutoIncrementQuery = "ALTER TABLE Toppings AUTO_INCREMENT = 1";
        $conn->query($resetAutoIncrementQuery);

        // Redirect after successful deletion
        header("Location: manage-items.php?topping-deleted=1");
    } else {
        // Error handling
        header("Location: manage-items.php?error=1");
    }
    $stmt->close();
    $conn->close();
}
?>
