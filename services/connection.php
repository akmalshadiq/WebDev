<?php
session_start();

// Database configuration
$servername = "sql200.infinityfree.com";
$username = "if0_37998389";
$password = "7DN2oOJqZn4oAk5";
$dbname = "if0_37998389_MemsKoloMee";

try {
    //PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /**
     *
     * @param PDO 
     * @return array 
     */

     //Fetch All User
    function fetchAllUsers(PDO $pdo) {
        $stmt = $pdo->prepare("SELECT full_name, email, bio, role FROM Users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Insert new member user
    function insertMember(PDO $pdo, $full_name, $email, $password, $role = "Member", $created_at) {
        $stmt = $pdo->prepare("INSERT INTO Users (full_name, email, password_hash, role, created_at) 
                               VALUES (:name, :email, :password, :role, :created_at)");
        return $stmt->execute([
            ':name' => $full_name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_DEFAULT), 
            ':role' => $role,
            ':created_at' => $created_at
        ]);
    }

    //Fetch user data by name
    function getUserInfoByName(PDO $pdo, $name) {
        $stmt = $pdo->prepare("SELECT full_name, email, bio, role FROM Users WHERE full_name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
