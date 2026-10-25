<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle (includes both Bootstrap JS and Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f0fdf0; 
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 90%;
        }

        .logo-section {
            flex: 1;
            text-align: center;
        }

        .logo-section img {
            max-width: 200px;
            height: auto;
        }

        .buttons-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #d4f5d4;
            padding: 20px;
            border-radius: 10px;
        }

        .btn {
            margin: 10px 0;
            width: 100%;
        }

        .btn-primary {
            background-color: #0ebc17;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0a8e11;
        }

        .btn-secondary {
            background-color: #28a745;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #1e7a34;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Logo Section -->
        <div class="logo-section">
            <img src="images/MemLogo.png" alt="Mem's Kolo Mee Logo">
            <h2>Mem's Kolo Mee</h2>
        </div>

        <!-- Buttons Section -->
        <div class="buttons-section">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerModal">Register</button>
            <a href="index.php" class="btn btn-secondary">Enter as Guest</a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adminModal">Enter as Admin</a>
        </div>
    </div>
    
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-column align-items-center">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="images/MemLogo.png" alt="Modal Image" class="img-fluid mb-3" style="max-width: 150px; height: auto;">
                </div>
                <div class="modal-header d-flex justify-content-between align-items-center w-100 border-0">
                    <h5 class="modal-title text-center" id="registerModalLabel">Login</h5>
                </div>
                <div class="modal-body">
                    <!-- Login Form -->
                    <form action="services/checkUser.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="loginUsername" name="loginUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Modal -->
    <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-column align-items-center">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="images/MemLogo.png" alt="Modal Image" class="img-fluid mb-3" style="max-width: 150px; height: auto;">
                </div>
                <div class="modal-header d-flex justify-content-between align-items-center w-100 border-0">
                    <h5 class="modal-title text-center" id="registerModalLabel">Admin Login</h5>
                </div>
                <div class="modal-body">
                    <!-- Login Form -->
                    <form action="services/checkUser.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="loginUsername" name="loginUsername" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex flex-column align-items-center">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img src="images/MemLogo.png" alt="Modal Image" class="img-fluid mb-3" style="max-width: 150px; height: auto;">
                </div>
                <div class="modal-header d-flex justify-content-between align-items-center w-100 border-0">
                    <h5 class="modal-title text-left" id="registerModalLabel">Register</h5>
                </div>

                <div class="modal-body">
                    <!-- Registration Form -->
                    <form action="services/register_user.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="registerUsername" name="registerUserName" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="registerEmail" name="registerUserEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="registerPassword" name="registerPass" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="register_confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>  

<script>
    function showAlert(message, redirect = false) {
        document.getElementById('alertMessage').innerText = message;
        $('#alertModal').modal('show');
        
        // If redirect is true change the button link to the login page
        if (redirect) {
            document.getElementById('redirectBtn').style.display = 'block';
        } else {
            document.getElementById('redirectBtn').style.display = 'none';
        }
    }
</script>

</body>
</html>
