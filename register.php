<?php

        $servername = "sql200.infinityfree.com";
        $username = "if0_37998389";
        $password = "7DN2oOJqZn4oAk5";
        $dbname = "if0_37998389_MemsKoloMee";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>

        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #0EBC17A1;
        }
        .navbar-brand {
            color: black !important;
        }
        .navbar-nav .nav-link {
            color: black !important;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-black {
            background-color: #0EBC17A1;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .btn-black:hover {
            background-color: #17831ca1;
        }
        .text-black {
            color: black !important;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html" style="font-size: 24px; font-weight: bold;">
                Mem's Kolo Mee
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Registration Form Section -->
    <div class="container" style="max-width: 700px; margin-top: 50px; align-items-center">
        <!-- Image Section -->
        <div class="row justify-content-center mb-4">
            <div class="col-12 text-center">
                <img src="images/MemLogo.png" alt="Logo" class="img-fluid" style="max-width: 200px; height: auto;" />
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Form with action attribute to process registration -->
                <form class="form-container" method="POST" action="register.php">
                    <h3 class="text-center text-black mb-4">Register</h3>

                    <!-- Full Name -->
                    <div class="col-8">
                        <div class="form-outline">
                            <input type="text" name="fullName" id="fullName" class="form-control" required />
                            <label class="form-label" for="fullName">Full Name</label>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-8">
                        <div class="form-outline">
                            <input type="email" name="email" id="email" class="form-control" required />
                            <label class="form-label" for="email">Email Address</label>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="col-8">
                        <div class="form-outline">
                            <input type="password" name="password" id="password" class="form-control" required placeholder="Password" />
                            <label class="form-label" for="password">Password</label>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-8">
                        <div class="form-outline">
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" required placeholder="Confirm Password" />
                            <label class="form-label" for="confirmPassword"></label>
                        </div>
                        <small id="errorMessage" class="text-danger" style="display:none;">Does not match</small>
                    </div>

                    <button type="submit" name="submit" class="btn btn-black btn-block mb-4 w-100">Register</button>
                </form>
            </div>
        </div>
    </div>

    <?php

    if (isset($_POST['submit'])) {
        
        // Get form data
        $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        // Check if passwords match
        if ($password !== $confirmPassword) {
            echo '<script>document.getElementById("errorMessage").style.display = "block";</script>';
        } else {
            // Hash the password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insert into the database
            $sql = "INSERT INTO Users (full_name, email, password_hash, role) VALUES ('$fullName', '$email', '$passwordHash', 'member')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $conn->close();
    }
    ?>
</body>
</html>
