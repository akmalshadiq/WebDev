<?php
// Database connection
$servername = "sql200.infinityfree.com";
$username = "if0_37998389";
$password = "7DN2oOJqZn4oAk5";
$dbname = "if0_37998389_MemsKoloMee";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = floatval($_POST['price']);
    $status = $conn->real_escape_string($_POST['status']);

    // Update the record in the database
    $sql = "UPDATE Noodles SET name='$name', description='$description', price=$price, status='$status' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the menu page with a success message
        header("Location: menumanagement.php?update=success");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
