<?php
include("services/auth.php");
session_start(); // Ensure the session is started to access cart data

// Database connection details
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

// If cart data is missing, initialize an empty array
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

// Handle remove item request
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $indexToRemove = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$indexToRemove])) {
        unset($_SESSION['cart'][$indexToRemove]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the cart
    }

    header("Location: cart.php");
    exit;
}

// Calculate total price
$total_price = array_reduce($_SESSION['cart'], function ($sum, $item) {
    return $sum + $item['total_price'];
}, 0);

// Insert the cart data into the Order_items table
if (isset($_POST['submit_order'])) {
    $fullName = $_SESSION['full_name'] ?? 'Anonymous'; 
    
    // Insert each item in the cart into the database table
    foreach ($_SESSION['cart'] as $item) {
        $noodleName = $item['name'];
        $quantity = $item['quantity'];
        $toppings = $item['topping'];
        $total = $item['total_price'];
        
        // Insert the order item into the database table
        $orderStmt = $conn->prepare("INSERT INTO Order_items (full_name, noodle, quantity, toppings, total) VALUES (?, ?, ?, ?, ?)");
        $orderStmt->bind_param("ssiss", $fullName, $noodleName, $quantity, $toppings, $total);
        $orderStmt->execute();
    }
    
    // Redirect to receipt page after order is placed
    header("Location: receipt.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Mem's Kolo Mee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8fdf8;
        }
        .cart-item {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .cart-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .payment-option {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
        }
    </style>
</head>
<body>
<?php include("navbar.php"); ?>

<div class="container my-5">
    <h2 class="mb-4">Cart</h2>

    <!-- Cart Items -->
    <div class="row">
        <div class="col-12">
            <?php if (count($_SESSION['cart']) > 0): ?>
                <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                    <div class="cart-item d-flex align-items-center">
                        <!-- Use getImagePath to get the image for the item -->
                        <img src="images/<?php echo htmlspecialchars(getImagePath($item['name'], $imageMap)); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="ms-3 flex-grow-1">
                            <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                            <p>Topping: <?php echo htmlspecialchars($item['topping']); ?></p>
                        </div>
                        <div class="text-end">
                            <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                            <p>Price: RM<?php echo number_format($item['price'], 2); ?></p>
                            <p>Total: RM<?php echo number_format($item['total_price'], 2); ?></p>
                            <a href="cart.php?remove=<?php echo $index; ?>" class="btn btn-danger btn-sm">Remove</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Your cart is empty!</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Payment Section -->
    <?php if (count($_SESSION['cart']) > 0): ?>
        <div class="row mt-4">
            <div class="col-md-4">
                <h4>Choose Payment Option</h4>
                <button class="btn btn-outline-primary w-100 mb-2" id="online-payment-btn">Online Payment</button>
                <button class="btn btn-outline-secondary w-100" id="physical-payment-btn">Physical Payment</button>
            </div>
            <div class="col-md-8">
                <!-- Payment Option Container (Initially Hidden) -->
                <div class="payment-option" id="payment-option" style="display: none;">
                    <!-- Content will inserted by JavaScript -->
                </div>
            </div>
        </div>
    <?php endif; ?> 

    <!-- Total Section -->
    <div class="row mt-4">
        <div class="col-12 text-end">
            <h4>Total: RM<?php echo number_format($total_price, 2); ?></h4>
        </div>
    </div>
</div>

<!-- JavaScript (Payment Toggle) -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const onlinePaymentBtn = document.getElementById("online-payment-btn");
    const physicalPaymentBtn = document.getElementById("physical-payment-btn");
    const paymentOptionDiv = document.getElementById("payment-option");

    // Handle online payment button click
    onlinePaymentBtn.addEventListener("click", () => {
        paymentOptionDiv.style.display = "block";
        paymentOptionDiv.innerHTML = ` 
            <h4>Online Payment</h4>
            <div class="row align-items-center">
                <div class="col-3 text-center">
                    <label for="qr-code" class="d-block mt-2">Mem's Kolok Mee</label>
                    <img src="images/qr.jpg" alt="QR Code" class="img-fluid">
                    <input type="radio" name="payment-method" id="qr-code" class="payment-method-radio">
                    <p class="text-muted">Please show proof of payment to the cashier after paying using QR.</p>
                </div>
                <div class="col-6">
                    <h6>Online Banking</h6>
                    <div>
                        <input type="radio" name="payment-method" id="mastercard">
                        <label for="mastercard">
                            <img src="images/mastercard.png" alt="Mastercard Logo" style="width: 40px; height: auto; margin-right: 10px;">
                            **** 9127
                        </label>
                        <br>
                        <input type="radio" name="payment-method" id="visa">
                        <label for="visa">
                            <img src="images/visa.jpg" alt="Visa Logo" style="width: 40px; height: auto; margin-right: 10px;">
                            **** 6741
                        </label>
                        <br>
                        <a href="#" class="text-decoration-none">+ Add New Card</a>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <p>Name: <?php echo htmlspecialchars($_SESSION['full_name'] ?? ''); ?></p>
                    <!-- Order Submission -->
                    <form method="POST">
                     <button type="submit" name="submit_order" class="btn btn-success w-100 mt-4">Place Order</button>
                    </form>
                </div>
            </div>
        `;
    });

    // Handle physical payment button click
    physicalPaymentBtn.addEventListener("click", () => {
        paymentOptionDiv.style.display = "block";
        paymentOptionDiv.innerHTML = ` 
            <h4>Physical Payment</h4>
            <div class="row align-items-center">
                <div class="col-12">
                    <p>Name: <?php echo htmlspecialchars($_SESSION['full_name'] ?? ''); ?></p>
                    <p>*Please state your name at the counter to verify and pick up your order*.</p>
                    <!-- Order Submission -->
                    <form method="POST">
                     <button type="submit" name="submit_order" class="btn btn-success w-100 mt-4">Place Order</button>
                    </form>
                </div>
            </div>
        `;
    });
});
</script>

</body>
</html>

