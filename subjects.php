<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT subjects.*, classes.name AS class_name 
        FROM subjects 
        LEFT JOIN classes ON subjects.class_id = classes.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Subjects</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<link rel="stylesheet" href="style.css">

<body>
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Subjects</h2>
    <a href="add_subject.php" class="btn btn-primary">+ Add Subject</a>
  </div>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Name</th>
        <th>Class</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['class_name']; ?></td>
          <td>
            <a href="edit_subject.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete_subject.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this subject?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>