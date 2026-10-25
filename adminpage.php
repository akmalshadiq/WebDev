<?php
include("services/auth.php");
session_start();
include("services/connection2.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mem's Kolo Mee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background-color: #f8fdf8; /* Light green background */
        }
        .navbar-dark .navbar-nav .nav-link,
        .navbar-dark .navbar-brand {
            color: black !important;
            font-weight: bold !important;
        }
        .navbar {
            min-height: 80px;
            background-color: #0EBC17A1;
        }
        .dashboard-card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .dashboard-icon {
            font-size: 2rem;
            color: #0ebc17;
        }
        .card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
        }
        .left-section {
            display: flex;
            flex-direction: column;
			padding-left: 100px; 
        }
        .left-section h3, .left-section h5 {
            color: #333;
        }
        .top3-meals {
            list-style-type: none;
            padding: 0;
        }
        .top3-meals li {
            padding: 10px;
            background-color: #f1f1f1;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        /* Search bar style */
        .search-bar {
            background-color: #f8fdf8; /* Light background */
            border-radius: 30px;
            width: 50%; 
            margin: 10px 0;
        }

        .left-section-container {
			margin-top: 10px;
            flex: 3;
        }

        .right-section-container {
            flex: 1;
        }

        .dashboard-card {
            padding: 15px;
            margin: 10px;
        }

        .menu-banner {
            position: relative;
            width: 100%;
            height: 300px;
            background-image: url('images/bannermem.jpg');
            background-size: cover;
            background-position: center;
            border-radius: 0; 
            margin-bottom: 20px;
        }

        .search-bar {
            position: absolute;
            top: 10px;
            right: 5px;
            width: 40%; 
        }
		.container {
		max-width: 100%; 
		margin-left: auto;
		margin-right: auto;
		}
    </style>
</head>
<body>

<?php

// Fetch total orders for today
$totalOrdersQuery = "SELECT COUNT(*) AS total_orders FROM Order_items ";
$totalOrdersResult = $conn->query($totalOrdersQuery);
$totalOrders = ($totalOrdersResult && $totalOrdersResult->num_rows > 0) 
    ? $totalOrdersResult->fetch_assoc()['total_orders'] 
    : 0;

// Fetch total revenue for today
$totalRevenueQuery = "SELECT COALESCE(SUM(total), 0) AS total_revenue FROM Order_items ";
$totalRevenueResult = $conn->query($totalRevenueQuery);
$totalRevenue = ($totalRevenueResult && $totalRevenueResult->num_rows > 0) 
    ? $totalRevenueResult->fetch_assoc()['total_revenue'] 
    : 0;

?>



<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <img src="../images/MemLogo.png" alt="Logo" class="img-fluid" style="width: 100px; height: auto;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="adminpage.php">Dashboard</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" href="orders.php">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage-members.php">Members</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage-items.php">Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="transactions.php">Transactions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services/logout.php">Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

	<!-- Banner Section with Search Bar -->
	<div class="menu-banner">
		<div class="search-bar">
			<div class="input-group">
				<input type="text" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="search-addon">
				<button class="btn btn-outline-success" type="button" id="search-addon">
					<i class="bi bi-search"></i>
				</button>
			</div>
		</div>
	</div>

    <div class="row">

		<div class="col-md-8 left-section-container">
			<div class="card mb-4">
				<div class="left-section">
					<h3>Welcome Admin!</h3>
					<br>
					<h5>Total Orders Today:</h5>
					<p><?php echo $totalOrders; ?></p> <!-- Display total orders -->
					<h5>Total Revenue:</h5>
					<p>RM <?php echo number_format($totalRevenue, 2); ?></p> <!-- Display total revenue -->
					<h5>Popular Meals of the Day</h5>
					<!-- Popular Meals Bar Chart -->
					<div class="container my-5">
						<div class="chart-container" style="position: relative; height: 400px; width: 100%;">
                            <canvas id="mealChart"></canvas>
                        </div>
					</div>
				</div>
			</div>
		</div>


        <!-- Right Section: Manage Options -->
        <div class="col-md-4 right-section-container">
			<!-- Manage Orders -->
			<div class="card dashboard-card text-center">
				<i class="bi bi-receipt-cutoff dashboard-icon"></i>
				<h5 class="mt-3">Manage Orders</h5>
				<p>View and manage incoming orders.</p>
				<a href="orders.php" class="btn btn-outline-success">Go to Orders</a>
			</div>
            <!-- Manage Members -->
            <div class="card dashboard-card text-center">
                <i class="bi bi-people dashboard-icon"></i>
                <h5 class="mt-3">Manage Members</h5>
                <p>Manage registered members.</p>
                <a href="manage-members.php" class="btn btn-outline-success">Go to Members</a>
            </div>

            <!-- Manage Items -->
            <div class="card dashboard-card text-center">
                <i class="bi bi-box-seam dashboard-icon"></i>
                <h5 class="mt-3">Manage Items</h5>
                <p>Perform CRUD operations for items/products/services.</p>
                <a href="manage-items.php" class="btn btn-outline-success">Go to Items</a>
            </div>

            <!-- Transactions -->
            <div class="card dashboard-card text-center">
                <i class="bi bi-file-earmark-text dashboard-icon"></i>
                <h5 class="mt-3">Transactions</h5>
                <p>View and filter transaction summaries.</p>
                <a href="transactions.php" class="btn btn-outline-success">Go to Transactions</a>
            </div>

            <!-- Generate Reports -->
            <div class="card dashboard-card text-center">
                <i class="bi bi-printer dashboard-icon"></i>
                <h5 class="mt-3">Generate Reports</h5>
                <p>Generate transaction reports (PDF or on-screen).</p>
                <a href="salesreport.php" class="btn btn-outline-success">Go to Reports</a>
            </div>
        </div>
    </div>
</div>

<?php
$query = "
    SELECT Noodles.name, SUM(Order_items.quantity) AS popularity
    FROM Noodles
    LEFT JOIN Order_items ON Noodles.name = Order_items.noodle
    GROUP BY Noodles.id
    ORDER BY popularity DESC
";
$result = $conn->query($query);

$mealNames = [];
$popularityData = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mealNames[] = $row['name'];
        $popularityData[] = $row['popularity'];
    }
} else {
    // Fallback data if no results
    $mealNames = ['Chicken Kolo Mee', 'Beef Noodles', 'Veggie Kolo Mee'];
    $popularityData = [120, 80, 50]; 
}
?>





<script>
// Fetch the meal names and popularity data from PHP
const mealNames = <?php echo json_encode($mealNames); ?>;
const popularityData = <?php echo json_encode($popularityData); ?>;

// Bar Chart Data
const ctx = document.getElementById('mealChart').getContext('2d');
const mealChart = new Chart(ctx, {
    type: 'bar', 
    data: {
        labels: mealNames, // Meal names from the database
        datasets: [{
            label: 'Meals Popularity', // Label for the dataset
            data: popularityData, // Popularity from the database
            backgroundColor: '#0ebc17', // Bar color
            borderColor: '#0b9a13', // Border color for bars
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, 
        scales: {
            x: {
                beginAtZero: true 
            },
            y: {
                beginAtZero: true 
            }
        },
        plugins: {
            legend: {
                display: false 
            }
        }
    }
});
</script>

</body>
</html>
