<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Include the database connection file
require_once "db_connection.php";

// Get the class ID from the URL parameter
$class_id = $_GET['class_id'];

// Get the class name
$sql = "SELECT name FROM classes WHERE class_id = '$class_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$className = $row['name'];

// Handle attendance form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form input values
  $student_id = $_POST['student_id'];
  $date = $_POST['date'];
  $status = $_POST['status'];

  // Insert attendance record into the database
  $sql = "INSERT INTO attendance (class_id, student_id, date, status) VALUES ('$class_id', '$student_id', '$date', '$status')";
  if (mysqli_query($conn, $sql)) {
    $message = "Attendance recorded successfully.";
  } else {
    $error = "Error: " . mysqli_error($conn);
  }
}

// Retrieve students for the selected class
$sql = "SELECT * FROM students WHERE class_id = '$class_id'";
$studentsResult = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Take Attendance</title>
</head>
<body>
  <h2>Take Attendance - <?php echo $className; ?></h2>
  <?php if (isset($message)) { ?>
    <p><?php echo $message; ?></p>
  <?php } ?>
  <?php if (isset($error)) { ?>
    <p><?php echo $error; ?></p>
  <?php } ?>
  <form action="<?php echo $_SERVER['PHP_SELF'] . '?class_id=' . $class_id; ?>" method="POST">
    <label for="student_id">Select Student:</label>
    <select id="student_id" name="student_id" required>
      <option value="">Select Student</option>
      <?php while ($student = mysqli_fetch_assoc($studentsResult)) { ?>
        <option value="<?php echo $student['student_id']; ?>"><?php echo $student['name']; ?></option>
      <?php } ?>
    </select><br><br>
    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required><br><br>
    <label for="status">Status:</label>
    <select id="status" name="status" required>
      <option value="">Select Status</option>
      <option value="present">Present</option>
      <option value="absent">Absent</option>
    </select><br><br>
    <input type="submit" value="Submit">
  </form>
  <br>
  <a href="dashboard.php">Back to Dashboard</a> |
  <a href="logout.php">Logout</a>
</body>
</html>
