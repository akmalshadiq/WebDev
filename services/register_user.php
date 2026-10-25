<?php

require 'connection.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data from POST request
    $full_name = trim($_POST['registerUserName']);
    $email = trim($_POST['registerUserEmail']);
    $password = $_POST['registerPass'];
    $confirm_password = $_POST['confirm_password'];
    $created_at = date('Y-m-d H:i:s');

    // Confirm password check
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
        exit;
    }
    // Check if the email already exists in the database
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Email is already registered.');</script>";
        exit;
    }

    // Insert function
    try {
        // Hash the password before storing
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new member
        $role = "Member"; 
        $stmt = $pdo->prepare("INSERT INTO Users (full_name, email, password_hash, role, created_at) 
                               VALUES (:full_name, :email, :password_hash, :role, :created_at)");
        $stmt->execute([
            ':full_name' => $full_name,
            ':email' => $email,
            ':password_hash' => $password_hash,
            ':role' => $role,
            ':created_at' => $created_at
        ]);

        // Success alert and redirection
        echo "<script>alert('Registration successful!'); window.location.href='https://memskolomee.rf.gd/login.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>
