
<?php
include("services/auth.php");
session_start();
include("services/connection2.php"); 
//Get sales for the current week
$weeklySalesQuery = "
    SELECT d.day, COALESCE(SUM(o.total_amount), 0) AS total_sales
    FROM (
        SELECT 'Monday' AS day
        UNION ALL SELECT 'Tuesday'
        UNION ALL SELECT 'Wednesday'
        UNION ALL SELECT 'Thursday'
        UNION ALL SELECT 'Friday'
        UNION ALL SELECT 'Saturday'
        UNION ALL SELECT 'Sunday'
    ) d
    LEFT JOIN Orders o ON DAYNAME(o.created_at) = d.day AND o.created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
    GROUP BY d.day
    ORDER BY FIELD(d.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
";
$weeklySalesResult = $conn->query($weeklySalesQuery);


//Get sales for the current month
$startDate = date('Y-m-01'); 
$endDate = date('Y-m-t');  

$monthlySalesQuery = "
    SELECT w.week, COALESCE(SUM(o.total_amount), 0) AS total_sales
    FROM (
        SELECT WEEK('$startDate' + INTERVAL (n) WEEK, 1) - WEEK('$startDate', 1) + 1 AS week
        FROM (SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4) num
        WHERE '$startDate' + INTERVAL (n * 7) DAY <= '$endDate'
    ) w
    LEFT JOIN Orders o 
        ON WEEK(o.created_at, 1) - WEEK('$startDate', 1) + 1 = w.week
        AND o.created_at BETWEEN '$startDate' AND '$endDate'
    GROUP BY w.week
    ORDER BY w.week
";
$monthlySalesResult = $conn->query($monthlySalesQuery);




//Get sales for the current year
$yearlySalesQuery = "
    SELECT m.month, COALESCE(SUM(o.total_amount), 0) AS total_sales
    FROM (
        SELECT 'January' AS month
        UNION ALL SELECT 'February'
        UNION ALL SELECT 'March'
        UNION ALL SELECT 'April'
        UNION ALL SELECT 'May'
        UNION ALL SELECT 'June'
        UNION ALL SELECT 'July'
        UNION ALL SELECT 'August'
        UNION ALL SELECT 'September'
        UNION ALL SELECT 'October'
        UNION ALL SELECT 'November'
        UNION ALL SELECT 'December'
    ) m
    LEFT JOIN Orders o ON MONTHNAME(o.created_at) = m.month AND YEAR(o.created_at) = YEAR(CURDATE())
    GROUP BY m.month
    ORDER BY FIELD(m.month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')
";
$yearlySalesResult = $conn->query($yearlySalesQuery);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
	<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0EBC17A1;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sales Report</a>
            <img src="images/MemLogo.png" alt="Logo" class="img-fluid" style="width: 100px; height: auto ;">
        </div>
    </nav>
    <div class="container my-5">
        <h2 class="text-center mb-4">Sales Report</h2>

        <!-- Weekly Sales Chart -->
        <div class="card mb-4">
            <h5 class="card-header">Weekly Sales</h5>
            <div class="card-body">
                <canvas id="weeklySalesChart"></canvas>
            </div>
        </div>

        <!-- Monthly Sales Chart -->
        <div class="card mb-4">
            <h5 class="card-header">Monthly Sales</h5>
            <div class="card-body">
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>

        <!-- Yearly Sales Chart -->
        <div class="card mb-4">
            <h5 class="card-header">Yearly Sales</h5>
            <div class="card-body">
                <canvas id="yearlySalesChart"></canvas>
            </div>
        </div>

        <!-- Download Report Button -->
        <div class="text-center">
            <a href="download-sales-report.php" class="btn btn-success"target='_blank'>Download Sales Report</a>
        </div>
		
		<!-- Back Button -->
		<a href="adminpage.php" class="btn" style="background-color: #0EBC17A1; color: white ; position: absolute; top: 100px; left: 300px;">Back</a>
    </div>

    <!-- JavaScript for the charts -->
    <script>
        // Weekly Sales Chart
        const weeklySalesCtx = document.getElementById('weeklySalesChart').getContext('2d');
        const weeklySalesData = <?php
            $weeklySales = [];
            while ($row = $weeklySalesResult->fetch_assoc()) {
                $weeklySales[] = $row;
            }
            echo json_encode($weeklySales);
        ?>;
        const weeklyLabels = weeklySalesData.map(item => item.day);
        const weeklyData = weeklySalesData.map(item => item.total_sales);

        const weeklySalesChart = new Chart(weeklySalesCtx, {
            type: 'bar',
            data: {
                labels: weeklyLabels,
                datasets: [{
                    label: 'Sales (RM)',
                    data: weeklyData,
                    backgroundColor: '#0ebc17',
                    borderColor: '#0b9a13',
                    borderWidth: 1
                }]
            }
        });

        // Monthly Sales Chart
        const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesData = <?php
            $monthlySales = [];
            while ($row = $monthlySalesResult->fetch_assoc()) {
                $monthlySales[] = $row;
            }
            echo json_encode($monthlySales);
        ?>;

        const monthlyLabels = monthlySalesData.map(item => `Week ${item.week}`);
        const monthlyData = monthlySalesData.map(item => item.total_sales);

        const monthlySalesChart = new Chart(monthlySalesCtx, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Sales (RM)',
                    data: monthlyData,
                    backgroundColor: '#0ebc17',
                    borderColor: '#0b9a13',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true 
                    }
                }
            }
        });


        // Yearly Sales Chart
        const yearlySalesCtx = document.getElementById('yearlySalesChart').getContext('2d');
        const yearlySalesData = <?php
            $yearlySales = [];
            while ($row = $yearlySalesResult->fetch_assoc()) {
                $yearlySales[] = $row;
            }
            echo json_encode($yearlySales);
        ?>;
        const yearlyLabels = yearlySalesData.map(item => item.month);
        const yearlyData = yearlySalesData.map(item => item.total_sales);

        const yearlySalesChart = new Chart(yearlySalesCtx, {
            type: 'bar',
            data: {
                labels: yearlyLabels,
                datasets: [{
                    label: 'Sales (RM)',
                    data: yearlyData,
                    backgroundColor: '#0ebc17',
                    borderColor: '#0b9a13',
                    borderWidth: 1
                }]
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
