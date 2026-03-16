<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT students.*, classes.name AS class_name
        FROM students
        LEFT JOIN classes ON students.class_id = classes.id
        ORDER BY students.id DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Students</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<link rel="stylesheet" href="style.css">
<body>
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Students</h2>
    <a href="add_student.php" class="btn btn-primary">+ Add Student</a>
  </div>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Photo</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Class</th>
        <th>Date of Birth</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><img src="images/<?php echo $row['image']; ?>" width="50" class="rounded-circle"></td>
          <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
          <td><?php echo ucfirst($row['gender']); ?></td>
          <td><?php echo $row['class_name']; ?></td>
          <td><?php echo $row['dob']; ?></td>
          <td>
            <a href="edit_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete_student.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this student?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>