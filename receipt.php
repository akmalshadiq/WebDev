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

// Ensure cart is initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Image mapping for items
$imageMap = [
    'Char Kuey Teow' => 'ckt.jpg',
    'Fried Noodles' => 'fnoodles.jpg',
    'Mee Kolok Biasa' => 'meekolokchic.JPG',
    'Mee Kolok Merah' => 'meekolokmerah.jpg',
    'Mee Pok Biasa' => 'meepokchic.jpg',
    'Mee Pok Merah' => 'meepokmerah.jpg',
];

// Function to get the image path
function getImagePath($itemName, $imageMap) {
    $defaultImage = 'default.jpg';
    return isset($imageMap[$itemName]) ? $imageMap[$itemName] : $defaultImage;
}

// Initialize total price
$total_price = array_reduce($_SESSION['cart'], function ($sum, $item) {
    return $sum + $item['total_price'];
}, 0);

// Handle saving the order to the database
if (isset($_POST['submit_order'])) {
    $fullName = $_SESSION['full_name'] ?? 'Anonymous';
    $orderId = uniqid(); // Generate a unique order ID for this transaction

    try {

        $conn->begin_transaction();

        // Insert each item in the cart into the database table
        foreach ($_SESSION['cart'] as $item) {
            $noodleName = $item['name'];
            $quantity = $item['quantity'];
            $toppings = $item['topping'];
            $total = $item['total_price'];

            // Prepare and execute the insert statement
            $orderStmt = $conn->prepare("INSERT INTO Order_items (order_id, full_name, noodle, quantity, toppings, total) VALUES (?, ?, ?, ?, ?, ?)");
            $orderStmt->bind_param("sssisd", $orderId, $fullName, $noodleName, $quantity, $toppings, $total);
            $orderStmt->execute();
        }

        // Commit the transaction
        $conn->commit();

        
        // Clear the cart after saving
        $_SESSION['cart'] = [];

       // Redirect to the index page with success message
        header("Location: index.php?status=success");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "<script>alert('Error saving order: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Mem's Kolo Mee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8fdf8;
        }
        .receipt-container {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 30px;
            margin-top: 20px;
        }
        .receipt-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .receipt-total {
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php include("navbar.php"); ?>

<div class="container my-5">
    <h2 class="mb-4">Receipt</h2>

    <!-- Order Confirmation Message -->
    <div class="alert alert-success text-center" role="alert">
        Your order has been confirmed! Thank you for dining with Mem's Kolo Mee.
    </div>

    <div class="receipt-container">
        <h4>Order Summary</h4>
        <?php foreach ($_SESSION['cart'] as $item): ?>
            <div class="receipt-item d-flex align-items-center">
                <img src="images/<?php echo htmlspecialchars(getImagePath($item['name'], $imageMap)); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="me-3">
                <div class="flex-grow-1">
                    <div><strong><?php echo htmlspecialchars($item['name']); ?></strong></div>
                    <div>Topping: <?php echo htmlspecialchars($item['topping']); ?></div>
                </div>
                <div class="text-end">
                    <div>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></div>
                    <div>Price: RM<?php echo number_format($item['price'], 2); ?></div>
                    <div>Total: RM<?php echo number_format($item['total_price'], 2); ?></div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="receipt-total text-end mt-4">
            Total: RM<?php echo number_format($total_price, 2); ?>
        </div>
    </div>

    <form method="POST" class="text-center mt-4">
        <button type="submit" name="submit_order" class="btn btn-primary">Save</button>
    </form>
</div>

</body>
</html>
