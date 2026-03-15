<?php
// Database configuration
$servername = "localhost";
$username   = "root";        // default for XAMPP
$password   = "";            // default for XAMPP
$database   = "servicebooking";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}


// Optional: success message (comment out in production)
// echo "Database Connected Successfully";
?>
