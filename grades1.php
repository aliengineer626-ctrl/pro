<?php
session_start();
require_once 'conn.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // عرض كل أخطاء mysqli

if (!isset($_SESSION['student'])) {
    header("Location: login.php");
    exit();
}

$student = $_SESSION['student'];
$student_id = $student['id'];

$sql = "SELECT subject, grade FROM grades WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

// لحساب المجموع والمتوسط
$total = 0;
$count = 0;

while ($row = $result->fetch_assoc()) {
    $grades[] = $row;
    $total += $row['grade'];
    $count++;
}

$average = $count > 0 ? round($total / $count, 2) : 0;
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>درجاتي</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card p-4 shadow">
    <h4 class="mb-3">مرحبًا، <?php echo $student['firstname'] . " " . $student['lastname']; ?></h4>
    <h5 class="mb-3">درجاتك:</h5>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>المادة</th>
          <th>الدرجة</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($grades as $grade): ?>
        <tr>
          <td><?php echo htmlspecialchars($grade['subject']); ?></td>
          <td><?php echo htmlspecialchars($grade['grade']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot class="table-light">
        <tr>
          <th>المجموع الكلي</th>
          <td><?php echo $total; ?></td>
        </tr>
        <tr>
          <th>المتوسط</th>
          <td><?php echo $average; ?></td>
        </tr>
      </tfoot>
    </table>
    <a href="logout1.php" class="btn btn-danger">تسجيل الخروج</a>
  </div>
</div>
</body>
</html>
