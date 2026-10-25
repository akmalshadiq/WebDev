<?php include ("navbar.php"); ?>

<?php
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

// Fetch menu items from the database
$menuItem1 = $conn->query("SELECT id, name, price FROM Noodles WHERE id='1'")->fetch_assoc();
$menuItem2 = $conn->query("SELECT id, name, price FROM Noodles WHERE id='6'")->fetch_assoc();
$menuItem3 = $conn->query("SELECT id, name, price FROM Noodles WHERE id='2'")->fetch_assoc();
$menuItem4 = $conn->query("SELECT id, name, price FROM Noodles WHERE id='4'")->fetch_assoc();
$menuItem5 = $conn->query("SELECT id, name, price FROM Noodles WHERE id='3'")->fetch_assoc();
$menuItem6 = $conn->query("SELECT id, name, price FROM Noodles WHERE id='5'")->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .menu-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }
        .card-body {
            padding: 15px;
        }
        .col-md-6 {
            flex: 0 0 70%;
            max-width: 70%;
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Search Bar -->
        <div class="row search-bar">
            <div class="col">
                <input type="text" id="menuSearch" class="form-control" placeholder="Search for menu items...">
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <!-- Tabs Navigation -->
                <ul class="nav flex-column nav-pills" id="categoryTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="mee-kolok-tab" data-bs-toggle="pill" data-bs-target="#mee-kolok" role="tab" aria-controls="mee-kolok"       aria-selected="true">Mee Kolok</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="mee-pok-tab" data-bs-toggle="pill" data-bs-target="#mee-pok" role="tab" aria-controls="mee-pok" aria-selected="false">Mee Pok</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="fried-noodles-tab" data-bs-toggle="pill" data-bs-target="#fried-noodles" role="tab" aria-controls="fried-noodles" aria-selected="false">Fried Noodles</button>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <!-- Tabs Content -->
                <div class="tab-content" id="categoryTabsContent">
                    <!-- Mee Kolok -->
                    <div class="tab-pane fade show active" id="mee-kolok" role="tabpanel" aria-labelledby="mee-kolok-tab">
                        <div class="row">
                            <div class="col-md-6 mb-4 menu-item" data-category="Mee Kolok">
                                <div class="card">
                                    <img src="images/meekolokchic.JPG" class="menu-image card-img-top" alt="Mee Kolok 1">
                                    <div class="card-body">
                                        <a href = "productKolo.php" h5 class="card-title"><?= htmlspecialchars($menuItem1['name']) ?></h5>
                                        <h5>RM<?= number_format($menuItem1['price'], 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 menu-item" data-category="Mee Kolok">
                                <div class="card">
                                    <img src="images/meekolokbeef.jpg" class="menu-image card-img-top" alt="Mee Kolok 2">
                                    <div class="card-body">
                                        <a href = "productKoloMerah.php" h5 class="card-title"><?= htmlspecialchars($menuItem2['name']) ?></h5>
                                        <h5>RM<?= number_format($menuItem2['price'], 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mee Pok -->
                    <div class="tab-pane fade" id="mee-pok" role="tabpanel" aria-labelledby="mee-pok-tab">
                        <div class="row">
                            <div class="col-md-6 mb-4 menu-item" data-category="Mee Pok">
                                <div class="card">
                                    <img src="images/meepokchic.jpg" class="menu-image card-img-top" alt="Mee Pok 1">
                                    <div class="card-body">
                                        <a href = "productPok.php" h5 class="card-title"><?= htmlspecialchars($menuItem3['name']) ?></h5>
                                        <h5>RM<?= number_format($menuItem3['price'], 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 menu-item" data-category="Mee Pok">
                                <div class="card">
                                    <img src="images/meepokbeef.jpg" class="menu-image card-img-top" alt="Mee Pok 2">
                                    <div class="card-body">
                                        <a href = "productPokMerah.php" h5 class="card-title"><?= htmlspecialchars($menuItem4['name']) ?></h5>
                                        <h5>RM<?= number_format($menuItem4['price'], 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fried Noodles -->
                    <div class="tab-pane fade" id="fried-noodles" role="tabpanel" aria-labelledby="fried-noodles-tab">
                        <div class="row">
                            <div class="col-md-6 mb-4 menu-item" data-category="Fried Noodles">
                                <div class="card">
                                    <img src="images/fnoodles.jpg" class="menu-image card-img-top" alt="Fried Noodles 1">
                                    <div class="card-body">
                                        <a href = "productFried.php"h5 class="card-title"><?= htmlspecialchars($menuItem5['name']) ?></h5>
                                        <h5>RM<?= number_format($menuItem5['price'], 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 menu-item" data-category="Fried Noodles">
                                <div class="card">
                                    <img src="images/ckt.jpg" class="menu-image card-img-top" alt="Fried Noodles 2">
                                    <div class="card-body">
                                        <a href = "productCharKueyTeow.php"h5 class="card-title"><?= htmlspecialchars($menuItem6['name']) ?></h5>
                                        <h5>RM<?= number_format($menuItem6['price'], 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality
        document.getElementById('menuSearch').addEventListener('input', function () {
            const query = this.value.toLowerCase();
            const items = document.querySelectorAll('.menu-item');

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(query)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
