<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f9fff9; 
        }
        .container {
            text-align: center;
        }
        .logo {
            margin-bottom: 20px;
        }
        .logo img {
            width: 100px; 
        }
        h1 {
            font-size: 24px;
            color: #555;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            color: #fff;
            background-color: #4caf50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <img src="images/MemLogo.png" alt="Mem's Kolo Mee Logo"> 
        </div>
        <!-- Thank You Text -->
        <h1>Thanks for using our website!</h1>
        <!-- Login Button -->
        <a href="login.php" class="button">Go to Login</a>
    </div>
</body>
</html>
