<?php
include 'connection.php';  

session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    try {
        $stmt = $pdo->prepare("SELECT full_name, email, bio, password_hash, role FROM Users WHERE full_name = :username OR email = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Store user info in session
            $_SESSION['user_id'] = $user['email'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['bio'] = $user['bio'];

            if ($user['role'] == 'Admin') {
                header("Location: https://memskolomee.rf.gd/adminpage.php");
                exit();
            } elseif ($user['role'] == 'Member') {
                header("Location: https://memskolomee.rf.gd/index.php");
                exit();
            }
        } else {
            echo "Invalid username or password.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?> 