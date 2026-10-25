<?php
// Database connection
$servername = "sql200.infinityfree.com";
$username = "if0_37998389";
$password = "7DN2oOJqZn4oAk5";
$dbname = "if0_37998389_MemsKoloMee";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the POST request contains an 'id' parameter
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); 

    // Prepare and execute the DELETE query
    $stmt = $conn->prepare("DELETE FROM Noodles WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the menu page with a success message
        header("Location: menumanagement.php?message=Item deleted successfully");
        exit;
    } else {
        // Redirect back with an error message
        header("Location: menumanagement.php?message=Failed to delete item");
        exit;
    }

    $stmt->close();
} else {
    // Redirect back if no ID is provided
    header("Location: menumanagement.php?message=Invalid request");
    exit;
}

$conn->close();
?>
