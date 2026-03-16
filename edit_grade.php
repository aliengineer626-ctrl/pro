<?php
require_once 'conn.php';
session_start();

if (!isset($_SESSION['id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$grade = $conn->query("SELECT * FROM grades WHERE id = $id")->fetch_assoc();
$students = $conn->query("SELECT * FROM students");
$subjects = $conn->query("SELECT * FROM subjects");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $score = $_POST['score'];
    $exam_date = $_POST['exam_date'];

    $sql = "UPDATE grades SET student_id=?, subject_id=?, score=?, exam_date=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iidsi", $student_id, $subject_id, $score, $exam_date, $id);
    $stmt->execute();

    header("Location: grades.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Grade</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<link rel="stylesheet" href="style.css">
<body>
<div class="container mt-5">
  <h2>Edit Grade</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Student</label>
      <select name="student_id" class="form-control" required>
        <?php while($s = $students->fetch_assoc()): ?>
          <option value="<?php echo $s['id']; ?>" <?php if ($grade['student_id'] == $s['id']) echo 'selected'; ?>>
            <?php echo $s['firstname'] . " " . $s['lastname']; ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Subject</label>
      <select name="subject_id" class="form-control" required>
        <?php while($sub = $subjects->fetch_assoc()): ?>
          <option value="<?php echo $sub['id']; ?>" <?php if ($grade['subject_id'] == $sub['id']) echo 'selected'; ?>>
            <?php echo $sub['name']; ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label>Score</label>
      <input type="number" step="0.01" name="score" class="form-control" value="<?php echo $grade['score']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Exam Date</label>
      <input type="date" name="exam_date" class="form-control" value="<?php echo $grade['exam_date']; ?>" required>
    </div>
    <button type="submit" class="btn btn-warning">Update Grade</button>
  </form>
</div>
</body>
</html>