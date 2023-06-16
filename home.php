<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Get the logged-in user information
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Home Page</title>
</head>
<body>
  <h2>Welcome, <?php echo $username; ?>!</h2>
  <p>You are now logged in.</p>
  <a href="logout.php">Logout</a>
</body>
</html>
