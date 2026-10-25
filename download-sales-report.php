<?php
include("services/auth.php");
session_start();
include("services/connection2.php");

// HTML structure for the on-screen sales report
echo "<!DOCTYPE html>";
echo "<html lang='en'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Sales Report</title>";
echo "<style>";
echo "table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }";
echo "th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }";
echo "th { background-color: #f2f2f2; }";
echo "h2 { margin-top: 30px; }";
echo "</style>";
echo "</head>";
echo "<body>";

echo "<h1>Sales Report</h1>";

// Weekly Sales Report
echo "<h2>Weekly Sales</h2>";
echo "<table>";
echo "<thead>";
echo "<tr><th>Category</th><th>Period</th><th>Total Amount (RM)</th></tr>";
echo "</thead>";
echo "<tbody>";

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
while ($row = $weeklySalesResult->fetch_assoc()) {
    echo "<tr>";
    echo "<td>Weekly</td>";
    echo "<td>" . htmlspecialchars($row['day']) . "</td>";
    echo "<td>" . number_format($row['total_sales'], 2) . "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";

// Monthly Sales Report
echo "<h2>Monthly Sales</h2>";
echo "<table>";
echo "<thead>";
echo "<tr><th>Category</th><th>Period</th><th>Total Amount (RM)</th></tr>";
echo "</thead>";
echo "<tbody>";

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
while ($row = $monthlySalesResult->fetch_assoc()) {
    echo "<tr>";
    echo "<td>Monthly</td>";
    echo "<td>Week " . htmlspecialchars($row['week']) . " (This Month)</td>";
    echo "<td>" . number_format($row['total_sales'], 2) . "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";

// Yearly Sales Report
echo "<h2>Yearly Sales</h2>";
echo "<table>";
echo "<thead>";
echo "<tr><th>Category</th><th>Period</th><th>Total Amount (RM)</th></tr>";
echo "</thead>";
echo "<tbody>";

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
while ($row = $yearlySalesResult->fetch_assoc()) {
    echo "<tr>";
    echo "<td>Yearly</td>";
    echo "<td>" . htmlspecialchars($row['month']) . "</td>";
    echo "<td>" . number_format($row['total_sales'], 2) . "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "</table>";

echo "</body>";
echo "</html>";
?>
