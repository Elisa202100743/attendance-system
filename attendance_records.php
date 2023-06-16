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

// Retrieve attendance records for the selected class
$sql = "SELECT attendance.*, students.name AS student_name
        FROM attendance
        INNER JOIN students ON attendance.student_id = students.student_id
        WHERE attendance.class_id = '$class_id'";
$recordsResult = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Attendance Records</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <h2>Attendance Records - <?php echo $className; ?></h2>
  <table>
    <tr>
      <th>Date</th>
      <th>Student</th>
      <th>Status</th>
    </tr>
    <?php while ($record = mysqli_fetch_assoc($recordsResult)) { ?>
      <tr>
        <td><?php echo $record['date']; ?></td>
        <td><?php echo $record['student_name']; ?></td>
        <td><?php echo $record['status']; ?></td>
      </tr>
    <?php } ?>
  </table>
  <br>
  <a href="dashboard.php">Back to Dashboard</a> |
  <a href="logout.php">Logout</a>
</body>
</html>
