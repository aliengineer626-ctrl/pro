<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Get the current student's info
$student_id = $_SESSION['id'];

$student_sql = "SELECT firstname, lastname FROM students WHERE id = ?";
$stmt_student = $conn->prepare($student_sql);
$stmt_student->bind_param("i", $student_id);
$stmt_student->execute();
$student_result = $stmt_student->get_result();
$student = $student_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Grades (Last 6 Subjects)</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
   
    .card {
      margin-top: 30px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      border-radius: 10px;
    }
    .card h5 {
      background-color: #343a40;
      color: white;
      padding: 10px;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }
  </style>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
  <div class="card">
    <h5><?php echo $student['firstname'] . ' ' . $student['lastname']; ?> - Your Latest 6 Grades</h5>
    <div class="p-3">
      <table class="table table-striped table-bordered text-center">
        <thead class="table-dark">
          <tr>
            <th>Subject</th>
            <th>Grade</th>
            <th>Exam Date</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $grades_sql = "SELECT g.score, g.exam_date, s.name AS subject_name
                         FROM grades g
                         LEFT JOIN subjects s ON g.subject_id = s.id
                         WHERE g.student_id = ?
                         ORDER BY g.exam_date DESC
                         LIMIT 6";
          $stmt = $conn->prepare($grades_sql);
          $stmt->bind_param("i", $student_id);
          $stmt->execute();
          $grades_result = $stmt->get_result();

          if ($grades_result->num_rows > 0):
            while ($grade = $grades_result->fetch_assoc()):
          ?>
            <tr>
              <td><?php echo htmlspecialchars($grade['subject_name']); ?></td>
              <td><?php echo htmlspecialchars($grade['score']); ?></td>
              <td><?php echo date("Y-m-d", strtotime($grade['exam_date'])); ?></td>
            </tr>
          <?php
            endwhile;
          else:
          ?>
            <tr><td colspan="3">No grades available.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
