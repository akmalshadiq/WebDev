<?php
include("services/auth.php");
session_start();

$servername = "sql200.infinityfree.com";
$username = "if0_37998389";
$password = "7DN2oOJqZn4oAk5"; 
$dbname = "if0_37998389_MemsKoloMee"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_full_name = $_SESSION['full_name'];
$sql = "SELECT noodle, quantity, toppings, total FROM Order_items WHERE full_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_full_name);
$stmt->execute();
$result = $stmt->get_result();
$purchases = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $purchases[] = $row;
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
    <title>Profile - Mem's Kolo Mee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8fdf8;
        }
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #eaeaea;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #666;
            margin: 20px auto;
        }
        .section-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .recent-section img {
            width: 60px;
            height: 60px;
            border-radius: 5px;
            object-fit: cover;
        }
        .btn-edit-profile {
            background-color: #0ebc17;
            color: #fff;
            border: none;
        }
        .btn-edit-profile:hover {
            background-color: #099e13;
        }
        .btn-logout {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
        }
        .btn-logout:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>

<?php include("navbar.php"); ?>

<div class="container my-5">
    <!-- Profile Avatar and Edit Button -->
    <div class="section-container text-center">
        <div class="profile-avatar">
            <span>👤</span>
        </div>
    <!-- Update the button to redirect to edit_profile.php -->
    <a href="edit_profile.php" class="btn btn-edit-profile mb-3">Edit Profile</a>
</div>

    <!-- User Details Section -->
    <div class="section-container">
        <h5>Details</h5>
        <div class="mb-3">
            <label><strong>Name:</strong></label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($_SESSION['full_name']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label><strong>Email:</strong></label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label><strong>Bio:</strong></label>
            <textarea class="form-control" rows="3" readonly><?php echo htmlspecialchars($_SESSION['bio']); ?></textarea>
        </div>
    </div>

    <!-- Recent Reviews Section -->
    <div class="section-container">
        <h5>Recent Reviews:</h5>
        <div class="d-flex align-items-center recent-section">
            <img src="images/meekolokchic.JPG" alt="Mee Kolok" class="me-3">
            <div>
                <p class="mb-1"><strong>Mee Kolok Biasa</strong></p>
                <p class="mb-0">⭐⭐⭐⭐⭐</p>
                <p class="mb-0">"Impeccable"</p>
            </div>
        </div>
    </div>

    <!-- Recent Purchases Section -->
    <div class="section-container">
        <h5>Recent Purchases:</h5>
        <?php if (!empty($purchases)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Noodle</th>
                        <th>Quantity</th>
                        <th>Toppings</th>
                        <th>Total (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchases as $purchase): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($purchase['noodle']); ?></td>
                            <td><?php echo htmlspecialchars($purchase['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($purchase['toppings']); ?></td>
                            <td><?php echo htmlspecialchars($purchase['total']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No recent purchases found.</p>
        <?php endif; ?>
    </div>

    <!-- Logout Button -->
    <div class="section-container text-center">
        <a href="services/logout.php" class="btn btn-logout">Log Out</a>
    </div>
</div>

</body>
</html>