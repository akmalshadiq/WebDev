<?php
include("services/auth.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .order-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .order-card img {
            max-width: 100%;
            border-radius: 5px;
        }
        .ready-button {
            background-color: #0EBC17A1;
            color: #fff;
        }
        .ready-button:hover {
            background-color: green;
        }
    </style>
</head>
<body>
	<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0EBC17A1;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Manage Orders</a>
            <img src="images/MemLogo.png" alt="Logo" class="img-fluid" style="width: 100px; height: auto ;">
        </div>
    </nav>
	<!-- Back Button -->
	<a href="adminpage.php" class="btn" style="background-color: #0EBC17A1; color: white ; position: absolute; top: 100px; left: 200px;">Back</a>
	<div class="container my-5">
    <h2 class="mb-4">Manage Orders</h2>

    <!-- Toast Container -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="toast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

<?php

    include("services/connection2.php"); 

    $ordersQuery = "
        SELECT oi.id AS order_id, oi.full_name AS user_name, oi.noodle AS noodle_name,
               oi.quantity, oi.toppings, oi.total AS item_total, oi.status AS order_status,
               n.image_url AS noodle_image
        FROM Order_items oi
        JOIN Noodles n ON oi.noodle = n.name
        WHERE oi.status IN ('Pending', 'In Progress')
        ORDER BY oi.id ASC
    ";
    $ordersResult = $conn->query($ordersQuery);

    if ($ordersResult->num_rows > 0) {
        while ($order = $ordersResult->fetch_assoc()) {
            ?>
            <div class="order-card">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="<?= $order['noodle_image']; ?>" alt="Noodle Image" />
                    </div>
                    <div class="col-md-6">
                        <h5>Order ID: <?= $order['order_id']; ?></h5>
                        <p><strong>Noodle:</strong> <?= $order['noodle_name']; ?></p>
                        <p><strong>Toppings:</strong> <?= $order['toppings']; ?></p>
                        <p><strong>Quantity:</strong> <?= $order['quantity']; ?></p>
                        <p><strong>Total Amount:</strong> RM <?= $order['item_total']; ?></p>
                    </div>
                    <div class="col-md-4 text-center">
                        <p><strong>Status:</strong> <?= $order['order_status']; ?></p>
                        <form method="POST" action="update-order-status.php">
                            <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">
                            <button type="submit" class="btn ready-button" name="status" value="Completed">
                                Mark as Ready
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p class='text-center'>No incoming orders at the moment.</p>";
    }
?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const params = new URLSearchParams(window.location.search);
    const toast = document.getElementById('toast');
    const toastBody = document.querySelector('.toast-body');

    if (params.has('success')) {
        toastBody.textContent = params.get('success');
        toast.classList.replace('text-bg-danger', 'text-bg-success');
        const toastInstance = new bootstrap.Toast(toast);
        toastInstance.show();
    } else if (params.has('error')) {
        toastBody.textContent = params.get('error');
        toast.classList.replace('text-bg-success', 'text-bg-danger');
        const toastInstance = new bootstrap.Toast(toast);
        toastInstance.show();
    }
</script>
</body>
</html>
