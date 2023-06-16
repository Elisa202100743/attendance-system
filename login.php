<?php
session_start();

// Check if the user is already logged in, redirect to home page
if (isset($_SESSION['user_id'])) {
  header("Location: home.php");
  exit;
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form input values
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Connect to the database
  $conn = mysqli_connect("localhost", "root", "", "attendance_system");

  // Check the database connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Prepare the SQL statement to retrieve user information
  $sql = "SELECT user_id, username, password FROM users WHERE username = '$username'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) === 1) {
    // Fetch the user record
    $row = mysqli_fetch_assoc($result);

    // Verify the password
    if ($password === $row['password']) {
      // Password is correct, set the session variables
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['username'] = $row['username'];

      // Redirect to the home page
      header("Location: home.php");
      exit;
    } else {
      // Invalid password
      $error = "Invalid username or password.";
    }
  } else {
    // Invalid username
    $error = "Invalid username or password.";
  }

  // Close the database connection
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Login</title>
</head>
<body>
  <h2>User Login</h2>
  <?php if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
  <?php } ?>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Login">
  </form>
</body>
</html>
