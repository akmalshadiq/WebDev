<?php

session_start();
if (isset($_SESSION['role']) && !empty($_SESSION['role'])) {
    $userRole = $_SESSION['role']; 
} else {
    session_unset(); 
    session_destroy(); 
    header("Location: https://memskolomee.rf.gd/login.php");
    exit();  
}

?>