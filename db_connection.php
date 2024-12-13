<?php
// Database configuration
$host = 'localhost';
$dbname = 'campus_connect';
$username = 'root';
$password = '';

// Start session
session_start();

// Initialize error variable
$error = "";

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>