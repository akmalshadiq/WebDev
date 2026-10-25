<?php
include("services/auth.php");
session_start();

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

// Fetch order notifications
$user_full_name = $_SESSION['full_name'];
$sql = "SELECT noodle, quantity, toppings, total, status FROM Order_items WHERE full_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_full_name);
$stmt->execute();
$result = $stmt->get_result();
$notifications = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Mem's Kolo Mee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8fdf8; 
        }
        .section-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="container my-5">
    <!-- Notifications Section -->
    <div class="section-container">
        <h5>Order Notifications:</h5>
        <?php if (!empty($notifications)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Noodle</th>
                        <th>Quantity</th>
                        <th>Toppings</th>
                        <th>Total (RM)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notifications as $notification): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($notification['noodle']); ?></td>
                            <td><?php echo htmlspecialchars($notification['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($notification['toppings']); ?></td>
                            <td><?php echo htmlspecialchars($notification['total']); ?></td>
                            <td>
                                <?php 
                                    // Highlight status
                                    $status = htmlspecialchars($notification['status']);
                                    $status_class = "";
                                    if ($status == "Pending") {
                                        $status_class = "text-warning";
                                    } elseif ($status == "Preparing") {
                                        $status_class = "text-info";
                                    } elseif ($status == "Completed") {
                                        $status_class = "text-success";
                                    }
                                    echo "<span class='$status_class'>$status</span>";
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No notifications found.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
