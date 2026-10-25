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

// Fetch data from noodles table
$sql = "SELECT * FROM Noodles";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-button {
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }
        .status-available {
            background-color: #28a745;
        }
        .status-out {
            background-color: #dc3545;
        }
        .status-low {
            background-color: #ffc107;
            color: black;
        }
        .menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .menu-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }
        .menu-content {
            flex: 1;
            margin-left: 15px;
        }
        .add-menu {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Menu Management</h1>

        <!-- Menu List -->
        <div class="menu-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="menu-item">
                        <img src="images/<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="menu-image">
                        <div class="menu-content">
                            <h5><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p><?php echo htmlspecialchars($row['description']); ?></p>
                            <p><strong>RM<?php echo number_format($row['price'], 2); ?></strong></p>
                        </div>
                        <?php
                        // Determine the status button class based on availability
                        $status = strtolower($row['status']); 
                        if ($status == 'available') {
                            $buttonClass = 'status-available';
                            $buttonText = 'Available';
                        } elseif ($status == 'out') {
                            $buttonClass = 'status-out';
                            $buttonText = 'Out of Stock';
                        } elseif ($status == 'low') {
                            $buttonClass = 'status-low';
                            $buttonText = 'Running Low';
                        } else {
                            $buttonClass = '';
                            $buttonText = 'Unknown';
                        }
                        ?>
                        <button class="status-button <?php echo $buttonClass; ?>"><?php echo $buttonText; ?></button>
                        <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                        <form method="POST" action="delete_menu_item.php" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?php echo $row['id']; ?>">Edit Menu Item</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="POST" action="update_menu_item.php">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="mb-3">
                                            <label for="name<?php echo $row['id']; ?>" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name<?php echo $row['id']; ?>" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description<?php echo $row['id']; ?>" class="form-label">Description</label>
                                            <textarea class="form-control" id="description<?php echo $row['id']; ?>" name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price<?php echo $row['id']; ?>" class="form-label">Price</label>
                                            <input type="number" step="0.01" class="form-control" id="price<?php echo $row['id']; ?>" name="price" value="<?php echo $row['price']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status<?php echo $row['id']; ?>" class="form-label">Status</label>
                                            <select class="form-select" id="status<?php echo $row['id']; ?>" name="status" required>
                                                <option value="available" <?php echo $status == 'available' ? 'selected' : ''; ?>>Available</option>
                                                <option value="out" <?php echo $status == 'out' ? 'selected' : ''; ?>>Out of Stock</option>
                                                <option value="low" <?php echo $status == 'low' ? 'selected' : ''; ?>>Running Low</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">No menu items found.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php $conn->close(); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
