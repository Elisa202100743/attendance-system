<!-- Display attendance records for the selected student -->
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Get the selected student ID
  $studentId = $_POST['student_id'];

  // Retrieve attendance records for the selected student from the database
  $sql = "SELECT a.date, c.name AS class_name, a.status
          FROM attendance a
          INNER JOIN classes c ON a.class_id = c.classes_id
          WHERE a.student_id = '$studentId'";
  $attendanceResult = mysqli_query($conn, $sql);

  // Display the attendance records in a table
  if (mysqli_num_rows($attendanceResult) > 0) {
    echo '<h2>Attendance Records for Selected Student</h2>';
    echo '<table>';
    echo '<tr><th>Date</th><th>Class Name</th><th>Attendance Status</th></tr>';

    while ($row = mysqli_fetch_assoc($attendanceResult)) {
      echo '<tr>';
      echo '<td>' . $row['date'] . '</td>';
      echo '<td>' . $row['class_name'] . '</td>';
      echo '<td>' . $row['status'] . '</td>';
      echo '</tr>';
    }

    echo '</table>';
  } else {
    echo '<p>No attendance records found for the selected student.</p>';
  }
}
?>
