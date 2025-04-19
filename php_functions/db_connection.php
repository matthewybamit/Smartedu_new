<?php
// Database connection parameters
$host = 'localhost';
$dbname = 'smartedu';  // Your database name
$username = 'root';    // Adjust according to your MySQL credentials
$password = '';        // Adjust according to your MySQL credentials

// Create the database connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
