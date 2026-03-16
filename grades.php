<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT grades.*, students.firstname, students.lastname, subjects.name AS subject_name
        FROM grades
        LEFT JOIN students ON grades.student_id = students.id
        LEFT JOIN subjects ON grades.subject_id = subjects.id
        ORDER BY grades.id DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Grades</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<link rel="stylesheet" href="style.css">

<body>
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Grades</h2>
    <a href="add_grade.php" class="btn btn-primary">+ Add Grade</a>
  </div>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Student</th>
        <th>Subject</th>
        <th>Score</th>
        <th>Exam Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
          <td><?php echo $row['subject_name']; ?></td>
          <td><?php echo $row['score']; ?></td>
          <td><?php echo $row['exam_date']; ?></td>
          <td>
            <a href="edit_grade.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete_grade.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this grade?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>