<?php
// Database connection configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "attendance_system";

// Create a connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check the database connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
