<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Mem's Kolo Mee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8fdf8; /* Light green background */
        }
        .menu-banner {
            height: 300px;
            background: url('images/banner.jpg') no-repeat center center/cover;
        }
        .category-tab {
            font-weight: bold;
            border-bottom: 2px solid #0ebc17;
        }
        .food-item img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .menu-image {
            width: 250px !important; 
            height: 250px !important;
            object-fit: cover !important;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        
.top-category-image {
    max-width: 25%;  
    height: auto;     
    border-radius: 10px; 
    margin-bottom: 20px; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
}

    </style>
</head>
<body>

<?php include ("navbar.php") ;?>

    <!-- Banner -->
    <div class="menu-banner d-flex align-items-center justify-content-center">
        <img src="images/bannermem.jpg" alt="Logo" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
        <h1 class="text-white"></h1>
    </div>

    <!-- Categories and Items -->
    <div class="container my-5">
        <ul class="nav nav-tabs justify-content-center mb-4" id="menuTabs" role="tablist">
            <li class="nav-item" role="presentation">
             <button class="nav-link active category-tab" id="mee-kolok-tab" data-bs-toggle="tab" data-bs-target="#mee-kolok" type="button" role="tab"><b>Mee Kolok</b></button>
        </li>
            <li class="nav-item" role="presentation">
            <button class="nav-link category-tab" id="mee-pok-tab" data-bs-toggle="tab" data-bs-target="#mee-pok" type="button" role="tab"><b>Mee Pok</b></button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link category-tab" id="fried-noodles-tab" data-bs-toggle="tab" data-bs-target="#fried-noodles" type="button" role="tab"><b>Fried Noodles</b></button>
        </li>
    </ul>

    <div class="tab-content" id="menuTabsContent">
        <!-- Mee Kolok -->
        <div class="tab-pane fade show active" id="mee-kolok" role="tabpanel">
    <!-- Centered Image -->
    <div class="text-center mb-4">
        <img src="images/meekolokbeef.jpg" alt="Mee Kolok" class="top-category-image">
    </div>
    
    <!-- Description -->
    <div class="text-center mb-4">
        <h5>Mee Kolok</h5>
        <p>
            Beloved noodle dish originating from Sarawak, Malaysia. 
            It features springy egg noodles tossed in a light and fragrant sauce, often made with vegetable oil, soy sauce, and sometimes vinegar.
        </p>
        <h5>View our current selections for Mee Kolok below!</h5>
    </div>

    <!-- Food Items -->
            <div class="row">
                <div class="col-md-4 food-item mb-4">
                    <a href="productKolo.php" class="text-decoration-none">
                        <img src="images/meekolokchic.JPG" alt="Mee Kolok Biasa" class="menu-image">
                        <h5 class="mt-2">Mee Kolok Biasa</h5>
                        <p>RM6.50</p>
                    </a>
                </div>
                <div class="col-md-4 food-item mb-4">
                    <a href="productKoloMerah.php" class="text-decoration-none">
                        <img src="images/meekolokbeef.jpg" alt="Mee Kolok Merah" class="menu-image">
                        <h5 class="mt-2">Mee Kolok Merah</h5>
                        <p>RM6.50</p>
                    </a>
                </div>
            </div>
        </div>


        <!-- Mee Pok -->
        <div class="tab-pane fade" id="mee-pok" role="tabpanel">

        <div class="text-center mb-4">
        <img src="images/meepokbeef.jpg" alt="Mee Pok" class="top-category-image">
        </div>
            <div class="text-center mb-4">
                <h5>Mee Pok</h5>
                <p>Mee Pok is a flat egg noodle dish, popular in Singapore and Malaysia. It is versatile, often prepared in a dry (tossed) style or as a soup.</p>
                <h5>View our current selections for Mee Pok below!</h5>
            </div>
            
            <div class="row">
                <div class="col-md-4 food-item mb-4">
                    <a href="productPok.php" class="text-decoration-none">
                        <img src="images/meepokchic.jpg" alt="Mee Pok Biasa" class="menu-image">
                        <h5 class="mt-2">Mee Pok Biasa</h5>
                        <p>RM6.5</p>
                    </a>
                </div>
                <div class="col-md-4 food-item mb-4">
                    <a href="productPokMerah.php" class="text-decoration-none">
                        <img src="images/meepokmerah.jpg" alt="Mee Pok Merah" class="menu-image">
                        <h5 class="mt-2">Mee Pok Merah</h5>
                        <p>RM6.50</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Fried Noodles -->
        <div class="tab-pane fade" id="fried-noodles" role="tabpanel">
        <div class="text-center mb-4">
        <img src="images/fnoodles.jpg" alt="Mee Kolok" class="top-category-image">
        </div>
            <div class="text-center mb-4">
                <h5>Fried Noodles</h5>
                <p>Fried Noodles are a flavorful stir-fried dish made with noodles, vegetables, and your choice of meat, seasoned with soy sauce and spices.</p>
                <h5>View our current selections for Fried Noodles below!</h5>
            </div>
            <div class="row">
                <div class="col-md-4 food-item mb-4">
                    <a href="productFried.php" class="text-decoration-none">
                        <img src="images/fnoodles.jpg" alt="Fried Noodles" class="menu-image">
                        <h5 class="mt-2">Fried Noodles</h5>
                        <p>RM8.00</p>
                    </a>
                </div>
                <div class="col-md-4 food-item mb-4">
                    <a href="productCharKueyTeow.php" class="text-decoration-none">
                        <img src="images/ckt.jpg" alt="Char Kuey Teow" class="menu-image">
                        <h5 class="mt-2">Char Kuey Teow</h5>
                        <p>RM8.00</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hot Items Section -->
<div class="container my-5">
    <h3 class="text-center mb-4">🔥 Hot Items 🔥</h3>
    <h3 class="text-center mb-4">Take a look at our our most popular items!</h3>
    <div class="row">
        <!-- Hot Item 1 -->
        <div class="col-md-4 food-item mb-4">
            <a href="productKolo.php" class="text-decoration-none">
                <img src="images/meekolokchic.JPG" alt="Mee Kolok Biasa" class="menu-image">
                <h5 class="mt-2">Mee Kolok Biasa</h5>
            </a>
            <p>RM6.5</p>
        </div>
        
        <!-- Hot Item 2 -->
        <div class="col-md-4 food-item mb-4">
            <a href="productPok.php" class="text-decoration-none">
                <img src="images/meepokchic.jpg" alt="Mee Pok Biasa" class="menu-image">
                <h5 class="mt-2">Mee Pok Biasa</h5>
            </a>
            <p>RM6.5</p>
        </div>
        
        <!-- Hot Item 3 -->
        <div class="col-md-4 food-item mb-4">
            <a href="productFried.php" class="text-decoration-none">
                <img src="images/fnoodles.jpg" alt="Fried Noodle" class="menu-image">
                <h5 class="mt-2">Fried Noodle</h5>
            </a>
            <p>RM8.0</p>
        </div>

        <div class="col-md-4 food-item mb-4">
            <a href="productCharKueyTeow.php" class="text-decoration-none">
                <img src="images/ckt.jpg" alt="Char Kuey Teow" class="menu-image">
                <h5 class="mt-2">Char Kuey Teow</h5>
            </a>
            <p>RM8.0</p>
        </div>
    </div>
</div>


</body>
</html>
