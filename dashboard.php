<?php
session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Include the database connection file
require_once "db_connection.php";

// Retrieve class information and attendance records
$sql = "SELECT classes.class_id, classes.name AS class_name, CONCAT(users.first_name, ' ', users.last_name) AS teacher_name,
        COUNT(attendance.attendance_id) AS total_classes, 
        SUM(CASE WHEN attendance.status = 'present' THEN 1 ELSE 0 END) AS present_classes
        FROM classes
        INNER JOIN users ON classes.teacher_id = users.user_id
        LEFT JOIN attendance ON classes.class_id = attendance.class_id
        GROUP BY classes.class_id, class_name, teacher_name";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Attendance Dashboard</title>
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
  <h2>Attendance Dashboard</h2>
  <table>
    <tr>
      <th>Class Name</th>
      <th>Teacher Name</th>
      <th>Attendance Percentage</th>
      <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['class_name']; ?></td>
        <td><?php echo $row['teacher_name']; ?></td>
        <td><?php echo round(($row['present_classes'] / $row['total_classes']) * 100, 2); ?>%</td>
        <td>
          <a href="attendance.php?class_id=<?php echo $row['class_id']; ?>">Take Attendance</a> |
          <a href="attendance_records.php?class_id=<?php echo $row['class_id']; ?>">View Attendance Records</a>
        </td>
      </tr>
    <?php } ?>
  </table>
  <br>
  <a href="logout.php">Logout</a>
</body>
</html>
