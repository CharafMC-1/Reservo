<?php
$host = "localhost";
$user = "root";
$password = ""; // Set your password here if needed
$dbname = "meetings";

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Test the connection
    echo "Connected successfully to the database!";
} catch (PDOException $e) {
    // Log the error and display a user-friendly message
    error_log($e->getMessage()); // Log error message
    die("Connection failed: Unable to connect to the database.");
}
?>