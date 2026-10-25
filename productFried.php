<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "sql200.infinityfree.com";
$username = "if0_37998389";
$password = "7DN2oOJqZn4oAk5";
$dbname = "if0_37998389_MemsKoloMee";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the price for the Fried Noodles 
$product_id = 3; 
$sql = "SELECT price FROM Noodles WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize price variable
    $price = 0.00;
    if ($row = $result->fetch_assoc()) {
        $price = $row['price'];
    }
    $stmt->close();
} else {
    die("Query preparation failed: " . $conn->error);
}

// Add to cart functionality
$item_added = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $topping = $_POST['topping'];
    $quantity = $_POST['quantity'];

    // Create a cart array if not already created
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add item to the cart
    $_SESSION['cart'][] = [
        'name' => 'Fried Noodles',
        'topping' => $topping,
        'quantity' => $quantity,
        'price' => $price,
        'total_price' => $quantity * $price,
    ];

    // Set item_added to true if the item is successfully added to the cart
    $item_added = true;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product - Fried Noodles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8fdf8; 
        }
        .product-container {
            margin: 50px auto;
        }
        .menu-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .reviews {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 10px;
        }
        .rating {
            color: gold;
        }

        .notification {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 9999;
            width: 300px;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<?php include("navbar.php"); ?>

<div class="container product-container">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <h1>Fried Noodles</h1>
            <img src="images/fnoodles.jpg" alt="Fried Noodles" class="menu-image">
            <div class="mb-3 p-3 border rounded" style="background-color: #f8f8f8;">
                <h5>Product Details</h5>
                <p>
                    A classic dish of stir-fried noodles, cooked to perfection with soy sauce, garlic, and a mix of fresh vegetables, offering a savory and smoky flavor in every bite.
                </p>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <form method="POST">
                <!-- Toppings -->
                <h5>Toppings</h5>
                <div class="mb-3">
                    <div>
                        <input type="radio" id="chicken" name="topping" value="Chicken" checked>
                        <label for="chicken">Chicken</label>
                    </div>
                    <div>
                        <input type="radio" id="beef" name="topping" value="Beef">
                        <label for="beef">Beef</label>
                    </div>
                    <div>
                        <input type="radio" id="mushroom" name="topping" value="Mushroom">
                        <label for="mushroom">Mushroom</label>
                    </div>
                    <div>
                        <input type="radio" id="squid" name="topping" value="Squid">
                        <label for="squid">Squid</label>
                    </div>
                </div>

                <!-- Quantity -->
                <h5>Quantity</h5>
                <div class="mb-3 d-flex align-items-center">
                    <button type="button" class="btn btn-outline-secondary" id="decrement-btn">-</button>
                    <input type="number" id="quantity-input" name="quantity" value="1" min="1" class="form-control mx-2" style="width: 60px; text-align: center;" readonly>
                    <button type="button" class="btn btn-outline-secondary" id="increment-btn">+</button>
                </div>

                <script>
                    // Select the quantity input and buttons
                    const quantityInput = document.getElementById('quantity-input');
                    const decrementBtn = document.getElementById('decrement-btn');
                    const incrementBtn = document.getElementById('increment-btn');

                    // Decrease quantity
                    decrementBtn.addEventListener('click', () => {
                        const currentValue = parseInt(quantityInput.value);
                        if (currentValue > parseInt(quantityInput.min)) {
                            quantityInput.value = currentValue - 1;
                        }
                    });

                    // Increase quantity
                    incrementBtn.addEventListener('click', () => {
                        const currentValue = parseInt(quantityInput.value);
                        quantityInput.value = currentValue + 1;
                    });

                    // Show the notification if item is added
                    window.onload = function() {
                        if (<?php echo json_encode($item_added); ?>) {
                            const notification = document.getElementById('notification');
                            notification.style.display = 'block';
                            setTimeout(() => {
                                notification.style.display = 'none';
                            }, 3000); 
                        }
                    }
                </script>

                <!-- Price -->
                <h5>Price: RM<?php echo number_format($price, 2); ?></h5>

                <!-- Buttons -->
                <div class="mt-4">
                    <button type="submit" name="add_to_cart" class="btn btn-primary me-2">Add to Cart</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reviews -->
    <div class="mt-5 reviews">
        <h5>Reviews</h5>
        <div class="d-flex align-items-center mb-3">
            <div>
                <img src="images/user.png" alt="User" class="rounded-circle" style="width: 60px; height: 60px;">
            </div>
            <div class="ms-3">
                <p class="mb-1"><strong>John Doe</strong></p>
                <p class="mb-1"><span class="rating">★★★★★</span></p>
                <p class="text-muted">Impeccable</p>
                <p class="text-muted">28/06/2002</p>
            </div>
        </div>
    </div>
</div>

<!-- Notification -->
<div id="notification" class="notification">
    Item added to cart!
</div>

</body>
</html>
