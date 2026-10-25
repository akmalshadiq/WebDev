<?php
	// Database configuration
    $servername = "sql200.infinityfree.com";
    $username = "if0_37998389";
    $password = "7DN2oOJqZn4oAk5";
    $dbname = "if0_37998389_MemsKoloMee";

	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
}