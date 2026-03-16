<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$students = $conn->query("SELECT * FROM students");
$subjects = $conn->query("SELECT * FROM subjects");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $score = $_POST['score'];
    $exam_date = $_POST['exam_date'];

    $sql = "INSERT INTO grades (student_id, subject_id, score, exam_date)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iids", $student_id, $subject_id, $score, $exam_date);
    $stmt->execute();

    header("Location: grades.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Grade</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<link rel="stylesheet" href="style.css">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<body>
<div class="container mt-5">
  <h2>Add New Grade</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Student</label>
     <select name="student_id" id="student-select" class="form-control" required>
  <option value="">Select Student</option>
  <?php while($s = $students->fetch_assoc()): ?>
    <option value="<?php echo $s['id']; ?>">
      <?php echo $s['firstname'] . " " . $s['lastname']; ?>
    </option>
  <?php endwhile; ?>
</select>

    </div>
    <div class="mb-3">
      <label>Subject</label>
      <select name="subject_id" class="form-control" required>
        <option value="">Select Subject</option>
        <?php while($sub = $subjects->fetch_assoc()): ?>
          <option value="<?php echo $sub['id']; ?>"><?php echo $sub['name']; ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Score</label>
      <input type="number" step="0.01" name="score" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Exam Date</label>
      <input type="date" name="exam_date" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Add Grade</button>
  </form>
</div>
<!-- jQuery (مطلوب لـ Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    $('#student-select').select2({
      placeholder: "Search student...",
      allowClear: true
    });
  });
</script>

</body>
</html>