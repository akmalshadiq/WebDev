<?php include ("adminnavbar.php") ;?>

<?php
// Database connection
$servername = "sql200.infinityfree.com";
$username = "if0_37998389"; 
$password = "7DN2oOJqZn4oAk5"; 
$dbname = "if0_37998389_MemsKoloMee";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $noodleType = $_POST['noodleType'];
    $noodleName = $_POST['noodleName'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $imageDir = 'images/'; 
        $imagePath = $imageDir . $imageName;

        // Move uploaded image to the server folder
        if (move_uploaded_file($imageTmpName, $imagePath)) {
            // Insert data into the database
            $sql = "INSERT INTO Noodles (type, name, description, price, image_url)
                    VALUES ('$noodleType', '$noodleName', '$description', '$price', '$imageName')";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success'>New menu item added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Failed to upload image.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Please upload a valid image.</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Item</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Add New Menu Item</h1>
        <form id="addMenuItemForm" class="shadow p-4 bg-light rounded" method="POST" enctype="multipart/form-data">
            <!-- Noodle Type -->
            <div class="mb-3">
                <label for="noodleType" class="form-label">Noodle Type</label>
                <select class="form-select" id="noodleType" name="noodleType" required>
                    <option value="">Select Noodle Type</option>
                    <option value="Mee Kolok">Mee Kolok</option>
                    <option value="Mee Pok">Mee Pok</option>
                    <option value="Fried Noodles">Fried Noodles</option>
                </select>
            </div>

            <!-- Noodle Name -->
            <div class="mb-3">
                <label for="noodleName" class="form-label">Noodle Name</label>
                <input type="text" class="form-control" id="noodleName" name="noodleName" placeholder="Enter noodle name" required>
            </div>
            <!-- Description-->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter description" required>
            </div>
            <!-- Price -->
            <div class="mb-3">
                <label for="price" class="form-label">Price (RM)</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter price" required>
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Add Item</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
