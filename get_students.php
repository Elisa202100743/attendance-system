<?php
// Include the database connection file
require_once "db_connection.php";

// Get the class ID from the AJAX request
$class_id = $_POST['class_id'];

// Retrieve students for the selected class
$sql = "SELECT * FROM students WHERE class_id = '$class_id'";
$studentsResult = mysqli_query($conn, $sql);

// Display the list of students
while ($student = mysqli_fetch_assoc($studentsResult)) {
  echo '<li>';
  echo '<label>';
  echo '<input type="checkbox" name="student_ids[]" value="' . $student['student_id'] . '">';
  echo $student['name'];
  echo '</label>';
  echo '</li>';
}
?>
